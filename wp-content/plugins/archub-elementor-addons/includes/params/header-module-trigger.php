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

function ld_el_module_trigger($pf, $pf2, $type = ''){

    $pf->start_controls_section(
        $pf2.'module_trigger_section',
        [
            'label' => __( 'Trigger Options', 'archub-elementor-addons' ),
        ]
    );

    $pf->add_control(
        $pf2.'trigger_label',
        [
            'label' => __( 'Trigger Label', 'archub-elementor-addons' ),
            'type' => Controls_Manager::TEXT
        ]
    );

    $pf->add_control(
        $pf2.'i_type',
        [
            'label' => __( 'Icon Library', 'archub-elementor-addons' ),
            'type' => Controls_Manager::SELECT,
            'default' => 'icon',
            'options' => [
                'icon'  => __( 'Icon Library', 'archub-elementor-addons' ),
                'image' => __( 'Image', 'archub-elementor-addons' ),
            ],
        ]
    );

    
    if ( $type === 'cart'){
        $default_icon = 'lqd-icn-ess icon-ld-cart';
    } elseif ( $type === 'search') {
        $default_icon = 'lqd-icn-ess icon-ld-search-2';
    } else {
        $default_icon = 'lqd-icn-ess icon-ion-ios-arrow-down';
    }
    
    $pf->add_control(
        $pf2.'i_icon',
        [
            'label' => __( 'Icon', 'archub-elementor-addons' ),
            'type' => Controls_Manager::ICONS,
            'default' => [
                'value' => $default_icon,
                'library' => 'liquid-essentials',
            ],
            'condition' => [
                $pf2.'i_type' => 'icon',
            ],
        ]
    );

    $pf->add_control(
        $pf2.'i_image',
        [
            'label' => __( 'Image', 'archub-elementor-addons' ),
            'type' => Controls_Manager::MEDIA,
            'condition' => [
                $pf2.'i_type' => 'image',
            ],
        ]
    );
    $pf->add_control(
        $pf2.'icon_size',
        [
            'label' => __( 'Icon Size', 'archub-elementor-addons' ),
            'type' => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em' ],
            'range' => [
                'px' => [
                    'min' => 1,
                    'max' => 100,
                    'step' => 1,
                ],
                'em' => [
                    'min' => 1,
                    'max' => 10,
                    'step' => 0.1,
                ],
            ],
            'default' => [
                'unit' => 'em',
                'size' => 1,
            ],
            'selectors' => [
                '{{WRAPPER}} .ld-module-trigger-icon' => 'font-size: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                $pf2.'i_type' => 'icon',
            ],
        ]
    );

    $pf->add_control(
        $pf2.'icon_text_align',
        [
            'label' => __( 'Text Position', 'archub-elementor-addons' ),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'lqd-module-trigger-txt-left' => [
                    'title' => __( 'Left', 'archub-elementor-addons' ),
                    'icon' => 'eicon-h-align-left',
                ],
                'lqd-module-trigger-txt-right' => [
                    'title' => __( 'Right', 'archub-elementor-addons' ),
                    'icon' => 'eicon-h-align-right',
                ],
            ],
            'default' => 'lqd-module-trigger-txt-left',
            'toggle' => false,
        ]
    );

    $pf->add_control(
        $pf2.'trigger_type',
        [
            'label' => __( 'Trigger Type', 'archub-elementor-addons' ),
            'type' => Controls_Manager::SELECT,
            'default' => 'click',
            'options' => [
                'hoverFade'  => __( 'Hover', 'archub-elementor-addons' ),
                'click' => __( 'Click', 'archub-elementor-addons' ),
            ],
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
                'size' => 10,
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
                '{{WRAPPER}} .ld-module-trigger .ld-module-trigger-txt' => 'margin-inline-end: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                $pf2.'icon_text_align' => 'lqd-module-trigger-txt-left'
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
                'size' => 10,
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
                '{{WRAPPER}} .ld-module-trigger .ld-module-trigger-txt' => 'margin-inline-start: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                $pf2.'icon_text_align' => 'lqd-module-trigger-txt-right'
            ]
        ]
    );

    $pf->add_responsive_control(
        $pf2.'trigger_custom_w',
        [
            'label' => __( 'Shape width', 'archub-elementor-addons' ),
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
                '{{WRAPPER}} .ld-module-trigger' => 'width: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    $pf->add_responsive_control(
        $pf2.'trigger_custom_h',
        [
            'label' => __( 'Shape height', 'archub-elementor-addons' ),
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
                '{{WRAPPER}} .ld-module-trigger' => 'height: {{SIZE}}{{UNIT}};',
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
                '{{WRAPPER}} .ld-module-trigger' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $pf->add_responsive_control(
        $pf2.'trigger_border_radius',
        [
            'label' => __( 'Trigger roundness', 'archub-elementor-addons' ),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'selectors' => [
                '{{WRAPPER}} .ld-module-trigger' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

    $pf->add_group_control(
        Group_Control_Border::get_type(),
        [
            'label' => __( 'Trigger border', 'archub-elementor-addons' ),
            'name' => $pf2.'trigger_border',
            'selector' => '{{WRAPPER}} .ld-module-trigger',
        ]
    );

    $pf->end_controls_section();

    $pf->start_controls_section(
        $pf2.'trigger_style_section',
        [
            'label' => __( 'Trigger Style', 'archub-elementor-addons' ),
            'tab' => Controls_Manager::TAB_STYLE,
        ]
    );

    $pf->add_group_control(
        Group_Control_Typography::get_type(),
        [
            'name' => $pf2.'label_typography',
            'label' => __( 'Label Typography', 'archub-elementor-addons' ),
            'selector' => '{{WRAPPER}} .ld-module-trigger',
        ]
    );

    $pf->add_control(
        $pf2.'trigger_bg_heading',
        [
            'label' => esc_html__( 'Background', 'archub-elementor-addons' ),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
        ]
    );

    $pf->add_group_control(
        Group_Control_Background::get_type(),
        [
            'name' => $pf2.'trigger_bg',
            'label' => __( 'Background', 'archub-elementor-addons' ),
            'types' => [ 'classic', 'gradient' ],
            'exclude' => [ 'image' ],
            'selector' => '{{WRAPPER}} .ld-module-trigger',
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
            'selector' => '{{WRAPPER}} .ld-module-trigger:hover',
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
            'selector' => '{{WRAPPER}} .ld-module-trigger.is-active',
        ]
    );

    $pf->add_control(
        $pf2.'trigger_color',
        [
            'label' => __( 'Color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ld-module-trigger' => 'color: {{VALUE}}',
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
                '{{WRAPPER}} .ld-module-trigger:hover' => 'color: {{VALUE}}',
            ],
        ]
    );

    $pf->add_control(
        $pf2.'trigger_icon_color',
        [
            'label' => __( 'Icon Color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ld-module-trigger-icon' => 'color: {{VALUE}}',
            ],
            'separator' => 'before',
        ]
    );

    $pf->add_control(
        $pf2.'trigger_icon_color_hover',
        [
            'label' => __( 'Hover icon Color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ld-module-trigger:hover .ld-module-trigger-icon' => 'color: {{VALUE}}',
            ],
        ]
    );

    $pf->add_control(
        $pf2.'trigger_border__color',
        [
            'label' => __( 'Border color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ld-module-trigger' => 'border-color: {{VALUE}}',
            ],
            'condition' => [
                $pf2.'trigger_border_border!' => ''
            ],
            'separator' => 'before',
        ]
    );

    $pf->add_control(
        $pf2.'trigger_border_color_hover',
        [
            'label' => __( 'Hover border color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ld-module-trigger:hover' => 'border-color: {{VALUE}}',
            ],
            'condition' => [
                $pf2.'trigger_border_border!' => ''
            ],
        ]
    );

    $pf->add_control(
        $pf2.'trigger_border_color_active',
        [
            'label' => __( 'Active border color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .ld-module-trigger.is-active' => 'border-color: {{VALUE}}',
            ],
            'condition' => [
                $pf2.'trigger_border_border!' => ''
            ],
        ]
    );

    $pf->end_controls_section();

    // Sticky Colors
    $pf->start_controls_section(
        $pf2.'sticky_color_section',
        [
            'label' => __( 'Trigger Sticky Colors', 'archub-elementor-addons' ),
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
            'selector' => '.is-stuck {{WRAPPER}} .ld-module-trigger',
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
            'selector' => '.is-stuck {{WRAPPER}} .ld-module-trigger:hover',
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
            'selector' => '.is-stuck {{WRAPPER}} .ld-module-trigger.is-active',
        ]
    );

    $pf->add_control(
        $pf2.'sticky_trigger_color',
        [
            'label' => __( 'Color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '.is-stuck {{WRAPPER}} .ld-module-trigger' => 'color: {{VALUE}}',
            ],
            'separator' => 'before',
        ]
    );

    $pf->add_control(
        $pf2.'sticky_trigger_color_hover',
        [
            'label' => __( 'Hover color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '.is-stuck {{WRAPPER}} .ld-module-trigger:hover' => 'color: {{VALUE}}',
            ],
        ]
    );

    $pf->add_control(
        $pf2.'sticky_trigger_icon_color',
        [
            'label' => __( 'Icon color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '.is-stuck {{WRAPPER}} .ld-module-trigger-icon' => 'color: {{VALUE}}',
            ],
            'separator' => 'before',
        ]
    );

    $pf->add_control(
        $pf2.'sticky_trigger_icon_color_hover',
        [
            'label' => __( 'Hover icon color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '.is-stuck {{WRAPPER}} .ld-module-trigger:hover .ld-module-trigger-icon' => 'color: {{VALUE}}',
            ],
        ]
    );

    $pf->add_control(
        $pf2.'sticky_trigger_border_color',
        [
            'label' => __( 'Border color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '.is-stuck {{WRAPPER}} .ld-module-trigger' => 'border-color: {{VALUE}}',
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
                '.is-stuck {{WRAPPER}} .ld-module-trigger:hover' => 'border-color: {{VALUE}}',
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
                '.is-stuck {{WRAPPER}} .ld-module-trigger.is-active' => 'border-color: {{VALUE}}',
            ],
            'condition' => [
                $pf2.'trigger_border_border!' => ''
            ],
        ]
    );

    $pf->end_controls_section();

    // Colors Over Light Rows
    $pf->start_controls_section(
        $pf2.'sticky_light_section',
        [
            'label' => __( 'Trigger Colors Over Light Rows', 'archub-elementor-addons' ),
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
            'selector' => '{{WRAPPER}}.lqd-active-row-light .ld-module-trigger',
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
            'selector' => '{{WRAPPER}}.lqd-active-row-light .ld-module-trigger:hover',
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
            'selector' => '{{WRAPPER}}.lqd-active-row-light .ld-module-trigger.is-active',
        ]
    );

    $pf->add_control(
        $pf2.'sticky_light_trigger_color',
        [
            'label' => __( 'Color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}.lqd-active-row-light .ld-module-trigger' => 'color: {{VALUE}}',
            ],
            'separator' => 'before',
        ]
    );

    $pf->add_control(
        $pf2.'sticky_light_trigger_color_hover',
        [
            'label' => __( 'Hover color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}.lqd-active-row-light  .ld-module-trigger:hover' => 'color: {{VALUE}}',
            ],
        ]
    );

    $pf->add_control(
        $pf2.'sticky_light_trigger_icon_color',
        [
            'label' => __( 'Icon color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}.lqd-active-row-light .ld-module-trigger-icon' => 'color: {{VALUE}}',
            ],
            'separator' => 'before',
        ]
    );

    $pf->add_control(
        $pf2.'sticky_light_trigger_icon_color_hover',
        [
            'label' => __( 'Icon hover color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}.lqd-active-row-light .ld-module-trigger:hover .ld-module-trigger-icon' => 'color: {{VALUE}}',
            ],
        ]
    );

    $pf->add_control(
        $pf2.'sticky_light_trigger_border_color',
        [
            'label' => __( 'Border color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}.lqd-active-row-light .ld-module-trigger' => 'border-color: {{VALUE}}',
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
                '{{WRAPPER}}.lqd-active-row-light .ld-module-trigger:hover' => 'border-color: {{VALUE}}',
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
                '{{WRAPPER}}.lqd-active-row-light .ld-module-trigger.is-active' => 'border-color: {{VALUE}}',
            ],
            'condition' => [
                $pf2.'trigger_border_border!' => ''
            ],
        ]
    );

    $pf->end_controls_section();

    // Colors Over Dark Rows
    $pf->start_controls_section(
        $pf2.'sticky_dark_section',
        [
            'label' => __( 'Trigger Colors Over Dark Rows', 'archub-elementor-addons' ),
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
            'selector' => '{{WRAPPER}}.lqd-active-row-dark .ld-module-trigger',
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
            'selector' => '{{WRAPPER}}.lqd-active-row-dark .ld-module-trigger:hover',
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
            'selector' => '{{WRAPPER}}.lqd-active-row-dark .ld-module-trigger.is-active',
        ]
    );

    $pf->add_control(
        $pf2.'sticky_dark_trigger_color',
        [
            'label' => __( 'Color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}.lqd-active-row-dark .ld-module-trigger' => 'color: {{VALUE}}',
            ],
            'separator' => 'before',
        ]
    );

    $pf->add_control(
        $pf2.'sticky_dark_trigger_color_hover',
        [
            'label' => __( 'Hover color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}.lqd-active-row-dark .ld-module-trigger:hover' => 'color: {{VALUE}}',
            ],
        ]
    );

    $pf->add_control(
        $pf2.'sticky_dark_trigger_icon_color',
        [
            'label' => __( 'Icon Color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}.lqd-active-row-dark .ld-module-trigger-icon' => 'color: {{VALUE}}',
            ],
            'separator' => 'before',
        ]
    );

    $pf->add_control(
        $pf2.'sticky_dark_trigger_icon_color_hover',
        [
            'label' => __( 'Icon hover color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}.lqd-active-row-dark .ld-module-trigger:hover .ld-module-trigger-icon' => 'color: {{VALUE}}',
            ],
        ]
    );

    $pf->add_control(
        $pf2.'sticky_dark_trigger_border_color',
        [
            'label' => __( 'Border color', 'archub-elementor-addons' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}}.lqd-active-row-dark .ld-module-trigger' => 'border-color: {{VALUE}}',
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
                '{{WRAPPER}}.lqd-active-row-dark .ld-module-trigger:hover' => 'border-color: {{VALUE}}',
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
                '{{WRAPPER}}.lqd-active-row-dark .ld-module-trigger.is-active' => 'border-color: {{VALUE}}',
            ],
            'condition' => [
                $pf2.'trigger_border_border!' => ''
            ],
        ]
    );

    $pf->end_controls_section();

}

function ld_el_module_trigger_render( $data_target, $pf2, $settings, $type = '', $classes = array() ){

    $classes[] = 'ld-module-trigger';
    $classes[] = 'd-inline-flex';
    $classes[] = 'align-items-center';
    $classes[] = 'justify-content-center';
    $classes[] = 'pos-rel';
    $classes[] = 'border-radius-circle';
    $classes[] = $settings[$pf2.'icon_text_align'];

    if ( $type === 'cart' ) {
        $trigger_class = array(
            'collapsed',
            $settings['show_icon'] === 'yes' ? 'lqd-module-show-icon' : 'lqd-module-hide-icon',
            $settings['icon_style'],
            $settings['counter_style']
        );

        $classes = array_merge($classes, $trigger_class);
    } 
    
    if ( $type === 'search' ){
        $trigger_class = array(
            'collapsed',
            (isset($settings['show_icon']) && $settings['show_icon'] === 'yes') ? 'lqd-module-show-icon' : 'lqd-module-hide-icon', 
            isset($settings['icon_style']) ? $settings['icon_style'] : '',
        );

        $classes = array_merge($classes, $trigger_class);
    }

    ?>

    <span class="<?php echo liquid_helper()->sanitize_html_classes( $classes ) ?>" role="button" data-ld-toggle="true" data-toggle="collapse" data-target="<?php echo '#' . $data_target; ?>" aria-controls="<?php echo $data_target ?>" aria-expanded="false" 
    <?php if ($settings[$pf2.'trigger_type'] === 'hoverFade' ) { ?> data-toggle-options='{ "type": "hoverFade" }' <?php } ?> >
        
        <?php if ( $type === 'cart' ):  ?>
            <?php if ( 'yes' === $settings['show_icon'] )  { ?>
                <span class="ld-module-trigger-icon d-flex align-items-center justify-content-center pos-rel">
                    <?php if ( empty($settings[$pf2.'i_icon']['value']) ): ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="30" viewBox="0 0 32 30" style="width: 1em; height: 1em;"><path fill="currentColor" d="M.884.954c-.435.553-.328 1.19.25 1.488.272.141.878.183 2.641.183h2.287l1.67 7.657c.917 4.21 1.778 7.909 1.912 8.218.296.683.854 1.284 1.606 1.73l.563.333h15.125l.527-.283c.703-.375 1.39-1.079 1.667-1.706.231-.525 2.368-10.476 2.368-11.028 0-.17-.138-.445-.307-.614l-.307-.307H19.952c-10.306 0-10.939-.013-11.002-.219-.037-.12-.318-1.37-.624-2.778-.452-2.078-.608-2.602-.83-2.782C7.25.648 6.906.625 4.183.625h-3.04l-.259.33M29.25 8.733c0 .492-1.89 8.957-2.056 9.211-.443.676-.49.68-7.846.68-6.505 0-6.802-.011-7.185-.245-.22-.133-.487-.376-.594-.54-.106-.162-.634-2.303-1.172-4.755l-.978-4.46h9.915c5.553 0 9.916.048 9.916.109M12.156 25.118c-1.06.263-1.802 1.153-1.882 2.256-.07.971.13 1.506.792 2.116l.553.51h1.186c1.16 0 1.197-.01 1.648-.405 1.374-1.207 1.136-3.45-.455-4.282-.424-.221-1.345-.32-1.842-.196m12.74 0c-.594.15-1.288.745-1.615 1.386-.537 1.052-.261 2.333.669 3.1.461.38.53.397 1.59.397 1.272 0 1.65-.156 2.162-.895.62-.895.651-1.845.093-2.82-.525-.92-1.818-1.44-2.899-1.167M13.18 27.196a.716.716 0 0 1 .196.429c0 .248-.312.625-.517.625a.618.618 0 0 1-.608-.623c0-.553.55-.808.929-.43m12.704-.068c.37.198.325.838-.07 1.018-.258.118-.355.103-.563-.084-.304-.276-.317-.531-.043-.834.238-.264.342-.279.676-.1"></path></svg>
                    <?php else: ?>
                        <?php \Elementor\Icons_Manager::render_icon( $settings[$pf2.'i_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                    <?php endif;?>
                    <span class="ld-module-trigger-close-cross"></span>
                </span>
            <?php } ?>
        <?php else: ?>
            <?php if ( (isset($settings['show_icon']) && $settings['show_icon'] === 'yes') || !isset($settings['show_icon']) ) : ?>
                <?php if ( isset($settings['render_type']) && $settings['render_type'] === 'html' ) : ?>
                    <i class="<?php echo esc_attr( $settings[$pf2.'i_icon']['value'] ); ?>" aria-hidden="true"></i>
                <?php else : ?>
                    <span class="ld-module-trigger-icon d-flex align-items-center justify-content-center pos-rel">
                        <?php \Elementor\Icons_Manager::render_icon( $settings[$pf2.'i_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                    </span>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>

        <?php if( !empty( $settings[$pf2.'trigger_label'] ) ) : ?>
            <span class="ld-module-trigger-txt">
                <?php echo esc_html( $settings[$pf2.'trigger_label'] ); ?>
                <?php if ( isset( $settings['show_subtotal'] ) &&  $settings['show_subtotal'] === 'yes' ) : ?>
                <span class="ld-module-cart-subtotal"><?php echo WC()->cart->get_cart_subtotal(); ?></span>
                <?php endif; ?>
            </span>
        <?php endif; ?>

        <?php if ( $type === 'cart' && $settings['show_counter'] ) : ?>
			<?php printf( '<span class="ld-module-trigger-count ld-module-trigger-count-sup header-cart-fragments d-inline-flex align-items-center justify-content-center border-radius-circle">%s</span>', '0' ); ?>
        <?php endif; ?>
        
    </span>

    <?php

}