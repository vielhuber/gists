# links

- overview: https://www.gruenderkueche.de/fachartikel/xrechnung-erstellen-so-funktioniert-es-diese-tools-gibt-es
- generator: https://xrechnungsgenerator.nortal.com
- validator: https://erechnungsvalidator.service-bw.de, https://validator.invoice-portal.de
- php-library: https://github.com/horstoeko/zugferd
- php-visualizer: https://github.com/horstoeko/zugferdvisualizer

# installation

```sh
composer require horstoeko/zugferd:^1
composer require horstoeko/zugferdvisualizer:^1
```

# example

```php
appendZugferdXmlToPdf(
    $_SERVER['DOCUMENT_ROOT'] . '/path/to/existing.pdf',

    '471102',
    '2018-03-05',

    [
      // name, amount, net price, tax
      ['Trennblätter A4', 20, 9.9, 19],
      ['Joghurt Banane', 50, 5.5, 7]
    ],

    'Kunden AG Mitte',
    'Kundenstraße 15',
    '69876',
    'Frankfurt',
    'DE',
    'info@buyer.com',

    'Lieferant GmbH',
    'Lieferantenstraße 20',
    '80333',
    'München',
    'DE',
    'info@seller.com',
  	'0123456789'

    'DE123456789',

    'DE02120300000000202051',
    '04011000-12345ABCXYZ-86',
    '549910',
    'Zahlbar innerhalb 30 Tagen netto bis 04.04.2018, 3% Skonto innerhalb 10 Tagen bis 15.03.2018'
);

function appendZugferdXmlToPdf(
    $filename_output,

    $invoice_nr,
    $invoice_date,

    $articles,

    $buyer_company_name,
    $buyer_address_street_nr,
    $buyer_address_zip,
    $buyer_address_location,
    $buyer_address_country,
    $buyer_email_address,

    $seller_company_name,
    $seller_address_street_nr,
    $seller_address_zip,
    $seller_address_location,
    $seller_address_country,
    $seller_email_address,
    $seller_phone_number,

    $vat_id,
    $payment_iban,
    $payment_reference_nr,
    $payment_mandate_id,
    $payment_term
) {
    $document = \horstoeko\zugferd\ZugferdDocumentBuilder::CreateNew(
        \horstoeko\zugferd\ZugferdProfiles::PROFILE_XRECHNUNG_3
    );

    $document->setDocumentInformation(
        $invoice_nr,
        '380',
        \DateTime::createFromFormat('Ymd', date('Ymd', strtotime($invoice_date))),
        'EUR'
    );

    $document->addDocumentNote('Rechnung vom ' . date('d.m.Y', strtotime($invoice_date)));

    $document->setDocumentSupplyChainEvent(\DateTime::createFromFormat('Ymd', date('Ymd', strtotime($invoice_date))));

    $document->setDocumentSeller($seller_company_name, $payment_mandate_id);

    $document->addDocumentSellerTaxRegistration('VA', $vat_id);

    $document->setDocumentSellerAddress(
        $seller_address_street_nr,
        '',
        '',
        $seller_address_zip,
        $seller_address_location,
        $seller_address_country
    );

    $document->setDocumentSellerCommunication('EM', $seller_email_address);
  
    $document->setDocumentSellerContact($seller_company_name, null, $seller_phone_number, null, $seller_email_address);

    $document->setDocumentBuyer($buyer_company_name);

    $document->setDocumentBuyerAddress(
        $buyer_address_street_nr,
        '',
        '',
        $buyer_address_zip,
        $buyer_address_location,
        $buyer_address_country
    );

    $document->setDocumentBuyerCommunication('EM', $buyer_email_address);
  
  	$document->setDocumentBuyerContact($buyer_company_name, null, null, null, $buyer_email_address);

    $document->addDocumentPaymentMeanToDirectDebit($payment_iban, $invoice_nr);

    $document->setDocumentBuyerReference($payment_reference_nr);

    $taxes = [];
    foreach ($articles as $articles__value) {
        if (!array_key_exists($articles__value[3], $taxes)) {
            $taxes[$articles__value[3]] = ['sum' => 0, 'tax' => 0];
        }
        $taxes[$articles__value[3]]['sum'] += $articles__value[1] * $articles__value[2];
        $taxes[$articles__value[3]]['tax'] += round(
            $articles__value[1] * $articles__value[2] * ($articles__value[3] / 100),
            2
        );
    }
    ksort($taxes);

    foreach ($taxes as $taxes__key => $taxes__value) {
        $document->addDocumentTax(
            'S',
            'VAT',
            (float) $taxes__value['sum'],
            (float) $taxes__value['tax'],
            (float) $taxes__key
        );
    }

    $sum_net = 0;
    $sum_tax = 0;
    $sum_gross = 0;
    foreach ($articles as $articles__value) {
        $sum_net += $articles__value[1] * $articles__value[2];
        $sum_tax += round($articles__value[1] * $articles__value[2] * ($articles__value[3] / 100), 2);
        $sum_gross +=
            $articles__value[1] * $articles__value[2] +
            round($articles__value[1] * $articles__value[2] * ($articles__value[3] / 100), 2);
    }
    $document->setDocumentSummation($sum_gross, $sum_gross, $sum_net, 0.0, 0.0, $sum_net, $sum_tax, null, 0.0);

    $document->addDocumentPaymentTerm($payment_term, null, $payment_mandate_id);

    foreach ($articles as $articles__key => $articles__value) {
        $document
            ->addNewPosition($articles__key + 1)
            ->setDocumentPositionProductDetails($articles__value[0])
            ->setDocumentPositionNetPrice($articles__value[2])
            ->setDocumentPositionQuantity($articles__value[1], 'H87') // H87 = Stück
            ->addDocumentPositionTax('S', 'VAT', $articles__value[3])
            ->setDocumentPositionLineSummation($articles__value[1] * $articles__value[2]);
    }

    $pdfBuilder = new \horstoeko\zugferd\ZugferdDocumentPdfBuilder($document, $filename_output);
    $pdfBuilder->generateDocument()->saveDocument($filename_output);

    // debug
  	if(1===0) {
      $document->writeFile($filename_output . '.xml');
      $document = \horstoeko\zugferd\ZugferdDocumentReader::readAndGuessFromFile($filename_output . '.xml');
      $visualizer = new \horstoeko\zugferdvisualizer\ZugferdVisualizer($document);
      $visualizer->setDefaultTemplate();
      $visualizer->setPdfFontDefault('courier');
      $visualizer->renderPdfFile($filename_output . '.test.pdf');
    }
}
```