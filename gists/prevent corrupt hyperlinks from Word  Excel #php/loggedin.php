<?php
if( !isset($_COOKIE["logged_in"]) ) { header("Location: login.php"); die(); }
echo 'you are logged in';
?>