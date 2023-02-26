<?php
/**
 * Liquid Themes Theme Hooks
 */

if( ! defined( 'ABSPATH' ) ) 
	exit; 
// Exit if accessed directly

/**
 * [liquid_add_body_classes description]
 * @method liquid_add_body_classes
 * @param  [type] $classes [description]
 */
function liquid_add_body_classes( $classes ) {

	$post_ids = get_the_ID(); 
	$post_types = get_post_type( $post_ids );

	if ( (class_exists( 'Liquid_Elementor_Addons' ) && defined('ELEMENTOR_VERSION')) && ( $post_types === 'post' || $post_types === 'page' || $post_types === 'liquid-portfolio' ) ){
		$page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers( 'page' );
		$page_settings_model = $page_settings_manager->get_model( $post_ids );
		$page_color_scheme = $page_settings_model->get_settings( 'body_color_scheme' );
		$enable_frame = $page_settings_model->get_settings( 'page_enable_frame' );
		$enabled_stack = $page_settings_model->get_settings( 'page_enable_stack' );
		$enabled_nav_stack = $page_settings_model->get_settings( 'page_stack_nav' );
		$enabled_nums_stack = $page_settings_model->get_settings( 'page_stack_numbers' );
		$nums_stack_style = $page_settings_model->get_settings( 'page_stack_numbers_style' );
		$nums_stack_indicator = $page_settings_model->get_settings( 'page_stack_numbers_indicator' );
		$buttons_style = $page_settings_model->get_settings( 'page_stack_buttons_style' );
		$nav_stack_style = $page_settings_model->get_settings( 'page_stack_nav_style' );
		$nav_show_current_total_numbers = $page_settings_model->get_settings( 'page_stack_nav_show_current_total' );

		// Single Post Options
		$single_post_style = $page_settings_model->get_settings( 'post_style' );
		$single_post_style = $single_post_style ? $single_post_style : liquid_helper()->get_option( 'post-style', 'classic' );
		
		// Portfolio Options
		$portfolio_single_post_style = $page_settings_model->get_settings( 'portfolio_style' );
		$portfolio_single_post_style = $portfolio_single_post_style ? $portfolio_single_post_style : liquid_helper()->get_option( 'portfolio-style' );
	} else {
		$page_color_scheme = liquid_helper()->get_option( 'body-color-scheme' );
		$enable_frame = liquid_helper()->get_option( 'page-enable-frame', 'raw', '' );
		$enabled_stack  = liquid_helper()->get_option( 'page-enable-stack' );
		$enabled_nav_stack  = liquid_helper()->get_option( 'page-stack-nav' );
		$enabled_nums_stack = liquid_helper()->get_option( 'page-stack-numbers' );
		$nums_stack_style = liquid_helper()->get_option( 'page-stack-numbers-style' );
		$nums_stack_indicator = '';
		$buttons_style = liquid_helper()->get_option( 'page-stack-buttons-style' );
		$nav_stack_style = liquid_helper()->get_option( 'page-stack-nav-style' );

		// Single Post Options
		$single_post_style = liquid_helper()->get_option( 'post-style', 'classic' );

		// Portfolio Options
		$portfolio_single_post_style = liquid_helper()->get_option( 'portfolio-style' );
	}
	
	//Add for single post body classnames
	if( is_singular( 'post' ) ) {
		
		$alt_image_src   = liquid_helper()->get_option( 'liquid-post-cover-image' );
		$image_src = isset( $alt_image_src['background-image'] ) ? esc_url( $alt_image_src['background-image'] ) : get_the_post_thumbnail_url( get_the_ID(), 'full' );
		
		$classes[] = 'lqd-blog-post';
		
		if( empty( $single_post_style ) ) {
			$single_post_style = 'classic';
		}
		
		switch( $single_post_style ) {
			
			case 'modern':
				$classes[] = 'lqd-blog-post-style-1';
			break;
			
			case 'modern-full-screen':
				$classes[] = 'lqd-blog-post-style-2';
			break;
			
			case 'minimal':
				$classes[] = 'lqd-blog-post-style-3';
			break;

			case 'overlay':
				$classes[] = 'lqd-blog-post-style-4';
			break;
			
			case 'dark':
				$classes[] = 'lqd-blog-post-style-5';
			break;
			
			case 'classic':
			default:
				$classes[] = 'lqd-blog-post-style-6';
			break;
			
			case 'wide':
				$classes[] = 'lqd-blog-post-style-7';
			break;
			
			case 'cover':
				$classes[] = 'lqd-blog-post-style-8';
			break;
		} 


		if( !empty( $image_src ) ) {
			$classes[] = 'blog-single-post-has-thumbnail';
		}
		else {
			$classes[] = 'blog-single-post-has-not-thumbnail';
		}
		if( '' === get_post()->post_content ) {
			$classes[] = 'post-has-no-content';
		}
		
	}
	
	if( ('custom' !== $portfolio_single_post_style) && get_post_type() === 'liquid-portfolio' ) {
		$classes[] = 'lqd-pf-single lqd-pf-single-style-1';
	}

	if( class_exists( 'WooCommerce' ) && is_product() ) {

		$sp_custom_layout_enable = get_post_meta( get_the_ID(), 'wc-custom-layout-enable', true );

		if ( $sp_custom_layout_enable === 'on' ) {
			$sp_custom_layout = get_post_meta( get_the_ID(), 'wc-custom-layout', true );
		} elseif ( $sp_custom_layout_enable === '0' || empty( $sp_custom_layout_enable ) ) {
			$sp_custom_layout_enable = liquid_helper()->get_theme_option( 'wc-custom-layout-enable' );
			$sp_custom_layout = liquid_helper()->get_theme_option( 'wc-custom-layout' );
		}

		if( 'on' !== $sp_custom_layout_enable ) {
			$single_product_style = liquid_helper()->get_option( 'product-page-style', '0' );
			if( '1' === $single_product_style ) {
				$classes[] = 'lqd-woo-single-layout-1 lqd-woo-single-images-grid';
			}
			elseif( '2' === $single_product_style ) {
				$classes[] = 'lqd-woo-single-layout-2 lqd-woo-single-images-sticky-stack';
			}
			else {
				$classes[] = 'lqd-woo-single-layout-3 lqd-woo-single-images-woo-default';
			}	
		}
	}
	$enable_preloader = liquid_helper()->get_option( 'enable-preloader', 'raw', '' );
	if ( defined( 'ELEMENTOR_VERSION' ) && \Elementor\Plugin::$instance->preview->is_preview_mode() ){
		$enable_preloader = "off";
	}
	if( 'on' === $enable_preloader ) {
		$preloader_style  = liquid_helper()->get_theme_option( 'preloader-style' );
		$classes[] = 'lqd-preloader-activated';
		$classes[] = 'lqd-page-not-loaded';
		$classes[] = !empty( $preloader_style ) ? 'lqd-preloader-style-' . $preloader_style : 'lqd-preloader-style-spinner';
	}
	
	if( 'on' === $enable_frame ) {
		$classes[] = 'page-has-frame';
	}	

	if( 'on' === $enabled_stack ) {

		$classes[] = !empty( $buttons_style ) ? $buttons_style : 'lqd-stack-buttons-style-1';
		if( 'on' == $enabled_nav_stack ) {

			$classes[] = !empty( $nav_stack_style ) ? $nav_stack_style : 'lqd-stack-nav-style-1';

			if ( isset( $nav_show_current_total_numbers ) && ! empty( $nav_show_current_total_numbers ) ) {
				$classes[] = 'lqd-stack-nav-numbers-visible';
			}

		}
		
		if( 'on' == $enabled_nums_stack ) {
			$classes[] = !empty( $nums_stack_style ) ? $nums_stack_style : 'lqd-stack-nums-style-1';
		}
		
		if(
			'on' == $enabled_nums_stack &&
			!empty( $nums_stack_style ) &&
			'lqd-stack-nums-style-2' === $nums_stack_style &&
			'on' === $nums_stack_indicator
		) {
			$classes[] = 'lqd-stack-nums-style-2-ind';
		}

	}
	
	$site_layout = liquid_helper()->get_option( 'page-layout' );
	if( !empty( $site_layout ) ) {
		$classes[] = "site-$site_layout-layout";
	}

	if ( class_exists( 'Liquid_Elementor_Addons' ) && defined('ELEMENTOR_VERSION') ){
		$page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers( 'page' );
		$page_settings_model = $page_settings_manager->get_model( get_the_ID() );
		$sidebar_style = $page_settings_model->get_settings( 'sidebar_widgets_style' );
		$sidebar_style = $sidebar_style ? $sidebar_style : liquid_helper()->get_option( 'sidebar-widgets-style' );
	} else {
		$sidebar_style = liquid_helper()->get_option( 'sidebar-widgets-style' );
	}
	
	if( !empty( $sidebar_style ) ) {
		$classes[] = $sidebar_style;
	}
	
	$body_shadow = liquid_helper()->get_option( 'body-shadow' );
	if( !empty( $body_shadow ) ) {
		$classes[] = $body_shadow;
	}	

	//Page color scheme
	if( !empty( $page_color_scheme ) ) {
		if( 'light' === $page_color_scheme ) {
			$classes[] = 'page-scheme-light';
		}
		else {
			$classes[] = 'page-scheme-dark';	
		}
	}
	//Progressively load classnames
	if( 'on' === liquid_helper()->get_option( 'enable-lazy-load' ) && !is_admin() ) {
		$classes[] = 'lazyload-enabled';
	}
	
	// Header body class
	$id = liquid_get_custom_header_id(); // which one
	if ( class_exists( 'Liquid_Elementor_Addons' ) && defined('ELEMENTOR_VERSION') ){
		$page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers( 'page' );
		$page_settings_model = $page_settings_manager->get_model( $id );
		$layout = $page_settings_model->get_settings( 'header_layout' );

	} else {
		$layout = liquid_helper()->get_post_meta( 'header-layout', $id) ;
	}

	if( $layout ) {
		if( 'fullscreen' === $layout ) {
			$classes[] = 'header-style-fullscreen';
		}
		elseif( in_array( $layout, array( 'side', 'side-2', 'side-3' ) ) ) {
			$classes[] = 'header-style-side';
		}
	}
	if( liquid_get_header_shortcode_param( $id, 'lqd-stickybar-left' ) ) {
		$classes[] = 'page-has-left-stickybar';
	}
	if( liquid_get_header_shortcode_param( $id, 'lqd-stickybar-right' ) ) {
		$classes[] = 'page-has-right-stickybar';
	}

	return $classes;
	
}
add_filter( 'body_class', 'liquid_add_body_classes' );

/**
 * [liquid_add_admin_body_classes description]
 * @method liquid_add_admin_body_classes
 * @param  [type] $classes [description]
 */
function liquid_add_admin_body_classes( $classes ) {
	
	$enabled_stack  = liquid_helper()->get_option( 'page-enable-stack' );
	if( 'on' === $enabled_stack ) {
		$classes .= 'lqd-stack-enabled';
	}

	return $classes;

}
add_filter( 'admin_body_class', 'liquid_add_admin_body_classes' );

function liquid_add_megamenu_hover_bg_tags() {	

	$id = liquid_get_custom_header_id(); // which one

	if ( class_exists( 'Liquid_Elementor_Addons' ) && defined('ELEMENTOR_VERSION') ){
		$page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers( 'page' );
		$page_settings_model = $page_settings_manager->get_model( $id );
		$header_megamenu_react = $page_settings_model->get_settings( 'header_megamenu_react' );	
	} else {
		$header_megamenu_react  = get_post_meta( $id, 'header-megamenu-react', true );
	}

	if( 'yes' == $header_megamenu_react ) {
		echo '<div class="megamenu-hover-bg pointer-events-none"></div>';
	}
}
add_action( 'liquid_before_header_tag', 'liquid_add_megamenu_hover_bg_tags' );

function liquid_mobile_nav_body_attributes( $attributes ) {
	
	//Default Values
	$attributes['data-mobile-nav-style']             = 'modern';
	$attributes['data-mobile-nav-scheme']            = 'dark';
	$attributes['data-mobile-nav-trigger-alignment'] = 'right';
	$attributes['data-mobile-header-scheme']         = 'gray';
	$attributes['data-mobile-logo-alignment']        = 'default';

	// Header body atts
	$id = liquid_get_custom_header_id(); // which one
	if( $id ) {

		if ( class_exists( 'Liquid_Elementor_Addons' ) && defined('ELEMENTOR_VERSION') ){
			$page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers( 'page' );
			$page_settings_model = $page_settings_manager->get_model( $id );
	
			$mobile_nav_logo_alignment = $page_settings_model->get_settings( 'm_nav_logo_alignment' );
			$mobile_nav_logo_alignment_global = liquid_helper()->get_theme_option( 'm-nav-logo-alignment' ); // global redux
			$mobile_nav_logo_alignment = $mobile_nav_logo_alignment ? $mobile_nav_logo_alignment : $mobile_nav_logo_alignment_global;

			$mobile_nav_style = $page_settings_model->get_settings( 'm_nav_style' );
			$mobile_nav_style_global = liquid_helper()->get_theme_option( 'm-nav-style' ); // global redux
			$mobile_nav_style = $mobile_nav_style ? $mobile_nav_style : $mobile_nav_style_global;

			$mobile_nav_trigger_alignment = $page_settings_model->get_settings( 'm_nav_trigger_alignment' );
			$mobile_nav_trigger_alignment_global = liquid_helper()->get_theme_option( 'm-nav-trigger-alignment' ); // global redux
			$mobile_nav_trigger_alignment = $mobile_nav_trigger_alignment ? $mobile_nav_trigger_alignment : $mobile_nav_trigger_alignment_global;

			$mobile_nav_alignment = $page_settings_model->get_settings( 'm_nav_alignment' );
			$mobile_nav_alignment_global = liquid_helper()->get_theme_option( 'm-nav-alignment' ); // global redux
			$mobile_nav_alignment = $mobile_nav_alignment ? $mobile_nav_alignment : $mobile_nav_alignment_global;

			$mobile_nav_scheme = $page_settings_model->get_settings( 'm_nav_scheme' );
			$mobile_nav_scheme_global = liquid_helper()->get_theme_option( 'm-nav-scheme' ); // global redux
			$mobile_nav_scheme = $mobile_nav_scheme ? $mobile_nav_scheme : $mobile_nav_scheme_global;

			$mobile_nav_header_style = $page_settings_model->get_settings( 'm_nav_header_scheme' );
			$mobile_nav_header_style_global = liquid_helper()->get_theme_option( 'm-nav-header-scheme' ); // global redux
			$mobile_nav_header_style = $mobile_nav_header_style ? $mobile_nav_header_style : $mobile_nav_header_style_global;

			$mobile_header_overlay = $page_settings_model->get_settings( 'mobile_header_overlay' );
			$mobile_header_overlay_global = liquid_helper()->get_theme_option( 'mobile-header-overlay' ); // global redux
			$mobile_header_overlay = $mobile_header_overlay ? $mobile_header_overlay : $mobile_header_overlay_global;
			
			$disable_liquid_animations_on_mobile = liquid_helper()->get_theme_option( 'disable_liquid_animations_on_mobile' );
			$disable_carousel_on_mobile = liquid_helper()->get_theme_option( 'disable_carousel_on_mobile' );
			
			$enable_mobile_header_builder = $page_settings_model->get_settings( 'enable_mobile_header_builder' );
			if ( $enable_mobile_header_builder ){
				$attributes['data-mobile-header-builder'] = 'true';
			}
			
		} else {
			$mobile_nav_logo_alignment = liquid_helper()->get_post_meta( 'm-nav-logo-alignment', $id );
			$mobile_nav_logo_alignment_global = liquid_helper()->get_theme_option( 'm-nav-logo-alignment' );
			$mobile_nav_style = liquid_helper()->get_post_meta( 'm-nav-style', $id );
			$mobile_nav_style_global = liquid_helper()->get_theme_option( 'm-nav-style' );
			$mobile_nav_trigger_alignment = liquid_helper()->get_post_meta( 'm-nav-trigger-alignment', $id );
			$mobile_nav_trigger_alignment_global = liquid_helper()->get_theme_option( 'm-nav-trigger-alignment' );
			$mobile_nav_alignment = liquid_helper()->get_post_meta( 'm-nav-alignment', $id );
			$mobile_nav_alignment_global = liquid_helper()->get_theme_option( 'm-nav-alignment' );
			$mobile_nav_scheme = liquid_helper()->get_post_meta( 'm-nav-scheme', $id );
			$mobile_nav_scheme_global = liquid_helper()->get_theme_option( 'm-nav-scheme' );
			$mobile_nav_header_style = liquid_helper()->get_post_meta( 'm-nav-header-scheme', $id );
			$mobile_nav_header_style_global = liquid_helper()->get_theme_option( 'm-nav-header-scheme' );

			$mobile_header_overlay = liquid_helper()->get_post_meta( 'mobile-header-overlay', $id );
			if( empty( $mobile_header_overlay ) ) {
				$mobile_header_overlay = liquid_helper()->get_theme_option( 'mobile-header-overlay' );
			}

			$disable_liquid_animations_on_mobile = liquid_helper()->get_theme_option( 'disable_liquid_animations_on_mobile' );
			$disable_carousel_on_mobile = liquid_helper()->get_theme_option( 'disable_carousel_on_mobile' );
		}

		
		if( $mobile_nav_logo_alignment ) {
			$attributes['data-mobile-logo-alignment'] = $mobile_nav_logo_alignment;
		}
		elseif( $mobile_nav_logo_alignment_global ) {
			$attributes['data-mobile-logo-alignment'] = $mobile_nav_logo_alignment_global;
		}

		if( $mobile_nav_style ) {
			$attributes['data-mobile-nav-style'] = $mobile_nav_style;
			if( 'modern' === $mobile_nav_style ) {
				$attributes['data-mobile-nav-scheme'] = 'dark';	
			}
		}
		elseif( $mobile_nav_style_global ) {
			$attributes['data-mobile-nav-style'] = $mobile_nav_style_global;
			if( 'modern' === $mobile_nav_style_global ) {
				$attributes['data-mobile-nav-scheme'] = 'dark';	
			}			
		}

		if( $mobile_nav_trigger_alignment ) {
			$attributes['data-mobile-nav-trigger-alignment'] = $mobile_nav_trigger_alignment;
		}
		elseif( $mobile_nav_trigger_alignment_global ) {
			$attributes['data-mobile-nav-trigger-alignment'] = $mobile_nav_trigger_alignment_global;
		}

		if( $mobile_nav_alignment && 'modern' !== $mobile_nav_style ) {
			$attributes['data-mobile-nav-align'] = $mobile_nav_alignment;
		}
		elseif( $mobile_nav_alignment_global && 'modern' !== $mobile_nav_style_global ) {
			$attributes['data-mobile-nav-align'] = $mobile_nav_alignment_global;
		}

		if( $mobile_nav_scheme && 'modern' !== $mobile_nav_style ) {
			$attributes['data-mobile-nav-scheme'] = $mobile_nav_scheme;
		}
		elseif( $mobile_nav_scheme_global && 'modern' !== $mobile_nav_style_global ) {
			$attributes['data-mobile-nav-scheme'] = $mobile_nav_scheme_global;			
		}

		if( $mobile_nav_header_style ) {
			$attributes['data-mobile-header-scheme'] = $mobile_nav_header_style;
		}
		elseif( $mobile_nav_header_style_global ) {
			$attributes['data-mobile-header-scheme'] = $mobile_nav_header_style_global;
		}

		if( !empty( $mobile_header_overlay ) ) {
			if( 'yes' === $mobile_header_overlay ) {
				$attributes['data-overlay-onmobile'] = 'true';
			}
			else {
				$attributes['data-overlay-onmobile'] = 'false';
			}
		}

		if ( $disable_carousel_on_mobile === 'on' ){
			$attributes['data-disable-carousel-onmobile'] = 'true';
		}
		if ( $disable_liquid_animations_on_mobile === 'on' ){
			$attributes['data-disable-animations-onmobile'] = 'true';
		}
		
	}
	
	return $attributes;
	
}

/**
* [liquid_get_header_shortcode_param description]
* @method liquid_get_header_shortcode_param
* @return [type]                [description]
*/
function liquid_get_header_shortcode_param( $header_id, $param ) {

	if( $header_id ) {

		$header = get_post( $header_id );
		if( !isset($header->post_content) ){
			return false;
		}
		$content = $header->post_content;

		if ( liquid_helper()->str_contains( $param, $content ) ) {
			return true;
		}

	}

	return false;
}



add_filter( 'liquid_attr_body', 'liquid_mobile_nav_body_attributes', 10 );

function liquid_add_custom_cursor( $attributes ) {
	
	$bgs = array();
	$enable = liquid_helper()->get_theme_option( 'enable-custom-cursor' );
	$hide_outer             = liquid_helper()->get_theme_option( 'cc-hide-outer' );
	
	if( 'on' !== $enable ) {
		return $attributes;
	}
	if( 'on' == $hide_outer ) {
		$bgs['outerCursorHide'] = true;
	}

	$attributes['data-lqd-cc'] = 'true';
	
	if( !empty( $bgs ) ) {
		$attributes['data-cc-options'] = wp_json_encode( $bgs );
	}
	
	return $attributes;
	
}
add_filter( 'liquid_attr_body', 'liquid_add_custom_cursor', 10 );

function liquid_add_header_collapsed( $classes ) {

	// Header body class
	$id = liquid_get_custom_header_id(); // which one
	if ( class_exists( 'Liquid_Elementor_Addons' ) && defined('ELEMENTOR_VERSION') ){
		$page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers( 'page' );
		$page_settings_model = $page_settings_manager->get_model( $id );
		$layout = $page_settings_model->get_settings( 'header_layout' );

	} else {
		$layout = liquid_helper()->get_post_meta( 'header-layout', $id );
	}

	if( $layout ) {
		if( 'fullscreen' === $layout ) {
			$classes[] = 'navbar-fullscreen';
		}
	}
	return $classes;	
} 
add_filter( 'liquid_header_collapsed_classes', 'liquid_add_header_collapsed', 99 );

function liquid_add_header_nav_classes( $classes ) {

	// Header body class
	$id = liquid_get_custom_header_id(); // which one
	if ( class_exists( 'Liquid_Elementor_Addons' ) && defined('ELEMENTOR_VERSION') ){
		$page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers( 'page' );
		$page_settings_model = $page_settings_manager->get_model( $id );
		$layout = $page_settings_model->get_settings( 'header_layout' );

	} else {
		$layout = liquid_helper()->get_post_meta( 'header-layout', $id );
	}
	if( $layout ) {
		if( 'fullscreen' === $layout ) {
			$classes[] = 'main-nav-fullscreen-style-1';
		}
		elseif( 'side' === $layout ) {
			$classes[] = 'main-nav-side main-nav-side-style-1';
		}
		elseif( 'side-2' === $layout ) {
			$classes[] = 'main-nav-side main-nav-side-style-2';
		}
		elseif( 'side-3' === $layout ) {
			$classes[] = 'main-nav-side main-nav-side-style-2';
		}
	}
	return $classes;	
} 
add_filter( 'liquid_header_nav_classes', 'liquid_add_header_nav_classes', 99 );

function liquid_add_header_nav_args( $args ) {

	// Header body class
	$id = liquid_get_custom_header_id(); // which one

	if ( class_exists( 'Liquid_Elementor_Addons' ) && defined('ELEMENTOR_VERSION') ){
		$page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers( 'page' );
		$page_settings_model = $page_settings_manager->get_model( $id );
		$layout = $page_settings_model->get_settings( 'header_layout' );

	} else {
		$layout = liquid_helper()->get_post_meta( 'header-layout', $id );
	}

	if( $layout ) {
		if( 'fullscreen' === $layout 
			|| 'side' === $layout 
			|| 'side-2' === $layout 
			|| 'side-3' === $layout 
		) {
			$args['toggleType'] = 'slide';
			$args['handler']    = 'click';
		}
	}
	return $args;	
} 
add_filter( 'liquid_header_nav_args', 'liquid_add_header_nav_args', 99 );

function liquid_add_trigger_classes( $classes ) {

	// Header body class
	$id = liquid_get_custom_header_id(); // which one

	if ( class_exists( 'Liquid_Elementor_Addons' ) && defined('ELEMENTOR_VERSION') ){
		$page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers( 'page' );
		$page_settings_model = $page_settings_manager->get_model( $id );
		$layout = $page_settings_model->get_settings( 'header_layout' );

	} else {
		$layout = liquid_helper()->get_post_meta( 'header-layout', $id );
	}

	if( $layout ) {
		if( 'fullscreen' === $layout ) {
			$classes[] = 'main-nav-trigger';
		}
	}	
	return $classes;
}
add_filter( 'liquid_trigger_classes', 'liquid_add_trigger_classes', 99 );

function liquid_add_trigger_opts( $opts ) {

	// Header body class
	$id = liquid_get_custom_header_id(); // which one
	if ( class_exists( 'Liquid_Elementor_Addons' ) && defined('ELEMENTOR_VERSION') ){
		$page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers( 'page' );
		$page_settings_model = $page_settings_manager->get_model( $id );
		$layout = $page_settings_model->get_settings( 'header_layout' );

	} else {
		$layout = liquid_helper()->get_post_meta( 'header-layout', $id );
	}

	if( $layout ) {
		if( 'fullscreen' === $layout ) {
			$opts[] = 'data-toggle-options=\'{ "changeClassnames": {"html": "overflow-hidden"} }\'';
		}
		elseif( 'side' === $layout ) {
			$opts[] = 'data-toggle-options=\'{ "changeClassnames": {"html": "side-nav-showing"} }\'';
		}
	}	
	return $opts;
}
add_filter( 'liquid_trigger_opts', 'liquid_add_trigger_opts', 99 );

/**
 * [liquid_get_preloader description]
 * @method liquid_get_preloader
 * @return [type]             [description]
 */
 
function liquid_get_preloader() {

	if ( defined( 'ELEMENTOR_VERSION' ) && \Elementor\Plugin::$instance->preview->is_preview_mode() ){
		return;
	}

	$enable = liquid_helper()->get_option( 'enable-preloader', 'raw', '' );
	$preloader_style  = liquid_helper()->get_theme_option( 'preloader-style' );
	// Check if preloader is enabled
	if( 'off' === $enable ) {
		return;
	}
	
	if( !empty( $preloader_style ) ) {
		
		get_template_part( 'templates/preloader/' . $preloader_style );	
		return;
	}

	get_template_part( 'templates/preloader/spinner' );
	
}

add_action( 'liquid_before', 'liquid_get_preloader' );


/**
 * [liquid_get_header_view description]
 * @method liquid_get_header_view
 * @return [type] [description]
 */

function liquid_get_header_view() {

	//Check if is not frontend vc editor
	if( function_exists( 'vc_mode' ) && 'page_editable' === vc_mode() ) {
		return;
	}

	if ( class_exists( 'Liquid_Elementor_Addons' ) && defined('ELEMENTOR_VERSION') ){
		if ( \Elementor\Plugin::$instance->preview->is_preview_mode() && 'liquid-header' === get_post_type() ) {
			liquid_action( 'after_header_tag' );
			return;
		}
	}
	
	if( 'liquid-header' === get_post_type() ||
		'liquid-footer' === get_post_type() ||
		'liquid-mega-menu' === get_post_type() ||
		'ld-product-layout' === get_post_type()
	) {
		return;
	}

	$header_id = liquid_get_custom_header_id();
	
	if (class_exists( 'Liquid_Elementor_Addons' ) && defined('ELEMENTOR_VERSION') ){
		$page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers( 'page' );
		$page_settings_model = $page_settings_manager->get_model( get_the_ID() );
		$header_enable_switch = $page_settings_model->get_settings( 'header_enable_switch' );
		$enable = ($header_enable_switch) ? $header_enable_switch : liquid_helper()->get_option( 'header-enable-switch', 'raw', '' );
		// Overlay Header
		$page_settings_model_h = $page_settings_manager->get_model( $header_id );
		$header_overlay = $page_settings_model_h->get_settings( 'header_overlay' );
	} else {
		$enable = liquid_helper()->get_option( 'header-enable-switch', 'raw', '' );
		// Overlay Header
		$header_overlay = liquid_helper()->get_post_meta( 'header-overlay', $header_id );
	}
	// Check if header is enabled
	if( 'off' === $enable ) {
		return;
	}

		if( is_search() ) {
			$enable_titlebar = liquid_helper()->get_option( 'search-title-bar-enable', 'raw', '' );
		}
		elseif( is_post_type_archive( 'liquid-portfolio' ) || is_tax( 'liquid-portfolio-category' ) ) {
			$enable_titlebar = liquid_helper()->get_option( 'portfolio-title-bar-enable', 'raw', '' );
		}
		elseif( class_exists( 'WooCommerce' ) && ( is_product_taxonomy() || is_product_category() ) ) {
			$enable_titlebar = liquid_helper()->get_option( 'wc-archive-title-bar-enable', 'raw', '' );
		}
		elseif( class_exists( 'WooCommerce' ) && ( is_product() ) ) {
			$enable_titlebar = liquid_helper()->get_option( 'wc-title-bar-enable', 'raw', '' );
		}
		elseif (!liquid_helper()->get_current_page_id() && is_home() || ( get_option('page_for_posts') == liquid_helper()->get_page_id_by_url() || liquid_helper()->get_page_id_by_url() == 0)) {
			$enable_titlebar = liquid_helper()->get_option( 'blog-title-bar-enable', 'raw', '' );
		}
		elseif( is_singular( 'post' ) ) {
			if ( class_exists( 'Liquid_Elementor_Addons' ) && defined('ELEMENTOR_VERSION') ){
				$enable_titlebar = $page_settings_model->get_settings( 'title_bar_enable' );
				$enable_titlebar = $enable_titlebar ? $enable_titlebar : liquid_helper()->get_theme_option( 'post-titlebar-enable' );
			} else {
				$enable_titlebar = liquid_helper()->get_post_meta( 'title-bar-enable' ) ? liquid_helper()->get_post_meta( 'title-bar-enable' ) : liquid_helper()->get_theme_option( 'post-titlebar-enable' );
			}
		}
		elseif( is_category() ) {
			$enable_titlebar = liquid_helper()->get_option( 'category-title-bar-enable', 'raw', '' );
		}
		elseif( is_tag() ){
			$enable_titlebar = liquid_helper()->get_option( 'tag-title-bar-enable', 'raw', '' );
		}
		elseif( is_author() ) {
			$enable_titlebar = liquid_helper()->get_option( 'author-title-bar-enable', 'raw', '' );
		}
		else {
			if ( class_exists( 'Liquid_Elementor_Addons' ) && defined('ELEMENTOR_VERSION') ){
				$enable_titlebar = $page_settings_model->get_settings( 'title_bar_enable' );
				$enable_titlebar = $enable_titlebar ? $enable_titlebar : liquid_helper()->get_option( 'title-bar-enable', 'raw', '' );
			} else {
				$enable_titlebar = liquid_helper()->get_option( 'title-bar-enable', 'raw', '' );
			}
		}

	if( 'main-header-overlay' === $header_overlay && 'on' === $enable_titlebar ){
		return;
	}

	if ( class_exists( 'Liquid_Elementor_Addons' ) && defined('ELEMENTOR_VERSION') ){
		$header_template = $page_settings_model->get_settings( 'header_template' );
		$header_enable_switch = $page_settings_model->get_settings( 'header_enable_switch' );

		$id = (!empty($header_template) && $header_enable_switch === 'on') ? $header_template : liquid_helper()->get_option( 'header-template' );
		if ($id){
			get_template_part( 'templates/header/custom' );
			return;
		}
	} else {
		if( $id = liquid_helper()->get_option( 'header-template', 'raw', false ) ) {
			get_template_part( 'templates/header/custom' );
			return;
		}
	}

	get_template_part( 'templates/header/default' );
}
add_action( 'liquid_header', 'liquid_get_header_view' );

/**
 * [liquid_get_header_view description]
 * @method liquid_get_header_view
 * @return [type]             [description]
 */
function liquid_get_header_titlebar_view() {

	//Check if is not frontend vc editor
	if( function_exists( 'vc_mode' ) && 'page_editable' === vc_mode() ) {
		return;
	}
	
	if( 'liquid-header' === get_post_type() ||
		'liquid-footer' === get_post_type() ||
		'liquid-mega-menu' === get_post_type()
	) {
		return;
	}

	$header_id = liquid_get_custom_header_id();

	if( is_404() ) {
		$enable = liquid_helper()->get_option( 'error-404-header-enable-switch', 'raw', '' );	
	}
	else {
		if ( class_exists( 'Liquid_Elementor_Addons' ) && defined('ELEMENTOR_VERSION') ){
			$page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers( 'page' );
			$page_settings_model = $page_settings_manager->get_model( get_the_ID() );
			$header_enable_switch = $page_settings_model->get_settings( 'header_enable_switch' );
			$enable = ($header_enable_switch) ? $header_enable_switch : liquid_helper()->get_option( 'header-enable-switch', 'raw', '' );
			// Overlay Header
			$page_settings_model_h = $page_settings_manager->get_model( $header_id );
			$header_overlay = $page_settings_model_h->get_settings( 'header_overlay' );
		} else {
			$enable = liquid_helper()->get_option( 'header-enable-switch', 'raw', '' );
			// Overlay Header
			$header_overlay = liquid_helper()->get_post_meta( 'header-overlay', $header_id );
		}
	}
	// Check if title bar is enabled
	if( 'on' !== $enable ) {
		return;
	}

	if( empty( $header_overlay ) ){
		return;
	}

	if ( class_exists( 'Liquid_Elementor_Addons' ) && defined('ELEMENTOR_VERSION') ){
		$page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers( 'page' );
		$page_settings_model = $page_settings_manager->get_model( get_the_ID() );

		$header_template = $page_settings_model->get_settings( 'header_template' );
		$header_enable_switch = $page_settings_model->get_settings( 'header_enable_switch' );

		$id = (!empty($header_template) && $header_enable_switch === 'on') ? $header_template : liquid_helper()->get_option( 'header-template' );

		if ($id){
			get_template_part( 'templates/header/custom' );
			return;
		}
	} else {
		if( $id = liquid_helper()->get_option( 'header-template', 'raw', false ) ) {
			get_template_part( 'templates/header/custom' );
			return;
		}
	}

	get_template_part( 'templates/header/default' );
}
add_action( 'liquid_header_titlebar', 'liquid_get_header_titlebar_view' );

/**
 * [liquid_get_footer_view description]
 * @method liquid_get_footer_view
 * @return [type] [description]
 */

function liquid_get_back_to_top_link() {

	if ( defined('ELEMENTOR_VERSION') && \Elementor\Plugin::$instance->preview->is_preview_mode() ){
		return;
	}

	$enable = liquid_helper()->get_option( 'footer-back-to-top', 'raw', '' );

	if( 'off' === $enable ) {
		return;
	}

	$scroll_indicator = liquid_helper()->get_option( 'footer-back-to-top-scrl-ind', 'raw', '' );
	$scroll_ind_markup = '';

	if ( 'on' === $scroll_indicator ) {
		$scroll_ind_markup = '<span class="lqd-back-to-top-scrl-ind lqd-overlay d-block" data-lqd-scroll-indicator="true" data-scrl-indc-options=\'{"scale": true, "end": "bottom bottom", "origin": "bottom"}\'>
			<span class="lqd-scrl-indc-inner d-block lqd-overlay">
					<span class="lqd-scrl-indc-line d-block lqd-overlay">
						<span class="lqd-scrl-indc-el d-block lqd-overlay"></span>
					</span>
			</span>
		</span>';
	}

	echo '<div class="lqd-back-to-top pos-fix" data-back-to-top="true">
			<a href="#wrap" class="d-inline-flex align-items-center justify-content-center border-radius-circle pos-rel overflow-hidden" data-localscroll="true">
			' . $scroll_ind_markup . '
				<svg class="d-inline-block" xmlns="http://www.w3.org/2000/svg" width="21" height="32" viewBox="0 0 21 32" style="width: 1em; heigth: 1em;"><path fill="white" d="M10.5 13.625l-7.938 7.938c-.562.562-1.562.562-2.124 0C.124 21.25 0 20.875 0 20.5s.125-.75.438-1.063L9.5 10.376c.563-.563 1.5-.5 2.063.063l9 9c.562.562.562 1.562 0 2.125s-1.563.562-2.125 0z"></path></svg>
			</a>
		</div>';

}
add_action( 'liquid_before_footer', 'liquid_get_back_to_top_link' );

/**
 * [liquid_get_footer_view description]
 * @method liquid_get_footer_view
 * @return [type] [description]
 */

function liquid_get_top_scroll_indicator() {

	$enable = liquid_helper()->get_option( 'top-scroll-indicator', 'raw', '' );

	if( 'off' === $enable ) {
		return;
	}

	$style = '';

	if ( is_admin_bar_showing() ) {
		$style = 'top: 32px;';
	}

	echo '<div class="lqd-top-scrol-ind pos-fix pos-tl z-index-10 w-100 pointer-events-none" data-lqd-scroll-indicator="true" data-scrl-indc-options=\'{"scale": true, "dir": "x", "end": "bottom bottom", "origin": "left"}\' style="' . esc_attr($style) . '" >
			<span class="lqd-scrl-indc-inner d-block lqd-overlay">
				<span class="lqd-scrl-indc-line d-block lqd-overlay">
					<span class="lqd-scrl-indc-el d-block lqd-overlay"></span>
				</span>
			</span>
		</div>';

}
add_action( 'liquid_before_footer', 'liquid_get_top_scroll_indicator' );


/**
 * [liquid_get_page_frame description]
 * @method liquid_get_page_frame
 * @return [type] [description]
 */

function liquid_get_page_frame() {

	$post_ids = get_the_ID(); 
	$post_types = get_post_type( $post_ids );

	if ( ( class_exists( 'Liquid_Elementor_Addons' ) && defined('ELEMENTOR_VERSION') ) && ( $post_types === 'post' || $post_types === 'page' || $post_types === 'liquid-portfolio' ) ){
		$page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers( 'page' );
		$page_settings_model = $page_settings_manager->get_model( $post_ids );
		$enable = $page_settings_model->get_settings( 'page_enable_frame' );
		$enable_liquid_bg_frame = $page_settings_model->get_settings( 'page_enable_liquid_bg_frame' );
	} else {
		$enable = liquid_helper()->get_option( 'page-enable-frame', 'raw', '' );
		$enable_liquid_bg_frame = liquid_helper()->get_option( 'page-enable-liquid-bg-frame', 'raw', '' );
	}

	if( 'on' !== $enable ) {
		return;
	}
	$data_opts = '';
	
	if( 'on' === $enable_liquid_bg_frame ) {
		$data_opts = 'data-liquid-bg="true" data-liquid-bg-options=\'{"getBgFromSelector": "borderColor", "setBgTo": "> .lqd-page-frame"}\'';	
	}

	echo '<div class="lqd-page-frame-wrap" ' . $data_opts . '>
				<span class="lqd-page-frame lqd-page-frame-top" data-orientation="h"></span>
				<span class="lqd-page-frame lqd-page-frame-right" data-orientation="v"></span>
				<span class="lqd-page-frame lqd-page-frame-bottom" data-orientation="h"></span>
				<span class="lqd-page-frame lqd-page-frame-left" data-orientation="v"></span>
			</div>';

}
add_action( 'liquid_after_footer', 'liquid_get_page_frame' );


/**
 * [liquid_get_page_frame description]
 * @method liquid_get_page_frame
 * @return [type] [description]
 */

function liquid_get_gdpr() {

	if ( class_exists( 'Liquid_Gdpr' ) ){

		if ( liquid_helper()->get_option( 'enable-gdpr', 'raw', '' ) === 'on' ){

			if ( empty( $content = liquid_helper()->get_option( 'gdpr-content', 'raw', '' ) ) ){
				$content = esc_html__( '🍪 This website uses cookies to improve your web experience.', 'archub' );
			}
			if ( empty( $button = liquid_helper()->get_option( 'gdpr-button', 'raw', '' ) ) ){
				$button = esc_html__( 'Accept', 'archub' );
			}
	
			echo '
			<div id="lqd-gdpr" class="lqd-gdpr">
				<div class="lqd-gdpr-inner">
					<div class="lqd-gdpr-left">
						' . $content . '
					</div>
					<div class="lqd-gdpr-right">
						<button class="lqd-gdpr-accept">
						' . $button . '
						</button>
					</div>
				</div>
			</div>';
	
		}

	}

}
add_action( 'liquid_after_footer', 'liquid_get_gdpr' );


/**
 * [liquid_get_titlebar_view description]
 * @method liquid_get_titlebar_view
 * @return [type]                  [description]
 */
function liquid_get_titlebar_view() {
	
	if( is_404() ) {
		return;
	}
	
	if( 'liquid-header' === get_post_type() ||
		'liquid-footer' === get_post_type() ||
		'liquid-mega-menu' === get_post_type()
	) {
		return;
	}

	if ( class_exists( 'Liquid_Elementor_Addons' ) && defined('ELEMENTOR_VERSION') ){
		$page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers( 'page' );
		$page_settings_model = $page_settings_manager->get_model( get_the_ID() );
	}

	if( class_exists( 'ReduxFramework' ) && class_exists( 'Liquid_Addons' ) ) {

		if( is_search() ) {
			$enable = liquid_helper()->get_option( 'search-title-bar-enable', 'raw', '' );
		}
		elseif( is_post_type_archive( 'liquid-portfolio' ) || is_tax( 'liquid-portfolio-category' ) ) {
			$enable = liquid_helper()->get_option( 'portfolio-title-bar-enable', 'raw', '' );
		}
		elseif( class_exists( 'WooCommerce' ) && ( is_product_taxonomy() || is_product_category() ) ) {
			$enable = liquid_helper()->get_option( 'wc-archive-title-bar-enable', 'raw', '' );
		}
		elseif( class_exists( 'WooCommerce' ) && ( is_product() ) ) {
			$enable = liquid_helper()->get_option( 'wc-title-bar-enable', 'raw', '' );
		}
		elseif( ! liquid_helper()->get_current_page_id() && is_home() ){
			$enable = liquid_helper()->get_option( 'blog-title-bar-enable', 'raw', '' );
		}
		elseif( is_singular( 'post' ) ) {
			if ( class_exists( 'Liquid_Elementor_Addons' ) && defined('ELEMENTOR_VERSION') ){
				$enable = $page_settings_model->get_settings( 'title_bar_enable' );
				$enable = $enable ? $enable : liquid_helper()->get_theme_option( 'post-titlebar-enable' );
			} else {
				$enable = liquid_helper()->get_post_meta( 'title-bar-enable' ) ? liquid_helper()->get_post_meta( 'title-bar-enable' ) : liquid_helper()->get_theme_option( 'post-titlebar-enable' );
			}
		}
		elseif( is_category() ) {
			$enable = liquid_helper()->get_option( 'category-title-bar-enable', 'raw', '' );
		}
		elseif( is_tag() ){
			$enable = liquid_helper()->get_option( 'tag-title-bar-enable', 'raw', '' );
		}
		elseif( is_author() ) {
			$enable = liquid_helper()->get_option( 'author-title-bar-enable', 'raw', '' );
		}
		else {
			if ( class_exists( 'Liquid_Elementor_Addons' ) && defined('ELEMENTOR_VERSION') ){
				$enable = $page_settings_model->get_settings( 'title_bar_enable' );
				$enable = $enable ? $enable : liquid_helper()->get_option( 'title-bar-enable', 'raw', '' );
			} else {
				$enable = liquid_helper()->get_option( 'title-bar-enable', 'raw', '' );
			}
		}

		if( 'on' !== $enable ) {
			return;
		}
	}
	
	if( class_exists( 'bbPress' ) && is_bbpress() ) {
		get_template_part( 'templates/header/header-title-bar', 'bbpress' );
		return;		
	}

	if( is_singular( 'liquid-portfolio' )) {
		get_template_part( 'templates/header/header-title-bar', 'portfolio' );
		return;
	}

	if( !class_exists( 'ReduxFramework' ) && is_single() ) {
		return;
	}

	get_template_part( 'templates/header/header-title', 'bar' );
}
add_action( 'liquid_after_header', 'liquid_get_titlebar_view' );

/**
 * [liquid_get_footer_view description]
 * @method liquid_get_footer_view
 * @return [type] [description]
 */

function liquid_get_footer_view() {
	
	if( 'liquid-header' === get_post_type() ||
		'liquid-footer' === get_post_type() ||
		'liquid-mega-menu' === get_post_type() ||
		'ld-product-layout' === get_post_type()
	) {
		return;
	}

	if ( class_exists( 'Liquid_Elementor_Addons' ) && defined('ELEMENTOR_VERSION') ){
		$page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers( 'page' );
		$page_settings_model = $page_settings_manager->get_model( get_the_ID() );
		$footer_enable_switch = $page_settings_model->get_settings( 'footer_enable_switch' );
		$enable = ($footer_enable_switch) ? $footer_enable_switch : liquid_helper()->get_option( 'footer-enable-switch', 'raw', '' );
	} else {
		$enable = liquid_helper()->get_option( 'footer-enable-switch', 'raw', '' );
	}

	if( 'off' === $enable ) {
		return;
	}

	if ( class_exists( 'Liquid_Elementor_Addons' ) && defined('ELEMENTOR_VERSION') ){
		$page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers( 'page' );
		$page_settings_model = $page_settings_manager->get_model( get_the_ID() );

		$footer_template = $page_settings_model->get_settings( 'footer_template' );
		$footer_enable_switch = $page_settings_model->get_settings( 'footer_enable_switch' );

		$id = (!empty($footer_template) && $footer_enable_switch === 'on') ? $footer_template : liquid_helper()->get_option( 'footer-template' );
		if($id) {
			get_template_part( 'templates/footer/custom' );
			return;
		}
	} else {
		if( $id = liquid_helper()->get_option( 'footer-template', 'raw', false ) ) {
			get_template_part( 'templates/footer/custom' );
			return;
		}
	}

	

	get_template_part( 'templates/footer/default' );
}
add_action( 'liquid_footer', 'liquid_get_footer_view' );

/**
 * [liquid_custom_sidebars description]
 * @method liquid_custom_sidebars
 * @return [type] [description]
 */
function liquid_custom_sidebars() {

	//adding custom sidebars defined in theme options
	$custom_sidebars = liquid_helper()->get_theme_option( 'custom-sidebars' );
	$custom_sidebars = array_filter( (array)$custom_sidebars );

	if ( !empty( $custom_sidebars ) ) {

		foreach ( $custom_sidebars as $sidebar ) {

			register_sidebar ( array (
				'name'          => $sidebar,
				'id'            => sanitize_title( $sidebar ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			) );
		}
	}
}
add_action( 'after_setup_theme', 'liquid_custom_sidebars', 9 );

/**
* [liquid_before_comment_form description]
* @method liquid_before_comment_form
* @return [type] [description]
*/
function liquid_before_comment_form() {
	echo '<div class="row">';
}
add_action( 'comment_form_top', 'liquid_before_comment_form', 9 );

/**
* [liquid_after_comment_form description]
* @method liquid_after_comment_form
* @return [type] [description]
*/
function liquid_after_comment_form( $post_id ) {
	echo '</div>';
}
add_action( 'comment_form', 'liquid_after_comment_form', 9 );

/**
* [liquid_move_comment_field_to_bottom description]
* @method liquid_move_comment_field_to_bottom
* @return [type] [description]
*/
function liquid_move_comment_field_to_bottom( $fields ) {

	$comment_field = $fields['comment'];

	unset( $fields['comment'] );
	$fields['comment'] = $comment_field;

	return $fields;
}
add_filter( 'comment_form_fields', 'liquid_move_comment_field_to_bottom' );

/**
 * [liquid_add_image_placeholders description]
 * @method liquid_add_image_placeholders
 * @param  [type]                       $content [description]
 */

add_action( 'init', 'liquid_enable_lazy_load' );
function liquid_enable_lazy_load() {
	
	if( function_exists( 'vc_mode' ) && 'page_editable' === vc_mode() ) {
		return;
	}

	if( 'on' === liquid_helper()->get_option( 'enable-lazy-load' ) && !is_admin() ) {
		add_filter( 'wp_get_attachment_image_attributes', 'liquid_filter_gallery_img_atts', 10, 2 );
		add_filter( 'wp_lazy_loading_enabled', '__return_false' ); // romove loading attr
	}

}

/**
 * [liquid_filter_gallery_img_atts description]
 * @method liquid_process_image_placeholders
 * @param  [type]             $atts [description]
 * @param  [type]             $attachment [description]
 * @return [type]            [description]
 */
function liquid_filter_gallery_img_atts( $atts, $attachment ) {

	$img_data = $atts['src'];
    $aspect_ratio = '';

	// check image exists
	if ( empty($img_data) ){
		return array();
	}

	// check lazy load nth
	$lazy_load_nth = (int)liquid_helper()->get_option( 'lazy_load_nth' );

	if ( $lazy_load_nth != 1 ){
		STATIC $lazy_load_counter = 1;

		if ( ( $lazy_load_nth - 1 ) >= $lazy_load_counter ){
			$lazy_load_counter++;
			// check loading attribute
			if ( isset( $atts['loading'] ) ){
				$atts['loading'] ='eager';
			}
			return $atts;
		}

		$lazy_load_counter++;
	}

	// check lazy load excludes
	if ( $lazy_load_exclude = liquid_helper()->get_option( 'lazy_load_exclude' ) ){
		$excludes = explode( "\n", str_replace("\r", "", $lazy_load_exclude ) );
		if( is_array( $excludes ) ) {
			foreach ( $excludes as $exclude ) {
				if ( false !== strpos( $img_data, $exclude ) ) {
					// check loading attribute
					if ( isset( $atts['loading'] ) ){
						$atts['loading'] ='eager';
					}
					return $atts;
				}
			}
		}
	}

    $filetype = wp_check_filetype( $img_data );

    @list( $width, $height ) = getimagesize( $img_data );
    if( isset( $width ) && isset( $height ) ) {
        $aspect_ratio = $width / $height;
    }

	if( 'svg' === $filetype['ext'] ) {
        return $atts;
    }

    $atts['src'] = "data:image/svg+xml;charset=utf-8,%3Csvg xmlns%3D'http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg' viewBox%3D'0 0 {$width} {$height}'%2F%3E";
    $atts['class'] .= ' ld-lazyload';
    $atts['data-src'] = $img_data;
    if ( isset($atts['srcset']) ) {
        $atts['data-srcset'] = $atts['srcset'];
        unset($atts['srcset']);
    }
    if ( isset($atts['sizes']) ) {
        $atts['data-sizes'] = $atts['sizes'];
        unset($atts['sizes']);
    }
    $atts['data-aspect'] = $aspect_ratio;

    return $atts;
}

/**
 * [liquid_page_ajaxify description]
 * @method liquid_page_ajaxify
 * @param  [type]             $template [description]
 * @return [type]                       [description]
 */
add_action( 'template_include', 'liquid_page_ajaxify', 1 );
function liquid_page_ajaxify( $template ) {

	if( isset( $_GET['ajaxify'] ) && $_GET['ajaxify'] ) {
		
		if( ! is_archive() ) {
			$located = locate_template( 'ajaxify.php' );
		}

		if( '' != $located ) {
			return $located;
		}
	}

	return $template;
}

function liquid_get_custom_cursor() {

	$enable  = liquid_helper()->get_theme_option( 'enable-custom-cursor' );
	$explore = liquid_helper()->get_theme_option( 'cc-label-explore' );
	if( empty( $explore ) ) {
		$explore = esc_html__( 'Explore', 'archub' );
	}
	$drag    = liquid_helper()->get_theme_option( 'cc-label-drag' );
	if( empty( $drag ) ) {
		$drag = esc_html__( 'Drag', 'archub' );
	}

	// Check if preloader is enabled
	if( 'on' !== $enable ) {
		return;
	}
	
	echo '<div class="lqd-cc lqd-cc--inner pos-fix pointer-events-none"></div>
		
	<div class="lqd-cc--el lqd-cc-solid lqd-cc-explore d-flex align-items-center justify-content-center border-radius-circle pos-fix pointer-events-none">
		<div class="lqd-cc-solid-bg d-flex pos-abs lqd-overlay"></div>
		<div class="lqd-cc-solid-txt d-flex justify-content-center text-center pos-rel">
			<div class="lqd-cc-solid-txt-inner">' . wp_kses( $explore, array( 'i' => array( 'class' => array(), 'style' => array(), 'aria-hidden' => array(),) ) ) . '</div>
		</div>
	</div>

	<div class="lqd-cc--el lqd-cc-solid lqd-cc-drag d-flex align-items-center justify-content-center border-radius-circle pos-fix pointer-events-none">
		<div class="lqd-cc-solid-bg d-flex pos-abs lqd-overlay"></div>
		<div class="lqd-cc-solid-ext lqd-cc-solid-ext-left d-inline-flex align-items-center">
			<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" style="width: 1em; height: 1em;"><path fill="currentColor" d="M19.943 6.07L9.837 14.73a1.486 1.486 0 0 0 0 2.25l10.106 8.661c.96.826 2.457.145 2.447-1.125V7.195c0-1.27-1.487-1.951-2.447-1.125z"></path></svg>
		</div>
		<div class="lqd-cc-solid-txt d-flex justify-content-center text-center pos-rel">
			<div class="lqd-cc-solid-txt-inner">' . wp_kses( $drag, array( 'i' => array( 'class' => array(), 'style' => array(), 'aria-hidden' => array(),) ) ) . '</div>
		</div>
		<div class="lqd-cc-solid-ext lqd-cc-solid-ext-right d-inline-flex align-items-center">
			<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" style="width: 1em; height: 1em;"><path fill="currentColor" d="M11.768 25.641l10.106-8.66a1.486 1.486 0 0 0 0-2.25L11.768 6.07c-.96-.826-2.457-.145-2.447 1.125v17.321c0 1.27 1.487 1.951 2.447 1.125z"></path></svg>
		</div>
	</div>

	<div class="lqd-cc--el lqd-cc-arrow d-inline-flex align-items-center pos-fix pos-tl pointer-events-none">
		<svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M60.4993 0V4.77005H8.87285L80 75.9207L75.7886 79.1419L4.98796 8.35478V60.4993H0V0H60.4993Z"/>
		</svg>
	</div>

	<div class="lqd-cc--el lqd-cc-custom-icon border-radius-circle pos-fix pointer-events-none">
		<div class="lqd-cc-ci d-inline-flex align-items-center justify-content-center border-radius-circle pos-rel">
			<svg width="32" height="32" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" style="width: 1em; height: 1em;"><path fill="currentColor" fill-rule="evenodd" clip-rule="evenodd" d="M16.03 6a1 1 0 0 1 1 1v8.02h8.02a1 1 0 1 1 0 2.01h-8.02v8.02a1 1 0 1 1-2.01 0v-8.02h-8.02a1 1 0 1 1 0-2.01h8.02v-8.01a1 1 0 0 1 1.01-1.01z"></path></svg>
		</div>
	</div>

	<div class="lqd-cc lqd-cc--outer pos-fix pos-tl pointer-events-none"></div>';
	
}
add_action( 'wp_footer', 'liquid_get_custom_cursor', 54 );

function liquid_get_snickers_bar_template() {
	
	echo '<template id="lqd-temp-snickersbar">
			<div class="lqd-snickersbar d-flex flex-wrap lqd-snickersbar-in" data-item-id>
				<div class="lqd-snickersbar-inner d-flex flex-wrap align-items-center">
					<div class="lqd-snickersbar-detail">
						<p style="display: none;" class="lqd-snickersbar-addding-temp mt-0 mb-0">' . esc_html__( 'Adding {{itemName}} to cart', 'archub' ) . '</p>
						<p style="display: none;" class="lqd-snickersbar-added-temp mt-0 mb-0">'.  esc_html__( 'Added {{itemName}} to cart', 'archub' ) . '</p>
						<p class="lqd-snickersbar-msg d-flex align-items-center mt-0 mb-0"></p>
						<p class="lqd-snickersbar-msg-done d-flex align-items-center mt-0 mb-0"></p>
					</div>
					<div class="lqd-snickersbar-ext ml-4 ms-4"></div>
				</div>
			</div>
		</template>';
}
add_action( 'wp_footer', 'liquid_get_snickers_bar_template', 55 );

function liquid_get_sticky_header_sentinel_template() {
	
	echo '<template id="lqd-temp-sticky-header-sentinel">
		<div class="lqd-sticky-sentinel invisible pos-abs pointer-events-none"></div>
	</template>';
}
add_action( 'wp_footer', 'liquid_get_sticky_header_sentinel_template', 56 );

function liquid_get_modal_template() {
	
	echo '<template id="lqd-temp-modal-box">
		<div class="lqd-lity-top-wrap">
			<div class="lqd-lity" role="dialog" aria-label="Dialog Window (Press escape to close)" tabindex="-1" data-modal-type="{{MODAL-TYPE}}">
				<div class="lqd-lity-backdrop"></div>
				<div class="lqd-lity-wrap" role="document">
					<div class="lqd-lity-loader" aria-hidden="true">Loading...</div>
					<div class="lqd-lity-container">
						<div class="lqd-lity-content"></div>
					</div>
					<div class="lqd-lity-close-btn-wrap">
						<svg class="lqd-lity-close-arrow" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 32 32"><path fill="currentColor" d="M26.688 14.664H10.456l7.481-7.481L16 5.313 5.312 16 16 26.688l1.87-1.87-7.414-7.482h16.232v-2.672z"></path></svg>
						<button class="lqd-lity-close" type="button" aria-label="Close (Press escape to close)" data-lqd-lity-close>&times;</button>
						<span class="lqd-lity-trigger-txt"></span>
					</div>
				</div>
			</div>
		</div>
	</template>';
}
add_action( 'wp_footer', 'liquid_get_modal_template', 57 );

function liquid_get_animated_borders_template() {
	
	echo '<template id="lqd-temp-animated-borders" data-lqd-append-template="true" data-append-options=\'{ "targetElements": "[data-animated-borders].e-container, [data-animated-borders].elementor-section, [data-animated-borders].elementor-column > .elementor-element-populated", "getCssFromTarget": ["border-top", "border-right", "border-bottom", "border-left"], "applyCssTo": "> .lqd-animated-line" }\'>
		<div class="lqd-animated-borders pointer-events-none lqd-overlay">
			<div class="lqd-animated-line lqd-animated-line-x lqd-animated-line-t w-100 pos-abs pos-tl" data-inview="true"></div>
			<div class="lqd-animated-line lqd-animated-line-y lqd-animated-line-r h-100 pos-abs pos-tr" data-inview="true"></div>
			<div class="lqd-animated-line lqd-animated-line-x lqd-animated-line-b w-100 pos-abs pos-bl" data-inview="true"></div>
			<div class="lqd-animated-line lqd-animated-line-y lqd-animated-line-l h-100 pos-abs pos-tl" data-inview="true"></div>
		</div>
	</template>';
}
add_action( 'wp_footer', 'liquid_get_animated_borders_template', 58 );

/**
 * Get current products list view type
 * @return string
 */
function liquid_woocommerce_get_products_list_view_type() {
	
	if ( isset( $_GET['view'] ) && in_array( $_GET['view'], array( 'list', 'grid' ) ) ) {
		return $_GET['view'];
	}
	return liquid_helper()->get_option( 'shop-products-list-view' );
}

function liquid_get_product_list_classnames( $class = '' ) {
	
	$classes = array();
	
	if ( ! empty( $class ) ) {
        if ( ! is_array( $class ) ) {
            $class = preg_split( '#\s+#', $class );
        }
        $classes = array_merge( $classes, $class );
    } else {
        // Ensure that we always coerce class to being an array.
        $class = array();
    }
    
    $classes = array_map( 'esc_attr', $classes );
    $classes = apply_filters( 'liquid_product_lists_classnames', $classes, $class );
    $classes = array_unique( $classes );

	echo join( ' ', $classes );

}

function liquid_woo_price_start_container() {

	echo '<p class="ld-sp-price pos-rel">';

}
function liquid_woo_price_end_container() {

	echo '</p>';

}

function liquid_woo_buttons_start_container() {

	echo '<div class="ld-sp-btns d-flex flex-column pos-abs z-index-2">';

}
function liquid_woo_buttons_end_container() {

	echo '</div>';

}

/**
 * Add custom classnames to product content
 * @return void
 */
if ( ! function_exists( 'liquid_woocommerce_product_styles' ) ) {
	function liquid_woocommerce_product_styles( $style = '' ) {
		
		if( empty( $style ) ) {
			$style = liquid_helper()->get_option( 'wc-archive-product-style' );
		}
		
		if ( class_exists( 'YITH_WCWL_Frontend' ) ) {
			remove_action( 'woocommerce_before_shop_loop_item', array( 'YITH_WCWL_Frontend', 'print_button' ), 5 );
			remove_action( 'woocommerce_after_shop_loop_item', array( 'YITH_WCWL_Frontend', 'print_button' ), 7 );
			remove_action( 'woocommerce_after_shop_loop_item', array( 'YITH_WCWL_Frontend', 'print_button' ), 15 );
		}
		
		$view_type = liquid_woocommerce_get_products_list_view_type();
		if( 'list' ==  $view_type ) {
			return;
		}	

		if( 'classic' == $style || 'classic-alt' == $style ) {
			
			if ( class_exists( 'YITH_WCQV_Frontend' ) ) {
				remove_action( 'woocommerce_after_shop_loop_item', array( 'YITH_WCQV_Frontend', 'yith_add_quick_view_button' ), 15 );
				add_action( 'woocommerce_extra_buttons_item', 'liquid_add_quickview_button', 10 );
			}	
			
			remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 10 );

			add_action( 'woocommerce_extra_buttons_item', 'liquid_add_wishlist_button', 15 );
			add_action( 'woocommerce_extra_buttons_item', 'liquid_get_compare_button', 20 );
			
			add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_rating', 2 );
			add_action( 'woocommerce_shop_loop_item_title', 'liquid_get_product_category', 5 );
			
// 			add_action( 'woocommerce_shop_loop_item_title', 'liquid_woo_price_start_container', 5 );
// 			add_action( 'woocommerce_shop_loop_item_title', 'liquid_woo_price_end_container', 15 );

			add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 99 );
			
		}
		elseif( 'minimal' == $style ) {
			remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 10 );
			//add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
			
			add_action( 'woocommerce_after_shop_loop_item_title', 'liquid_woo_price_start_container', 1 );
			add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 15 );
			add_action( 'woocommerce_after_shop_loop_item_title', 'liquid_woo_price_end_container', 99 );
			
			//add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
			add_action( 'woocommerce_after_shop_loop_item', 'liquid_add_wishlist_button', 15 );
			add_action( 'woocommerce_after_shop_loop_item', 'liquid_get_compare_button', 20 );
			
		}
		elseif( 'minimal-2' == $style ) {
			remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 10 );
			//add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
			add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 10 );
			add_action( 'woocommerce_after_shop_loop_item', 'liquid_add_wishlist_button', 15 );
			add_action( 'woocommerce_after_shop_loop_item', 'liquid_get_compare_button', 20 );			
			
		}
		elseif( 'minimal-hover-shadow' == $style ) {
			remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 10 );
			//add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
			
			add_action( 'woocommerce_after_shop_loop_item_title', 'liquid_woo_price_start_container', 1 );
			add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 15 );
			add_action( 'woocommerce_after_shop_loop_item_title', 'liquid_woo_price_end_container', 99 );
			
			//add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
			add_action( 'woocommerce_after_shop_loop_item', 'liquid_add_wishlist_button', 15 );
			add_action( 'woocommerce_after_shop_loop_item', 'liquid_get_compare_button', 20 );
			
		}
		elseif( 'minimal-hover-shadow-2' == $style ) {
			remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 10 );
			//add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
			
			add_action( 'woocommerce_after_shop_loop_item_title', 'liquid_woo_price_start_container', 1 );
			add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 15 );
			add_action( 'woocommerce_after_shop_loop_item_title', 'liquid_woo_price_end_container', 99 );
			
			//add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
			add_action( 'woocommerce_after_shop_loop_item', 'liquid_add_wishlist_button', 15 );
			add_action( 'woocommerce_after_shop_loop_item', 'liquid_get_compare_button', 20 );
			
		}
		else {
			if ( class_exists( 'YITH_WCQV_Frontend' ) ) {
				remove_action( 'woocommerce_after_shop_loop_item', array( 'YITH_WCQV_Frontend', 'yith_add_quick_view_button' ), 15 );
				add_action( 'woocommerce_extra_buttons_item', 'liquid_add_quickview_button', 10 );
			}
			add_action( 'woocommerce_extra_buttons_item', 'liquid_add_wishlist_button', 15 );
			add_action( 'woocommerce_extra_buttons_item', 'liquid_get_compare_button', 20 );
		}
		
	}
}
liquid_woocommerce_product_styles();

add_action( 'woocommerce_shortcode_before_products_loop', 'liquid_before_products_shortcode_loop', 1, 10 );
add_action( 'woocommerce_shortcode_after_products_loop', 'liquid_after_products_shortcode_loop', 0, 10 );

add_action( 'woocommerce_shortcode_before_product_loop', 'liquid_before_products_shortcode_loop', 1, 10 );
add_action( 'woocommerce_shortcode_after_product_loop', 'liquid_after_products_shortcode_loop', 0, 10 );

add_action( 'woocommerce_shortcode_before_product_category_loop', 'liquid_before_products_shortcode_loop', 1, 10 );
add_action( 'woocommerce_shortcode_after_product_category_loop', 'liquid_after_products_shortcode_loop', 0, 10 );

function liquid_before_products_shortcode_loop( $atts ) {
	
	$style = liquid_helper()->get_option( 'wc-archive-product-style' );
	
    $GLOBALS[ 'liquid_woocommerce_loop_template' ] = ( isset( $atts[ 'style' ] ) ? $atts[ 'style' ] : $style );
}

function liquid_after_products_shortcode_loop( $atts ) {
    $GLOBALS[ 'liquid_woocommerce_loop_template' ] = '';
}

if( 'on' ===  liquid_helper()->get_option( 'wc-enable-carousel-featured' ) ) {
	add_filter( 'liquid_enable_woo_products_carousel', '__return_true' );
}
else {
	add_filter( 'liquid_enable_woo_products_carousel', '__return_false' );
}

$woo_breadcrumb_enable = liquid_helper()->get_theme_option( 'wc-archive-breadcrumb' );
if( 'on' === $woo_breadcrumb_enable ) {
	add_action( 'woocommerce_before_shop_loop', 'woocommerce_breadcrumb', 11 );
}

$grid_list_enable = liquid_helper()->get_theme_option( 'wc-archive-grid-list' );
if( 'on' === $grid_list_enable ) {
	add_action( 'woocommerce_before_shop_loop', 'liquid_woocommere_top_bar_grid_list_selector', 12 );
}

$product_categories_trigger_enable = liquid_helper()->get_theme_option( 'wc-archive-show-product-cats' );
if( 'on' === $product_categories_trigger_enable ) {
	add_action( 'woocommerce_before_shop_loop', 'liquid_woo_top_bar_product_categories_trigger', 13 );
}

$product_show_limit_enable = liquid_helper()->get_theme_option( 'wc-archive-show-number' );
if( 'on' === $product_show_limit_enable ) {
	add_action( 'woocommerce_before_shop_loop', 'liquid_woo_top_bar_show_products', 12 );
}


$sorterby_enable = liquid_helper()->get_theme_option( 'wc-archive-sorter-enable' );
if( 'off' === $sorterby_enable ) {
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
}
$result_count_enable = liquid_helper()->get_theme_option( 'wc-archive-result-count' );
if( 'off' === $result_count_enable ) {
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
}
if( 'on' == $sorterby_enable || 'on' == $result_count_enable ) {
	add_action( 'woocommerce_before_shop_loop', 'liquid_start_sorter_counter_container', 19 );
	add_action( 'woocommerce_before_shop_loop', 'liquid_end_sorter_counter_container', 99 );
}
function liquid_woocommerce_product_loop_start_div( $ob_get_clean ) {	
	return '<div class="products row">';
}
function liquid_woocommerce_product_loop_end_div( $ob_get_clean ) {
	return '</div>';
}

$view_type = liquid_woocommerce_get_products_list_view_type();

if( 'list' == $view_type ) {
	if ( class_exists( 'YITH_WCQV_Frontend' ) ) {
		remove_action( 'woocommerce_after_shop_loop_item', array( 'YITH_WCQV_Frontend', 'yith_add_quick_view_button' ), 15 );
	}
	remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 10 );
	add_filter( 'woocommerce_product_loop_start', 'liquid_woocommerce_product_loop_start_div', 99 );
	add_filter( 'woocommerce_product_loop_end', 'liquid_woocommerce_product_loop_end_div', 99 );
	add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_single_excerpt', 75 );
	add_action( 'woocommerce_extra_buttons_item', 'liquid_add_wishlist_button', 15 );
	add_action( 'woocommerce_extra_buttons_item', 'liquid_add_quickview_button', 10 );
	add_action( 'woocommerce_extra_buttons_item', 'liquid_get_compare_button', 20 );
	add_action( 'liquid_loop_product_summary_foot', 'woocommerce_template_loop_add_to_cart', 10 );
}

$add_to_cart_ajax_enable = liquid_helper()->get_option( 'wc-add-to-cart-ajax-enable' );
if( 'on' === $add_to_cart_ajax_enable ) {
	add_filter( 'liquid_ajax_add_to_cart_single_product', '__return_true', 99 );
}

/**
 * [liquid_print_custom_header_css description]
 * @method liquid_print_custom_header_css
 * @return [type]                        [description]
 */
add_action( 'wp_head', 'liquid_print_custom_product_layout_css', 1001 );
function liquid_print_custom_product_layout_css() {
	
	global $post;
	
	$sp_custom_layout_enable = get_post_meta( get_the_ID(), 'wc-custom-layout-enable', true );

	if ( $sp_custom_layout_enable === 'on' ) {
		$sp_custom_layout = get_post_meta( get_the_ID(), 'wc-custom-layout', true );
	} elseif ( $sp_custom_layout_enable === '0' || empty( $sp_custom_layout_enable ) ) {
		$sp_custom_layout_enable = liquid_helper()->get_theme_option( 'wc-custom-layout-enable' );
		$sp_custom_layout = liquid_helper()->get_theme_option( 'wc-custom-layout' );
	}
	
	if( 'on' === $sp_custom_layout_enable && !empty( $sp_custom_layout ) ) {
		echo liquid_helper()->get_vc_custom_css( $sp_custom_layout );
	}
}
$enable_woo_image_gallery = liquid_helper()->get_option( 'wc-archive-image-gallery' );
if( 'on' !== $enable_woo_image_gallery ) {
	remove_action( 'woocommerce_before_shop_loop_item_title', 'liquid_woocommerce_template_loop_product_gallery', 12 );
}

add_action( 'wp_head', 'liquid_print_woo_cats_page_css', 1002 );
function liquid_print_woo_cats_page_css() {
	
	if( class_exists( 'WooCommerce' ) && is_product_category() || class_exists( 'WooCommerce' ) && is_product_taxonomy() ) {
		$term_id = get_queried_object_id();
		$content_id = get_term_meta( $term_id, 'liquid_page_id_content_to_cat' , true );
		if( !empty( $content_id ) ) {
			echo liquid_helper()->get_vc_custom_css( $content_id );
		}
	}
}

function liquid_get_single_media() {
	return get_template_part( 'templates/blog/single/part', 'head' );
}
function liquid_get_single_floating_box() {
	return get_template_part( 'templates/blog/single/part', 'share' );
}

add_action( 'liquid_before_single_article_content', 'liquid_single_post_start_container', 1 );
add_action( 'liquid_after_single_article_content', 'liquid_single_post_end_container', 99 );

function liquid_single_post_start_container() {
	$content = get_the_content();
	if( liquid_helper()->str_contains( '[vc_row', $content ) ) {
		return;
	}
	echo '<div class="container">';		
}

function liquid_single_post_end_container() {
	$content = get_the_content();
	if( liquid_helper()->str_contains( '[vc_row', $content ) ) {
		return;
	}
	echo '</div>';
}

add_filter( 'wp_kses_allowed_html', 'liquid_kses_allowed_html', 10, 2);
function liquid_kses_allowed_html( $tags, $context ) {
	switch( $context ) {
		case 'svg': 
			$tags = array(
				'svg' => array(
					'class'       => true,
					'xmlns'       => true,
					'width'       => true,
					'height'      => true,
					'viewbox'     => true,
					'aria-hidden' => true,
					'role'        => true,
					'focusable'   => true,
					'style'       => true,
				),
				'path'  => array(
					'fill'      => true,
					'd'         => true,
				),
			);
		return $tags;
		case 'span': 
			$tags = array(
				'span' => array(
					'class'       => true,
					'aria-hidden' => true,
					'role'        => true,
					'style'       => true,
				),
			);
		return $tags;
		case 'a': 
			$tags = array(
				'a' => array(
					'class'       => true,
					'href'        => true,
					'target'      => true,
					'style'       => true,
				),
			);
		return $tags;
		case 'lqd_post':
			$tags = array(
				'a' => array(
					'class' => array(),
					'href'  => array(),
					'rel'   => array(),
					'title' => array(),
					'target' => array(),
				),
				'abbr' => array(
					'title' => array(),
				),
				'b' => array(),
				'br' => array(),
				'blockquote' => array(
					'cite'  => array(),
				),
				'cite' => array(
					'title' => array(),
				),
				'code' => array(),
				'del' => array(
					'datetime' => array(),
					'title' => array(),
				),
				'dd' => array(),
				'div' => array(
					'class' => array(),
					'title' => array(),
					'style' => array(),
				),
				'dl' => array(),
				'dt' => array(),
				'em' => array(),
				'h1' => array(
					'class' => array(),
				),
				'h2' => array(
					'class' => array(),
				),
				'h3' => array(
					'class' => array(),
				),
				'h4' => array(
					'class' => array(),
				),
				'h5' => array(
					'class' => array(),
				),
				'h6' => array(
					'class' => array(),
				),
				'i' => array(
					'class' => array(),
					'aria-hidden' => array(),
				),
				'img' => array(
					'alt'    => array(),
					'class'  => array(),
					'height' => array(),
					'src'    => array(),
					'width'  => array(),
				),
				'li' => array(
					'class' => array(),
				),
				'ol' => array(
					'class' => array(),
				),
				'p' => array(
					'class' => array(),
					'style' => array(),
				),
				'q' => array(
					'cite' => array(),
					'title' => array(),
				),
				'span' => array(
					'class' => array(),
					'title' => array(),
					'style' => array(),
				),
				'strike' => array(),
				'strong' => array(),
				'ul' => array(
					'class' => array(),
				),
			);
		return $tags;
		case 'lqd_breadcrumb':
			$tags = array(
				'nav' => array(
					'class' => array(),
					'role'  => array(),
					'aria-label' => array(),
					'item-prop' => array(),
				),
				'div' => array(
					'class' => array(),
				),
				'ol' => array(
					'class' => array(),
				),
				'ul' => array(
					'class' => array(),
				),
				'li' => array(
					'class' => array(),
				),
				'a' => array(
					'class' => array(),
					'href'  => array(),
					'rel'   => array(),
					'title' => array(),
					'target' => array(),
				),
			);
		return $tags;
		default: 
		return $tags;
	}
}