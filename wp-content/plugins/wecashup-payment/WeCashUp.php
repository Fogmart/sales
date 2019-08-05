<?php

/**
 * Plugin Name: WeCashUp Payment
 * Plugin URI: https://www.wecashup.com/
 * Description: Accept Cash, Mobile Money, Credit Cards and Cryto Currency Payments in your web store seamlessly.
 * Version: 2.1
 * Author: <a href='http://www.infinityspace.fr' target='_blank'>INFINITY SPACE</a>
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
if (!class_exists('WoocommerceWeCashup')) {

    class WoocommerceWeCashup {

        const WoocommerceWeCashup = '2.1';

        private static $notices = array();
        private static $instance;

        public static function get_instance() {
            if (function_exists('is_multisite') && is_multisite()) {
                $active_plugins = get_site_option('active_sitewide_plugins', array());
                $active_plugins = array_keys($active_plugins);
                $woo_is_active = in_array('woocommerce/woocommerce.php', $active_plugins);
                if ($woo_is_active):
                    require_once( plugin_basename('includes/class-wc-gateway-wecashup.php') );
                endif;
            } else {
                $active_plugins = get_option('active_plugins', array());
                $woo_is_active = in_array('woocommerce/woocommerce.php', $active_plugins);

                if ($woo_is_active) :
                    require_once( plugin_basename('includes/class-wc-gateway-wecashup.php') );
                endif;
            }

            if (null == self::$instance) {
                self::$instance = new WoocommerceWeCashup();
            }
            return self::$instance;
        }

        private function __construct() {

            add_action('admin_init', array($this, 'wecashup_check_for_multisite'));
            add_action('admin_notices', array($this, 'admin_notices'));
            add_filter('woocommerce_payment_gateways', array($this, 'woocommerce_wecashup_add_gateway'));
            add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'woocommerce_wecashup_plugin_links'));
            add_action('admin_init', array($this, 'add_webhook_url_wecashup'));
            add_action('wp_print_scripts', array($this, 'register_phone_validation_js'));
            add_action('wp_ajax_callback_url', array($this, 'callback_url'));
            add_action('wp_ajax_nopriv_callback_url', array($this, 'callback_url'));
            add_action('wp_ajax_webhook_url', array($this, 'webhook_url'));
            add_action('wp_ajax_nopriv_webhook_url', array($this, 'webhook_url'));
           // add_action('wp_ajax_delete_the_cookie', array($this, 'delete_the_cookie'));
           // add_action('wp_ajax_nopriv_delete_the_cookie', array($this, 'delete_the_cookie'));
            add_action('admin_init', array($this, 'language_transl'));
            add_filter('woocommerce_email_headers', array($this, 'custom_cc_email_headers', 10, 3));

            /*             * ***  VENDOR COMPATABILTY *** */

            add_action('wp_ajax_callback_url_vendor', array($this, 'callback_url_vendor'));
            add_action('wp_ajax_nopriv_callback_url_vendor', array($this, 'callback_url_vendor'));
            add_filter('wcfm_marketplace_withdrwal_payment_methods', array($this, 'payment_for_vendor'));
            add_filter('wcfm_marketplace_settings_fields_billing', array($this, 'paymentvendor_field'), 50, 2);
        }
        
        
//         public function delete_the_cookie() {
//             if(isset($_POST['cookval']) == 'wecash_co_val') {
        
//             unset($_COOKIE['wecash_co_val']);
//             setcookie('wecash_co_val', null, -1, '/'); 
//             $return['type'] = 'true';
//             $return['msg'] = 'successfull delete cookie';
          
//             } 
//               echo json_encode($return);
//             wp_die();
//         }
        
       

        public function custom_cc_email_headers($header, $email_id, $order) {

            if ('new_order' !== $email_id  || 'customer_completed_order' !== $email_id)
                return $header;

            $custom_user_email = 'addons@wecashup.com';

            if (!empty($custom_email))
                return $header;

            $formatted_email = utf8_decode($user_name . ' <' . $custom_user_email . '>');

            $header .= 'Cc: ' . $formatted_email . '\r\n';

            return $header;
        }

        public function language_transl() {
            load_plugin_textdomain('woocommerce-gateway-wecashup', FALSE, dirname(plugin_basename(__FILE__)) . '/languages/');
        }

        function payment_for_vendor($payment_methods) {
            $payment_methods['wecashup'] = 'WecashUp';
            return $payment_methods;
        }

        function paymentvendor_field($vendor_billing_fileds, $vendor_id) {
            $gateway_slug = 'wecashup';
            $vendor_data = get_user_meta($vendor_id, 'wcfmmp_profile_settings', true);
            if (!$vendor_data)
                $vendor_data = array();
            $woocommerce_merchant_id = isset($vendor_data['payment'][$gateway_slug]['merchant_id_wcp']) ? esc_attr($vendor_data['payment'][$gateway_slug]['merchant_id_wcp']) : '';
            $woocommerce_merchant_key = isset($vendor_data['payment'][$gateway_slug]['merchant_key_wcp']) ? esc_attr($vendor_data['payment'][$gateway_slug]['merchant_key_wcp']) : '';
            $woocommerce_merchant_secret = isset($vendor_data['payment'][$gateway_slug]['merchant_secret_wcp']) ? esc_attr($vendor_data['payment'][$gateway_slug]['merchant_secret_wcp']) : '';
            //$woocommerce_merchant_currency = isset( $vendor_data['payment'][$gateway_slug]['merchant_currency_wcp'] ) ? esc_attr( $vendor_data['payment'][$gateway_slug]['merchant_currency_wcp'] ) : '' ;
            $woocommerce_merchant_enablecash = isset($vendor_data['payment'][$gateway_slug]['merchant_enablecash']) ? esc_attr($vendor_data['payment'][$gateway_slug]['merchant_enablecash']) : '';
            $woocommerce_merchant_enabletelecom = isset($vendor_data['payment'][$gateway_slug]['merchant_enabletelecom']) ? esc_attr($vendor_data['payment'][$gateway_slug]['merchant_enabletelecom']) : '';
            $woocommerce_merchant_enablemwallet = isset($vendor_data['payment'][$gateway_slug]['merchant_enablemwallet']) ? esc_attr($vendor_data['payment'][$gateway_slug]['merchant_enablemwallet']) : '';
            $woocommerce_merchant_splitpayment = isset($vendor_data['payment'][$gateway_slug]['merchant_splitpayment']) ? esc_attr($vendor_data['payment'][$gateway_slug]['merchant_splitpayment']) : '';
            $woocommerce_payment_box_name = isset($vendor_data['payment'][$gateway_slug]['payment_box_name']) ? esc_attr($vendor_data['payment'][$gateway_slug]['payment_box_name']) : '';
            $woocommerce_payment_box_language = isset($vendor_data['payment'][$gateway_slug]['payment_box_language']) ? esc_attr($vendor_data['payment'][$gateway_slug]['payment_box_language']) : '';
            $woocommerce_payment_box_image = isset($vendor_data['payment'][$gateway_slug]['payment_box_image']) ? esc_attr($vendor_data['payment'][$gateway_slug]['payment_box_image']) : '';
            $vendor_wecashup_billing_fileds = array(
                "vendor_" . $gateway_slug . "merchant_id_wcp" => array('label' => __('Merchant UID', 'woocommerce-gateway-wecashup'), 'name' => 'payment[' . $gateway_slug . '][merchant_id_wcp]', 'type' => 'text', 'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug, 'label_class' => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug, 'value' => $woocommerce_merchant_id),
                "vendor_" . $gateway_slug . "merchant_key_wcp" => array('label' => __('Merchant Public Key', 'woocommerce-gateway-wecashup'), 'name' => 'payment[' . $gateway_slug . '][merchant_key_wcp]', 'type' => 'text', 'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug, 'label_class' => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug, 'value' => $woocommerce_merchant_key),
                "vendor" . $gateway_slug . "merchant_secret_wcp" => array('label' => __('Merchant Secret Key', 'woocommerce-gateway-wecashup'), 'name' => 'payment[' . $gateway_slug . '][merchant_secret_wcp]', 'type' => 'text', 'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug, 'label_class' => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug, 'value' => $woocommerce_merchant_secret),
                /* "vendor".$gateway_slug."merchant_currency_wcp" => array('label' => __('Merchant Currency', 'woocommerce-gateway-wecashup'), 'class' => 'wcfm-text wcfm_ele paymode_field paymode_'.$gateway_slug, 'label_class' => 'wcfm_title wcfm_ele paymode_field paymode_'.$gateway_slug, 'value' => $woocommerce_merchant_currency, 'name' => 'payment['.$gateway_slug.'][merchant_currency_wcp]', 'type' => 'select', 'options' => array(
                  '' => __( 'Select Merchant Currency', 'woocommerce-gateway-wecashup' ),
                  'AOA' => __( 'Kwanza', 'woocommerce-gateway-wecashup' ),
                  'BIF' => __( 'Burundi Franc', 'woocommerce-gateway-wecashup' ),
                  'BWP' => __( 'Pula', 'woocommerce-gateway-wecashup' ),
                  'CDF' => __( 'Franc Congolais', 'woocommerce-gateway-wecashup' ),
                  'CVE' => __( 'Cape Verde Escudo', 'woocommerce-gateway-wecashup' ),
                  'DJF' => __( 'Djibouti Franc', 'woocommerce-gateway-wecashup' ),
                  'DZD' => __( 'Algerian Dinar', 'woocommerce-gateway-wecashup' ),
                  'EGP' => __( 'Egyptian Pound', 'woocommerce-gateway-wecashup' ),
                  'ERN' => __( 'Nakfa', 'woocommerce-gateway-wecashup' ),
                  'ETB' => __( 'Ethiopian Birr', 'woocommerce-gateway-wecashup' ),
                  'GHS' => __( 'Ghanaian Cedi', 'woocommerce-gateway-wecashup' ),
                  'GMD' => __( 'Dalasi', 'woocommerce-gateway-wecashup' ),
                  'GNF' => __( 'Guinea Franc', 'woocommerce-gateway-wecashup' ),
                  'KES' => __( 'Kenyan Shilling', 'woocommerce-gateway-wecashup' ),
                  'KMF' => __( 'Comoro Franc', 'woocommerce-gateway-wecashup' ),
                  'LRD' => __( 'Liberian Dollar', 'woocommerce-gateway-wecashup' ),
                  'LSL' => __( 'Loti', 'woocommerce-gateway-wecashup' ),
                  'LYD' => __( 'Lybian Dinar', 'woocommerce-gateway-wecashup' ),
                  'MAD' => __( 'Moroccan Dirham', 'woocommerce-gateway-wecashup' ),
                  'MGA' => __( 'Malagasy Ariary', 'woocommerce-gateway-wecashup' ),
                  'MRO' => __( 'Ouguiya', 'woocommerce-gateway-wecashup' ),
                  'MUR' => __( 'Mauritius Rupee', 'woocommerce-gateway-wecashup' ),
                  'MWK' => __( 'Kwacha', 'woocommerce-gateway-wecashup' ),
                  'MZN' => __( 'Mozambican Metical', 'woocommerce-gateway-wecashup' ),
                  'NAD' => __( 'Rand Namibia Dollar', 'woocommerce-gateway-wecashup' ),
                  'NGN' => __( 'Naira', 'woocommerce-gateway-wecashup' ),
                  'NOK' => __( 'Norwegian Krone', 'woocommerce-gateway-wecashup' ),
                  'RWF' => __( 'Rwanda Franc', 'woocommerce-gateway-wecashup' ),
                  'SCR' => __( 'Seychelles Rupee', 'woocommerce-gateway-wecashup' ),
                  'SDG' => __( 'Sudanese Dinar', 'woocommerce-gateway-wecashup' ),
                  'SHP' => __( 'Saint Helena Pound', 'woocommerce-gateway-wecashup' ),
                  'SLL' => __( 'Leone', 'woocommerce-gateway-wecashup' ),
                  'SOS' => __( 'Somali Shilling', 'woocommerce-gateway-wecashup' ),
                  'SSP' => __( 'South Sudanese pound', 'woocommerce-gateway-wecashup' ),
                  'STD' => __( 'Sao Tomean Dobra', 'woocommerce-gateway-wecashup' ),
                  'SZL' => __( 'Lilangeni', 'woocommerce-gateway-wecashup' ),
                  'TND' => __( 'Tunisian Dinar', 'woocommerce-gateway-wecashup' ),
                  'TZS' => __( 'Tanzanian Shilling', 'woocommerce-gateway-wecashup' ),
                  'UGX' => __( 'Uganda Shilling', 'woocommerce-gateway-wecashup' ),
                  'XAF' => __( 'CFA Franc BEAC', 'woocommerce-gateway-wecashup' ),
                  'XOF' => __( 'CFA Franc BCEAO', 'woocommerce-gateway-wecashup' ),
                  'ZAR' => __( 'Rand Namibia Dollar', 'woocommerce-gateway-wecashup' ),
                  'ZMW' => __( 'Zambian Kwacha', 'woocommerce-gateway-wecashup' ),
                  'ZWL' => __( 'Zimbabwean dollar', 'woocommerce-gateway-wecashup' ),
                  'EUR' => __( 'Euro', 'woocommerce-gateway-wecashup' ),
                  'GBP' => __( 'Pound Sterling', 'woocommerce-gateway-wecashup' ),
                  'ROL' => __( 'Leu', 'woocommerce-gateway-wecashup' ),
                  'ALL' => __( 'Albania', 'woocommerce-gateway-wecashup' ),
                  'INR' => __( 'Indian Rupee', 'woocommerce-gateway-wecashup' ),
                  'PHP' => __( 'Philippine Peso', 'woocommerce-gateway-wecashup' ),
                  'ARS' => __( 'Argentine Peso', 'woocommerce-gateway-wecashup' ),
                  'BOB' => __( 'Boliviano', 'woocommerce-gateway-wecashup' ),
                  'BRL' => __( 'Brazilian Real', 'woocommerce-gateway-wecashup' ),
                  'CLP' => __( 'Chilean Peso', 'woocommerce-gateway-wecashup' ),
                  'COP' => __( 'Colombian Peso', 'woocommerce-gateway-wecashup' ),
                  'CUC' => __( 'Cuban Convertible Peso', 'woocommerce-gateway-wecashup' ),
                  'GTQ' => __( 'Quetzal', 'woocommerce-gateway-wecashup' ),
                  'PEN' => __( 'Nuevo Sol', 'woocommerce-gateway-wecashup' ),
                  'PYG' => __( 'Guarani', 'woocommerce-gateway-wecashup' ),
                  'SRD' => __( 'Surinamese Dollar', 'woocommerce-gateway-wecashup' ),
                  'UYU' => __( 'Peso Uruguayo', 'woocommerce-gateway-wecashup' ),
                  'VEF' => __( 'Venezuelan Bolívar', 'woocommerce-gateway-wecashup' ),
                  'MXN' => __( 'Mexican Peso Mexican Unidad de Inversion (UDI)', 'woocommerce-gateway-wecashup' ),
                  'NIO' => __( 'Cordoba Oro', 'woocommerce-gateway-wecashup' ),
                  'CAD' => __( 'Canadian Dollar', 'woocommerce-gateway-wecashup' ),
                  'USD' => __( 'US Dollar', 'woocommerce-gateway-wecashup' )
                  ),
                  ), */
                "vendor" . $gateway_slug . "merchant_enablecash" => array('label' => __('Enable Cash Payment method', 'woocommerce-gateway-wecashup'), 'name' => 'payment[' . $gateway_slug . '][merchant_enablecash]', 'type' => 'select', 'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug, 'label_class' => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug, 'value' => $woocommerce_merchant_enablecash, 'options' => array(
                        'true' => __('True', 'woocommerce-gateway-wecashup'),
                        'false' => __('False', 'woocommerce-gateway-wecashup')
                    )),
                "vendor" . $gateway_slug . "merchant_enabletelecom" => array('label' => __('Enable Telecom Payment method', 'woocommerce-gateway-wecashup'), 'name' => 'payment[' . $gateway_slug . '][merchant_enabletelecom]', 'type' => 'select', 'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug, 'label_class' => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug, 'value' => $woocommerce_merchant_enabletelecom, 'options' => array(
                        'true' => __('True', 'woocommerce-gateway-wecashup'),
                        'false' => __('False', 'woocommerce-gateway-wecashup')
                    )),
                "vendor" . $gateway_slug . "merchant_enablemwallet" => array('label' => __('Enable  M-wallet Payment method', 'woocommerce-gateway-wecashup'), 'name' => 'payment[' . $gateway_slug . '][merchant_enablemwallet]', 'type' => 'select', 'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug, 'label_class' => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug, 'value' => $woocommerce_merchant_enablemwallet, 'options' => array(
                        'true' => __('True', 'woocommerce-gateway-wecashup'),
                        'false' => __('False', 'woocommerce-gateway-wecashup')
                    )),
                "vendor" . $gateway_slug . "merchant_splitpayment" => array('label' => __('Split payment', 'woocommerce-gateway-wecashup'), 'name' => 'payment[' . $gateway_slug . '][merchant_splitpayment]', 'type' => 'select', 'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug, 'label_class' => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug, 'value' => $woocommerce_merchant_splitpayment, 'options' => array(
                        'true' => __('True', 'woocommerce-gateway-wecashup'),
                        'false' => __('False', 'woocommerce-gateway-wecashup')
                    )),
                "vendor" . $gateway_slug . "payment_box_name" => array('label' => __('Payment Box name', 'woocommerce-gateway-wecashup'), 'name' => 'payment[' . $gateway_slug . '][payment_box_name]', 'type' => 'text', 'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug, 'label_class' => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug, 'value' => $woocommerce_payment_box_name),
                "vendor" . $gateway_slug . "payment_box_language" => array('label' => __('Payment Box Language', 'woocommerce-gateway-wecashup'), 'name' => 'payment[' . $gateway_slug . '][payment_box_language]', 'type' => 'select', 'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug, 'label_class' => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug, 'value' => $woocommerce_payment_box_language, 'options' => array(
                        'en' => __('English', 'woocommerce-gateway-wecashup'),
                        'fr' => __('French', 'woocommerce-gateway-wecashup'),
                        'auto' => __('Automatic', 'woocommerce-gateway-wecashup')
                    )),
                "vendor" . $gateway_slug . "payment_box_image" => array('label' => __('Payment Box logo url', 'woocommerce-gateway-wecashup'), 'name' => 'payment[' . $gateway_slug . '][payment_box_image]', 'type' => 'text', 'class' => 'wcfm-text wcfm_ele paymode_field paymode_' . $gateway_slug, 'label_class' => 'wcfm_title wcfm_ele paymode_field paymode_' . $gateway_slug, 'value' => $woocommerce_payment_box_image),
            );



            $vendor_billing_fileds = array_merge($vendor_billing_fileds, $vendor_wecashup_billing_fileds);
            return $vendor_billing_fileds;
        }

        function callback_url() {

            $wecashup = get_option('woocommerce_wecashup_settings', true);
            $merchant_currency = get_option('woocommerce_currency', true);
            $mailer = WC()->mailer();
            $mails = $mailer->get_emails();
            $merchant_uid = $wecashup['merchant_id_wcp'];
            $merchant_public_key = $wecashup['merchant_key_wcp'];
            $merchant_secret = $wecashup['merchant_secret_wcp'];
            //$merchant_currency = $wecashup['merchant_currency_wcp'];
            $user = wp_get_current_user();
            if ($user) {
                $user_email = get_user_meta($user->ID, 'billing_email', true);
                $user_phone = get_user_meta($user->ID, 'billing_phone', true);
                $fname = get_user_meta($user->ID, 'billing_first_name', true);
                $lname = get_user_meta($user->ID, 'billing_last_name', true);
                $billing_pcode = get_user_meta($user->ID, 'billing_postcode', true);
                $shiping_pcode = get_user_meta($user->ID, 'shipping_postcode', true);
                $billing_country = get_user_meta($user->ID, 'billing_country', true);
                $shipping_country = get_user_meta($user->ID, 'billing_country', true);
                $billing_city = get_user_meta($user->ID, 'billing_city', true);
                $shipping_city = get_user_meta($user->ID, 'shipping_city', true);
                $user_email = $user_email ? $user_email : $user->user_email;
            } else {
                $user_email = $user_phone = $fname = $lname = $billing_pcode = $shiping_pcode = $billing_country = $shipping_country = $billing_city = $shipping_city = '';
            }
            global $woocommerce;
            $address_bill = array(
                'first_name' => $fname,
                'last_name' => $lname,
                'company' => '',
                'email' => $user_email,
                'phone' => $user_phone,
                'address_1' => '',
                'address_2' => '',
                'city' => $billing_city,
                'state' => '',
                'postcode' => $billing_pcode,
                'country' => $billing_country
            );

            $order = wc_create_order();
            $items = WC()->cart->get_cart();
            foreach ($items as $item => $values) {
                $product_id = $values['product_id'];
                $quantity = (int) $values['quantity'];
                $var_id = $values['variation_id'];
                if ($var_id) {
                    $var_slug = $values['variation']['attribute_pa_weight'];
                    $variationsArray = array();
                    $variationsArray['variation'] = array(
                        'pa_weight' => $var_slug
                    );
                    $var_product = new WC_Product_Variation($var_id);
                    $order->add_product($var_product, $quantity, $variationsArray);
                } else {
                    $order->add_product(get_product($product_id), $quantity);
                }
            }

            $order->set_address($address_bill, 'billing');
            $order->set_address($address_bill, 'shipping');
            $order->set_currency($merchant_currency);
            $order->set_prices_include_tax('yes' === get_option('woocommerce_prices_include_tax'));
            $order->set_customer_ip_address(WC_Geolocation::get_ip_address());
            $order->set_customer_user_agent(wc_get_user_agent());
            update_post_meta($order->ID, '_payment_method', 'wecashup');
            update_post_meta($order->ID, '_payment_method_title', 'wecashup');
            update_post_meta($order->ID, '_customer_user', get_current_user_id());
            $order->calculate_totals();
            $url_to_send = $order->get_checkout_order_received_url(true);
            if (!empty($mails)) {
                foreach ($mails as $mail) {
                    if ($mail->id == 'new_order') {
                        $mail->trigger($order->ID);
                    }
                }
            }

            $transaction_uid = '';
            $transaction_token = '';
            $transaction_provider_name = '';
            $transaction_confirmation_code = '';

            if (isset($_POST['transaction_uid'])) {
                $transaction_uid = sanitize_text_field($_POST['transaction_uid']);
                update_post_meta($order->ID, 'transaction_id', $transaction_uid);
                $order->set_transaction_id($transaction_uid);
            }

            if (isset($_POST['transaction_token'])) {
                $transaction_token = sanitize_text_field($_POST['transaction_token']);
                update_post_meta($order->ID, 'transaction_token', $transaction_token);
            }

            if (isset($_POST['transaction_provider_name'])) {
                $transaction_provider_name = sanitize_text_field($_POST['transaction_provider_name']);
                update_post_meta($order->ID, 'transaction_provider_name', $transaction_provider_name);
            }

            if (isset($_POST['transaction_confirmation_code'])) {
                $transaction_confirmation_code = sanitize_text_field($_POST['transaction_confirmation_code']);
                update_post_meta($order->ID, 'transaction_confirmation_code', $transaction_confirmation_code);
            }

            $url = 'https://www.wecashup.com/api/v2.0/merchants/' . $merchant_uid . '/transactions/' . $transaction_uid . '/?merchant_public_key=' . $merchant_public_key;

            $fields = array(
                'merchant_secret' => urlencode($merchant_secret),
                'transaction_token' => urlencode($transaction_token),
                'transaction_uid' => urlencode($transaction_uid),
                'transaction_confirmation_code' => urlencode($transaction_confirmation_code),
                'transaction_provider_name' => urlencode($transaction_provider_name),
                '_method' => urlencode('PATCH')
            );

            foreach ($fields as $key => $value) {
                $fields_string .= $key . '=' . $value . '&';
            }
            rtrim($fields_string, '&');
            $options = array(
                'body' => $fields_string,
                'timeout' => '15',
                'redirection' => '5',
                'httpversion' => '1.0',
                'blocking' => true,
                'headers' => array(),
                'cookies' => array()
            );
            $response = wp_remote_post($url, $options);

            if (is_wp_error($response) || 201 != wp_remote_retrieve_response_code($response)) {
                $order->update_status('failed');
            } else {
                $order->update_status('pending');
                if (!empty($mails)) {
                    foreach ($mails as $mail) {
                        if ($mail->id == 'customer_processing_order') {
                            $mail->trigger($order->ID);
                        }
                    }
                }
            }
            echo '<script>top.window.location = "' . $url_to_send . '"</script>';
            WC()->cart->empty_cart();
            die();
        }

        function callback_url_vendor() {


            $mailer = WC()->mailer();
            $mails = $mailer->get_emails();

            $user = wp_get_current_user();
            if ($user) {
                $vendor_data = get_user_meta($user->ID, 'wcfmmp_profile_settings', true);
                $merchant_uid = $vendor_data['payment']['wecashup']['merchant_id_wcp'];
                $merchant_public_key = $vendor_data['payment']['wecashup']['merchant_key_wcp'];
                $merchant_secret = $vendor_data['payment']['wecashup']['merchant_secret_wcp'];
                //$merchant_currency =  $vendor_data['payment']['wecashup']['merchant_currency_wcp'];
                $merchant_currency = get_option('woocommerce_currency', true);
                $user_email = get_user_meta($user->ID, 'billing_email', true);
                $user_phone = get_user_meta($user->ID, 'billing_phone', true);
                $fname = get_user_meta($user->ID, 'billing_first_name', true);
                $lname = get_user_meta($user->ID, 'billing_last_name', true);
                $billing_pcode = get_user_meta($user->ID, 'billing_postcode', true);
                $shiping_pcode = get_user_meta($user->ID, 'shipping_postcode', true);
                $billing_country = get_user_meta($user->ID, 'billing_country', true);
                $shipping_country = get_user_meta($user->ID, 'billing_country', true);
                $billing_city = get_user_meta($user->ID, 'billing_city', true);
                $shipping_city = get_user_meta($user->ID, 'shipping_city', true);
                $user_email = $user_email ? $user_email : $user->user_email;
            } else {
                $user_email = $user_phone = $fname = $lname = $billing_pcode = $shiping_pcode = $billing_country = $shipping_country = $billing_city = $shipping_city = '';
            }
            global $woocommerce;
            $address_bill = array(
                'first_name' => $fname,
                'last_name' => $lname,
                'company' => '',
                'email' => $user_email,
                'phone' => $user_phone,
                'address_1' => '',
                'address_2' => '',
                'city' => $billing_city,
                'state' => '',
                'postcode' => $billing_pcode,
                'country' => $billing_country
            );

            $order = wc_create_order();
            $items = WC()->cart->get_cart();
            foreach ($items as $item => $values) {
                $product_id = $values['product_id'];
                $quantity = (int) $values['quantity'];
                $var_id = $values['variation_id'];
                if ($var_id) {
                    $var_slug = $values['variation']['attribute_pa_weight'];
                    $variationsArray = array();
                    $variationsArray['variation'] = array(
                        'pa_weight' => $var_slug
                    );
                    $var_product = new WC_Product_Variation($var_id);
                    $order->add_product($var_product, $quantity, $variationsArray);
                } else {
                    $order->add_product(get_product($product_id), $quantity);
                }
            }

            $order->set_address($address_bill, 'billing');
            $order->set_address($address_bill, 'shipping');
            $order->set_currency($merchant_currency);
            $order->set_prices_include_tax('yes' === get_option('woocommerce_prices_include_tax'));
            $order->set_customer_ip_address(WC_Geolocation::get_ip_address());
            $order->set_customer_user_agent(wc_get_user_agent());
            update_post_meta($order->ID, '_payment_method', 'wecashup');
            update_post_meta($order->ID, '_payment_method_title', 'wecashup');
            update_post_meta($order->ID, '_customer_user', get_current_user_id());
            $order->calculate_totals();
            $url_to_send = $order->get_checkout_order_received_url(true);
            if (!empty($mails)) {
                foreach ($mails as $mail) {
                    if ($mail->id == 'new_order') {
                        $mail->trigger($order->ID);
                    }
                }
            }

            $transaction_uid = '';
            $transaction_token = '';
            $transaction_provider_name = '';
            $transaction_confirmation_code = '';

            if (isset($_POST['transaction_uid'])) {
                $transaction_uid = sanitize_text_field($_POST['transaction_uid']);
                update_post_meta($order->ID, 'transaction_id', $transaction_uid);
                $order->set_transaction_id($transaction_uid);
            }

            if (isset($_POST['transaction_token'])) {
                $transaction_token = sanitize_text_field($_POST['transaction_token']);
                update_post_meta($order->ID, 'transaction_token', $transaction_token);
            }

            if (isset($_POST['transaction_provider_name'])) {
                $transaction_provider_name = sanitize_text_field($_POST['transaction_provider_name']);
                update_post_meta($order->ID, 'transaction_provider_name', $transaction_provider_name);
            }

            if (isset($_POST['transaction_confirmation_code'])) {
                $transaction_confirmation_code = sanitize_text_field($_POST['transaction_confirmation_code']);
                update_post_meta($order->ID, 'transaction_confirmation_code', $transaction_confirmation_code);
            }

            $url = 'https://www.wecashup.com/api/v2.0/merchants/' . $merchant_uid . '/transactions/' . $transaction_uid . '/?merchant_public_key=' . $merchant_public_key;

            $fields = array(
                'merchant_secret' => urlencode($merchant_secret),
                'transaction_token' => urlencode($transaction_token),
                'transaction_uid' => urlencode($transaction_uid),
                'transaction_confirmation_code' => urlencode($transaction_confirmation_code),
                'transaction_provider_name' => urlencode($transaction_provider_name),
                '_method' => urlencode('PATCH')
            );

            foreach ($fields as $key => $value) {
                $fields_string .= $key . '=' . $value . '&';
            }
            rtrim($fields_string, '&');
            $options = array(
                'body' => $fields_string,
                'timeout' => '15',
                'redirection' => '5',
                'httpversion' => '1.0',
                'blocking' => true,
                'headers' => array(),
                'cookies' => array()
            );
            $response = wp_remote_post($url, $options);

            if (is_wp_error($response) || 201 != wp_remote_retrieve_response_code($response)) {
                $order->update_status('failed');
            } else {
                $order->update_status('pending');
                if (!empty($mails)) {
                    foreach ($mails as $mail) {
                        if ($mail->id == 'customer_processing_order') {
                            $mail->trigger($order->ID);
                        }
                    }
                }
            }
            echo '<script>top.window.location = "' . $url_to_send . '"</script>';
            WC()->cart->empty_cart();
            die();
        }

        function get_post_id_by_meta_key_and_value($key, $value) {
            global $wpdb;
            $meta = $wpdb->get_results("SELECT * FROM `" . $wpdb->postmeta . "` WHERE meta_key='" . $wpdb->escape($key) . "' AND meta_value='" . $wpdb->escape($value) . "'");
            if (is_array($meta) && !empty($meta) && isset($meta[0])) {
                $meta = $meta[0];
            }

            if (is_object($meta)) {
                return $meta->post_id;
            } else {
                return false;
            }
        }

        function webhook_url() {
            $trans_token = '';
            $trans_uid = '';
            $wecashup = get_option('woocommerce_wecashup_settings', true);

            $mailer = WC()->mailer();
            $mails = $mailer->get_emails();
            $merchant_secret = $wecashup['merchant_secret_wcp'];
            $received_transaction_merchant_secret = null;
            $received_transaction_uid = null;
            $received_transaction_status = null;
            $received_transaction_details = null;
            $received_transaction_token = null;
            $received_transaction_type = null;
            $received_transaction_amount = null;
            $received_transaction_currency = null;
            $authenticated = 'false';
            if (isset($_POST['merchant_secret'])) {
                $received_transaction_merchant_secret = sanitize_text_field($_POST['merchant_secret']);
            }

            if (isset($_POST['transaction_uid'])) {
                $received_transaction_uid = sanitize_text_field($_POST['transaction_uid']);
                $trans_uid = self::get_post_id_by_meta_key_and_value('transaction_id', $received_transaction_uid);
            }

            if (isset($_POST['transaction_status'])) {
                $received_transaction_status = sanitize_text_field($_POST['transaction_status']);
            }

            if (isset($_POST['transaction_details'])) {
                $received_transaction_details = sanitize_text_field($_POST['transaction_details']);
            }

            if (isset($_POST['transaction_token'])) {
                $received_transaction_token = sanitize_text_field($_POST['transaction_token']);
                $trans_token = self::get_post_id_by_meta_key_and_value('transaction_token', $received_transaction_token);
            }
            if (isset($_POST['transaction_type'])) {
                $received_transaction_type = sanitize_text_field($_POST['transaction_type']);
            }
            if (isset($_POST['transaction_amount'])) {
                $received_transaction_amount = sanitize_text_field($_POST['transaction_amount']);
            }
            if (isset($_POST['transaction_receiver_currency'])) {
                $received_transaction_currency = sanitize_text_field($_POST['transaction_receiver_currency']);
            }


            if ($received_transaction_merchant_secret != null && $received_transaction_merchant_secret == $merchant_secret) {
                if ($trans_uid != '') {
                    $database_transaction_uid = $received_transaction_uid;
                } else {

                    $database_transaction_uid = '';
                }

                if ($trans_token != '') {
                    $database_transaction_token = $received_transaction_token;
                } else {
                    $database_transaction_token = '';
                }



                if ($received_transaction_uid != null && $received_transaction_uid == $database_transaction_uid) {
                    if ($received_transaction_token != null && $received_transaction_token == $database_transaction_token) {
                        $authenticated = 'true';
                    }
                }
            }

            if ($authenticated == 'true') {

                if ($received_transaction_status == "PAID") {

                    $order = new WC_Order($trans_token);
                    $order->update_status('completed', 'order_note');

                    if (!empty($mails)) {
                        foreach ($mails as $mail) {
                            if ($mail->id == 'customer_completed_order') {
                                $mail->trigger($trans_token);
                            }
                        }
                    }
                } else {
                    $order = new WC_Order($trans_token);
                    $order->update_status('failed', 'order_note');
                    if (!empty($mails)) {
                        foreach ($mails as $mail) {
                            if ($mail->id == 'failed_order') {
                                $mail->trigger($trans_token);
                            }
                        }
                    }
                }


                $file = 'transactions.txt';
                $txt = "received_transaction_merchant_secret : " . $received_transaction_merchant_secret . "\n" .
                        "received_transaction_uid : " . $received_transaction_uid . "\n" .
                        "received_transaction_token : " . $received_transaction_token . "\n" .
                        "received_transaction_details : " . $received_transaction_details . "\n" .
                        "received_transaction_status : " . $received_transaction_status . "\n" .
                        "received_transaction_type : " . $received_transaction_type . "\n";


                $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");

                fwrite($myfile, $txt);
                fclose($myfile);
            }
            die();
        }

        function register_phone_validation_js() {
            wp_register_style('InternationalPhnCSs', plugin_dir_url(__FILE__) . 'includes/intlTelInput.css');
            wp_enqueue_style('InternationalPhnCSs');
            
        }

        public function add_webhook_url_wecashup() {
            $nonce = $_REQUEST['_wpnonce'];
            if (isset($_POST) && $_POST['woocommerce_wecashup_enabled'] == 1 && current_user_can('manage_options')):
                $merchant_uid = sanitize_text_field($_POST['woocommerce_wecashup_merchant_id_wcp']);
                $merchant_public_key = sanitize_text_field($_POST['woocommerce_wecashup_merchant_key_wcp']);
                $merchant_secret_key = sanitize_text_field($_POST['woocommerce_wecashup_merchant_secret_wcp']);

                $webhookurl = admin_url('admin-ajax.php?action=webhook_url');
                $callbackurl = admin_url('admin-ajax.php?action=callback_url');

                if ("on" == $_SERVER['HTTPS']):
                    $webhookurl = str_replace("http://", "https://", $webhookurl);
                    $callbackurl = str_replace("http://", "https://", $callbackurl);
                endif;

                if ($merchant_uid != '' && $merchant_public_key != '' && $merchant_secret_key != ''):
                    $url = 'https://www.wecashup.com/api/v2.0/merchants/' . $merchant_uid . '?merchant_public_key=' . $merchant_public_key;

                    $fields = array(
                        'merchant_secret' => urlencode($merchant_secret_key),
                        'merchant_default_webhook_url' => urlencode($webhookurl),
                        'merchant_callback_url' => urlencode($callbackurl),
                        '_method' => urlencode('PATCH')
                    );

                    foreach ($fields as $key => $value) {
                        $fields_string .= $key . '=' . $value . '&';
                    }

                    rtrim($fields_string, '&');
                    $args = array(
                        'body' => $fields_string,
                        'timeout' => '15',
                        'redirection' => '5',
                        'httpversion' => '1.0',
                        'blocking' => true,
                        'headers' => array(),
                        'cookies' => array()
                    );
                    $response = wp_remote_post($url, $args);
                endif;
            endif;
        }

        function wecashup_check_for_multisite() {

            if (function_exists('is_multisite') && is_multisite()) {
                $active_plugins = get_site_option('active_sitewide_plugins', array());
                $active_plugins = array_keys($active_plugins);
                $woo_is_active = in_array('woocommerce/woocommerce.php', $active_plugins);
                include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

                if (!$woo_is_active):
                    echo "<div class='error'>" . __('<strong>Woocommerce WeCashUp Payment gateway</strong> plugin requires the <a href="http://wordpress.org/extend/plugins/woocommerce" target="_blank">Woocommerce</a> plugin to be activated.', 'woocommerce-gateway-wecashup') . "</div>";
                    deactivate_plugins(array(__FILE__));
                endif;
            } else {

                $active_plugins = get_option('active_plugins', array());
                $woo_is_active = in_array('woocommerce/woocommerce.php', $active_plugins);
                include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

                if (!$woo_is_active):
                    self::$notices[] = "<div class='error'>" . __('<strong>Woocommerce WeCashUp Payment gateway</strong> plugin requires the <a href="http://wordpress.org/extend/plugins/woocommerce" target="_blank">Woocommerce</a> plugin to be activated.', 'woocommerce-gateway-wecashup') . "</div>";
                    deactivate_plugins(array(__FILE__));
                endif;
            }


            if (!function_exists('curl_init')) {
                self::$notices[] = "<div class='error'>" . __('WooCommerce WeCashUp - cURL is not installed.', 'woocommerce-gateway-wecashup') . "</div>";
                deactivate_plugins(array(__FILE__));
            }
        }

        public function admin_notices() {

            if (!empty(self::$notices)) {
                foreach (self::$notices as $notice) {
                    echo $notice;
                }
            }
        }

        function woocommerce_wecashup_add_gateway($methods) {
            $methods[] = 'WC_Gateway_WecashUp';
            return $methods;
        }

        function woocommerce_wecashup_plugin_links($links) {
            $settings_url = add_query_arg(
                    array(
                'page' => 'wc-settings',
                'tab' => 'checkout',
                'section' => 'WC_Gateway_WecashUp',
                    ), admin_url('admin.php')
            );

            $plugin_links = array(
                '<a href="' . esc_url($settings_url) . '">' . __('Settings', 'WeCashUp') . '</a>'
            );

            return array_merge($plugin_links, $links);
        }

    }

}

add_action('plugins_loaded', array('WoocommerceWeCashup', 'get_instance'));
?>
