<?php
add_filter('posts_join', function($join)
{
    global $wpdb;
    if(is_search())
    {    
        $join .= ' LEFT JOIN '.$wpdb->postmeta. ' ON '. $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
    }
    return $join;
});
add_filter('posts_where', function($where)
{
    global $pagenow, $wpdb;
    if(is_search())
    {
        $where = preg_replace(
            "/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
            '('.$wpdb->posts.'.post_title LIKE $1) OR ('.$wpdb->postmeta.'.meta_value LIKE $1)', $where );
    }
    return $where;
});
add_filter('posts_distinct', function($where)
{
    global $wpdb;
    if(is_search())
    {
        return 'DISTINCT';
    }
    return $where;
});