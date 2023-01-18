<?php
if( $_SERVER["SERVER_ADMIN"] == "david.vielhuber@close2.de" ) {
//if( strpos(realpath(dirname(__FILE__)),"MAMP\htdocs") !== false) {
//if(in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', "::1"])) {
//if(strpos($_SERVER['HTTP_HOST'], ".dev") !== false) {
	define('DB_NAME', 'dbname');
	define('DB_USER', 'username');
	define('DB_PASSWORD', 'password');
	define('DB_HOST', '127.0.0.1');
	define('WP_DEBUG', true);
	define('DIEONDBERROR', true); 
}
else {
	define('DB_NAME', 'dbname');
	define('DB_USER', 'username');
	define('DB_PASSWORD', 'password');
	define('DB_HOST', '127.0.0.1');
	define('WP_DEBUG', false);
	define('DIEONDBERROR', false); 
}