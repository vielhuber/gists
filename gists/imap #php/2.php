<?php
// composer require webklex/php-imap

require_once __DIR__ . '/vendor/autoload.php';

use Webklex\PHPIMAP\ClientManager;

$settings = [
    'client_id' => '***',
    'client_secret' => '***',
    'tenant_id' => '***',
    'email' => '***'
];

$ch = curl_init();
try {
    curl_setopt($ch, CURLOPT_URL, 'https://login.microsoftonline.com/' . $settings['tenant_id'] . '/oauth2/v2.0/token');
    curl_setopt(
        $ch,
        CURLOPT_POSTFIELDS,
        http_build_query([
            'client_id' => $settings['client_id'],
            'client_secret' => $settings['client_secret'],
            'scope' => 'https://outlook.office365.com/.default',
            'grant_type' => 'client_credentials'
        ])
    );
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $curl_result = curl_exec($ch);
    if (empty($curl_result)) {
        throw new Exception('Missing results.');
    }
    $curl_result = json_decode($curl_result);
    if (empty($curl_result)) {
        throw new Exception('Error decoding json result.');
    }
    if (!isset($curl_result->access_token)) {
        throw new Exception('Missing access token from result.');
    }
    $access_token = $curl_result->access_token;
} finally {
    curl_close($ch);
}

$mails = [];
$cm = new ClientManager();
$client = $cm->make([
    'host' => 'outlook.office365.com',
    'port' => 993,
    'encryption' => 'tls',
    'validate_cert' => true,
    'username' => $settings['email'],
    'password' => $access_token,
    'protocol' => 'imap',
    'authentication' => 'oauth'
]);
$client->connect();
$folders = $client->getFolders(); // use "false" here to speed up things by getting a non hierarchical structure
foreach ($folders as $folder) {
    if ($folder->full_name !== 'INBOX') {
        continue;
    }
    $messages = $folder->messages()->all()->get();
  
  	// alternative with paging (when lots of mails should be loaded)
    //$messages = $folder->messages()->all()->paginate($per_page = 100, $page = null, $page_name = 'imap_page');  
  
    foreach ($messages as $messages__value) {
        $mail = [];
        $mail['id'] = $messages__value->getMessageId()[0];
        $mail['from_name'] = $messages__value->getFrom()[0]->personal;
        $mail['from_email'] = $messages__value->getFrom()[0]->mail;
        $mail['to'] = $messages__value->getTo()[0]->mail;
        $mail['date'] = $messages__value
            ->getDate()
            ->toDate()
            ->format('Y-m-d H:i:s');
      
        $subject = @$messages__value->getSubject()[0];
        $subject = trim($subject);
        $subject = preg_replace("/\r\n|\r|\n/", '', trim(@$messages__value->getSubject()[0]));
        if (mb_detect_encoding($subject, 'UTF-8, ISO-8859-1') !== 'UTF-8') { $subject = utf8_encode($subject); }
        $mail['subject'] = $subject;
      
        $mail['eml'] =
            json_decode(json_encode($messages__value->getHeader()), true)['raw'] . $messages__value->getRawBody();
        $mail['attachments'] = $messages__value->getAttachments()->count();
        $mail['content_html'] = $messages__value->getHTMLBody();
        $mail['content_plain'] = $messages__value->getTextBody();

        // methods
        //$messages__value->setFlag('Seen');
        //$messages__value->unsetFlag('Seen');
        //$messages__value->move('INBOX/ARCHIV');

        $mails[] = $mail;
    }
}
print_r($mails);
