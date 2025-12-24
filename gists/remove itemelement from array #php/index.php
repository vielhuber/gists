<?php
$arr = ['foo','bar','baz'];
unset($arr[1]);
// reset keys
$arr = array_values($arr);
print_r($arr);
// [0 => foo, 1 => baz]