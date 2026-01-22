<?php
/* disable wordpress native cors settings (so that .htaccess settings are applied) */
add_action('rest_api_init', function() {
    remove_filter('rest_pre_serve_request', 'rest_send_cors_headers');
}, 15);