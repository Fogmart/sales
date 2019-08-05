<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
define( 'WoocommerceWeCashup', '2.1' );

class WC_Gateway_WecashUp extends WC_Payment_Gateway {
	public $version;
	protected $data_to_send = array();
	public function __construct() {
		$this->version = WoocommerceWeCashup;
		$this->id = 'wecashup';
		$this->method_title       = __( 'WeCashUp', 'woocommerce-gateway-wecashup' );

		$this->method_description = __( 'Payer via WeCashUp: Vous pouvez utiliser un compte Mobile Money pour payer votre commande', 'woocommerce-gateway-wecashup');
		$this->has_fields = true; // in case you need a custom credit card form
		$this->init_form_fields();
		$this->init_settings();
		$this->title            = $this->get_option( 'title' );
		$this->merchant_id_wcp      = $this->get_option( 'merchant_id_wcp' );
		$this->merchant_key_wcp     = $this->get_option( 'merchant_key_wcp' );
		$this->merchant_secret_wcp     = $this->get_option( 'merchant_secret_wcp' );
		$this->merchant_enabletelecom     = $this->get_option( 'merchant_enabletelecom' );
		$this->merchant_enablecash     = $this->get_option( 'merchant_enablecash' );
		$this->merchant_enablemwallet     = $this->get_option( 'merchant_enablemwallet' );
		$this->description      = $this->get_option( 'description' );
		$this->payment_box_name      = $this->get_option( 'payment_box_name' );
		$this->payment_box_image      = $this->get_option( 'payment_box_image' );
		//$this->merchant_currency_wcp      = $this->get_option( 'merchant_currency_wcp' );
		$this->merchant_splitpayment      = $this->get_option( 'merchant_splitpayment' );
		$this->payment_box_language      = $this->get_option( 'payment_box_language' );

		add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
              add_action( 'wp_footer', array( $this, 'ajaxstop_all_function' ) );
                add_filter( 'woocommerce_before_checkout_form', array( $this, 'remove_cookie_variable' ) );
             // add_action( 'woocommerce_review_order_before_payment', array( $this, 'refresh_payment_methods' ));
              add_action( 'woocommerce_thankyou', array( $this, 'my_custom_tracking') );

	}
         
        
        public function refresh_payment_methods(){
    ?>
<script type="text/javascript">
        var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
</script>
    <script type="text/javascript">
        (function($){
            $( 'form.checkout' ).on( 'change', 'input[name^="payment_method"]', function() {
             let mainh = $(this).val();
             if(mainh != 'wecashup') {
             jQuery.ajax({
                    type: 'post',
                    url: ajaxurl,
                    dataType: "json",
                    data: {action : 'delete_the_cookie', cookval : 'wecash_co_val'},
                   beforeSend: function () {
                        
                    },
                    success: function (response) {
                        console.log(response);
                        if (response.type == "true") {
                           
                         console.log('delete the cookie');
                           
                        }
                    }
                });
             } 
            });
        })(jQuery);
    </script>
   
    <?php
}

	public function my_custom_tracking()
	{ ?>
		<script>
			jQuery(function($) {
				console.log('asdas thanks', $('#wecashup'))
				$('#wecashup').remove()
			})
		</script>
	<?php }



	public function init_form_fields() {
		$currency = get_woocommerce_currency();
		$this->form_fields = array(
			'enabled' => array(
				'title'       => __( 'Enable/Disable', 'woocommerce-gateway-wecashup' ),
				'label'       => __( 'Enable WeCashUp', 'woocommerce-gateway-wecashup' ),
				'type'        => 'checkbox',
				'description' => __( 'This controls whether or not this gateway is enabled within WooCommerce.', 'woocommerce-gateway-wecashup' ),
				'default'     => 'yes',
				'desc_tip'    => true,
			),
			'merchant_id_wcp' => array(
				'title'       => __( 'Merchant UID', 'woocommerce-gateway-wecashup' ),
				'type'        => 'text',
				'description' => __( 'This is the merchant UID, available on the WeCashUp dashboard.', 'woocommerce-gateway-wecashup' ),
				'default'     => '',
			),
			'merchant_key_wcp' => array(
				'title'       => __( 'Merchant Public Key', 'woocommerce-gateway-wecashup' ),
				'type'        => 'text',
				'description' => __( 'This is the merchant public key, available on the WeCashUp dashboard.', 'woocommerce-gateway-wecashup' ),
				'default'     => '',
			),
			'merchant_secret_wcp' => array(
				'title'       => __( 'Merchant Secret Key', 'woocommerce-gateway-wecashup' ),
				'type'        => 'text',
				'description' => __( 'This is the merchant secret key available on the WeCashUp dashboard.', 'woocommerce-gateway-wecashup' ),
				'default'     => '',
			),
			'title' => array(
				'title'       => __( 'Title', 'woocommerce-gateway-wecashup' ),
				'type'        => 'text',
				'description' => __( 'Here you can enter the title that the user will see during checkout.', 'woocommerce-gateway-wecashup' ),
				'default'     => __( 'Pay with Mobile Money.', 'woocommerce-gateway-wecashup' ),
				'desc_tip'    => true,
			),
			'description' => array(
				'title'       => __( 'Description', 'woocommerce-gateway-wecashup' ),
				'type'        => 'text',
				'description' => __( 'Here you can enter the description that the user will see during checkout.', 'woocommerce-gateway-wecashup' ),
				'default'     => 'Pay with your Mobile Money Account, Cash or Cards.',
				'desc_tip'    => true,
			),
			
			/*'merchant_currency_wcp' => array(
				'title'       => __( 'Merchant Currency', 'woocommerce-gateway-wecashup' ),
				'type'        => 'select',
				'description' => __( 'Setup your currency for mobile banking. Leave blank to use woocommerce default currency', 'woocommerce-gateway-wecashup' ),
				'default'     => $currency,
				'options' => array(
						'' => __( 'Select the Currency or your country', 'woocommerce-gateway-wecashup' ),
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
						)
			),*/

			'advanced_pm' => array(
				'title'       => __( 'Payment methods', 'woocommerce-gateway-wecashup' ),
				'type'        => 'title',
				'description' => '',
			),
			'merchant_enablecash' => array(
				'title'       => __( 'Enable Cash Payment method', 'woocommerce-gateway-wecashup' ),
				'type'        => 'select',
				'description' => __( 'Select true/false to enable this method.', 'woocommerce-gateway-wecashup' ),
				'default'     => 'false',
				'options' => array(
					  'true'        => __( 'True', 'woocommerce-gateway-wecashup' ),
					  'false'       => __( 'False', 'woocommerce-gateway-wecashup' )
					)
			),
			'merchant_enabletelecom' => array(
				'title'       => __( 'Enable Mobile Money Payments from Mobile Operators', 'woocommerce-gateway-wecashup' ),
				'type'        => 'select',
				'description' => __( 'Select true/false to enable this method.', 'woocommerce-gateway-wecashup' ),
				'default'     => 'true',
				'options' => array(
					  'true'        => __( 'True', 'woocommerce-gateway-wecashup' ),
					  'false'       => __( 'False', 'woocommerce-gateway-wecashup' )
					)
			),
			'merchant_enablemwallet' => array(
				'title'       => __( 'Enable Mobile Money Payments from Banks', 'woocommerce-gateway-wecashup' ),
				'type'        => 'select',
				'description' => __( 'Select true/false to enable this method.', 'woocommerce-gateway-wecashup' ),
				'default'     => 'false',
				'options' => array(
					  'true'        => __( 'True', 'woocommerce-gateway-wecashup' ),
					  'false'       => __( 'False', 'woocommerce-gateway-wecashup' )
					)
			),
			'merchant_splitpayment' => array(
				'title'       => __( 'Enable the SPLIT PAYMENT feature', 'woocommerce-gateway-wecashup' ),
				'type'        => 'select',
				'description' => __( 'Select true/false to enable this feature.', 'woocommerce-gateway-wecashup' ),
				'default'     => 'false',
				'options' => array(
					  'true'        => __( 'True', 'woocommerce-gateway-wecashup' ),
					  'false'       => __( 'False', 'woocommerce-gateway-wecashup' )
					)
			),
			'advanced_pm_gateway' => array(
				'title'       => __( 'Payment box design options', 'woocommerce-gateway-wecashup' ),
				'type'        => 'title',
				'description' => '',
			),
			'payment_box_name' => array(
				'title'       => __( 'Enter your company\'s name', 'woocommerce-gateway-wecashup' ),
				'type'        => 'text',
				'description' => __( 'This is heading used to display in payment box.', 'woocommerce-gateway-wecashup' ),
				'default'     => '',
			),
			'payment_box_language' => array(
				'title'       => __( 'Define the language of the payment box', 'woocommerce-gateway-wecashup' ),
				'type'        => 'select',
				'description' => __( 'Select a language for payment box or leave it on AUTOMATIC', 'woocommerce-gateway-wecashup' ),
				'default'     => 'en',
				'options' => array(
					  'en'        => __( 'English', 'woocommerce-gateway-wecashup' ),
					  'fr'       => __( 'French', 'woocommerce-gateway-wecashup' ),
					  'auto'       => __( 'Automatic', 'woocommerce-gateway-wecashup' )
					)
			),
			'payment_box_image' => array(
				'title'       => __( 'Enter the URL to your logo (50x50 px recommended)', 'woocommerce-gateway-wecashup' ),
				'type'        => 'text',
				'description' => __( 'Logo use in payment box.', 'woocommerce-gateway-wecashup' ),
				'default'     => 'https://www.wecashup.cloud/cdn/images/logos/WeCashUp-logo-square-white-bg.png',
			)

		);
	}

         public function remove_cookie_variable() {


            unset($_COOKIE['wecash_co_val']);
            setcookie('wecash_co_val', null, -1, '/'); ?>
          <script>
                jQuery(document).ready(function(){
			jQuery("#WCUpaymentButton").hide();

                   });
          </script>

        <?php  }
	
	
			public function ajaxstop_all_function() { ?>

              <script type="text/javascript">
        		jQuery(function($) {
					
					jQuery('body').on('click', '#place_order', function(e) {
						if ( jQuery('input[name="payment_method"]:checked').val() === 'wecashup' ) {
							
							e.preventDefault();
							jQuery( ".woocommerce-NoticeGroup" ).remove();
							jQuery('#WCUpaymentButton').click();
							
						}
					})
                 		
				});
                </script> 
   

          <?php   }


	public function process_payment( $order_id ) {
            global $wpdb, $woocommerce;
             $order = wc_get_order( $order_id );
               $user = wp_get_current_user();
                $productitems = $order->get_items();
                $count = 0;
                $argu = array();

                foreach ( $productitems as $item ) {
                $product_name = $item->get_name();
                $product_id = $item->get_product_id();
                $product_variation_id = $item->get_variation_id();
                $quantity = $item->get_quantity();
                $total = $item->get_total();
                 if ($product_variation_id) {
                $product = new WC_Product($product_variation_id);
                } else {
                 $product = new WC_Product($product_id);
                }
                $term_list = wp_get_post_terms($product_id,'product_cat',array('fields'=>'ids'));
                $cat_id = (int)$term_list[0];
                $sku = $product->get_sku();
                $description = $product->get_description();
                $argu[$product_id] = array("data-product-".$count."-name" => $product_name,
                                            "data-product-".$count."-quantity" => $quantity,
                                            "data-product-".$count."-unit-price" => $total,
                                            "data-product-".$count."-reference" => $sku,
                                            "data-product-".$count."-category" => $cat_id,
                                            "data-product-".$count."-description" => $description,
                                            );

                $count++;}

             update_option('data-product'.$user->ID, $argu);
            $return['result'] = "success";
            $return['messages'] = "";
            $return['custom'] = "wecashup";
//             if($return['custom'] == "wecashup") {
//            $cookie_name = "wecash_co_val";
//            $cookie_value = "wecashup_success";
//            setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
//             }
           echo json_encode($return);   wp_die();
	}

        public function theFxn($v, $k) { return sprintf('%s="%s"', $k, $v); }


        public function payment_fields() {
$lang = get_bloginfo("language"); 

            if ($lang == 'fr-FR') {
                echo wpautop( wp_kses_post( $this->method_description ) );
            } elseif ( $this->payment_box_language == 'fr') {
			echo wpautop( wp_kses_post( $this->method_description ) );
		} else {
                    echo wpautop( wp_kses_post( $this->description ) );
                }


        
		$user = wp_get_current_user();
                global $woocommerce;
                $merchant_currency_wcp = get_woocommerce_currency();
		$p = $woocommerce->cart->total;
                $data_product  = get_option('data-product'.$user->ID);
                $count =0;
                $adr = array();
				if (is_array($data_product) || is_object($data_product))
		{
                foreach($data_product as $val) {
                 $adr[] = array('data-product-'.$count.'-name' => $val['data-product-'.$count.'-name'],
                               'data-product-'.$count.'-quantity' => $val['data-product-'.$count.'-quantity'],
                               'data-product-'.$count.'-unit-price' => $val['data-product-'.$count.'-unit-price'],
                               'data-product-'.$count.'-reference' => $val['data-product-'.$count.'-reference'],
                               'data-product-'.$count.'-category' => $val['data-product-'.$count.'-category'],
                               'data-product-'.$count.'-description' => $val['data-product-'.$count.'-description'],
                   );
                    
               $count++; }
			}
//                        echo 'here';
              $lo = array_reduce( $adr, 'array_merge', array() );
              //echo 'and here';
              $output = implode(' ', array_map(array($this, 'theFxn'),
                        $lo,
                        array_keys($lo)
                        ));
               
		$total = max( 0, apply_filters( 'woocommerce_calculated_total', round($p), WC()->cart ) );
				if ( $user ) {
					$user_email = get_user_meta( $user->ID, 'billing_email', true );
					$user_phone1 = get_user_meta( $user->ID, 'billing_phone', true );
					$user_phone = preg_replace('/[\\x0-\x20\x7f]/', '', $user_phone1);

					$fname = get_user_meta( $user->ID, 'billing_first_name', true );
					$lname = get_user_meta( $user->ID, 'billing_last_name', true );
					$billing_pcode = get_user_meta( $user->ID, 'billing_postcode', true );
					$shiping_pcode = get_user_meta( $user->ID, 'shipping_postcode', true );
					$billing_country = get_user_meta( $user->ID, 'billing_country', true );
					$shipping_country = get_user_meta( $user->ID, 'billing_country', true );
					$billing_city = get_user_meta( $user->ID, 'billing_city', true );
					$shipping_city = get_user_meta( $user->ID, 'shipping_city', true );
					$user_email = $user_email ? $user_email : $user->user_email;
				} else {
					$user_email=$user_phone=$fname=$lname=$billing_pcode=$shiping_pcode=$billing_country=$shipping_country=$billing_city=$shipping_city='';
					
				}

		/* Coupon de reduction START */

		add_action('woocommerce_applied_coupon', 'apply_product_on_coupon');
		$coupons = $this->applied_coupons;
		echo $coupons;

		/* END */

		$call_url = admin_url('admin-ajax.php?action=callback_url');
		$js_url =	plugin_dir_url( __FILE__ ).'utils.js';
		$js_url_phn =	plugin_dir_url( __FILE__ ).'intlTelInput.min.js';
		if ("on"==$_SERVER['HTTPS']):
			$call_url = str_replace("http://","https://",$call_url);
		endif;
			
			echo '<form action="' . $call_url . '" method="POST" id="wecashup"><script async src="https://www.wecashup.com/library/MobileMoney.js" class="wecashup_button" data-demo data-transaction-method="pull" data-marketplace-mode="false" configuration-id="3" data-receiver-uid="' . esc_attr( $this->merchant_id_wcp ) . '" data-receiver-public-key="' . esc_attr( $this->merchant_key_wcp ) . '" data-transaction-receiver-total-amount="'.$total.'" data-transaction-receiver-currency="' . esc_attr( $merchant_currency_wcp ) . '" data-name="' . esc_attr( $this->payment_box_name ) . '" data-transaction-receiver-reference="'.$order_id.'" data-transaction-sender-reference="' . esc_attr( $user_email ) . '" data-style="1" data-image="' . esc_attr( $this->payment_box_image ) . '" data-cash="' . esc_attr( $this->merchant_enablecash ) . '" data-telecom="' . esc_attr( $this->merchant_enabletelecom ) . '" data-m-wallet="' . esc_attr( $this->merchant_enablemwallet ) . '" data-split="' . esc_attr( $this->merchant_splitpayment ) . '" data-sender-lang="' . esc_attr( $this->payment_box_language ) . '"  data-sender-phonenumber="' . esc_attr( $user_phone ) .'" data-sender-firstname="' . esc_attr( $fname ) . '" data-sender-lastname="' . esc_attr( $lname ) . '" data-sender-email="' . esc_attr( $user_email ) . '" data-sender-shipping-country-code-iso2="'. esc_attr($shipping_country ) .'" data-sender-shipping-town="'. esc_attr($shipping_city ) .'" data-sender-shipping-postcode="'. esc_attr($shiping_pcode ) .'" data-sender-billing-country-code-iso2="' . esc_attr( $billing_country ) . '" data-sender-billing-town="' . esc_attr( $billing_city ).'" data-sender-billing-postcode="'. esc_attr($billing_pcode) .'" '.$output.'> 
       </script></form>';

	   echo '<script type="text/javascript" src="' . esc_attr( $js_url_phn ) . '"></script>
	   <script>jQuery(document).ready(function($){

		   jQuery("#billing_first_name").change(function(){
			  var billfname = jQuery(this).val();
			  jQuery(".wecashup_button").attr("data-sender-firstname",billfname);
		   });
		   jQuery("#billing_last_name").change(function(){
			  var billlname = jQuery(this).val();
			  jQuery(".wecashup_button").attr("data-sender-lastname",billlname);
		   });

		   jQuery("#billing_email").change(function(){
			  var billemail = jQuery(this).val();
			  jQuery(".wecashup_button").attr("data-sender-email",billemail);
		   });
		    jQuery("#billing_postcode").change(function(){
			  var billpcode = jQuery(this).val();
			  jQuery(".wecashup_button").attr("data-sender-billing-postcode",billpcode);
		   });

		    jQuery("#billing_city").change(function(){
			  var billtwn = jQuery(this).val();
			  jQuery(".wecashup_button").attr("data-sender-billing-town",billtwn);
		   });

		    jQuery("#billing_country").change(function(){
			  var billctry = jQuery(this).val();
			  jQuery(".wecashup_button").attr("data-sender-billing-country-code-iso2",billctry);
		   });

		 

                    var telInput = jQuery("#billing_phone");

					telInput.intlTelInput({
						utilsScript: "' . esc_attr( $js_url ) . '",
						nationalMode: false,
						});

				var reset = function() {
					telInput.removeClass("error_inter");
				};

				telInput.blur(function() {
				reset();
				if (jQuery.trim(telInput.val())) {
				if (telInput.intlTelInput("isValidNumber")) {
					telInput.removeClass("error_inter");
					var billphn = telInput.val();
					jQuery(".wecashup_button").attr("data-sender-phonenumber",billphn);

					} else {
					telInput.addClass("error_inter");
					jQuery(".wecashup_button").attr("data-sender-phonenumber","");


				}
				}
			});


				telInput.on("keyup change", reset);

		   });


		   </script><style>#WCUpaymentButton{font-size: 1.25em; float: right;margin-top: -18px; display: none;}</style>';


}
}
?>
