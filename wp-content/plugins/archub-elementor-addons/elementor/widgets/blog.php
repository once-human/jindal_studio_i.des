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
use Elementor\Heading;
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
class LD_Blog extends Widget_Base {

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
		return 'ld_blog';
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
		return __( 'Liquid Blog List', 'elementor' );
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
		return 'eicon-post-list lqd-element';
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
		return [ 'hub-core' ];
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
		return [ 'blog', 'post', 'page' ];
	}

	/**
	 * Retrieve the list of scripts the counter widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.1
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {

		if ( liquid_helper()->liquid_elementor_script_depends() ){
			return [ 'isotope', 'packery-mode' ];
		} else {
			return [''];
		}
		
	}

    protected function get_post_type_list() {
		
		$postTypesList = array(
			'post' => __( 'Posts', 'archub-elementor-addons' ),
			'ids' => __( 'List of IDs', 'archub-elementor-addons' ),
		);

		return $postTypesList;
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

		$this->start_controls_section(
			'blog_section',
			array(
				'label' => __( 'Blog', 'archub-elementor-addons' ),
			)
		);

		$this->add_control(
			'style',
			[
				'label' => __( 'Style', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'style01',
				'options' => [
					'style01' => __( 'Style 1', 'archub-elementor-addons' ),
					'style02' => __( 'Style 2', 'archub-elementor-addons' ),
					'style03' => __( 'Style 3', 'archub-elementor-addons' ),
					'style04' => __( 'Style 4', 'archub-elementor-addons' ),
					'style05' => __( 'Style 5', 'archub-elementor-addons' ),
					'style06' => __( 'Style 6', 'archub-elementor-addons' ),
					'style07' => __( 'Style 7', 'archub-elementor-addons' ),
					'style08' => __( 'Style 8', 'archub-elementor-addons' ),
					'style09' => __( 'Style 9', 'archub-elementor-addons' ),
					'style10' => __( 'Style 10', 'archub-elementor-addons' ),
					'style11' => __( 'Style 11', 'archub-elementor-addons' ),
					'style12' => __( 'Style 12', 'archub-elementor-addons' ),
					'style13' => __( 'Style 13', 'archub-elementor-addons' ),
					'style14' => __( 'Style 14', 'archub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'enable_filter',
			[
				'label' => __( 'Post Filters', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'no',
				'options' => [
					'no' => __( 'Disable', 'archub-elementor-addons' ),
					'yes' => __( 'Enable', 'archub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'masonry_layout',
			[
				'label' => __( 'Use Masonry Layout?', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'packery',
				'default' => 'packery',
				'condition' => [
					'enable_filter' => 'yes'
				],
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
					'enable_filter' => 'yes',
				],
			]
		);

		$this->start_popover();

		$this->add_control(
			'filter_cats',
			[
				'label' => __( 'Categories', 'archub-elementor-addons' ),
				'description' => __( 'Enter categories to display in filter bar.', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => $this->get_available_categories(),
			]
		);

		$this->add_control(
			'filter_normal_color',
			[
				'label' => __( 'Color', 'archub-elementor-addons' ),
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
			'filter_lbl_all',
			[
				'label' => __( 'Label "All"', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'All', 'archub-elementor-addons' ),
				'placeholder' => __( 'All', 'archub-elementor-addons' ),
			]
		);

		$this->add_control(
			'filter_color',
			[
				'label' => __( 'Color Scheme', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''  => __( 'Default', 'archub-elementor-addons' ),
					'filter-list-scheme-light'  => __( 'Light', 'archub-elementor-addons' ),
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
				],
				'selectors' => [
					'{{WRAPPER}} .liquid-filter-items' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'filter_typography',
				'label' => __( 'Typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .filter-list',
			]
		);
		$this->end_popover();

		$this->add_control(
			'filter_title_toggle',
			[
				'label' => __( 'Filter Title', 'archub-elementor-addons' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'label_off' => __( 'Default', 'archub-elementor-addons' ),
				'label_on' => __( 'Custom', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'separator' => 'after',
				'condition' => [
					'enable_filter' => 'yes',
				],
			]
		);

		$this->start_popover();
		$this->add_control(
			'filter_title',
			[
				'label' => __( 'Filter Title', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Filter by', 'archub-elementor-addons' ),
			]
		);
		
		$this->add_control(
			'filter_subtitle',
			[
				'label' => __( 'Filter Subtitle', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Subtitle', 'archub-elementor-addons' ),
				'condition' => [
					'style' => 'carousel-filterable',
				],
			]
		);

		$this->add_control(
			'link_label',
			[
				'label' => __( 'Button Label', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Subtitle', 'archub-elementor-addons' ),
				'condition' => [
					'style' => 'carousel-filterable',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'filter_title_typography',
				'label' => __( 'Typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .liquid-filter-items-label',
			]
		);

		$this->end_popover();

		$this->add_responsive_control(
			'grid_columns_custom',
			[
				'label' => __( 'Columns custom width', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw', 'vh' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 0.1,
					],
					'vw' => [
						'min' => 0,
						'max' => 100,
						'step' => 0.1,
					],
					'vh' => [
						'min' => 0,
						'max' => 100,
						'step' => 0.1,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-lp-column' => 'width: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->add_control(
			'items_height',
			[
				'label' => __( 'Items Height', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'h-vh-100',
				'options' => [
					'h-vh-100' => __( 'Full Height', 'archub-elementor-addons' ),
					'h-pt-75' => __( '75% of Column Width (Wide)', 'archub-elementor-addons' ),
					'h-pt-100' => __( '100% of Column Width (Square)', 'archub-elementor-addons' ),
					'h-pt-125' => __( '125% of Column Width (Tall)', 'archub-elementor-addons' ),
					'h-custom' => __( 'Custom', 'archub-elementor-addons' ),
				],
				'condition' => array(
					'style' => 'style08',
				)
			]
		);

		$this->add_responsive_control(
			'items_height_custom',
			[
				'label' => __( 'Custom Height', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw', 'vh' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 0.1,
					],
					'vw' => [
						'min' => 0,
						'max' => 100,
						'step' => 0.1,
					],
					'vh' => [
						'min' => 0,
						'max' => 100,
						'step' => 0.1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 500,
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-lp' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'items_height' => 'h-custom',
					'style' => 'style08',
				]
			]
		);

		$this->add_responsive_control(
			'items_vertical_aling',
			[
				'label' => __( 'Vertical Alignment', 'archub-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => __( 'Start', 'archub-elementor-addons' ),
						'icon' => 'eicon-h-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'archub-elementor-addons' ),
						'icon' => 'eicon-h-align-center',
					],
					'end' => [
						'title' => __( 'End', 'archub-elementor-addons' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-lp' => 'align-items: {{VALUE}}; text-align: {{VALUE}} !important;',
					'{{WRAPPER}} .lqd-lp-inner, {{WRAPPER}} .lqd-lp-title' => 'text-align: inherit !important;',
				],
				'toggle' => true,
				'condition' => [
					'style' => ['style08', 'style13'],
				],
			]
		);

		$this->add_responsive_control(
			'items_horizontal_aling',
			[
				'label' => __( 'Horizontal Alignment', 'archub-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => __( 'Top', 'archub-elementor-addons' ),
						'icon' => 'eicon-v-align-top',
					],
					'center' => [
						'title' => __( 'Middle', 'archub-elementor-addons' ),
						'icon' => 'eicon-v-align-middle',
					],
					'flex-end' => [
						'title' => __( 'Bottom', 'archub-elementor-addons' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-lp-inner' => 'justify-content: {{VALUE}} !important;',
				],
				'toggle' => true,
				'condition' => [
					'style' => 'style08',
				],
			]
		);

		$this->add_control(
			'show_meta',
			[
				'label' => __( 'Post Meta', 'archub-elementor-addons' ),
				'description' => __( 'Show/Hide post meta ( tags, categories )', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'yes',
				'options' => [
					'yes'  => __( 'Show', 'archub-elementor-addons' ),
					'no'  => __( 'Hide', 'archub-elementor-addons' ),
				],
				'condition' => array(
						'style!' => array( 
								'style09',
						),
				),
			]
		);

		$this->add_control(
			'meta_type',
			[
				'label' => __( 'Meta Type', 'archub-elementor-addons' ),
				'description' => __( 'Type Of Post Meta To Show', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'cats',
				'options' => [
					'tags'  => __( 'Tags', 'archub-elementor-addons' ),
					'cats'  => __( 'Categories', 'archub-elementor-addons' ),
				],
				'condition' => array(
					'show_meta' => 'yes',
				),
			]
		);

		$this->add_control(
			'meta_style',
			[
				'label' => __( 'Meta Style', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => [
					'solid'  => __( 'Solid', 'archub-elementor-addons' ),
					'plain'  => __( 'Plain', 'archub-elementor-addons' ),
				],
				'condition' => array(
					'show_meta' => 'yes',
					'style' => [ 'style13' ],
				),
			]
		);

		$this->add_control(
			'one_category',
			[
				'label' => __( 'Show Only One Post Meta', 'archub-elementor-addons' ),
				'description' => __( 'Enable to show one category/tag', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'yes',
				'options' => [
					'yes' => __( 'Enable', 'archub-elementor-addons' ),
					'no' => __( 'Disable', 'archub-elementor-addons' ),
				],
				'condition' => array(
					'show_meta' => 'yes',
				),
			]
		);

		$this->add_control(
			'show_read_more_button',
			[
				'label' => __( 'Read More Button', 'archub-elementor-addons' ),
				'description' => __( 'Show/Hide read more button', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'yes',
				'options' => [
					'yes'  => __( 'Show', 'archub-elementor-addons' ),
					'no'  => __( 'Hide', 'archub-elementor-addons' ),
				],
				'condition' => [
					'style' => [ 
						'style06',
						'style07',
						'style08',
						'style10',
					],
				],
			]
		);

		$this->add_control(
			'enable_post_excerpt',
			[
				'label' => __( 'Post Excerpt', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'yes',
				'options' => [
					'yes'  => __( 'Show', 'archub-elementor-addons' ),
					'no'  => __( 'Hide', 'archub-elementor-addons' ),
				],
				'condition' => [
					'style!' => array(  
						'style01',
						'style02',
						'style10',
					),
				],
			]
		);
        
		$this->add_control(
			'post_excerpt_length',
			[
				'label' => __( 'Excerpt Length', 'archub-elementor-addons' ),
				'description' => __( 'Set the excerpt length. Leave blank to set default ( 20 words )', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Default 20', 'archub-elementor-addons' ),
				'condition' => array(
					'style!' => array(  
						'style01',
						'style02',
						'style10',
					),
				),
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
					'ajax' => __( 'Load More', 'archub-elementor-addons' ),
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
				'condition' => array(
					'pagination' => 'ajax',
				)
			]
		);

		$this->add_control(
			'ajax_text',
			array(
				'label' => __( 'Button Label', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'condition' => array(
					'pagination' => 'ajax',
				),
			)
		);

		$this->add_control(
			'post_type',
			[
				'label' => __( 'Data source', 'archub-elementor-addons' ),
				'description' => __( 'Select content type for your grid.', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'post',
				'options' => self::get_post_type_list(),
			]
		);

		$this->add_control(
			'posts_per_page',
			array(
				'label' => __( 'Total items', 'archub-elementor-addons' ),
				'description' => esc_html__( 'Set max limit for items in grid or enter -1 to display all (limited to 1000).', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => '10',
				'condition' => array(
					'post_type!' => array( 'ids' )
				),
			)
		);

		$this->add_control(
			'taxonomies',
			[
				'label' => __( 'Narrow data source', 'archub-elementor-addons' ),
				'description' => __( 'Enter categories.', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => $this->get_available_categories(),
                'condition' => [
                    'post_type' => 'post',
				],
            ]
		);

		$this->add_control(
			'include',
			[
				'label' => __( 'Include only', 'archub-elementor-addons' ),
				'description' => __( 'Add posts, pages, etc. by title.', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
                'placeholder' => __( 'Add posts, pages, etc. by title.', 'archub-elementor-addons' ),
                'condition' => array(
                    'post_type' => 'ids',
                )
            ]
		);
		$this->end_controls_section();

        // Columns Spacing
		$this->start_controls_section(
			'columns_spacing_section',
			array(
				'label' => __( 'Columns Spacing', 'archub-elementor-addons' ),
			)
		);

		$this->add_responsive_control(
			'columns_gap',
			[
				'label' => __( 'Columns Spacing', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 15,
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-lp-row' => 'margin-inline-start: -{{SIZE}}{{UNIT}};margin-inline-end: -{{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .lqd-lp-column' => 'padding-inline-start: {{SIZE}}{{UNIT}};padding-inline-end: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'bottom_gap',
			[
				'label' => __( 'Bottom Spacing', 'archub-elementor-addons' ),
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
					'{{WRAPPER}} .lqd-lp-column' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();

		// Style Section
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
				'selector' => '{{WRAPPER}} .lqd-lp-title',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => __( 'Content typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-lp-excerpt p',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'readmore_btn_typography',
				'label' => __( 'Read more button typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-lp-footer .btn',
				'condition' => [ 'show_read_more_button' => 'yes' ],
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'label' => __( 'Title margin', 'archub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-lp-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}!important;',
				],
				'separator' => 'before'
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Title color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-lp-title a' => 'color: {{VALUE}}',
				],
				'separator' => 'before'
			]
		);

		$this->add_control(
			'title_hover_color',
			[
				'label' => __( 'Title hover color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-lp .lqd-lp-title a:hover' => 'color: {{VALUE}}',
					'{{WRAPPER}} .lqd-lp:hover .lqd-lp-title a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'underline_color',
			[
				'label' => __( 'Underline color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-lp h2 .split-inner:before' => 'background: {{VALUE}}',
				],
                'condition' => array(
                    'style' => 'style09',
                )
			]
		);

		$this->add_control(
			'hover_underline_color',
			[
				'label' => __( 'Underline color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-lp h2 .split-inner:after' => 'background: {{VALUE}}',
				],
                'condition' => array(
                    'style' => array(
                        'style06',
						'style09',
						'style10'
                    ),
                )
			]
		);

		$this->add_control(
			'excerpt_color',
			[
				'label' => __( 'Excerpt color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-lp-excerpt' => 'color: {{VALUE}}',
				],
				'condition' => array(
					'style' => array(
					'style04',
					'style05',
					'style06',
					'style07',
					'style11',
					'style13',
					),
				)
			]
		);
		
		$this->add_control(
			'meta_color',
			[
				'label' => __( 'Meta color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-lp-meta, {{WRAPPER}} .lqd-lp-date' => 'color: {{VALUE}}',
				],
				'condition' => [ 
					'show_meta' => 'yes'
				]
			]
		);		
        
		$this->add_control(
			'btn_color',
			[
				'label' => __( 'Button color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-lp-read-more' => 'color: {{VALUE}}',
				],
				'condition' => array(
					'style' => array(
						'style07',
						'style08',
					),
				)
			]
		);

		$this->add_control(
			'hover_btn_color',
			[
				'label' => __( 'Hover button color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}:hover .lqd-lp-read-more' => 'color: {{VALUE}}',
				],
				'condition' => array(
					'style' => array(
						'style07',
						'style08',
					),
				)
			]
		);

		$this->add_control(
			'background_heading',
			[
				'label' => __( 'Background', 'archub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'style' => array(
						'style12'
					),
				)
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'bg_color',
				'label' => __( 'Background color', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .lqd-lp',
				'condition' => array(
					'style' => array(
						'style12'
					),
				)
			]
		);

		$this->add_control(
			'overlay_background_heading',
			[
				'label' => __( 'Overlay color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'style' => array(
						'style02',
						'style05',
						'style08',
						'style12'
					),
				)
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'overlay_color',
				'label' => __( 'Overlay color', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .lqd-lp .lqd-lp-content-bg, {{WRAPPER}} .lqd-lp .lqd-lp-img .lqd-overlay',
				'condition' => array(
					'style' => array(
						'style02',
						'style05',
						'style08',
						'style12'
					),
				)
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'items_border',
				'selector' => '{{WRAPPER}} .lqd-lp',
				'separator' => 'before',
				'condition' => array(
					'style' => array(
						'style04',
						'style12',
					),
				),
			]
		);

		$this->end_controls_section();

		// Pagination Styling
		$this->start_controls_section(
			'ajax_btn_colors_section',
			array(
				'label' => __( 'Pagination Button Styling', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'pagination' => [ 'ajax' ]
				]
			)
		);

		$this->start_controls_tabs(
			'pagination_style_tabs'
		);

		// Normal state
		$this->start_controls_tab(
			'pagination_style_normal_tab',
			[
				'label' => __( 'Normal', 'archub-elementor-addons' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'pagination_btn_bg',
				'label' => __( 'Button Background', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .ld-ajax-loadmore',
			]
		);

		$this->add_control(
			'pagination_btn_color',
			[
				'label' => __( 'Button text color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ld-ajax-loadmore' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		// Hovver state
		$this->start_controls_tab(
			'pagination_style_hover_tab',
			[
				'label' => __( 'Hover', 'archub-elementor-addons' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'hover_pagination_btn_bg',
				'label' => __( 'Button Background', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .ld-ajax-loadmore:hover',
			]
		);

		$this->add_control(
			'hover_pagination_btn_color',
			[
				'label' => __( 'Button text color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ld-ajax-loadmore:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'ajax_btn_width',
			[
				'label' => __( 'Ajax Button Width', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Default', 'archub-elementor-addons' ),
					'btn-block' => __( 'Fullwidth', 'archub-elementor-addons' ),
				],
				'condition' => array(
					'pagination' => 'ajax',
				),
			]
		);

		$this->end_controls_section();

		// Data Section
		$this->start_controls_section(
			'data_section',
			[
				'label' => __( 'Data', 'archub-elementor-addons' ),
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
					'title' => __( 'title', 'archub-elementor-addons' ),
					'modified' => __( 'Last modified date', 'archub-elementor-addons' ),
					'parent' => __( 'Post/page parent ID', 'archub-elementor-addons' ),
					'comment_count' => __( 'Number of comments', 'archub-elementor-addons' ),
					'menu_order' => __( 'Menu order/Page Order', 'archub-elementor-addons' ),
					'meta_value' => __( 'Meta value', 'archub-elementor-addons' ),
					'meta_value_num' => __( 'Meta value number', 'archub-elementor-addons' ),
					'rand' => __( 'Random order', 'archub-elementor-addons' ),
				],
                'condition' => array(
                    'post_type!' => array(
                        'ids',
						'custom'
                    ),
                ),
			]
		);

		$this->add_control(
			'order',
			[
				'label' => __( 'Sort Order', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => [
					'DESC' => __( 'Descending', 'archub-elementor-addons' ),
					'ASC' => __( 'Ascending', 'archub-elementor-addons' ),
				],
                'condition' => array(
                    'post_type!' => array(
                        'ids',
						'custom'
                    ),
                ),
			]
		);

		$this->add_control(
			'meta_key',
			[
				'label' => __( 'Meta key', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'description' => __( 'Input meta key for grid ordering.', 'archub-elementor-addons' ),
                'condition' => array(
                    'orderby' => array(
                        'meta_value',
						'meta_value_num',
                    ),
                ),
			]
		);

		$this->add_control(
			'offset',
			[
				'label' => __( 'Offset', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Number of grid elements to displace or pass over.', 'archub-elementor-addons' ),
                'condition' => array(
                    'post_type!' => array(
                        'ids',
						'custom'
                    ),
                ),
			]
		);

		$this->add_control(
			'exclude',
			[
				'label' => __( 'Exclude', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Exclude posts, pages, etc. by title.', 'archub-elementor-addons' ),
                'condition' => array(
                    'post_type!' => array(
                        'ids',
						'custom'
                    ),
                ),
			]
		);
        
		$this->end_controls_section();

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

		$style = $atts['style'];
		$items_height = $atts['items_height'];
		$filter_id = 'blog-filter-' . $this->get_id_int();
		$section_id = uniqid( 'heading-id' );
		$ajax_trigger = $atts['ajax_trigger'];

		$filter_size = $filter_decoration = $filter_transformation = $filter_weight = $filter_title_size = $filter_title_weight = $filter_title_transformation = '';

		$carousel_heading = '';
		if( !empty( $atts['carousel_heading'] ) ) {
			$carousel_heading = '<header id="' . $section_id . '"><h2>'. esc_html( $atts['carousel_heading'] ) . '</h2></header>';
		}

		$ajax_wrapper = '';

		$unique_id = 'blog-id-' . $this->get_id_int();
		$ajax_wrapper = '.' . $unique_id;

		// check
		$located = locate_template( "templates/blog/tmpl-$style.php" );
		if ( ! file_exists( $located ) ) {
			return;
		}

		$i = 0;

		echo '<div class="lqd-lp-grid ' . $this->get_id() . ' ' . $unique_id . ' ">';

		// Include filter
		if( 'yes' === $atts['enable_filter'] ) {
			$filter_located = locate_template( 'templates/blog/partial-filters.php' );
			include $filter_located;
		}

		// Build Query
		$GLOBALS['wp_query'] = new \WP_Query( $this->build_query() );
		$before = $after = '';
		$masonry_options = [];
		$layout_mode = $atts['masonry_layout'] && $atts['masonry_layout'] === 'packery' ? 'packery' : 'fitRows';
		$row_data_attrs = [];
		
		$row_classnames = [
			'lqd-lp-row',
			'd-flex',
			'flex-wrap',
			'row',
			'pos-rel',
		];
		
		if ( 'yes' === $atts['enable_filter'] ) {
			
			$row_data_attrs['data-liquid-masonry'] = 'true';
			
			$masonry_options['filtersID'] = '#' . $filter_id;
			$masonry_options['itemSelector'] = '.lqd-lp-column';
			$masonry_options['layoutMode'] = $layout_mode;

			$row_data_attrs['data-masonry-options'] = json_encode( $masonry_options );

		};
			
		printf( '<div class="%1$s" %2$s>', ld_helper()->sanitize_html_classes( $row_classnames ), ld_helper()->html_attributes( $row_data_attrs ) );
		$after  = '</div>';

			
			while( have_posts() ): the_post();

				$before = '<div class="lqd-lp-column d-flex flex-column ' . $this->get_grid_class() . ' ' . $this->entry_term_classes() . '">';

				$post_classes = array( 'lqd-lp', 'pos-rel' );
				if( 'style01' === $style ) {
					$post_classes[] = 'lqd-lp-style-1 text-start';
				}
				elseif( 'style02' === $style ) {
					$post_classes[] = 'lqd-lp-style-2 text-start';
				}
				elseif( 'style03' === $style ) {
					$post_classes[] = 'lqd-lp-style-3 lqd-lp-hover-img-zoom text-start';
					$before = '<div class="lqd-lp-column d-flex flex-column col-md-12 ' . $this->entry_term_classes() . '">';
				}
				elseif( 'style04' === $style ) {
					$post_classes[] = 'lqd-lp-style-4 lqd-lp-animate-onhover p-5 border-radius-4 overflow-hidden text-start';
				}
				elseif( 'style05' === $style ) {
					$post_classes[] = 'lqd-lp-style-5 d-flex flex-wrap text-start';
				}
				elseif( 'style06' === $style  ) {
					$post_classes[] = 'lqd-lp-style-6 text-start';
				}
				elseif( 'style07' === $style  ) {
					$post_classes[] = 'lqd-lp-style-7 lqd-lp-hover-img-zoom text-start';
				}
				elseif( 'style08' === $style  ) {
					$post_classes[] = 'lqd-lp-style-8 lqd-lp-img-cover d-flex flex-wrap border-radius-4 overflow-hidden ' . $items_height . ' text-start';
				}
				elseif( 'style09' === $style  ) {
					$post_classes[] = 'lqd-lp-style-9 d-md-block text-start';
				}
				elseif( 'style10' === $style  ) {
					$post_classes[] = 'lqd-lp-style-10 lqd-lp-hover-img-zoom lqd-lp-title-highlight text-start';
				}
				elseif( 'style11' === $style  ) {
					$post_classes[] = 'lqd-lp-style-11 lqd-lp-hover-img-zoom text-start';
				}
				elseif( 'style12' === $style  ) {
					$post_classes[] = 'lqd-lp-style-12 d-flex flex-wrap text-start';
				}
				elseif( 'style13' === $style  ) {
					$post_classes[] = 'lqd-lp-style-13 lqd-lp-hover-img-zoom text-start';
				}
				elseif( 'style14' === $style  ) {
					$post_classes[] = 'lqd-lp-style-14 lqd-lp-hover-img-zoom lqd-lp-hover-img-zoom-out text-start';
				}

				$post_classes = join( ' ', get_post_class( $post_classes, get_the_ID() ) );

				$attributes = array(
					'id'    => 'post-' . get_the_ID(),
					'class' => $post_classes
				);
				
				echo $before;
				
				printf( '<article%s>', ld_helper()->html_attributes( $attributes ) );

					if( 'quote' === get_post_format() ) {
						$quote_located = locate_template( 'templates/blog/format-quote.php' );
						include $quote_located;
					}
					else {
						include $located;
					}

				echo '</article>';

				echo $after;
				
			endwhile;
			
			if( 'carousel' == $style ) {
				echo '</div></div>';
			}
			echo '</div><!--/ .row -->';
			
			// Pagination
			if( 'pagination' === $atts['pagination'] ) {
				
				$max = $GLOBALS['wp_query']->max_num_pages;

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
			
			if( in_array( $atts['pagination'], array( 'ajax' ) ) && $url = get_next_posts_page_link( $GLOBALS['wp_query']->max_num_pages ) ) {
				$hash = array(
					'ajax' => 'btn btn-md ajax-load-more',
				);

				$attributes = array(
					'href' => add_query_arg( 'ajaxify', '1', $url ),
					'rel' => 'nofollow',
					'data-ajaxify' => true,
					'data-ajaxify-options' => json_encode( array(
						'wrapper' => '.lqd-lp-grid' . $ajax_wrapper . ' > .lqd-lp-row',
						'items'   => '> .lqd-lp-column',
						'trigger' => $ajax_trigger,
					) )
				);

				echo '<div class="liquid-pf-nav ld-pf-nav-ajax"><div class="page-nav text-center"><nav aria-label="' . esc_attr__( 'Page navigation', 'archub-elementor-addons' ) . '">';
				switch( $atts['pagination'] ) {

					case 'ajax':
						$ajax_text = ! empty( $atts['ajax_text'] ) ? esc_html( $atts['ajax_text'] ) : esc_html__( 'Load more', 'archub-elementor-addons' );
						$attributes['class'] = 'elementor-button btn ws-nowrap ld-ajax-loadmore ws-nowrap pos-rel ' . $atts['ajax_btn_width'];
						printf( '<a%2$s><span class="static d-block">%1$s</span><span class="loading d-block pos-abs"><span class="dots d-block"><span class="d-inline-block"></span><span class="d-inline-block"></span><span class="d-inline-block"></span></span><span class="d-block mt-1">' . esc_html__( 'Loading', 'archub-elementor-addons' ) . '</span></span><span class="all-loaded d-block pos-abs">' . esc_html__( 'All items loaded', 'archub-elementor-addons' ) . ' <svg width="32" height="29" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 29" style="width: 1.5em; height: 1.5em; margin-inline-start: 0.5em;"><path fill="currentColor" d="M25.74 6.23c0.38 0.34 0.42 0.9 0.09 1.28l-12.77 14.58a0.91 0.91 0 0 1-1.33 0.04l-5.46-5.46a0.91 0.91 0 1 1 1.29-1.29l4.77 4.78 12.12-13.85a0.91 0.91 0 0 1 1.29-0.08z"></path></svg></span></a>', $ajax_text, ld_helper()->html_attributes( $attributes ), $url );
						break;
				}

				echo '</nav></div></div>';
			}

			wp_reset_query();

		echo '</div><!--/ .lqd-lp-grid -->';
				
	}

	private function get_available_categories() {

		$cats = get_categories( array(
			'orderby' => 'name',
			'order'   => 'ASC'
		));

		$options = [];

		foreach ( $cats as $cat ) {
			$options[ $cat->cat_ID ] = $cat->name;
		}
		
		return $options;

	}

	protected function overlay_link() {
		
		$format = get_post_format();
		$url = 'link' == $format ? liquid_helper()->get_option( 'post-link-url' ) : get_permalink();
		$target = 'link' == $format ? 'target="_blank"' : '';
		
		echo '<a ' . $target . ' href="' . esc_url( $url ) . '" class="lqd-lp-overlay-link lqd-overlay z-index-2"></a>';

	}

	// https://codex.wordpress.org/Making_Custom_Queries_using_Offset_and_Pagination
	// check it
	protected function build_query() {

		extract( $this->get_settings_for_display() );
		$settings = array();
		$settings['post_status'] = 'publish';

		if( 'custom' === $post_type && ! empty( $custom_query ) ) {
			$query = html_entity_decode(  $custom_query , ENT_QUOTES, 'utf-8' );
			$settings = wp_parse_args( $query );
		}
		elseif( 'ids' === $post_type ) {

			if ( empty( $include ) ) {
				$include = - 1;
			}

			$incposts = wp_parse_id_list( $include );
			$settings = array(
				'post__in' => $incposts,
				'posts_per_page' => count( $incposts ),
				'post_type' => 'any',
				'orderby' => 'post__in',
			);
		}
		else {
			$settings = array(
				'posts_per_page' => isset( $posts_per_page ) ? (int) $posts_per_page : 100,
				'offset'         => $offset,
				'orderby' => $orderby,
				'order' => $order,
				'meta_key' => in_array( $orderby, array(
					'meta_value',
					'meta_value_num',
				) ) ? $meta_key : '',
				'post_type' => $post_type,
				'ignore_sticky_posts' => true,
			);

			if( $exclude ) {
				$settings['post__not_in'] = wp_parse_id_list( $exclude );
			}

			/*if( intval( $offset ) ) {
				$settings['no_found_rows'] = intval( $offset );
			}*/

			if( 'none' === $pagination ) {
				$settings['no_found_rows'] = true;
			}
			else {
				$settings['paged'] = ld_helper()->get_paged();
			}

			if ( $settings['posts_per_page'] < 1 ) {
				$settings['posts_per_page'] = 1000;
			}

			// elementor pro archive filter
			if ( is_category() ){
				$settings['cat'] = get_the_category()[0]->term_id;
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
							'field' => 'id',
							'terms' => array( $t->term_id ),
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

	protected function get_grid_class() {

		$column = $this->get_settings_for_display('grid_columns');
		$hash = array(
			'1' => '12',
			'2' => '6',
			'3' => '4',
			'4' => '3',
			'6' => '2'
		);

		if ( ! empty( $hash[ $column ] ) ) {
			$col = $hash[ $column ];
			if ( $col !== '12' ) {
				$col .= ' col-sm-6';
			}
			return sprintf( 'col-md-%s', $col );
		}

		return 'col-md-12';

	}

	/**
	 * [entry_term_classes description]
	 * @method entry_term_classes
	 * @return [type]             [description]
	 */
	protected function entry_term_classes() {

		$postcats = get_the_category();
		$cat_slugs = array();
		if ( count( $postcats ) > 0 ) :
			foreach ( $postcats as $postcat ):
				$cat_slugs[] = 	$postcat->slug;
			endforeach;
		endif;
		
		return implode( ' ', $cat_slugs );
		
	}

	protected function entry_title( $classes = '' ) {
		
		$style = $this->get_settings_for_display('style');
		
		$format = get_post_format();
		if ( 'link' !== $format && is_single() ) {
			the_title( '<h1 class="entry-title">', '</h1>' );
			return;
		}

		$url = 'link' == $format ? liquid_helper()->get_option( 'post-link-url' ) : get_permalink();
		$target = 'link' == $format ? 'target="_blank"' : '';
		
		the_title( sprintf( '<h2 class="entry-title lqd-lp-title %s"><a ' . $target . ' href="%s" rel="bookmark">', $classes, esc_url( $url ) ), '</a></h2>' );
		
	}

	protected function entry_tags_color( $term_id ){

		if ( $color = get_term_meta( $term_id, 'lqd_category_color', true ) ){
			$color = esc_attr( ' style=--color-primary:#' . $color  );
			return $color;
		}

	}

	protected function entry_tags( $classes = '' ) {

		$settings = $this->get_settings_for_display();
		
		$show_meta = $settings['show_meta'];
		if( 'no' === $show_meta ) {
			return;
		}
		
		global $post;
		
		$out = '';
		
		$meta_type    = $settings['meta_type'];
		$one_category = $settings['one_category'];
		$style = $settings['style'];
		
		$tags_list = wp_get_post_tags( $post->ID );
		
		
		$rel = 'rel="tag"';
		$color = '';
		
		if( 'cats' === $meta_type ) {
			$tags_list = get_the_category( $post->ID );	
			$rel = 'rel="category"';
		}		
		
		$before       = '<ul class="lqd-lp-cat ' . esc_attr( $classes ) . '">';
		$after        = '</ul>';
		$before_link  = '<li>';
		$after_link   = '</li>';
		$before_label = '';
		$after_label  = '';
		
		if ( $tags_list ) {			
			$out .= $before;
			if( 'yes' === $one_category ) {
				if( 'style01' == $settings['style'] || 'style14' == $settings['style'] ) {
					$out .= '<li><a class="border-radius-circle" href="' . get_category_link( $tags_list['0']->term_id ) . '" ' . $rel . $this->entry_tags_color($tags_list['0']->term_id) . '>' . $before_label . esc_html( $tags_list['0']->name ) . $after_label . '</a></li>';
				}
				else {
					$out .= '<li><a href="' . get_category_link( $tags_list['0']->term_id ) . '" ' . $rel . $this->entry_tags_color($tags_list['0']->term_id) . '>' . $before_label . esc_html( $tags_list['0']->name ) . $after_label . '</a></li>';
				}
				
			}
			else {
				foreach( $tags_list as $tag ) {
					if( 'style01' == $settings['style'] || 'style14' == $settings['style'] ) {
						$out .= '<li><a class="border-radius-circle" href="' . get_category_link( $tag->term_id ) . '" ' . $rel . $this->entry_tags_color($tag->term_id) . '>' . $before_label . esc_html( $tag->name ) . $after_label . '</a></li>';
					}
					else {
						$out .= '<li><a href="' . get_category_link( $tag->term_id ) . '" ' . $rel . $this->entry_tags_color($tag->term_id) . '>' . $before_label . esc_html( $tag->name ) . $after_label . '</a></li>';
					}
				}				
			}
			$out .= $after;
		}
		
		if( $out ) {
			printf( '<span class="screen-reader-text">%1$s </span>%2$s',
				_x( 'Tags', 'Used before tag names.', 'archub-elementor-addons' ),
				$out
			);
		}
		
	}

	protected function entry_thumbnail( $size = 'liquid-thumbnail', $attr = '', $background = false ) {
		
		//Check
		if ( post_password_required() || is_attachment() ) {
			return;
		}
		$figure_classnames = '';
		
		if( 'rounded' === $this->get_settings_for_display( 'style' ) ) {
			$figure_classnames = 'rounded';
		}
		elseif( 'square' === $this->get_settings_for_display( 'style' ) ) {
			$figure_classnames = 'round';
		}		
		
		$src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full', false );
		$src = liquid_get_resized_image_src( $src, $size );		
		
		$format = get_post_format();
		$style = $this->get_settings_for_display( 'style' );
		$url = 'link' == $format ? liquid_helper()->get_option( 'post-link-url' ) : get_permalink();
		$target = 'link' == $format ? 'target="_blank"' : '';
		
		if( has_post_thumbnail() ) {

			if( 'style01' == $this->get_settings_for_display( 'style' ) ) {
				printf( '<div class="lqd-lp-img"><figure class="border-radius-2 overflow-hidden">' );
				liquid_the_post_thumbnail( 'liquid-style1-lb', array( 'class' => 'w-100'  ), true );
				echo '</figure></div>';
			}
			elseif( 'style02' == $this->get_settings_for_display( 'style' ) ) {
				printf( '<div class="lqd-lp-img mb-5"><figure class="pos-rel overflow-hidden border-radius-6">' );	
				liquid_the_post_thumbnail( 'liquid-style1-lb', array( 'class' => 'w-100' ), true );
				echo '<div class="lqd-overlay d-flex align-items-center justify-content-center">
			<div class="lqd-overlay lqd-overlay-bg"></div>
			<i class="lqd-icn-ess icon-md-arrow-forward"></i>
		</div>';
				echo '</figure></div>';
			}
			elseif( 'style03' == $this->get_settings_for_display( 'style' ) ) {
				printf( '<div class="lqd-lp-img overflow-hidden border-radius-6 mb-6"><figure>' );	
				liquid_the_post_thumbnail( 'liquid-style5-lb', array( 'class' => 'w-100' ), true );
				echo '</figure></div>';
			}
			elseif( 'style05' == $this->get_settings_for_display( 'style' ) ) {
				liquid_the_post_thumbnail( 'liquid-style9-lb', array( 'class' => 'w-100' ), true );
			}
			elseif( 'style06' == $this->get_settings_for_display( 'style' ) ) {
				printf( '<figure class="pos-rel overflow-hidden">' );	
				liquid_the_post_thumbnail( 'liquid-style06-lb', array( 'class' => 'w-100' ), true );
				echo '</figure>';
			}
			elseif( 'style08' == $this->get_settings_for_display( 'style' ) ) {
				printf( '<figure class="pos-rel bg-cover bg-center w-100 h-100">' );	
				liquid_the_post_thumbnail( 'liquid-style09-lb', array( 'class' => 'w-100 h-100 objfit-cover objfit-center' ), true );
				echo '</figure>';
			}
			elseif( 'style07' == $this->get_settings_for_display( 'style' ) ) {
				printf( '<figure class="pos-rel bg-cover bg-center w-100">' );	
				liquid_the_post_thumbnail( $size, array( 'class' => 'w-100' ), true );
				echo '</figure>';
			}
			elseif( 'style09' == $this->get_settings_for_display( 'style' ) ) {
				printf( '<figure>' );	
				liquid_the_post_thumbnail( 'liquid-style09-lb', array( 'class' => 'w-100' ), true );
				echo '</figure>';
			}
			elseif( 'style10' == $this->get_settings_for_display( 'style' ) ) {
				printf( '<figure class="pos-rel overflow-hidden">' );	
				liquid_the_post_thumbnail( null, array( 'class' => 'w-100' ), true );
				echo '</figure>';
			}
			elseif( 'style11' == $this->get_settings_for_display( 'style' ) ) {
				printf( '<figure class="pos-rel">' );	
				liquid_the_post_thumbnail( 'liquid-style1-lb', array( 'class' => 'w-100' ), true );
				echo '</figure>';
			}
			elseif( 'style12' == $this->get_settings_for_display( 'style' ) ) {
				printf( '<figure class="lqd-overlay">' );
				liquid_the_post_thumbnail( 'liquid-style1-lb', array( 'class' => 'w-100' ), true );
				echo '<div class="lqd-overlay d-flex align-items-center justify-content-center"><i class="lqd-icn-ess icon-md-arrow-forward"></i></div>';
				echo '</figure>';
			}
			elseif( 'style13' == $this->get_settings_for_display( 'style' ) ) {
					printf( '<figure>' );
					liquid_the_post_thumbnail( $size, array( 'class' => 'w-100' ), true );
					echo '</figure>';
			}
			elseif( 'style14' == $this->get_settings_for_display( 'style' ) ) {
				printf( '<figure>' );	
				liquid_the_post_thumbnail( 'liquid-style6-alt-lb', array( 'class' => 'w-100' ), true );
				echo '</figure>';
			}
			else {
				printf( '<figure class="lqd-lp-img %s">', $figure_classnames );
				liquid_the_post_thumbnail( $size, $attr, true );
				echo '</figure>';
			}

		}
	
	}

	protected function entry_content( $class = '' ) {

		if ( $this->get_settings_for_display('enable_post_excerpt') === 'no' ){
			return;
		}

		$style = $this->get_settings_for_display('style');

		if( !is_single() ) :

	?>
			<div class="<?php echo $class; ?>">
				<?php
					add_filter( 'excerpt_length', array( $this, 'excerpt_lengh' ), 999 );
					add_filter( 'excerpt_more', array( $this, 'excerpt_more' ) );
					add_filter( 'liquid_dinamic_css_output', array( $this, 'clean_excerpt' ) );
					the_excerpt();
					remove_filter( 'liquid_dinamic_css_output', array( $this, 'clean_excerpt' ) ); ?>
			</div>
		<?php else: ?>
			<div class="entry-content">
			<?php
				/* translators: %s: Name of current post */
				the_content( sprintf(
					__( 'Continue reading %s', 'archub-elementor-addons' ),
					the_title( '<span class="screen-reader-text">', '</span>', false )
				) );

				wp_link_pages( array(
					'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'archub-elementor-addons' ) . '</span>',
					'after'       => '</div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
					'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'archub-elementor-addons' ) . ' </span>%',
					'separator'   => '<span class="screen-reader-text">, </span>',
				) );
			?>
	    </div>
	<?php endif;

	}

	protected function entry_cats() {

		$categories_list = get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'archub-elementor-addons' ) );

		if ( $categories_list ) {
			printf( '<span class="cat-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
				_x( 'Categories', 'Used before category names.', 'archub-elementor-addons' ),
				$categories_list
			);
		}
	}

	protected function entry_time() {

		printf( '<time class="lqd-lp-date" datetime="%s">', get_the_date( 'c' ) );
		echo liquid_helper()->liquid_post_date();
		echo '</time>';
		
	}

	protected function entry_time_to_read() {

		$time_to_read = liquid_helper()->get_option( 'post-time-read' );
		if( empty( $time_to_read ) ) {
			return;
		}

		printf( '<span class="post-time-read"><i class="fa fa-book"></i> %s</span>',
				esc_html( $time_to_read )
		);

	}

	public function excerpt_lengh( $length ) {

		$post_excerpt_length = $this->get_settings_for_display('post_excerpt_length');

		if( !isset( $post_excerpt_length ) ) {
			return '20';
		}
		return $post_excerpt_length;
	}

	public function excerpt_more( $more ) {

		$post_excerpt_length = $this->get_settings_for_display('post_excerpt_length');
		
		if( !isset( $post_excerpt_length ) ) {
			return $more;
		}
		return '';

	}
	
	public function clean_excerpt() {
		return false;
	}

	public function entry_read_more_button() {

		return $this->get_settings_for_display( 'show_read_more_button' );

	}

}
