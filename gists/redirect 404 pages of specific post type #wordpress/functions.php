add_action('template_redirect', function() {
    global $wp_query;
    if (is_404() && array_key_exists('post_type', $wp_query->query) && $wp_query->query['post_type'] == 'custom') {
        wp_redirect(home_url(), 301);
        exit();
    }
});