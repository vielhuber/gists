// cleverreach api
$cleverreach = (object) [
    'api_url' => 'https://rest.cleverreach.com',
    'client_id' => 'xxxxxxxxxx',
    'client_secret' => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
    'list_id' => 1337,
    'form_id' => 1337,
    'access_token' => null,
    'email' => 'david@vielhuber.de',
    'source' => 'tld.com',
    'attrs' => [
        // use placeholders (without "{}" here)
        'SALUTATION' => 'Herr',
        'FIRSTNAME' => 'David',
        'LASTNAME' => 'Vielhuber',
        'COUNTRY' => 'Deutschland',
        'DATENSCHUTZ' => '1'
    ]
];

/* login (get token) */
$response = wp_remote_post($cleverreach->api_url . '/oauth/token.php', [
    'body' => wp_json_encode([
        'grant_type' => 'client_credentials'
    ]),
    'headers' => [
        'Content-Type' => 'application/json',
        'Authorization' => 'Basic ' . base64_encode($cleverreach->client_id . ':' . $cleverreach->client_secret)
    ]
]);
if (is_wp_error($response) || @$response['response']['code'] != 200) {
    die('error');
}
$cleverreach->access_token = json_decode($response['body'])->access_token;

/* add recipient (unverified) */
$response = wp_remote_post($cleverreach->api_url . '/groups.json/' . $cleverreach->list_id . '/receivers', [
    'body' => wp_json_encode([
        'email' => $cleverreach->email,
        'registered' => time(),
        'activated' => 0,
        'source' => $cleverreach->source,
        'global_attributes' => array_combine(
            array_map(function ($a) {
                return str_replace(['{', '}'], '', str_replace(' ', '_', mb_strtolower($a)));
            }, array_keys($cleverreach->attrs)),
            $cleverreach->attrs
        )
    ]),
    'headers' => [
        'Content-Type' => 'application/json',
        'Authorization' => 'Bearer ' . $cleverreach->access_token
    ]
]);
if (is_wp_error($response) || @$response['response']['code'] != 200) {
    die('duplicate mail');
}

/* send double opt in */
$response = wp_remote_post($cleverreach->api_url . '/forms.json/' . $cleverreach->form_id . '/send/activate', [
    'body' => wp_json_encode([
        'email' => $cleverreach->email,
        'doidata' => [
            'user_ip' => $_SERVER['REMOTE_ADDR'],
            'referer' => $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT']
        ]
    ]),
    'headers' => [
        'Content-Type' => 'application/json',
        'Authorization' => 'Bearer ' . $cleverreach->access_token
    ]
]);
if (is_wp_error($response) || @$response['response']['code'] != 200) {
    die('error');
}

die('success');