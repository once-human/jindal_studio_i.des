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
class LD_Portfolio extends Widget_Base {

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
		return 'ld_portfolio';
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
		return __( 'Liquid Portfolio List', 'archub-elementor-addons' );
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
		return 'eicon-posts-masonry lqd-element';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the heading widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'hub-core', 'hub-portfolio' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 2.1.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'portfolio', 'gallery' ];
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
			return [ 'packery-mode', 'flickity', 'jquery-fresco' ];
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
				'label' => __( 'general', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'style',
			[
				'label' => __( 'Style', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'style01',
				'options' => [
					'style01' => __( 'Style 01', 'archub-elementor-addons' ),
					'style02' => __( 'Style 02', 'archub-elementor-addons' ),
					'style03' => __( 'Style 03', 'archub-elementor-addons' ),
					'style04' => __( 'Style 04', 'archub-elementor-addons' ),
					'style05' => __( 'Style 05', 'archub-elementor-addons' ),
					'style06' => __( 'Style 06', 'archub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'horizontal_alignment',
			[
				'label' => __( 'Horizontal alignment', 'archub-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'' => [
						'title' => __( 'Default', 'archub-elementor-addons' ),
						'icon' => 'fa fa-minus',
					],
					'pf-details-h-str' => [
						'title' => __( 'Left', 'archub-elementor-addons' ),
						'icon' => 'eicon-h-align-left',
					],
					'pf-details-h-mid' => [
						'title' => __( 'Center', 'archub-elementor-addons' ),
						'icon' => 'eicon-h-align-center',
					],
					'pf-details-h-end' => [
						'title' => __( 'Right', 'archub-elementor-addons' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => '',
				'toggle' => false,
				'condition' => [
					'style!' => [ 'style04', 'style05', 'style06' ],
				],
			]
		);

		$this->add_control(
			'vertical_alignment',
			[
				'label' => __( 'Vertical alignment', 'archub-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'' => [
						'title' => __( 'Default', 'archub-elementor-addons' ),
						'icon' => 'fa fa-minus',
					],
					'pf-details-v-str' => [
						'title' => __( 'Top', 'archub-elementor-addons' ),
						'icon' => 'eicon-v-align-top',
					],
					'pf-details-v-mid' => [
						'title' => __( 'Middle', 'archub-elementor-addons' ),
						'icon' => 'eicon-v-align-middle',
					],
					'pf-details-v-end' => [
						'title' => __( 'Bottom', 'archub-elementor-addons' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'default' => '',
				'toggle' => false,
				'condition' => [
					'style!' => [ 'style02', 'style04', 'style05', 'style06' ]
				]
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
					'6' => __( '6 Columns', 'archub-elementor-addons' ),
				],
				'condition' => [
					'style' => [ 'style02', 'style06' ]
				]
			]
		);

		$this->add_responsive_control(
			'columns_gap',
			[
				'label' => __( 'Columns gap', 'archub-elementor-addons' ),
				'description' => __( 'Select gap between columns in row.', 'archub-elementor-addons' ),
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
					'{{WRAPPER}} .lqd-pf-row' => 'margin-inline-start: -{{SIZE}}{{UNIT}}; margin-inline-end: -{{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .carousel-items' => 'margin-inline-start: -{{SIZE}}{{UNIT}}; margin-inline-end: -{{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .lqd-pf-column' => 'padding-inline-start: {{SIZE}}{{UNIT}}; padding-inline-end: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .carousel-item' => 'padding-inline-start: {{SIZE}}{{UNIT}}; padding-inline-end: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'bottom_gap',
			[
				'label' => __( 'Bottom gap', 'archub-elementor-addons' ),
				'description' => __( 'Bottom gap for portfolio items', 'archub-elementor-addons' ),
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
					'size' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-pf-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'style!' => [ 'style04', 'style05' ]
				]
			]
		);

		$this->add_responsive_control(
			'items_height',
			[
				'label' => __( 'Items height', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'vh' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'vh',
					'size' => 100,
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-pf-item' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'style' => [ 'style05' ]
				]
			]
		);

		$this->add_responsive_control(
			'items_height_subtract',
			[
				'label' => __( 'Items height subtract', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'vh' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-pf-item' => 'height: calc( {{items_height.SIZE}}{{items_height.UNIT}} - {{SIZE}}{{UNIT}} );',
				],
				'condition' => [
					'style' => [ 'style05' ]
				]
			]
		);

		$this->add_control(
			'post_type',
			[
				'label' => __( 'Data source', 'archub-elementor-addons' ),
				'description' => __( 'Select content type for your grid.', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'liquid-portfolio',
				'options' => self::get_post_type_list(),
			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label' => __( 'Total items', 'archub-elementor-addons' ),
				'description' => __( 'Set max limit or enter -1 to display all (limited to 1000).', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => '10',
				'placeholder' => __( 'enter -1 to display all ', 'archub-elementor-addons' ),
				'condition' => [
					'post_type!' => [ 'ids', 'custom' ]
				],
			]
		);

		$this->add_control(
			'include',
			[
				'label' => __( 'Include only', 'archub-elementor-addons' ),
				'description' => __( 'Add posts, pages, etc. by title.', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'placeholder' => __( 'Add posts, pages, etc. by title.', 'archub-elementor-addons' ),
				'condition' => [
					'post_type' => [ 'ids' ]
				],
			]
		);

		$this->end_controls_section();
	
		// Custom Query
		$this->start_controls_section(
			'categories_section',
			[
				'label' => __( 'Categories', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'post_type' => 'custom'
				]
			]
		);
		$this->end_controls_section();

		// Category
		$this->start_controls_section(
			'custom_query_section',
			[
				'label' => __( 'Custom query', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'post_type' => 'custom'
				]
			]
		);
		$this->end_controls_section();


		// Data Settings
		$this->start_controls_section(
			'data_settings_section',
			[
				'label' => __( 'Data settings', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'orderby',
			[
				'label' => __( 'Order by', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date' => __( 'Date', 'archub-elementor-addons' ),
					'ID' => __( 'Order by post ID', 'archub-elementor-addons' ),
					'author' => __( 'Author', 'archub-elementor-addons' ),
					'title' => __( 'Title', 'archub-elementor-addons' ),
					'modified' => __( 'Last modified date', 'archub-elementor-addons' ),
					'parent' => __( 'Post/page parent ID', 'archub-elementor-addons' ),
					'comment_count' => __( 'Number of comments', 'archub-elementor-addons' ),
					'menu_order' => __( 'Menu order/Page Order', 'archub-elementor-addons' ),
					'meta_value' => __( 'Meta value', 'archub-elementor-addons' ),
					'meta_value_num' => __( 'Meta value number', 'archub-elementor-addons' ),
					'rand' => __( 'Random order', 'archub-elementor-addons' ),
				],
				'condition' => [
					'post_type!' => [ 'ids', 'custom' ]
				]
			]
		);

		$this->add_control(
			'order',
			[
				'label' => __( 'Sort order', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => [
					'DESC' => __( 'Descending', 'archub-elementor-addons' ),
					'ASC' => __( 'Ascending', 'archub-elementor-addons' ),
				],
				'condition' => [
					'post_type!' => [ 'ids', 'custom' ]
				]
			]
		);

		$this->add_control(
			'meta_key',
			[
				'label' => __( 'Meta key', 'archub-elementor-addons' ),
				'description' => __( 'Input meta key for grid ordering.', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'condition' => [
					'orderby' => [ 'meta_value', 'meta_value_num' ]
				]
			]
		);

		$this->add_control(
			'taxonomies',
			[
				'label' => __( 'Narrow data source', 'archub-elementor-addons' ),
				'description' => __( 'Enter categories', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => $this->get_narrow_taxonomies(),
				'condition' => [
					'post_type!' => [ 'ids', 'custom' ]
				]
			]
		);

		$this->add_control(
			'exclude',
			[
				'label' => __( 'Exclude', 'archub-elementor-addons' ),
				'description' => __( 'Exclude posts by title.', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT2,
				'options' => $this->get_exlude_taxonomies(),
				'multiple' => true,
				'condition' => [
					'post_type!' => [ 'ids', 'custom' ]
				]
			]
		);
		$this->end_controls_section();

		// Extra Options Section
		$this->start_controls_section(
			'extra_options_section',
			[
				'label' => __( 'Extra options', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'one_category',
			[
				'label' => __( 'Show Only One Post Meta', 'archub-elementor-addons' ),
				'description' => __( 'Enable to show one category/tag', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'disable_postformat',
			[
				'label' => __( 'Disable post formats?', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'enable_ext',
			[
				'label' => __( 'Enable external links?', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'enable_parallax_img',
			[
				'label' => __( 'Enable parallax image?', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
				'separator' => 'before',
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
				'separator' => 'before',
			]
		);

		$this->add_control(
			'filter_toggle',
			[
				'label' => __( 'Filter', 'archub-elementor-addons' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'label_off' => __( 'Default', 'archub-elementor-addons' ),
				'label_on' => __( 'Custom', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'condition' => [
					'show_filter' => 'yes',
				],
			]
		);

		$this->start_popover();

		$this->add_control(
			'filter_cats',
			[
				'label' => __( 'Categories', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => $this->get_taxonomies(),
				'default' => [ 'title', 'description' ],
			]
		);

		$this->add_control(
			'filter_style',
			[
				'label' => __( 'Filter style?', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'lqd-filter-style-default',
				'options' => [
					'lqd-filter-style-default' => __( 'Default', 'archub-elementor-addons' ),
					'lqd-filter-style-dropdown' => __( 'Dropdown', 'archub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'filter_enable_counter',
			[
				'label' => __( 'Show counter?', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'filter_title',
			[
				'label' => __( 'Filter title', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Filter', 'archub-elementor-addons' ),
				'placeholder' => __( 'Type your title here', 'archub-elementor-addons' ),
			]
		);
		
		$this->add_control(
			'filter_subtitle',
			[
				'label' => __( 'Filter subtitle', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Subtitle', 'archub-elementor-addons' ),
				'placeholder' => __( 'Type your title here', 'archub-elementor-addons' ),
				'condition' => [
					'show_filter' => 'yes',
					'style' => array( 'style03', 'style04' ),
				]
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
			'filter_color',
			[
				'label' => __( 'Color scheme', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'None', 'archub-elementor-addons' ),
					'filter-list-scheme-light' => __( 'Light', 'archub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'filter_decoration',
			[
				'label' => __( 'Decoration', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'None', 'archub-elementor-addons' ),
					'filters-underline' => __( 'Underline', 'archub-elementor-addons' ),
					'filters-line-through' => __( 'Linethrough', 'archub-elementor-addons' ),
				],
			]
		);

		$this->add_responsive_control(
			'filter_underline_height',
			[
				'label' => __( 'Underline height', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 10,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 2,
				],
				'selectors' => [
					'{{WRAPPER}} .filters-underline li span:after' => 'height: {{VALUE}}',
					'{{WRAPPER}} .filters-underline li span:after' => 'min-height: {{VALUE}}',
				],
				'condition' => [
					'filter_decoration!' => '',
				],
			]
		);

		$this->add_control(
			'filter_align',
			[
				'label' => esc_html__( 'Alignment', 'archub-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'archub-elementor-addons' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'archub-elementor-addons' ),
						'icon' => 'eicon-h-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'archub-elementor-addons' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => 'left',
				'toggle' => false,
				'selectors' => [
					'{{WRAPPER}} .lqd-pf-grid .liquid-filter-items-inner' => 'justify-content: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'filter_mb',
			[
				'label' => __( 'Filters bottom space', 'archub-elementor-addons' ),
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
				'condition' => [
					'style!' => 'style04',
				]
			]
		);
		
		$this->add_responsive_control(
			'filter_mb2',
			[
				'label' => __( 'Filters bottom space', 'archub-elementor-addons' ),
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
					'{{WRAPPER}} .filter-list' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'style' => 'style04',
				]
			]
		);
		$this->end_popover();

		$this->add_control(
			'enable_gallery',
			[
				'label' => __( 'Enable gallery?', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'listing-lightbox-gallery',
				'default' => '',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'custom_cursor_style',
			[
				'label' => __( 'Custom cursor style', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'lqd-cc-label-trigger',
				'options' => [
					'lqd-cc-label-trigger' => __( 'Images Label from Theme Options', 'archub-elementor-addons' ),
					'lqd-cc-icon-trigger' => __( 'Icon from Theme Options', 'archub-elementor-addons' ),
				],
				'separator' => 'before',
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
				'condition' => [
					'style!' => [ 'carousel' ]
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'pagination_toggle',
			[
				'label' => __( 'Pagination Options', 'archub-elementor-addons' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'label_off' => __( 'Default', 'archub-elementor-addons' ),
				'label_on' => __( 'Custom', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'condition' => [
					'pagination' => 'ajax',
				],
			]
		);

		$this->start_popover();

			$this->add_control(
				'ajax_trigger',
				[
					'label' => __( 'Ajax trigger', 'archub-elementor-addons' ),
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

			$this->start_controls_tabs(
				'style_tabs'
			);

			$this->start_controls_tab(
				'style_normal_tab',
				[
					'label' => esc_html__( 'Normal', 'archub-elementor-addons' ),
				]
			);

				$this->add_control(
					'ajax_button_bg',
					[
						'label' => __( 'Button background color', 'archub-elementor-addons' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .ld-ajax-loadmore' => 'background-color: {{VALUE}}!important',
						],
						'condition' => [
							'pagination' => 'ajax',
							'pagination_toggle' => 'yes',
						]
					]
				);

				$this->add_control(
					'ajax_border_color',
					[
						'label' => __( 'Button border color', 'archub-elementor-addons' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .ld-ajax-loadmore' => 'border-color: {{VALUE}}!important',
						],
						'condition' => [
							'pagination' => 'ajax',
							'pagination_toggle' => 'yes',
						]
					]
				);
				
				$this->add_control(
					'ajax_button_color',
					[
						'label' => __( 'Button text color', 'archub-elementor-addons' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .ld-ajax-loadmore' => 'color: {{VALUE}}!important',
						],
						'condition' => [
							'pagination' => 'ajax',
							'pagination_toggle' => 'yes',
						]
					]
				);

				$this->add_control(
					'ajax_btn_bg_loading',
					[
						'label' => __( 'Loading background', 'archub-elementor-addons' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .ld-pf-nav-ajax .items-loading, {{WRAPPER}} .ld-pf-nav-ajax .btn:focus' => 'background-color: {{VALUE}}!important',
						],
						'separator' => 'before',
						'condition' => [
							'pagination' => 'ajax',
							'pagination_toggle' => 'yes',
						]
					]
				);

				$this->add_control(
					'ajax_btn_border_color_loading',
					[
						'label' => __( 'Loading border color', 'archub-elementor-addons' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .ld-pf-nav-ajax .items-loading, {{WRAPPER}} .ld-pf-nav-ajax .btn:focus' => 'border-color: {{VALUE}}!important',
						],
						'condition' => [
							'pagination' => 'ajax',
							'pagination_toggle' => 'yes',
						]
					]
				);

				$this->add_control(
					'ajax_btn_color_loading',
					[
						'label' => __( 'Loading text color', 'archub-elementor-addons' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .ld-pf-nav-ajax .items-loading, {{WRAPPER}} .ld-pf-nav-ajax .btn:focus' => 'color: {{VALUE}}!important',
						],
						'condition' => [
							'pagination' => 'ajax',
							'pagination_toggle' => 'yes',
						]
					]
				);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'style_hover_tab',
				[
					'label' => esc_html__( 'Hover', 'archub-elementor-addons' ),
				]
			);

				$this->add_control(
					'ajax_button_hover_bg',
					[
						'label' => __( 'Button background hover color', 'archub-elementor-addons' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .ld-ajax-loadmore:hover' => 'background-color: {{VALUE}}!important',
						],
						'condition' => [
							'pagination' => 'ajax',
							'pagination_toggle' => 'yes',
						]
					]
				);

				$this->add_control(
					'ajax_border_hover_color',
					[
						'label' => __( 'Button border hover color', 'archub-elementor-addons' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .ld-ajax-loadmore:hover' => 'border-color: {{VALUE}}!important',
						],
						'condition' => [
							'pagination' => 'ajax',
							'pagination_toggle' => 'yes',
						]
					]
				);

				$this->add_control(
					'ajax_button_hover_color',
					[
						'label' => __( 'Button hover text color', 'archub-elementor-addons' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .ld-ajax-loadmore:hover' => 'color: {{VALUE}}!important',
						],
						'condition' => [
							'pagination' => 'ajax',
							'pagination_toggle' => 'yes',
						]
					]
				);

			$this->end_controls_tab();
			$this->end_controls_tabs();

			$this->add_control(
				'ajax_btn_all_items_loaded_color',
				[
					'label' => __( 'All items loaded color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ld-pf-nav-ajax .all-items-loaded' => 'color: {{VALUE}}!important',
					],
					'separator' => 'before',
					'condition' => [
						'pagination' => 'ajax',
						'pagination_toggle' => 'yes',
					]
				]
			);

			$this->add_control(
				'ajax_btn_icon',
				[
					'label' => esc_html__( 'Icon', 'archub-elementor-addons' ),
					'type' => Controls_Manager::ICONS,
					'skin' => 'inline',
					'exclude_inline_options' => [ 'svg' ],
					'default' => [
						'value' => 'lqd-icn-ess icon-ion-ios-add',
						'library' => 'lqd-essentials',
					],
					'condition' => [
						'pagination' => 'ajax',
						'pagination_toggle' => 'yes',
					]
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'ajax_btn_typography',
					'label' => __( 'Typography', 'archub-elementor-addons' ),
					'selector' => '{{WRAPPER}} .ld-ajax-loadmore',
				]
			);

		$this->end_popover();

		$this->add_control(
			'carousel_nav_w',
			[
				'label' => __( 'Navigation button width', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => '50px',
				'selectors' => [
					'{{WRAPPER}} .carousel-nav .flickity-button' => 'width: {{VALUE}} !important;'
				],
				'condition' => [
					'style' => [ 'style04' ]
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'carousel_nav_h',
			[
				'label' => __( 'Navigation button height', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => '50px',
				'selectors' => [
					'{{WRAPPER}} .carousel-nav .flickity-button' => 'height: {{VALUE}} !important;'
				],
				'condition' => [
					'style' => [ 'style04' ]
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
				'name' => 'title_typography',
				'label' => __( 'Title typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-pf-item h2',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => __( 'Excerpt/category color', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-pf-details p,{{WRAPPER}} .lqd-pf-details a',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'color_overlay',
				'label' => __( 'Background/overlay color', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .lqd-pf-overlay-bg',
				'separator' => 'before'
			]
		);

		$this->add_control(
			'bg_opacity',
			[
				'label' => __( 'Background opacity on hover', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.05,
					],
				],
				'default' => [
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-pf-item:hover .lqd-pf-overlay-bg' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_control(
			'color_type',
			[
				'label' => __( 'Text color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Default', 'archub-elementor-addons' ),
					'lqd-pf-light' => __( 'Light', 'archub-elementor-addons' ),
					'lqd-pf-dark' => __( 'Dark', 'archub-elementor-addons' ),
					'lqd-pf-color-custom' => __( 'Custom', 'archub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Title color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-pf-details h2' => 'color: {{VALUE}}',
				],
				'condition' => [
					'color_type' => [ 'lqd-pf-color-custom' ]
				]
			]
		);

		$this->add_control(
			'content_color',
			[
				'label' => __( 'Excerpt/category color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-pf-details p,{{WRAPPER}} .lqd-pf-details a' => 'color: {{VALUE}}',
				],
				'condition' => [
					'color_type' => [ 'lqd-pf-color-custom' ]
				]
			]
		);

		$this->add_control(
			'overlay_arrow_color',
			[
				'label' => __( 'Overlay arrow color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-pf-overlay-bg' => 'color: {{VALUE}}',
				],
				'condition' => [
					'color_type' => [ 'lqd-pf-color-custom' ]
				]
			]
		);

		$this->add_control(
			'carousel_nav_color',
			[
				'label' => __( 'Nav color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .flickity-button' => 'color: {{VALUE}}',
				],
				'condition' => [
					'style' => [ 'style03' ]
				],
				'separator' => 'before'
			]
		);

		$this->add_control(
			'carousel_nav_hcolor',
			[
				'label' => __( 'Nav hover color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .flickity-button:hover' => 'color: {{VALUE}}',
				],
				'condition' => [
					'style' => [ 'style03' ]
				],
			]
		);

		$this->add_control(
			'carousel_mobile_nav_color',
			[
				'label' => __( 'Mobile nav color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .carousel-dots-mobile .dot' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'style' => [ 'style03' ]
				],
				'separator' => 'before'
			]
		);

		$this->add_control(
			'carousel_mobile_nav_hcolor',
			[
				'label' => __( 'Mobile nav active color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .carousel-dots-mobile .dot.is-selected' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'style' => [ 'style03' ]
				],
			]
		);

		$this->add_control(
			'items_border_radius',
			[
				'label' => __( 'Items border radius', 'archub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-pf-item, {{WRAPPER}} .lqd-pf-item-inner, {{WRAPPER}} .lqd-pf-img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;'
				],
				'separator' => 'before'
			]
		);

		$this->add_control(
			'cc_icon_color',
			[
				'label' => __( 'Custom cursor icon color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'custom_cursor_style' => [ 'lqd-cc-icon-trigger' ]
				],
				'separator' => 'before'
			]
		);

		$this->end_controls_section();

		// Filter Color
		$this->start_controls_section(
			'filter_style_section',
			[
				'label' => __( 'Filter style', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_filter' => 'yes',
				]
			]
		);

		$this->add_control(
			'filter_title_color',
			[
				'label' => __( 'Filter title color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .liquid-filter-items-label, {{WRAPPER}} .lqd-pf-carousel-header h6' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'filter_title_typography',
				'label' => __( 'Typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .liquid-filter-items-label',
				'separator' => 'after',
			]
		);

		$this->add_control(
			'hr_filter_title',
			[
				'type' => Controls_Manager::DIVIDER,
				'condition' => [
					'show_filter' => 'yes',
					'style' => array( 'style03', 'style04' ),
				]
			]
		);

		$this->add_control(
			'filter_subtitle_color',
			[
				'label' => __( 'Filter subtitle color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-pf-carousel-header h2' => 'color: {{VALUE}}',
				],
				'condition' => [
					'show_filter' => 'yes',
					'style' => array( 'style03', 'style04' ),
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'filter_subtitle_typography',
				'label' => __( 'Typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-pf-carousel-header h2',
				'separator' => 'after',
				'condition' => [
					'show_filter' => 'yes',
					'style' => array( 'style03', 'style04' ),
				]
			]
		);

		$this->add_control(
			'hr_filter_subtitle',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'filter_normal_color',
			[
				'label' => __( 'Filter item color', 'archub-elementor-addons' ),
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
				'label' => __( 'Hover/active color', 'archub-elementor-addons' ),
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
				'label' => __( 'Decoration color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .filters-underline li span:after, {{WRAPPER}} .filters-line-through li span:after' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'filter_item_typography',
				'label' => __( 'Filter items typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .filter-list li',
				'separator' => 'after',
			]
		);

		$this->add_control(
			'hr_filter_mobile',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);


		$this->add_control(
			'mobile_filter_normal_color',
			[
				'label' => __( 'Mobile filter color', 'archub-elementor-addons' ),
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
				'label' => __( 'Mobile hover/active filter color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-filter-dropdown .ui-button:active, {{WRAPPER}} .lqd-filter-dropdown .ui-button:focus' => 'color: {{VALUE}}',
					'{{WRAPPER}} .lqd-filter-dropdown .ui-button:active, {{WRAPPER}} .lqd-filter-dropdown .ui-button:focus' => 'border-color: {{VALUE}}',
				],
			]
		);
		
		$this->end_controls_section();
		
		ld_el_btn($this, 'ib_'); // load button

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
		
		$settings = $this->get_settings_for_display();
		$atts = $this->get_settings_for_display();
		$atts['filter_cats'] = ('yes' === $settings['show_filter'] ? implode(',', $atts['filter_cats']) : ''); 
		$style = $settings['style'];
		$filter_id = esc_attr( 'pf-filter-' . $this->get_id_int() );
		$grid_id = uniqid( 'grid-');
		$filter_enable_counter = $settings['filter_enable_counter'];
		$grid_columns = $settings['grid_columns'];
		$ajax_trigger = $settings['ajax_trigger'];
		$origin = is_rtl() ? esc_attr( 'right' ) : esc_attr( 'left' );
		$opt_counter = $filter_enable_counter === 'yes' ? ', "filtersCounter": true' : '';
		$buttons_append_to = $settings['show_filter'] === 'yes' ? esc_attr( '#'.$filter_id ) : esc_attr( 'self' );
		$filter_style = $settings['filter_style'];

		// Locate the template and check if exists.
		$located = locate_template( array(
			"templates/portfolio/tmpl-$style.php"
		) );
		if ( ! $located ) {
			return;
		}

		if ($style === 'style03'){

			// Build Query and check for posts
			$the_query = new \WP_Query( $this->build_query() );
			if( !$the_query->have_posts() ) {
				return;
			}
			
			// Include filter
			if( 'yes' === $settings['show_filter'] ) {
				$filter_located = locate_template( 'templates/portfolio/partial-filters.php' );
				include $filter_located;
			}
			
			//Container 
			echo '<div class="carousel-container">';
			echo '<div class="carousel-items pos-rel" data-lqd-flickity=\'{ "equalHeightCells": true, "filters": "#' . $filter_id . '", "prevNextButtons": true, "navArrow": 6, "fullwidthSide": true, "buttonsAppendTo": "' . $buttons_append_to . '" }\'>';
			echo '<div class="flickity-viewport pos-rel w-100">';
			echo '<div class="flickity-slider d-flex w-100 h-100" style="' . $origin . ': 0; transform: translateX(0%);">';
			
				// Build Query
				$GLOBALS['wp_query'] = $the_query;
				$before = $after = '';
			
				$this->add_excerpt_hooks();
			
				while( have_posts() ): the_post();
			
					$post_classes = array( 'lqd-pf-item', $this->get_item_classes() );		
					$post_classes = join( ' ', get_post_class( $post_classes, get_the_ID() ) );
			
					$attributes = array(
						'id' => 'post-' . get_the_ID(),
						'class' => $post_classes
					);
			
					echo $before;
			
						include $located;
			
					echo $after;
			
				endwhile;
			
				$this->remove_excerpt_hooks();
			
				wp_reset_query();
			
			echo '</div>';
			echo '</div>';
			echo '</div>';
			echo '</div>';

		} elseif ($style === 'style04'){
			// Build Query and check for posts
			$the_query = new \WP_Query( $this->build_query() );
			if( !$the_query->have_posts() ) {
				return;
			}

			//Container 
			echo '<div class="carousel-container carousel-nav-floated carousel-nav-bottom carousel-nav-left carousel-nav-square carousel-nav-solid carousel-nav-lg carousel-nav-shadowed lqd-pf-filterable-carousel" data-filterable-carousel="true">';
			
			// Include filter
			if( 'yes' === $settings['show_filter'] ) {
				echo '<div class="row d-flex flex-wrap align-items-start">';
				$filter_located = locate_template( 'templates/portfolio/partial-filters-carousel.php' );
				include $filter_located;
				echo '<div class="col-md-8 col-xs-12">';
			}
				
			echo '<div class="carousel-items pos-rel" data-lqd-flickity=\'{ "filters": "#' . $filter_id . '"' . $opt_counter . ', "doSomethingCrazyWithFilters": true, "prevNextButtons": true, "buttonsAppendTo": "parent_el", "navArrow": 6, "fullwidthSide": true, "navOffsets": { "nav": {"bottom": "110px", "left": "15px", "right": "auto"} } }\'>';
			echo '<div class="flickity-viewport-wrap">';
			echo '<div class="flickity-viewport pos-rel w-100">';
			echo '<div class="flickity-slider d-flex w-100 h-100" style="' . $origin . ': 0; transform: translateX(0%);">';
				
			// Build Query
			$GLOBALS['wp_query'] = $the_query;
			$before = $after = '';
			

			$this->add_excerpt_hooks();

			while( have_posts() ): the_post();

				$post_classes = array( 'lqd-pf-item', $this->get_item_classes() );		
				$post_classes = join( ' ', get_post_class( $post_classes, get_the_ID() ) );

				$attributes = array(
					'id' => 'post-' . get_the_ID(),
					'class' => $post_classes
				);

				echo $before;

					include $located;

				echo $after;

			endwhile;

			$this->remove_excerpt_hooks();

			wp_reset_query();

			if( 'yes' === $settings['show_filter'] ) {
				echo '</div>';
				echo '</div>';
			}
			echo '</div>';
			echo '</div>';
			echo '</div>';
			echo '</div>';
			echo '</div>';

		} elseif ($style === 'style05'){

			// Build Query and check for posts
			$the_query = new \WP_Query( $this->build_query() );
			if( !$the_query->have_posts() ) {
				return;
			}

			//Container 
			echo '<div class="lqd-pf-carousel carousel-container carousel-nav-floated carousel-nav-center carousel-nav-middle carousel-nav-circle carousel-nav-solid carousel-nav-lg carousel-nav-shadowed carousel-dots-mobile-inside" data-filterable-carousel="true">';
			
				// Include filter
			if( 'yes' === $settings['show_filter'] ) {
				$filter_located = locate_template( 'templates/portfolio/partial-filters.php' );
				include $filter_located;
			}

			echo '<div class="carousel-items pos-rel mx-0" data-lqd-flickity=\'{ "filters": "#' . $filter_id . '"' . $opt_counter .', "wrapAround": true, "groupCells": false, "prevNextButtons": true, "navOffsets": { "prev": 15, "next": 15 }, "prevNextButtonsOnlyOnMobile": true, "buttonsAppendTo": "' . $buttons_append_to . '" }\'>';
			echo '<div class="flickity-viewport pos-rel w-100 overflow-hidden">';
			echo '<div class="flickity-slider d-flex w-100 h-100" style="' . $origin . ': 0; transform: translateX(0%);">';
			
			// Build Query
			$GLOBALS['wp_query'] = $the_query;
			$before = $after = '';
			

			$this->add_excerpt_hooks();

			while( have_posts() ): the_post();

				$post_classes = array( 'lqd-pf-item', $this->get_item_classes() );		
				$post_classes = join( ' ', get_post_class( $post_classes, get_the_ID() ) );

				$attributes = array(
					'id' => 'post-' . get_the_ID(),
					'class' => $post_classes
				);

				echo $before;

					include $located;

				echo $after;

			endwhile;

			$this->remove_excerpt_hooks();

			wp_reset_query();

			echo '</div>';
			echo '</div>';
			echo '</div>';
			echo '</div>';

		} else {

			// Build Query and check for posts
			$the_query = new \WP_Query( $this->build_query() );
			if( !$the_query->have_posts() ) {
				return;
			}

			//Container 
			echo '<div class="lqd-pf-grid">';
				
				// Include filter
				if( 'yes' === $settings['show_filter'] ) {
					$filter_located = locate_template( 'templates/portfolio/partial-filters.php' );
					include $filter_located;
					printf( '<div id="%1$s" class="lqd-pf-row row d-flex flex-wrap %1$s" data-liquid-masonry="true" data-masonry-options=\'{ "filtersID": "#%2$s"' . $opt_counter . ' }\'>', $grid_id, $filter_id );
				}
				else {
					printf( '<div id="%1$s" class="lqd-pf-row row d-flex flex-wrap %1$s" data-liquid-masonry="true" data-masonry-options=\'{ "layoutMode": "packery"' . $opt_counter . ' }\'>', $grid_id);
				}

				// Build Query
				$GLOBALS['wp_query'] = $the_query;
				$before = $after = '';

				$this->add_excerpt_hooks();

				while( have_posts() ): the_post();

					$post_classes = array( 'lqd-pf-item', $this->get_item_classes() );		
					$post_classes = join( ' ', get_post_class( $post_classes, get_the_ID() ) );

					$attributes = array(
						'id'    => 'post-' . get_the_ID(),
						'class' => $post_classes
					);

					echo $before;

						include $located;

					echo $after;

				endwhile;

				$this->remove_excerpt_hooks();
				
				echo '</div>';
				
				// Pagination
				if( 'pagination' === $settings['pagination'] ) {

					$svg_args = array(
						'svg'     => array(
							'class'       => true,
							'xmlns'       => true,
							'width'       => true,
							'height'      => true,
							'viewbox'     => true,
							'aria-hidden' => true,
							'role'        => true,
							'focusable'   => true,
							'style'       => true,
						  ),
						  'path'    => array(
							'fill'      => true,
							'd'         => true,
						  ),
					);
	
					// Set up paginated links.
					$links = paginate_links( array(
						'type' => 'array',
						'prev_next' => true,
						'prev_text' => '<span aria-hidden="true">' . wp_kses( __( '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="32" viewBox="0 0 12 32" style="width: 1em; height: 1em;"><path fill="currentColor" d="M3.625 16l7.938 7.938c.562.562.562 1.562 0 2.125-.313.312-.688.437-1.063.437s-.75-.125-1.063-.438L.376 17c-.563-.563-.5-1.5.063-2.063l9-9c.562-.562 1.562-.562 2.124 0s.563 1.563 0 2.125z"></path></svg>', 'archub-elementor-addons' ), $svg_args ) . '</span>',
						'next_text' => '<span aria-hidden="true">' . wp_kses( __( '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="32" viewBox="0 0 12 32" style="width: 1em; height: 1em;"><path fill="currentColor" d="M8.375 16L.437 8.062C-.125 7.5-.125 6.5.438 5.938s1.563-.563 2.126 0l9 9c.562.562.624 1.5.062 2.062l-9.063 9.063c-.312.312-.687.437-1.062.437s-.75-.125-1.063-.438c-.562-.562-.562-1.562 0-2.125z"></path></svg>', 'archub-elementor-addons' ), $svg_args ) . '</span>',
					) );
	
					if( !empty( $links ) ) {
						printf( '<div class="page-nav text-center"><nav aria-label="Page navigation"><ul class="pagination"><li>%s</li></ul></nav></div>', join( "</li>\n\t<li>", $links ) );
					}
					
				}
				
				if( in_array( $settings['pagination'], array( 'ajax' ) ) && $url = get_next_posts_page_link( $GLOBALS['wp_query']->max_num_pages ) ) {
					$hash = array(
						'ajax' => 'btn btn-md ajax-load-more',
					);

					$attributes = array(
						'href' => add_query_arg( 'ajaxify', '1', $url ),
						'rel' => 'nofollow',
						'data-ajaxify' => true,
						'data-ajaxify-options' => json_encode( array(
							'wrapper' => '.lqd-pf-grid .lqd-pf-row',
							'items'   => '> .masonry-item',
							'trigger' => $ajax_trigger,
						) )
					);

					echo '<div class="liquid-pf-nav ld-pf-nav-ajax"><div class="page-nav text-center"><nav aria-label="' . esc_attr__( 'Page navigation', 'archub-elementor-addons' ) . '">';
					switch( $settings['pagination'] ) {

						case 'ajax':

							$icon = '';
							if ( isset( $settings['ajax_btn_icon']['value'] ) && !empty( $settings['ajax_btn_icon']['value'] ) ) {
								$icon =  '<i class="' . esc_attr( $settings['ajax_btn_icon']['value'] ) . '" style="vertical-align:middle"></i>';
							} 
							
							$ajax_text = ! empty( $settings['ajax_text'] ) ? esc_html( $settings['ajax_text'] ) : esc_html__( 'Load more', 'archub-elementor-addons' );
							$attributes['class'] = 'elementor-button btn ws-nowrap ld-ajax-loadmore ws-nowrap pos-rel';
							printf( '<a%2$s><span class="static d-block">%1$s %4$s</span><span class="loading d-block pos-abs"><span class="dots d-block"><span class="d-inline-block"></span><span class="d-inline-block"></span><span class="d-inline-block"></span></span><span class="d-block mt-1">' . esc_html__( 'Loading', 'archub-elementor-addons' ) . '</span></span><span class="all-loaded d-block pos-abs">' . esc_html__( 'All items loaded', 'archub-elementor-addons' ) . ' <svg width="32" height="29" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 29" style="width: 1.5em; height: 1.5em; margin-inline-start: 0.5em;"><path fill="currentColor" d="M25.74 6.23c0.38 0.34 0.42 0.9 0.09 1.28l-12.77 14.58a0.91 0.91 0 0 1-1.33 0.04l-5.46-5.46a0.91 0.91 0 1 1 1.29-1.29l4.77 4.78 12.12-13.85a0.91 0.91 0 0 1 1.29-0.08z"></path></svg></span></a>', $ajax_text, ld_helper()->html_attributes( $attributes ), $url, $icon );
							break;
					}

					echo '</nav></div></div>';
				}
				
				wp_reset_query();

			echo '</div>';
		}

	}

	protected function get_post_type_list() {
		
		$postTypesList = array(
			'liquid-portfolio' => __( 'Posts', 'archub-elementor-addons' ),
			//'ids' => __( 'List of IDs', 'archub-elementor-addons' ),
		);

		return $postTypesList;
	}

	// https://codex.wordpress.org/Making_Custom_Queries_using_Offset_and_Pagination
	// check it
	protected function build_query() {

		extract( $this->get_settings_for_display() );
		$settings = array();

		if( 'custom' === $post_type && ! empty( $custom_query ) ) {
			$query = html_entity_decode( vc_value_from_safe( $custom_query ), ENT_QUOTES, 'utf-8' );
			$settings = wp_parse_args( $query );
		}
		elseif( 'ids' === $post_type ) {

			if ( empty( $include ) ) {
				$include = - 1;
			}

			$incposts = wp_parse_id_list( $include );
			$settings = array(
				'post__in'       => $incposts,
				'posts_per_page' => count( $incposts ),
				'post_type'      => 'any',
				'orderby'        => 'post__in',
			);
		}
		else {

			$orderby = !empty( $_GET['orderby'] ) ? $_GET['orderby'] : $orderby;
			$order   = !empty( $_GET['order'] ) ? $_GET['order'] : $order;

			$settings = array(
				'posts_per_page' => isset( $posts_per_page ) ? (int) $posts_per_page : 100,
				'orderby'        => $orderby,
				'order'          => $order,
				'meta_key'       => in_array( $orderby, array(
					'meta_value',
					'meta_value_num',
				) ) ? $meta_key : '',
				'post_type'           => $post_type,
				'ignore_sticky_posts' => true,
			);

			if( $exclude ) {
				$settings['post__not_in'] = wp_parse_id_list( $exclude );
			}

			if( 'none' === $pagination ) {
				$settings['no_found_rows'] = true;
			}
			else {
				$settings['paged'] = ld_helper()->get_paged();
			}

			if ( $settings['posts_per_page'] < 1 ) {
				$settings['posts_per_page'] = 1000;
			}

			
			if ( ! empty( $taxonomies ) ) {

				$terms = get_terms( array(
					'hide_empty' => false,
					'include' => $taxonomies,
				) );
				$settings['tax_query'] = array();
				$tax_queries = array(); // List of taxnonimes
				foreach ( $terms as $t ) {
					if ( ! isset( $tax_queries[ $t->taxonomy ] ) ) {
						$tax_queries[ $t->taxonomy ] = array(
							'taxonomy' => $t->taxonomy,
							'field'    => 'id',
							'terms'    => array( $t->term_id ),
							'relation' => 'IN',
						);
					} else {
						$tax_queries[ $t->taxonomy ]['terms'][] = $t->term_id;
					}
				}
				$settings['tax_query'] = array_values( $tax_queries );
				$settings['tax_query']['relation'] = 'OR';
			}
		}

		return $settings;
	}

	public function add_excerpt_hooks() {
		add_filter( 'excerpt_more', array( $this, 'excerpt_more' ) );
		add_filter( 'excerpt_length', array( $this, 'excerpt_length' ) );
	}

	public function remove_excerpt_hooks() {
		remove_filter( 'excerpt_more', array( $this, 'excerpt_more' ) );
		remove_filter( 'excerpt_length', array( $this, 'excerpt_length' ) );
	}

	protected function get_item_classes() {

		$settings = $this->get_settings_for_display();
		
		$style = $settings['style'];
		$item_classes = array();


		if( 'style01' === $style ) {
			$item_classes[] = 'lqd-pf-item-style-1';
			$item_classes[] = !empty( $settings['color_type'] ) ? $settings['color_type'] : 'lqd-pf-dark';
			$item_classes[] = !empty( $settings['horizontal_alignment'] ) ? $settings['horizontal_alignment'] : 'pf-details-h-end';
			$item_classes[] = 'pos-rel';
			$item_classes[] = 'overflow-hidden';
		}
		elseif( 'style02' === $style ) {
			$item_classes[] = 'lqd-pf-item-style-2';
			$item_classes[] = 'lqd-pf-overlay-bg-scale';
			$item_classes[] = !empty( $settings['color_type'] ) ? $settings['color_type'] : 'lqd-pf-dark';
			$item_classes[] = !empty( $settings['horizontal_alignment'] ) ? $settings['horizontal_alignment'] : 'pf-details-h-str';
		}
		elseif( 'style03' === $style ) {
			$item_classes[] = 'lqd-pf-item-style-3';
			$item_classes[] = 'lqd-pf-overlay-bg-scale';
			$item_classes[] = 'lqd-pf-content-v';
			$item_classes[] = !empty( $settings['color_type'] ) ? $settings['color_type'] : 'lqd-pf-dark';
			$item_classes[] = !empty( $settings['horizontal_alignment'] ) ? $settings['horizontal_alignment'] : 'pf-details-h-str';
		}
		elseif( 'style04' === $style ) {
			$item_classes[] = 'lqd-pf-item-style-4';
			$item_classes[] = 'overflow-hidden';
			$item_classes[] = 'border-radius-6';
			$item_classes[] = 'pos-rel';
			$item_classes[] = 'lqd-pf-content-v';
			$item_classes[] = !empty( $settings['color_type'] ) ? $settings['color_type'] : 'lqd-pf-light';
			$item_classes[] = !empty( $settings['horizontal_alignment'] ) ? $settings['horizontal_alignment'] : 'pf-details-h-str';
		}
		elseif( 'style05' === $style ) {
			$item_classes[] = 'lqd-pf-item-style-5';
			$item_classes[] = 'pos-rel';
			$item_classes[] = !empty( $settings['color_type'] ) ? $settings['color_type'] : 'lqd-pf-light';
			$item_classes[] = !empty( $settings['horizontal_alignment'] ) ? $settings['horizontal_alignment'] : 'pf-details-h-str';
		}
		elseif( 'style06' === $style ) {
			$item_classes[] = 'lqd-pf-item-style-6';
			$item_classes[] = 'border-radius-6';
			$item_classes[] = 'p-3';
			$item_classes[] = 'pt-4';
			$item_classes[] = !empty( $settings['color_type'] ) ? $settings['color_type'] : 'lqd-pf-dark';
		}
		
		return join( ' ', $item_classes );
		
	}

	protected function get_column_class() {

		$page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers( 'page' );
		$page_settings_model = $page_settings_manager->get_model( get_the_ID() );
		$width = $page_settings_model->get_settings( 'portfolio_width' );

		if ( !empty( $width ) && 'auto' !=  $width ) {
			echo $width;
			return;
		}

		$img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'post-thumbnail' );
		$width = $img[1];

		if( $width > 260 && $width < 370 ) {
			echo '3';
			return;
		}

		if( $width > 360 && $width < 470 ) {
			echo '4';
			return;
		}

		if( $width > 471 && $width < 600 ) {
			echo '5';
			return;
		}

		if( $width > 600 ) {
			echo '6';
			return;
		}
	}

	/**
	 * [entry_term_classes description]
	 * @method entry_term_classes
	 * @return [type]             [description]
	 */
	protected function entry_term_classes() {

		$settings = $this->get_settings_for_display();

		$terms = get_the_terms( get_the_ID(), 'liquid-portfolio-category' );
		if( !$terms ) {
			return;
		}
		$terms = wp_list_pluck( $terms, 'slug' );
		echo join( ' ', $terms );

	}

	protected function entry_thumbnail( $size = 'full' ) {

		$settings = $this->get_settings_for_display();
	
		if ( post_password_required() || is_attachment() ) {
			return;
		}
		
		$format = get_post_format();
		$style  = $settings['style'];

		if  ( 'yes' === $settings['disable_postformat'] ) {
			$format = 'image';
		}
		
		$thumb_size = $this->get_thumb_size();
		if( ! empty( $thumb_size ) ) {
			$size = $thumb_size;
		}
		
		$image_src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
		$resized_image = liquid_get_resized_image_src( $image_src, $size );
		$image_is_overlay =
			'style03' === $style ||
			'style04' === $style ||
			'style05' === $style ||
			'yes' === $settings['enable_parallax_img'];
		
		$figure_attrs = array(
			'class' => []
		);
		$image_attrs = array(
			'class' => ['w-100']
		);

		if ( 'style03' === $style || 'style04' === $style || 'style05' === $style ) {
			
			$figure_attrs['class'][] = 'lqd-overlay';
			
		} else {

			$figure_attrs['class'][] = 'w-100';

		}

		if ( $image_is_overlay ) {

			$image_attrs['class'][] = 'h-100';
			$image_attrs['class'][] = 'objfit-cover';
			$image_attrs['class'][] = 'objfit-center';

		}

		if ( 'yes' === $settings['enable_parallax_img'] ) {

			$figure_attrs['class'][] = 'overflow-hidden';

			$image_attrs['data-parallax'] = true;
			$image_attrs['data-parallax-from'] = wp_json_encode( array( 'yPercent' => -25 ) );
			$image_attrs['data-parallax-to'] = wp_json_encode( array( 'yPercent' => 25 ) );
			$image_attrs['data-parallax-options'] = wp_json_encode( array( 'scrub' => 1 ) );

		}

		$image_attrs['class'] = implode( ' ', $image_attrs['class'] );
		$figure_attrs['class'] = implode( ' ', $figure_attrs['class'] );
		
		echo '<figure ' . ld_helper()->html_attributes( $figure_attrs ) . '>';
			liquid_the_post_thumbnail( $size, $image_attrs );
		echo '</figure>';
	
	}

	protected function get_thumb_size() {

		$page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers( 'page' );
		$page_settings_model = $page_settings_manager->get_model( get_the_ID() );
		$size = $page_settings_model->get_settings( '_portfolio_image_size' );

		if( ! empty( $size ) ) {
			return $size;
		}

	}

	protected function entry_cats() {

		$settings = $this->get_settings_for_display();
		
		$style = $settings['style'];
		$one_category = $settings['one_category'];
		
		$terms = get_the_terms( get_the_ID(), 'liquid-portfolio-category' );

		if ( ! $terms || count( $terms ) === 0 ) {
			return;
		}

		$term = $terms[0];

		if( !isset( $term->name ) ) {
			return;
		}

		if( 'yes' === $one_category ) {
			$out = sprintf( '<ul class="reset-ul inline-nav lqd-pf-cat d-inline-flex pos-rel z-index-2"><li><a href="%s">%s</a></li></ul>', get_term_link( $term->slug, $term->taxonomy ), $term->name );
		} else {
			$out = sprintf('<ul class="reset-ul inline-nav lqd-pf-cat lqd-lp-cat d-inline-flex pos-rel z-index-2">');
			foreach( $terms as $t ) {
				$out .= sprintf('<li><a href="%s">%s</a></li>', get_term_link( $t->slug, $t->taxonomy ), $t->name );
			}
			$out .= sprintf('</ul>');

		}

		echo $out;

	}

	protected function get_overlay_button() {

		$settings = $this->get_settings_for_display();

		$page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers( 'page' );
		$page_settings_model = $page_settings_manager->get_model( get_the_ID() );

		$ext_url = $page_settings_model->get_settings( 'portfolio_website' );
		
		$local_url = get_the_permalink( get_the_ID() );
		$enable_gallery = $settings['enable_gallery'];
		$cc_style = $settings['custom_cursor_style'];
		
		$target = '';
		
		$enable_ext = $settings['enable_ext'];
		if( $enable_ext ) {
			$url = isset( $ext_url['url'] ) ? esc_url( $ext_url['url'] ) : $local_url;
			$target = 'target="_blank"';
		}
		else {
			$url = esc_url( $local_url );	
		}

		// video url
		if ( $video_url = get_post_meta( get_the_ID(), 'post-video-url' ) ) {
			$url = esc_url( $video_url[0] );
		}
		
		if( 'listing-lightbox-gallery' === $enable_gallery ) {
			$url = wp_get_attachment_image_url( get_post_thumbnail_id(), 'full' );

			// video url
			if ( $video_url = get_post_meta( get_the_ID(), 'post-video-url' ) ) {
				$url = esc_url( $video_url[0] );
			}

			printf( '<a href="%s" class="lqd-overlay lqd-pf-overlay-link fresco %s" data-fresco-group="'. esc_attr( $this->get_id() ) .'" data-cc-icon-color="%s"></a>', $url, $cc_style, $settings['cc_icon_color']);	
		}
		else {
			printf( '<a href="%s" %s class="lqd-overlay lqd-pf-overlay-link %s" data-cc-icon-color="%s"></a>', $url, $target, $cc_style, $settings['cc_icon_color']);
		}
		
	}

	public function before_output( $atts, &$content ) {

		$settings = $this->get_settings_for_display();


		if( 'style03' === $settings['style'] ) {
			$settings['template'] = 'carousel';
		}
		elseif( 'style04' === $settings['style'] ) {
			$settings['template'] = 'carousel-2';
		}
		elseif( 'style05' === $settings['style'] ) {
			$settings['template'] = 'carousel-3';
		}

		return $atts;
	}

	protected function entry_title() {

		$settings = $this->get_settings_for_display();

		if( !$settings['show_title'] ) {
			return;
		}

		$sub_style = $settings['item_style'];

		// Default
		the_title( sprintf( '<h2><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
	}

	protected function entry_subtitle( $before = '<p>', $after = '</p>' ) {

		$page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers( 'page' );
		$page_settings_model = $page_settings_manager->get_model( get_the_ID() );
		$subtitle = $page_settings_model->get_settings( 'portfolio_subtitle' );

		if( empty( $subtitle ) ) {
			return;
		}
		
		printf( '%1$s %2$s %3$s', $before, esc_html( $subtitle ), $after  );
	}

	protected function entry_read_more() {

		$settings = $this->get_settings_for_display();

		if( !$settings['show_link'] ) {
			return;
		}

		$link = '<a href="' . esc_url( get_permalink() ) . '" class="read-more">
					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
					 	viewBox="0 0 268.832 268.832" style="enable-background:new 0 0 268.832 268.832;"
						 xml:space="preserve">
						<g>
							<path d="M265.171,125.577l-80-80c-4.881-4.881-12.797-4.881-17.678,0c-4.882,4.882-4.882,12.796,0,17.678l58.661,58.661H12.5
								c-6.903,0-12.5,5.597-12.5,12.5c0,6.902,5.597,12.5,12.5,12.5h213.654l-58.659,58.661c-4.882,4.882-4.882,12.796,0,17.678
								c2.44,2.439,5.64,3.661,8.839,3.661s6.398-1.222,8.839-3.661l79.998-80C270.053,138.373,270.053,130.459,265.171,125.577z"/>
						</g>
					</svg>
				</a>';

		echo $link;
	}

	protected function entry_content() {

	?>
		<div class="portfolio-summary">
			<p><?php liquid_portfolio_the_excerpt(); ?></p>
		</div>
	<?php
	}

	public function excerpt_more() {
		return '';
	}

	public function excerpt_length() {
		return 10;
	}

	protected function get_grid_class() {

		$settings = $this->get_settings_for_display();

		$column = $settings['grid_columns'];
		$hash = array(
			'1' => '12',
			'2' => '6',
			'3' => '4',
			'4' => '3',
			'6' => '2'
		);

		printf( 'col-md-%s col-sm-6 col-xs-12', $hash[$column] );
	}

	protected function get_badge() {

		$page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers( 'page' );
		$page_settings_model = $page_settings_manager->get_model( get_the_ID() );
		$badge = $page_settings_model->get_settings( 'portfolio_badge' );
		
		if( !empty( $badge ) ) {
			printf( '<span class="lqd-pf-badge">%s</span>', esc_html( $badge ) );
		}
	}

	protected function get_button() {
		
		extract( $this->get_settings_for_display() );
		$ib_link = isset($ib_link['url']) ? $ib_link['url'] : '';
		$ib_i_icon = isset($ib_icon['value']) ? $ib_icon['value'] : '';

		$ib_classes = array( 
			'elementor-button',
			'btn',
			'align-items-center',
			'justify-content-center',
			'pos-rel',
			'overflow-hidden',
			'ws-nowrap',
			$ib_style,
			$ib_i_separator,
			$ib_hover_txt_effect,
			$ib_style === 'btn-solid' ? $ib_hover_bg_effect : '',
			$ib_border_w,
		
			($ib_link_type === 'lightbox') ? 'fresco' : '',
			
			//Icon Classes
			$ib_i_position,
			$ib_i_shape,
			$ib_i_shape !== '' && $ib_i_shape_style !== '' ? $ib_i_shape_size : '',
			$ib_i_shape !== '' && $ib_i_shape_style !== '' ? 'btn-icon-shaped' : '',
			$ib_i_shape_style,	
			$ib_i_shape_bw,	
			$ib_i_ripple,
			$ib_i_add_icon === 'true' && ($ib_i_position === 'btn-icon-left' || $ib_i_position === 'btn-icon-right') ? $ib_i_hover_reveal : '',
			!empty( $ib_title ) ? 'btn-has-label' : 'btn-no-label',
		);

	 if ($show_button === 'yes'){	

		$txt_class = array(
			'btn-txt',
			'd-block',
			'pos-rel',
			'z-index-3',
			'btn-hover-txt-switch btn-hover-txt-switch-x' === $ib_hover_txt_effect ||
			'btn-hover-txt-switch btn-hover-txt-switch-y' === $ib_hover_txt_effect ? 'overflow-hidden' : '',
		);

		$data_text = $ib_title;

		if ( $ib_hover_txt_effect === 'btn-hover-txt-switch-change btn-hover-txt-switch btn-hover-txt-switch-y' && ! empty($ib_title_secondary) ) {
			$data_text = $ib_title_secondary;
		}

		$ib_attributes['href'] = trim($ib_link);
		$ib_attributes['class'] = ld_helper()->sanitize_html_classes( $ib_classes );

		if( !empty( $ib_image_caption ) ) {
			$ib_attributes['data-fresco-caption'] = $ib_image_caption;
		} 

		if( 'modal_window' === $ib_link_type ) {
			$ib_attributes['data-lqd-lity'] = isset( $ib_anchor_id ) ? esc_url( $ib_anchor_id ) : '#modal-box';
			$ib_attributes['href'] = isset( $ib_anchor_id ) ? esc_url( $ib_anchor_id ) : '#modal-box';
		}
		elseif( 'local_scroll' === $ib_link_type ) {
			$ib_attributes['data-localscroll'] = true;
			$ib_attributes['href'] = isset( $ib_anchor_id ) ? esc_url( $ib_anchor_id ) : '#';
			if( !empty( $ib_scroll_speed ) ) {
				$ib_attributes['data-localscroll-options'] = wp_json_encode( array( 'scrollSpeed' => $ib_scroll_speed ) );
			}
			
		}
		elseif( 'scroll_to_section' === $ib_link_type ) {
			$ib_attributes['data-localscroll'] = true;
			if( !empty( $ib_scroll_speed ) ) {
				$ib_attributes['data-localscroll-options'] = wp_json_encode( array( 'scrollBelowSection' => true, 'scrollSpeed' => $ib_scroll_speed ) );	
			}
			else {
				$ib_attributes['data-localscroll-options'] = wp_json_encode( array( 'scrollBelowSection' => true ) );
			}
			
			$ib_attributes['href'] = '#';
		}?>
		<a <?php echo ld_helper()->html_attributes( $ib_attributes ) ?> >
			<?php if( !empty( $ib_title ) ) { ?>
				<span class="<?php echo ld_helper()->sanitize_html_classes( $txt_class ) ?>" data-text="<?php echo esc_attr( $data_text ) ?>" <?php $this->get_hover_text_opts(); ?>>
					<?php
						if(
							'btn-hover-txt-switch btn-hover-txt-switch-x' === $ib_hover_txt_effect ||
							'btn-hover-txt-switch btn-hover-txt-switch-y' === $ib_hover_txt_effect ||
							'btn-hover-txt-switch-change btn-hover-txt-switch btn-hover-txt-switch-y' === $ib_hover_txt_effect
						) {
					?>
						<span class="btn-txt-inner d-inline-flex align-items-center justify-content-center"  data-text="<?php echo esc_attr( $data_text ) ?>">
							<?php echo wp_kses_post( do_shortcode( $ib_title ) ); ?>
						</span>
					<?php } else { ?>
						<?php echo wp_kses_post( do_shortcode( $ib_title ) ); ?>
					<?php } ?>
				</span>
			<?php } ?>
			<?php
				if( $ib_i_icon ) {
					printf( '<span class="btn-icon pos-rel z-index-3"><i class="%s"></i></span>', $ib_i_icon );
				}
				if( 'btn-hover-swp' === $ib_i_hover_reveal ) {
					printf( '<span class="btn-icon pos-rel z-index-3"><i class="%s"></i></span>', $ib_i_icon );
				}
				if( 'yes' === $ib_extended_lines && 'btn-solid' === $ib_style ) {
					foreach (['tl', 'tr', 'br', 'bl'] as $side) { ?>
						<i class="btn-extended-line btn-extended-line-<?php echo $side ?> d-inline-block pos-abs pointer-events-none"></i>
					<?php }
				}
			?>
		</a>
		<?php

		}
	}
	
	protected function get_border() {

		$style = $this->get_settings_for_display('ib_style');
		
		if( 'btn-naked' === $style || 'btn-underlined' === $style ) {
			return;
		}

		$border = $this->get_settings_for_display('ib_border');

		if ( 'btn-solid' === $style ) {
			return $border;	
		}
		
		return "btn-bordered $border";	
	}

	protected function get_hover_text_opts() {
		
		$effect = $this->get_settings_for_display('ib_hover_txt_effect');
		if( empty( $effect ) ) {
			return;
		}

		$start_delay = 0;
		$out = '';
		
		switch( $effect ) {
			
			case 'btn-hover-txt-liquid-x':
			case 'btn-hover-txt-liquid-x-alt':
			case 'btn-hover-txt-liquid-y':
			case 'btn-hover-txt-liquid-y-alt':
				$out = 'data-split-text="true" data-split-options=\'{"type": "chars, words"}\'';
				break;

			default:
				$out = '';
				break;

		}

		echo $out;

	}

	private function get_category_filters() {
		$menus = wp_get_nav_menus();
		$options = [];
		foreach ( $menus as $menu ) {
			$options[ $menu->slug ] = $menu->name;
		}
		return $options;
	}

	protected function get_taxonomies() {

		$taxonomies = get_terms(  array(
			'taxonomy'   => 'liquid-portfolio-category',
			'hide_empty' => false,
		));

		if ( is_wp_error( $taxonomies ) ) {
			return [];
		}
	
		$options = [ '' => '' ];
	
		foreach ( $taxonomies as $taxonomy ) {
		  $options[ $taxonomy->slug ] = $taxonomy->name;
		}
	
		return $options;
	  }

	  protected function get_narrow_taxonomies() {
		
		$taxonomies = get_categories(  
			array( 
				'taxonomy'     => 'liquid-portfolio-category',
				'orderby'      => 'name',
			)
		);
	
		$options = [ '' => '' ];
	
		foreach ( $taxonomies as $taxonomy ) {
		  $options[ $taxonomy->cat_ID ] = $taxonomy->name;
		}
	
		return $options;
	  }

	  protected function get_exlude_taxonomies() {
		$taxonomies = get_posts(  array(
			'post_type'   => 'liquid-portfolio',
			'hide_empty' => false,
			'posts_per_page' => -1,
		));
	
		$options = [ '' => '' ];
	
		foreach ( $taxonomies as $taxonomy ) {
		  $options[ $taxonomy->ID ] = $taxonomy->post_title;
		}
	
		return $options;
	  }


}
