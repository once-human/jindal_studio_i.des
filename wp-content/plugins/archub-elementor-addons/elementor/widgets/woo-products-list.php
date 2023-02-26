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
 * @since 1.0.0
 */
class LD_Woo_Products_List extends Widget_Base {

	/**
	 * Shortcode type.
	 *
	 * @since 3.2.0
	 * @var   string
	 */
	protected $type = 'liquid_products';

	/**
	 * [$post_type description]
	 * @var string
	 */
	private $post_type = 'product';

	/**
	 * Attributes.
	 *
	 * @since 3.2.0
	 * @var   array
	 */
	protected $attributes = array();


	/**
	 * Query args.
	 *
	 * @since 3.2.0
	 * @var   array
	 */
	protected $query_args = array();

	/**
	* [$taxonomies description]
	* @var array
	*/
	private $taxonomies = array( 'product_cat' );

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
		return 'ld_woo_products_list';
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
		return __( 'Liquid Woo Products', 'archub-elementor-addons' );
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
		return 'eicon-products lqd-element';
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
		return [ 'hub-woo' ];
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
		return [ 'woocommerce', 'products' ];
	}

	/**
	 * Retrieve the list of scripts the counter widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {

		if ( liquid_helper()->liquid_elementor_script_depends() ){
			return [ 'flickity' ];
		} else {
			return [''];
		}
		
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
			[
				'label' => __( 'General', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'template',
			[
				'label' => __( 'Layout Style', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'grid',
				'options' => [
					'grid' => __( 'Grid', 'archub-elementor-addons' ),
					'masonry' => __( 'Masonry', 'archub-elementor-addons' ),
					'carousel' => __( 'Carousel', 'archub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'enable_gallery',
			[
				'label' => __( 'Show Gallery?', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'grid_columns',
			[
				'label' => __( 'Columns', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '3',
				'options' => [
					'1' => __( '1 Column', 'archub-elementor-addons' ),
					'2' => __( '2 Columns', 'archub-elementor-addons' ),
					'3' => __( '3 Columns', 'archub-elementor-addons' ),
					'4' => __( '4 Columns', 'archub-elementor-addons' ),
					'5' => __( '5 Columns', 'archub-elementor-addons' ),
					'6' => __( '6 Columns', 'archub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'columns_gap',
			[
				'label' => __( 'Columns Gap', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 35,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 15,
				],
				'selectors' => [
					'{{WRAPPER}} ul.products li.product' => 'padding-inline-start: {{SIZE}}{{UNIT}}; padding-inline-end: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'fadesides',
			[
				'label' => __( 'Fade Sides Carousel', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'lqd-fade-sides',
				'default' => '',
				'condition' => [
					'template' => 'carousel'
				]
			]
		);

		
		$this->add_control(
			'wraparound',
			[
				'label' => __( 'Carousel Loop', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
				'condition' => [
					'template' => 'carousel'
				]
			]
		);
				
		$this->add_control(
			'draggable',
			[
				'label' => __( 'Draggable', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
				'condition' => [
					'template' => 'carousel'
				]
			]
		);

						
		$this->add_control(
			'freescroll',
			[
				'label' => __( 'Free Scroll', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
				'condition' => [
					'template' => 'carousel'
				]
			]
		);
				
		$this->add_control(
			'autoplay',
			[
				'label' => __( 'Autoplay', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
				'condition' => [
					'template' => 'carousel'
				]
			]
		);

		$this->add_control(
			'autoplaytime',
			[
				'label' => __( 'Autoplay Delay', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'milliseconds', 'archub-elementor-addons' ),
				'condition' => [
					'autoplay' => 'yes'
				]
			]
		);

		$this->add_control(
			'pauseautoplayonhover',
			[
				'label' => __( 'Pause AutoPlay On Hover', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
				'condition' => [
					'autoplay' => 'yes'
				]
			]
		);

		$this->add_control(
			'prevnextbuttons',
			[
				'label' => __( 'Navigation Arrows', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '', 
				'condition' => [
					'template' => 'carousel'
				]
			]
		);
			
		$this->add_control(
			'show_filter',
			[
				'label' => __( 'Enable filter?', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '', 
				'condition' => [
					'template!' => 'grid'
				]
			]
		);

		$this->add_control(
			'pagination',
			[
				'label' => __( 'Pagination', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none' => __( 'None', 'archub-elementor-addons' ),
					'ajax' => __( 'Ajax', 'archub-elementor-addons' ),
					'pagination' => __( 'Pagination', 'archub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'ajax_trigger',
			[
				'label' => __( 'Ajax Trigger', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'click',
				'options' => [
					'click' => __( 'Click', 'archub-elementor-addons' ),
					'inview' => __( 'Inview', 'archub-elementor-addons' ),
				],
				'condition' => [
					'pagination' => 'ajax'
				]
			]
		);

		$this->add_control(
			'ajax_text',
			[
				'label' => __( 'Ajax button text', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Load more', 'archub-elementor-addons' ),
				'condition' => [
					'pagination' => 'ajax'
				]
			]
		);

		$this->add_control(
			'limit',
			[
				'label' => __( 'Limit', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => '8',
			]
		);
		$this->end_controls_section();

		// Data
		$this->start_controls_section(
			'data_section',
			[
				'label' => __( 'Data', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'taxonomies',
			[
				'label' => __( 'Categories', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => $this->get_woo_cat(),
			]
		);

		$this->add_control(
			'orderby',
			[
				'label' => __( 'Order by', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'rand' => __( 'Rand', 'archub-elementor-addons' ),
					'date' => __( 'Date', 'archub-elementor-addons' ),
					'price' => __( 'Price', 'archub-elementor-addons' ),
					'popularity' => __( 'Popularity', 'archub-elementor-addons' ),
					'rating' => __( 'Rating', 'archub-elementor-addons' ),
					'title' => __( 'Title', 'archub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label' => __( 'Order', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'asc',
				'options' => [
					'asc' => __( 'Ascending', 'archub-elementor-addons' ),
					'desc' => __( 'Descending', 'archub-elementor-addons' ),
				],
				'condition' => [
					'orderby' => [ 'date', 'price', 'title' ]
				],
			]
		);

		$this->add_control(
			'show',
			[
				'label' => __( 'Show', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'All Products', 'archub-elementor-addons' ),
					'featured' => __( 'Featured Products', 'archub-elementor-addons' ),
					'onsale' => __( 'On-sale Products', 'archub-elementor-addons' ),
				],
			]
		);
		$this->end_controls_section();

		// Navigation
		$this->start_controls_section(
			'navigation_section',
			[
				'label' => __( 'Navigation', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'prevnextbuttons' => 'yes'
				]
			]
		);

		$this->add_control(
			'navarrow',
			[
				'label' => __( 'Style', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'None', 'archub-elementor-addons' ),
					'1' => __( 'Style 2', 'archub-elementor-addons' ),
					'2' => __( 'Default', 'archub-elementor-addons' ),
					'3' => __( 'Style 3', 'archub-elementor-addons' ),
					'4' => __( 'Style 4', 'archub-elementor-addons' ),
					'5' => __( 'Style 5', 'archub-elementor-addons' ),
					'6' => __( 'Style 6', 'archub-elementor-addons' ),
					'custom' => __( 'Custom', 'archub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'navappend',
			[
				'label' => __( 'Append Navigation Arrows To', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'self',
				'options' => [
					'self' => __( 'Carousel itself', 'archub-elementor-addons' ),
					'parent_row' => __( 'Parent Row', 'archub-elementor-addons' ),
					'custom_id' => __( 'Other Elements', 'archub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'navappend_id',
			[
				'label' => __( 'ID to Append navigation arrows', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => __( 'ex. #heading-id', 'archub-elementor-addons' ),
				'condition' => [
					'navappend' => 'custom_id'
				],
			]
		);

		$this->add_control(
			'prev',
			[
				'label' => __( 'Previous Button', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'placeholder' => __( 'for ex <i class=\"fa fa-angle-left\"></i>', 'archub-elementor-addons' ),
				'condition' => [
					'navarrow' => 'custom'
				],
			]
		);

		$this->add_control(
			'next',
			[
				'label' => __( 'Next Button', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'placeholder' => __( 'for ex <i class=\"fa fa-angle-right\"></i>', 'archub-elementor-addons' ),
				'condition' => [
					'navarrow' => 'custom'
				],
			]
		);

		$this->add_control(
			'navsize',
			[
				'label' => __( 'Navigation Arrow Size', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'carousel-nav-md',
				'options' => [
					'carousel-nav-md' => __( 'Default', 'archub-elementor-addons' ),
					'carousel-nav-sm' => __( 'Small', 'archub-elementor-addons' ),
					'carousel-nav-lg' => __( 'Large', 'archub-elementor-addons' ),
					'carousel-nav-xl' => __( 'Extra Large', 'archub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'navfill',
			[
				'label' => __( 'Fill Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'None', 'archub-elementor-addons' ),
					'carousel-nav-bordered' => __( 'Bordered', 'archub-elementor-addons' ),
					'carousel-nav-solid' => __( 'Solid', 'archub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'navshape',
			[
				'label' => __( 'Shape Style', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'None', 'archub-elementor-addons' ),
					'carousel-nav-rectangle' => __( 'Rectangle', 'archub-elementor-addons' ),
					'carousel-nav-square' => __( 'Square', 'archub-elementor-addons' ),
					'carousel-nav-circle' => __( 'Circle', 'archub-elementor-addons' ),
				],
			]
		);
		
		$this->add_control(
			'navshadow',
			[
				'label' => __( 'Shadow Styles', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'None', 'archub-elementor-addons' ),
					'carousel-nav-shadowed' => __( 'Shadow', 'archub-elementor-addons' ),
					'carousel-nav-shadowed-onhover' => __( 'Shadow on hover', 'archub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'navhalign',
			[
				'label' => __( 'Navigation Arrows Alignment', 'archub-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'carousel-nav-left' => [
						'title' => __( 'Left', 'archub-elementor-addons' ),
						'icon' => 'fa fa-align-left',
					],
					'carousel-nav-center' => [
						'title' => __( 'Center', 'archub-elementor-addons' ),
						'icon' => 'fa fa-align-center',
					],
					'carousel-nav-right' => [
						'title' => __( 'Right', 'archub-elementor-addons' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'carousel-nav-center',
				'toggle' => true,
			]
		);

		$this->add_control(
			'navfloated',
			[
				'label' => __( 'Floated Navigation Arrows', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'carousel-nav-floated',
				'default' => '',
			]
		);

		$this->add_control(
			'navvalign',
			[
				'label' => __( 'Navigation Arrows Vertical Position', 'archub-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => true,
				'options' => [
					'' => [
						'title' => __( 'Default', 'archub-elementor-addons' ),
						'icon' => 'fa fa-minus',
					],
					'carousel-nav-top' => [
						'title' => __( 'Top', 'archub-elementor-addons' ),
						'icon' => 'eicon-v-align-top',
					],
					'carousel-nav-middle' => [
						'title' => __( 'Middle', 'archub-elementor-addons' ),
						'icon' => 'eicon-v-align-middle',
					],
					'carousel-nav-bottom' => [
						'title' => __( 'Bottom', 'archub-elementor-addons' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'default' => '',
				'toggle' => false,
				'condition' => [
					'navfloated' => [ 'carousel-nav-floated' ]
				],
			]
		);

		$this->add_control(
			'navdirection',
			[
				'label' => __( 'Navigation Arrows Direction', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Default', 'archub-elementor-addons' ),
					'carousel-nav-vertical' => __( 'Vertical', 'archub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'navslidernumberstoarrows',
			[
				'label' => __( 'Numbers to Arrows', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '', // no to null
			]
		);

		$this->add_control(
			'navline',
			[
				'label' => __( 'Arrows Separator', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'arousel-nav-dot-between', 
				'default' => '', // no to null
				'condition' => [
					'navslidernumberstoarrows' => '' 
				],
			]
		);

		$this->add_control(
			'navoffset',
			[
				'label' => __( 'Navigation Arrows Offset', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => __( 'ex. top:20%', 'archub-elementor-addons' ),
			]
		);

		$this->add_control(
			'prevoffset',
			[
				'label' => __( 'Previous Button Offset', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => __( 'ex. 10px', 'archub-elementor-addons' ),
			]
		);

		$this->add_control(
			'nextoffset',
			[
				'label' => __( 'Next Button Offset', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => __( 'ex. 10px', 'archub-elementor-addons' ),
			]
		);

		$this->add_control(
			'shapesize',
			[
				'label' => __( 'Navigation Arrow Shape Size', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => __( 'ex. 10px', 'archub-elementor-addons' ),
				'condition' => [
					'navshape' => [ 'carousel-nav-square', 'carousel-nav-circle' ]
				],
			]
		);

		$this->add_control(
			'shapeheight',
			[
				'label' => __( 'Navigation Arrow Shape Height', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => __( 'ex. 10px', 'archub-elementor-addons' ),
				'condition' => [
					'navshape' => [ 'carousel-nav-rectangle' ]
				],
			]
		);

		$this->add_control(
			'shapewidth',
			[
				'label' => __( 'Navigation Arrow Shape Width', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => __( 'ex. 10px', 'archub-elementor-addons' ),
				'condition' => [
					'navshape' => [ 'carousel-nav-rectangle' ]
				],
			]
		);
		$this->end_controls_section();

		// Navigation Colors
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Navigation Colors', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'prevnextbuttons' => 'yes',
				],
			]
		);

		$this->add_control(
			'nav_arrow_color',
			[
				'label' => __( 'Arrow Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .carousel-nav .flickity-button svg' => 'stroke: {{VALUE}}',
					'{{WRAPPER}} .carousel-nav .flickity-button' => 'color: {{VALUE}}',
					'{{WRAPPER}} .carousel-nav .flickity-button.previous:after' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'nav_arrow_color_hover',
			[
				'label' => __( 'Arrow Hover Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .carousel-nav .flickity-button:hover svg' => 'stroke: {{VALUE}}',
					'{{WRAPPER}} .carousel-nav .flickity-button:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'nav_arrow_numbers',
			[
				'label' => __( 'Arrow Numbers Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .carousel-nav .lqd-carousel-slides' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'nav_border_color',
			[
				'label' => __( 'Border Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .carousel-nav .flickity-button' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .carousel-nav .flickity-button.previous:after' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'nav_border_hcolor',
			[
				'label' => __( 'Border Hover Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .carousel-nav .flickity-button:hover' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'nav_bg_color',
			[
				'label' => __( 'Background', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .carousel-nav .flickity-button' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'nav_bg_hcolor',
			[
				'label' => __( 'Background Hover', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .carousel-nav .flickity-button:before' => 'background: {{VALUE}}',
				],
			]
		);
		$this->end_controls_section();

		// Filter Section
		$this->start_controls_section(
			'filter_section',
			[
				'label' => __( 'Filter', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'show_filter' => 'yes',
					'template!' => 'grid'
				],
			]
		);

		$this->add_control(
			'filter_cats',
			[
				'label' => __( 'Categories', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => $this->get_woo_cat(),
				'default' => [ 'title', 'description' ],
			]
		);

		$this->add_control(
			'filter_enable_counter',
			[
				'label' => __( 'Show Counter?', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'filter_lbl_all',
			[
				'label' => __( 'Label "All"', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'All', 'archub-elementor-addons' ),
				'placeholder' => __( 'Type your title here', 'archub-elementor-addons' ),
			]
		);

		$this->add_control(
			'filter_align',
			[
				'label' => __( 'Filter Alignment', 'archub-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => __( 'Left', 'archub-elementor-addons' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => __( 'Use Global Settings', 'archub-elementor-addons' ),
						'icon' => 'eicon-h-align-center',
					],
					'flex-end' => [
						'title' => __( 'Right', 'archub-elementor-addons' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => 'flex-start',
				'toggle' => false,
				'selectors' => [
					'{{WRAPPER}} .liquid-filter-items' => 'justify-content: {{VALUE}}!important',
				],
			]
		);

		$this->add_control(
			'filter_mb',
			[
				'label' => __( 'Filter Margin Bottom', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .liquid-filter-items' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();

		// Filter Color
		$this->start_controls_section(
			'filter_color_section',
			[
				'label' => __( 'Filter Style', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_filter' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'filter_typography',
				'label' => __( 'Typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} ul.filter-list',
			]
		);

		$this->add_control(
			'filter_normal_color',
			[
				'label' => __('Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .filter-list li,{{WRAPPER}} .lqd-filter-dropdown .ui-button' => 'color: {{VALUE}}',
					'{{WRAPPER}} .lqd-filter-dropdown .ui-button' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'filter_hover_color',
			[
				'label' => __( 'Hover/Active Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .filter-list li.active, {{WRAPPER}} .filter-list li.hover,{{WRAPPER}} .lqd-filter-dropdown .ui-button:active, {{WRAPPER}} .lqd-filter-dropdown .ui-button:focus' => 'color: {{VALUE}}',
					'{{WRAPPER}} .lqd-filter-dropdown .ui-button:active, {{WRAPPER}} .lqd-filter-dropdown .ui-button:focus' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'filter_dec_color',
			[
				'label' => __( 'Decoration Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .filters-underline li span:after, {{WRAPPER}} .filters-line-through li span:after' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'mobile_filter_normal_color',
			[
				'label' => __( 'Mobile Filter Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-filter-dropdown .ui-button' => 'color: {{VALUE}}',
					'{{WRAPPER}} .lqd-filter-dropdown .ui-button' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'mobile_filter_hover_color',
			[
				'label' => __( 'Mobile Hover/Active Filter Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-filter-dropdown .ui-button:active, {{WRAPPER}} .lqd-filter-dropdown .ui-button:focus' => 'color: {{VALUE}}',
					'{{WRAPPER}} .lqd-filter-dropdown .ui-button:active, {{WRAPPER}} .lqd-filter-dropdown .ui-button:focus' => 'border-color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_section();

		// Style Tab
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
				'name' => 'product_title_typo',
				'label' => __( 'Product title typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .woocommerce ul.products li.product a',
			]
		);

		$this->add_control(
			'product_title_color',
			[
				'label' => __( 'Product title color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce ul.products li.product a' => 'color: {{VALUE}};',
				],
				'separator' => 'after',
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'product_price_typo',
				'label' => __( 'Product price typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .woocommerce ul.products li.product .price',
			]
		);

		$this->add_control(
			'product_price_color',
			[
				'label' => __( 'Product price color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce ul.products li.product .price' => 'color: {{VALUE}};',
				],
				'separator' => 'after',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'product_button_typo',
				'label' => __( 'Button typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .ld-sp-btn',
			]
		);

		// Button normal state
		$this->start_controls_tabs(
			'product_button_colors_tab'
		);

		$this->start_controls_tab(
			'product_button_colors_normal',
			[
				'label' => __( 'Normal', 'archub-elementor-addons' ),
			]
		);

		$this->add_control(
			'product_button_color',
			[
				'label' => __( 'Button Text Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ld-sp-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'product_button_bg',
				'label' => __( 'Button background', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .ld-sp-btn',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'load_more_button_color',
			[
				'label' => __( 'Load More Button Text Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .page-nav .btn' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
				'condition' => [
					'pagination' => 'ajax'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'load_more_button_bg',
				'label' => __( 'Load More Button background', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .page-nav .btn',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
				'condition' => [
					'pagination' => 'ajax'
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'product_button_colors_hover',
			[
				'label' => __( 'Hover', 'archub-elementor-addons' ),
			]
		);

		$this->add_control(
			'product_button_color_hover',
			[
				'label' => __( 'Button Text Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ld-sp-btn:hover, {{WRAPPER}} .ld-sp-btn:focus' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'product_button_bg_hover',
				'label' => __( 'Button background', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .ld-sp-btn:hover, {{WRAPPER}} .ld-sp-btn:focus',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'load_more_button_h_color',
			[
				'label' => __( 'Load More Button Text Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .page-nav .btn:hover' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
				'condition' => [
					'pagination' => 'ajax'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'load_more_button_h_bg',
				'label' => __( 'Load More Button background', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .page-nav .btn:hover',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
				'condition' => [
					'pagination' => 'ajax'
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}
	

	protected function get_woo_cat() {

		$taxonomies = get_categories(  
			array( 
				'taxonomy' => 'product_cat',
				'orderby' => 'name',
			)
		);
	
		$options = [ '' => '' ];
	
		foreach ( $taxonomies as $taxonomy ) {
		  $options[ $taxonomy->slug ] = $taxonomy->name;
		}
	
		return $options;
	}

	public function add_ul_classname( $class = array() ) {
		
		$class[] = 'reset-ul';
		$class[] = 'lqd-prods-row';
		
		return $class;
	}
	
	public function add_product_classname( $class = array() ) {

		$class[] = 'lqd-prod-item';
		$class[] = $this->entry_term_classes();

		return $class;
	}


	public function get_grid_class( $class = array() ) {

		$columns = $this->get_settings_for_display( 'grid_columns' );
		$width = get_post_meta( get_the_ID(), 'product-item-width', true );

		if ( !empty( $width ) ) {
			$class[] = sprintf( 'col-md-%s col-sm-6 col-xs-12', $width );
			return $class;
		}
		else {

			$hash = array(
				'1' => '12',
				'2' => '6',
				'3' => '4',
				'4' => '3',
				'5' => '5',
				'6' => '2'
			);
			
			if( '5' == $hash[ $columns ] )  {
				$class[] = 'vc_col-md-1/5 col-sm-6 col-xs-12';
			} else {
				$class[] = sprintf( 'col-md-%s col-sm-6 col-xs-12', isset( $hash[ $columns ] ) ? $hash[ $columns ] : '12' );
			}
			
			return $class;
			
		}

	}
	
	public function woocommerce_product_loop_start( $ob_get_clean ) {

		ob_start();
		
		include locate_template( 'woo-products-list/loop/loop-start.php' );
		
		return ob_get_clean();
		
	}

	/**
	 * [entry_term_classes description]
	 * @method entry_term_classes
	 * @return [type]             [description]
	 */
	protected function entry_term_classes() {

		$terms = get_the_terms( get_the_ID(), 'product_cat' );
		if( !$terms ) {
			return;
		}
		$terms = wp_list_pluck( $terms, 'slug' );
		return join( ' ', $terms );

	}
	

	protected function get_options() {

		$settings = $this->get_settings_for_display();

		$default_args = array(
			'carouselEl'       => 'ul.products',
			'filters'          => '#lqd-woo-filter-' . $this->get_id(),
			'equalHeightCells' => true,
			'prevNextButtons'  => true,
			'navArrow'         => $settings['navarrow'],
			'wrapAround'       => true,
			
		);
		
		if( empty( $settings['navarrow'] ) ) {
			unset( $default_args['navArrow'] );
		}
		$opts = $offset_values = array();
		
		if( empty($settings['prevnextbuttons']) ) {
			$opts['prevNextButtons'] = false;
		}
		if( !empty( $settings['autoplay'] ) ) {
			$opts['autoPlay'] = true;
		}
		if( !empty( $settings['autoplaytime'] ) ) {
			$opts['autoPlay'] = $settings['autoplaytime'];
		}
		if( 'yes' === $settings['pauseautoplayonhover'] ) {
			$opts['pauseAutoPlayOnHover'] = true;
		}
		if( empty($settings['draggable']) ) {
			$opts['draggable'] = false;
		}
		if( !empty( $settings['freescroll'] ) ) {
			$opts['freeScrol'] = true;	
		}
		
		if( 'custom_id' === $settings['navappend'] && !empty( $settings['navappend_id'] ) ) {
			$opts['buttonsAppendTo'] = $settings['navappend_id'];
		}
		else {
			$opts['buttonsAppendTo'] = $settings['navappend'];
		}
		if( 'custom' === $settings['navarrow'] ) {
			
			$nav_next = !empty( $settings['next'] ) ? esc_html($settings['next']) : '<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"12\" height=\"32\" viewBox=\"0 0 12 32\" style=\"height: 1em;\"><path fill=\"fillColor\" d=\"M3.625 16l7.938 7.938c.562.562.562 1.562 0 2.125-.313.312-.688.437-1.063.437s-.75-.125-1.063-.438L.376 17c-.563-.563-.5-1.5.063-2.063l9-9c.562-.562 1.562-.562 2.124 0s.563 1.563 0 2.125z\"></path></svg>';
			$nav_prev = !empty( $settings['prev'] ) ? esc_html($settings['prev']) : '<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"12\" height=\"32\" viewBox=\"0 0 12 32\" style=\"height: 1em;\"><path fill=\"fillColor\" d=\"M8.375 16L.437 8.062C-.125 7.5-.125 6.5.438 5.938s1.563-.563 2.126 0l9 9c.562.562.624 1.5.062 2.062l-9.063 9.063c-.312.312-.687.437-1.062.437s-.75-.125-1.063-.438c-.562-.562-.562-1.562 0-2.125z\"></path></svg>';
			
			$next = '<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"12\" height=\"32\" viewBox=\"0 0 12 32\" style=\"height: 1em;\"><path fill=\"fillColor\" d=\"M3.625 16l7.938 7.938c.562.562.562 1.562 0 2.125-.313.312-.688.437-1.063.437s-.75-.125-1.063-.438L.376 17c-.563-.563-.5-1.5.063-2.063l9-9c.562-.562 1.562-.562 2.124 0s.563 1.563 0 2.125z\"></path></svg>';

			$opts['navArrow'] = array(
				'next' => $nav_next,
				'prev' => $nav_prev
			);
		}
		if( 'yes' !== $settings['wraparound'] ) {
			$opts['wrapAround'] = false;
		}
		
		if( !empty( $settings['navoffset'] ) ) {
			
			$offset_values = explode( ',', $settings['navoffset'] );
			foreach( $offset_values as $value ) {
				$arr = explode( ':', $value );
				$offset_value[ $arr[0] ] = $arr[1] ;
			}
			
			$opts['navOffsets'] = array( 'nav' => $offset_value );
		}
		if( !empty( $settings['prevoffset'] ) ) {
			$opts['navOffsets']['prev'] = $settings['prevoffset'];
		}
		if( !empty( $settings['nextoffset'] ) ) {
			$opts['navOffsets']['next'] = $settings['nextoffset'];
		}

		$opts = wp_parse_args( $opts, $default_args );
		
		
		
		echo " data-lqd-flickity='" . stripslashes( wp_json_encode( $opts ) ) ."'";
		
	}
	
	public function enable_gallery() {		
		
		if( empty( $this->get_settings_for_display( 'enable_gallery' ) ) ) {
			remove_action( 'woocommerce_before_shop_loop_item_title', 'liquid_woocommerce_template_loop_product_gallery', 12 );
		}
		
	}

	/**
	 * Parse query args.
	 *
	 * @since  3.2.0
	 * @return array
	 */
	protected function parse_query_args() {

		$query_args = array(
			'post_type'           => 'product',
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
			'no_found_rows'       => false,
			'orderby'             => empty( $_GET['orderby'] ) ? $this->get_settings_for_display( 'orderby' ) : wc_clean( wp_unslash( $_GET['orderby'] ) ), // phpcs:ignore WordPress.Security.NonceVerification.Recommended

		);

		$orderby_value         = explode( '-', $query_args['orderby'] );
		$orderby               = esc_attr( $orderby_value[0] );
		$order                 = ! empty( $orderby_value[1] ) ? $orderby_value[1] : strtoupper( $this->get_settings_for_display( 'order' ) );
		$query_args['orderby'] = $orderby;
		$query_args['order']   = $order;

// 		if ( wc_string_to_bool( $this->attributes['paginate'] ) ) {
			$page = absint( empty( $_GET['product-page'] ) ? 1 : $_GET['product-page'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
// 		}

/*
		if ( ! empty( $this->attributes['rows'] ) ) {
			$this->attributes['limit'] = $this->attributes['columns'] * $this->attributes['rows'];
		}
*/

		$ordering_args         = WC()->query->get_catalog_ordering_args( $query_args['orderby'], $query_args['order'] );
		$query_args['orderby'] = $ordering_args['orderby'];
		$query_args['order']   = $ordering_args['order'];
		if ( $ordering_args['meta_key'] ) {
			$query_args['meta_key'] = $ordering_args['meta_key']; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
		}
		$query_args['posts_per_page'] = intval( $this->get_settings_for_display( 'limit' ) );
		if ( 1 < $page ) {
			$query_args['paged'] = absint( $page );
		}
		//$query_args['meta_query'] = WC()->query->get_meta_query(); // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
		switch ( $this->get_settings_for_display( 'show' ) ) {
			case 'featured' :
/*
				$query_args['meta_query'][] = array(
					'key'   => '_featured',
					'value' => 'yes'
				);
*/
				//$query_args['visibility'] = 'featured';
				
			break;
			case 'onsale' :
				$query_args['post__in'] = array_merge( array( 0 ), wc_get_product_ids_on_sale() );
			break;
		}
		$query_args['tax_query']  = array(); // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query

		// Visibility.
		$this->set_visibility_query_args( $query_args );

		// SKUs.
		//$this->set_skus_query_args( $query_args );

		// IDs.
		//$this->set_ids_query_args( $query_args );

		// Set specific types query args.

		if ( method_exists( $this, "set_{$this->type}_query_args" ) ) {
			$this->{"set_{$this->type}_query_args"}( $query_args );
		}
		

		// Attributes.
		//$this->set_attributes_query_args( $query_args );

		// Categories.
		$this->set_categories_query_args( $query_args );

		// Tags.
		//$this->set_tags_query_args( $query_args );

		$query_args = apply_filters( 'woocommerce_shortcode_products_query', $query_args, $this->attributes, $this->type );

		// Always query only IDs.
		$query_args['fields'] = 'ids';

		return $query_args;
	}
	
	
	/**
	 * Set visibility as featured.
	 *
	 * @since 3.2.0
	 * @param array $query_args Query args.
	 */
	protected function set_visibility_featured_query_args( &$query_args ) {
		$query_args['tax_query'] = array_merge( $query_args['tax_query'], WC()->query->get_tax_query() ); // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query

		$query_args['tax_query'][] = array(
			'taxonomy'         => 'product_visibility',
			'terms'            => 'featured',
			'field'            => 'name',
			'operator'         => 'IN',
			'include_children' => false,
		);
	}
	
	/**
	 * Set categories query args.
	 *
	 * @since 3.2.0
	 * @param array $query_args Query args.
	 */
	protected function set_categories_query_args( &$query_args ) {
		$taxonomies = $this->get_settings_for_display( 'taxonomies' );
		if ( ! empty( $taxonomies ) ) {
			$categories = array_map( 'sanitize_title', $taxonomies );
			$field      = 'slug';

			if ( is_numeric( $categories[0] ) ) {
				$field      = 'term_id';
				$categories = array_map( 'absint', $categories );
				// Check numeric slugs.
				foreach ( $categories as $cat ) {
					$the_cat = get_term_by( 'slug', $cat, 'product_cat' );
					if ( false !== $the_cat ) {
						$categories[] = $the_cat->term_id;
					}
				}
			}

			$query_args['tax_query'][] = array(
				'taxonomy'         => 'product_cat',
				'terms'            => $categories,
				'field'            => 'slug'
			);
		}
	}
	
	
	/**
	 * Set visibility query args.
	 *
	 * @since 3.2.0
	 * @param array $query_args Query args.
	 */
	protected function set_visibility_query_args( &$query_args ) {

		if ( 'featured' === $this->get_settings_for_display( 'show' ) ) {
			$this->{'set_visibility_featured_query_args'}( $query_args );
		} else {
			$query_args['tax_query'] = array_merge( $query_args['tax_query'], WC()->query->get_tax_query() ); // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
		}
	}
	
	/**
	 * Set product as visible when querying for hidden products.
	 *
	 * @since  3.2.0
	 * @param  bool $visibility Product visibility.
	 * @return bool
	 */
	public function set_product_as_visible( $visibility ) {
		return true;
	}

	/**
	 * Run the query and return an array of data, including queried ids and pagination information.
	 *
	 * @since  3.3.0
	 * @return object Object with the following props; ids, per_page, found_posts, max_num_pages, current_page
	 */
	protected function get_query_results() {
		$this->query_args = $this->parse_query_args();
		$transient_name    = $this->get_transient_name();
		$transient_version = \WC_Cache_Helper::get_transient_version( 'product_query' );
		$cache             = true;
		$transient_value   = $cache ? get_transient( $transient_name ) : false;

		if ( isset( $transient_value['value'], $transient_value['version'] ) && $transient_value['version'] === $transient_version ) {
			$results = $transient_value['value'];
		} else {
			$query = new \WP_Query( $this->query_args );

			$paginated = ! $query->get( 'no_found_rows' );

			$results = (object) array(
				'ids'          => wp_parse_id_list( $query->posts ),
				'total'        => $paginated ? (int) $query->found_posts : count( $query->posts ),
				'total_pages'  => $paginated ? (int) $query->max_num_pages : 1,
				'per_page'     => (int) $query->get( 'posts_per_page' ),
				'current_page' => $paginated ? (int) max( 1, $query->get( 'paged', 1 ) ) : 1,
			);
		}

		// Remove ordering query arguments which may have been added by get_catalog_ordering_args.
		WC()->query->remove_ordering_args();

		/**
		 * Filter shortcode products query results.
		 *
		 * @since 4.0.0
		 * @param stdClass $results Query results.
		 * @param WC_Shortcode_Products $this WC_Shortcode_Products instance.
		 */
		return apply_filters( 'woocommerce_shortcode_products_query_results', $results, $this );
	}

	/**
	 * Loop over found products.
	 *
	 * @since  3.2.0
	 * @return string
	 */
	protected function product_loop() {
		$columns  = '3';
		$classes  = '';
		$products = $this->get_query_results();

		ob_start();

		if ( $products && $products->ids ) {
			// Prime caches to reduce future queries.
			if ( is_callable( '_prime_post_caches' ) ) {
				_prime_post_caches( $products->ids );
			}

			// Setup the loop.
			wc_setup_loop(
				array(
					'columns'      => $columns,
					'name'         => $this->type,
					'is_shortcode' => true,
					'is_search'    => false,
					'is_paginated' => true,
					'total'        => $products->total,
					'total_pages'  => $products->total_pages,
					'per_page'     => $products->per_page,
					'current_page' => $products->current_page,
				)
			);

			$original_post = $GLOBALS['post'];

			do_action( "woocommerce_shortcode_before_{$this->type}_loop", $this->attributes );

			woocommerce_product_loop_start();

			if ( wc_get_loop_prop( 'total' ) ) {
				foreach ( $products->ids as $product_id ) {
					$GLOBALS['post'] = get_post( $product_id ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
					setup_postdata( $GLOBALS['post'] );

					// Set custom product visibility when quering hidden products.
					//add_action( 'woocommerce_product_is_visible', array( $this, 'set_product_as_visible' ) );

					// Render product template.
					wc_get_template_part( 'content', 'product' );

					// Restore product visibility.
					//remove_action( 'woocommerce_product_is_visible', array( $this, 'set_product_as_visible' ) );
				}
			}

			$GLOBALS['post'] = $original_post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
			woocommerce_product_loop_end();

			// Fire standard shop loop hooks when paginating results so we can show result counts and so on.
			//if ( wc_string_to_bool( $this->atts['paginate'] ) ) {
				do_action( 'woocommerce_after_shop_loop' );
			//}

			do_action( "woocommerce_shortcode_after_{$this->type}_loop", $this->attributes );

			wp_reset_postdata();
			wc_reset_loop();
		} else {
			do_action( "woocommerce_shortcode_{$this->type}_loop_no_results", $this->attributes );
		}

		return '<div class="woocommerce">' . ob_get_clean() . '</div>';
	}

	/**
	 * Order by rating.
	 *
	 * @since  3.2.0
	 * @param  array $args Query args.
	 * @return array
	 */
	public static function order_by_rating_post_clauses( $args ) {
		global $wpdb;

		$args['where']  .= " AND $wpdb->commentmeta.meta_key = 'rating' ";
		$args['join']   .= "LEFT JOIN $wpdb->comments ON($wpdb->posts.ID = $wpdb->comments.comment_post_ID) LEFT JOIN $wpdb->commentmeta ON($wpdb->comments.comment_ID = $wpdb->commentmeta.comment_id)";
		$args['orderby'] = "$wpdb->commentmeta.meta_value DESC";
		$args['groupby'] = "$wpdb->posts.ID";

		return $args;
	}
	
	/**
	 * Generate and return the transient name for this shortcode based on the query args.
	 *
	 * @since 3.3.0
	 * @return string
	 */
	protected function get_transient_name() {
		$transient_name = 'wc_product_loop_' . md5( wp_json_encode( $this->query_args ));

		if ( 'rand' === $this->get_settings_for_display( 'orderby' ) ) {
			// When using rand, we'll cache a number of random queries and pull those to avoid querying rand on each page load.
			$rand_index      = wp_rand( 0, max( 1, absint( apply_filters( 'woocommerce_product_query_max_rand_cache_count', 5 ) ) ) );
			$transient_name .= $rand_index;
		}

		return $transient_name;
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
		extract( $atts );
		$filter_id = 'lqd-woo-filter-' . $this->get_id();

		$columns_gap = $columns_gap['size'];


		// check
		if( !liquid_helper()->is_woocommerce_active() ) {
			return;
		}



		global $wpdb, $product;


		add_filter( 'liquid_product_lists_classnames', array( $this, 'add_ul_classname' ) );
		add_filter( 'post_class', array( $this, 'add_product_classname' ) );
		add_filter( 'post_class', array( $this, 'get_grid_class' ) );
		$this->enable_gallery();

		$style = liquid_helper()->get_option( 'wc-archive-product-style' );

		//query args
		$args = array(
			'posts_per_page' => intval( $limit ) ? intval( $limit ) : 12,
			'post_type'      => 'product',
			'post_status'    => 'publish',
		);

		$args['meta_query']   = array();
		$args['meta_query'][] = WC()->query->stock_status_meta_query();
		$args['meta_query']   = array_filter( $args['meta_query'] );

		// default - menu_order
		$args['orderby'] = 'menu_order title';
		$args['order'] = $order == 'desc' ? 'desc' : 'asc';
		$args['meta_key'] = '';

		switch ( $orderby ) {
			case 'rand' :
				$args['orderby'] = 'rand';
			break;
			case 'date' :
				$args['orderby'] = 'date';
				$args['order'] = $order == 'asc' ? 'asc' : 'desc';
			break;
			case 'price' :
				$args['orderby'] = "meta_value_num {$wpdb->posts}.ID";
				$args['order'] = $order == 'desc' ? 'desc' : 'asc';
				$args['meta_key'] = '_price';
			break;
			case 'popularity' :
				$args['meta_key'] = 'total_sales';
				// Sorting handled later though a hook
				$args['orderby'] = "$wpdb->postmeta.meta_value+0 DESC, $wpdb->posts.post_date DESC";
				//add_filter('posts_clauses', 'liquid_woocommerce_order_by_popularity_post_clauses');
			break;
			case 'rating' :
				// Sorting handled later though a hook
				add_filter('posts_clauses', 'liquid_woocommerce_order_by_rating_post_clauses');
			break;
			case 'title' :
				$args['orderby'] = 'title';
				$args['order'] = $order == 'desc' ? 'desc' : 'asc';
			break;
		}

		switch ( $show ) {
			case 'featured' :
				$args['meta_query'][] = array(
					'key'   => '_featured',
					'value' => 'yes'
				);
			break;
			case 'onsale' :
				$product_ids_on_sale   = wc_get_product_ids_on_sale();
				$product_ids_on_sale[] = 0;
				$args['post__in']      = $product_ids_on_sale;
			break;
		}

		switch($template){
		case 'grid':

			$prods_classnames = array( 
				'lqd-prods',
				$this->get_id() 
			);
	
			$columns  = $this->get_settings_for_display('grid_columns');
			$classes  = '';
			$products = $this->get_query_results();
	
			ob_start();
	
			if ( $products && $products->ids ) {
				// Prime caches to reduce future queries.
				if ( is_callable( '_prime_post_caches' ) ) {
					_prime_post_caches( $products->ids );
				}
	
				// Setup the loop.
				wc_setup_loop(
					array(
						'columns'      => $columns,
						'name'         => '',
						'is_shortcode' => true,
						'is_search'    => false,
						'is_paginated' => true,
						'total'        => $products->total,
						'total_pages'  => $products->total_pages,
						'per_page'     => $products->per_page,
						'current_page' => $products->current_page,
					)
				);
	
				$original_post = $GLOBALS['post'];
	
				do_action( "woocommerce_shortcode_before_{$this->type}_loop", $this->attributes );
	
				// Fire standard shop loop hooks when paginating results so we can show result counts and so on.
			/*
				if ( wc_string_to_bool( $this->attributes['paginate'] ) ) {
					do_action( 'woocommerce_before_shop_loop' );
				}
			*/
	
				woocommerce_product_loop_start();
	
				if ( wc_get_loop_prop( 'total' ) ) {
					foreach ( $products->ids as $product_id ) {
						$GLOBALS['post'] = get_post( $product_id ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
						setup_postdata( $GLOBALS['post'] );
	
						// Set custom product visibility when quering hidden products.
						add_action( 'woocommerce_product_is_visible', array( $this, 'set_product_as_visible' ) );
	
						// Render product template.
						if( function_exists( 'wc_get_template' ) ) { 
					
							if( 'minimal' === $style || 'minimal-2' === $style ) {
								wc_get_template_part( 'content', 'product-minimal' );
							}
							elseif( 'minimal-hover-shadow' === $style ) {
								wc_get_template_part( 'content', 'product-minimal-hover-shadow' );
							}
							elseif( 'minimal-hover-shadow-2' === $style ) {
								wc_get_template_part( 'content', 'product-minimal-hover-shadow-2' );				
							}
							elseif( 'classic' === $style || 'classic-alt' === $style ) {
								wc_get_template_part( 'content', 'product-classic' );
							}
							else {
								wc_get_template_part( 'content', 'product' );
							}
						}
	
						// Restore product visibility.
						remove_action( 'woocommerce_product_is_visible', array( $this, 'set_product_as_visible' ) );
					}
				}
	
				$GLOBALS['post'] = $original_post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
				woocommerce_product_loop_end();
	
				// Fire standard shop loop hooks when paginating results so we can show result counts and so on.
				if( 'pagination' === $atts['pagination'] ) {
					do_action( 'woocommerce_after_shop_loop' );
				}
				if( in_array( $atts['pagination'], array( 'ajax' ) ) ) {
					
					global $wp;
					$current_url = home_url( add_query_arg( array(), $wp->request ) );
					
					if( ( $products->current_page + 1 ) <= $products->total_pages ) {
						$next_page_url = $products->current_page + 1;
					}
					else {
						$next_page_url = $products->current_page;
					}
					$url = $current_url . '/?product-page=' . $next_page_url . '';
					
					$hash = array(
						'ajax' => 'btn btn-md ajax-load-more',
					);
	
					$attributes = array(
						'href' => add_query_arg( 'ajaxify', '1', $url ),
						'rel' => 'nofollow',
						'data-ajaxify' => true,
						'data-ajaxify-options' => json_encode( array(
							'wrapper' => '.woocommerce .lqd-prods-row',
							'items'   => '> .lqd-prod-item',
							'trigger' => $ajax_trigger,
						) )
					);
	
					echo '<div class="liquid-pf-nav ld-pf-nav-ajax"><div class="page-nav text-center"><nav aria-label="' . esc_attr__( 'Page navigation', 'archub-elementor-addons' ) . '">';
					switch( $atts['pagination'] ) {
	
						case 'ajax':
							$ajax_text = ! empty( $atts['ajax_text'] ) ? esc_html( $atts['ajax_text'] ) : esc_html__( 'Load more', 'archub-elementor-addons' );
							$attributes['class'] = 'elementor-button btn ws-nowrap pos-rel ld-ajax-loadmore';
							printf( '<a%2$s><span class="static d-block">%1$s</span><span class="loading d-block pos-abs"><span class="dots d-block"><span class="d-inline-block"></span><span class="d-inline-block"></span><span class="d-inline-block"></span></span><span class="d-block mt-1">' . esc_html__( 'Loading', 'archub-elementor-addons' ) . '</span></span><span class="all-loaded d-block pos-abs">' . esc_html__( 'All items loaded', 'archub-elementor-addons' ) . ' <svg width="32" height="29" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 29" style="width: 1.5em; height: 1.5em; margin-inline-start: 0.5em;"><path fill="currentColor" d="M25.74 6.23c0.38 0.34 0.42 0.9 0.09 1.28l-12.77 14.58a0.91 0.91 0 0 1-1.33 0.04l-5.46-5.46a0.91 0.91 0 1 1 1.29-1.29l4.77 4.78 12.12-13.85a0.91 0.91 0 0 1 1.29-0.08z"></path></svg></span></a>', $ajax_text, ld_helper()->html_attributes( $attributes ), $url );
							break;
					}
	
					echo '</nav></div></div>';
				}	
	
				do_action( "woocommerce_shortcode_after_{$this->type}_loop", $this->attributes );
	
				wp_reset_postdata();
				wc_reset_loop();
			} else {
				do_action( "woocommerce_shortcode_{$this->type}_loop_no_results", $this->attributes );
			}
	
			echo '<div class="woocommerce">' . ob_get_clean() . '</div>';
		break;
		case 'masonry':

			if ( ! empty( $taxonomies ) ) {
				$args['tax_query'] = array( array(
					'taxonomy' => 'product_cat',
					'field'    => 'slug',
					'terms'    => $taxonomies,
					'relation' => 'IN',
				) );
				$args['tax_query']['relation'] = 'OR';
			}

			$products_query = new \WP_Query( $args );

			if( !$products_query->have_posts() ) {
				return '';
			}

			?>
			<div class="woocommerce lqd-prods-wrap lqd-prods-masonry" data-gap="<?php echo esc_attr( $columns_gap ); ?>">
				<div class="lqd-prods">
					<?php
						if( 'yes' === $atts['show_filter'] ) {
							$filter_located = locate_template( 'templates/vc/woo-products-list/partial-filters.php' );
							include $filter_located;
						}
					?>
					<div
					class="lqd-prods-row row d-flex flex-wrap"
					id="<?php echo $this->get_id() ?>"
					data-liquid-masonry="true"
					data-masonry-options='{ "itemSelector": ".lqd-prod-item", "filtersID": "#<?php echo esc_attr( $filter_id ); ?>" }'>
						
						<?php
							
							woocommerce_product_loop_start();

							$posts_sz = count( $products_query->posts );
							if( $limit > $posts_sz ) {
								$all = $posts_sz;
							} else {
								$all = $limit;
							}
						?>

						<?php

							while ( $products_query->have_posts() ) :

								$products_query->the_post();
								$product = new \WC_Product( get_the_ID() );
						?>		
						<?php

							if( function_exists( 'wc_get_template' ) ) { 
						
								if( 'minimal' === $style || 'minimal-2' === $style ) {
									wc_get_template_part( 'content', 'product-minimal' );
								}
								elseif( 'minimal-hover-shadow' === $style ) {
									wc_get_template_part( 'content', 'product-minimal-hover-shadow' );
								}
								elseif( 'minimal-hover-shadow-2' === $style ) {
									wc_get_template_part( 'content', 'product-minimal-hover-shadow-2' );				
								}
								elseif( 'classic' === $style || 'classic-alt' === $style ) {
									wc_get_template_part( 'content', 'product-classic' );
								}
								else {
									wc_get_template_part( 'content', 'product' );
								}
							}
								
						?>
						<?php
							endwhile; // end of the loop.
							
							wp_reset_postdata();
							
							woocommerce_product_loop_end();
								
							remove_filter('posts_clauses', 'liquid_woocommerce_order_by_popularity_post_clauses');
							remove_filter('posts_clauses', 'liquid_woocommerce_order_by_rating_post_clauses');
							
							//liquid_woocommerce_product_styles( $style );

						?>
					</div>
				</div>
			</div>
			<?php
		break;
		case 'carousel':
		$carousel_classnames = array( 
			'lqd-prods',
			'carousel-container',
			$navfloated,
			$navhalign,
			$navvalign,
			$navdirection,
			$navline,
			$navsize,
			$navfill,
			$navshape,
			$navshadow,
		);

		if ( ! empty( $taxonomies ) ) {
			$args['tax_query'] = array( array(
				'taxonomy' => 'product_cat',
				'field'    => 'slug',
				'terms'    => $taxonomies,
				'relation' => 'IN',
			) );
			$args['tax_query']['relation'] = 'OR';
		}
		
		$products_query = new \WP_Query( $args );
		
		if( !$products_query->have_posts() ) {
			return '';
		}
		
		
		?>
		<div class="woocommerce lqd-prods-wrap lqd-prods-carousel" data-gap="<?php echo esc_attr( $columns_gap ); ?>">
			<div class="<?php echo join( ' ', $carousel_classnames ); ?>">
				<?php
					if( 'yes' === $atts['show_filter'] ) {
						$filter_located = locate_template( 'templates/vc/woo-products-list/partial-filters.php' );
						include $filter_located;
					}
				?>
				<div
				class="lqd-prods-row <?php echo $fadesides ?>"
				id="<?php echo $this->get_id() ?>"
				<?php $this->get_options(); ?>>			
					<?php
						
						woocommerce_product_loop_start();
		
						$posts_sz = count( $products_query->posts );
						if( $limit > $posts_sz ) {
							$all = $posts_sz;
						} else {
							$all = $limit;
						}
					?>
		
					<?php
		
						while ( $products_query->have_posts() ) :
		
							$products_query->the_post();
							$product = new \WC_Product( get_the_ID() );
					?>		
					<?php
		
						if( function_exists( 'wc_get_template' ) ) { 
					
							if( 'minimal' === $style || 'minimal-2' === $style ) {
								wc_get_template_part( 'content', 'product-minimal' );
							}
							elseif( 'minimal-hover-shadow' === $style ) {
								wc_get_template_part( 'content', 'product-minimal-hover-shadow' );
							}
							elseif( 'minimal-hover-shadow-2' === $style ) {
								wc_get_template_part( 'content', 'product-minimal-hover-shadow-2' );				
							}
							elseif( 'classic' === $style || 'classic-alt' === $style ) {
								wc_get_template_part( 'content', 'product-classic' );
							}
							else {
								wc_get_template_part( 'content', 'product' );
							}
						}
							
					?>
					<?php
						endwhile; // end of the loop.
						
						wp_reset_postdata();
						
						woocommerce_product_loop_end();
							
						remove_filter('posts_clauses', 'liquid_woocommerce_order_by_popularity_post_clauses');
						remove_filter('posts_clauses', 'liquid_woocommerce_order_by_rating_post_clauses');
						
						//liquid_woocommerce_product_styles( $style );
		
					?>
				</div>
			</div>
		</div>
		<?php
		break;
		}
		
	}

}
