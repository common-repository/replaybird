<?php
/**
 * Plugin Name: ReplayBird
 * Description: ReplayBird lets you watch how users' interact with your website and see precisely why they are struggling and what to do about it.
 * Author: ReplayBird
 * Author URI: https://www.replaybird.com/
 * Version: 2.0.2
 * Text Domain: replaybird
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


add_action( 'plugins_loaded', 'replaybird_plugin_init' );

function replaybird_plugin_init() {

	if ( ! class_exists( 'WP_ReplayBird' ) ) :

		class WP_ReplayBird {
			/**
			 * @var Const Plugin Version Number
			 */
			const VERSION = '2.0.2';

			/**
			 * @var Singleton The reference the *Singleton* instance of this class
			 */
			private static $instance;

			/**
			 * Returns the *Singleton* instance of this class.
			 *
			 * @return Singleton The *Singleton* instance.
			 */
			public static function get_instance() {
				if ( null === self::$instance ) {
					self::$instance = new self();
				}
				return self::$instance;
			}

			private function __clone() {}

			private function __wakeup() {}

			/**
			 * Protected constructor to prevent creating a new instance of the
			 * *Singleton* via the `new` operator from outside of this class.
			 */
			private function __construct() {
				add_action( 'admin_init', array( $this, 'install' ) );
				add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array( 'WP_ReplayBird', 'plugin_action_links' ));
				$this->init();
			}

			/**
			 * Init the plugin after plugins_loaded so environment variables are set.
			 *
			 * @since 1.0.0
			 */
			public function init() {
				require_once( dirname( __FILE__ ) . '/src/includes/index.php' );
				$replaybird = new ReplayBird();
				$replaybird->init();
			}

			/**
			 * Updates the plugin version in db
			 *
			 * @since 1.0.0
			 */
			public function update_plugin_version() {
				delete_option( 'replaybird_version' );
				update_option( 'replaybird_version', self::VERSION );
			}

			/**
			 * Handles upgrade routines.
			 *
			 * @since 1.0.0
			 */
			public function install() {
				if ( ! is_plugin_active( plugin_basename( __FILE__ ) ) ) {
					return;
				}

				if ( ( self::VERSION !== get_option( 'replaybird_version' ) ) ) {

					$this->update_plugin_version();
				}
			}

			/**
			 * Adds plugin action links.
			 *
			 * @since 1.0.0
			 */
			public static function plugin_action_links( $links ) {

				$my_links = array(
  					'<a href="' . admin_url( 'options-general.php?page=replaybird_settings' ) . '">Settings</a>',
					// '<a href="https://www.replaybird.com">ReplayBird Home</a>',
				);
				return array_merge( $links, $my_links );
			}
		}

		WP_ReplayBird::get_instance();

	endif;
}
