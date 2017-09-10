<?php
	/**
	 * Trigger this file on Plugin uninstall
	 * @package VapeSocietyPlugin
	 */

	if (! defined( 'WP_UNINSTALL_PLUGIN')) {
		exit;
	}

	$option_name = 'product_cat_logo';
  delete_option( $option_name);

	global $wpdb;
	$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}product_cat_logo");