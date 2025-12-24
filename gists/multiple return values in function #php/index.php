<?php
function fun() {
  return ['foo','bar']; 
}

// #1: using php 7 short list syntax
[$var1, $var2] = fun();

// #2: using lists
list($var1, $var2) = fun();

// #3: the hard way
echo fun()[0];
echo fun()[1];

echo $var1; // foo
echo $var2; // bar