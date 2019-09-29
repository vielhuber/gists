<?php
// wp-config.php
define( 'SAVEQUERIES', true );

// footer.php
global $wpdb;
print_r($wpdb->queries);