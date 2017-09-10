<?php
	/**
	 * @package VapeSocietyPlugin
	 */
	/**
	 * Plugin Name: Vape Society Plugin
	 * Description: A plugin package for vape society
	 * Version: 1.0
	 * Author: Xing Li
	 * Author URI: http://gitxing.com
	 * Text Domain: vsp
	 */

	if (!defined( 'ABSPATH'))
	{
		exit;
	}

	require_once plugin_dir_path( __FILE__) . 'VapeSocietyPlugin.php';

	function vape_start() {
		if ( ! class_exists( 'VapeSocietyPlugin' ) ) {
			exit;
		}
		$vapeSocietyPlugin = new VapeSocietyPlugin();
		register_activation_hook( __FILE__, array( $vapeSocietyPlugin, 'activate' ) );
		register_deactivation_hook( __FILE__, array( $vapeSocietyPlugin, 'deactivate' ) );
		$vapeSocietyPlugin->register();
		$vapeSocietyPlugin->form_init();
		if (isset( $_POST['product_cat_logo'])) {
			if ( ! empty( $_POST['product_cat_logo'] ) ) {
				if ( $vapeSocietyPlugin->check_term_id( $_POST['term_id'] ) ) {
					$vapeSocietyPlugin->insert( $_POST['term_id'], $_POST['product_cat_logo'] );
				} else {
					$vapeSocietyPlugin->update( $_POST['term_id'], $_POST['product_cat_logo'] );
				}
			} else {
				if (! $vapeSocietyPlugin->check_term_id($_POST['term_id'])) {
					$vapeSocietyPlugin->delete($_POST['term_id']);
				}
			}
		}
	}

	vape_start();

	///// use this on front page
//        if (class_exists('VapeSocietyPlugin')) {
//	          if (get_queried_object()->term_id){
//		            VapeSocietyPlugin::cat_logo(get_queried_object()->term_id);
//	          }
//	      }