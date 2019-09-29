<?php
require_once('https://raw.githubusercontent.com/drewm/mailchimp-api/master/src/MailChimp.php');
use \DrewM\MailChimp\MailChimp;
$MailChimp = new MailChimp('YOUR-API-KEY');
$list_id = 'YOUR-LIST-ID';
$result = $MailChimp->post("lists/$list_id/members", [
	'email_address' => 'david@vielhuber.de',
	'merge_fields' => ['FNAME'=>'David', 'LNAME'=>'Vielhuber'],
	'status' => 'subscribed', // use status "pending" to send out email
]);
print_r($result);