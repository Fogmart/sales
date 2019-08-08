<?php
include get_template_directory().'/vendor/autoload.php';
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

            $this->supports = array(
                'products'
            );

            $this->has_fields = true;
            $this->init_form_fields();
            // Load the settings.
            $this->init_settings();
            $this->title = $this->get_option('title');
            $this->description = $this->get_option('description');
            $this->enabled = $this->get_option('enabled');

            $this->auth_header = $this->get_option('auth_header');
            $this->merchant_key = $this->get_option('merchant_key');

            add_action('woocommerce_update_options_payment_gateways_' . $this->id, array($this, 'process_admin_options'));
            add_action('woocommerce_thankyou_' . $this->id, array($this, 'capture_payment'));
            add_action('woocommerce_order_status_completed', array($this, 'capture_payment'));
            add_action('woocommerce_order_status_completed', array($this, 'capture_payment'));

            // You can also register a webhook here
            add_action('woocommerce_api_wc_orange_pay_hook', array($this, 'webhook'));
        }

        /**
         * Plugin options, we deal with it in Step 3 too
         */
        public function init_form_fields()
        {

            $this->form_fields = array(
                'enabled' => array(
                    'title'       => 'Enable/Disable',
                    'label'       => 'Enable Orange Payment Method',
                    'type'        => 'checkbox',
                    'description' => '',
                    'default'     => 'no'
                ),
                'title' => array(
                    'title'       => 'Title',
                    'type'        => 'text',
                    'description' => 'This text users will see on payment page.',
                    'default'     => 'Orange Web Payment',
                    'desc_tip'    => true,
                ),
                'description' => array(
                    'title'       => 'Description',
                    'type'        => 'textarea',
                    'description' => 'This controls the description which the user sees during checkout.',
                    'default'     => 'Pay online with Orange Web Payment.',
                ),
                'auth_header' => array(
                    'title'       => 'Authorization header',
                    'type'        => 'text',
                    'description' => 'Required field from payment API. In should be provided in your account.',
                    'default'     => '',
                ),
                'merchant_key' => array(
                    'title'       => 'Merchant Key',
                    'type'        => 'text',
                    'description' => 'Required field from payment API. In should be provided in your account.',
                    'default'     => '',
                ),
            );
        }

        /*
		 * We're processing the payments here, everything about it is in Step 5
		 */
        public function process_payment($order_id)
        {
            // we need it to get any order detailes
            $order = wc_get_order($order_id);
            $order_amount = $order->get_total();

            $opt = [
                "merchant_key" => $this->get_option('merchant_key'),
                "currency" => 'OUV', //"GNF",
                "order_id" => $order_id.'_pay',
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

            exit(var_dump($rep));

            $pay_token = $rep['pay_token'] ?? null;

            if ($pay_token) {
                update_option('pay_token_'.$order_id, $pay_token);
                update_option('payment_url_'.$order_id, $rep['payment_url']);

                $this->capture_payment($order_id);
            }

            // Redirect to the thank you page
            return array(
                'result' => 'success',
                'redirect' => $this->get_return_url($order)
            );
        }

        /**
         * Capture payment when the order is changed from on-hold to complete or processing
         *
         * @param  int $order_id Order ID.
         */
        public function capture_payment($order_id)
        {
            $pay_token = get_option('pay_token_'.$order_id);

            if (empty($pay_token)) {
                return;
            }

            $order = wc_get_order($order_id);
            if ($order->has_status(['processing', 'completed'])) {
                delete_option('pay_token_'.$order_id);
                delete_option('payment_url_'.$order_id);

                WC()->session->set('order_id', $order_id);

                wp_redirect(SS_THANKYOU_PAGE);
            }

            $order_amount = $order->get_total();

            putenv('AUTH_HEADER=' . $this->get_option('auth_header'));
            putenv('MERCHANT_KEY=' . $this->get_option('merchant_key'));
            putenv('RETURN_URL=' . $this->get_return_url($order));
            putenv('CANCEL_URL=' . $this->get_return_url($order));
            putenv('NOTIF_URL=' . $this->get_return_url($order));

            $om = new OmSdk();

            $rep = $om->checkTransactionStatus($order_id.'_pay', $order_amount, $pay_token);
            $order->add_order_note(
                print_r($rep, true)
            );
            switch ($rep['status']) {
                case "INITIATED":
                    $payment_url = get_option('payment_url_'.$order_id);
                    wp_redirect($payment_url);
                    exit;
                    break;
                case "PENDING":

                    break;
                case "EXPIRED":
                    delete_option('pay_token_'.$order_id);
                    delete_option('payment_url_'.$order_id);

                    break;
                case "SUCCESS":
                    // we received the payment
                    $order->payment_complete();
                    wc_reduce_stock_levels($order);
                    // Empty cart
                    WC()->cart->empty_cart();
                    delete_option('pay_token_'.$order_id);
                    delete_option('payment_url_'.$order_id);

                    WC()->session->set('order_id', $order_id);

                    wp_redirect(SS_THANKYOU_PAGE);
                    exit;
                    break;
                case "FAILED":
                    delete_option('pay_token_'.$order_id);
                    delete_option('payment_url_'.$order_id);

                    break;
            }
        }

        /*
		 * In case you need a webhook, like PayPal IPN etc
		 */
        public function webhook()
        { }
    }
}
