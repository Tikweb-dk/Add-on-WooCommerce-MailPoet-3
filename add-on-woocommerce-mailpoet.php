<?php
/**
 * Plugin Name:       Add-on WooCommerce MailPoet 3
 * Description:       Let your customers subscribe to your newsletter as they checkout with their purchase.
 * Version:           1.1.2
 * Author:            Tikweb
 * Author URI:        http://www.tikweb.dk/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       add-on-woocommerce-mailpoet
 * Domain Path:       /languages
 */

/*
Add-on WooCommerce MailPoet 3  is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Add-on WooCommerce MailPoet 3  is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Add-on WooCommerce MailPoet 3 . If not, see http://www.gnu.org/licenses/gpl-2.0.txt.
*/

// If this file is called directly, abort.
if(!defined( 'WPINC' )){
	die;
}

if(!defined('ABSPATH')){
	exit;
}

/**
 * Define root path
 */
if(!defined('MPWA_ROOT_PATH')){
	$mbh_root = plugin_dir_path(__FILE__);
	define('MPWA_ROOT_PATH', $mbh_root);
}

/**
 * Define root url
 */
if(!defined('MPWA_ROOT_URL')){
	$mbh_url = plugin_dir_url( __FILE__ );
	define('MPWA_ROOT_URL', $mbh_url);
}


/**
 * If php version is lower
 */
if(version_compare(phpversion(), '5.4', '<')){
	function mailpoet_cfi_php_version_notice(){
		?>
		<div class="error">
			<p><?php _e('Add-on WooCommerce MailPoet 3  plugin requires PHP version 5.4 or newer, Please upgrade your PHP.', 'add-on-woocommerce-mailpoet'); ?></p>
		</div>
		<?php
	}
	add_action('admin_notices', 'mailpoet_cfi_php_version_notice');
	return;
}

/**
 * Include plugin.php to detect plugin.
 */
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/**
 * Check MailPoet active
 * Prerequisite
 */
if(!is_plugin_active('mailpoet/mailpoet.php')){
	add_action('admin_notices', function(){
		?>
		<div class="error">
			<p>
			<?php
				$name = 'Add-on WooCommerce MailPoet 3';
				$mp_link = '<a href="https://wordpress.org/plugins/mailpoet/" target="_blank">MailPoet</a>';
				printf(
					__('%s plugin requires %s plugin, Please activate %s first to using %s.', 'add-on-woocommerce-mailpoet'),
					$name,
					$mp_link,
					$mp_link,
					$name
				);
			?>
			</p>
		</div>
		<?php
	});
	return;	// If not then return
}


/**
 * Check WooCommerce active
 * Prerequisite
 */
if(!is_plugin_active('woocommerce/woocommerce.php')){
	add_action('admin_notices', function(){
		?>
		<div class="error">
			<p>
			<?php
				$name = '<strong>Add-on WooCommerce MailPoet 3 </strong>';
				$cf7_link = '<a href="https://wordpress.org/plugins/woocommerce/" target="_blank">WooCommerce</a>';
				printf(
					__('Hold on a minute. You need to install %s first to use %s.', 'add-on-woocommerce-mailpoet'),
					$cf7_link,
					$name
				);
			?>
			</p>
		</div>
		<?php
	});
	return;	// If not then return
}

/**
 * Helper functions
 */
require_once MPWA_ROOT_PATH . 'includes/class-mpwa-helper-function.php';

/**
 * This class is used to define admin specific Actions and settings.
 * @uses Only for admin panel
 */
if(is_admin()){
	function mpwa_admin_settings_pages($settings){
		$settings[] = include( MPWA_ROOT_PATH . 'includes/class-mpwa-admin-settings.php' );
		return $settings;
	}
	add_filter('woocommerce_get_settings_pages', 'mpwa_admin_settings_pages');
}//End if

/**
 * PLugin front end functions and hook
 */
if(!is_admin()){
	//Chackout page form fields
	require_once MPWA_ROOT_PATH . 'includes/class-mpwa-frontend-fields.php';

	//Place order actions
	//Run after the checkout form validation complete
	function wc_after_checkout_validation_mpwa_subscribe($order_id, $data){

		// Fixes - Confirmation email sending conflict
		// with older versions of Mailpoet
		if( MAILPOET_VERSION > '3.11.3' ){
			require_once MPWA_ROOT_PATH . 'includes/class-mpwa-place-order.php';
		}else{
			require_once MPWA_ROOT_PATH . 'includes/class-mpwa-place-order-deprecated.php';
		}
		MPWA_Place_Order::subscribe_user();
	}
	add_action('woocommerce_checkout_update_order_meta', 'wc_after_checkout_validation_mpwa_subscribe', 20, 2);
}//End if
