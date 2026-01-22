<?php
global $wp_query;
if (have_posts()) {
    echo $wp_query->found_posts;
    the_search_query();
} else {
    the_search_query();
}
if (have_posts()) {
    $result_index = 1;
    $max_num_per_page = (int) get_option('posts_per_page');
    $current_paged = get_query_var('paged') ? get_query_var('paged') : 1;
    while (have_posts()) {
        the_post();
        global $post;
        $result_num = $result_index + ($current_paged - 1) * $max_num_per_page;
        $post_type = get_post_type(get_the_ID());
        if ($post_type === 'post' || $post_type === 'page') {
            echo get_the_ID();
            echo get_the_category(get_the_ID());
            echo get_the_permalink();
            echo get_the_title();
        }
        if ($post_type == 'custom') {
            print_r($post);
        }
    }
}
$pagination = paginate_links(array(
    'base' => str_replace(PHP_INT_MAX, '%#%', esc_url(get_pagenum_link(PHP_INT_MAX))),
    'format' => '?paged=%#%',
    'current' => max(1, absint(get_query_var('paged'))),
    'total' => $wp_query->max_num_pages,
    'type' => 'array',
    'prev_text' => false,
    'next_text' => false
));
if (!empty($pagination)) {
    if (get_previous_posts_link()) {
        previous_posts_link('<img class="search-pagination__link--prev" src="' . get_template_directory_uri() . '/_images/arrow-bold-up-white.svg" alt="Vorige" />');
    }
    $max_num_per_page = (int) get_option('posts_per_page');
    $current_paged = get_query_var('paged') ? get_query_var('paged') : 1;
    $first_result_num = $max_num_per_page * $current_paged - ($max_num_per_page - 1);
    $last_result_num = $max_num_per_page * $current_paged;
    if (get_next_posts_link()) {
        next_posts_link('<img class="search-pagination__link--next" src="' . get_template_directory_uri() . '/_images/arrow-bold-down-white.svg" alt="Nächste" />');
    }
}
