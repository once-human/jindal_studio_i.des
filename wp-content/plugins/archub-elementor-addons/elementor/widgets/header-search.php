<?php
namespace LiquidElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Schemes\Color;
use Elementor\Schemes\Typography;
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
 * @since 1.0.0
 */
class LD_Header_Search extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve heading widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ld_header_search';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve heading widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Liquid Header Search', 'archub-elementor-addons' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve heading widget icon.
	 *
	 * @since 1.0.0
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
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'hub-header' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'header', 'search' ];
	}

	/**
	 * Register heading widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {

		// General Section
		$this->start_controls_section(
			'general_section',
			array(
				'label' => __( 'Header Search', 'archub-elementor-addons' ),
			)
		);

		$this->add_control(
			'style',
			[
				'label' => __( 'Style', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => __( 'Default', 'archub-elementor-addons' ),
					'frame' => __( 'Frame', 'archub-elementor-addons' ),
					'slide-top' => __( 'Slide Top', 'archub-elementor-addons' ),
					'zoom-out' => __( 'Zoom Out', 'archub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'search_type',
			[
				'label' => __( 'Search by', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'post',
				'options' => [
					'all'  => __( 'All', 'archub-elementor-addons' ),
					'post'  => __( 'Post', 'archub-elementor-addons' ),
					'product' => __( 'Product', 'archub-elementor-addons' ),
					'custom' => __( 'Custom', 'archub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'custom_search_type',
			[
				'label' => __( 'Custom post type', 'archub-elementor-addons' ),
				'description' => __( 'Enter the custom post type slug', 'archub-elementor-addons' ),
				'placeholder' => 'my-post-type-slug',
				'type' => Controls_Manager::TEXT,
				'condition' => [
					'search_type' => 'custom',
				],
			]
		);


		$this->add_control(
			'show_icon',
			[
				'label' => __( 'Show Icon', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'archub-elementor-addons' ),
				'label_off' => __( 'No', 'archub-elementor-addons' ),
				'return_value' => 'yes', 
				'default' => 'yes',
				'separator' => 'before',
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

		$this->add_control(
			'description',
			[
				'label' => __( 'Description', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Type and hit enter', 'archub-elementor-addons' ),
				'placeholder' => __( 'Description under serchform', 'archub-elementor-addons' ),
			]
		);

		$this->add_control(
			'suggestions_title',
			[
				'label' => __( 'Title', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'May We Suggest?', 'archub-elementor-addons' ),
				'placeholder' => __( 'Add title for suggestions', 'archub-elementor-addons' ),
				'condition' => array(
					'style' => array( 'frame', 'zoom-out' ),
				)
			]
		);

		$this->add_control(
			'suggestions',
			[
				'label' => __( 'Suggestion Text', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( '#drone #funny #catgif #broken #lost', 'archub-elementor-addons' ),
				'placeholder' => __( 'Add text for suggestions. for ex. #drone #funny #catgif #broken #lost', 'archub-elementor-addons' ),
				'condition' => array(
					'style' => array( 'frame', 'zoom-out' ),
				)
			]
		);

		$this->add_control(
			'suggestions_title2',
			[
				'label' => __( 'Title 2', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Is It This?', 'archub-elementor-addons' ),
				'placeholder' => __( 'Add title for suggestions', 'archub-elementor-addons' ),
				'condition' => array(
					'style' => array( 'frame', 'zoom-out' ),
				)
			]
		);

		$this->add_control(
			'suggestions2',
			[
				'label' => __( 'Suggestion Text 2', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( '#drone #funny #catgif #broken #lost', 'archub-elementor-addons' ),
				'placeholder' => __( 'Add text for suggestions. for ex. #drone #funny #catgif #broken #lost', 'archub-elementor-addons' ),
				'condition' => array(
					'style' => array( 'frame', 'zoom-out' ),
				)
			]
		);

		$this->add_control(
			'suggestions_title3',
			[
				'label' => __( 'Title 3', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Needle, Where Art Thou?', 'archub-elementor-addons' ),
				'placeholder' => __( 'Add title for suggestions', 'archub-elementor-addons' ),
				'condition' => array(
					'style' => array( 'frame', 'zoom-out' ),
				)
			]
		);

		$this->add_control(
			'suggestions3',
			[
				'label' => __( 'Suggestion Text 3', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( '#drone #funny #catgif #broken #lost', 'archub-elementor-addons' ),
				'placeholder' => __( 'Add text for suggestions. for ex. #drone #funny #catgif #broken #lost', 'archub-elementor-addons' ),
				'condition' => array(
					'style' => array( 'frame', 'zoom-out' ),
				)
			]
		);
		$this->end_controls_section();
		
		$this->start_controls_section(
			'style_section',
			[
				'label' => __( 'Style', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'label_typography',
					'label' => __( 'Label Typography', 'archub-elementor-addons' ),
					'selector' => '{{WRAPPER}} .ld-module-trigger-txt',
				]
			);

			$this->add_control(
				'primary_color',
				[
					'label' => __( 'Primary Color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ld-module-search .ld-module-trigger' => 'color: {{VALUE}}',
					],
				]
			);
		$this->end_controls_section();

		ld_el_module_trigger( $pf = $this, $pf2 = 'hmt_' );
	}

	/**
	 * Render heading widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		
		$atts = $this->get_settings_for_display();

		$style = isset( $atts['style'] ) ? $atts['style'] : 'default';
		$search_type = $atts['search_type'];

		if ( $search_type == 'custom' && empty( $atts['custom_search_type'] ) ) {
			$search_type = 'all';
		} else if ( $search_type == 'custom' && !empty( $atts['custom_search_type'] ) ) {
			$search_type = $atts['custom_search_type'];
		}

		// check
		$located = locate_template( "templates/header/header-search-$style.php" );

		if ( !file_exists( $located ) ) {
			$located = locate_template( 'templates/header/header-search.php' );
		}

		?>		
			<div class="d-flex <?php echo esc_attr( $atts['show_on_mobile'] ); ?>">
				<?php include $located; ?>
			</div>
		<?php

	}

}
