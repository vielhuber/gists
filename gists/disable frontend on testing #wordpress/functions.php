<?php
if(
    strpos($_SERVER['HTTP_HOST'], 'close2dev') !== false &&
    !is_user_logged_in() &&
    !is_admin() &&
  	!in_array($GLOBALS['pagenow'], ['wp-login.php', 'wp-register.php'])
)
{
    wp_redirect(get_admin_url());
    die();
}