<?php
function cool($foo, $bar, $baz) { echo $foo.$bar.$baz; }
$args = [];
$args["1st_arg"] = 'one';
$args["2nd_arg"] = 'two';
$args["3rd_arg"] = 'three';
cool(...array_values($args)); // "onetwothree"
call_user_func_array('cool',$args); // below php 7.4