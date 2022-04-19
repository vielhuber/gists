function check_iban_rechner($iban) {
    $response = __curl(
        'https://www.iban-rechner.de/iban_validieren.html',
        [
            'tx_valIBAN_pi1[iban]' => $iban,
            'tx_valIBAN_pi1[fi]' => 'fi',
            'no_cache' => '1'
        ],
        'POST',
        [],
        false,
        false,
        5, 
        null,
        null,
        true,
        null
    );
    file_put_contents('output.html',$response->result);
    return strpos($response->result, 'Diese IBAN ist formal korrekt') !== false && strpos($response->result, 'alt="-"') === false;
}
var_dump([
    check_iban_rechner('DE10202208008000000300'),
    check_iban_rechner('DE10202208008000000301')
]);