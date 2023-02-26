<?php

/*
 * Header Layout Section
*/
$this->sections[] = array(
	'title'      => esc_html__( 'Select the header', 'archub' ),
	'subsection' => true,
	'fields'     => array(
		array(
			'id'       => 'header-enable-switch',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Header', 'archub' ),
			'subtitle' => esc_html__( 'Switch off to hide the header on your website.', 'archub' ),
			'options'  => array(
				'on'  => esc_html__( 'On', 'archub' ),
				'off' => esc_html__( 'Off', 'archub' ),
			),
			'default' => 'on'
		),		
		array(
			'id'=>'header-template',
			'type' => 'select',
			'title' => esc_html__('Header', 'archub'),
			'subtitle'=> esc_html__('Select a header template for your website', 'archub'),
			'data' => 'post',
			'args' => array( 'post_type' => 'liquid-header', 'posts_per_page' => -1 )
		),
		array(
			'id'      => 'header-overlay',
			'type'	  => 'button_set',
			'title'   => esc_html__( 'Overlay?', 'archub' ),
			'options' => array(
				''    => esc_html__( 'No', 'archub' ),
				'main-header-overlay' => esc_html__( 'Yes', 'archub' ),
			),
			'default' => ''
		),
		array(
			'id'      => 'header-force',
			'type'	  => 'button_set',
			'title'   => esc_html__( 'Force header template site-wide?', 'archub' ),
			'subtitle'   => esc_html__( 'Override single post/page header settings to show the same header template site-wide', 'archub' ),
			'options' => array(
				'off'    => esc_html__( 'No', 'archub' ),
				'on' => esc_html__( 'Yes', 'archub' ),
			),
			'default' => 'off',
			'required' => array(
                'header-template',
                '!=',
                ''
            ),
		),
	)
);
