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
use Elementor\Icons_Manager;

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
class LD_Tabs extends Widget_Base {

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
		return 'ld_tabs';
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
		return __( 'Liquid Tabs', 'archub-elementor-addons' );
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
		return 'eicon-tabs lqd-element';
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
	 * @since 2.1.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'tab', 'swipe' ];
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
	public function get_style_depends() {

		if ( liquid_helper()->liquid_elementor_script_depends() ){
			return [ 'liquid-sc-tabs' ];
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

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'content_type',
			[
				'label' => __( 'Content Type', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'tinymce',
				'label_block' => true,
				'options' => [
					'tinymce' => __( 'TinyMCE', 'archub-elementor-addons' ),
					'el_template' => __( 'Elementor Template', 'archub-elementor-addons' ),
				],
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'templates', [
				'label' => __( 'Select Template', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => true,
				'options' => $this->get_block_posts(),
				'default' => '0',
				'condition' => [
					'content_type' => 'el_template'
				],
			]
		);
		
		$repeater->add_control(
			'item_title', [
				'label' => __( 'Title', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Title' , 'archub-elementor-addons' ),
				'label_block' => true,
				'seperator' => 'before',
			]
		);

		$repeater->add_control(
			'item_description', [
				'label' => __( 'Short Description', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Description' , 'archub-elementor-addons' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'item_content', [
				'label' => __( 'Content', 'archub-elementor-addons' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => __( 'Content' , 'archub-elementor-addons' ),
				'condition' => [
					'content_type' => 'tinymce'
				],
			]
		);
		
		$repeater->add_control(
			'item_icon',
			[
				'label' => __( 'Icon', 'archub-elementor-addons' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fa fa-arrow-left',
					'library' => 'solid',
				],
			]
		);

		$repeater->add_control(
			'item_icon_color',
			[
				'label' => __( 'Icon Color', 'archub-elementor-addons' ),
				'description' => __( 'If you use this option it will override the widget color settings.', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-tabs-nav-icon-icon' => 'color: {{VALUE}}',
				],
			]
		);

		$repeater->add_control(
			'item_icon_bg_color',
			[
				'label' => __( 'Icon Background Color', 'archub-elementor-addons' ),
				'description' => __( 'If you use this option it will override the widget color settings.', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-tabs-nav-icon-icon' => 'background: {{VALUE}}',
				],
			]
		);

		$repeater->add_control(
			'item_custom_id', [
				'label' => __( 'Set Custom ID', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => 'my-custom-id',
				'description' => __( 'Set a custom ID. Leave blank if you want it to be defined automatically. Each tab must have a different ID. And don\'t use "#".' , 'archub-elementor-addons' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'items',
			[
				'label' => __( 'Items', 'archub-elementor-addons' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'item_title' => __( 'Title #1', 'archub-elementor-addons' ),
						'item_content' => __( 'Item 1 content. Click the edit button to change this text.', 'archub-elementor-addons' ),
					],
					[
						'item_title' => __( 'Title #2', 'archub-elementor-addons' ),
						'item_content' => __( 'Item 2 content. Click the edit button to change this text.', 'archub-elementor-addons' ),
					],
					[
						'item_title' => __( 'Title #3', 'archub-elementor-addons' ),
						'item_content' => __( 'Item 3 content. Click the edit button to change this text.', 'archub-elementor-addons' ),
					],
				],
				'title_field' => '{{{ item_title }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'options_section',
			[
				'label' => __( 'Options', 'archub-elementor-addons' ),
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
					'style01' => __( 'Style 1', 'archub-elementor-addons' ),
					'style02' => __( 'Style 2', 'archub-elementor-addons' ),
					'style03' => __( 'Style 3', 'archub-elementor-addons' ),
					'style04' => __( 'Style 4', 'archub-elementor-addons' ),
					'style05' => __( 'Style 5', 'archub-elementor-addons' ),
					'style06' => __( 'Style 6', 'archub-elementor-addons' ),
					'style07' => __( 'Style 7', 'archub-elementor-addons' ),
					'style08' => __( 'Style 8', 'archub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'nav_alignment',
			[
				'label' => __( 'Nav alignment', 'archub-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'justify-content-between' => [
						'title' => __( 'Space Between', 'archub-elementor-addons' ),
						'icon' => 'eicon-navigation-horizontal',
					],
					'justify-content-start' => [
						'title' => __( 'Start', 'archub-elementor-addons' ),
						'icon' => 'eicon-h-align-left',
					],
					'justify-content-center' => [
						'title' => __( 'Center', 'archub-elementor-addons' ),
						'icon' => 'eicon-h-align-center',
					],
					'justify-content-end' => [
						'title' => __( 'End', 'archub-elementor-addons' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => 'justify-content-between',
				'toggle' => false,
				'condition' => [
					'style' => [ 'style01', 'style06', 'style07' ],
				],
			]
		);

		$this->add_control(
			'reverse_direction',
			[
				'label' => __( 'Reverse direction', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
				'condition' => [
					'style' => [ 'style03', 'style04', 'style05', 'style06', 'style07' ],
				],
			]
		);

		$this->add_control(
			'tab_trigger',
			[
				'label' => __( 'Trigger', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'click',
				'options' => [
					'click' => __( 'Click', 'archub-elementor-addons' ),
					'hover' => __( 'Hover', 'archub-elementor-addons' ),
				],
				'condition' => [
					'style!' => [ 'style08' ],
				],
			]
		);

		$this->add_control(
			'nav_underline_width',
			[
				'label' => __( 'Nav underline width', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => __( 'Default', 'archub-elementor-addons' ),
					'fw' => __( 'Fullwidth', 'archub-elementor-addons' ),
				],
				'condition' => [
					'style' => [ 'style07' ],
				],
			]
		);

		$this->add_control(
			'enable_deeplinks',
			[
				'label' => __( 'Enable Deeplinks?', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'enable_sticky_nav',
			[
				'label' => __( 'Enable Sticky Nav?', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'lqd-css-sticky',
				'default' => '',
				'condition' => [
					'style' => [ 'style04', 'style05' ],
				],
			]
		);

		$this->add_control(
			'title',
			[
				'label' => __( 'Title', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Title', 'archub-elementor-addons' ),
				'placeholder' => __( 'Type your title here', 'archub-elementor-addons' ),
				'condition' => [
					'style' => [ 'style04' ],
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'general_style_section',
			[
				'label' => __( 'General', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'nav_typography',
				'label' => __( 'Nav Typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-tabs-nav > li > a, {{WRAPPER}} .lqd-tabs-nav .h3,{{WRAPPER}} .lqd-tabs-nav > li > a .lqd-tabs-nav-txt',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'nav_desc_typography',
				'label' => __( 'Nav Description Typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-tabs .lqd-tabs-nav .lqd-tabs-nav-desc',
				'condition' => 	[
					'style' => [ 'style03' ],
				]
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'nav_ext_desc_typography',
				'label' => __( 'Nav Description Typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-tabs .lqd-tabs-nav .lqd-tabs-nav-ext',
				'condition' => 	[
					'style' => [ 'style08' ]
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'tab_content_typography',
				'label' => __( 'Content Typography', 'archub-elementor-addons' ),
				'selector' => '.lqd-tabs-content',
			]
		);


		$this->add_responsive_control(
			'padding',
			[
				'label' => __( 'Content Padding', 'archub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-tabs-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'tabs_icon_size',
			[
				'label' => __( 'Icon Size', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 300,
						'step' => 1,
					],
					'em' => [
						'min' => 0,
						'max' => 10,
						'step' => 0.1,
					],
				],
				'default' => [
					'unit' => 'em',
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-tabs-nav' => '--icon-size: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		// Colors
		$this->start_controls_section(
			'style_section',
			[
				'label' => __( 'Colors', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs(
			'style_tabs'
		);

		$this->start_controls_tab(
			'style_normal_tab',
			[
				'label' => __( 'Normal', 'archub-elementor-addons' ),
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Title Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-tabs .lqd-tabs-nav a' => 'color: {{VALUE}}'
				],
				'condition' => array(
					'style!' => [ 'style08' ]
				)
			]
		);
		
		$this->add_control(
			'title_color_style08_heading',
			[
				'label' => __( 'Title Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'condition' => [
					'style' => [ 'style08' ]
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'title_color_style08',
				'label' => __( 'Title Color', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .lqd-tabs .lqd-tabs-nav > li .lqd-tabs-nav-txt span',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
				'condition' => [
					'style' => [ 'style08' ]
				],
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label' => __( 'Description Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-tabs .lqd-tabs-nav .lqd-tabs-nav-desc' => 'color: {{VALUE}}'
				],
				'condition' => array(
					'style' => [ 'style03' ]
				)
			]
		);

		$this->add_control(
			'ext_color',
			[
				'label' => __( 'Description Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-tabs .lqd-tabs-nav .lqd-tabs-nav-ext' => 'color: {{VALUE}}'
				],
				'condition' => array(
					'style' => [ 'style08' ]
				)
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'bg_color',
				'label' => __( 'Background Color', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .lqd-tabs .lqd-tabs-nav a',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
				'condition' => [
					'style' => [ 'style03', 'style04' ]
				],
			]
		);

		$border_colors = [
			'style01' => array(
				'{{WRAPPER}} .lqd-tabs .lqd-tabs-nav' => 'border-color: {{VALUE}}'
			),
			'style02' => array(
				'{{WRAPPER}} .lqd-tabs .lqd-tabs-nav:before' => 'background: {{VALUE}}',
				'{{WRAPPER}} .lqd-tabs .lqd-tabs-nav .h3:after' => 'background: {{VALUE}}',
			),
			'style07' => array(
				'{{WRAPPER}} .lqd-tabs .lqd-tabs-nav a:after' => 'background: {{VALUE}}'
			)
		];
		
		foreach ($border_colors as $key => $style) {

			$this->add_control(
				'border_color_'.$key,
				[
					'label' => __( 'Border Color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'condition' => [
						'style' => [ $key ],
					],
					'selectors' => $border_colors[$key]
				]
			);
			
		};

		$this->add_control(
			'icon_bg_heading',
			[
				'label' => __( 'Icon Background', 'archub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'condition' => [
					'style' => [ 'style04' ]
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'icon_bg_alt',
				'label' => __( 'Icon Background', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .lqd-tabs .lqd-tabs-nav .lqd-tabs-nav-icon',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
				'condition' => [
					'style' => [ 'style04' ]
				],
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => __( 'Icon Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-tabs .lqd-tabs-nav .lqd-tabs-nav-icon-icon' => 'color: {{VALUE}}'
				],
				'condition' => [
					'style' => [ 'style01', 'style02', 'style03' ],
				],
			]
		);

		$this->add_control(
			'icon_color_alt',
			[
				'label' => __( 'Icon Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-tabs .lqd-tabs-nav .lqd-tabs-nav-icon-icon' => 'color: {{VALUE}}'
				],
				'condition' => [
					'style' => [ 'style04' ],
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'style_active_tab',
			[
				'label' => __( 'Active', 'archub-elementor-addons' ),
			]
		);

		$this->add_control(
			'active_title_color',
			[
				'label' => __( 'Title Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-tabs .lqd-tabs-nav li.active a' => 'color: {{VALUE}}'
				],
				'condition' => array(
					'style!' => [ 'style08' ]
				)
			]
		);

		$this->add_control(
			'active_title_color_style08_heading',
			[
				'label' => __( 'Title Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'condition' => [
					'style' => [ 'style08' ]
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'active_title_color_style08',
				'label' => __( 'Title Color', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .lqd-tabs-style-8 .lqd-tabs-nav > li .lqd-tabs-nav-txt::before',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
				'condition' => [
					'style' => [ 'style08' ]
				],
			]
		);

		$this->add_control(
			'active_desc_color',
			[
				'label' => __( 'Description Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-tabs .lqd-tabs-nav li.active .lqd-tabs-nav-desc' => 'color: {{VALUE}}'
				],
				'condition' => array(
					'style' => [ 'style03' ]
				)
			]
		);

		$this->add_control(
			'active_ext_color',
			[
				'label' => __( 'Description Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-tabs .lqd-tabs-nav li.active .lqd-tabs-nav-ext' => 'color: {{VALUE}}'
				],
				'condition' => array(
					'style' => [ 'style08' ]
				)
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'active_bg_color',
				'label' => __( 'Background Color', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .lqd-tabs .lqd-tabs-nav li.active a',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
				'condition' => [
					'style' => [ 'style03', 'style04' ]
				],
			]
		);

		$active_border_colors = [
			'style01' => array(
				'{{WRAPPER}} .lqd-tabs .lqd-tabs-nav li:after' => 'background: {{VALUE}}'
			),
			'style02' => array(
				'{{WRAPPER}} .lqd-tabs .lqd-tabs-nav li.active .h3:after' => 'background: {{VALUE}}',
			),
			'style05' => array(
				'{{WRAPPER}} .lqd-tabs .lqd-tabs-nav li.active a:before' => 'background: {{VALUE}}',
			),
			'style07' => array(
				'{{WRAPPER}} .lqd-tabs .lqd-tabs-nav li.active a:after' => 'background: {{VALUE}}'
			)
		];
		
		foreach ($active_border_colors as $key => $style) {

			$this->add_control(
				'active_border_color_'.$key,
				[
					'label' => __( 'Border Color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'condition' => [
						'style' => [ $key ],
					],
					'selectors' => $active_border_colors[$key]
				]
			);
			
		};

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'active_icon_bg',
				'label' => __( 'Icon Background', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .lqd-tabs .lqd-tabs-nav li.active .lqd-tabs-nav-icon-icon',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
				'condition' => [
					'style' => [ 'style04'  ]
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'active_icon_bg_alt',
				'label' => __( 'Icon Background', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .lqd-tabs .lqd-tabs-nav li.active .lqd-tabs-nav-icon-icon',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
				'condition' => [
					'style' => [ 'style04' ]
				],
			]
		);

		$this->add_control(
			'active_icon_color',
			[
				'label' => __( 'Icon Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-tabs .lqd-tabs-nav li.active .lqd-tabs-nav-icon-icon' => 'color: {{VALUE}}'
				],
				'condition' => [
					'style' => [ 'style01', 'style02', 'style03' ],
				],
			]
		);

		$this->add_control(
			'active_icon_color_alt',
			[
				'label' => __( 'Icon Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-tabs .lqd-tabs-nav li.active .lqd-tabs-nav-icon-icon' => 'color: {{VALUE}}'
				],
				'condition' => [
					'style' => [ 'style04' ],
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		ld_el_btn($this, 'ib_', $condition = ['style' => ['style03', 'style04', 'style05', 'style06', 'style07']]);

	}

	protected function get_class( $style ) {

		$hash = array(
			'style01'  => 'lqd-tabs lqd-tabs-style-1 lqd-tabs-nav-iconbox',
			'style02'  => 'lqd-tabs lqd-tabs-style-2 lqd-tabs-nav-iconbox',
			'style03'  => 'lqd-tabs lqd-tabs-style-4 lqd-tabs-nav-iconbox d-flex flex-wrap',
			'style04'  => 'lqd-tabs lqd-tabs-style-4 lqd-tabs-nav-iconbox lqd-tabs-nav-icon-inline d-flex flex-wrap',
			'style05'  => 'lqd-tabs lqd-tabs-style-5 d-flex flex-wrap',
			'style06'  => 'lqd-tabs lqd-tabs-style-6 lqd-tabs-nav-plain d-flex',
			'style07'  => 'lqd-tabs lqd-tabs-style-7 lqd-tabs-nav-plain d-flex',
			'style08'  => 'lqd-tabs lqd-tabs-style-8 lqd-tabs-has-nav-arrows d-flex',
		);

		return $hash[ $style ];

	}

	protected function get_nav_expand() {

		$nav_expand = $this->get_settings_for_display('nav_expand');

		if ( $nav_expand === 'yes' ) {
			return;
		}

		return 'lqd-tabs-nav-items-not-expanded';

	}

	protected function get_reverse_direction() {

		$settings = $this->get_settings_for_display();

		$style = $settings['style'];
		$reverse = $settings['reverse_direction'];
		$isInRow = 'style03' === $style || 'style04' === $style || 'style05' === $style;
		$isInColumn = 'style06' === $style || 'style07' === $style || 'style08' === $style;

		if ( ! $isInRow && ! $isInColumn ) {
			return;
		}

		if ( $isInRow && $reverse ) {
			return 'flex-row-reverse';
		} else if ( $isInColumn && $reverse ) {
			return 'flex-column-reverse';
		} else if ( $isInColumn && ! $reverse ) {
			return 'flex-column';
		}
		
	}

	protected function get_tabs_opts() {

		$settings = $this->get_settings_for_display();
		
		$opts = array();
		
		if( !empty( $settings['enable_deeplinks'] ) ) {
			$opts['deepLink'] = true;
		}
		
		if( !empty( $settings['tab_trigger'] ) ) {
			$opts['trigger'] = $settings['tab_trigger'];
		}

		if ( 'style08' === $settings['style'] ) {
			$opts['translateNav'] = true;
		}

		return 'data-tabs-options=\'' . wp_json_encode( $opts ) . '\'';

	}

	protected function get_nav_wrap_classnames() {

		$settings = $this->get_settings_for_display();

		$classname_arr = array('lqd-tabs-nav-wrap');
		$style = $settings['style'] ? $settings['style'] : 'style01';
		
		if ( !empty( $settings['show_button'] ) ) {
			$classname_arr[] = 'lqd-tabs-nav-has-btn';
		}

		switch ($style) {

			case 'style01':
			case 'style02':
			case 'style06':
				$classname_arr[] = 'mb-5';
				break;

			case 'style07':
				$classname_arr[] = 'mb-6';
				break;

			case 'style08':
				$classname_arr[] = 'mb-3';
				break;

		}

		if ( $settings['reverse_direction'] ) {

			if (
				$style === 'style06'
			) {
				array_pop($classname_arr);
			}

			switch ($style) {
	
				case 'style07':
					$classname_arr[] = 'mt-6';
					break;
	
				case 'style06':
					$classname_arr[] = 'mt-5';
					break;
	
			}

		}

		return $classname_arr;

	}

	protected function get_nav_icons( $icons, $tab_style ){
		if ( $icons[ 'value' ] ) {

			$icon_classname = 'lqd-tabs-nav-icon-icon d-inline-flex align-items-center justify-content-center me-5 border-radius-circle';
			
			if ( $tab_style === 'style01' ) {
				$icon_classname = 'lqd-tabs-nav-icon-icon d-block';
			}
			if ( $tab_style === 'style02' ) {
				$icon_classname = 'lqd-tabs-nav-icon-icon d-flex justify-content-center';
			}
			if ( $tab_style === 'style03' ) {
				$icon_classname = 'lqd-tabs-nav-icon-icon d-flex flex-wrap me-5';
			}

			echo '<span class="' . $icon_classname . '">';
			Icons_Manager::render_icon( $icons, [ 'aria-hidden' => 'true' ] );
			echo '</span>';
			
		}
	}

	protected function get_nav() {

		$settings = $this->get_settings_for_display();

		$out = $nav_align = ''; $first = true;
		$style = $settings['style'] ? $settings['style'] : 'style01';
		$nav_align = $settings['nav_alignment'];
		$sticky = $settings['enable_sticky_nav'];
		
		if( 'style01' === $style ) {
			echo '<ul class="reset-ul lqd-tabs-nav d-flex align-items-center ' . $nav_align . ' pos-rel" role="tablist">';
		}
		elseif( 'style02' === $style ) {
			echo '<ul class="reset-ul lqd-tabs-nav d-flex align-items-center flex-wrap justify-content-between pos-rel" role="tablist">';
		}
		elseif( 'style03' === $style ) {
			echo '<ul class="reset-ul lqd-tabs-nav d-flex flex-column justify-content-center pos-rel" role="tablist">';
		}
		elseif( 'style04' === $style ) {
			echo '<ul class="reset-ul lqd-tabs-nav d-flex flex-column ' . $sticky .' pos-rel" role="tablist">';
		}
		elseif( 'style05' === $style ) {
			echo '<ul class="reset-ul lqd-tabs-nav d-flex flex-column ' . $sticky .' pos-rel" role="tablist">';
		}
		elseif( 'style06' === $style ) {
			echo '<ul class="reset-ul lqd-tabs-nav d-flex align-items-center flex-wrap ' . $nav_align . ' pos-rel" role="tablist">';
		}
		elseif( 'style07' === $style ) {
			echo '<ul class="reset-ul lqd-tabs-nav d-flex align-items-center flex-wrap ' . $nav_align . ' pos-rel" role="tablist">';
		}
		elseif( 'style08' === $style ) {
			echo '<ul class="reset-ul lqd-tabs-nav d-flex align-items-center mb-6 pos-rel" role="tablist">';
		}
		else {
			echo '<ul class="reset-ul lqd-tabs-nav d-flex align-items-center justify-content-between flex-wrap pos-rel" role="tablist">';
		}

		if ( $settings['items'] ) {
			foreach ( $settings[ 'items' ] as $i => $tab ) {
				$id_int = $this->tab_get_id_int();
				$tab_count = $i + 1;
				$tab_ids = $id_int . $tab_count;

				if ( ! empty( $tab['item_custom_id'] ) ){
					$tab_ids = $tab['item_custom_id'];
				}

				$classes = array();

				$classes[] = 'elementor-repeater-item-' . $tab['_id'];

				if ( $first ) {
					$classes[] = 'active';
				}
				
				if ( 'style01' === $style || 'style02' === $style ) {
					$classes[] = 'text-center';
				} elseif ( 'style04' === $style ) {
					$classes[] = 'font-weight-medium';
				} elseif ( 'style07' === $style ) {
					$classes[] = 'mb-3';
				}

				$classes = ! empty( $classes ) ? ' class="' . join( ' ', $classes ) . '"' : '';

				// Tab title
				$title = wp_kses_data( do_shortcode( $tab[ 'item_title' ] ) );

				// Nav
				if ( 'style01' === $style || 'style02' === $style ) {
					echo sprintf( '<li data-controls="%1$s" role="presentation"%2$s><a class="d-block" href="#%1$s" aria-expanded="false" aria-controls="%1$s" role="tab" data-toggle="tab">', $tab_ids, $classes );
					echo '<span class="lqd-tabs-nav-icon d-block">';
						$this->get_nav_icons( $tab['item_icon'], $style );
					echo '<span class="lqd-tabs-nav-content d-block"><span class="d-block pos-rel h3 mt-0 mb-0">' . $title . '</span>';
					echo '</span></span><span class="lqd-tabs-nav-progress"><span class="lqd-tabs-nav-progress-inner"></span></span></a></li>';
				} elseif ( 'style03' === $style ) {
					echo sprintf( '<li data-controls="%1$s" role="presentation"%2$s><a class="d-block p-5 border-radius-7" href="#%1$s" aria-expanded="false" aria-controls="%1$s" role="tab" data-toggle="tab">', $tab_ids, $classes );
					echo '<span class="lqd-tabs-nav-icon d-flex">';
						$this->get_nav_icons( $tab['item_icon'], $style );
					echo '<span class="lqd-tabs-nav-content d-block"><span class="d-block h3 mt-0 mb-3">' . $title . '</span>';
					if ( ! empty( $tab[ 'item_description' ] ) ) {
						echo '<span class="lqd-tabs-nav-desc d-block">' . $tab[ 'item_description' ] . '</span>';
					};
					echo '</span></span></a></li>';
				} elseif ( 'style04' === $style ) {
					echo sprintf( '<li data-controls="%1$s" role="presentation"%2$s><a class="d-block pt-3 pb-3 border-radius-4" href="#%1$s" aria-expanded="false" aria-controls="%1$s" role="tab" data-toggle="tab">', $tab_ids, $classes );
						$this->get_nav_icons( $tab['item_icon'], $style );
					echo '<span class="lqd-tabs-nav-txt">' . $title . '</span></a></li>';
				} elseif ( 'style05' === $style ) {
					echo sprintf( '<li data-controls="%1$s" role="presentation"%2$s><a class="d-flex align-items-center pt-1 pb-1 mb-2" href="#%1$s" aria-expanded="false" aria-controls="%1$s" role="tab" data-toggle="tab">', $tab_ids, $classes );
					echo '<span class="lqd-tabs-nav-txt">' . $title . '</span></a></li>';
				} elseif ( 'style07' === $style ) {
					echo sprintf( '<li data-controls="%1$s" role="presentation"%2$s><a class="d-flex align-items-center" href="#%1$s" aria-expanded="false" aria-controls="%1$s" role="tab" data-toggle="tab">', $tab_ids, $classes );
					echo '<span class="lqd-tabs-nav-txt">' . $title . '</span></a></li>';
				} elseif ( 'style08' === $style ) {
					echo sprintf( '<li data-controls="%1$s" role="presentation"%2$s><a class="d-inline-flex align-items-center border-radius-circle" href="#%1$s" aria-expanded="false" aria-controls="%1$s" role="tab" data-toggle="tab">', $tab_ids, $classes );
					echo '<span class="lqd-tabs-nav-txt" data-txt="' . $title . '"><span>' . $title . '<span></span></a>';
					if ( ! empty( $tab[ 'item_description' ] ) ) {
						echo '<span class="lqd-tabs-nav-ext">' . $tab[ 'item_description' ] . '</span>';
					};
					echo '</li>';
				} else {
					echo sprintf( '<li data-controls="%1$s" role="presentation"%2$s><a class="d-block" href="#%1$s" aria-expanded="false" aria-controls="%1$s" role="tab" data-toggle="tab">', $tab_ids, $classes );
					echo '<span class="lqd-tabs-nav-txt">' . $title . '</span></a></li>';
				}

				$first = false;

			}
		}

		echo '</ul>';
	}

	protected function get_content() {

		$settings = $this->get_settings_for_display();

		$out = ''; $first = true;
		$style = $settings['style'];
		
		if(
			'style01' === $style || 
			'style02' === $style 
		) {
			$out .= '<div class="lqd-tabs-content pos-rel">';
		}
		elseif( 
			'style03' === $style || 
			'style04' === $style 
		) {
			if ( $settings['reverse_direction'] ) {
				$out .= '<div class="lqd-tabs-content pe-5 pos-rel">';
			} else {
				$out .= '<div class="lqd-tabs-content ps-5 pos-rel">';
			}
		}
		elseif( 'style05' === $style ) {
			if ( $settings['reverse_direction'] ) {
				$out .= '<div class="lqd-tabs-content pe-6 pos-rel">';
			} else {
				$out .= '<div class="lqd-tabs-content ps-6 pos-rel">';
			}
		}		
		else {
			$out .= '<div class="lqd-tabs-content pos-rel">';
		}

		if ( $settings['items'] ) {
			foreach ( $settings[ 'items' ] as $i => $tab ) {
				$tab_count = $i + 1;
				$id_int = $this->tab_get_id_int();
				$tab_ids = $id_int . $tab_count;

				if ( ! empty( $tab['item_custom_id'] ) ){
					$tab_ids = $tab['item_custom_id'];
				}

				$out .= sprintf( '<div id="%1$s" role="tabpanel" class="lqd-tabs-pane fade%3$s">%2$s %4$s</div>', $tab_ids, ($tab['content_type'] === 'tinymce' ? $tab[ 'item_content' ] : \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $tab[ 'templates' ] )), ( $first ? ' active in' : '' ), ($tab['content_type'] === 'tinymce' ? '' : $this->edit_btn($tab[ 'templates' ])) );
				$first = false;
				
			}
		} else {
			$out .= vc_container_anchor();
		}

		if ( 'style08' === $style ) {
			$out .= '<div class="lqd-tabs-nav-arrows">
				<button class="lqd-tabs-nav-arrow lqd-tabs-nav-prev d-inline-flex align-items-center justify-content-center border-radius-circle pos-abs">
					<i class="lqd-icn-ess icon-md-arrow-back"></i>
				</button>
				<button class="lqd-tabs-nav-arrow lqd-tabs-nav-next d-inline-flex align-items-center justify-content-center border-radius-circle pos-abs">
					<i class="lqd-icn-ess icon-md-arrow-forward"></i>
				</button>
			</div>';
		}

		$out .= '</div>';

		echo $out;
	}

	protected function get_block_posts() {
		$posts = get_posts( array(
			'post_type' => 'elementor_library',
			'posts_per_page' => -1,
			'meta_query'  => array(
				array(
					'key' => '_elementor_template_type',
					'value' => 'kit',
					'compare' => '!=',
				),
			),
		) );
	
		$options = [ '0' => 'Select Template' ];
	
		foreach ( $posts as $post ) {
		  $options[ $post->ID ] = $post->post_title;
		}
	
		return $options;
	}

	protected function edit_btn( $template_id = false ){
		return; // disabled because collections broken.
		if ( ! $template_id || !\Elementor\Plugin::$instance->editor->is_edit_mode()){
			return;
		}

		$out = '<a data-href="' . esc_url(\Elementor\Plugin::$instance->documents->get( $template_id )->get_edit_url()) . '" onclick=" window.open(this.dataset.href, \'_blank\') " class="elementor-button ws-nowrap btn btn-solid btn-xsm btn-icon-right btn-has-label btn-block">
					<span class="btn-txt pos-rel z-index-3" data-text="Edit this Template">Edit Content Template</span>
					<span class="btn-icon pos-rel z-index-3"><i class="fa fa-external-link-alt"></i></span>
				</a>';
		return $out;
	}

	// Button Functions 
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

	protected function tab_get_id_int() {

		$id_int = substr( $this->get_id_int(), 0, 3 );

		return 'lqd-tab-'.$id_int;

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

		extract($settings);

		$el_classes = array( 
			$this->get_class( $style ),
			$this->get_nav_expand(),
			$this->get_reverse_direction(),
			$this->get_id(),
			'lqd-nav-underline-' . $nav_underline_width
		);
		
		?>
		<div class="<?php echo ld_helper()->sanitize_html_classes( $el_classes ); ?>" <?php echo $this->get_tabs_opts(); ?>>
		
			<nav class="<?php echo ld_helper()->sanitize_html_classes( $this->get_nav_wrap_classnames() ); ?>">
				<?php $this->get_nav(); ?>
				<?php $this->get_button(); ?> 
			</nav>
		
			<?php $this->get_content() ?>
		
		</div>
	<?php		

	}

	protected function content_template() {
	?>
		<#
		function get_class( style ) {

			const hash = []
			hash['style01'] = 'lqd-tabs lqd-tabs-style-1 lqd-tabs-nav-iconbox';
			hash['style02'] = 'lqd-tabs lqd-tabs-style-2 lqd-tabs-nav-iconbox';
			hash['style03'] = 'lqd-tabs lqd-tabs-style-3 lqd-tabs-nav-iconbox d-flex flex-wrap';
			hash['style04'] = 'lqd-tabs lqd-tabs-style-4 lqd-tabs-nav-iconbox lqd-tabs-nav-icon-inline d-flex flex-wrap';
			hash['style05'] = 'lqd-tabs lqd-tabs-style-5 d-flex flex-wrap';
			hash['style06'] = 'lqd-tabs lqd-tabs-style-6 lqd-tabs-nav-plain d-flex';
			hash['style07'] = 'lqd-tabs lqd-tabs-style-7 lqd-tabs-nav-plain d-flex';
			hash['style08'] = 'lqd-tabs lqd-tabs-style-8 lqd-tabs-has-nav-arrows d-flex';
			
			return hash[ style ];
		}

		function get_reverse_direction() {

			var style = settings.style,
				reverse = settings.reverse_direction,
				isInRow = 'style03' === style || 'style04' === style || 'style05' === style,
				isInColumn = 'style06' === style || 'style07' === style || 'style08' === style;

			if ( !isInRow && !isInColumn ) { return ''; }

			if ( isInRow && reverse ) {
				return 'flex-row-reverse';
			} else if ( isInColumn && reverse ) {
				return 'flex-column-reverse';
			} else if ( isInColumn && !reverse ) {
				return 'flex-column';
			}

		}

		function get_tabs_opts() {

			var opts = {};

			if( settings.enable_deeplinks ) {
				opts['deepLink'] = 'true';
			}

			if( settings.tab_trigger ) {
				opts['trigger'] = settings.tab_trigger;
			}

			if ( 'style08' === settings.style ) {
				opts['translateNav'] = 'true';
			}

			return JSON.stringify( opts );

		}

		function get_nav_wrap_classnames() {
			var classname_arr = [],
				style = settings.style ? settings.style : 'style01';

			classname_arr.push('lqd-tabs-nav-wrap');

			if ( settings.show_button ) {
				classname_arr.push('lqd-tabs-nav-has-btn');
			}

			switch (style) {

				case 'style01':
				case 'style02':
				case 'style06':
					classname_arr.push('mb-5');
					break;
				
				case 'style07':
					classname_arr.push('mb-6');
					break;

			}

			if ( settings.reverse_direction ) {

				if (
					style === 'style06'
				) {
					classname_arr.pop();
				}

				switch (style) {

					case 'style07':
						classname_arr.push('mt-6');
						break;

					case 'style06':
						classname_arr.push('mt-5');
						break;

				}

			}

			return classname_arr.join(' ');

		}

		function get_nav_icon(item) {

			const iconHTML = elementor.helpers.renderIcon( view, item.item_icon, {}, 'i' , 'object' );
			const migrated = elementor.helpers.isIconMigrated( item, 'item_icon' );
			let iconMarkup = '';

			if ( iconHTML && ( ! item.item_icon || migrated ) ) {
				iconMarkup = iconHTML.value;
			} else {
				iconMarkup = '<i class="' + item.item_icon.value + '"></i>';
			}

			return iconMarkup;

		}

		function get_nav() {

			var out = nav_align = '', 
				first = true,
				style = settings.style ? settings.style : 'style01',
				nav_align = settings.nav_alignment,
				sticky = settings.enable_sticky_nav;

			if( 'style01' === style ) {
				out += '<ul class="reset-ul lqd-tabs-nav d-flex align-items-center ' + nav_align + ' pos-rel" role="tablist">';
			}
			else if( 'style02' === style ) {
				out += '<ul class="reset-ul lqd-tabs-nav d-flex align-items-center flex-wrap justify-content-between pos-rel" role="tablist">';
			}
			else if( 'style03' === style ) {
				out += '<ul class="reset-ul lqd-tabs-nav d-flex flex-column justify-content-center pos-rel" role="tablist">';
			}
			else if( 'style04' === style ) {
				out += '<ul class="reset-ul lqd-tabs-nav d-flex flex-column ' + sticky + ' pos-rel" role="tablist">';
			}
			else if( 'style05' === style ) {
				out += '<ul class="reset-ul lqd-tabs-nav d-flex flex-column ' + sticky + ' pos-rel" role="tablist">';
			}
			else if( 'style06' === style ) {
				out += '<ul class="reset-ul lqd-tabs-nav d-flex align-items-center flex-wrap ' + nav_align + ' pos-rel" role="tablist">';
			}
			else if( 'style07' === style ) {
				out += '<ul class="reset-ul lqd-tabs-nav d-flex align-items-center flex-wrap ' + nav_align + ' pos-rel" role="tablist">';
			}
			else if( 'style08' === style ) {
				out += '<ul class="reset-ul lqd-tabs-nav d-flex align-items-center mb-6 pos-rel" role="tablist">';
			}
			else {
				out += '<ul class="reset-ul lqd-tabs-nav d-flex align-items-center flex-wrap pos-rel" role="tablist">';
			}

			if ( settings.items ) {
				var tabindex = 'lqd-tab-' + view.getIDInt().toString().substr( 0, 3 );
				_.each( settings.items, function( tab, i ) {

					var tabCount = i + 1;

					var classes = [`elementor-repeater-item-${tab._id}`];
					
					classes.push(tabindex + tabCount);

					if ( first ) {
						classes.push('active');
					}

					if ( 'style01' === style || 'style02' === style ) {
						classes.push('text-center');
					} else if ( 'style04' === style ) {
						classes.push('font-weight-medium');
					} else if ( 'style07' === style ) {
						classes.push('mb-3');
					}

					classes = classes ? ' class="' + classes.join(' ') + '"' : '';

					// Tab title
					title = tab.item_title;

					// Nav
					if ( 'style01' === style || 'style02' === style ) {

						out += '<li data-controls="' + tabindex + tabCount + '" role="presentation" ' + classes + '><a class="d-block" href="#' + tabindex + tabCount + '" aria-expanded="false" aria-controls="' + tabindex + tabCount + '" role="tab" data-toggle="tab">';

						out += '<span class="lqd-tabs-nav-icon d-block">';
						if ( tab.item_icon.value ) {
							out += '<span class="lqd-tabs-nav-icon-icon border-radius-circle">' + get_nav_icon(tab) + '</span>';
						}
						out += '<span class="lqd-tabs-nav-content d-block"><span class="d-block pos-rel h3 mt-0 mb-0">' + title + '</span>';
						out += '</span></span>';
						out += '<span class="lqd-tabs-nav-progress"><span class="lqd-tabs-nav-progress-inner"></span></span>';
						out += '</a></li>';
					} else if ( 'style03' === style ) {

						out += '<li data-controls="' + tabindex + tabCount + '" role="presentation" ' + classes + '><a class="d-block p-5 border-radius-7" href="#' + tabindex + tabCount + '" aria-expanded="false" aria-controls="' + tabindex + tabCount + '" role="tab" data-toggle="tab">';

						out += '<span class="lqd-tabs-nav-icon d-flex flex-wrap mb-0">';
						if ( tab.item_icon.value ) {
							out += '<span class="lqd-tabs-nav-icon-icon me-5">' + get_nav_icon(tab) + '</span>';
						}
						out += '<span class="lqd-tabs-nav-content d-block"><span class="d-block h3 mt-0 mb-3">' + title + '</span>';
						if ( tab.item_description ) {
							out += '<span class="lqd-tabs-nav-desc d-block">' + tab.item_description + '</span>';
						}
						out += '</span></span>';

						out += '</a></li>';
					} else if ( 'style04' === style ) {
						out += '<li data-controls="' + tabindex + tabCount + '" role="presentation" ' + classes + '><a class="d-block pt-3 pb-3 border-radius-4" href="#' + tabindex + tabCount + '" aria-expanded="false" aria-controls="' + tabindex + tabCount + '" role="tab" data-toggle="tab">';
						if ( tab.item_icon.value ) {
							out += '<span class="lqd-tabs-nav-icon-icon d-inline-flex align-items-center justify-content-center me-5 border-radius-circle">' + get_nav_icon(tab) + '</span>';
						}
						out += '<span class="lqd-tabs-nav-txt">' + title + '</span>';
						out += '</a></li>';
					} else if ( 'style05' === style ) {
						out += '<li data-controls="' + tabindex + tabCount + '" role="presentation" ' + classes + '><a class="d-flex align-items-center py-1 mb-2" href="#' + tabindex + tabCount + '" aria-expanded="false" aria-controls="' + tabindex + tabCount + '" role="tab" data-toggle="tab">';
						out += '<span class="lqd-tabs-nav-txt">' + title + '</span>';
						out += '</a></li>';
					} else if ( 'style07' === style ) {
						out += '<li data-controls="' + tabindex + tabCount + '" role="presentation" ' + classes + '><a class="d-flex align-items-center" href="#' + tabindex + tabCount + '" aria-expanded="false" aria-controls="' + tabindex + tabCount + '" role="tab" data-toggle="tab">';
						out += '<span class="lqd-tabs-nav-txt">' + title + '</span>';
						out += '</a></li>';
					} else if ( 'style08' === style ) {
						out += '<li data-controls="' + tabindex + tabCount + '" role="presentation" ' + classes + '><a class="d-inline-flex align-items-center border-radius-circle" href="#' + tabindex + tabCount + '" aria-expanded="false" aria-controls="' + tabindex + tabCount + '" role="tab" data-toggle="tab">';
						out += '<span class="lqd-tabs-nav-txt" data-txt="' + title + '"><span>' + title + '<span></span>';
						out += '</a>';
						if ( tab.item_description ) {
							out += '<span class="lqd-tabs-nav-ext">' + tab.item_description + '</span>';
						}
						out += '</li>';
					} else {
						out += '<li data-controls="' + tabindex + tabCount + '" role="presentation" ' + classes + '><a class="d-block" href="#' + tab._id + '" aria-expanded="false" aria-controls="' + tabindex + tabCount + '" role="tab" data-toggle="tab">';
						out += '<span class="lqd-tabs-nav-txt">' + title + '</span>';
						out += '</a></li>';
					}
					
					first = false;

				} );
			}

			out += '</ul>';
			return out;
		}

		function get_content() {

			var out = '',
				first = true,
				style = settings.style;

			if( 'style01' === style || 'style02' === style ) {
				out += '<div class="lqd-tabs-content pos-rel">';
			} else if( 'style03' === style || 'style04' === style ) {
				if ( settings.reverse_direction ) {
					out += '<div class="lqd-tabs-content pe-5 pos-rel">';
				} else {
					out += '<div class="lqd-tabs-content ps-5 pos-rel">';
				}
			} else if( 'style05' === style ) {
				if ( settings.reverse_direction ) {
					out += '<div class="lqd-tabs-content pe-6 pos-rel">';
				} else {
					out += '<div class="lqd-tabs-content ps-6 pos-rel">';
				}
			} else {
				out += '<div class="lqd-tabs-content pos-rel">';
			}

			
			if ( settings.items ) {
				var tabindex = 'lqd-tab-' + view.getIDInt().toString().substr( 0, 3 );
				_.each( settings.items, function( tab, i ) {
						var tabCount = i + 1;
						out += '<div id="' + tabindex + tabCount + '" role="tabpanel" class="lqd-tabs-pane fade' + ( first && ' active in' ) + '">' + (tab.content_type === 'tinymce' ? tab.item_content : "Template " + tab.templates + " will be display here!" ) + '</div>';
						first = false;
				} );
			} 

			if ( 'style08' === style ) {
				out += '<div class="lqd-tabs-nav-arrows"><button class="lqd-tabs-nav-arrow lqd-tabs-nav-prev d-inline-flex align-items-center justify-content-center border-radius-circle pos-abs"><i class="lqd-icn-ess icon-md-arrow-back"></i></button><button class="lqd-tabs-nav-arrow lqd-tabs-nav-next d-inline-flex align-items-center justify-content-center border-radius-circle pos-abs"><i class="lqd-icn-ess icon-md-arrow-forward"></i></button></div>';
			}

			out += '</div>';
			return out;
		}

		view.addRenderAttribute( 'wrapperAttributes', {
			'class': [ get_class( settings.style ), get_reverse_direction(), `lqd-nav-underline-${settings.nav_underline_width}` ],
			'data-tabs-options': get_tabs_opts(),
		} );

		view.addRenderAttribute( 'navAttributes', {
			'class': [ get_nav_wrap_classnames() ],
		} );

		// Button
		const ib_classes = [
			settings.ib_style,
			settings.ib_i_separator,
			settings.ib_hover_txt_effect,

			settings.ib_link_type === 'lightbox' ? 'fresco' : '',
			
			//Icon classnames
			settings.ib_i_position,
			settings.ib_i_shape,
			settings.ib_i_shape !== '' && settings.ib_i_shape_style !== '' ? settings.ib_i_shape_size : '',
			settings.ib_i_shape !== '' && settings.ib_i_shape_style !== '' ? 'btn-icon-shaped' : '',
			settings.ib_i_shape_style,
			settings.ib_i_shape_bw,	
			settings.ib_i_ripple,
			settings.ib_border_w,
			settings.ib_i_add_icon === 'true' && settings.i_hover_reveal,
			settings.ib_title != '' ? 'btn-has-label' : 'btn-no-label',
		].filter(ib_class => ib_class !== '');

		function getExtendedLines() {

			const sides = ['tl', 'tr', 'br', 'bl'];

			sides.forEach(side => { #>
				<i class="btn-extended-line btn-extended-line-{{ side }} d-inline-block pos-abs pointer-events-none"></i>
			<# });

		};

		view.addRenderAttribute( 'buttonAttrs', {
			'class' : [
				'btn',
				'elementor-button',
				'elementor-button',
				'btn',
				'align-items-center',
				'justify-content-center',
				'pos-rel',
				'overflow-hidden',
				'ws-nowrap',
				ib_classes.join(' ')
			],
		});

		const {ib_link_type} = settings;
		let link = settings.ib_link.url;
		let linkAttrs = ``;
		let anchorId = settings.ib_anchor_id === '' ? '#' : settings.ib_anchor_id;

		if ( ib_link_type === 'modal_window' || ib_link_type === 'local_scroll' ) {
			link = anchorId;
		}
		if ( ib_link_type === 'local_scroll' || ib_link_type === 'scroll_to_section' ) {
			linkAttrs += ` data-localscroll="true"`;
		}

		if ( ib_link_type === 'modal_window' ) {
			linkAttrs += ` data-lqd-lity="${anchorId}"`;
		} else if ( ib_link_type === 'local_scroll' )  {
			linkAttrs += ` data-localscroll="true"`;
			if ( settings.scroll_speed !== '' ) {
				linkAttrs += ` data-localscroll-options='{"scrollSpeed": ${settings.ib_scroll_speed}}'`
			}
		} else if ( ib_link_type === 'scroll_to_section' ) {
			linkAttrs += ` data-localscroll-options='{"scrollBelowSection": true}'`
		}

		const {ib_hover_txt_effect} = settings;
		let hoverEffectAttrs = ``;
		
		switch( ib_hover_txt_effect ) {
			case 'btn-hover-txt-liquid-x':
				hoverEffectAttrs += `data-transition-delay="true" data-delay-options='{"elements": ".lqd-chars", "delayType": "animation", "delayBetween": 32.5}' data-split-text="true" data-split-options='{"type": "chars, words"}'`;
			break;
			
			case 'btn-hover-txt-liquid-x-alt':
				hoverEffectAttrs += `data-transition-delay="true" data-delay-options='{"elements": ".lqd-chars", "delayType": "animation", "delayBetween": 32.5, "reverse": true}' data-split-text="true" data-split-options='{"type": "chars, words"}'`;
			break;
			
			case 'btn-hover-txt-liquid-y':
				hoverEffectAttrs += `data-transition-delay="true" data-delay-options='{"elements": ".lqd-chars", "delayType": "animation", "delayBetween": 32.5}' data-split-text="true" data-split-options='{"type": "chars, words"}'`;
			break;

			case 'btn-hover-txt-liquid-y-alt':
				hoverEffectAttrs += `data-transition-delay="true" data-delay-options='{"elements": ".lqd-chars", "delayType": "animation", "delayBetween": 32.5}' data-split-text="true" data-split-options='{"type": "chars, words"}'`;
			break;
			default:
				'';
			break;
		}

		function get_button(){

			if( settings.show_button === 'yes' &&  ( settings.style === 'style03' || settings.style === 'style04' || settings.style === 'style05' || settings.style === 'style06' || settings.style === 'style07' ) ){
			var out = `<div class="lqd-tabs-nav-btn-wrap">
				<a 
				href="${link.trim()}"
				${view.getRenderAttributeString('buttonAttrs')}
				data-fresco-caption="${settings.ib_image_caption}"
				${linkAttrs}
				>`;
					if ( settings.ib_title ) {
						out += `<span class="btn-txt pos-rel z-index-3" data-text="${settings.ib_title}" ${hoverEffectAttrs} > ${settings.ib_title} </span>`;
					}

					if ( settings.ib_i_add_icon ) {
						out += `<span class="btn-icon pos-rel z-index-3"><i class="${settings.ib_icon.value}"></i></span>`;
					}

					if ( 'btn-hover-swp' === settings.ib_i_hover_reveal && settings.ib_i_add_icon ) {
						out += `<span class="btn-icon pos-rel z-index-3"><i class="${settings.ib_icon.value}"></i></span>`;
					}
					if ( settings.ib_extended_lines === 'yes' && settings.ib_style === 'btn-solid' ) {
							getExtendedLines();
					}
				out += `</a>
			</div>`;
			return out;
			}
		}
		
		#>

		<div {{{ view.getRenderAttributeString( 'wrapperAttributes' ) }}}>
			<nav {{{ view.getRenderAttributeString( 'navAttributes' ) }}}>
				{{{ get_nav() }}}
				{{{ get_button() }}}
			</nav>
			{{{ get_content() }}}
		</div>
	<?php
	}

}
