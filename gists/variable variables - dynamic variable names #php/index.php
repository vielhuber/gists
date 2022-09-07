<?php
// variant 1
$a = 'hello';
${$a} = 'world';
echo $a.' '.${$a}; // hello world

// variant 2
$a = 'hello';
$$a = 'world';
echo $a.' '.${$a}; // hello world

// variant 3
${'hello'} = 'world';
echo 'hello '.$hello; // hello world
