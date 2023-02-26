<?php 

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

function ld_el_nav_trigger($pf, $pf2, $condition = ''){

    // General Section
    $pf->start_controls_section(
        $pf2.'general_section',
        [
            'label' => __( 'Trigger button', 'archub-elementor-addons' ),
        ]
    );

    $pf->add_control(
        $pf2.'style',
        [
            'label' => __( 'Style', 'archub-elementor-addons' ),
            'type' => Controls_Manager::SELECT,
            'default' => 'style-1',
            'options' => [
                'style-1' => __( 'Style 1', 'archub-elementor-addons' ),
                'style-2' => __( 'Style 2', 'archub-elementor-addons' ),
                'style-3' => __( 'Style 3', 'archub-elementor-addons' ),
                'style-4' => __( 'Style 4', 'archub-elementor-addons' ),
                'style-5' => __( 'Style 5', 'archub-elementor-addons' ),
                'style-6' => __( 'Style 6', 'archub-elementor-addons' ),
            ],
        ]
    );

    $pf->add_control(
        $pf2.'text',
        [
            'label' => __( 'Text', 'archub-elementor-addons' ),
            'type' => Controls_Manager::TEXT,
            'default' => __( 'Menu', 'archub-elementor-addons' ),
            'placeholder' => __( 'Add text near the trigger', 'archub-elementor-addons' ),
        ]
    );

    $pf->add_control(
        $pf2.'position',
        [
            'label' => __( 'Text alignment', 'archub-elementor-addons' ),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'txt-left' => [
                    'title' => __( 'Left', 'archub-elementor-addons' ),
                    'icon' => 'eicon-h-align-left',
                ],
                'txt-right' => [
                    'title' => __( 'Right', 'archub-elementor-addons' ),
                    'icon' => 'eicon-h-align-right',
                ],
            ],
            'default' => 'txt-left',
            'toggle' => false,
        ]
    );

    $pf->add_control(
        $pf2.'trigger_type',
        [
            'label' => __( 'Trigger type', 'archub-elementor-addons' ),
            'type' => Controls_Manager::SELECT,
            'default' => 'click',
            'options' => [
                'hover' => __( 'Hover', 'archub-elementor-addons' ),
                'click' => __( 'Click', 'archub-elementor-addons' ),
            ],
        ]
    );

    if ( 'ld_header_sidedrawer' === $pf->get_name() ) {

        $pf->add_control(
			$pf2.'clone_trigger',
			[
				'label' => __( 'Add close button inside sidedrawer?', 'hub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hub-elementor-addons' ),
				'label_off' => __( 'Off', 'hub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		); 

    }


    if ( empty($pf2) ){
        $pf->add_control(
            $pf2.'target_id',
            [
                'label' => __( 'ID of the target', 'archub-elementor-addons' ),
                'type' => Controls_Manager::TEXT,
                'description' => __( 'Add id of the target for trigger button, for ex. target_id', 'archub-elementor-addons' ),
            ]
        );
    } 

    $pf->end_controls_section();

    // Typography
    $pf->start_controls_section(
        $pf2.'tigger_typography_section',
        [
            'label' => __( 'Trigger typography', 'archub-elementor-addons' ),
            'tab' => Controls_Manager::TAB_STYLE,
        ]
    );

    $pf->add_group_control(
        Group_Control_Typography::get_type(),
        [
            'name' => $pf2.'trigger_typography',
            'label' => __( 'Typography', 'archub-elementor-addons' ),
            'selector' => '{{WRAPPER}} .nav-trigger',
        ]
    );

    $pf->end_controls_section();

    // Spacing & Size
    $pf->start_controls_section(
        $pf2.'trigger_spacing_and_size_section',
        [
            'label' => __( 'Trigger spacing & size', 'archub-elementor-addons' ),
            'tab' => Controls_Manager::TAB_STYLE,
        ]
    );

    $pf->add_responsive_control(
        $pf2.'trigger_txt_space_left',
        [
            'label' => __( 'Shape space', 'archub-elementor-addons' ),
            'type' => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em' ],
            'default' => [
                'unit' => 'px',
                'size' => 0,
            ],
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
                '{{WRAPPER}} .nav-trigger .txt' => 'margin-inline-end: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                $pf2.'position' => 'txt-left'
            ]
        ]
    );

    $pf->add_responsive_control(
        $pf2.'trigger_txt_space_right',
        [
            'label' => __( 'Shape space', 'archub-elementor-addons' ),
            'type' => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em' ],
            'default' => [
                'unit' => 'px',
                'size' => 0,
            ],
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
                '{{WRAPPER}} .nav-trigger .txt' => 'margin-inline-start: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                $pf2.'position' => 'txt-right'
            ]
        ]
    );

    $pf->add_responsive_control(
        $pf2.'trigger_custom_w',
        [
            'label' => __( 'Shape width', 'archub-elementor-addons' ),
            'type' => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em' ],
            'default' => [
                'unit' => 'px',
                'size' => 55,
            ],
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
                '{{WRAPPER}} .nav-trigger .bars' => 'width: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    $pf->add_responsive_control(
        $pf2.'trigger_custom_h',
        [
            'label' => __( 'Shape height', 'archub-elementor-addons' ),
            'type' => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em' ],
            'default' => [
                'unit' => 'px',
                'size' => 55,
            ],
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
                '{{WRAPPER}} .nav-trigger .bars' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    $pf->add_responsive_control(
        $pf2.'trigger_padding',
        [
            'label' => __( 'Trigger padding', 'archub-elementor-addons' ),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'selectors' => [
                '{{WRAPPER}} .nav-trigger' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $pf->end_controls_section();

    // Border
    $pf->start_controls_section(
        $pf2.'trigger_border_section',
        [
            'label' => __( 'Trigger borders', 'archub-elementor-addons' ),
            'tab' => Controls_Manager::TAB_STYLE,
        ]
    );

    $pf->add_control(
        $pf2.'trigger_border_heading',
        [
            'label' => esc_html__( 'Trigger border', 'archub-elementor-addons' ),
            'type' => Controls_Manager::HEADING,
        ]
    );

    $pf->add_group_control(
        Group_Control_Border::get_type(),
        [
            'label' => __( 'Trigger border', 'archub-elementor-addons' ),
            'name' => $pf2.'trigger_border',
            'selector' => '{{WRAPPER}} .nav-trigger',
        ]
    );

    $pf->add_control(
        $pf2.'trigger_shape_border_heading',
        [
            'label' => esc_html__( 'Trigger shape border', 'archub-elementor-addons' ),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
        ]
    );

    $pf->add_group_control(
        Group_Control_Border::get_type(),
        [
            'label' => __( 'Trigger shape border', 'archub-elementor-addons' ),
            'name' => $pf2.'trigger_shape_border',
            'selector' => '{{WRAPPER}} .nav-trigger .bars',
        ]
    );

    $pf->add_responsive_control(
        $pf2.'trigger_border_radius',
        [
            'label' => __( 'Trigger roundness', 'archub-elementor-addons' ),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'selectors' => [
                '{{WRAPPER}} .nav-trigger' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'separator' => 'before',
        ]
    );

    $pf->end_controls_section();
    

    // Colors
    $pf->start_controls_section(
        $pf2.'tigger_color_section',
        [
            'label' => __( 'Trigger colors', 'archub-elementor-addons' ),
            'tab' => Controls_Manager::TAB_STYLE,
        ]
    );

    $pf->add_control(
        $pf2.'trigger_bg_heading',
        [
            'label' => esc_html__( 'Background', 'archub-elementor-addons' ),
            'type' => Controls_Manager::HEADING,
        ]
    );

    $pf->add_group_control(
        Group_Control_Background::get_type(),
        [
            'name' => $pf2.'trigger_bg',
            'label' => __( 'Background', 'archub-elementor-addons' ),
            'types' => [ 'classic', 'gradient' ],
            'exclude' => [ 'image' ],
            'selector' => '{{WRAPPER}} .nav-trigger',
        ]
    );

    $pf->add_control(
        $pf2.'trigger_bg_hover_heading',
        [
            'label' => esc_html__( 'Hover background', 'archub-elementor-addons' ),
            'type' => Controls_Manager::HEADING,
        ]
    );

    $pf->add_group_control(
        Group_Control_Background::get_type(),
        [
            'name' => $pf2.'trigger_bg_hover',
            'label' => __( 'Background', 'archub-elementor-addons' ),
            'types' => [ 'classic', 'gradient' ],
            'exclude' => [ 'image' ],
            'selector' => '{{WRAPPER}} .nav-trigger:hover',
        ]
    );

    $pf->add_control(
        $pf2.'trigger_bg_active_heading',
        [
            'label' => esc_html__( 'Active background', 'archub-elementor-addons' ),
            'type' => Controls_Manager::HEADING,
        ]
    );

    $pf->add_group_control(
        Group_Control_Background::get_type(),
        [
            'name' => $pf2.'trigger_bg_active',
            'label' => __( 'Background', 'archub-elementor-addons' ),
            'types' => [ 'classic', 'gradient' ],
            'exclude' => [ 'image' ],
            'selector' => '{{WRAPPER}} .nav-trigger.is-active',
        ]
    );

    $pf->add_control(
        $pf2.'trigger_shape_bg_heading',
        [
            'label' => esc_html__( 'Shape background', 'archub-elementor-addons' ),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
        ]
    );

    $pf->add_group_control(
        Group_Control_Background::get_type(),
        [
            'name' => $pf2.'trigger_shape_bg',
            'label' => __( 'Shape background', 'archub-elementor-addons' ),
            'types' => [ 'classic', 'gradient' ],
            'exclude' => [ 'image' ],
            'selector' => '{{WRAPPER}} .nav-trigger .bars',
        ]
    );

    $pf->add_control(
        $pf2.'trigger_shape_bg_hover_heading',
        [
            'label' => esc_html__( 'Hover shape background', 'archub-elementor-addons' ),
            'type' => Controls_Manager::HEADING,
        ]
    );

    $pf->add_group_control(
        Group_Control_Background::get_type(),
        [
            'name' => $pf2.'trigger_shape_bg_hover',
            'label' => __( 'Hover shape background', 'archub-elementor-addons' ),
            'types' => [ 'classic', 'gradient' ],
            'exclude' => [ 'image' ],
            'selector' => '{{WRAPPER}} .nav-trigger:hover .bars',
        ]
    );

    $pf->add_control(
        $pf2.'trigger_shape_bg_active_heading',
        [
            'label' => esc_html__( 'Active shape background', 'archub-elementor-addons' ),
            'type' => Controls_Manager::HEADING,
        ]
    );

    $pf->add_group_control(
        Group_Control_Background::get_type(),
        [
            'name' => $pf2.'trigger_shape_bg_active',
            'label' => __( 'Active shape background', 'archub-elementor-addons' ),
            'types' => [ 'classic', 'gradient' ],
            'exclude' => [ 'image' ],
            'selector' => '{{WRAPPER}} .nav-trigger.is-active .bars',
        ]
    );

    $pf->add_control(
        $pf2.'trigger_color',
        [
            'label' => __( 'Color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .nav-trigger' => 'color: {{VALUE}}',
            ],
            'separator' => 'before',
        ]
    );

    $pf->add_control(
        $pf2.'trigger_color_hover',
        [
            'label' => __( 'Hover color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .nav-trigger:hover' => 'color: {{VALUE}}',
            ],
        ]
    );

    $pf->add_control(
        $pf2.'trigger_color_active',
        [
            'label' => __( 'Active color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .nav-trigger.is-active' => 'color: {{VALUE}}',
            ],
        ]
    );

    $pf->add_control(
        $pf2.'trigger_text_color',
        [
            'label' => __( 'Text color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .nav-trigger .txt' => 'color: {{VALUE}}',
            ],
            'separator' => 'before'
        ]
    );

    $pf->add_control(
        $pf2.'trigger_text_color_hover',
        [
            'label' => __( 'Hover text color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .nav-trigger:hover > .txt' => 'color: {{VALUE}}',
            ],
        ]
    );

    $pf->add_control(
        $pf2.'trigger_text_color_active',
        [
            'label' => __( 'Active text color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .nav-trigger.is-active > .txt' => 'color: {{VALUE}}',
            ],
        ]
    );

    $pf->add_control(
        $pf2.'trigger_shape_color',
        [
            'label' => __( 'Shape color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .nav-trigger .bar' => 'color: {{VALUE}}',
            ],
            'separator' => 'before'
        ]
    );

    $pf->add_control(
        $pf2.'trigger_shape_color_hover',
        [
            'label' => __( 'Hover shape color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .nav-trigger:hover .bar' => 'color: {{VALUE}}',
            ],
        ]
    );

    $pf->add_control(
        $pf2.'trigger_shape_color_active',
        [
            'label' => __( 'Active shape color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .nav-trigger.is-active .bar' => 'color: {{VALUE}}',
            ],
        ]
    );

    $pf->add_control(
        $pf2.'trigger_border_color_hover',
        [
            'label' => __( 'Hover border color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .nav-trigger:hover' => 'border-color: {{VALUE}}',
            ],
            'condition' => [
                $pf2.'trigger_border_border!' => ''
            ],
            'separator' => 'before',
        ]
    );

    $pf->add_control(
        $pf2.'trigger_border_color_active',
        [
            'label' => __( 'Active border color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .nav-trigger.is-active' => 'border-color: {{VALUE}}',
            ],
            'condition' => [
                $pf2.'trigger_border_border!' => ''
            ],
        ]
    );

    $pf->add_control(
        $pf2.'trigger_shape_border_color_hover',
        [
            'label' => __( 'Hover shape border color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .nav-trigger:hover .bars' => 'border-color: {{VALUE}}',
            ],
            'condition' => [
                $pf2.'trigger_shape_border_border!' => ''
            ],
            'separator' => 'before',
        ]
    );

    $pf->add_control(
        $pf2.'trigger_shape_border_color_active',
        [
            'label' => __( 'Active shape border color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .nav-trigger.is-active .bars' => 'border-color: {{VALUE}}',
            ],
            'condition' => [
                $pf2.'trigger_shape_border_border!' => ''
            ],
        ]
    );

    $pf->end_controls_section();

    // Sticky Colors
    $pf->start_controls_section(
        $pf2.'sticky_color_section',
        [
            'label' => __( 'Trigger sticky colors', 'archub-elementor-addons' ),
            'tab' => Controls_Manager::TAB_STYLE,
        ]
    );

    $pf->add_control(
        $pf2.'sticky_trigger_bg_heading',
        [
            'label' => esc_html__( 'Background', 'archub-elementor-addons' ),
            'type' => Controls_Manager::HEADING,
        ]
    );

    $pf->add_group_control(
        Group_Control_Background::get_type(),
        [
            'name' => $pf2.'sticky_trigger_bg',
            'label' => __( 'Background', 'archub-elementor-addons' ),
            'types' => [ 'classic', 'gradient' ],
            'exclude' => [ 'image' ],
            'selector' => '.is-stuck {{WRAPPER}} .nav-trigger',
        ]
    );

    $pf->add_control(
        $pf2.'sticky_trigger_bg_hover_heading',
        [
            'label' => esc_html__( 'Hover background', 'archub-elementor-addons' ),
            'type' => Controls_Manager::HEADING,
        ]
    );

    $pf->add_group_control(
        Group_Control_Background::get_type(),
        [
            'name' => $pf2.'sticky_trigger_bg_hover',
            'label' => __( 'Background', 'archub-elementor-addons' ),
            'types' => [ 'classic', 'gradient' ],
            'exclude' => [ 'image' ],
            'selector' => '.is-stuck {{WRAPPER}} .nav-trigger:hover',
        ]
    );

    $pf->add_control(
        $pf2.'sticky_trigger_bg_active_heading',
        [
            'label' => esc_html__( 'Active background', 'archub-elementor-addons' ),
            'type' => Controls_Manager::HEADING,
        ]
    );

    $pf->add_group_control(
        Group_Control_Background::get_type(),
        [
            'name' => $pf2.'sticky_trigger_bg_active',
            'label' => __( 'Background', 'archub-elementor-addons' ),
            'types' => [ 'classic', 'gradient' ],
            'exclude' => [ 'image' ],
            'selector' => '.is-stuck {{WRAPPER}} .nav-trigger.is-active',
        ]
    );

    $pf->add_control(
        $pf2.'sticky_trigger_shape_bg_heading',
        [
            'label' => esc_html__( 'Shape background', 'archub-elementor-addons' ),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
        ]
    );

    $pf->add_group_control(
        Group_Control_Background::get_type(),
        [
            'name' => $pf2.'sticky_trigger_shape_bg',
            'label' => __( 'Shape background', 'archub-elementor-addons' ),
            'types' => [ 'classic', 'gradient' ],
            'exclude' => [ 'image' ],
            'selector' => '.is-stuck {{WRAPPER}} .nav-trigger .bars',
        ]
    );

    $pf->add_control(
        $pf2.'sticky_trigger_shape_bg_hover_heading',
        [
            'label' => esc_html__( 'Hover shape background', 'archub-elementor-addons' ),
            'type' => Controls_Manager::HEADING,
        ]
    );

    $pf->add_group_control(
        Group_Control_Background::get_type(),
        [
            'name' => $pf2.'sticky_trigger_shape_bg_hover',
            'label' => __( 'Hover shape background', 'archub-elementor-addons' ),
            'types' => [ 'classic', 'gradient' ],
            'exclude' => [ 'image' ],
            'selector' => '.is-stuck {{WRAPPER}} .nav-trigger:hover .bars',
        ]
    );

    $pf->add_control(
        $pf2.'sticky_trigger_shape_bg_active_heading',
        [
            'label' => esc_html__( 'Active shape background', 'archub-elementor-addons' ),
            'type' => Controls_Manager::HEADING,
        ]
    );

    $pf->add_group_control(
        Group_Control_Background::get_type(),
        [
            'name' => $pf2.'sticky_trigger_shape_bg_active',
            'label' => __( 'Active shape background', 'archub-elementor-addons' ),
            'types' => [ 'classic', 'gradient' ],
            'exclude' => [ 'image' ],
            'selector' => '.is-stuck {{WRAPPER}} .nav-trigger.is-active .bars',
        ]
    );

    $pf->add_control(
        $pf2.'sticky_trigger_color',
        [
            'label' => __( 'Color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '.is-stuck {{WRAPPER}} .nav-trigger' => 'color: {{VALUE}}',
            ],
            'separator' => 'before'
        ]
    );

    $pf->add_control(
        $pf2.'sticky_trigger_color_hover',
        [
            'label' => __( 'Hover color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '.is-stuck {{WRAPPER}} .nav-trigger:hover' => 'color: {{VALUE}}',
            ],
        ]
    );

    $pf->add_control(
        $pf2.'sticky_trigger_color_active',
        [
            'label' => __( 'Active color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '.is-stuck {{WRAPPER}} .nav-trigger.is-active' => 'color: {{VALUE}}',
            ],
        ]
    );

    $pf->add_control(
        $pf2.'sticky_trigger_text_color',
        [
            'label' => __( 'Text color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '.is-stuck {{WRAPPER}} .nav-trigger .txt' => 'color: {{VALUE}}',
            ],
            'separator' => 'before'
        ]
    );

    $pf->add_control(
        $pf2.'sticky_trigger_text_color_hover',
        [
            'label' => __( 'Hover text color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '.is-stuck {{WRAPPER}} .nav-trigger:hover > .txt' => 'color: {{VALUE}}',
            ],
        ]
    );

    $pf->add_control(
        $pf2.'sticky_trigger_text_color_active',
        [
            'label' => __( 'Active text color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '.is-stuck {{WRAPPER}} .nav-trigger.is-active > .txt' => 'color: {{VALUE}}',
            ],
        ]
    );

    $pf->add_control(
        $pf2.'sticky_trigger_shape_color',
        [
            'label' => __( 'Shape color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '.is-stuck {{WRAPPER}} .nav-trigger .bar' => 'color: {{VALUE}}',
            ],
            'separator' => 'before'
        ]
    );

    $pf->add_control(
        $pf2.'sticky_trigger_shape_color_hover',
        [
            'label' => __( 'Hover shape color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '.is-stuck {{WRAPPER}} .nav-trigger:hover .bar' => 'color: {{VALUE}}',
            ],
        ]
    );

    $pf->add_control(
        $pf2.'sticky_trigger_shape_color_active',
        [
            'label' => __( 'Active shape color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '.is-stuck {{WRAPPER}} .nav-trigger.is-active .bar' => 'color: {{VALUE}}',
            ],
        ]
    );

    $pf->add_control(
        $pf2.'sticky_trigger_border_color',
        [
            'label' => __( 'Border color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '.is-stuck {{WRAPPER}} .nav-trigger' => 'border-color: {{VALUE}}',
            ],
            'condition' => [
                $pf2.'trigger_border_border!' => ''
            ],
            'separator' => 'before',
        ]
    );

    $pf->add_control(
        $pf2.'sticky_trigger_border_color_hover',
        [
            'label' => __( 'Hover border color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '.is-stuck {{WRAPPER}} .nav-trigger:hover' => 'border-color: {{VALUE}}',
            ],
            'condition' => [
                $pf2.'trigger_border_border!' => ''
            ],
        ]
    );

    $pf->add_control(
        $pf2.'sticky_trigger_border_color_active',
        [
            'label' => __( 'Active border color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '.is-stuck {{WRAPPER}} .nav-trigger.is-active' => 'border-color: {{VALUE}}',
            ],
            'condition' => [
                $pf2.'trigger_border_border!' => ''
            ],
        ]
    );

    $pf->add_control(
        $pf2.'sticky_trigger_shape_border_color',
        [
            'label' => __( 'Shape border color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '.is-stuck {{WRAPPER}} .nav-trigger .bars' => 'border-color: {{VALUE}}',
            ],
            'condition' => [
                $pf2.'trigger_shape_border_border!' => ''
            ],
            'separator' => 'before',
        ]
    );

    $pf->add_control(
        $pf2.'sticky_trigger_shape_border_color_hover',
        [
            'label' => __( 'Hover shape border color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '.is-stuck {{WRAPPER}} .nav-trigger:hover .bars' => 'border-color: {{VALUE}}',
            ],
            'condition' => [
                $pf2.'trigger_shape_border_border!' => ''
            ],
        ]
    );

    $pf->add_control(
        $pf2.'sticky_trigger_shape_border_color_active',
        [
            'label' => __( 'Active shape border color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '.is-stuck {{WRAPPER}} .nav-trigger.is-active .bars' => 'border-color: {{VALUE}}',
            ],
            'condition' => [
                $pf2.'trigger_shape_border_border!' => ''
            ],
        ]
    );

    $pf->end_controls_section();

    // Colors Over Light Rows
    $pf->start_controls_section(
        $pf2.'sticky_light_section',
        [
            'label' => __( 'Trigger colors over light rows', 'archub-elementor-addons' ),
            'tab' => Controls_Manager::TAB_STYLE,
        ]
    );

    $pf->add_control(
        $pf2.'sticky_light_trigger_bg_heading',
        [
            'label' => esc_html__( 'Background', 'archub-elementor-addons' ),
            'type' => Controls_Manager::HEADING,
        ]
    );

    $pf->add_group_control(
        Group_Control_Background::get_type(),
        [
            'name' => $pf2.'sticky_light_trigger_bg',
            'label' => __( 'Background', 'archub-elementor-addons' ),
            'types' => [ 'classic', 'gradient' ],
            'exclude' => [ 'image' ],
            'selector' => '{{WRAPPER}}.lqd-active-row-light .nav-trigger',
        ]
    );

    $pf->add_control(
        $pf2.'sticky_light_trigger_bg_hover_heading',
        [
            'label' => esc_html__( 'Hover background', 'archub-elementor-addons' ),
            'type' => Controls_Manager::HEADING,
        ]
    );

    $pf->add_group_control(
        Group_Control_Background::get_type(),
        [
            'name' => $pf2.'sticky_light_trigger_bg_hover',
            'label' => __( 'Background', 'archub-elementor-addons' ),
            'types' => [ 'classic', 'gradient' ],
            'exclude' => [ 'image' ],
            'selector' => '{{WRAPPER}}.lqd-active-row-light .nav-trigger:hover',
        ]
    );

    $pf->add_control(
        $pf2.'sticky_light_trigger_bg_active_heading',
        [
            'label' => esc_html__( 'Active background', 'archub-elementor-addons' ),
            'type' => Controls_Manager::HEADING,
        ]
    );

    $pf->add_group_control(
        Group_Control_Background::get_type(),
        [
            'name' => $pf2.'sticky_light_trigger_bg_active',
            'label' => __( 'Background', 'archub-elementor-addons' ),
            'types' => [ 'classic', 'gradient' ],
            'exclude' => [ 'image' ],
            'selector' => '{{WRAPPER}}.lqd-active-row-light .nav-trigger.is-active',
        ]
    );



    $pf->add_control(
        $pf2.'sticky_light_trigger_shape_bg_heading',
        [
            'label' => esc_html__( 'Shape background', 'archub-elementor-addons' ),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
        ]
    );

    $pf->add_group_control(
        Group_Control_Background::get_type(),
        [
            'name' => $pf2.'sticky_light_trigger_shape_bg',
            'label' => __( 'Shape background', 'archub-elementor-addons' ),
            'types' => [ 'classic', 'gradient' ],
            'exclude' => [ 'image' ],
            'selector' => '{{WRAPPER}}.lqd-active-row-light .nav-trigger .bars',
        ]
    );

    $pf->add_control(
        $pf2.'sticky_light_trigger_shape_bg_hover_heading',
        [
            'label' => esc_html__( 'Hover shape background', 'archub-elementor-addons' ),
            'type' => Controls_Manager::HEADING,
        ]
    );

    $pf->add_group_control(
        Group_Control_Background::get_type(),
        [
            'name' => $pf2.'sticky_light_trigger_shape_bg_hover',
            'label' => __( 'Hover shape background', 'archub-elementor-addons' ),
            'types' => [ 'classic', 'gradient' ],
            'exclude' => [ 'image' ],
            'selector' => '{{WRAPPER}}.lqd-active-row-light .nav-trigger:hover .bars',
        ]
    );

    $pf->add_control(
        $pf2.'sticky_light_trigger_shape_bg_active_heading',
        [
            'label' => esc_html__( 'Active shape background', 'archub-elementor-addons' ),
            'type' => Controls_Manager::HEADING,
        ]
    );

    $pf->add_group_control(
        Group_Control_Background::get_type(),
        [
            'name' => $pf2.'sticky_light_trigger_shape_bg_active',
            'label' => __( 'Active shape background', 'archub-elementor-addons' ),
            'types' => [ 'classic', 'gradient' ],
            'exclude' => [ 'image' ],
            'selector' => '{{WRAPPER}}.lqd-active-row-light .nav-trigger.is-active .bars',
        ]
    );

    $pf->add_control(
        $pf2.'sticky_light_trigger_color',
        [
            'label' => __( 'Color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}.lqd-active-row-light .nav-trigger' => 'color: {{VALUE}};'
            ],
            'separator' => 'before'
        ]
    );

    $pf->add_control(
        $pf2.'sticky_light_trigger_color_hover',
        [
            'label' => __( 'Hover color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}.lqd-active-row-light .nav-trigger:hover' => 'color: {{VALUE}};',
            ],
        ]
    );

    $pf->add_control(
        $pf2.'sticky_light_trigger_color_active',
        [
            'label' => __( 'Active color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}.lqd-active-row-light .nav-trigger.is-active' => 'color: {{VALUE}};',
            ],
        ]
    );

    $pf->add_control(
        $pf2.'sticky_light_trigger_text_color',
        [
            'label' => __( 'Text color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}.lqd-active-row-light .nav-trigger > .txt' => 'color: {{VALUE}}',
            ],
            'separator' => 'before'
        ]
    );

    $pf->add_control(
        $pf2.'sticky_light_trigger_text_color_hover',
        [
            'label' => __( 'Hover text color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}.lqd-active-row-light .nav-trigger:hover > .txt' => 'color: {{VALUE}}',
            ],
        ]
    );

    $pf->add_control(
        $pf2.'sticky_light_trigger_text_color_active',
        [
            'label' => __( 'Active text color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}.lqd-active-row-light .nav-trigger.is-active > .txt' => 'color: {{VALUE}}',
            ],
        ]
    );

    $pf->add_control(
        $pf2.'sticky_light_trigger_shape_color',
        [
            'label' => __( 'Shape color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}.lqd-active-row-light .nav-trigger .bar' => 'color: {{VALUE}}',
            ],
            'separator' => 'before'
        ]
    );

    $pf->add_control(
        $pf2.'sticky_light_trigger_shape_color_hover',
        [
            'label' => __( 'Hover shape color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}.lqd-active-row-light .nav-trigger:hover .bar' => 'color: {{VALUE}}',
            ],
        ]
    );

    $pf->add_control(
        $pf2.'sticky_light_trigger_shape_color_active',
        [
            'label' => __( 'Active shape color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}.lqd-active-row-light .nav-trigger.is-active .bar' => 'color: {{VALUE}}',
            ],
        ]
    );

    $pf->add_control(
        $pf2.'sticky_light_trigger_border_color',
        [
            'label' => __( 'Border color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}.lqd-active-row-light .nav-trigger' => 'border-color: {{VALUE}}',
            ],
            'condition' => [
                $pf2.'trigger_border_border!' => ''
            ],
            'separator' => 'before',
        ]
    );

    $pf->add_control(
        $pf2.'sticky_light_trigger_border_color_hover',
        [
            'label' => __( 'Hover border color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}.lqd-active-row-light .nav-trigger:hover' => 'border-color: {{VALUE}}',
            ],
            'condition' => [
                $pf2.'trigger_border_border!' => ''
            ],
        ]
    );

    $pf->add_control(
        $pf2.'sticky_light_trigger_border_color_active',
        [
            'label' => __( 'Active border color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}.lqd-active-row-light .nav-trigger.is-active' => 'border-color: {{VALUE}}',
            ],
            'condition' => [
                $pf2.'trigger_border_border!' => ''
            ],
        ]
    );

    $pf->add_control(
        $pf2.'sticky_light_trigger_shape_border_color',
        [
            'label' => __( 'Shape border color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}.lqd-active-row-light .nav-trigger .bars' => 'border-color: {{VALUE}}',
            ],
            'condition' => [
                $pf2.'trigger_shape_border_border!' => ''
            ],
            'separator' => 'before',
        ]
    );

    $pf->add_control(
        $pf2.'sticky_light_trigger_shape_border_color_hover',
        [
            'label' => __( 'Hover shape border color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}.lqd-active-row-light .nav-trigger:hover .bars' => 'border-color: {{VALUE}}',
            ],
            'condition' => [
                $pf2.'trigger_shape_border_border!' => ''
            ],
        ]
    );

    $pf->add_control(
        $pf2.'sticky_light_trigger_shape_border_color_active',
        [
            'label' => __( 'Active shape border color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}.lqd-active-row-light .nav-trigger.is-active .bars' => 'border-color: {{VALUE}}',
            ],
            'condition' => [
                $pf2.'trigger_shape_border_border!' => ''
            ],
        ]
    );

    $pf->end_controls_section();

    // Colors Over Dark Rows
    $pf->start_controls_section(
        $pf2.'sticky_dark_section',
        [
            'label' => __( 'Trigger colors over dark rows', 'archub-elementor-addons' ),
            'tab' => Controls_Manager::TAB_STYLE,
        ]
    );

    $pf->add_control(
        $pf2.'sticky_dark_trigger_bg_heading',
        [
            'label' => esc_html__( 'Background', 'archub-elementor-addons' ),
            'type' => Controls_Manager::HEADING,
        ]
    );

    $pf->add_group_control(
        Group_Control_Background::get_type(),
        [
            'name' => $pf2.'sticky_dark_trigger_bg',
            'label' => __( 'Background', 'archub-elementor-addons' ),
            'types' => [ 'classic', 'gradient' ],
            'exclude' => [ 'image' ],
            'selector' => '{{WRAPPER}}.lqd-active-row-dark .nav-trigger',
        ]
    );

    $pf->add_control(
        $pf2.'sticky_dark_trigger_bg_hover_heading',
        [
            'label' => esc_html__( 'Hover background', 'archub-elementor-addons' ),
            'type' => Controls_Manager::HEADING,
        ]
    );

    $pf->add_group_control(
        Group_Control_Background::get_type(),
        [
            'name' => $pf2.'sticky_dark_trigger_bg_hover',
            'label' => __( 'Background', 'archub-elementor-addons' ),
            'types' => [ 'classic', 'gradient' ],
            'exclude' => [ 'image' ],
            'selector' => '{{WRAPPER}}.lqd-active-row-dark .nav-trigger:hover',
        ]
    );

    $pf->add_control(
        $pf2.'sticky_dark_trigger_bg_active_heading',
        [
            'label' => esc_html__( 'Active background', 'archub-elementor-addons' ),
            'type' => Controls_Manager::HEADING,
        ]
    );

    $pf->add_group_control(
        Group_Control_Background::get_type(),
        [
            'name' => $pf2.'sticky_dark_trigger_bg_active',
            'label' => __( 'Background', 'archub-elementor-addons' ),
            'types' => [ 'classic', 'gradient' ],
            'exclude' => [ 'image' ],
            'selector' => '{{WRAPPER}}.lqd-active-row-dark .nav-trigger.is-active',
        ]
    );



    $pf->add_control(
        $pf2.'sticky_dark_trigger_shape_bg_heading',
        [
            'label' => esc_html__( 'Shape background', 'archub-elementor-addons' ),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
        ]
    );

    $pf->add_group_control(
        Group_Control_Background::get_type(),
        [
            'name' => $pf2.'sticky_dark_trigger_shape_bg',
            'label' => __( 'Shape background', 'archub-elementor-addons' ),
            'types' => [ 'classic', 'gradient' ],
            'exclude' => [ 'image' ],
            'selector' => '{{WRAPPER}}.lqd-active-row-dark .nav-trigger .bars',
        ]
    );

    $pf->add_control(
        $pf2.'sticky_dark_trigger_shape_bg_hover_heading',
        [
            'label' => esc_html__( 'Hover shape background', 'archub-elementor-addons' ),
            'type' => Controls_Manager::HEADING,
        ]
    );

    $pf->add_group_control(
        Group_Control_Background::get_type(),
        [
            'name' => $pf2.'sticky_dark_trigger_shape_bg_hover',
            'label' => __( 'Hover shape background', 'archub-elementor-addons' ),
            'types' => [ 'classic', 'gradient' ],
            'exclude' => [ 'image' ],
            'selector' => '{{WRAPPER}}.lqd-active-row-dark .nav-trigger:hover .bars',
        ]
    );

    $pf->add_control(
        $pf2.'sticky_dark_trigger_shape_bg_active_heading',
        [
            'label' => esc_html__( 'Active shape background', 'archub-elementor-addons' ),
            'type' => Controls_Manager::HEADING,
        ]
    );

    $pf->add_group_control(
        Group_Control_Background::get_type(),
        [
            'name' => $pf2.'sticky_dark_trigger_shape_bg_active',
            'label' => __( 'Active shape background', 'archub-elementor-addons' ),
            'types' => [ 'classic', 'gradient' ],
            'exclude' => [ 'image' ],
            'selector' => '{{WRAPPER}}.lqd-active-row-dark .nav-trigger.is-active .bars',
        ]
    );

    $pf->add_control(
        $pf2.'sticky_dark_trigger_color',
        [
            'label' => __( 'Color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}.lqd-active-row-dark .nav-trigger' => 'color: {{VALUE}};',
            ],
        ]
    );

    $pf->add_control(
        $pf2.'sticky_dark_trigger_color_hover',
        [
            'label' => __( 'Hover color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}.lqd-active-row-dark .nav-trigger:hover' => 'color: {{VALUE}};',
            ],
        ]
    );

    $pf->add_control(
        $pf2.'sticky_dark_trigger_color_active',
        [
            'label' => __( 'Active color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}.lqd-active-row-dark .nav-trigger.is-active' => 'color: {{VALUE}};',
            ],
        ]
    );

    $pf->add_control(
        $pf2.'sticky_dark_trigger_text_color',
        [
            'label' => __( 'Text color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}.lqd-active-row-dark .nav-trigger > .txt' => 'color: {{VALUE}}',
            ],
            'separator' => 'before'
        ]
    );

    $pf->add_control(
        $pf2.'sticky_dark_trigger_text_color_hover',
        [
            'label' => __( 'Hover text color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}.lqd-active-row-dark .nav-trigger:hover > .txt' => 'color: {{VALUE}}',
            ],
        ]
    );

    $pf->add_control(
        $pf2.'sticky_dark_trigger_text_color_active',
        [
            'label' => __( 'Active text color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}.lqd-active-row-dark .nav-trigger.is-active > .txt' => 'color: {{VALUE}}',
            ],
        ]
    );

    $pf->add_control(
        $pf2.'sticky_dark_trigger_shape_color',
        [
            'label' => __( 'Shape color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}.lqd-active-row-dark .nav-trigger .bar' => 'color: {{VALUE}}',
            ],
            'separator' => 'before'
        ]
    );

    $pf->add_control(
        $pf2.'sticky_dark_trigger_shape_color_hover',
        [
            'label' => __( 'Hover shape color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}.lqd-active-row-dark .nav-trigger:hover .bar' => 'color: {{VALUE}}',
            ],
        ]
    );

    $pf->add_control(
        $pf2.'sticky_dark_trigger_shape_color_active',
        [
            'label' => __( 'Active shape color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}.lqd-active-row-dark .nav-trigger.is-active .bar' => 'color: {{VALUE}}',
            ],
        ]
    );

    $pf->add_control(
        $pf2.'sticky_dark_trigger_border_color',
        [
            'label' => __( 'Border color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}.lqd-active-row-dark .nav-trigger' => 'border-color: {{VALUE}}',
            ],
            'condition' => [
                $pf2.'trigger_border_border!' => ''
            ],
            'separator' => 'before',
        ]
    );

    $pf->add_control(
        $pf2.'sticky_dark_trigger_border_color_hover',
        [
            'label' => __( 'Hover border color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}.lqd-active-row-dark .nav-trigger:hover' => 'border-color: {{VALUE}}',
            ],
            'condition' => [
                $pf2.'trigger_border_border!' => ''
            ],
        ]
    );

    $pf->add_control(
        $pf2.'sticky_dark_trigger_border_color_active',
        [
            'label' => __( 'Active border color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}.lqd-active-row-dark .nav-trigger.is-active' => 'border-color: {{VALUE}}',
            ],
            'condition' => [
                $pf2.'trigger_border_border!' => ''
            ],
        ]
    );

    $pf->add_control(
        $pf2.'sticky_dark_trigger_shape_border_color',
        [
            'label' => __( 'Shape border color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}.lqd-active-row-dark .nav-trigger .bars' => 'border-color: {{VALUE}}',
            ],
            'condition' => [
                $pf2.'trigger_shape_border_border!' => ''
            ],
            'separator' => 'before',
        ]
    );

    $pf->add_control(
        $pf2.'sticky_dark_trigger_shape_border_color_hover',
        [
            'label' => __( 'Hover shape border color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}.lqd-active-row-dark .nav-trigger:hover .bars' => 'border-color: {{VALUE}}',
            ],
            'condition' => [
                $pf2.'trigger_shape_border_border!' => ''
            ],
        ]
    );

    $pf->add_control(
        $pf2.'sticky_dark_trigger_shape_border_color_active',
        [
            'label' => __( 'Active shape border color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}.lqd-active-row-dark .nav-trigger.is-active .bars' => 'border-color: {{VALUE}}',
            ],
            'condition' => [
                $pf2.'trigger_shape_border_border!' => ''
            ],
        ]
    );

    $pf->end_controls_section();

}

function ld_el_nav_trigger_render( $settings, $pf2, $id, $type = '' ) {

        $clone_in_target = false;

        if ( !empty($pf2) ) {
            $data_target = $id;
        } else {
            $target_id = $settings[$pf2.'target_id'];
            $data_target = !empty( $target_id ) ? $target_id : 'main-header-collapse';
        }
        
        if (
            $type === 'header-fullproj' ||
            (
                isset($settings[$pf2.'clone_trigger']) &&
                'yes' === $settings[$pf2.'clone_trigger']
            )
        ) {
            $clone_in_target = true;
        }

        $options = wp_json_encode(
            array(
                'cloneTriggerInTarget' => $clone_in_target,
                'type' => $settings[$pf2.'trigger_type'],
            )
        );

		$classes = array( 
			'nav-trigger',
			'main-nav-trigger',
			'd-flex',
			'pos-rel',
			'align-items-center',
			'justify-content-center',
			'collapsed',
			$settings[$pf2.'style'],
			(!empty($settings[$pf2.'position']) || !empty($settings[$pf2.'text']) ? $settings[$pf2.'position'] : '')
		);

		$classes = apply_filters( 'liquid_trigger_classes', $classes );

		$opts = array(
			'type="button"',
			'data-ld-toggle="true"',
            'data-toggle-options=\'' . $options . '\'',
			'data-toggle="collapse"',
			'data-target="#' . $data_target . '"',
			'aria-expanded="false"',
			'aria-controls="' . $data_target . '"',
		);

		$opts = apply_filters( 'liquid_trigger_opts', $opts );

		
	?>
		<button 
			class="<?php echo ld_helper()->sanitize_html_classes( $classes ) ?>"
			<?php echo implode( ' ', $opts ); ?>
			>
			<span class="bars d-inline-flex align-items-center justify-content-center pos-rel z-index-1">
				<span class="bars-inner d-flex flex-column">
					<span class="bar d-inline-block pos-rel"></span>
					<span class="bar d-inline-block pos-rel"></span>
					<span class="bar d-inline-block pos-rel"></span>
				</span>
			</span>
			<?php if( !empty( $settings[$pf2.'text'] ) ) { ?>
				<?php printf( '<span class="txt d-inline-block">%s</span>', esc_html( $settings[$pf2.'text'] ) ); ?>
			<?php } ?>
		</button>
	<?php

}