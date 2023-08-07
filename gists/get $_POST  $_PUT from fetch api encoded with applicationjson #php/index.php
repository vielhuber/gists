<?php

$_POST // x-www-form-urlencoded
  
json_decode(file_get_contents('php://input'), true); // raw JSON (application/json)

file_get_contents('php://input') // form-data / multipart/form-data (this has to be parsed further!)

// one global helper function to get $_POST / $_PUT with x-www-form-urlencoded or application/json
__::input();