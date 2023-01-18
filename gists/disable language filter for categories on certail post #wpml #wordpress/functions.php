<?php
add_action('current_screen', function () {
    $screen = get_current_screen();
    if (is_admin() && $screen->post_type === 'special_post_type') {
        global $sitepress;
        remove_filter('terms_clauses', array($sitepress, 'terms_clauses'));
    }
});