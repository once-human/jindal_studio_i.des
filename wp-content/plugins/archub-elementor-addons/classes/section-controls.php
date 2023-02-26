<?php

use Elementor\Element_Base;
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

defined('ABSPATH') || die();

class Hub_Elementor_Custom_Controls {

	public static function init() {
        //add_action( 'elementor/element/common/_section_style/after_section_end', [ __CLASS__, 'add_controls_section' ], 1 );
		add_action( 'elementor/element/column/section_advanced/after_section_end', [ __CLASS__, 'add_controls_section' ], 1 );
		add_action( 'elementor/element/section/section_advanced/after_section_end', [ __CLASS__, 'add_controls_section' ], 1 );
		add_action( 'elementor/element/container/section_layout/after_section_end', [ __CLASS__, 'add_controls_section' ], 1 );
		add_action( 'elementor/frontend/before_render', [ __CLASS__, 'before_section_render' ], 1 );

        // Additional Shape Colors
        add_action( 'elementor/element/section/section_shape_divider/before_section_end', [ __CLASS__, 'additional_shape_colors' ], 1 );
        add_action( 'elementor/element/container/section_shape_divider/before_section_end', [ __CLASS__, 'additional_shape_colors' ], 1 );

        // Liquid Animations
        add_action( 'elementor/element/after_section_end', function( $element, $section_id ) {

            if (
                ( $element->get_name() === 'container' && 'section_layout' === $section_id) ||
                'section_advanced' === $section_id ||
                '_section_style' === $section_id
            ) {

                $element->start_controls_section(
                    'lqd_custom_animations',
                    [
                        'label' => __( 'Animations & parallax', 'hub elementor addons' ),
                        'tab' => Controls_Manager::TAB_ADVANCED,
                    ]
                );
        
                ld_el_parallax( $element ); // call parallax options
                ld_el_content_animation( $element ); // call content animation options

                $element->end_controls_section();
            }
        }, 10, 2 );

         // Custom CSS
         add_action( 'elementor/element/parse_css', function( $post_css, $element ){

            if ( $post_css instanceof Dynamic_CSS ) {
                return;
            }
    
            $element_settings = $element->get_settings();
    
            if ( empty( $element_settings['lqd_custom_css'] ) ) {
                return;
            }
    
            $css = trim( $element_settings['lqd_custom_css'] );
    
            if ( empty( $css ) ) {
                return;
            }

            $css = str_replace( 'selector', $post_css->get_element_unique_selector( $element ), $css );
    
            $post_css->get_stylesheet()->add_raw_css( $css );

        }, 10, 2 );

        add_action( 'elementor/element/after_section_end', function( $element, $section_id ) {

            if (
                ( $element->get_name() === 'container' && 'section_layout' === $section_id) ||
                'section_advanced' === $section_id ||
                '_section_style' === $section_id
            ) {

                $element->start_controls_section(
                    'lqd_custom_css_section',
                    [
                        'label' => __( 'Custom CSS', 'archub-elementor-addons' ),
                        'tab' => Controls_Manager::TAB_ADVANCED,
                    ]
                );
        
                $element->add_control(
                    'lqd_custom_css',
                    [
                        'type' => Controls_Manager::CODE,
                        'language' => 'css',
                        'render_type' => 'ui',
                    ]
                );

                $element->add_control(
                    'lqd_custom_css_desc',
                    [
                        'raw' => sprintf(
                            esc_html__( 'Use "selector" to target wrapper element.%1$sselector {your css code}', 'archub-elementor-addons' ),
                            '<br><br>'
                        ),
                        'type' => Controls_Manager::RAW_HTML,
                        'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
                    ]
                );

                $element->end_controls_section();
            }
        }, 10, 20 );

        // Iconbox Scale
        add_action( 'elementor/frontend/widget/before_render', function ( Element_Base $element ) {
            if ( ! $element->get_settings( 'enable_scale_animation' ) ) {
                return;
            }
            
            $element->add_render_attribute( '_wrapper', [
                'class' => 'lqd-iconbox-scale'
            ] );
        
        } );

        // Wrap Columns
        add_action( 'elementor/element/section/section_layout/before_section_end', function( $control_stack ) {
        
            $control_stack->start_injection([
                'at' => 'before',
                'of' => 'gap'
            ]);

            $control_stack->add_control(
                'liquid_columns_wrap',
                [
                    'label' => __( 'Wrap columns', 'archub-elementor-addons' ),
                    'description' => __( 'Check this option if you want to wrap columns in multiple rows on desktop. Change column width to see the effect.', 'archub-elementor-addons' ),
                    'type' => Controls_Manager::SWITCHER,
                    'selectors' => [
                        '{{WRAPPER}} > .elementor-container' => 'flex-wrap: wrap;',
                    ],
                ]
            );

            $control_stack->end_injection();

        });

	}

    public static function additional_shape_colors( $control_stack ) {

        // Bottom
        $control_stack->start_injection([
            'at' => 'before',
            'of' => 'shape_divider_bottom_width'
        ]);

        $control_stack->add_control(
            'lqd_custom_shape_bottom_color2',
            [
                'label' => __( 'Color 2', 'archub-elementor-addons' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-shape-bottom .elementor-shape-fill:nth-child(2)' => 'fill: {{VALUE}}; fill-opacity: 1 !important; opacity: 1 !important;',
                ],
                'condition' => [
                    'shape_divider_bottom!' => '',
                ],
            ]
        );
        
        $control_stack->add_control(
            'lqd_custom_shape_bottom_color3',
            [
                'label' => __( 'Color 3', 'archub-elementor-addons' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-shape-bottom .elementor-shape-fill:nth-child(3)' => 'fill: {{VALUE}}; fill-opacity: 1 !important; opacity: 1 !important;',
                ],
                'condition' => [
                    'shape_divider_bottom!' => '',
                ],
            ]
        );
        
        $control_stack->add_control(
            'lqd_custom_shape_bottom_color4',
            [
                'label' => __( 'Color 4', 'archub-elementor-addons' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-shape-bottom .elementor-shape-fill:nth-child(4)' => 'fill: {{VALUE}}; fill-opacity: 1 !important; opacity: 1 !important;',
                ],
                'condition' => [
                    'shape_divider_bottom!' => '',
                ],
            ]
        );

        $control_stack->end_injection();

        // Top
        $control_stack->start_injection([
            'at' => 'before',
            'of' => 'shape_divider_top_width'
        ]);

        $control_stack->add_control(
            'lqd_custom_shape_top_color2',
            [
                'label' => __( 'Color 2', 'archub-elementor-addons' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-shape-top .elementor-shape-fill:nth-child(2)' => 'fill: {{VALUE}}; fill-opacity: 1 !important; opacity: 1 !important;',
                ],
                'condition' => [
                    'shape_divider_top!' => '',
                ],
            ]
        );
        
        $control_stack->add_control(
            'lqd_custom_shape_top_color3',
            [
                'label' => __( 'Color 3', 'archub-elementor-addons' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-shape-top .elementor-shape-fill:nth-child(3)' => 'fill: {{VALUE}}; fill-opacity: 1 !important; opacity: 1 !important;',
                ],
                'condition' => [
                    'shape_divider_top!' => '',
                ],
            ]
        );
        
        $control_stack->add_control(
            'lqd_custom_shape_top_color4',
            [
                'label' => __( 'Color 4', 'archub-elementor-addons' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-shape-top .elementor-shape-fill:nth-child(4)' => 'fill: {{VALUE}}; fill-opacity: 1 !important; opacity: 1 !important;',
                ],
                'condition' => [
                    'shape_divider_top!' => '',
                ],
            ]
        );

        $control_stack->end_injection();

        // Bottom shape animation
        $control_stack->start_injection([
            'at' => 'after',
            'of' => 'shape_divider_bottom_above_content'
        ]);

        $control_stack->end_injection();

        // Top shape animation
        $control_stack->start_injection([
            'at' => 'after',
            'of' => 'shape_divider_top_above_content'
        ]);

        $control_stack->end_injection();

    }

	public static function add_controls_section( Element_Base $element) {

        $is_container = 'container' === $element->get_name();
        $is_section = 'section' === $element->get_name();

        if ( $is_container || $is_section ) {

            $element->start_controls_section(
                'liquid_custom_row_heading',
                [
                    'label' => __( 'Section options', 'archub-elementor-addons' ),
                    'tab'   => Controls_Manager::TAB_LAYOUT,
                ]
            );

            if ( get_post_type( get_the_ID()) !== 'liquid-header' ) {

                $page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers( 'page' );
			    $page_settings_model = $page_settings_manager->get_model( get_the_ID() );

                $element->add_control(
                    'liquid_luminosity_data_attr',
                    [
                        'label' => __( 'Luminosity', 'archub-elementor-addons' ),
                        'type' => Controls_Manager::CHOOSE,
                        'options' => [
                            'default-auto' => [
                                'title' => __( 'Automatic', 'archub-elementor-addons' ),
                                'icon' => 'fa fa-adjust',
                            ],
                            'dark' => [
                                'title' => __( 'Dark', 'archub-elementor-addons' ),
                                'icon' => 'fa fa-moon',
                            ],
                            'light' => [
                                'title' => __( 'Light', 'archub-elementor-addons' ),
                                'icon' => 'fa fa-sun',
                            ],
                        ],
                        'default' => 'default-auto',
                        'toggle' => false,
                    ]
                );
                
                $element->add_control(
                    'lqd_section_scroll',
                    [
                        'label' => __( 'Section scroll?', 'archub-elementor-addons' ),
                        'description' => __( 'Enable this option to make the section scrollable.', 'archub-elementor-addons' ),
                        'type' => Controls_Manager::SWITCHER,
                        'label_on' => __( 'On', 'archub-elementor-addons' ),
                        'label_off' => __( 'Off', 'archub-elementor-addons' ),
                        'return_value' => 'yes',
                        'default' => '',
                        'separator' => 'before',
                    ]
                );
                
                $element->add_responsive_control(
                    'section_scroll_nav_offset',
                    [
                        'label' => esc_html__( 'Nav offset', 'elementor' ),
                        'type' => Controls_Manager::SLIDER,
                        'default' => [
                            'size' => 65,
                            'unit' => 'px',
                        ],
                        'size_units' => [ '%', 'px', 'vw' ],
                        'range' => [
                            '%' => [
                                'min' => 1,
                                'max' => 100,
                            ],
                            'px' => [
                                'min' => 1,
                                'max' => 100,
                            ],
                            'vw' => [
                                'min' => 1,
                                'max' => 100,
                            ],
                        ],
                        'selectors' => [
                            '{{WRAPPER}} > .lqd-section-scroll-dots' => 'right: {{SIZE}}{{UNIT}};',
                        ],
                        'condition' => [
                            'lqd_section_scroll' => 'yes',
                        ],
                    ]
                );

                $element->add_control(
                    'lqd_section_scroll_dot_bg_heading',
                    [
                        'label' => esc_html__( 'Nav background', 'archub-elementor-addons' ),
                        'type' => Controls_Manager::HEADING,
                        'condition' => [
                            'lqd_section_scroll' => 'yes',
                        ],
                    ]
                );

                $element->add_group_control(
                    Group_Control_Background::get_type(),
                    [
                        'name' => 'lqd_section_scroll_dot_bg',
                        'label' => __( 'Nav background', 'archub-elementor-addons' ),
                        'types' => [ 'classic', 'gradient' ],
                        'exclude' => [ 'image' ],
                        'selector' => '{{WRAPPER}} > .lqd-section-scroll-dots .lqd-section-scroll-dot',
                        'condition' => [
                            'lqd_section_scroll' => 'yes',
                        ],
                    ]
                );

                $element->add_control(
                    'lqd_section_scroll_hover_dot_bg_hover',
                    [
                        'label' => esc_html__( 'Nav hover/active background', 'archub-elementor-addons' ),
                        'type' => Controls_Manager::HEADING,
                        'condition' => [
                            'lqd_section_scroll' => 'yes',
                        ],
                    ]
                );

                $element->add_group_control(
                    Group_Control_Background::get_type(),
                    [
                        'name' => 'lqd_section_scroll_hover_dot_bg',
                        'label' => __( 'Nav hover/active background', 'archub-elementor-addons' ),
                        'types' => [ 'classic', 'gradient' ],
                        'exclude' => [ 'image' ],
                        'selector' => '{{WRAPPER}} > .lqd-section-scroll-dots .lqd-section-scroll-dot.is-active, {{WRAPPER}} > .lqd-section-scroll-dots .lqd-section-scroll-dot:hover',
                        'condition' => [
                            'lqd_section_scroll' => 'yes',
                        ],
                    ]
                );

                $element->add_control(
                    'lqd_section_scroll_dot_border',
                    [
                        'label' => __( 'Nav border color', 'archub-elementor-addons' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} > .lqd-section-scroll-dots .lqd-section-scroll-dot' => 'border-color: {{VALUE}};',
                        ],
                        'condition' => [
                            'lqd_section_scroll' => 'yes',
                        ],
                    ]
                );

                $element->add_control(
                    'lqd_section_scroll_hover_dot_border',
                    [
                        'label' => __( 'Nav hover/active border color', 'archub-elementor-addons' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} > .lqd-section-scroll-dots .lqd-section-scroll-dot.is-active, {{WRAPPER}} > .lqd-section-scroll-dots .lqd-section-scroll-dot:hover' => 'border-color: {{VALUE}};',
                        ],
                        'condition' => [
                            'lqd_section_scroll' => 'yes',
                        ],
                    ]
                );

                $element->add_control(
                    'lqd_section_scroll_dot_color',
                    [
                        'label' => __( 'Nav text color', 'archub-elementor-addons' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} > .lqd-section-scroll-dots .lqd-section-scroll-dot' => 'color: {{VALUE}};',
                        ],
                        'condition' => [
                            'lqd_section_scroll' => 'yes',
                        ],
                    ]
                );

                $element->add_control(
                    'lqd_section_scroll_hover_dot_color',
                    [
                        'label' => __( 'Nav hover/active text color', 'archub-elementor-addons' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} > .lqd-section-scroll-dots .lqd-section-scroll-dot.is-active, {{WRAPPER}} > .lqd-section-scroll-dots .lqd-section-scroll-dot:hover' => 'color: {{VALUE}};',
                        ],
                        'condition' => [
                            'lqd_section_scroll' => 'yes',
                        ],
                    ]
                );

                $element->add_control(
                    'custom_cursor_on_hover',
                    [
                        'label' => __( 'Custom cursor on hover', 'archub-elementor-addons' ),
                        'description' => __( 'For it to work, enable the following from: Theme Options > Extras > Custom Cursor', 'archub-elementor-addons' ),
                        'type' => Controls_Manager::SWITCHER,
                        'label_on' => __( 'On', 'archub-elementor-addons' ),
                        'label_off' => __( 'Off', 'archub-elementor-addons' ),
                        'return_value' => 'yes',
                        'default' => '',
                        'separator' => 'before',
                    ]
                );

                $element->add_control(
                    'custom_cursor_color',
                    [
                        'label' => __( 'Custom cursor color', 'archub-elementor-addons' ),
                        'type' => Controls_Manager::COLOR,
                        'selectors' => [
                            '{{WRAPPER}} > .lqd-extra-cursor' => 'background: {{VALUE}};',
                        ],
                        'condition' => [
                            'custom_cursor_on_hover' => 'yes',
                        ],
                    ]
                );

                $page_enable_stack = $page_settings_model->get_settings( 'page_enable_stack' );
                $page_enable_stack = $page_enable_stack === 'on' ? '' : array( 'lqd_disable_option' => 'on' );

                $element->add_control(
                    'section_data_tooltip',
                    [
                        'label' => __( 'Section tooltip', 'archub-elementor-addons' ),
                        'type' => Controls_Manager::TEXT,
                        'description' => __( 'Add title as tooltip on stack page', 'archub-elementor-addons' ),
                        'render_type' => 'none',
                        'condition' => $page_enable_stack
                    ]
                );

                $element->add_control(
                    'lqd_sticky_row',
                    [
                        'label' => __( 'Sticky', 'archub-elementor-addons' ),
                        'description' => __( 'Enable to make this row sticky', 'archub-elementor-addons' ),
                        'type' => Controls_Manager::SWITCHER,
                        'label_on' => __( 'On', 'archub-elementor-addons' ),
                        'label_off' => __( 'Off', 'archub-elementor-addons' ),
                        'return_value' => 'lqd-css-sticky',
                        'render_type' => 'none',
                        'default' => '',
                        'separator' => 'before',
                    ]
                );

                $element->add_control(
                    'lqd_sticky_row_anchor',
                    [
                        'label' => __( 'Sticky anchor', 'archub-elementor-addons' ),
                        'description' => __( 'Choose row sticking from top or bottom. If you choose <b>bottom</b>, you may want to set a higher z-index for top sections.', 'archub-elementor-addons' ),
                        'type' => Controls_Manager::CHOOSE,
                        'options' => [
                            'top' => [
                                'title' => __( 'Top', 'archub-elementor-addons' ),
                                'icon' => 'eicon-v-align-top',
                            ],
                            'bottom' => [
                                'title' => __( 'Bottom', 'archub-elementor-addons' ),
                                'icon' => 'eicon-v-align-bottom',
                            ],
                        ],
                        'default' => 'top',
                        'toggle' => false,
                        'condition' => [
                            'lqd_sticky_row' => 'lqd-css-sticky'
                        ],
                    ]
                );

                $element->add_control(
                    'lqd_sticky_row_offset',
                    [
                        'label' => __( 'Sticky offset', 'archub-elementor-addons' ),
                        'type' => Controls_Manager::TEXT,
                        'default' => '0px',
                        'placeholder' => __( 'ex. 10px', 'archub-elementor-addons' ),
                        'condition' => [
                            'lqd_sticky_row' => 'lqd-css-sticky'
                        ],
                    ]
                );

                $element->add_control(
                    'enable_animated_borders',
                    [
                        'label' => __( 'Animated borders', 'archub-elementor-addons' ),
                        'type' => Controls_Manager::SWITCHER,
                        'label_on' => __( 'On', 'archub-elementor-addons' ),
                        'label_off' => __( 'Off', 'archub-elementor-addons' ),
                        'return_value' => 'yes',
                        'default' => '',
                        'separator' => 'before',
                    ]
                );

            }

            // Header section controls
            if ( get_post_type( get_the_ID()) === 'liquid-header' ) { 
    
                $element->add_control(
                    'hide_on_sticky',
                    [
                        'label' => __( 'Hide on sticky header?', 'archub-elementor-addons' ),
                        'type' => Controls_Manager::SWITCHER,
                        'label_on' => __( 'On', 'archub-elementor-addons' ),
                        'label_off' => __( 'Off', 'archub-elementor-addons' ),
                        'return_value' => 'lqd-hide-onstuck',
                        'default' => '',
                        'condition' => array(
                            'show_on_sticky' => '',
                        ),
                    ]
                );
        
                $element->add_control(
                    'show_on_sticky',
                    [
                        'label' => __( 'Show only on sticky header?', 'archub-elementor-addons' ),
                        'type' => Controls_Manager::SWITCHER,
                        'label_on' => __( 'On', 'archub-elementor-addons' ),
                        'label_off' => __( 'Off', 'archub-elementor-addons' ),
                        'return_value' => 'lqd-show-onstuck',
                        'default' => '',
                        'condition' => array(
                            'hide_on_sticky' => '',
                        ),
                    ]
                );
                
                $element->add_control(
                    'sticky_bar',
                    [
                        'label' => __( 'Vertical bar?', 'archub-elementor-addons' ),
                        'type' => Controls_Manager::SWITCHER,
                        'label_on' => __( 'On', 'archub-elementor-addons' ),
                        'label_off' => __( 'Off', 'archub-elementor-addons' ),
                        'return_value' => 'yes',
                        'default' => '',
                    ]
                );
        
                $element->add_control(
                    'stickybar_placement',
                    [
                        'label' => __( 'Vertical bar position', 'archub-elementor-addons' ),
                        'type' => Controls_Manager::CHOOSE,
                        'options' => [
                            'lqd-stickybar-left' => [
                                'title' => __( 'Left', 'archub-elementor-addons' ),
                                'icon' => 'eicon-arrow-left',
                            ],
                            'lqd-stickybar-right' => [
                                'title' => __( 'Right', 'archub-elementor-addons' ),
                                'icon' => 'eicon-arrow-right',
                            ],
                        ],
                        'default' => 'lqd-stickybar-left',
                        'toggle' => false,
                        'condition' => [
                            'sticky_bar' => 'yes'
                        ],
                    ]
                );

            }

            $element->start_injection(
                array(
                    'of' => 'padding',
                    'at' => 'after',
                )
            );

            $element->add_responsive_control(
                'lqd_sticky_section_margin',
                [
                    'label' => __( 'Margin on sticky header', 'archub-elementor-addons' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em', 'rem' ],
                    'selectors' => [
                        '.is-stuck {{WRAPPER}}' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' => 'before',
                ]
            );

            $element->add_responsive_control(
                'lqd_sticky_section_padding',
                [
                    'label' => __( 'Padding on sticky header', 'archub-elementor-addons' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em', 'rem' ],
                    'selectors' => [
                        '.is-stuck {{WRAPPER}}' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' => 'after',
                ]
            );

            $element->end_injection();
			
            $element->end_controls_section();
        }

        if ( 'column' === $element->get_name() ) {
            $element->start_controls_section(
                'liquid_custom_column_heading',
                [
                    'label' => __( 'Column options', 'archub-elementor-addons' ),
                    'tab'   => Controls_Manager::TAB_LAYOUT,
                ]
            );

            $element->add_control(
                'enable_sticky_column',
                [
                    'label' => __( 'Sticky column', 'archub-elementor-addons' ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => __( 'On', 'archub-elementor-addons' ),
                    'label_off' => __( 'Off', 'archub-elementor-addons' ),
                    'return_value' => 'yes',
                    'default' => '',
                ]
            );

            $element->add_control(
                'sticky_column_offset',
                [
                    'label' => __( 'Sticky offset', 'archub-elementor-addons' ),
                    'type' => Controls_Manager::TEXT,
                    'default' => '30px',
                    'placeholder' => __( 'ex. 10px', 'archub-elementor-addons' ),
                    'condition' => [
                        'enable_sticky_column' => 'yes'
                    ],
                ]
            );

            $element->add_control(
                'enable_animated_borders',
                [
                    'label' => __( 'Animated borders', 'archub-elementor-addons' ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => __( 'On', 'archub-elementor-addons' ),
                    'label_off' => __( 'Off', 'archub-elementor-addons' ),
                    'return_value' => 'yes',
                    'default' => '',
                ]
            );
            
            $element->end_controls_section();
        }
	}

	public static function before_section_render( Element_Base $element ) {

        $container_selector = version_compare( ELEMENTOR_VERSION, '3.8', '>=' ) ? 'e-con' : 'e-container';
        $container_inner_selector = version_compare( ELEMENTOR_VERSION, '3.8', '>=' ) && $element->get_settings('content_width') === 'boxed' ? '.e-con-inner' : '';

        // Section
		if ( $element->get_settings( 'liquid_luminosity_data_attr' ) && 'default-auto' !== $element->get_settings( 'liquid_luminosity_data_attr' ) ) {
                $element->add_render_attribute( '_wrapper', [
                'data-section-luminosity' => $element->get_settings( 'liquid_luminosity_data_attr' ),
            ] );
        }

        if ( $element->get_settings( 'custom_cursor_on_hover' ) ) {
                $element->add_render_attribute( '_wrapper', [
                'data-lqd-custom-cursor' => 'true',
            ] );
        }
       
        if ( $element->get_settings( 'lqd_section_scroll' ) ) {
                $element->add_render_attribute( '_wrapper', [
                'data-lqd-section-scroll' => 'true',
            ] );
        }
        
        if ( $element->get_settings( 'hide_on_sticky' ) ) {
                $element->add_render_attribute( '_wrapper', [
                'class' => $element->get_settings( 'hide_on_sticky' ),
            ] );
        }

        if ( $element->get_settings( 'show_on_sticky' ) ) {
                $element->add_render_attribute( '_wrapper', [
                'class' => $element->get_settings( 'show_on_sticky' ),
            ] );
        }

        if ( $element->get_settings( 'sticky_bar' ) ) {
            $placement = $element->get_settings( 'stickybar_placement' );
            if ( empty( $placement ) ) {
                $placement = 'lqd-stickybar-left';
            }
            $element->add_render_attribute( '_wrapper', [
                'class' => 'lqd-stickybar-wrap '. $placement,
            ] );
        }

        if ( $element->get_settings( 'lqd_enable_bottom_shape_animation' ) ) {
            $element->add_render_attribute( '_wrapper', [
                'class' => $element->get_settings( 'lqd_enable_bottom_shape_animation' ),
            ] );
        }

        if ( $element->get_settings( 'lqd_enable_top_shape_animation' ) ) {
            $element->add_render_attribute( '_wrapper', [
                'class' => $element->get_settings( 'lqd_enable_top_shape_animation' ),
            ] );
        }

        if ( $element->get_settings( 'enable_sticky_column' ) ) {
            $element->add_render_attribute( '_wrapper', [
                'class' => 'lqd-css-sticky-column',
                'style' => '--lqd-sticky-offset:'.$element->get_settings( 'sticky_column_offset' ) ,
            ] );
        }

        if ( $element->get_settings( 'enable_animated_borders' ) ) {
            $element->add_render_attribute( '_wrapper', [
                'data-animated-borders' => true,
            ] );
            if ( ! wp_script_is( 'liquid-append-template' ) ){
                wp_enqueue_script( 'liquid-append-template' );
            }
        }

        if ( $element->get_settings( 'section_data_tooltip' ) ) {
            $element->add_render_attribute( '_wrapper', [
                'data-tooltip' => $element->get_settings( 'section_data_tooltip' ),
            ] );
        }
        
        if ( $element->get_settings( 'lqd_sticky_row' ) ) {
            $element->add_render_attribute( '_wrapper', [
                'class' => $element->get_settings( 'lqd_sticky_row' ),
                'style' => 'top: auto; ' . $element->get_settings( 'lqd_sticky_row_anchor' ) . ': ' . $element->get_settings( 'lqd_sticky_row_offset' ) . ';',
            ] );
        }

        // Scale BG
        if ( $element->get_settings( 'row_scaleBg_onhover' ) ) {

                $image_uri = $element->get_settings( 'background_image' );

                $element->add_render_attribute( '_wrapper', [
                'class' => 'lqd-scale-bg-onhover',
                'data-row-bg' => $image_uri['url'],
            ] );
        }

        // Parallax
        if ( $element->get_settings( 'lqd_parallax' ) ) {

            $perspective = $element->get_settings( 'lqd_parallax_settings_perspective' );

            $from_x = $element->get_settings( 'lqd_parallax_from_x' );
            $from_y = $element->get_settings( 'lqd_parallax_from_y' );
            $from_z = $element->get_settings( 'lqd_parallax_from_z' );

            $from_scaleX = $element->get_settings( 'lqd_parallax_from_scaleX' );
            $from_scaleY = $element->get_settings( 'lqd_parallax_from_scaleY' );
            
            $from_rotationX = $element->get_settings( 'lqd_parallax_from_rotationX' );
            $from_rotationY = $element->get_settings( 'lqd_parallax_from_rotationY' );
            $from_rotationZ = $element->get_settings( 'lqd_parallax_from_rotationZ' );

            $from_opacity = $element->get_settings( 'lqd_parallax_from_opacity' );

            $from_transformOriginX = $element->get_settings( 'lqd_parallax_from_transformOriginX' );
            $from_transformOriginY = $element->get_settings( 'lqd_parallax_from_transformOriginY' );
            $from_transformOriginZ = $element->get_settings( 'lqd_parallax_from_transformOriginZ' );

            $to_x = $element->get_settings( 'lqd_parallax_to_x' );
            $to_y = $element->get_settings( 'lqd_parallax_to_y' );
            $to_z = $element->get_settings( 'lqd_parallax_to_z' );
                     
            $to_scaleX = $element->get_settings( 'lqd_parallax_to_scaleX' );
            $to_scaleY = $element->get_settings( 'lqd_parallax_to_scaleY' );

            $to_rotationX = $element->get_settings( 'lqd_parallax_to_rotationX' );
            $to_rotationY = $element->get_settings( 'lqd_parallax_to_rotationY' );
            $to_rotationZ = $element->get_settings( 'lqd_parallax_to_rotationZ' );
           
            $to_opacity = $element->get_settings( 'lqd_parallax_to_opacity' );

            $to_transformOriginX = $element->get_settings( 'lqd_parallax_to_transformOriginX' );
            $to_transformOriginY = $element->get_settings( 'lqd_parallax_to_transformOriginY' );
            $to_transformOriginZ = $element->get_settings( 'lqd_parallax_to_transformOriginZ' );
            
            $parallax_ease = $element->get_settings( 'lqd_parallax_settings_ease' );
            $parallax_duration = $element->get_settings( 'lqd_parallax_settings_duration' );
            $parallax_trigger = $element->get_settings( 'lqd_parallax_settings_trigger' );
            $parallax_trigger_start = $element->get_settings( 'lqd_parallax_settings_trigger_start' );
            $parallax_trigger_end = $element->get_settings( 'lqd_parallax_settings_trigger_end' );

            $wrapper_attributes = $parallax_data = $parallax_data_from = $parallax_data_to = $parallax_opts = array();
        
            if ( !empty( $perspective ) && !empty( $perspective['size'] ) ) { $parallax_data_from['transformPerspective'] = $perspective['size'].$perspective['unit']; }

            if ( !empty( $from_x ) && !empty( $to_x ) && $from_x != $to_x ) {
                $parallax_data_from['x'] = $from_x['size'].$from_x['unit'];
                $parallax_data_to['x'] = $to_x['size'].$to_x['unit'];
            }
            if ( !empty( $from_y ) && !empty( $to_y ) && $from_y != $to_y ) {
                $parallax_data_from['y'] = $from_y['size'].$from_y['unit'];
                $parallax_data_to['y'] = $to_y['size'].$to_y['unit'];
            }
            if ( !empty( $from_z ) && !empty( $to_z ) && $from_z != $to_z ) {
                $parallax_data_from['z'] = $from_z['size'].$from_z['unit'];
                $parallax_data_to['z'] = $to_z['size'].$to_z['unit'];
            }
            
            if ( !empty( $from_scaleX ) && !empty( $to_scaleX ) && $from_scaleX != $to_scaleX ) {
                $parallax_data_from['scaleX'] = (float) $from_scaleX['size'];
                $parallax_data_to['scaleX'] = (float) $to_scaleX['size'];
            }
            if ( !empty( $from_scaleY ) && !empty( $to_scaleY ) && $from_scaleY != $to_scaleY ) {
                $parallax_data_from['scaleY'] = (float) $from_scaleY['size'];
                $parallax_data_to['scaleY'] = (float) $to_scaleY['size'];
            }

            if ( !empty( $from_rotationX ) && !empty( $to_rotationX ) && $from_rotationX != $to_rotationX ) {
                $parallax_data_from['rotationX'] = (int) $from_rotationX['size'];
                $parallax_data_to['rotationX'] = (int) $to_rotationX['size'];
            }
            if ( !empty( $from_rotationY ) && !empty( $to_rotationY ) && $from_rotationY != $to_rotationY ) {
                $parallax_data_from['rotationY'] = (int) $from_rotationY['size'];
                $parallax_data_to['rotationY'] = (int) $to_rotationY['size'];
            }
            if ( !empty( $from_rotationZ ) && !empty( $to_rotationZ ) && $from_rotationZ != $to_rotationZ ) {
                $parallax_data_from['rotationZ'] = (int) $from_rotationZ['size'];
                $parallax_data_to['rotationZ'] = (int) $to_rotationZ['size'];
            }

            if ( !empty( $from_opacity ) && !empty( $to_opacity ) && $from_opacity != $to_opacity ) {
                $parallax_data_from['opacity'] = (float) $from_opacity['size'];
                $parallax_data_to['opacity'] = (float) $to_opacity['size'];
            }
        
            $from_toriginX = isset( $from_transformOriginX ) && ! empty( $from_transformOriginX ) ? $from_transformOriginX['size'].$from_transformOriginX['unit'] : '';
            $from_toriginY = isset( $from_transformOriginY ) && ! empty( $from_transformOriginY ) ? $from_transformOriginY['size'].$from_transformOriginY['unit'] : '';
            $from_toriginZ = isset( $from_transformOriginZ ) && ! empty( $from_transformOriginZ ) ? $from_transformOriginZ['size'].$from_transformOriginZ['unit'] : '';
        
            $to_toriginX = isset( $to_transformOriginX ) && ! empty( $to_transformOriginX ) ? $to_transformOriginX['size'].$to_transformOriginX['unit'] : '';
            $to_toriginY = isset( $to_transformOriginY ) && ! empty( $to_transformOriginY ) ? $to_transformOriginY['size'].$to_transformOriginY['unit'] : '';
            $to_toriginZ = isset( $to_transformOriginZ ) && ! empty( $to_transformOriginZ ) ? $to_transformOriginZ['size'].$to_transformOriginZ['unit'] : '';

            if (
                ! empty( $from_toriginX ) && ! empty( $from_toriginY ) && ! empty( $from_toriginZ ) &&
                ! empty( $to_toriginX ) && ! empty( $to_toriginY ) && ! empty( $to_toriginZ )
            ) {
                $parallax_data_from['transformOrigin'] = $from_toriginX . ' ' . $from_toriginY . ' ' . $from_toriginZ;
                $parallax_data_to['transformOrigin'] = $to_toriginX . ' ' . $to_toriginY . ' ' . $to_toriginZ;
            }

            if ( $parallax_data_from['transformOrigin'] == $parallax_data_to['transformOrigin'] ) {
                unset($parallax_data_from['transformOrigin']);
                unset($parallax_data_to['transformOrigin']);
            }
        
            //Parallax general options
            $parallax_data['from'] = $parallax_data_from;
            $parallax_data['to'] = $parallax_data_to;
        
            if( is_array( $parallax_data['from'] ) && ! empty( $parallax_data['from'] ) ) {
                $wrapper_attributes[] = 'data-parallax-from=\'' . wp_json_encode( $parallax_data['from'] ) . '\'';
            }
            if( is_array( $parallax_data['to'] ) && ! empty( $parallax_data['to'] ) ) {
                $wrapper_attributes[] = 'data-parallax-to=\'' . wp_json_encode( $parallax_data['to'] ) . '\'';
            }

            if ( isset( $parallax_ease ) ) { $parallax_opts['ease'] = $parallax_ease; }
            if( 'custom' !== $parallax_trigger ){
                $parallax_opts['start'] = esc_attr( $parallax_trigger );
                if ( isset($parallax_duration) && ! empty($parallax_duration) ) {
                    $dur = $parallax_duration['size'] >= 0 ? '+='.abs((int)$parallax_duration['size']).$parallax_duration['unit'].'' : '-='.abs((int)$parallax_duration['size']).$parallax_duration['unit'].'';
                    $parallax_opts['end'] = esc_attr( 'bottom'  . $dur . ' top' );
                }
            } else {
                if ( ! empty( $parallax_trigger_start ) ) {
                    $parallax_opts['start'] = esc_attr( $parallax_trigger_start );
                }
                if ( ! empty( $parallax_trigger_end ) ) {
                    $parallax_opts['end'] = esc_attr( $parallax_trigger_end );
                }
            }

            if ( ! empty( $element->get_settings('lqd_parallax_settings_parallaxElement') ) ) {
                $parallax_opts['parallaxElement'] = $element->get_settings('lqd_parallax_settings_parallaxElement');
            }

            if ( ! empty( $element->get_settings('lqd_parallax_settings_scrub') ) && $element->get_settings('lqd_parallax_settings_scrub')['size'] !== 0.55 ) {
                $parallax_opts['scrub'] = $element->get_settings('lqd_parallax_settings_scrub')['size'];
            }

            if( ! empty( $parallax_opts ) ) {
                $wrapper_attributes[] = 'data-parallax-options=\'' . wp_json_encode( $parallax_opts ) .'\'';
            }

            $element->add_render_attribute( '_wrapper', [
                'data-parallax' => 'true',
                'data-parallax-options' => wp_json_encode( $parallax_opts ),
                'data-parallax-from' => wp_json_encode( $parallax_data['from'] ),
                'data-parallax-to' => wp_json_encode( $parallax_data['to'] ),
            ] );

        }

         // Animation
         if ( $element->get_settings( 'lqd_custom_animation' ) ) {
           
            $ca_preset_values = array();
            $ca_opts = $ca_from_values = $ca_to_values = array();
            $animation_targets = array();

            $animation_preset = $element->get_settings( 'lqd_ca_preset' );
            $ca_ease = $element->get_settings( 'lqd_ca_settings_ease' );
            $ca_direction = $element->get_settings( 'lqd_ca_settings_direction' );
            $ca_duration = $element->get_settings( 'lqd_ca_settings_duration' )['size'];
            $ca_stagger = $element->get_settings( 'lqd_ca_settings_stagger' )['size'];
            $ca_start_delay = $element->get_settings( 'lqd_ca_settings_start_delay' )['size'];

            $ca_opts['addChildTimelines'] = false;
            // $ca_opts['addPerspective'] = false;

            switch ( $element->get_name() ){
                case 'container': 
                    array_push($animation_targets, ':scope ' . $container_inner_selector . ' > .elementor-element:not(.lqd-exclude-parent-ca) > .elementor-widget-container');
                    array_push($animation_targets, ':scope ' . $container_inner_selector . ' > .elementor-widget-hub_fancy_heading .lqd-split-lines .lqd-lines .split-inner');
                    array_push($animation_targets, ':scope ' . $container_inner_selector . ' > .elementor-widget-hub_fancy_heading .lqd-split-words .lqd-words .split-inner');
                    array_push($animation_targets, ':scope ' . $container_inner_selector . ' > .elementor-widget-hub_fancy_heading .lqd-split-chars .lqd-chars .split-inner');
                    array_push($animation_targets, ':scope ' . $container_inner_selector . ' > .elementor-widget-hub_fancy_heading .lqd-adv-txt-fig');
                    array_push($animation_targets, ':scope ' . $container_inner_selector . ' > .elementor-widget-ld_custom_menu .lqd-fancy-menu > ul > li');
                    array_push($animation_targets, ':scope .' . $container_selector . ':not([data-parallax]) ' . $container_inner_selector . ' > .elementor-element > .elementor-widget-container');
                    array_push($animation_targets, ':scope .' . $container_selector . ':not([data-parallax]) ' . $container_inner_selector . ' > .elementor-widget-hub_fancy_heading .lqd-split-lines .lqd-lines .split-inner');
                    array_push($animation_targets, ':scope .' . $container_selector . ':not([data-parallax]) ' . $container_inner_selector . ' > .elementor-widget-hub_fancy_heading .lqd-split-words .lqd-words .split-inner');
                    array_push($animation_targets, ':scope .' . $container_selector . ':not([data-parallax]) ' . $container_inner_selector . ' > .elementor-widget-hub_fancy_heading .lqd-split-chars .lqd-chars .split-inner');
                    array_push($animation_targets, ':scope .' . $container_selector . ':not([data-parallax]) ' . $container_inner_selector . ' > .elementor-widget-ld_custom_menu .lqd-fancy-menu > ul > li');
                case 'section': 
                    array_push($animation_targets, ':scope > .elementor-container > .elementor-column');
                break;
                case 'column':
                    // $ca_opts['addChildTimelines'] = true;
                    array_push($animation_targets, ':scope > .elementor-widget-wrap > .elementor-element > .elementor-widget-container');
                    array_push($animation_targets, ':scope > .elementor-widget-wrap > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element:not(.lqd-el-has-inner-anim) > .elementor-widget-container');
                    array_push($animation_targets, ':scope > .elementor-widget-wrap > .elementor-widget-hub_fancy_heading .lqd-split-lines .lqd-lines .split-inner');
                    array_push($animation_targets, ':scope > .elementor-widget-wrap > .elementor-widget-hub_fancy_heading .lqd-split-words .lqd-words .split-inner');
                    array_push($animation_targets, ':scope > .elementor-widget-wrap > .elementor-widget-hub_fancy_heading .lqd-split-chars .lqd-chars .split-inner');
                    array_push($animation_targets, ':scope > .elementor-widget-wrap > .elementor-widget-ld_custom_menu .lqd-fancy-menu > ul > li');
                break;
                case 'ld_carousel':
                case 'ld_testimonial_carousel':
                    array_push($animation_targets, '[data-lqd-flickity] > .flickity-viewport > .flickity-slider > .carousel-item > .carousel-item-inner');
                break;
                default:
                    // $ca_opts['addChildTimelines'] = true;
                    
                    if( $element->get_name() === 'hub_fancy_heading' && $element->get_settings( 'enable_split' ) ){
                        
                        $split_type = $element->get_settings( 'split_type' );

                        if ( $split_type === 'lines' ){
                            array_push($animation_targets, '.lqd-split-lines .lqd-lines .split-inner');
                        } else if ( $split_type === 'words' ){
                            array_push($animation_targets, '.lqd-split-words .lqd-words .split-inner');
                        } else if ( $split_type === 'chars, words' ){
                            array_push($animation_targets, '.lqd-split-chars .lqd-chars .split-inner');
                        }
                    } else if ( $element->get_name() === 'ld_custom_menu' ) {
                        array_push($animation_targets, ':scope .lqd-fancy-menu > ul > li');
                    } else {
                        array_push($animation_targets, ':scope > .elementor-widget-container');
                    }

                break;
            }

            $ca_opts['animationTarget'] = implode(', ', $animation_targets);
            
            if ( !empty( $ca_duration ) && $ca_duration !== 1.6 ) {
                $ca_opts['duration'] = (float) ($ca_duration * 1000);
            }
            if( !empty( $ca_start_delay ) && $ca_start_delay !== 0 ) {
                $ca_opts['startDelay'] = (float) ($ca_start_delay * 1000);
            }
            if ( !empty( $ca_stagger ) && $ca_stagger !== 0.16 ) {
                $ca_opts['delay'] = (float) ($ca_stagger * 1000);
            }
            if ( $ca_ease !== 'power4.out' ) {
                $ca_opts['ease'] = $ca_ease;
            }
            if ( $ca_direction !== 'forward' ) {
                $ca_opts['direction'] = $ca_direction;
            }
            
            if( 'custom' !== $animation_preset ) {

                $defined_animations = array(

                    'Fade In' => array(
                        'from' => array( 'opacity' => 0 ),
                        'to'   => array( 'opacity' => 1 ),
                    ),
                    'Fade In Down' => array(
                        'from' => array( 'opacity' => 0, 'translateY' => -150 ),
                        'to'   => array( 'opacity' => 1, 'translateY' => 0 ),
                    ),
                    'Fade In Up' => array(
                        'from' => array( 'opacity' => 0, 'translateY' => 150 ),
                        'to'   => array( 'opacity' => 1, 'translateY' => 0 ),
                    ),
                    'Fade In Left' => array(
                        'from' => array( 'opacity' => 0, 'translateX' => -150 ),
                        'to'   => array( 'opacity' => 1, 'translateX' => 0 ),
                    ),
                    'Fade In Right' => array(
                        'from' => array( 'opacity' => 0, 'translateX' => 150 ),
                        'to'   => array( 'opacity' => 1, 'translateX' => 0 ),
                    ),
                    'Flip In Y' => array(
                        'from' => array( 'opacity' => 0, 'translateX' => 150, 'rotationY' => 30 ),
                        'to'   => array( 'opacity' => 1, 'translateX' => 0, 'rotationY' => 0 ),
                    ),
                    'Flip In X' => array(
                        'from' => array( 'opacity' => 0, 'translateY' => 150, 'rotationX' => -30 ),
                        'to'   => array( 'opacity' => 1, 'translateY' => 0, 'rotationX' => 0 ),
                    ),
                    'Scale Up' => array(
                        'from' => array( 'opacity' => 0, 'scale' => 0.75 ),
                        'to'   => array( 'opacity' => 1, 'scale' => 1 ),
                    ),
                    'Scale Down' => array(
                        'from' => array( 'opacity' => 0, 'scale' => 1.25 ),
                        'to'   => array( 'opacity' => 1, 'scale' => 1 ),
                    ),
            
                );
                
                $ca_preset_values = $defined_animations[ $animation_preset ];
                $ca_from_values = $ca_preset_values['from'];
                $ca_to_values = $ca_preset_values['to'];
            }
            else {

                // From values
                $ca_from_x = $element->get_settings( 'lqd_ca_from_x' );
                $ca_from_y = $element->get_settings( 'lqd_ca_from_y' );
                $ca_from_z = $element->get_settings( 'lqd_ca_from_z' );

                $ca_from_scaleX = $element->get_settings( 'lqd_ca_from_scaleX' );
                $ca_from_scaleY = $element->get_settings( 'lqd_ca_from_scaleY' );

                $ca_from_rotationX = $element->get_settings( 'lqd_ca_from_rotationX' );
                $ca_from_rotationY = $element->get_settings( 'lqd_ca_from_rotationY' );
                $ca_from_rotationZ = $element->get_settings( 'lqd_ca_from_rotationZ' );

                $ca_from_transformOriginX = $element->get_settings( 'lqd_ca_from_transformOriginX' );
                $ca_from_transformOriginY = $element->get_settings( 'lqd_ca_from_transformOriginY' );
                $ca_from_transformOriginZ = $element->get_settings( 'lqd_ca_from_transformOriginZ' );
                
                $ca_from_opacity = $element->get_settings( 'lqd_ca_from_opacity' );
            
                // To values
                $ca_to_x = $element->get_settings( 'lqd_ca_to_x' );
                $ca_to_y = $element->get_settings( 'lqd_ca_to_y' );
                $ca_to_z = $element->get_settings( 'lqd_ca_to_z' );

                $ca_to_scaleX = $element->get_settings( 'lqd_ca_to_scaleX' );
                $ca_to_scaleY = $element->get_settings( 'lqd_ca_to_scaleY' );

                $ca_to_rotationX = $element->get_settings( 'lqd_ca_to_rotationX' );
                $ca_to_rotationY = $element->get_settings( 'lqd_ca_to_rotationY' );
                $ca_to_rotationZ = $element->get_settings( 'lqd_ca_to_rotationZ' );

                $ca_to_transformOriginX = $element->get_settings( 'lqd_ca_to_transformOriginX' );
                $ca_to_transformOriginY = $element->get_settings( 'lqd_ca_to_transformOriginY' );
                $ca_to_transformOriginZ = $element->get_settings( 'lqd_ca_to_transformOriginZ' );
                
                $ca_to_opacity = $element->get_settings( 'lqd_ca_to_opacity' );

                if ( !empty( $ca_from_x ) && !empty( $ca_to_x ) && $ca_from_x != $ca_to_x ) {
                    $ca_from_values['x'] = $ca_from_x['size'].$ca_from_x['unit'];
                    $ca_to_values['x'] = $ca_to_x['size'].$ca_to_x['unit'];
                }
                if ( !empty( $ca_from_y ) && !empty( $ca_to_y ) && $ca_from_y != $ca_to_y ) {
                    $ca_from_values['y'] = $ca_from_y['size'].$ca_from_y['unit'];
                    $ca_to_values['y'] = $ca_to_y['size'].$ca_to_y['unit'];
                }
                if ( !empty( $ca_from_z ) && !empty( $ca_to_z ) && $ca_from_z != $ca_to_z ) {
                    $ca_from_values['z'] = $ca_from_z['size'].$ca_from_z['unit'];
                    $ca_to_values['z'] = $ca_to_z['size'].$ca_to_z['unit'];
                }
                
                if ( !empty( $ca_from_scaleX ) && !empty( $ca_to_scaleX ) && $ca_from_scaleX != $ca_to_scaleX ) {
                    $ca_from_values['scaleX'] = (float) $ca_from_scaleX['size'];
                    $ca_to_values['scaleX'] = (float) $ca_to_scaleX['size'];
                }
                if ( !empty( $ca_from_scaleY ) && !empty( $ca_to_scaleY ) && $ca_from_scaleY != $ca_to_scaleY ) {
                    $ca_from_values['scaleY'] = (float) $ca_from_scaleY['size'];
                    $ca_to_values['scaleY'] = (float) $ca_to_scaleY['size'];
                }
    
                if ( !empty( $ca_from_rotationX ) && !empty( $ca_to_rotationX ) && $ca_from_rotationX != $ca_to_rotationX ) {
                    $ca_from_values['rotationX'] = (int) $ca_from_rotationX['size'];
                    $ca_to_values['rotationX'] = (int) $ca_to_rotationX['size'];
                }
                if ( !empty( $ca_from_rotationY ) && !empty( $ca_to_rotationY ) && $ca_from_rotationY != $ca_to_rotationY ) {
                    $ca_from_values['rotationY'] = (int) $ca_from_rotationY['size'];
                    $ca_to_values['rotationY'] = (int) $ca_to_rotationY['size'];
                }
                if ( !empty( $ca_from_rotationZ ) && !empty( $ca_to_rotationZ ) && $ca_from_rotationZ != $ca_to_rotationZ ) {
                    $ca_from_values['rotationZ'] = (int) $ca_from_rotationZ['size'];
                    $ca_to_values['rotationZ'] = (int) $ca_to_rotationZ['size'];
                }
    
                if ( !empty( $ca_from_opacity ) && !empty( $ca_to_opacity ) && $ca_from_opacity != $ca_to_opacity ) {
                    $ca_from_values['opacity'] = (float) $ca_from_opacity['size'];
                    $ca_to_values['opacity'] = (float) $ca_to_opacity['size'];
                }
            
                $ca_from_toriginX = isset( $ca_from_transformOriginX ) && ! empty( $ca_from_transformOriginX ) ? $ca_from_transformOriginX['size'].$ca_from_transformOriginX['unit'] : '';
                $ca_from_toriginY = isset( $ca_from_transformOriginY ) && ! empty( $ca_from_transformOriginY ) ? $ca_from_transformOriginY['size'].$ca_from_transformOriginY['unit'] : '';
                $ca_from_toriginZ = isset( $ca_from_transformOriginZ ) && ! empty( $ca_from_transformOriginZ ) ? $ca_from_transformOriginZ['size'].$ca_from_transformOriginZ['unit'] : '';
            
                $ca_to_toriginX = isset( $ca_to_transformOriginX ) && ! empty( $ca_to_transformOriginX ) ? $ca_to_transformOriginX['size'].$ca_to_transformOriginX['unit'] : '';
                $ca_to_toriginY = isset( $ca_to_transformOriginY ) && ! empty( $ca_to_transformOriginY ) ? $ca_to_transformOriginY['size'].$ca_to_transformOriginY['unit'] : '';
                $ca_to_toriginZ = isset( $ca_to_transformOriginZ ) && ! empty( $ca_to_transformOriginZ ) ? $ca_to_transformOriginZ['size'].$ca_to_transformOriginZ['unit'] : '';

                if (
                    ! empty( $ca_from_toriginX ) && ! empty( $ca_from_toriginY ) && ! empty( $ca_from_toriginZ ) &&
                    ! empty( $ca_to_toriginX ) && ! empty( $ca_to_toriginY ) && ! empty( $ca_to_toriginZ )
                ) {

                    $ca_from_values['transformOrigin'] = $ca_from_toriginX . ' ' . $ca_from_toriginY . ' ' . $ca_from_toriginZ;
                    $ca_to_values['transformOrigin'] = $ca_to_toriginX . ' ' . $ca_to_toriginY . ' ' . $ca_to_toriginZ;

                    if ( $ca_from_values['transformOrigin'] == $ca_to_values['transformOrigin'] ) {
                        unset($ca_from_values['transformOrigin']);
                        unset($ca_to_values['transformOrigin']);
                    }

                }
            
            }

            $ca_opts['initValues'] = !empty( $ca_from_values ) ? $ca_from_values : array();
            $ca_opts['animations'] = !empty( $ca_to_values ) ? $ca_to_values : array();

            $element->add_render_attribute( '_wrapper', [
                'data-custom-animations' => 'true',
                'data-ca-options' => stripslashes( wp_json_encode( $ca_opts ) ),
            ] );

        }
	}
}

Hub_Elementor_Custom_Controls::init();
