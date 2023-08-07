<?php
/*
composer require smhg/sepa-qr-data
composer require endroid/qr-code
*/
require_once(__DIR__ . '/vendor/autoload.php');
use SepaQr\Data;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelMedium;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Color\Color;

$filename = 'qr.png';

Builder::create()
    ->data(Data::create()
        ->setName('Max Mustermann')
        ->setIban('DE42424242424242424242')
        ->setAmount(1337.42)
    )
    ->errorCorrectionLevel(new ErrorCorrectionLevelMedium())
    ->size(300)
    ->margin(10)
    ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
    ->labelText('Jetzt mit QR-Code bezahlen')
    ->labelFont(new NotoSans(16))
    ->labelAlignment(new LabelAlignmentCenter())
    ->foregroundColor(new Color(89, 183, 130))
    ->backgroundColor(new Color(255, 255, 255))
    ->build()
    ->saveToFile($filename);

header('Content-Type: image/png');
header('Content-Length: ' . filesize($filename));
readfile($filename);