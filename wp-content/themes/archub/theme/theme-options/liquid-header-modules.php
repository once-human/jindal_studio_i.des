<?php
/*
 * Header Modules Section
*/

$this->sections[] = array(
	'title'      => esc_html__( 'Modules', 'archub' ),
	'subsection' => true,
	'fields'     => array(
		
		array(
			'id'       => 'header-enable-social',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Enable Header Social', 'archub' ),
			'subtitle' => esc_html__( 'If on, will display social links in header.', 'archub' ),
			'options'  => array(
				'on'  => esc_html__( 'On', 'archub' ),
				'off' => esc_html__( 'Off', 'archub' ),
			),
		),
		
		array(
			'id' => 'header-social-links',
			'type' => 'repeater',
			'title'    => esc_html__( 'Social Links', 'archub' ),
			'subtitle' => esc_html__( 'Add social links to display in header', 'archub' ),
			'sortable' => true,
			'group_values' => false,
			'required'  => array(
				'header-enable-social', 
				'equals', 
				'on'
			),
			'fields' => array(

				array(
					'id'    => 'social_label',
					'type'  => 'text',	
					'title' => esc_html__( 'Label', 'archub' ),
					'placeholder' => esc_html__( 'Link text', 'archub' ),
				),
				
				array(
					'id' => 'social_icon',
					'type' => 'iconpicker',
					'title'    => esc_html__( 'Icon', 'archub' ),
					'placeholder' => esc_html__( 'Select an icon', 'archub' ),
					'data'  => 'social-icons',
				),
				
				array(
					'id'    => 'social_url',
					'type'  => 'text',	
					'title' => esc_html__( 'URL', 'archub' ),
				),
				
			)
		),		
		
		array(
			'id'       => 'header-enable-button',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Enable Header Button', 'archub' ),
			'subtitle' => esc_html__( 'If on, will display buttons in header.', 'archub' ),
			'options'  => array(
				'on'  => esc_html__( 'On', 'archub' ),
				'off' => esc_html__( 'Off', 'archub' ),
			),
		),
		
		array(
			'id' => 'header-button',
			'type' => 'repeater',
			'title'    => esc_html__( 'Buttons', 'archub' ),
			'subtitle' => esc_html__( 'Add buttons to display in header', 'archub' ),
			'sortable' => true,
			'group_values' => false,
			'required'  => array(
				'header-enable-button', 
				'equals', 
				'on'
			),
			'fields' => array(

				array(
					'id'    => 'button_label',
					'type'  => 'text',	
					'title' => esc_html__( 'Label', 'archub' ),
					'placeholder' => esc_html__( 'Button text', 'archub' ),
				),
				
				array(
					'id' => 'button_icon',
					'type' => 'iconpicker',
					'title'    => esc_html__( 'Icon', 'archub' ),
					'placeholder' => esc_html__( 'Select an icon', 'archub' ),
				),
				
				array(
					'id'    => 'button_url',
					'type'  => 'text',	
					'title' => esc_html__( 'URL', 'archub' ),
				),
				
			)
		),
		
		array(
			'id'       => 'header-enable-text',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Enable Header Text', 'archub' ),
			'subtitle' => esc_html__( 'If on, will display text in header.', 'archub' ),
			'options'  => array(
				'on'  => esc_html__( 'On', 'archub' ),
				'off' => esc_html__( 'Off', 'archub' ),
			),
		),
		
		array(
			'id'       => 'header-text',
			'type'	   => 'textarea',
			'title'    => esc_html__( 'Header Text', 'archub' ),
			'required'  => array(
				'header-enable-text', 
				'equals', 
				'on'
			),
		),
		
	)
);	
