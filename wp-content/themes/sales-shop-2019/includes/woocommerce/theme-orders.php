<?php

function ss_get_user_orders($status = [])
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

            if (!empty($status) && !in_array($coupon_status, $status)) {
                continue;
            }

            $coupons[] = $coupon;
        }
    }

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

function ss_get_seller_coupons($search = null){
    global $wpdb;

    $founded_coupons = [];
    
    $select = "SELECT * FROM {$wpdb->prefix}woocommerce_order_items";
    
    $all_coupons = $wpdb->get_results($select);

    // exit(var_dump($all_coupons));
    foreach($all_coupons as $coupon_row){
        $found = false;

        $order_item_product = new WC_Order_Item_Product($coupon_row->order_item_id);
        $coupon_seller = get_field('seller', $order_item_product->get_product_id());
        
        if(get_current_user_id() == $coupon_seller->ID){
            $coupon_number = wc_get_order_item_meta($coupon_row->order_item_id, 'coupon_number', true);
            $order_customer_id = get_post_meta($coupon_row->order_id, '_customer_user', true);
            $customer_data = get_userdata($order_customer_id);
            $customer_full_name = $customer_data->user_lastname . ' ' . $customer_data->user_firstname;

            $search_in = array(
                $coupon_row->order_id,
                $coupon_number,
                $customer_data->user_firstname,
                $customer_data->user_lastname,
                $customer_full_name,
            );

            foreach ($search_in as $value) {
                $found = strpos($value, $search) !== false;

                if ($found) {
                    break;
                }
            }

            if ($search === null || $found) {
                $coupon_data = array(
                    'order_item_id' => $coupon_row->order_item_id,
                    'coupon_number' => $coupon_number,
                );
                $founded_coupons[$coupon_row->order_id] = (object) $coupon_data;
            }   
        }
    }
    return $founded_coupons;
}
// ss_get_seller_coupons();

function edit_formatted_wc_price($return, $price, $args, $unformatted_price)
{
    $return = $unformatted_price . get_woocommerce_currency_symbol();

    return $return;
}

add_filter('wc_price', 'edit_formatted_wc_price', 99, 4);
