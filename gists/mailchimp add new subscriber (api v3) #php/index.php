<?php
require_once(__DIR__ . '/vendor/autoload.php');
// OR
//require_once('https://raw.githubusercontent.com/drewm/mailchimp-api/master/src/MailChimp.php');

use \DrewM\MailChimp\MailChimp;

$MailChimp = new MailChimp('YOUR-API-KEY');
$list_id = 'YOUR-LIST-ID';
$email = 'david@vielhuber.de';
$fields = ['FNAME'=>'David', 'LNAME'=>'Vielhuber'];

$result = $MailChimp->post('lists/'.$list_id.'/members', [
	'email_address' => $email,
	'merge_fields' => $fields,
	'status' => 'subscribed', // use status "pending" to send out email
]);
print_r($result);
if ($MailChimp->success()) {
  echo 'OK';
} else {
  if ($result['title'] == 'Member Exists') {
    $subscriberHash = $MailChimp->subscriberHash($email);
    $result = $MailChimp->patch('lists/' . $list_id . '/members/' . $subscriberHash, [
      'merge_fields' => $fields,
      'status' => 'subscribed'
    ]);
    if ($MailChimp->success()) {
      echo 'OK';
    } else {
      echo $result['detail'];
    }
  }
}