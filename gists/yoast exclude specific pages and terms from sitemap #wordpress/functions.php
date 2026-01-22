add_filter('wpseo_exclude_from_sitemap_by_post_ids', function () {
    $exclude = [];
    $wp_query = new \WP_Query([
        'post_type' => ['custom-post-type'],
        'posts_per_page' => -1,
        'meta_key' => 'active',
        'meta_compare' => '!=',
        'meta_value' => '1'
    ]);
    if ($wp_query->found_posts > 0) {
        foreach ($wp_query->posts as $posts__value) {
            $exclude[] = $posts__value->ID;
        }
    }
    return $exclude;
});
add_filter(
    'wpseo_exclude_from_sitemap_by_term_ids',
    function () {
        $exclude = [];
        $terms = get_terms([
            'taxonomy' => 'custom-taxonomy',
            'hide_empty' => false,
            'meta_query' => [
                [
                    'key' => 'active',
                    'compare' => '!=',
                    'value' => '1'
                ]
            ]
        ]);
        if (!empty($terms)) {
            foreach ($terms as $terms__value) {
                $exclude[] = $terms__value->term_id;
            }
        }
        return $exclude;
    },
    10,
    1
);