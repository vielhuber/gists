### option 1: register json route (recommended)
```php
// functions.php
/* custom api endpoint */
add_action('rest_api_init', function () {
    // url: https://tld.com/wp-json/v1/custom/path/1337
    // for strings use '/custom/path/(?P<id>[a-zA-Z0-9]+)'
    register_rest_route('v1', '/custom/path/(?P<id>\d+)', [
        'methods' => WP_REST_Server::READABLE, // 'GET', for 'POST use WP_REST_Server::CREATABLE
        'callback' => function (WP_REST_Request $request) {
            $request->get_params();
            $request->get_param('example');
            /* ... */
            if (1 == 0) {
                return new WP_REST_Response(
                    [
                        'success' => false,
                        'message' => 'server error',
                        'public_message' => 'Es ist ein Fehler aufgetreten.',
                    ],
                    404
                );
            }
            return new WP_REST_Response(
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