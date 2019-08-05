<?php

if (wp_doing_ajax()) {
    add_action('wp_ajax_nopriv_add_and_render_bar', 'ss_add_and_render_bar_handler');
    add_action('wp_ajax_add_and_render_bar', 'ss_add_and_render_bar_handler');

    function ss_add_and_render_bar_handler()
    {
        global $woocommerce;

        $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
        $variation_id = filter_input(INPUT_POST, 'variation_id', FILTER_VALIDATE_INT);

        if (!wp_verify_nonce($_POST['_wpnonce'], 'nonce_' . $product_id))
            exit;

        if ($product_id && $product = ss_get_product($product_id)) {
            $cart_key = null;

            if ($product->has_child()) {
                if ($variation_id) {
                    //variation product
                    $product = ss_get_product($variation_id);
                    $v_attributes = $product->get_variation_attributes();

                    $cart_key = $woocommerce->cart->add_to_cart($product_id, 1, $variation_id, $v_attributes);
                }
            } else {
                //simple product
                $cart_key = $woocommerce->cart->add_to_cart($product_id, 1);
            }

            if ($cart_key) {
                $product->cart_key = $cart_key;

                set_query_var('ss_product', $product);
                ob_start();
                get_template_part('parts/header', 'add');
                $added_bar = ob_get_clean();
                remove_query_arg('ss_product');

                ob_start();
                get_template_part('parts/header', 'cart');
                $header_cart = ob_get_clean();

                $out = [
                    'added_bar' => $added_bar,
                    'header_cart' => $header_cart,
                ];

                wp_send_json_success($out);
            }
        }

        wp_send_json_error();
    }

    add_action('wp_ajax_nopriv_render_filters', 'ss_render_filters');
    add_action('wp_ajax_render_filters', 'ss_render_filters');

    function ss_render_filters(){
        ob_start();
        
        wc_get_template_part('filters', 'archive');
        $filters = ob_get_clean();
        wp_send_json_success($filters);
    }

    add_action('wp_ajax_nopriv_quantity_order_form', 'ss_quantity_order_form_handler');
    add_action('wp_ajax_quantity_order_form', 'ss_quantity_order_form_handler');

    //Quantity order form
    function ss_quantity_order_form_handler()
    {
        $user = wp_get_current_user();
        // Verify nonce
        if (
            !isset($_POST['_wpnonce']) ||
            !wp_verify_nonce($_POST['_wpnonce'], 'ss_quantity_order_form') ||
            !$user->exists()
        ) {
            wp_die('verify error');
        }

        $key = filter_input(INPUT_POST, 'key', FILTER_SANITIZE_STRING);
        $quantity = filter_input(INPUT_POST, 'quantity', FILTER_SANITIZE_NUMBER_INT);

        if (empty($key) || empty($quantity) || $quantity < 1) {
            wp_die('error input');
        }

        WC()->cart->set_quantity($key, $quantity);

        wp_die('ok');
    }

    add_action('wp_ajax_nopriv_checkout_form_order', 'ss_checkout_form_order_handler');
    add_action('wp_ajax_checkout_form_order', 'ss_checkout_form_order_handler');

    function ss_checkout_form_order_handler()
    {
        if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'ss_checkout_form_order')) {
            exit(wp_generate_uuid4());
        }

        $payment = filter_input(INPUT_POST, 'payment');

        $arg = [
            'payment_method' => $payment,
            'status' => 'wc-pending'
        ];
        $order_id = WC()->checkout()->create_order($arg);
        if ($order_id) {
            WC()->cart->empty_cart();
            $order = wc_get_order($order_id);

            if (in_array('sold', SS_FREE_COUPON_STATUSES)) {
                foreach ($order->get_items() as $coupon) {
                    $coupon->add_meta_data('coupon_status', 'sold', false);
                    $coupon->save();
                }
            }

            $pay_now_url = $order->get_checkout_payment_url();
            wp_safe_redirect($pay_now_url);
            exit;
            //ss_return_home(); redirect on Thank You Page
        }

        ss_return_back();
    }
}
