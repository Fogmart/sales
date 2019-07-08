<?php

function ss_get_product_seller($product_id){
    $seller = new class{};
    $seller_id = get_field('seller', $product_id);
    if($seller_id){
        $seller->id = $seller_id;
        $seller->name = get_field('name', $seller->id);
    }
    return $seller;
}

function ss_get_seller_city($seller_id){
    $city = new class{};
    $city_id = get_field('city', $seller_id);
    if($city_id){
        $city->id = $city_id;
        $city->name = get_the_title($city->id);
    }
    return $city;
}

function ss_get_product($product_id){
    $obj = wc_get_product($product_id);

    //init product seller
    $obj->seller = ss_get_product_seller($product_id);
    //init product city
    $obj->city = ss_get_seller_city($obj->seller->id);
    $obj->neighborhood = get_field('neighborhood', $obj->seller->id);
    
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
