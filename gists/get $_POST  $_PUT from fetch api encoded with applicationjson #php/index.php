<?php

$_POST // x-www-form-urlencoded
  
json_decode(file_get_contents('php://input'), true); // raw JSON (application/json)

file_get_contents('php://input') // form-data / multipart/form-data (this has to be parsed further!)

// one global helper function to get $_POST / $_PUT with x-www-form-urlencoded or application/json
function input($key)
{
  $p1 = $_POST;
  $p2 = json_decode(file_get_contents('php://input'), true);
  parse_str(file_get_contents('php://input'), $p3);
  if( isset($p1) && !empty($p1) && array_key_exists($key, $p1) ) {
    return $p1[$key];
  }
  if( isset($p2) && !empty($p2) && array_key_exists($key, $p2) ) {
    return $p2[$key];
  }        
  if( isset($p3) && !empty($p3) )
  {
    foreach($p3 as $p3__key => $p3__value)
    {
      unset($p3[$p3__key]);
      $p3[str_replace('amp;', '', $p3__key)] = $p3__value;
    }
    if( array_key_exists($key, $p3) ) {
      return $p3[$key];
    }
  }
  return null;
}