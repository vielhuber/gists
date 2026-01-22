add_filter(
    'posts_search',
    function ($sql, $wp_query) {
        if (empty($sql)) {
            return $sql;
        }
        global $wpdb;
        $search_term = $wp_query->query_vars['s'];
        $sql .= ' OR (' . $wpdb->prefix . 'posts.ID IN (1,2,3))';
        return $sql;
    },
    20,
    2
);