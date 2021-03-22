// action
add_action('action_name', function($input) {
	// do something
}, PHP_INT_MAX);

// filter
add_filter('filter_name', function($input) {
	// modify input and return
	return $input;
}, PHP_INT_MAX);
add_filter('filter_name', function($input, $additional_input) {
	return $input;
}, PHP_INT_MAX, 2); // provide an argument count if you want to read more than 1 argument
