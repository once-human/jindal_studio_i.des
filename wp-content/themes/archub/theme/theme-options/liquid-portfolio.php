<?php
/*
 * Portfolio
 */

$this->sections[] = array(
	'title'  => esc_html__( 'Portfolio', 'archub' ),
	'icon'   => 'el el-th-large'
);

$this->sections[] = array(
	'title'      => esc_html__( 'General', 'archub' ),
	'subsection' => true,
	'fields'     => array(
		
		array(
			'id'       => 'portfolio-title-bar-enable',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Enable Portfolio Archive Page Title', 'archub' ),
			'subtitle' => esc_html__( 'Display the portfolio archive page title.', 'archub' ),
			'options'  => array(
				'on'   => esc_html__( 'On', 'archub' ),
				'off'  => esc_html__( 'Off', 'archub' )
			),
			'default'  => 'on'
		),
		array(
			'id'       => 'portfolio-title-bar-heading',
			'type'	   => 'text',
			'title'    => esc_html__( 'Portfolio Archive Page Title', 'archub' ),
			'desc'     => esc_html__( '[ld_category_title] shortcode displays the corresponding category title, any text can be added before or after the shortcode.', 'archub' ),
			'subtitle' => esc_html__( 'Manage the title of portfolio archive pages.', 'archub' ),
			'default'  => esc_html__( '[ld_category_title]', 'archub' ),
		),

		array(
			'id'      => 'portfolio-archive-style',
			'type'    => 'select',
			'title'   => esc_html__( 'Portfolio Style', 'archub' ),
			'options' => array(
				'style01' => esc_html__( 'Style 1', 'archub' ),
				'style02' => esc_html__( 'Style 2', 'archub' ),
				'style03' => esc_html__( 'Style 3', 'archub' ),
				'style04' => esc_html__( 'Style 4', 'archub' ),
				'style05' => esc_html__( 'Style 5', 'archub' ),

			),
			'default'  => 'style01'
		),
		array(
			'id'       => 'portfolio-horizontal-alignment',
			'type'     => 'select',
			'title'    => esc_html__( 'Horizontal Alignment', 'archub' ),
			'subtitle' => esc_html__( 'Content horizontal alignment', 'archub' ),
			'options' => array(
				''                 => esc_html__( 'Default', 'archub' ),
				'pf-details-h-str' => esc_html__( 'Left', 'archub' ),
				'pf-details-h-mid' => esc_html__( 'Center', 'archub' ),
				'pf-details-h-end' => esc_html__( 'Right', 'archub' ),
			),
			'required' => array(
				'portfolio-style',
				'!=',
				array( 
					'grid-alt',
				),
			),
		),
		array(
			'id'       => 'portfolio-vertical-alignment',
			'type'     => 'select',
			'title'    => esc_html__( 'Vertical Alignment', 'archub' ),
			'subtitle' => esc_html__( 'Content vertical alignment', 'archub' ),
			'options' => array(
				'' => esc_html__( 'Default', 'archub' ),
				'pf-details-v-str' => esc_html__( 'Top', 'archub' ),
				'pf-details-v-mid' => esc_html__( 'Middle', 'archub' ),
				'pf-details-v-end' => esc_html__( 'Bottom', 'archub' ),
			),
			'required' => array(
				'portfolio-style',
				'!=',
				array( 
					'grid-alt',
				),
			),
		),
		array(
			'id' => 'portfolio-grid-columns',
			'type' => 'select',
			'title' => esc_html__( 'Columns', 'archub' ),
			'options' => array(
				'1' => '1 Column',
				'2' => '2 Columns',
				'3' => '3 Columns',
				'4' => '4 Columns',
				'6' => '6 Columns',
			),
			'required' => array(
				'portfolio-archive-style',
				'equals',
				array( 
					'style02',
					'style06'
				),
			),
		),
		array(
			'id'    => 'portfolio-columns-gap',
			'type'  => 'slider',
			'title' => esc_html__( 'Columns gap', 'archub' ),
			'min'     => 0,
			'max'     => 35,
			'default' => 15,
		),
		array(
			'id'    => 'portfolio-bottom-gap',
			'type'  => 'slider',
			'title' => esc_html__( 'Bottom gap', 'archub' ),
			'min'     => 0,
			'max'     => 100,
			'default' => 30,
		),
		array(
			'id'       => 'portfolio-enable-parallax',
			'type'	   => 'switch',
			'title'    => esc_html__( 'Enable parallax?', 'archub' ),
			'subtitle' => esc_html__( 'Parallax for images', 'archub' ),
			'default'  => false
		),
		array(
			'type'  => 'text',
			'id'    => 'portfolio-single-slug',
			'title' => esc_html__( 'Portfolio Slug', 'archub' ),
			'description' => esc_html__( 'After saving your custom portfolio slug, flush the permalinks from "Wordpress Settings > Permalinks" for the changes to take effect.', 'archub' ),
		),
		
		array(
			'type'  => 'text',
			'id'    => 'portfolio-category-slug',
			'title' => esc_html__( 'Portfolio Category Slug', 'archub' ),
			'description' => esc_html__( 'After saving your custom portfolio slug, flush the permalinks from "Wordpress Settings > Permalinks" for the changes to take effect.', 'archub' ),
		),
		
	)
);

$this->sections[] = array(
	'title'      => esc_html__( 'Portfolio Single', 'archub' ),
	'subsection' => true,
	'fields'     => array(
		array(
			'id'       => 'portfolio-enable-header',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Header', 'archub' ),
			'subtitle' => esc_html__( 'Display the header', 'archub' ),
			'options'  => array(
				'on'   => esc_html__( 'On', 'archub' ),
				'off'  => esc_html__( 'Off', 'archub' )
			),
			'default' => 'on'
		),
		array(
			'id'       => 'portfolio-subtitle',
			'type'     => 'text',
			'title'    => esc_html__( 'Subtitle', 'archub' ),
			'subtitle' => esc_html__( 'Manage the subtitle of portfolio listing', 'archub' ),
		),
		array(
			'id'       => 'portfolio-style',
			'type'     => 'select',
			'title'    => esc_html__( 'Portfolio Style', 'archub' ),
			'options' => array(
				'default'        => esc_html__( 'Default', 'archub' ),
				'custom'         => esc_html__( 'Custom', 'archub' ),
			)
		),
		array(
			'id'       => 'portfolio-width',
			'type'     => 'select',
			'title'    => esc_html( 'Width', 'archub' ),
			'subtitle' => esc_html__( 'Defines the width of the featured image on the portfolio listing page', 'archub' ),
			'options'  => array(
				''     => esc_html__( 'Default', 'archub' ),
				'auto' => esc_html__( 'Auto - width determined by thumbnail width', 'archub' ),
				'2'    => esc_html__( '2 columns - 1/6', 'archub' ),
				'3'    => esc_html__( '3 columns - 1/4', 'archub' ),
				'4'    => esc_html__( '4 columns - 1/3', 'archub' ),
				'5'    => esc_html__( '5 columns - 5/12', 'archub' ),
				'6'    => esc_html__( '6 columns - 1/2', 'archub' ),
				'7'    => esc_html__( '7 columns - 7/12', 'archub' ),
				'8'    => esc_html__( '8 columns - 2/3', 'archub' ),
				'9'    => esc_html__( '9 columns - 3/4', 'archub' ),
				'10'   => esc_html__( '10 columns - 5/6', 'archub' ),
				'11'   => esc_html__( '11 columns - 11/12', 'archub' ),
				'12'   => esc_html__( '12 columns - 12/12', 'archub' ),
			)
		),
		array(
			'id'       => '_portfolio_image_size',
			'type'     => 'select',
			'title'    => esc_html__( 'Thumb Dimension', 'archub' ),
			'subtitle' => esc_html__( 'Choose a dimension for your portfolio thumb', 'archub' ),
			'options'  => array(

				'liquid-portfolio'          => esc_html__( 'Default - (370 x 300)', 'archub' ),
				'liquid-portfolio-sq'       => esc_html__( 'Square - (295 x 295)',     'archub' ),
				'liquid-portfolio-big-sq'   => esc_html__( 'Big Square - (600 x 600)', 'archub' ),
				'liquid-portfolio-portrait' => esc_html__( 'Portrait - (350 x 500)',   'archub' ),
				'liquid-portfolio-wide'     => esc_html__( 'Wide - (600 x 295)',       'archub' ),
				//Packery image sizes
				'liquid-packery-wide'     => esc_html__( 'Packery Wide - (570 x 370)', 'archub' ),
				'liquid-packery-portrait' => esc_html__( 'Packery Portrait - (270 x 370)', 'archub' ),
				
			)
		),
		array(
			'id'       => 'portfolio-social-box-enable',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Social Sharing Module', 'archub' ),
			'subtitle' => esc_html__( 'Switch on to display the social sharing module on single portfolio pages.', 'archub' ),
			'options'  => array(
				'on'   => esc_html__( 'On', 'archub' ),
				'off'  => esc_html__( 'Off', 'archub' )
			),
			'default'  => 'on'
		),
		array(
			'id'       => 'portfolio-archive-link',
			'type'     => 'text',
			'title'    => esc_html__( 'Portfolio Archive URL', 'archub' ),
			'desc'     => esc_html__( 'Custom link to portfolio page on navigation to link to the default portfolio archive', 'archub' ),
			'validate' => 'url',
		),
		array(
			'id'       => 'portfolio-related-enable',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Related Works', 'archub' ),
			'subtitle' => esc_html__( 'Switch on to display related works on single portfolio pages.', 'archub' ),
			'options'  => array(
				'on'   => esc_html__( 'On', 'archub' ),
				'off'  => esc_html__( 'Off', 'archub' )
			),
			'default' => 'on'
		),

		array(
			'type'    => 'text',
			'id'      => 'portfolio-related-title',
			'title'   => esc_html__( 'Related Works Title', 'archub' ),
			'default' => 'Related Works',
			'required' => array(
				'portfolio-related-enable',
				'equals',
				'on'
			)
		),
		array(
			'id'       => 'portfolio-related-style',
			'type'	   => 'select',
			'title'    => esc_html__( 'Related Works Style', 'archub' ),
			'subtitle' => esc_html__( 'Choose a style for related works on single portfolio posts.', 'archub' ),
			'options'  => array(
				'style1'   => esc_html__( 'Style 1', 'archub' ),
				'style2'   => esc_html__( 'Style 2', 'archub' ),
			),
			'required' => array(
				'portfolio-related-enable',
				'equals',
				'on'
			),
			'default' => 'style1'
		),

		array(
			'type'     => 'slider',
			'id'       => 'portfolio-related-number',
			'title'    => esc_html__( 'Number of Related Works', 'archub' ),
			'subtitle' => esc_html__( 'Manages the number of works that display on related works section.', 'archub' ),
			'default'  => 3,
			'max'      => 6,
			'required' => array(
				'portfolio-related-enable',
				'equals',
				'on'
			)
		),
		array(
			'id'       => 'portfolio-enable-date',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Date', 'archub' ),
			'subtitle' => esc_html__( 'Swtich on to show the date on your portfolio item.', 'archub' ),
			'options'  => array(
				'on'   => esc_html__( 'On', 'archub' ),
				'off'  => esc_html__( 'Off', 'archub' )
			),
			'default' => ''
		),
		array(
			'id'    => 'portfolio-date-label',
			'type'  => 'text',
			'title' => esc_html__( 'Label of Date', 'archub' ),
			'subtitle' => esc_html__( 'Translate or change the "date" text. Leave empty for no change.', 'archub' ),
			'required' => array(
				'portfolio-enable-date',
				'!=',
				'off'
			)			
		),

		array(
			'id'    => 'portfolio-date',
			'type'  => 'date',
			'title' => esc_html__( 'Date of Work', 'archub' ),
			'desc'  => esc_html__( 'Overwrites the portfolio post publish date.', 'archub' ),
			'required' => array(
				'portfolio-enable-date',
				'!=',
				'off'
			)			
		),
		array(
			'id'       => 'portfolio-website',
			'type'     => 'text',
			'validate' => 'url',
			'title'    => esc_html__( 'External URL', 'archub' )
		),
		array(
			'id'       => 'portfolio-website-label',
			'type'     => 'text',
			'title'    => esc_html__( 'Label of Button', 'archub' ),
			'default'  => esc_html__( 'Launch', 'archub' ),
		),
	)
);
