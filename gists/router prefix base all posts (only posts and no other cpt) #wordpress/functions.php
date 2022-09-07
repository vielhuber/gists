add_action('generate_rewrite_rules', function( $wp_rewrite )
{
    $new_rules = array(
        'custom-prefix/(.+?)/?$' => 'index.php?post_type=post&name='. $wp_rewrite->preg_index(1),
    );
    $wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
});
add_filter('post_link', function($post_link, $id=0){
    $post = get_post($id);
    if( is_object($post) && $post->post_type == 'post'){
        return home_url('/custom-prefix/'. $post->post_name.'/');
    }
    return $post_link;
}, 1, 3);
add_filter( 'wpseo_canonical', function( $url ) {
  if ( get_post_type() == 'post' ) { return get_permalink(get_the_ID()); }
  return $url;
});
add_filter( 'wpseo_opengraph_url', function( $url ) {
  if ( get_post_type() == 'post' ) { return get_permalink(get_the_ID()); }
  return $url;
});
// if needed, reset yoast indexables manually: https://yoast.com/help/how-to-reset-yoast-indexables/
