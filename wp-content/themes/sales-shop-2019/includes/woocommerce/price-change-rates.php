<?php
if (!is_admin()) {

    // Currency exchange rate
    function get_price_multiplier()
    {
        global $ss_theme_option;
        $coefficient = 1;

        $current_currency = get_woocommerce_currency();
        if ($current_currency == "EUR") {
            if ($ss_theme_option["eur-rate"]) {
                $coefficient = $ss_theme_option["eur-rate"];
            }
        } elseif ($current_currency == "USD") {
            if ($ss_theme_option["usd-rate"]) {
                $coefficient = $ss_theme_option["usd-rate"];
            }
        }
        return (float) $coefficient;
    }
    function custom_price($price)
    {
        $new_price = $price;
        if (!empty($price)) {
            $new_price = $price * get_price_multiplier();
        }

        return $new_price;
    }
    function custom_variable_price($price, $variation, $product)
    {
        // Delete product cached price  (if needed)
        // wc_delete_product_transients($variation->get_id());
        // return empty($price) ? $price : $price * get_price_multiplier();
        return $price;
    }

    function add_price_multiplier_to_variation_prices_hash($hash)
    {
        $hash[] = get_price_multiplier();
        return $hash;
    }

    // Simple, grouped and external products
    $simple_price_change_hooks = [
        'woocommerce_product_get_price',
        'woocommerce_product_get_sale_price',
        'woocommerce_product_get_regular_price',
        'woocommerce_product_variation_get_regular_price',
        'woocommerce_product_variation_get_price',
        'woocommerce_product_variation_get_sale_price',
        //'woocommerce_variation_prices_price',
        //'woocommerce_variation_prices_regular_price',
        'woocommerce_cart_get_subtotal',
        'woocommerce_cart_get_total',
        'woocommerce_order_get_total'
    ];

    foreach ($simple_price_change_hooks as $one) {
        add_filter($one, 'custom_price', 99, 1);
    }
    // Handling price caching
    add_filter('woocommerce_get_variation_prices_hash', 'add_price_multiplier_to_variation_prices_hash', 99, 1);
}
