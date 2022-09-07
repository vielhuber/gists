<?php
$obj = new stdClass();
$obj->foo = 'bar';

// alternative (when working with namespaces)
$obj = new \stdClass();
$obj->foo = 'bar';

// alternative
$obj = [];
$obj['foo'] = 'bar';
$obj = (object)$obj;
print_r($obj);