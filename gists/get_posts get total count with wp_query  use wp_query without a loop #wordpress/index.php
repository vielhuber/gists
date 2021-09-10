<?php
/* fill in args from https://gist.github.com/luetkemj/2023628 */
$args = [];
$wp_query = new \WP_Query($args);
if($wp_query->found_posts > 0 ) {
	foreach($wp_query->posts as $posts__value) {
    	/* ... */
	}
}

// debug query
echo $wp_query->request;

// manually start loop
if ($wp_query->have_posts()) {
  while ($wp_query->have_posts()) {
    $wp_query->the_post();
    echo get_the_title();
  }
}
wp_reset_postdata();