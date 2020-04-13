<?php
$handle = fopen('test.txt', 'w');
fwrite($handle, 'foo');
fclose($handle);

$handle = fopen('test.txt', 'r');
$contents = fread($handle, filesize('test.txt')); 
fclose($handle);
print_r($contents); // foo

$handle = fopen('test.txt', 'w');
fwrite($handle, 'foobar');
fclose($handle);

$handle = fopen('test.txt', 'r');
$contents = fread($handle, filesize('test.txt')); 
fclose($handle);
print_r($contents); // foo