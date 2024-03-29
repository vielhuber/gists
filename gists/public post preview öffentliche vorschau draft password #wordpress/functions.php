<?php
/* preview posts */
add_filter('posts_results', function( $posts )
{
    if( !empty($posts) && isset($_GET['key']) && $_GET['key'] === md5($posts[0]->ID.'secret') )
    {
        $posts[0]->post_status = 'publish';
    }
    return $posts;
}, 10, 2);
// siteorigin builder compatiblity (showing old content)
add_action('pre_get_posts', function() {
    if( isset($_GET['key']) && $_GET['key'] != '' )
    {
        global $preview;
        $preview = false;
    }
}, PHP_INT_MAX);
add_action( 'post_submitbox_misc_actions', function()
{
    $post = get_post();
    if( !in_array($post->post_type, ['post', 'custom-post']) || $post->post_status === 'publish' )
    {
        return;
    }
    echo '<div style="padding:6px 10px 8px"><a href="'.get_permalink($post->ID).'&amp;preview=1&amp;key='.md5($post->ID.'secret').'" target="_blank">Öffentliche Vorschau</a></div>';
});