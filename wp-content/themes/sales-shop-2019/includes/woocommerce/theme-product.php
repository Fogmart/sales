<?php

function ss_get_product_seller($product_id)
{
    $seller = new stdClass();
    $seller_obj = get_field('seller', $product_id); //user obj
    if ($seller_obj) {
        $seller->id = $seller_obj->ID;
        $seller->name = $seller_obj->first_name . ' ' . $seller_obj->last_name;
        //need to be processed!!!! start
        $seller->rating = 3; 
        $seller->reviews_count = 23;
        //need to be processed!!!! end
    }
    return $seller;
}

function ss_get_seller_city($seller_id)
{
    $city = new stdClass();
    $city_id = get_field('city', 'user_' . $seller_id);
    if ($city_id) {
        $city->id = $city_id;
        $city->name = get_the_title($city->id);
        $city->country = get_field('country', 'user_' . $seller_id);
    }
    return $city;
}

function ss_get_product($product_id)
{
    $obj = wc_get_product($product_id);

    //init product seller
    $obj->seller = ss_get_product_seller($product_id);
    //init product city
    $obj->city = ss_get_seller_city($obj->seller->id);
    $obj->neighborhood = get_field('neighborhood', 'user_' . $obj->seller->id);
    $obj->sale_percentage = $obj->is_on_sale() && !empty($obj->get_regular_price()) ? 100 - floor(($obj->get_sale_price() / $obj->get_regular_price()) * 100) : 0;
    $obj->buyings_count = get_post_meta( $product_id, 'total_sales', true );;

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
