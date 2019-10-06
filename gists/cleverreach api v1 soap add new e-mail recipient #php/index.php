<?php
$data_api = [
	"key" => "XXX",
	"url" => "http://api.cleverreach.com/soap/interface_v5.1.php?wsdl",
	"list" => "XXX", // id of list
	"form" => "XXX" // id of form
];
$data_user = [
	"email" => "david@vielhuber.de",
	"source" => "This page",
	"vorname" => "David",
	"name" => "Vielhuber",
	"unternehmen" => "vielhuber.de"
];
$api = new SoapClient($data_api["url"]);

// add recipient
$user = [
    "email" => $data_user["email"],
    "registered" => time(),
    "activated" => time(),
    "source" => $data_user["source"],
    "attributes" => []
];
foreach($data_user as $data_user__key=>$data_user__value) {
	if( in_array($data_user__key, ["email", "source"]) ) { continue; }
	$user["attributes"][] = ["key" => $data_user__key, "value" => $data_user__value];
}
echo '<pre>';print_r($user);echo'</pre>';
$result = $api->receiverAdd( $data_api["key"], $data_api["list"], $user );
if( $result->status == "SUCCESS" ) { var_dump($result); }
else { var_dump($result->message); die(); }

// immediately set inactive
$result = $api->receiverSetInactive( $data_api["key"], $data_api["list"], $data_user["email"] );
if($result->status=="SUCCESS") { var_dump($result); }
else { var_dump($result->message); die(); }
  
// send out double-opt-in mail
$doidata = [
	"user_ip" => $_SERVER['REMOTE_ADDR'],
	"user_agent" => $_SERVER['HTTP_USER_AGENT'],
	"referer" => $_SERVER['REQUEST_URI'],
	"postdata" => [],
	"info" => "Timestamp: ".date('Y-m-d H:i:s',strtotime('now'))
]; 
foreach($data_user as $data_user__key=>$data_user__value) {
	if( in_array($data_user__key, ["email", "source"]) ) { continue; }
	$doidata["postdata"][] = $data_user__key.":".$data_user__value;
}
$doidata["postdata"] = implode(",", $doidata["postdata"]);
echo '<pre>';print_r($doidata);echo'</pre>';

$result = $api->formsSendActivationMail( $data_api["key"], $data_api["form"], $data_user["email"], $doidata );
if($result->status=="SUCCESS") { var_dump($result); }
else { var_dump($result->message); die(); }