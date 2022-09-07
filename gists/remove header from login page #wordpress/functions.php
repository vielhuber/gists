function custom_login() {
	echo '<style type="text/css">'.
             '#login h1, #login #nav, #login #backtoblog { display:none; }'.
	'</style>';
}
add_action( 'login_enqueue_scripts', 'custom_login' );