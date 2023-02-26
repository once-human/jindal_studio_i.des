<?php
$sections[] = array(
	'post_types' => array( 'product' ),
	'title'  => esc_html__( 'General', 'archub' ),
	'icon'       => 'el-icon-cog',
	'fields' => array(

		array(
			'id'       => 'product-page-style',
			'type'     => 'select',
			'title'    => esc_html( 'Style', 'archub' ),
			'subtitle' => esc_html__( 'Select a style for the single product page', 'archub' ),
			'options'  => array(
				'0'    => esc_html__( 'Default', 'archub' ),
				'1'    => esc_html__( 'Style 1', 'archub' ),
				'2'    => esc_html__( 'Style 2', 'archub' ),
				'3'    => esc_html__( 'Style 3', 'archub' ),
			)
		),
		array(
			'id'       => 'product-item-width',
			'type'     => 'select',
			'title'    => esc_html( 'Width', 'archub' ),
			'subtitle' => esc_html__( 'Defines the width of the product image on the product list', 'archub' ),
			'options'  => array(
				''     => esc_html__( 'Default', 'archub' ),
				'2'    => esc_html__( '2 columns - 1/6', 'archub' ),
				'3'    => esc_html__( '3 columns - 1/4', 'archub' ),
				'4'    => esc_html__( '4 columns - 1/3', 'archub' ),
				'5'    => esc_html__( '5 columns - 5/12', 'archub' ),
				'6'    => esc_html__( '6 columns - 1/2', 'archub' ),
				'7'    => esc_html__( '7 columns - 7/12', 'archub' ),
				'8'    => esc_html__( '8 columns - 2/3', 'archub' ),
				'9'    => esc_html__( '9 columns - 3/4', 'archub' ),
				'10'   => esc_html__( '10 columns - 5/6', 'archub' ),
				'11'   => esc_html__( '11 columns - 11/12', 'archub' ),
				'12'   => esc_html__( '12 columns - 12/12', 'archub' ),
			)
		),
		array(
			'id'       => 'wc-custom-layout-enable',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Woo Single Product Layout', 'archub' ),
			'subtitle' => esc_html__( 'Turn on to enable custom layouts', 'archub' ),
			'options'  => array(
				'on'   => esc_html__( 'On', 'archub' ),
				'0'    => esc_html__( 'Default', 'archub' ),
				'off'  => esc_html__( 'Off', 'archub' )
			),
			'default'  => '0'
		),
		array(
			'id'       =>'wc-custom-layout',
			'type'     => 'select',
			'title'    => esc_html__( 'Product Layout', 'archub' ),
			'subtitle' => esc_html__( 'Select a layout for the product single page', 'archub' ),
			'data'     => 'post',
			'args' => array( 
				'post_type' => 'ld-product-layout', 
				'posts_per_page' => -1 
			),
			'required' => array(
				'wc-custom-layout-enable',
				'equals',
				'on'
			),
		),

	) 
);