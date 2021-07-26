<?php
/* fill in args from https://gist.github.com/luetkemj/2023628 */
$args = [];
$wp_query = new \WP_Query($args);
if($wp_query->found_posts > 0 ) {
	foreach($wp_query->posts as $posts__value) {
    	/* ... */
	}
}