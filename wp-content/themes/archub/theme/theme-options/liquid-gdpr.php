<?php
/*
 * GDPR
*/

if ( !class_exists ( 'Liquid_Gdpr' ) ){
	$gdpr_desc = sprintf(
		wp_kses( '<div class="notice-red"> To use this feature, you need to install and activate the <strong>Liquid GDPR</strong> plugin. <a href="%1$s" target="_blank"> Install Plugin</a></div>', 'archub', 'lqd_post' ),
		admin_url( 'admin.php?page=liquid-setup&step=plugins' )
	);
	$gdpr_fields = array();

} else {
	$gdpr_desc = '';
	$gdpr_fields = array(
		array(
			'id' => 'enable-gdpr',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Enable GDPR', 'archub' ),
			'subtitle' => esc_html__( 'Switch off to disable the GDPR Box', 'archub' ),
			'options'  => array(
				'on'   => esc_html__( 'On', 'archub' ),
				'off'  => esc_html__( 'Off', 'archub' ),
			),
			'default' => 'on'
		),
		array(
			'id'       => 'gdpr-button',
			'type'     => 'text',
			'title'    => esc_html__( 'Accept Button Text', 'archub' ),
			'subtitle' => '',
			'default'  => esc_html__( 'Accept', 'archub' ),
			'placeholder' => esc_html__( 'Accept', 'archub' ),
			'required' => array(
				'enable-gdpr',
				'=',
				'on'
			),
		),
		array(
			'id'       => 'gdpr-content',
			'type'     => 'textarea',
			'title'    => esc_html__( 'Content', 'archub' ),
			'subtitle' => '',
			'default'  => esc_html__( 'This website uses cookies to improve your web experience.', 'archub' ),
			'placeholder' => esc_html__( 'This website uses cookies to improve your web experience.', 'archub' ),
			'required' => array(
				'enable-gdpr',
				'=',
				'on'
			),
		),
		array(
			'id'       => 'gdpr-typography-enable',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Custom Typography', 'archub' ),
			'options'  => array(
				'on'  => esc_html__( 'On', 'archub' ),
				'off' => esc_html__( 'Off', 'archub' )
			),
			'default'  => 'off',

		),
		'gdpr-typography' => array(
			'id'             => 'gdpr-typography',
			'title'          => esc_html__( 'Typography', 'archub' ),
			'subtitle'       => esc_html__( 'Manages the typography for the page title', 'archub' ),
			'type'           => 'typography',
			'text-transform' => true,
			'letter-spacing' => true,
			'text-align'     => false,
			'compiler'       => true,
			'color'          => false,
			'units'          => '%',
			'required' => array(
				'gdpr-typography-enable',
				'equals',
				'on'
			),
		),
		array(
			'id'            => 'gdpr-bg-color',
			'type'          => 'liquid_colorpicker',
			'title'    => esc_html__( 'Background', 'archub' ),
			'subtitle' => esc_html__( 'Set GDPR Box Background', 'archub' ),
			'required' => array(
				'enable-gdpr',
				'=',
				'on'
			),
		),
		array(
			'id'            => 'gdpr-color',
			'type'          => 'liquid_colorpicker',
			'only_solid'    => true,
			'title'    => esc_html__( 'Content Color', 'archub' ),
			'required' => array(
				'enable-gdpr',
				'=',
				'on'
			),
		),
		array(
			'id'            => 'gdpr-btn-color',
			'type'          => 'liquid_colorpicker',
			'only_solid'    => true,
			'title'    => esc_html__( 'Button Color', 'archub' ),
			'required' => array(
				'enable-gdpr',
				'=',
				'on'
			),
		),
		array(
			'id'            => 'gdpr-btn-color-hover',
			'type'          => 'liquid_colorpicker',
			'only_solid'    => true,
			'title'    => esc_html__( 'Button Hover Color', 'archub' ),
			'required' => array(
				'enable-gdpr',
				'=',
				'on'
			),
		),
		array(
			'id'            => 'gdpr-btn-bg-color',
			'type'          => 'liquid_colorpicker',
			'title'    => esc_html__( 'Button Background Color', 'archub' ),
			'required' => array(
				'enable-gdpr',
				'=',
				'on'
			),
		),
		array(
			'id'            => 'gdpr-btn-bg-color-hover',
			'type'          => 'liquid_colorpicker',
			'title'    => esc_html__( 'Button Background Hover Color', 'archub' ),
			'required' => array(
				'enable-gdpr',
				'=',
				'on'
			),
		),
		array(
			'id'             => 'gdpr-box-paddings',
			'type'           => 'spacing',
			'mode'           => 'padding',
			'units_extended' => true,
			'title'          => __('GDPR Box Padding', 'archub'),
			'subtitle'       => __('Set GDPR Box Padding. Add value with the unit type (px, em, etc.). Example: 1.5em', 'archub'),
			'required' => array(
				'enable-gdpr',
				'=',
				'on'
			),
		),
		array(
			'id'             => 'gdpr-box-radius',
			'type'           => 'spacing',
			'mode'           => 'padding',
			'units_extended' => true,
			'title'          => __('GDPR Box Border Radius', 'archub'),
			'subtitle'       => __('Set GDPR Box Border Radius. Add value with the unit type (px, em, etc.). Example: 1.5em', 'archub'),
			'required' => array(
				'enable-gdpr',
				'=',
				'on'
			),
		),
		array(
			'id'             => 'gdpr-btn-paddings',
			'type'           => 'spacing',
			'mode'           => 'padding',
			'units_extended' => true,
			'title'          => __('GDPR Button Padding', 'archub'),
			'subtitle'       => __('Set GDPR Button Padding. Add value with the unit type (px, em, etc.). Example: 1.5em', 'archub'),
			'required' => array(
				'enable-gdpr',
				'=',
				'on'
			),
		),
		array(
			'id'             => 'gdpr-btn-radius',
			'type'           => 'spacing',
			'mode'           => 'padding',
			'units_extended' => true,
			'title'          => __('Button Border Radius', 'archub'),
			'subtitle'       => __('Set Button Border Radius. Add value with the unit type (px, em, etc.). Example: 1.5em', 'archub'),
			'required' => array(
				'enable-gdpr',
				'=',
				'on'
			),
		),
	);
}

$this->sections[] = array(
	'title' => esc_html__( 'GDPR Alert', 'archub' ),
	'icon' => 'el-icon-lock',
	'desc' => $gdpr_desc,
	'fields' => $gdpr_fields
);
