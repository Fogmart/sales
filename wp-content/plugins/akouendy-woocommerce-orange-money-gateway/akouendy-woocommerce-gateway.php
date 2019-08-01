<?php

/*
  Plugin Name: Akouendy Woocommerce Orange Money Gateway
  Plugin URI: https://docs.akouendy.com/docs/wordpress/paiement-avec-orange-money
  Description: Integrer facilement des paiements via Orange Money dans votre site WooCommerce et commencer à  accepter les paiements depuis le Senegal.
  Version: 1.0.1
  Author: AKOUENDY
  Author URI: https://www.akouendy.com
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    exit;
}

add_action('plugins_loaded', 'woocommerce_akouendy_init', 0);


function woocommerce_akouendy_init() {
    if (!class_exists('WC_Payment_Gateway'))
        return;

    class WC_Akouendy extends WC_Payment_Gateway {

        public function __construct() {
            $this->akouendy_errors = new WP_Error();

            $this->id = 'akouendy';
            $this->medthod_title = 'Orange Money';
            $this->icon = apply_filters('woocommerce_akouendy_icon', plugins_url('assets/images/orange-cash.png', __FILE__));
            $this->has_fields = false;

            $this->init_form_fields();
            $this->init_settings();

            $this->title = $this->settings['title'];
            $this->description = $this->settings['description'];

            $this->site_id = $this->settings['site_id'];
            $this->site_token = $this->settings['site_token'];

            $this->sandbox = $this->settings['sandbox'];

    
            
            $this->ipnbase = "https://reservation.akouendy.com";
            //$this->ipnbase = "http://192.168.50.1:9000";
            $this->posturl = $this->ipnbase . "/v1/billing/payment/init";
            $this->geturl =  $this->ipnbase . "/v1/billing/payment/status";
            $this->checkouturl = $this->ipnbase . "/v1/billing/orange-money-sn/";
            $this->poststatus = $this->ipnbase . "/v1/billing/payment/status";

            $this->msg['message'] = "";
            $this->msg['class'] = "";            

            if (isset($_REQUEST["akouendy"])) {
                wc_add_notice(sanitize_text_field($_REQUEST["akouendy"]), "error");
            } elseif (isset($_REQUEST["akouendy-msg"])) {
                wc_add_notice(sanitize_text_field($_REQUEST["akouendy-msg"]), "notice");
            }

            if (isset($_REQUEST["token"]) && $_REQUEST["token"] <> "") {
                $token = sanitize_text_field(trim($_REQUEST["token"]));
                $this->check_akouendy_response($token);

            } else if (isset($_REQUEST["transaction-status"])) {
                $trxid = sanitize_text_field(trim($_REQUEST['ref_cmd']));
                $this->return_status($trxid);

            } else {
                $query_str = sanitize_text_field($_SERVER['QUERY_STRING']);
                $query_str_arr = explode("?", $query_str);
                foreach ($query_str_arr as $value) {
                    $data = explode("=", $value);
                    if (trim($data[0]) == "token") {
                        $token = isset($data[1]) ? trim($data[1]) : "";
                        if ($token <> "") {
                            $this->check_akouendy_response($token);
                        }
                        break;
                    }
                }
            }

            if (version_compare(WOOCOMMERCE_VERSION, '2.0.0', '>=')) {
                add_action('woocommerce_update_options_payment_gateways_' . $this->id, array(&$this, 'process_admin_options'));
            } else {
                add_action('woocommerce_update_options_payment_gateways', array(&$this, 'process_admin_options'));
            }

            add_action( 'woocommerce_api_callback', array( $this, 'callback_handler' ) );
            //add_action( 'woocommerce_api_wc_gateway_paypal', array( $this, 'callback_handler' ) );

            //add_action( 'woocommerce_api_callback', 'callback_handler' );


        }


        function callback_handler() {
            global $woocommerce;
            $id = explode("_",sanitize_text_field($_POST["REF_CMD"]));
            $wc_order_id = $id[0];
            $order = new WC_Order($wc_order_id);

            

            // checking hmac
            $statut = sanitize_text_field($_POST["STATUT"]);
            $str = $this->site_token."|".sanitize_text_field($_POST["REF_CMD"])."|". $statut;
            $hash = hash('sha512', $str);
            if ($hash === sanitize_text_field($_POST["HASH"])) {
                switch ($statut) {
                    case 117:
                        //transaction failed
                        $message = "Transaction failed";
                        $order_status = 'failed';
                        break;
                    case 200:
                        // transaction success
                        $order_status = 'completed';
                        $woocommerce->cart->empty_cart();
                        $message = "Transaction success";
                        break;
                    case 220:
                        // transaction not found
                        $message = "Transaction not found";
                        $order_status = "pending";
                        break;
                    case 375:
                        //OTP expires or is already used or invalid
                        $message = "OTP expires or is already used or invalid";
                        $order_status = 'failed';
                        break;
                    
                }
                if(!empty($order_status)) {
                    $order->add_order_note($message);
                    $order->update_status($order_status);
                    
                }
                
            } 

        }


        function init_form_fields() {
            $this->form_fields = array(
                'enabled' => array(
                    'title' => __('Activer/D&eacute;sactiver', 'akouendy'),
                    'type' => 'checkbox',
                    'label' => __('Activer le module de paiement Orange Money avec AKOUENDY.', 'akouendy'),
                    'default' => 'no'),
                'title' => array(
                    'title' => __('Titre:', 'akouendy'),
                    'type' => 'text',
                    'description' => __('Texte que verra le client lors du paiement de sa commande.', 'akouendy'),
                    'default' => __('Paiement ORANGE MONEY', 'akouendy')),
                'description' => array(
                    'title' => __('Description:', 'akouendy'),
                    'type' => 'textarea',
                    'description' => __('Description que verra le client lors du paiement de sa commande.', 'akouendy'),
                    'default' => __('AKOUENDY est une passerelle de paiement Orange Money en ligne.', 'akouendy')),
                'site_id' => array(
                    'title' => __('Cl&eacute; Priv&eacute; de production', 'akouendy'),
                    'type' => 'text',
                    'description' => __('Cl&eacute; Priv&eacute; de production fournie par AKOUENDY lors de la cr&eacute;ation de votre application.')),
                'site_token' => array(
                    'title' => __('Token de production', 'akouendy'),
                    'type' => 'text',
                    'description' => __('Token de production fourni par AKOUENDY lors de la cr&eacute;ation de votre application.')),
                'sandbox' => array(
                    'title' => __('Activer le mode test', 'akouendy'),
                    'type' => 'checkbox',
                    'description' => __("Cocher cette case si vous &egrave;tes encore à l'etape des paiements tests.", 'akouendy')),

            );
        }

        public function admin_options() {
            echo '<h3>' . __('Passerelle de paiement Orange Money avec AKOUENDY', 'akouendy') . '</h3>';
            echo '<p>' . __('AKOUENDY est une passerelle de paiement pour les achats en ligne au S&eacute;n&eacute;gal.') . '</p>';
            echo '<table class="form-table">';
            // Generate the HTML For the settings form.
            $this->generate_settings_html();
            echo '</table>';
            wp_enqueue_script('akouendy_admin_option_js', plugin_dir_url(__FILE__) . 'assets/js/settings.js', array('jquery'), '1.0.1');
        }

        function payment_fields() {
            if ($this->description)
                echo wpautop(wptexturize($this->description));
        }

        protected function get_akouendy_args($order) {
            global $woocommerce;

            //$order = new WC_Order($order_id);
            $txnid = $order->id . '_' . date("ymds");

            $redirect_url = $woocommerce->cart->get_checkout_url();

            $productinfo = "Commande: " . $order->id;

            $this->merchant_id = $this->site_id;

            $str = "$this->merchant_id|$txnid|".intval($order->order_total)."|akouna_matata";
            $hash = hash('sha512', $str);

            WC()->session->set('akouendy_wc_hash_key', $hash);

            $items = $woocommerce->cart->get_cart();
            $akouendy_items = array();
            foreach ($items as $item) {
                $akouendy_items[] = array(
                    "name" => $item["data"]->post->post_title,
                    "quantity" => $item["quantity"],
                    "unit_price" => $item["line_total"] / (($item["quantity"] == 0) ? 1 : $item["quantity"]),
                    "total_price" => $item["line_total"],
                    "description" => ""
                );
            }

            $total = intval($order->order_total);

            $description = "Achat de ". count($akouendy_items)." article(s) pour un total de #total# sur ". get_bloginfo("name").".";

            $akouendy_args = array(
                    //"items" => $akouendy_items,
                    "total_amount" => intval($order->order_total),
                    "description" => $description,
                    "name" => get_bloginfo("name"),
                    "merchant_id" => $this->merchant_id,
                    //"logo_url" => "",
                    "website_url" => get_site_url(),
                    "cancel_url" => $redirect_url,
                    "return_url" => $redirect_url,
                    "order_id" => $order->id,
                    "trans_id" => $txnid,
                    "items" => json_encode($akouendy_items),
                    "hash" => $hash,
                    "site_name_slug" => sanitize_title(get_bloginfo("name")),
                    "webhook" => get_site_url() . "/wc-api/callback",
                    "sn_ref" => $txnid,
                    "hash_str" => $str

            );


            apply_filters('woocommerce_akouendy_args', $akouendy_args, $order);
            return $akouendy_args;
        }

        function post_to_url($url, $data, $order_id) {
            $master_key = "";
            $private_key = "";
            $token = "";
            if ($this->settings['sandbox'] == "yes") {
                $private_key = $this->test_private_key;
                $token = $this->test_token;
            } else {
                $private_key = $this->live_private_key;
                $token = $this->live_token;
            }

            $args = array(
                'body' => $data,
                'timeout' => '5',
                'redirection' => '5',
                'httpversion' => '1.0',
                'blocking' => true,
                'headers' => array(),
                'cookies' => array()
            );
            $request = wp_remote_post($url,$args);

            if( is_wp_error( $request ) ) {
                error_log('Create payment error: ');
            }
            $response = wp_remote_retrieve_body( $request );
            
            $response_decoded = json_decode($response);
            
            WC()->session->set('akouendy_wc_oder_id', $order_id);

            if ($response_decoded->response_code && $response_decoded->response_code == "00") {
                $order = new WC_Order($order_id);
                $order->add_order_note("AKOUENDY Token: " . $response_decoded->token);
                return $this->checkouturl . $response_decoded->token;
            } else {
                global $woocommerce;
                $url = $woocommerce->cart->get_checkout_url();
                if (strstr($url, "?")) {
                    return $url . "&akouendy=" . $response_decoded->response_text;
                } else {
                    return $url . "?akouendy=" . $response_decoded->response_text;
                }
            }
        }

        function process_payment($order_id) {
            $order = new WC_Order($order_id);
            return array(
                'result' => 'success',
                'redirect' => $this->post_to_url($this->posturl, $this->get_akouendy_args($order), $order_id)
            );
        }

        function showMessage($content) {
            return '<div class="box ' . $this->msg['class'] . '-box">' . $this->msg['message'] . '</div>' . $content;
        }

        function get_pages($title = false, $indent = true) {
            $wp_pages = get_pages('sort_column=menu_order');
            $page_list = array();
            if ($title)
                $page_list[] = $title;
            foreach ($wp_pages as $page) {
                $prefix = '';
                // show indented child pages?
                if ($indent) {
                    $has_parent = $page->post_parent;
                    while ($has_parent) {
                        $prefix .= ' - ';
                        $next_page = get_page($has_parent);
                        $has_parent = $next_page->post_parent;
                    }
                }
                // add to page list array array
                $page_list[$page->ID] = $prefix . $page->post_title;
            }
            return $page_list;
        }

        function check_akouendy_response($mtoken) {
            global $woocommerce;
            if ($mtoken <> "") {
                $wc_order_id = WC()->session->get('akouendy_wc_oder_id');
                $hash = WC()->session->get('akouendy_wc_hash_key');
                $order = new WC_Order($wc_order_id);
                try {
                    $master_key = $this->live_master_key;
                    $private_key = "";
                    $url = $this->geturl . $mtoken;
                    $token = "";
                    if ($this->settings['sandbox'] == "yes") {
                        $private_key = $this->test_private_key;
                        $token = $this->test_token;
                    } else {
                        $private_key = $this->live_private_key;
                        $token = $this->live_token;
                    }

                    $request = wp_remote_get($url);

                    if( is_wp_error( $request ) ) {
                        error_log('Check payment status error: ');
                    }
                    $response = wp_remote_retrieve_body( $request );
                    $response_decoded = json_decode($response);
                    $respond_code = $response_decoded->response_code;
                    if ($respond_code == "00") {
                        //payment found
                        $status = $response_decoded->status;
                        $custom_data = $response_decoded->custom_data;
                        $order_id = $custom_data->order_id;
                        if ($wc_order_id <> $order_id) {
                            $message = "Votre session de transaction a expir&eacute;. Votre num&eacute;ro de commande est: $order_id";
                            $message_type = "notice";
                            $order->add_order_note($message);
                            $redirect_url = $order->get_cancel_order_url();
                        }
                        if ($status == "completed") {
                            //payment was completely processed
                            $total_amount = strip_tags($woocommerce->cart->get_cart_total());
                            $message = "Merci pour votre achat. La transaction a &eacute;t&eacute; un succ&egrave;s, le paiement a &eacute;t&eacute; re&ccedil;u. Votre commande est en cours de traitement. Votre num&eacute;ro de commande est $order_id";
                            $message_type = "success";
                            $order->payment_complete();
                            $order->update_status('completed');
                            $order->add_order_note('Paiement AKOUENDY effectu&eacute; avec succ&egrave;s<br/>ID unique reÃ§u de AKOUENDY: ' . $mtoken);
                            $order->add_order_note($this->msg['message']);
                            $woocommerce->cart->empty_cart();
                            $redirect_url = $this->get_return_url($order);
                            $customer = trim($order->billing_last_name . " " . $order->billing_first_name);
    
                        } else {
                            //payment is still pending, or user cancelled request
                            $message = "La transaction n'a pu &egrave;tre compl&eacute;t&eacute;e.";
                            $message_type = "error";
                            $order->add_order_note("La transaction a &eacute;chou&eacute; ou l'utilisateur a eu &agrave; une faire demande d'annulation de paiement");
                            $redirect_url = $order->get_cancel_order_url();
                        }
                    } else {
                        //payment not found
                        $message = "Merci de nous avoir choisi. Malheureusement, la transaction a &eacute;t&eacute; refus&eacute;e.";
                        $message_type = "error";
                        $redirect_url = $order->get_cancel_order_url();
                    }

                    $notification_message = array(
                        'message' => $message,
                        'message_type' => $message_type
                    );
                    if (version_compare(WOOCOMMERCE_VERSION, "2.2") >= 0) {
                        add_post_meta($wc_order_id, '_akouendy_hash', $hash, true);
                    }
                    update_post_meta($wc_order_id, '_akouendy_wc_message', $notification_message);

                    WC()->session->__unset('akouendy_wc_hash_key');
                    WC()->session->__unset('akouendy_wc_order_id');

                    wp_redirect($redirect_url);
                    exit;
                } catch (Exception $e) {
                    $order->add_order_note('Erreur: ' . $e->getMessage());

                    $redirect_url = $order->get_cancel_order_url();
                    wp_redirect($redirect_url);
                    exit;
                }
            }
        }

        static function add_akouendy_fcfa_currency($currencies) {
            $currencies['FCFA'] = __('BCEAO XOF', 'woocommerce');
            return $currencies;
        }

        static function add_akouendy_fcfa_currency_symbol($currency_symbol, $currency) {
            switch (
            $currency) {
                case 'FCFA': $currency_symbol = 'FCFA';
                    break;
            }
            return $currency_symbol;
        }

        static function woocommerce_add_akouendy_gateway($methods) {
            $methods[] = 'WC_Akouendy';
            return $methods;
        }



        // Add settings link on plugin page
        static function woocommerce_add_akouendy_settings_link($links) {
            $settings_link = '<a href="admin.php?page=wc-settings&tab=checkout&section=wc_akouendy">Param&egrave;tres</a>';
            array_unshift($links, $settings_link);
            return $links;
        }

        function return_status($trxid){
            global $woocommerce;
            $id = explode("_",$trxid);
            $wc_order_id = $id[0];

            $order = new WC_Order($wc_order_id);
            $status = $order->get_status();

            switch ($status) {
                case "pending":

                    //payment is still pending, or user cancelled request
                    $message = "La+transaction+est+en+cours.";
                    $message_type = "success";
                    $redirect_url = $woocommerce->cart->get_checkout_url();
                    $redirect_url .=   "?akouendy-msg= $message";
                    break;

                case "completed":

                    $message = "Merci pour votre achat. La transaction a &eacute;t&eacute; un succÃ¨s, le paiement a &eacute;t&eacute; reÃ§u. Votre commande est en cours de traitement. Votre num&eacute;ro de commande est $wc_order_id";
                    $message_type = "success";
                    $order->payment_complete();
                    $order->update_status('completed');
                    $order->add_order_note('Paiement AKOUENDY effectu&eacute; avec succes<br/>ID de la transaction : ' . $trxid);
                    $order->add_order_note($this->msg['message']);
                    $woocommerce->cart->empty_cart();
                    $redirect_url = $this->get_return_url($order);

                    break;

                default:

                    //payment is still pending, or user cancelled request
                    $message = "La transaction n'a pu &egrave;tre compl&eacute;t&eacute;e.";
                    $message_type = "error";
                    $order->add_order_note("La transaction a &eacute;chou&eacute; ou l'utilisateur a eu &agrave;  faire demande d'annulation de paiement");
                    $redirect_url = $order->get_cancel_order_url();
            }

            $notification_message = array(
                'message' => $message,
                'message_type' => $message_type
            );


            update_post_meta($wc_order_id, '_akouendy_wc_message', $notification_message);
            WC()->session->__unset('akouendy_wc_hash_key');
            WC()->session->__unset('akouendy_wc_order_id');

            wp_redirect($redirect_url);
            exit;

        }

    }

    $plugin = plugin_basename(__FILE__);

    add_filter('woocommerce_currencies', array('WC_Akouendy', 'add_akouendy_fcfa_currency'));
    add_filter('woocommerce_currency_symbol', array('WC_Akouendy', 'add_akouendy_fcfa_currency_symbol'), 10, 2);

    add_filter("plugin_action_links_$plugin", array('WC_Akouendy', 'woocommerce_add_akouendy_settings_link'));
    add_filter('woocommerce_payment_gateways', array('WC_Akouendy', 'woocommerce_add_akouendy_gateway'));
}


