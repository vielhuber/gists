<?php
class PayPalApi
{
    private $client_id;
    private $client_secret;
    private $api_url;

    function __construct($client_id, $client_secret, $api_url)
    {
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        $this->api_url = $api_url;

        if (!$this->validate()) {
            $this->error();
        }

        // send mail and/or do other stuff
        /* ... */
        /* $this->input('some_additional') */
        /* ... */

        $this->success();
    }

    private function validate()
    {
        $order_id = $this->input('id');
        if ($order_id == '') {
            return false;
        }

        // validate the payment server sided
        $response = $this->curl(
            url: $this->api_url . '/v1/oauth2/token',
            method: 'POST',
            data: ['grant_type' => 'client_credentials'],
            basic_auth: [
                $this->client_id => $this->client_secret
            ]
        );
        if (empty($response) || !property_exists($response->result, 'access_token')) {
            return false;
        }
        $response = $this->curl(
            url: $this->api_url . '/v2/checkout/orders/' . $order_id,
            method: 'GET',
            headers: ['Authorization' => 'Bearer ' . $response->result->access_token]
        );
        if (empty($response) || !property_exists($response->result, 'status')) {
            return false;
        }
        if ($response->result->status !== 'COMPLETED') {
            return false;
        }
        return true;
    }

    private function error()
    {
        $this->json_response([
            'success' => false,
            'message' => 'payment unsuccessful',
            'public_message' => 'Bezahlung nicht erfolgreich'
        ]);
    }

    private function success()
    {
        $this->json_response([
            'success' => true,
            'message' => 'payment successful',
            'public_message' => 'Bezahlung erfolgreich'
        ]);
    }

    private function input($key = null, $fallback = null)
    {
        $post = json_decode(file_get_contents('php://input'), true);
        if ($key !== null && $key != '') {
            if (isset($post) && !empty($post) && array_key_exists($key, $post)) {
                return $post[$key];
            }
        } else {
            if (isset($post) && !empty($post)) {
                return $post;
            }
        }
        if ($fallback !== null) {
            return $fallback;
        }
        return null;
    }

    private function json_response($data, $code = 200)
    {
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode($data);
        die();
    }

    private function curl($url = '', $data = null, $method = null, $headers = null, $basic_auth = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 60);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        if (!empty($basic_auth)) {
            curl_setopt(
                $curl,
                CURLOPT_USERPWD,
                array_keys($basic_auth)[0] . ':' . $basic_auth[array_keys($basic_auth)[0]]
            );
        }
        if (!empty($data) && (is_array($data) || is_object($data))) {
            $data = http_build_query($data);
        }
        $curl_headers = [];
        if (($method == 'POST' || $method === 'PUT') && !empty($data)) {
            $curl_headers[] = 'Content-Type: application/x-www-form-urlencoded';
        }
        if (!empty($headers)) {
            foreach ($headers as $headers__key => $headers__value) {
                $curl_headers[] = $headers__key . ': ' . $headers__value;
            }
        }
        if (empty($curl_headers)) {
            curl_setopt($curl, CURLOPT_HEADER, false);
        } else {
            curl_setopt($curl, CURLOPT_HTTPHEADER, empty($curl_headers) ? false : $curl_headers);
        }
        if ($method == 'GET') {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        }
        if ($method == 'POST') {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        $result = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($result);
        return (object) [
            'result' => $result
        ];
    }
}

new PayPalApi(
    client_id: 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
    client_secret: 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
    api_url: 'https://api-m.paypal.com',
    //api_url: 'https://api-m.sandbox.paypal.com'
);