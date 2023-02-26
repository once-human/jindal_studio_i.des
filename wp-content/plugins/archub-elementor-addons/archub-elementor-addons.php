<?php
/**
 * Plugin Name: ArcHub Elementor Addons
 * Description: ArcHub Theme exclusively Elementor addons.
 * Plugin URI: https://archub.liquid-themes.com/
 * Version: 1.1.5
 * Author: Liquid Themes
 * Author URI: https://themeforest.net/user/liquidthemes
 * Text Domain: archub-elementor-addons
 * WC tested up to: 7.3
 * Elementor tested up to: 3.10
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'LD_ELEMENTOR_PATH', plugin_dir_path( __FILE__ ) );
define( 'LD_ELEMENTOR_URL', plugin_dir_url( __FILE__ ) );
define( 'LD_ELEMENTOR_VERSION', get_file_data( __FILE__, array('Version' => 'Version'), false)['Version']);

if ( defined( 'ELEMENTOR_VERSION' ) && is_callable( 'Elementor\Plugin::instance' ) ) {
	include LD_ELEMENTOR_PATH . 'classes/hub-templates-lib.php';
	include LD_ELEMENTOR_PATH . 'classes/global-controls.php';
}

/**
 * Main Elementor Test Extension Class
 *
 * The main class that initiates and runs the plugin.
 *
 * @since 1.0.0
 */
final class Liquid_Elementor_Addons {

	/**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 *
	 * @var string The plugin version.
	 */
	const VERSION = '1.1.5';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '3.0.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '5.6';

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 * @static
	 *
	 * @var Liquid_Elementor_Addons The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 * @static
	 *
	 * @return Liquid_Elementor_Addons An instance of the class.
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;

	}

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function __construct() {

		add_action( 'plugins_loaded', [ $this, 'on_plugins_loaded' ] );
	}

	/**
	 * Load Textdomain
	 *
	 * Load plugin localization files.
	 *
	 * Fired by `init` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function i18n() {

		load_plugin_textdomain( 'archub-elementor-addons' );

	}

	public function plugin_css() {

		// Load theme css without elementor pages
		if ( !liquid_helper()->is_page_elementor() || liquid_helper()->get_theme_option( 'enable_optimized_files' ) == 'off' ) {
			wp_enqueue_style(
				'theme-elementor',
				LD_ELEMENTOR_URL . 'assets/css/theme-elementor.min.css',
				['liquid-base'],
				LD_ELEMENTOR_VERSION
			);
		}

		$page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers( 'page' );
		$page_settings_model = $page_settings_manager->get_model( get_the_ID() );
		$title_bar = $page_settings_model->get_settings( 'title_bar_enable' );
		$title_bar = $title_bar === '0' ? liquid_helper()->get_option( 'title-bar-enable', 'raw', '' ) : $title_bar;
		$sidebars = $this->get_sidebar_enq();
		
	}

	function get_sidebar_enq() {

		if( is_home() ) {
			$sidebars = array(
				'global'    => true,
				'sidebar'   => liquid_helper()->get_theme_option( 'blog-archive-sidebar-one' ),
				'position'  => liquid_helper()->get_theme_option( 'blog-archive-sidebar-position' ),
			);
		}
		elseif ( class_exists( 'WooCommerce' ) && is_product() ) {
			$sidebars = array(
				'global'    => liquid_helper()->get_theme_option( 'wc-enable-global' ),
				'sidebar'   => liquid_helper()->get_theme_option( 'wc-sidebar' ),
				'position'  => liquid_helper()->get_theme_option( 'wc-sidebar-position' ),
			);
		}
		elseif ( class_exists( 'WooCommerce' ) && ( is_product_taxonomy() || is_product_category() ) ) {
			$sidebars = array(
				'global'    => true,
				'sidebar'   => liquid_helper()->get_theme_option( 'wc-archive-sidebar-one' ),
				'position'  => liquid_helper()->get_theme_option( 'wc-archive-sidebar-position' )
			);
		}
		elseif ( is_page() ) {
			$sidebars = array(
				'global'    => liquid_helper()->get_theme_option( 'page-enable-global' ),
				'sidebar'   => liquid_helper()->get_theme_option( 'page-sidebar-one' ),
				'position'  => liquid_helper()->get_theme_option( 'page-sidebar-position' ),
			);
		}
		elseif ( is_single() ) {

			$sidebars = array(
				'global'    => liquid_helper()->get_theme_option( 'blog-enable-global' ),
				'sidebar'   => liquid_helper()->get_theme_option( 'blog-sidebar-one' ),
				'position'  => liquid_helper()->get_theme_option( 'blog-sidebar-position' )
			);

			if ( is_singular( 'liquid-portfolio' ) ) {
				$sidebars = array(
					'global'    => liquid_helper()->get_theme_option( 'portfolio-enable-global' ),
					'sidebar'   => liquid_helper()->get_theme_option( 'portfolio-sidebar-one' ),
					'position'  => liquid_helper()->get_theme_option( 'portfolio-sidebar-position' ),
				);
			}
		}
		elseif ( is_archive() ) {
			$sidebars = array(
				'global'    => true,
				'sticky'    => liquid_helper()->get_theme_option( 'blog-archive-sidebar-enable-sticky' ),
				'sidebar'   => liquid_helper()->get_theme_option( 'blog-archive-sidebar-one' ),
				'position'  => liquid_helper()->get_theme_option( 'blog-archive-sidebar-position' ),

			);

			if ( is_post_type_archive( 'liquid-portfolio' ) || is_tax( 'liquid-portfolio-category' ) ) {
				$sidebars = array(
					'global'    => true,
					'sticky'    => liquid_helper()->get_theme_option( 'portfolio-archive-sidebar-enable-sticky' ),
					'sidebar'   => liquid_helper()->get_theme_option( 'portfolio-archive-sidebar-one' ),
					'position'  => liquid_helper()->get_theme_option( 'portfolio-archive-sidebar-position' ),
				);
			}
		}
		 elseif ( is_search() ) {
			$sidebars = array(
				'global'    => true,
				'sticky'    => liquid_helper()->get_theme_option( 'seach-sidebar-enable-sticky' ),
				'sidebar'   => liquid_helper()->get_theme_option( 'search-sidebar-one' ),
				'position'  => liquid_helper()->get_theme_option( 'search-sidebar-position' ),
			);
		}
		else {
			$sidebars = array(
				'global'    => liquid_helper()->get_theme_option( 'page-enable-global' ),
				'sticky'    => liquid_helper()->get_theme_option( 'page-sidebar-enable-sticky' ),
				'sidebar'   => liquid_helper()->get_theme_option( 'page-sidebar-one' ),
				'position'  => liquid_helper()->get_theme_option( 'page-sidebar-position' ),
			);
		}

		return $sidebars;
	}

	/**
	 * On Plugins Loaded
	 *
	 * Checks if Elementor has loaded, and performs some compatibility checks.
	 * If All checks pass, inits the plugin.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function on_plugins_loaded() {

		if ( $this->is_compatible() ) {
			add_action( 'elementor/init', [ $this, 'init' ] );
		}

	}

	/**
	 * Compatibility Checks
	 *
	 * Checks if the installed version of Elementor meets the plugin's minimum requirement.
	 * Checks if the installed PHP version meets the plugin's minimum requirement.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function is_compatible() {

		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return false;
		}

		// Check if ArcHub Core installed and activated
		if ( ! class_exists( 'Liquid_Addons' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_hub_core' ] );
			return false;
		}

		// Check if Liquid Bakery installed and activated
		if ( class_exists( 'WPBakeryShortCode' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_liquid_bakery' ] );
			return false;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return false;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return false;
		}
		
		// Check for theme activated
		if ( 'ArcHub' !== wp_get_theme()->get( 'Name' ) && 'ArcHub Child' !== wp_get_theme()->get( 'Name' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_hub_theme' ] );
			return false;
		}

		return true;

	}

	/**
	 * Initialize the plugin
	 *
	 * Load the plugin only after Elementor (and other plugins) are loaded.
	 * Load the files required to run the plugin.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init() {
	
		$this->i18n();
		$this->include_files();
		add_action( 'elementor/elements/categories_registered', [ $this, 'register_elementor_categories'], 5 );
		add_action( 'wp_enqueue_scripts', [$this, 'plugin_css'], 99 );
		add_action( 'after_switch_theme', [$this, 'ld_el_defaults'] );
		
	}

	public function include_files() {

        if ( defined( 'ELEMENTOR_VERSION' ) && is_callable( 'Elementor\Plugin::instance' ) ) {
            include_once LD_ELEMENTOR_PATH . 'elementor/liquid-elementor.php';
            include_once LD_ELEMENTOR_PATH . 'elementor/shortcodes/misc/liquid-misc.php';
            include_once LD_ELEMENTOR_PATH . 'includes/params/blog.php';
            include_once LD_ELEMENTOR_PATH . 'includes/params/portfolio.php';
        }

    }
	
    public function register_elementor_categories( $elements_manager ) {

		$categories = [];
		$categories['hub-header'] = [
			'title' => sprintf( __( '%s - Header', 'archub-elementor-addons' ), '<strong>Liquid</strong>' ),
			'icon'  => 'eicon-font'
		];
		$categories['hub-core'] = [
			'title' => sprintf( __( '%s - General', 'archub-elementor-addons' ), '<strong>Liquid</strong>' ),
			'icon'  => 'eicon-font'
		];
		$categories['hub-woo'] = [
			'title' => sprintf( __( '%s - Woocommerce', 'archub-elementor-addons' ), '<strong>Liquid</strong>' ),
			'icon'  => 'eicon-font'
		];
		$categories['hub-portfolio'] = [
			'title' => sprintf( __( '%s - Portfolio', 'archub-elementor-addons' ), '<strong>Liquid</strong>' ),
			'icon'  => 'eicon-font'
		];

		if ( !version_compare( PHP_VERSION, '7.0.0', '<' ) ) {
			$old_categories = $elements_manager->get_categories();
			$categories = array_merge($categories, $old_categories);
		
			$set_categories = function ( $categories ) {
				$this->categories = $categories;
			};
		
			$set_categories->call( $elements_manager, $categories );
		} else {
			foreach ($categories as $key => $category){
				$elements_manager->add_category( $key, $category );
			}
		}
	
    }

	function ld_el_defaults() {
		update_option( 'elementor_css_print_method', 'internal' );
		update_option( 'elementor_disable_color_schemes', 'yes' );
		update_option( 'elementor_disable_typography_schemes', 'yes' );
		update_option( 'elementor_font_display', 'swap' );
		update_option( 'elementor_experiment-e_dom_optimization', 'active' );

		//if exists, assign to $cpt_support var
		$cpt_support = get_option( 'elementor_cpt_support' );
		
		//check if option DOESN'T exist in db
		if( ! $cpt_support ) {
			$cpt_support = [ 'page', 'post', 'liquid-header', 'liquid-footer', 'liquid-portfolio', 'liquid-mega-menu']; //create array of our default supported post types
			update_option( 'elementor_cpt_support', $cpt_support ); //write it to the database
		}
	}

	
	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'archub-elementor-addons' ),
			'<strong>' . esc_html__( 'ArcHub Elementor Addons', 'archub-elementor-addons' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'archub-elementor-addons' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'archub-elementor-addons' ),
			'<strong>' . esc_html__( 'ArcHub Elementor Addons', 'archub-elementor-addons' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'archub-elementor-addons' ) . '</strong>',
			 self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'archub-elementor-addons' ),
			'<strong>' . esc_html__( 'ArcHub Elementor Addons', 'archub-elementor-addons' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'archub-elementor-addons' ) . '</strong>',
			 self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_hub_core() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'archub-elementor-addons' ),
			'<strong>' . esc_html__( 'ArcHub Elementor Addons', 'archub-elementor-addons' ) . '</strong>',
			'<strong>' . esc_html__( 'ArcHub Core', 'archub-elementor-addons' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_hub_theme() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" theme to be installed and activated.', 'archub-elementor-addons' ),
			'<strong>' . esc_html__( 'ArcHub Elementor Addons', 'archub-elementor-addons' ) . '</strong>',
			'<strong>' . esc_html__( 'ArcHub or ArcHub Child', 'archub-elementor-addons' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}
	
	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_liquid_bakery() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$deactive_url = add_query_arg(array(
			'action' => 'deactivate',
			'plugin' => rawurlencode( 'liquid_js_composer/liquid_js_composer.php' ),
			'plugin_status' => 'all',
			'paged' => '1',
			'_wpnonce' => wp_create_nonce('deactivate-plugin_liquid_js_composer/liquid_js_composer.php'),
		), network_admin_url('plugins.php'));

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be disabled. %3$s', 'archub-elementor-addons' ),
			'<strong>' . esc_html__( 'ArcHub Elementor Addons', 'archub-elementor-addons' ) . '</strong>',
			'<strong>' . esc_html__( 'Liquid WPBakery Page Builder', 'archub-elementor-addons' ) . '</strong>',
			'<a href="'. esc_url( $deactive_url ) . '">' . esc_html__('Deactivate now.', 'archub-elementor-addons') . '</a>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

}

Liquid_Elementor_Addons::instance();