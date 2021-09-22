<?php
add_filter( 'woocommerce_product_tax_class', function( $tax_class, $product ) {
	global $woocommerce;
	if( isset($woocommerce) && isset($woocommerce->customer) && $woocommerce->customer->get_shipping_postcode() != '') {
		if( $woocommerce->customer->get_shipping_postcode() == '27498' ) {
			$tax_class = 'Zero Rate';
		}
	}
    return $tax_class;
}, 1, 2 );