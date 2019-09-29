<?php
/* disable comments in backend and frontend */
add_action( 'admin_menu', function()
{
    remove_menu_page( 'edit-comments.php' );
});
add_action('init', function()
{
    remove_post_type_support( 'post', 'comments' );
    remove_post_type_support( 'page', 'comments' );
}, 100);
add_action( 'wp_before_admin_bar_render', function()
{
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('comments');
});