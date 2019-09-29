<?php
if(
    strpos($_SERVER['HTTP_HOST'], 'close2dev') !== false &&
    !is_user_logged_in() &&
    !is_admin() &&
    $pagenow != 'wp-login.php'
)
{
    wp_redirect(get_admin_url());
    die();
}