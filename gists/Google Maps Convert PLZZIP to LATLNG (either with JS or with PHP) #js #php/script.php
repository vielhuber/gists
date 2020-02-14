<?php
// use here a server side api key
$key = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX';
$address = urlencode('Baumannstraße 23, 94036 Passau, Deutschland');
$url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key='.$key;
$resp_json = file_get_contents($url);
$resp = json_decode($resp_json, true);
if($resp['status'] == 'OK'){
	$lat = $resp['results'][0]['geometry']['location']['lat'];
	$lng = $resp['results'][0]['geometry']['location']['lng'];
}
echo $lat." ".$lng;