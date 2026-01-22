<?php
add_action('init', function () {
	/* internal rules (will be added to database) */
	add_rewrite_rule(
		'^internalfoo$',
		'index.php',
		'top'
	);
  
  	/* example */
  	add_rewrite_rule(
      'blog/([0-9]+)/?$',
      'index.php?pagename=blog&pagination=$matches[1]',
      'top'
    );

	/* how to debug */
	/*
	global $wp_rewrite;
	print_r($wp_rewrite->rules);
	*/

	/* external rules
	- will be added to .htaccess
	- only relative urls are allowed
	*/

	add_rewrite_rule(
		'^externalfoo$',
		'foo.php',
		'top'
	);

	/* how to debug */
	/*
	global $wp_rewrite;
	print_r($wp_rewrite->non_wp_rules);
	*/
});

/* if you have added (custom) query vars */
add_filter('query_vars', function ($query_vars) {
    $query_vars[] = 'pagination';
    return $query_vars;
});

/* only run this once(!) */
/* always run this in the BACKEND, because in frontend external rules won't be added */
/* or: simply save permalinks in backend */
if (1 == 1) {
	add_action('shutdown', function () {
		global $wp_rewrite;
		$wp_rewrite->flush_rules();
	});
}
