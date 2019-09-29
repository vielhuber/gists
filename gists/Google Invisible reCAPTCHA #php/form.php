<?php
// check captcha
if( !isset($_POST['g-recaptcha-response']) || $_POST['g-recaptcha-response'] == '' ) { die('captcha'); }
$secret = 'XXX';
$response = strip_tags($_POST['g-recaptcha-response']);
$check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$response);
$check = json_decode($check);
if(!isset($check->success) || $check->success !== true) { die('captcha'); }

// mail
// ...