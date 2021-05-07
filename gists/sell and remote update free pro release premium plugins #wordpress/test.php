<?php
/**
 * Plugin Name: Test
 * Plugin URI: https://test.de
 * Description: A simple test.
 * Version: 1.0.0
 * Author: David Vielhuber
 * Author URI: https://vielhuber.de
 * License: free
 */

class TestPlugin
{

    public function __construct() {
        $this->init();
        $this->checkForUpdates();
    }

    private function init() {

        // dummy logic
        add_action( 'admin_init', function() {
            add_filter( 'admin_footer_text', function($content) {
                return 'Test plugin 1.0.0 active!';
            }, 11 );
        });

        // this should be editable in wp backend
        update_option('test_license_key', '3WVPLU-W4GZJ9-9PNU74-5PROU2');

    }

    private function checkForUpdates() {

        // code inspired from https://rudrastyh.com/wordpress/self-hosted-plugin-update.html
        
        global $custom_options;
        $custom_options = [
            'plugin_slug' => 'test',
            'update_url' => 'https://tld.com/wp-json/v1/update',
            'license_key' => get_option('test_license_key'),
            'cache_time' => 3 // debug
        ];

        // check license key
        if ($custom_options['license_key'] == '') {
            return;
        }

        // allow http without ssl in download url
        add_filter( 'http_request_args', function ( $args ) {
            $args['reject_unsafe_urls'] = false;  
            return $args;
        }, 999 );

        // check for plugin updates
        add_filter('site_transient_update_plugins', function ($transient) {
            global $custom_options;
            if (empty($transient->checked)) {
                return $transient;
            }
            $remote = get_transient('custom_upgrade_' . $custom_options['plugin_slug']);
            if ($remote == false) {
                $remote = wp_remote_post($custom_options['update_url'], [
                    'body' => wp_json_encode([
                        'key' => $custom_options['license_key'],
                        'domain' => $_SERVER['HTTP_HOST']
                    ]),
                    'headers' => [
                        'Content-Type' => 'application/json'
                    ],
                    'timeout' => 10
                ]);
                if (
                    !is_wp_error($remote) &&
                    isset($remote['response']['code']) &&
                    $remote['response']['code'] == 200 &&
                    !empty($remote['body'])
                ) {
                    set_transient(
                        'custom_upgrade_' . $custom_options['plugin_slug'],
                        $remote,
                        $custom_options['cache_time']
                    );
                }
            }
            if (
                !is_wp_error($remote) &&
                isset($remote['response']['code']) &&
                $remote['response']['code'] == 200 &&
                !empty($remote['body'])
            ) {
                $remote = json_decode($remote['body']);
                if (
                    $remote &&
                    version_compare(
                        get_file_data(__FILE__, ['Version' => 'Version'], false)['Version'],
                        $remote->version,
                        '<'
                    ) &&
                    version_compare($remote->requires, get_bloginfo('version'), '<')
                ) {
                    $res = new stdClass();
                    $res->slug = $custom_options['plugin_slug'];
                    $res->plugin = $custom_options['plugin_slug'] . '/' . $custom_options['plugin_slug'] . '.php';
                    $res->new_version = $remote->version;
                    $res->tested = $remote->tested;
                    $res->package = $remote->download_url;
                    $res->icons = [
                        '1x' => $remote->icon,
                        '2x' => $remote->icon
                    ];
                    $transient->response[$res->plugin] = $res;
                }
            }
            return $transient;
        });

        // provide detail infos
        add_filter(
            'plugins_api',
            function ($res, $action, $args) {
                global $custom_options;
                if ($action !== 'plugin_information') {
                    return false;
                }
                if ($args->slug !== $custom_options['plugin_slug']) {
                    return false;
                }
                $remote = get_transient('custom_update_' . $custom_options['plugin_slug']);
                if ($remote == false) {
                    $remote = wp_remote_post($custom_options['update_url'], [
                        'body' => wp_json_encode([
                            'key' => $custom_options['license_key'],
                            'domain' => $_SERVER['HTTP_HOST']
                        ]),
                        'headers' => [
                            'Content-Type' => 'application/json'
                        ],
                        'timeout' => 10
                    ]);
                    if (
                        !is_wp_error($remote) &&
                        isset($remote['response']['code']) &&
                        $remote['response']['code'] == 200 &&
                        !empty($remote['body'])
                    ) {
                        set_transient(
                            'custom_update_' . $custom_options['plugin_slug'],
                            $remote,
                            $custom_options['cache_time']
                        );
                    }
                }
                if (
                    !is_wp_error($remote) &&
                    isset($remote['response']['code']) &&
                    $remote['response']['code'] == 200 &&
                    !empty($remote['body'])
                ) {
                    $remote = json_decode($remote['body']);
                    $res = new stdClass();

                    $res->name = $remote->name;
                    $res->slug = $custom_options['plugin_slug'];
                    $res->version = $remote->version;
                    $res->tested = $remote->tested;
                    $res->download_link = $remote->download_url;
                    $res->trunk = $remote->download_url;
                    $res->sections = [];
                    return $res;
                }
                return false;
            },
            20,
            3
        );

        // clean cache after plugin update
        add_action(
            'upgrader_process_complete',
            function ($upgrader_object, $options) {
                global $custom_options;
                if ($options['action'] == 'update' && $options['type'] === 'plugin') {
                    delete_transient('custom_upgrade_' . $custom_options['plugin_slug']);
                }
            },
            10,
            2
        );
    }

}

new TestPlugin();