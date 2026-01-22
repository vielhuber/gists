<?php
function redirect_post_custom_posts()
{
  $queried_post_type = get_query_var('post_type');
  if( is_single() && in_array($queried_post_type,['customposttype1', 'customposttype2', 'customposttype3']) )
  {
    wp_redirect( home_url(), 301 );
  	die();
  }
}
add_action( 'template_redirect', 'redirect_post_custom_posts' );