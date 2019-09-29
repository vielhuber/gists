<?php
function wp_modify_version($src)
{
  $version = 42; // do one of the above solutions
  if(strpos($src, 'ver=') !== false)
  {
    $src = remove_query_arg('ver', $src);
  }
  $src = add_query_arg('ver', $version, $src);
  return $src;
}
add_filter( 'style_loader_src', 'wp_modify_version', 9999 );
add_filter( 'script_loader_src', 'wp_modify_version', 9999 );