$query = new \WP_Query(['post_type' => 'any', 'posts_per_page' => '-1', 'post_status' => 'publish']);
while ($query->have_posts()) {
  $query->the_post();
  $url = get_the_permalink();
  echo $url . '<br/>';
}
$query = new \WP_Term_Query(['hide_empty' => false]);
if (!empty($query->terms)) {
  foreach ($query->terms as $terms__value) {
    $url = get_term_link($terms__value);
    // exclude non-public
    if (strpos($url, '?') !== false) {
      continue;
    }
    echo $url.'<br/>';
  }
}