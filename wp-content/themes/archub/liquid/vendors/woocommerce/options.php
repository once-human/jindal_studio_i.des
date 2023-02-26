<?php

add_action( 'liquid_option_sidebars', 'liquid_woocommerce_option_sidebars' );

function liquid_woocommerce_option_sidebars( $obj ) {

	// Product Sidebar
	$obj->sections[] = array(
		'title'  => esc_html__('Products', 'archub'),
		'subsection' => true,
		'fields' => array(

			array(
				'id'       => 'wc-enable-global',
				'type'	   => 'button_set',
				'title'    => esc_html__( 'Activate Global Sidebar For Products', 'archub' ),
				'subtitle' => esc_html__( 'Turn on if you want to use the same sidebars on all product posts. This option overrides the product options.', 'archub' ),
				'options'  => array(
					'on'   => esc_html__( 'On', 'archub' ),
					'off'  => esc_html__( 'Off', 'archub' ),
				),
				'default' => 'off'
			),
			array(
				'id'       => 'wc-sidebar',
				'type'     => 'select',
				'title'    => esc_html__( 'Global Products Sidebar', 'archub' ),
				'subtitle' => esc_html__( 'Select sidebar that will display on all product posts.', 'archub' ),
				'data'     => 'sidebars'
			),
			array(
				'id'       => 'wc-sidebar-position',
				'type'     => 'button_set',
				'title'    => esc_html__( 'Global Products Sidebar Position', 'archub' ),
				'subtitle' => esc_html__( 'Controls the position of the sidebar for all product posts.', 'archub' ),
				'options'  => array(
					'left'  => esc_html__( 'Left', 'archub' ),
					'right' => esc_html__( 'Right', 'archub' )
				),
				'default' => 'right'
			),
		)
	);

	// Product Archive Sidebar
	$obj->sections[] = array(
		'title'  => esc_html__( 'Product Archive', 'archub' ),
		'subsection' => true,
		'fields' => array(
			array(
				'id'       =>'wc-archive-sidebar-one',
				'type'     => 'select',
				'title'    => esc_html__( 'Product Archive Sidebar', 'archub' ),
				'subtitle' => esc_html__( 'Select sidebar 1 that will display on the product archive pages.', 'archub' ),
				'data'     => 'sidebars'
			),
			array(
				'id'       => 'wc-archive-sidebar-position',
				'type'     => 'button_set',
				'title'    => esc_html__( 'Global Products Archive Sidebar Position', 'archub' ),
				'subtitle' => esc_html__( 'Controls the position of the sidebar for all product archives.', 'archub' ),
				'options'  => array(
					'left'  => esc_html__( 'Left', 'archub' ),
					'right' => esc_html__( 'Right', 'archub' )
				),
				'default' => 'right'
			),
			array(
				'id'       => 'wc-archive-sidebar-hide-mobile',
				'type'	   => 'button_set',
				'title'    => esc_html__( 'Hide sidebar on mobile devices?', 'archub' ),
				'subtitle' => esc_html__( 'Turn on to hide the sidebar on mobile devices', 'archub' ),
				'options'  => array(
					'yes'   => esc_html__( 'Yes', 'archub' ),
					'no'  => esc_html__( 'No', 'archub' )
				),
				'default'  => 'no'
			),

		)
	);

}