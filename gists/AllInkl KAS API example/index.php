<?php
$kas_user = 'wxxxxxxx';
$kas_pass = 'xxx';

try
{
    $soap = new SoapClient('https://kasapi.kasserver.com/soap/wsdl/KasAuth.wsdl');
    $CredentialToken = $soap->KasAuth(json_encode([
        'KasUser' => $kas_user,
        'KasAuthType' => 'sha1',
        'KasPassword' => sha1($kas_pass),
        'SessionLifeTime' => 600,
        'SessionUpdateLifeTime' => 'Y'
    ]));
}
catch (SoapFault $fault)
{
    throw new \Exception('Fehlernummer: '.$fault->faultcode.', Fehlermeldung: '.$fault->faultstring.', Verursacher: '.$fault->faultactor.', Details: '.$fault->detail.'');
}

try
{
    $soap = new SoapClient('https://kasapi.kasserver.com/soap/wsdl/KasApi.wsdl');
    $req = $soap->KasApi(json_encode([
        'KasUser' => $kas_user,
        'KasAuthType' => 'session',
        'KasAuthData' => $CredentialToken,
        'KasRequestType' => 'get_mailaccounts',
        'KasRequestParams' => []
    ]));
    echo '<pre>';
    print_r($req);
    echo '</pre>';
}
catch (SoapFault $fault)
{
    throw new \Exception('Fehlernummer: '.$fault->faultcode.', Fehlermeldung: '.$fault->faultstring.', Verursacher: '.$fault->faultactor.', Details: '.$fault->detail.'');
}