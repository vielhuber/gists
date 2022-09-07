<?php
function filter_my_search_query($query)
{
    if (is_search() && $query->is_main_query() && !is_admin()) {
        global $the_original_paged;
        $the_original_paged = $query->get('paged') ? $query->get('paged') : 1;
        $query->set('paged', null);
        $query->set('nopaging', true);
    }
}
add_action('pre_get_posts', 'filter_my_search_query', 1);

function add_posts_to_search_query($posts)
{
    global $wp_query, $the_original_paged;
    if (!is_main_query() || is_admin() || !is_search() || is_null($the_original_paged)) {
        return $posts;
    }
    $perpage = get_option('posts_per_page');    
    remove_filter('the_posts', 'add_posts_to_search_query'); // prevent endless loop
    $query = get_query_var('s', null);
    $custom_posts = [
        (object) [
            'ID' => 654654,
            'post_title' => 'Dummy title #1',
            'post_type' => 'custom'
        ],
        (object) [
            'ID' => 654654,
            'post_title' => 'Dummy title #2',
            'post_type' => 'custom'
        ]
    ];
    $merged = array_merge($posts, $custom_posts);
    $wp_query->found_posts += count($custom_posts);
    $wp_query->posts = array_slice($merged, $perpage * ($the_original_paged - 1), $perpage);
    $wp_query->set('paged', $the_original_paged);
    $wp_query->post_count = count($wp_query->posts);
    $wp_query->max_num_pages = ceil($wp_query->found_posts / $perpage);
    unset($the_original_paged); // clean up global variable
    return $wp_query->posts;
}
add_filter('the_posts', 'add_posts_to_search_query');
