<?php
/**
 * LiquidThems Theme Framework
 */

if( !defined( 'ABSPATH' ) ) 
	exit; // Exit if accessed directly

// Custom Post Type Supports
add_theme_support( 'liquid-portfolio' );
add_theme_support( 'liquid-footer' );
add_theme_support( 'liquid-header' );
add_theme_support( 'liquid-promotion' );
add_theme_support( 'liquid-mega-menu' );
if( liquid_helper()->is_woocommerce_active() ) {
	add_theme_support( 'liquid-product-layout' );
}

// Custom Extensions
add_theme_support( 'liquid-extension', array(
	'mega-menu',
	'breadcrumb',
	'wp-editor'
) );
add_post_type_support( 'post', 'liquid-post-likes' );

//Support Gutenberg
add_theme_support(
	'gutenberg',
	array( 'wide-images' => true )
);
add_theme_support( 'wp-block-styles' );
add_theme_support( 'responsive-embeds' );
add_theme_support( 'align-wide' );

// Set theme options
liquid()->set_option_name( 'liquid_one_opt' );
add_theme_support( 'liquid-theme-options', array(
	'header',
	'footer',
	'sidebars',
	'typography',
	'blog',
	'portfolio',
	'woocommerce',
	'page-search',
	'apikeys',
	'extras',
	'gdpr',
	'advanced',
	'custom-code',
	'export',
    'optimization'
));

if( function_exists( 'liquid_add_image_sizes' ) ) {
	liquid_add_image_sizes();
}

//Set available metaboxes
add_theme_support( 'liquid-metaboxes', array(
	
	'woocommerce',
	'title-wrapper',
	'post-format'

));

//Enable support for Post Formats.
//See http://codex.wordpress.org/Post_Formats
add_theme_support( 'post-formats', array(
	'audio', 'gallery', 'link', 'quote', 'video'
) );

// Sets up theme navigation locations.
register_nav_menus( array(
   'primary'   => esc_html__( 'Primary Menu', 'archub' ),
   'secondary' => esc_html__( 'Secondary Menu', 'archub' )
) );

// Register Widgets Area.
add_action( 'widgets_init', 'liquid_main_sidebar' );
function liquid_main_sidebar() {
	register_sidebar( array(
		'name'          => esc_html__( 'Main Sidebar', 'archub' ),
		'id'            => 'main',
		'description'   => esc_html__( 'Main widget area to display in sidebar', 'archub' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	));
}