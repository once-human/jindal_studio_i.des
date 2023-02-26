<?php
/*
 * Export options
*/

$this->sections[] = array(
	'title' => esc_html__( 'Import/Export', 'archub' ),
	'desc' => esc_html__( 'Import/Export options', 'archub' ),
	'icon' => 'el-icon-arrow-down',
	'fields' => array(		

		array(
			'id'            => 'opt-import-export',
			'type'          => 'import_export',
			'title'         => esc_html__( 'Import / Export', 'archub' ),
			'full_width'    => false,
		),
	),
);
