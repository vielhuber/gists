<?php
$arr = [1, '2', true];
$arr = array_map(function($value) { return (string)$value; }, $arr); // ['1','2','1'];