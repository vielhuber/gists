<?php
// set timeout for wp_remote_request (used for cache-priming) to 15 seconds
add_filter('http_request_timeout', function( $timeout ) {
    return 15;
});
