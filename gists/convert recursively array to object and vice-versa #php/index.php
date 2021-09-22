<?php
$arr = [
  "i am" => [
    "an array" => [
      "of arrays" => "yo!"
    ]
  ]
];

// array to object (warning: this does only work on associative arrays, not on ['foo']!)
$obj = json_decode(json_encode($arr));
print_r($obj);


// object to array
$arr = json_decode(json_encode($obj),true);
print_r($arr);