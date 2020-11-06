<?php
// disable backend on testing
if( strpos($_SERVER['HTTP_HOST'], 'close2dev') !== false ) {
  if( !is_admin() && !in_array($GLOBALS['pagenow'], ['wp-login.php', 'wp-register.php']) ) {
    // e.g. redirect to backend    
    wp_redirect(get_admin_url());
    die();
  }
  else {
    die();
  }
}