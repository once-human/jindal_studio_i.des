<?php

/*
 * Sidebars Section
*/

$this->sections[] = array(
	'title'  => esc_html__( 'Sidebars', 'archub' ),
	'icon'   => 'el el-braille'
);


$this->sections[] = array(
	'title'      => esc_html__( 'Add sidebars', 'archub' ),
	'subsection' => true,
	'fields' => array(
		array(
			'id'       => 'custom-sidebars',
			'type'     => 'multi_text',
			'title'    => esc_html__( 'Add a Sidebar', 'archub' ),
			'desc'     => esc_html__( 'You can add as many custom sidebars as you need.', 'archub' )
		),
		array(
			'id'       => 'sidebar-widgets-style',
			'type'     => 'select',
			'title'    => esc_html__( 'Sidebar Style', 'archub' ),
			'options'  => array(
				'sidebar-widgets-default' => esc_html__( 'Default', 'archub' ),
				'sidebar-widgets-outline' => esc_html__( 'Outline', 'archub' ),
			),
			'default' => 'sidebar-widgets-outline'
		),
	)	
);

// Page Sidebar
$this->sections[] = array(
	'title'  => esc_html__( 'Page', 'archub' ),
	'subsection' => true,
	'fields' => array(

		array(
			'id'       => 'page-enable-global',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Default Sidebar of Pages', 'archub' ),
			'subtitle' => esc_html__( 'Switch on to use the same sidebars across all pages by overwriting the page options.', 'archub' ),
			'options'  => array(
				'on'   => esc_html__( 'On', 'archub' ),
				'off'  => esc_html__( 'Off', 'archub' ),
			),
			'default' => 'off'
		),
		array(
			'id'       => 'page-sidebar-one',
			'type'     => 'select',
			'title'    => esc_html__( 'Default Sidebar of Pages', 'archub' ),
			'subtitle' => esc_html__( 'Choose the sidebar that will display across all pages.', 'archub' ),
			'data'     => 'sidebars'
		),
		array(
			'id'       => 'page-sidebar-position',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Default Sidebar Position of Pages', 'archub' ),
			'subtitle' => esc_html__( 'Manages the position of the sidebar across all pages.', 'archub' ),
			'options'  => array(
				'left'  => esc_html__( 'Left', 'archub' ),
				'right' => esc_html__( 'Right', 'archub' )
			),
			'default'   => 'right'
		)
	)
);

// Portfolio Sidebar
$this->sections[] = array(
	'title'      => esc_html__( 'Portfolio Posts', 'archub' ),
	'subsection' => true,
	'fields'     => array(

		array(
			'id'       => 'portfolio-enable-global',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Default Sidebar of Portfolio Posts', 'archub' ),
			'subtitle' => esc_html__( 'Switch on to use the same sidebars across all portfolio posts by overwriting the page options.', 'archub' ),
			'options'  => array(
				'on'   => esc_html__( 'On', 'archub' ),
				'off'  => esc_html__( 'Off', 'archub' ),
			),
			'default' => 'off'
		),
		array(
			'id'       => 'portfolio-sidebar-one',
			'type'     => 'select',
			'title'    => esc_html__( 'Default Sidebar of Portfolio Posts', 'archub' ),
			'subtitle' => esc_html__( 'Select sidebar that will display on all portfolio posts.', 'archub' ),
			'data'     => 'sidebars'
		),
		array(
			'id'       => 'portfolio-sidebar-position',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Default Sidebar Position of Portfolio Posts', 'archub' ),
			'subtitle' => esc_html__( 'Manages the position of the sidebar for all portfolio posts.', 'archub' ),
			'options'  => array(
				'left'  => esc_html__( 'Left', 'archub' ),
				'right' => esc_html__( 'Right', 'archub' )
			),
			'default' => 'right'
		)
	)
);

// Portfolio Archive Sidebar
$this->sections[] = array(
	'title'      => esc_html__( 'Portfolio Archive', 'archub' ),
	'subsection' => true,
	'fields' => array(

		array(
			'id'       => 'portfolio-archive-sidebar-one',
			'type'     => 'select',
			'title'    => esc_html__( 'Sidebar of Portfolio Archive', 'archub' ),
			'subtitle' => esc_html__( 'Select a sidebar that will display on the portfolio archive pages.', 'archub' ),
			'data'     => 'sidebars'
		),
		array(
			'id'       => 'portfolio-archive-sidebar-position',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Default Sidebar Position of Portfolio Archive', 'archub' ),
			'subtitle' => esc_html__( 'Manages the position of the sidebar for portfolio archive pages.', 'archub' ),
			'options'  => array(
				'left'  => esc_html__( 'Left', 'archub' ),
				'right' => esc_html__( 'Right', 'archub' )
			),
			'default' => 'right'
		)
	)
);

// Blog Posts Sidebar
$this->sections[] = array(
	'title'      => esc_html__( 'Blog Posts', 'archub' ),
	'subsection' => true,
	'fields'     => array(

		array(
			'id'       => 'blog-enable-global',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Default Sidebar For Blog Posts', 'archub' ),
			'subtitle' => esc_html__( 'Turn on if you want to use the same sidebars on all blog posts. This option overrides the blog options.', 'archub' ),
			'options'  => array(
				'on'   => esc_html__( 'On', 'archub' ),
				'off'  => esc_html__( 'Off', 'archub' ),
			),
			'default' => 'off'
		),		
		array(
			'id'       => 'blog-sidebar-one',
			'type'     => 'select',
			'title'    => esc_html__( 'Default Blog Posts Sidebar', 'archub' ),
			'subtitle' => esc_html__( 'Select sidebar 1 that will display on all blog posts.', 'archub' ),
			'data'     => 'sidebars'
		),
		array(
			'id'       => 'blog-sidebar-position',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Default Blog Sidebar Position', 'archub' ),
			'subtitle' => esc_html__( 'Controls the position of sidebar for all blog posts. ', 'archub' ),
			'options'  => array(
				'left'  => esc_html__( 'Left', 'archub' ),
				'right' => esc_html__( 'Right', 'archub' )
			),
			'default' => 'right'
		)
	)
);

// Blog Archive Sidebar
$this->sections[] = array(
	'title'      => esc_html__( 'Blog Archive', 'archub' ),
	'subsection' => true,
	'fields'     => array(

		array(
			'id'       => 'blog-archive-sidebar-one',
			'type'     => 'select',
			'title'    => esc_html__( 'Blog Archive Sidebar', 'archub' ),
			'subtitle' => esc_html__( 'Select a sidebar that will display on the blog archive pages.', 'archub' ),
			'data' => 'sidebars'
		),
		array(
			'id'       => 'blog-archive-sidebar-position',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Default Blog Archive Sidebar Position', 'archub' ),
			'subtitle' => esc_html__( 'Controls the position of the sidebar for blog archive pages.', 'archub' ),
			'options'  => array(
				'left'  => esc_html__( 'Left', 'archub' ),
				'right' => esc_html__( 'Right', 'archub' )
			),
			'default' => 'right'
		)
	)
);

// Search page Sidebar
$this->sections[] = array(
	'title'      => esc_html__( 'Search Page', 'archub' ),
	'subsection' => true,
	'fields'     => array(

		array(
			'id'       => 'search-sidebar-one',
			'type'     => 'select',
			'title'    => esc_html__( 'Sidebar of Search Page', 'archub' ),
			'subtitle' => esc_html__( 'Choose a sidebar that will display on the search results page.', 'archub' ),
			'data' => 'sidebars'
		),
		array(
			'id'       => 'search-sidebar-position',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Sidebar Position of Search Page', 'archub' ),
			'subtitle' => esc_html__( 'Manages the position of the sidebar for the search results page.', 'archub' ),
			'options'  => array(
				'left'  => esc_html__( 'Left', 'archub' ),
				'right' => esc_html__( 'Right', 'archub' )
			),
			'default' => 'right'
		)
	)
);

liquid_action( 'option_sidebars', $this );
