add_action('wp_enqueue_scripts', function() {
    global $wp_styles;
    foreach ($wp_styles->queue as $style_handle) {
        wp_dequeue_style($style_handle);
    }
    global $wp_scripts;
    foreach ($wp_scripts->queue as $script_handle) {
        wp_dequeue_script($script_handle);
    }
});