<?php
// composer
require_once(__DIR__ . '/vendor/autoload.php');

use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

// settings
define('ENCRYPTION_FOLDER', __DIR__ . '/encryption');
$settings = (object) [
    'url' => 'https://rest.cleverreach.com',
    'version' => 3,
    'oauth_id' => 'XXXXXXXXXX',
    'oauth_secret' => 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX',
    'input_file' => 'input.xlsx',
    'smtp' => (object) [
        'host' => 'xxxxxxxxxxxx',
        'port' => 587,
        'username' => 'xxxxxxxxxxxx',
        'password' => 'xxxxxxxxxxxx',
        'email' => 'xxxxxxxxxxxx',
        'name' => 'David Vielhuber'
    ],
	'email' => (object) [
        'DE' => (object)[
            'subject' => 'Lorem ipsum',
            'body' => 'Sehr geehrte{SALUTATION_R} {SALUTATION} {FIRST_NAME} {LAST_NAME},
        
Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.

Klicken Sie auf folgenden Link, um den Newsletter zu abonnieren:
{LINK}

Herzliche Grüße'
        ],
        'EN' => (object)[
            'subject' => 'Lorem ipsum',
            'body' => 'Dear {FIRST_NAME} {LAST_NAME},
        
Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.

Click on the following link to subscribe to the newsletter:
{LINK}

Best Regards'
        ]
    ]
];

// get cleverreach access token
$response = __curl(
    $settings->url . '/oauth/token.php',
    ['grant_type' => 'client_credentials'],
    'POST',
    ['Authorization' => 'Basic ' . base64_encode($settings->oauth_id . ':' . $settings->oauth_secret)]
);
if ($response->status !== 200) {
    die('error');
}
$settings->access_token = $response->result->access_token;

if (@$_GET['init'] == 1) {
    // read excel file
    $emails = [];
    $reader = ReaderEntityFactory::createXLSXReader();
    $reader->open($settings->input_file);
    foreach ($reader->getSheetIterator() as $sheet__key => $sheet__value) {
        if( $sheet__value->getName() !== 'LIVE' )
        {
            continue;
        }
        foreach ($sheet__value->getRowIterator() as $row__key => $row__value) {
            $cells = $row__value->toArray();
            if ($row__key <= 1 || @$cells[0] == '') {
                continue;
            }
            $emails[] = (object) [
                'gender' => $cells[0],
                'first_name' => $cells[1],
                'last_name' => $cells[2],
                'email' => $cells[3],
                'group_id' => $cells[4],
                'language' => $cells[5],
            ];
        }
    }

    // insert disabled users
    foreach ($emails as $emails__key => $emails__value) {
        if(__nx(@$_GET['cur']) && $emails__key > 0)
        {
            continue;
        }
        if(__x(@$_GET['cur']) && $emails__key != $_GET['cur'])
        {
            continue;
        }
        $response = __curl(
            $settings->url . '/v' . $settings->version . '/groups.json/' . $emails__value->group_id . '/receivers',
            [
                'email' => $emails__value->email,
                'registered' => time(),
                'deactivated' => 1,
                'global_attributes' => [
                    'first_name' => $emails__value->first_name,
                    'last_name' => $emails__value->last_name,
                    'gender' => $emails__value->gender
                ]
            ],
            'POST',
            ['Authorization' => 'Bearer ' . $settings->access_token]
        );
        if ($response->status != 200 || __nx($response->result->id)) {
            logMessage('error adding ' . $emails__value->email.': '.@$response->result->error->message);
            redirectToNext($emails, $emails__key);
        }
        else
        {
            logMessage('successfully added ' . $emails__value->email);
            $emails[$emails__key]->receiver_id = $response->result->id;
        }
    }

    // send out first email
    foreach ($emails as $emails__key=>$emails__value) {
        if(__nx(@$_GET['cur']) && $emails__key > 0)
        {
            continue;
        }
        if(__x(@$_GET['cur']) && $emails__key != $_GET['cur'])
        {
            continue;
        }
        $token = __encrypt_poor(serialize((object) ['group_id' => $emails__value->group_id, 'receiver_id' => $emails__value->receiver_id, 'language' => $emails__value->language]));
        $body = $settings->email->{$emails__value->language}->body;
        $body = str_replace('{SALUTATION_R}', ($emails__value->gender === 'M') ? 'r' : '', $body);
        $body = str_replace('{SALUTATION}', ($emails__value->gender === 'M') ? 'Herr' : 'Frau', $body);
        $body = str_replace('{FIRST_NAME}', $emails__value->first_name, $body);
        $body = str_replace('{LAST_NAME}', $emails__value->last_name, $body);
        $body = str_replace('{LINK}', __urlWithoutArgs() . '/?token=' . $token . '', $body);
        $transport = (new Swift_SmtpTransport($settings->smtp->host, $settings->smtp->port))
            ->setUsername($settings->smtp->username)
            ->setPassword($settings->smtp->password);
        $mailer = new Swift_Mailer($transport);
        $message = (new Swift_Message($settings->email->{$emails__value->language}->subject))
            ->setFrom([$settings->smtp->email => $settings->smtp->name])
            ->setTo([$emails__value->email => $emails__value->first_name . ' ' . $emails__value->last_name])
            ->setBody($body);
        $result = $mailer->send($message);
        if( $result == '1' )
        {
            logMessage('successfully sent out ' . $emails__value->email);
        }
        else
        {
            logMessage('error sending out ' . $emails__value->email);
        }
        redirectToNext($emails, $emails__key);
    }
}

if (@$_GET['token'] != '') {
    $data = __decrypt_poor($_GET['token'], true);

    if (__nx($data) || !__is_serialized($data)) {
        __redirect_to(__baseurl());
    }
    
    $data = unserialize($data);

    // add verified recipient
    $response = __curl(
        $settings->url . '/v' . $settings->version . '/groups.json/' . $data->group_id . '/receivers/' . $data->receiver_id . '/activate',
        null,
        'PUT',
        ['Authorization' => 'Bearer ' . $settings->access_token]
    );
    __redirect_to(__baseurl());
}

function redirectToNext($emails, $emails__key)
{
    if( __x(@$emails[$emails__key+1]) && __x(@$emails[$emails__key+1]->email) )
    {
        __redirect_to(__urlWithoutArgs().'/?init=1&cur='.($emails__key+1), 20, 'html'); // throttle (max. 250 emails / hour)
        die();
    }
    die('finished');
}

function logMessage($message)
{
    if( !file_exists('log.txt') )
    {
        touch('log.txt');
    }
    file_put_contents('log.txt', date('Y-m-d H:i:s').' '.$message.PHP_EOL, FILE_APPEND);
}