<?php
/* enable search by sku */
add_filter('posts_where', function($where, $query)
{
    if(!$query->is_main_query() || is_admin() || !is_search())
    {
        return $where;
    } 
    global $wpdb;
    $where = preg_replace(
        "/\(\s*{$wpdb->posts}.post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
        "
            ({$wpdb->posts}.post_title LIKE $1) OR
            (EXISTS(SELECT * FROM {$wpdb->postmeta} WHERE {$wpdb->postmeta}.post_id = {$wpdb->posts}.ID AND {$wpdb->postmeta}.meta_key = '_sku' AND meta_value LIKE $1))
        ",
        $where
    );
    return $where;
}, 10, 2);