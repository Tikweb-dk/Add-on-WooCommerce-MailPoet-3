<?php
/**
 * Run actions after place order
 * @since      1.0.0
 * @package    Add-on WooCommerce MailPoet 3
 * @subpackage add-on-woocommerce-mailpoet/includes
 * @author     Tikweb <kasper@tikjob.dk>
 */

use MailPoet\Models\Subscriber;

if(!class_exists('MPWA_Place_Order')){
	class MPWA_Place_Order
	{
		//Helper trait
		use MPWA_Helper_Function;

		/**
		 * Get user information and subscribe
		 */
		public static function subscribe_user()
		{
			//Form Data
			$posted_data = $_POST;

			//If Multi-Subscription enable
			if(isset($posted_data['mailpoet_multi_subscription'])){

				$list_id_array = $posted_data['mailpoet_multi_subscription'];
				self::save_subscriber_record($list_id_array, $posted_data);

			}elseif(isset($posted_data['mailpoet_checkout_subscribe']) && !empty($posted_data['mailpoet_checkout_subscribe'])){
				
				$list_id_array = get_option('wc_mailpoet_segment_list');	
				self::save_subscriber_record($list_id_array, $posted_data);

			}//End if

			// If unsubscribe requested.
			if ( isset($posted_data['gdpr_unsubscribe']) && $posted_data['gdpr_unsubscribe'] == 'on' ){

				self::unsubscribe_user( $posted_data );

			} //End if

		}//End of subscribe_user

		/**
		 * Save subscriber record
		 */
		public static function save_subscriber_record($list_id_array = '', $posted_data)
		{
			//List id array must not be empty
			if(is_array($list_id_array) && !empty($list_id_array)){

				$subscribe_data = array(
					'email'     => $posted_data['billing_email'],
					'first_name' => $posted_data['billing_first_name'],
					'last_name'  => $posted_data['billing_last_name'],
					'segments' => $list_id_array
				);

				//Get `Enable Double Opt-in` value
				$double_optin = get_option('wc_mailpoet_double_optin'); 

				if($double_optin == 'yes'){ //If Double Opt-in enable
					
					$subscribe_data['status'] = 'unconfirmed';
					
					//Save subcriber data
					$subscriber = Subscriber::createOrUpdate($subscribe_data);
					
					// Display success notice to the customer.
					if(!empty($subscriber)){
						wc_add_notice( 
							apply_filters(
								'mailpoet_woocommerce_subscribe_confirm', 
								self::__('We have sent you an email to confirm your newsletter subscription. Please confirm your subscription. Thank you.') 
							)
						);
						
						// Send signup confirmation email
						$confirm_email = $subscriber->sendConfirmationEmail();

					//Show error notice if unable to save data
					}else{
						self::subscribe_error_notice();
					}//End of if $subscriber !== false

				}else{ //If Double Opt-in disable

					$subscribe_data['status'] = 'subscribed';
					
					//Save subcriber data
					$subscriber = Subscriber::createOrUpdate($subscribe_data);

					// Display success notice to the customer.
					if($subscriber !== false){
						wc_add_notice( 
							apply_filters(
								'mailpoet_woocommerce_subscribe_thank_you', 
								self::__('Thank you for subscribing to our newsletters.') 
							) 
						);

					//Show error notice if unable to save data
					}else{
						self::subscribe_error_notice();
					
					}//End of if $subscriber !== false
				
				}//End of if $double_optin == 'yes'
			
			}//End of if is_array($list_id_array)
		
		}//End of save_subscriber_record

		/**
		 * Unsubscribe User
		 */
		public static function unsubscribe_user( $posted_data )
		{

			$email = isset($posted_data['billing_email']) ? $posted_data['billing_email'] : false;
			$subscriber = Subscriber::findOne( $email );

			if ( $subscriber !== false ){

				$subscriber->status = 'unsubscribed';
				$subscriber->save();

				wc_add_notice( 
					apply_filters(
						'mailpoet_woocommerce_unsubscribe_confirm', 
						self::__('You will no longer receive our newletter! Feel free to subscribe our newsletter anytime you want.') 
					)
				);

			}

		} // End of unsubscribe_user

		/**
		 * Save data Error notice
		 */
		public static function subscribe_error_notice()
		{
			wc_add_notice( 
				apply_filters( 
					'mailpoet_woocommerce_subscribe_error', 
					self::__('There appears to be a problem subscribing you to our newsletters. Please let us know so we can manually add you ourselves. Thank you.') 
				), 
				'error' 
			);
		}//End of subscribe_error_notice

	}//End of class

}//End if