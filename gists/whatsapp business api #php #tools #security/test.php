<?php
$access_key = 'xxxxxxxxxxxxxxxxxxxxxxxxx';
__curl(
    'https://conversations.messagebird.com/v1/send',
    ['to' => '+49xxxxxxxxx', 'from' => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx', 'type' => 'text', 'content' => [ 'text' => 'This works' ], 'reportUrl' => 'https://example.com/reports'],
    'POST',
    ['Authorization' => 'AccessKey '.$access_key],
);
__curl(
    'https://conversations.messagebird.com/v1/conversations/start',
    [
        'to' => '+49xxxxxxxxx',
        'from' => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
        'channelId' => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
        'type' => 'hsm',  
        'content' => [ 'hsm' => [
            'namespace' => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
            'templateName' => 'custom_template_name', 
            'language' => ['policy' => 'deterministic', 'code' => 'de'],
            'params' => [ ['default' => 'David'] ]
        ] ]
    ],
    'POST',
    ['Authorization' => 'AccessKey '.$access_key],
);