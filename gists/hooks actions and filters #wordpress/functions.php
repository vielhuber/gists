// action
add_action('action_name', function($input) {
	// do something
}, PHP_INT_MAX);

// filter
add_filter('filter_name', function($input) {
	// modify input and return
	return $input;
}, PHP_INT_MAX);