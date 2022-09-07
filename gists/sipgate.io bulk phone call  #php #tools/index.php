<?php
foreach([
    '089123456780',
    '089123456781',
    '089123456782',
    '089123456783',
    '089123456784',
    '089123456785',
    '089123456786',
    '089123456787',
    '089123456788',
    '089123456789',
    '089123456790',
    '089123456791'
] as $iteration=>$number)
{
    sleep($iteration*15); // set this to the length in seconds of the audio file
    call($number);
}

function call($number)
{
    if (!extension_loaded('xmlrpc'))
    {
        die('xmlrpc not available');
    }
    $username = 'your-sipgate-io-username';
    $password = 'your-sipgate-io-password';
    $requestParameter = [
        'RemoteUri' => sprintf('sip:%s@sipgate.de', $number),
        //'LocalUri' => sprintf('sip:%s@sipgate.de', 'own-number'), // automatically set
        'TOS' => 'api-voice'
    ];
    $auth = base64_encode(sprintf('%s:%s', $username, $password));
    $request = xmlrpc_encode_request("samurai.SessionInitiate", $requestParameter);
    $context = stream_context_create(
        [
            'http' => [
                'method' => "POST",
                'header' => sprintf("Content-Type: text/xml\r\nAuthorization: Basic %s)", $auth),
                'content' => $request
            ],
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ]
        ]
    );
    $response_xml = file_get_contents("https://api.sipgate.net/RPC2", false, $context);
    return xmlrpc_decode($response_xml);
}