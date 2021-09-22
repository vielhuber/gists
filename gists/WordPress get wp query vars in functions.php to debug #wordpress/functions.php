<?php
// the filter is needed here because otherwise it is too early
add_filter('pre_get_posts', function($query) {
	echo '<pre>';
	print_r($query);
	echo '</pre>';
    return $query;
},5);

// alternative
add_action( 'wp_enqueue_scripts', function() {
	// here you can call is_singular, is_tax, etc.
});