<?php
// composer require stripe/stripe-php
require_once(__DIR__ . '/vendor/autoload.php');

class Stripe {
    private $stripe = null;
    private $secret_key = 'sk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
  
    public function init() {
        $this->stripe = new \Stripe\StripeClient($this->secret_key);

        $response = $this->createSession([
            'items' => [
                [
                    'price' => 20.33,
                    'name' => 'Lorem Ipsum',
                    'amount' => 1
                ],
                [
                    'price' => 20.33,
                    'name' => 'Lorem Ipsum',
                    'amount' => 1
                ]
            ],
            /* you should check the payment status via webhooks */
            /* if you don't expect much payments and don't have the infrastructure */
            /* you also can directly check the status on the success page via getPaymentStatus() */
            'success_url' => $this->getCurrentUrl().'?success=1&session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => $this->getCurrentUrl().'?success=1&session_id={CHECKOUT_SESSION_ID}',
            'payment_methods' => ['sepa_debit', 'sofort', 'card'],
        ]);
        echo '<a href="'.$response->url.'" target="_blank">KAUFEN</a>';
    }

    private function createSession($data)
    {
        $line_items = [];
        foreach($data['items'] as $items__value) {
            $line_items[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount_decimal' => round($items__value['price'], 2) * 100,
                    'product_data' => [
                        'name' => $items__value['name']
                    ]
                ],
                'quantity' => $items__value['amount']
            ];
        }
        try {
            $response = $this->stripe->checkout->sessions->create(
                [
                    'success_url' => $data['success_url'],
                    'cancel_url' => $data['cancel_url'],
                    'payment_method_types' => $data['payment_methods'],
                    'line_items' => $line_items,
                    'mode' => 'payment'
                ],
                //['stripe_account' => $data['account_id']] // when using stripe connect, you can specify an account here
            );
        } catch (\Throwable $e) {
            print_r($e->getMessage());
            return null;
        }
        return $response;
    }

    private function getAccount($account_id)
    {
        try {
            $response = $this->stripe->accounts->retrieve($account_id);
        } catch (\Throwable $e) {
            $response = null;
        }
        return $response;
    }

    private function deleteAccount($account_id)
    {
        $response = $this->stripe->accounts->delete($account_id);
        return $response;
    }

    private function getLinkedAccounts()
    {
        $response = $this->stripe->accounts->all(['limit' => 999]);
        return $response->data;
    }

    private function createAccount()
    {
        $response = $this->stripe->accounts->create([
            'type' => 'standard'
        ]);
        return $response->id;
    }

    private function getPaymentStatus($session_id, $account_id)
    {
        try {
            $response = $this->stripe->checkout->sessions->retrieve($session_id, [], ['stripe_account' => $account_id]);
        } catch (\Throwable $e) {
            return null;
        }
        return $response->payment_status;
    }

    private function getCurrentUrl() {
        return 'http'.((isset($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')?'s':'').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    }

}

$s = new Stripe();
$s->init();