<?php
$filename = 'test.csv';
$data = file_get_contents($filename);
$data = iconv('UTF-8', 'windows-1252', $data);
file_put_contents($filename, $data);