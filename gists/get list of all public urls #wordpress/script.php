$query = new \WP_Query(['post_type' => 'any', 'posts_per_page' => '-1', 'post_status' => 'publish']);
while ($query->have_posts()) {
  $query->the_post();
  echo get_the_permalink() . '<br/>';
}