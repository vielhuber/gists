<?php
$google_maps_location = "Baumannstraße 23, 94036 Passau, Deutschland";
$google_maps_args = array(
  "key" => '***REMOVED***',
	"center" => $google_maps_location,
	"zoom" => 15,
	"scale" => 1,
	"size" => "220x220",
	"maptype" => "terrain",
	"format" => "png",
	"visual_refresh" => "true",
	"markers" => array(
  		"size" => "mid",
  		"color" => "0xF12263",
  		"label" => substr(strtoupper($customer->company_name),0,1),
		"" => $google_maps_location
	)
);
echo '<a href="https://www.google.de/maps/dir//'.$google_maps_location.'/" target="_blank" title="Zu Google Maps">';
  echo '<img src="http://maps.googleapis.com/maps/api/staticmap?';
  foreach($google_maps_args as $key=>$val) {
  	if(!is_array($val)) {
  		echo $key."=".$val;
  		if( $val !== end($google_maps_args) ) { echo "&amp;"; }
  	}
  	else {
  		echo $key."=";
  		foreach($val as $key2=>$val2) {
  			echo $key2.":".$val2;
  			if( $val2 !== end($val) ) { echo "%7C"; }
  		}
  	}
  }
  echo '" alt="">';
echo '</a>';
?>