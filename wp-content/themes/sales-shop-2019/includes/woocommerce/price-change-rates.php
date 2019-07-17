<?php

// Currency exchange rate
function get_price_multiplier()
{
    return 2;
}
function custom_price($price, $product)
{
    // return empty($price) ? $price : $price * get_price_multiplier();
    return $price;
}
function custom_variable_price($price, $variation, $product)
{
    // Delete product cached price  (if needed)
    // wc_delete_product_transients($variation->get_id());
    // return empty($price) ? $price : $price * get_price_multiplier();
    return $price;
}

// Simple, grouped and external products
$simple_price_change_hooks = [
    'woocommerce_product_get_price',
    'woocommerce_product_get_sale_price',
    'woocommerce_product_get_regular_price',
    'woocommerce_product_variation_get_regular_price',
    'woocommerce_product_variation_get_price'
];

foreach ($simple_price_change_hooks as $one) {
    add_filter($one, 'custom_price', 99, 2);
}

// Variable (price range)

$variable_price_change_hooks = [
    'woocommerce_variation_prices_price',
    'woocommerce_variation_prices_regular_price',
];

foreach ($variable_price_change_hooks as $one) {
    add_filter($one, 'custom_price', 99, 3);
}

// Handling price caching
add_filter('woocommerce_get_variation_prices_hash', 'add_price_multiplier_to_variation_prices_hash', 99, 1);
function add_price_multiplier_to_variation_prices_hash($hash)
{
    $hash[] = get_price_multiplier();
    return $hash;
}
