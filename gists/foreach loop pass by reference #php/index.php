<?php
  
$foo = ['FOO','BaR'];
foreach($foo as &$foo__value) {
	$foo__value = mb_strtolower($foo__value);
}
print_r($foo); // ['foo','bar']

$bar = [1, 2];
foreach ($bar as &$bar__value) {
    $bar__value++;
}
print_r($bar); // [2,3]