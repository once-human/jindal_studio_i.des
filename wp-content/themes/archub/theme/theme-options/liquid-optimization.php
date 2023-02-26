<?php
/*
 * Optimization Section
*/

$title = esc_html__( 'Performance', 'archub' );

if ( class_exists( 'Liquid_Elementor_Addons' ) && defined( 'ELEMENTOR_VERSION' ) ){
    $title = wp_kses( __( 'Performance <small>beta</small>', 'archub' ), array( 'small' => array() ) );
}

$this->sections[] = array(
    'title'  => $title,
    'icon'   => 'el el-dashboard'  
);

if ( class_exists( 'Liquid_Elementor_Addons' ) && defined( 'ELEMENTOR_VERSION' ) ){
$this->sections[] = array(
    'title'  => esc_html__( 'General Settings', 'archub' ),
    'subsection' => true,
    'desc' => esc_html__( 'We recommend keeping the optimization options disabled while developing the website. You can enable this option to boost the performance once you are done with the development.', 'archub' ),  
    'fields' => array(
        array(
            'id' => 'enable_optimized_files',
            'type'     => 'button_set',
            'title'    => esc_html__( 'Enable Optimize Files', 'archub' ),
            'subtitle' => esc_html__( 'Switch on to enable the optimize files.', 'archub' ),
            'description' => wp_kses( __( '<div class="notice-yellow">This option is used to reduce size of CSS and JS files. Once activated all files will be called separately as per your page’s need. JS files can be combined via Performance > JS > Combine JS option. Please note that CSS files will be combined automatically.</div>', 'archub' ), array( 'div' => array( 'class' => array() ) ) ),
            'options'  => array(
                'on'   => esc_html__( 'On', 'archub' ),
                'off'  => esc_html__( 'Off', 'archub' ),
            ),
            'default' => 'off'
        ),
    )
);
}

if ( class_exists( 'Liquid_Elementor_Addons' ) && defined( 'ELEMENTOR_VERSION' ) ){
    $optimized_bootsrap =  array(
        'id' => 'optimized_bootstrap',
        'type'     => 'button_set',
        'title'    => esc_html__( 'Optimize Bootstrap', 'archub' ),
        'subtitle' => esc_html__( 'Load a lite version of Bootstrap containing only necesessary CSS for ArcHub.', 'archub' ),
        'options'  => array(
            'on'   => esc_html__( 'On', 'archub' ),
            'off'  => esc_html__( 'Off', 'archub' ),
        ),
        'default' => 'off'
    );
} else {
    $optimized_bootsrap = array();
}

$this->sections[] = array(
    'title'  => esc_html__( 'CSS', 'archub' ),
    'subsection' => true,
    'fields' => array(
        $optimized_bootsrap,
        array(
            'id'       => 'disable_css',
            'type'     => 'select',
            'multi'    => true,
            'title'    => __('Disable Styles', 'archub'), 
            'subtitle' => __('Selected styles will be removed from all pages.', 'archub'),
            'options'  => array(
                'wp-block-library' => 'Gutenberg Library',
                'wp-block-library-theme' => 'Gutenberg Library Theme',
                'wc-block-style' => 'Gutenberg Woocommerce',
                'wc-blocks-vendors-style' => 'Gutenberg Woocommerce Vendors'
            ),
        )
    )
);

$js_options = array();
if ( class_exists( 'Liquid_Elementor_Addons' ) && defined( 'ELEMENTOR_VERSION' ) ){
$js_options[] = array(
    'id' => 'combine_js',
    'type'     => 'button_set',
    'title'    => esc_html__( 'Combine 3rd party JS', 'archub' ),
    'subtitle' => esc_html__( 'Combine 3rd party JavaScript files coming from ArcHub into 1 file.', 'archub' ),
    'options'  => array(
        'on'   => esc_html__( 'Yes', 'archub' ),
        'off'  => esc_html__( 'No', 'archub' ),
    ),
    'default' => 'off',
    'required' => array(
        'enable_optimized_files',
        '=',
        'on'
    ),
);
}
$js_options[] = array(
    'id' => 'manage_liquid_scripts',
    'type'     => 'button_set',
    'title'    => esc_html__( 'Manage Theme Scripts', 'archub' ),
    'subtitle' => esc_html__( 'This settings for advanced users. Manage js files.', 'archub' ),
    'options'  => array(
        'on'   => esc_html__( 'Yes', 'archub' ),
        'off'  => esc_html__( 'No', 'archub' ),
    ),
    'default' => 'off',
    'required' => array(
        'lqd_disabled_opts',
        '=',
        'on'
    ),
);

if ( is_array( get_option('liquid_scrips') ) ){
    foreach ( get_option('liquid_scrips') as $key => $name){
        $js_options[] = array(
            'id'       => 'lqd-script-' . $key,
            'type'     => 'button_set',
            'title'    => $name,
            'options' => array(
                'enq' => esc_html__( 'Load', 'archub' ),
                'default' => esc_html__( 'Default', 'archub' ),
                'deq' => esc_html__( 'Remove', 'archub' ),
             ), 
            'default' => 'default',
            'required' => array(
                'manage_liquid_scripts',
                '=',
                'on'
            ),
        );
    }
}

$js_options[] =  array(
    'id' => 'jquery_rearrange',
    'type'     => 'button_set',
    'title'    => esc_html__( 'Load jQuery in Footer', 'archub' ),
    'subtitle' => esc_html__( 'Load all jQuery libraries in the footer. This can reduce the boot time of your site but may prevent some 3rd party plugins from working.', 'archub' ),
    'options'  => array(
        'on'   => esc_html__( 'Yes', 'archub' ),
        'off'  => esc_html__( 'No', 'archub' ),
    ),
    'default' => 'off'
);

$js_options[] =  array(
    'id' => 'disable_carousel_on_mobile',
    'type'     => 'button_set',
    'title'    => esc_html__( 'Disable Carousel on Mobile', 'archub' ),
    'subtitle' => esc_html__( 'Disable JavaScript carousel functionality on mobile. But still carousels will be draggable.', 'archub' ),
    'options'  => array(
        'on'   => esc_html__( 'Yes', 'archub' ),
        'off'  => esc_html__( 'No', 'archub' ),
    ),
    'default' => 'off'
);

$js_options[] =  array(
    'id' => 'disable_liquid_animations_on_mobile',
    'type'     => 'button_set',
    'title'    => esc_html__( 'Disable Liquid Animations on Mobile', 'archub' ),
    'subtitle' => esc_html__( 'Disable Custom Aimations for better performance and page scores for mobile.', 'archub' ),
    'options'  => array(
        'on'   => esc_html__( 'Yes', 'archub' ),
        'off'  => esc_html__( 'No', 'archub' ),
    ),
    'default' => 'off'
);

$js_options[] = array(
    'id'         => 'manage_liquid_custom_scripts',
    'type'       => 'repeater',
    'title'      => __( 'Manage Custom Scripts', 'archub' ),
    'subtitle'   => __( 'Add queue or dequeue custom scripts', 'archub' ),
    'sortable' => true,
    'group_values' => true,
    'bind_title' => 'handle',
    'fields'     => array(
        array(
            'id'          => 'action',
            'type'        => 'select',
            'title'       => __( 'Choose Action', 'archub' ),
            'options'     => array(
                'deq'     => __( 'Dequeue Script', 'archub' ),
                'enq'     => __( 'Enqueue Script', 'archub' ),
            ),
            'default'     => 'deq',
        ),
        array(
            'id'          => 'handle',
            'type'        => 'text',
            'title'       => __( 'Handle Name', 'archub' ),
            'placeholder' => __( 'my-custom-script', 'archub' ),
        ),
    )
);

$this->sections[] = array(
    'title'  => esc_html__( 'JS', 'archub' ),
    'subsection' => true, 
    'fields' => $js_options
);

// Fonts & Icons
$this->sections[] = array(
    'title'  => esc_html__( 'Fonts & Icon', 'archub' ),
    'subsection' => true,
    'fields' => array(
        array(
            'id'       => 'google_font_display',
            'type'     => 'select',
            'multi'    => false,
            'title'    => __('Google Fonts Load', 'archub'), 
            'subtitle' => __('Font-display property defines how font files are loaded and displayed by the browser. Set the way Google Fonts are being loaded by selecting the font-display property (Default: Auto).', 'archub'),
            'options'  => array(
                'auto' => __('Auto - Default', 'archub'),
                'block' => __('Block', 'archub'),
                'swap' => __('Swap', 'archub'),
                'fallback' => __('Fallback', 'archub'),
                'optional' => __('Optional', 'archub'),
            ),
            'default' => 'swap',
        ),
        array(
            'id' => 'load_fontawesome',
            'type'     => 'button_set',
            'title'    => esc_html__( 'Font Awesome', 'archub' ),
            'subtitle' => esc_html__( 'Load Font Awesome Icon Library', 'archub' ),
            'options'  => array(
                'on'   => esc_html__( 'Load', 'archub' ),
                'off'  => esc_html__( 'Don\'t load', 'archub' ),
            )
        ),
        array(
            'id' => 'preload_liquid_icons',
            'type'     => 'button_set',
            'title'    => esc_html__( 'Request Preload for Liquid Icons', 'archub' ),
            'subtitle' => esc_html__( 'Preload is a way of telling the browser to request a resource before the browser feels the needs of it. If you get a lqd-essentials.woff2 on Google PageSpeed, enable it.', 'archub' ),
            'options'  => array(
                'on'   => esc_html__( 'Yes', 'archub' ),
                'off'  => esc_html__( 'No', 'archub' ),
            ),
            'default' => 'on'
        ),
        array(
            'id'       => 'custom_fonts_display',
            'type'     => 'select',
            'multi'    => false,
            'title'    => __('Custom Fonts Load', 'archub'), 
            'subtitle' => __('Font-display property defines how font files are loaded and displayed by the browser. Set the way Font Icons are being loaded by selecting the font-display property (Default: Auto).', 'archub'),
            'options'  => array(
                'auto' => __('Auto - Default', 'archub'),
                'block' => __('Block', 'archub'),
                'swap' => __('Swap', 'archub'),
                'fallback' => __('Fallback', 'archub'),
                'optional' => __('Optional', 'archub'),
            ),
            'default' => 'swap',
        ),
        array(
            'id' => 'preload_liquid_custom_fonts',
            'type'     => 'button_set',
            'title'    => esc_html__( 'Request Preload for Custom Fonts', 'archub' ),
            'subtitle' => esc_html__( 'Preload is a way of telling the browser to request a resource before the browser feels the needs of it. If you get a "yours custom font" on Google PageSpeed, enable it.', 'archub' ),
            'options'  => array(
                'on'   => esc_html__( 'Yes', 'archub' ),
                'off'  => esc_html__( 'No', 'archub' ),
            ),
            'default' => 'on'
        )
    )
);

// Lazy Load
$this->sections[] = array(
    'title'  => esc_html__( 'Lazy Load', 'archub' ),
    'subsection' => true,
    'fields' => array(
        array(
			'id'       => 'enable-lazy-load',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Lazy Load', 'archub' ),
			'subtitle' => esc_html__( 'Lazy load enables images to load only when they are in the viewport. Therefore, lazy load boosts the performance.', 'archub' ),
			'options'  => array(
				'on'   => esc_html__( 'On', 'archub' ),
				'off'  => esc_html__( 'Off', 'archub' ),
			),
			'default' => 'on'
		),
        array(
			'id'       => 'lazy_load_offset',
			'type'     => 'slider',
			'title'    => esc_html__( 'Offset', 'archub' ),
			'subtitle' => esc_html__( 'Lazy Load vertical offset', 'archub' ),
			'default'  => 500,
			'max'      => 1000,
			'required' => array(
				'enable-lazy-load',
				'=',
				'on'
			),
		),
        array(
			'id'       => 'lazy_load_nth',
			'type'     => 'slider',
			'title'    => esc_html__( 'Lazy Load from nth image', 'archub' ),
			'subtitle' => esc_html__( 'Don\'t Lazy Load the first X image. When you set 1, the lazy load will apply all images', 'archub' ),
			'default'  => 2,
			'min'      => 1,
			'max'      => 10,
			'required' => array(
				'enable-lazy-load',
				'=',
				'on'
			),
		),
        array(
		    'id'       => 'lazy_load_exclude',
		    'type'     => 'textarea',
		    'title'    => esc_html__( 'Exclude custom images', 'archub'),
		    'subtitle' => esc_html__( 'Enter the image url for each line you want to disable lazy load', 'archub' ),
            'required' => array(
				'enable-lazy-load',
				'=',
				'on'
			),
		)
    )
);

// Plugins

$plugins_options = array(
    array(
        'id' => 'disable_wp_emojis',
        'type'     => 'button_set',
        'title'    => esc_html__( 'WP Emojis', 'archub' ),
        'subtitle' => esc_html__( 'Just disable this. Who in this world uses Wordpress emojis? :-) Ugh', 'archub' ),
        'options'  => array(
            'on'   => esc_html__( 'Load', 'archub' ),
            'off'  => esc_html__( 'Don\'t load', 'archub' ),
        ),
        'default' => 'on'
    ),
);

if ( defined( 'WPCF7_PLUGIN' ) ) {
    $plugins_options[] =  array(
        'id' => 'disable_cf7_js',
        'type'     => 'button_set',
        'title'    => esc_html__( 'Contact Form 7 JS', 'archub' ),
        'subtitle' => esc_html__( 'Disabling this can prevent AJAX form validation and AJAX form submits.', 'archub' ),
        'options'  => array(
            'on'   => esc_html__( 'Load', 'archub' ),
            'off'  => esc_html__( 'Don\'t load', 'archub' ),
        ),
        'default' => 'on'
    );

    $plugins_options[] =  array(
        'id' => 'disable_cf7_css',
        'type'     => 'button_set',
        'title'    => esc_html__( 'Contact Form 7 CSS', 'archub' ),
        'subtitle' => esc_html__( 'Contact Form 7 default styles.', 'archub' ),
        'options'  => array(
            'on'   => esc_html__( 'Load', 'archub' ),
            'off'  => esc_html__( 'Don\'t load', 'archub' ),
        ),
        'default' => 'on'
    );
}
if ( class_exists( 'WooCommerce' ) ) {
    $plugins_options[] =  array(
        'id' => 'disable_wc_cart_fragments',
        'type'     => 'button_set',
        'title'    => esc_html__( 'Woocommerce Cart Fragments JS', 'archub' ),
        'subtitle' => esc_html__( 'This controls updating cart usinig AJAX without refreshing page.', 'archub' ),
        'options'  => array(
            'on'   => esc_html__( 'Load', 'archub' ),
            'off'  => esc_html__( 'Don\'t load', 'archub' ),
        ),
        'default' => 'on'
    );
}

if ( defined('ELEMENTOR_VERSION') ){
    $plugins_options[] = array(
        'id'       => 'elementor_animations_css',
        'type'     => 'button_set',
        'title'    => esc_html__( 'Elementor animations CSS file', 'archub' ),
        'subtitle' => esc_html__( 'Disable this if you don\'t use Elementor  animations. This won\'t affect Liquid Custom Animations.', 'archub' ),
        'options'  => array(
            'on'   => esc_html__( 'Load', 'archub' ),
            'off'  => esc_html__( 'Don\'t load', 'archub' ),
        ),
        'default' => 'on'
    );

    $plugins_options[] = array(
        'id'       => 'elementor_icons_css',
        'type'     => 'button_set',
        'title'    => esc_html__( 'Elementor icons CSS file', 'archub' ),
        'subtitle' => esc_html__( 'Control whether you want to load Elementor "eicons" or not. ', 'archub' ),
        'options'  => array(
            'on'   => esc_html__( 'Load', 'archub' ),
            'off'  => esc_html__( 'Don\'t load', 'archub' ),
        ),
        'default' => 'on'
    );

    $plugins_options[] = array(
        'id'       => 'elementor_dialog_js',
        'type'     => 'button_set',
        'title'    => esc_html__( 'Elementor dialog.js library', 'archub' ),
        'subtitle' => esc_html__( 'If you don\'t use Elementor popups, disable this JavaScript file. ', 'archub' ),
        'options'  => array(
            'on'   => esc_html__( 'Load', 'archub' ),
            'off'  => esc_html__( 'Don\'t load', 'archub' ),
        ),
        'default' => 'on'
    );

    $plugins_options[] =  array(
        'id'       => 'elementor_frontend_js',
        'type'     => 'button_set',
        'title'    => esc_html__( 'Elementor frontend.js', 'archub' ),
        'subtitle' => esc_html__( 'This file controls some features like background slideshow, kenburns, elementor carousels, video background etc. Disabling this may break some Elementor featues.', 'archub' ),
        'options'  => array(
            'on'   => esc_html__( 'Load', 'archub' ),
            'off'  => esc_html__( 'Don\'t load', 'archub' ),
        ),
        'default' => 'on'
    );
}



$this->sections[] = array(
    'title'  => esc_html__( 'Plugins', 'archub' ),
    'subsection' => true,
    'fields' => $plugins_options
);