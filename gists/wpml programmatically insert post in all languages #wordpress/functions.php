// this should be run e.g. on a rest api route
// don't run this on admin_init hook (since it conflicts with the users session)
add_action('rest_api_init', function () {
    register_rest_route('v1', '/debug', [
        'methods' => \WP_REST_Server::READABLE,
        'permission_callback' => function (\WP_REST_Request $request) { return true; },
        'callback' => function (\WP_REST_Request $request) {
            global $sitepress;
          	// insert post in default language
            $sitepress->switch_lang('de');
            $post_id_de = wp_insert_post([
                'post_type' => 'custom',
                'post_title' => 'Test post (DE)',
                'post_status' => 'draft'
            ]);
          	// insert post in secondary language
            $sitepress->switch_lang('en');
            $post_id_en = wp_insert_post([
                'post_type' => 'custom',
                'post_title' => 'Test post (EN)',
                'post_status' => 'draft'
            ]);
          	// connect the two posts
            $sitepress->switch_lang('de');
            do_action('wpml_set_element_language_details', [
                'element_id' => $post_id_en,
                'element_type' => apply_filters('wpml_element_type', 'custom'),
                'trid' => apply_filters('wpml_element_language_details', null, [
                    'element_id' => $post_id_de,
                    'element_type' => 'custom'
                ])->trid,
                'language_code' => 'en',
                'source_language_code' => 'de'
            ]);
        }
    ]);
});