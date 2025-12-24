<?php
// tests/Feature/ExampleTest.php
namespace Tests\Feature;

use Tests\TestCase;
use GuzzleHttp\Client;

class ExampleTest extends TestCase
{
    public function test()
    {
        $http = new Client();
        try
        {
            $response = $http->request('GET', url('/').'/test', [
                'form_params' => $data,
                'headers' => [ 'Testing' => '1' ]
            ]);
            return json_decode((string)$response->getBody());
        }
        catch(\Exception $e)
        {
            return json_decode((string)$e->getResponse()->getBody()->getContents());
        }
    }
}