<?php
$secret = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
if (!isset($_POST['g-recaptcha-response']) || $_POST['g-recaptcha-response'] == '') { die(); }
$check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='. $_POST['g-recaptcha-response']);
$check = json_decode($check);
$minimium_score = 0.5;
// debug
if( strpos($_SERVER['HTTP_HOST'], 'local') !== false ) { $minimum_score = 0; }
if(!isset($check->success) || $check->success !== true || !isset($check->score) || $check->score < $minimium_score) { die(); }