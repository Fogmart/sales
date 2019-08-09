<?php
include get_template_directory() . '/vendor/autoload.php';

use Foris\OmSdk\OmSdk;

//Adding Orange to Woocommerce Gateways
add_filter('woocommerce_payment_gateways', 'orange_add_gateway_class');
function orange_add_gateway_class($gateways)
{
    $gateways[] = 'WC_Orange_Gateway';

    return $gateways;
}

add_action('init', 'orange_init_gateway_class');
function orange_init_gateway_class()
{
    class WC_Orange_Gateway extends WC_Payment_Gateway
    {

        public function __construct()
        {

            $this->id = 'orange_pay'; // payment gateway plugin ID
            // $this->icon = ''; // URL of the icon that will be displayed on checkout page near your gateway name
            // $this->has_fields = true; // in case you need a custom credit card form
            $this->method_title = 'Orange Pay';
            $this->method_description = __('Orange Web Money payment method'); // will be displayed on the options page

            $this->supports = [
                'products'
            ];

            $this->has_fields = true;
            $this->init_form_fields();
            // Load the settings.
            $this->init_settings();
            $this->title = $this->get_option('title');
            $this->description = $this->get_option('description');
            $this->enabled = $this->get_option('enabled');

            $this->auth_header = $this->get_option('auth_header');
            $this->merchant_key = $this->get_option('merchant_key');

            add_action('woocommerce_update_options_payment_gateways_' . $this->id, [$this, 'process_admin_options']);
            add_action('get_header', [$this, 'processing_after_payment']);

            // You can also register a webhook here
            add_action('woocommerce_api_wc_orange_pay_hook', [$this, 'webhook']);
        }

        /**
         * Plugin options, we deal with it in Step 3 too
         */
        public function init_form_fields()
        {

            $this->form_fields = [
                'enabled' => [
                    'title' => 'Enable/Disable',
                    'label' => 'Enable Orange Payment Method',
                    'type' => 'checkbox',
                    'description' => '',
                    'default' => 'no'
                ],
                'title' => [
                    'title' => 'Title',
                    'type' => 'text',
                    'description' => 'This text users will see on payment page.',
                    'default' => 'Orange Web Payment',
                    'desc_tip' => true,
                ],
                'description' => [
                    'title' => 'Description',
                    'type' => 'textarea',
                    'description' => 'This controls the description which the user sees during checkout.',
                    'default' => 'Pay online with Orange Web Payment.',
                ],
                'auth_header' => [
                    'title' => 'Authorization header',
                    'type' => 'text',
                    'description' => 'Required field from payment API. In should be provided in your account.',
                    'default' => '',
                ],
                'merchant_key' => [
                    'title' => 'Merchant Key',
                    'type' => 'text',
                    'description' => 'Required field from payment API. In should be provided in your account.',
                    'default' => '',
                ],
            ];
        }

        /*
		 * We're processing the payments here, everything about it is in Step 5
		 */
        public function process_payment($order_id)
        {
            // we need it to get any order detailes
            $order = wc_get_order($order_id);
            $order_amount = $order->get_total();
            $pay_order = rand(100000, 900000) . '_pay_' . $order_id;

            $opt = [
                "merchant_key" => $this->get_option('merchant_key'),
                "currency" => 'OUV', //"GNF",
                "order_id" => $pay_order,
                "amount" => $order_amount,
                "return_url" => $this->get_return_url($order),
                "cancel_url" => $this->get_return_url($order),
                "notif_url" => $this->get_return_url($order),
                "lang" => "en"
            ];
            putenv('AUTH_HEADER=' . $this->get_option('auth_header'));
            putenv('MERCHANT_KEY=' . $opt['merchant_key']);
            putenv('RETURN_URL=' . $opt['return_url']);
            putenv('CANCEL_URL=' . $opt['cancel_url']);
            putenv('NOTIF_URL=' . $opt['notif_url']);

            $om = new OmSdk();
            $rep = $om->webPayment($opt);

            $pay_token = $rep['pay_token'] ?? null;

            if ($pay_token) {
                update_option('pay_token_' . $order_id, $pay_token);
                update_option('payment_url_' . $order_id, $rep['payment_url']);
                update_option('pay_order_' . $order_id, $pay_order);

                $this->capture_payment($order_id);
            }

            // Redirect to the thank you page
            return [
                'result' => 'success',
                'redirect' => $this->get_return_url($order)
            ];
        }

        /**
         * Capture payment when the order is changed from on-hold to complete or processing
         *
         * @param int $order_id Order ID.
         */
        public function capture_payment($order_id)
        {
            $pay_token = get_option('pay_token_' . $order_id);

            if (empty($pay_token)) {
                return;
            }

            $order = wc_get_order($order_id);
            if ($order->has_status(['processing', 'completed'])) {
                delete_option('pay_token_' . $order_id);
                delete_option('payment_url_' . $order_id);
                delete_option('pay_order_' . $order_id);

                unset(WC()->session->pay_order_id);
                WC()->session->set('order_id', $order_id);

                wp_redirect(SS_THANKYOU_PAGE);
            }

            $order_amount = $order->get_total();
            $pay_order = get_option('pay_order_' . $order_id);

            putenv('AUTH_HEADER=' . $this->get_option('auth_header'));
            putenv('MERCHANT_KEY=' . $this->get_option('merchant_key'));
            putenv('RETURN_URL=' . $this->get_return_url($order));
            putenv('CANCEL_URL=' . $this->get_return_url($order));
            putenv('NOTIF_URL=' . $this->get_return_url($order));

            $om = new OmSdk();

            $rep = $om->checkTransactionStatus($pay_order, $order_amount, $pay_token);
            $order->add_order_note(
                print_r($rep, true)
            );
            switch ($rep['status']) {
                case "INITIATED":
                    $payment_url = get_option('payment_url_' . $order_id);
                    wp_redirect($payment_url);
                    exit;
                    break;
                case "PENDING":

                    break;
                case "SUCCESS":
                    // we received the payment
                    $order->payment_complete();
                    wc_reduce_stock_levels($order);

                    // Empty Cart
                    WC()->cart->empty_cart();

                    delete_option('pay_token_' . $order_id);
                    delete_option('payment_url_' . $order_id);
                    delete_option('pay_order_' . $order_id);

                    unset(WC()->session->pay_order_id);
                    WC()->session->set('order_id', $order_id);

                    wp_redirect(SS_THANKYOU_PAGE);
                    exit;
                    break;
                case "FAILED":
                case "EXPIRED":
                    $order->set_status('wc-failed');
                    $order->save();
                    // Empty Cart
                    WC()->cart->empty_cart();

                    unset(WC()->session->pay_order_id);
                    delete_option('pay_token_' . $order_id);
                    delete_option('payment_url_' . $order_id);
                    delete_option('pay_order_' . $order_id);
                    ss_return_home();

                    break;
            }
        }

        /**
         * Order processing after payment
         */
        function processing_after_payment()
        {
            global $wp;

            $order_id = WC()->session->get('pay_order_id');

            if ($order_id > 0) {
                $this->capture_payment($order_id);

                return;
            }

            if (!empty($wp->query_vars['order-received'])) {

                $order_id = absint($wp->query_vars['order-received']);

                if ($order_id > 0) {
                    $this->capture_payment($order_id);
                }
            }
        }

        /*
		 * In case you need a webhook, like PayPal IPN etc
		 */
        public function webhook()
        {
        }
    }
}
