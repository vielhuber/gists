$wpdb->query("
	INSERT INTO
		table
	(
		`key_1`,
		`key_2`,
		`key_3`
	)
	VALUES
	(
		'".date('Y-m-d H:i:s')."',
		'".$value2."',
		".(($value3 == "")?("NULL"):("'".$value3."'"))."
")