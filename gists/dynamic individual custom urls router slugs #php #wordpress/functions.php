<?php
function rewrite_tag() {
	add_rewrite_tag('%rewrite%', '([^&]+)');
}
add_action('init', 'rewrite_tag', 10, 0);
function rewrite_rule() {
	$base = 'custom-page';
	if( $base != "" ) { $base = str_replace("/","\/",$base); $base = $base."\/"; }
	add_rewrite_rule('^'.$base.'(.*)/?','index.php?page_id='.get_page_by_path('custom-page')->ID.'&rewrite=$matches[1]','top');
}
add_action('init', 'rewrite_rule', 10, 0);

/* always flush rewrite rules ONCE after making changes */
if(1==0) { flush_rewrite_rules(); }


/* if you want to modify permalinks for custom post types in order to lead to the urls specified above, do this here */
function change_permalinks( $post_link, $post, $leavename ) {
    if ( $post->post_type != 'specific-post-type' ) { return $post_link; }
    $post_link = str_replace( '/'.$post->post_type.'/', '/whatever/', $post_link );
    return $post_link;
}
add_filter( 'post_type_link', 'change_permalinks', 10, 3 );

/* disable yoast canonical urls on those special pages */
add_filter( 'wpseo_canonical', function($canonical) {
  if( strpos($canonical, 'custom-page') !== false )
  {
    return false;
  }
  return $canonical;
});