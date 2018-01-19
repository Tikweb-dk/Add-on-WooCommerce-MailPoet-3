<?php
/**
 * Fired when the plugin is uninstalled.
 * @since      1.0.0
 * @package    Plugin_Name
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

global $wpdb;

// For a single site
if(! is_multisite()) {
	$uninstall = get_option('wc_mailpoet_uninstall_data');

	//If checked `Remove all data on uninstall` then delete options
	if(!empty($uninstall)){
		$wpdb->query("DELETE FROM $wpdb->options WHERE option_name LIKE 'wc_mailpoet_%';");
	}
}
