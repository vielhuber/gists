<?php
$file_url = 'http://www.myremoteserver.com/file.exe';
header('Content-Type: application/octet-stream');
header('Content-Transfer-Encoding: Binary'); 
header('Content-disposition: attachment; filename="'.basename($file_url).'"'); 
readfile($file_url);
die();