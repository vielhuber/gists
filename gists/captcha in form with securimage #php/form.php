<?php
// test captcha
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/.../securimage/securimage.php');
$securimage = new Securimage();
$securimage->setNamespace("captcha");
if( !isset($_POST["captcha"]) || $_POST["captcha"] == "" || $securimage->check($_POST['captcha']) === false) {
	die('wrong_captcha'); 
}

die('ok');
?>