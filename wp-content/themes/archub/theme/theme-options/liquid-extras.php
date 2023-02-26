<?php
/*
 * Extras Section
*/

$this->sections[] = array(
	'title'  => esc_html__('Extras', 'archub'),
	'icon'   => 'el el-plus-sign'
);

// Custom Cursor Fields
$this->sections[] = array(
	'title'  => esc_html__( 'Custom Cursor', 'archub' ),
	'subsection' => true,
	'fields' => array(
		array(
			'id'       => 'use-cursor-image',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Change system cursor?', 'archub' ),
			'subtitle' => esc_html__( 'You can set a custom image as the system cursor.', 'archub' ),
			'options' => array(
				'on'  => esc_html__( 'On', 'archub' ),
				'off' => esc_html__( 'Off', 'archub' )
			),
			'default' => 'off',
		),
		array(
			'id'       => 'cursor-image-style',
			'type'     => 'select',
			'title'    => esc_html__( 'Cursor image', 'archub' ),
			'subtitle'   => esc_html__( 'Choose pre-made cursor images, or upload a custom image.', 'archub' ),
			'options'  => array(
				'custom-cursor-1.svg' => esc_html__( 'Image 1', 'archub' ),
				'custom' => esc_html__( 'Custom', 'archub' ),
			),
			'default' => 'custom-cursor-1.svg',
			'required' => array(
				'use-cursor-image',
				'=',
				'on'
			),
		),
		array(
			'id'       => 'cursor-image-image',
			'type'     => 'background',
			'title'    => esc_html__( 'Cursor Custom Image', 'archub' ),
			'background-color'      => false,
			'background-repeat'     => false,
			'background-attachment' => false,
			'background-position'   => false,
			'background-image'      => true,
			'background-gradient'   => false,
			'background-clip'       => false,
			'background-origin'     => false,
			'background-size'       => false,
			'preview_media'         => false,
			'preview'               => false,
			'transparent'           => false,
			'required' => array(
				'cursor-image-style',
				'=',
				'custom'
			),
		),
		array(
			'id'       => 'cursor-image-cor-x',
			'type'     => 'slider',
			'title'    => esc_html__( 'Image Horizontal Offset', 'archub' ),
			'min'     => '0',
			'max'		 	=> '100',
			'step'    => '1',
			'default' => '0',
			'required' => array(
				'use-cursor-image',
				'=',
				'on'
			),
		),
		array(
			'id'       => 'cursor-image-cor-y',
			'type'     => 'slider',
			'title'    => esc_html__( 'Image Vertical Offset', 'archub' ),
			'min'     => '0',
			'max'			=> '100',
			'step'    => '1',
			'default' => '0',
			'required' => array(
				'use-cursor-image',
				'=',
				'on'
			),
		),
		array(
			'id'       => 'enable-custom-cursor',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Custom cursor', 'archub' ),
			'subtitle' => esc_html__( 'Switch on to enable custom cursor', 'archub' ),
			'options' => array(
				'on'  => esc_html__( 'On', 'archub' ),
				'off' => esc_html__( 'Off', 'archub' )
			),
			'default' => 'off'
		),
		array(
			'id'       => 'cc-label-explore',
			'type'     => 'text',
			'title'    => esc_html__( 'Label Over Images', 'archub' ),
			'default'  => esc_html__( 'Explore', 'archub' ),
			'required' => array(
				'enable-custom-cursor',
				'=',
				'on'
			),
		),
		array(
			'id'       => 'cc-label-drag',
			'type'     => 'text',
			'title'    => esc_html__( 'Label Over Carousels', 'archub' ),
			'default'  => esc_html__( 'Drag', 'archub' ),
			'required' => array(
				'enable-custom-cursor',
				'=',
				'on'
			),
		),
		array(
			'id'       => 'cc-hide-outer',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Hide Outer circle cursor', 'archub' ),
			'subtitle' => esc_html__( 'Switch on to hide outer circle', 'archub' ),
			'options' => array(
				'on'  => esc_html__( 'On', 'archub' ),
				'off' => esc_html__( 'Off', 'archub' )
			),
			'default' => 'off',
			'required' => array(
				'enable-custom-cursor',
				'=',
				'on'
			),
		),
		array(
			'id'       => 'cc-inner-size',
			'type'     => 'text',
			'title'    => esc_html__( 'Inner circle size', 'archub' ),
			'subtitle' => esc_html__( 'Define the size of the inner custom cursor, For instance, 120px', 'archub' ),
			'default'  => '7px',
			'required' => array(
				'enable-custom-cursor',
				'=',
				'on'
			),
		),
		array(
			'id'       => 'cc-outer-size',
			'type'     => 'text',
			'title'    => esc_html__( 'Custom Cursor Outer size', 'archub' ),
			'subtitle' => esc_html__( 'Define the size of the outer custom cursor, For instance, 120px', 'archub' ),
			'default'  => '35px',
			'required' => array(
				array( 'enable-custom-cursor', '=', 'on' ),
				array( 'cc-hide-outer', '=', 'off' ),
			),
		),
		array(
			'id'       => 'cc-outer-active-border-width',
			'type'     => 'text',
			'title'    => esc_html__( 'Outer Circle Active Border Width', 'archub' ),
			'subtitle' => esc_html__( 'Define the border width of outer circle when hovering over links, for instance, 3px', 'archub' ),
			'default'  => '1px',
			'required' => array(
				array( 'enable-custom-cursor', '=', 'on' ),
				array( 'cc-hide-outer', '=', 'off' ),
			),
		),
		array(
			'id'       => 'cc-blend-mode',
			'type'     => 'select',
			'title'    => esc_html__( 'Custom Cursor Blend Mode', 'archub' ),
			'subtitle'   => esc_html__( 'Try \'Difference\' and white background for inner circle and active color 😉', 'archub' ),
			'options'  => array(
				'normal' => esc_html__( 'Normal', 'archub' ),
				'multiply' => esc_html__( 'Multiply', 'archub' ),
				'screen' => esc_html__( 'Screen', 'archub' ),
				'overlay' => esc_html__( 'Overlay', 'archub' ),
				'darken' => esc_html__( 'Darken', 'archub' ),
				'lighten' => esc_html__( 'Lighten', 'archub' ),
				'color-dodge' => esc_html__( 'Color Dodge', 'archub' ),
				'color-burn' => esc_html__( 'Color Burn', 'archub' ),
				'hard-light' => esc_html__( 'Hard Light', 'archub' ),
				'soft-light' => esc_html__( 'Soft Light', 'archub' ),
				'difference' => esc_html__( 'Difference', 'archub' ),
				'exclusion' => esc_html__( 'Exclusion', 'archub' ),
				'hue' => esc_html__( 'Hue', 'archub' ),
				'saturation' => esc_html__( 'Saturation', 'archub' ),
				'color' => esc_html__( 'Color', 'archub' ),
				'luminosity' => esc_html__( 'Luminosity', 'archub' ),
			),
			'default' => 'normal',
			'required' => array(
				'enable-custom-cursor',
				'=',
				'on'
			),
		),
		array(
			'id'         => 'cc-inner-circle-bg',
			'type'       => 'liquid_colorpicker',
			'only_solid' => true,
			'title'      => esc_html__( 'Inner Circle Color', 'archub' ),
			'subtitle'   => esc_html__( 'Choose a color for inner circle of the custom cursor', 'archub' ),
			'required' => array(
				'enable-custom-cursor',
				'=',
				'on'
			),
		),
		array(
			'id'         => 'cc-outer-circle-bg',
			'type'       => 'liquid_colorpicker',
			'only_solid' => true,
			'title'      => esc_html__( 'Outer Circle Color', 'archub' ),
			'subtitle'   => esc_html__( 'Choose a color for outer circle of the custom cursor', 'archub' ),
			'required' => array(
				array( 'enable-custom-cursor', '=', 'on' ),
				array( 'cc-hide-outer', '=', 'off' ),
			),
		),
		array(
			'id'         => 'cc-active-circle-color-bg',
			'type'       => 'liquid_colorpicker',
			'only_solid' => true,
			'title'      => esc_html__( 'Active Color', 'archub' ),
			'subtitle'   => esc_html__( 'Choose a color for active of the custom cursor', 'archub' ),
			'required' => array(
				'enable-custom-cursor',
				'=',
				'on'
			),
		),
		array(
			'id'         => 'cc-active-circle-solid-color-txt',
			'type'       => 'liquid_colorpicker',
			'only_solid' => true,
			'title'      => esc_html__( 'Active Circle Text Color', 'archub' ),
			'subtitle'   => esc_html__( 'Choose a color for the active circle of the custom cursor. The big circle when hovering over elements like carousel or portfolio.', 'archub' ),
			'required' => array(
				'enable-custom-cursor',
				'=',
				'on'
			),
		),
		array(
			'id'         => 'cc-active-circle-solid-color-bg',
			'type'       => 'liquid_colorpicker',
			'only_solid' => true,
			'title'      => esc_html__( 'Active Circle Background Color', 'archub' ),
			'subtitle'   => esc_html__( 'Choose a background for the active circle of the custom cursor. The big circle when hovering over elements like carousel or portfolio.', 'archub' ),
			'required' => array(
				'enable-custom-cursor',
				'=',
				'on'
			),
		),
		array(
			'id'         => 'cc-active-arrow-color',
			'type'       => 'liquid_colorpicker',
			'only_solid' => true,
			'title'      => esc_html__( 'Active Arrow Color', 'archub' ),
			'subtitle'   => esc_html__( 'Choose a color for the active arrow of the custom cursor.', 'archub' ),
			'required' => array(
				'enable-custom-cursor',
				'=',
				'on'
			),
		),
	)
);

// Preloader Fields
$this->sections[] = array(
	'title'  => esc_html__( 'Preloader', 'archub' ),
	'subsection' => true,
	'fields' => array(
		array(
			'id'       => 'enable-preloader',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Preloader', 'archub' ),
			'subtitle' => esc_html__( 'Switch on to enable preloader', 'archub' ),
			'options' => array(
				'on'  => esc_html__( 'On', 'archub' ),
				'off' => esc_html__( 'Off', 'archub' )
			),
			'default' => 'off'
		),
		array(
			'id'       => 'preloader-style',
			'type'     => 'select',
			'title'    => esc_html__( 'Preloader Style', 'archub' ),
			'subtitle' => esc_html__( 'Select preloder style', 'archub' ),
			'options'  => array(
				'curtain' => esc_html__( 'Curtain', 'archub' ),
				'fade'    => esc_html__( 'Fade', 'archub' ),
				'sliding' => esc_html__( 'Sliding', 'archub' ),
				'spinner' => esc_html__( 'Spinner', 'archub' ),
				'spinner-classical' => esc_html__( 'Spinner Classic', 'archub' ),
				'dissolve' => esc_html__( 'Dissolve', 'archub' ),
				'logo' => esc_html__( 'Logo', 'archub' ),
			),
			'required' => array(
				'enable-preloader',
				'=',
				'on'
			),
		),
		array(
			'id'       => 'preloader-logo-image',
			'type'     => 'background',
			'title'    => esc_html__( 'Logo image', 'archub' ),
			'background-color'      => false,
			'background-repeat'     => false,
			'background-attachment' => false,
			'background-position'   => false,
			'background-image'      => true,
			'background-gradient'   => false,
			'background-clip'       => false,
			'background-origin'     => false,
			'background-size'       => false,
			'preview_media'         => false,
			'preview'               => false,
			'transparent'           => false,
			'required' => array(
				'preloader-style',
				'=',
				'logo'
			),
		),
		array(
			'type'     => 'slider',
			'id'       => 'preloader-logo-spinner-width',
			'title'    => esc_html__( 'Loading bar width', 'archub' ),
			'default'  => 66,
			'max'      => 500,
			'min'      => 0,
			'required' => array(
				'preloader-style',
				'=',
				'logo'
			),
		),
		array(
			'id'         => 'preloader-color',
			'type'       => 'liquid_colorpicker',
			'title'      => esc_html__( 'Preloader Background Color', 'archub' ),
			'subtitle'   => esc_html__( 'Choose a background color for preloader', 'archub' ),
			'required' => array(
				'enable-preloader',
				'=',
				'on'
			),
		),
		array(
			'id'         => 'preloader-color-2',
			'type'       => 'liquid_colorpicker',
			'title'      => esc_html__( 'Preloader Background Color 2', 'archub' ),
			'subtitle'   => esc_html__( 'Choose a 2 background color for preloader', 'archub' ),
			'required' => array(
				'preloader-style',
				'=',
				'curtain'
			),
		),
		array(
			'id'         => 'preloader-elements-color',
			'type'       => 'liquid_colorpicker',
			'title'      => esc_html__( 'Preloader Elements Color', 'archub' ),
			'subtitle'   => esc_html__( 'Choose a color for preloader elements', 'archub' ),
			'required' => array(
				'preloader-style',
				'=',
				array( 'dots', 'signal', 'logo' )
			),
		),
		array(
			'id'         => 'preloader-elements-color-2',
			'type'       => 'liquid_colorpicker',
			'only_solid' => true,
			'title'      => esc_html__( 'Preloader Elements Color 2', 'archub' ),
			'subtitle'   => esc_html__( 'Choose a color for preloader elements', 'archub' ),
			'required' => array(
				'preloader-style',
				'=',
				array( 'spinner', 'logo' )
			),
		),
	)
);

// Text Selection Fields
$this->sections[] = array(
	'title'  => esc_html__( 'Text Selection', 'archub' ),
	'subsection' => true,
	'fields' => array(
		array(
			'id'         => 'text-selection-bg',
			'type'       => 'liquid_colorpicker',
			'only_solid' => true,
			'title'      => esc_html__( 'Text Selection Background', 'archub' ),
			'subtitle'   => esc_html__( 'Choose a color for the background when text selected or highlighted.', 'archub' ),
		),
		array(
			'id'         => 'text-selection-color',
			'type'       => 'liquid_colorpicker',
			'only_solid' => true,
			'title'      => esc_html__( 'Text Selection Color', 'archub' ),
			'subtitle'   => esc_html__( 'Choose a color for the text color when text selected or highlighted.', 'archub' ),
		),
	)
);

// Local Scroll Fields
$this->sections[] = array(
	'title'  => esc_html__( 'Local Scroll', 'archub' ),
	'subsection' => true,
	'fields' => array(
		array(
			'type'     => 'text',
			'id'       => 'pagescroll-speed',
			'title'    => esc_html__( 'Local scroll speed', 'archub' ),
			'subtitle'     => esc_html__( 'Please add scroll speed in milliseconds, works for one page websites', 'archub' ),
		),
		array(
			'type'     => 'slider',
			'id'       => 'pagescroll-offset',
			'title'    => esc_html__( 'Local scroll offset', 'archub' ),
			'subtitle'     => esc_html__( 'Set the offset for localscroll. Value is in px.', 'archub' ),
			'default'  => 0,
			'max'      => 500,
			'min'      => -500,
		),
	)
);

// Top Scroll Indicator Bar Fields
$this->sections[] = array(
	'title'  => esc_html__( 'Top Scroll Indicator Bar', 'archub' ),
	'subsection' => true,
	'fields' => array(
		array(
			'id'       => 'top-scroll-indicator',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Top Scroll Indicator Bar', 'archub' ),
			'subtitle' => esc_html__( 'Display a scroll indicator bar at top.', 'archub' ),
			'options' => array(
				'on'  => esc_html__( 'On', 'archub' ),
				'off' => esc_html__( 'Off', 'archub' )
			),
			'default' => 'off'
		),
		array(
			'type'     => 'slider',
			'id'       => 'top-scroll-indicator-height',
			'title'    => esc_html__( 'Top Scroll Indicator Bar Height', 'archub' ),
			'default'  => 5,
			'max'      => 100,
			'min'      => 2,
			'required' => array(
				'top-scroll-indicator',
				'=',
				'on'
			),
		),
		array(
			'id'         => 'top-scroll-indicator-bg',
			'type'       => 'liquid_colorpicker',
			'title'      => esc_html__( 'Top Scroll Indicator Background', 'archub' ),
			'required' => array(
				'top-scroll-indicator',
				'=',
				'on'
			),
		),
		array(
			'id'         => 'top-scroll-indicator-bar-bg',
			'type'       => 'liquid_colorpicker',
			'title'      => esc_html__( 'Top Scroll Indicator Bar Background', 'archub' ),
			'default'    => '#000',
			'required' => array(
				'top-scroll-indicator',
				'=',
				'on'
			),
		),
	)
);

// Back to Top Fields
$this->sections[] = array(
	'title'  => esc_html__( 'Back to Top', 'archub' ),
	'subsection' => true,
	'fields' => array(
		array(
			'id'       => 'footer-back-to-top',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Back To Top', 'archub' ),
			'subtitle' => esc_html__( 'Switch on to display the back to top link', 'archub' ),
			'options' => array(
				'on'  => esc_html__( 'On', 'archub' ),
				'off' => esc_html__( 'Off', 'archub' )
			),
			'default' => 'off'
		),
		array(
			'id'       => 'footer-back-to-top-scrl-ind',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Back To Top Scroll Indicator', 'archub' ),
			'subtitle' => esc_html__( 'Add a scroll indicator inside the back to top button.', 'archub' ),
			'options' => array(
				'on'  => esc_html__( 'On', 'archub' ),
				'off' => esc_html__( 'Off', 'archub' )
			),
			'default' => 'off',
			'required' => array(
				'footer-back-to-top',
				'=',
				'on'
			),
		),
	)
);

if ( !class_exists( 'Liquid_Elementor_Addons' ) ){
	// Theme Features
	$this->sections[] = array(
		'title'      => esc_html__( 'Custom Icons', 'archub' ),
		'subsection' => true,
		'fields'     => array(

			array(
				'id'    => 'sh_theme_features',
				'type'  => 'raw',
				'class' => 'redux-sub-heading',
				'desc'  => '<h2>' . esc_html__( 'Manage Icons', 'archub' ) . '</h2>'
			),
			array(
				'id'       => 'font-icons',
				'type'     => 'select',
				'multi'    => true,
				'title'    => esc_html__( 'Custom Icon Fonts', 'archub' ),
				'subtitle' => esc_html__( 'Choose the icon Fonts', 'archub' ),
				'options'  => array(
					'liquid-icons' => esc_html__( 'Liquid Icons', 'archub' )
				),
				'default' => array( 'liquid-icons' ),
			),
			array(
				'id' => 'custom-icons-fonts',
				'type' => 'repeater',
				'title'    => esc_html__( 'Add Custom Icons', 'archub' ),
				'desc' => esc_html__( 'NOTE: All icons files should be uploaded via FTP on your server', 'archub' ),
				'sortable' => false,
				'group_values' => false,
							'fields' => array(
					
					array(
						'id' => 'custom_icon_font_title',
						'type' => 'text',
						'title'    => esc_html__( 'Title', 'archub' ),
						'placeholder' => esc_html__( 'Awesome Font', 'archub' ),
					),
					array(
						'id'    => 'custom_icon_font_css',
						'type'  => 'text',	
						'title' => esc_html__( 'Icon Css file', 'archub' ),
					),
					array(
						'id'    => 'custom_icons_classnames',
						'type'  => 'textarea',	
						'title' => esc_html__( 'Icons classnames', 'archub' ),
						'desc'  => esc_html__( 'Icon classnames should be separated by comma,for ex: icon-classname, icon-2-classname', 'archub' ),
					),
					array(
						'id'          => 'custom_icon_prefix',
						'type'        => 'text',
						'title'       => esc_html__( 'Prefix', 'archub' ),
						'placeholder' => esc_html__( 'fa', 'archub' ),
						'subtitle'    => esc_html__( 'Add a prefix for the icon, will add as classname for all icons.', 'archub' ),
					),
				)
			),		

		)
	);
}
include_once( get_template_directory() . '/theme/theme-options/liquid-page-404.php' );

