<?php

$this->sections[] = array(
	'title'  => esc_html__( 'Woocommerce', 'archub' ),
	'icon'   => 'el-icon-shopping-cart'
);

$this->sections[] = array(
	'title'  => esc_html__( 'General', 'archub' ),
	'subsection' => true,
	'fields' => array(

		array(
			'id'    => 'wc-archive-product-style',
			'type'  => 'select',	
			'title' => esc_html__( 'Woo Category Product Style', 'archub' ),
			'desc'  => esc_html__( 'Select a style for products to display on archive page', 'archub' ),
			'options' => array(
				'default'                => esc_html__( 'Default', 'archub' ),
				'classic'                => esc_html__( 'Classic', 'archub' ),
				'classic-alt'            => esc_html__( 'Classic 2', 'archub' ),
				'minimal'                => esc_html__( 'Minimal', 'archub' ),
				'minimal-2'              => esc_html__( 'Minimal 2', 'archub' ),
				'minimal-hover-shadow'   => esc_html__( 'Minimal Hover Shadow', 'archub' ),
				'minimal-hover-shadow-2' => esc_html__( 'Minimal Hover Shadow 2', 'archub' ),
			),
			'default' => 'default'
		),
		array(
			'id'       => 'wc-archive-title-bar-enable',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Woo Category Title Bar', 'archub' ),
			'subtitle' => esc_html__( 'Turn on to show the woo category title bar', 'archub' ),
			'options'  => array(
				'on'   => esc_html__( 'On', 'archub' ),
				'off'  => esc_html__( 'Off', 'archub' )
			),
			'default'  => 'on'
		),
		array(
			'id'       => 'wc-ajax-filter',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Woo Ajax filter', 'archub' ),
			'subtitle' => esc_html__( 'Enable WooCommerce Ajax filter', 'archub' ),
			'options'  => array(
				'on'   => esc_html__( 'On', 'archub' ),
				'off'  => esc_html__( 'Off', 'archub' )
			),
			'default'  => 'off'
		),
		array(
			'id'       => 'wc-ajax-pagination',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Woo Ajax pagination', 'archub' ),
			'subtitle' => esc_html__( 'Enable WooCommerce Ajax pagination', 'archub' ),
			'options'  => array(
				'on'   => esc_html__( 'On', 'archub' ),
				'off'  => esc_html__( 'Off', 'archub' )
			),
			'default'  => 'off'
		),
		array(
			'id'       => 'wc-ajax-pagination-type',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Woo Ajax pagination type', 'archub' ),
			'subtitle' => esc_html__( 'Controls WooCommerce Ajax pagination type', 'archub' ),
			'options'  => array(
				'classic' => esc_html__( 'Classic', 'archub' ),
				'scroll'  => esc_html__( 'Scroll', 'archub' ),
				'button'  => esc_html__( 'Button', 'archub' ),
			),
			'default'  => 'classic',
			'required' => array(
				'wc-ajax-pagination',
				'equals',
				'on'
			),
		),
		array(
			'id'       => 'wc-ajax-pagination-button-text',
			'type'	   => 'text',
			'title'    => esc_html__( 'Woo Ajax pagination button text', 'archub' ),
			'subtitle' => esc_html__( 'Controls WooCommerce Ajax button text', 'archub' ),
			'default'  => esc_html__( 'Load more products', 'archub' ),
			'required' => array(
				'wc-ajax-pagination-type',
				'equals',
				'button'
			),
		),
		array(
			'id'       => 'wc-archive-title-bar-heading',
			'type'	   => 'text',
			'title'    => esc_html__( 'Woo Category Title', 'archub' ),
			'subtitle' => esc_html__( 'Controls the title text that displays in the woo category', 'archub' ),
		),
		array(
			'id'       => 'wc-archive-title-bar-subheading',
			'type'	   => 'text',
			'title'    => esc_html__( 'Woo Category Subtitle', 'archub' ),
			'subtitle' => esc_html__( 'Controls the subtitle text that displays in the woo category', 'archub' )
		),
		//Sorters/product result
		array(
			'id'       => 'wc-archive-breadcrumb',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Breadcrumb', 'archub' ),
			'subtitle' => esc_html__( 'Turn on to show breadcrumb', 'archub' ),
			'options'  => array(
				'on'   => esc_html__( 'On', 'archub' ),
				'off'  => esc_html__( 'Off', 'archub' )
			),
			'default'  => 'off'
		),
		array(
			'id'       => 'wc-archive-grid-list',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Grid/List', 'archub' ),
			'subtitle' => esc_html__( 'Turn on to show grid/list selector', 'archub' ),
			'options'  => array(
				'on'   => esc_html__( 'On', 'archub' ),
				'off'  => esc_html__( 'Off', 'archub' )
			),
			'default'  => 'off'
		),
		array(
			'id'       => 'wc-archive-image-gallery',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Show Gallery?', 'archub' ),
			'subtitle' => esc_html__( 'Enable to show images from the gallery', 'archub' ),
			'options'  => array(
				'on'   => esc_html__( 'Yes', 'archub' ),
				'off'  => esc_html__( 'No', 'archub' )
			),
			'default'  => 'off'
		),
		array(
			'id'       => 'wc-archive-show-number',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Show Products Limiter', 'archub' ),
			'subtitle' => esc_html__( 'Turn on to show products limits on the page', 'archub' ),
			'options'  => array(
				'on'   => esc_html__( 'On', 'archub' ),
				'off'  => esc_html__( 'Off', 'archub' )
			),
			'default'  => 'off'
		),
		array(
			'id'       => 'wc-archive-show-product-cats',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Show Widgetized Side Drawer', 'archub' ),
			'subtitle' => esc_html__( 'Turn on to enable widgetized side drawer', 'archub' ),
			'options'  => array(
				'on'   => esc_html__( 'On', 'archub' ),
				'off'  => esc_html__( 'Off', 'archub' )
			),
			'default'  => 'off'
		),
		array(
			'id'      => 'wc-widget-side-drawer-label',
			'type'    => 'text',
			'title'   => esc_html__( 'Label For Side Drawer', 'archub' ),
			'default' => esc_html__( 'Filter Products', 'archub' ),
			'required' => array(
				'wc-archive-show-product-cats',
				'equals',
				'on'
			),
		),
		array(
			'id'       => 'wc-widget-side-drawer-sidebar-id',
			'type'     => 'select',
			'title'    => esc_html__( 'Widgetized Side Drawer', 'archub' ),
			'subtitle' => esc_html__( 'Choose the widgetized area to display in the side drawer.', 'archub' ),
			'data'     => 'sidebars',
			'required' => array(
				'wc-archive-show-product-cats',
				'equals',
				'on'
			),
		),
		array(
			'id'      => 'wc-widget-side-drawer-mobile',
			'type'	  => 'button_set',
			'title'   => esc_html__( 'Show  on Mobile only?', 'archub' ),
			'subtitle' => esc_html__( 'Show the widgetized side drawer only for mobile devices?', 'archub' ),
			'options'  => array(
				'yes'   => esc_html__( 'Yes', 'archub' ),
				'no'  => esc_html__( 'No', 'archub' )
			),
			'default'  => 'no',
			'required' => array(
				'wc-archive-show-product-cats',
				'equals',
				'on'
			),
		),
		array(
			'id'       => 'wc-archive-result-count',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Result Count', 'archub' ),
			'subtitle' => esc_html__( 'Turn on to show result count on shop/category page', 'archub' ),
			'options'  => array(
				'on'   => esc_html__( 'On', 'archub' ),
				'off'  => esc_html__( 'Off', 'archub' )
			),
			'default'  => 'off'
		),
		array(
			'id'       => 'wc-archive-sorter-enable',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Sorter By', 'archub' ),
			'subtitle' => esc_html__( 'Turn on to show sorterby on shop/category page', 'archub' ),
			'options'  => array(
				'on'   => esc_html__( 'On', 'archub' ),
				'off'  => esc_html__( 'Off', 'archub' )
			),
			'default'  => 'off'
		),
		array(
			'id'      => 'ld_woo_products_per_page',
			'type'    => 'text',	
			'title'   => esc_html__( 'Number of Products Displayed per Page', 'archub' ),
			'desc'    => esc_html__( 'This option works with predefined WooCommerce catalog page and category pages', 'archub' ),
			'default' => '9'
		),
		array(
			'id'      => 'ld_woo_columns',
			'type'    => 'slider',
			'title'   => esc_html__( 'Number of Products Per Row', 'archub' ),
			'desc'    => esc_html__( 'Define number of products per row to display on your predefined WooCommerce page and category pages', 'archub' ),
			'min'     => 1,
			'max'     => 6,
			'default' => 3
		),
	) 
);

$this->sections[] = array(
	'title'  => esc_html__( 'Product Single', 'archub' ),
	'subsection' => true,
	'fields' => array(
		array(
			'id'       => 'product-page-style',
			'type'     => 'select',
			'title'    => esc_html( 'Product Single Style', 'archub' ),
			'subtitle' => esc_html__( 'Select a style for the single product page', 'archub' ),
			'options'  => array(
				'0'    => esc_html__( 'Default', 'archub' ),
				'1'    => esc_html__( 'Style 1', 'archub' ),
				'2'    => esc_html__( 'Style 2', 'archub' ),
				'3'    => esc_html__( 'Style 3', 'archub' ),
			),
			'default' => '0'
		),
		array(
			'id'       => 'wc-custom-layout-enable',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Woo Single Product Layout', 'archub' ),
			'subtitle' => esc_html__( 'Turn on to enable custom layouts', 'archub' ),
			'options'  => array(
				'on'   => esc_html__( 'On', 'archub' ),
				'off'  => esc_html__( 'Off', 'archub' )
			),
			'default'  => 'off'
		),
		array(
			'id'       =>'wc-custom-layout',
			'type'     => 'select',
			'title'    => esc_html__( 'Product Layout', 'archub' ),
			'subtitle' => esc_html__( 'Select a layout for the product single page', 'archub' ),
			'data'     => 'post',
			'args' => array( 
				'post_type' => 'ld-product-layout', 
				'posts_per_page' => -1 
			),
			'required' => array(
				'wc-custom-layout-enable',
				'equals',
				'on'
			),
		),
		array(
			'id'       => 'wc-title-bar-enable',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Single Product Title Wrapper', 'archub' ),
			'options'  => array(
				'on'  => esc_html__( 'On', 'archub' ),
				'off' => esc_html__( 'Off', 'archub' )
			),
			'default'  => 'on'
		),
		array(
			'id'       => 'wc-add-to-cart-ajax-enable',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Ajax add to cart ( single product )', 'archub' ),
			'subtitle' => esc_html__( 'Turn on enable ajax add to cart on single product page', 'archub' ),
			'options'  => array(
				'on'   => esc_html__( 'On', 'archub' ),
				'off'  => esc_html__( 'Off', 'archub' )
			),
			'default'  => 'off'
		),
		array(
			'id'       => 'wc-share-enable',
			'type'	   => 'button_set',
			'title'    => esc_html__( 'Woo Single Product Share', 'archub' ),
			'subtitle' => esc_html__( 'Turn on to show the share links', 'archub' ),
			'options'  => array(
				'on'   => esc_html__( 'On', 'archub' ),
				'off'  => esc_html__( 'Off', 'archub' )
			),
			'default'  => 'on'
		),
		array(
			'id'      => 'ld_woo_related_columns',
			'type'    => 'slider',	
			'title'   => esc_html__( 'Number of Related Products', 'archub' ),
			'desc'    => esc_html__( 'Define number of related products.', 'archub' ),
			'min'     => 1,
			'max'     => 6,
			'default' => 4
		),
		array(
			'id'      => 'ld_woo_cross_sell_columns',
			'type'    => 'slider',
			'title'   => esc_html__( 'Number of Displayed Cross-sells', 'archub' ),
			'desc'    => esc_html__( 'Define number of cross-sells display.', 'archub' ),
			'min'     => 1,
			'max'     => 6,
			'default' => 2
		),	
		array(
			'id'      => 'ld_woo_up_sell_columns',
			'type'    => 'slider',
			'title'   => esc_html__( 'Number of Displayed Up-sells', 'archub' ),
			'desc'    => esc_html__( 'Define number of up-sells display.', 'archub' ),
			'min'     => 1,
			'max'     => 6,
			'default' => 4
		),
	) 
);