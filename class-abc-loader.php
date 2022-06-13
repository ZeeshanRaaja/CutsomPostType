<?php
/**
 * Main Loader.
 *
 * @package be-the-unique-customization
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'BTUC_Loader' ) ) {

	/**
	 * Class BTUC_Loader.
	 */
	class ABC_Loader {

		/**
		 *  Constructor.
		 */
		public function __construct() {
			$this->includes();
			add_action( 'plugins_loaded', array( $this, 'btuc_load_plugin_textdomain' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'btuc_enqueue_scripts' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'btuc_wp_enqueue_scripts' ) );
		}

		/**
		 * Include Files depend on platform.
		 */
		public function includes() {
			include_once 'class-btuc-search-filters.php';
			include_once 'class-btuc-bookings-dropdown.php';
			include_once 'class-btuc-booking-filter.php';
		}

		/**
		 * Enqueue Files.
		 */
		public function btuc_enqueue_scripts() {
			wp_enqueue_script( 'gutenberg-block-script', plugin_dir_url( __DIR__ ) . 'assets/js/gutenberg-block.js', array(), wp_rand() );
			wp_enqueue_script( 'shortcode-setting-script', plugin_dir_url( __DIR__ ) . 'assets/js/shortcode-setting.js', array(), wp_rand() );
		}

		/**
		 * Enqueue Frontend Files.
		 */
		public function btuc_wp_enqueue_scripts() {
			wp_enqueue_script('jquery');
			wp_enqueue_script( 'select2-script', "https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js", array(), wp_rand() );
			wp_enqueue_style( 'select2-style', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css' );
			wp_enqueue_script( 'dropdown-select-script', plugin_dir_url( __DIR__ ) . 'assets/js/dropdown-select.js', array(), wp_rand() );
		}

		/**
		 * Languages loaded.
		 */
		public function btuc_load_plugin_textdomain() {
			load_plugin_textdomain( 'be-the-unique-customization', false, basename( BTUC_ABSPATH ) . '/languages/' );
		}
	}
}

new ABC_Loader();