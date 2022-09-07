<?php
$_ENV = array();
$handle = fopen(".env", "r");
if($handle) {
    while (($line = fgets($handle)) !== false) {
      if( strpos($line,"=") !== false) {
        $var = explode("=",$line);
        $_ENV[$var[0]] = trim($var[1]);
    	}
    }
    fclose($handle);
} else { die('error opening .env'); }