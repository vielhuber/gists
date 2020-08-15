```sh
composer require setasign/fpdf  
composer require setasign/fpdi
```
  
```php
<?php
require_once(get_template_directory().'/vendor/autoload.php');
use setasign\Fpdi\Fpdi;
$pdf = new Fpdi();
$pdf->AddPage();
$pdf->setSourceFile('input.pdf');
$pdf->useTemplate($pdf->importPage(1), 0, 0, null, null, true);
$pdf->SetFont('Helvetica');
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFontSize(9);
$pdf->SetXY(10, 10);
$pdf->Write(0, iconv('UTF-8', 'windows-1252', $str));
$pdf->Output('I', 'output.pdf');
```