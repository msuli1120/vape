<?php
	/**
	 * Created by PhpStorm.
	 * User: xing
	 * Date: 9/9/17
	 * Time: 11:12 PM
	 */

	class VapeSocietyPlugin {

		public function __construct() {
		}

		private static function create_database() {
			global $wpdb, $table_prefix;
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			$product_cat_logo_table = $table_prefix . 'product_cat_logo';
			if ($wpdb->get_var("SHOW TABLES LIKE '$product_cat_logo_table'") != $product_cat_logo_table) {
				$createSQL_cat_logo = "CREATE TABLE `" . $wpdb->prefix . "product_cat_logo` ( `ID` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT , `logo` VARCHAR(255) NOT NULL, `term_id` BIGINT(20) NOT NULL, PRIMARY KEY (`ID`)) ENGINE = InnoDB " . $wpdb->get_charset_collate() . " AUTO_INCREMENT=1;";
				dbDelta($createSQL_cat_logo);
			}
		}

		public function insert($term_id, $logo) {
			global $wpdb;
			$wpdb->insert( 'wp_product_cat_logo', array(
				'logo' => $logo,
				'term_id' => $term_id,
			));
		}

		public static function cat_logo($term_id) {
			global $wpdb;
			$query = $wpdb->prepare("SELECT logo FROM wp_product_cat_logo WHERE term_id = %d", $term_id);
			$logo = $wpdb->get_results($query);
			if (isset( $logo[0])){
				$path = $logo[0]->logo;
				echo "<img src=" . $path . " style='width: 30px'>";
			}
			return;
		}

		public function activate() {
			if (version_compare( get_bloginfo('version'), '4.7', '<')) {
				wp_die(__('You have to update WordPress to use this plugin.', 'vsp'));
			}
			self::create_database();
			flush_rewrite_rules();
		}

		public function deactivate() {
			flush_rewrite_rules();
		}

		public function enqueue() {
			wp_enqueue_style( 'vsp_style', plugins_url('/assets/style.css', __FILE__));
			wp_enqueue_script( 'vsp_scripts', plugins_url('/assets/scripts.js', __FILE__), array('jquery'), false, true);
			wp_enqueue_media();
		}

		public function register() {
			if (is_admin()) {
				add_action('admin_enqueue_scripts', array($this, 'enqueue'));
			}
		}

		public function form_init() {
			add_action('product_cat_edit_form_fields', array($this, 'form_edit'));
		}

		public function form_edit($tag) {
			include ( __DIR__ . '/includes/form.php' );
		}

		public function check_term_id($term_id) {
			global $wpdb;
			$term_id_array = array();
			$query = $wpdb->prepare("SELECT term_id FROM wp_product_cat_logo WHERE term_id = %d", $term_id);
			$results = $wpdb->get_results($query);
			foreach ($results as $result) {
				array_push( $term_id_array, $result->term_id);
			}
			if (! in_array( $term_id, $term_id_array)){
				return true;
			}
		}

		public function update($term_id, $logo) {
			global $wpdb;
			$wpdb->update('wp_product_cat_logo', array('term_id' => $term_id, 'logo' => $logo), array('term_id' => $term_id));
		}

		public function delete($term_id) {
			global $wpdb;
			$wpdb->delete('wp_product_cat_logo', array('term_id' => $term_id));
		}

	}