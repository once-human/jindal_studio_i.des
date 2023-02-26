<?php
// Widget options
switch ( $element_name ) {
    case 'container':
    case 'section':
        $widget_options = array(
            'lqdsep-sticky-section' => array(
                'conditions' => $element->get_settings( 'lqd_sticky_row' ) === 'lqd-css-sticky'
            ),
            'lqdsep-svg-divider-base' => array(
                'conditions' =>
                    $element->get_settings( 'shape_divider_top' ) !== '' ||
                    $element->get_settings( 'shape_divider_bottom' ) !== ''
            ),
            'lqdsep-section-scroll-base' => array(
                'conditions' =>
                    $element->get_settings( 'lqd_section_scroll' ) === 'yes'
            ),
            'lqdsep-header-stickybar-base' => array(
                'conditions' => $element->get_settings( 'sticky_bar' ) === 'yes'
            ),
            'lqdsep-header-stickybar-left' => array(
                'conditions' =>
                    $element->get_settings( 'sticky_bar' ) === 'yes' &&
                    $element->get_settings( 'stickybar_placement' ) === 'lqd-stickybar-left' ||
                    empty( $element->get_settings( 'stickybar_placement' ) )
            ),
            'lqdsep-header-stickybar-right' => array(
                'conditions' =>
                    $element->get_settings( 'sticky_bar' ) === 'yes' &&
                    $element->get_settings( 'stickybar_placement' ) === 'lqd-stickybar-right'
            ),
            'lqdsep-header-sticky-hide-onstuck' => array(
                'conditions' =>
                    $element->get_settings( 'hide_on_sticky' ) === 'lqd-hide-onstuck' &&
                    empty( $element->get_settings( 'show_on_sticky' ) )
            ),
            'lqdsep-header-sticky-show-onstuck' => array(
                'conditions' =>
                    $element->get_settings( 'show_on_sticky' ) === 'lqd-show-onstuck' &&
                    empty( $element->get_settings( 'hide_on_sticky' ) )
            ),
            'lqdsep-animated-borders-base' => array( 'conditions' => $element->get_settings( 'enable_animated_borders' ) === 'yes' ),
            'lqdsep-animated-borders-section' => array( 'conditions' => $element->get_settings( 'enable_animated_borders' ) === 'yes' ),
            'lqdsep-js-append-template' => array(
                'type' => 'js',
                'conditions' => $element->get_settings( 'enable_animated_borders' ) === 'yes'
            ),
            'lqdsep-js-fastdom-base' => array(
                'type' => 'js',
                'conditions' =>
                    $element->get_settings( 'lqd_section_scroll' ) === 'yes'
            ),
        );
        break;
    case 'column':
        $widget_options = array(
            'lqdsep-sticky-column' => array( 'conditions' => $element->get_settings( 'enable_sticky_column' ) === 'yes' ),
            'lqdsep-animated-borders-base' => array( 'conditions' => $element->get_settings( 'enable_animated_borders' ) === 'yes' ),
            'lqdsep-animated-borders-column' => array( 'conditions' => $element->get_settings( 'enable_animated_borders' ) === 'yes' ),
            'lqdsep-js-append-template' => array(
                'type' => 'js',
                'conditions' => $element->get_settings( 'enable_animated_borders' ) === 'yes'
            ),
        );
        break;
    case 'ld_header_cart':
        $widget_options = array(
            'lqdsep-header-module-trigger-base' => array(),
            'lqdsep-header-dropdown-base' => array(),
            'lqdsep-header-cart-base' => array(),
            'lqdsep-header-cart-offcanvas' => array( 'conditions' => $element->get_settings( 'enable_offcanvas' ) === 'yes' ),
            'lqdsep-js-bootstrap' => array( 'type' => 'js' ),
        );
        break;
    case 'ld_header_dropdown':
        $widget_options = array(
            'lqdsep-header-module-trigger-base' => array(),
            'lqdsep-header-dropdown-base' => array(),
            'lqdsep-header-dropdown-menu-base' => array(),
            'lqdsep-js-bootstrap' => array( 'type' => 'js' ),
        );
        break;
    case 'ld_header_fullproj':
        $widget_options = array(
            'lqdsep-video-bg-base' => array(
                'conditions' =>
                    $this->get_repeater_item_condition($element, 'identities', 'media_type', 'local_video')
            ),
            'lqdsep-header-nav-trigger-base' => array(),
            'lqdsep-header-dropdown-base' => array(),
            'lqdsep-fullscreen-project-base' => array(),
            'lqdsep-header-fullscreen-project-base' => array(),
            'lqdsep-header-nav-trigger-style-1' => array(
                'conditions' =>
                    $element->get_settings( 'ib_style' ) === 'style-1'
            ),
            'lqdsep-header-nav-trigger-style-2' => array(
                'conditions' =>
                    $element->get_settings( 'ib_style' ) === 'style-2'
            ),
            'lqdsep-header-nav-trigger-style-3' => array(
                'conditions' =>
                    $element->get_settings( 'ib_style' ) === 'style-3'
            ),
            'lqdsep-header-nav-trigger-style-4' => array(
                'conditions' =>
                    $element->get_settings( 'ib_style' ) === 'style-4'
            ),
            'lqdsep-header-nav-trigger-style-5' => array(
                'conditions' =>
                    $element->get_settings( 'ib_style' ) === 'style-5'
            ),
            'lqdsep-header-nav-trigger-style-6' => array(
                'conditions' =>
                    $element->get_settings( 'ib_style' ) === 'style-6'
            ),
            'lqdsep-js-bootstrap' => array( 'type' => 'js' ),
        );
        break;
    case 'ld_fullscreen_nav':
        $widget_options = array(
            'lqdsep-header-fullscreen-nav-base' => array(),
            'lqdsep-js-bootstrap' => array( 'type' => 'js' ),
        );
        break;
    case 'ld_header_image':
        $widget_options = array(
            'lqdsep-header-logo-base' => array(),
            'lqdsep-header-logo-solid' => array(
                'conditions' =>
                    $element->get_settings( 'useshapelogo' ) === 'navbar-brand-solid'
            ),
            'lqdsep-header-logo-hover-image' => array(
                'conditions' =>
                    $element->get_settings('hover_image') !== null &&
                    ! empty( $element->get_settings('hover_image')['url'] )
            ),
        );
        break;
    case 'ld_header_iconbox':
        $widget_options = array(
            'lqdsep-icon-box-base' => array(),
            'lqdsep-icon-box-side' => array(),
        );
        break;
    case 'ld_header_menu':
        $widget_options = array(
            'lqdsep-header-primary-menu-base' => array(),
            'lqdsep-header-submenu-base' => array(),
            'lqdsep-header-submenu-style-cover' => array(
                'conditions' =>
                    $element->get_settings( 'ddmenu_hover_style' ) === 'lqd-submenu-cover'
            ),
            'lqdsep-header-megamenu-base' => array(),
            'lqdsep-header-nav-hover-style-fade' => array(
                'conditions' =>
                    $element->get_settings( 'hover_style' ) === 'fade-inactive'
            ),
            'lqdsep-header-nav-hover-style-fill' => array(
                'conditions' =>
                    $element->get_settings( 'hover_style' ) === 'fill'
            ),
            'lqdsep-header-nav-hover-style-underline' => array(
                'conditions' =>
                    $element->get_settings( 'hover_style' ) === 'underline'
            ),
            'lqdsep-header-nav-visible-ontoggle' => array(
                'conditions' =>
                    $element->get_settings( 'visible' ) === 'navbar-visible-ontoggle'
            ),
            'lqdsep-js-bootstrap' => array( 'type' => 'js' ),
            'lqdsep-js-fastdom-base' => array( 'type' => 'js' ),
            'lqdsep-js-tinycolor' => array( 'type' => 'js' ),
            'lqdsep-js-imagesloaded-base' => array(
                'type' => 'js',
                'conditions' =>
                    $element->get_settings('local_scroll') === 'yes'
            ),
        );
        break;
    case 'ld_header_search':
        $widget_options = array(
            'lqdsep-header-module-trigger-base' => array(),
            'lqdsep-header-dropdown-base' => array(),
            'lqdsep-header-search-base' => array(),
            'lqdsep-header-search-style-default' => array(
                'conditions' =>
                    $element->get_settings( 'style' ) === 'default'
            ),
            'lqdsep-header-search-style-frame' => array(
                'conditions' =>
                    $element->get_settings( 'style' ) === 'frame'
            ),
            'lqdsep-header-search-style-slide' => array(
                'conditions' =>
                    $element->get_settings( 'style' ) === 'slide-top'
            ),
            'lqdsep-header-search-style-zoom' => array(
                'conditions' =>
                    $element->get_settings( 'style' ) === 'zoom-out'
            ),
            'lqdsep-js-bootstrap' => array( 'type' => 'js' ),
        );
        break;
    case 'ld_header_sidedrawer':
        $widget_options = array(
            'lqdsep-header-nav-trigger-base' => array(),
            'lqdsep-header-dropdown-base' => array(),
            'lqdsep-header-nav-trigger-style-1' => array(
                'conditions' =>
                    $element->get_settings( 'ib_style' ) === 'style-1'
            ),
            'lqdsep-header-nav-trigger-style-2' => array(
                'conditions' =>
                    $element->get_settings( 'ib_style' ) === 'style-2'
            ),
            'lqdsep-header-nav-trigger-style-3' => array(
                'conditions' =>
                    $element->get_settings( 'ib_style' ) === 'style-3'
            ),
            'lqdsep-header-nav-trigger-style-4' => array(
                'conditions' =>
                    $element->get_settings( 'ib_style' ) === 'style-4'
            ),
            'lqdsep-header-nav-trigger-style-5' => array(
                'conditions' =>
                    $element->get_settings( 'ib_style' ) === 'style-5'
            ),
            'lqdsep-header-nav-trigger-style-6' => array(
                'conditions' =>
                    $element->get_settings( 'ib_style' ) === 'style-6'
            ),
            'lqdsep-header-side-drawer-base' => array(),
            'lqdsep-js-bootstrap' => array( 'type' => 'js' ),
        );
        break;
    case 'ld_header_separator':
        $widget_options = array(
            'lqdsep-header-v-sep-base' => array(),
        );
        break;
    case 'ld_header_scroll_indicator':
        $widget_options = array(
            'lqdsep-header-scroll-indicator-base' => array(),
            'lqdsep-header-scroll-indicator-dot' => array(
                'condition' =>
                    $element->get_settings( 'indicator_type' ) === 'dot'
            ),
            'lqdsep-header-scroll-indicator-line' => array(
                'condition' =>
                    $element->get_settings( 'indicator_type' ) === 'line'
            ),
            'lqdsep-js-gsap-base' => array( 'type' => 'js' ),
            'lqdsep-js-scrolltrigger-base' => array( 'type' => 'js' ),
        );
        break;
    case 'ld_header_trigger':
        $widget_options = array(
            'lqdsep-header-nav-trigger-base' => array(),
            'lqdsep-header-nav-trigger-style-1' => array(
                'conditions' =>
                    $element->get_settings( 'style' ) === 'style-1'
            ),
            'lqdsep-header-nav-trigger-style-2' => array(
                'conditions' =>
                    $element->get_settings( 'style' ) === 'style-2'
            ),
            'lqdsep-header-nav-trigger-style-3' => array(
                'conditions' =>
                    $element->get_settings( 'style' ) === 'style-3'
            ),
            'lqdsep-header-nav-trigger-style-4' => array(
                'conditions' =>
                    $element->get_settings( 'style' ) === 'style-4'
            ),
            'lqdsep-header-nav-trigger-style-5' => array(
                'conditions' =>
                    $element->get_settings( 'style' ) === 'style-5'
            ),
            'lqdsep-header-nav-trigger-style-6' => array(
                'conditions' =>
                    $element->get_settings( 'style' ) === 'style-6'
            ),
            'lqdsep-js-bootstrap' => array( 'type' => 'js' ),
        );
        break;
    case 'ld_accordion':
        $widget_options = array(
            'lqdsep-accordion-base' => array(),
            'lqdsep-accordion-xs' => array( 'conditions' => $element->get_settings( 'size' ) === 'xs' ),
            'lqdsep-accordion-sm' => array( 'conditions' => $element->get_settings( 'size' ) === 'sm' ),
            'lqdsep-accordion-lg' => array( 'conditions' => $element->get_settings( 'size' ) === 'lg' ),
            'lqdsep-accordion-title-bordered' => array( 'conditions' => $element->get_settings( 'borders' ) === 'accordion-title-bordered' ),
            'lqdsep-accordion-title-underlined' => array( 'conditions' => $element->get_settings( 'borders' ) === 'accordion-title-underlined' ),
            'lqdsep-accordion-body-underlined' => array( 'conditions' => $element->get_settings( 'borders' ) === 'accordion-body-underlined' ),
            'lqdsep-accordion-body-bordered' => array( 'conditions' => $element->get_settings( 'borders' ) === 'accordion-body-bordered' ),
            'lqdsep-accordion-title-round' => array( 'conditions' => $element->get_settings( 'border_round' ) === 'accordion-title-round' ),
            'lqdsep-accordion-title-circle' => array( 'conditions' => $element->get_settings( 'border_round' ) === 'accordion-title-circle' ),
            'lqdsep-accordion-body-round' => array( 'conditions' => $element->get_settings( 'body_border_round' ) === 'accordion-body-round' ),
            'lqdsep-accordion-heading-has-shadow' => array( 'conditions' => $element->get_settings( 'heading_shadow' ) === 'yes' ),
            'lqdsep-accordion-active-has-shadow' => array( 'conditions' => $element->get_settings( 'active_style' ) === 'yes' ),
            'lqdsep-accordion-expander' => array( 'conditions' => $element->get_settings( 'show_icon' ) === 'yes' ),
            'lqdsep-accordion-side-spacing' => array(
                'conditions' =>
                    $element->get_settings( 'active_style' ) === 'yes' ||
                    $element->get_settings( 'items_shadow' ) === 'yes' ||
                    ! empty( $element->get_settings( 'heading_bg_color' ) ) ||
                    ! empty( $element->get_settings( 'heading_active_bg_color' ) )
            ),
            'lqdsep-js-bootstrap' => array( 'type' => 'js' ),
        );
        break;
    case 'ld_animated_frame':
        $widget_options = array(
            'lqdsep-animated-frame-base' => array(),
            'lqdsep-animated-frame-nav' => array(
                'conditions' =>
                    $element->get_settings('enable_arrows') === ''
            ),
            'lqdsep-animated-frame-num' => array(
                'conditions' =>
                    $element->get_settings('enable_counter') === ''
            ),
            'lqdsep-video-bg-base' => array(
                'conditions' =>
                    $this->get_repeater_item_condition($element, 'list', 'media_type', 'local_video') ||
                    $this->get_repeater_item_condition($element, 'list', 'media_type', 'yt_video')
            ),
            'lqdsep-js-gsap-base' => array( 'type' => 'js' ),
            'lqdsep-js-custom-ease' => array( 'type' => 'js' ),
            'lqdsep-js-ytplayer' => array(
                'type' => 'js',
                'conditions' =>
                    $this->get_repeater_item_condition($element, 'list', 'media_type', 'yt_video')
            ),
        );
        break;
    case 'ld_asymmetric_slider':
        $widget_options = array(
            'lqdsep-split-text-base' => array(),
            'lqdsep-split-text-char' => array(),
            'lqdsep-asymmetric-slider-base' => array(),
            'lqdsep-js-fontface-observer-base' => array( 'type' => 'js' ),
            'lqdsep-js-fastdom-base' => array( 'type' => 'js' ),
            'lqdsep-js-imagesloaded-base' => array( 'type' => 'js' ),
            'lqdsep-js-splittext-base' => array( 'type' => 'js' ),
            'lqdsep-js-gsap-base' => array( 'type' => 'js' ),
        );
        $widget_options = $this->merge_button_settings($widget_options, $this->get_button_param_options( $element, 'ib_' ));
        break;
    case 'ld_banner':
        $widget_options = array(
            'lqdsep-banner-base' => array(),
        );
        $widget_options = $this->merge_button_settings($widget_options, $this->get_button_param_options( $element, 'ib_' ));
        break;
    case 'ld_bananas_banner':
        $widget_options = array(
            'lqdsep-banner-bananas-base' => array(),
            'lqdsep-js-scrolltrigger-base' => array( 'type' => 'js' ),
            'lqdsep-js-gsap-base' => array( 'type' => 'js' ),
        );
        break;
    case 'ld_blog':
        $widget_options = array(
            'lqdsep-split-text-base' => array(
                'conditions' =>
                    $element->get_settings( 'style' ) === 'style10'
            ),
            'lqdsep-split-text-line' => array(
                'conditions' =>
                    $element->get_settings( 'style' ) === 'style10'
            ),
            'lqdsep-btn-base' => array(
                'conditions' =>
                    $element->get_settings( 'show_read_more_button' ) === 'yes' &&
                    (
                        $element->get_settings( 'style' ) === 'style06' ||
                        $element->get_settings( 'style' ) === 'style07' ||
                        $element->get_settings( 'style' ) === 'style10'
                    )
            ),
            'lqdsep-btn-shape-plain' => array(
                'conditions' =>
                    $element->get_settings( 'show_read_more_button' ) === 'yes' &&
                    (
                        $element->get_settings( 'style' ) === 'style06' ||
                        $element->get_settings( 'style' ) === 'style07'
                    )
            ),
            'lqdsep-btn-shape-solid' => array(
                'conditions' =>
                    $element->get_settings( 'style' ) === 'style10' &&
                    $element->get_settings( 'show_read_more_button' ) === 'yes'
            ),
            'lqdsep-btn-icon-base' => array(
                'conditions' =>
                    $element->get_settings( 'show_read_more_button' ) === 'yes' &&
                    (
                        $element->get_settings( 'style' ) === 'style06' ||
                        $element->get_settings( 'style' ) === 'style07' ||
                        $element->get_settings( 'style' ) === 'style10'
                    )
            ),
            'lqdsep-btn-hover-swap' => array(
                'conditions' =>
                    $element->get_settings( 'style' ) === 'style06' &&
                    $element->get_settings( 'show_read_more_button' ) === 'yes'
            ),
            // Pagination
            'lqdsep-pagination-base' => array( 'conditions' => $element->get_settings( 'pagination' ) === 'pagination' ),
            'lqdsep-btn-ajax-loadmore' => array( 'conditions' => $element->get_settings( 'pagination' ) === 'ajax' ),
            // Filter list
            'lqdsep-filter-list-base' => array( 'conditions' => $element->get_settings( 'enable_filter' ) === 'yes' ),
            'lqdsep-filter-list-decorated' => array( 
                'conditions' =>
                    $element->get_settings( 'enable_filter' ) === 'yes'
            ),
            'lqdsep-filter-list-inline' => array( 
                'conditions' =>
                    $element->get_settings( 'enable_filter' ) === 'yes'
            ),
            'lqdsep-filter-list-title-base' => array( 
                'conditions' =>
                    $element->get_settings( 'enable_filter' ) === 'yes' &&
                    ! empty( $element->get_settings( 'filter_title' ) )
            ),
            'lqdsep-blog-base' => array(),
            'lqdsep-blog-animate-onhover' => array(
                'conditions' =>
                    $element->get_settings( 'style' ) === 'style04'
            ),
            'lqdsep-blog-author' => array(
                'conditions' =>
                    $element->get_settings( 'style' ) === 'style05' ||
                    $element->get_settings( 'style' ) === 'style03' ||
                    $element->get_settings( 'style' ) === 'style04'
            ),
            'lqdsep-blog-category-base' => array(
                'conditions' =>
                    $element->get_settings( 'style' ) !== 'style07' &&
                    $element->get_settings( 'style' ) !== 'style09'
            ),
            'lqdsep-blog-category-shaped-base' => array(
                'conditions' =>
                    $element->get_settings( 'style' ) !== 'style04' &&
                    $element->get_settings( 'style' ) !== 'style06' &&
                    $element->get_settings( 'style' ) !== 'style08' &&
                    $element->get_settings( 'style' ) !== 'style10' &&
                    $element->get_settings( 'style' ) !== 'style12'
            ),
            'lqdsep-blog-category-border' => array(
                'conditions' =>
                    $element->get_settings( 'style' ) === 'style05'
            ),
            'lqdsep-blog-category-plain' => array(
                'conditions' =>
                    $element->get_settings( 'style' ) === 'style04' ||
                    $element->get_settings( 'style' ) === 'style05'
            ),
            'lqdsep-blog-category-solid' => array(
                'conditions' =>
                    $element->get_settings( 'style' ) === 'style01' ||
                    $element->get_settings( 'style' ) === 'style02' ||
                    $element->get_settings( 'style' ) === 'style03' ||
                    $element->get_settings( 'style' ) === 'style11' ||
                    $element->get_settings( 'style' ) === 'style13' ||
                    $element->get_settings( 'style' ) === 'style14'
            ),
            'lqdsep-blog-category-solid-colored' => array(
                'conditions' =>
                    $element->get_settings( 'style' ) === 'style01' ||
                    $element->get_settings( 'style' ) === 'style02' ||
                    $element->get_settings( 'style' ) === 'style03' ||
                    $element->get_settings( 'style' ) === 'style13'
            ),
            'lqdsep-blog-date' => array(
                'conditions' =>
                    $element->get_settings( 'style' ) !== 'style07' &&
                    $element->get_settings( 'style' ) !== 'style08' &&
                    $element->get_settings( 'style' ) !== 'style10' &&
                    $element->get_settings( 'style' ) !== 'style11' &&
                    $element->get_settings( 'style' ) !== 'style12'
            ),
            'lqdsep-blog-excerpt' => array(
                'conditions' =>
                    $element->get_settings( 'style' ) !== 'style01' &&
                    $element->get_settings( 'style' ) !== 'style02' &&
                    $element->get_settings( 'style' ) !== 'style08' &&
                    $element->get_settings( 'style' ) !== 'style09' &&
                    $element->get_settings( 'style' ) !== 'style10'
            ),
            'lqdsep-blog-image' => array(
                'conditions' =>
                    $element->get_settings( 'style' ) !== 'style04'
            ),
            'lqdsep-blog-image-hover-zoom-out' => array(
                'conditions' =>
                    $element->get_settings( 'style' ) === 'style14'
            ),
            'lqdsep-blog-image-hover-zoom' => array(
                'conditions' =>
                    $element->get_settings( 'style' ) === 'style03' ||
                    $element->get_settings( 'style' ) === 'style07' ||
                    $element->get_settings( 'style' ) === 'style10' ||
                    $element->get_settings( 'style' ) === 'style11' ||
                    $element->get_settings( 'style' ) === 'style13' ||
                    $element->get_settings( 'style' ) === 'style14'
            ),
            'lqdsep-blog-meta-base' => array(),
            'lqdsep-blog-meta-dot-between' => array(
                'conditions' =>
                    $element->get_settings( 'style' ) === 'style02' ||
                    $element->get_settings( 'style' ) === 'style03' ||
                    $element->get_settings( 'style' ) === 'style04' ||
                    $element->get_settings( 'style' ) === 'style05' ||
                    $element->get_settings( 'style' ) === 'style13' ||
                    $element->get_settings( 'style' ) === 'style14' 
            ),
            'lqdsep-blog-meta-solid' => array(
                'conditions' =>
                    $element->get_settings( 'style' ) === 'style05' ||
                    $element->get_settings( 'style' ) === 'style06'
            ),
            'lqdsep-blog-meta-solid-nopadding' => array(
                'conditions' =>
                    $element->get_settings( 'style' ) === 'style06'
            ),
            'lqdsep-blog-read-more' => array(
                'conditions' =>
                    $element->get_settings( 'style' ) === 'style07' ||
                    $element->get_settings( 'style' ) === 'style08' ||
                    $element->get_settings( 'style' ) === 'style12'
            ),
            'lqdsep-blog-title-highlight' => array(
                'conditions' =>
                    $element->get_settings( 'style' ) === 'style10'
            ),
            'lqdsep-blog-style-1' => array( 'conditions' => $element->get_settings( 'style' ) === 'style01' ),
            'lqdsep-blog-style-2' => array( 'conditions' => $element->get_settings( 'style' ) === 'style02' ),
            'lqdsep-blog-style-3' => array( 'conditions' => $element->get_settings( 'style' ) === 'style03' ),
            'lqdsep-blog-style-4' => array( 'conditions' => $element->get_settings( 'style' ) === 'style04' ),
            'lqdsep-blog-style-5' => array( 'conditions' => $element->get_settings( 'style' ) === 'style05' ),
            'lqdsep-blog-style-6' => array( 'conditions' => $element->get_settings( 'style' ) === 'style06' ),
            'lqdsep-blog-style-7' => array( 'conditions' => $element->get_settings( 'style' ) === 'style07' ),
            'lqdsep-blog-style-8' => array( 'conditions' => $element->get_settings( 'style' ) === 'style08' ),
            'lqdsep-blog-style-9' => array( 'conditions' => $element->get_settings( 'style' ) === 'style09' ),
            'lqdsep-blog-style-10' => array( 'conditions' => $element->get_settings( 'style' ) === 'style10' ),
            'lqdsep-blog-style-11' => array( 'conditions' => $element->get_settings( 'style' ) === 'style11' ),
            'lqdsep-blog-style-12' => array( 'conditions' => $element->get_settings( 'style' ) === 'style12' ),
            'lqdsep-blog-style-13' => array( 'conditions' => $element->get_settings( 'style' ) === 'style13' ),
            'lqdsep-blog-style-14' => array( 'conditions' => $element->get_settings( 'style' ) === 'style14' ),
            'lqdsep-js-fastdom-base' => array(
                'type' => 'js',
                'conditions' =>
                    $element->get_settings( 'style' ) === 'style10'
            ),
            'lqdsep-js-fontface-observer-base' => array(
                'type' => 'js',
                'conditions' =>
                    $element->get_settings( 'style' ) === 'style10'
            ),
            'lqdsep-js-splittext-base' => array(
                'type' => 'js',
                'conditions' =>
                    $element->get_settings( 'style' ) === 'style10'
            ),
            'lqdsep-js-imagesloaded-base' => array(
                'type' => 'js',
                'conditions' =>
                    $element->get_settings( 'style' ) === 'style05' ||
                    $element->get_settings( 'style' ) === 'style03' ||
                    $element->get_settings( 'enable_filter' ) === 'yes'
            ),
            'lqdsep-js-isotope' => array(
                'type' => 'js',
                'conditions' =>
                    $element->get_settings( 'style' ) === 'style05' ||
                    $element->get_settings( 'style' ) === 'style03' ||
                    $element->get_settings( 'enable_filter' ) === 'yes'
            ),
            'lqdsep-js-isotope-packery' => array(
                'type' => 'js',
                'conditions' =>
                    $element->get_settings( 'style' ) === 'style05' ||
                    $element->get_settings( 'style' ) === 'style03' ||
                    $element->get_settings( 'enable_filter' ) === 'yes'
            ),
            'lqdsep-js-jquery-ui-base' => array(
                'type' => 'js',
                'conditions' => $element->get_settings( 'enable_filter' ) === 'yes'
            ),
            'lqdsep-js-jquery-ui-touch' => array(
                'type' => 'js',
                'conditions' => $element->get_settings( 'enable_filter' ) === 'yes'
            ),
        );
        break;
    case 'ld_button':
        $widget_options = $this->get_button_param_options( $element, '' );
        break;
    case 'ld_carousel':
        $widget_options = $this->get_carousel_param_options( $element, '' );
        break;
    case 'ld_cf722':
        $widget_options = array(
            'lqdsep-contact-form-base' => array(),
            'lqdsep-contact-form-inputs-fill-filled' => array(
                'conditions' =>
                    $element->get_settings('shape') === 'lqd-contact-form-inputs-filled'
            ),
            'lqdsep-contact-form-inputs-fill-underlined' => array(
                'conditions' =>
                    $element->get_settings('shape') === 'lqd-contact-form-inputs-underlined'
            ),
            'lqdsep-contact-form-inputs-roundness-round' => array(
                'conditions' =>
                    $element->get_settings('roundness') === 'lqd-contact-form-inputs-round'
            ),
            'lqdsep-contact-form-inputs-roundness-circle' => array(
                'conditions' =>
                    $element->get_settings('roundness') === 'lqd-contact-form-inputs-circle'
            ),
            'lqdsep-contact-form-inputs-size-sm' => array(
                'conditions' =>
                    $element->get_settings('size') === 'lqd-contact-form-inputs-sm'
            ),
            'lqdsep-contact-form-inputs-size-md' => array(
                'conditions' =>
                    $element->get_settings('size') === 'lqd-contact-form-inputs-md'
            ),
            'lqdsep-contact-form-inputs-size-lg' => array(
                'conditions' =>
                    $element->get_settings('size') === 'lqd-contact-form-inputs-lg'
            ),
            'lqdsep-contact-form-inputs-border-none' => array(
                'conditions' =>
                    $element->get_settings('thickness') === 'lqd-contact-form-inputs-border-none'
            ),
            'lqdsep-contact-form-inputs-border-thin' => array(
                'conditions' =>
                    $element->get_settings('thickness') === ''
            ),
            'lqdsep-contact-form-inputs-border-thick' => array(
                'conditions' =>
                    $element->get_settings('thickness') === 'lqd-contact-form-inputs-border-thick'
            ),
            'lqdsep-contact-form-inputs-border-thicker' => array(
                'conditions' =>
                    $element->get_settings('thickness') === 'lqd-contact-form-inputs-border-thicker'
            ),
            'lqdsep-contact-form-button-border-none' => array(
                'conditions' =>
                    $element->get_settings('btn_thickness') === 'lqd-contact-form-button-border-none'
            ),
            'lqdsep-contact-form-button-border-thin' => array(
                'conditions' =>
                    $element->get_settings('btn_thickness') === ''
            ),
            'lqdsep-contact-form-button-border-thick' => array(
                'conditions' =>
                    $element->get_settings('btn_thickness') === 'lqd-contact-form-button-border-thick'
            ),
            'lqdsep-contact-form-button-border-thicker' => array(
                'conditions' =>
                    $element->get_settings('btn_thickness') === 'lqd-contact-form-button-border-thicker'
            ),
            'lqdsep-contact-form-button-fill-underlined' => array(
                'conditions' =>
                    $element->get_settings('btn_shape') === 'lqd-contact-form-button-underlined'
            ),
            'lqdsep-contact-form-button-roundness-round' => array(
                'conditions' =>
                    $element->get_settings('btn_roundness') === 'lqd-contact-form-button-round'
            ),
            'lqdsep-contact-form-button-roundness-circle' => array(
                'conditions' =>
                    $element->get_settings('btn_roundness') === 'lqd-contact-form-button-circle'
            ),
            'lqdsep-contact-form-button-size-sm' => array(
                'conditions' =>
                    $element->get_settings('btn_size') === 'lqd-contact-form-button-sm'
            ),
            'lqdsep-contact-form-button-size-md' => array(
                'conditions' =>
                    $element->get_settings('btn_size') === 'lqd-contact-form-button-md'
            ),
            'lqdsep-contact-form-button-size-lg' => array(
                'conditions' =>
                    $element->get_settings('btn_size') === 'lqd-contact-form-button-lg'
            ),
            'lqdsep-contact-form-button-width-block' => array(
                'conditions' =>
                    $element->get_settings('btn_width') === 'lqd-contact-form-button-block'
            ),
            'lqdsep-js-jquery-ui-base' => array( 'type' => 'js' ),
            'lqdsep-js-jquery-ui-touch' => array( 'type' => 'js' ),
        );
        break;
    case 'ld_content_box':
        $widget_options = array(
            'lqdsep-split-text-base' => array(
                'conditions' =>
                        $element->get_settings( 'template' ) === 's01' ||
                        $element->get_settings( 'template' ) === 's02' ||
                        $element->get_settings( 'template' ) === 's03' ||
                        $element->get_settings( 'template' ) === 's08'
            ),
            'lqdsep-block-reveal-base' => array(
                'conditions' =>
                        $element->get_settings( 'template' ) === 's02' ||
                        $element->get_settings( 'template' ) === 's03' ||
                        $element->get_settings( 'template' ) === 's08'
            ),
            'lqdsep-custom-animations' => array(
                'conditions' =>
                        $element->get_settings( 'template' ) === 's01' ||
                        $element->get_settings( 'template' ) === 's01a' ||
                        $element->get_settings( 'template' ) === 's02' ||
                        $element->get_settings( 'template' ) === 's03' ||
                        $element->get_settings( 'template' ) === 's08' ||
                        $element->get_settings( 'template' ) === 's09'
            ),
            'lqdsep-fancybox-base' => array(),
            'lqdsep-fancybox-content-overlay' => array(
                'conditions' =>
                    $element->get_settings( 'template' ) === 's01' ||
                    $element->get_settings( 'template' ) === 's01a' ||
                    $element->get_settings( 'template' ) === 's01b' ||
                    $element->get_settings( 'template' ) === 's02'
            ),
            'lqdsep-fancybox-image' => array(
                'conditions' =>
                    $element->get_settings( 'template' ) !== 's10'
            ),
            'lqdsep-fancybox-img-zoom-onhover' => array(
                'conditions' => 
                    $element->get_settings( 'template' ) === 's01' ||
                    $element->get_settings( 'template' ) === 's01a' ||
                    $element->get_settings( 'template' ) === 's01b' ||
                    $element->get_settings( 'template' ) === 's03' ||
                    $element->get_settings( 'template' ) === 's04' ||
                    $element->get_settings( 'template' ) === 's11'
            ),
            'lqdsep-fancybox-overlay-hover' => array(
                'conditions' => 
                    $element->get_settings( 'template' ) !== 's01' &&
                    $element->get_settings( 'template' ) !== 's08' &&
                    $element->get_settings( 'template' ) !== 's09' &&
                    $element->get_settings( 'template' ) !== 's10' &&
                    $element->get_settings( 'template' ) !== 's11'
            ),
            'lqdsep-fancybox-style-1-base' => array(
                'conditions' => 
                    $element->get_settings( 'template' ) === 's01' ||
                    $element->get_settings( 'template' ) === 's01a' ||
                    $element->get_settings( 'template' ) === 's01b'
            ),
            'lqdsep-fancybox-style-1-1' => array( 'conditions' => $element->get_settings( 'template' ) === 's01' ),
            'lqdsep-fancybox-style-1-2' => array( 'conditions' => $element->get_settings( 'template' ) === 's01a' ),
            'lqdsep-fancybox-style-1-3' => array( 'conditions' => $element->get_settings( 'template' ) === 's01b' ),
            'lqdsep-fancybox-style-2' => array( 'conditions' => $element->get_settings( 'template' ) === 's02' ),
            'lqdsep-fancybox-style-3' => array( 'conditions' => $element->get_settings( 'template' ) === 's03' ),
            'lqdsep-fancybox-style-4' => array( 'conditions' => $element->get_settings( 'template' ) === 's04' ),
            'lqdsep-fancybox-style-5' => array( 'conditions' => $element->get_settings( 'template' ) === 's05' ),
            'lqdsep-fancybox-style-6' => array( 'conditions' => $element->get_settings( 'template' ) === 's06' ),
            'lqdsep-fancybox-style-7' => array( 'conditions' => $element->get_settings( 'template' ) === 's07' ),
            'lqdsep-fancybox-style-8' => array( 'conditions' => $element->get_settings( 'template' ) === 's08' ),
            'lqdsep-fancybox-style-9' => array( 'conditions' => $element->get_settings( 'template' ) === 's09' ),
            'lqdsep-fancybox-style-10' => array( 'conditions' => $element->get_settings( 'template' ) === 's10' ),
            'lqdsep-fancybox-style-11' => array( 'conditions' => $element->get_settings( 'template' ) === 's11' ),
            'lqdsep-js-fastdom-base' => array(
                'type' => 'js',
                'conditions' =>
                        $element->get_settings( 'template' ) === 's01' ||
                        $element->get_settings( 'template' ) === 's02' ||
                        $element->get_settings( 'template' ) === 's03' ||
                        $element->get_settings( 'template' ) === 's08'
            ),
            'lqdsep-js-fontface-observer-base' => array(
                'type' => 'js',
                'conditions' =>
                        $element->get_settings( 'template' ) === 's01' ||
                        $element->get_settings( 'template' ) === 's02' ||
                        $element->get_settings( 'template' ) === 's03' ||
                        $element->get_settings( 'template' ) === 's08'
            ),
            'lqdsep-js-splittext-base' => array(
                'type' => 'js',
                'conditions' =>
                        $element->get_settings( 'template' ) === 's01' ||
                        $element->get_settings( 'template' ) === 's02' ||
                        $element->get_settings( 'template' ) === 's03' ||
                        $element->get_settings( 'template' ) === 's08'
            ),
            'lqdsep-js-imagesloaded-base' => array(
                'type' => 'js',
                'conditions' =>
                        $element->get_settings( 'template' ) === 's02' ||
                        $element->get_settings( 'template' ) === 's03' ||
                        $element->get_settings( 'template' ) === 's08'
            ),
            'lqdsep-js-gsap-base' => array(
                'type' => 'js',
                'conditions' =>
                        $element->get_settings( 'template' ) === 's01' ||
                        $element->get_settings( 'template' ) === 's01b' ||
                        $element->get_settings( 'template' ) === 's02' ||
                        $element->get_settings( 'template' ) === 's03' ||
                        $element->get_settings( 'template' ) === 's06' ||
                        $element->get_settings( 'template' ) === 's08'
            ),
        );
        $widget_options = $this->merge_button_settings($widget_options, $this->get_button_param_options( $element, 'ib_' ));
        break;
    case 'ld_countdown':
        $widget_options = array(
            'lqdsep-countdown-base' => array(),
            'lqdsep-countdown-inline' => array(
                'conditions' =>
                    $element->get_settings('countdown_inline') === 'yes'
            ),
            'lqdsep-js-countdown-jquery' => array( 'type' => 'js', ),
            'lqdsep-js-countdown-base' => array( 'type' => 'js', ),
        );
        break;
    case 'ld_counter':
        $widget_options = array(
            'lqdsep-counter-base' => array(),
            'lqdsep-counter-bordered' => array(
                'conditions' =>
                    $element->get_settings('template') === 'bordered'
            ),
            'lqdsep-counter-icon' => array(
                'conditions' =>
                    $element->get_settings('add_icon')
            ),
            'lqdsep-counter-overlay-bg' => array(
                'conditions' =>
                    $element->get_settings('template') === 'bordered' ||
                    $element->get_settings('template') === 'solid'
            ),
            'lqdsep-counter-solid' => array(
                'conditions' =>
                    $element->get_settings('template') === 'solid'
            ),
            'lqdsep-js-gsap-base' => array( 'type' => 'js' ),
        );
        break;
    case 'ld_list':
        $widget_options = array(
            'lqdsep-bullet-list-base' => array(),
            'lqdsep-bullet-list-inline' => array(
                'conditions' =>
                    $element->get_settings('inline') === 'inline-nav'
            ),
        );
        break;
    case 'ld_custom_menu':
        $widget_options = array(
            'lqdsep-header-scroll-indicator-base' => array(
                'conditions' =>
                    $element->get_settings('add_scroll_indicator') === 'yes'
            ),
            'lqdsep-custom-menu-base' => array(),
            'lqdsep-custom-menu-dropdown-btn-has-fill' => array(
                'conditions' =>
                    $element->get_settings('add_toggle') === 'yes' &&
                    (
                        ! empty( $element->get_settings('toggle_bg_color') ) ||
                        ! empty( $element->get_settings('toggle_active_bg_color') )
                    )
            ),
            'lqdsep-custom-menu-dropdown-btn' => array(
                'conditions' =>
                    $element->get_settings('add_toggle') === 'yes' ||
                    $element->get_settings('mobile_add_toggle') === 'yes'
            ),
            'lqdsep-custom-menu-dropdown' => array(
                'conditions' =>
                    $element->get_settings('add_toggle') === 'yes' ||
                    $element->get_settings('mobile_add_toggle') === 'yes'
            ),
            'lqdsep-custom-menu-icon-base' => array(),
            'lqdsep-custom-menu-icon-right' => array(),
            'lqdsep-custom-menu-items-has-border' => array(
                'conditions' =>
                    ! empty( $element->get_settings('border_color') ) ||
                    ! empty( $element->get_settings('border_hcolor') )
            ),
            'lqdsep-custom-menu-items-has-border-inline' => array(
                'conditions' =>
                    (
                        ! empty( $element->get_settings('border_color') ) ||
                        ! empty( $element->get_settings('border_hcolor') )
                    ) &&
                    (
                        $element->get_settings('sticky') === 'yes' ||
                        $element->get_settings('inline') === 'yes'
                    )
            ),
            'lqdsep-custom-menu-items-has-fill' => array(
                'conditions' =>
                    ! empty( $element->get_settings('bg_color') ) ||
                    ! empty( $element->get_settings('bg_hcolor') ) ||
                    ! empty( $element->get_settings('sticky_bg_color') ) ||
                    ! empty( $element->get_settings('sticky_bg_hcolor') ) ||
                    ! empty( $element->get_settings('sticky_light_bg_color') ) ||
                    ! empty( $element->get_settings('sticky_light_bg_hcolor') ) ||
                    ! empty( $element->get_settings('sticky_dark_bg_color') ) ||
                    ! empty( $element->get_settings('sticky_dark_bg_hcolor') )
            ),
            'lqdsep-custom-menu-mobile-collapsible' => array(
                'conditions' =>
                    $element->get_settings('mobile_add_toggle') === 'yes'
            ),
            'lqdsep-custom-menu-pin' => array(
                'conditions' =>
                    $element->get_settings('sticky') === 'yes' &&
                    $element->get_settings('cm_sticky_type') === 'lqd-sticky-menu-default'
            ),
            'lqdsep-custom-menu-sticky' => array(
                'conditions' =>
                    $element->get_settings('sticky') === 'yes'
            ),
            'lqdsep-custom-menu-sticky-floating' => array(
                'conditions' =>
                    $element->get_settings('sticky') === 'yes' &&
                    $element->get_settings('cm_sticky_type') === 'lqd-sticky-menu-floating'
            ),
            'lqdsep-custom-menu-sticky-floating-expand' => array(
                'conditions' =>
                    $element->get_settings('sticky') === 'yes' &&
                    $element->get_settings('cm_sticky_type') === 'lqd-sticky-menu-floating' &&
                    $element->get_settings('auto_expand_items') === 'inline-nav'
            ),
            'lqdsep-custom-menu-sticky-floating-vertical' => array(
                'conditions' =>
                    $element->get_settings('sticky') === 'yes' &&
                    $element->get_settings('cm_sticky_type') === 'lqd-sticky-menu-floating-vertical'
            ),
            'lqdsep-custom-menu-sticky-indc' => array(
                'conditions' =>
                    $element->get_settings('add_scroll_indicator') === 'yes'
            ),
            'lqdsep-custom-menu-sticky-inline' => array(
                'conditions' =>
                    $element->get_settings('sticky') === 'yes' &&
                    $element->get_settings('auto_expand_items') === 'inline-nav'
            ),
            'lqdsep-custom-menu-sticky-inline-expand' => array(
                'conditions' =>
                    $element->get_settings('sticky') === 'yes' &&
                    $element->get_settings('auto_expand_items') === 'inline-nav'
            ),
            'lqdsep-custom-menu-toggle-has-fill' => array(
                'conditions' =>
                    $element->get_settings('items_decoration') === 'lqd-menu-td-underline'
            ),
            // no conditions in case there's submenu
            'lqdsep-js-fastdom-base' => array( 'type' => 'js' ),
            'lqdsep-js-imagesloaded-base' => array(
                'type' => 'js',
                'conditions' =>
                    $element->get_settings('localscroll') === 'yes'
            ),
            'lqdsep-js-scrolltrigger-base' => array(
                'type' => 'js',
                'conditions' =>
                    $element->get_settings('sticky') === 'yes'
            ),
        );
        break;
    case 'hub_fancy_heading':
        $widget_options = array(
            'lqdsep-highlight-base' => array(
                'conditions' =>
                    $element->get_settings( 'highlight_type' ) !== ''
            ),
            'lqdsep-highlight-classic' => array(
                'conditions' =>
                    $element->get_settings( 'highlight_type' ) === 'lqd-highlight-underline'
            ),
            'lqdsep-highlight-custom-base' => array(
                'conditions' =>
                    $element->get_settings( 'highlight_type' ) === 'lqd-highlight-custom-underline' ||
                    $element->get_settings( 'highlight_type' ) === 'lqd-highlight-custom-underline lqd-highlight-custom-underline-alt'
            ),
            'lqdsep-highlight-custom-1' => array(
                'conditions' =>
                    $element->get_settings( 'highlight_type' ) === 'lqd-highlight-custom-underline'
            ),
            'lqdsep-highlight-custom-2' => array(
                'conditions' =>
                    $element->get_settings( 'highlight_type' ) === 'lqd-highlight-custom-underline lqd-highlight-custom-underline-alt'
            ),
            'lqdsep-highlight-reset-onhover' => array(
                'conditions' =>
                    $element->get_settings( 'highlight_reset_onhover' ) === 'yes'
            ),
            'lqdsep-split-text-base' => array(
                'conditions' =>
                    $element->get_settings( 'enable_split' )  !== ''
            ),
            'lqdsep-split-text-line' => array(
                'conditions' =>
                    $element->get_settings( 'enable_split' )  !== '' &&
                    $element->get_settings( 'split_type' )  === 'lines'
            ),
            'lqdsep-split-text-word' => array(
                'conditions' =>
                    $element->get_settings( 'enable_split' )  !== '' &&
                    (
                        $element->get_settings( 'split_type' )  === 'words' ||
                        $element->get_settings( 'split_type' )  === 'chars, words'
                    )
            ),
            'lqdsep-split-text-char' => array(
                'conditions' =>
                    $element->get_settings( 'enable_split' )  !== '' &&
                    $element->get_settings( 'split_type' )  === 'chars, words'
            ),
            'lqdsep-text-rotator-base' => array(
                'conditions' =>
                    $element->get_settings( 'enable_txt_rotator' )  === 'yes'
            ),
            'lqdsep-text-rotator-type-basic' => array(
                'conditions' =>
                    $element->get_settings( 'enable_txt_rotator' )  === 'yes' &&
                    $element->get_settings( 'rotator_type' )  === 'basic'
            ),
            'lqdsep-text-rotator-type-slide' => array(
                'conditions' =>
                    $element->get_settings( 'enable_txt_rotator' )  === 'yes' &&
                    $element->get_settings( 'rotator_type' )  === ''
            ),
            'lqdsep-utils-text-vertical' => array(
                'conditions' =>
                    $element->get_settings( 'vertical_txt' )  === 'true'
            ),
            'lqdsep-fancy-heading-base' => array(),
            'lqdsep-fancy-heading-gradient' => array(
                'conditions' =>
                    $element->get_settings( 'add_gradient' )  === 'yes'
            ),
            'lqdsep-fancy-heading-mask-text' => array(
                'conditions' =>
                    $element->get_settings( 'enable_split' )  !== '' &&
                    $element->get_settings( 'use_mask' )  === 'true'
            ),
            'lqdsep-fancy-heading-outline-base' => array(
                'conditions' =>
                    $element->get_settings( 'hover_text_outline' )  === 'ld-fh-outline'
            ),
            'lqdsep-fancy-heading-outline-default' => array(
                'conditions' =>
                    $element->get_settings( 'hover_text_outline' )  === 'ld-fh-outline' &&
                    $element->get_settings( 'outline_appearance' )  === 'ld-fh-outline-static'
            ),
            'lqdsep-fancy-heading-outline-onhover' => array(
                'conditions' =>
                    $element->get_settings( 'hover_text_outline' )  === 'ld-fh-outline' &&
                    $element->get_settings( 'outline_appearance' )  === 'ld-fh-outline'
            ),
            'lqdsep-fancy-heading-text-vertical' => array(
                'conditions' => $element->get_settings( 'vertical_txt' )  === 'true'
            ),
            'lqdsep-js-gsap-base' => array(
                'type' => 'js',
                'conditions' =>
                    $element->get_settings( 'enable_txt_rotator' )  === 'yes' &&
                    $element->get_settings( 'rotator_type' )  === 'basic'
            ),
            'lqdsep-js-fastdom-base' => array(
                'type' => 'js',
                'conditions' =>
                    $element->get_settings( 'enable_split' )  !== ''
            ),
            'lqdsep-js-fontface-observer-base' => array(
                'type' => 'js',
                'conditions' =>
                    $element->get_settings( 'enable_split' )  !== ''
            ),
            'lqdsep-js-splittext-base' => array(
                'type' => 'js',
                'conditions' =>
                    $element->get_settings( 'enable_split' )  !== ''
            ),
        );
        break;
    case 'ld_fancy_image':
        $widget_options = array(
            'lqdsep-block-reveal-base' => array(
                'conditions' =>
                    $element->get_settings( 'enable_reveal' ) === 'yes'
            ),
            'lqdsep-v-line-base' => array(
                'conditions' =>
                    $element->get_settings( 'enable_lines' ) === 'yes'
            ),
            'lqdsep-lightbox-base' => array(
                'conditions' =>
                    $element->get_settings( 'enable_lightbox' )  === 'yes'
            ),
            'lqdsep-fancy-image-base' => array(),
            'lqdsep-fancy-image-content-base' => array(
                'conditions' =>
                    ! empty( $element->get_settings( 'label' ) )
            ),
            'lqdsep-fancy-image-content-base-reveal' => array(
                'conditions' =>
                    ! empty( $element->get_settings( 'label' ) ) &&
                    $element->get_settings( 'enable_reveal' ) === 'yes'
            ),
            'lqdsep-fancy-image-content-fixed-base' => array(
                'conditions' =>
                    ! empty( $element->get_settings( 'label' ) ) &&
                    $element->get_settings( 'enable_side_label' ) === 'yes'
            ),
            'lqdsep-fancy-image-content-fixed-left' => array(
                'conditions' =>
                    ! empty( $element->get_settings( 'label' ) ) &&
                    $element->get_settings( 'enable_side_label' ) === 'yes' &&
                    $element->get_settings( 'label_side' ) === 'lqd-imggrp-content-fixed-left'
            ),
            'lqdsep-fancy-image-content-fixed-left-reveal' => array(
                'conditions' =>
                    ! empty( $element->get_settings( 'label' ) ) &&
                    $element->get_settings( 'enable_side_label' ) === 'yes' &&
                    $element->get_settings( 'label_side' ) === 'lqd-imggrp-content-fixed-left' &&
                    $element->get_settings( 'enable_reveal' ) === 'yes'
            ),
            'lqdsep-fancy-image-content-fixed-right' => array(
                'conditions' =>
                    ! empty( $element->get_settings( 'label' ) ) &&
                    $element->get_settings( 'enable_side_label' ) === 'yes' &&
                    $element->get_settings( 'label_side' ) === 'lqd-imggrp-content-fixed-right'
            ),
            'lqdsep-fancy-image-content-fixed-right-reveal' => array(
                'conditions' =>
                    ! empty( $element->get_settings( 'label' ) ) &&
                    $element->get_settings( 'enable_side_label' ) === 'yes' &&
                    $element->get_settings( 'label_side' ) === 'lqd-imggrp-content-fixed-right' &&
                    $element->get_settings( 'enable_reveal' ) === 'yes'
            ),
            'lqdsep-fancy-image-content-overlay-base' => array(
                'conditions' =>
                    ! empty( $element->get_settings( 'label' ) ) &&
                    $element->get_settings( 'enable_side_label' ) === 'yes' &&
                    $element->get_settings( 'enable_side_label_overlay' ) === 'lqd-imggrp-content-fixed-in'
            ),
            'lqdsep-fancy-image-content-overlay-left-reveal' => array(
                'conditions' =>
                    ! empty( $element->get_settings( 'label' ) ) &&
                    $element->get_settings( 'enable_side_label' ) === 'yes' &&
                    $element->get_settings( 'enable_side_label_overlay' ) === 'lqd-imggrp-content-fixed-in' &&
                    $element->get_settings( 'label_side' ) === 'lqd-imggrp-content-fixed-left' &&
                    $element->get_settings( 'enable_reveal' ) === 'yes'
            ),
            'lqdsep-fancy-image-content-overlay-right-reveal' => array(
                'conditions' =>
                    ! empty( $element->get_settings( 'label' ) ) &&
                    $element->get_settings( 'enable_side_label' ) === 'yes' &&
                    $element->get_settings( 'enable_side_label_overlay' ) === 'lqd-imggrp-content-fixed-in' &&
                    $element->get_settings( 'label_side' ) === 'lqd-imggrp-content-fixed-right' &&
                    $element->get_settings( 'enable_reveal' ) === 'yes'
            ),
            'lqdsep-fancy-image-float-base' => array(
                'conditions' =>
                    $element->get_settings( 'enable_float_effect' )  === 'yes'
            ),
            'lqdsep-fancy-image-shadow-1' => array(
                'conditions' =>
                    $element->get_settings( 'enable_image_shadow' )  === 'yes' &&
                    $element->get_settings( 'shadow_style' )  === '1'
            ),
            'lqdsep-fancy-image-shadow-2' => array(
                'conditions' =>
                    $element->get_settings( 'enable_image_shadow' )  === 'yes' &&
                    $element->get_settings( 'shadow_style' )  === '2'
            ),
            'lqdsep-fancy-image-shadow-3' => array(
                'conditions' =>
                    $element->get_settings( 'enable_image_shadow' )  === 'yes' &&
                    $element->get_settings( 'shadow_style' )  === '3'
            ),
            'lqdsep-fancy-image-shadow-4' => array(
                'conditions' =>
                    $element->get_settings( 'enable_image_shadow' )  === 'yes' &&
                    $element->get_settings( 'shadow_style' )  === '4'
            ),
            'lqdsep-fancy-image-shadow-animate-1' => array(
                'conditions' =>
                    $element->get_settings( 'enable_image_shadow' )  === 'yes' &&
                    $element->get_settings( 'enable_animated_shadow' )  === 'yes' &&
                    $element->get_settings( 'shadow_style' )  === '1'
            ),
            'lqdsep-fancy-image-shadow-animate-2' => array(
                'conditions' =>
                    $element->get_settings( 'enable_image_shadow' )  === 'yes' &&
                    $element->get_settings( 'enable_animated_shadow' )  === 'yes' &&
                    $element->get_settings( 'shadow_style' )  === '2'
            ),
            'lqdsep-fancy-image-shadow-animate-3' => array(
                'conditions' =>
                    $element->get_settings( 'enable_image_shadow' )  === 'yes' &&
                    $element->get_settings( 'enable_animated_shadow' )  === 'yes' &&
                    $element->get_settings( 'shadow_style' )  === '3'
            ),
            'lqdsep-fancy-image-shadow-animate-4' => array(
                'conditions' =>
                    $element->get_settings( 'enable_image_shadow' )  === 'yes' &&
                    $element->get_settings( 'enable_animated_shadow' )  === 'yes' &&
                    $element->get_settings( 'shadow_style' )  === '4'
            ),
            'lqdsep-fancy-image-shadow-animate-base' => array(
                'conditions' =>
                    $element->get_settings( 'enable_image_shadow' )  === 'yes' &&
                    $element->get_settings( 'enable_animated_shadow' )  === 'yes'
            ),
            'lqdsep-js-lightbox' => array(
                'type' => 'js',
                'conditions' =>
                    $element->get_settings( 'enable_lightbox' )  === 'yes'
            ),
            'lqdsep-js-fastdom-base' => array(
                'type' => 'js',
                'conditions' =>
                    $element->get_settings( 'enable_hover3d' ) === 'yes'
            ),
            'lqdsep-js-imagesloaded-base' => array(
                'type' => 'js',
                'conditions' =>
                    $element->get_settings( 'enable_reveal' ) === 'yes'
            ),
            'lqdsep-js-gsap-base' => array(
                'type' => 'js',
                'conditions' =>
                    $element->get_settings( 'enable_hover3d' ) === 'yes' ||
                    $element->get_settings( 'enable_reveal' ) === 'yes' ||
                    $element->get_settings( 'enable_interactive_swap' ) === 'yes'
            ),
            'lqdsep-js-three' => array(
                'type' => 'js',
                'conditions' =>
                    $element->get_settings( 'enable_interactive_swap' ) === 'yes'
            ),
            'lqdsep-js-interactive-swap' => array(
                'type' => 'js',
                'conditions' =>
                    $element->get_settings( 'enable_interactive_swap' ) === 'yes'
            ),
        );
        break;
    case 'ld_flipbox':
        $widget_options = array(
            'lqdsep-flipbox-base' => array(),
            'lqdsep-flipbox-bt' => array(
                'conditions' =>
                    $element->get_settings( 'direction' ) === 'ld-flipbox-bt'
            ),
            'lqdsep-flipbox-rl' => array(
                'conditions' =>
                    $element->get_settings( 'direction' ) === 'ld-flipbox-rl'
            ),
            'lqdsep-flipbox-tb' => array(
                'conditions' =>
                    $element->get_settings( 'direction' ) === 'ld-flipbox-tb'
            ),
            'lqdsep-flipbox-shadow' => array(
                'conditions' =>
                    $element->get_settings( 'shadow' ) === 'ld-flipbox-shadow'
            ),
            'lqdsep-flipbox-shadow-bt' => array(
                'conditions' =>
                    $element->get_settings( 'shadow' ) === 'ld-flipbox-shadow' &&
                    $element->get_settings( 'direction' ) === 'ld-flipbox-bt'
            ),
            'lqdsep-flipbox-shadow-tb' => array(
                'conditions' =>
                    $element->get_settings( 'shadow' ) === 'ld-flipbox-shadow' &&
                    $element->get_settings( 'direction' ) === 'ld-flipbox-tb'
            ),
            'lqdsep-flipbox-shadow-onhover' => array(
                'conditions' =>
                    $element->get_settings( 'shadow' ) === 'ld-flipbox-shadow-onhover'
            ),
            'lqdsep-flipbox-shadow-onhover-bt' => array(
                'conditions' =>
                    $element->get_settings( 'shadow' ) === 'ld-flipbox-shadow-onhover' &&
                    $element->get_settings( 'direction' ) === 'ld-flipbox-bt'
            ),
            'lqdsep-flipbox-shadow-onhover-tb' => array(
                'conditions' =>
                    $element->get_settings( 'shadow' ) === 'ld-flipbox-shadow-onhover' &&
                    $element->get_settings( 'direction' ) === 'ld-flipbox-tb'
            ),
        );
        break;
    case 'ld_fullproj':
        $widget_options = array(
            'lqdsep-video-bg-base' => array(
                'conditions' =>
                    $this->get_repeater_item_condition($element, 'identities', 'media_type', 'local_video')
            ),
            'lqdsep-fullscreen-project-base' => array(),
        );
        break;
    case 'ld_gallery':
        $widget_options = array(
            'lqdsep-carousel-base' => array(),
            'lqdsep-carousel-draggable' => array(),
            'lqdsep-carousel-dots-base' => array(),
            'lqdsep-carousel-dots-style-4' => array(),
            'lqdsep-carousel-dots-mobile-inside' => array(),
            'lqdsep-carousel-nav-base' => array(),
            'lqdsep-carousel-nav-floated' => array(),
            'lqdsep-carousel-nav-align-v-center' => array(),
            'lqdsep-carousel-nav-align-h-middle' => array(),
            'lqdsep-carousel-nav-size-lg' => array(),
            'lqdsep-carousel-nav-shaped-base' => array(),
            'lqdsep-carousel-nav-shaped-solid' => array(),
            'lqdsep-carousel-nav-shape-circle' => array(),
            'lqdsep-image-gallery-base' => array(),
            'lqdsep-js-imagesloaded-base' => array( 'type' => 'js' ),
            'lqdsep-js-flickity-base' => array( 'type' => 'js' ),
        );
        break;
    case 'ld_google_map':
        $widget_options = array(
            'lqdsep-google-map-info-box' => array(
                'conditions' =>
                    $element->get_settings('show_info_box') === 'yes'
            ),
            'lqdsep-google-map-custom-marker' => array(
                'conditions' =>
                    $element->get_settings('map_marker') === 'html'
            ),
            'lqdsep-icon-box-base' => array(
                'conditions' =>
                    $element->get_settings('show_info_box') === 'yes'
            ),
            'lqdsep-icon-box-inline' => array(
                'conditions' =>
                    $element->get_settings('show_info_box') === 'yes'
            ),
        );
        $widget_options = $this->merge_button_settings($widget_options, $this->get_button_param_options( $element, 'ib_' ));
        break;
    case 'ld_hotspots':
        $widget_options = array(
            'lqdsep-hotspot-base' => array(),
            'lqdsep-hotspot-item-x' => array(
                'conditions' =>
                    $this->get_repeater_item_condition($element, 'identities', 'position', 'lqd-hotspot-r') ||
                    $this->get_repeater_item_condition($element, 'identities', 'position', 'lqd-hotspot-l')
            ),
            'lqdsep-hotspot-item-y' => array(
                'conditions' =>
                    $this->get_repeater_item_condition($element, 'identities', 'position', 'lqd-hotspot-t') ||
                    $this->get_repeater_item_condition($element, 'identities', 'position', 'lqd-hotspot-b')
            ),
            'lqdsep-hotspot-item-t' => array(
                'conditions' =>
                    $this->get_repeater_item_condition($element, 'identities', 'position', 'lqd-hotspot-t')
            ),
            'lqdsep-hotspot-item-r' => array(
                'conditions' =>
                    $this->get_repeater_item_condition($element, 'identities', 'position', 'lqd-hotspot-r')
            ),
            'lqdsep-hotspot-item-b' => array(
                'conditions' =>
                    $this->get_repeater_item_condition($element, 'identities', 'position', 'lqd-hotspot-b')
            ),
            'lqdsep-hotspot-item-l' => array(
                'conditions' =>
                    $this->get_repeater_item_condition($element, 'identities', 'position', 'lqd-hotspot-l')
            ),
        );
        break;
    case 'ld_icon_box':
        $widget_options = array(
            'lqdsep-icon-box-base' => array(),
            'lqdsep-icon-box-bubble' => array(
                'conditions' =>
                    $element->get_settings('get_bubble_classname') === 'iconbox-bubble'
            ),
            'lqdsep-icon-box-button' => array(
                'conditions' =>
                    $element->get_settings('ib_show_button') === 'yes'
            ),
            'lqdsep-icon-box-content-show-onhover' => array(
                'conditions' =>
                    $element->get_settings('toggleable') === 'yes'
            ),
            'lqdsep-icon-box-content-show-onhover-bubble' => array(
                'conditions' =>
                    $element->get_settings('get_content_hover_classname') === 'iconbox-contents-show-onhover' &&
                    $element->get_settings('get_bubble_classname') === 'iconbox-bubble'
            ),
            'lqdsep-icon-box-heading-arrow-onhover' => array(
                'conditions' =>
                    $element->get_settings('heading_icon_onhover') === 'yes'
            ),
            'lqdsep-icon-box-icon-animated' => array(
                'conditions' =>
                    $element->get_settings('i_type') &&
                    $element->get_settings('i_type') === 'image' &&
                    $element->get_settings('i_animated') === 'yes'
            ),
            'lqdsep-icon-box-icon-gradient' => array(
                'conditions' =>
                    $element->get_settings('enable_gradient_icon') === 'yes' &&
                    $element->get_settings('i_type') !== 'image'
            ),
            'lqdsep-icon-box-icon-linked' => array(
                'conditions' =>
                    $element->get_settings('position') === 'iconbox-side' &&
                    $element->get_settings('i_linked') === 'iconbox-icon-linked'
            ),
            'lqdsep-icon-box-icon-linked-middle' => array(
                'conditions' =>
                    $element->get_settings('position') === 'iconbox-side' &&
                    $element->get_settings('i_linked') === 'iconbox-icon-linked' &&
                    $element->get_settings('items_alignment') === 'align-items-center'
            ),
            'lqdsep-icon-box-icon-ripple' => array(
                'conditions' =>
                    $element->get_settings('i_shape') !== '' &&
                    $element->get_settings('i_shape') !== 'custombg' &&
                    $element->get_settings('i_shape_options') === 'yes' &&
                    $element->get_settings('i_ripple_effect') === 'yes'
            ),
            'lqdsep-icon-box-icon-shaped-base' => array(
                'conditions' =>
                    $element->get_settings('i_shape') !== '' &&
                    $element->get_settings('i_shape') !== 'custombg'
            ),
            'lqdsep-icon-box-icon-shaped-circle' => array(
                'conditions' =>
                    $element->get_settings('i_shape') === 'circle'
            ),
            'lqdsep-icon-box-icon-shaped-custombg' => array(
                'conditions' =>
                    $element->get_settings('i_shape') === 'custombg'
            ),
            'lqdsep-icon-box-icon-shaped-lozenge' => array(
                'conditions' =>
                    $element->get_settings('i_shape') === 'lozenge'
            ),
            'lqdsep-icon-box-icon-svg' => array(
                'conditions' =>
                    $element->get_settings('i_type') &&
                    $element->get_settings('i_type') === 'image'
            ),
            'lqdsep-icon-box-inline' => array(
                'conditions' =>
                    $element->get_settings('position') === 'iconbox-inline'
            ),
            'lqdsep-icon-box-label-base' => array(
                'conditions' =>
                    $element->get_settings('show_label') === 'yes' &&
                    ! empty( $element->get_settings('label') )
            ),
            'lqdsep-icon-box-label-incontent' => array(
                'conditions' =>
                    $element->get_settings('show_label') === 'yes' &&
                    $element->get_settings('label_position') === 'in_content' &&
                    ! empty( $element->get_settings('label') )
            ),
            'lqdsep-icon-box-scale' => array(
                'conditions' =>
                    $element->get_settings('enable_scale_animation') === 'yes'
            ),
            'lqdsep-icon-box-side' => array(
                'conditions' =>
                    $element->get_settings('position') === 'iconbox-side'
            ),
            'lqdsep-js-aniamted-icon' => array(
                'type' => 'js',
                'conditions' =>
                    $element->get_settings('i_type') &&
                    $element->get_settings('i_type') === 'image' &&
                    $element->get_settings('i_animated') === 'yes'
            ),
            'lqdsep-js-imagesloaded-base' => array(
                'type' => 'js',
                'conditions' =>
                    $element->get_settings('toggleable') === 'yes' ||
                    ( $element->get_settings( 'show_button' ) === 'yes' &&  $element->get_settings( 'ib_link_type' ) === 'local_scroll' )
            ),
            'lqdsep-js-gsap-base' => array(
                'type' => 'js',
                'conditions' =>
                    $element->get_settings('toggleable') === 'yes'
            ),
        );
        $widget_options = $this->merge_button_settings($widget_options, $this->get_button_param_options( $element, 'ib_' ));
        break;
    case 'ld_icon_box_circle':
        $widget_options = array(
            'lqdsep-icon-box-circle-base' => array(),
            'lqdsep-js-fastdom-base' => array(
                'type' => 'js',
                'conditions' =>
                    $element->get_settings('enable_animation') === 'yes'
            ),
            'lqdsep-js-gsap-base' => array( 'type' => 'js' ),
        );
        break;
    case 'ld_images_comparison':
        $widget_options = array(
            'lqdsep-image-comparison-base' => array(),
        );
        break;
    case 'ld_image_text_overlay':
        $widget_options = array(
            'lqdsep-image-overlay-text' => array(),
            'lqdsep-block-reveal-base' => array(),
            'lqdsep-js-imagesloaded-base' => array( 'type' => 'js' ),
            'lqdsep-js-gsap-base' => array( 'type' => 'js' ),
        );
        break;
    case 'ld_imgtxt_slider':
        $widget_options = array(
            'lqdsep-image-text-slider-base' => array(),
            'lqdsep-video-bg-base' => array(
                'conditions' =>
                    $this->get_repeater_item_condition($element, 'identities', 'media_type', 'local_video') ||
                    $this->get_repeater_item_condition($element, 'identities', 'media_type', 'yt_video')
            ),
            'lqdsep-js-ytplayer' => array(
                'type' => 'js',
                'conditions' =>
                    $this->get_repeater_item_condition($element, 'identities', 'media_type', 'yt_video')
            ),
        );
        break;
    case 'ld_instagram':
        $widget_options = array(
            'lqdsep-instagram-feed-base' => array(),
        );
        $widget_options = $this->merge_button_settings($widget_options, $this->get_button_param_options( $element, 'ib_' ));
        break;
    case 'ld_interactive_text_image':
        $widget_options = array(
            'lqdsep-interactive-text-image-base' => array(),
            'lqdsep-js-gsap-base' => array( 'type' => 'js' ),
            'lqdsep-js-mouse-pos' => array( 'type' => 'js' ),
        );
        break;
    case 'ld_mask_slider':
        $widget_options = array(
            'lqdsep-mask-slider-base' => array(),
            'lqdsep-js-imagesloaded-base' => array( 'type' => 'js' ),
            'lqdsep-js-switch-active' => array( 'type' => 'js' ),
        );
        break;
    case 'ld_media_element':
        $widget_options = array(
            'lqdsep-lightbox-base' => array(
                'conditions' =>
                    $this->get_repeater_item_condition($element, 'items', 'link_type', 'image') ||
                    $this->get_repeater_item_condition($element, 'items', 'link_type', 'video')
            ),
            'lqdsep-modal-base' => array(
                'conditions' =>
                    $this->get_repeater_item_condition($element, 'items', 'link_type', 'iframe')
            ),
            'lqdsep-media-element-base' => array(),
            'lqdsep-media-element-contents-visible' => array(
                'conditions' =>
                    $this->get_repeater_item_condition($element, 'items', 'visible_content', 'yes')
            ),
            'lqdsep-media-element-icon' => array(
                'conditions' =>
                    $this->get_repeater_item_condition($element, 'items', 'add_icon', 'yes')
            ),
            'lqdsep-media-element-shadow-onhover' => array(
                'conditions' =>
                    $this->get_repeater_item_condition($element, 'items', 'shadow_content', 'yes')
            ),
            'lqdsep-media-element-shadow-onhover' => array(
                'conditions' =>
                    $this->get_repeater_item_condition($element, 'items', 'shadow_content', 'yes')
            ),
            'lqdsep-js-imagesloaded-base' => array( 'type' => 'js' ),
            'lqdsep-js-isotope' => array( 'type' => 'js' ),
            'lqdsep-js-isotope-packery' => array( 'type' => 'js' ),
            'lqdsep-js-lightbox' => array(
                'type' => 'js',
                'conditions' =>
                    $this->get_repeater_item_condition($element, 'items', 'link_type', 'image') ||
                    $this->get_repeater_item_condition($element, 'items', 'link_type', 'video')
            ),
            'lqdsep-js-modal' => array(
                'type' => 'js',
                'conditions' =>
                    $this->get_repeater_item_condition($element, 'items', 'link_type', 'iframe')
            ),
        );
        break;
    case 'ld_modal_window':
        $widget_options = array(
            'lqdsep-modal-base' => array(),
            'lqdsep-modal-type-default' => array( 'conditions' => $element->get_settings( 'modal_type' ) === 'default' ),
            'lqdsep-modal-type-fullscreen' => array( 'conditions' => $element->get_settings( 'modal_type' ) === 'fullscreen' ),
            'lqdsep-modal-type-box' => array( 'conditions' => $element->get_settings( 'modal_type' ) === 'box' ),
            'lqdsep-modal-type-side' => array( 'conditions' => $element->get_settings( 'modal_type' ) === 'side' ),
            'lqdsep-js-modal' => array( 'type' => 'js' ),
        );
        break;
    case 'ld_milestone':
        $widget_options = array(
            'lqdsep-milestone-base' => array(),
        );
        break;
    case 'ld_newsletter':
        $widget_options = array(
            'lqdsep-newsletter-base' => array(),
            'lqdsep-newsletter-inputs-solid' => array(
                'conditions' =>
                    $element->get_settings('style') === 'ld-sf--input-solid'
            ),
            'lqdsep-newsletter-inputs-underline' => array(
                'conditions' =>
                    $element->get_settings('style') === 'ld-sf--input-underlined'
            ),
            'lqdsep-newsletter-border-none' => array(
                'conditions' =>
                    $element->get_settings('inputs_border') === 'ld-sf--border-none'
            ),
            'lqdsep-newsletter-border-thin' => array(
                'conditions' =>
                    $element->get_settings('inputs_border') === 'ld-sf--border-thin'
            ),
            'lqdsep-newsletter-border-thick' => array(
                'conditions' =>
                    $element->get_settings('inputs_border') === 'ld-sf--border-thick'
            ),
            'lqdsep-newsletter-border-thicker' => array(
                'conditions' =>
                    $element->get_settings('inputs_border') === 'ld-sf--border-thicker'
            ),
            'lqdsep-newsletter-button-inline' => array(
                'conditions' =>
                    $element->get_settings('btn_position') === 'ld-sf--button-inline'
            ),
            'lqdsep-newsletter-button-inside' => array(
                'conditions' =>
                    $element->get_settings('btn_position') === 'ld-sf--button-inside'
            ),
            'lqdsep-newsletter-button-block' => array(
                'conditions' =>
                    $element->get_settings('btn_position') === 'ld-sf--button-block'
            ),
            'lqdsep-newsletter-button-border' => array(
                'conditions' =>
                    $element->get_settings('btn_style') === 'ld-sf--button-bordered'
            ),
            'lqdsep-newsletter-button-underline' => array(
                'conditions' =>
                    $element->get_settings('btn_style') === 'ld-sf--button-underlined'
            ),
            'lqdsep-newsletter-button-plain' => array(
                'conditions' =>
                    $element->get_settings('btn_style') === 'ld-sf--button-naked'
            ),
            'lqdsep-newsletter-button-equal' => array(
                'conditions' =>
                    (
                        $element->get_settings('btn_style') === 'ld-sf--button-solid' ||
                        $element->get_settings('btn_style') === 'ld-sf--button-bordered'
                    ) &&
                    $element->get_settings('btn_eql') === 'ld-sf--button-eql'
            ),
            'lqdsep-newsletter-button-hidden' => array(
                'conditions' =>
                    $element->get_settings('btn_state') === 'ld-sf--button-hidden'
            ),
            'lqdsep-newsletter-button-inside-border' => array(
                'conditions' =>
                    $element->get_settings('btn_position') === 'ld-sf--button-inside' &&
                    $element->get_settings('btn_style') === 'ld-sf--button-bordered'
            ),
            'lqdsep-newsletter-inputs-sharp' => array(
                'conditions' =>
                    $element->get_settings('inputs_radius') === 'ld-sf--sharp'
            ),
            'lqdsep-newsletter-inputs-round' => array(
                'conditions' =>
                    $element->get_settings('inputs_radius') === 'ld-sf--round'
            ),
            'lqdsep-newsletter-inputs-circle' => array(
                'conditions' =>
                    $element->get_settings('inputs_radius') === 'ld-sf--circle'
            ),
            'lqdsep-newsletter-inputs-has-border' => array(
                'conditions' =>
                    $element->get_settings('inputs_border') !== 'ld-sf--border-none'
            ),
            'lqdsep-newsletter-inputs-inline' => array(
                'conditions' =>
                    $element->get_settings('show_inline') === 'ld-sf--inputs-inline'
            ),
            'lqdsep-newsletter-inputs-shadow' => array(
                'conditions' =>
                    $element->get_settings('inputs_shadow') === 'ld-sf--input-shadow'
            ),
            'lqdsep-newsletter-inputs-shadow-inner' => array(
                'conditions' =>
                    $element->get_settings('inputs_shadow') === 'ld-sf--input-inner-shadow'
            ),
            'lqdsep-newsletter-inputs-inline-shadow' => array(
                'conditions' =>
                    $element->get_settings('show_inline') === 'ld-sf--inputs-inline' &&
                    $element->get_settings('inputs_shadow') === 'ld-sf--input-shadow'
            ),
            'lqdsep-newsletter-size-lg' => array(
                'conditions' =>
                    $element->get_settings('inputs_size') === 'ld-sf--size-lg'
            ),
            'lqdsep-newsletter-size-md' => array(
                'conditions' =>
                    $element->get_settings('inputs_size') === 'ld-sf--size-md'
            ),
            'lqdsep-newsletter-size-sm' => array(
                'conditions' =>
                    $element->get_settings('inputs_size') === 'ld-sf--size-sm'
            ),
            'lqdsep-newsletter-size-xl' => array(
                'conditions' =>
                    $element->get_settings('inputs_size') === 'ld-sf--size-xl'
            ),
            'lqdsep-newsletter-size-xs' => array(
                'conditions' =>
                    $element->get_settings('inputs_size') === 'ld-sf--size-xs'
            ),
            'lqdsep-newsletter-submit-icon' => array(
                'conditions' =>
                    $element->get_settings('i_add_icon') === 'true'
            ),
        );
        break;
    case 'ld_overlay_link':
        $widget_options = array(
            'lqdsep-overlay-link-base' => array(),
            'lqdsep-lightbox-base' => array(
                'conditions' =>
                    $element->get_settings( 'link_type' )  === 'lightbox'
            ),
            'lqdsep-modal-base' => array(
                'conditions' =>
                    $element->get_settings( 'link_type' )  === 'modal_window'
            ),
            'lqdsep-js-imagesloaded-base' => array(
                'type' => 'js',
                'conditions' =>
                    $element->get_settings( 'link_type' ) === 'local_scroll'
            ),
            'lqdsep-js-lightbox' => array(
                'type' => 'js',
                'conditions' =>
                    $element->get_settings( 'link_type' )  === 'lightbox'
            ),
            'lqdsep-js-modal' => array(
                'type' => 'js',
                'conditions' =>
                    $element->get_settings( 'link_type' )  === 'modal_window'
            ),
        );
        break;
    case 'ld_particles':
        $widget_options = array(
            'lqdsep-particles-visible-onhover' => array(
                'conditions' =>
                    $element->get_settings('visible_on_hover') === 'yes'
            ),
            'lqdsep-js-particles' => array( 'type' => 'js' ),
        );
        break;
    case 'ld_portfolio':
        $widget_options = array(
            // Pagination
            'lqdsep-pagination-base' => array( 'conditions' => $element->get_settings( 'pagination' ) === 'pagination' ),
            'lqdsep-btn-ajax-loadmore' => array( 'conditions' => $element->get_settings( 'pagination' ) === 'ajax' ),
            // Filter list
            'lqdsep-filter-list-base' => array( 'conditions' => $element->get_settings( 'show_filter' ) === 'yes' ),
            'lqdsep-filter-list-counter' => array( 
                'conditions' =>
                    $element->get_settings( 'show_filter' ) === 'yes' &&
                    $element->get_settings( 'filter_enable_counter' ) === 'yes'
            ),
            'lqdsep-filter-list-decorated' => array( 
                'conditions' =>
                    $element->get_settings( 'show_filter' ) === 'yes' &&
                    (
                        $element->get_settings( 'filter_decoration' ) !== '' ||
                        $element->get_settings( 'style' ) === 'style03' ||
                        $element->get_settings( 'style' ) === 'style04' ||
                        $element->get_settings( 'style' ) === 'style05'
                    )
            ),
            'lqdsep-filter-list-inline' => array( 
                'conditions' =>
                    $element->get_settings( 'show_filter' ) === 'yes' &&
                    (
                        $element->get_settings( 'style' ) !== 'style04'
                    )
            ),
            'lqdsep-filter-list-lg' => array( 
                'conditions' =>
                    $element->get_settings( 'show_filter' ) === 'yes' &&
                    $element->get_settings( 'filter_size' ) === 'size-lg'
            ),
            'lqdsep-filter-list-md' => array( 
                'conditions' =>
                    $element->get_settings( 'show_filter' ) === 'yes' &&
                    $element->get_settings( 'filter_size' ) === 'size-md'
            ),
            'lqdsep-filter-list-sm' => array( 
                'conditions' =>
                    $element->get_settings( 'show_filter' ) === 'yes' &&
                    $element->get_settings( 'filter_size' ) === 'size-sm'
            ),
            'lqdsep-filter-list-line-through' => array( 
                'conditions' =>
                    $element->get_settings( 'show_filter' ) === 'yes' &&
                    $element->get_settings( 'filter_decoration' ) === 'filters-line-through'
            ),
            'lqdsep-filter-list-scheme-light' => array( 
                'conditions' =>
                    $element->get_settings( 'show_filter' ) === 'yes' &&
                    $element->get_settings( 'filter_color' ) === 'filter-list-scheme-light'
            ),
            'lqdsep-filter-list-style-dropdown' => array( 
                'conditions' =>
                    $element->get_settings( 'show_filter' ) === 'yes' &&
                    $element->get_settings( 'filter_style' ) === 'lqd-filter-style-dropdown'
            ),
            'lqdsep-filter-list-title-base' => array( 
                'conditions' =>
                    $element->get_settings( 'show_filter' ) === 'yes' &&
                    ! empty( $element->get_settings( 'filter_title' ) )
            ),
            'lqdsep-filter-list-title-xxlg' => array( 
                'conditions' =>
                    $element->get_settings( 'show_filter' ) === 'yes' &&
                    $element->get_settings( 'filter_title_size' ) === 'size-xxlg'
            ),
            'lqdsep-filter-list-title-xlg' => array( 
                'conditions' =>
                    $element->get_settings( 'show_filter' ) === 'yes' &&
                    $element->get_settings( 'filter_title_size' ) === 'size-xlg'
            ),
            'lqdsep-filter-list-title-lg' => array( 
                'conditions' =>
                    $element->get_settings( 'show_filter' ) === 'yes' &&
                    $element->get_settings( 'filter_title_size' ) === 'size-lg'
            ),
            'lqdsep-filter-list-title-md' => array( 
                'conditions' =>
                    $element->get_settings( 'show_filter' ) === 'yes' &&
                    $element->get_settings( 'filter_title_size' ) === 'size-md'
            ),
            'lqdsep-filter-list-title-sm' => array( 
                'conditions' =>
                    $element->get_settings( 'show_filter' ) === 'yes' &&
                    $element->get_settings( 'filter_title_size' ) === 'size-sm'
            ),
            'lqdsep-filter-list-underline' => array( 
                'conditions' =>
                    $element->get_settings( 'show_filter' ) === 'yes' &&
                    (
                        $element->get_settings( 'style' ) === 'style03' ||
                        $element->get_settings( 'style' ) === 'style04' ||
                        $element->get_settings( 'style' ) === 'style05'
                    )
            ),
            'lqdsep-filter-list-underline-alt' => array( 
                'conditions' =>
                    $element->get_settings( 'show_filter' ) === 'yes' &&
                    (
                        $element->get_settings( 'style' ) === 'style03' ||
                        $element->get_settings( 'style' ) === 'style04' ||
                        $element->get_settings( 'style' ) === 'style05'
                    )
            ),
            'lqdsep-carousel-base' => array(
                'conditions' =>
                    $element->get_settings( 'style' ) === 'style03' ||
                    $element->get_settings( 'style' ) === 'style04' ||
                    $element->get_settings( 'style' ) === 'style05'
            ),
            'lqdsep-carousel-draggable' => array(
                'conditions' =>
                    $element->get_settings( 'style' ) === 'style03' ||
                    $element->get_settings( 'style' ) === 'style04' ||
                    $element->get_settings( 'style' ) === 'style05'
            ),
            'lqdsep-carousel-nav-base' => array(
                'conditions' =>
                    $element->get_settings( 'style' ) === 'style03' ||
                    $element->get_settings( 'style' ) === 'style04'
            ),
            'lqdsep-carousel-dots-base' => array(
                'conditions' =>
                    $element->get_settings( 'style' ) === 'style03' ||
                    $element->get_settings( 'style' ) === 'style04' ||
                    $element->get_settings( 'style' ) === 'style05'
            ),
            'lqdsep-carousel-nav-floated' => array(
                'conditions' => $element->get_settings( 'style' ) === 'style04'
            ),
            'lqdsep-carousel-nav-floated-left' => array(
                'conditions' => $element->get_settings( 'style' ) === 'style04'
            ),
            'lqdsep-carousel-nav-align-h-bottom' => array(
                'conditions' => $element->get_settings( 'style' ) === 'style04'
            ),
            'lqdsep-carousel-nav-shape-square' => array(
                'conditions' => $element->get_settings( 'style' ) === 'style04'
            ),
            'lqdsep-carousel-nav-shaped-base' => array(
                'conditions' => $element->get_settings( 'style' ) === 'style04'
            ),
            'lqdsep-carousel-nav-shaped-solid' => array(
                'conditions' => $element->get_settings( 'style' ) === 'style04'
            ),
            'lqdsep-carousel-nav-size-lg' => array(
                'conditions' => $element->get_settings( 'style' ) === 'style04'
            ),
            'lqdsep-carousel-nav-shadowed' => array(
                'conditions' => $element->get_settings( 'style' ) === 'style04'
            ),
            'lqdsep-portfolio-base' => array(),
            'lqdsep-portfolio-image' => array(),
            'lqdsep-portfolio-overlay-bg' => array(),
            'lqdsep-portfolio-content-v' => array(
                'conditions' =>
                    $element->get_settings( 'style' ) === 'style03' ||
                    $element->get_settings( 'style' ) === 'style04'
            ),
            'lqdsep-portfolio-details-h-end' => array(
                'conditions' =>
                    $element->get_settings( 'horizontal_alignment' ) === 'pf-details-h-end' ||
                    ( $element->get_settings( 'horizontal_alignment' ) === '' && $element->get_settings( 'style' ) === 'style01' )
            ),
            'lqdsep-portfolio-details-h-mid' => array(
                'conditions' => $element->get_settings( 'horizontal_alignment' ) === 'pf-details-h-mid'
            ),
            'lqdsep-portfolio-details-h-str' => array(
                'conditions' =>
                    $element->get_settings( 'horizontal_alignment' ) === 'pf-details-h-str' ||
                    ( $element->get_settings( 'horizontal_alignment' ) === '' && $element->get_settings( 'style' ) === 'style02' ) ||
                    ( $element->get_settings( 'horizontal_alignment' ) === '' && $element->get_settings( 'style' ) === 'style03' ) ||
                    ( $element->get_settings( 'horizontal_alignment' ) === '' && $element->get_settings( 'style' ) === 'style04' ) ||
                    ( $element->get_settings( 'horizontal_alignment' ) === '' && $element->get_settings( 'style' ) === 'style05' )
            ),
            'lqdsep-portfolio-filterable-carousel' => array(
                'conditions' =>
                    $element->get_settings( 'style' ) === 'style04' ||
                    (
                        $element->get_settings( 'show_filter' ) === 'yes' &&
                        (
                            $element->get_settings( 'style' ) === 'style03' ||
                            $element->get_settings( 'style' ) === 'style05'
                        )
                    )
            ),
            'lqdsep-portfolio-overlay-bg-scale' => array(
                'conditions' =>
                    $element->get_settings( 'style' ) === 'style02' ||
                    $element->get_settings( 'style' ) === 'style03'
            ),
            'lqdsep-portfolio-dark' => array(
                'conditions' =>
                    $element->get_settings( 'color_type' ) === 'lqd-pf-dark' ||
                    ( $element->get_settings( 'color_type' ) === '' && $element->get_settings( 'style' ) === 'style01' ) ||
                    ( $element->get_settings( 'color_type' ) === '' && $element->get_settings( 'style' ) === 'style02' ) ||
                    ( $element->get_settings( 'color_type' ) === '' && $element->get_settings( 'style' ) === 'style03' ) ||
                    ( $element->get_settings( 'color_type' ) === '' && $element->get_settings( 'style' ) === 'style06' )
            ),
            'lqdsep-portfolio-light' => array(
                'conditions' =>
                    $element->get_settings( 'color_type' ) === 'lqd-pf-light' ||
                    ( $element->get_settings( 'color_type' ) === '' && $element->get_settings( 'style' ) === 'style04' ) ||
                    ( $element->get_settings( 'color_type' ) === '' && $element->get_settings( 'style' ) === 'style05' )
            ),
            'lqdsep-portfolio-style-1' => array( 'conditions' => $element->get_settings( 'style' ) === 'style01' ),
            'lqdsep-portfolio-style-2' => array( 'conditions' => $element->get_settings( 'style' ) === 'style02' ),
            'lqdsep-portfolio-style-3' => array( 'conditions' => $element->get_settings( 'style' ) === 'style03' ),
            'lqdsep-portfolio-style-4' => array( 'conditions' => $element->get_settings( 'style' ) === 'style04' ),
            'lqdsep-portfolio-style-5' => array( 'conditions' => $element->get_settings( 'style' ) === 'style05' ),
            'lqdsep-portfolio-style-6' => array( 'conditions' => $element->get_settings( 'style' ) === 'style06' ),
            'lqdsep-js-imagesloaded-base' => array( 'type' => 'js', ),
            'lqdsep-js-flickity-base' => array(
                'type' => 'js',
                'conditions' =>
                    $element->get_settings( 'style' ) === 'style03' ||
                    $element->get_settings( 'style' ) === 'style04' ||
                    $element->get_settings( 'style' ) === 'style05'
            ),
            'lqdsep-js-isotope' => array(
                'type' => 'js',
                'conditions' =>
                    $element->get_settings( 'style' ) === 'style01' ||
                    $element->get_settings( 'style' ) === 'style02' ||
                    $element->get_settings( 'style' ) === 'style06' ||
                    $element->get_settings( 'show_filter' ) === 'yes'
            ),
            'lqdsep-js-isotope-packery' => array(
                'type' => 'js',
                'conditions' =>
                    $element->get_settings( 'style' ) === 'style01' ||
                    $element->get_settings( 'style' ) === 'style02' ||
                    $element->get_settings( 'style' ) === 'style06' ||
                    $element->get_settings( 'show_filter' ) === 'yes'
            ),
            'lqdsep-js-jquery-ui-base' => array(
                'type' => 'js',
                'conditions' => $element->get_settings( 'show_filter' ) === 'yes'
            ),
            'lqdsep-js-jquery-ui-touch' => array(
                'type' => 'js',
                'conditions' => $element->get_settings( 'show_filter' ) === 'yes'
            ),
        );
        $widget_options = $this->merge_button_settings($widget_options, $this->get_button_param_options( $element, 'ib_' ));
        break;
    case 'ld_single_portfolio_cover':
        $widget_options = array(
            'lqdsep-pf-single-meta-title' => array(),
            'lqdsep-pf-single-meta-scroll-down-link' => array(),
            'lqdsep-pf-single-meta-cover' => array(),
        );
        break;
    case 'ld_single_portfolio_meta':
        $widget_options = array(
            'lqdsep-pf-single-meta-meta' => array(),
        );
        break;
    case 'ld_single_portfolio_nav':
        $widget_options = array(
            'lqdsep-pf-single-meta-nav' => array(),
        );
        break;
    case 'ld_single_portfolio_related':
        $widget_options = array(
            'lqdsep-carousel-base' => array(),
            'lqdsep-carousel-nav-base' => array(),
            'lqdsep-carousel-nav-floated' => array(),
            'lqdsep-carousel-nav-align-v-center' => array(),
            'lqdsep-carousel-nav-align-h-middle' => array(),
            'lqdsep-carousel-nav-shape-square' => array(),
            'lqdsep-carousel-nav-shaped-base' => array(),
            'lqdsep-carousel-nav-shaped-solid' => array(),
            'lqdsep-carousel-nav-size-lg' => array(),
            'lqdsep-portfolio-base' => array(),
            'lqdsep-portfolio-image' => array(),
            'lqdsep-portfolio-overlay-bg' => array(),
            'lqdsep-portfolio-dark' => array(),
            'lqdsep-portfolio-details-h-str' => array(),
            'lqdsep-portfolio-overlay-bg-scale' => array(),    
            'lqdsep-portfolio-style-2' => array(),
            'lqdsep-pf-single-meta-related-projects' => array(),
            'lqdsep-js-imagesloaded-base' => array( 'type' => 'js' ),
            'lqdsep-js-flickity-base' => array( 'type' => 'js' ),
        );
        break;
    case 'ld_price_table':
        $widget_options = array(
            'lqdsep-pricing-table-base' => array(),
            'lqdsep-pricing-table-description' => array(),
            'lqdsep-pricing-table-featured' => array( 'conditions' => $element->get_settings( 'featured_tag' ) === 'yes' ),
            'lqdsep-pricing-table-foot' => array(
                'conditions' =>
                    ! empty( $element->get_settings( 'footer_text' ) ) &&
                    $element->get_settings( 'template' ) === 'style01'
            ),
            'lqdsep-pricing-table-label' => array(
                'conditions' =>
                    $element->get_settings( 'featured_tag' ) === 'yes' &&
                    ! empty( $element->get_settings( 'featured_label' ) )
            ),
            'lqdsep-pricing-table-scale-bg' => array( 'conditions' => $element->get_settings( 'pt_scale_bg' ) === 'yes' ),
            'lqdsep-pricing-table-style-1' => array( 'conditions' => $element->get_settings( 'template' ) === 'style01' ),
            'lqdsep-pricing-table-style-2' => array( 'conditions' => $element->get_settings( 'template' ) === 'style02' ),
            'lqdsep-pricing-table-style-3' => array( 'conditions' => $element->get_settings( 'template' ) === 'style03' ),
        );
        $widget_options = $this->merge_button_settings($widget_options, $this->get_button_param_options( $element, 'ib_' ));
        break;
    case 'ld_process_box':
        $widget_options = array(
            'lqdsep-process-box-base' => array(),
            'lqdsep-process-box-shaped' => array(),
            'lqdsep-process-box-icon-between' => array(
                'conditions' =>
                    $element->get_settings( 'style' ) === 'style01' ||
                    $element->get_settings( 'style' ) === 'style03'
            ),
            'lqdsep-process-box-icon-between-middle' => array(
                'conditions' =>
                    $element->get_settings( 'style' ) === 'style03'
            ),
            'lqdsep-process-box-icon' => array(
                'conditions' =>
                    $element->get_settings( 'style' ) === 'style04'
            ),
            'lqdsep-process-box-num' => array(),
            'lqdsep-process-box-shape-border' => array(
                'conditions' =>
                    $element->get_settings( 'style' ) === 'style01' ||
                    $element->get_settings( 'style' ) === 'style02'
            ),
            'lqdsep-process-box-zigzag' => array(
                'conditions' =>
                    $element->get_settings( 'style' ) === 'style02'
            ),
            'lqdsep-process-box-style-1' => array( 'conditions' => $element->get_settings( 'style' ) === 'style01' ),
            'lqdsep-process-box-style-2' => array( 'conditions' => $element->get_settings( 'style' ) === 'style02' ),
            'lqdsep-process-box-style-3' => array( 'conditions' => $element->get_settings( 'style' ) === 'style03' ),
            'lqdsep-process-box-style-4' => array( 'conditions' => $element->get_settings( 'style' ) === 'style04' ),
            'lqdsep-process-box-style-5' => array( 'conditions' => $element->get_settings( 'style' ) === 'style05' ),
        );
        break;
    case 'ld_progressbar':
        $widget_options = array(
            'lqdsep-progressbar-base' => array(),
            'lqdsep-progressbar-values-inline' => array( 'conditions' => $element->get_settings( 'label_position' ) === 'lqd-progressbar-values-inline' ),
        );
        break;
    case 'ld_roadmap':
        $widget_options = array(
            'lqdsep-roadmap-base' => array(),
        );
        break;
    case 'ld_tabs':
        $widget_options = array(
            'lqdsep-tab-base' => array(),
            'lqdsep-tab-nav-base' => array(),
            'lqdsep-tab-arrows' => array(
                'conditions' =>
                    $element_template === 'style08'
            ),
            'lqdsep-tab-nav-has-btn' => array(
                'conditions' =>
                    $element->get_settings( 'show_button' ) === 'yes'
            ),
            'lqdsep-tab-nav-icon-inline' => array(
                'conditions' =>
                    $element->get_settings( 'style' ) === 'style04' ||
                    $element->get_settings( 'style' ) === 'style07'
            ),
            'lqdsep-tab-nav-iconbox' => array(
                'conditions' =>
                    $element->get_settings( 'style' ) === 'style01' ||
                    $element->get_settings( 'style' ) === 'style02' ||
                    $element->get_settings( 'style' ) === 'style03' ||
                    $element->get_settings( 'style' ) === 'style04'
            ),
            'lqdsep-tab-nav-plain' => array(
                'conditions' =>
                    $element->get_settings( 'style' ) === 'style06' ||
                    $element->get_settings( 'style' ) === 'style07'
            ),
            'lqdsep-tab-style-1' => array( 'conditions' => $element->get_settings( 'style' ) === 'style01' ),
            'lqdsep-tab-style-2' => array( 'conditions' => $element->get_settings( 'style' ) === 'style02' ),
            'lqdsep-tab-style-3' => array( 'conditions' => $element->get_settings( 'style' ) === 'style03' ),
            'lqdsep-tab-style-4' => array( 'conditions' => $element->get_settings( 'style' ) === 'style04' ),
            'lqdsep-tab-style-5' => array( 'conditions' => $element->get_settings( 'style' ) === 'style05' ),
            'lqdsep-tab-style-6' => array( 'conditions' => $element->get_settings( 'style' ) === 'style06' ),
            'lqdsep-tab-style-7' => array( 'conditions' => $element->get_settings( 'style' ) === 'style07' ),
            'lqdsep-tab-style-8' => array( 'conditions' => $element->get_settings( 'style' ) === 'style08' ),
        );
        break;
    case 'ld_team_member':
        $widget_options = array(
            'lqdsep-custom-animations' => array(
                'conditions' =>
                    $element->get_settings( 'template' ) === 'lqd-tm-style-1' ||
                    $element->get_settings( 'template' ) === 'lqd-tm-style-2'
            ),
            'lqdsep-block-reveal-base' => array(
                'conditions' =>
                    $element->get_settings( 'template' ) === 'lqd-tm-style-1' ||
                    $element->get_settings( 'template' ) === 'lqd-tm-style-2'
            ),
            'lqdsep-social-icon-base' => array(
                'conditions' =>
                    $element->get_settings( 'list' ) &&
                    (
                        $element->get_settings( 'template' ) === 'lqd-tm-style-2' ||
                        $element->get_settings( 'template' ) === 'lqd-tm-style-3'
                    )
            ),
            'lqdsep-social-icon-vertical' => array(
                'conditions' =>
                    $element->get_settings( 'list' ) &&
                    (
                        $element->get_settings( 'template' ) === 'lqd-tm-style-2' ||
                        $element->get_settings( 'template' ) === 'lqd-tm-style-3'
                    )
            ),
            'lqdsep-team-member-base' => array(),
            'lqdsep-team-member-style-1' => array( 'conditions' => $element->get_settings( 'template' ) === 'lqd-tm-style-1' ),
            'lqdsep-team-member-style-2' => array( 'conditions' => $element->get_settings( 'template' ) === 'lqd-tm-style-2' ),
            'lqdsep-team-member-style-3' => array( 'conditions' => $element->get_settings( 'template' ) === 'lqd-tm-style-3' ),
            'lqdsep-team-member-style-4' => array( 'conditions' => $element->get_settings( 'template' ) === 'lqd-tm-style-4' ),
            'lqdsep-team-member-style-5' => array( 'conditions' => $element->get_settings( 'template' ) === 'lqd-tm-style-5' ),
            'lqdsep-js-imagesloaded-base' => array(
                'type' => 'js',
                'conditions' =>
                    $element->get_settings( 'template' ) === 'lqd-tm-style-2'
            ),
            'lqdsep-js-gsap-base' => array(
                'type' => 'js',
                'conditions' =>
                    $element->get_settings( 'template' ) === 'lqd-tm-style-1' ||
                    $element->get_settings( 'template' ) === 'lqd-tm-style-2'
            ),
        );
        break;
    case 'ld_testimonial':
        $widget_options = $this->get_testimonial_param_options( $element, '' );
        break;
    case 'ld_testimonial_carousel':
        $widget_options = $this->get_carousel_param_options( $element, '' );
        $widget_options = array_merge($widget_options, $this->get_testimonial_param_options( $element, 'list' ));
        break;
    case 'ld_services_slideshow':
        $widget_options = array(
            'lqdsep-carousel-base' => array(),
            'lqdsep-carousel-fade' => array(),
            'lqdsep-services-slideshow-base' => array(),
            'lqdsep-js-imagesloaded-base' => array( 'type' => 'js' ),
            'lqdsep-js-flickity-base' => array( 'type' => 'js' ),
            'lqdsep-js-flickity-fade' => array( 'type' => 'js' ),
        );
        break;
    case 'ld_slideshow':
        $widget_options = array(
            'lqdsep-btn-base' => array(),
            'lqdsep-btn-shape-plain' => array(),
            'lqdsep-btn-icon-base' => array(),
            'lqdsep-btn-hover-swap' => array(),
            'lqdsep-carousel-base' => array(),
            'lqdsep-carousel-nav-base' => array(),
            'lqdsep-carousel-nav-floated' => array(),
            'lqdsep-carousel-nav-align-h-top' => array(),
            'lqdsep-carousel-nav-size-lg' => array(),
            'lqdsep-carousel-nav-shaped-solid' => array(),
            'lqdsep-carousel-dots-base' => array(),
            'lqdsep-carousel-dots-style-4' => array(),
            'lqdsep-split-text-base' => array(),
            'lqdsep-slideshow-base' => array(),
            'lqdsep-js-fastdom-base' => array( 'type' => 'js' ),
            'lqdsep-js-fontface-observer-base' => array( 'type' => 'js' ),
            'lqdsep-js-splittext-base' => array( 'type' => 'js' ),
            'lqdsep-js-imagesloaded-base' => array( 'type' => 'js' ),
            'lqdsep-js-gsap-base' => array( 'type' => 'js' ),
            'lqdsep-js-flickity-base' => array( 'type' => 'js' ),
        );
        break;
    case 'ld_slideshow_2':
        $widget_options = array(
            'lqdsep-vertical-slider-base' => array(),
            'lqdsep-js-imagesloaded-base' => array( 'type' => 'js' ),
            'lqdsep-js-gsap-base' => array( 'type' => 'js' ),
        );
        break;
    case 'ld_typewriter':
        $widget_options = array(
            'lqdsep-typewriter-base' => array(),
            'lqdsep-js-t' => array( 'type' => 'js' ),
        );
        break;
    case 'ld_woo_products':
        $widget_options = array(
            'lqdsep-snickers-bar-base' => array(),
            'lqdsep-carousel-nav-base' => array(),
            'lqdsep-carousel-nav-shaped-base' => array(),
            'lqdsep-carousel-nav-shaped-solid' => array(),
        );
        break;
    case 'ld_woo_products_list':
        $widget_options = array(
            'lqdsep-snickers-bar-base' => array(),
            'lqdsep-btn-ajax-loadmore' => array( 'conditions' => $element->get_settings( 'pagination' ) === 'ajax' ),
        );
        break;
    case 'ld_woo_product_add_to_cart':
        $widget_options = array(
            'lqdsep-js-jquery-ui-base' => array( 'type' => 'js' ),
            'lqdsep-js-jquery-ui-touch' => array( 'type' => 'js' ),
        );
        break;
}