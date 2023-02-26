<?php
/*
 * Title Wrapper Section
 *
 * Available options on $section array:
 * separate_box (boolean) - separate metabox is created if true
 * box_title - title for separate metabox
 * title - section title
 * desc - section description
 * icon - section icon
 * fields - fields, @see https://docs.reduxframework.com/ for details
*/

$sections[] = array(
	'post_types' => array( 'product' ),
	'title'      => esc_html__( 'Title Wrapper', 'archub' ),
	'icon'       => 'el-icon-cog',
	'fields'     => array(
		array(
			'id'       => 'title-bar-enable',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Title Wrapper', 'archub' ),
			'options'  => array(
				'on'  => esc_html__( 'On', 'archub' ),
				'0'   => esc_html__( 'Default', 'archub' ),
				'off' => esc_html__( 'Off', 'archub' )
			),
			'default'  => '0'
		),
		array(
			'id'       => 'title-bar-heading',
			'type'     => 'text',
			'title'    => esc_html__( 'Custom Heading', 'archub' ),
			'subtitle' => esc_html__( 'Custom heading will override the default page/post title', 'archub' ),
			'required' => array(
				'title-bar-enable',
				'!=',
				'off'
			),
		),
		array(
			'id'       => 'title-bar-typography-enable',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Enable Title bar Typography', 'archub' ),
			'options'  => array(
				'on'  => esc_html__( 'On', 'archub' ),
				'0'   => esc_html__( 'Default', 'archub' ),
				'off' => esc_html__( 'Off', 'archub' )
			),
			'default'  => 'off',
			'required' => array(
				'title-bar-enable',
				'!=',
				'off'
			),
		),
		'title-bar-typography' => array(
			'id'             => 'title-bar-typography',
			'title'          => esc_html__( 'Title Bar Heading Typography', 'archub' ),
			'subtitle'       => esc_html__( 'These settings control the typography for the titlebar heading', 'archub' ),
			'type'           => 'typography',
			'text-transform' => true,
			'letter-spacing' => true,
			'text-align'     => false,
			'compiler'       => true,
			'units'          => '%',
			'required' => array(
				'title-bar-typography-enable',
				'!=',
				'off'
			),
		),
		array(
			'id'    => 'title-bar-subheading',
			'type'  => 'text',
			'title' => esc_html__( 'Sub-Heading', 'archub' ),
			'required' => array(
				'title-bar-enable',
				'!=',
				'off'
			),
		),
		array(
			'id'       => 'title-bar-subheading-typography-enable',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Enable Title bar Typography', 'archub' ),
			'options'  => array(
				'on'  => esc_html__( 'On', 'archub' ),
				'0'   => esc_html__( 'Default', 'archub' ),
				'off' => esc_html__( 'Off', 'archub' )
			),
			'default'  => 'off',
			'required' => array(
				'title-bar-enable',
				'!=',
				'off'
			),
		),
		'title-bar-subheading-typography' => array(
			'id'             => 'title-bar-subheading-typography',
			'title'          => esc_html__( 'Title Bar Subheading Typography', 'archub' ),
			'subtitle'       => esc_html__( 'These settings control the typography for the titlebar subheading', 'archub' ),
			'type'           => 'typography',
			'text-transform' => true,
			'letter-spacing' => true,
			'text-align'     => false,
			'compiler'       => true,
			'units'          => '%',
			'required' => array(
				'title-bar-subheading-typography-enable',
				'!=',
				'off'
			),
		),
		array(
			'type'     => 'slider',
			'id'       => 'title-bar-padding-top',
			'title'    => esc_html__( 'Padding Top', 'archub' ),
			'subtitle' => esc_html__( 'Controls the top padding of the titlebar', 'archub' ),
			'default'  => 80,
			'max'      => 300,
			'required' => array(
				'title-bar-enable',
				'!=',
				'off'
			),
		),
		array(
			'type'     => 'slider',
			'id'       => 'title-bar-padding-bottom',
			'title'    => esc_html__( 'Padding Bottom', 'archub' ),
			'subtitle' => esc_html__( 'Controls the bottom padding of the titlebar', 'archub' ),
			'default'  => 80,
			'max'      => 300,
			'required' => array(
				'title-bar-enable',
				'!=',
				'off'
			),
		),
		array(
			'id'       => 'title-bar-scheme',
			'type'     => 'select',
			'title'    => esc_html__( 'Color scheme', 'archub' ),
			'options'  => array(
				''              => esc_html__( 'Light', 'archub' ),
				'scheme-light'  => esc_html__( 'Dark', 'archub' ),
			),
			'required' => array(
				'title-bar-enable',
				'!=',
				'off'
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
			'required' => array(
				'title-bar-enable',
				'!=',
				'off'
			),
		),
		array(
			'id'       => 'title-bar-bg',
			'type'     => 'background',
			'title'    => esc_html__( 'Background Image', 'archub' ),
			'required' => array(
				'title-bar-enable',
				'!=',
				'off'
			),
		),
		
		array(
			'id'            => 'title-bar-bg-gradient',
			'type'          => 'liquid_colorpicker',
			'only_gradient' => true,
			'title'    => esc_html__( 'Background Gradient', 'archub' ),
			'subtitle' => esc_html__( 'Overwrites the background image, unless has transparency.', 'archub' ),
			'required' => array(
				'title-bar-enable',
				'!=',
				'off'
			),
		),
		array(
			'id'       => 'title-bar-parallax',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Enable Parallax?', 'archub' ),
			'options' => array(
				'on'   => esc_html__( 'On', 'archub' ),
				'0'   => esc_html__( 'Default', 'archub' ),
				'off'  => esc_html__( 'Off', 'archub' ),
			),
			'subtitle' => esc_html__( 'The background should have an image', 'archub' ),
			'required' => array(
				'title-bar-enable',
				'!=',
				'off'
			),
		),
		array(
			'id'      => 'title-bar-overlay',
			'type'	  => 'button_set',
			'title'   => esc_html__( 'Enable Overlay', 'archub' ),
			'options' => array(
				'on'   => esc_html__( 'On', 'archub' ),
				'0'   => esc_html__( 'Default', 'archub' ),
				'off'  => esc_html__( 'Off', 'archub' ),
			),
			'default' => 'off',
			'required' => array(
				'title-bar-enable',
				'!=',
				'off'
			),
		),
		array(
			'id'       => 'title-bar-overlay-background',
			'type'     => 'liquid_colorpicker',
			'title'    => esc_html__( 'Overlay Background', 'archub' ),
			'required' => array(
				'title-bar-overlay',
				'!=',
				'off'
			),
		),
		array(
			'id'      => 'title-bar-breadcrumb',
			'type'    => 'button_set',
			'title'   => esc_html__( 'Enable Breadcrumbs', 'archub' ),
			'options' => array(
				'on'  => esc_html__( 'On', 'archub' ),
				'0'   => esc_html__( 'Default', 'archub' ),
				'off' => esc_html__( 'Off', 'archub' )
			),
			'required' => array(
				'title-bar-enable',
				'!=',
				'off'
			),
		),
		array(
			'id'      => 'title-bar-scroll',
			'type'	  => 'button_set',
			'title'   => esc_html__( 'Enable Scroll Button', 'archub' ),
			'options' => array(
				'on'   => esc_html__( 'On', 'archub' ),
				'0'    => esc_html__( 'Default', 'archub' ),
				'off'  => esc_html__( 'Off', 'archub' ),
			),
			'default' => '',
			'required' => array(
				'title-bar-enable',
				'!=',
				'off'
			),
		),		
		array(
			'id'         => 'title-bar-scroll-color',
			'type'       => 'liquid_colorpicker',
			'only_solid' => true,
			'title'      => esc_html__( 'Scroll Button Color', 'archub' ),
			'subtitle'   => esc_html__( 'Pick a color for scroll button', 'archub' ),
			'required'   => array(
				'title-bar-scroll',
				'!=',
				'off'
			),
		),
		array(
			'id'       => 'title-bar-scroll-id',
			'type'     => 'text',
			'title'    => esc_html__( 'Anchor ID', 'archub' ),
			'subtitle' => esc_html__( 'Input anchor ID of the section for scroll button', 'archub' ),
			'required' => array(
				'title-bar-scroll',
				'!=',
				'off'
			),
		),
		array(
			'id'=>'title-bar-classes',
			'type' => 'text',
			'title' => esc_html__('Extra classes', 'archub'),
			'required' => array(
				'title-bar-enable',
				'!=',
				'off'
			),
			
		),

	), // #fields
);