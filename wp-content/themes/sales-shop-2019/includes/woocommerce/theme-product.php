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
    $obj->sale_percentage = $obj->is_on_sale() && !empty($obj->get_regular_price()) ? 100 - floor(($obj->get_sale_price() / $obj->get_regular_price()) * 100) : 0;
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
