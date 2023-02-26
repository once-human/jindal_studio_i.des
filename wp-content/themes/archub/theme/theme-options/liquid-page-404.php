<?php
/*
 * Page 404
*/

$this->sections[] = array (
	'title'  => esc_html__( '404 Page', 'archub' ),
	'subsection' => true,
	'fields' => array(
		array(
			'id'       => 'error-404-title',
			'type'     => 'text',
			'title'    => esc_html__( 'Title', 'archub' ),
			'subtitle' => '',
			'default' => '404'
		),
		array(
			'id'       => 'error-404-subtitle',
			'type'     => 'text',
			'title'    => esc_html__( 'Heading', 'archub' ),
			'subtitle' => '',
			'default' => 'Looks like you are lost.'
		),
		array(
			'id'       => 'error-404-content',
			'type'     => 'editor',
			'title'    => esc_html__( 'Content', 'archub' ),
			'subtitle' => '',
			'default' => '<p>We can’t seem to find the page you’re looking for.</p>'
		),
		array(
			'id' => 'error-404-enable-btn',
			'type'	 => 'button_set',
			'title' => esc_html__('Button', 'archub'),
			'subtitle' => esc_html__('Switch on to display the "back to home" button.', 'archub'),
			'options' => array(
				'on'  => esc_html__( 'On', 'archub' ),
				'off' => esc_html__( 'Off', 'archub' )
			),
			'default' => 'on'
		),

		array(
			'id'       => 'error-404-btn-title',
			'type'     => 'text',
			'title'    => esc_html__( 'Button Title', 'archub' ),
			'subtitle' => '',
			'default' => 'Back to home',
			'required' => array(
				'error-404-enable-btn',
				'equals',
				'on'
			)
		),
	)
);
