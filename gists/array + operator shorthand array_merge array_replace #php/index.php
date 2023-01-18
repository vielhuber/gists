<?php
$array1 = ['one', 'two', 'foo' => 'bar'];
$array2 = ['three', 'four', 'five', 'foo' => 'baz']; 

print_r($array1 + $array2);

Array
(
    [0] => one   // preserved from $array1 (left-hand array)
    [1] => two   // preserved from $array1 (left-hand array)
    [foo] => bar // preserved from $array1 (left-hand array)
    [2] => five  // added from $array2 (right-hand array)
)

// be careful: array_merge is different than the + operator when using duplicated / numeric keys
print_r(array_merge($array1, $array2));

Array
(
    [0] => one   // preserved from $array1
    [1] => two   // preserved from $array1
    [foo] => baz // overwritten from $array2
    [2] => three // appended from $array2
    [3] => four  // appended from $array2
    [4] => five  // appended from $array2
)
  
// same as "+", but in other order
print_r(array_replace($array2, $array1));

Array
(
    [0] => one   // preserved from $array1 (left-hand array)
    [1] => two   // preserved from $array1 (left-hand array)
    [2] => five  // added from $array2 (right-hand array)
    [foo] => bar // preserved from $array1 (left-hand array)
)