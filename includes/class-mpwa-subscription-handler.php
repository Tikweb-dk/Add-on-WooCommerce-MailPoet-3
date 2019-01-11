<?php
/**
 * Handles Subscription on Checkout Page
 * @since      1.1.2
 * @package    Add-on WooCommerce MailPoet 3
 * @subpackage add-on-woocommerce-mailpoet/includes
 * @author     Tikweb <kasper@tikjob.dk>
 */

use MailPoet\Models\Subscriber;
use MailPoet\Subscribers\ConfirmationEmailMailer;

if(!class_exists('MPWA_Subscription_Handler')){
	class MPWA_Subscription_Handler
	{
		//Helper trait
		use MPWA_Helper_Function;

		//Subscribes user to list
		public static function subscribe_user()
		{

		}

		//Unsubscribe user from list
		public static function unsubscribe_user()
		{

		}
		//Get subscriber data
		public static function get_subscriber_data()
		{

		}
	}// End class
		

}//End if