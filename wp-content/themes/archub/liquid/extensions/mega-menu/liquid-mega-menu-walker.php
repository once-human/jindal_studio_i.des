<?php
/**
 * The Menu Walker
 * Menu Walker class extends from Nav Menu Walker
*/

if( ! defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly

class Liquid_Mega_Menu_Walker extends Walker_Nav_Menu {

	/**
     * Starts the list before the elements are added.
     *
     * @since 3.0.0
     *
     * @see Walker::start_lvl()
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of wp_nav_menu() arguments.
     */
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"nav-item-children\">\n";
    }

	/**
     * @see Walker::start_el()
     */
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

		$item_html = $is_fullwidth = $badge_color = '';//$args->link_after = $args->link_before = '';
		
		if ( !isset( $args->link_before )){
			return;
		}

		$args->link_before = '';
		if( $item->hasChildren || !empty( $item->liquid_megaprofile ) ) {
			$args->link_after = '<span class="submenu-expander"><svg xmlns="http://www.w3.org/2000/svg" width="21" height="32" viewBox="0 0 21 32" style="width: 1em; height: 1em;"><path fill="currentColor" d="M10.5 18.375l7.938-7.938c.562-.562 1.562-.562 2.125 0s.562 1.563 0 2.126l-9 9c-.563.562-1.5.625-2.063.062L.437 12.562C.126 12.25 0 11.876 0 11.5s.125-.75.438-1.063c.562-.562 1.562-.562 2.124 0z"></path></svg></span>';
		}
		else {
			$args->link_after = '';
		}

		if( '[divider]' === $item->title ) {
			$output .= '<li class="menu-item-divider"></li>';
			return;
		}

		if( !empty( $item->liquid_megaprofile ) ) {
			if ( class_exists( 'Liquid_Elementor_Addons' ) && defined( 'ELEMENTOR_VERSION' ) ){
				$page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers( 'page' );
				$page_settings_model = $page_settings_manager->get_model( $item->liquid_megaprofile );
				$is_fullwidth = $page_settings_model->get_settings( 'megamenu_fullwidth' );
			} else {
				$is_fullwidth = get_post_meta( $item->liquid_megaprofile, 'megamenu-fullwidth', true );
			}
			if( 'yes' === $is_fullwidth ) {
				$item->classes[] = 'megamenu menu-item-has-children megamenu-fullwidth';
			}
			else {
				$item->classes[] = 'megamenu menu-item-has-children';
			}
		}
		
		if( ! empty( $args->local_scroll ) && $depth === 0 ) {
			$item->classes[] = 'local-scroll' ;
		}

		if( 'submenu-dark' === $item->liquid_submenu_color ) {
			$item->classes[] = 'submenu-dark';
		}
		elseif( 'nav-item-children-style2' === $item->liquid_submenu_color ) {
			$item->classes[] = 'nav-item-children-style2';
		}
		
		if( $item->thumbnail_id ) {
			$item->liquid_icon = '';
			
			$icon_src = wp_get_attachment_url( $item->thumbnail_id );
			$filetype = wp_check_filetype( $icon_src );
			if( 'svg' === $filetype['ext'] ) {
				add_filter( 'https_ssl_verify', '__return_false' );
				$request  = wp_remote_get( $icon_src );
				$response = wp_remote_retrieve_body( $request );
				$custom_icon = $response;
			} else {
				$custom_icon = wp_get_attachment_image( $item->thumbnail_id, 'full', false, array( 'class' => 'liquid-custom-image-icon' ) );
			}
			
			if( 'left' === $item->liquid_icon_position ) {
				$args->old_link_before = $args->link_before;
				$args->link_before = '<span class="link-icon d-inline-flex align-items-center hide-if-empty left-icon">' . $custom_icon . '</span>' . $args->link_before;
			} 
			elseif( 'center' === $item->liquid_icon_position ) {
				$item->classes[] = 'center-icon';
				$args->old_link_before = $args->link_before;
				$args->link_before = '<span class="link-icon d-inline-flex align-items-center hide-if-empty center-icon">' . $custom_icon . '</span>' . $args->link_before;
			}
			else {
				$args->old_link_after = $args->link_after;
				$args->link_after = $args->link_after . '<span class="link-icon d-inline-flex align-items-center hide-if-empty right-icon">' . $custom_icon . '</span>';			
			}
		}
		
		
		if( ! empty( $item->liquid_icon ) ) {
			if( 'left' === $item->liquid_icon_position ) {
				$args->old_link_before = $args->link_before;
				$args->link_before = '<span class="link-icon d-inline-flex align-items-center hide-if-empty left-icon"><i class="'. esc_attr( $item->liquid_icon ) .'"></i></span>' . $args->link_before;
			} 
			elseif( 'center' === $item->liquid_icon_position ) {
				$item->classes[] = 'center-icon';
				$args->old_link_before = $args->link_before;
				$args->link_before = '<span class="link-icon d-inline-flex align-items-center hide-if-empty center-icon"><i class="'. esc_attr( $item->liquid_icon ) .'"></i></span>' . $args->link_before;
			}
			else {
				$args->old_link_after = $args->link_after;
				$args->link_after = $args->link_after . '<span class="link-icon d-inline-flex align-items-center hide-if-empty right-icon"><i class="'. esc_attr( $item->liquid_icon ) .'"></i></span>';				
			}
		}
		
		if( ! empty( $item->liquid_counter ) ) {
			$args->old_link_after = $args->link_after;
			$args->link_after = $args->link_after . '<sup class="link-sup">' . esc_html( $item->liquid_counter ) . '</sup>';
		}
		
		

		if( !empty( $args->caret_visibility ) && ( $item->hasChildren || !empty( $item->liquid_megaprofile ) ) ) {
			$args->old_link_after = $args->link_after;
			$args->link_after = $args->link_after . '<i class="lqd-icn-ess icon-ion-ios-arrow-down"></i>';
		}
		
		if( !empty( $item->liquid_badge ) ) {
			$args->old_link_after = $args->link_after;			
			$badge_color = !empty( $item->liquid_color ) ? 'style="--badge-color: ' . $item->liquid_color . ';"' : '';
			$args->link_after = $args->link_after . '<span class="link-badge" ' . $badge_color . ' >'. esc_html( $item->liquid_badge ) . '</span>';
		}

		if ( !empty($args->item_separator) ) {
			STATIC $item_separator_counter = 0;
			if ( $item_separator_counter++ ){
				if ( $depth == 0 ){ // check dropdown
					$args->old_link_before = $args->link_before;
					$args->link_before = $args->link_before . '<span class="link-sep">' .  $args->item_separator . '</span>';
				}
			}
		}

		if( isset( $args->nav_style ) && 'onepage' === $args->nav_style ) {
			$item->classes[] = 'local-scroll';
		}
		
        parent::start_el( $item_html, $item, $depth, $args, $id );
        
		if( 'yes' === $item->liquid_heading_item ) {
			$item_html = str_replace( '</a>', '</h5>', $item_html );
			$item_html = preg_replace( '/<a(.*?)href="(.*?)"(.*?)>/', '<h5>', $item_html );
		}

		if( !empty( $args->old_link_before ) ) {
			$args->link_before = $args->old_link_before;
			$args->old_link_before = '';
		}

		if( !empty( $args->old_link_after ) ) {
			$args->link_after = $args->old_link_after;
			$args->old_link_after = '';
		}

		if( !empty( $item->liquid_megaprofile ) ) {
			$item_html .= $this->get_megamenu( $item->liquid_megaprofile );
		}

		$output .= $item_html;
	}

	function get_megamenu( $id ) {

		$css = liquid_helper()->get_vc_custom_css( $id );

		$bg = $style = '';
		
		if( !empty( $id ) ) {
			$page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers( 'page' );
			$page_settings_model = $page_settings_manager->get_model( $id );
			$bg_type = $page_settings_model->get_settings( 'megamenu_bg_background' );
			$color = $page_settings_model->get_settings( 'megamenu_bg_color' );
			$megamenu_width = $page_settings_model->get_settings( 'megamenu_width' );
			if ( $bg_type === 'classic' && ! empty( $color ) ) {
				$bg = 'background-color: ' . $color . ';';
			} else if ( $bg_type === 'gradient' ) {
				$gradient_type = $page_settings_model->get_settings( 'megamenu_bg_gradient_type' );
				$gradient_angle = $page_settings_model->get_settings( 'megamenu_bg_gradient_angle' )['size'];
				$gradient_color_a_stop = $page_settings_model->get_settings( 'megamenu_bg_color_stop' )['size'];
				$gradient_color_b = $page_settings_model->get_settings( 'megamenu_bg_color_b' );
				$gradient_color_b_stop = $page_settings_model->get_settings( 'megamenu_bg_color_b_stop' )['size'];
				
				$bg = 'background-color: ' . $color . '; background: ' . $gradient_type . '-gradient(' . $gradient_angle . 'deg, ' . $color . ' ' . $gradient_color_a_stop . '%, ' . $gradient_color_b . ' ' . $gradient_color_b_stop . '%);';
			}
		}

		$style .= 'style="';

		if ( !empty($bg) ) {
			$style .= $bg;
		}

		if ( !empty($megamenu_width['size']) ) {
			$style .= 'max-width: ' . $megamenu_width['size'] . $megamenu_width['unit'] . '';
		}
		
		$style .= '"';
		
		return $css . '<div class="nav-item-children"><div class="lqd-megamenu-rows-wrap megamenu-container container" '. $style . '>' . \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $id )  . '</div></div>';

	}

	function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {

		// check whether this item has children, and set $item->hasChildren accordingly
		$element->hasChildren = isset( $children_elements[$element->ID] ) && !empty( $children_elements[$element->ID] );

		return parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
	}
}
