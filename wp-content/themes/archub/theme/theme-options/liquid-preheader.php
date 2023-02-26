<?php
/*
 * Preheader Section
*/

$this->sections[] = array(
	'title' => esc_html__('Preheader', 'archub'),
	'desc' => esc_html__('Change the preheader section configuration.', 'archub'),
	'icon' => 'el-icon-cog',
	'fields' => array(

		array(
			'id' => 'preheader-enable-switch',
			'type' => 'switch', 
			'title' => esc_html__('Enable preheader', 'archub'),
			'subtitle' => esc_html__('If on, this layout part will be displayed.', 'archub'),
			'default' => 1,
		),
		
	), // #fields
);
