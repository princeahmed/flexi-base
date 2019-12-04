<?php

/**
 * Plugin Name: Flexi Base
 * Plugin URI:  https://keendevs.com
 * Description: The Base Plugin For Flexi Addons.
 * Version:     1.0.0
 * Author:      KeenDevs
 * Author URI:  http://keendevs.com
 * Text Domain: flexi-base
 * Domain Path: /languages/
 */

defined( 'ABSPATH' ) || exit();


/**
 * Main initiation class
 *
 * @since 1.0.0
 */
final class FLEXI_BASE {

	public $version = '1.0.0';

	private $min_php = '5.6.0';

	private $name = 'Flexi Base';

	protected static $instance = null;

	public function __construct() {

		if ( $this->check_environment() ) {
			$this->define_constants();
			$this->includes();
			$this->init_hooks();
			do_action( 'flexi_base_loaded' );
		}

	}

	function check_environment() {

		$return = true;

		if ( version_compare( PHP_VERSION, $this->min_php, '<=' ) ) {
			$return = false;

			$notice = sprintf(
			/* translators: %s: Min PHP version */
				esc_html__( 'Unsupported PHP version Min required PHP Version: "%s"', 'wp-radio-updater' ),
				$this->min_php
			);
		}

		if ( ! $return ) {

			add_action( 'admin_notices', function () use ( $notice ) { ?>
                <div class="notice is-dismissible notice-error">
                    <p><?php echo $notice; ?></p>
                </div>
			<?php } );

			if ( ! function_exists( 'deactivate_plugins' ) ) {
				require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			}

			deactivate_plugins( plugin_basename( __FILE__ ) );

			return $return;
		} else {
			return $return;
		}

	}

	function define_constants() {
		define( 'FLEXI_BASE_VERSION', $this->version );
		define( 'FLEXI_BASE_FILE', __FILE__ );
		define( 'FLEXI_BASE_PATH', dirname( FLEXI_BASE_FILE ) );
		define( 'FLEXI_BASE_INCLUDES', FLEXI_BASE_PATH . '/includes' );
		define( 'FLEXI_BASE_URL', plugins_url( '', FLEXI_BASE_FILE ) );
		define( 'FLEXI_BASE_ASSETS', FLEXI_BASE_URL . '/assets' );
		define( 'FLEXI_BASE_TEMPLATES', FLEXI_BASE_PATH . '/templates' );
		define( 'FLEXI_BASE_LIBS', FLEXI_BASE_PATH . '/libs' );
	}

	function includes() {

		//core includes
		//include_once FLEXI_BASE_INCLUDES . '/class-install.php';
		//include_once FLEXI_BASE_INCLUDES . '/prince-settings/prince-loader.php';
		//include_once FLEXI_BASE_INCLUDES . '/class-enqueue.php';
		include_once FLEXI_BASE_INCLUDES . '/class-cpt.php';
		include_once FLEXI_BASE_INCLUDES . '/functions.php';
		include_once FLEXI_BASE_INCLUDES . '/class-shortcodes.php';
		//include_once FLEXI_BASE_INCLUDES . '/wp-2checkout-api.php';
		include_once FLEXI_BASE_INCLUDES . '/class-form-handler.php';

		//admin includes
		if(is_admin()){
			include_once FLEXI_BASE_INCLUDES . '/admin/class-admin.php';
		}

	}

	function init_hooks() {

		// Localize our plugin
		add_action( 'init', [ $this, 'localization_setup' ] );

		//action_links
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), [ $this, 'plugin_action_links' ] );

		//register_activation_hook( __FILE__, [ 'FLEXI_BASE_Install', 'activate' ] );

	}

	function localization_setup() {
		load_plugin_textdomain( 'flexi-base', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	function plugin_action_links( $links ) {

		return $links;
	}

	static function instance() {

		if ( is_null( self::$instance ) ) {

			self::$instance = new self();
		}

		return self::$instance;
	}

}

function FLEXI_BASE() {
	return FLEXI_BASE::instance();
}

FLEXI_BASE();
