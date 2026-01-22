<?php
function fun() {
  static $var = 0; // var maintains its value after the function exits
  $var++;
  echo $var;
}
fun(); // 1
fun(); // 2
fun(); // 3