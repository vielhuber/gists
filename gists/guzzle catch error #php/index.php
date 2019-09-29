<?php
$http = new Client();
try
{
  $response = $http->request('post', 'https://tld.com/api/foo', [
    'form_params' => ['foo' => 'bar'],
    'headers' => [
      'Authorization' => 'Bearer foo'
    ]
  ]);
  return json_decode((string)$response->getBody());
}
catch(\Exception $e)
{
  // short message
  print_r($e->getMessage());
  // long message
  print_r(substr($e->getResponse()->getBody()->getContents(), 0, 1000));
  die();
}