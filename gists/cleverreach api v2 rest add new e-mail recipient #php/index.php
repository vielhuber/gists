<?php
/* if you get the error: "Forbidden: account not veryfied yet" you must enter all details under "Mein Account" > "Einstellungen" > "Meine Daten" */  
  
$_POST['email'] = 'david@vielhuber.de';

if( !isset($_POST['email']) || $_POST['email'] == '' || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) )
{
    die('missing data');
}

$data = (object)[
    'api' => 'https://rest.cleverreach.com/v2/',
    'email' => $_POST['email'],
    'group_id' => 999999, // Empfängerlisten-ID
    'form_id' => 999999, // Formular-ID
    'client_id' => 999999, // Kundennummer
    'username' => 'XXX', // Benutzername
    'password' => 'XXX', // Passwort
    'token' => null,
    'source' => 'tld.com',
    'global_attributes' => null
];

/* if you want to add more attributes */
/*
$data->global_attributes = [
    'firstname' => 'Steve',
    'lastname' => 'Jobs',
    'gender' => 'male'
];
*/

/* login (get token) */
$response = curl_post($data->api.'login.json', [
    'client_id' => $data->client_id,
    'login' => $data->username,
    'password' => $data->password
]);

if( isset($response->error) ) { die('error'); }

$data->token = $response;

/* add recipient (unverified) */
$response = curl_post($data->api.'groups.json/'.$data->group_id.'/receivers', [
    'email' => $data->email,
    'registered' => time(),
    'activated' => 0,
    'source' => $data->source,
    'global_attributes' => $data->global_attributes
], $data->token);

if( isset($response->error) ) { die('duplicate'); }

/* send double opt in */
$response = curl_post($data->api.'forms.json/'.$data->form_id.'/send/activate', [
    'email' => $data->email,
    'doidata' => [
        'user_ip' => $_SERVER['REMOTE_ADDR'],
        'referer' => $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'],
        'user_agent' => $_SERVER['HTTP_USER_AGENT']
    ]
], $data->token);

if( isset($response->error) ) { die('error'); }

die('ok');

/* helper function */
function curl_post($url, $data = null, $token = null)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); 
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($curl, CURLOPT_POST, 1);
    if( !empty($data) )
    {
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        $header = [];
        $header[] = 'Content-Type: application/json';
        $header[] = 'Content-Length: '.strlen(json_encode($data));
        if( $token !== null )
        {
            $header[] = 'Authorization: Bearer ' . $token;
        }
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    }
    $result = curl_exec($curl);
    $headers = curl_getinfo($curl);
    curl_close($curl);
    $result = json_decode($result);
    return $result;
}