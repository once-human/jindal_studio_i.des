<?php
/*
 * Advanced theme options like social sites API Keys etc.
*/

$this->sections[] = array(
	'title' => esc_html__( 'Advanced', 'archub' ),
	'icon'   => 'el el-wrench'
);

// Code Fields
$this->sections[] = array(
	'title'  => esc_html__( 'Code Fields', 'archub' ),
	'subsection' => true,
	'fields' => array(
		array(
			'id'          => 'google_analytics',
			'type'        => 'ace_editor',
			'title'       => esc_html__( 'Tracking Code', 'archub' ),
			'subtitle' => esc_html__( 'Paste your tracking code here. This will be added into the header template of your theme. Place code inside &lt;script&gt; tags.', 'archub' ),
			'mode' => 'html',
			'theme' => 'chrome',
			'options' => array( 'minLines' => 20, 'maxLines' => 60 )
		),

		array(
			'id'          => 'space_head',
			'type'        => 'ace_editor',
			'title'       => esc_html__( 'Space before &lt;/head&gt;', 'archub' ),
			'subtitle' => esc_html__( 'Only accepts javascript code wrapped with &lt;script&gt; tags and HTML markup that is valid inside the &lt;/head&gt; tag.', 'archub' ),
			'mode' => 'html',
			'theme' => 'chrome',
			'options' => array( 'minLines' => 20, 'maxLines' => 60 )
		),

		array(
			'id'          => 'space_body',
			'type'        => 'ace_editor',
			'title'       => esc_html__( 'Space before &lt;/body&gt;', 'archub' ),
			'subtitle' => esc_html__( 'Only accepts javascript code, wrapped with &lt;script&gt; tags and valid HTML markup inside the &lt;/body&gt; tag.', 'archub' ),
			'mode' => 'html',
			'theme' => 'chrome',
			'options' => array( 'minLines' => 20, 'maxLines' => 60 )
		)
	)
);

if ( !class_exists( 'Liquid_Elementor_Addons' ) && !defined( 'ELEMENTOR_VERSION' )){
	// Dynamic CSS
	$this->sections[] = array(
		'title'  => esc_html__( 'Dynamic CSS', 'archub' ),
		'subsection' => true,
		'fields' => array(

			array(
				'id'          => 'dynamic_css_compiler',
				'type'        => 'switch',
				'title'       => esc_html__( 'CSS Compiler', 'archub' ),
				'subtitle' => esc_html__( 'By default all the CSS files are combined. Disabling the CSS compiler will load non-combined CSS files. This will have an impact on the performance of your site.', 'archub' ),
				'default'     => '0',
			),

			array(
				'id'          => 'dynamic_css_db_caching',
				'type'        => 'switch',
				'title'       => esc_html__( 'Database Cache for Dynamic CSS', 'archub' ),
				'subtitle' => esc_html__( 'Turn on to enable caching the dynamic CSS in your database.', 'archub' ),
				'default'     => '0',
			),

			array(
				'id'          => 'cache_server_ip',
				'type'        => 'text',
				'title'       => esc_html__( 'Cache Server IP', 'archub' ),
				'subtitle' => esc_html__( 'For unique cases where you are using cloud flare and a cache server, ex: varnish cache. Enter your cache server IP to clear the theme options dynamic CSS cache. Consult with your server admin for help.', 'archub' ),
			),
		)
	);
}