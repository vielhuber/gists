<?php
/* wp-config.php */
define( 'SAVEQUERIES', true );

/* footer.php */
global $wpdb;
print_r($wpdb->queries);
// show slowest
$queries = $wpdb->queries;
usort($queries, function($a,$b) {
    if ($a[1] == $b[1]) { return 0; }
    return ($a[1] > $b[1]) ? -1 : 1;
});
print_r($queries[0][0]);