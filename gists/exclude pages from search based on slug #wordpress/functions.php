add_filter('pre_get_posts', function ($query) {
    global $wpdb;
    $slug = 'forum';
    $post_ids = $wpdb->get_col(
        $wpdb->prepare(
            'SELECT ID FROM ' .
                $wpdb->prefix .
                'posts WHERE post_status = %s AND
                (post_name LIKE %s OR post_parent = (SELECT ID FROM red_posts WHERE post_status = %s AND post_name LIKE %s LIMIT 1))',
            'publish',
            '%' . $slug . '%',
            'publish',
            '%' . $slug . '%'
        )
    );
    if (!$query->is_admin && $query->is_search && $query->is_main_query() && !empty($post_ids)) {
        $query->set('post__not_in', $post_ids);
    }
});