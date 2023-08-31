// GET
$response = wp_remote_get('http://httpbin.org/get', [
  	'timeout' => 60,
  	'sslverify' => false,
    'headers' => [
        'foo' => 'bar'
    ]                       
]);
if (is_wp_error($response)) {
    echo $response->get_error_message();
    die();
}
if( @$response['response']['code'] != 200 ) { // be careful: not all response codes (like 400) throw wp error
  die();  
}
echo '<pre>';    
var_dump($response['headers'],json_decode($response['body']), $response['response']);
echo '</pre>';

// POST
$response = wp_remote_post('http://httpbin.org/post', [
    'method' => 'POST',
    'timeout' => 60,
  	'body' => wp_json_encode([
        'foo' => 'bar',
        'bar' => 'baz'
    ]),
    'headers' => [
        'Content-Type' => 'application/json'
    ],
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
if( @$response['response']['code'] != 200 ) { // be careful: not all response codes (like 400) throw wp error
  die();  
}
echo '<pre>';    
var_dump($response['headers'],json_decode($response['body']), $response['response']);
echo '</pre>';

// PUT
$response = wp_remote_request('http://httpbin.org/post', [
    'method' => 'PUT',
    'timeout' => 60,
    /* ... */
]);