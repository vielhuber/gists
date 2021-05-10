<?php
/*
placeholders:
  - %s (string)
  - %d (integer)
  - %f (float)
  
functions:
  - get_results
  - get_var
  - get_row
  - get_col
  - query
  - insert
  - update
  - delete
  - prepare
*/
  
// examples
$wpdb->get_var($wpdb->prepare('
  SELECT * FROM table WHERE col_digit = %d AND col_string = %s
', 1337, 'foo'));

$wpdb->get_results($wpdb->prepare('
  SELECT * FROM '.$wpdb->prefix.'table WHERE col_digit = %d
', 1337));

// table names cannot be prepared (because of single quotes instead of backticks)
$wpdb->get_results($wpdb->prepare('SELECT * FROM %s WHERE ID = %d', $wpdb->prefix.'table', 1337)); // does not work
$wpdb->get_results($wpdb->prepare('SELECT * FROM '.$wpdb->prefix.'table WHERE ID = %d', 1337)); // works
$wpdb->get_results($wpdb->prepare('SELECT * FROM '.$wpdb->table.' WHERE ID = %d', 1337)); // alternative

// be careful with % in query
$wpdb->get_var($wpdb->prepare('SELECT * FROM table WHERE partner_id = %i AND name LIKE \'%foo%\'', 1337)); // does not work
$wpdb->get_var($wpdb->prepare('SELECT * FROM table WHERE partner_id = %i AND name LIKE %s', 1337, '%foo%')); // does work

// null values only work with db_insert / db_update
$val = null;
$wpdb->query($wpdb->prepare('INSERT INTO table(col1) VALUES(%s)',$val)); // does not work
$wpdb->insert($wpdb->prefix . 'table', ['col1' => $val], ['%s']); // does work
$wpdb->update($wpdb->prefix . 'table', ['col1' => $val], ['id' => 1337], ['%s'], ['%d']); // does work