// approach 1 (db)
$urls = [];
$urls[] = get_bloginfo('url');
$query = new \WP_Query(['post_type' => 'any', 'posts_per_page' => '-1', 'post_status' => 'publish']);
while ($query->have_posts()) {
  $query->the_post();
  $url = get_the_permalink();
  $urls[] = $url;
}
$query = new \WP_Term_Query(['hide_empty' => false]);
if (!empty($query->terms)) {
  foreach ($query->terms as $terms__value) {
    $url = get_term_link($terms__value);
    // exclude non-public
    if (strpos($url, '?') !== false) {
      continue;
    }
    $urls[] = $url;
  }
}

// approach 2 (sitemap)
$urls = __extract_urls_from_sitemap('https://vielhuber.de/sitemap.xml');