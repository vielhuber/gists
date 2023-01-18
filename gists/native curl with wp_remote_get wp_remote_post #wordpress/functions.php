// GET
$response = wp_remote_get('http://httpbin.org/get', [
    'headers' => [
        'foo' => 'bar'
    ]                       
]);
if (is_wp_error($response)) {
    echo $response->get_error_message();
    die();
}
echo '<pre>';    
var_dump($response['headers'],json_decode($response['body']), $response['response']);
echo '</pre>';

// POST
$response = wp_remote_post('http://httpbin.org/post', [
    'method' => 'POST',
  	'body' => wp_json_encode([
        'foo' => 'bar',
        'bar' => 'baz'
    ]),
    'headers' => [
        'Content-Type' => 'application/json'
    ],
    'timeout' => 60,
    'redirection' => 5,
    'blocking' => true,
    'httpversion' => '1.0',
    'sslverify' => false,
    'data_format' => 'body',
    'cookies' => []
]);
if (is_wp_error($response)) {
    echo $response->get_error_message();
    die();
}
echo '<pre>';    
var_dump($response['headers'],json_decode($response['body']), $response['response']);
echo '</pre>';

// PUT
$response = wp_remote_request('http://httpbin.org/post', [
    'method' => 'PUT',
    /* ... */
]);