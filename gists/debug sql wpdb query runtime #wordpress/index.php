<?php
/* wp-config.php */
define( 'SAVEQUERIES', true );

/* functions.php */
add_action(
  'wp_footer', // use 'wp_footer' (frontend), 'admin_footer' (backend), 'wp_ajax_*ACTION*' (ajax calls, find *ACTION* via payload)
  function($input) {
    global $wpdb;
    echo '<pre>';
    // show all
    print_r($wpdb->queries);
    // show slowest
    $queries = $wpdb->queries;
    usort($queries, function($a,$b) {
        if ($a[1] == $b[1]) { return 0; }
        return ($a[1] > $b[1]) ? -1 : 1;
    });
    print_r($queries[0][0]);
    echo '</pre>';
  },
  PHP_INT_MAX // use -1 instead if it's too late
);