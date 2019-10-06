<?php
add_filter('site_transient_update_plugins', function($value)
{
    if(isset($value) && is_object($value))
    {
        unset( $value->response[ 'custom-facebook-feed-pro/custom-facebook-feed.php' ] );
    }
    return $value;
});