<?php
// general filters
add_filter('wpseo_title', function($input) {
    return 'FOO';
},10,1);
add_filter('wpseo_metadesc', function($input) {
    return 'BAR';
},10,1);
add_filter('wpseo_metakey', function($input) {
    return 'BAZ';
},10,1);

// add custom yoast tags on front page (because we use show latest posts)
add_action( 'pre_get_posts', function() {
    if( is_front_page() )
    {
        add_filter('wpseo_title', function($input) {
            return get_field('frontpage_wpseo_title', 'option');
        },10,1);
        add_filter('wpseo_metadesc', function($input) {
            return get_field('frontpage_wpseo_metadesc', 'option');
        },10,1);
    }
});

// first put a default image at SEO > Social > Facebook, then add this filter
// also wrap an action around to get this called in functions.php
add_action( 'wp_enqueue_scripts', function() {
	if( is_singular('custom-post-type') ) {
		add_filter('wpseo_opengraph_image', function($input) {
        $input = 'https://custom-image.jpg';
		    return $input;
		},10,1);
	}
});

// get current custom set images
get_post_meta($post_id, '_yoast_wpseo_opengraph-image', true);
get_post_meta($post_id, '_yoast_wpseo_twitter-image', true);

