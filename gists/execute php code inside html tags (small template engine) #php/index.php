<?php
// save template
file_put_contents('template.html', '<!DOCTYPE html><html><body><div>current time: <?php echo date('Y-m-d'); ?></div></body></html>');

// include template and run php inside
ob_start();
include('template.html');
$final = ob_get_clean();