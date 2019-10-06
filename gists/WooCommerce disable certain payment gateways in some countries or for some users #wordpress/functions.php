<?php
add_filter('woocommerce_available_payment_gateways', function($available_gateways) {
	global $woocommerce;
	if (isset($available_gateways['sofortgateway']) && isset($woocommerce->customer) && $woocommerce->customer->get_country() == 'FR') {
		unset( $available_gateways['sofortgateway'] );
	}
	return $available_gateways;
});

add_filter('woocommerce_available_payment_gateways', function($available_gateways) {
    global $woocommerce;
    if (isset($available_gateways['bacs']) && (!is_user_logged_in() || (wp_get_current_user()->user_login != 'vlhbr'))) {
        unset($available_gateways['bacs']);
    }
    return $available_gateways;
});
