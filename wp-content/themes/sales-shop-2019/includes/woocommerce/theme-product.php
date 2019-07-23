<?php

function ss_get_product_seller($product_id)
{
    $seller = null;
    $seller_obj = get_field('seller', $product_id); //user obj
    if ($seller_obj) {
        $seller = ss_get_seller_info($seller_obj->ID);
    }
    return $seller;
}

function ss_get_product($product_id)
{
    $obj = wc_get_product($product_id);

    //init product seller
    $obj->seller = ss_get_product_seller($product_id);
    //init product city
    $obj->city = ss_get_seller_city($obj->seller->id);
    $obj->neighborhood = get_field('neighborhood', 'user_' . $obj->seller->id);

    if($obj->is_on_sale()){
        $obj->sale_percentage = $obj->is_on_sale() && !empty($obj->get_regular_price()) ? 100 - floor(($obj->get_sale_price() / $obj->get_regular_price()) * 100) : 0;
    }
    $obj->buyings_count = $obj->get_total_sales();

    return $obj;
}

function ss_render_product($product_id, $style)
{
    $product = ss_get_product($product_id);

    set_query_var('ss_product', $product);
    get_template_part('parts/product', $style);
    remove_query_arg('ss_product_id');
}

function ss_render_product_big($product_id)
{
    ss_render_product($product_id, 'big');
}

function ss_render_product_card($product_id)
{
    ss_render_product($product_id, 'card');
}

function ss_get_video_image_link($attachment_id)
{
    $video_link = null;
    if ($videolink_id_value = get_post_meta($attachment_id, 'videolink_id', true)) {
        $video_link_name = get_post_meta($attachment_id, 'video_site', true);
        $video_link = video_site_name($video_link_name, $videolink_id_value);
    }
    return $video_link;
}

/**
 * Makes pricegetting in all product templates like from regular product
 * When product is variable, product prices will be largest and smalles variables prices
 */
function ss_variable_simulate_regular()
{
    if (!is_admin()) {
        add_filter( 'woocommerce_product_get_sale_price', 'ss_sync_variable_sale_price', 10, 2);
        add_filter( 'woocommerce_product_get_regular_price', 'ss_sync_variable_price', 10, 2);
    }
}

function ss_sync_variable_price($price, $product)
{
    if ($product->has_child()) {
        $price = (float)$product->get_variation_price('min');
    }
    return $price;
}

function ss_sync_variable_sale_price($price, $product)
{
    if ($product->has_child()) {
        $price = (float)$product->get_variation_sale_price('min');
    }
    return $price;
}

function ss_get_active_seller_products($seller_id)
{
    return wc_get_products([
        'status' => 'publish',
        'seller' => $seller_id
    ]);
}

function ss_get_min_price_product($product)
{
    $regular_price = 0;
    if ($product->is_on_sale()) {
        $regular_price = $product->get_sale_price();
    } elseif (!empty($product->get_regular_price())) {
        $regular_price = $product->get_regular_price();
    }

    return $regular_price;
}

/**
 * Handle a custom 'seller' query var to get products with the 'seller' meta.
 * @param array $query - Args for WP_Query.
 * @param array $query_vars - Query vars from WC_Product_Query.
 * @return array modified $query
 */
function handle_custom_query_var($query, $query_vars)
{
    $field = 'seller';
    if (!empty($query_vars[$field])) {
        $query['meta_query'][] = [
            'key' => $field,
            'value' => esc_attr($query_vars[$field]),
        ];
    }

    return $query;
}

add_filter( 'woocommerce_product_data_store_cpt_get_products_query', 'handle_custom_query_var', 10, 2 );
