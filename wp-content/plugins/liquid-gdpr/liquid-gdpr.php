<?php
/*
Plugin Name: Liquid GDPR Box
Plugin URI: http://ave.liquid-themes.com/
Description: Liquid GDPR box
Version: 1.0.2
Author: LiquidThemes
Author URI: https://themeforest.net/user/liquidthemes
Text Domain: liquid-gdpr
*/

if( !defined( 'ABSPATH' ) ) 
	exit; // Exit if accessed directly

class Liquid_Gdpr {

	/**
	 * Hold an instance of Liquid_Gdpr class.
	 * @var Liquid_Gdpr
	 */
	protected static $instance = null;
	
	/**
	 * [$params description]
	 * @var array
	 */
	public $params = array();
	
	/**
	 * Main Liquid_Gdpr instance.
	 *
	 * @return Liquid_Gdpr - Main instance.
	 */
	public static function instance() {

		if(null == self::$instance) {
			self::$instance = new Liquid_Gdpr();
		}

		return self::$instance;
	}

	/**
	 * [__construct description]
	 * @method __construct
	 */
	public function __construct() {

		add_action( 'init', array( $this, 'init_hooks' ) );
		add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain' ) );
		//add_action( 'admin_notices', array( $this, 'activate_addons_notice' ) );
		
		add_action( 'admin_print_scripts-post.php', array( $this, 'enqueue' ), 99 );
		add_action( 'admin_print_scripts-post-new.php', array( $this, 'enqueue' ), 99 );
		
		add_action( 'wp_enqueue_scripts', array( $this, 'frontend_enqueue_css_js' ), 99 );

	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain( 'liquid-gdpr', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}

	/**
	 * [init_hooks description]
	 * @method init_hooks
	 * @return [type]     [description]
	 */
	/**
	 * [init_hooks description]
	 * @method init_hooks
	 *
	 * @return [type]     [description]
	 */
	public function init_hooks() {

		$this->assets_css = plugins_url( '/assets/css', __FILE__ );
		$this->assets_js  = plugins_url( '/assets/js', __FILE__ );

		if( class_exists( 'WPBakeryShortCode' ) ) {
			include_once $this->plugin_dir() . 'includes/shortcode.class.php';

			$this->load_shortcodes();
			
			global $vc_manager;
			$vc_manager->setIsAsTheme();
			$vc_manager->disableUpdater();
	
			$list = array( 'page', 'post', 'product' );
			$vc_manager->setEditorDefaultPostTypes( $list );
	
			//disable VC update notifications
			if( is_admin() ) {
	
				if ( ! isset( $_COOKIE['vchideactivationmsg'] ) ) {
					setcookie( 'vchideactivationmsg', '1', strtotime( '+3 years' ), '/' );
				}
	
				if ( ! isset( $_COOKIE[ 'vchideactivationmsg_vc11' ] ) ) {
					setcookie( 'vchideactivationmsg_vc11', ( defined( 'WPB_VC_VERSION' ) ? WPB_VC_VERSION : '1' ), strtotime( '+3 years' ), '/' );
				}
			}
			
		}	

	}
	
	/**
	 * Load vc scripts
	 */
	public function enqueue() {
		
		wp_enqueue_style( 'le-vc-style', $this->assets_css. '/vc-style.css' );
	}
	
	/**
	 * Load vc scripts
	 */
	public function frontend_enqueue_css_js() {
		
		wp_enqueue_style( 'ld-gdpr-box', $this->assets_css. '/liquid-gdpr.min.css' );
		wp_enqueue_script( 'ld-gdpr-box-js',   $this->assets_js . '/liquid-gdpr.min.js' ,  array( 'jquery' ), '1.0.0', true );
	}

	public function activate_addons_notice() {

		if( class_exists( 'WPBakeryShortCode' ) || class_exists( 'Liquid_Elementor_Addons' ) ) {
			return;
		}
	?>
		<div class="updated not-h2">
			<p><strong><?php esc_html_e( 'Please activate the WPBakery Page Builder to use the Liquid GDPR plugin.', 'liquid-events' ); ?></strong></p>
			<?php
				$screen = get_current_screen();
				if ( $screen->base != 'plugins' ):
			?>
				<p><a href="<?php echo esc_url( admin_url( 'plugins.php' ) ); ?>"><?php esc_html_e( 'Activate WPBakery Page Builder', 'liquid-events' ); ?></a></p>
			<?php endif; ?>
		</div>
	<?php
	}
	
	/**
	 * [load_shortcodes description]
	 * @method load_shortcodes
	 *
	 * @return [type]          [description]
	 */
	public function load_shortcodes() {

		//List of shortcodes in APLHABETICAL ORDER!!!!
		$shortcodes = array(
			'gdpr-box'
		);

		// Order Shortcodes
		sort( $shortcodes );

		foreach( $shortcodes as $shortcode ) {

			$file = $this->plugin_dir(). "shortcodes/{$shortcode}/liquid-{$shortcode}.php";

			if ( file_exists( $file ) ) {
				require_once $file;
			}
		}
	}
	
	public function get_param( $id, $old ) {

		$id = sanitize_key( $id );

		if( ! isset( $this->params[$id] ) ) {
			_doing_it_wrong( 'get_param', wp_kses( sprintf( __( 'ID: <strong>%s</strong>, didn\'t exists in the system', 'liquid-events' ), $id ), array( 'strong' => array() ) ), null );
		}

		$new = array_merge( $this->params[$id], $old );
		unset( $new['id'] );

		return $new;
	}

	/**
	 * Plugin activation
	 */
	public static function activate() {
		flush_rewrite_rules();
	}

	/**
	 * Plugin deactivation
	 */
	public static function deactivate() {
		flush_rewrite_rules();
	}

	public function plugin_uri() {
		return plugin_dir_url( __FILE__ );
	}

	public function plugin_dir() {
		return plugin_dir_path( __FILE__ );
	}
	
}

/**
 * Main instance of Liquid_Gdpr.
 *
 * Returns the main instance of Liquid_Gdpr to prevent the need to use globals.
 *
 * @return Liquid_Gdpr
 */
function liquid_gdpr() {
	return Liquid_Gdpr::instance();
}
liquid_gdpr(); // init i

register_activation_hook( __FILE__, array( 'Liquid_Gdpr', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Liquid_Gdpr', 'deactivate' ) );