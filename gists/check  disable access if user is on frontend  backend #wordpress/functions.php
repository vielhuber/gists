<?php
if( strpos($_SERVER['HTTP_HOST'], 'close2dev') !== false ) {
  if( !is_admin() && $pagenow != 'wp-login.php' ) {
    // e.g. redirect to backend    
    wp_redirect(get_admin_url());
    die();
  }

  if( is_admin() || $pagenow == 'wp-login.php' ) {
    die();
  }
}