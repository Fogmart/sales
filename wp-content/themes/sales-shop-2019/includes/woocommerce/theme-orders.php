<?php

function ss_get_user_orders($paginate_page = 1, $paginate_count = -1, $status = [])
{
    if (empty($status)) {
        $status = array_keys(wc_get_order_statuses());
    }

    if (!is_array($status)) {
        return null;
    }

    $args = array(
        'customer_id' => get_current_user_id(),
    );
    $orders = wc_get_orders($args);

    return $orders;
}

function ss_get_coupons($orders, $status = [])
{
    $coupons = [];

    foreach ($orders as $one) {

        foreach ($one->get_items() as $coupon) {

            $coupon_status = wc_get_order_item_meta($coupon->get_id(), 'coupon_status', true);

            // wc_update_order_item_meta() 
            if (!empty($status) && !in_array($coupon_status, $status)) {
                continue;
            }

            $coupons[] = $coupon;
        }
    }

    // var_dump($coupons);

    return $coupons;
}

function ss_get_coupon_status($coupon_id)
{
    $coupon_status = wc_get_order_item_meta($coupon_id, 'coupon_status', true);

    return $coupon_status;
}

function ss_render_account_customer_coupon($order_item, $show_status){
    set_query_var('ss_order_item', $order_item);
    set_query_var('ss_show_status', $show_status);
    $out = get_template_part('parts/account-customer', 'coupon');
    remove_query_arg(array('ss_order_item', 'ss_show_status'));
    
    return $out;
}

function edit_formatted_wc_price($return, $price, $args, $unformatted_price)
{
    $return = $unformatted_price . get_woocommerce_currency_symbol();

    return $return;
}

add_filter('wc_price', 'edit_formatted_wc_price', 99, 4);
