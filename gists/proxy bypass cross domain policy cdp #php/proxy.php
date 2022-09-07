<?php
$proxy_url =
    'http' .
    (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 's' : '') .
    '://' .
    $_SERVER['HTTP_HOST'] .
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$receipts = [
    'example.js' => [
        ['location.origin!==n.origin', '1===0&&location.origin!==n.origin'], /* simple replacements (like origin checks) */
        ['/(https:\/\/.+\.example\.net\/assets\/js\/another\/asset.js)/', $proxy_url . '?url=$1'], /* regex is also possible */
        ['</head>', '<style>.ads { display:none; }</style></head>'] /* inject your own styles */
    ],
    '/regex-match-v.*\.js/' => [/*...*/]
];

if (!isset($_REQUEST['url'])) {
    die();
}
$url = $_REQUEST['url'];

$mime_types = [
    '.js' => 'text/javascript',
    '.css' => 'text/css'
];
$mime_type = 'text/html';
foreach ($mime_types as $mime_types__key => $mime_types__value) {
    if (stripos($url, $mime_types__key) !== false) {
        $mime_type = $mime_types__value;
        break;
    }
}
header('Content-Type: ' . $mime_type);

$output = file_get_contents($url);

foreach ($receipts as $receipts__key => $receipts__value) {
    $is_regex_key = preg_match("/^\/.+\/[a-z]*$/i", $receipts__key);
    if (
        ($is_regex_key && preg_match($receipts__key, $url)) ||
        (!$is_regex_key && stripos($url, $receipts__key) !== false)
    ) {
        foreach ($receipts__value as $receipts__value__value) {
            $is_regex_value = preg_match("/^\/.+\/[a-z]*$/i", $receipts__value__value[0]);
            if ($is_regex_value) {
                $output = preg_replace($receipts__value__value[0], $receipts__value__value[1], $output);
            } else {
                $output = str_replace($receipts__value__value[0], $receipts__value__value[1], $output);
            }
        }
    }
}

echo $output;
die();
