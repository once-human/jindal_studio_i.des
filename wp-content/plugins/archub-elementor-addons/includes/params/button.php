<?php

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

use Elementor\Core\Kits\Documents\Tabs\Global_Colors;

function ld_el_btn($pf, $pf2, $condition = ''){
    // Button Section
		$pf->start_controls_section(
			'button_section2',
			[
				'label' => __( 'Button', 'archub-elementor-addons' ),
				'condition' => $condition
			]
		);

		$pf->add_control(
			'show_button',
			[
				'label' => __( 'Show button', 'archub-elementor-addons' ),
				'type' => ($pf2 === 'ib_' ? Controls_Manager::SWITCHER : Controls_Manager::HIDDEN),
				'label_on' => __( 'Show', 'archub-elementor-addons' ),
				'label_off' => __( 'Hide', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => ($pf2 === 'ib_' ? '' : 'yes'),
			]
		);

		$pf->add_control(
			$pf2.'style',
			[
				'label' => __( 'Style', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'btn-solid',
				'options' => [
					'btn-solid' => __( 'Solid', 'archub-elementor-addons' ),
					'btn-naked' => __( 'Plain', 'archub-elementor-addons' ),
					'btn-underlined' => __( 'Underline', 'archub-elementor-addons' ),
				],
				'condition' => [
					'show_button' => 'yes',
				]
			]
		);

		$pf->add_control(
			$pf2.'title',
			[
				'label' => __( 'Title', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Button', 'archub-elementor-addons' ),
				'placeholder' => __( 'Enter Text', 'archub-elementor-addons' ),
				'condition' => [
					'show_button' => 'yes',
				]
			]
		);

		if ($pf2 !== 'ib_' ){
			$pf->add_responsive_control(
				$pf2.'align',
				[
					'label' => __( 'Alignment', 'archub-elementor-addons' ),
					'type' => Controls_Manager::CHOOSE,
					'options' => [
						'left'    => [
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
						'justify' => [
							'title' => __( 'Justified', 'archub-elementor-addons' ),
							'icon' => 'eicon-text-align-justify',
						],
					],
					'prefix_class' => 'elementor%s-align-',
					'default' => '',
					'condition' => [
						'show_button' => 'yes',
					],
				]
			);
		}


		$pf->add_control(
			$pf2.'link_type',
			[
				'label' => __( 'Link type', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''  => __( 'Simple Click', 'archub-elementor-addons' ),
					'lightbox' => __( 'Lightbox', 'archub-elementor-addons' ),
					'modal_window' => __( 'Modal Window', 'archub-elementor-addons' ),
					'local_scroll' => __( 'Local Scroll', 'archub-elementor-addons' ),
					'scroll_to_section' => __( 'Scroll to Section Bellow', 'archub-elementor-addons' ),
				],
				'separator' => 'before',
				'condition' => [
					'show_button' => 'yes',
				]
			]
		);

		$pf->add_control(
			$pf2.'image_caption',
			[
				'label' => __( 'Image caption', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter Image Caption', 'archub-elementor-addons' ),
				'condition' => array(
					$pf2.'link_type' => 'lightbox',
					'show_button' => 'yes',
				),
			]
		);

		$pf->add_control(
			$pf2.'scroll_speed',
			[
				'label' => __( 'Scroll speed', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'description' => __( 'Add scroll speed in milliseconds', 'archub-elementor-addons' ),
				'condition' => array(
					$pf2.'link_type' => array('local_scroll', 'scroll_to_section'),
					'show_button' => 'yes',
				),
				]
		);

		$pf->add_control(
			$pf2.'anchor_id',
			[
				'label' => __( 'Element id', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'description' => __( 'Input the ID of the element to scroll, for ex. #Element_ID', 'archub-elementor-addons' ),
				'condition' => array(
					$pf2.'link_type' => array( 'modal_window', 'local_scroll'),
					'show_button' => 'yes',
				),
			]
		);
			
		$pf->add_control(
			$pf2.'link',
			[
				'label' => __( 'Link', 'archub-elementor-addons' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'archub-elementor-addons' ),
				'show_external' => true,
				'dynamic' => array(
					'active' => true,
				),
				'default' => [
					'url' => '#',
					'is_external' => false,
					'nofollow' => false,
				],
				'condition' => array(
					$pf2.'link_type' => array('', 'lightbox'),
					'show_button' => 'yes',
				),
			]
		);
		
		$pf->end_controls_section();

		// Styling Section 
		$pf->start_controls_section(
			$pf2.'button_styling_section',
			array(
				'label' => __( 'Button styling', 'archub-elementor-addons' ),
				'condition' => [
					'show_button' => 'yes',
				]
			)
		);

		$pf->add_control(
			$pf2.'custom_size',
			[
				'label' => __( 'Custom size?', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'condition' => [
					$pf2.'style' => array( 'btn-solid' ),
				]
			]
		);

		$pf->add_control(
			$pf2.'fullwidth',
			[
				'label' => __( 'Fullwidth?', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .btn' => 'width: 100%;',
				],
			]
		);

		$pf->add_responsive_control(
			$pf2.'custom_w',
			[
				'label' => __( 'Button width', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
					'em' => [
						'min' => 0,
						'max' => 10,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .btn' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => array(
					$pf2.'style' => array( 'btn-solid' ),
					$pf2.'custom_size' => 'yes',
				),
			]
		);

		$pf->add_responsive_control(
			$pf2.'custom_h',
			[
				'label' => __( 'Button height', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
					'em' => [
						'min' => 0,
						'max' => 10,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .btn' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => array(
					$pf2.'style' => array( 'btn-solid' ),
					$pf2.'custom_size' => 'yes',
				),
			]
		);

		$pf->add_control(
			$pf2.'border_w',
			[
				'label' => __( 'Border size', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'border-thin',
				'options' => [
					'border-thin' => __( '1px', 'archub-elementor-addons' ),
					'border-thick' => __( '2px', 'archub-elementor-addons' ),
					'border-thicker' => __( '3px', 'archub-elementor-addons' ),
				],
				'separator' => 'before',
				'condition' => array(
					$pf2.'style' => array( 'btn-underlined' ),
				),
			]
		);

		$pf->add_control(
			$pf2.'extended_lines',
			[
				'label' => __( 'Extended lines', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'separator' => 'before',
				'condition' => [
					$pf2.'style' => array( 'btn-solid' ),
				]
			]
		);

		$pf->add_control(
			$pf2.'extended_lines_size',
			[
				'label' => __( 'Extended lines size', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
					'em' => [
						'min' => 0,
						'max' => 10,
						'step' => 0.1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 12,
				],
				'selectors' => [
					'{{WRAPPER}} .btn' => '--extended-line-size: {{SIZE}}{{UNIT}};'
				],
				'condition' => array(
					$pf2.'style' => array( 'btn-solid' ),
					$pf2.'extended_lines' => array( 'yes' ),
				),
				'separator' => 'before',
			]
		);

		$pf->add_control(
			$pf2.'hover_txt_effect',
			[
				'label' => __( 'Hover text effect', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'None', 'archub-elementor-addons' ),
					'btn-hover-txt-liquid-x' => __( 'Hover Liquid X', 'archub-elementor-addons' ),
					'btn-hover-txt-liquid-x-alt' => __( 'Hover Liquid X Alt', 'archub-elementor-addons' ),
					'btn-hover-txt-liquid-y' => __( 'Hover Liquid Y', 'archub-elementor-addons' ),
					'btn-hover-txt-liquid-y-alt' => __( 'Hover Liquid Y Alt', 'archub-elementor-addons' ),
					'btn-hover-txt-switch btn-hover-txt-switch-x' => __( 'Hover Switch X', 'archub-elementor-addons' ),
					'btn-hover-txt-switch btn-hover-txt-switch-y' => __( 'Hover Switch Y', 'archub-elementor-addons' ),
					'btn-hover-txt-marquee btn-hover-txt-marquee-x' => __( 'Hover Marquee X', 'archub-elementor-addons' ),
					'btn-hover-txt-marquee btn-hover-txt-marquee-y' => __( 'Hover Marquee Y', 'archub-elementor-addons' ),
					'btn-hover-txt-switch-change btn-hover-txt-switch btn-hover-txt-switch-y' => __( 'Hover Change Text', 'archub-elementor-addons' ),
				],
				'separator' => 'before',
			]
		);
		
		$pf->add_control(
			$pf2.'title_secondary',
			[
				'label' => __( 'Title', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Button', 'archub-elementor-addons' ),
				'placeholder' => __( 'Enter Text', 'archub-elementor-addons' ),
				'condition' => [
					'show_button' => 'yes',
					$pf2.'hover_txt_effect' => 'btn-hover-txt-switch-change btn-hover-txt-switch btn-hover-txt-switch-y',
				],
			]
		);

		$pf->add_control(
			$pf2.'hover_bg_effect',
			[
				'label' => __( 'Hover background effect', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'None', 'archub-elementor-addons' ),
					'btn-hover-bg-unfill btn-hover-bg-unfill-y btn-hover-bg-unfill-top' => __( 'Unfill top', 'archub-elementor-addons' ),
					'btn-hover-bg-unfill btn-hover-bg-unfill-y btn-hover-bg-unfill-bottom' => __( 'Unfill bottom', 'archub-elementor-addons' ),
					'btn-hover-bg-unfill btn-hover-bg-unfill-x btn-hover-bg-unfill-left' => __( 'Unfill left', 'archub-elementor-addons' ),
					'btn-hover-bg-unfill btn-hover-bg-unfill-x btn-hover-bg-unfill-right' => __( 'Unfill right', 'archub-elementor-addons' ),
				],
				'separator' => 'before',
				'condition' => [
					'show_button' => 'yes',
					$pf2.'style' => array( 'btn-solid' ),
				],
			]
		);

		$pf->end_controls_section();

		// Icon Section
		$pf->start_controls_section(
			'icon_section',
			array(
				'label' => __( 'Button icon', 'archub-elementor-addons' ),
				'condition' => [
					'show_button' => 'yes',
				]
			)
		);

		
		$pf->add_control(
			$pf2.'i_add_icon',
			[
				'label' => __( 'Add icon', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'true',
				'default' => 'false',
			]
		);

		$pf->add_control(
			$pf2.'icon',
			[
				'label' => __( 'Icon', 'archub-elementor-addons' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fa fa-star',
					'library' => 'solid',
				],
				'condition' => array(
					$pf2.'i_add_icon' => 'true',
				),
			]
		);

		$pf->add_control(
			$pf2.'i_size',
			[
				'label' => __( 'Icon size', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
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
					'{{WRAPPER}} .btn' => '--icon-font-size: {{SIZE}}{{UNIT}};'
				],
				'condition' => array(
					$pf2.'i_add_icon' => 'true',
				),
			]
		);

		$pf->add_control(
			$pf2.'i_position',
			[
				'label' => __( 'Icon position', 'archub-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'btn-icon-left' => [
						'title' => __( 'Left', 'archub-elementor-addons' ),
						'icon' => 'eicon-arrow-left',
					],
					'btn-icon-right' => [
						'title' => __( 'Right', 'archub-elementor-addons' ),
						'icon' => 'eicon-arrow-right',
					],
					'btn-icon-block btn-icon-top' => [
						'title' => __( 'Top', 'archub-elementor-addons' ),
						'icon' => 'eicon-arrow-up',
					],
					'btn-icon-block' => [
						'title' => __( 'Bottom', 'archub-elementor-addons' ),
						'icon' => 'eicon-arrow-down',
					],
				],
				'default' => 'btn-icon-right',
				'toggle' => false,
				'condition' => array(
					$pf2.'i_add_icon' => 'true',
				),
			]
		);

		$pf->add_control(
			$pf2.'i_shape_style',
			[
				'label' => __( 'Icon shape style', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Default', 'archub-elementor-addons' ),
					'btn-icon-solid' => __( 'Solid', 'archub-elementor-addons' ),
					'btn-icon-bordered' => __( 'Outline', 'archub-elementor-addons' ),
				],
				'condition' => array(
					$pf2.'i_add_icon' => 'true',
				),
			]
		);

		$pf->add_control(
			$pf2.'i_shape',
			[
				'label' => __( 'Icon shape', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'None', 'archub-elementor-addons' ),
					'btn-icon-square' => __( 'Square', 'archub-elementor-addons' ),
					'btn-icon-semi-round' => __( 'Semi Round', 'archub-elementor-addons' ),
					'btn-icon-round' => __( 'Round', 'archub-elementor-addons' ),
					'btn-icon-circle' => __( 'Circle', 'archub-elementor-addons' ),
				],
				'condition' => array(
					$pf2.'i_add_icon' => 'true',
					$pf2.'i_shape_style!' => '',
				),
			]
		);

		$pf->add_control(
			$pf2.'i_shape_bw',
			[
				'label' => __( 'Border size', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Default - 1px', 'archub-elementor-addons' ),
					'btn-icon-border-thick' => __( '2px', 'archub-elementor-addons' ),
					'btn-icon-border-thicker' => __( '3px', 'archub-elementor-addons' ),
					'btn-icon-border-thickest' => __( '4px', 'archub-elementor-addons' ),
				],
				'condition' => array(
					$pf2.'i_shape_style' => 'btn-icon-bordered',
					$pf2.'i_add_icon' => 'true',
				),
			]
		);

		$pf->add_control(
			$pf2.'i_shape_size',
			[
				'label' => __( 'Icon shape size', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'btn-icon-md',
				'options' => [
					'btn-icon-xsm' => __( 'Extra Small', 'archub-elementor-addons' ),
					'btn-icon-sm' => __( 'Small', 'archub-elementor-addons' ),
					'btn-icon-md' => __( 'Medium', 'archub-elementor-addons' ),
					'btn-icon-lg' => __( 'Large', 'archub-elementor-addons' ),
					'btn-icon-xlg' => __( 'Extra Large', 'archub-elementor-addons' ),
					'btn-icon-custom-size' => __( 'Custom Size', 'archub-elementor-addons' ),
				],
				'condition' => array(
					$pf2.'i_add_icon' => 'true',
					$pf2.'i_shape!' => '',
					$pf2.'i_shape_style!' => '',
				),
			]
		);

		$pf->add_control(
			$pf2.'i_shape_custom_size',
			[
				'label' => __( 'Icon shape size', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .btn .btn-icon' => '--icon-w: {{SIZE}}{{UNIT}}; --icon-h: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					$pf2.'i_add_icon' => 'true',
					$pf2.'i_shape!' => '',
					$pf2.'i_shape_style!' => '',
					$pf2.'i_shape_size' => 'btn-icon-custom-size',
				],
			]
		);

		$pf->add_control(
			$pf2.'i_hover_reveal',
			[
				'label' => __( 'Hover effect', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Default', 'archub-elementor-addons' ),
					'btn-hover-reveal' => __( 'Reveal', 'archub-elementor-addons' ),
					'btn-hover-swp' => __( 'Switch Position', 'archub-elementor-addons' )
				],
				'condition' => array(
					$pf2.'i_add_icon' => 'true',
					$pf2.'i_position' => [ 'btn-icon-left', 'btn-icon-right' ],
					// $pf2.'i_shape!' => '',
					// $pf2.'i_shape_style!' => '',
				),
			]
		);

		$pf->add_control(
			$pf2.'i_ripple',
			[
				'label' => __( 'Icon ripple effect', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'No', 'archub-elementor-addons' ),
					'btn-icon-ripple' => __( 'Yes', 'archub-elementor-addons' ),
				],
				'condition' => array(
					$pf2.'i_shape!' => '',
					$pf2.'i_shape_style!' => '',
					$pf2.'i_add_icon' => 'true',
				),
			]
		);
		

		$pf->add_control(
			$pf2.'i_separator',
			[
				'label' => __( 'Add separator', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'No', 'archub-elementor-addons' ),
					'btn-icon-sep' => __( 'Yes', 'archub-elementor-addons' ),
				],
				'condition' => [
					$pf2.'i_add_icon' => 'true',
					$pf2.'i_position' => [ 'btn-icon-left', 'btn-icon-right' ],
					$pf2.'i_ripple' => ''
				],
			]
		);

		$pf->add_responsive_control(
			$pf2.'i_margin',
			[
				'label' => __( 'Icon margin', 'archub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .btn' => '--icon-mt: {{TOP}}{{UNIT}}; --icon-me: {{RIGHT}}{{UNIT}}; --icon-mb: {{BOTTOM}}{{UNIT}}; --icon-ms: {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
				'condition' => [
					$pf2.'i_add_icon' => 'true',
				],
			]
		);

		$pf->end_controls_section();
		
		// Style Section
		$pf->start_controls_section(
			$pf2.'button_style_section',
			[
				'label' => __( 'Button style', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_button' => 'yes',
				]
			]
		);

		$pf->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => $pf2.'_content_typography',
				'label' => __( 'Typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .btn',
			]
		);

			$pf->start_controls_tabs(
				'button_style_tabs'
			);

			// Normal state
			$pf->start_controls_tab(
				'button_style_normal_tab',
				[
					'label' => __( 'Normal', 'archub-elementor-addons' ),
				]
			);

			$pf->add_control(
				$pf2.'text_color',
				[
					'label' => __( 'Text color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .btn' => 'color: {{VALUE}}; fill: {{VALUE}}',
					],
				]
			);

			$pf->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name' => $pf2.'background',
					'label' => __( 'Background', 'archub-elementor-addons' ),
					'types' => [ 'classic', 'gradient' ],
					'exclude' => [ 'image' ],
					'selector' => '{{WRAPPER}} .btn, {{WRAPPER}} .btn:before',
					'fields_options' => [
						'background' => [
							'default' => 'classic',
						],
						'color' => [
							'global' => [
								'default' => Global_Colors::COLOR_PRIMARY,
							],
						],
					],
					'separator' => 'before',
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
					),
				]
			);

			$pf->add_control(
				$pf2.'b_color',
				[
					'label' => __( 'Border color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .btn-txt:before' => 'background: {{VALUE}}',
					],
					'separator' => 'before',
					'condition' => array(
						$pf2.'style' => array( 'btn-underlined' ),
					),
				]
			);

			$pf->add_control(
				$pf2.'i_color',
				[
					'label' => __( 'Icon color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .btn-icon' => 'color: {{VALUE}}; fill: {{VALUE}}',
					],
					'condition' => array(
						$pf2.'i_add_icon' => 'true',
					),
					'separator' => 'before'
				]
			);

			$pf->add_control(
				$pf2.'i_fill_color',
				[
					'label' => __( 'Icon fill color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .btn-icon' => 'background: {{VALUE}}',
					],
					'condition' => array(
						$pf2.'i_shape_style' => 'btn-icon-solid',
					),
				]
			);

			$pf->add_control(
				$pf2.'i_border_color',
				[
					'label' => __( 'Icon border color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .btn-icon' => 'border-color: {{VALUE}}',
					],
					'condition' => array(
						$pf2.'i_shape_style' => 'btn-icon-bordered',
					),
				]
			);

			$pf->add_control(
				$pf2.'i_sep_color',
				[
					'label' => __( 'Icon separator color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .btn-icon:before' => 'background: {{VALUE}}',
					],
					'condition' => array(
						$pf2.'i_separator' => 'btn-icon-sep',
					),
				]
			);

			$pf->add_control(
				$pf2.'ripple_color',
				[
					'label' => __( 'Icon ripple color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .btn-icon:before' => 'border-color: {{VALUE}}',
					],
					'condition' => array(
						$pf2.'i_shape!' => '',
						$pf2.'i_add_icon' => 'true',
					),
				]
			);

			$pf->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => $pf2.'border',
					'selector' => '{{WRAPPER}} .btn, {{WRAPPER}} .btn-extended-line',
					'separator' => 'before',
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
					),
				]
			);

			$pf->add_control(
				$pf2.'extended_lines_color',
				[
					'label' => __( 'Extended line color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .btn-extended-line' => 'border-color: {{VALUE}}',
					],
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
						$pf2.'extended_lines' => 'yes',
					),
				]
			);
	
			$pf->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => $pf2.'button_box_shadow',
					'selector' => '{{WRAPPER}} .btn',
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
					),
				]
			);

			$pf->end_controls_tab();

			// Hover state
			$pf->start_controls_tab(
				$pf2.'button_style_hover_tab',
				[
					'label' => __( 'Hover', 'archub-elementor-addons' ),
				]
			);

			$pf->add_control(
				$pf2.'htext_color',
				[
					'label' => __( 'Text color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .btn:hover, {{WRAPPER}} .btn:focus' => 'color: {{VALUE}}',
					],
				]
			);

			$pf->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name' => $pf2.'button_background_hover',
					'label' => __( 'Background', 'archub-elementor-addons' ),
					'types' => [ 'classic', 'gradient' ],
					'exclude' => [ 'image' ],
					'selector' => '{{WRAPPER}} .btn:hover, {{WRAPPER}} .btn:focus, {{WRAPPER}} .btn:after',
					'fields_options' => [
						'background' => [
							'default' => 'classic',
						],
						'color' => [
							'global' => [
								'default' => Global_Colors::COLOR_PRIMARY,
							],
						],
					],
					'separator' => 'before',
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
					),
				]
			);

			$pf->add_control(
				$pf2.'h_b_color',
				[
					'label' => __( 'Border color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .btn-txt:after' => 'background: {{VALUE}}',
					],
					'separator' => 'before',
					'condition' => array(
						$pf2.'style' => array( 'btn-underlined' ),
					),
				]
			);

			$pf->add_control(
				$pf2.'i_hcolor',
				[
					'label' => __( 'Icon color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .btn:hover .btn-icon, {{WRAPPER}} .btn:focus .btn-icon' => 'color: {{VALUE}}; fill: {{VALUE}}',
					],
					'condition' => array(
						$pf2.'i_add_icon' => 'true',
					),
					'separator' => 'before'
				]
			);

			$pf->add_control(
				$pf2.'i_fill_hcolor',
				[
					'label' => __( 'Icon fill color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .btn:hover .btn-icon, {{WRAPPER}} .btn:focus .btn-icon' => 'background: {{VALUE}}',
					],
					'condition' => array(
						$pf2.'i_shape_style' => array('btn-icon-solid', 'btn-icon-bordered'),
					),
				]
			);

			$pf->add_control(
				$pf2.'i_border_hcolor',
				[
					'label' => __( 'Icon border color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .btn:hover .btn-icon, {{WRAPPER}} .btn:focus .btn-icon' => 'border-color: {{VALUE}}',
					],
					'condition' => array(
						$pf2.'i_shape_style' => 'btn-icon-bordered',
					),
				]
			);

			$pf->add_control(
				$pf2.'h_i_sep_color',
				[
					'label' => __( 'Icon separator color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .btn:hover .btn-icon:before, {{WRAPPER}} .btn:focus .btn-icon:before' => 'background: {{VALUE}}',
					],
					'condition' => array(
						$pf2.'i_separator' => 'btn-icon-sep',
					),
				]
			);

			$pf->add_control(
				$pf2.'h_ripple_color',
				[
					'label' => __( 'Icon ripple color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .btn:hover .btn-icon:before, {{WRAPPER}} .btn:focus .btn-icon:before' => 'border-color: {{VALUE}}',
					],
					'condition' => array(
						$pf2.'i_shape!' => '',
						$pf2.'i_add_icon' => 'true',
					),
				]
			);

			$pf->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => $pf2.'h_border',
					'selector' => '{{WRAPPER}} .btn:hover, {{WRAPPER}} .btn:focus, {{WRAPPER}} .btn:hover .btn-extended-line, {{WRAPPER}} .btn:focus .btn-extended-line',
					'separator' => 'before',
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
					),
				]
			);
	
			$pf->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => $pf2.'h_button_box_shadow',
					'selector' => '{{WRAPPER}} .btn:hover, {{WRAPPER}} .btn:focus',
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
					),
				]
			);

			$pf->add_control(
				$pf2.'h_extended_lines_color',
				[
					'label' => __( 'Extended line color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .btn:hover .btn-extended-line, {{WRAPPER}} .btn:focus .btn-extended-line' => 'border-color: {{VALUE}}',
					],
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
						$pf2.'extended_lines' => 'yes',
					),
				]
			);

			$pf->end_controls_tab();
			$pf->end_controls_tabs();
	
			$pf->add_control(
				$pf2.'border_radius',
				[
					'label' => __( 'Border radius', 'archub-elementor-addons' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
					),
				]
			);

			$pf->add_responsive_control(
				$pf2.'text_padding',
				[
					'label' => __( 'Text padding', 'archub-elementor-addons' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						'{{WRAPPER}} .btn' => '--btn-pt: {{TOP}}{{UNIT}}; --btn-pe: {{RIGHT}}{{UNIT}}; --btn-pb: {{BOTTOM}}{{UNIT}}; --btn-ps: {{LEFT}}{{UNIT}}; padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'separator' => 'before',
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
					),
				]
			);
		
		$pf->end_controls_section();

		$color_sections_hide = get_post_type() === 'liquid-header' ? '' : '_hide';

		// Sticky Header
		$pf->start_controls_section(
			$pf2.'sticky_button_style_section' . $color_sections_hide,
			[
				'label' => __( 'Sticky color', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_button' => ($pf2 === 'ib_' ? 'hidden' : 'yes'),
				]
			]
		);

			$pf->start_controls_tabs(
				'sticky_button_style_tabs'
			);

			// Normal state
			$pf->start_controls_tab(
				'sticky_button_style_normal_tab',
				[
					'label' => __( 'Normal', 'archub-elementor-addons' ),
				]
			);

			$pf->add_control(
				'sticky_' . $pf2 . 'text_color',
				[
					'label' => __( 'Text color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'.is-stuck {{WRAPPER}} .btn' => 'color: {{VALUE}} !important;',
					],
				]
			);

			$pf->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name' => 'sticky_' . $pf2 . 'background',
					'label' => __( 'Background', 'archub-elementor-addons' ),
					'types' => [ 'classic', 'gradient' ],
					'exclude' => [ 'image' ],
					'selector' => '.is-stuck {{WRAPPER}} .btn',
					'fields_options' => [
						'background' => [
							'default' => 'classic',
						],
						'color' => [
							'global' => [
								'default' => Global_Colors::COLOR_PRIMARY,
							],
						],
					],
					'separator' => 'before',
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
					),
				]
			);

			$pf->add_control(
				'sticky_' . $pf2 . 'b_color_solid',
				[
					'label' => __( 'Border color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'.is-stuck {{WRAPPER}} .btn' => 'border-color: {{VALUE}} !important;',
					],
					'separator' => 'before',
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
					),
				]
			);

			$pf->add_control(
				'sticky_' . $pf2 . 'b_color',
				[
					'label' => __( 'Border color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'.is-stuck {{WRAPPER}} .btn-txt:before' => 'background: {{VALUE}} !important;',
					],
					'separator' => 'before',
					'condition' => array(
						$pf2.'style' => array( 'btn-underlined' ),
					),
				]
			);

			$pf->add_control(
				'sticky_'. $pf2 . 'i_color',
				[
					'label' => __( 'Icon color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'.is-stuck {{WRAPPER}} .btn-icon' => 'color: {{VALUE}} !important;',
					],
					'condition' => array(
						$pf2.'i_add_icon' => 'true',
					),
					'separator' => 'before'
				]
			);

			$pf->add_control(
				'sticky_' . $pf2 . 'i_fill_color',
				[
					'label' => __( 'Icon fill color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'.is-stuck {{WRAPPER}} .btn-icon' => 'background: {{VALUE}} !important;',
					],
					'condition' => array(
						$pf2.'i_shape_style' => 'btn-icon-solid',
					),
				]
			);

			$pf->add_control(
				'sticky_' . $pf2 . 'ripple_color',
				[
					'label' => __( 'Icon ripple color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'.is-stuck {{WRAPPER}} .btn-icon:before' => 'border-color: {{VALUE}} !important;',
					],
					'condition' => array(
						$pf2.'i_shape!' => '',
						$pf2.'i_add_icon' => 'true',
					),
				]
			);
	
			$pf->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'sticky_' . $pf2 . 'button_box_shadow',
					'selector' => '.is-stuck {{WRAPPER}} .btn',
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
					),
				]
			);

			$pf->end_controls_tab();

			// Hover state
			$pf->start_controls_tab(
				'sticky_' . $pf2 . 'button_style_hover_tab',
				[
					'label' => __( 'Hover', 'archub-elementor-addons' ),
				]
			);

			$pf->add_control(
				'sticky_' . $pf2 . 'htext_color',
				[
					'label' => __( 'Text color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'.is-stuck {{WRAPPER}} .btn:hover, .is-stuck {{WRAPPER}} .btn:focus' => 'color: {{VALUE}} !important;',
					],
				]
			);

			$pf->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name' => 'sticky_' . $pf2 . 'button_background_hover',
					'label' => __( 'Background', 'archub-elementor-addons' ),
					'types' => [ 'classic', 'gradient' ],
					'exclude' => [ 'image' ],
					'selector' => '.is-stuck {{WRAPPER}} .btn:hover, .is-stuck {{WRAPPER}} .btn:focus',
					'fields_options' => [
						'background' => [
							'default' => 'classic',
						],
						'color' => [
							'global' => [
								'default' => Global_Colors::COLOR_PRIMARY,
							],
						],
					],
					'separator' => 'before',
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
					),
				]
			);

			$pf->add_control(
				'sticky_' . $pf2 . 'h_b_color_solid',
				[
					'label' => __( 'Border color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'.is-stuck {{WRAPPER}} .btn:hover, .is-stuck {{WRAPPER}} .btn:focus' => 'border-color: {{VALUE}} !important;',
					],
					'separator' => 'before',
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
					),
				]
			);

			$pf->add_control(
				'sticky_' . $pf2 . 'h_b_color',
				[
					'label' => __( 'Border color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'.is-stuck {{WRAPPER}} .btn-txt:after' => 'background: {{VALUE}} !important;',
					],
					'separator' => 'before',
					'condition' => array(
						$pf2.'style' => array( 'btn-underlined' ),
					),
				]
			);

			$pf->add_control(
				'sticky_' . $pf2 . 'i_hcolor',
				[
					'label' => __( 'Icon color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'.is-stuck {{WRAPPER}} .btn:hover .btn-icon, .is-stuck {{WRAPPER}} .btn:focus .btn-icon' => 'color: {{VALUE}} !important;',
					],
					'condition' => array(
						$pf2.'i_add_icon' => 'true',
					),
					'separator' => 'before'
				]
			);

			$pf->add_control(
				'sticky_' . $pf2 . 'i_fill_hcolor',
				[
					'label' => __( 'Icon fill color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'.is-stuck {{WRAPPER}} .btn:hover .btn-icon, .is-stuck {{WRAPPER}} .btn:focus .btn-icon' => 'background: {{VALUE}} !important;',
					],
					'condition' => array(
						$pf2.'i_shape_style' => array('btn-icon-solid', 'btn-icon-bordered'),
					),
				]
			);

			$pf->add_control(
				'sticky_' . $pf2 . 'h_ripple_color',
				[
					'label' => __( 'Icon ripple color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'.is-stuck {{WRAPPER}} .btn:hover .btn-icon:before, .is-stuck {{WRAPPER}} .btn:focus .btn-icon:before' => 'border-color: {{VALUE}} !important;',
					],
					'condition' => array(
						$pf2.'i_shape!' => '',
						$pf2.'i_add_icon' => 'true',
					),
				]
			);
	
			$pf->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'sticky_' . $pf2 . 'h_button_box_shadow',
					'selector' => '.is-stuck {{WRAPPER}} .btn:hover, .is-stuck {{WRAPPER}} .btn:focus',
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
					),
				]
			);

			$pf->end_controls_tab();
			$pf->end_controls_tabs();
		
		$pf->end_controls_section();
		
		// Colors Over Light Rows
		$pf->start_controls_section(
			$pf2.'sticky_light_button_style_section' . $color_sections_hide,
			[
				'label' => __( 'Colors over light rows', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_button' => ($pf2 === 'ib_' ? 'hidden' : 'yes'),
				]
			]
		);

			$pf->start_controls_tabs(
				'sticky_light_button_style_tabs'
			);

			// Normal state
			$pf->start_controls_tab(
				'sticky_light_button_style_normal_tab',
				[
					'label' => __( 'Normal', 'archub-elementor-addons' ),
				]
			);

			$pf->add_control(
				'sticky_light_' . $pf2 . 'text_color',
				[
					'label' => __( 'Text color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-light .btn' => 'color: {{VALUE}} !important;',
					],
				]
			);

			$pf->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name' => 'sticky_light_' . $pf2 . 'background',
					'label' => __( 'Background', 'archub-elementor-addons' ),
					'types' => [ 'classic', 'gradient' ],
					'exclude' => [ 'image' ],
					'selector' => '{{WRAPPER}}.lqd-active-row-light .btn',
					'fields_options' => [
						'background' => [
							'default' => 'classic',
						],
						'color' => [
							'global' => [
								'default' => Global_Colors::COLOR_PRIMARY,
							],
						],
					],
					'separator' => 'before',
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
					),
				]
			);

			$pf->add_control(
				'sticky_light_' . $pf2 . 'b_color_solid',
				[
					'label' => __( 'Border color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-light .btn' => 'border-color: {{VALUE}} !important;',
					],
					'separator' => 'before',
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
					),
				]
			);

			$pf->add_control(
				'sticky_light_' . $pf2 . 'b_color',
				[
					'label' => __( 'Border color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-light .btn:before' => 'background: {{VALUE}} !important;',
					],
					'separator' => 'before',
					'condition' => array(
						$pf2.'style' => array( 'btn-underlined' ),
					),
				]
			);

			$pf->add_control(
				'sticky_light_'. $pf2 . 'i_color',
				[
					'label' => __( 'Icon color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-light .btn-icon' => 'color: {{VALUE}} !important;',
					],
					'condition' => array(
						$pf2.'i_add_icon' => 'true',
					),
					'separator' => 'before'
				]
			);

			$pf->add_control(
				'sticky_light_' . $pf2 . 'i_fill_color',
				[
					'label' => __( 'Icon fill color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-light .btn-icon' => 'background: {{VALUE}} !important;',
					],
					'condition' => array(
						$pf2.'i_shape_style' => 'btn-icon-solid',
					),
				]
			);

			$pf->add_control(
				'sticky_light_' . $pf2 . 'ripple_color',
				[
					'label' => __( 'Icon ripple color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-light .btn-icon:before' => 'border-color: {{VALUE}} !important;',
					],
					'condition' => array(
						$pf2.'i_shape!' => '',
						$pf2.'i_add_icon' => 'true',
					),
				]
			);
	
			$pf->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'sticky_light_' . $pf2 . 'button_box_shadow',
					'selector' => '{{WRAPPER}}.lqd-active-row-light .btn',
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
					),
				]
			);

			$pf->end_controls_tab();

			// Hover state
			$pf->start_controls_tab(
				'sticky_light_' . $pf2 . 'button_style_hover_tab',
				[
					'label' => __( 'Hover', 'archub-elementor-addons' ),
				]
			);

			$pf->add_control(
				'sticky_light_' . $pf2 . 'htext_color',
				[
					'label' => __( 'Text color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-light .btn:hover, {{WRAPPER}}.lqd-active-row-light .btn:focus' => 'color: {{VALUE}} !important;',
					],
				]
			);

			$pf->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name' => 'sticky_light_' . $pf2 . 'button_background_hover',
					'label' => __( 'Background', 'archub-elementor-addons' ),
					'types' => [ 'classic', 'gradient' ],
					'exclude' => [ 'image' ],
					'selector' => '{{WRAPPER}}.lqd-active-row-light .btn:hover, {{WRAPPER}}.lqd-active-row-light .btn:focus',
					'fields_options' => [
						'background' => [
							'default' => 'classic',
						],
						'color' => [
							'global' => [
								'default' => Global_Colors::COLOR_PRIMARY,
							],
						],
					],
					'separator' => 'before',
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
					),
				]
			);

			$pf->add_control(
				'sticky_light_' . $pf2 . 'h_b_color_solid',
				[
					'label' => __( 'Border color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-light .btn:hover, {{WRAPPER}}.lqd-active-row-light .btn:focus' => 'border-color: {{VALUE}} !important;',
					],
					'separator' => 'before',
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
					),
				]
			);

			$pf->add_control(
				'sticky_light_' . $pf2 . 'h_b_color',
				[
					'label' => __( 'Border color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-light .btn-txt:after' => 'background: {{VALUE}} !important;',
					],
					'separator' => 'before',
					'condition' => array(
						$pf2.'style' => array( 'btn-underlined' ),
					),
				]
			);

			$pf->add_control(
				'sticky_light_' . $pf2 . 'i_hcolor',
				[
					'label' => __( 'Icon color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-light .btn:hover .btn-icon, {{WRAPPER}}.lqd-active-row-light .btn:focus .btn-icon' => 'color: {{VALUE}} !important;',
					],
					'condition' => array(
						$pf2.'i_add_icon' => 'true',
					),
					'separator' => 'before'
				]
			);

			$pf->add_control(
				'sticky_light_' . $pf2 . 'i_fill_hcolor',
				[
					'label' => __( 'Icon fill color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-light .btn:hover .btn-icon, {{WRAPPER}}.lqd-active-row-light .btn:focus .btn-icon' => 'background: {{VALUE}} !important;',
					],
					'condition' => array(
						$pf2.'i_shape_style' => array('btn-icon-solid', 'btn-icon-bordered'),
					),
				]
			);

			$pf->add_control(
				'sticky_light_' . $pf2 . 'h_ripple_color',
				[
					'label' => __( 'Icon ripple color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-light .btn:hover .btn-icon:before, {{WRAPPER}}.lqd-active-row-light .btn:focus .btn-icon:before' => 'border-color: {{VALUE}} !important;',
					],
					'condition' => array(
						$pf2.'i_shape!' => '',
						$pf2.'i_add_icon' => 'true',
					),
				]
			);
	
			$pf->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'sticky_light_' . $pf2 . 'h_button_box_shadow',
					'selector' => '{{WRAPPER}}.lqd-active-row-light .btn:hover, {{WRAPPER}}.lqd-active-row-light .btn:focus',
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
					),
				]
			);

			$pf->end_controls_tab();
			$pf->end_controls_tabs();
		
		$pf->end_controls_section();
		
		// Colors Over Dark Rows
		$pf->start_controls_section(
			$pf2.'sticky_dark_button_style_section' . $color_sections_hide,
			[
				'label' => __( 'Colors over dark rows', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_button' => ($pf2 === 'ib_' ? 'hidden' : 'yes'),
				]
			]
		);

			$pf->start_controls_tabs(
				'sticky_dark_button_style_tabs'
			);

			// Normal state
			$pf->start_controls_tab(
				'sticky_dark_button_style_normal_tab',
				[
					'label' => __( 'Normal', 'archub-elementor-addons' ),
				]
			);

			$pf->add_control(
				'sticky_dark_' . $pf2 . 'text_color',
				[
					'label' => __( 'Text color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-dark .btn' => 'color: {{VALUE}} !important;',
					],
				]
			);

			$pf->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name' => 'sticky_dark_' . $pf2 . 'background',
					'label' => __( 'Background', 'archub-elementor-addons' ),
					'types' => [ 'classic', 'gradient' ],
					'exclude' => [ 'image' ],
					'selector' => '{{WRAPPER}}.lqd-active-row-dark .btn',
					'fields_options' => [
						'background' => [
							'default' => 'classic',
						],
						'color' => [
							'global' => [
								'default' => Global_Colors::COLOR_PRIMARY,
							],
						],
					],
					'separator' => 'before',
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
					),
				]
			);

			$pf->add_control(
				'sticky_dark_' . $pf2 . 'b_color_solid',
				[
					'label' => __( 'Border color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-dark .btn' => 'border-color: {{VALUE}} !important;',
					],
					'separator' => 'before',
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
					),
				]
			);

			$pf->add_control(
				'sticky_dark_' . $pf2 . 'b_color',
				[
					'label' => __( 'Border color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-dark .btn-txt:before' => 'background: {{VALUE}} !important;',
					],
					'separator' => 'before',
					'condition' => array(
						$pf2.'style' => array( 'btn-underlined' ),
					),
				]
			);

			$pf->add_control(
				'sticky_dark_'. $pf2 . 'i_color',
				[
					'label' => __( 'Icon color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-dark .btn-icon' => 'color: {{VALUE}} !important;',
					],
					'condition' => array(
						$pf2.'i_add_icon' => 'true',
					),
					'separator' => 'before'
				]
			);

			$pf->add_control(
				'sticky_dark_' . $pf2 . 'i_fill_color',
				[
					'label' => __( 'Icon fill color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-dark .btn-icon' => 'background: {{VALUE}} !important;',
					],
					'condition' => array(
						$pf2.'i_shape_style' => 'btn-icon-solid',
					),
				]
			);

			$pf->add_control(
				'sticky_dark_' . $pf2 . 'ripple_color',
				[
					'label' => __( 'Icon ripple color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-dark .btn-icon:before' => 'border-color: {{VALUE}} !important;',
					],
					'condition' => array(
						$pf2.'i_shape!' => '',
						$pf2.'i_add_icon' => 'true',
					),
				]
			);
	
			$pf->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'sticky_dark_' . $pf2 . 'button_box_shadow',
					'selector' => '{{WRAPPER}}.lqd-active-row-dark .btn',
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
					),
				]
			);

			$pf->end_controls_tab();

			// Hover state
			$pf->start_controls_tab(
				'sticky_dark_' . $pf2 . 'button_style_hover_tab',
				[
					'label' => __( 'Hover', 'archub-elementor-addons' ),
				]
			);

			$pf->add_control(
				'sticky_dark_' . $pf2 . 'htext_color',
				[
					'label' => __( 'Text color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-dark .btn:hover, {{WRAPPER}}.lqd-active-row-dark .btn:focus' => 'color: {{VALUE}} !important;',
					],
				]
			);

			$pf->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name' => 'sticky_dark_' . $pf2 . 'button_background_hover',
					'label' => __( 'Background', 'archub-elementor-addons' ),
					'types' => [ 'classic', 'gradient' ],
					'exclude' => [ 'image' ],
					'selector' => '{{WRAPPER}}.lqd-active-row-dark .btn:hover, {{WRAPPER}}.lqd-active-row-dark .btn:focus',
					'fields_options' => [
						'background' => [
							'default' => 'classic',
						],
						'color' => [
							'global' => [
								'default' => Global_Colors::COLOR_PRIMARY,
							],
						],
					],
					'separator' => 'before',
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
					),
				]
			);

			$pf->add_control(
				'sticky_dark_' . $pf2 . 'h_b_color_solid',
				[
					'label' => __( 'Border color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-dark .btn:hover, {{WRAPPER}}.lqd-active-row-dark .btn:focus' => 'border-color: {{VALUE}} !important;',
					],
					'separator' => 'before',
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
					),
				]
			);

			$pf->add_control(
				'sticky_dark_' . $pf2 . 'h_b_color',
				[
					'label' => __( 'Border color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-dark .btn-txt:after' => 'background: {{VALUE}} !important;',
					],
					'separator' => 'before',
					'condition' => array(
						$pf2.'style' => array( 'btn-underlined' ),
					),
				]
			);

			$pf->add_control(
				'sticky_dark_' . $pf2 . 'i_hcolor',
				[
					'label' => __( 'Icon color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-dark .btn:hover .btn-icon, {{WRAPPER}}.lqd-active-row-dark .btn:focus .btn-icon' => 'color: {{VALUE}} !important;',
					],
					'condition' => array(
						$pf2.'i_add_icon' => 'true',
					),
					'separator' => 'before'
				]
			);

			$pf->add_control(
				'sticky_dark_' . $pf2 . 'i_fill_hcolor',
				[
					'label' => __( 'Icon fill color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-dark .btn:hover .btn-icon, {{WRAPPER}}.lqd-active-row-dark .btn:focus .btn-icon' => 'background: {{VALUE}} !important;',
					],
					'condition' => array(
						$pf2.'i_shape_style' => array('btn-icon-solid', 'btn-icon-bordered'),
					),
				]
			);

			$pf->add_control(
				'sticky_dark_' . $pf2 . 'h_ripple_color',
				[
					'label' => __( 'Icon ripple color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}.lqd-active-row-dark .btn:hover .btn-icon:before, {{WRAPPER}}.lqd-active-row-dark .btn:focus .btn-icon:before' => 'border-color: {{VALUE}} !important;',
					],
					'condition' => array(
						$pf2.'i_shape!' => '',
						$pf2.'i_add_icon' => 'true',
					),
				]
			);
	
			$pf->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'sticky_dark_' . $pf2 . 'h_button_box_shadow',
					'selector' => '{{WRAPPER}}.lqd-active-row-dark .btn:hover, {{WRAPPER}}.lqd-active-row-dark .btn:focus',
					'condition' => array(
						$pf2.'style' => array( 'btn-solid' ),
					),
				]
			);

			$pf->end_controls_tab();
			$pf->end_controls_tabs();
		
		$pf->end_controls_section();

}