// redirect first blog always to admin
if (
    get_current_blog_id() == '1' &&
    !is_admin() &&
    !in_array($GLOBALS['pagenow'], ['wp-login.php', 'wp-register.php']) &&
    !(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') &&
    !wp_is_json_request() &&
    !defined('DOING_CRON')
) {
    wp_redirect(get_admin_url());
    die();
}