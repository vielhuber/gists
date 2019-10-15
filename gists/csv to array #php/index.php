<?php
$csv = $_SERVER['DOCUMENT_ROOT'].'/input.csv';
$array = array_map(function($d) {
  return array_map(function($d2) {
    if( !mb_detect_encoding($d2, 'UTF-8', true) ) { $d2 = utf8_encode($d2); }
    return $d2;
  }, str_getcsv($d, ';', '"'));
}, file($csv));