<?php
$foo = (object)['foo'=>'bar'];
$bar = $foo;
$foo->foo = 'baz';
print_r([$foo,$bar]); // Array ([0] => stdClass Object ([foo] => baz) [1] => stdClass Object ([foo] => baz))

$foo = (object)['foo'=>'bar'];
$bar = clone $foo;
$foo->foo = 'baz';
print_r([$foo,$bar]); // Array ([0] => stdClass Object ([foo] => baz) [1] => stdClass Object ([foo] => bar))

$foo = ['foo'=>'bar'];
$bar = $foo;
$foo['foo'] = 'baz';
print_r([$foo,$bar]); // Array ([0] => Array ([foo] => baz) [1] => Array ([foo] => bar))