$data = ['foo','bar','baz'];
$query = '';
$query_and = '';
foreach($data as $data__value) {
	$query .= $query_and.$data__value;
    $query_and = ' AND ';
}
echo $query; // foo AND bar AND baz