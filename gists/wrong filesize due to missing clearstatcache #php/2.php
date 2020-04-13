<?php
$handle = fopen('test.txt', 'w');
fwrite($handle, 'foo');
fclose($handle);
clearstatcache();

$handle = fopen('test.txt', 'r');
$contents = fread($handle, filesize('test.txt')); 
fclose($handle);
print_r($contents); // foo

$handle = fopen('test.txt', 'w');
fwrite($handle, 'foobar');
fclose($handle);
clearstatcache();

$handle = fopen('test.txt', 'r');
$contents = fread($handle, filesize('test.txt')); 
fclose($handle);
print_r($contents); // foobar