<?php
namespace LiquidElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Utils;
use Elementor\Control_Media;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor heading widget.
 *
 * Elementor widget that displays an eye-catching headlines.
 *
 * @since 1.0.1
 */
class LD_Header_Woo_Search extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve heading widget name.
	 *
	 * @since 1.0.1
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ld_header_woo_search';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve heading widget title.
	 *
	 * @since 1.0.1
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Liquid Product Search', 'archub-elementor-addons' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve heading widget icon.
	 *
	 * @since 1.0.1
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-search lqd-element';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the heading widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since 1.0.1
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'hub-header', 'hub-woo' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 1.0.1
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'woocommerce', 'search' ];
	}


	public function __construct($data = [], $args = null) {

		parent::__construct($data, $args);
		
		wp_enqueue_script( 'ld-header-woo-search', 
			LD_ELEMENTOR_URL . 'assets/js/widgets/header-woo-search.js',
			[ 'jquery' ], 
			LD_ELEMENTOR_VERSION, 
			true
		);
		
	 }
  
	 public function get_script_depends() {
		 return [ 'ld-header-woo-search' ];
	 }

	/**
	 * Register heading widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.1
	 * @access protected
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'general_section',
			[
				'label' => __( 'General', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'enable_ajax',
			[
				'label' => __( 'Enable Ajax', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'on',
				'default' => '',
			]
		);

		$this->add_control(
			'enable_category_dropdown',
			[
				'label' => __( 'Enable Category Dropdown', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'on',
				'default' => '',
			]
		);

		$current_header_id = liquid_get_custom_header_id(); 
		$page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers( 'page' );
		$page_settings_model = $page_settings_manager->get_model( $current_header_id );

		if ( $page_settings_model->get_settings( 'enable_mobile_header_builder' ) === 'yes' ){
			$hide_for_mhb = array('lqd_hide' => 'true');
		} else {
			$hide_for_mhb = '';
		}

		$this->add_control(
			'show_on_mobile',
			[
				'label' => __( 'Show on Mobile', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'archub-elementor-addons' ),
				'label_off' => __( 'No', 'archub-elementor-addons' ),
				'return_value' => 'lqd-show-on-mobile',
				'default' => '',
				'condition' => $hide_for_mhb
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Render heading widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.1
	 * @access protected
	 */
	protected function render() {
		
		$settings = $this->get_settings_for_display();

		// check
		if ( ! liquid_helper()->is_woocommerce_active() ) {
			return;
		}

		$search_id = uniqid( 'search-' );

		$classes = [ 'liquid-wc-product-search' ];

		$category_dropdown = $settings[ 'enable_category_dropdown' ] === 'on';
		$ajax_search       = $settings[ 'enable_ajax' ] === 'on';

		$input_id = uniqid( 'liquid-wc-product-search-field-input-' );

		if ( $category_dropdown ) {
			$select_id    = uniqid( 'liquid-wc-product-search-field-select-' );
			$product_cats = get_terms( [ 'taxonomy' => 'product_cat' ] );
			$classes[]    = 'liquid-wc-product-search-category-enabled';
		}

		if ( $ajax_search ) {
			$classes[] = 'liquid-wc-product-search-ajax-enabled';
		}

		?>
		<div class="header-module module-product-search <?php echo esc_attr( $settings['show_on_mobile'] ); ?>">
			<span class="ld-module-trigger" data-ld-toggle="true" data-toggle="collapse" data-target="<?php echo esc_attr( '#' . $search_id ); ?>" aria-controls="<?php echo esc_attr( $search_id ); ?>" aria-expanded="false">
				<span class="ld-module-trigger-icon">
					<i class="lqd-icn-ess icon-ld-search"></i>
				</span>
			</span>
			<div class="ld-module-dropdown collapse pos-abs" id="<?php echo esc_attr( $search_id ); ?>" aria-expanded="false">
				<form role="search" method="get" class="<?php echo ld_helper()->sanitize_html_classes( $classes ); ?>"
					action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<label class="screen-reader-text"
						for="<?php echo esc_attr( $input_id ); ?>"><?php esc_html_e( 'Search for:', 'archub-elementor-addons' ); ?></label>
					<input type="search" id="<?php echo esc_attr( $input_id ); ?>" class="search-field"
						placeholder="<?php echo esc_attr__( 'Search products&hellip;', 'archub-elementor-addons' ); ?>"
						value="<?php echo get_search_query(); ?>" name="s" autocomplete="off"/>
					<label class="screen-reader-text"
						for="<?php echo esc_attr( $select_id ); ?>"><?php esc_html_e( 'Product Category:', 'archub-elementor-addons' ); ?></label>
					<?php if ( $category_dropdown ) { ?>
						<div class="search-field-select">
							<select id="<?php echo esc_attr( $select_id ); ?>" class="search-field" name="product_cat">
								<option value="" data-term-id=""><?php esc_html_e( 'All Categories', 'archub-elementor-addons' ); ?></option>
								<?php foreach ( $product_cats as $product_cat ) { ?>
									<option value="<?php echo esc_attr( $product_cat->slug ); ?>" data-term-id="<?php echo esc_attr( $product_cat->term_id ); ?>"><?php echo esc_html( $product_cat->name ); ?></option>
								<?php } ?>
							</select>
						</div>
					<?php } ?>
					<button type="submit">
						<span class="screen-reader-text"><?php echo esc_html_x( 'Search', 'submit button', 'archub-elementor-addons' ); ?></span>
						<i class="lqd-icn-ess icon-ld-search"></i>
						<span class="loading-icon">
							<i class="lqd-icn-ess icon-lqd-sync"></i>
						</span>
					</button>
					<input type="hidden" name="post_type" value="product"/>
				</form>
			</div>
		</div>

		<?php
		
	}

}
