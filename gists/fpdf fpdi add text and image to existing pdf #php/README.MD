```sh
composer require setasign/fpdf  
composer require setasign/fpdi
```
  
```php
<?php
$input = 'input.pdf';
$output = 'output.pdf';
$str = 'This is a test!';
$image = [
    'path' => 'file.png',
    'x' => 0,
    'y' => 0,
    'w' => 50,
    'h' => 50
];
  
require_once(get_template_directory().'/vendor/autoload.php');
use setasign\Fpdi\Fpdi;
$pdf = new Fpdi();
$count = $pdf->setSourceFile($input);
for ($page = 1; $page <= $count; $page++) {
    $tplIdx = $pdf->importPage($page);
    $pdf->AddPage();
    $pdf->useTemplate($tplIdx, 0, 0, null, null, true);
  	// only on page 3
    if ($page === 3) {
        $pdf->SetFont('Helvetica');
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFontSize(9);
        $pdf->SetXY(10, 10);
        $pdf->Write(0, iconv('UTF-8', 'windows-1252', $str));
        $x = 0;
        $y = 0;
        $w = 10;
        $h = 10;
        $pdf->Image($image['path'], $image['x'], $image['y'], $image['w'], $image['h']);
    }
}
$pdf->Output('F', $output);
```