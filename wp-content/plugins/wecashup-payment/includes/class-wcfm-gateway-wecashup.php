<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
define( 'WoocommerceWeCashup', '2.1' );

class WCFMmp_Gateway_WecashUp{ 
	public $version;
	protected $data_to_send = array();
	public function __construct() {
		$this->version = WoocommerceWeCashup;
		$this->id = 'WecashUp_wcfm';
		$this->gateway_title = __('WecashUp', 'woocommerce-gateway-wecashup');
		$this->payment_gateway = $this->id;
        add_action( 'woocommerce_review_order_after_submit', array( $this, 'payment_fields' ) );
       }
	   
	   
	public function process_payment( $withdrawal_id, $vendor_id, $withdraw_amount, $withdraw_charges, $transaction_mode = 'auto' ) {
               global $WCFM, $WCFMmp;
                $this->withdrawal_id = $withdrawal_id;
                $this->vendor_id = $vendor_id;
                $this->withdraw_amount = $withdraw_amount;
                //$this->currency = isset( $WCFMmp->wcfmmp_withdrawal_options[$this->id.'merchant_currency_wcp'] ) ? $WCFMmp->wcfmmp_withdrawal_options[$this->id.'merchant_currency_wcp'] : '';
                $this->merchant_id_wcp = isset( $WCFMmp->wcfmmp_withdrawal_options[$this->id.'merchant_id_wcp'] ) ? $WCFMmp->wcfmmp_withdrawal_options[$this->id.'merchant_id_wcp'] : '';
                $this->merchant_key_wcp = isset( $WCFMmp->wcfmmp_withdrawal_options[$this->id.'merchant_key_wcp'] ) ? $WCFMmp->wcfmmp_withdrawal_options[$this->id.'merchant_key_wcp'] : '';
                $this->merchant_secret_wcp = isset( $WCFMmp->wcfmmp_withdrawal_options[$this->id.'merchant_secret_wcp'] ) ? $WCFMmp->wcfmmp_withdrawal_options[$this->id.'merchant_secret_wcp'] : '';
                $this->merchant_enablecash = isset( $WCFMmp->wcfmmp_withdrawal_options[$this->id.'merchant_enablecash'] ) ? $WCFMmp->wcfmmp_withdrawal_options[$this->id.'merchant_enablecash'] : '';
                $this->merchant_enabletelecom = isset( $WCFMmp->wcfmmp_withdrawal_options[$this->id.'merchant_enabletelecom'] ) ? $WCFMmp->wcfmmp_withdrawal_options[$this->id.'merchant_enabletelecom'] : '';
                $this->merchant_enablemwallet = isset( $WCFMmp->wcfmmp_withdrawal_options[$this->id.'merchant_enablemwallet'] ) ? $WCFMmp->wcfmmp_withdrawal_options[$this->id.'merchant_enablemwallet'] : '';
                $this->merchant_splitpayment = isset( $WCFMmp->wcfmmp_withdrawal_options[$this->id.'merchant_splitpayment'] ) ? $WCFMmp->wcfmmp_withdrawal_options[$this->id.'merchant_splitpayment'] : '';
                $this->payment_box_name = isset( $WCFMmp->wcfmmp_withdrawal_options[$this->id.'payment_box_name'] ) ? $WCFMmp->wcfmmp_withdrawal_options[$this->id.'payment_box_name'] : '';
                $this->payment_box_image = isset( $WCFMmp->wcfmmp_withdrawal_options[$this->id.'payment_box_image'] ) ? $WCFMmp->wcfmmp_withdrawal_options[$this->id.'payment_box_image'] : '';
                

			if ( $this->validate_request() ) {
				$WCFMmp->wcfmmp_withdraw->wcfmmp_update_withdrawal_meta( $this->withdrawal_id, 'withdraw_amount', $this->withdraw_amount );
                $WCFMmp->wcfmmp_withdraw->wcfmmp_update_withdrawal_meta( $this->vendor_id, 'enabled', $this->enabled );
                $WCFMmp->wcfmmp_withdraw->wcfmmp_update_withdrawal_meta( $this->vendor_id, 'merchant_id_wcp', $this->merchant_id_wcp );
                $WCFMmp->wcfmmp_withdraw->wcfmmp_update_withdrawal_meta( $this->vendor_id, 'merchant_key_wcp', $this->merchant_key_wcp );
                $WCFMmp->wcfmmp_withdraw->wcfmmp_update_withdrawal_meta( $this->vendor_id, 'merchant_secret_wcp', $this->merchant_secret_wcp );
                $WCFMmp->wcfmmp_withdraw->wcfmmp_update_withdrawal_meta( $this->vendor_id, 'merchant_enablecash', $this->currency );
                $WCFMmp->wcfmmp_withdraw->wcfmmp_update_withdrawal_meta( $this->vendor_id, 'merchant_enabletelecom', $this->currency );
                $WCFMmp->wcfmmp_withdraw->wcfmmp_update_withdrawal_meta( $this->vendor_id, 'merchant_enablemwallet', $this->currency );
                $WCFMmp->wcfmmp_withdraw->wcfmmp_update_withdrawal_meta( $this->vendor_id, 'merchant_splitpayment', $this->currency );
                $WCFMmp->wcfmmp_withdraw->wcfmmp_update_withdrawal_meta( $this->vendor_id, 'payment_box_name', $this->currency );
                $WCFMmp->wcfmmp_withdraw->wcfmmp_update_withdrawal_meta( $this->vendor_id, 'payment_box_image', $this->currency );
					return array( 'status' => true, 'message' => __('New transaction has been initiated', 'wc-multivendor-marketplace') );
				} else {
						return $this->message;
					}
		}
		
		public function validate_request() {    
                    global $WCFMmp;
                    return true;
        }
        
                    
		public function payment_fields() {
			$user = wp_get_current_user();
                        $role = $user->roles;
                        if ($role[0] == 'wcfm_vendor') :
			global $woocommerce;
			$p = $woocommerce->cart->total;
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

                $vendor_data = get_user_meta( $user->ID, 'wcfmmp_profile_settings', true );
                 $merchant_currency_wcp = get_option('woocommerce_currency');
                   $merchant_id_wcp =  $vendor_data['payment']['wecashup']['merchant_id_wcp'];
                   $merchant_key_wcp =  $vendor_data['payment']['wecashup']['merchant_key_wcp'];
                   $merchant_secret_wcp =  $vendor_data['payment']['wecashup']['merchant_secret_wcp'];
                   //$merchant_currency_wcp =  $vendor_data['payment']['wecashup']['merchant_currency_wcp'];
                   $merchant_enablecash =  $vendor_data['payment']['wecashup']['merchant_enablecash'];
                   $merchant_enabletelecom =  $vendor_data['payment']['wecashup']['merchant_enabletelecom'];
                   $merchant_enablemwallet =  $vendor_data['payment']['wecashup']['merchant_enablemwallet'];
                   $merchant_splitpayment =  $vendor_data['payment']['wecashup']['merchant_splitpayment'];
                   $payment_box_name =  $vendor_data['payment']['wecashup']['payment_box_name'];
                   $payment_box_language =  $vendor_data['payment']['wecashup']['payment_box_language'];
                   $payment_box_image =  $vendor_data['payment']['wecashup']['payment_box_image'];

		$call_url = admin_url('admin-ajax.php?action=callback_url_vendor');
		$js_url =	plugin_dir_url( __FILE__ ).'utils.js'; 
		$js_url_phn =	plugin_dir_url( __FILE__ ).'intlTelInput.min.js'; 
		if ("on"==$_SERVER['HTTPS']):
			$call_url = str_replace("http://","https://",$call_url);
		endif;
			
		echo '<form action="' . $call_url . '" method="POST" id="wecashup"><script async src="https://www.wecashup.com/library/MobileMoney.js" class="wecashup_button" data-demo data-transaction-method="pull" data-marketplace-mode="false" configuration-id="3" data-receiver-uid="' . esc_attr( $merchant_id_wcp ) . '" data-receiver-public-key="' . esc_attr( $merchant_key_wcp ) . '" data-transaction-receiver-total-amount="'.$total.'" data-transaction-receiver-currency="' . esc_attr( $merchant_currency_wcp ) . '" data-name="' . esc_attr( $payment_box_name ) . '" data-transaction-receiver-reference="'.$order_id.'" data-transaction-sender-reference="' . esc_attr( $user_email ) . '" data-style="1" data-image="' . esc_attr( $payment_box_image ) . '" data-cash="' . esc_attr( $merchant_enablecash ) . '" data-telecom="' . esc_attr( $merchant_enabletelecom ) . '" data-m-wallet="' . esc_attr( $merchant_enablemwallet ) . '" data-split="' . esc_attr( $merchant_splitpayment ) . '" data-sender-lang="' . esc_attr( $payment_box_language ) . '"  data-sender-phonenumber="' . esc_attr( $user_phone ) .'" data-sender-firstname="' . esc_attr( $fname ) . '" data-sender-lastname="' . esc_attr( $lname ) . '" data-sender-email="' . esc_attr( $user_email ) . '" data-sender-shipping-country-code-iso2="'. esc_attr($shipping_country ) .'" data-sender-shipping-town="'. esc_attr($shipping_city ) .'" data-sender-shipping-postcode="'. esc_attr($shiping_pcode ) .'" data-sender-billing-country-code-iso2="' . esc_attr( $billing_country ) . '" data-sender-billing-town="' . esc_attr( $billing_city ).'" data-sender-billing-postcode="'. esc_attr($billing_pcode) .'"> 
       </script></form>';
	   
	   echo '<script type="text/javascript" src="' . esc_attr( $js_url_phn ) . '"></script>
	   <script>jQuery(document).ready(function($){
		   if(jQuery("input[name=payment_method]").val() == "wecashup"){
			    jQuery("#place_order").hide();
				jQuery("#WCUpaymentButton").show();
		   } else{
			    jQuery("#place_order").show();
				jQuery("#WCUpaymentButton").hide();
		   }
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
		   
		  	jQuery("input[name=payment_method]").click(function(){
			   if(jQuery(this).val()== "wecashup"){
				  jQuery("#place_order").hide();
				  jQuery("#WCUpaymentButton").show();
			   }else{
				    jQuery("#place_order").show();
					jQuery("#WCUpaymentButton").hide();
			   }
			   
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
		   
		   
		   
		   </script><style>#WCUpaymentButton{width:100%;font-size:1.25em;}</style>';
           endif;
	}
}
