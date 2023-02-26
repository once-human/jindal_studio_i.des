<?php
/**
 * Liquid Themes Theme Framework
 * The Liquid_Theme initiate the theme engine
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

// Include base class
include_once( get_template_directory() . '/liquid/liquid-base.php' );

// For developers to hook.
liquid_action( 'before_init' );

/**
 * Liquid Theme
 */
class Liquid_Theme extends Liquid_Base {

	/**
	 * [$version description]
	 * @var string
	 */
	private $version = '1.0.0';

	/**
	 * Theme options values
	 * @var array
	 */
	protected $theme_options_values = array();

	/**
	 * Hold an instance of Liquid_Theme class.
	 * @var Liquid_Theme
	 */
	protected static $instance = null;

	/**
	 * Main Liquid_Theme instance.
	 *
	 * @return Liquid_Theme - Main instance.
	 */
	public static function instance() {
		if ( null == self::$instance ) {
			self::$instance = new Liquid_Theme();
		}

		return self::$instance;
	}

	/**
	 * [__construct description]
	 * @method __construct
	 */
	private function __construct() {

		$this->init_hooks();
	}

	/**
	 * [init_hooks description]
	 * @method init_hooks
	 * @return [type]     [description]
	 */
	private function init_hooks() {

		$this->add_action( 'after_setup_theme', 'includes', 2 );
		$this->add_action( 'after_setup_theme', 'setup_theme', 7 );
		$this->add_action( 'after_setup_theme', 'admin', 7 );
		$this->add_action( 'after_setup_theme', 'extensions', 25 );

		// Check plugin conflict
		if ( class_exists( 'WPBakeryShortCode' ) || defined('ELEMENTOR_VERSION') ) {
			$this->add_action( 'admin_head', 'admin_conflict_notice' );
		}

		$this->add_action( 'admin_head', 'admin_update_redirect' );

		// For developers to hook.
		liquid_action( 'loaded' );
	}

	/**
	 * [includes description]
	 * @method includes
	 * @return [type]   [description]
	 */
	public function includes() {

		// Load Core
		include_once( get_template_directory() . '/liquid/liquid-helpers.php' );
		include_once( get_template_directory() . '/liquid/liquid-template-tags.php' );
		include_once( get_template_directory() . '/liquid/liquid-media.php' );
		include_once( get_template_directory() . '/liquid/liquid-theme-options-init.php' );
		include_once( get_template_directory() . '/liquid/liquid-meta-boxes-init.php' );
		include_once( get_template_directory() . '/liquid/liquid-dynamic-css.php' );
		include_once( get_template_directory() . '/liquid/liquid-responsive-css.php' );

		// Load Structure
		include_once( get_template_directory() . '/liquid/structure/markup.php' );
		include_once( get_template_directory() . '/liquid/structure/header.php' );
		include_once( get_template_directory() . '/liquid/structure/footer.php' );
		include_once( get_template_directory() . '/liquid/structure/posts.php' );
		include_once( get_template_directory() . '/liquid/structure/comments.php' );

		// Load Woocommerce stuff
		if ( class_exists( 'WooCommerce' ) ) {
			include_once( get_template_directory() . '/liquid/vendors/woocommerce/liquid-woocommerce-init.php' );
		}

		// Load Aqua Resizer
		include_once( get_template_directory() . '/liquid/extensions/aq_resizer/aq_resizer.php' );

		// Load Register and updater classes
		include_once( get_template_directory() . '/liquid/admin/updater/liquid-register-admin.php' );

		// Front-end
		if ( ! is_admin() ) {
			$this->layout = include_once( get_template_directory() . '/liquid/liquid-theme-layout.php' );
		}

	}

	/**
	 * [setup_theme description]
	 * @method setup_theme
	 * @return [type]      [description]
	 */
	public function setup_theme() {

		// Set Content Width
		global $content_width;
		if ( ! isset( $content_width ) ) {
			$content_width = 780;
		}

		// Localization
		load_theme_textdomain( 'archub', trailingslashit( WP_LANG_DIR ) . 'themes/' ); // From Wp-Content
		load_theme_textdomain( 'archub', get_stylesheet_directory() . '/languages' ); // From Child Theme
		load_theme_textdomain( 'archub', get_template_directory() . '/languages' ); // From Parent Theme

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Let WordPress manage the document title.
		add_theme_support( 'title-tag' );

		// Enable support for Post Thumbnails on posts and pages.
		add_theme_support( 'post-thumbnails' );

		// Enable support for WooCommerce
		add_theme_support( 'woocommerce' );

		// Switch default core markup for search form, comment form, and comments to output valid HTML5.
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'liquid-assets',
			'script',
			'style'
		) );

		// Allow shortcodes in widgets.
		add_filter( 'widget_text', 'do_shortcode' );

		// Theme Specific Setup
		$this->load_theme_part( 'liquid-setup' );

		// Get options for globals
		$GLOBALS[ $this->get_option_name() ] = get_option( $this->get_option_name(), array() );

		$this->load_theme_part( 'liquid-scripts' );
		$this->load_theme_part( 'liquid-hooks' );
		$this->load_theme_part( 'liquid-template-tags' );
		$this->load_theme_part( 'liquid-dynamic-css' );
		$this->load_theme_part( 'liquid-responsive-css' );
		$this->load_theme_part( 'liquid-walkers' );

		if ( class_exists( 'WPBakeryVisualComposerAbstract' ) ) {
			$this->load_theme_part( 'liquid-vc-templates-panel-editor' );
			$this->load_theme_part( 'liquid-vc-templates' );
		}

		// Load elementor first
		$this_plugin = 'elementor/elementor.php';
		$active_plugins = get_option('active_plugins');
		$this_plugin_key = array_search($this_plugin, $active_plugins);
		if ($this_plugin_key) { // if it's 0 it's the first plugin already, no need to continue
			array_splice($active_plugins, $this_plugin_key, 1);
			array_unshift($active_plugins, $this_plugin);
			update_option('active_plugins', $active_plugins);
		}

	}

	/**
	 * [admin description]
	 * @method admin
	 * @return [type] [description]
	 */
	public function admin() {

		if ( is_admin() ) {
			include_once( get_template_directory() . '/liquid/admin/liquid-admin-init.php' );
		}

	}

	/**
	 * [extensions description]
	 * @method extensions
	 * @return [type]     [description]
	 */
	public function extensions() {

		// check
		$extensions = get_theme_support( 'liquid-extension' );
		if ( empty( $extensions ) || empty( $extensions[0] ) ) {
			return;
		}

		// Load
		$extensions = $extensions[0];
		foreach ( $extensions as $extension ) {
			$this->load_extension( $extension );
		}
	}

	/**
	 * [set_option_name description]
	 * @method set_option_name
	 *
	 * @param string $name [description]
	 */
	public function set_option_name( $name = '' ) {

		if ( $name ) {
			$this->theme_options_name = $name;
		}
	}

	/**
	 * [get_option_name description]
	 * @method get_option_name
	 *
	 * @param string $name [description]
	 *
	 * @return [type]                [description]
	 */
	public function get_option_name( $name = '' ) {
		return $this->theme_options_name;
	}

	// Helper ----------------------------------------

	/**
	 * [get_version description]
	 * @method get_version
	 * @return [type]      [description]
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * [load_theme_part description]
	 * @method load_theme_part
	 *
	 * @param  [type]          $slug [description]
	 * @param  [type]          $args [description]
	 *
	 * @return [type]                [description]
	 */
	public function load_theme_part( $slug, $args = null ) {
		liquid_helper()->get_template_part( 'theme/' . $slug, $args );
	}

	/**
	 * [load_library description]
	 * @method load_library
	 *
	 * @param  [type]       $slug [description]
	 * @param  [type]       $args [description]
	 *
	 * @return [type]             [description]
	 */
	public function load_library( $slug, $args = null ) {
		liquid_helper()->get_template_part( 'liquid/libs/' . $slug, $args );
	}

	public function load_assets( $slug ) {
		return get_template_directory_uri() . '/liquid/assets/' . $slug;
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site activated both page builder
	 *
	 * @since 1.5.0.3
	 *
	 * @access public
	 */
	public function admin_conflict_notice() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		if ( class_exists( 'WPBakeryShortCode' ) && defined('ELEMENTOR_VERSION') ){

			$deactive_vc_url = add_query_arg(array(
				'action' => 'deactivate',
				'plugin' => rawurlencode( 'liquid_js_composer/liquid_js_composer.php' ),
				'plugin_status' => 'all',
				'paged' => '1',
				'_wpnonce' => wp_create_nonce('deactivate-plugin_liquid_js_composer/liquid_js_composer.php'),
			), network_admin_url('plugins.php'));
			
			$deactive_el_url = add_query_arg(array(
				'action' => 'deactivate',
				'plugin' => rawurlencode( 'elementor/elementor.php' ),
				'plugin_status' => 'all',
				'paged' => '1',
				'_wpnonce' => wp_create_nonce('deactivate-plugin_elementor/elementor.php'),
			), network_admin_url('plugins.php'));

			?>
				<style>
					.jconfirm-box{
						text-align: center;
					}
					.jconfirm.jconfirm-light .jconfirm-box .jconfirm-buttons{
						float: none;
					}
					body .jconfirm .jconfirm-box .jconfirm-buttons button.btn-default:hover{
						box-shadow: 0 10px 30px rgba(0,0,0,.3) !important;
						background: #000!important;
					}

					.jconfirm-title::before {
						content: '';
						display: block;
						background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="60" height="60"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm-1-7v2h2v-2h-2zm0-8v6h2V7h-2z"/></svg>');
						background-repeat: no-repeat;
						background-position: center;
						width: 100%;
						height: 60px;
						padding-bottom: 40px;
					}

				</style>
			<?php

			wp_add_inline_script( 'liquid-admin', "
				jQuery( document ).ready(function() {
					jQuery.confirm({
						type: 'orange',
						title: 'Conflict detected!',
						content: 'It seems that you have both <strong>Elementor Page Builder</strong> and <strong>WP Bakery Page Builder</strong> installed and activated. You need to disable one of these plugins, otherwise it\'ll break down your website. Please choose one of them to continue using ArcHub.',
						buttons: {
							new: {
								text: 'Use Elementor',
								action: function(){
									window.location.href = '$deactive_vc_url';
								}
							},
							confirm: {
								text: 'Use WPBakery',
								action: function() {
									window.location.href = '$deactive_el_url';
								}
							},
						}
					});
				});
			" );
		}

		if ( isset($_GET['page']) && ($_GET['page'] == 'tgmpa-install-plugins') ){

			if ( defined( 'ELEMENTOR_VERSION' ) ){
				wp_add_inline_script( 'liquid-admin', "jQuery(document).ready(function($){ $(':checkbox[value=liquid_js_composer]').attr('disabled', true); $(':checkbox[value=liquid_js_composer]').parent().parent().css( 'display', 'none' ); });" );
			}
			
			if ( class_exists( 'WPBakeryShortCode' ) ){
				wp_add_inline_script( 'liquid-admin', "jQuery(document).ready(function($){ $(':checkbox[value=elementor],:checkbox[value=hub-elementor-addons]').attr('disabled', true); $(':checkbox[value=elementor],:checkbox[value=archub-elementor-addons]').parent().parent().css( 'display', 'none' ); });" );
			}

		}

	}

	public function admin_update_redirect() {

		global $wp;
		$url = add_query_arg( $_GET, $wp->request );

		$theme_version = wp_get_theme(get_template())->get( 'Version' );

		if ( 
			( class_exists('Liquid_Elementor_Addons') && version_compare( LD_ELEMENTOR_VERSION, '1.1.4', '<' ) ) ||
			( defined('LD_ADDONS_VERSION') && version_compare( LD_ADDONS_VERSION, '1.1.1', '<' ) ) 
		){
			if ( $url != '?page=liquid-about' )  {
				if ( false === get_transient('lqd_about_update_escape') ) {
					wp_redirect(admin_url( 'admin.php?page=liquid-about' ));
				}
			}
		}

	}

}

/**
 * Main instance of Liquid_Theme.
 *
 * Returns the main instance of Liquid_Theme to prevent the need to use globals.
 *
 * @return Liquid_Theme
 */
function liquid() {
	return Liquid_Theme::instance();
}

liquid(); // init it

// For developers to hook.
liquid_action( 'init' );