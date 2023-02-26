<?php
namespace LiquidElementor;

/**
 * Class Liquid_Elementor
 *
 * Main Plugin class
 * @since 1.0
 */
class Liquid_Elementor {

	/**
	 * Instance
	 *
	 * @since 1.2.0
	 * @access private
	 * @static
	 *
	 * @var Plugin The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	/**
	 *  Plugin class constructor
	 *
	 * Register plugin action hooks and filters
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {

		include LD_ELEMENTOR_PATH . 'classes/icon-manager.php';
		include LD_ELEMENTOR_PATH . 'classes/section-controls.php';
		if ( function_exists('liquid_helper') && !empty( liquid_helper()->get_theme_option( 'typekit_id' ) ) ){ 
			include LD_ELEMENTOR_PATH . 'classes/typekit.php';
		}
		include LD_ELEMENTOR_PATH . 'classes/admin-menu.php';
		include LD_ELEMENTOR_PATH . 'includes/params/button.php';
		include LD_ELEMENTOR_PATH . 'includes/params/header-trigger.php';
		include LD_ELEMENTOR_PATH . 'includes/params/header-module-trigger.php';
		include LD_ELEMENTOR_PATH . 'includes/params/parallax.php';
		include LD_ELEMENTOR_PATH . 'includes/params/animations.php';
		include LD_ELEMENTOR_PATH . 'includes/params/testimonials.php';
		if ( function_exists('liquid_helper') && class_exists( 'WooCommerce' ) ) {
			include LD_ELEMENTOR_PATH . 'includes/params/woo-ajax-search.php'; 
		}
		if( function_exists('liquid_helper') && !empty( liquid_helper()->get_theme_option( 'mailchimp-api-key' ) ) ) {
			include LD_ELEMENTOR_PATH . 'includes/params/newsletter.php'; 
		}

		// WordPress Init
		add_action( 'init', function(){
			if( function_exists('liquid_helper') && liquid_helper()->get_theme_option( 'enable_optimized_files' ) == 'on' ) {
				if ( function_exists('liquid_helper') && ! liquid_helper()->get_assets_cache(liquid_helper()->get_page_id_by_url()) ) {
					include LD_ELEMENTOR_PATH . 'classes/widget-assets.php';
				}
			}
		} );

		// load elementor styles in the editor
		add_action( 'wp_enqueue_scripts', function(){
			
			// Load elementor-fronend css on archive pages
			if ( is_archive() || is_search() || is_home() || is_404() || !liquid_helper()->is_page_elementor() ) {
				wp_enqueue_style('elementor-frontend');
			}
			
			if ( \Elementor\Plugin::$instance->preview->is_preview_mode() ) {	
				wp_dequeue_style( 'liquid-theme' );
				wp_enqueue_style(
					'theme-elementor',
					LD_ELEMENTOR_URL . 'assets/css/theme-elementor.min.css',
					['elementor-frontend'],
					LD_ELEMENTOR_VERSION
				);

				wp_enqueue_style(
					'liquid-elementor-iframe',
					LD_ELEMENTOR_URL . 'assets/css/liquid-elementor-iframe.css',
					['theme-elementor'],
					LD_ELEMENTOR_VERSION
				);
			}
		});

		// Register widget scripts
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );

		// Register widgets
		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
		
		// Elementor After Enqueue
		add_action( 'elementor/editor/after_enqueue_scripts', function() {
			wp_enqueue_style(
				'liquid-elementor-editor-style',
				LD_ELEMENTOR_URL . 'assets/css/liquid-elementor-fe.css',
				['elementor-editor'],
				LD_ELEMENTOR_VERSION
			);

			wp_enqueue_style(
				'liquid-elementor-editor-style-dark',
				LD_ELEMENTOR_URL . 'assets/css/liquid-elementor-fe-dark.css',
				['elementor-editor'],
				LD_ELEMENTOR_VERSION,
				'(prefers-color-scheme: dark)'
			);

			wp_enqueue_script(
				'liquid-elementor-editor',
				LD_ELEMENTOR_URL . 'assets/js/liquid-elementor-fe.min.js',
				[],
				LD_ELEMENTOR_VERSION,
				true
			);

			// load Font Awesome for Elementor widget icon
			wp_enqueue_style(
				'font-awesome-all', 
				plugins_url() . '/elementor/assets/lib/font-awesome/css/all.min.css',
				['elementor-editor'],
				LD_ELEMENTOR_VERSION
			);
		} );

		// Elementor Preview CSS / JS
		add_action( 'elementor/preview/enqueue_styles', function() {
			wp_enqueue_script(
				'liquid-elementor-iframe',
				LD_ELEMENTOR_URL . 'assets/js/liquid-elementor-iframe.min.js',
				['elementor-frontend'],
				LD_ELEMENTOR_VERSION,
				true
			);
		} );

		// Add custom fonts to elementor from redux
		if ( function_exists('liquid_helper') ){ 
		
			if ( !empty( liquid_helper()->get_option( 'custom_font_title' )[0]) ){ 
				// Add Fonts Group
				add_filter( 'elementor/fonts/groups', function( $font_groups ) {
					$font_groups['liquid_custom_fonts'] = __( 'Liquid Custom Fonts' );
					return $font_groups;
				} );
	
				// Add Group Fonts
				add_filter( 'elementor/fonts/additional_fonts', function( $additional_fonts ) {
					$font_list = array_unique( liquid_helper()->get_option( 'custom_font_title' ) );
					foreach( $font_list as $font_name){
						// Font name/font group
						$additional_fonts[$font_name] = 'liquid_custom_fonts';
					}
					return $additional_fonts;
				} );
	
			}

			// Google Fonts display
			if ( get_option( 'elementor_font_display' ) !== liquid_helper()->get_theme_option( 'google_font_display' ) ) {
				update_option( 'elementor_font_display', liquid_helper()->get_theme_option( 'google_font_display' ) );
			}

		}

		// Add missing Google Fonts
		add_filter( 'elementor/fonts/additional_fonts', function( $additional_fonts ){
			if ( !is_array($additional_fonts) ) {
				$additional_fonts = [];
			}
			$fonts = array(
				// font name => font file (system / googlefonts / earlyaccess / local)
				'Outfit' => 'googlefonts'
			);
			$fonts = array_merge( $fonts, $additional_fonts );
			return $fonts;
		} );

		// Custom Shapes
		add_action( 'elementor/shapes/additional_shapes', function( $additional_shapes ) {

			for ($i=1; $i<=15; $i++){
				$additional_shapes[ 'lqd-custom-shape-'.$i ] = [
					'title' => __('Liquid Shape - '.$i, 'archub-elementor-addons'),
					'path' => LD_ELEMENTOR_PATH . 'includes/params/shape-divider/'.$i.'.svg',
					'url' => LD_ELEMENTOR_URL . 'includes/params/shape-divider/'.$i.'.svg',
					'has_flip' => false,
					'has_negative' => false,
				];
			}
			return $additional_shapes;
		});

		// Woocommerce Session Handler 
		if ( class_exists( 'WooCommerce' ) && (! empty( $_REQUEST['action'] ) && 'elementor' === $_REQUEST['action'] && is_admin()) ) {
            add_action( 'admin_action_elementor', function(){
				\WC()->frontend_includes();
				if ( is_null( \WC()->cart ) ) {
					global $woocommerce;
					$session_class = apply_filters( 'woocommerce_session_handler', 'WC_Session_Handler' );
					$woocommerce->session = new $session_class();
					$woocommerce->session->init();
		
					$woocommerce->cart     = new \WC_Cart();
					$woocommerce->customer = new \WC_Customer( get_current_user_id(), true );
				}
			}, 5 );
        }

		// Regenerate css after save for footer
		add_action( 'elementor/editor/after_save', function( $post_id ) {

			if ( 
				get_post_type( $post_id ) === 'liquid-header' || 
				get_post_type( $post_id ) === 'liquid-footer' || 
				get_post_type( $post_id ) === 'liquid-mega-menu'
			){
				\Elementor\Plugin::instance()->files_manager->clear_cache();
				liquid_helper()->purge_assets_cache( true );
			} else {
				\Elementor\Plugin::instance()->files_manager->clear_cache();
				liquid_helper()->purge_assets_cache( $post_id );
			}
    
		});

		// Purge assets cache after save for theme options
		add_action( 'redux/options/liquid_one_opt/saved', function() {
			\Elementor\Plugin::instance()->files_manager->clear_cache(); // regenerate elementor css
			liquid_helper()->purge_assets_cache( true ); // purge cache for all assets
		});
	}
	
	/**
	 * widget_scripts
	 *
	 * Load required plugin core files.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function widget_scripts() {
		
	}

	/**
	 * Include Widgets files
	 *
	 * Load widgets files
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function include_widgets_files() {

		// Header Footer Widgets
		if ( !\Elementor\Plugin::$instance->editor->is_edit_mode() || 
		( \Elementor\Plugin::$instance->editor->is_edit_mode() && (get_post_type() === 'liquid-header') || get_post_type() === 'elementor_library') ) {
			require __DIR__ . '/widgets/header-dropdown.php';
			require __DIR__ . '/widgets/header-fullproj.php';
			require __DIR__ . '/widgets/header-image.php';
			require __DIR__ . '/widgets/header-menu.php';
			require __DIR__ . '/widgets/header-search.php';
			require __DIR__ . '/widgets/header-separator.php';
			require __DIR__ . '/widgets/header-scroll-indicator.php';
			require __DIR__ . '/widgets/header-iconbox.php';
			require __DIR__ . '/widgets/header-trigger.php';
			require __DIR__ . '/widgets/sidedrawer.php';
			require __DIR__ . '/widgets/fullscreen-nav.php';

			// Woocommerce
			if ( class_exists( 'woocommerce' ) ) {
				require __DIR__ . '/widgets/header-cart.php';
				require __DIR__ . '/widgets/header-woo-search.php';
			}
		}
		// Porfolio Widgets
		if ( !\Elementor\Plugin::$instance->editor->is_edit_mode() || 
		( \Elementor\Plugin::$instance->editor->is_edit_mode() && (get_post_type() === 'liquid-portfolio') || get_post_type() === 'elementor_library') ) {
			require __DIR__ . '/widgets/pf-single-cover.php';
			require __DIR__ . '/widgets/pf-single-meta.php';
			require __DIR__ . '/widgets/pf-single-nav.php';
			require __DIR__ . '/widgets/pf-single-related.php';
		}
		// General Widgets
		require __DIR__ . '/widgets/1button.php';
		require __DIR__ . '/widgets/accordion.php';
		require __DIR__ . '/widgets/animated-frame.php';
		require __DIR__ . '/widgets/asymmetric-slider.php';
		require __DIR__ . '/widgets/banner.php';
		require __DIR__ . '/widgets/banner-bananas.php';
		require __DIR__ . '/widgets/blog.php';
		require __DIR__ . '/widgets/carousel.php';
		require __DIR__ . '/widgets/countdown.php';
		require __DIR__ . '/widgets/counter.php';
		require __DIR__ . '/widgets/custom-menu.php';
		require __DIR__ . '/widgets/custom-list.php';
		require __DIR__ . '/widgets/fancy-heading.php';
		require __DIR__ . '/widgets/fancy-box.php';
		require __DIR__ . '/widgets/fancy-image.php';
		require __DIR__ . '/widgets/flipbox.php';
		require __DIR__ . '/widgets/fullproj.php';
		require __DIR__ . '/widgets/gallery.php';
		require __DIR__ . '/widgets/icon-box-circle.php';
		require __DIR__ . '/widgets/icon-box.php';
		require __DIR__ . '/widgets/image-comparison.php';
		require __DIR__ . '/widgets/image-text-overlay.php';
		require __DIR__ . '/widgets/image-text-slider.php';
		require __DIR__ . '/widgets/instagram.php';
		require __DIR__ . '/widgets/mask-slider.php';
		require __DIR__ . '/widgets/media-element.php';
		require __DIR__ . '/widgets/modal-window.php';
		require __DIR__ . '/widgets/milestone.php';
		require __DIR__ . '/widgets/newsletter.php';
		require __DIR__ . '/widgets/particles.php';
		require __DIR__ . '/widgets/google-map.php';
		require __DIR__ . '/widgets/hotspots.php';
		require __DIR__ . '/widgets/process-box.php';
		require __DIR__ . '/widgets/progressbar.php';
		require __DIR__ . '/widgets/roadmap.php';
		require __DIR__ . '/widgets/portfolio.php';
		require __DIR__ . '/widgets/price-table.php';
		require __DIR__ . '/widgets/services-slideshow.php';
		require __DIR__ . '/widgets/slideshow-2.php';
		require __DIR__ . '/widgets/slideshow.php';
		require __DIR__ . '/widgets/team-member.php';
		require __DIR__ . '/widgets/tabs.php';
		require __DIR__ . '/widgets/testimonial-carousel.php';
		require __DIR__ . '/widgets/testimonial.php';
		require __DIR__ . '/widgets/typewriter.php';
		require __DIR__ . '/widgets/overlay-link.php';
		require __DIR__ . '/widgets/interactive-text-image.php';
		// Woocommerce Widgets
		if ( class_exists( 'woocommerce' ) ) {
			require __DIR__ . '/widgets/woo-product-add-to-cart.php';
			require __DIR__ . '/widgets/woo-product-description.php';
			require __DIR__ . '/widgets/woo-product-image.php';
			require __DIR__ . '/widgets/woo-product-meta.php';
			require __DIR__ . '/widgets/woo-product-price.php';
			require __DIR__ . '/widgets/woo-product-rating.php';
			require __DIR__ . '/widgets/woo-product-related.php';
			require __DIR__ . '/widgets/woo-product-sharing.php';
			require __DIR__ . '/widgets/woo-product-tabs.php';
			require __DIR__ . '/widgets/woo-product-title.php';
			require __DIR__ . '/widgets/woo-product-upsell.php';
			require __DIR__ . '/widgets/woo-products-list.php';
			require __DIR__ . '/widgets/woo-products.php';
		}

		if ( defined( 'WPCF7_PLUGIN' ) ) {
			require __DIR__ . '/widgets/contact-form.php';
		}
		

	}

	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function register_widgets() {
		// Its is now safe to include Widgets files
		$this->include_widgets_files();

		// Header Footer Widgets
		if ( !\Elementor\Plugin::$instance->editor->is_edit_mode() || 
		( \Elementor\Plugin::$instance->editor->is_edit_mode() && (get_post_type() === 'liquid-header') || get_post_type() === 'elementor_library') ) {
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Header_Dropdown() );
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Header_Fullproj() );
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Header_Image() );
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Header_Menu() );
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Header_Search() );
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Header_Separator() );
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Header_Scroll_Indicator() );
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Header_IconBox() );
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Header_Trigger() );
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Header_Sidedrawer() );
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Fullscreen_Nav() );

			// Woocommerce
			if ( class_exists( 'woocommerce' ) ) {
				\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Header_Cart() );
				\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Header_Woo_Search() );
			}
		}
		// Porfolio Widgets
		if ( !\Elementor\Plugin::$instance->editor->is_edit_mode() || 
		( \Elementor\Plugin::$instance->editor->is_edit_mode() && (get_post_type() === 'liquid-portfolio') || get_post_type() === 'elementor_library') ) {
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Pf_Single_Cover() );
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Pf_Single_Meta() );
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Pf_Single_Nav() );
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Pf_Single_Related() );
		}
		// General Widgets
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Accordion() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Animated_Frame() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Asymmetric_Slider() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Banner() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Bananas_Banner() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Button() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Blog() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Carousel() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Custom_Menu() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Content_Box() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Countdown() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Counter() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_List() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Fancy_Heading() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Fancy_Image() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Flipbox() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Fullproj() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Gallery() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Icon_Box_Circle() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Icon_Box() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Images_Comparison() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Images_Text_Overlay() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Image_Text_Slider() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Instagram() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Mask_Slider() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Media_Element() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Modal_Window() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Milestone() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Newsletter() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Particles() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Google_Map() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Hotspots() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Process_Box() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Progressbar() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Roadmap() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Portfolio() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Price_Table() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Services_Slideshow() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Slideshow_2() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Slideshow() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Team_Member() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Tabs() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Testimonial_Carousel() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Testimonial() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Typewriter() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Overlay_Link() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Interactive_Text_Image() );
		// Woocommerce Widgets
		if ( class_exists( 'woocommerce' ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Woo_Product_Add_To_Cart() );
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Woo_Product_Description() );
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Woo_Product_Image() );
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Woo_Product_Meta() );
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Woo_Product_Price() );
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Woo_Product_Rating() );
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Woo_Product_Related() );
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Woo_Product_Sharing() );
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Woo_Product_Tabs() );
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Woo_Product_Title() );
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Woo_Product_Upsell() );
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Woo_Products_List() );
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Woo_Products() );
		}

		if ( defined( 'WPCF7_PLUGIN' ) ) {
			\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\LD_Contact_Form_() );
		}
		
	}

}

// Instantiate Plugin Class
Liquid_Elementor::instance();