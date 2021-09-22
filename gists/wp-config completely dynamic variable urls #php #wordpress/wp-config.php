<?php
define('WP_HOME', 'http'.(($_SERVER['SERVER_PORT'] == 443)?('s'):('')).'://'.str_replace("www.","",$_SERVER['HTTP_HOST']));
	define('WP_SITEURL', 'http'.(($_SERVER['SERVER_PORT'] == 443)?('s'):('')).'://'.str_replace("www.","",$_SERVER['HTTP_HOST']));