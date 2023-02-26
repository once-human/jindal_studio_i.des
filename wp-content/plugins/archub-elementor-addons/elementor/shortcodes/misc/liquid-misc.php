<?php

/**
 * Shortcode Title: Inline Video
 * Shortcode: ld_inline_video
 */
add_shortcode( 'ld_inline_video', 'ld_inline_video' );
function ld_inline_video( $atts ) {

	// override default attributes with user attributes
	extract( shortcode_atts( array(
			'mp4'      => '',
			'style'    => null,
			'controls' => false,
			'height' => '',
			'width'  => '',
	), $atts ));

	// build output
	if( !empty( $width ) ) {
		$width = 'width="' . $width . '"';
	}
	if( !empty( $height ) ) {
		$height = 'height="' . $height . '"';
	}
	if( 'on' == liquid_helper()->get_option( 'enable-lazy-load' ) ) {
		$src = 'data-src="' . esc_url( $mp4 ) . '"';
	}
	else {
		$src = 'src="' . esc_url( $mp4 ) . '"';
	}
	$o = '';
	$o .= '<div class="lqd-inline-video"><video ' . $width . ' ' . $height . ' autoplay loop muted playsinline ';
	if ( $controls ) $o .= 'controls ';
	if( 'on' == liquid_helper()->get_option( 'enable-lazy-load' ) ) {
		$o .= 'class="ld-lazyload"';
	}	
	if ( !empty( $style ) ) 
		$o .= 'style="' . $style . '" ';
	$o .= '><source ' . $src . ' type="video/mp4" />';
	$o .= '<p>Your browser does not support the video element.</p></video></div>';

	// return output
	return $o;
}

/**
 * Shortcode Title: Icon
 * Shortcode: ld_icon
 */
add_shortcode( 'ld_icon', 'ld_sc_icon' );
function ld_sc_icon( $atts, $content = null ) {

	extract( shortcode_atts(array(
		'icon'      => false,
		'container' => false,
		'span'      => false,
		'container_class' => 'icon-container'
    ), $atts ));

	if ( ! $icon ) {
		return '';
	}

	if ( $container ) {
		return sprintf( '<span class="%2$s"><i class="%1$s"></i></span>', ld_helper()->sanitize_html_classes( $icon ), $container_class );
	}

	if ( $span ) {
		return sprintf( '<span class="%1$s"></span>', ld_helper()->sanitize_html_classes( $icon ) );
	} else {
		return sprintf( '<i class="%1$s"></i>', ld_helper()->sanitize_html_classes( $icon ) );
	}

}

/**
 * Shortcode Title: Icon
 * Shortcode: ld_icon
 */
add_shortcode( 'ld_get_cart_total', 'ld_sc_get_cart_total' );
function ld_sc_get_cart_total( $atts, $content = null ) {
	
	$total = '';
	
	if( class_exists( 'WooCommerce' ) ) {
		$total = WC()->cart->get_cart_subtotal();	
	}

	echo $total;
	
}

/**
 * Shortcode Title: Link
 * Shortcode: ld_link
 */
add_shortcode( 'ld_link', 'ld_sc_link' );
function ld_sc_link( $atts, $content = null ) {

	extract( shortcode_atts(array(
		'href'   => '#',
		'class'  => false,
		'target' => false,

    ), $atts ));
	
	if( ! empty( $class ) ) {
		$class = 'class="'. $class .'"';
	}

	if( ! empty( $target ) ) {
		$target = 'target="'. $target .'"';
	}

	return '<a '. $class .' href="'. esc_url( $href ) .'" '. $target .'  >' . do_shortcode( $content ) . '</a>';
}

/**
 * Shortcode Title: Category Title
 * Shortcode: ld_category_title
 */
add_shortcode( 'ld_category_title', 'ld_sc_category_title' );
function ld_sc_category_title( $atts, $content = null ) {
	return single_cat_title( '', false );
}

/**
 * Shortcode Title: Tag Title
 * Shortcode: ld_tag_title
 */
add_shortcode( 'ld_tag_title', 'ld_sc_tag_title' );
function ld_sc_tag_title( $atts, $content = null ) {
	return single_tag_title( '', false );
}

/**
 * Shortcode Title: Author
 * Shortcode: ld_author
 */
add_shortcode( 'ld_author', 'ld_sc_author' );
function ld_sc_author( $atts, $content = null ) {
	return get_the_author();
}

/**
 * Shortcode Title: Share post links
 * Shortcode: ld_share_links
 */
add_shortcode( 'ld_share_links', 'ld_sc_share_links' );
function ld_sc_share_links( $atts, $content = null ) {
	return liquid_portfolio_share( get_post_type(), array(), false );
}

/**
 * Shortcode Title: Typed
 * Shortcode: ld_typed
 */

add_shortcode( 'ld_typed', 'ld_sc_typed' );
function ld_sc_typed( $atts, $content = null ) {

	extract( shortcode_atts(array(

		'words' => false,

	), $atts ));
	
	if ( empty( $words ) ) {
		return;
	}

	$out = '';
	$words = explode( '|', $words );
	
	$out .= '<span class="typed-keywords">';
	$i = 1;
	foreach ( $words as $word ) {
		$active = ( $i == 1 ) ? ' active' : '';
		$out .= '<span class="keyword' . $active . '">' . $word . '</span>';
		$i++;
	}
	$out .= '</span>';
	
	return $out;
	
}

/**
 * Shortcode Title: Typed String
 * Shortcode: ld_string
 */
add_shortcode( 'ld_string', 'ld_sc_string' );
function ld_sc_string( $atts, $content = null ) {
	
	extract( shortcode_atts( array(
		
		'words' => false,
		
	), $atts ));

	if ( empty( $words ) ) {
		return;
	}
	
	$out = '';
	$words = explode( '|', $words );
	
	$out .= '<span class="typed-strings">';
	foreach ( $words as $word ) {
		$out .= '<span>' . $word . '</span>';
	}
	$out .= '</span>';

	return $out;	

}


/**
 * Shortcode Title: DropCap
 * Shortcode: ld_dropcap
 */
add_shortcode( 'ld_dropcap', 'ld_sc_dropcap' );
function ld_sc_dropcap( $atts, $content = null ) {

	return '<span class="dropcap">' . esc_html( $content ) . '</span>';
}

/**
 * Shortcode Title: Highlight
 * Shortcode: ld_highlight
 */
add_shortcode( 'ld_highlight', 'ld_sc_highlight' );
function ld_sc_highlight( $atts, $content = null ) {
	
	extract( shortcode_atts( array(
		'color'          => '',
		'font_size'      => '',
		'letter_spacing' => '',
		'margin'         => '',
		'padding'        => '',
	), $atts ) );
	
	
	$style = '';
	$style_atts = array();
	
	if( !empty( $color ) || !empty( $font_size ) || !empty( $letter_spacing ) || !empty( $margin ) || !empty( $padding ) ) {
		
		$style_atts[] = !empty( $color ) ? 'color:' . $color .';': '';
		$style_atts[] = !empty( $font_size ) ? 'font-size:' . $font_size .';' : '';	
		$style_atts[] = !empty( $letter_spacing ) ? 'letter-spacing:' . $letter_spacing .';' : '';
		$style_atts[] = !empty( $margin ) ? 'margin:' . $margin .';' : '';
		$style_atts[] = !empty( $padding ) ? 'padding:' . $padding .';' : '';
		
		$style = 'style="' . implode( ' ', $style_atts ) . '"';
	}

	return '<mark class="lqd-highlight"><span class="lqd-highlight-txt" ' . $style . ' >' . esc_html( $content ) . '</span><span class="lqd-highlight-inner">' . get_underline_svg() . '</span></mark>';

}


/**
 * Shortcode Title: Span
 * Shortcode: ld_span
 */
add_shortcode( 'ld_span', 'ld_sc_span' );
function ld_sc_span( $atts, $content = null ) {
	
	extract( shortcode_atts( array(
		'color' => '',
		'opacity' => '',
		'font_size' => '',
		'font_weight' => '',
		'text_decoration' => '',
	), $atts ) );
	
		
	$style = '';
	$style_atts = array();
	
	if( !empty( $color ) || !empty( $text_decoration ) || !empty( $opacity ) || !empty( $font_size ) || !empty( $font_weight ) ) {
		
		$style_atts[] = !empty( $color ) ? 'color:' . $color .';': '';
		$style_atts[] = !empty( $opacity ) ? 'opacity:' . $opacity .';': '';
		$style_atts[] = !empty( $font_size ) ? 'font-size:' . $font_size .';' : '';	
		$style_atts[] = !empty( $font_weight ) ? 'font-weight:' . $font_weight .';' : '';	
		$style_atts[] = !empty( $text_decoration ) ? 'text-decoration:' . $text_decoration .';' : '';	
		
		$style = 'style="' . implode( ' ', $style_atts ) . '"';
	}

	return '<span ' . $style . '>' . esc_html( $content ) . '</span>';
}
/**
 * Shortcode Title: Strong
 * Shortcode: ld_strong
 */
add_shortcode( 'ld_strong', 'ld_sc_strong' );
function ld_sc_strong( $atts, $content = null ) {
	
	extract( shortcode_atts( array(
		'color' => '',
		'opacity' => '',
		'font_size' => '',
		'font_weight' => '',
		'text_decoration' => '',
	), $atts ) );
	
		
	$style = '';
	$style_atts = array();
	
	if( !empty( $color ) || !empty( $text_decoration ) || !empty( $opacity ) ) {
		
		$style_atts[] = !empty( $color ) ? 'color:' . $color .';': '';
		$style_atts[] = !empty( $opacity ) ? 'opacity:' . $opacity .';': '';
		$style_atts[] = !empty( $font_size ) ? 'font-size:' . $font_size .';' : '';	
		$style_atts[] = !empty( $font_weight ) ? 'font-weight:' . $font_weight .';' : '';	
		$style_atts[] = !empty( $text_decoration ) ? 'text-decoration:' . $text_decoration .';' : '';	
		
		$style = 'style="' . implode( ' ', $style_atts ) . '"';
	}

	return '<strong ' . $style . '>' . esc_html( $content ) . '</strong>';
}

/**
 * Shortcode Title: Span
 * Shortcode: ld_span
 */
add_shortcode( 'ld_small', 'ld_sc_small' );
function ld_sc_small( $atts, $content = null ) {
	
	extract( shortcode_atts( array(
		'color' => '',
		'opacity' => '',
		'font_size' => '',
		'font_weight' => '',
		'text_decoration' => '',
	), $atts ) );
	
	
	if( ! empty( $color ) ) {
		
		return '<small style="color:' . esc_attr( $color ) . '">' . esc_html( $content ) . '</small>';
	}
	
	return '<small>' . esc_html( $content ) . '</small>';
}

/**
 * Shortcode Title: Break
 * Shortcode: ld_br
 */
add_shortcode( 'ld_br', 'ld_sc_break' );
function ld_sc_break( $atts, $content = null ) {

	return '<br />';
}

//Header Row Shortcode 
add_shortcode( 'ld_header_row', 'ld_header_row_shortcode' );
//add_shortcode( 'ld_header_row_inner', 'ld_header_row_shortcode' );
function ld_header_row_shortcode( $atts, $content ) {

	extract( shortcode_atts( array(

		'header_full_width'   => '',
		'hide_on_sticky'      => '',
		'show_on_sticky'      => '',
		'sticky_bar'          => '',
		'stickybar_placement' => '',
		'fullscreen_nav'      => '',
		'fn_bg'               => '',
		'fn_border_color'     => '',
		'css'                 => '',
		'bg_position'         => '',
		'responsive_css'      => '',
		'row_box_shadow'      => '',
		'custom_border_radius' => '',
		'gradient_bg'         => '',
		'el_id'               => '',
		'el_class'            => '',

	), $atts ) );

	$output = $shadow_box_id = $trigger = $responsive_id = $shadow_css = $responsive_style = $border_radius_style = '';
	$container = 'container';
	
	$wrapper_attributes = array();
	
	if( $header_full_width ) {
		$container = 'container-fluid';
	}
	
	$row_box_shadow = vc_param_group_parse_atts( $row_box_shadow );
	if( !empty( $row_box_shadow ) ) {
		$shadow_box_id = uniqid('liquid-header-shadowbox-');
		$shadow_css    = liquid_get_shadow_css( $row_box_shadow, $shadow_box_id );
	}

	$the_id = $bg_styles = $fn_bg_styles = $fn_border_styles = '';
	if ( ! empty( $el_id ) ) {
		$the_id = 'id="' . esc_attr( $el_id ) . '"';
	}
	
	if( !empty( $fn_bg ) ) {
		$fn_bg_styles = '.navbar-fullscreen .lqd-fsh-bg-side-container span, .navbar-fullscreen .lqd-fsh-bg-col span { background: ' . $fn_bg . ' !important; }';
	}
	if( !empty( $fn_border_color ) ) {
		$fn_border_styles = '.navbar-fullscreen .lqd-fsh-bg-side-container:before, .navbar-fullscreen .lqd-fsh-bg-col:before { background: ' . $fn_border_color . ' !important; }';
	}
	

	if( 'custom' != $bg_position && ! empty( $bg_position ) ) {
		$bg_styles = ' background-position:' . esc_attr( $bg_position ) . ' !important;';
	} 
	elseif( 'custom' === $bg_position ) {
		$bg_styles = ' background-position:' . esc_attr( $bg_pos_h ) . ' ' . esc_attr( $bg_pos_v ) . ' !important; ';
	}

	if( !empty( $gradient_bg ) ) {
		$bg_styles = ' background:' . esc_attr( $gradient_bg ) . '; ';
	}

	if( !empty( $custom_border_radius ) ) {
		$border_radius_style = 'border-radius:' . esc_attr( $custom_border_radius ) . ';';
	}
	
	$wrapper_attributes[] = 'style="' . esc_attr( trim( $bg_styles . $border_radius_style  ) ) . '"';
	
	if( $sticky_bar ) {
		$classes = array(

			'lqd-stickybar-wrap', 
			$stickybar_placement,

			$hide_on_sticky,
			$show_on_sticky,

			$el_class,
			vc_shortcode_custom_css_class( $css ),
			$shadow_box_id
		);
	}
	else {
		$classes = array(
			'lqd-head-sec-wrap', 
			'pos-rel',
			$hide_on_sticky,
			$show_on_sticky,
			$el_class,
			vc_shortcode_custom_css_class( $css ),
			$shadow_box_id
		);
	}
	
	if( !empty( $responsive_css ) ) {
		$responsive_id = uniqid( 'liquid-row-responsive-' );
		$responsive_style = Liquid_Responsive_Css_Editor::generate_css( $responsive_css, $responsive_id );
		$classes[] = $responsive_id;
	}
	
	if( !liquid_helper()->str_contains( 'ld_header_image', $content ) ) {
		
		$src = $retina_src = $retina_logo = $logo = $scrset = '';
		
		$img_array    = liquid_helper()->get_option( 'menu-logo' );
		if( empty( $img_array['url'] ) ) {
			$img_array = liquid_helper()->get_option( 'header-logo' ); 
		}
		$retina_array = liquid_helper()->get_option( 'menu-logo-retina' );
		$src = esc_url( $img_array['url'] );
		
		if( is_array( $retina_array ) && !empty( $retina_array['url'] ) ) {
			$retina_src = esc_url( $retina_array['url'] );
		}
		else {
			$retina_src = '';
		}
		
		if( empty( $src ) ) {
			$src = get_template_directory_uri() . '/assets/img/logo/logo-dark.svg';
		}
		
		if( !empty( $retina_src ) ) {
			$scrset	= 'srcset="' . $retina_src . ' 2x"';	
		}
		
		$alt = get_bloginfo( 'title' );
		$image = sprintf( '<img class="mobile-logo-default" src="%s" alt="%s" %s />', $src, $alt, $scrset );
		
	}
	
	if ( !empty( $shadow_css ) || !empty( $responsive_style ) || !empty( $fn_bg_styles ) || !empty( $fn_border_styles ) ) {
		$output .= '<style>' . $shadow_css . ' ' . $responsive_style .' ' . $fn_bg_styles . ' ' . $fn_border_styles . '</style>';
	}
	
	if( $sticky_bar ) {

		$output .= '<div ' . $the_id . ' class="' . join( ' ', $classes ) . '">
						<div class="lqd-stickybar">';
		$output .=					do_shortcode( $content );		
		$output .= '	</div>';
		$output .= '</div>';

		
	}
	elseif( $fullscreen_nav ) {
	
		$output .= '<div class="navbar-fullscreen" id="' . ( !empty( $el_id ) ? $el_id : 'main-header-collapse' ) . '">
						<div class="lqd-fsh-bg">
							<div class="lqd-fsh-bg-side-container lqd-fsh-bg-before-container">
								<span></span>
							</div>
							<div class="container lqd-fsh-bg-container px-0">
								<div class="row lqd-fsh-bg-row mx-0">
									<div class="col-md-3 px-0 lqd-fsh-bg-col">
										<span></span>
									</div>
									<div class="col-md-3 px-0 lqd-fsh-bg-col">
										<span></span>
									</div>
									<div class="col-md-3 px-0 lqd-fsh-bg-col">
										<span></span>
									</div>
									<div class="col-md-3 px-0 lqd-fsh-bg-col">
										<span></span>
									</div>
								</div>
							</div>
							<div class="lqd-fsh-bg-side-container lqd-fsh-bg-after-container">
								<span></span>
							</div>
						</div>
					
						<div class="header-modules-container">
							<div class="container">
								<div class="row">';
			$output .=				do_shortcode( $content );		
			$output .= '		</div>
							</div>
						</div>
					</div>';
				
	
		
	}
	else {
	
		$output .= '<div ' . $the_id . ' class="' . join( ' ', $classes ) . '" ' . implode( ' ', $wrapper_attributes ) . '>
						<div class="' . $container . ' lqd-head-container d-flex flex-wrap align-items-stretch">
							<div class="lqd-head-sec d-flex flex-column w-100">
								<div class="row lqd-head-row d-flex align-items-stretch">';
		$output .=					do_shortcode( $content );
		$output .= '			</div>';
		$output .= '		</div>';
		$output .= '	</div>';
		$output .= '</div>';

	
	}
	
	return $output;
	
}

//Header Columns Shortcode
add_shortcode( 'ld_header_column', 'ld_header_column_shortcode' );
//add_shortcode( 'ld_header_column_inner', 'ld_header_column_shortcode' );
function ld_header_column_shortcode( $atts, $content = null ) {
	
	extract( shortcode_atts( array(
		'align'            => '',
		'responsive_align' => '',
		'header_col_width' => 'col',
		'bg_position'      => '',
		'css'              => '',
		'el_id'            => '',
		'el_class'         => '',
	), $atts ) );
	
	$classes = array(
		$header_col_width,
		'lqd-head-col',
		vc_shortcode_custom_css_class( $css ),
		$el_class
	);
	
	$wrapper_attributes = array();
	$the_id = $bg_styles = '';
	if ( ! empty( $el_id ) ) {
		$the_id = 'id="' . esc_attr( $el_id ) . '"';
	}
	
	if( !empty( $align ) ) {
		$classes[] = $align;
	}
	if( !empty( $responsive_align ) ) {
		$classes[] = $responsive_align;
	}
	
	if( 'custom' != $bg_position && ! empty( $bg_position ) ) {
		$bg_styles = ' background-position:' . esc_attr( $bg_position ) . ' !important;';
	} 
	elseif( 'custom' === $bg_position ) {
		$bg_styles = ' background-position:' . esc_attr( $bg_pos_h ) . ' ' . esc_attr( $bg_pos_v ) . ' !important; ';
	}
	
	if( !empty( $bg_styles ) ) {
		$wrapper_attributes[] = 'style="' . esc_attr( trim( $bg_styles  ) ) . '"';
	}
	
	$output = '';
	
	$output .= '<div ' . $the_id . ' class="' . implode( ' ', $classes ) . '" ' . implode( ' ', $wrapper_attributes ) . '>';
	$output .=	do_shortcode( $content );		
	$output .= '</div>';
	
	return $output;
	
}

//Megamenu Columns Shortcode
add_shortcode( 'ld_megamenu_column', 'ld_megamenu_column_shortcode' );
function ld_megamenu_column_shortcode( $atts, $content = null ) {
	
	extract( shortcode_atts( array(
		'align'            => '',
		'responsive_align' => '',
		'offset'           => '',
		'width'            => '',
		'css'              => ''
	), $atts ) );

	$width = wpb_translateColumnWidthToSpan( $width );
	$width = vc_column_offset_class_merge( $offset, $width );

	$classes = array(
		'megamenu-column',
		$width,
		vc_shortcode_custom_css_class( $css ),
	);
	
	if( !empty( $align ) ) {
		$classes[] = $align;
	}
	if( !empty( $responsive_align ) ) {
		$classes[] = $responsive_align;
	}
	
	$output = '';
	
	$output .= '<div class="' . implode( ' ', $classes ) . '">';
	$output .=	do_shortcode( $content );		
	$output .= '</div>';
	
	return $output;
	
}

//Megamenu Columns Shortcode
add_shortcode( 'ld_megamenu_row', 'ld_megamenu_row_shortcode' );
function ld_megamenu_row_shortcode( $atts, $content = null ) {
	
	extract( shortcode_atts( array(
		'css'              => ''
	), $atts ) );

	$classes = array(
		'vc_row',
		'megamenu-inner-row',
		vc_shortcode_custom_css_class( $css ),
	);
	
	if( !empty( $align ) ) {
		$classes[] = $align;
	}
	if( !empty( $responsive_align ) ) {
		$classes[] = $responsive_align;
	}
	
	$output = '';
	
	$output .= '<div class="' . implode( ' ', $classes ) . '">';
	$output .=	do_shortcode( $content );		
	$output .= '</div>';
	
	return $output;
	
}
function get_underline_svg() {
	return '<svg class="lqd-highlight-brush-svg lqd-highlight-brush-svg-1" xmlns="http://www.w3.org/2000/svg" width="235.509" height="13.504" viewBox="0 0 235.509 13.504" aria-hidden="true" preserveAspectRatio="none"><path d="M163,.383a13.044,13.044,0,0,1,1.517-.072,3.528,3.528,0,0,1,1.237-.134q.618.044,1.237.044a.249.249,0,0,1-.1.178.337.337,0,0,0-.1.266q3.092.088,6.184-.044T178.953.4l-.206-.088a12,12,0,0,0,4.123,0,13.467,13.467,0,0,1,5.772,0q1.443-.178,2.68-.266A5.978,5.978,0,0,1,193.8.4,16.707,16.707,0,0,1,198.01.045q2.164.088,4.844.088-.618.088-.824.134L201.412.4a3.893,3.893,0,0,0,2.061,0,5.413,5.413,0,0,1,1.649-.356q.618.088,1.134.178a9.762,9.762,0,0,0,1.544.09,17,17,0,0,1,3.092-.266q1.649,0,3.5.178,2.886.088,5.875.044t5.875-.222q0,.088.206.088h.412a21.975,21.975,0,0,0,2.577.889A12.458,12.458,0,0,1,232.12,2.18a3.962,3.962,0,0,1,1.031.622A3.349,3.349,0,0,1,234.8,3.825a5.079,5.079,0,0,1,.618,1.111q.412.534-1.031.98-1.031.444-.618.98a2.09,2.09,0,0,1,.206.889q0,.444.825.889.618.8-.206,1.245l-1.237.534q-1.443-.088-2.68-.134a17.255,17.255,0,0,1-2.267-.222,3.128,3.128,0,0,0-.928-.044,3.129,3.129,0,0,1-.928-.044q-2.267-.178-4.432-.266T217.7,9.476q-1.649-.088-2.886-.088a17.343,17.343,0,0,1-2.474-.178q-3.916,0-7.73-.088t-7.73-.266l-12.471-.178q-6.287-.088-12.883-.088h-1.958q-.928,0-1.958.088h-2.061q-1.031,0-2.061-.088-2.68-.088-5.256-.134t-5.256.044h-5.462q-2.577,0-5.462.088-4.535.088-8.76.178t-8.554.088q-2.886.088-5.875.088t-5.875.088q-1.443.088-2.886.134t-3.092.044q-4.741.178-9.791.312t-9.791.312q-2.267.088-4.329.088T78.77,10.1q-4.329.266-8.863.49t-9.276.49q-1.237.088-2.68.134a24.356,24.356,0,0,0-2.683.224q-2.68.178-5.462.312t-5.668.4q-2.474.266-4.741.312t-4.741.044q-1.031-.088-1.958-.134a9.684,9.684,0,0,1-1.958-.312,12.5,12.5,0,0,0-1.443-.312q-.825-.134-1.856-.31-2.886.356-6.39.666t-6.8.845a26.709,26.709,0,0,1-2.886.356,20.758,20.758,0,0,1-9.482-.889Q.232,11.962.026,11.25T1.263,9.917q0-.266.825-.266a13.039,13.039,0,0,0,2.886-.444A17.187,17.187,0,0,1,7.86,8.672q3.092-.266,6.184-.8,1.649-.178,3.3-.312t3.5-.312q4.123-.354,8.039-.712t8.039-.622q9.478-.8,18.758-1.338,2.68-.178,5.153-.356t4.741-.356q2.474-.178,5.05-.356T75.88,3.24h1.34a4.829,4.829,0,0,0,1.34-.178q2.267-.178,4.329-.222t4.329-.134a7.256,7.256,0,0,1,2.267,0,3.459,3.459,0,0,0,1.031-.088,6.009,6.009,0,0,1,2.37-.266,14.745,14.745,0,0,0,2.783-.088q1.649,0,2.474.088a1.308,1.308,0,0,1,.185.011,1.226,1.226,0,0,1,.33-.1,3.656,3.656,0,0,0,.515-.088,4.433,4.433,0,0,1,2.886.266q.412-.088,1.031-.178l1.237-.178q.412,0,1.031.044a5.761,5.761,0,0,0,1.237-.044q2.886-.088,5.772-.044a53.829,53.829,0,0,0,5.772-.222,9.505,9.505,0,0,1,1.34-.088h1.34a4.428,4.428,0,0,1,.821-.258l.825-.178a15.178,15.178,0,0,1,1.855.444,3.028,3.028,0,0,1,1.031-.534,4.039,4.039,0,0,1,1.443-.178,6.158,6.158,0,0,1,1.649.178,5.05,5.05,0,0,0,2.267.268q1.855-.088,3.813-.134T138.13,1.2q1.031,0,2.164-.044t2.37-.044q-.206-.088.412-.534h3.092q.412,0,.309.266t.928,0a5.845,5.845,0,0,1,1.443,0,31.833,31.833,0,0,0,5.359.088,21.471,21.471,0,0,1,6.8.178,5.236,5.236,0,0,0,1.031-.4q.412-.222.825-.4a.694.694,0,0,1,.137.07Z" transform="translate(0 0.002)"/></svg><svg class="lqd-highlight-pen" width="51" height="51" viewBox="0 0 51 51" xmlns="http://www.w3.org/2000/svg"><path d="M36.204 1.044C32.02 2.814 5.66 31.155 4.514 35.116c-.632 2.182-1.75 5.516-2.483 7.409-3.024 7.805-1.54 9.29 6.265 6.265 1.893-.733 5.227-1.848 7.41-2.477 3.834-1.105 4.473-1.647 19.175-16.27 0 0 10.63-10.546 15.21-15.125C53 8.997 42.021-1.418 36.203 1.044Zm7.263 5.369c3.56 3.28 4.114 4.749 2.643 6.995l-1.115 1.7-4.586-4.543-4.585-4.544 1.42-1.157C39.311 3.18 40.2 3.4 43.467 6.413ZM37.863 13.3l4.266 4.304-11.547 11.561-11.547 11.561-4.48-4.446-4.481-4.447 11.404-11.418c6.273-6.28 11.566-11.42 11.762-11.42.197 0 2.277 1.938 4.623 4.305ZM12.016 39.03l3.54 3.584-3.562 1.098-5.316 1.641c-1.665.516-1.727.455-1.211-1.21l1.614-5.226c1.289-4.177.685-4.191 4.935.113Z"/></svg><svg class="lqd-highlight-brush-svg lqd-highlight-brush-svg-2" width="233" height="13" viewBox="0 0 233 13" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="none"><path d="m.624 9.414-.312-2.48C0 4.454.001 4.454.002 4.454l.035-.005.102-.013.398-.047c.351-.042.872-.102 1.557-.179 1.37-.152 3.401-.368 6.05-.622C13.44 3.081 21.212 2.42 31.13 1.804 50.966.572 79.394-.48 113.797.24c34.387.717 63.927 2.663 84.874 4.429a1048.61 1048.61 0 0 1 24.513 2.34 641.605 641.605 0 0 1 8.243.944l.432.054.149.02-.318 2.479-.319 2.48-.137-.018c-.094-.012-.234-.03-.421-.052a634.593 634.593 0 0 0-8.167-.936 1043.26 1043.26 0 0 0-24.395-2.329c-20.864-1.76-50.296-3.697-84.558-4.413-34.246-.714-62.535.332-82.253 1.556-9.859.612-17.574 1.269-22.82 1.772-2.622.251-4.627.464-5.973.614a213.493 213.493 0 0 0-1.901.22l-.094.01-.028.004Z"/></svg>';
}