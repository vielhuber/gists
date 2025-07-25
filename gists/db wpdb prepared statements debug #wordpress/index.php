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
  
global $wpdb;
  
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
$wpdb->query($wpdb->prepare('SELECT * FROM table WHERE col1 = %s AND col2 = %s', $val, 'bar')); // does not work
$wpdb->query($wpdb->prepare('SELECT * FROM table WHERE (col1 = %s'.($val === null ? ' OR col1 IS NULL' : '').') AND col2 = %s', $val, 'bar')); // does work
$wpdb->insert($wpdb->prefix . 'table', ['col1' => $val], ['%s']); // does work
$wpdb->insert_id // get id of last insert
$wpdb->update($wpdb->prefix . 'table', ['col1' => $val], ['id' => 1337], ['%s'], ['%d']); // does work

// IN query
$ids = [1,2,3];
$wpdb->get_results($wpdb->prepare('SELECT * FROM '.$wpdb->prefix.'table WHERE ID IN (%d)', $ids)); // does not work
$wpdb->get_results($wpdb->prepare('SELECT * FROM '.$wpdb->prefix.'table WHERE ID IN ('.implode(',', array_fill(0, count($ids), '%d')).')', ...$ids)); // works

// retrieve single col/row
$wpdb->get_row()
$wpdb->get_col()
  
// delete rows
$wpdb->delete($wpdb->prefix . 'table', ['ID' => 42]);
  
// connect to external db
global $wpdb;
$wpdb_2 = new wpdb('USERNAME', 'PASSWORD', 'DBNAME', 'HOST:PORT');
$results = $wpdb_2->get_results($wpdb_2->prepare('SELECT * FROM '.$wpdb_2->prefix.'tbl WHERE ID > %d', 3));
var_dump($results);

// debug / info
print_r($wpdb->last_query);
print_r($wpdb->rows_affected);