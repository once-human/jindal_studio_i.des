<?php
/*
 * Slider Section
*/

$sections[] = array(
	'post_types' => array( 'post', 'page' ),
	'title' => esc_html__('Sliders', 'archub'),
	'icon' => 'el-icon-adjust-alt',
	'fields' => array(

		array(
 			'id'=>'slider-type',
 			'type' => 'select',
 			'title' => esc_html__('Slider Type', 'archub'),
 			'subtitle'=> esc_html__('Select the type of slider that displays.', 'archub'),
			'options' => array(
				'no' => esc_html__( 'No Slider', 'archub' ),
				'liquid' => esc_html__( 'liquid Slider', 'archub' ),
				'rev' => esc_html__( 'Revolution Slider', 'archub' )
			),
			'default' => 'no'
		),

		array(
 			'id'=>'slider-liquid',
 			'type' => 'select',
 			'title' => esc_html__('Select liquid Slider', 'archub'),
 			'subtitle'=> esc_html__('Select the unique name of the slider.', 'archub'),
			'options' => array(
				'no' => esc_html__( 'Select a slider', 'archub' )
			),
			'required' => array(
				'slider-type',
				'equals',
				'liquid'
			),
			'default' => 'no'
		),

		array(
 			'id'=>'slider-rev',
 			'type' => 'select',
 			'title' => esc_html__('Select Revolution Slider', 'archub'),
 			'subtitle'=> esc_html__('Select the unique name of the slider.', 'archub'),
			'options' => array(
				'no' => esc_html__( 'Select a slider', 'archub' )
			),
			'required' => array(
				'slider-type',
				'equals',
				'rev'
			),
			'default' => 'no'
		),

		array(
 			'id'=>'slider-position',
 			'type' => 'button_set',
 			'title' => esc_html__('Slider Position', 'archub'),
 			'subtitle'=> esc_html__('Select if the slider shows below or above the header.', 'archub'),
			'options' => array(
				'default' => esc_html__( 'Default', 'archub' ),
				'below' => esc_html__( 'Below', 'archub' ),
				'above' => esc_html__( 'Above', 'archub' )
			),
			'required' => array(
				'slider-type',
				'not',
				'no'
			),
			'default' => 'default'
		)
	)
);
