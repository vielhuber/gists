<?php
/* wp-config.php */
define( 'SAVEQUERIES', true );

/* functions.php */
add_action('wp_footer', function($input) {
  global $wpdb;
  // show all
  print_r($wpdb->queries);
  // show slowest
  $queries = $wpdb->queries;
  usort($queries, function($a,$b) {
      if ($a[1] == $b[1]) { return 0; }
      return ($a[1] > $b[1]) ? -1 : 1;
  });
  print_r($queries[0][0]);
}, PHP_INT_MAX);