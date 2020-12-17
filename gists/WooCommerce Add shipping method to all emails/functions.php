add_action( 'woocommerce_email_after_order_table', function($order, $is_admin_email) {
    echo '<p><strong>Shipping Method:</strong> ' . $order->get_shipping_method() . '</p>';
}, 15, 2 );
