<?php
/**
 * LiquidThemes Theme Framework
 * Include the TGM_Plugin_Activation class and register the required plugins.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 */

liquid()->load_library( 'class-tgm-plugin-activation' );

/**
 * Register the required plugins for this theme.
 */
add_action( 'tgmpa_register', '_s_register_required_plugins' );

function _s_register_required_plugins() {

	$images = get_template_directory_uri() . '/theme/plugins/images';

	$plugins = array(

		array(
			'name' 		         => esc_html__( 'ArcHub Core', 'archub' ),
			'slug' 		         => 'archub-core',
			'required' 	         => true,
			'source'             => 'http://api.liquid-themes.com/download.php?type=plugins&file=archub-core.zip',
			'liquid_logo'        => $images . '/one-core-min.png',
			'version'            => '1.1.1',
			'liquid_author'      => esc_html__( 'Liquid Themes', 'archub' ),
			'liquid_description' => esc_html__( 'Intelligent and Powerful Elements Plugin, exclusively for Hub WordPress Theme.', 'archub' ),
		),
		array(
			'name' 		         => esc_html__( 'ArcHub Portfolio', 'archub' ),
			'slug' 		         => 'archub-portfolio',
			'required' 	         => true,
			'source'             => 'http://api.liquid-themes.com/download.php?type=plugins&file=archub-portfolio.zip',
			'liquid_logo'        => $images . '/one-pf-min.png',
			'version'            => '1.0',
			'liquid_author'      => esc_html__( 'Liquid Themes', 'archub' ),
			'liquid_description' => esc_html__( 'Modern and Diversified Portfolio Plugin, exclusively ArcHub WordPress Theme.', 'archub' ),
		),
		array(
			'name'               => esc_html__( 'Elementor', 'archub' ),
			'slug'               => 'elementor',
			'required'           => true,
			'liquid_logo'        => $images . '/elementor.png',
			'liquid_author'      => esc_html__( 'Elementor.com', 'archub' ),
			'liquid_description' => esc_html__( 'Introducing a WordPress website builder, with no limits of design. A website builder that delivers high-end page designs and advanced capabilities, never before seen on WordPress.', 'archub' )
		),
		array(
			'name' 		         => esc_html__( 'ArcHub Elementor Addons', 'archub' ),
			'slug' 		         => 'archub-elementor-addons',
			'required' 	         => true,
			'source'             => 'http://api.liquid-themes.com/download.php?type=plugins&file=archub-elementor-addons.zip',
			'liquid_logo'        => $images . '/one-core-min.png',
			'version'            => '1.1.4',
			'liquid_author'      => esc_html__( 'Liquid Themes', 'archub' ),
			'liquid_description' => esc_html__( 'Hub Theme exclusively Elementor addons.', 'archub' ),
		),
        array(
			'name'               => esc_html__( 'Liquid GDPR Box', 'archub' ),
			'slug'               => 'liquid-gdpr',
			'required'           => false,
			'source'             => 'http://api.liquid-themes.com/download.php?type=plugins&file=liquid-gdpr.zip',
			'liquid_logo'        => $images . '/cf-7-min.png',
			'version'            => '1.0.2',
			'liquid_author'      => 'LiquidThemes',
			'liquid_description' => esc_html__( 'Liquid GDPR box', 'archub' )
		),
        array(
			'name'               => esc_html__( 'Slider Revolution', 'archub' ),
			'slug'               => 'revslider',
			'required'           => false,
			'source'             => 'http://api.liquid-themes.com/download.php?type=plugins&file=revslider.zip',
			'liquid_logo'        => $images . '/rev-slider-min.png',
			'version'            => '6.5.21',
			'liquid_author'      => 'ThemePunch',
			'liquid_description' => esc_html__( 'Premium responsive slider', 'archub' )
		),
        array(
			'name'               => esc_html__( 'Contact Form 7', 'archub' ),
			'slug'               => 'contact-form-7',
			'required'           => false,
			'liquid_logo'        => $images . '/cf-7-min.png',
			'liquid_author'      => esc_html__( 'Takayuki Miyoshi', 'archub' ),
			'liquid_description' => esc_html__( 'Contact Form 7 can manage multiple contact forms, plus you can customize the form and the mail contents flexibly with simple markup.', 'archub' )
		),
		array(
			'name'               => esc_html__( 'WooCommerce', 'archub' ),
			'slug'               => 'woocommerce',
			'required'           => false,
			'liquid_logo'        => $images . '/woo-min.png',
			'liquid_author'      => esc_html__( 'Automattic', 'archub' ),
			'liquid_description' => esc_html__( 'WooCommerce is the world’s most popular open-source eCommerce solution.', 'archub' )
		),
	);

	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
	);

	tgmpa( $plugins, $config );
}