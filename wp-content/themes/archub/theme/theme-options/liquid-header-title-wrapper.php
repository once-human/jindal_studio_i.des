<?php
/*
 * Title Wrapper Section
*/

// Title Bar
$this->sections[] = array(
	'title'      => esc_html__( 'Page Title Bar', 'archub' ),
	'icon'       => 'el el-indent-right',
	//'subsection' => true,
	'fields'     => array(
		array(
			'id'       => 'title-bar-enable',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Title Bar', 'archub' ),
			'subtitle' => esc_html__( 'Switch off to hide the title bar on your website.', 'archub' ),
			'options'  => array(
				'on'  => esc_html__( 'On', 'archub' ),
				'off' => esc_html__( 'Off', 'archub' )
			),
			'default'  => 'on'
		),
		array(
			'id'       => 'title-bar-heading',
			'type'     => 'text',
			'title'    => esc_html__( 'Custom Page Title', 'archub' ),
			'subtitle' => esc_html__( 'Custom page title will override the default page and post titles', 'archub' ),
		),
		array(
			'id'       => 'title-bar-typography-enable',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Page Title Custom Typography', 'archub' ),
			'options'  => array(
				'on'  => esc_html__( 'On', 'archub' ),
				'off' => esc_html__( 'Off', 'archub' )
			),
			'default'  => 'off',

		),
		'title-bar-typography' => array(
			'id'             => 'title-bar-typography',
			'title'          => esc_html__( 'Page Title Typography', 'archub' ),
			'subtitle'       => esc_html__( 'Manages the typography for the page title', 'archub' ),
			'type'           => 'typography',
			'text-transform' => true,
			'letter-spacing' => true,
			'text-align'     => false,
			'compiler'       => true,
			'units'          => '%',
			'required' => array(
				'title-bar-typography-enable',
				'equals',
				'on'
			),
		),
		array(
			'id'    => 'title-bar-subheading',
			'type'  => 'text',
			'title' => esc_html__( 'Page Subtitle', 'archub' ),

		),
		array(
			'id'       => 'title-bar-subheading-typography-enable',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Page Subtitle Custom Typography', 'archub' ),
			'options'  => array(
				'on'  => esc_html__( 'On', 'archub' ),
				'off' => esc_html__( 'Off', 'archub' )
			),
			'default'  => 'off',

		),
		'title-bar-subheading-typography' => array(
			'id'             => 'title-bar-subheading-typography',
			'title'          => esc_html__( 'Page Subtitle Typography', 'archub' ),
			'subtitle'       => esc_html__( 'Manages the typography for the page subtitle', 'archub' ),
			'type'           => 'typography',
			'text-transform' => true,
			'letter-spacing' => true,
			'text-align'     => false,
			'compiler'       => true,
			'units'          => '%',
			'required' => array(
				'title-bar-subheading-typography-enable',
				'equals',
				'on'
			),
		),
		array(
			'type'     => 'slider',
			'id'       => 'title-bar-padding-top',
			'title'    => esc_html__( 'Padding Top', 'archub' ),
			'subtitle' => esc_html__( 'Manages the top padding of the titlebar', 'archub' ),
			'default'  => 80,
			'max'      => 300,
		),
		array(
			'type'     => 'slider',
			'id'       => 'title-bar-padding-bottom',
			'title'    => esc_html__( 'Padding Bottom', 'archub' ),
			'subtitle' => esc_html__( 'Manages the bottom padding of the titlebar', 'archub' ),
			'default'  => 80,
			'max'      => 300,
		),
		array(
			'id'       => 'title-bar-scheme',
			'type'     => 'select',
			'title'    => esc_html__( 'Color scheme', 'archub' ),
			'options'  => array(
				''              => esc_html__( 'Light', 'archub' ),
				'scheme-light'  => esc_html__( 'Dark', 'archub' ),
			),
		),
		array(
			'id'       => 'title-bar-align',
			'type'     => 'select',
			'title'    => esc_html__( 'Alignment', 'archub' ),
			'options' => array(
				'text-start'   => esc_html__( 'Left', 'archub' ),
				'text-center' => esc_html__( 'Center', 'archub' ),
				'text-end'  => esc_html__( 'Right', 'archub' ),
				'titlebar-split'  => esc_html__( 'Split', 'archub' ),
			),
		),
		
		array(
			'id'       => 'title-bar-bg',
			'type'     => 'background',
			'title'    => esc_html__( 'Background Image', 'archub' ),
		),
		
		array(
			'id'            => 'title-bar-bg-gradient',
			'type'          => 'liquid_colorpicker',
			'only_gradient' => true,
			'title'    => esc_html__( 'Background Gradient', 'archub' ),
			'subtitle' => esc_html__( 'Overwrites the background image, unless has transparency.', 'archub' ),
		),
		array(
			'id'       => 'title-bar-parallax',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Parallax', 'archub' ),
			'options' => array(
				'on'   => esc_html__( 'On', 'archub' ),
				'off'  => esc_html__( 'Off', 'archub' ),
			),
			'subtitle' => esc_html__( 'The background should have an image', 'archub' ),
			'default' => 'off',
		),
		array(
			'id'      => 'title-bar-overlay',
			'type'	  => 'button_set',
			'title'   => esc_html__( 'Overlay', 'archub' ),
			'options' => array(
				'on'   => esc_html__( 'On', 'archub' ),
				'off'  => esc_html__( 'Off', 'archub' ),
			),
			'default' => 'off',
		),
		array(
			'id'       => 'title-bar-overlay-background',
			'type'     => 'liquid_colorpicker',
			'title'    => esc_html__( 'Overlay Background', 'archub' ),
			'required' => array(
				'title-bar-overlay',
				'equals',
				'on'
			),
		),
		array(
			'id'      => 'title-bar-breadcrumb',
			'type'    => 'button_set',
			'title'   => esc_html__( 'Breadcrumbs', 'archub' ),
			'options' => array(
				'on'  => esc_html__( 'On', 'archub' ),
				'off' => esc_html__( 'Off', 'archub' )
			),
		),
		array(
			'id'      => 'title-bar-scroll',
			'type'	  => 'button_set',
			'title'   => esc_html__( 'Scroll Button', 'archub' ),
			'options' => array(
				'on'   => esc_html__( 'On', 'archub' ),
				'off'  => esc_html__( 'Off', 'archub' ),
			),
			'default' => '',
		),		
		array(
			'id'         => 'title-bar-scroll-color',
			'type'       => 'liquid_colorpicker',
			'only_solid' => true,
			'title'      => esc_html__( 'Scroll Button Color', 'archub' ),
			'subtitle'   => esc_html__( 'Choose a color for scroll button', 'archub' ),
			'required'   => array(
				'title-bar-scroll',
				'equals',
				'on'
			),
		),
		array(
			'id'       => 'title-bar-scroll-id',
			'type'     => 'text',
			'title'    => esc_html__( 'Anchor ID', 'archub' ),
			'subtitle' => esc_html__( 'Anchor ID of the section where the page will be scrolled on click to the scroll button', 'archub' ),
			'required' => array(
				'title-bar-scroll',
				'equals',
				'on'
			),
		),
		array(
			'id'=>'title-bar-classes',
			'type' => 'text',
			'title' => esc_html__( 'Extra classes', 'archub' ),
			
		),
	)
);
