<?php
$captcha_success = hCaptchaIsValid();
if($captcha_success === true) {
    /* ... */
} 

header('Content-Type: application/json');
echo json_encode(['success' => $captcha_success]);
die();

function hCaptchaIsValid() {
    if( !isset($_POST['h-captcha-response']) || $_POST['h-captcha-response'] == '' ) {
        return false;
    }
    $verify = curl_init();
    curl_setopt($verify, CURLOPT_URL, 'https://hcaptcha.com/siteverify');
    curl_setopt($verify, CURLOPT_POST, true);
    curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query([
        'secret' => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
        'response' => $_POST['h-captcha-response']
    ]));
    curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($verify);
    $responseData = json_decode($response);
    return $responseData->success;
}