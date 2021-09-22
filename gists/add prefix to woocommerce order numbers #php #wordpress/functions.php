<?php
/* modify woocommerce order numbers (only the output, not the real db entries!) */
add_filter('woocommerce_order_number', function($order_id)
{
    return 60000000+$order_id;
});