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

function ld_el_parallax($pf){

	$parallax_elements_array = [
		''  => __( 'Default', 'archub-elementor-addons' ),
	];

	$parallax_elements_array['img, canvas'] = __( 'Image element', 'archub-elementor-addons' );

	$pf->add_control(
		'lqd_parallax',
		[
			'label' => __( 'Parallax', 'archub-elementor-addons' ),
			'type' => Controls_Manager::SWITCHER,
			'label_on' => __( 'On', 'archub-elementor-addons' ),
			'label_off' => __( 'Off', 'archub-elementor-addons' ),
			'return_value' => 'yes',
			'default' => '',
			'render_type' => 'none',
		]
	);

	$pf->add_control(
		'lqd_parallax_settings_popover',
		[
			'label' => __( 'Settings', 'archub-elementor-addons' ),
			'type' => Controls_Manager::POPOVER_TOGGLE,
			'label_off' => __( 'Default', 'archub-elementor-addons' ),
			'label_on' => __( 'Custom', 'archub-elementor-addons' ),
			'return_value' => 'yes',
			'default' => 'yes',
			'condition' => [
				'lqd_parallax' => 'yes'
			],
			'render_type' => 'none',
		]
	);

	// Parallax Settings
	$pf->start_popover();
		$pf->add_control(
			'lqd_parallax_settings_ease',
			[
				'label' => __( 'Easing', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => [ 'linear' ],
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
					'lqd_parallax_settings_popover' => 'yes',
				],
				'render_type' => 'none',
			]
		);

		$pf->add_control(
			'lqd_parallax_settings_trigger',
			[
				'label' => __( 'Trigger', 'archub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'top bottom',
				'options' => [
					'top bottom'  => __( 'On Enter', 'archub-elementor-addons' ),
					'top top' => __( 'On Leave', 'archub-elementor-addons' ),
					'center center' => __( 'On Center', 'archub-elementor-addons' ),
					'custom' => __( 'Custom', 'archub-elementor-addons' ),
				],
				'condition' => [
					'lqd_parallax_settings_popover' => 'yes',
				],
				'render_type' => 'none',
			]
		);

		$pf->add_control(
			'lqd_parallax_settings_parallaxElement',
			[
				'label' => __( 'Parallax element', 'archub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => $parallax_elements_array,
				'condition' => [
					'lqd_parallax_settings_popover' => 'yes',
				],
				'render_type' => 'none',
			]
		);

		$pf->add_control(
			'lqd_parallax_trigger_desc',
			[
				'type' => Controls_Manager::RAW_HTML,
				'raw' => sprintf( __( '<div style="font-style: normal;">For custom start and end values you can use keywords like <b>top, bottom, left, right and center</b>. You can also use numbers. E.g. <b>50&#x25; 50&#x25;</b>. Or you can use relative values e.g. <b>top bottom-=25&#x25;</b>.</div>', 'archub-elementor-addons' ) ),
				'separator' => 'before',
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				'condition' => array(
					'lqd_parallax_settings_trigger' => 'custom',
					'lqd_parallax_settings_popover' => 'yes',
				),
			]
		);

		$pf->add_control(
			'lqd_parallax_settings_trigger_start',
			[
				'label' => __( 'Trigger Start', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Default: top bottom', 'archub-elementor-addons' ),
				'default' => 'top bottom',
				'description' => __( 'Define when parallax starts. Default is <b>top bottom</b> which means starts when <b>top</b> of the element hits the <b>bottom</b> of the viewport.', 'archub-elementor-addons' ),
				'condition' => array(
					'lqd_parallax_settings_trigger' => 'custom',
					'lqd_parallax_settings_popover' => 'yes',
				),
				'render_type' => 'none',
			]
		);

		$pf->add_control(
			'lqd_parallax_settings_trigger_end',
			[
				'label' => __( 'Trigger End', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Default: bottom top', 'archub-elementor-addons' ),
				'default' => 'bottom top',
				'description' => __( 'Define when parallax ends. Default is <b>bottom top</b> which means ends when <b>bottom</b> of the element hits the <b>top</b> of the viewport.', 'archub-elementor-addons' ),
				'condition' => array(
					'lqd_parallax_settings_trigger' => 'custom',
					'lqd_parallax_settings_popover' => 'yes',
				),
				'separator' => 'after',
				'render_type' => 'none',
			]
		);

		$pf->add_control(
			'lqd_parallax_settings_scrub',
			[
				'label' => __( 'Scrub', 'archub-elementor-addons' ),
				'description' => __( 'The time that takes the elements to catch the scroll position in seconds.', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0.1,
						'max' => 10,
						'step' => 0.1,
					],
				],
				'default' => [
					'size' => 0.55,
				],
				'condition' => [
					'lqd_parallax_settings_popover' => 'yes',
					'lqd_parallax_settings_trigger!' => 'custom',
				],
				'render_type' => 'none',
			]
		);

		$pf->add_control(
			'lqd_parallax_settings_duration',
			[
				'label' => __( 'Increase / Decrease Duration', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
							'min' => -500,
							'max' => 500,
							'step' => 1,
						],
						'%' => [
							'min' => -500,
							'max' => 500,
							'step' => 0.1,
						],
				],
				'default' => [
					'size' => 0,
				],
				'condition' => [
					'lqd_parallax_settings_popover' => 'yes',
					'lqd_parallax_settings_trigger!' => 'custom',
				],
				'render_type' => 'none',
			]
		);

		$pf->add_control(
			'lqd_parallax_settings_perspective',
			[
				'label' => __( 'Perspective', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
							'min' => 0,
							'max' => 2000,
							'step' => 1,
						],
				],
				'default' => [
					'size' => '',
				],
				'condition' => [
					'lqd_parallax_settings_popover' => 'yes',
				],
				'render_type' => 'none',
			]
		);
	$pf->end_popover();

	// Parallax From Options
	$pf->add_control(
		'lqd_parallax_from_options',
		[
			'label' => __( 'Parallax from', 'archub-elementor-addons' ),
			'type' => Controls_Manager::POPOVER_TOGGLE,
			'label_off' => __( 'Default', 'archub-elementor-addons' ),
			'label_on' => __( 'Custom', 'archub-elementor-addons' ),
			'return_value' => 'yes',
			'default' => 'yes',
			'condition' => [
				'lqd_parallax' => 'yes'
			],
			'render_type' => 'none',
		]
	);
	$pf->start_popover();
	$pf->add_control(
		'lqd_parallax_from_x',
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
				'lqd_parallax_from_options' => 'yes'
			],
			'render_type' => 'none',
		]
	);

	$pf->add_control(
		'lqd_parallax_from_y',
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
				'lqd_parallax_from_options' => 'yes'
			],
			'render_type' => 'none',
		]
	);

	$pf->add_control(
		'lqd_parallax_from_z',
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
				'lqd_parallax_from_options' => 'yes'
			],
			'render_type' => 'none',
		]
	);

	$pf->add_control(
		'lqd_parallax_from_scaleX',
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
				'lqd_parallax_from_options' => 'yes'
			],
			'render_type' => 'none',
		]
	);

	$pf->add_control(
		'lqd_parallax_from_scaleY',
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
				'lqd_parallax_from_options' => 'yes'
			],
			'separator' => 'after',
			'render_type' => 'none',
		]
	);

	$pf->add_control(
		'lqd_parallax_from_rotationX',
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
				'lqd_parallax_from_options' => 'yes'
			],
			'render_type' => 'none',
		]
	);

	$pf->add_control(
		'lqd_parallax_from_rotationY',
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
				'lqd_parallax_from_options' => 'yes'
			],
			'render_type' => 'none',
		]
	);

	$pf->add_control(
		'lqd_parallax_from_rotationZ',
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
			'condition' => [
				'lqd_parallax_from_options' => 'yes'
			],
			'render_type' => 'none',
		]
	);

	$pf->add_control(
		'lqd_parallax_from_opacity',
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
				'lqd_parallax_from_options' => 'yes'
			],
			'separator' => 'before',
			'render_type' => 'none',
		]
	);

	$pf->add_control(
		'lqd_parallax_from_transformOriginX',
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
				'lqd_parallax_from_options' => 'yes'
			],
			'render_type' => 'none',
		]
	);

	$pf->add_control(
		'lqd_parallax_from_transformOriginY',
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
				'lqd_parallax_from_options' => 'yes'
			],
			'render_type' => 'none',
		]
	);

	$pf->add_control(
		'lqd_parallax_from_transformOriginZ',
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
			'condition' => [
				'lqd_parallax_from_options' => 'yes'
			],
			'render_type' => 'none',
		]
	);

	$pf->end_popover(); // parallax from

	// Parallax To Options
	$pf->add_control(
		'lqd_parallax_to_options',
		[
			'label' => __( 'Parallax to', 'archub-elementor-addons' ),
			'type' => Controls_Manager::POPOVER_TOGGLE,
			'label_off' => __( 'Default', 'archub-elementor-addons' ),
			'label_on' => __( 'Custom', 'archub-elementor-addons' ),
			'return_value' => 'yes',
			'default' => 'yes',
			'condition' => [
				'lqd_parallax' => 'yes'
			],
			'render_type' => 'none',
		]
	);
	$pf->start_popover();
	$pf->add_control(
		'lqd_parallax_to_x',
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
				'lqd_parallax_to_options' => 'yes'
			],
			'render_type' => 'none',
		]
	);

	$pf->add_control(
		'lqd_parallax_to_y',
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
				'lqd_parallax_to_options' => 'yes'
			],
			'render_type' => 'none',
		]
	);

	$pf->add_control(
		'lqd_parallax_to_z',
		[
			'label' => __( 'Translate Z', 'archub-elementor-addons' ),
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
				'lqd_parallax_to_options' => 'yes'
			],
			'render_type' => 'none',
		]
	);

	$pf->add_control(
		'lqd_parallax_to_scaleX',
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
				'lqd_parallax_to_options' => 'yes'
			],
			'render_type' => 'none',
		]
	);

	$pf->add_control(
		'lqd_parallax_to_scaleY',
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
				'lqd_parallax_to_options' => 'yes'
			],
			'separator' => 'after',
			'render_type' => 'none',
		]
	);

	$pf->add_control(
		'lqd_parallax_to_rotationX',
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
				'lqd_parallax_to_options' => 'yes'
			],
			'render_type' => 'none',
		]
	);

	$pf->add_control(
		'lqd_parallax_to_rotationY',
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
				'lqd_parallax_to_options' => 'yes'
			],
			'render_type' => 'none',
		]
	);

	$pf->add_control(
		'lqd_parallax_to_rotationZ',
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
			'condition' => [
				'lqd_parallax_to_options' => 'yes'
			],
			'render_type' => 'none',
		]
	);

	$pf->add_control(
		'lqd_parallax_to_opacity',
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
				'lqd_parallax_to_options' => 'yes'
			],
			'separator' => 'before',
			'render_type' => 'none',
		]
	);

	$pf->add_control(
		'lqd_parallax_to_transformOriginX',
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
				'lqd_parallax_to_options' => 'yes'
			],
			'render_type' => 'none',
		]
	);

	$pf->add_control(
		'lqd_parallax_to_transformOriginY',
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
				'lqd_parallax_to_options' => 'yes'
			],
			'render_type' => 'none',
		]
	);

	$pf->add_control(
		'lqd_parallax_to_transformOriginZ',
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
			'condition' => [
				'lqd_parallax_to_options' => 'yes'
			],
			'render_type' => 'none',
		]
	);
	
	$pf->end_popover(); // parallax to
}