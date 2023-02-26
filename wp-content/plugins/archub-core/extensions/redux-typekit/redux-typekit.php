<?php

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

//Include the typekit client
include_once ( 'typekit-client/typekit-client.php' );

if( class_exists( 'Typekit' ) &&  class_exists( 'ReduxFramework' ) ) {
	
	class Liquid_Typekit extends Typekit {

		/**
		 * [$params description]
		 * @var string
		 */
		private $typekit_id = null;
	
		/**
		 * [$params description]
		 * @var boolean
		 */
		private $typekit_use = false;
	
		/**
		 * [$params description]
		 * @var boolean
		 */	
		private $typekit_async = true;
	
		/**
		 * [$params description]
		 * @var array
		 */
		private $typekit_fonts = null;
	
		/**
		 * [$params description]
		 * @var array
		 */
		public $typekit_fonts_full = null;
	
		/**
		 * [$params description]
		 * @var string
		 */
		private $reduxInstance = null;
	
		/**
		 * [__construct description]
		 * @method __construct
		 */
		function __construct() {


			add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_backend_scripts' ) );
			
			add_filter( 'redux/options/liquid_one_opt/sections', array( $this, 'add_typekit_options') );
			add_filter( 'redux/liquid_one_opt/field/typography/custom_fonts', array( $this, 'add_typekit_fonts_to_redux'), 20 );
			add_action( 'redux/loaded', array( $this, 'getReduxInstance' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'typekit_js' ) );
			
			add_action( 'redux/loaded', array( $this, 'get_typekit_options' ) );
			add_action( 'redux/loaded', array( $this, 'check_for_webfontloader' ), 20 );
	
		}
		
		/**
		 * Load the plugin text domain for translation.
		 *
		 * @since    1.0.0
		 */
		public function load_plugin_textdomain() {
		
			load_plugin_textdomain( 'infinite-typekit', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
		}

		public function typekit_js() {
			if ( liquid_helper()->get_theme_option( 'typekit_id' ) ){
				wp_enqueue_script( 'liquid-typekit', plugin_dir_url( __FILE__ ) . 'liquid-typekit.js', array( 'jquery' ), false, true );
			}
		}

		/**
		 * get Redux parent instance
		 */
		public function getReduxInstance( $redux ) {

			$this->reduxInstance = $redux;

		}

		/**
		 * add_typekit_options adds typekit section in redux options
		 * @param [arr] $sections - redux sections
		 * @return [arr] modified sections
		 */
		function add_typekit_options( $sections ) {
	
			$sections[] = array(

				'title' => esc_html__( 'Adobe Fonts (Typekit)', 'one-typekit' ),
				'icon'  => 'el-icon-fontsize',
				'fields' => array(

					array(
						'id'       => 'typekit_id',
						'type'     => 'text',
						'title'    => esc_html__( 'Typekit Kit ID', 'one-typekit' ),
						'desc'     => esc_html__( 'Insert the typekit ID here, and make sure the kit is published', 'one-typekit' ),
					),

				)
			);
	
			return $sections;
	
		}

		/**
		 * get_typekit_options get values of the typekit theme options
		 * @return none
		 */
		function get_typekit_options() {

			global $liquid_options;

			$this->typekit_id  = isset( $liquid_options['typekit_id'] ) ? $liquid_options['typekit_id'] : null;
			$this->enqueue_fonts();

			$this->typekit_fonts = $this->get_typekit_fonts_array( $this->typekit_id );
			$this->typekit_fonts_full = $this->get_typekit_fonts_full_array( $this->typekit_id);

		}
		
		/**
		 * add_typekit_fonts_to_redux
		 * @return  [arr] fonts array
		 */
		function add_typekit_fonts_to_redux( $fonts = array() ) {

			if ( empty( $this->typekit_fonts ) || ! is_array( $this->typekit_fonts ) ) {
				return $fonts;
			}

			$fonts_label = esc_html__( 'Typekit Fonts', 'one-typekit' );
			$fonts       = array_merge( $fonts, $this->typekit_fonts );

			if ( is_array( $fonts ) ) {
				$this->enqueue_fonts_admin();
				return array( $fonts_label => $fonts );
			}

		}

		/**
		 * get_typekit_fonts_array
		 * 
		 * @param  string $kit_id optional
		 * @return [arr] fonts array
		 */
		function get_typekit_fonts_array( $kit_id = false ) {

			$force 	= $kit_id !== false ? true : false;
			$kit_id = $kit_id ? $kit_id : $this->typekit_id;

			if ( !$kit_id ) {
				return false;
			}
			
			if ( $force ) {
				$kit = $this->get( $kit_id );			
			}
			
			$ret = array();

			if ( isset( $kit['kit']['families'] ) ) {
				foreach ( $kit['kit']['families'] as $family ) {
					
					if( isset( $family['css_names'][0] ) ) {
						$slug = $family['css_names'][0];	
					} else {
						$slug = $family['slug'];
					}

					$name = $family['name'];
					$ret[$slug] = $name;
				}
				
				return $ret;
			} else {
				return false;
			}
		}
		
		/**
		 * get_typekit_fonts_full_array
		 * 
		 * @param  string $kit_id optional
		 * @return [arr] fonts array
		 */
		function get_typekit_fonts_full_array( $kit_id = false ) {

			$force 	= $kit_id !== false ? true : false;
			$kit_id = $kit_id ? $kit_id : $this->typekit_id;

			if ( ! $kit_id ) {
				return false;
			}
			
			if ( $force ) {
				$kit = $this->get( $kit_id );
			}
			
			$ret = array();

			if ( isset( $kit['kit']['families'] ) ) {
				foreach ( $kit['kit']['families'] as $family ) {
					$ret[$family['slug']] = array(
						'name'       => $family['name'],
						'variations' => $this->parse_typekit_variations( $family['variations'] )
						);
				}
				return $ret;
			} else {
				return false;
			}
		}

		function parse_typekit_variations( $variations ) {

			$ret = array();

			foreach ( $variations as $variation ) {
				$s = substr( $variation, 0, 1 );
				$w = substr( $variation, 1, 1 );

				switch ( $s ) {

					case 'n':
						$style = 'normal';
						break;

					case 'i':
						$style = 'italic';
						break;

					default:
						$style = 'normal';
						break;

				}

				switch ($w) {

					case '1':
						$weight = '100';
						break;

					case '2':
						$weight = '200';
						break;

					case '3':
						$weight = '300';
						break;

					case '4':
						$weight = '400';
						break;

					case '5':
						$weight = '500';
						break;

					case '6':
						$weight = '600';
						break;

					case '7':
						$weight = '700';
						break;

					case '8':
						$weight = '800';
						break;

					case '9':
						$weight = '900';
						break;

					default:
						$weight = '400';
						break;

				}

				$ret[] = array(
					'style' => $style,
					'weight' => $weight
					);
			}

			return $ret;
		}

		/**
		 * enqueue_fonts enqueue Typekit fonts in frontend of the theme.
		 * @return none
		 */
		function enqueue_fonts() {

			//Check
			if ( ! $this->typekit_id ) { 
				return; 
			}

			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_async_js' ), 155 );

		}


		/**
		 * enqueue_fonts_admin enqueue Typekit fonts in backend of wp
		 * @return none
		 */
		function enqueue_fonts_admin() {

			//Check
			if ( ! $this->typekit_id ) { 
				return; 
			}

			add_action( 'admin_footer', array( $this, 'enqueue_async_js' ), 30 );
		}


		/**
		 * enqueue_async_js adds ASYNC typekit js
		 * @return echoes JS
		 */
		function enqueue_async_js() {

			// Don't miss any google font
			if ( $this->reduxInstance ) {
				$typography = new ReduxFramework_typography( null, null, $this->reduxInstance );

				if ( ! empty ( $this->reduxInstance->typography ) ) {
					$families = array();
					foreach ( $this->reduxInstance->typography as $key => $value ) {
						$families[] = $key;
					}

					$google_script = 'var WebFontConfig = WebFontConfig || {}; WebFontConfig[\'google\'] = {families: [' . $typography->makeGoogleWebfontString ( $this->reduxInstance->typography ) . ']};';
					wp_add_inline_script( 'liquid-typekit', $google_script, 'before' );
				}
			}

			// Add typekit kit id
			$script = 'var WebFontConfig = WebFontConfig || {}; WebFontConfig[\'typekit\'] = { id: \'' . esc_js( $this->typekit_id ) . '\' };';
			wp_add_inline_script( 'liquid-typekit', $script, 'before' );
		}

		function enqueue_webfontloader() {

			ob_start(); ?>
				var WebFontConfig = WebFontConfig || {};
				WebFontConfig['events'] = true;
				WebFontConfig['timeout'] = 5000;
				WebFontConfig['active'] = function() {
					if ( typeof ( window.jQuery ) !== 'undefined' ) {
						jQuery(window).trigger('liquid_async_fonts_active');
					}
				};
				WebFontConfig['inactive'] = function() {
					if ( typeof ( window.jQuery ) !== 'undefined' ) {
						jQuery(window).trigger('liquid_async_fonts_inactive');
					}
				};

				(function(d) {
					var wf = d.createElement('script'), s = d.scripts[0];
					wf.src = 'https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js';
					s.parentNode.insertBefore(wf, s);
				})(document);
			<?php 
			$script = ( ob_get_clean() );
			wp_add_inline_script( 'liquid-typekit', $script, 'before' );

		}
		
		/**
		 * Only way to get in before redux's 
		 * webfont.js init routine.
		 */
		function set_callbacks_notypekit() {

			?>
			<script>
			var WebFontConfig = WebFontConfig || {};
			WebFontConfig['active'] = function() {
				if ( typeof ( window.jQuery ) !== 'undefined' ) {
					jQuery(window).trigger('liquid_async_fonts_active');
				}
			};
			WebFontConfig['inactive'] = function() {
				if ( typeof ( window.jQuery ) !== 'undefined' ) {
					jQuery(window).trigger('liquid_async_fonts_inactive');
				}
			};
			</script>
			<?php
		}
		
		function check_for_webfontloader( $redux ) {

			if ( ! $this->typekit_id ) { 
				add_action('wp_enqueue_scripts', array( $this, 'set_callbacks_notypekit'), 145 );
				return; 
			}

			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_webfontloader' ), 160 );
			
			// Stop redux from handling fonts
			$this->reduxInstance->args['async_typography']          = false;
			$this->reduxInstance->args['disable_google_fonts_link'] = true;

		}
		
		/**
		 * enqueue_backend_scripts
		 */
		function enqueue_backend_scripts() {

			wp_enqueue_script( 'liquid-redux-typekit-js', plugin_dir_url( __FILE__ ) . 'liquid-typekit.js', array( 'jquery' ), false, false );

			if ( ! empty( $this->typekit_fonts ) ) {
				wp_localize_script( 'liquid-redux-typekit-js', 'redux_typekit', array( 
					'fonts' => $this->typekit_fonts
				) );
			}
		}
	
	}

	new Liquid_Typekit;

}