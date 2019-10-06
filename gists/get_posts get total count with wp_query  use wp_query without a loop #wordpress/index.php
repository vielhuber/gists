<?php
function get_posts_with_count() {
  $wp_query = new WP_Query( $args );
	$wp_query = new WP_Query( $args );
	$return = ["count" => 0, "data" => []];
	$return["count"] = $wp_query->found_posts;
	if($return["count"] > 0 ) {
	foreach($wp_query->posts as $post) {
	    $return["data"][] = $post;
	}
	}
	return $return;
}