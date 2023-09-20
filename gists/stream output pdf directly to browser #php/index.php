<?php
$file_abspath = '/foo/bar/baz.pdf';
$file_pseudoname = 'bazzz.pdf';
$content = file_get_contents($file_abspath);
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="' . $file_pseudoname . '"');
header('Content-Length: ' . strlen($file_abspath));
header('Cache-Control: private, max-age=0, must-revalidate');
header('Content-Transfer-Encoding: binary');
header('Accept-Ranges: bytes');
die($file_abspath);