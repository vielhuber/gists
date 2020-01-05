<?php
$duplicates = [];
$tables = $this->db->get_tables();
foreach ($tables as $tables__value) {
	$columns = $this->db->get_columns($tables__value);
	$primaryKey = $this->db->get_primary_key($tables__value);
	__remove_by_value($columns, $primaryKey);
	$duplicates_this = $this->db->fetch_all('SELECT ' . implode(', ', $columns) . ', COUNT(*) FROM ' . $tables . ' GROUP BY ' . implode(', ', $columns) . ' HAVING COUNT(*) > 1');
	if (__x($duplicates_this)) { $duplicates[] = $duplicates_this; }
}
__d($duplicates);