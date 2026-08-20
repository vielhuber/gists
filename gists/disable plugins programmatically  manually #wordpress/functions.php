<?php
if( $_SERVER["SERVER_ADMIN"] == "david@vielhuber.de" ) {
	require_once(ABSPATH.'wp-admin/includes/plugin.php');
	deactivate_plugins([
		'w3-total-cache/w3-total-cache.php'
	]);
}