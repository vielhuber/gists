<?php
// calculate distance with the help of the haversine formula
function distance($lat1, $lng1, $lat2, $lng2) {
  $theta = $lng1 - $lng2;
  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
  $dist = acos($dist);
  $dist = rad2deg($dist);
  return round(($dist * 60 * 1.1515 * 1.609344),2);
}
echo distance(48.576687, 13.403173, 48.632311, 13.17464);