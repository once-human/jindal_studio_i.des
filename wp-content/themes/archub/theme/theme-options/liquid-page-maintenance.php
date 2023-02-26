<?php
/*
 * Page Maintenance
*/

// Hours
$hours = array();
for ($i = 0; $i <= 24; $i++){

	$hour = $i;
	if ($i < 10) {
		$hour = '0'.$i;
	}
	$hours[(string)$hour] = (string)$hour;
}

// Minutes
$minutes = array();
for ($i = 0; $i < 60; $i++){

	$min = $i;
	if ($i < 10) {
		$min = '0'.$i;
	}
	$minutes[(string)$min] = (string)$min;
}

$this->sections[] = array (
	'title'  => esc_html__( 'Maintenance Page', 'archub' ),
	'subsection' => true,
	'fields' => array(

		array(
			'id' => 'page-maintenance-enable',
			'type'	 => 'button_set',
			'title' => esc_html__('Enable Maintenance Mode', 'archub'),
			'subtitle' => esc_html__('If on, the frontend shows maintenance mode page only.', 'archub'),
			'desc' => esc_html__('Only administrator will be able to visit site. If you want to check if maintenance mode is enabled you have to logout.', 'archub'),
			'options' => array(
				'on'  => esc_html__( 'On', 'archub' ),
				'off' => esc_html__( 'Off', 'archub' )
			),
			'default' => 'on'
		),

		array(
			'id' => 'page-maintenance-mode-till',
			'type'	 => 'button_set',
			'title' => esc_html__('Enable Till', 'archub'),
			'subtitle' => esc_html__('If on, the frontend shows maintenance mode page only.', 'archub'),
			'desc' => esc_html__('Only administrator will be able to visit site. If you want to check if maintenance mode is enabled you have to logout.', 'archub'),
			'options' => array(
				'on'  => esc_html__( 'On', 'archub' ),
				'off' => esc_html__( 'Off', 'archub' )
			),
			'default' => 'on'
		),

		array(
			'id'        => 'page-maintenance-mode-till-date',
			'type'      => 'date',
			'title'     => esc_html__('Date (mm/dd/yyyy)', 'archub'),
			'default'   => date('m/d/Y'),
			'required' => array(
				'page-maintenance-mode-till',
				'equals',
				'on'
			)
		),

		array(
			'id'        => 'page-maintenance-mode-till-hour',
			'type'      => 'select',
			'title'     => esc_html__('Hour', 'archub'),
			'options' => $hours,
			'default'   => '00',
			'required' => array(
				'page-maintenance-mode-till',
				'equals',
				'on'
			)
		),

		array(
			'id'        => 'page-maintenance-mode-till-minutes',
			'type'      => 'select',
			'title'     => esc_html__('Minutes', 'archub'),
			'options' => $minutes,
			'default'   => '00',
			'required' => array(
				'page-maintenance-mode-till',
				'equals',
				'on'
			)
		),

		array(
			'id'       => 'page-maintenance-title',
			'type'     => 'text',
			'title'    => esc_html__( 'Page Title', 'archub' ),
			'subtitle' => '',
			'default'  => esc_html__( 'We will Be Right Back.', 'archub' ),
		),

		array(
			'id'       => 'page-maintenance-content',
			'type'     => 'editor',
			'title'    => esc_html__( 'Page Content', 'archub' ),
			'subtitle' => '',
			'default' => esc_html__( 'Our team is working hard to be able to back in a couple hours.', 'archub' ),
		),

		array(
			'id'       => 'page-maintenance-background-type',
			'type'     => 'select',
			'title'    => esc_html__( 'Background Type', 'archub' ),
			'options' => array(
				'solid'    => esc_html__( 'Solid', 'archub' ),
				'gradient' => esc_html__( 'Gradient', 'archub' ),
				'image'    => esc_html__( 'Image', 'archub' ),
			),
			'default' => 'image'
		),

		array(
			'id'=>'page-maintenance-bar-bg',
			'type' => 'media',
			'url' => true,
			'title' => esc_html__('Background', 'archub'),
			'required' => array(
				'page-maintenance-background-type',
				'equals',
				'image'
			),
		),

		array(
			'id'=>'page-maintenance-bar-solid',
			'type' => 'color',
			'url' => true,
			'title' => esc_html__('Background', 'archub'),
			'required' => array(
				'page-maintenance-background-type',
				'equals',
				'solid'
			),
		),

		array(
			'id'=>'page-maintenance-bar-gradient',
			'type' => 'gradient',
			'url' => true,
			'title' => esc_html__('Background', 'archub'),
			'required' => array(
				'page-maintenance-background-type',
				'equals',
				'gradient'
			),
		),

		array(
			'id' => 'page-maintenance-identities',
			'type' => 'repeater',
			'group_values' => true,
			'title' => esc_html__('Social identities', 'archub'),
			'fields' => array(

				array(
					'id'       => 'title',
					'type'     => 'text',
					'title'    => esc_html__( 'Title', 'archub' )
				),

				array(
					'id'       => 'url',
					'type'     => 'text',
					'title'    => esc_html__( 'Url', 'archub' )
				),
			)
		)
	)
);
