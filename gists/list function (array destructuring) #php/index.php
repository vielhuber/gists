<?php
// main syntax
list($a, $b, $c) = ['foo', 'bar', 'baz'];
[$a, $b, $c] = ['foo', 'bar', 'baz'];

// basics
list($a,$b, $c) = ['foo', 'bar', 'baz'];
echo $a; // foo
echo $b; // bar
echo $c; // baz

list($a, $b) = ['foo', 'bar', 'baz'];
echo $a; // foo
echo $b; // bar

list($a, $b, $c) = ['foo', 'bar'];
echo $a; // foo
echo $b; // bar
echo $c; // undefined offset

list($a, , $b) = ['foo', 'bar', 'baz'];
echo $a; // foo
echo $b; // baz

$person = [
  'name' => 'David',
  'job' => 'Developer',
];
list('job' => $job) = $person;
echo $job; // "Developer"

// example: swap values
[$a, $b] = [$b, $a];

// example: multiple return values
function fun(int $i): array {
    return [$i+5, $i-5];
}
[$x, $y] = fun(10);
echo $x; // 15
echo $y; // 5