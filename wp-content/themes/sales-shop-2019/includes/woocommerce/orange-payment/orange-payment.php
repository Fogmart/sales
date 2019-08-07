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
            global $woocommerce;

            // we need it to get any order detailes
            $order = wc_get_order($order_id);
            $order_amount = $order->get_total();

            $om = new OmSdk();
            $opt = [
                "merchant_key" => $this->get_option('merchant_key'),
                "currency" => "GNF",
                "order_id" => $order_id,
                "amount" => $order_amount,
                "return_url" => $this->get_return_url($order),
                "cancel_url" => $this->get_return_url($order),
                "notif_url" => $this->get_return_url($order),
                "lang" => "en"
            ];

            // header('WWW-Authenticate:  Basic NHROR3Ywek5Kak13Z3hpUXpxZlk2T2daR0h0MHBaSDM6Z0FDRFl3YTFkemNMSUdwbg==');

            $rep = $om->webPayment($opt);

            $pay_token = $rep['pay_token'] ?? null;

            if ($pay_token) {
                $rep = $om->checkTransactionStatus($order_id, $order_amount, $pay_token);
                switch ($rep['status']) {
                    case "INITIATED":

                        break;
                    case "PENDING":

                        break;
                    case "EXPIRED":

                        break;
                    case "SUCCESS":
                        // we received the payment
                        $order->payment_complete();
                        $order->reduce_order_stock();
                        // Empty cart
                        $woocommerce->cart->empty_cart();
                        break;
                    case "FAILED":

                        break;
                }
            }

            // Redirect to the thank you page
            return array(
                'result' => 'success',
                'redirect' => $this->get_return_url($order)
            );
        }

        /*
		 * In case you need a webhook, like PayPal IPN etc
		 */
        public function webhook()
        { }
    }
}
