<?php
add_filter(
    'posts_search',
    function ($sql, $wp_query) {
        if (empty($sql) || empty($wp_query->query_vars['s'])) { return $sql; }
        global $wpdb;
        return ' AND (' . $wpdb->prefix . 'posts.ID IN ( SELECT ID FROM ( SELECT ' . $wpdb->prefix . 'posts.ID as ID,
        CONCAT( ' . $wpdb->prefix . 'posts.post_title,
        ExtractValue(' . $wpdb->prefix . 'posts.post_content, \'//text()\'),
        GROUP_CONCAT(' . $wpdb->prefix . 'postmeta.meta_value) ) as content
        FROM ' . $wpdb->prefix . 'posts
        LEFT JOIN ' . $wpdb->prefix . 'postmeta ON ' . $wpdb->prefix . 'postmeta.post_id = ' . $wpdb->prefix . 'posts.ID
        GROUP BY ' . $wpdb->prefix . 'posts.ID
        HAVING content REGEXP \'' . implode( '|', array_map(function ($a) { return '.*' . str_replace("'", "\'", preg_quote(trim($a))) . '.*'; }, explode(' ', $wp_query->query_vars['s'])) ) . '\') as t
        ) OR (' . (strpos($sql, ' AND') === 0 ? substr($sql, strlen(' AND')) : $sql) . '))';
    },
20, 2);