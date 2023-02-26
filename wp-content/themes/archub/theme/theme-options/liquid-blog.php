<?php
/*
 * Blog
 */

$this->sections[] = array(
	'title'  => esc_html__( 'Blog', 'archub' ),
	'icon'   => 'el el-pencil'
);

$this->sections[] = array(
	'title'      => esc_html__( 'General Blog', 'archub' ),
	'subsection' => true,
	'fields'     => array(

		array(
			'id'       => 'blog-title-bar-enable',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Blog Page Title Bar', 'archub' ),
			'subtitle' => esc_html__( 'Display the page title bar for the assigned blog page in settings > reading or the blog archive pages. Note: This option will not control the blog element.', 'archub' ),
			'options'  => array(
				'on'   => esc_html__( 'On', 'archub' ),
				'off'  => esc_html__( 'Off', 'archub' )
			),
			'default'  => 'on'
		),

		array(
			'id'       => 'blog-title-bar-heading',
			'type'	   => 'text',
			'title'    => esc_html__( 'Blog Page Title', 'archub' ),
			'subtitle' => esc_html__( 'Manages the title text that displays in the page title bar only if your front page displays your latest post in "settings > reading".', 'archub' ),
			'default'  => 'Blog'
		),
		array(
			'id'       => 'blog-title-bar-subheading',
			'type'	   => 'text',
			'title'    => esc_html__( 'Blog Page Subtitle', 'archub' ),
			'subtitle' => esc_html__( 'Manage the subtitle text that displays in the page title bar only if your front page displays your latest post in "settings > reading".', 'archub' )
		),
		array(
			'id'      => 'blog-style',
			'type'    => 'select',
			'title'   => esc_html__( 'Post Style', 'archub' ),
			'options' => array(
				'style01' => esc_html__( 'Style 1', 'archub' ),
				'style02' => esc_html__( 'Style 2', 'archub' ),
				'style03' => esc_html__( 'Style 3', 'archub' ),
				'style04' => esc_html__( 'Style 4', 'archub' ),
				'style05' => esc_html__( 'Style 5', 'archub' ),
				'style06' => esc_html__( 'Style 6', 'archub' ),
				'style07' => esc_html__( 'Style 7', 'archub' ),
				'style08' => esc_html__( 'Style 8', 'archub' ),
				'style09' => esc_html__( 'Style 9', 'archub' ),
				'style10' => esc_html__( 'Style 10', 'archub' ),
				'style11' => esc_html__( 'Style 11', 'archub' ),
				'style12' => esc_html__( 'Style 12', 'archub' ),
				'style13' => esc_html__( 'Style 13', 'archub' ),
				'style14' => esc_html__( 'Style 14', 'archub' ),
			),
			'subtitle' => esc_html__( 'Choose a post style for your blog page.', 'archub' ),
			'default'  => 'style11'
		),
		array(
			'id'      => 'blog-columns',
			'type'    => 'select',
			'title'   => esc_html__( 'Columns', 'archub' ),
			'options' => array(
				'1'       => esc_html__( '1 Column', 'archub' ),
				'2'       => esc_html__( '2 Columns', 'archub' ),
				'3'       => esc_html__( '3 Columns', 'archub' ),
				'4'       => esc_html__( '4 Columns', 'archub' ),
			),
			'subtitle' => esc_html__( 'How many columns to show for your blog page.', 'archub' ),
			'default'  => '1'
		),
		array(
			'id'    => 'blog-show-meta',
			'type'	   => 'button_set',
			'title' => esc_html__( 'Meta', 'archub' ),
			'options' => array(
				'yes' => esc_html__( 'Yes', 'archub' ),
				'no' => esc_html__( 'No', 'archub' ),
			),
			'subtitle' => esc_html__( 'Manage the meta for posts', 'archub' ),
			'default'  => 'yes'
		),
		array(
			'id'    => 'blog-meta-type',
			'type'  => 'select',
			'title' => esc_html__( 'Meta Type', 'archub' ),
			'options' => array(
				'tags' => esc_html__( 'Tags', 'archub' ),
				'cats' => esc_html__( 'Categories', 'archub' ),
			),
			'subtitle' => esc_html__( 'Manage the meta type for posts', 'archub' ),
			'default'  => 'tags',
			'required' => array(
				'blog-show-meta',
				'equals',
				'yes'
			)
		),
		array(
			'id'    => 'blog-one-category',
			'type'  => 'select',
			'title' => esc_html__( 'Single Category', 'archub' ),
			'options' => array(
				'yes' => esc_html__( 'Yes', 'archub' ),
				'no' => esc_html__( 'No', 'archub' ),
			),
			'subtitle' => esc_html__( 'Manage the single category for posts', 'archub' ),
			'default'  => 'yes',
			'required' => array(
				'blog-meta-type',
				'equals',
				'cats'
			)	
		),
		array(
			'id'       => 'blog-excerpt-length',
			'type'     => 'text',
			'title'    => esc_html__( 'Default Blog Excerpt Length', 'archub' ),
			'validate' => 'numeric',
			'default'  => '20',
		),
		array(
			'id'    => 'blog-date-format',
			'type'  => 'select',
			'title' => esc_html__( 'Blog Date Format', 'archub' ),
			'options' => array(
				'ago' => esc_html__( 'The passing time (x day ago)', 'archub' ),
				'wp' => esc_html__( 'Wordpress Date Format (WP Settings > General)', 'archub' ),
			),
			'subtitle' => esc_html__( 'Choose date format for archive blog page.', 'archub' ),
			'default'  => 'ago',
		),

	)
);

//Category Archive Options
$this->sections[] = array(
	'title'      => esc_html__( 'Blog Category Page', 'archub' ),
	'subsection' => true,
	'fields'     => array(

		array(
			'id'       => 'category-title-bar-enable',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Blog Category Page Title', 'archub' ),
			'subtitle' => esc_html__( 'Display the blog category page title.', 'archub' ),
			'options'  => array(
				'on'   => esc_html__( 'On', 'archub' ),
				'off'  => esc_html__( 'Off', 'archub' )
			),
			'default'  => 'on'
		),
		array(
			'id'       => 'category-title-bar-bg',
			'type'     => 'background',
			'title'    => esc_html__( 'Background Image', 'archub' ),
			'required' => array(
				'category-title-bar-enable',
				'!=',
				'off'
			),
		),
		array(
			'id'            => 'category-title-bar-bg-gradient',
			'type'          => 'liquid_colorpicker',
			'only_gradient' => true,
			'title'    => esc_html__( 'Background Gradient', 'archub' ),
			'subtitle' => esc_html__( 'Overwrites the background image, unless has transparency.', 'archub' ),
			'required' => array(
				'category-title-bar-enable',
				'!=',
				'off'
			),
		),
		array(
			'id'       => 'category-title-bar-scheme',
			'type'     => 'select',
			'title'    => esc_html__( 'Color scheme', 'archub' ),
			'options'  => array(
				''              => esc_html__( 'Light', 'archub' ),
				'scheme-light'  => esc_html__( 'Dark', 'archub' ),
			),
			'required' => array(
				'category-title-bar-enable',
				'!=',
				'off'
			),
		),
		array(
			'id'       => 'category-title-bar-heading',
			'type'	   => 'text',
			'title'    => esc_html__( 'Blog Category Page Title', 'archub' ),
			'desc'     => esc_html__( '[ld_category_title] shortcode displays the corresponding the category title, any text can be added before or after the shortcode.', 'archub' ),
			'subtitle' => esc_html__( 'Manage the title of blog category pages.', 'archub' ),
			'default'  => '',
		),

		array(
			'id'       => 'category-title-bar-subheading',
			'type'	   => 'text',
			'title'    => esc_html__( 'Blog Category Page Subtitle', 'archub' ),
			'subtitle' => esc_html__( 'Manages the subtitle of blog category pages.', 'archub' )
		),

		array(
			'id'      => 'category-blog-style',
			'type'    => 'select',
			'title'   => esc_html__( 'Style', 'archub' ),
			'options' => array(
				'style01' => esc_html__( 'Style 1', 'archub' ),
				'style02' => esc_html__( 'Style 2', 'archub' ),
				'style03' => esc_html__( 'Style 3', 'archub' ),
				'style04' => esc_html__( 'Style 4', 'archub' ),
				'style05' => esc_html__( 'Style 5', 'archub' ),
				'style06' => esc_html__( 'Style 6', 'archub' ),
				'style07' => esc_html__( 'Style 7', 'archub' ),
				'style08' => esc_html__( 'Style 8', 'archub' ),
				'style09' => esc_html__( 'Style 9', 'archub' ),
				'style10' => esc_html__( 'Style 10', 'archub' ),
				'style11' => esc_html__( 'Style 11', 'archub' ),
				'style12' => esc_html__( 'Style 12', 'archub' ),
				'style13' => esc_html__( 'Style 13', 'archub' ),
				'style14' => esc_html__( 'Style 14', 'archub' ),
			),
			'subtitle' => esc_html__( 'Select content type for your grid.', 'archub' ),
			'default'  => 'style11'
		),
		array(
			'id'      => 'blog-category-columns',
			'type'    => 'select',
			'title'   => esc_html__( 'Columns', 'archub' ),
			'options' => array(
				'1'       => esc_html__( '1 Column', 'archub' ),
				'2'       => esc_html__( '2 Columns', 'archub' ),
				'3'       => esc_html__( '3 Columns', 'archub' ),
				'4'       => esc_html__( '4 Columns', 'archub' ),
			),
			'subtitle' => esc_html__( 'How many columns to show for your blog category page.', 'archub' ),
			'default'  => '1'
		),
		array(
			'id'    => 'category-blog-show-meta',
			'type'  => 'select',
			'title' => esc_html__( 'Meta', 'archub' ),
			'options' => array(
				'yes' => esc_html__( 'Yes', 'archub' ),
				'no' => esc_html__( 'No', 'archub' ),
			),
			'subtitle' => esc_html__( 'Manage the meta for posts', 'archub' ),
			'default'  => 'yes'
		),
		array(
			'id'    => 'category-blog-meta-type',
			'type'  => 'select',
			'title' => esc_html__( 'Meta Type', 'archub' ),
			'options' => array(
				'tags' => esc_html__( 'Tags', 'archub' ),
				'cats' => esc_html__( 'Categories', 'archub' ),
			),
			'subtitle' => esc_html__( 'Manage the meta type for posts', 'archub' ),
			'default'  => 'tags',
			'required' => array(
				'blog-show-meta',
				'equals',
				'yes'
			)
		),
		array(
			'id'    => 'category-blog-one-category',
			'type'	=> 'button_set',
			'title' => esc_html__( 'Single Category', 'archub' ),
			'options' => array(
				'yes' => esc_html__( 'Yes', 'archub' ),
				'no' => esc_html__( 'No', 'archub' ),
			),
			'default'  => 'yes',
			'required' => array(
				'blog-meta-type',
				'equals',
				'cats'
			)	
		),
		array(
			'id'       => 'category-blog-excerpt-length',
			'type'     => 'text',
			'title'    => esc_html__( 'Default Blog Excerpt Length', 'archub' ),
			'validate' => 'numeric',
			'default'  => '20',
		),

	)
);

//Tag Archive Options
$this->sections[] = array(
	'title'      => esc_html__( 'Blog Tag Page', 'archub' ),
	'subsection' => true,
	'fields'     => array(

		array(
			'id'       => 'tag-title-bar-enable',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Blog Tag Page Title Bar', 'archub' ),
			'subtitle' => esc_html__( 'Display the title on blog tag pages.', 'archub' ),
			'options'  => array(
				'on'   => esc_html__( 'On', 'archub' ),
				'off'  => esc_html__( 'Off', 'archub' )
			),
			'default'  => 'on'
		),
		array(
			'id'       => 'tag-title-bar-bg',
			'type'     => 'background',
			'title'    => esc_html__( 'Background Image', 'archub' ),
			'required' => array(
				'tag-title-bar-enable',
				'!=',
				'off'
			),
		),
		array(
			'id'            => 'tag-title-bar-bg-gradient',
			'type'          => 'liquid_colorpicker',
			'only_gradient' => true,
			'title'    => esc_html__( 'Background Gradient', 'archub' ),
			'subtitle' => esc_html__( 'Overwrites the background image, unless has transparency.', 'archub' ),
			'required' => array(
				'tag-title-bar-enable',
				'!=',
				'off'
			),
		),
		array(
			'id'       => 'tag-title-bar-scheme',
			'type'     => 'select',
			'title'    => esc_html__( 'Color scheme', 'archub' ),
			'options'  => array(
				''              => esc_html__( 'Light', 'archub' ),
				'scheme-light'  => esc_html__( 'Dark', 'archub' ),
			),
			'required' => array(
				'tag-title-bar-enable',
				'!=',
				'off'
			),
		),
		array(
			'id'       => 'tag-title-bar-heading',
			'type'	   => 'text',
			'title'    => esc_html__( 'Blog Tag Page Title', 'archub' ),
			'desc'     => esc_html__( '[ld_tag_title] shortcode displays the corresponding the category title, any text can be added before or after the shortcode.', 'archub' ),
			'subtitle' => esc_html__( 'Manage the title of blog tag pages.', 'archub' ),
			'default'  => ''
		),
		array(
			'id'       => 'tag-title-bar-subheading',
			'type'	   => 'text',
			'title'    => esc_html__( 'Blog Tag Page Subtitle', 'archub' ),
			'subtitle' => esc_html__( 'Manage the subtitle of blog category pages.', 'archub' )
		),
		array(
			'id'      => 'tag-blog-style',
			'type'    => 'select',
			'title'   => esc_html__( 'Style', 'archub' ),
			'options' => array(
				'style01' => esc_html__( 'Style 1', 'archub' ),
				'style02' => esc_html__( 'Style 2', 'archub' ),
				'style03' => esc_html__( 'Style 3', 'archub' ),
				'style04' => esc_html__( 'Style 4', 'archub' ),
				'style05' => esc_html__( 'Style 5', 'archub' ),
				'style06' => esc_html__( 'Style 6', 'archub' ),
				'style07' => esc_html__( 'Style 7', 'archub' ),
				'style08' => esc_html__( 'Style 8', 'archub' ),
				'style09' => esc_html__( 'Style 9', 'archub' ),
				'style10' => esc_html__( 'Style 10', 'archub' ),
				'style11' => esc_html__( 'Style 11', 'archub' ),
				'style12' => esc_html__( 'Style 12', 'archub' ),
				'style13' => esc_html__( 'Style 13', 'archub' ),
				'style14' => esc_html__( 'Style 14', 'archub' ),
			),
			'subtitle' => esc_html__( 'Choose a post style for your blog category pages.', 'archub' ),
			'default'  => 'style11'
		),
		array(
			'id'      => 'blog-tag-columns',
			'type'    => 'select',
			'title'   => esc_html__( 'Columns', 'archub' ),
			'options' => array(
				'1'       => esc_html__( '1 Column', 'archub' ),
				'2'       => esc_html__( '2 Columns', 'archub' ),
				'3'       => esc_html__( '3 Columns', 'archub' ),
				'4'       => esc_html__( '4 Columns', 'archub' ),
			),
			'subtitle' => esc_html__( 'How many columns to show for your blog tag page.', 'archub' ),
			'default'  => '1'
		),
		array(
			'id'    => 'tag-blog-show-meta',
			'type'	=> 'button_set',
			'title' => esc_html__( 'Meta', 'archub' ),
			'options' => array(
				'yes' => esc_html__( 'Yes', 'archub' ),
				'no' => esc_html__( 'No', 'archub' ),
			),
			'default'  => 'yes'
		),
		array(
			'id'    => 'tag-blog-meta-type',
			'type'  => 'select',
			'title' => esc_html__( 'Meta Type', 'archub' ),
			'options' => array(
				'tags' => esc_html__( 'Tags', 'archub' ),
				'cats' => esc_html__( 'Categories', 'archub' ),
			),
			'subtitle' => esc_html__( 'Manage the meta type for posts', 'archub' ),
			'default'  => 'tags',
			'required' => array(
				'blog-show-meta',
				'equals',
				'yes'
			)
		),
		array(
			'id'    => 'tag-blog-one-category',
			'type'  => 'select',
			'title' => esc_html__( 'Single Category', 'archub' ),
			'options' => array(
				'yes' => esc_html__( 'Yes', 'archub' ),
				'no' => esc_html__( 'No', 'archub' ),
			),
			'default'  => 'yes',
			'required' => array(
				'blog-meta-type',
				'equals',
				'cats'
			)	
		),
		array(
			'id'       => 'tag-blog-excerpt-length',
			'type'     => 'text',
			'title'    => esc_html__( 'Default Blog Excerpt Length', 'archub' ),
			'validate' => 'numeric',
			'default'  => '20',
		),

	)
);

//Author Archive Options
$this->sections[] = array(
	'title'      => esc_html__( 'Blog Author Page', 'archub' ),
	'subsection' => true,
	'fields'     => array(

		array(
			'id'       => 'author-title-bar-enable',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Blog Author Page Title Bar', 'archub' ),
			'subtitle' => esc_html__( 'Display the title bar on blog author pages.', 'archub' ),
			'options'  => array(
				'on'   => esc_html__( 'On', 'archub' ),
				'off'  => esc_html__( 'Off', 'archub' )
			),
			'default'  => 'on'
		),
		array(
			'id'       => 'author-title-bar-bg',
			'type'     => 'background',
			'title'    => esc_html__( 'Background Image', 'archub' ),
			'required' => array(
				'author-title-bar-enable',
				'!=',
				'off'
			),
		),
		array(
			'id'            => 'author-title-bar-bg-gradient',
			'type'          => 'liquid_colorpicker',
			'only_gradient' => true,
			'title'    => esc_html__( 'Background Gradient', 'archub' ),
			'subtitle' => esc_html__( 'Overwrites the background image, unless has transparency.', 'archub' ),
			'required' => array(
				'author-title-bar-enable',
				'!=',
				'off'
			),
		),
		array(
			'id'       => 'author-title-bar-scheme',
			'type'     => 'select',
			'title'    => esc_html__( 'Color scheme', 'archub' ),
			'options'  => array(
				''              => esc_html__( 'Light', 'archub' ),
				'scheme-light'  => esc_html__( 'Dark', 'archub' ),
			),
			'required' => array(
				'author-title-bar-enable',
				'!=',
				'off'
			),
		),
		array(
			'id'       => 'author-title-bar-heading',
			'type'	   => 'text',
			'title'    => esc_html__( 'Blog Author Page Title', 'archub' ),
			'desc'     => esc_html__( '[ld_author] shortcode displays the corresponding the author name, any text can be added before or after the shortcode.', 'archub' ),
			'subtitle' => esc_html__( 'Manage the title of blog author page title.', 'archub' ),
			'default'  => ''
		),
		array(
			'id'       => 'author-title-bar-subheading',
			'type'	   => 'text',
			'title'    => esc_html__( 'Blog Author Page Subtitle', 'archub' ),
			'subtitle' => esc_html__( 'Manages the subtitle of blog author pages.', 'archub' )
		),
		array(
			'id'      => 'author-blog-style',
			'type'    => 'select',
			'title'   => esc_html__( 'Post Style', 'archub' ),
			'options' => array(
				'style01' => esc_html__( 'Style 1', 'archub' ),
				'style02' => esc_html__( 'Style 2', 'archub' ),
				'style03' => esc_html__( 'Style 3', 'archub' ),
				'style04' => esc_html__( 'Style 4', 'archub' ),
				'style05' => esc_html__( 'Style 5', 'archub' ),
				'style06' => esc_html__( 'Style 6', 'archub' ),
				'style07' => esc_html__( 'Style 7', 'archub' ),
				'style08' => esc_html__( 'Style 8', 'archub' ),
				'style09' => esc_html__( 'Style 9', 'archub' ),
				'style10' => esc_html__( 'Style 10', 'archub' ),
				'style11' => esc_html__( 'Style 11', 'archub' ),
				'style12' => esc_html__( 'Style 12', 'archub' ),
				'style13' => esc_html__( 'Style 13', 'archub' ),
				'style14' => esc_html__( 'Style 14', 'archub' ),
			),
			'subtitle' => esc_html__( 'Choose the post style for your blog author pages.', 'archub' ),
			'default'  => 'style11'
		),
		array(
			'id'      => 'blog-author-columns',
			'type'    => 'select',
			'title'   => esc_html__( 'Columns', 'archub' ),
			'options' => array(
				'1'       => esc_html__( '1 Column', 'archub' ),
				'2'       => esc_html__( '2 Columns', 'archub' ),
				'3'       => esc_html__( '3 Columns', 'archub' ),
				'4'       => esc_html__( '4 Columns', 'archub' ),
			),
			'subtitle' => esc_html__( 'How many columns to show for your blog author page.', 'archub' ),
			'default'  => '1'
		),
		array(
			'id'    => 'author-blog-show-meta',
			'type'	=> 'button_set',
			'title' => esc_html__( 'Meta', 'archub' ),
			'options' => array(
				'yes' => esc_html__( 'Yes', 'archub' ),
				'no' => esc_html__( 'No', 'archub' ),
			),
			'subtitle' => esc_html__( 'Manage the meta for posts', 'archub' ),
			'default'  => 'yes'
		),
		array(
			'id'    => 'author-blog-meta-type',
			'type'  => 'select',
			'title' => esc_html__( 'Meta Type', 'archub' ),
			'options' => array(
				'tags' => esc_html__( 'Tags', 'archub' ),
				'cats' => esc_html__( 'Categories', 'archub' ),
			),
			'default'  => 'tags',
			'required' => array(
				'blog-show-meta',
				'equals',
				'yes'
			)
		),
		array(
			'id'    => 'author-blog-one-category',
			'type'  => 'select',
			'title' => esc_html__( 'Single Category', 'archub' ),
			'options' => array(
				'yes' => esc_html__( 'Yes', 'archub' ),
				'no' => esc_html__( 'No', 'archub' ),
			),
			'default'  => 'yes',
			'required' => array(
				'blog-meta-type',
				'equals',
				'cats'
			)	
		),
		array(
			'id'       => 'author-blog-excerpt-length',
			'type'     => 'text',
			'title'    => esc_html__( 'Default Blog Excerpt Length', 'archub' ),
			'validate' => 'numeric',
			'default'  => '20',
		),

	)
);

$this->sections[] = array(
	'title'      => esc_html__('Blog Single Post', 'archub'),
	'subsection' => true,
	'fields'     => array(
		array(
			'id'      => 'post-style',
			'type'    => 'select',
			'title'   => esc_html__( 'Single Post Style', 'archub' ),
			'options' => array(
				'default'            => esc_html__( 'Default', 'archub' ),
				'modern'             => esc_html__( 'Modern', 'archub' ),
				'modern-full-screen' => esc_html__( 'Modern Full Screen', 'archub' ),
				'minimal'            => esc_html__( 'Minimal', 'archub' ),
				'overlay'            => esc_html__( 'Overlay', 'archub' ),
				'dark'               => esc_html__( 'Dark', 'archub' ),
				'classic'            => esc_html__( 'Classic', 'archub' ),
				'wide'               => esc_html__( 'Wide', 'archub' ),
			),
			'default' => 'classic'
		),
		array(
			'id'       => 'post-one-category',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Show Only One Post Category', 'archub' ),
			'subtitle' => esc_html__( 'When you turn it "off", all categories are will be listed.', 'archub' ),
			'options'  => array(
				'on'   => esc_html__( 'On', 'archub' ),
				'off'  => esc_html__( 'Off', 'archub' )
			),
			'default' => 'off'
		),
		array(
			'id'       => 'post-titlebar-enable',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Page Title Bar', 'archub' ),
			'subtitle' => esc_html__( 'Display title bar on single posts', 'archub' ),
			'options'  => array(
				'on'   => esc_html__( 'On', 'archub' ),
				'off'  => esc_html__( 'Off', 'archub' )
			),
			'default' => 'off'
		),
		array(
			'id'       => 'post-social-box-enable',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Social Sharing', 'archub' ),
			'subtitle' => esc_html__( 'Display the social sharing box on single post pages.', 'archub' ),
			'options'  => array(
				'on'   => esc_html__( 'On', 'archub' ),
				'off'  => esc_html__( 'Off', 'archub' )
			),
			'default'  => 'on'
		),
		array(
			'id'       => 'post-author-box-enable',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Author Meta', 'archub' ),
			'subtitle' => esc_html__( 'Switch on to display the author info box on single post pages.', 'archub' ),
			'options'  => array(
				'on'   => esc_html__( 'On', 'archub' ),
				'off'  => esc_html__( 'Off', 'archub' )
			),
			'default'  => 'on'
		),
		array(
			'id'       => 'post-author-role-enable',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Author Role', 'archub' ),
			'subtitle' => esc_html__( 'Turn on to display the author role in info box below posts.', 'archub' ),
			'options'  => array(
				'on'   => esc_html__( 'On', 'archub' ),
				'off'  => esc_html__( 'Off', 'archub' )
			),
			'default'  => ''
		),
		array(
			'id'       => 'post-floating-box-enable',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Floating Box', 'archub' ),
			'subtitle' => esc_html__( 'Turn on to display floating box with share social links and admin info', 'archub' ),
			'options'  => array(
				'on'   => esc_html__( 'On', 'archub' ),
				''     => esc_html__( 'Default', 'archub' ),
				'off'  => esc_html__( 'Off', 'archub' )
			),
			'default'  => ''
		),
		array(
			'id'       => 'post-floating-box-social-style',
			'type'     => 'select',
			'title'    => esc_html__( 'Floating Box Social Style', 'archub' ),
			'options'  => array(
				'default'           => esc_html__( 'Default', 'archub' ),
				'with-text-outline' => esc_html__( 'Outline Text', 'archub' ),
			),
			'required' => array(
				'post-floating-box-enable',
				'!=',
				'off'
			)
		),
		array(
			'id'       => 'post-floating-box-author-enable',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Floating Box Author', 'archub' ),
			'subtitle' => esc_html__( 'Turn on to display author info in floating box', 'archub' ),
			'options'  => array(
				'on'   => esc_html__( 'On', 'archub' ),
				''     => esc_html__( 'Default', 'archub' ),
				'off'  => esc_html__( 'Off', 'archub' )
			),
			'default'  => ''
		),
		array(
			'id'       => 'post-navigation-enable',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Neighbour Posts', 'archub' ),
			'subtitle' => esc_html__( 'Switch on to display the previous post and next post on single post pages.', 'archub' ),
			'options'  => array(
				'on'   => esc_html__( 'On', 'archub' ),
				'off'  => esc_html__( 'Off', 'archub' )
			),
			'default'  => 'on'
		),
		array(
			'id'       => 'blog-archive-link',
			'type'     => 'text',
			'title'    => esc_html__( 'Blog Archive URL', 'archub' ),
			'desc'     => esc_html__( 'Custom link to post on navigation to link to the default blog archive', 'archub' ),
			'validate' => 'url',
			'required' => array(
				'post-navigation-enable',
				'equals',
				'on'
			)
		),
		array(
			'id'       => 'post-related-enable',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Related Posts', 'archub' ),
			'subtitle' => esc_html__( 'Display the related posts on single posts.', 'archub' ),
			'options'  => array(
				'on'   => esc_html__( 'On', 'archub' ),
				'off'  => esc_html__( 'Off', 'archub' )
			),
			'default'  => 'on'
		),
		array(
			'id'       => 'post-related-style',
			'type'     => 'select',
			'title'    => esc_html__( 'Related posts section style', 'archub' ),
			'subtitle' => esc_html__( 'Select desired style for the related posts section to display on single post', 'archub' ),
			'options'  => array(
				'style-1'   => esc_html__( 'Style 1', 'archub' ),
				'style-2'   => esc_html__( 'Style 2', 'archub' ),
				'style-3'   => esc_html__( 'Style 3', 'archub' ),
			),
			'default' => '',
			'required' => array(
				'post-related-enable',
				'!=',
				'off'
			)
		),
		array(
			'type'     => 'text',
			'id'       => 'post-related-title',
			'title'    => esc_html__( 'Title of Related Posts', 'archub' ),
			'default'  => 'You may also like',
			'required' => array(
				'post-related-enable',
				'equals',
				'on'
			)
		),
		array(
			'type'     => 'slider',
			'id'       => 'post-related-number',
			'title'    => esc_html__( 'Related Posts Quantity', 'archub' ),
			'subtitle' => esc_html__( 'Quantity of projects those display on related posts section.', 'archub' ),
			'default'  => 2,
			'max'      => 100,
			'required' => array(
				'post-related-enable',
				'equals',
				'on'
			)
		)
	)
);
