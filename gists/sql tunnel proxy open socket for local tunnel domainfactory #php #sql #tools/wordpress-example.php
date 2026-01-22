shell_exec('ssh *see notes* sleep 3 > /dev/null');
$wpdb_remote = new wpdb('USERNAME', 'PASSWORD', 'DBNAME', 'HOST:PORT');
$results = $wpdb_remote->get_results($wpdb_remote->prepare('SELECT * FROM '.$wpdb_remote->prefix.'tbl WHERE ID > %d', 3));
var_dump($results);
shell_exec('killall ssh');