```sh
composer require tecnickcom/tcpdf
composer require setasign/fpdi
openssl req -x509 -nodes -days 365000 -newkey rsa:1024 -keyout mycert.crt -out mycert.crt
```

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');
use setasign\Fpdi\Tcpdf\Fpdi;
$pdf = new Fpdi();
$count = $pdf->setSourceFile('input.pdf');
for ($page = 1; $page <= $count; $page++) {
    $tplIdx = $pdf->importPage($page);
    $pdf->AddPage();
    $pdf->useTemplate($tplIdx, 0, 0, null, null, true);
    $pdf->setSignature('file://mycert.crt', 'file://mycert.crt', 'certdemo', '', 2, [
        'Name' => 'My company',
        'Location' => 'Office',
        'Reason' => 'Testing digital cert',
        'ContactInfo' => 'https://tld.com',
    ]);
}
$pdf->Output(__DIR__.'/output.pdf', 'F');
```