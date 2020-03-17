<?php
require_once(__DIR__ . '/vendor/autoload.php');

// get city and zip ("{{geocodeArea:Germany}}" is only available in overpass turbo and is syntactic sugar for "area(3600051477)")
$query = '
    [out:csv(postal_code,"note")][timeout:180];
    area(3600051477)->.searchArea;
    relation["boundary"="postal_code"](area.searchArea);
    out body;
';

// get streets for city
$query = '
  [out:csv(name;false)];
  area(3600051477)->.a;
  area[name="Passau"]->.a;
  way(area.a)[highway][name];
  out;
';

// get streets for zip
$query = '
    [out:csv(name;false)];
    area[postal_code="94036"]->.a;
    way(area.a)[highway][name];
    out;
';

$response = __curl(
    'https://lz4.overpass-api.de/api/interpreter',
    ['data' => $query],
    null,
    false,
    false,
    60
);

$output = $response->result;
$output = explode(PHP_EOL, $output);
$output = __remove_empty($output);
$output = array_unique($output);
natcasesort($output);
$output = array_values($output);

__d($output);