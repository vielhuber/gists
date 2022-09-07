<?php
// without prepared statements
$sql->query("INSERT INTO table(`row1`,`row2`,`row3`) VALUES(
	'".date('Y-m-d H:i:s')."',
	".(($data1!=="")?("'".$data1."'"):("NULL")).",
	'".$data2."'
)");
$result_id = $sql->insert_id;

// with prepared statements
$query = $sql->prepare("INSERT INTO table(`row1`,`row2`,`row3`) VALUES(?,?,?)");
$query->bind_param("sss", $a=date('Y-m-d H:i:s'), $a=(($data1!=="")?($data1):(null)), $a=$data2);
$query->execute();
?>