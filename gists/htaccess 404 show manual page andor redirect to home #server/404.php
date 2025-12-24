<?php
header('HTTP/1.0 404 Not Found');
$url = 'http'.((isset($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')?'s':'').'://'.$_SERVER['HTTP_HOST'].'';
echo '<meta http-equiv="refresh" content="2; url=\''.$url.'\'">';
die();