<?php
$whitelist = [
    'foo'
];
$cookies = [];
foreach (headers_list() as $headers__value) {
    if (strpos($headers__value, 'Set-Cookie: ') === 0) {
        $cookies[] = $headers__value;
    }
}
if (!empty($cookies)) {
    header_remove('Set-Cookie');
    foreach ($cookies as $cookies__value) {
        $accept = false;
        foreach ($whitelist as $whitelist__value) {
            if (strpos($cookies__value, 'Set-Cookie: ' . $whitelist__value . '=') === 0) {
                $accept = true;
                break;
            }
        }
        if ($accept === true) {
            header($cookies__value);
        }
    }
}
if (!empty($_COOKIE)) {
    foreach ($_COOKIE as $cookies__key => $cookies__value) {
        if (!in_array($cookies__key, $whitelist)) {
            unset($_COOKIE[$cookies__key]);
            setcookie($cookies__key, '', time() - 3600, '/');
        }
    }
}
