<?php
add_action('admin_init', function()
{
    remove_post_type_support( 'post', 'editor' );
    remove_post_type_support( 'page', 'editor' );
});