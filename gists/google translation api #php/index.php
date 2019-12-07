<?php
$text = 'Test new message only.';
$apiKey = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
$url = 'https://www.googleapis.com/language/translate/v2?key=' . $apiKey . '&q=' . rawurlencode($text) . '&source=en&target=fr';
$handle = curl_init($url);
curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($handle);
$responseDecoded = json_decode($response, true);
curl_close($handle);
print_r($responseDecoded['data']['translations'][0]['translatedText']);
die();