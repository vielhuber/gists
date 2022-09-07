<?php
add_filter('wpcf7_ajax_json_echo', function( $response, $result )
{
    if( $response['message'] === 'foo')
    {
        $response['message'] .= 'bar';
    }
    return $response;
}, 10, 2);