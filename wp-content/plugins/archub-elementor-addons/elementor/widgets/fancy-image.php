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
use Elementor\Group_Control_Css_Filter;
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
class LD_Fancy_Image extends Widget_Base {

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
		return 'ld_fancy_image';
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
		return __( 'Liquid Image', 'archub-elementor-addons' );
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
		return 'eicon-image lqd-element';
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
		return [ 'image', 'fancy', 'gallery'  ];
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
			return [ 'jquery-fresco', 'fresco', 'threejs', 'liquid-interactive-swap' ];
		} else {
			return [''];
		}
		
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
			return [ 'fresco' ];
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
			'image',
			[
				'label' => __( 'Image', 'archub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail', // // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'exclude' => [ 
					'liquid-style1-lb',
					'liquid-style3-lb',
					'liquid-style4-lb',
					'liquid-style5-lb',
					'liquid-style6-lb',
					'liquid-style6-alt-lb',
					'liquid-style7-lb',
					'liquid-style9-lb',
					'liquid-style13-lb',
					'liquid-style16-lb',
					'liquid-style18-lb',
					'liquid-style19-lb',
					'liquid-style20-lb',
					'liquid-style21-lb',
					'liquid-style3-sp',
					'liquid-style3-pf',
					'liquid-style4-pf',
					'liquid-style6-pf',
					'liquid-portfolio',
					'liquid-portfolio-sq',
					'liquid-portfolio-big-sq',
					'liquid-portfolio-portrait',
					'liquid-portfolio-wide',
					'liquid-packery-wide',
					'liquid-packery-portrait',
				 ],
				'include' => [],
				'default' => 'full',
			]
		);
		
		$this->add_responsive_control(
			'fi_width',
			[
				'label' => esc_html__( 'Width', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'size_units' => [ '%', 'px', 'vw' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
					'vw' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} img' => 'width: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'fi_space',
			[
				'label' => esc_html__( 'Max Width', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => '%',
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'size_units' => [ '%', 'px', 'vw' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
					'vw' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} img' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'fi_height',
			[
				'label' => esc_html__( 'Height', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
				],
				'tablet_default' => [
					'unit' => 'px',
				],
				'mobile_default' => [
					'unit' => 'px',
				],
				'size_units' => [ 'px', 'vh' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 500,
					],
					'vh' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} img' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'fi_object-fit',
			[
				'label' => esc_html__( 'Object Fit', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'condition' => [
					'fi_height[size]!' => '',
				],
				'options' => [
					'' => esc_html__( 'Default', 'archub-elementor-addons' ),
					'fill' => esc_html__( 'Fill', 'archub-elementor-addons' ),
					'cover' => esc_html__( 'Cover', 'archub-elementor-addons' ),
					'contain' => esc_html__( 'Contain', 'archub-elementor-addons' ),
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} img' => 'object-fit: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_align',
			[
				'label' => __( 'Alignment', 'archub-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'archub-elementor-addons' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'archub-elementor-addons' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'archub-elementor-addons' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
				'separator' => 'before'
			]
		);

		$this->add_control(
			'img_link',
			[
				'label' => __( 'Link', 'archub-elementor-addons' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'archub-elementor-addons' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => false,
				],
				'separator' => 'before'
			]
		);

		$this->add_control(
			'fi_overflow',
			[
				'label' => __( 'Overflow', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => __( 'Default', 'archub-elementor-addons' ),
					'hidden' => __( 'Hidden', 'archub-elementor-addons' ),
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .lqd-imggrp-img-container' => 'overflow: {{VALUE}}'
				],
				'separator' => 'before'
			]
		);

		$this->end_controls_section();
		
		// Opacity
		$this->start_controls_section(
			'opacity_section',
			[
				'label' => __( 'Opacity', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'fi_opacity',
			[
				'label' => __( 'Opacity', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.05,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-imggrp-single' => 'opacity: {{SIZE}}',
				],
				'separator' => 'before'
			]
		);

		$this->add_control(
			'fi_hover_opacity',
			[
				'label' => __( 'Hover opacity', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.05,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-imggrp-single:hover' => 'opacity: {{SIZE}}',
				],
			]
		);

		$this->end_controls_section();
		
		// Hover transform
		$this->start_controls_section(
			'transform_section',
			[
				'label' => __( 'Hover transform', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'fi_scale_hover',
			[
				'label' => __( 'Hover scale', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 5,
						'step' => 0.05,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-imggrp-img-container:hover figure' => 'transform: scale({{SIZE}});',
				],
			]
		);

		$this->end_controls_section();
		
		// Lightbox
		$this->start_controls_section(
			'lightbox_section',
			[
				'label' => __( 'Lightbox', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'enable_lightbox',
			[
				'label' => __( 'Enable lightbox', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'lightbox_group_id',
			[
				'label' => __( 'Lightbox groupd id', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter a lightbox group id', 'archub-elementor-addons' ),
				'condition' => [
					'enable_lightbox' => 'yes'
				]
			]
		);

		$this->end_controls_section();
		
		// Interactive swap
		$this->start_controls_section(
			'interactive_swap_section',
			[
				'label' => __( 'Interactive swap', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'enable_interactive_swap',
			[
				'label' => __( 'Enable interactive swap', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'interactive_swap_image',
			[
				'label' => __( 'Image', 'archub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'enable_interactive_swap' => 'yes'
				],
			]
		);

		$this->add_control(
			'interactive_swap_disp',
			[
				'label' => __( 'Displacement map', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'disp7.jpg',
				'options' => [
					'disp1.jpg' => __( 'Displacement 1', 'archub-elementor-addons' ),
					'disp2.jpg' => __( 'Displacement 2', 'archub-elementor-addons' ),
					'disp3.jpg' => __( 'Displacement 3', 'archub-elementor-addons' ),
					'disp4.jpg' => __( 'Displacement 4', 'archub-elementor-addons' ),
					'disp5.jpg' => __( 'Displacement 5', 'archub-elementor-addons' ),
					'disp6.jpg' => __( 'Displacement 6', 'archub-elementor-addons' ),
					'disp7.jpg' => __( 'Displacement 7', 'archub-elementor-addons' ),
					'disp8.jpg' => __( 'Displacement 8', 'archub-elementor-addons' ),
					'disp9.jpg' => __( 'Displacement 9', 'archub-elementor-addons' ),
				],
				'condition' => [
					'enable_interactive_swap' => 'yes'
				],
			]
		);

		$this->add_control(
			'interactive_swap_intensity',
			[
				'label' => esc_html__( 'Interactive swap intensity', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 10,
						'step' => 0.1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0.15,
				],
				'condition' => [
					'enable_interactive_swap' => 'yes'
				],
			]
		);

		$this->end_controls_section();
		
		// Roundness
		$this->start_controls_section(
			'roundness_section',
			[
				'label' => __( 'Roundness', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'enable_roudness',
			[
				'label' => __( 'Add roundness?', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'image_roudness',
			[
				'label' => __( 'Border radius', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '2px',
				'options' => [
					'2px' => __( '2px', 'archub-elementor-addons' ),
					'4px' => __( '4px', 'archub-elementor-addons' ),
					'6px' => __( '6px', 'archub-elementor-addons' ),
					'8px' => __( '8px', 'archub-elementor-addons' ),
					'50em' => __( '50em (Circle)', 'archub-elementor-addons' ),
					'custom' => __( 'Custom', 'archub-elementor-addons' ),
				],
				'condition' => [
					'enable_roudness' => 'yes'
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-imggrp-img-container' => 'border-radius: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'custom_roundness',
			[
				'label' => __( 'Custom roundness', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'condition' => [
					'image_roudness' => 'custom'
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-imggrp-img-container' => 'border-radius: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		// Shadow
		$this->start_controls_section(
			'shadow_section',
			[
				'label' => __( 'Shadow', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'enable_image_shadow',
			[
				'label' => __( 'Add shadow?', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'shadow_style',
			[
				'label' => __( 'Shadow', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '1',
				'options' => [
					'1' => __( 'Shadow Depth 1', 'archub-elementor-addons' ),
					'2' => __( 'Shadow Depth 2', 'archub-elementor-addons' ),
					'3' => __( 'Shadow Depth 3', 'archub-elementor-addons' ),
					'4' => __( 'Shadow Depth 4', 'archub-elementor-addons' ),
					'custom' => __( 'Custom', 'archub-elementor-addons' ),
				],
				'condition' => [
					'enable_image_shadow' => 'yes'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'custom_box_shadow',
				'label' => __( 'Box shadow', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-imggrp-single:not([data-animate-shadow=true]) .lqd-imggrp-img-container, {{WRAPPER}} .lqd-imggrp-single[data-animate-shadow=true].is-in-view .lqd-imggrp-img-container',
				'condition' => [
					'enable_image_shadow' => 'yes',
					'shadow_style' => 'custom'
				]
			]
		);

		$this->add_control(
			'enable_animated_shadow',
			[
				'label' => __( 'Animate shadow?', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
				'condition' => [
					'enable_image_shadow' => 'yes'
				]
			]
		);

		$this->add_control(
			'shadow_delay',
			[
				'label' => __( 'Delay in (ms)', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'condition' => [
					'enable_animated_shadow' => 'yes'
				]
			]
		);

		$this->end_controls_section();

		// Reveal effect
		$this->start_controls_section(
			'reveal_effect_section',
			[
				'label' => __( 'Reveal effect', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'enable_reveal',
			[
				'label' => __( 'Reveal effect', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'reveal_color',
				'label' => __( 'Background', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .block-revealer__element',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
				'condition' => [
					'enable_reveal' => 'yes'
				]
			]
		);

		$this->add_control(
			'reveal_direction',
			[
				'label' => __( 'Direction', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'lr',
				'options' => [
					'lr' => __( 'Left - Right', 'archub-elementor-addons' ),
					'tb' => __( 'Top - Bottom', 'archub-elementor-addons' ),
					'rl' => __( 'Right - Left', 'archub-elementor-addons' ),
					'bt' => __( 'Bottom - Top', 'archub-elementor-addons' ),
				],
				'condition' => [
					'enable_reveal' => 'yes'
				]
			]
		);

		$this->add_control(
			'reveal_initial_cover_area_x',
			[
				'label' => esc_html__( 'Initial cover area', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .block-revealer__element' => 'transform: scaleX(calc( {{SIZE}} / 100 ));',
				],
				'condition' => [
					'enable_reveal' => 'yes',
					'reveal_direction' => ['lr', 'rl']
				]
			]
		);

		$this->add_control(
			'reveal_initial_cover_area_y',
			[
				'label' => esc_html__( 'Initial cover area', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .block-revealer__element' => 'transform: scaleY(calc( {{SIZE}} / 100 ));',
				],
				'condition' => [
					'enable_reveal' => 'yes',
					'reveal_direction' => ['tb', 'bt']
				]
			]
		);

		$this->add_control(
			'reveal_delay',
			[
				'label' => __( 'Delay in (ms)', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'condition' => [
					'enable_reveal' => 'yes'
				]
			]
		);

		$this->end_controls_section();
		
		// Floating effect
		$this->start_controls_section(
			'floating_section',
			[
				'label' => __( 'Floating effect', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'enable_float_effect',
			[
				'label' => __( 'Floating effect?', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'float_animate_from',
			[
				'label' => __( 'Float animate from', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => '0%',
				'condition' => [
					'enable_float_effect' => 'yes'
				],
				'render_type' => 'template',
				'selectors' => [
					'{{WRAPPER}} .lqd-imggrp-single[data-float]' => '--float-animate-from: {{VALUE}}'
				]
			]
		);

		$this->add_control(
			'float_animate_to',
			[
				'label' => __( 'Float animate to', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => '3%',
				'condition' => [
					'enable_float_effect' => 'yes'
				],
				'render_type' => 'template',
				'selectors' => [
					'{{WRAPPER}} .lqd-imggrp-single[data-float]' => '--float-animate-to: {{VALUE}}'
				]
			]
		);

		$this->add_control(
			'float_delay',
			[
				'label' => __( 'Float delay', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => '0s',
				'condition' => [
					'enable_float_effect' => 'yes'
				],
				'render_type' => 'template',
				'description' => __( 'Float starting delay. value can be in seconds or milliseconds. e.g. 0.5s or 500ms.', 'archub-elementor-addons' ),
				'selectors' => [
					'{{WRAPPER}} .lqd-imggrp-single[data-float]' => '--float-delay: {{VALUE}}'
				]
			]
		);

		$this->add_control(
			'float_easing',
			[
				'label' => __( 'Float easing', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'ease',
				'options' => [
					'ease' => __( 'Ease', 'archub-elementor-addons' ),
					'ease-in' => __( 'Ease In', 'archub-elementor-addons' ),
					'ease-out' => __( 'Ease Out', 'archub-elementor-addons' ),
					'ease-in-out' => __( 'Ease In Out', 'archub-elementor-addons' ),
					'custom_ease' => __( 'Custom Ease', 'archub-elementor-addons' ),
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-imggrp-single[data-float]' => '--float-animation-ease: {{VALUE}}'
				],
				'condition' => [
					'enable_float_effect' => 'yes'
				]
			]
		);

		$this->add_control(
			'float_custom_ease',
			[
				'label' => __( 'Custom float easing', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'selectors' => [
					'{{WRAPPER}} .lqd-imggrp-single[data-float]' => '--float-animation-ease: {{VALUE}}'
				],
				'condition' => [
					'float_easing' => 'custom_ease'
				]
			]
		);

		$this->end_controls_section();
		
		// Hover 3D
		$this->start_controls_section(
			'hover3d_section',
			[
				'label' => __( 'Hover 3d', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'enable_hover3d',
			[
				'label' => __( 'Enable hover 3d?', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'hover3d_stacking_factor',
			[
				'label' => __( 'Intensity', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => '1',
				'condition' => [
					'enable_hover3d' => 'yes'
				]
			]
		);

		$this->add_control(
			'hover3d_perspective',
			[
				'label' => __( 'Perspective value', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => '1200px',
				'selectors' => [
					'{{WRAPPER}} .elementor-widget-container' => 'perspective: {{VALUE}}'
				],
				'condition' => [
					'enable_hover3d' => 'yes'
				]
			]
		);

		$this->end_controls_section();
		
		// Custom cursor
		$this->start_controls_section(
			'custom_cursor_section',
			[
				'label' => __( 'Custom cursor', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'custom_cursor_style',
			[
				'label' => __( 'Custom cursor style', 'archub-elementor-addons' ),
				'description' => __( 'Select custom cursor style when hovering over the fancy image link or the lightbox link.', 'archub-elementor-addons' ),
				'label_block' => true,
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
			'cc_icon_color',
			[
				'label' => __( 'Custom cursor icon color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'custom_cursor_style' => [ 'lqd-cc-icon-trigger' ]
				],
			]
		);

		$this->end_controls_section();
		
		// CSS Filters
		$this->start_controls_section(
			'fi_css_filters_section',
			[
				'label' => __( 'CSS Filters', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'fi_css_filters',
				'label' => esc_html__( 'CSS filters', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} img',
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'fi_css_filters_hover',
				'label' => esc_html__( 'Hover CSS filters', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-imggrp-single:hover img',
			]
		);

		$this->end_controls_section();

		// Overlay Lines
		$this->start_controls_section(
			'oberlay_lines_section',
			[
				'label' => __( 'Overlay lines', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'enable_lines',
			[
				'label' => __( 'Add lines', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'lines_count',
			[
				'label' => __( 'Side label', 'archub-elementor-addons' ),
				'default' => '3',
				'type' => Controls_Manager::TEXT,
				'condition' => [
					'enable_lines' => 'yes'
				]
			]
		);

		$this->add_control(
			'lines_color',
			[
				'label' => __( 'Lines color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-v-line div' => 'background: {{VALUE}}',
				],
				'condition' => [
					'enable_lines' => 'yes'
				]
			]
		);
		$this->end_controls_section();

		// Overlay Background
		$this->start_controls_section(
			'overlay_bg_section',
			[
				'label' => __( 'Overlay background', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'enable_overlay_bg',
			[
				'label' => __( 'Add overlay background', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'overlay_bg',
				'label' => __( 'Background', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .lqd-imggrp-overlay-bg',
				'condition' => [
					'enable_overlay_bg' => 'yes'
				]
			]
		);

		$this->add_control(
			'overlay_bg_mix_blend_mode',
			[
				'label' => esc_html__( 'Mix blend mode', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'Normal', 'archub-elementor-addons' ),
					'multiply' => esc_html__( 'Multiply', 'archub-elementor-addons' ),
					'screen' => esc_html__( 'Screen', 'archub-elementor-addons' ),
					'overlay' => esc_html__( 'Overlay', 'archub-elementor-addons' ),
					'darken' => esc_html__( 'Darken', 'archub-elementor-addons' ),
					'lighten' => esc_html__( 'Lighten', 'archub-elementor-addons' ),
					'color-dodge' => esc_html__( 'Color Dodge', 'archub-elementor-addons' ),
					'color-burn' => esc_html__( 'Color Burn', 'archub-elementor-addons' ),
					'hard-light' => esc_html__( 'Hard Light', 'archub-elementor-addons' ),
					'soft-light' => esc_html__( 'Soft Light', 'archub-elementor-addons' ),
					'difference' => esc_html__( 'Difference', 'archub-elementor-addons' ),
					'exclusion' => esc_html__( 'Exclusion', 'archub-elementor-addons' ),
					'hue' => esc_html__( 'Hue', 'archub-elementor-addons' ),
					'saturation' => esc_html__( 'Saturation', 'archub-elementor-addons' ),
					'color' => esc_html__( 'Color', 'archub-elementor-addons' ),
					'luminosity' => esc_html__( 'Luminosity', 'archub-elementor-addons' ),
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .lqd-imggrp-overlay-bg' => 'mix-blend-mode: {{VALUE}};',
				],
				'condition' => [
					'enable_overlay_bg' => 'yes'
				]
			]
		);

		$this->end_controls_section();

		// Side Label
		$this->start_controls_section(
			'sidelabel_section',
			[
				'label' => __( 'Side label', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'enable_side_label',
			[
				'label' => __( 'Add side label', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);
		
		$this->add_control(
			'label',
			[
				'label' => __( 'Side label', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'condition' => [
					'enable_side_label' => 'yes'
				]
			]
		);

		$this->add_control(
			'label_side',
			[
				'label' => __( 'Content alignment', 'archub-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'lqd-imggrp-content-fixed-left' => [
						'title' => __( 'Left', 'archub-elementor-addons' ),
						'icon' => 'eicon-h-align-left',
					],
					'lqd-imggrp-content-fixed-right' => [
						'title' => __( 'Right', 'archub-elementor-addons' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => 'lqd-imggrp-content-fixed-left',
				'toggle' => false,
				'condition' => [
					'enable_side_label' => 'yes'
				]
			]
		);

		$this->add_control(
			'label_pos',
			[
				'label' => __( 'Content position', 'archub-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start' => [
						'title' => __( 'Start', 'archub-elementor-addons' ),
						'icon' => 'eicon-v-align-top',
					],
					'center' => [
						'title' => __( 'Center', 'archub-elementor-addons' ),
						'icon' => 'eicon-v-align-middle',
					],
					'end' => [
						'title' => __( 'End', 'archub-elementor-addons' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'default' => 'center',
				'toggle' => false,
				'condition' => [
					'enable_side_label' => 'yes',
					'enable_side_label_overlay' => '',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'label_typography',
				'label' => __( 'Typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-imggrp-content',
				'condition' => [
					'enable_side_label' => 'yes'
				]
			]
		);

		$this->add_control(
			'enable_side_label_overlay',
			[
				'label' => __( 'Side label overlay', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'lqd-imggrp-content-fixed-in',
				'default' => '',
				'condition' => [
					'enable_side_label' => 'yes'
				]
			]
		);
		
		$this->add_control(
			'label_color',
			[
				'label' => __( 'Label color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-imggrp-content-fixed-left,{{WRAPPER}} .lqd-imggrp-content-fixed-right' => 'color: {{VALUE}}',
				],
				'condition' => [
					'enable_side_label' => 'yes'
				]
			]
		);

		$this->add_control(
			'label_overlay_bgcolor',
			[
				'label' => __( 'Overlay background color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-imggrp-content-fixed-in' => 'background: {{VALUE}}',
				],
				'condition' => [
					'enable_side_label' => 'yes',
					'enable_side_label_overlay!' => ''
				]
			]
		);


		$this->end_controls_section();

	}

	protected function get_data_options() {
		$settings = $this->get_settings_for_display();
		
		$opts = array();
		
		$shadow = $settings['enable_image_shadow'];
		$shadow_style = $settings['shadow_style'];
		$shadow_delay = $settings['shadow_delay'];
		$hover3d = $settings['enable_hover3d'];
		$enable_animated_shadow = $settings['enable_animated_shadow'];

		if( $settings['enable_image_shadow'] ) {
			$opts[] = 'data-shadow-style="' . $shadow_style . '"';
		}

		if( $enable_animated_shadow ) {
			$opts[] = 'data-inview="true"';
			if( ! empty( $shadow_delay ) && isset( $shadow_delay ) ) {
				$opts[] = 'data-inview-options=\'' . wp_json_encode( array( 'delayTime' => (int)$shadow_delay ) ) . '\'';
			}
			$opts[] = 'data-animate-shadow="true"';	
		}
		
		if( $hover3d ) {
			$opts[] = 'data-hover3d="true"';
		}
		
		if( empty( $opts ) ) {
			return;
		}
		
		return implode( ' ', $opts );	
	}

	protected function get_data_float_effect() {
		$settings = $this->get_settings_for_display();
		
		$enable_float_effect = $settings['enable_float_effect'];
		$float_easing = $settings['float_easing'];
		$float_custom_ease = $settings['float_custom_ease'];
		
		$easing = $float_easing;
		
		if( $float_easing === 'custom_ease' && ! empty($float_custom_ease) ) {
			$easing = $float_custom_ease;
		}

		if ( $enable_float_effect ) {
			return 'data-float="' . $easing . '"';
		}
		
	}

	protected function get_data_stacking_factor() {
		$settings = $this->get_settings_for_display();
		
		$hover3d = $settings['enable_hover3d'];
		$hover3d_stacking_factor = $settings['hover3d_stacking_factor'];
		
		if( $hover3d === 'yes' ) {
			return 'data-stacking-factor="' . $hover3d_stacking_factor . '"';
		}
		
	}

	protected function get_reveal_data() {
		
		$settings = $this->get_settings_for_display();
		
		$reveal = $settings['enable_reveal'];

		$data = array();

		if( $reveal ) {

			$reveal_opts = array(
				'direction' => $settings['reveal_direction'],
				'appendMarkup' => false,
			);
			
			if ( isset( $settings['reveal_delay'] ) && ! empty( $settings['reveal_delay'] ) ) {
				$reveal_opts['delay'] = $settings['reveal_delay'];
			}

			if ( $settings['reveal_direction'] === 'lr' || $settings['reveal_direction'] === 'rl' ) {
				$reveal_opts['initialCoverArea'] = $settings['reveal_initial_cover_area_x']['size'];
			} else {
				$reveal_opts['initialCoverArea'] = $settings['reveal_initial_cover_area_y']['size'];
			}

			if ( $reveal_opts['initialCoverArea'] === 100 ) {
				$reveal_opts['isContentHidden'] = false;
				$reveal_opts['duration'] = 2;
			}

			$data[] = 'data-reveal="true"';
			$data[] = 'data-reveal-options=\'' . wp_json_encode( $reveal_opts ) . '\'';

		}

		if ( empty( $data ) ) {
			return;
		}

		return implode( ' ', $data );	

	}

	protected function get_label($pos) {
		
		$settings = $this->get_settings_for_display();

		if (
			(
				$pos === 'before' &&
				$settings['enable_side_label_overlay'] === 'lqd-imggrp-content-fixed-in'
			) ||
			(
				$pos === 'inside' &&
				$settings['enable_side_label_overlay'] !== 'lqd-imggrp-content-fixed-in'
			)
		) {
			return;
		}
		
		$label = $settings['label'];
		$side = $settings['label_side'];
		$side_overlay = 'lqd-imggrp-content-fixed ' . $settings['enable_side_label_overlay'];
		if( empty( $label ) ) {
			return;
		}
		
		printf( '<div class="lqd-imggrp-content %s %s"><div class="lqd-imggrp-content-inner"><p class="m-0">%s</p></div></div>', esc_attr( $side ), esc_attr( $side_overlay ), wp_kses_post( $label ) );		

	}
	
	protected function get_lines() {
		$settings = $this->get_settings_for_display();
		
		if( !$settings['enable_lines'] ) {
			return '';
		}
		
		$out = '';
		
		$lines = $settings['lines_count'];
		
		$out = '<div class="lqd-v-lines lqd-overlay d-flex justify-content-center">';
		$out .= '<div class="lqd-v-line d-inline-flex justify-content-start flex-grow-1 invisible"><div class="h-100"></div></div>';
		for( $i = 1; $i <= $lines; $i++ ) {
			$out .= '<div class="lqd-v-line d-inline-flex justify-content-start flex-grow-1"><div class="h-100"></div></div>';
		}
		$out .= '</div>';

		echo $out;
		
	}
	
	protected function get_overlay_bg() {
		$settings = $this->get_settings_for_display();
		
		if( !$settings['enable_overlay_bg'] ) {
			return '';
		}

		echo '<span class="lqd-overlay lqd-imggrp-overlay-bg"></span>';
		
	}
	
	protected function get_reveal_el() {

		$settings = $this->get_settings_for_display();
		
		if( !$settings['enable_reveal'] ) {
			return '';
		}

		$dir = $settings['reveal_direction'];
		$origin = '50% 0%';

		switch ($dir) {
			case 'lr':
				$origin = '0% 50%';
				break;
			case 'rl':
				$origin = '100% 50%';
				break;
			case 'bt':
				$origin = '50% 0%';
				break;
		}

		echo '<div class="block-revealer__element" style="transform-origin: '. $origin .'"></div>';
		
	}

	protected function get_overlay_link() {
		$settings = $this->get_settings_for_display();

		$link['href'] =  $settings['img_link']['url'];
		$target = isset($settings['img_link']['is_external']) && $settings['img_link']['is_external'] ? ' target="_blank"' : '';
		$nofollow = isset($settings['img_link']['nofollow']) && $settings['img_link']['nofollow'] ? ' rel="nofollow"' : '';
		if ( !empty( $link['href'] ) && empty($settings['enable_lightbox']) ) {
			printf( '<a%s %s %s class="lqd-overlay lqd-fi-overlay-link %s" data-cc-icon-color="%s"></a>', ld_helper()->html_attributes( $link ), $target, $nofollow, esc_attr( $settings['custom_cursor_style'] ), $settings['cc_icon_color'] );
		}
		
	}

	protected function get_lightbox_link() {
		$settings = $this->get_settings_for_display();
		
		$link['href'] =  $settings['img_link']['url'];

		if ( ! empty($settings['enable_lightbox']) && empty( $link['href'] ) ) {
			printf( '<a href="%s" class="lqd-overlay lqd-fi-overlay-link %s fresco" data-fresco-group="%s" data-cc-icon-color="%s"></a>', wp_get_attachment_image_url( $settings['image']['id'], 'full', false ), esc_attr( $settings['custom_cursor_style'] ), $settings['lightbox_group_id'], $settings['cc_icon_color'] );
		} else if ( ! empty($settings['enable_lightbox']) && ! empty( $link['href'] ) ) {
			printf( '<a%s class="lqd-overlay lqd-fi-overlay-link %s fresco" data-fresco-group="%s" data-cc-icon-color="%s"></a>', ld_helper()->html_attributes( $link ), esc_attr( $settings['custom_cursor_style'] ), $settings['lightbox_group_id'], $settings['cc_icon_color'] );
		}
	}

	protected function get_interactive_swap_options() {
		
		$settings = $this->get_settings_for_display();
		
		if ( 'yes' !== $settings['enable_interactive_swap'] ) {
			return '';
		}

		$opts = [];
		$image_1_src = wp_get_attachment_image_url( $settings['image']['id'], 'full', false );
		$image_2_src = wp_get_attachment_image_url( $settings['interactive_swap_image']['id'], 'full', false, false, array( 'class' => 'lqd-overlay invisible' ) );
		$intensity = $settings['interactive_swap_intensity']['size'];

		if ( empty( $image_2_src ) ) {

			if ( empty( $image_1_src ) ) return '';

			$image_2_src = $image_1_src;
			
		}
		

		$opts[] = 'data-lqd-interactive-swap="true"';
		$opts[] = 'data-swap-options=\'' . wp_json_encode( array(
			'image1' => $image_1_src,
			'image2' => $image_2_src,
			'dispImage' => get_template_directory_uri() . '/assets/img/displacements/'. $settings['interactive_swap_disp'] .'',
			'speedIn' => 1.25,
			'speedOut' => 1.25,
			'intensity1' => ! empty( $intensity ) ? $intensity : 0.15,
			'intensity2' => ! empty( $intensity ) ? $intensity : 0.15,
			'angle1' => 10,
			'angle2' => 10,
		) ) . '\'';

		return implode(' ', $opts);
		
	}

	protected function get_interactive_swap_image() {
		
		$settings = $this->get_settings_for_display();
		
		if ( 'yes' !== $settings['enable_interactive_swap'] || empty( $settings['interactive_swap_image']['id'] ) ) {
			return;
		}

		return wp_get_attachment_image( $settings['interactive_swap_image']['id'], 'full', false, array( 'class' => 'lqd-overlay invisible' ) );
		
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
		
		$wrapper_class = array(
			'lqd-imggrp-single',
			'd-inline-flex',
			'pos-rel',
			'align-items-' . ($settings['label_pos'] ? $settings['label_pos'] : 'center'),
			'justify-content-center',
			$settings['enable_hover3d'] === 'yes' ? 'transform-style-3d' : '',
		);

		$container_class = array(
			'lqd-imggrp-img-container',
			'pos-rel',
		);

		?>

			<div class="<?php echo ld_helper()->sanitize_html_classes( $wrapper_class ); ?>" <?php echo $this->get_data_options(); ?> <?php echo $this->get_data_float_effect() ?> >
				
				<?php $this->get_label('before') ?>

				<div class="<?php echo ld_helper()->sanitize_html_classes( $container_class ); ?>" <?php echo $this->get_data_stacking_factor() ?>>
					
					<figure
						class="w-100 pos-rel"
						<?php echo $this->get_interactive_swap_options() ?>
						<?php echo $this->get_reveal_data(); ?>
					>
						<?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'image' ); ?>
						<?php if ( 'yes' === $settings['enable_interactive_swap'] && ! empty( $settings['interactive_swap_image']['id'] ) ) { ?>
						<canvas class="lqd-overlay"></canvas>
						<?php echo $this->get_interactive_swap_image(); } ?>
						<?php $this->get_overlay_bg(); ?>
						<?php $this->get_label('inside') ?>
						<?php $this->get_lines(); ?>
						<?php $this->get_reveal_el(); ?>
						<?php $this->get_overlay_link(); ?>
						<?php $this->get_lightbox_link(); ?>
					</figure>
					
				</div>
			</div>

		<?php

	}

	protected function content_template() {
		?>
		<# 

		function get_data_options() {
			
			var opts = [];
			
			var shadow = settings.enable_image_shadow;
			var shadow_style = settings.shadow_style;
			var shadow_delay = settings.shadow_delay;
			var hover3d = settings.enable_hover3d;
			var enable_animated_shadow = settings.enable_animated_shadow;

			if( settings.enable_image_shadow ) { opts.push('data-shadow-style="' + shadow_style + '"');}
	
			if( enable_animated_shadow ) {
				opts.push('data-inview="true"');
				if( shadow_delay !== '' ) {
					opts.push(`data-inview-options='${JSON.stringify( {"delayTime": shadow_delay} )}'`);
				}
				opts.push('data-animate-shadow="true"');	
			}
		
			if( hover3d ) { opts.push('data-hover3d="true"');}
			if( !opts ) { return '';}
			
			return opts.join(' ');	
			
		}

		function get_data_float_effect() {
			
			var enable_float_effect = settings.enable_float_effect;
			var float_easing = settings.float_easing;
			var float_custom_ease = settings.float_custom_ease;
			
			var easing = float_easing;
			
			if( float_easing === 'custom_ease' && float_custom_ease !== '' ) {
				easing = float_custom_ease;
			}

			if ( enable_float_effect ) {
				return 'data-float="' + easing + '"';
			}
			
		}

		function get_data_stacking_factor() {
			
			var hover3d = settings.enable_hover3d;
			var hover3d_stacking_factor = settings.hover3d_stacking_factor;
			
			if( hover3d === 'yes' ) {
				return 'data-stacking-factor="' + hover3d_stacking_factor + '"';
			}
			
		}

		function get_reveal_data() {

			var reveal = settings.enable_reveal;

			if ( reveal !== 'yes' ) return '';

			var data = [];

			var reveal_opts = {
				direction: settings.reveal_direction,
				appendMarkup: false,
			}

			if ( settings.reveal_delay && settings.reveal_delay !== '' ) {
				reveal_opts['delay'] = settings.reveal_delay;
			}

			if ( settings.reveal_direction === 'lr' || settings.reveal_direction === 'rl' ) {
				reveal_opts['initialCoverArea'] = settings.reveal_initial_cover_area_x.size;
			} else {
				reveal_opts['initialCoverArea'] = settings.reveal_initial_cover_area_y.size;
			}

			if ( reveal_opts['initialCoverArea'] === 100 ) {
				reveal_opts['isContentHidden'] = false;
				reveal_opts['duration'] = 2;
			}

			data.push('data-reveal="true"');
			data.push(`data-reveal-options='${JSON.stringify( reveal_opts )}'`);

			if ( !data  ) { return ''; }

			return data.join(' ');

		}

		function get_label(pos) {

			if (
				(
					pos === 'before' &&
					settings.enable_side_label_overlay === 'lqd-imggrp-content-fixed-in'
				) ||
				(
					pos === 'inside' &&
					settings.enable_side_label_overlay !== 'lqd-imggrp-content-fixed-in'
				)
			) {
				return;
			}
			
			var label = settings.label;
			var side = settings.label_side;
			var side_overlay = `lqd-imggrp-content-fixed ${settings.enable_side_label_overlay}`;
			if( label === '' || !settings.enable_side_label) {
				return '';
			}

			return `<div class="lqd-imggrp-content ${side} ${side_overlay}"><div class="lqd-imggrp-content-inner"><p class="m-0">${label}</p></div></div>`;	

		}

		function get_lines() {
			
			if( !settings.enable_lines ) { return ''; }
			
			var out = '';
			var lines = settings.lines_count;
			
			out = '<div class="lqd-v-lines lqd-overlay d-flex justify-content-center">';
			out += '<div class="lqd-v-line d-inline-flex justify-content-start flex-grow-1 invisible"><div class="h-100"></div></div>';
			for( let i = 1; i <= lines; i++ ) {
				out += '<div class="lqd-v-line d-inline-flex justify-content-start flex-grow-1"><div class="h-100"></div></div>';
			}
			out += '</div>';

			return out;
			
		}

		function get_overlay_bg() {
			
			if( !settings.enable_overlay_bg ) { return ''; }

			return '<span class="lqd-overlay lqd-imggrp-overlay-bg"></span>';
			
		}

		function get_overlay_link() {

			if ( settings.img_link.url && !settings.enable_lightbox ) {
				return '<a href="' + settings.img_link.url + '" class="lqd-overlay lqd-fi-overlay-link ' + settings.custom_cursor_style  + '"></a>';
			}

		}

		function get_lightbox_link() {

			if ( settings.enable_lightbox && !settings.img_link.url ) {
				return '<a href="' + settings.img_link.url + '" class="lqd-overlay lqd-fi-overlay-link ' + settings.custom_cursor_style  + ' fresco" data-fresco-group="' + settings.lightbox_group_id + '"></a>';
			} else if ( settings.enable_lightbox && !settings.img_link.url ) {
				return '<a href="' + settings.img_link.url + '" class="lqd-overlay lqd-fi-overlay-link ' + settings.custom_cursor_style  + ' fresco" data-fresco-group="' + settings.lightbox_group_id + '"></a>';
			}

		}

		function get_interactive_swap_options() {

			if ( 'yes' !== settings['enable_interactive_swap'] ) {
				return '';
			}

			var opts = [];
			var image_1_src = settings.image.url;
			var image_2_src = settings.interactive_swap_image.url;
			var intensity = settings['interactive_swap_intensity']['size'];

			if ( ! image_2_src ) {

				if ( ! image_1_src ) return '';

				image_2_src = image_1_src;
				
			}

			var swap_opts = JSON.stringify({
				"image1": image_1_src,
				"image2": image_2_src,
				"dispImage": `${window.liquidParams?.url}/img/displacements/${settings['interactive_swap_disp']}`,
				"speedIn": 1.25,
				"speedOut": 1.25,
				"intensity1": intensity ? intensity : 0.15,
				"intensity2": intensity ? intensity : 0.15,
				"angle1": 10,
				"angle2": 10,
			});

			opts.push( 'data-lqd-interactive-swap="true"' );
			opts.push( `data-swap-options='${swap_opts}'` );

			return opts.join(' ');
			
		}

		function get_interactive_swap_image() {
			
			if ( 'yes' !== settings['enable_interactive_swap'] || settings['interactive_swap_image']['id'] === '' ) {
				return;
			}

			if ( settings.interactive_swap_image.url ) {
				var image = {
					id: settings.interactive_swap_image.id,
					url: settings.interactive_swap_image.url,
					model: view.getEditModel()
				};

				var image_url = elementor.imagesManager.getImageUrl( image );

				if ( ! image_url ) {
					return;
				}
			}

			return '<canvas class="lqd-overlay"></canvas><img src=' + image_url + ' class="lqd-overlay invisible" />';

		}

		function get_reveal_el() {

			if ( ! settings.enable_reveal ) return '';

			const dir = settings.reveal_direction;
			let origin = '50% 0%';

			switch ( dir ) {
				case 'lr':
					origin = '0% 50%';
					break;
				case 'rl':
					origin = '100% 50%';
					break;
				case 'bt':
					origin = '50% 100%';
					break;
			}

			return '<div class="block-revealer__element" style="transform-origin: ' + origin + ';"></div>';

		}

		var render_image = {
			id: settings.image.id,
			url: settings.image.url,
			size: settings.thumbnail_size,
			dimension: settings.thumbnail_custom_dimension,
			model: view.getEditModel()
		};
		var render_image_url = elementor.imagesManager.getImageUrl( render_image );

		#>

		<div class="lqd-imggrp-single d-inline-flex pos-rel align-items-{{ settings.label_pos ? settings.label_pos : 'center'}} justify-content-center  {{ settings.enable_hover3d === 'yes' ? 'transform-style-3d' : '' }}"
		{{{ get_data_options() }}}
		{{{ get_data_float_effect() }}}
		>
			{{{ get_label('before') }}}
			<div class="lqd-imggrp-img-container pos-rel" {{{ get_data_stacking_factor() }}}>
				<figure class="w-100 pos-rel" {{{ get_interactive_swap_options() }}} {{{ get_reveal_data() }}}>
					<img src="{{ render_image_url }}">
					{{{ get_interactive_swap_image() }}}
					{{{ get_overlay_bg() }}}
					{{{ get_label('inside') }}}
					{{{ get_lines() }}}
					{{{ get_reveal_el() }}}
					{{{ get_overlay_link() }}}
					{{{ get_lightbox_link() }}}
				</figure>
			</div>
		</div>

	<?php

	}

}
