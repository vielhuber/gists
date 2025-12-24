<?php
function function_to_run_on_save($post_id) {
    if (wp_is_post_revision($post_id) || get_current_blog_id() != 1 || get_post_type($post_id) != 'custom_post_type') {
        return;
    }
    // TODO
}
add_action('save_post', 'function_to_run_on_save');
