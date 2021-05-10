class ServerPluginDeploy
{
    public function __construct()
    {
        $this->makeNewRelease();
        $this->checkForUpdates();
        $this->showLicenseDomains();
    }

    private function makeNewRelease()
    {
        add_action('rest_api_init', function () {
            register_rest_route('v1', '/release', [
                'methods' => \WP_REST_Server::CREATABLE,
                'permission_callback' => function () {
                    $username = @$_SERVER['PHP_AUTH_USER'];
                    $password = @$_SERVER['PHP_AUTH_PW'];
                    if ($username == '' || $password == '') {
                        return false;
                    }
                    $user = wp_authenticate($username, $password);
                    if (is_wp_error($user)) {
                        return false;
                    }
                    wp_set_current_user($user->ID);
                    return current_user_can('manage_options');
                },
                'callback' => function (\WP_REST_Request $request) {
                    $input = $request->get_params();
                    if (
                        !isset($input['name']) ||
                        $input['name'] == '' ||
                        !isset($input['version']) ||
                        $input['version'] == '' ||
                        !isset($input['requires']) ||
                        $input['requires'] == '' ||
                        !isset($input['tested']) ||
                        $input['tested'] == '' ||
                        !isset($input['file']) ||
                        $input['file'] == '' ||
                        !isset($input['icon']) ||
                        $input['icon'] == ''
                    ) {
                        return new \WP_REST_Response(
                            [
                                'success' => false,
                                'message' => 'server error'
                            ],
                            404
                        );
                    }
                    $filename = md5(uniqid(mt_rand(), true));
                    $folder = wp_upload_dir()['basedir'] . '/release/';
                    $folder_public = wp_upload_dir()['baseurl'] . '/release/';
                    if (!is_dir($folder)) {
                        @mkdir($folder);
                    }
                    foreach (glob($folder . '*') as $files__value) {
                        if (is_file($files__value)) {
                            @unlink($files__value);
                        }
                    }
                    if (!file_exists($folder . '.gitignore')) {
                        file_put_contents($folder . '.gitignore', '*');
                    }
                    file_put_contents($folder . $filename . '.zip', base64_decode($input['file']));
                    file_put_contents($folder . $filename . '.png', base64_decode($input['icon']));
                    file_put_contents(
                        $folder . $filename . '.txt',
                        serialize([
                            'name' => $input['name'],
                            'version' => $input['version'],
                            'requires' => $input['requires'],
                            'tested' => $input['tested'],
                            'download_url' => $folder_public . $filename . '.zip',
                            'icon' => $folder_public . $filename . '.png'
                        ])
                    );
                    // update wordpress downloadable zip url
                    global $wpdb;
                    $files = $wpdb->get_results(
                        $wpdb->prepare(
                            'SELECT * FROM ' . $wpdb->prefix . 'postmeta WHERE meta_key = %s',
                            '_downloadable_files'
                        )
                    );
                    if (!empty($files)) {
                        foreach ($files as $files__value) {
                            $files_meta_value = $files__value->meta_value;
                            $files_meta_value = @unserialize($files_meta_value);
                            if (!empty($files_meta_value)) {
                                foreach ($files_meta_value as $files_meta_value__key => $files_meta_value__value) {
                                    $files_meta_value[$files_meta_value__key]['file'] =
                                        $folder_public . $filename . '.zip';
                                }
                            }
                            $files_meta_value = serialize($files_meta_value);
                            $wpdb->update(
                                $wpdb->prefix . 'postmeta',
                                ['meta_value' => $files_meta_value],
                                ['meta_id' => $files__value->meta_id]
                            );
                        }
                    }
                    return new \WP_REST_Response(
                        [
                            'success' => true,
                            'message' => 'successfully made a new release',
                            'data' => [
                                'url' => $folder_public . $filename . '.zip'
                            ]
                        ],
                        200
                    );
                }
            ]);
        });
    }
  
    private function checkForUpdates()
    {
        add_action('rest_api_init', function () {
            register_rest_route('v1', '/update', [
                'methods' => \WP_REST_Server::CREATABLE,
                'permission_callback' => '__return_true',
                'callback' => function (\WP_REST_Request $request) {
                    $key = $request->get_param('key');
                    $domain = $request->get_param('domain');
                    $file = glob(wp_upload_dir()['basedir'] . '/release/*.txt');

                    // error
                    if ($key == '' || $domain == '' || !lmfwc_get_license($key) || empty($file)) {
                        return new \WP_REST_Response(
                            [
                                'success' => false,
                                'message' => 'server error',
                                'public_message' => 'Es ist ein Fehler aufgetreten.'
                            ],
                            404
                        );
                    }

                    // log domains
                    $license = lmfwc_get_license($key);
                    $domains = lmfwc_get_license_meta($license->getId(), 'domains', false);
                    if (!in_array($domain, $domains)) {
                        $domains[] = $domain;
                        lmfwc_add_license_meta($license->getId(), 'domains', $domain);
                    }

                    // return update data
                    return new \WP_REST_Response(unserialize(file_get_contents($file[0])), 200);
                }
            ]);
        });
    }
  
    private function showLicenseDomains()
    {
        add_filter(
            'gettext',
            function ($translation, $text, $domain) {
                if (
                    is_admin() &&
                    isset($_GET['page']) &&
                    isset($_GET['action']) &&
                    isset($_GET['id']) &&
                    $_GET['page'] === 'lmfwc_licenses' &&
                    $_GET['action'] === 'edit' &&
                    $_GET['id'] != '' &&
                    $text === 'The license key will be encrypted before it is stored inside the database.' &&
                    $domain === 'license-manager-for-woocommerce' &&
                    !empty(($meta = lmfwc_get_license_meta($_GET['id'], 'domains')))
                ) {
                    $translation = 'Domains: ' . implode(', ', $meta);
                }
                return $translation;
            },
            PHP_INT_MAX,
            3
        );
    }
}

new ServerPluginDeploy();
