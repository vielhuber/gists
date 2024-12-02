<?php
/*
composer require smhg/sepa-qr-data
composer require endroid/qr-code
*/
require_once(__DIR__ . '/vendor/autoload.php');

use SepaQr\Data;

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\SvgWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Label\Font\OpenSans;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\LabelAlignment;

$builder = new Builder(
    writer: new PngWriter(),
    data: Data::create()->setName('Max Mustermann')->setIban('DE42424242424242424242')->setAmount(1337.42),
    size: 300,
    margin: 10,
    errorCorrectionLevel: ErrorCorrectionLevel::Medium,
    roundBlockSizeMode: RoundBlockSizeMode::None,
    labelText: 'Jetzt mit QR-Code bezahlen',
    labelFont: new OpenSans(16),
    labelAlignment: LabelAlignment::Center,
    foregroundColor: new Color(89, 183, 130),
    backgroundColor: new Color(255, 255, 255)

    //writer: new SvgWriter(),
    //logoPath: __DIR__ . '/../_assets/logo.svg',
    //logoResizeToWidth: 50,
    //logoResizeToHeight: 50,
    //logoPunchoutBackground: true,
);
$result = $builder->build();

// output
echo '<img src="'.$result->getDataUri().'" alt="" />';

// save
$result->build()->saveToFile('qr.png');
header('Content-Type: image/png');
header('Content-Length: ' . filesize($filename));
readfile($filename);