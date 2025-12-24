<?php
use GuzzleHttp\Client;
use vielhuber\comparehelper\comparehelper;

class ApiTest extends \PHPUnit\Framework\TestCase
{
    protected function setUp()
    {
        // do your migrations/seeds
    }

    protected function tearDown()
    {
    }

    function testLogin()
    {
        $this->assertTrue(
            CompareHelper::compare(
                $this->request('POST', '/testroute', ['foo' => 'bar'], ['bar' => 'baz']),
                [
                    'response' => [
                        'success' => true,
                        'message' => 'auth successful',
                        'public_message' => '#STR#',
                        'data' => '*'
                    ],
                    'code' => 200
                ]
            )
        );
    }

    function testLoginFailure()
    {
        $this->assertTrue(
            CompareHelper::compare(
                $this->request('POST', '/testroute', ['FALSE' => 'INPUTS'], ['bar' => 'baz']),),
                [
                    'response' => [
                        'success' => false,
                        'message' => 'auth not successful',
                        'public_message' => '#STR#'
                    ],
                    'code' => 401
                ]
            )
        );
    }

    private function request(
        $method = 'GET',
        $route = '/',
        $data = [],
        $headers = []
    ) {
        $client = new Client([
            'base_uri' => 'http://simpleauth.local'
        ]);
        try {
            $response = $client->request($method, $route, [
                'form_params' => $data,
                'headers' => $headers,
                'http_errors' => false
            ]);
            return [
                'code' => $response->getStatusCode(),
                'response' => json_decode(
                    json_encode(json_decode((string) $response->getBody())),
                    true
                )
            ];
        } catch (\Exception $e) {
            return [
                'response' => $e->getMessage()
            ];
        }
    }
}
