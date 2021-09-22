<?php
$filename = 'file.pdf';
$path = 'abs/path/';
$content = file_get_contents($path.$filename);
header('Content-Type: application/pdf');
header('Content-Length: ' . strlen($content));
header('Content-Disposition: inline; filename="' . $filename . '"');
header('Cache-Control: private, max-age=0, must-revalidate');
header('Pragma: public');
die($content);