<?php
$filename = 'file.exe';
header('Content-Type: application/octet-stream');
header('Content-Transfer-Encoding: Binary'); 
header('Content-disposition: attachment; filename="'.basename($filename).'"'); 
readfile($filename);
die();