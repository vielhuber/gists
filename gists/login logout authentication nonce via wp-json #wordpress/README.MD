```php
<?php
// enqueue api nonce
wp_enqueue_script('bundle', get_bloginfo('template_directory') . '/dist/js/bundle.js', ['jquery'], false, true);
wp_localize_script('bundle', 'settings', [
    'root' => esc_url_raw(rest_url()),
    'nonce' => wp_create_nonce('wp_rest')
]);

// see https://remonpel.nl/2018/06/wordpress-rest-api-nonce-sense/
add_action('set_logged_in_cookie', function ($logged_in_cookie) {
    $_COOKIE[\LOGGED_IN_COOKIE] = $logged_in_cookie;
});
add_action('clear_auth_cookie', function ($logged_in_cookie) {
    $_COOKIE[\LOGGED_IN_COOKIE] = '';
});
add_filter(
  'rest_post_dispatch',
  function (\WP_REST_Response $response) {
    $response->header('X-WP-Nonce', wp_create_nonce('wp_rest'));
    return $response;
  },
  \PHP_INT_MAX
);

// to generate a link via GET, use this:
rest_url('v1/foo/bar?_wpnonce=' . wp_create_nonce('wp_rest'));

// this cookie can be read by javascript and isset either via backend login or js login
add_action('wp_login', function () {
    setcookie('wp_user_logged_in', 1, time() + 31556926, '/');
    $_COOKIE['wp_user_logged_in'] = 1;
});
add_action('wp_logout', function () {
    unset($_COOKIE['wp_user_logged_in']);
    setcookie('wp_user_logged_in', null, -1, '/');
});

// login
add_action('rest_api_init', function () {
    register_rest_route('v1', '/user/login', [
        'methods' => \WP_REST_Server::CREATABLE,
        'callback' => function (\WP_REST_Request $request) {
            $params = $request->get_params();
            $response = wp_signon(
                [
                    'user_login' => $params['email'],
                    'user_password' => $params['password'],
                    'remember' => true
                ],
                false
            );
            $id = $response->ID;
            wp_clear_auth_cookie();
            wp_set_current_user($id);
            wp_set_auth_cookie($id, true);
            return new \WP_REST_Response(['success' => true, 'data' => ['id' => $id]], 200);
        }
    ]);
});

// check
add_action('rest_api_init', function () {
    register_rest_route('v1', '/user/check', [
        'methods' => \WP_REST_Server::READABLE,
        'callback' => function (\WP_REST_Request $request) {
            if (!is_user_logged_in()) {
                return new \WP_REST_Response(['success' => false], 400);
            }
            return new \WP_REST_Response(['success' => true, 'data' => ['id' => $data->ID, 'data' => wp_get_current_user()]], 200);
        }
    ]);
});

// logout
add_action('rest_api_init', function () {
    register_rest_route('v1', '/user/logout', [
        'methods' => \WP_REST_Server::READABLE,
        'callback' => function (\WP_REST_Request $request) {
            if (!is_user_logged_in()) {
                return new \WP_REST_Response(['success' => false], 400);
            }
            wp_logout();
            return new \WP_REST_Response(['success' => true], 200);
        }
    ]);
});
```

```js
// login
document.querySelector('.login').addEventListener('click', e => {
    let data = new URLSearchParams();
    data.append('email', 'xxx');
    data.append('password', 'xxx');
    fetch(window.settings.resturl + 'v1/user/login', {
        method: 'POST',
        body: data,
        cache: 'no-cache',
        headers: {
            'content-type': 'application/x-www-form-urlencoded',
            'X-WP-Nonce': window.settings.nonce
        }
    })
        .then(response => {
          if (response.headers.get('X-WP-Nonce') !== null) { window.settings.nonce = response.headers.get('X-WP-Nonce'); }
          return response.json();
        })
        .catch(v => v)
        .then(response => {
            console.log(response);
        });
    e.preventDefault();
});

// check
document.querySelector('.check').addEventListener('click', e => {
    fetch(window.settings.resturl + 'v1/user/check', {
        method: 'GET',
        headers: {
            'X-WP-Nonce': window.settings.nonce
        }
    })
        .then(response => {
          if (response.headers.get('X-WP-Nonce') !== null) { window.settings.nonce = response.headers.get('X-WP-Nonce'); }
          return response.json();
        })
        .catch(v => v)
        .then(response => {
            console.log(response);
        });
    e.preventDefault();
});

// logout
document.querySelector('.logout').addEventListener('click', e => {
    fetch(window.settings.resturl + 'v1/user/logout', {
        method: 'GET',
        headers: {
            'X-WP-Nonce': window.settings.nonce
        }
    })
        .then(response => {
          if (response.headers.get('X-WP-Nonce') !== null) { window.settings.nonce = response.headers.get('X-WP-Nonce'); }
          return response.json();
        })
        .catch(v => v)
        .then(response => {
            console.log(response);
        });
    e.preventDefault();
});
```