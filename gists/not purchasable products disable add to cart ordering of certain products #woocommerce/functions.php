add_filter('woocommerce_is_purchasable', function ($is_purchasable, $product) {
    return (productIsInSpecialCategory($product) ? false : $is_purchasable);
}, 10, 2);
add_filter('woocommerce_variation_is_purchasable', function ($is_purchasable, $product) {
    return (productIsInSpecialCategory($product->get_parent_id()) ? false : $is_purchasable);
}, 10, 2);
add_action('woocommerce_simple_add_to_cart', 'showNotPurchasableNotice');
add_action('woocommerce_variable_add_to_cart', 'showNotPurchasableNotice');
function showNotPurchasableNotice()
{
    global $product;
    if (productIsInSpecialCategory($product->ID)) {
        echo '<div class="product-not-deliverable-note">Nicht bestellbar</div>';
    }
}
function productIsInSpecialCategory($product)
{
    $terms = null;
    if ($product->is_type('variation')) { $terms = get_the_terms($product->get_parent_id(), 'product_cat'); }
    else { $terms = get_the_terms($product->id, 'product_cat'); }
    if ($terms) {
        foreach ($terms as $terms__value) {
            if (in_array($terms__value->name, ['CDs, DVDs', 'CDs and DVDs', 'CD - DVD'])) { return true; }
        }
    }
    return false;
}
