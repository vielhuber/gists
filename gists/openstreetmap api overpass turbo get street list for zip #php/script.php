<?php
require_once(__DIR__ . '/vendor/autoload.php');

$query = '
    [out:csv("name";false)];
    {{geocodeArea:Germany}}->.searchArea;
    area[name="Passau"];
    way(area)[highway][name];
    out;
';

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