// sort search results by post type
add_filter('posts_orderby', function($orderby){
    if (!is_admin() && is_search()) {
        global $wpdb;
        $orderby = '
            CASE WHEN '.$wpdb->prefix.'posts.post_type = \'page\' THEN \'1\' 
                 WHEN '.$wpdb->prefix.'posts.post_type = \'post\' THEN \'2\'
                 ELSE \'3\' END
            ASC, (9+'.$wpdb->prefix.'posts.menu_order) ASC
        ';
    }
    return $orderby;
});