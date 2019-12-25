<?php
// index.php
require_once __DIR__ . '/vendor/autoload.php';

// simple
use Example\Example;
new Example();

// more detailled
/*
use Example\Example;
use Example\Test1;
use Example\Test2;
use Example\Test3;
new Example(new Test1(), new Test2(), new Test3());
*/
