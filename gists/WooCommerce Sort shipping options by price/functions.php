add_filter('woocommerce_package_rates', function($rates, $package) {
    uasort( $rates, function($a, $b) {
        return floatval($b->get_cost()) < floatval($a->get_cost());
    });
    return $rates;
}, 10, 2);