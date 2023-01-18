<?php
// open https://tld.com/?debug_cron=your_cronjob_name
add_action( 'init', function() {
    if (!isset($_GET['debug_cron']) || $_GET['debug_cron'] == '') {
        return;
    }
    error_reporting( 1 );
    do_action( strip_tags($_GET['debug_cron']) );
    die();
} );