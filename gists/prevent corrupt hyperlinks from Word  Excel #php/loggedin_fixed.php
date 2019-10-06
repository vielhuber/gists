<?php
if( strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 7.0' ) !== false) { die('prevent redirect'); }
if( !isset($_COOKIE["logged_in"]) ) { header("Location: login.php"); die(); }
echo 'you are logged in';
?>