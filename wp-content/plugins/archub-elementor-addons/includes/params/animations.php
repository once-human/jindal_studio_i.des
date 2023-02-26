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

function ld_el_content_animation($pf){

	$section_title = __( 'Animate contents', 'archub-elementor-addons' );
	
	if ( $pf->get_name() === 'section'){
		$section_title = __( 'Animate columns', 'archub-elementor-addons' );
	} 

	$pf->add_control(
		'lqd_custom_animation',
		[
			'label' => $section_title,
			'type' => Controls_Manager::SWITCHER,
			'label_on' => __( 'On', 'archub-elementor-addons' ),
			'label_off' => __( 'Off', 'archub-elementor-addons' ),
			'return_value' => 'yes',
			'default' => '',
			'separator' => 'before',
			'render_type' => 'none',
		]
	);

	$pf->add_control(
		'lqd_ca_control_apply',
		[
			'label' => __( 'Play animations', 'archub-elementor-addons' ),
			'type' => \Elementor\Controls_Manager::BUTTON,
			'button_type' => 'success',
			'text' => __( 'Play', 'archub-elementor-addons' ),
			'condition' => [
				'lqd_custom_animation' => 'yes',
			],
			'event' => 'lqd_ca_apply',
			'render_type' => 'none',
		]
	);

	$pf->add_control(
		'lqd_ca_settings_popover',
		[
			'label' => __( 'Settings', 'archub-elementor-addons' ),
			'type' => Controls_Manager::POPOVER_TOGGLE,
			'label_off' => __( 'Default', 'archub-elementor-addons' ),
			'label_on' => __( 'Custom', 'archub-elementor-addons' ),
			'return_value' => 'yes',
			'default' => 'yes',
			'condition' => [
				'lqd_custom_animation' => 'yes'
			],
			'render_type' => 'none',
		]
	);

	// Animation Settings
	$pf->start_popover();
		$pf->add_control(
			'lqd_ca_preset',
			[
				'label' => __( 'Animation Presets', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'custom',
				'options' => [
					'custom'  => __( 'Custom', 'archub-elementor-addons' ),
					'Fade In'  => __( 'Fade In', 'archub-elementor-addons' ),
					'Fade In Down'  => __( 'Fade In Down', 'archub-elementor-addons' ),
					'Fade In Up'  => __( 'Fade In Up', 'archub-elementor-addons' ),
					'Fade In Left'  => __( 'Fade In Left', 'archub-elementor-addons' ),
					'Fade In Right'  => __( 'Fade In Right', 'archub-elementor-addons' ),
					'Flip In Y'  => __( 'Flip In Y', 'archub-elementor-addons' ),
					'Flip In X'  => __( 'Flip In X', 'archub-elementor-addons' ),
					'Scale Up'  => __( 'Scale Up', 'archub-elementor-addons' ),
					'Scale Down'  => __( 'Scale Down', 'archub-elementor-addons' ),
				],
				'condition' => [
					'lqd_ca_settings_popover' => 'yes'
				],
				'render_type' => 'none',
			]
		);

		$pf->add_control(
			'lqd_ca_settings_ease',
			[
				'label' => __( 'Easing', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => [ 'power4.out' ],
				'options' => [
					'linear' => 'linear',
					'power1.in' => 'power1.in',
					'power2.in' => 'power2.in',
					'power3.in' => 'power3.in',
					'power4.in' => 'power4.in',
					'sine.in' => 'sine.in',
					'expo.in' => 'expo.in',
					'circ.in' => 'circ.in',
					'back.in' => 'back.in',
					'bounce.in' => 'bounce.in',
					'elastic.in(1,0.2)' => 'elastic.in(1,0.2)',
					'power1.out' => 'power1.out',
					'power2.out' => 'power2.out',
					'power3.out' => 'power3.out',
					'power4.out' => 'power4.out',
					'sine.out' => 'sine.out',
					'expo.out' => 'expo.out',
					'circ.out' => 'circ.out',
					'back.out' => 'back.out',
					'bounce.out' => 'bounce.out',
					'elastic.out(1,0.2)' => 'elastic.out(1,0.2)',
					'power1.inOut' => 'power1.inOut',
					'power2.inOut' => 'power2.inOut',
					'power3.inOut' => 'power3.inOut',
					'power4.inOut' => 'power4.inOut',
					'sine.inOut' => 'sine.inOut',
					'expo.inOut' => 'expo.inOut',
					'circ.inOut' => 'circ.inOut',
					'back.inOut' => 'back.inOut',
					'bounce.inOut' => 'bounce.inOut',
					'elastic.inOut(1,0.2)' => 'elastic.inOut(1,0.2)',
				],
				'condition' => [
					'lqd_ca_settings_popover' => 'yes'
				],
				'render_type' => 'none',
			]
		);

		$pf->add_control(
			'lqd_ca_settings_direction',
			[
				'label' => __( 'Direction', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'forward',
				'options' => [
					'forward' => __( 'Forward', 'archub-elementor-addons' ),
					'backward' => __( 'Backward', 'archub-elementor-addons' ),
					'random' => __( 'Random', 'archub-elementor-addons' ),
				],
				'condition' => [
					'lqd_ca_settings_popover' => 'yes'
				],
				'render_type' => 'none',
			]
		);

		$pf->add_control(
			'lqd_ca_settings_duration',
			[
				'label' => __( 'Duration', 'archub-elementor-addons' ),
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
					'size' => 1.6,
				],
				'condition' => [
					'lqd_ca_settings_popover' => 'yes'
				],
				'render_type' => 'none',
			]
		);
	
		$pf->add_control(
			'lqd_ca_settings_stagger',
			[
				'label' => __( 'Stagger', 'archub-elementor-addons' ),
				'description' => __( 'Delay between animated elements.', 'archub-elementor-addons' ),
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
					'size' => .16,
				],
				'condition' => [
					'lqd_ca_settings_popover' => 'yes'
				],
				'render_type' => 'none',
			]
		);
	
		$pf->add_control(
			'lqd_ca_settings_start_delay',
			[
				'label' => __( 'Start Delay', 'archub-elementor-addons' ),
				'description' => __( 'Start delay of the animation.', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -0,
						'max' => 10,
						'step' => 0.1,
					],
				],
				'default' => [
					'size' => 0,
				],
				'condition' => [
					'lqd_ca_settings_popover' => 'yes'
				],
				'render_type' => 'none',
			]
		);
	$pf->end_popover();

	// From Options
	$pf->add_control(
		'lqd_ca_from_popover',
		[
			'label' => __( 'Animate from', 'archub-elementor-addons' ),
			'type' => Controls_Manager::POPOVER_TOGGLE,
			'label_off' => __( 'Default', 'archub-elementor-addons' ),
			'label_on' => __( 'Custom', 'archub-elementor-addons' ),
			'return_value' => 'yes',
			'default' => 'yes',
			'condition' => [
				'lqd_custom_animation' => 'yes',
				'lqd_ca_preset' => 'custom',
			],
			'render_type' => 'none',
		]
	);

	$pf->start_popover();
		$pf->add_control(
			'lqd_ca_from_x',
			[
				'label' => __( 'Translate X', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw', 'vh' ],
				'range' => [
					'px' => [
							'min' => -500,
							'max' => 500,
							'step' => 1,
						],
						'%' => [
							'min' => -100,
							'max' => 100,
							'step' => 0.1,
						],
						'vw' => [
							'min' => -100,
							'max' => 100,
							'step' => 0.1,
						],
						'vh' => [
							'min' => -100,
							'max' => 100,
							'step' => 0.1,
						],
				],
				'default' => [
					'size' => 0,
				],
				'condition' => [
					'lqd_ca_from_popover' => 'yes',
					'lqd_ca_preset' => 'custom',
				],
				'render_type' => 'none',
			]
		);

		$pf->add_control(
			'lqd_ca_from_y',
			[
				'label' => __( 'Translate Y', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw', 'vh' ],
				'range' => [
					'px' => [
							'min' => -500,
							'max' => 500,
							'step' => 1,
						],
						'%' => [
							'min' => -100,
							'max' => 100,
							'step' => 0.1,
						],
						'vw' => [
							'min' => -100,
							'max' => 100,
							'step' => 0.1,
						],
						'vh' => [
							'min' => -100,
							'max' => 100,
							'step' => 0.1,
						],
				],
				'default' => [
					'size' => 0,
				],
				'condition' => [
					'lqd_ca_from_popover' => 'yes',
					'lqd_ca_preset' => 'custom',
				],
				'render_type' => 'none',
			]
		);

		$pf->add_control(
			'lqd_ca_from_z',
			[
				'label' => __( 'Translate Z', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
							'min' => -500,
							'max' => 500,
							'step' => 1
					]
				],
				'default' => [
					'size' => 0,
				],
				'separator' => 'after',
				'condition' => [
					'lqd_ca_from_popover' => 'yes',
					'lqd_ca_preset' => 'custom',
				],
				'render_type' => 'none',
			]
		);

		$pf->add_control(
			'lqd_ca_from_scaleX',
			[
				'label' => __( 'Scale X', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 5,
						'step' => 0.1,
					],
				],
				'default' => [
					'size' => 1,
				],
				'condition' => [
					'lqd_ca_from_popover' => 'yes',
					'lqd_ca_preset' => 'custom',
				],
				'render_type' => 'none',
			]
		);

		$pf->add_control(
			'lqd_ca_from_scaleY',
			[
				'label' => __( 'Scale Y', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 5,
						'step' => 0.1,
					],
				],
				'default' => [
					'size' => 1,
				],
				'condition' => [
					'lqd_ca_from_popover' => 'yes',
					'lqd_ca_preset' => 'custom',
				],
				'separator' => 'after',
				'render_type' => 'none',
			]
		);

		$pf->add_control(
			'lqd_ca_from_rotationX',
			[
				'label' => __( 'Rotate X', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -360,
						'max' => 360,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 0,
				],
				'condition' => [
					'lqd_ca_from_popover' => 'yes',
					'lqd_ca_preset' => 'custom',
				],
				'render_type' => 'none',
			]
		);

		$pf->add_control(
			'lqd_ca_from_rotationY',
			[
				'label' => __( 'Rotate Y', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -360,
						'max' => 360,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 0,
				],
				'condition' => [
					'lqd_ca_from_popover' => 'yes',
					'lqd_ca_preset' => 'custom',
				],
				'render_type' => 'none',
			]
		);

		$pf->add_control(
			'lqd_ca_from_rotationZ',
			[
				'label' => __( 'Rotate Z', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -360,
						'max' => 360,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 0,
				],
				'separator' => 'after',
				'condition' => [
					'lqd_ca_from_popover' => 'yes',
					'lqd_ca_preset' => 'custom',
				],
				'render_type' => 'none',
			]
		);


		$pf->add_control(
			'lqd_ca_from_opacity',
			[
				'label' => __( 'Opacity', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.1,
					],
				],
				'default' => [
					'size' => 1,
				],
				'condition' => [
					'lqd_ca_from_popover' => 'yes',
					'lqd_ca_preset' => 'custom',
				],
				'render_type' => 'none',
			]
		);

		$pf->add_control(
			'lqd_ca_from_transformOriginX',
			[
				'label' => __( 'Transform origin X', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
							'min' => -500,
							'max' => 500,
							'step' => 1,
						],
						'%' => [
							'min' => -100,
							'max' => 100,
							'step' => 0.1,
						],
				],
				'default' => [
					'size' => 50,
					'unit' => '%',
				],
				'separator' => 'before',
				'condition' => [
					'lqd_ca_from_popover' => 'yes',
					'lqd_ca_preset' => 'custom',
				],
				'render_type' => 'none',
			]
		);

		$pf->add_control(
			'lqd_ca_from_transformOriginY',
			[
				'label' => __( 'Transform origin Y', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
							'min' => -500,
							'max' => 500,
							'step' => 1,
						],
						'%' => [
							'min' => -100,
							'max' => 100,
							'step' => 0.1,
						],
				],
				'default' => [
					'size' => 50,
					'unit' => '%',
				],
				'condition' => [
					'lqd_ca_from_popover' => 'yes',
					'lqd_ca_preset' => 'custom',
				],
				'render_type' => 'none',
			]
		);

		$pf->add_control(
			'lqd_ca_from_transformOriginZ',
			[
				'label' => __( 'Transform origin Z', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
							'min' => -500,
							'max' => 500,
							'step' => 1,
						],
				],
				'default' => [
					'size' => 0,
				],
				'separator' => 'after',
				'condition' => [
					'lqd_ca_from_popover' => 'yes',
					'lqd_ca_preset' => 'custom',
				],
				'render_type' => 'none',
			]
		);
	$pf->end_popover();

	// From Options
	$pf->add_control(
		'lqd_ca_to_popover',
		[
			'label' => __( 'Animate to', 'archub-elementor-addons' ),
			'type' => Controls_Manager::POPOVER_TOGGLE,
			'label_off' => __( 'Default', 'archub-elementor-addons' ),
			'label_on' => __( 'Custom', 'archub-elementor-addons' ),
			'return_value' => 'yes',
			'default' => 'yes',
			'condition' => [
				'lqd_custom_animation' => 'yes',
				'lqd_ca_preset' => 'custom',
			],
			'render_type' => 'none',
		]
	);

	$pf->start_popover();
		$pf->add_control(
			'lqd_ca_to_x',
			[
				'label' => __( 'Translate X', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw', 'vh' ],
				'range' => [
					'px' => [
							'min' => -500,
							'max' => 500,
							'step' => 1,
						],
						'%' => [
							'min' => -100,
							'max' => 100,
							'step' => 0.1,
						],
						'vw' => [
							'min' => -100,
							'max' => 100,
							'step' => 0.1,
						],
						'vh' => [
							'min' => -100,
							'max' => 100,
							'step' => 0.1,
						],
				],
				'default' => [
					'size' => 0,
				],
				'condition' => [
					'lqd_ca_to_popover' => 'yes',
					'lqd_ca_preset' => 'custom',
				],
				'render_type' => 'none',
			]
		);

		$pf->add_control(
			'lqd_ca_to_y',
			[
				'label' => __( 'Translate Y', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw', 'vh' ],
				'range' => [
					'px' => [
							'min' => -500,
							'max' => 500,
							'step' => 1,
						],
						'%' => [
							'min' => -100,
							'max' => 100,
							'step' => 0.1,
						],
						'vw' => [
							'min' => -100,
							'max' => 100,
							'step' => 0.1,
						],
						'vh' => [
							'min' => -100,
							'max' => 100,
							'step' => 0.1,
						],
				],
				'default' => [
					'size' => 0,
				],
				'condition' => [
					'lqd_ca_to_popover' => 'yes',
					'lqd_ca_preset' => 'custom',
				],
				'render_type' => 'none',
			]
		);

		$pf->add_control(
			'lqd_ca_to_z',
			[
				'label' => __( 'Translate Z', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
							'min' => -500,
							'max' => 500,
							'step' => 1
					]
				],
				'default' => [
					'size' => 0,
				],
				'separator' => 'after',
				'condition' => [
					'lqd_ca_to_popover' => 'yes',
					'lqd_ca_preset' => 'custom',
				],
				'render_type' => 'none',
			]
		);

		$pf->add_control(
			'lqd_ca_to_scaleX',
			[
				'label' => __( 'Scale X', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 5,
						'step' => 0.1,
					],
				],
				'default' => [
					'size' => 1,
				],
				'condition' => [
					'lqd_ca_to_popover' => 'yes',
					'lqd_ca_preset' => 'custom',
				],
				'render_type' => 'none',
			]
		);

		$pf->add_control(
			'lqd_ca_to_scaleY',
			[
				'label' => __( 'Scale Y', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 5,
						'step' => 0.1,
					],
				],
				'default' => [
					'size' => 1,
				],
				'condition' => [
					'lqd_ca_to_popover' => 'yes',
					'lqd_ca_preset' => 'custom',
				],
				'separator' => 'after',
				'render_type' => 'none',
			]
		);

		$pf->add_control(
			'lqd_ca_to_rotationX',
			[
				'label' => __( 'Rotate X', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -360,
						'max' => 360,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 0,
				],
				'condition' => [
					'lqd_ca_to_popover' => 'yes',
					'lqd_ca_preset' => 'custom',
				],
				'render_type' => 'none',
			]
		);

		$pf->add_control(
			'lqd_ca_to_rotationY',
			[
				'label' => __( 'Rotate Y', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -360,
						'max' => 360,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 0,
				],
				'condition' => [
					'lqd_ca_to_popover' => 'yes',
					'lqd_ca_preset' => 'custom',
				],
				'render_type' => 'none',
			]
		);

		$pf->add_control(
			'lqd_ca_to_rotationZ',
			[
				'label' => __( 'Rotate Z', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -360,
						'max' => 360,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 0,
				],
				'separator' => 'after',
				'condition' => [
					'lqd_ca_from_popover' => 'yes',
					'lqd_ca_preset' => 'custom',
				],
				'render_type' => 'none',
			]
		);


		$pf->add_control(
			'lqd_ca_to_opacity',
			[
				'label' => __( 'Opacity', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.1,
					],
				],
				'default' => [
					'size' => 1,
				],
				'condition' => [
					'lqd_ca_to_popover' => 'yes',
					'lqd_ca_preset' => 'custom',
				],
				'render_type' => 'none',
			]
		);

		$pf->add_control(
			'lqd_ca_to_transformOriginX',
			[
				'label' => __( 'Transform origin X', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
							'min' => -500,
							'max' => 500,
							'step' => 1,
						],
						'%' => [
							'min' => -100,
							'max' => 100,
							'step' => 0.1,
						],
				],
				'default' => [
					'size' => 50,
					'unit' => '%',
				],
				'separator' => 'before',
				'condition' => [
					'lqd_ca_to_popover' => 'yes',
					'lqd_ca_preset' => 'custom',
				],
				'render_type' => 'none',
			]
		);

		$pf->add_control(
			'lqd_ca_to_transformOriginY',
			[
				'label' => __( 'Transform origin Y', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
							'min' => -500,
							'max' => 500,
							'step' => 1,
						],
						'%' => [
							'min' => -100,
							'max' => 100,
							'step' => 0.1,
						],
				],
				'default' => [
					'size' => 50,
					'unit' => '%',
				],
				'condition' => [
					'lqd_ca_to_popover' => 'yes',
					'lqd_ca_preset' => 'custom',
				],
				'render_type' => 'none',
			]
		);

		$pf->add_control(
			'lqd_ca_to_transformOriginZ',
			[
				'label' => __( 'Transform origin Z', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
							'min' => -500,
							'max' => 500,
							'step' => 1,
						],
				],
				'default' => [
					'size' => 0,
				],
				'separator' => 'after',
				'condition' => [
					'lqd_ca_to_popover' => 'yes',
					'lqd_ca_preset' => 'custom',
				],
				'render_type' => 'none',
			]
		);
	$pf->end_popover();

}