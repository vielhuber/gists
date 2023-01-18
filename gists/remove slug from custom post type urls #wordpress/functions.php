<?php
add_filter(
    'post_type_link',
    function ($post_link, $post, $leavename) {
        if ($post->post_type != 'custom-post-type' || $post->post_status != 'publish') {
            return $post_link;
        }
        $post_link = str_replace('/' . $post->post_type . '/', '/', $post_link);
        return $post_link;
    },
    10,
    3
);
add_action('pre_get_posts', function ($query) {
    if (!$query->is_main_query()) {
        return;
    }
    if (count($query->query) != 2 || !isset($query->query['page'])) {
        return;
    }
    if (!empty($query->query['name'])) {
        $query->set('post_type', ['post', 'page', 'custom-post-type']);
    }
});