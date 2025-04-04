<?php
final class Test {
    public function init() {
        register_rest_route('v1', '/...', [
            /* ... */
            'callback' => function () {
                // basic way
                return new \WP_REST_Response([], 200);
                // usage in inner functions
                $this->fun1();
                $this->fun2();
            }
        ]);
    }
    private function fun1() {
        // check for error etc.
        if(1===0) {
            // this does not work (since we don't have "return" in front of "$this->fun1();")
            return new \WP_REST_Response($data, $status_code);
            // this immedialy stops the script and sends the response
            wp_send_json(new \WP_REST_Response([], 200));
        }
    }
    private function fun2() {
        echo 'This runs only if fun1 didnt return a response';
    }
}
$t = new Test();
$t->init();
