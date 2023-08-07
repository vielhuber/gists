### option 1: register json route (recommended)
```php
// functions.php
/* custom api endpoint */
add_action('rest_api_init', function () {
    // url: https://tld.com/wp-json/v1/custom/path/1337
    // for strings use '/custom/path/(?P<id>[a-zA-Z0-9]+)'
    register_rest_route('v1', '/custom/path/(?P<id>\d+)', [
        'methods' => \WP_REST_Server::READABLE, // 'GET', for 'POST' use WP_REST_Server::CREATABLE
        'permission_callback' => function (\WP_REST_Request $request) {
          	// public route
          	return true;
          
          	// check for manual token
          	return $request->get_param('token') === 'abcde';
          
          	// for user / authentication via cookie / api
          	// see https://gist.github.com/vielhuber/b1647427ddb32c87a9f56e92ed1fd371
            // this does not work!
            //return is_user_logged_in();
        	//return current_user_can( 'edit_others_posts' );
          
          	// simple basic auth
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
            $request->get_params();
            $request->get_param('example');
          	$request->get_headers();          
          	/* simple bearer token check */
          	if( $request->get_header('authorization') != 'Bearer xxx' ) { }
            /* ... */
            if (1 == 0) {
                return new \WP_REST_Response(
                    [
                        'success' => false,
                        'message' => 'server error',
                        'public_message' => 'Es ist ein Fehler aufgetreten.',
                    ],
                    404
                );
            }
            return new \WP_REST_Response(
                [
                    'success' => true,
                    'message' => 'successfully created object',
                    'public_message' => 'Object erfolgreich angelegt!',
                    'data' => [
                        'id' => $request->get_param('id'),
                        'example' => $request->get_param('example'),
                    ],
                ],
                200
            );
        },
    ]);
});
```

- note: if you want to use other classes of the namespace inside the callback function, you have to call a separate function from the current class
```php
private function routeTest() {
    add_action('rest_api_init', function () {
        register_rest_route('v1', '/test', [
            'methods' => \WP_REST_Server::READABLE,
            'permission_callback' => function () { return true; },
            'callback' => [$this, 'routeTestCallback']
        ]);
    });
}
public function routeTestCallback(\WP_REST_Request $request) {
    /* this works now */
    new OtherClass();
    /* ... */
}
```

### option 2: custom php file
```php
// custom-ajax.php
define('WP_USE_THEMES', false);
require($_SERVER['DOCUMENT_ROOT'].'/wp-blog-header.php');
/* ... */
```

### option 3: site template
```php
// create blank page
// add custom site template
// add logic inside site template
```