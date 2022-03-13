<?php
require 'vendor/autoload.php';
use Dompdf\Dompdf;
$options = new \Dompdf\Options();
$options->setDpi(72);
$options->setIsFontSubsettingEnabled(true);
$options->setIsHtml5ParserEnabled(true);
$options->setIsJavascriptEnabled(true);
$options->setIsPhpEnabled(true);
$options->setIsRemoteEnabled(true);
$options->set('chroot', './');
$dompdf = new Dompdf($options);
$html = file_get_contents('template1.html');
$dompdf->loadHtml($html);
$dompdf->setPaper('A4','portrait');
$dompdf->render();
/* direct output */
$dompdf->stream('output.pdf', ['Attachment' => false]);
/* download as */
$dompdf->stream('output.pdf');
/* save to file */
$output = $dompdf->output(); file_put_contents("output.pdf", $output);