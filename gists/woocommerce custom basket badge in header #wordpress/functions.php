/* basket badge in header */
function getNewBasketBadgeHtml()
{
    $html = '';
    $count = WC()->cart->cart_contents_count;
    $html .= '<a class="meta-nav__link--basket" href="' . WC()->cart->get_cart_url() . '">';
    if ($count > 0) {
        $html .= '<span>' . $count . '</span>';
    }
    $html .= '</a>';
    return $html;
}
add_action('custom_basket_badge', function () {
    if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
        echo getNewBasketBadgeHtml();
    }
});
add_filter('woocommerce_add_to_cart_fragments', function ($fragments) {
    /* update count on ajax calls */
    $fragments['a.meta-nav__link--basket'] = getNewBasketBadgeHtml();
    return $fragments;
});