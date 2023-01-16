<?php
$message = "hello\n";


$example = function () {
    echo $message;
};
// Notice: Undefined variable: message
$example();


$example = function () use ($message) {
    echo $message;
};
// "hello"
$example();


// Inherited variable's value is from when the function is defined, not when called
$message = "world\n";
// "hello"
$example();


// Inherit by-reference
$message = "hello\n";
$example = function () use (&$message) {
    echo $message;
};
// "hello"
$example();
// The changed value in the parent scope is reflected inside the function call
$message = "world\n";
// "world"
$example();


// Closures can also accept regular arguments
$example = function ($arg) use ($message) {
    echo $arg . ' ' . $message;
};
// "hello world"
$example("hello");


// You get access to the outer scope, but can't change it's values
$message = "before change\n";
$example = function () use ($message) {
    $message = "after change\n";
    echo $message;
};
// "after change"
$example();
// "before change"
echo $message;