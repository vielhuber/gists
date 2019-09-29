<?php
/* initial setup */
$ch = curl_init();
curl_setopt($ch, CURLOPT_ENCODING, '');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); 
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_COOKIEJAR, $_SERVER['DOCUMENT_ROOT'].'/cookies.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, $_SERVER['DOCUMENT_ROOT'].'/cookies.txt'); 

/* first extract token */
curl_setopt($ch, CURLOPT_URL, 'https://tld.com/login');
curl_setopt($ch, CURLOPT_POST, false);
$answer = curl_exec($ch);
if (curl_error($ch)) { echo curl_error($ch); }
$pos1 = strpos($answer, '<input name="_token" type="hidden" value="')+strlen('<input name="_token" type="hidden" value="');
$pos2 = strpos($answer, '">', $pos1);
$token = substr($answer, $pos1, $pos2-$pos1);

/* then login */
curl_setopt($ch, CURLOPT_URL, 'https://tld.com/login');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, '_token='.$token.'&email=your%40email.de&password=123');
$answer = curl_exec($ch);
if (curl_error($ch)) { echo curl_error($ch); }

/* then download */
curl_setopt($ch, CURLOPT_URL, 'https://tld.com/download');
curl_setopt($ch, CURLOPT_POST, false);
$answer = curl_exec($ch);
if (curl_error($ch)) { echo curl_error($ch); }
file_put_contents('file.csv', $answer);
print_r($answer);