$unique = [];
foreach ($array as $array__value) {
	$unique[print_r($array__value, true)] = $array__value;
}
$unique = array_values($unique);