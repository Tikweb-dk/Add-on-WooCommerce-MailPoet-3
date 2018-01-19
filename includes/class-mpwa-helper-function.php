<?php
/**
 * Plugin helper functions.
 * @since      1.0.0
 * @package    Add-on WooCommerce MailPoet 3
 * @subpackage add-on-woocommerce-mailpoet/includes
 * @author     Tikweb <kasper@tikjob.dk>
 */
trait MPWA_Helper_Function
{

	//Properties
	public $tab_slug = 'mailpoet';

	/**
	 * Translateable text method
	 * @uses return translate text
	 */
	public static function __($text)
	{
		return __($text, 'add-on-woocommerce-mailpoet');
	}//End of __


	/**
	 * Translateable text method
	 * @uses print translate text
	 */
	public function _e($text)
	{
		echo $this->__($text);
	}//End of __


}//End of trait