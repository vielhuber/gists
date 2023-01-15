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

/* BE VERY CAREFUL WHEN USING THIS! */
$bar = [2, 7, 14];
foreach ($bar as &$bar__value) { $bar__value++; }
print_r($bar); // [3, 8, 15]
print_r($bar__value); // 15 (this is the reference!)
$bar__value = 99;
print_r($bar); // [3, 8, 99]
$bar[2] = 0;
print_r($bar__value); // 0
foreach ($bar as $bar__value) { }
print_r($bar); // [3, 8, 8] // $bar__value gets overritten on every iteration (after the 2nd it has the value of 8; on the last run, it overrides itself with 8)

/* recommendation */
foreach ($bar as &$bar__value) { }
unset($bar__value); // unset to prevent errors