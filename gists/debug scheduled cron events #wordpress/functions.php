<?php
add_action( 'init', function() {
    if ( ! isset( $_GET['debug_cron'] ) ) {
        return;
    }
    error_reporting( 1 );
    do_action( 'cronjob_name' );
    die();
} );