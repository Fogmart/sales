<?php
add_action('woocommerce_init', 'add_discout_to_checkout', 10, 0);
//discounts, not vouchers (coupons)
function add_discout_to_checkout()
{
    if (null === WC()->session) {
        $session_class = apply_filters('woocommerce_session_handler', 'WC_Session_Handler');
        WC()->session = new $session_class();
        WC()->session->init();
    }

    $coupon_code = WC()->session->get('coupon_code');
    if (!empty($coupon_code) && !WC()->cart->has_discount($coupon_code)) {
        WC()->cart->add_discount($coupon_code);
        WC()->session->__unset('coupon_code');
    }
}
