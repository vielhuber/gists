<?php
if(!file_exists('key1.txt')) { file_put_contents('key1.txt', ''); }
if(!file_exists('key2.txt')) { file_put_contents('key2.txt', ''); }
if(!file_exists('key3.txt')) { file_put_contents('key3.txt', ''); }

if(@$_SERVER['REQUEST_METHOD'] === 'POST') {
    $_POST = json_decode(file_get_contents('php://input'), true);
    if( @$_POST['queue'] != '' ) {
        foreach($_POST['queue'] as $queue__value) {
            if( strtotime($queue__value['timestamp']) > filemtime($queue__value['key'].'.txt') ) {
                file_put_contents($queue__value['key'].'.txt', $queue__value['value']);
            }
        }
    }
}

http_response_code(200);
header('Content-Type: application/json');
echo json_encode([
    'success' => true,
    'cached' => false,
    'data' => [
        ['key' => 'key1', 'value' => @file_get_contents('key1.txt'), 'timestamp' => date('Y-m-d H:i:s',filemtime('key1.txt'))],
        ['key' => 'key2', 'value' => @file_get_contents('key2.txt'), 'timestamp' => date('Y-m-d H:i:s',filemtime('key2.txt'))],
        ['key' => 'key3', 'value' => @file_get_contents('key3.txt'), 'timestamp' => date('Y-m-d H:i:s',filemtime('key3.txt'))]
    ]
]);
die();