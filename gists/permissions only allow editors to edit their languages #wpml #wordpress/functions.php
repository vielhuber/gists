<?php
// wpml restrict editor edit
add_action('admin_head', function () {
    if (is_user_logged_in() && !in_array('administrator', (array) wp_get_current_user()->roles)) {

        global $wpdb;

        $languages = get_user_meta(get_current_user_id(), $wpdb->prefix . 'language_pairs', true);
        $language_current =
            isset($_GET['lang']) && $_GET['lang'] != '' ? $_GET['lang'] : apply_filters('wpml_current_language', null);
        $languages_allowed = [];

        if (!empty($languages)) {
            foreach ($languages as $languages__value) {
                foreach ($languages__value as $languages__value__key => $languages__value__value) {
                    if ($languages__value__value == '1') {
                        $languages_allowed[] = $languages__value__key;
                    }
                }
            }
        }
        ?>
        <style>
            #wp-admin-bar-WPML_ALS-default { display:none !important; }
        </style>
        <?php if (!in_array($language_current, $languages_allowed)) { ?>
            <script>
                let url_current = window.location.href,
                    language_allowed = '<?php echo $languages_allowed[0]; ?>';
                if( url_current.indexOf('lang=') > -1 ) {
                    url_current = url_current.replace(/(lang=)([a-zA-Z-]+)/i, '$1'+language_allowed)
                }
                else {
                    url_current += (url_current.indexOf('?') > -1 ? '&' : '?')+'lang='+language_allowed;
                }
                if( localStorage.getItem('wpml_last_redirect') === null || localStorage.getItem('wpml_last_redirect') !== url_current ) {
                    localStorage.setItem('wpml_last_redirect', url_current);
                    window.location.href = url_current;
                }
                else {
                    window.location.href = '<?php echo get_admin_url(); ?>';
                }
            </script>
        <?php die();}
    }
});