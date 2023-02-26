<?php

use Elementor\Core\Base\Module;
use Elementor\Controls_Manager;
use Elementor\Controls_Stack;
use Elementor\Element_Base;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Core\Settings\Manager;

defined( 'ABSPATH' ) || exit;

/**
 * Class Typography.
 *
 * @package Analog\Elementor
 */
class LD_Global_Controls extends Module {

	public function __construct() {
		add_action( 'elementor/element/kit/section_settings-site-identity/after_section_end', array( $this, 'tweak_siteidentity_section' ), 999, 2 );
		add_action( 'elementor/element/kit/section_global_colors/after_section_end', array( $this, 'tweak_globalcolors_section' ), 999, 2 );
		add_action( 'elementor/element/kit/section_settings-layout/after_section_end', array( $this, 'tweak_section_padding_section' ), 999, 2 );
		//add_action( 'elementor/element/kit/section_breakpoints/after_section_end', array( $this, 'tweak_breakpoints_section' ), 999, 2 );
		add_action( 'elementor/element/kit/section_typography/after_section_end', array( $this, 'tweak_typography_section' ), 999, 2 );
		add_action( 'elementor/element/kit/section_typography/after_section_end', array( $this, 'register_dark_typography_section' ), 20, 2 );
		add_action( 'elementor/element/kit/section_background/after_section_end', array( $this, 'tweak_background_section' ), 999, 2 );
		add_action( 'elementor/element/after_section_end', array( $this, 'register_header_options' ), 250, 2 );
		add_action( 'elementor/element/after_section_end', array( $this, 'register_footer_options' ), 250, 2 );
		add_action( 'elementor/element/after_section_end', array( $this, 'register_post_options' ), 250, 2 );
		add_action( 'elementor/element/after_section_end', array( $this, 'register_megamenu_options' ), 250, 2 );
		add_action( 'elementor/element/after_section_end', array( $this, 'register_portfolio_options' ), 250, 2 );
		
		// Custom CSS
		add_action( 'elementor/element/kit/section_custom_css_pro/after_section_end', array( $this, 'register_custom_css_section' ), 20, 2 );
		add_action( 'elementor/css-file/post/parse', [ $this, 'lqd_add_custom_css' ] );
 
	}

	public function get_name() {
		return 'hub-global-controls';
	}

	public function register_header_options( Controls_Stack $element, $section_id ) {
		if ( 'document_settings' !== $section_id ) {
			return;
		}

		$section_name = 'lqd_header_options_hide';
		$section_name_2 = 'lqd_header_mobile_options_hide';

		if ( get_post_type() === 'liquid-header' ){
			$section_name = 'lqd_header_options';
			$section_name_2 = 'lqd_header_mobile_options';
		} 

		$element->start_controls_section(
			$section_name,
			array(
				'label' => __( 'Header Design Options', 'archub-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_SETTINGS,
			)
		);

		$element->add_control(
			'header_apply',
			[
				'label' => __( 'Apply Changes', 'archub-elementor-addons' ),
				'description' => __( 'This option allows you to see the changes without refreshing the page.', 'archub-elementor-addons' ),
				'type' => Controls_Manager::BUTTON,
				'separator' => 'after',
				'button_type' => 'success liquid-page-refresh',
				'event' => 'lqd_page_refresh',
				'text' => __( 'Apply', 'archub-elementor-addons' ),
			]
		);

		$element->add_control(
			'header_layout',
			[
				'label' => __( 'Style', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => true,
				'default' => 'default',
				'options' => [
					'default' => __( 'Default', 'archub-elementor-addons' ),
					'side' => __( 'Side', 'archub-elementor-addons' ),
				],
				'condition' => [
					'lqd_disable' => 'no'
				]
			]
		);

		$element->add_control(
			'header_bg',
			[
				'label' => __( 'Background', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'.main-header > .elementor > .elementor-section' => 'background: {{VALUE}}',
				],
			]
		);
		
		$element->add_control(
			'header_megamenu_react',
			[
				'label' => __( 'Enable Megamenu Reaction?', 'archub-elementor-addons' ),
				'description' => __( 'Enable if you want to add background animation to header when hover the megamenu item', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => true,
				'default' => 'no',
				'separator' => 'before',
				'options' => [
					'no' => __( 'No', 'archub-elementor-addons' ),
					'yes' => __( 'Yes', 'archub-elementor-addons' ),
				],
			]
		);

		$element->add_control(
			'header_megamenu_slide',
			[
				'label' => __( 'Enable Megamenu Slide?', 'archub-elementor-addons' ),
				'description' => __( 'Enable megamenus slide effect. It works better if you have multiple megamenu beside each other.', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => true,
				'default' => 'no',
				'separator' => 'before',
				'options' => [
					'no' => __( 'No', 'archub-elementor-addons' ),
					'yes' => __( 'Yes', 'archub-elementor-addons' ),
				],
			]
		);

		$element->add_control(
			'header_sticky',
			[
				'label' => __( 'Enable Sticky Header?', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => true,
				'default' => 'no',
				'separator' => 'before',
				'options' => [
					'no' => __( 'No', 'archub-elementor-addons' ),
					'yes' => __( 'Yes', 'archub-elementor-addons' ),
				],
				'condition' => [
					'header_layout!' => [ 'side', 'side-3' ]
				],
			]
		);

		$element->add_control(
			'header_enable_smart_sticky',
			[
				'label' => __( 'Enable Smart Sticky?', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
				'condition' => [
					'header_sticky' =>  'yes',
					'header_layout!' => [ 'side', 'side-3' ]
				],
			]
		);

		$element->add_control(
			'header_sticky_pos',
			[
				'label' => __( 'Sticky Header Position', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => true,
				'default' => 'default',
				'options' => [
					'default' => __( 'Default - Bottom of the header', 'archub-elementor-addons' ),
					'after-section' => __( 'After first section', 'archub-elementor-addons' ),
				],
				'condition' => [
					'header_sticky' =>  'yes',
					'header_layout!' => [ 'side', 'side-3' ]
				],
			]
		);

		$element->add_control(
			'header_sticky_shadow',
			[
				'label' => __( 'Disable Sticky Header Shadow', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => true,
				'default' => '',
				'options' => [
					'' => __( 'No', 'archub-elementor-addons' ),
					'sticky-header-noshadow' => __( 'Yes', 'archub-elementor-addons' ),
				],
				'condition' => [
					'header_sticky' =>  'yes',
					'header_layout!' => [ 'side', 'side-3' ]
				],
			]
		);

		$element->add_control(
			'header_sticky_dynamic_color',
			[
				'label' => __( 'Enable Sticky Dynamic Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => true,
				'default' => 'no',
				'options' => [
					'no' => __( 'No', 'archub-elementor-addons' ),
					'yes' => __( 'Yes', 'archub-elementor-addons' ),
				],
				'condition' => [
					'header_sticky' =>  'yes',
					'header_layout!' => [ 'side', 'side-3' ]
				],
			]
		);

		$element->add_control(
			'header_sticky_bg_heading',
			[
				'label' => __( 'Sticky Header Colors', 'archub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$element->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'header_sticky_bg',
				'label' => __( 'Navigation Background Color', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '.is-stuck > .elementor > .elementor-section',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
				'condition' => [
					'header_sticky' => 'yes',
					'header_sticky_dynamic_color!' => 'yes',
					'header_layout!' => [ 'side', 'side-3' ]
				],
			]
		);

		$element->add_control(
			'header_sticky_color',
			[
				'label' => __( 'Sticky Header Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.is-stuck > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element > .elementor-widget-container > p,
					.is-stuck > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element > .elementor-widget-container > .ld-fancy-heading .ld-fh-element,
					.is-stuck > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element .nav-trigger,
					.is-stuck > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element .lqd-scrl-indc,
					.is-stuck > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element > .elementor-widget-container > .lqd-custom-menu,
					.is-stuck > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element > .elementor-widget-container > .btn-naked,
					.is-stuck > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element > .elementor-widget-container > .btn-underlined,
					.is-stuck > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element > .elementor-widget-container > .social-icon li a,
					.is-stuck > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element > .elementor-widget-container > .lqd-custom-menu > ul > li > a,
					.is-stuck > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element > .elementor-widget-container > .module-primary-nav > .navbar-collapse .main-nav > li > a,
					.is-stuck > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element .ld-module-trigger .ld-module-trigger-txt,
					.is-stuck > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element .lqd-module-badge-outline .ld-module-trigger-count,
					.is-stuck > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element .ld-module-trigger-icon,
					.is-stuck > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element > .elementor-widget-container > .lqd-custom-menu .lqd-custom-menu-dropdown-btn' => 'color: {{VALUE}};',

					'.is-stuck > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element > .elementor-widget-container > .ld-fancy-heading .ld-fh-element span' => 'color: {{VALUE}} !important;',

					'.is-stuck > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element .nav-trigger.bordered .bars:before' => 'border-color: {{VALUE}};',

					'.is-stuck > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element .nav-trigger .bar,
					.is-stuck > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element .lqd-scrl-indc .lqd-scrl-indc-line' => 'background: {{VALUE}};',
				],
				'condition' => [
					'header_sticky' => 'yes',
					'header_sticky_dynamic_color!' => 'yes',
					'header_layout!' => [ 'side', 'side-3' ]
				],
			]
		);

		$element->add_control(
			'header_sticky_hover_color',
			[
				'label' => __( 'Sticky Header Hover Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.is-stuck > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element > .elementor-widget-container > .btn-naked:hover,
					.is-stuck > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element > .elementor-widget-container > .btn-underlined:hover,
					.is-stuck > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element > .elementor-widget-container > .social-icon li a:hover,
					.is-stuck > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element > .elementor-widget-container > .lqd-custom-menu > ul > li > a:hover,
					.is-stuck > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element > .elementor-widget-container > .module-primary-nav > .navbar-collapse .main-nav > li > a:hover,
					.is-stuck > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element > .elementor-widget-container > .module-primary-nav > .navbar-collapse .main-nav > li:hover > a,
					.is-stuck > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element > .elementor-widget-container > .module-primary-nav > .navbar-collapse .main-nav > li.is-active > a,
					.is-stuck > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element > .elementor-widget-container > .module-primary-nav > .navbar-collapse .main-nav > li.current-menu-ancestor > a,
					.is-stuck > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element > .elementor-widget-container > .module-primary-nav > .navbar-collapse .main-nav > li.current_page_item > a,
					.is-stuck > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element > .elementor-widget-container > .module-primary-nav > .navbar-collapse .main-nav > li.current-menu-item > a' => 'color: {{VALUE}}',
				],
				'condition' => [
					'header_sticky' => 'yes',
					'header_sticky_dynamic_color!' => 'yes',
					'header_layout!' => [ 'side', 'side-3' ]
				],
			]
		);

		$element->start_controls_tabs(
			'sticky_colors_tabs'
		);

			$element->start_controls_tab(
				'sticky_normal_colors_tabs',
				[
					'label' => __( 'Normal', 'archub-elementor-addons' ),
					'condition' => [
						'header_sticky_dynamic_color' => 'yes',
						'header_layout!' => [ 'side', 'side-3' ]
					]
				]
			);

			$element->add_control(
				'header_sticky_dynamic_light_color',
				[
					'label' => __( 'Colors on light backgrounds', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'.main-header > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element.lqd-active-row-light .nav-trigger.bordered .bars:before' => 'border-color: {{VALUE}}',

						'.main-header > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element.lqd-active-row-light .nav-trigger .bar' => 'background: {{VALUE}}',

						'.main-header > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element.lqd-active-row-light > .elementor-widget-container > .lqd-custom-menu,
						.main-header > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element.lqd-active-row-light > .elementor-widget-container > .lqd-custom-menu > ul > li > a,
						.main-header > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element.lqd-active-row-light > .elementor-widget-container > .lqd-custom-menu .lqd-custom-menu-dropdown-btn,
						.main-header > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element.lqd-active-row-light > .elementor-widget-container > p,
						.main-header > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element.lqd-active-row-light > .elementor-widget-container > .btn-naked,
						.main-header > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element.lqd-active-row-light > .elementor-widget-container > .btn-underlined,
						.main-header > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element.lqd-active-row-light > .elementor-widget-container > .ld-fancy-heading .ld-fh-element,
						.main-header > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element.lqd-active-row-light > .elementor-widget-container > .social-icon li a,
						.main-header > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element.lqd-active-row-light > .elementor-widget-container > .iconbox h3,
						.main-header > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element.lqd-active-row-light > .elementor-widget-container > .iconbox .iconbox-icon-container,
						.main-header > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element.lqd-active-row-light .nav-trigger,
						.main-header > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element.lqd-active-row-light .lqd-scrl-indc
						.main-header > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element.lqd-active-row-light .main-nav > li > a,
						.main-header > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element.lqd-active-row-light .ld-module-trigger .ld-module-trigger-txt,
						.main-header > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element.lqd-active-row-light .ld-module-trigger .ld-module-trigger-count,
						.main-header > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element.lqd-active-row-light .ld-module-trigger-icon' => 'color: {{VALUE}}',

						'.main-header > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element.lqd-active-row-light > .elementor-widget-container > .ld-fancy-heading .ld-fh-element span' => 'color: {{VALUE}} !important'
					],
					'condition' => [
						'header_sticky_dynamic_color' => 'yes',
						'header_layout!' => [ 'side', 'side-3' ]
					],
				]
			);

			$element->add_control(
				'header_sticky_dynamic_dark_color',
				[
					'label' => __( 'Colors on dark backgrounds', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'.main-header > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element.lqd-active-row-dark .nav-trigger.bordered .bars:before' => 'border-color: {{VALUE}}',

						'.main-header > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element.lqd-active-row-dark .nav-trigger .bar' => 'background: {{VALUE}}',

						'.main-header > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element.lqd-active-row-dark > .elementor-widget-container > .lqd-custom-menu,
						.main-header > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element.lqd-active-row-dark > .elementor-widget-container > .lqd-custom-menu > ul > li > a,
						.main-header > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element.lqd-active-row-dark > .elementor-widget-container > .lqd-custom-menu .lqd-custom-menu-dropdown-btn,
						.main-header > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element.lqd-active-row-dark > .elementor-widget-container > p,
						.main-header > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element.lqd-active-row-dark > .elementor-widget-container > .btn-naked,
						.main-header > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element.lqd-active-row-dark > .elementor-widget-container > .btn-underlined,
						.main-header > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element.lqd-active-row-dark > .elementor-widget-container > .ld-fancy-heading .ld-fh-element,
						.main-header > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element.lqd-active-row-dark > .elementor-widget-container > .social-icon li a,
						.main-header > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element.lqd-active-row-dark > .elementor-widget-container > .iconbox h3,
						.main-header > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element.lqd-active-row-dark > .elementor-widget-container > .iconbox .iconbox-icon-container,
						.main-header > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element.lqd-active-row-dark .nav-trigger,
						.main-header > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element.lqd-active-row-dark .lqd-scrl-indc
						.main-header > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element.lqd-active-row-dark .main-nav > li > a,
						.main-header > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element.lqd-active-row-dark .ld-module-trigger .ld-module-trigger-txt,
						.main-header > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element.lqd-active-row-dark .ld-module-trigger .ld-module-trigger-count,
						.main-header > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element.lqd-active-row-dark .ld-module-trigger-icon' => 'color: {{VALUE}}',

						'.main-header > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element.lqd-active-row-dark > .elementor-widget-container > .ld-fancy-heading .ld-fh-element span' => 'color: {{VALUE}} !important'
					],
					'condition' => [
						'header_sticky_dynamic_color' => 'yes',
						'header_layout!' => [ 'side', 'side-3' ]
					],
				]
			);


			$element->end_controls_tab();

			$element->start_controls_tab(
				'sticky_hover_colors_tabs',
				[
					'label' => __( 'Hover', 'archub-elementor-addons' ),
					'condition' => [
						'header_sticky_dynamic_color' => 'yes',
						'header_layout!' => [ 'side', 'side-3' ]
					]
				]
			);

			$element->add_control(
				'header_sticky_dynamic_light_hcolor',
				[
					'label' => __( 'Colors on light', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'.main-header > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element.lqd-active-row-light > .elementor-widget-container > .lqd-custom-menu > ul > li > a:hover, .main-header > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element.lqd-active-row-light .main-nav > li > a:hover, .main-header > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element.lqd-active-row-light > .elementor-widget-container > .social-icon li a:hover' => 'color: {{VALUE}}',
					],
					'condition' => [
						'header_sticky_dynamic_color' => 'yes',
						'header_layout!' => [ 'side', 'side-3' ]
					],
				]
			);

			$element->add_control(
				'header_sticky_dynamic_dark_hcolor',
				[
					'label' => __( 'Colors on dark', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'.main-header > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element.lqd-active-row-dark > .elementor-widget-container > .lqd-custom-menu > ul > li > a:hover, .main-header > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element.lqd-active-row-dark .main-nav > li > a:hover, .main-header > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element.lqd-active-row-dark > .elementor-widget-container > .social-icon li a:hover' => 'color: {{VALUE}}',
					],
					'condition' => [
						'header_sticky_dynamic_color' => 'yes',
						'header_layout!' => [ 'side', 'side-3' ]
					],
				]
			);

			$element->end_controls_tab();
			
		$element->end_controls_tabs();

		$element->add_control(
			'header_sticky_dynamic_light_bg',
			[
				'label' => __( 'Header Background Color Over Light Sections', 'archub-elementor-addons' ),
				'description' => __( 'Background color of the sticky header on light sections', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'.main-header.lqd-active-row-light > .elementor > .elementor-section:not(.lqd-stickybar-wrap)' => 'background-color: {{VALUE}} !important',
				],
				'condition' => [
					'header_sticky_dynamic_color' => 'yes',
					'header_layout!' => [ 'side', 'side-3' ]
				],
			]
		);
		
		$element->add_control(
			'header-sticky-dynamic-dark-bg',
			[
				'label' => __( 'Header Background Color Over Dark Sections', 'archub-elementor-addons' ),
				'description' => __( 'Background color of the sticky header on dark sections', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'.main-header.lqd-active-row-dark > .elementor > .elementor-section:not(.lqd-stickybar-wrap)' => 'background-color: {{VALUE}} !important',
				],
				'condition' => [
					'header_sticky_dynamic_color' => 'yes',
					'header_layout!' => [ 'side', 'side-3' ]
				],
			]
		);

		$element->add_control(
			'header_overlay',
			[
				'label' => __( 'Overlay?', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => true,
				'default' => '',
				'options' => [
					'' => __( 'No', 'archub-elementor-addons' ),
					'main-header-overlay' => __( 'Yes', 'archub-elementor-addons' ),
				],
				'condition' => [
					'header_layout!' => [ 'side', 'side-3' ]
				],
			]
		);
		$element->end_controls_section();

		// Mobile Navigation
		$element->start_controls_section(
			$section_name_2,
			[
				'label' => __( 'Mobile Navigation', 'archub-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_SETTINGS,
			]
		);

		$element->add_control(
			'header_mobile_apply',
			[
				'label' => __( 'Apply Changes', 'archub-elementor-addons' ),
				'description' => __( 'This option allows you to see the changes without refreshing the page.', 'archub-elementor-addons' ),
				'type' => Controls_Manager::BUTTON,
				'button_type' => 'success liquid-page-refresh',
				'event' => 'lqd_page_refresh',
				'text' => __( 'Apply', 'archub-elementor-addons' ),
			]
		);

		$element->add_control(
			'enable_mobile_header_builder',
			[
				'label' => __( 'Enable mobile header builder?', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$menus = $this->get_available_menus();
		if ( ! empty( $menus ) ) {
			$element->add_control(
				'header_mobile_menu',
				[
					'label' => __( 'Mobile Primary Menu', 'archub-elementor-addons' ),
					'type' => Controls_Manager::SELECT,
					'label_block' => true,
					'options' => $menus,
					'default' => array_keys( $menus )[0],
					'save_default' => true,
					'separator' => 'before',
					'description'  => sprintf( __( 'Go to the <a href="%s" target="_blank">Menus screen</a> to manage your menus.', 'archub-elementor-addons' ), admin_url( 'nav-menus.php' ) ),
					'condition' => [
						'enable_mobile_header_builder' => ''
					]
 				]
			);
		} else {
			$element->add_control(
				'header_mobile_menu',
				[
					'type' => Controls_Manager::RAW_HTML,
					'raw' => sprintf( __( '<strong>There are no menus in your site.</strong><br>Go to the <a href="%s" target="_blank">Menus screen</a> to create one.', 'archub-elementor-addons' ), admin_url( 'nav-menus.php?action=edit&menu=0' ) ),
					'separator' => 'before',
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
					'condition' => [
						'enable_mobile_header_builder' => ''
					]
				]
			);
		}

		$element->add_control(
			'm_nav_style',
			[
				'label' => __( 'Style', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Use Global Settings', 'archub-elementor-addons' ),
					'classic' => __( 'Classic', 'archub-elementor-addons' ),
					'minimal' => __( 'Minimal', 'archub-elementor-addons' ),
					'modern' => __( 'Modern', 'archub-elementor-addons' ),
				],
				'condition' => [
					'enable_mobile_header_builder' => ''
				]
			]
		);
		
		$element->add_control(
			'm_nav_logo_alignment',
			[
				'label' => __( 'Logo Alignment', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Use Global Settings', 'archub-elementor-addons' ),
					'default' => __( 'Default', 'archub-elementor-addons' ),
					'center' => __( 'Center', 'archub-elementor-addons' ),
				],
				'condition' => [
					'enable_mobile_header_builder' => ''
				]
			]
		);

		$element->add_control(
			'm_nav_trigger_alignment',
			[
				'label' => __( 'Trigger Alignment', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Use Global Settings', 'archub-elementor-addons' ),
					'right' => __( 'Right', 'archub-elementor-addons' ),
					'left' => __( 'Left', 'archub-elementor-addons' ),
				],
				'condition' => [
					'enable_mobile_header_builder' => ''
				]
			]
		);

		$element->add_control(
			'm_nav_alignment',
			[
				'label' => __( 'Navigation Items Alignment', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Use Global Settings', 'archub-elementor-addons' ),
					'right' => __( 'Right', 'archub-elementor-addons' ),
					'center' => __( 'Center', 'archub-elementor-addons' ),
					'left' => __( 'Left', 'archub-elementor-addons' ),
				],
				'condition' => [
					'm_nav_style' => [ 'classic', 'minimal' ],
					'enable_mobile_header_builder' => ''
				]
			]
		);

		$element->add_control(
			'm_nav_scheme',
			[
				'label' => __( 'Navigation Color Scheme', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Use Global Settings', 'archub-elementor-addons' ),
					'gray' => __( 'Gray', 'archub-elementor-addons' ),
					'light' => __( 'Light', 'archub-elementor-addons' ),
					'dark' => __( 'Dark', 'archub-elementor-addons' ),
					'custom' => __( 'Custom', 'archub-elementor-addons' ),
				],
				'condition' => [
					'm_nav_style' => [ 'classic', 'minimal' ],
					'enable_mobile_header_builder' => ''
				]
			]
		);

		$element->add_control(
			'm_nav_custom_color_heading',
			[
				'label' => __( 'Navigation Background Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'm_nav_scheme' => 'custom',
					'm_nav_style' => [ 'classic', 'minimal', 'modern' ],
					'enable_mobile_header_builder' => ''
				]
			]
		);

		$element->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'm_nav_custom_color',
				'label' => __( 'Navigation Background Color', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '[data-mobile-nav-scheme=custom] .lqd-mobile-sec .navbar-collapse',
				'condition' => [
					'm_nav_scheme' => 'custom',
					'm_nav_style' => [ 'classic', 'minimal', 'modern' ],
					'enable_mobile_header_builder' => ''
				]
			]
		);

		$element->add_control(
			'm_nav_custom_txt_color',
			[
				'label' => __( 'Navigation Text Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'[data-mobile-nav-scheme=custom] .lqd-mobile-sec .navbar-collapse, [data-mobile-nav-scheme=custom] .lqd-mobile-sec .header-module .social-icon > li > a, [data-mobile-nav-scheme=custom] .lqd-mobile-sec .main-nav .lqd-custom-menu > li > a, [data-mobile-nav-scheme=custom] .lqd-mobile-sec ul.nav.main-nav > li > a' => 'color: {{VALUE}}',
				],
				'condition' => [
					'm_nav_scheme' => 'custom',
					'm_nav_style' => [ 'classic', 'minimal', 'modern' ],
					'enable_mobile_header_builder' => ''
				]
			]
		);

		$element->add_control(
			'm_nav_modern_bg_heading',
			[
				'label' => __( 'Navigation Background', 'archub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'm_nav_style' => 'modern',
					'enable_mobile_header_builder' => ''
				]
			]
		);

		$element->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'm_nav_modern_bg',
				'label' => __( 'Navigation Background', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '[data-mobile-nav-style=modern] .lqd-mobile-sec:before',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
				'condition' => [
					'm_nav_style' => 'modern',
					'enable_mobile_header_builder' => ''
				]
			]
		);

		$element->add_control(
			'm_nav_modern_color',
			[
				'label' => __( 'Navigation Text/Trigger Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'[data-mobile-nav-style=modern] .lqd-mobile-sec .navbar-collapse ul .nav-item-children > li > a, [data-mobile-nav-style=modern] .lqd-mobile-sec .navbar-collapse ul > li > a, [data-mobile-nav-style=modern] .lqd-mobile-sec .navbar-collapse ul.nav.main-nav .nav-item-children > li > a, [data-mobile-nav-style=modern] .lqd-mobile-sec .navbar-collapse ul.nav.main-nav > li > a, [data-mobile-nav-style=modern] .lqd-mobile-sec .megamenu .ld-fancy-heading .ld-fh-element' => 'color: {{VALUE}}',
					'[data-mobile-nav-style=modern] .lqd-mobile-sec .navbar-collapse ul .nav-item-children > li > a:hover, [data-mobile-nav-style=modern] .lqd-mobile-sec .navbar-collapse ul > li > a:hover, [data-mobile-nav-style=modern] .lqd-mobile-sec .navbar-collapse ul.nav.main-nav .nav-item-children > li > a:hover, [data-mobile-nav-style=modern] .lqd-mobile-sec .navbar-collapse ul.nav.main-nav > li > a:hover' => 'color: {{VALUE}}',
					'[data-mobile-nav-style=modern] .lqd-mobile-sec-nav .mobile-navbar-collapse > .nav-trigger .bars' => 'border: none; padding-inline-start: 10px;',
					'[data-mobile-nav-style=modern] .lqd-mobile-sec-nav .mobile-navbar-collapse > .nav-trigger .bars:before' => 'border: 2px solid {{value}}; opacity: 0.4;',
					'[data-mobile-nav-style=modern] .lqd-mobile-sec-nav .mobile-navbar-collapse > .nav-trigger .bar' => 'background: {{VALUE}}',
				],
				'condition' => [
					'm_nav_style' => 'modern',
					'enable_mobile_header_builder' => ''
				]
			]
		);
		
		$element->add_control(
			'm_nav_border_color',
			[
				'label' => __( 'Navigation Border Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.lqd-mobile-sec ul.nav.main-nav > li > a' => 'border-color: {{VALUE}}',
				],
				'condition' => [
					'm_nav_style' => 'classic',
					'm_nav_scheme' => 'custom',
					'enable_mobile_header_builder' => ''
				]
			]
		);

		$element->add_control(
			'm_nav_header_scheme',
			[
				'label' => __( 'Header Color Scheme', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Use Global Settings', 'archub-elementor-addons' ),
					'gray' => __( 'Gray', 'archub-elementor-addons' ),
					'light' => __( 'Light', 'archub-elementor-addons' ),
					'dark' => __( 'Dark', 'archub-elementor-addons' ),
					'custom' => __( 'Custom', 'archub-elementor-addons' ),
				],
				'condition' => [
					'enable_mobile_header_builder' => ''
				]
			]
		);

		$element->add_control(
			'm_nav_header_custom_bg_heading',
			[
				'label' => __( 'Header Background', 'archub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'condition' => [
					'm_nav_header_scheme' => 'custom',
					'm_nav_style' => [ 'classic', 'minimal', 'modern' ],
					'enable_mobile_header_builder' => ''
				]
			]
		);

		$element->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'm_nav_header_custom_bg',
				'label' => __( 'Header Background', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '[data-mobile-header-scheme] .lqd-mobile-sec .navbar-header',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
				'condition' => [
					'm_nav_header_scheme' => 'custom',
					'm_nav_style' => [ 'classic', 'minimal', 'modern' ],
					'enable_mobile_header_builder' => ''
				]
			]
		);

		$element->add_control(
			'm_nav_header_custom_color',
			[
				'label' => __( 'Header Text/Trigger Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'.lqd-mobile-sec .navbar-header .nav-trigger, .lqd-mobile-sec .navbar-header .ld-module-trigger, .lqd-mobile-sec .navbar-header .ld-search-form .input-icon' => 'color: {{VALUE}}',
					'.lqd-mobile-sec .navbar-header .nav-trigger .bar, .lqd-mobile-sec .navbar-header .nav-trigger.style-2 .bar:before, .lqd-mobile-sec .navbar-header .nav-trigger.style-2 .bar:after' => 'background: {{VALUE}}',
				],
				'condition' => [
					'm_nav_header_scheme' => 'custom',
					'm_nav_style' => [ 'classic', 'minimal', 'modern' ],
					'enable_mobile_header_builder' => ''
				]
			]
		);

		$element->add_control(
			'mobile_header_overlay',
			[
				'label' => __( 'Enable Overlay on mobile device?', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Use Global Settings', 'archub-elementor-addons' ),
					'no' => __( 'No', 'archub-elementor-addons' ),
					'yes' => __( 'Yes', 'archub-elementor-addons' ),
				]
			]
		);

		$element->add_control(
			'mobile_header_sticky',
			[
				'label' => __( 'Enable Sticky Header on mobile devices?', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Use Global Settings', 'archub-elementor-addons' ),
					'no' => __( 'No', 'archub-elementor-addons' ),
					'yes' => __( 'Yes', 'archub-elementor-addons' ),
				]
			]
		);
		


		$element->end_controls_section();
	}

	public function register_footer_options( Controls_Stack $element, $section_id ) {
		if ( 'document_settings' !== $section_id ) {
			return;
		}

		$section_name = 'lqd_footer_options_hide';

		if ( get_post_type() === 'liquid-footer' ){
			$section_name = 'lqd_footer_options';
		} 
		
		$element->start_controls_section(
			$section_name,
			array(
				'label' => __( 'Footer Design Options', 'archub-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_SETTINGS,
			)
		);

		$element->add_control(
			'footer_fixed',
			[
				'label' => __( 'Sticky Footer', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'off',
				'options' => [
					'on' => __( 'On', 'archub-elementor-addons' ),
					'off' => __( 'Off', 'archub-elementor-addons' ),
				],
			]
		);

		$element->add_control(
			'footer_fixed_shadow',
			[
				'label' => __( 'Sticky Footer Shadow Depth', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'off',
				'options' => [
					'0' => __( '0', 'archub-elementor-addons' ),
					'1' => __( '1', 'archub-elementor-addons' ),
					'2' => __( '2', 'archub-elementor-addons' ),
					'3' => __( '3', 'archub-elementor-addons' ),
					'4' => __( '4', 'archub-elementor-addons' ),
				],
				'condition' => [
					'footer_fixed' => 'on',
				],
			]
		);

		$element->start_controls_tabs(
			'footer_link_colors_tabs'
		);

			$element->start_controls_tab(
				'footer_link_colors_normal_tabs',
				[
					'label' => __( 'Normal', 'archub-elementor-addons' ),
				]
			);
			$element->add_control(
				'footer_link_color',
				[
					'label' => __( 'Link Color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'.main-footer a:not(.btn), .single-liquid-footer a:not(.btn)' => 'color: {{VALUE}}',
					],
				]
			);
			$element->end_controls_tab();

			$element->start_controls_tab(
				'footer_link_colors_hover_tabs',
				[
					'label' => __( 'Hover', 'archub-elementor-addons' ),
				]
			);

			$element->add_control(
				'footer_link_hcolor',
				[
					'label' => __( 'Link Color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'.main-footer a:not(.btn):hover, .single-liquid-footer a:not(.btn):hover' => 'color: {{VALUE}}',
					],
				]
			);
			$element->end_controls_tab();

		$element->end_controls_tabs();

		$element->add_control(
			'footer_text_color',
			[
				'label' => __( 'Text Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.main-footer, .single-liquid-footer' => 'color: {{VALUE}}',
				],
				'separator' => 'before',
			]
		);

		$element->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'footer_background',
				'label' => __( 'Background', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient', 'image' ],
				'selector' => '.main-footer, .single-liquid-footer #lqd-site-content',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
				'separator' => 'before',
			]
		);
		
		$element->end_controls_section();

	}

	public function register_post_options( Controls_Stack $element, $section_id ) {
		if ( 'document_settings' !== $section_id ) {
			return;
		}
		
		$post_type = get_post_type( get_the_ID() );

		// Page, Header and Footer Options
		if ( $post_type === 'post' || $post_type === 'page' || $post_type === 'liquid-portfolio' ) {

			// Page Options
			$element->start_controls_section(
				'lqd_post_options',
				[
					'label' => __( 'Page Options', 'archub-elementor-addons' ),
					'tab'   => Controls_Manager::TAB_SETTINGS,
				]
			);

			$element->add_control(
				'lqd_post_options_apply',
				[
					'label' => __( 'Apply Changes', 'archub-elementor-addons' ),
					'description' => __( 'This option allows you to see the changes without refreshing the page.', 'archub-elementor-addons' ),
					'type' => Controls_Manager::BUTTON,
					'separator' => 'after',
					'button_type' => 'success liquid-page-refresh',
					'event' => 'lqd_page_refresh',
					'text' => __( 'Apply', 'archub-elementor-addons' ),
				]
			);

			$element->add_control(
				'body_color_scheme',
				[
					'label' => __( 'Page Color Scheme', 'archub-elementor-addons' ),
					'type' => Controls_Manager::CHOOSE,
					'options' => [
						'light' => [
							'title' => __( 'Light', 'archub-elementor-addons' ),
							'icon' => 'fa fa-sun',
						],
						'dark' => [
							'title' => __( 'Dark', 'archub-elementor-addons' ),
							'icon' => 'fa fa-moon',
						],
					],
					'default' => '',
					'toggle' => true,
				]
			);

			$element->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name' => 'lqd_page_background',
					'label' => __( 'Background', 'archub-elementor-addons' ),
					'types' => [ 'classic', 'gradient', 'image' ],
					'selector' => '{{WRAPPER}} #lqd-site-content',
					'fields_options' => [
						'background' => [
							//'default' => 'classic',
						],
					],
					'separator' => 'before',
				]
			);

			$element->add_control(
				'page_enable_liquid_bg',
				[
					'label' => __( 'Adaptive Background Color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => __( 'On', 'archub-elementor-addons' ),
					'label_off' => __( 'Off', 'archub-elementor-addons' ),
					'return_value' => 'on',
					'separator' => 'before',
					'condition' => [
						'page_enable_stack' => '',
					],
				]
			);

			$element->add_control(
				'page_liquid_bg_interact',
				[
					'label' => __( 'Interact With Header', 'archub-elementor-addons' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => __( 'On', 'archub-elementor-addons' ),
					'label_off' => __( 'Off', 'archub-elementor-addons' ),
					'return_value' => 'on',
					'condition' => [
						'page_enable_liquid_bg' => 'on',
					],
				]
			);

			$element->add_control(
				'page_enable_frame',
				[
					'label' => __( 'Enable Page Frame', 'archub-elementor-addons' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => __( 'On', 'archub-elementor-addons' ),
					'label_off' => __( 'Off', 'archub-elementor-addons' ),
					'return_value' => 'on',
					'separator' => 'before',
				]
			);

			$element->add_control(
				'page_frame_v_color',
				[
					'label' => __( 'Page Frame Background Color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .lqd-page-frame[data-orientation=v],{{WRAPPER}} .lqd-page-frame[data-orientation=h]' => 'background: {{VALUE}}',
					],
					'condition' => [
						'page_enable_frame' => 'on',
					],
				]
			);

			$element->add_control(
				'page_enable_liquid_bg_frame',
				[
					'label' => __( 'Adaptive Frame Color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => __( 'On', 'archub-elementor-addons' ),
					'label_off' => __( 'Off', 'archub-elementor-addons' ),
					'return_value' => 'on',
					'separator' => 'before',
					'condition' => [
						'page_enable_stack' => '',
					],
				]
			);

			$element->add_control(
				'page_enable_stack',
				[
					'label' => __( 'Enable Page Blocks?', 'archub-elementor-addons' ),
					'description' => __( 'Will enable page stack', 'archub-elementor-addons' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => __( 'On', 'archub-elementor-addons' ),
					'label_off' => __( 'Off', 'archub-elementor-addons' ),
					'return_value' => 'on',
					'separator' => 'before',
					'condition' => [
						'page_enable_liquid_bg' => '',
					],
				]
			);

			$element->add_control(
				'page_enable_stack_mobile',
				[
					'label' => __( 'Enable Page Blocks? ( Mobile )', 'archub-elementor-addons' ),
					'description' => __( 'Will enable page stack for mobile devices', 'archub-elementor-addons' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => __( 'On', 'archub-elementor-addons' ),
					'label_off' => __( 'Off', 'archub-elementor-addons' ),
					'return_value' => 'on',
					'condition' => [
						'page_enable_stack' => 'on',
					],
				]
			);

			$element->add_control(
				'page_stack_effect',
				[
					'label' => __( 'Page Blocks Effect', 'archub-elementor-addons' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'fadeScale',
					'options' => [
						'fadeScale' => __( 'fadeScale', 'archub-elementor-addons' ),
						'slideOver' => __( 'slideOver', 'archub-elementor-addons' ),
						'mask' => __( 'Mask', 'archub-elementor-addons' ),
					],
					'condition' => [
						'page_enable_stack' => 'on',
					],
				]
			);

			
			$element->add_control(
				'page_stack_nav',
				[
					'label' => __( 'Blocks Navigation?', 'archub-elementor-addons' ),
					'description' => __( 'Will enable page blocks navigation', 'archub-elementor-addons' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => __( 'On', 'archub-elementor-addons' ),
					'label_off' => __( 'Off', 'archub-elementor-addons' ),
					'return_value' => 'on',
					'separator' => 'before',
					'condition' => [
						'page_enable_stack' => 'on',
					],
				]
			);

			$element->add_control(
				'page_stack_nav_style',
				[
					'label' => __( 'Blocks Navigation Style', 'archub-elementor-addons' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'lqd-stack-nav-style-1',
					'options' => [
						'lqd-stack-nav-style-1' => __( 'Style 1', 'archub-elementor-addons' ),
						'lqd-stack-nav-style-2' => __( 'Style 2', 'archub-elementor-addons' ),
						'lqd-stack-nav-style-3' => __( 'Style 3', 'archub-elementor-addons' ),
						'lqd-stack-nav-style-4' => __( 'Style 4', 'archub-elementor-addons' ),
					],
					'condition' => [
						'page_stack_nav' => 'on',
						'page_enable_stack' => 'on',
					],
				]
			);

			$element->add_control(
				'page_stack_nav_show_current_total',
				[
					'label' => __( 'Show current and total slides numbers?', 'archub-elementor-addons' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => __( 'On', 'archub-elementor-addons' ),
					'label_off' => __( 'Off', 'archub-elementor-addons' ),
					'return_value' => 'on',
					'condition' => [
						'page_stack_nav' => 'on',
						'page_enable_stack' => 'on',
					],
				]
			);
		
			$element->add_control(
				'page_blocks_nav_color_dark',
				[
					'label' => __( 'Navigation color on dark sections', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-dark #pp-nav' => 'color: {{VALUE}}',
					],
					'condition' => [
						'page_stack_nav' => 'on',
						'page_enable_stack' => 'on',
					],
				]
			);

			$element->add_control(
				'page_blocks_nav_active_color_dark',
				[
					'label' => __( 'Active navigation color on dark sections', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-dark #pp-nav li.active, {{WRAPPER}}.lqd-active-row-dark #pp-nav li.active a' => 'color: {{VALUE}}',
					],
					'condition' => [
						'page_stack_nav' => 'on',
						'page_enable_stack' => 'on',
					],
				]
			);

			$element->add_control(
				'page_blocks_nav_color_light',
				[
					'label' => __( 'Navigation color on light sections', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-light #pp-nav' => 'color: {{VALUE}}',
					],
					'condition' => [
						'page_stack_nav' => 'on',
						'page_enable_stack' => 'on',
					],
				]
			);

			$element->add_control(
				'page_blocks_nav_active_color_light',
				[
					'label' => __( 'Active navigation color on light sections', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-light #pp-nav li.active, {{WRAPPER}}.lqd-active-row-light #pp-nav li.active a' => 'color: {{VALUE}}',
					],
					'condition' => [
						'page_stack_nav' => 'on',
						'page_enable_stack' => 'on',
					],
				]
			);

			$element->add_control(
				'page_blocks_nav_numns_color_dark',
				[
					'label' => __( 'Navigation numbers color on dark sections', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-dark #pp-nav .pp-nav-current, {{WRAPPER}}.lqd-active-row-dark #pp-nav .pp-nav-total' => 'color: {{VALUE}}',
					],
					'condition' => [
						'page_stack_nav' => 'on',
						'page_enable_stack' => 'on',
					],
				]
			);

			$element->add_control(
				'page_blocks_nav_numns_color_light',
				[
					'label' => __( 'Navigation numbers color on light sections', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-light #pp-nav .pp-nav-current, {{WRAPPER}}.lqd-active-row-light #pp-nav .pp-nav-total' => 'color: {{VALUE}}',
					],
					'condition' => [
						'page_stack_nav' => 'on',
						'page_enable_stack' => 'on',
					],
				]
			);
		
			$element->add_control(
				'page_stack_nav_prevnextbuttons',
				[
					'label' => __( 'Blocks Previous/Next buttons?', 'archub-elementor-addons' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => __( 'On', 'archub-elementor-addons' ),
					'label_off' => __( 'Off', 'archub-elementor-addons' ),
					'return_value' => 'on',
					'separator' => 'before',
					'condition' => [
						'page_enable_stack' => 'on',
					],
				]
			);

			$element->add_control(
				'page_stack_buttons_style',
				[
					'label' => __( 'Buttons Style', 'archub-elementor-addons' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'lqd-stack-buttons-style-1',
					'options' => [
						'lqd-stack-buttons-style-1' => __( 'Style 1', 'archub-elementor-addons' ),
						'lqd-stack-buttons-style-2' => __( 'Style 2', 'archub-elementor-addons' ),
					],
					'condition' => [
						'page_enable_stack' => 'on',
						'page_stack_nav_prevnextbuttons' => 'on',
					],
				]
			);

			$element->add_control(
				'page_blocks_button_color_dark',
				[
					'label' => __( 'Button color on dark sections', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-dark .lqd-stack-prevnext-button' => 'color: {{VALUE}}',
					],
					'condition' => [
						'page_enable_stack' => 'on',
						'page_stack_nav_prevnextbuttons' => 'on',
					],
				]
			);

			$element->add_control(
				'page_blocks_button_hover_color_dark',
				[
					'label' => __( 'Hover button color on dark sections', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-dark .lqd-stack-prevnext-button:hover' => 'color: {{VALUE}}',
					],
					'condition' => [
						'page_enable_stack' => 'on',
						'page_stack_nav_prevnextbuttons' => 'on',
					],
				]
			);

			$element->add_control(
				'page_blocks_button_color_light',
				[
					'label' => __( 'Button color on light sections', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-light .lqd-stack-prevnext-button' => 'color: {{VALUE}}',
					],
					'condition' => [
						'page_enable_stack' => 'on',
						'page_stack_nav_prevnextbuttons' => 'on',
					],
				]
			);

			$element->add_control(
				'page_blocks_button_hover_color_light',
				[
					'label' => __( 'Hover button color on light sections', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-light .lqd-stack-prevnext-button:hover' => 'color: {{VALUE}}',
					],
					'condition' => [
						'page_enable_stack' => 'on',
						'page_stack_nav_prevnextbuttons' => 'on',
					],
				]
			);

			$element->add_control(
				'page_stack_numbers',
				[
					'label' => __( 'Blocks Numbers?', 'archub-elementor-addons' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => __( 'On', 'archub-elementor-addons' ),
					'label_off' => __( 'Off', 'archub-elementor-addons' ),
					'return_value' => 'on',
					'condition' => [
						'page_enable_stack' => 'on',
					],
					'separator' => 'before',
				]
			);

			$element->add_control(
				'page_stack_numbers_style',
				[
					'label' => __( 'Numbers Style', 'archub-elementor-addons' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'lqd-stack-nums-style-1',
					'options' => [
						'lqd-stack-nums-style-1' => __( 'Style 1', 'archub-elementor-addons' ),
						'lqd-stack-nums-style-2' => __( 'Style 2', 'archub-elementor-addons' ),
					],
					'condition' => [
						'page_enable_stack' => 'on',
						'page_stack_numbers' => 'on',
					],
				]
			);

			$element->add_control(
				'page_blocks_nums_color_dark',
				[
					'label' => __( 'Numbers color on dark sections', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-dark .lqd-stack-page-number' => 'color: {{VALUE}}',
					],
					'condition' => [
						'page_enable_stack' => 'on',
						'page_stack_numbers' => 'on',
					],
				]
			);

			$element->add_control(
				'page_blocks_nums_active_color_dark',
				[
					'label' => __( 'Active numbers color on dark sections', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-dark .lqd-stack-page-number-counter, {{WRAPPER}}.lqd-active-row-dark .lqd-stack-page-number li.active' => 'color: {{VALUE}}',
					],
					'condition' => [
						'page_enable_stack' => 'on',
						'page_stack_numbers' => 'on',
					],
				]
			);

			$element->add_control(
				'page_blocks_nums_color_light',
				[
					'label' => __( 'Numbers color on light sections', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-light .lqd-stack-page-number' => 'color: {{VALUE}}',
					],
					'condition' => [
						'page_enable_stack' => 'on',
						'page_stack_numbers' => 'on',
					],
				]
			);

			$element->add_control(
				'page_blocks_nums_active_color_light',
				[
					'label' => __( 'Active numbers color on light sections', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-light .lqd-stack-page-number-counter, {{WRAPPER}}.lqd-active-row-light .lqd-stack-page-number li.active' => 'color: {{VALUE}}',
					],
					'condition' => [
						'page_enable_stack' => 'on',
						'page_stack_numbers' => 'on',
					],
				]
			);
	
			$element->end_controls_section();

			// Header Options
			$element->start_controls_section(
				'lqd_post_header_options',
				[
					'label' => __( 'Page Header Options', 'archub-elementor-addons' ),
					'tab'   => Controls_Manager::TAB_SETTINGS,
				]
			);

			$element->add_control(
				'lqd_post_header_options_apply',
				[
					'label' => __( 'Apply Changes', 'archub-elementor-addons' ),
					'description' => __( 'This option allows you to see the changes without refreshing the page.', 'archub-elementor-addons' ),
					'type' => Controls_Manager::BUTTON,
					'separator' => 'after',
					'button_type' => 'success liquid-page-refresh',
					'event' => 'lqd_page_refresh',
					'text' => __( 'Apply', 'archub-elementor-addons' ),
				]
			);

			$element->add_control(
				'header_enable_switch',
				[
					'label' => __( 'Header', 'archub-elementor-addons' ),
					'type' => Controls_Manager::SELECT,
					'label_block' => true,
					'default' => '',
					'options' => [
						''  => __( 'Use Global Settings', 'archub-elementor-addons' ),
						'on'  => __( 'On', 'archub-elementor-addons' ),
						'off'  => __( 'Off', 'archub-elementor-addons' ),
					],
				]
			);

			$headers = $this->get_available_custom_post( 'liquid-header' );
			if ( ! empty( $headers ) ) {
				$element->add_control(
					'header_template',
					[
						'label' => __( 'Header Template', 'archub-elementor-addons' ),
						'type' => Controls_Manager::SELECT,
						'label_block' => true,
						'options' => $headers,
						'default' => array_keys( $headers )[0],
						'save_default' => true,
						'separator' => 'after',
						'description'  => sprintf( __( 'Go to the <a href="%s" target="_blank">Headers</a> to manage your headers.', 'archub-elementor-addons' ), admin_url( 'edit.php?post_type=liquid-header' ) ),
						'condition' => [
							'header_enable_switch' => 'on',
						],
					]
				);
			} else {
				$element->add_control(
					'header_template',
					[
						'type' => Controls_Manager::RAW_HTML,
						'raw' => sprintf( __( '<strong>There are no headers in your site.</strong><br>Go to the <a href="%s" target="_blank">Headers</a> to create one.', 'archub-elementor-addons' ), admin_url( 'edit.php?post_type=liquid-header' ) ),
						'separator' => 'after',
						'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
						'condition' => [
							'header_enable_switch' => 'on',
						],
					]
				);
			}
			$element->end_controls_section();

			// Footer Options
			$element->start_controls_section(
				'lqd_post_footer_options',
				array(
					'label' => __( 'Page Footer Options', 'archub-elementor-addons' ),
					'tab'   => Controls_Manager::TAB_SETTINGS,
				)
			);

			$element->add_control(
				'lqd_post_footer_options_apply',
				[
					'label' => __( 'Apply Changes', 'archub-elementor-addons' ),
					'description' => __( 'This option allows you to see the changes without refreshing the page.', 'archub-elementor-addons' ),
					'type' => Controls_Manager::BUTTON,
					'separator' => 'after',
					'button_type' => 'success liquid-page-refresh',
					'event' => 'lqd_page_refresh',
					'text' => __( 'Apply', 'archub-elementor-addons' ),
				]
			);

			$element->add_control(
				'footer_enable_switch',
				[
					'label' => __( 'Footer', 'archub-elementor-addons' ),
					'type' => Controls_Manager::SELECT,
					'label_block' => true,
					'default' => '',
					'options' => [
						''  => __( 'Use Global Settings', 'archub-elementor-addons' ),
						'on'  => __( 'On', 'archub-elementor-addons' ),
						'off'  => __( 'Off', 'archub-elementor-addons' ),
					],
				]
			);

			$headers = $this->get_available_custom_post( 'liquid-footer' );
			if ( ! empty( $headers ) ) {
				$element->add_control(
					'footer_template',
					[
						'label' => __( 'Footer Template', 'archub-elementor-addons' ),
						'type' => Controls_Manager::SELECT,
						'label_block' => true,
						'options' => $headers,
						'default' => array_keys( $headers )[0],
						'save_default' => true,
						'separator' => 'after',
						'description'  => sprintf( __( 'Go to the <a href="%s" target="_blank">Footers</a> to manage your footers.', 'archub-elementor-addons' ), admin_url( 'edit.php?post_type=liquid-footer' ) ),
						'condition' => [
							'footer_enable_switch' => 'on',
						],
					]
				);
			} else {
				$element->add_control(
					'footer_template',
					[
						'type' => Controls_Manager::RAW_HTML,
						'raw' => sprintf( __( '<strong>There are no footers in your site.</strong><br>Go to the <a href="%s" target="_blank">Footers</a> to create one.', 'archub-elementor-addons' ), admin_url( 'edit.php?post_type=liquid-footer' ) ),
						'separator' => 'after',
						'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
						'condition' => [
							'footer_enable_switch' => 'on',
						],
					]
				);
			}
			$element->end_controls_section();
		}
		
		// Sidebar Options
		if ( $post_type === 'post' || $post_type === 'page' ){
			// Sidebar Options
			$element->start_controls_section(
				'lqd_post_sidebar_options',
				[
					'label' => __( 'Page Sidebar Options', 'archub-elementor-addons' ),
					'tab'   => Controls_Manager::TAB_SETTINGS,
				]
			);

			$element->add_control(
				'lqd_post_sidebar_options_apply',
				[
					'label' => __( 'Apply Changes', 'archub-elementor-addons' ),
					'description' => __( 'This option allows you to see the changes without refreshing the page.', 'archub-elementor-addons' ),
					'type' => Controls_Manager::BUTTON,
					'separator' => 'after',
					'button_type' => 'success liquid-page-refresh',
					'event' => 'lqd_page_refresh',
					'text' => __( 'Apply', 'archub-elementor-addons' ),
				]
			);
		
			$element->add_control(
				'liquid_sidebar_one',
				[
					'label' => __( 'Select Sidebar', 'archub-elementor-addons' ),
					'type' => Controls_Manager::SELECT,
					'label_block' => true,
					'options' => liquid_helper()->get_sidebars( array( 'none' => esc_html__( 'No Sidebar', 'archub-elementor-addons' ), 'main' => esc_html__( 'Main Sidebar', 'archub-elementor-addons' ) ) ),
					'save_default' => true,
					'separator' => 'after',
					'description'  => __( 'Select sidebar that will display on this page. Choose "No Sidebar" for full width.', 'archub-elementor-addons' ),
				]
			);

			$element->add_control(
				'liquid_sidebar_position',
				[
					'label' => __( 'Sidebar Position', 'archub-elementor-addons' ),
					'type' => Controls_Manager::CHOOSE,
					'options' => [
						'left' => [
							'title' => __( 'Left', 'archub-elementor-addons' ),
							'icon' => 'eicon-h-align-left',
						],
						'0' => [
							'title' => __( 'Use Global Settings', 'archub-elementor-addons' ),
							'icon' => 'fa fa-adjust',
						],
						'right' => [
							'title' => __( 'Right', 'archub-elementor-addons' ),
							'icon' => 'eicon-h-align-right',
						],
					],
					'default' => '0',
					'toggle' => false,
					'condition' => [
						'liquid_sidebar_one!' => [ '', 'none' ],
					],
				]
			);

			$element->add_control(
				'sidebar_widgets_style',
				[
					'label' => __( 'Sidebar Style', 'archub-elementor-addons' ),
					'type' => Controls_Manager::SELECT,
					'default' => '',
					'options' => [
						'' => __( 'Use Global Settings', 'archub-elementor-addons' ),
						'sidebar-widgets-default' => __( 'Default', 'archub-elementor-addons' ),
						'sidebar-widgets-outline' => __( 'Outline', 'archub-elementor-addons' ),
					],
					'condition' => [
						'liquid_sidebar_one!' => [ '', 'none' ],
					],
				]
			);	
			$element->end_controls_section();
		}

		// Page Title Wrapper Options
		if ( $post_type === 'post' || $post_type === 'page' || $post_type === 'liquid-portfolio' || $post_type === 'product' ) {

			if (is_archive()){
				return;
			}

			$element->start_controls_section(
				'lqd_post_titlewrapper_options',
				[
					'label' => __( 'Page Title Wrapper Options', 'archub-elementor-addons' ),
					'tab'   => Controls_Manager::TAB_SETTINGS,
				]
			);

			$element->add_control(
				'lqd_post_titlewrapper_options_apply',
				[
					'label' => __( 'Apply Changes', 'archub-elementor-addons' ),
					'description' => __( 'This option allows you to see the changes without refreshing the page.', 'archub-elementor-addons' ),
					'type' => Controls_Manager::BUTTON,
					'separator' => 'after',
					'button_type' => 'success liquid-page-refresh',
					'event' => 'lqd_page_refresh',
					'text' => __( 'Apply', 'archub-elementor-addons' ),
				]
			);

			$element->add_control(
				'title_bar_enable',
				[
					'label' => __( 'Title Wrapper', 'archub-elementor-addons' ),
					'type' => Controls_Manager::SELECT,
					'default' => '0',
					'options' => [
						'0' => __( 'Use Global Settings', 'archub-elementor-addons' ),
						'on' => __( 'On', 'archub-elementor-addons' ),
						'off' => __( 'Off', 'archub-elementor-addons' ),
					],
				]
			);

			$element->add_control(
				'title_bar_heading',
				[
					'label' => __( 'Custom Heading', 'archub-elementor-addons' ),
					'description' => __( 'Custom heading will override the default page/post title', 'archub-elementor-addons' ),
					'type' => Controls_Manager::TEXT,
					'separator' => 'before',
					'label_block' => true,
					'condition' => [
						'title_bar_enable' => 'on',
					],
				]
			);

			$element->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'title_bar_heading_typography',
					'label' => __( 'Heading Typography', 'archub-elementor-addons' ),
					'selector' => '{{WRAPPER}} .titlebar-inner h1',
					'condition' => [
						'title_bar_enable' => 'on',
					],
				]
			);

			$element->add_control(
				'title_bar_heading_typography_color',
				[
					'label' => __( 'Heading Color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .titlebar-inner h1' => 'color: {{VALUE}}',
					],
					'condition' => [
						'title_bar_enable' => 'on',
					],
				]
			);

			$element->add_control(
				'title_bar_subheading',
				[
					'label' => __( 'Sub-Heading', 'archub-elementor-addons' ),
					'description' => __( 'Custom heading will override the default page/post title', 'archub-elementor-addons' ),
					'type' => Controls_Manager::TEXT,
					'label_block' => true,
					'separator' => 'before',
					'condition' => [
						'title_bar_enable' => 'on',
					],
				]
			);

			$element->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'title_bar_subheading_typography',
					'label' => __( 'Sub-Heading Typography', 'archub-elementor-addons' ),
					'selector' => '{{WRAPPER}} .titlebar-inner p',
					'condition' => [
						'title_bar_enable' => 'on',
					],
				]
			);

			$element->add_control(
				'title_bar_subheading_typography_color',
				[
					'label' => __( 'Sub-Heading Color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .titlebar-inner p' => 'color: {{VALUE}}',
					],
					'condition' => [
						'title_bar_enable' => 'on',
					],
				]
			);


			$element->add_responsive_control(
				'title_bar_padding',
				[
					'label' => __( 'Padding', 'archub-elementor-addons' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'separator' => 'before',
					'selectors' => [
						'{{WRAPPER}} .titlebar-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition' => [
						'title_bar_enable' => 'on',
					],
				]
			);

			$element->add_control(
				'title_bar_scheme',
				[
					'label' => __( 'Color Scheme', 'archub-elementor-addons' ),
					'type' => Controls_Manager::CHOOSE,
					'separator' => 'before',
					'options' => [
						'light' => [
							'title' => __( 'Light', 'archub-elementor-addons' ),
							'icon' => 'fa fa-sun',
						],
						'dark' => [
							'title' => __( 'Dark', 'archub-elementor-addons' ),
							'icon' => 'fa fa-moon',
						],
					],
					'default' => '',
					'toggle' => true,
					'condition' => [
						'title_bar_enable' => 'on',
					],
				]
			);

			$element->add_control(
				'title_bar_align',
				[
					'label' => __( 'Alignment', 'archub-elementor-addons' ),
					'type' => Controls_Manager::CHOOSE,
					'separator' => 'before',
					'options' => [
						'text-start' => [
							'title' => __( 'Left', 'archub-elementor-addons' ),
							'icon' => 'fa fa-align-left',
						],
						'text-center' => [
							'title' => __( 'Center', 'archub-elementor-addons' ),
							'icon' => 'fa fa-align-center',
						],
						'text-end' => [
							'title' => __( 'Right', 'archub-elementor-addons' ),
							'icon' => 'fa fa-align-right',
						],
						'titlebar-split' => [
							'title' => __( 'Split', 'archub-elementor-addons' ),
							'icon' => 'fa fa-align-justify',
						],
					],
					'default' => '',
					'toggle' => true,
					'condition' => [
						'title_bar_enable' => 'on',
					],
				]
			);

			$element->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name' => 'title_bar_bg',
					'label' => __( 'Titlebar Background Color', 'archub-elementor-addons' ),
					'separator' => 'before',
					'types' => [ 'classic', 'gradient', 'image' ],
					'selector' => '{{WRAPPER}} .titlebar',
					'fields_options' => [
						'background' => [
							//'default' => 'classic',
						],
					],
					'condition' => [
						'title_bar_enable' => 'on',
					],
				]
			);

			$element->add_control(
				'title_bar_parallax',
				[
					'label' => __( 'Enable Parallax?', 'archub-elementor-addons' ),
					'description' => __( 'The background should have an image', 'archub-elementor-addons' ),
					'type' => Controls_Manager::SELECT,
					'separator' => 'before',
					'default' => 'off',
					'options' => [
						'0' => __( 'Use Global Settings', 'archub-elementor-addons' ),
						'on' => __( 'On', 'archub-elementor-addons' ),
						'off' => __( 'Off', 'archub-elementor-addons' ),
					],
					'condition' => [
						'title_bar_enable' => 'on',
					],
				]
			);

			$element->add_control(
				'title_bar_overlay',
				[
					'label' => __( 'Enable Overlay', 'archub-elementor-addons' ),
					'type' => Controls_Manager::SELECT,
					'separator' => 'before',
					'default' => 'off',
					'options' => [
						'0' => __( 'Use Global Settings', 'archub-elementor-addons' ),
						'on' => __( 'On', 'archub-elementor-addons' ),
						'off' => __( 'Off', 'archub-elementor-addons' ),
					],
					'condition' => [
						'title_bar_enable' => 'on',
					],
				]
			);

			$element->add_control(
				'title_bar_overlay_background',
				[
					'label' => __( 'Overlay Background', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .titlebar > .titlebar-overlay.lqd-overlay' => 'background: {{VALUE}}',
					],
					'condition' => [
						'title_bar_overlay!' => 'off',
					],
				]
			);

			$element->add_control(
				'title_bar_breadcrumb',
				[
					'label' => __( 'Enable Breadcrumbs', 'archub-elementor-addons' ),
					'type' => Controls_Manager::SELECT,
					'separator' => 'before',
					'default' => 'off',
					'options' => [
						'0' => __( 'Use Global Settings', 'archub-elementor-addons' ),
						'on' => __( 'On', 'archub-elementor-addons' ),
						'off' => __( 'Off', 'archub-elementor-addons' ),
					],
					'condition' => [
						'title_bar_enable' => 'on',
					],
				]
			);

			$element->add_control(
				'title_bar_breadcrumb_color',
				[
					'label' => __( 'Breadcrumbs Color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .titlebar .breadcrumbs ol, {{WRAPPER}} .inline-nav > li > a' => 'color: {{VALUE}}',
					],
					'condition' => [
						'title_bar_breadcrumb' => 'on',
					],
				]
			);

			$element->add_control(
				'title_bar_scroll',
				[
					'type' => Controls_Manager::SELECT,
					'separator' => 'before',
					'default' => 'off',
					'options' => [
						'0' => __( 'Use Global Settings', 'archub-elementor-addons' ),
						'on' => __( 'On', 'archub-elementor-addons' ),
						'off' => __( 'Off', 'archub-elementor-addons' ),
					],
					'condition' => [
						'title_bar_enable' => 'on',
					],
				]
			);

			$element->add_control(
				'title_bar_scroll_color',
				[
					'label' => __( 'Scroll Button Color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .titlebar-scroll-link' => 'color: {{VALUE}}',
					],
					'condition' => [
						'title_bar_scroll!' => 'off',
					],
				]
			);

			$element->add_control(
				'title_bar_scroll_id',
				[
					'label' => __( 'Anchor ID', 'archub-elementor-addons' ),
					'description' => __( 'Input anchor ID of the section for scroll button', 'archub-elementor-addons' ),
					'type' => Controls_Manager::TEXT,
					'condition' => [
						'title_bar_scroll!' => 'off',
					],
				]
			);
	

			$element->add_control(
				'title_bar_classes',
				[
					'label' => __( 'Extra Classes', 'archub-elementor-addons' ),
					'type' => Controls_Manager::TEXT,
					'separator' => 'before',
					'condition' => [
						'title_bar_enable' => 'on',
					],
				]
			);
	

			$element->end_controls_section();
		}

		if ( $post_type === 'post' ){
			
			$element->start_controls_section(
				'lqd_singlepost_options',
				[
					'label' => __( 'Post Options', 'archub-elementor-addons' ),
					'tab'   => Controls_Manager::TAB_SETTINGS,
				]
			);

			$element->add_control(
				'lqd_post_singlepost_options_apply',
				[
					'label' => __( 'Apply Changes', 'archub-elementor-addons' ),
					'description' => __( 'This option allows you to see the changes without refreshing the page.', 'archub-elementor-addons' ),
					'type' => Controls_Manager::BUTTON,
					'separator' => 'after',
					'button_type' => 'success liquid-page-refresh',
					'event' => 'lqd_page_refresh',
					'text' => __( 'Apply', 'archub-elementor-addons' ),
				]
			);

			$element->add_control(
				'post_style',
				[
					'label' => __( 'Single Post Style', 'archub-elementor-addons' ),
					'type' => Controls_Manager::SELECT,
					'default' => '',
					'options' => [
						''  => __( 'Use Global Settings', 'archub-elementor-addons' ),
						'default'  => __( 'Default', 'archub-elementor-addons' ),
						// 'cover'  => __( 'Cover', 'archub-elementor-addons' ),
						'modern'  => __( 'Modern', 'archub-elementor-addons' ),
						'modern-full-screen'  => __( 'Modern Full Screen', 'archub-elementor-addons' ),
						'minimal'  => __( 'Minimal', 'archub-elementor-addons' ),
						'overlay'  => __( 'Overlay', 'archub-elementor-addons' ),
						'dark'  => __( 'Dark', 'archub-elementor-addons' ),
						'classic'  => __( 'Classic', 'archub-elementor-addons' ),
						'wide'  => __( 'Wide', 'archub-elementor-addons' ),

					],
				]
			);

			$element->add_control(
				'post_extra_text',
				[
					'label' => __( 'Extra Text', 'archub-elementor-addons' ),
					'description' => __( 'Text will display near meta section', 'archub-elementor-addons' ),
					'type' => Controls_Manager::TEXT,
					'separator' => 'before',
					'condition' => [
						'post_style' => [ 'default', 'cover-spaced', 'modern' ],
						'lqd_disabled' => 'no',
					],
				]
			);

			$element->add_control(
				'liquid_post_cover_style_image',
				[
					'label' => __( 'Cover Image', 'archub-elementor-addons' ),
					'description' => __( 'Will override the featured image in single post', 'archub-elementor-addons' ),
					'type' => Controls_Manager::MEDIA,
					'separator' => 'before',
				]
			);

			$element->add_control(
				'post_parallax_enable',
				[
					'label' => __( 'Enable Parallax', 'archub-elementor-addons' ),
					'description' => __( 'Turn on parallax effect on post featured image', 'archub-elementor-addons' ),
					'type' => Controls_Manager::SELECT,
					'separator' => 'before',
					'default' => '',
					'options' => [
						''  => __( 'Default', 'archub-elementor-addons' ),
						'on'  => __( 'On', 'archub-elementor-addons' ),
						'off'  => __( 'Off', 'archub-elementor-addons' ),
					],
					'condition' => [
						'post_style' => [ 'modern', 'modern-full-screen', 'dark' ],
					],
				]
			);

			$element->add_control(
				'post_social_box_enable',
				[
					'label' => __( 'Social Sharing Box', 'archub-elementor-addons' ),
					'description' => __( 'Turn on to display the social sharing box on single posts.', 'archub-elementor-addons' ),
					'type' => Controls_Manager::SELECT,
					'separator' => 'before',
					'default' => '',
					'options' => [
						''  => __( 'Default', 'archub-elementor-addons' ),
						'on'  => __( 'On', 'archub-elementor-addons' ),
						'off'  => __( 'Off', 'archub-elementor-addons' ),
					],
				]
			);

			$element->add_control(
				'post_author_meta_enable',
				[
					'label' => __( 'Author Info Meta', 'archub-elementor-addons' ),
					'description' => __( 'Turn on to display the author meta.', 'archub-elementor-addons' ),
					'type' => Controls_Manager::SELECT,
					'separator' => 'before',
					'default' => '',
					'options' => [
						''  => __( 'Default', 'archub-elementor-addons' ),
						'on'  => __( 'On', 'archub-elementor-addons' ),
						'off'  => __( 'Off', 'archub-elementor-addons' ),
					],
				]
			);

			$element->add_control(
				'post_author_box_enable',
				[
					'label' => __( 'Author Info Box', 'archub-elementor-addons' ),
					'description' => __( 'Turn on to display the author info box below posts', 'archub-elementor-addons' ),
					'type' => Controls_Manager::SELECT,
					'separator' => 'before',
					'default' => '',
					'options' => [
						''  => __( 'Default', 'archub-elementor-addons' ),
						'on'  => __( 'On', 'archub-elementor-addons' ),
						'off'  => __( 'Off', 'archub-elementor-addons' ),
					],
				]
			);

			$element->add_control(
				'post_author_role_enable',
				[
					'label' => __( 'Author Role', 'archub-elementor-addons' ),
					'description' => __( 'Turn on to display the author role in info box below posts.', 'archub-elementor-addons' ),
					'type' => Controls_Manager::SELECT,
					'separator' => 'before',
					'default' => '',
					'options' => [
						''  => __( 'Default', 'archub-elementor-addons' ),
						'on'  => __( 'On', 'archub-elementor-addons' ),
						'off'  => __( 'Off', 'archub-elementor-addons' ),
					],
				]
			);

			$element->add_control(
				'post_navigation_enable',
				[
					'label' => __( 'Previous/Next Pagination', 'archub-elementor-addons' ),
					'description' => __( 'Turn on to display the previous/next post pagination for single posts.', 'archub-elementor-addons' ),
					'type' => Controls_Manager::SELECT,
					'separator' => 'before',
					'default' => '',
					'options' => [
						''  => __( 'Default', 'archub-elementor-addons' ),
						'on'  => __( 'On', 'archub-elementor-addons' ),
						'off'  => __( 'Off', 'archub-elementor-addons' ),
					],
				]
			);

			$element->add_control(
				'blog_archive_link',
				[
					'label' => __( 'Blog Archive URL', 'archub-elementor-addons' ),
					'description' => __( 'Custom link to post on navigation to link to the default blog archive', 'archub-elementor-addons' ),
					'type' => Controls_Manager::URL,
					'placeholder' => __( 'https://your-link.com', 'archub-elementor-addons' ),
					'show_external' => true,
					'default' => [
						'url' => '',
						'is_external' => true,
						'nofollow' => true,
					],
					'condition' => [
						'post_navigation_enable' => 'on',
					],
				]
			);

			$element->add_control(
				'post_related_enable',
				[
					'label' => __( 'Related Posts', 'archub-elementor-addons' ),
					'description' => __( 'Turn on to display related posts/projects on single posts.', 'archub-elementor-addons' ),
					'type' => Controls_Manager::SELECT,
					'separator' => 'before',
					'default' => '',
					'options' => [
						''  => __( 'Use Global Settings', 'archub-elementor-addons' ),
						'on'  => __( 'On', 'archub-elementor-addons' ),
						'off'  => __( 'Off', 'archub-elementor-addons' ),
					],
				]
			);

			$element->add_control(
				'post_related_style',
				[
					'label' => __( 'Related posts section style', 'archub-elementor-addons' ),
					'description' => __( 'Select desired style for the related posts section to display on single post', 'archub-elementor-addons' ),
					'type' => Controls_Manager::SELECT,
					'default' => '',
					'options' => [
						''  => __( 'Use Global Settings', 'archub-elementor-addons' ),
						'style-1'  => __( 'Style 1', 'archub-elementor-addons' ),
						'style-2'  => __( 'Style 2', 'archub-elementor-addons' ),
						'style-3'  => __( 'Style 3', 'archub-elementor-addons' ),
					],
					'condition' => [
						'post_related_enable!' => 'off',
					],
				]
			);

			$element->add_control(
				'post_related_title',
				[
					'label' => __( 'Related posts section title', 'archub-elementor-addons' ),
					'type' => Controls_Manager::TEXT,
					'condition' => [
						'post_related_enable!' => 'off',
					],
				]
			);

			$element->add_control(
				'post_related_number',
				[
					'label' => __( 'Number of Related Projects', 'archub-elementor-addons' ),
					'type' => Controls_Manager::NUMBER,
					'min' => 2,
					'max' => 5,
					'step' => 1,
					'default' => 2,
					'condition' => [
						'post_related_enable!' => 'off',
					],
				]
			);

			$element->add_control(
				'liquid_read_min_label',
				[
					'label' => __( 'Label Read Time', 'archub-elementor-addons' ),
					'description' => __( 'Will display the text about time needs to read the article', 'archub-elementor-addons' ),
					'type' => Controls_Manager::TEXT,
					'separator' => 'before',
				]
			);

			$element->add_control(
				'post_floating_box_enable',
				[
					'label' => __( 'Floating Box', 'archub-elementor-addons' ),
					'description' => __( 'Turn on to display floating box with share social links and admin info', 'archub-elementor-addons' ),
					'type' => Controls_Manager::SELECT,
					'separator' => 'before',
					'default' => '',
					'options' => [
						''  => __( 'Use Global Settings', 'archub-elementor-addons' ),
						'on'  => __( 'On', 'archub-elementor-addons' ),
						'off'  => __( 'Off', 'archub-elementor-addons' ),
					],
				]
			);
			
			$element->add_control(
				'post_floating_box_social_style',
				[
					'label' => __( 'Floating Box Social Style', 'archub-elementor-addons' ),
					'type' => Controls_Manager::SELECT,
					'default' => '',
					'options' => [
						''  => __( 'Use Global Settings', 'archub-elementor-addons' ),
						'default'  => __( 'Default', 'archub-elementor-addons' ),
						'with-text-outline'  => __( 'Outline Text', 'archub-elementor-addons' ),
					],
					'condition' => [
						'post_floating_box_enable!' => 'off',
					],
				]
			);

			$element->add_control(
				'post_floating_box_author_enable',
				[
					'label' => __( 'Floating Box Author', 'archub-elementor-addons' ),
					'description' => __( 'Turn on to display author info in floating box', 'archub-elementor-addons' ),
					'type' => Controls_Manager::SELECT,
					'separator' => 'before',
					'default' => '',
					'options' => [
						''  => __( 'Default', 'archub-elementor-addons' ),
						'on'  => __( 'On', 'archub-elementor-addons' ),
						'off'  => __( 'Off', 'archub-elementor-addons' ),
					],
				]
			);

			$element->end_controls_section();
		}

	}

	public function register_megamenu_options( Controls_Stack $element, $section_id ) {
		if ( 'document_settings' !== $section_id ) {
			return;
		}

		$mm_section_name = 'lqd_megamenu_options_hide';
		if ( get_post_type() === 'liquid-mega-menu' ){
			$mm_section_name = 'lqd_megamenu_options';
		} 
		$element->start_controls_section(
			$mm_section_name,
			[
				'label' => __( 'Mega Menu Options', 'archub-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_SETTINGS,
			]
		);

		$element->add_control(
			'megamenu_fullwidth',
			[
				'label' => __( 'Fullwidth megamenu?', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
			]
		);

		$element->add_control(
			'megamenu_width',
			[
				'label' => __( 'Megamenu width', 'archub-elementor-addons' ),
				'description' => __( 'Set a width for the megamenu. We try to set the megamenu width automatically, but it may not work as expected some times. You can use this option to overwrite with this option.', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'separator' => 'before',
				'size_units' => [ 'px', 'vw' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1199,
						'step' => 1,
					],
					'vw' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
			]
		);

		$element->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'megamenu_bg',
				'label' => __( 'Megamenu Background', 'archub-elementor-addons' ),
				'separator' => 'before',
				'types' => [ 'classic', 'gradient' ],
				'excludes'=> [ 'image' ],
				'selector' => '.single-liquid-mega-menu #lqd-site-content',
			]
		);

		$element->end_controls_section();
		
	}

	public function register_portfolio_options( Controls_Stack $element, $section_id ) {
		if ( 'document_settings' !== $section_id ) {
			return;
		}

		if ( get_post_type() !== 'liquid-portfolio' ) {
			return;
		}

		$element->start_controls_section(
			'lqd_portfolio_options',
			[
				'label' => __( 'Portfolio General', 'archub-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_SETTINGS,
			]
		);

		$element->add_control(
			'lqd_portfolio_options_apply',
			[
				'label' => __( 'Apply Changes', 'archub-elementor-addons' ),
				'description' => __( 'This option allows you to see the changes without refreshing the page.', 'archub-elementor-addons' ),
				'type' => Controls_Manager::BUTTON,
				'separator' => 'after',
				'button_type' => 'success liquid-page-refresh',
				'event' => 'lqd_page_refresh',
				'text' => __( 'Apply', 'archub-elementor-addons' ),
			]
		);

		$element->add_control(
			'portfolio_description',
			[
				'label' => __( 'Portfolio Description', 'archub-elementor-addons' ),
				'type' => Controls_Manager::WYSIWYG,
			]
		);

		$element->add_control(
			'portfolio_subtitle',
			[
				'label' => __( 'Subtitle', 'archub-elementor-addons' ),
				'description' => __( 'Manage the subtitle of portfolio listing', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'separator' => 'before',
			]
		);

		$element->add_control(
			'portfolio_style',
			[
				'label' => __( 'Portfolio Style', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'custom',
				'separator' => 'before',
				'options' => [
					'custom' => __( 'Custom', 'archub-elementor-addons' ),
					'default' => __( 'Basic', 'archub-elementor-addons' ),
				],
			]
		);

		$element->add_control(
			'portfolio_width',
			[
				'label' => __( 'Width', 'archub-elementor-addons' ),
				'description' => __( 'Defines the width of the featured image on the portfolio listing page', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'separator' => 'before',
				'options' => [
					'' => __( 'Default', 'archub-elementor-addons' ),
					'auto' => __( 'Auto - width determined by thumbnail width', 'archub-elementor-addons' ),
					'2' => __( '2 columns - 1/6', 'archub-elementor-addons' ),
					'3' => __( '3 columns - 1/4', 'archub-elementor-addons' ),
					'4' => __( '4 columns - 1/3', 'archub-elementor-addons' ),
					'5' => __( '5 columns - 5/12', 'archub-elementor-addons' ),
					'6' => __( '6 columns - 1/2', 'archub-elementor-addons' ),
					'7' => __( '7 columns - 7/12', 'archub-elementor-addons' ),
					'8' => __( '8 columns - 2/3', 'archub-elementor-addons' ),
					'9' => __( '9 columns - 3/4', 'archub-elementor-addons' ),
					'10' => __( '10 columns - 5/6', 'archub-elementor-addons' ),
					'11' => __( '11 columns - 11/12', 'archub-elementor-addons' ),
					'12' => __( '12 columns - 12/12', 'archub-elementor-addons' ),
				],
			]
		);

		$element->add_control(
			'_portfolio_image_size',
			[
				'label' => __( 'Crop Thumbnail Image?', 'archub-elementor-addons' ),
				'description' => __( 'Choose a dimension for your portfolio thumb. 1. The images need to regenerated after this. 2. Image resolutions need to be greater than selected resolution.', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'separator' => 'before',
				'options' => [
					'' => __( 'Select a size', 'archub-elementor-addons' ),
					'liquid-portfolio' => __( 'Default - (760 x 520)', 'archub-elementor-addons' ),
					'liquid-portfolio-sq' => __( 'Square - (760 x 640)', 'archub-elementor-addons' ),
					'liquid-portfolio-big-sq' => __( 'Bigger Square - (1520 x 1280)', 'archub-elementor-addons' ),
					'liquid-portfolio-portrait' => __( 'Vertical - (700 x 1000)', 'archub-elementor-addons' ),
					'liquid-portfolio-wide' => __( 'Horizontal - (1200 x 590)', 'archub-elementor-addons' ),
					'liquid-packery-wide' => __( 'Packery Horizontal - (1140 x 740)', 'archub-elementor-addons' ),
					'liquid-packery-portrait' => __( 'Packery Vertical - (540 x 740)', 'archub-elementor-addons' ),
				],
			]
		);
		$element->end_controls_section();

		$element->start_controls_section(
			'lqd_portfolio_meta_options',
			[
				'label' => __( 'Portfolio Meta', 'archub-elementor-addons' ),
				'tab'   => Controls_Manager::TAB_SETTINGS,
			]
		);

		$element->add_control(
			'lqd_portfolio_meta_options_apply',
			[
				'label' => __( 'Apply Changes', 'archub-elementor-addons' ),
				'description' => __( 'This option allows you to see the changes without refreshing the page.', 'archub-elementor-addons' ),
				'type' => Controls_Manager::BUTTON,
				'separator' => 'after',
				'button_type' => 'success liquid-page-refresh',
				'event' => 'lqd_page_refresh',
				'text' => __( 'Apply', 'archub-elementor-addons' ),
			]
		);

		$element->add_control(
			'portfolio_badge',
			[
				'label' => __( 'Badge', 'archub-elementor-addons' ),
				'description' => __( 'Will show badge for the style 6 of the portfolio listing', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'separator' => 'before',
			]
		);

		/* Disabled these options because don't effect anywhere
		$element->add_control(
			'portfolio_related_enable',
			[
				'label' => __( 'Related Projects', 'archub-elementor-addons' ),
				'description' => __( 'Turn on to display related projects on single portfolio posts.', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'separator' => 'before',
				'options' => [
					''  => __( 'Default', 'archub-elementor-addons' ),
					'on'  => __( 'On', 'archub-elementor-addons' ),
					'off'  => __( 'Off', 'archub-elementor-addons' ),
				],
			]
		);

		$element->add_control(
			'portfolio_related_title',
			[
				'label' => __( 'Related Works Title', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'condition' => [
					'portfolio_related_enable!' => 'off',
				],
			]
		);

		$element->add_control(
			'portfolio_related_number',
			[
				'label' => __( 'Number of Related Works', 'archub-elementor-addons' ),
				'description' => __( 'Manages the number of works that display on related works section.', 'archub-elementor-addons' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 100,
				'step' => 1,
				'default' => 3,
				'condition' => [
					'portfolio_related_enable!' => 'off',
				],
			]
		);

		$element->add_control(
			'portfolio_website_label',
			[
				'label' => __( 'Label of Button', 'archub-elementor-addons' ),
				'default' => __( 'Launch', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'separator' => 'before',
			]
		);
		*/
		
		$element->add_control(
			'portfolio_website',
			[
				'label' => __( 'External URL', 'archub-elementor-addons' ),
				'type' => Controls_Manager::URL,
				'separator' => 'before',
				'placeholder' => __( 'https://your-link.com', 'archub-elementor-addons' ),
				'show_external' => false,
				'default' => [
					'url' => '',
				],
			]
		);

		$element->add_control(
			'portfolio_attributes',
			[
				'label' => __( 'Attributes', 'archub-elementor-addons' ),
				'description' => __( 'Add custom portfolio attributes. Divide by | label with value ( Label | Value ). Each row (Enter) is a new item', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'separator' => 'before',
				'default' =>  __( 'Client | Liquid Themes', 'archub-elementor-addons' ),
			]
		);

		$element->end_controls_section();

	}

	public function tweak_siteidentity_section( $element ) {
		$element->start_injection(
			array(
				'of' => 'site_logo',
				'at' => 'before',
			)
		);

		$element->add_responsive_control(
			'logo_max_width',
			[
				'label' => __( 'Logo Max Width (px)', 'hub-elementor-addons' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 20,
				'max' => 500,
				'step' => 1,
				'selectors' => [
					'.main-header .navbar-brand' => 'max-width: {{VALUE}}px',
					'(tablet).main-header .lqd-mobile-sec .navbar-brand img' => 'max-width: {{VALUE}}px',
					'(mobile).main-header .lqd-mobile-sec .navbar-brand img' => 'max-width: {{VALUE}}px'
				]
			]
		);

		$element->add_control(
			'header_logo',
			[
				'label' => __( 'Default Logo', 'archub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
			]
		);

		$element->add_control(
			'header_logo_retina',
			[
				'label' => __( 'Retina Default Logo', 'archub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
			]
		);

		$element->add_control(
			'header_sticky_logo',
			[
				'label' => __( 'Sticky Header Logo', 'archub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
			]
		);

		$element->add_control(
			'header_sticky_logo_retina',
			[
				'label' => __( 'Sticky Header Retina Logo', 'archub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
			]
		);

		$element->add_control(
			'hover_header_logo',
			[
				'label' => __( 'Hover State of Logo', 'archub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
			]
		);

		$element->add_control(
			'hover_header_logo_retina',
			[
				'label' => __( 'Hover State of Retina Default Logo', 'archub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
			]
		);

		$element->add_control(
			'menu_logo',
			[
				'label' => __( 'Mobile Logo', 'archub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
			]
		);

		$element->add_control(
			'menu_logo_retina',
			[
				'label' => __( 'Retina Mobile Logo', 'archub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
			]
		);

		$element->add_control(
			'header_light_logo',
			[
				'label' => __( 'Light Logo', 'archub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
			]
		);

		$element->add_control(
			'header_light_logo_retina',
			[
				'label' => __( 'Retina Light Logo', 'archub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
			]
		);

		$element->add_control(
			'header_dark_logo',
			[
				'label' => __( 'Dark Logo', 'archub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
			]
		);

		$element->add_control(
			'header_dark_logo_retina',
			[
				'label' => __( 'Retina Dark Logo', 'archub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
			]
		);

		$element->add_control(
			'favicon',
			[
				'label' => __( 'Favicon', 'archub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
			]
		);

		$element->add_control(
			'iphone_icon',
			[
				'label' => __( 'Apple iPhone Icon', 'archub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
			]
		);

		$element->add_control(
			'iphone_icon_retina',
			[
				'label' => __( 'Apple iPhone Retina Icon', 'archub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
			]
		);

		$element->add_control(
			'ipad_icon',
			[
				'label' => __( 'Apple iPad Icon', 'archub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
			]
		);

		$element->add_control(
			'ipad_icon_retina',
			[
				'label' => __( 'Apple iPad Retina Icon', 'archub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
			]
		);

		$element->end_injection();
	}

	public function tweak_globalcolors_section( $element ) {
		$element->start_injection(
			array(
				'of' => 'custom_colors',
				'at' => 'after',
			)
		);

		$element->add_control(
			'primary_gradient_color_from',
			[
				'label' => __( 'Primary Gradient Start Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#007fff',
				'selectors' => [
					'body.elementor-page' => '--color-gradient-start: {{VALUE}}',
				],
			]
		);
		
		$element->add_control(
			'primary_gradient_color_to',
			[
				'label' => __( 'Primary Gradient Stop Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ff4d54',
				'selectors' => [
					'body.elementor-page' => '--color-gradient-stop: {{VALUE}}',
				],
			]
		);

		$element->end_injection();
	}

	public function tweak_breakpoints_section( $element ) {
		$element->start_injection(
			array(
				'of' => 'viewport_tablet',
				'at' => 'after',
			)
		);

		$element->add_control(
			'media_mobile_nav',
			[
				'label' => __( 'Mobile Navigation Breakpoint', 'archub-elementor-addons' ),
				'description' => __( 'Set the breakpoint for the mobile navigation', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'separator' => 'before',
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 767,
						'max' => 1199,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 1199,
				],
			]
		);

		$element->end_injection();
	}

	public function tweak_section_padding_section( $element ) {
		$element->start_injection(
			array(
				'of' => 'space_between_widgets',
				'at' => 'after',
			)
		);
		$element->add_responsive_control(
			'lqd_custom_section_padding',
			[
				'label' => __( 'Section Padding', 'archub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-section.elementor-top-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		

		$element->end_injection();
	}

	public function tweak_typography_section( $element ) {
		// Blog post typography
		$element->start_injection(
			array(
				'of' => 'paragraph_spacing',
				'at' => 'after',
			)
		);

		$element->add_control(
			'lqd_blog_post_typography_heading',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Single Post' , 'archub-elementor-addons'),
				'separator' => 'before',
			]
		);

		$element->add_control(
			'lqd_blog_post_typography_color',
			[
				'label' => __( 'Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'dynamic' => [],
				'selectors' => [
					'{{WRAPPER}} .lqd-post-content,{{WRAPPER}} .lqd-post-header .entry-excerpt' => 'color: {{VALUE}};',
				],
			]
		);

		$element->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'lqd_blog_post_typography',
				'label' => __( 'Typography', 'archub-elementor-addons' ),
				'description' => __( 'Manage the typography of single post text.' , 'archub-elementor-addons'),
				'selector' => '{{WRAPPER}} .lqd-post-content,{{WRAPPER}} .lqd-post-header .entry-excerpt', 
			]
		);

		$element->end_injection();

		// Headings
		$element->start_injection(
			array(
				'of' => 'paragraph_spacing',
				'at' => 'after',
			)
		);

		$this->add_element_controls(
			$element,
			__( 'H1', 'archub-elementor-addons' ),
			'lqd_h1',
			'h1, .h1',
			'#181b31',
			array(
				'typography' => ['default' => 'yes'],
				'font_size' => ['default' => ['size' => 52]],
				'font_weight' => ['default' => 600],
				'line_height' => ['default' => ['size' => 1.2, 'unit' => 'em']],
			)
		);
		$this->add_element_controls(
			$element,
			__( 'H2', 'archub-elementor-addons' ),
			'lqd_h2',
			'h2, .h2',
			'#181b31',
			array(
				'typography' => ['default' => 'yes'],
				'font_size' => ['default' => ['size' => 40]],
				'font_weight' => ['default' => 600],
				'line_height' => ['default' => ['size' => 1.2, 'unit' => 'em']],
			)
		);
		$this->add_element_controls(
			$element,
			__( 'H3', 'archub-elementor-addons' ),
			'lqd_h3',
			'h3, .h3',
			'#181b31',
			array(
				'typography' => ['default' => 'yes'],
				'font_size' => ['default' => ['size' => 32]],
				'font_weight' => ['default' => 600],
				'line_height' => ['default' => ['size' => 1.2, 'unit' => 'em']],
			)
		);
		$this->add_element_controls(
			$element,
			__( 'H4', 'archub-elementor-addons' ),
			'lqd_h4',
			'h4, .h4',
			'#181b31',
			array(
				'typography' => ['default' => 'yes'],
				'font_size' => ['default' => ['size' => 25]],
				'font_weight' => ['default' => 600],
				'line_height' => ['default' => ['size' => 1.2, 'unit' => 'em']],
			)
		);
		$this->add_element_controls(
			$element,
			__( 'H5', 'archub-elementor-addons' ),
			'lqd_h5',
			'h5, .h5',
			'#181b31',
			array(
				'typography' => ['default' => 'yes'],
				'font_size' => ['default' => ['size' => 21]],
				'font_weight' => ['default' => 600],
				'line_height' => ['default' => ['size' => 1.2, 'unit' => 'em']],
			)
		);
		$this->add_element_controls(
			$element,
			__( 'H6', 'archub-elementor-addons' ),
			'lqd_h6',
			'h6, .h6',
			'#181b31',
			array(
				'typography' => ['default' => 'yes'],
				'font_size' => ['default' => ['size' => 18]],
				'font_weight' => ['default' => 600],
				'line_height' => ['default' => ['size' => 1.2, 'unit' => 'em']],
			)
		);

		$element->end_injection();
	}

	public function register_dark_typography_section( Controls_Stack $element, $section_id ) {

		$element->start_controls_section(
			'lqd_dark_typo_section',
			[
				'label' => __( 'Dark Pages Typography', 'archub-elementor-addons' ),
				'tab' => 'theme-style-typography',
			]
		);

		$element->add_control(
			'lqd_dark_body_heading',
			[
				'type' => Controls_Manager::HEADING,
				'label' => esc_html__( 'Body', 'elementor' ),
			]
		);

		$element->add_control(
			'lqd_dark_body_color',
			[
				'label' => esc_html__( 'Text Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'dynamic' => [],
				'default' => 'rgba(255, 255, 255, 0.8)',
				'selectors' => [
					'.page-scheme-dark' => 'color: {{VALUE}};',
				],
			]
		);

		$element->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => esc_html__( 'Typography', 'elementor' ),
				'name' => 'lqd_dark_body_typography',
				'selector' => '.page-scheme-dark',
			]
		);

		$element->add_responsive_control(
			'lqd_dark_paragraph_spacing',
			[
				'label' => esc_html__( 'Paragraph Spacing', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'.page-scheme-dark p' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
					'em' => [
						'min' => 0.1,
						'max' => 20,
					],
					'vh' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units' => [ 'px', 'em', 'vh' ],
			]
		);
		
		$this->add_element_controls( $element, __( 'H1', 'archub-elementor-addons' ), 'lqd_h1_dark', '.page-scheme-dark h1, .page-scheme-dark .h1', '#ffffff' );
		$this->add_element_controls( $element, __( 'H2', 'archub-elementor-addons' ), 'lqd_h2_dark', '.page-scheme-dark h2, .page-scheme-dark .h2', '#ffffff' );
		$this->add_element_controls( $element, __( 'H3', 'archub-elementor-addons' ), 'lqd_h3_dark', '.page-scheme-dark h3, .page-scheme-dark .h3', '#ffffff' );
		$this->add_element_controls( $element, __( 'H4', 'archub-elementor-addons' ), 'lqd_h4_dark', '.page-scheme-dark h4, .page-scheme-dark .h4', '#ffffff' );
		$this->add_element_controls( $element, __( 'H5', 'archub-elementor-addons' ), 'lqd_h5_dark', '.page-scheme-dark h5, .page-scheme-dark .h5', '#ffffff' );
		$this->add_element_controls( $element, __( 'H6', 'archub-elementor-addons' ), 'lqd_h6_dark', '.page-scheme-dark h6, .page-scheme-dark .h6', '#ffffff' );

		$element->add_control(
			'lqd_blog_post_dark_typography_heading',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Single Post' , 'archub-elementor-addons'),
				'separator' => 'before',
			]
		);

		$element->add_control(
			'lqd_blog_post_dark_typography_color',
			[
				'label' => __( 'Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'dynamic' => [],
				'selectors' => [
					'.page-scheme-dark .lqd-post-content, .page-scheme-dark .lqd-post-header .entry-excerpt' => 'color: {{VALUE}};',
				],
			]
		);

		$element->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'lqd_blog_post_dark_typography',
				'label' => __( 'Typography', 'archub-elementor-addons' ),
				'description' => __( 'Manage the typography of single post text.' , 'archub-elementor-addons'),
				'selector' => ' .lqd-post-content, .page-scheme-dark .lqd-post-header .entry-excerpt', 
			]
		);

		$element->add_control(
			'lqd_dark_link_heading',
			[
				'type' => Controls_Manager::HEADING,
				'label' => esc_html__( 'Link', 'elementor' ),
				'separator' => 'before',
			]
		);

		$element->start_controls_tabs( 'lqd_dark_tabs_link_style' );

		$element->start_controls_tab(
			'lqd_dark_tab_link_normal',
			[
				'label' => esc_html__( 'Normal', 'elementor' ),
			]
		);

		$element->add_control(
			'lqd_dark_link_normal_color',
			[
				'label' => esc_html__( 'Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'dynamic' => [],
				'selectors' => [
					'.page-scheme-dark a' => 'color: {{VALUE}};',
				],
			]
		);

		$element->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => esc_html__( 'Typography', 'elementor' ),
				'name' => 'llqd_dark_ink_normal_typography',
				'selector' => '.page-scheme-dark a',
			]
		);

		$element->end_controls_tab();

		$element->start_controls_tab(
			'lqd_dark_tab_link_hover',
			[
				'label' => esc_html__( 'Hover', 'elementor' ),
			]
		);

		$element->add_control(
			'lqd_dark_link_hover_color',
			[
				'label' => esc_html__( 'Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'dynamic' => [],
				'selectors' => [
					'.page-scheme-dark a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$element->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => esc_html__( 'Typography', 'elementor' ),
				'name' => 'lqd_dark_link_hover_typography',
				'selector' => '.page-scheme-dark a:hover',
			]
		);

		$element->end_controls_tab();
		$element->end_controls_tabs();
		$element->end_controls_section();
	}

	private function add_element_controls( $element, $label, $prefix, $selector, $default_color = '#181b31', $defaults_typo = [] ) {
		$element->add_control(
			$prefix . '_heading',
			[
				'type' => Controls_Manager::HEADING,
				'label' => $label,
				'separator' => 'before',
			]
		);

		$element->add_control(
			$prefix . '_color',
			[
				'label' => __( 'Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'dynamic' => [],
				'default' => $default_color,
				'selectors' => [
					$selector => 'color: {{VALUE}};',
				],
			]
		);

		$typo_options = [
			'label' => __( 'Typography', 'archub-elementor-addons' ),
			'name' => $prefix . '_typography',
			'selector' => $selector,
		];

		if ( ! empty( $defaults_typo ) ) {
			$typo_options['fields_options'] = $defaults_typo;
		}

		$element->add_group_control(
			Group_Control_Typography::get_type(),
			$typo_options
		);
	}

	public function tweak_background_section( $element ) {

		$element->start_injection(
			array(
				'of' => 'mobile_browser_background',
				'at' => 'before',
			)
		);

		$element->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'lqd_body_background',
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}}',
				'fields_options' => [
					'background' => [
						'frontend_available' => true,
					],
				],
				'selector' => '#lqd-site-content',
			]
		);

		$element->end_injection();
	}
	
	public function register_custom_css_section( Controls_Stack $element, $section_id ) {

		$element->start_controls_section(
			'lqd_custom_css_section',
			[
				'label' => __( 'Custom CSS', 'archub-elementor-addons' ),
				'tab' => 'settings-custom-css',
			]
		);

		$element->add_control(
			'lqd_custom_css',
			[
				'type' => Controls_Manager::CODE,
				'language' => 'css'
			]
		);
	
		$element->end_controls_section();
	}

	public function lqd_add_custom_css( $post_css ) {

		$custom_css = \Elementor\Plugin::$instance->kits_manager->get_active_kit_for_frontend()->get_settings_for_display('lqd_custom_css');

		$custom_css = trim( $custom_css );

		if ( empty( $custom_css ) ) {
			return;
		}

		// Add a css comment
		$custom_css = '/* Start Liquid custom CSS */' . $custom_css . '/* End Liquid custom CSS */';

		$post_css->get_stylesheet()->add_raw_css( $custom_css );
	}

	private function get_available_menus() {
		$menus = wp_get_nav_menus();
		$options = ['' => "Use Global Settings"] ;
		foreach ( $menus as $menu ) {
			$options[ $menu->slug ] = $menu->name;
		}
		return $options;
	}

	private function get_available_custom_post( $type ) {
		$posts = get_posts( array(
			'post_type' => $type,
			'posts_per_page' => -1,
		) );

		$options = [];
	
		foreach ( $posts as $post ) {
		  $options[ $post->ID ] = $post->post_title;
		}
	
		return $options;
	}

    
}

new LD_Global_Controls();
