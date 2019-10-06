<?php
add_action( 'wp_enqueue_scripts', function()
{
    add_action( 'wpseo_add_opengraph_images', function($object)
    {
        $image = 'https://www.camac-harps.com/wp-content/themes/camacharps/img/logo.png';  
        $object->add_image( $image );
    });
});