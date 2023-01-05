<?php
function disable_uneeded_archives() {
	if( is_category() || is_tag() || is_date() || is_author() || is_attachment() ) {
		header("Status: 404 Not Found");
		global $wp_query;
		$wp_query->set_404();
		status_header(404);
		nocache_headers();
	}
}
add_action('template_redirect', 'disable_uneeded_archives');