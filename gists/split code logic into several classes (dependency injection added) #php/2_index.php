<?php
// index.php
require_once __DIR__ . '/vendor/autoload.php';

// simple
use Example\App;
new App();

// explicit
/*
use Example\App;
use Example\Test1;
use Example\Test2;
use Example\Test3;
use Example\Test4;
new App(new Test1(), new Test2(), new Test3(), new Test4());
*/
