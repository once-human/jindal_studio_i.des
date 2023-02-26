<?php
$this->sections[] = array(
	'title'      => esc_html__( 'Mobile Navigation', 'archub' ),
	'subsection' => true,
	'desc' => sprintf(
		/* translators: 1: Plugin name 2: Elementor */
		wp_kses( '<div class="notice-red"> WARNING: These options might be overwritten by your header settings. Go to Headers > Your Header > Post Settings > Mobile Navigation if these options don\'t work for you. <a href="%1$s" target="_blank"> Read more</a></div>', 'lqd_post' ),
		class_exists('Liquid_Elementor_Addons') ? 'https://docs.liquid-themes.com/article/439-hub-elementor-mobile-header-options' : 'https://docs.liquid-themes.com/article/216-mobile-header-options'
	),
	'fields'     => array(
		array(
			'id'       => 'header-mobile-menu',
			'type'     => 'select',
			'title'    => esc_html__( 'Mobile Primary Menu', 'archub' ),
			'subtitle' => esc_html__( 'Select a menu to overwrite the header menu location.', 'archub' ),
			'data'     => 'menus',
			'default'  => '',
		),
		array(
			'id'      => 'm-nav-style',
			'type'	  => 'select',
			'title'   => esc_html__( 'Style', 'archub' ),
			'description' => esc_html__( 'Select the mobile nav style.', 'archub' ),
			'options' => array(
				'classic' => esc_html__( 'Classic', 'archub' ),
				'minimal' => esc_html__( 'Minimal', 'archub' ),
				'modern'  => esc_html__( 'Modern', 'archub' ),
			),
			'default'  => 'modern',
		),
		array(
			'id'      => 'm-nav-logo-alignment',
			'type'	  => 'select',
			'title'   => esc_html__( 'Logo Alignment', 'archub' ),
			'description' => esc_html__( 'Logo alignment on mobile.', 'archub' ),
			'options' => array(
				'default' => esc_html__( 'Default', 'archub' ),
				'center'  => esc_html__( 'Center', 'archub' ),
			),
		),
		array(
			'id'      => 'm-nav-trigger-alignment',
			'type'	  => 'select',
			'title'   => esc_html__( 'Trigger Alignment', 'archub' ),
			'description' => esc_html__( 'Navigation trigger alignment on mobile.', 'archub' ),
			'options' => array(
				'right' => esc_html__( 'Right', 'archub' ),
				'left'  => esc_html__( 'Left', 'archub' ),
			),
		),
		array(
			'id'      => 'm-nav-alignment',
			'type'	  => 'select',
			'title'   => esc_html__( 'Navigation Items Alignment', 'archub' ),
			'description' => esc_html__( 'Select the alignment for navigation items alignment.', 'archub' ),
			'options' => array(
				'right' => esc_html__( 'Right', 'archub' ),
				'center' => esc_html__( 'Center', 'archub' ),
				'left'  => esc_html__( 'Left', 'archub' ),
			),
			'required' => array(
				'm-nav-style',
				'=',
				array( 'classic', 'minimal' )
			),
		),
		array(
			'id'      => 'm-nav-scheme',
			'type'	  => 'select',
			'title'   => esc_html__( 'Navigation Color Scheme', 'archub' ),
			'description' => esc_html__( 'Select the color scheme for mobile navigation.', 'archub' ),
			'options' => array(
				'gray' => esc_html__( 'Gray', 'archub' ),
				'light' => esc_html__( 'Light', 'archub' ),
				'dark'  => esc_html__( 'Dark', 'archub' ),
				'custom' => esc_html__( 'Custom', 'archub' ),
			),
			'required' => array(
				'm-nav-style',
				'=',
				array( 'classic', 'minimal' )
			),
			'default'  => 'gray',
		),
		array(
			'id'          => 'm-nav-custom-bg',
			'type'        => 'liquid_colorpicker',
			'title'       => esc_html__( 'Navigation Background', 'archub' ),
			'description' => esc_html__( 'of the mobile version of the website', 'archub' ),
			'required'    => array(
				'm-nav-scheme',
				'=',
				array( 'custom' )
			),
		),
		array(
			'id'          => 'm-nav-custom-color',
			'type'        => 'liquid_colorpicker',
			'only_solid'  => true,
			'title'       => esc_html__( 'Navigation Text/Trigger Color', 'archub' ),
			'description' => esc_html__( 'of the mobile version of the website', 'archub' ),
			'required'    => array( 'm-nav-scheme', '=', array( 'custom' ) ),
		),
		array(
			'id'          => 'm-nav-modern-bg',
			'type'        => 'liquid_colorpicker',
			'title'       => esc_html__( 'Navigation Background', 'archub' ),
			'description' => esc_html__( 'of the mobile version of the website', 'archub' ),
			'required'    => array( 'm-nav-style', '=', 'modern' ),
		),
		array(
			'id'          => 'm-nav-modern-color',
			'type'        => 'liquid_colorpicker',
			'only_solid'  => true,
			'title'       => esc_html__( 'Navigation Text/Trigger Color', 'archub' ),
			'description' => esc_html__( 'of the mobile version of the website', 'archub' ),
			'required'    => array( 'm-nav-style', '=', 'modern' ),
		),
		array(
			'id'          => 'm-nav-border-color',
			'type'        => 'liquid_colorpicker',
			'only_solid'  => true,
			'title'       => esc_html__( 'Navigation Border Color', 'archub' ),
			'description' => esc_html__( 'of the mobile version of the website', 'archub' ),
			'required'    => array( 
				array( 'm-nav-style', '=', 'classic' ), 
				array( 'm-nav-scheme', '=', array( 'custom' ) ), 
			),
		),
		
		array(
			'id'      => 'm-nav-header-scheme',
			'type'	  => 'select',
			'title'   => esc_html__( 'Header Color Scheme', 'archub' ),
			'description' => esc_html__( 'Select color scheme for mobile header.', 'archub' ),
			'options' => array(
				'light' => esc_html__( 'Light', 'archub' ),
				'gray' => esc_html__( 'Gray', 'archub' ),
				'dark'  => esc_html__( 'Dark', 'archub' ),
				'custom' => esc_html__( 'Custom', 'archub' ),
			),
			'default'  => 'gray',
		),
		array(
			'id'          => 'm-nav-header-custom-bg',
			'type'        => 'liquid_colorpicker',
			'title'       => esc_html__( 'Header Background', 'archub' ),
			'description' => esc_html__( 'of the mobile version of the website', 'archub' ),
			'required'    => array(
				'm-nav-header-scheme',
				'=',
				array( 'custom' )
			),
		),
		array(
			'id'          => 'm-nav-header-custom-color',
			'type'        => 'liquid_colorpicker',
			'only_solid'  => true,
			'title'       => esc_html__( 'Header Text/Trigger Color', 'archub' ),
			'description' => esc_html__( 'of the mobile version of the website', 'archub' ),
			'required'    => array(
				'm-nav-header-scheme',
				'=',
				array( 'custom' )
			),
		),
		array(
			'id'      => 'mobile-header-overlay',
			'type'	  => 'button_set',
			'title'   => esc_html__( 'Enable Overlay on mobile device?', 'archub' ),
			'options' => array(
				'no'    => esc_html__( 'No', 'archub' ),
				'yes' => esc_html__( 'Yes', 'archub' ),
			),
			'default' => 'no'
		),
		array(
			'id'      => 'mobile-header-sticky',
			'type'	  => 'button_set',
			'title'   => esc_html__( 'Enable Sticky Header on mobile devices?', 'archub' ),
			'options' => array(
				'no'  => esc_html__( 'No', 'archub' ),
				'yes' => esc_html__( 'Yes', 'archub' ),
			),
			'default' => 'no',
		),
		

	)
);