<?php
$lat = 51.254180;
$lng = 10.700684;
$data = [];
for($i = 0; $i < 100; $i++) {
	$obj = new stdClass();
	$obj->lat = $lat + (mt_rand(-100,100)/50);
	$obj->lng = $lng + (mt_rand(-100,100)/50);
	$data[] = $obj;
}
echo json_encode($data);

