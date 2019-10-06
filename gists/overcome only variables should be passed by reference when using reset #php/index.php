<?php
function foo()
{
	return (object)['foo'=>'bar'];
}
echo reset(foo()); // error

// solution 1
$foo = foo();
echo reset($foo); // bar

// solution 2
echo current((array)foo()); // bar