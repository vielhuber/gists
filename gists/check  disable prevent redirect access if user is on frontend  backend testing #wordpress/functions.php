<?php
// disable frontend/backend on testing
if( strpos($_SERVER['HTTP_HOST'], '.dev') !== false ) {
  // frontend redirect to backend
  if( !is_admin() && !in_array($GLOBALS['pagenow'], ['wp-login.php', 'wp-register.php']) ) { 
    wp_redirect(get_admin_url());
    die();
  }
  // disable backend also
  else {
    die();
  }
}