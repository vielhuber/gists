<?php
/* problem */
$array = ['a' => 1, 'b' => 2, 'c' => 3];
foreach ($array as $array__key => $array__value) {
	echo 'iterating over '.$array__key."\n";
    if ($array__value === 2) {
        unset($array['c']);
    }
}
// iterating over a
// iterating over b
// iterating over c (❗this is the problem!)
print_r($array); // ['a' => 1, 'b' => 2]

/* solution */
$array = ['a' => 1, 'b' => 2, 'c' => 3];
foreach ($array as $array__key => $array__value) {
	if (!array_key_exists($array__key, $array)) { continue; }
	echo 'iterating over '.$array__key."\n";
    if ($array__value === 2) {
        unset($array['c']);
    }
}
// iterating over a
// iterating over b
print_r($array); // ['a' => 1, 'b' => 2]