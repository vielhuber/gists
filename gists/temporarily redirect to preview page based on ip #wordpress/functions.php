if (@$_SERVER['REMOTE_ADDR'] != '123.456.789' && 
    (strpos(@$_SERVER['HTTP_HOST'], '.local') === false && strpos(@$_SERVER['HTTP_HOST'], '192.168.178') === false) &&
    !is_user_logged_in() && !is_admin() && $pagenow != 'wp-login.php') {
    wp_redirect(site_url() . '/preview.html');
    die();
}