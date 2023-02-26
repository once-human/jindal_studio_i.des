<?php 

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('Liquid_Elementor_Widget_Assets')) :

    class Liquid_Elementor_Widget_Assets{

        private $count = 0;
        private $theme_options_files = array(); 
        private $elementor_page_settings = array();
        private $merged_css = array();
        private $merged_js = array();

        public function __construct(){

            $this->init_hooks();

        }

        private function init_hooks(){
            
            $this->check_styles_folder();

            $post_id = liquid_helper()->get_page_id_by_url();
            
            add_action( 'elementor/frontend/before_enqueue_styles', [ $this, 'widget_styles' ] );
            add_action( 'elementor/frontend/before_render', [ $this, 'enq_widget_assets' ], 9999 );

            // Merge files
            if ( $this->check_optimization() ) {
                add_action( 'wp_footer', function(){
                    
                    if ( \Elementor\Plugin::$instance->preview->is_preview_mode() ){
                        return; // if preview mode, return
                    }

                    global $wp_styles;
                    global $wp_scripts;
                    ?>
                        <script>
                            console.log('Separated CSS files:');
                            console.log(<?php echo wp_json_encode( $this->merged_css ); ?>);
                            console.log('Merged File path: <?php echo esc_url( wp_upload_dir()['baseurl'] . '/liquid-styles/liquid-merged-styles-' . get_the_ID() . '.css' ) ?>');
                            console.log('Separated JS files:');
                            console.log(<?php echo wp_json_encode( $this->merged_js ); ?>);
                            console.log('Merged File path: <?php echo esc_url( wp_upload_dir()['baseurl'] . '/liquid-styles/liquid-merged-scripts-' . get_the_ID() . '.js' ) ?>');
                            console.log('Optimized version will be appear on next page reload!');
                        </script>
                    <?php

                    $this->merge_all_separated_styles($wp_styles); // merge all separated styles
                    if ( $this->check_combine_js() ){
                        $this->merge_all_separated_scripts($wp_scripts); // merge all separated scripts
                    }
                    $this->set_cache();
                }, 9999);
            }

        }

        public function get_theme_options_files(){

            if ( $this->count > 0 ){
                return;
            }

            $theme_options_files = $widget_utils = array();

            $theme_option = get_option('liquid_one_opt');

            $lazyload_enabled = isset($theme_option['enable-lazy-load']) && $theme_option['enable-lazy-load'] === 'on';
            $titlebar_enabled = isset($theme_option['title-bar-enable']) && $theme_option['title-bar-enable'] === 'on';
            $titlebar_breadcrumb_enabled =
                $titlebar_enabled &&
                isset($theme_option['title-bar-breadcrumb']) && $theme_option['title-bar-breadcrumb'] === 'on';
            $titlebar_parallax_enabled =
                $titlebar_enabled &&
                isset($theme_option['title-bar-parallax']) && $theme_option['title-bar-parallax'] === 'on';
            $top_scroll_ind_enabled = isset($theme_option['top-scroll-indicator']) && $theme_option['top-scroll-indicator'] === 'on';
            $back_to_top_enabled = isset($theme_option['footer-back-to-top']) && $theme_option['footer-back-to-top'] === 'on';
            $back_to_top_scrl_ind_enabled = $back_to_top_enabled && $theme_option['footer-back-to-top-scrl-ind'] === 'on';
            $preloader_enabled = isset($theme_option['enable-preloader']) && $theme_option['enable-preloader'] === 'on';
            $custom_cursor_enabled = isset($theme_option['enable-custom-cursor']) && $theme_option['enable-custom-cursor'] === 'on';
            $site_settings_hover_logo = \Elementor\Plugin::$instance->kits_manager->get_active_kit_for_frontend()->get_settings_for_display('hover_header_logo');
            $blog_single_style = $theme_option['post-style'];
            $blog_single_related_style = $theme_option['post-related-style'];

            $widget_utils['lqdsep-utils-flex-d'] = array(
                'conditions' =>
                    $custom_cursor_enabled ||
                    $titlebar_enabled ||
                    (
                        empty( liquid_get_custom_header_id() )
                    )
            );
            $widget_utils['lqdsep-utils-block-d'] = array(
                'conditions' =>
                    $back_to_top_scrl_ind_enabled ||
                    $top_scroll_ind_enabled
            );
            $widget_utils['lqdsep-utils-flex-inline-d'] = array(
                'conditions' =>
                    $back_to_top_enabled ||
                    $custom_cursor_enabled ||
                    (
                        is_array( $site_settings_hover_logo ) &&
                        ! empty( $site_settings_hover_logo['url'] )
                    )
            );
            $widget_utils['lqdsep-utils-flex-wrap'] = array(
                'conditions' => $titlebar_enabled
            );
            $widget_utils['lqdsep-utils-block-inline-d'] = array(
                'conditions' =>
                    $back_to_top_enabled ||
                    (
                        $preloader_enabled &&
                        (
                            $theme_option['preloader-style'] === 'spinner' ||
                            $theme_option['preloader-style'] === 'logo'
                        )
                    )
            );
            $widget_utils['lqdsep-utils-flex-align-items-center'] = array(
                'conditions' =>
                    $custom_cursor_enabled ||
                    $titlebar_enabled ||
                    empty( liquid_get_custom_header_id() ) ||
                    (
                        is_array( $site_settings_hover_logo ) &&
                        ! empty( $site_settings_hover_logo['url'] )
                    )
            );
            $widget_utils['lqdsep-utils-flex-justify-content-center'] = array(
                'conditions' =>
                    $custom_cursor_enabled ||
                    (
                        is_array( $site_settings_hover_logo ) &&
                        ! empty( $site_settings_hover_logo['url'] )
                    )
            );
            $widget_utils['lqdsep-utils-w-100'] = array(
                'conditions' =>
                    (
                        $preloader_enabled &&
                        $theme_option['preloader-style'] === 'dissolve'
                    ) ||
                    $top_scroll_ind_enabled
            );
            $widget_utils['lqdsep-utils-flex-align-items-center'] = array(
                'conditions' => $back_to_top_enabled
            );
            $widget_utils['lqdsep-utils-flex-justify-content-center'] = array(
                'conditions' => $back_to_top_enabled
            );
            $widget_utils['lqdsep-utils-flex-justify-content-end'] = array(
                'conditions' =>
                    empty( liquid_get_custom_header_id() )
            );
            $widget_utils['lqdsep-utils-flex-grow-1'] = array(
                'conditions' =>
                    (
                        $preloader_enabled &&
                        $theme_option['preloader-style'] === 'dissolve'
                    ) ||
                    (
                        empty( liquid_get_custom_header_id() )
                    ) ||
                    (
                        is_array( $site_settings_hover_logo ) &&
                        ! empty( $site_settings_hover_logo['url'] )
                    )
            );
            $widget_utils['lqdsep-utils-p-0'] = array(
                'conditions' =>
                    empty( liquid_get_custom_header_id() )
            );
            $widget_utils['lqdsep-utils-pt-0'] = array(
                'conditions' =>
                    empty( liquid_get_custom_header_id() )
            );
            $widget_utils['lqdsep-utils-pt-4'] = array(
                'conditions' =>
                    empty( liquid_get_custom_header_id() )
            );
            $widget_utils['lqdsep-utils-pb-0'] = array(
                'conditions' =>
                    empty( liquid_get_custom_header_id() )
            );
            $widget_utils['lqdsep-utils-pb-4'] = array(
                'conditions' =>
                    empty( liquid_get_custom_header_id() )
            );
            $widget_utils['lqdsep-utils-ps-0'] = array(
                'conditions' =>
                    empty( liquid_get_custom_header_id() )
            );
            $widget_utils['lqdsep-utils-ps-2'] = array(
                'conditions' =>
                    empty( liquid_get_custom_header_id() )
            );
            $widget_utils['lqdsep-utils-ps-4'] = array(
                'conditions' =>
                    empty( liquid_get_custom_header_id() )
            );
            $widget_utils['lqdsep-utils-pe-0'] = array(
                'conditions' =>
                    empty( liquid_get_custom_header_id() )
            );
            $widget_utils['lqdsep-utils-pe-2'] = array(
                'conditions' =>
                    empty( liquid_get_custom_header_id() )
            );
            $widget_utils['lqdsep-utils-pe-4'] = array(
                'conditions' =>
                    empty( liquid_get_custom_header_id() )
            );
            $widget_utils['lqdsep-utils-m-0'] = array(
                'conditions' =>
                (
                    $preloader_enabled &&
                    (
                        $theme_option['preloader-style'] === 'logo'
                    )
                )
            );
            $widget_utils['lqdsep-utils-mb-3'] = array(
                'conditions' =>
                (
                    $preloader_enabled &&
                    (
                        $theme_option['preloader-style'] === 'logo'
                    )
                )
            );
            $widget_utils['lqdsep-utils-border-radius-circle'] = array(
                'conditions' =>
                    $back_to_top_enabled ||
                    $custom_cursor_enabled
            );
            $widget_utils['lqdsep-utils-pos-rel'] = array(
                'conditions' =>
                    $custom_cursor_enabled ||
                    empty( liquid_get_custom_header_id() ) ||
                    (
                        $preloader_enabled &&
                        (
                            $theme_option['preloader-style'] === 'logo'
                        )
                    )
            );
            $widget_utils['lqdsep-utils-pos-abs'] = array(
                'conditions' =>
                    $custom_cursor_enabled ||
                    (
                        $preloader_enabled &&
                        (
                            $theme_option['preloader-style'] === 'logo'
                        )
                    )
            );
            $widget_utils['lqdsep-utils-pos-fix'] = array(
                'conditions' =>
                    $back_to_top_enabled ||
                    $custom_cursor_enabled ||
                    $top_scroll_ind_enabled
            );
            $widget_utils['lqdsep-utils-pos-tl'] = array(
                'conditions' =>
                    $custom_cursor_enabled ||
                    $top_scroll_ind_enabled
            );
            $widget_utils['lqdsep-utils-zindex-10'] = array(
                'conditions' =>
                    $top_scroll_ind_enabled
            );
            $widget_utils['lqdsep-utils-overlay'] = array(
                'conditions' =>
                    $titlebar_parallax_enabled ||
                    $back_to_top_scrl_ind_enabled ||
                    $top_scroll_ind_enabled ||
                    (
                        $theme_option['title-bar-overlay'] === 'on' &&
                        ! empty( $theme_option['title-bar-overlay-background'] )
                    ) ||
                    (
                        $preloader_enabled &&
                        (
                            $theme_option['preloader-style'] === 'curtain' ||
                            $theme_option['preloader-style'] === 'sliding'
                        )
                    ) ||
                    (
                        is_array( $site_settings_hover_logo ) &&
                        ! empty( $site_settings_hover_logo['url'] )
                    )
            );
            $widget_utils['lqdsep-utils-overflow-hidden'] = array(
                'conditions' =>
                    $titlebar_parallax_enabled ||
                    $custom_cursor_enabled
            );
            $widget_utils['lqdsep-utils-reset-ul'] = array(
                'conditions' =>
                    $titlebar_breadcrumb_enabled ||
                    empty( liquid_get_custom_header_id() )
            );
            $widget_utils['lqdsep-utils-inline-ul'] = array(
                'conditions' =>
                    $titlebar_breadcrumb_enabled ||
                    empty( liquid_get_custom_header_id() )
            );
            $widget_utils['lqdsep-utils-text-center'] = array(
                'conditions' =>
                    $custom_cursor_enabled ||
                    (
                        $titlebar_enabled &&
                        isset($theme_option['title-bar-align']) && $theme_option['title-bar-align'] === 'text-center'
                    )
            );
            $widget_utils['lqdsep-utils-text-end'] = array(
                'conditions' =>
                    $titlebar_enabled &&
                    (
                        isset($theme_option['title-bar-align']) && $theme_option['title-bar-align'] === 'text-end' ||
                        isset($theme_option['title-bar-align']) && $theme_option['title-bar-align'] === 'titlebar-split'
                    )
            );
            $widget_utils['lqdsep-utils-pointer-events-none'] = array(
                'conditions' =>
                    $custom_cursor_enabled ||
                    $top_scroll_ind_enabled
            );

            $theme_options_files['lqdsep-back-to-top'] = array(
                'conditions' => $back_to_top_enabled
            );
            $theme_options_files['lqdsep-custom-cursor-base'] = array(
                'conditions' => $custom_cursor_enabled
            );
            $theme_options_files['lqdsep-lazyload'] = array(
                'conditions' => $lazyload_enabled
            );
            $theme_options_files['lqdsep-preloader-base'] = array(
                'conditions' => $preloader_enabled
            );
            $theme_options_files['lqdsep-preloader-curtain'] = array(
                'conditions' =>
                    $preloader_enabled &&
                    $theme_option['preloader-style'] === 'curtain'
            );
            $theme_options_files['lqdsep-preloader-fade'] = array(
                'conditions' =>
                    $preloader_enabled &&
                    $theme_option['preloader-style'] === 'fade'
            );
            $theme_options_files['lqdsep-preloader-sliding'] = array(
                'conditions' =>
                    $preloader_enabled &&
                    $theme_option['preloader-style'] === 'sliding'
            );
            $theme_options_files['lqdsep-preloader-spinner'] = array(
                'conditions' =>
                    $preloader_enabled &&
                    $theme_option['preloader-style'] === 'spinner'
            );
            $theme_options_files['lqdsep-preloader-classic'] = array(
                'conditions' =>
                    $preloader_enabled &&
                    $theme_option['preloader-style'] === 'spinner-classical'
            );
            $theme_options_files['lqdsep-preloader-dissolve'] = array(
                'conditions' =>
                    $preloader_enabled &&
                    $theme_option['preloader-style'] === 'dissolve'
            );
            $theme_options_files['lqdsep-preloader-logo'] = array(
                'conditions' =>
                    $preloader_enabled &&
                    $theme_option['preloader-style'] === 'logo'
            );
            $theme_options_files['lqdsep-titlebar-base'] = array(
                'conditions' => $titlebar_enabled
            );
            $theme_options_files['lqdsep-breadcrumb-base'] = array(
                'conditions' => $titlebar_breadcrumb_enabled
            );
            $theme_options_files['lqdsep-sidebar-base'] = array(
                'conditions' =>
                    ( isset($theme_option['page-enable-global']) && $theme_option['page-enable-global'] === 'on' ) ||
                    ( isset($theme_option['portfolio-enable-global']) && $theme_option['portfolio-enable-global'] === 'on' ) ||
                    ( isset($theme_option['blog-enable-global']) && $theme_option['blog-enable-global'] === 'on' )
            );
            $theme_options_files['lqdsep-header-default'] = array(
                'conditions' =>
                    empty( liquid_get_custom_header_id() )
            );
            $theme_options_files['lqdsep-header-primary-menu-base'] = array(
                'conditions' =>
                    empty( liquid_get_custom_header_id() )
            );
            $theme_options_files['lqdsep-header-submenu-base'] = array(
                'conditions' =>
                    empty( liquid_get_custom_header_id() )
            );
            $theme_options_files['lqdsep-header-logo-hover-image'] = array(
                'conditions' =>
                    (
                        is_array( $site_settings_hover_logo ) &&
                        ! empty( $site_settings_hover_logo['url'] )
                    )
            );

            // Blog posts
            $theme_options_files['lqdsep-blog-image-hover-zoom'] = array(
                'conditions' => is_singular( 'post' )
            );
            $theme_options_files['lqdsep-blog-animate-onhover'] = array(
                'conditions' =>
                    is_singular( 'post' ) &&
                    $blog_single_related_style === 'style-3'
            );
            $theme_options_files['lqdsep-blog-category-shaped-base'] = array(
                'conditions' =>
                    is_singular( 'post' ) &&
                    (
                        $blog_single_style === 'minimal' ||
                        $blog_single_related_style === 'style-1' ||
                        $blog_single_related_style === 'style-3'
                    )
            );
            $theme_options_files['lqdsep-blog-meta-solid'] = array(
                'conditions' =>
                    is_singular( 'post' ) &&
                    $blog_single_related_style === 'style-1'
            );
            $theme_options_files['lqdsep-blog-category-solid'] = array(
                'conditions' =>
                    is_singular( 'post' ) &&
                    (
                        $blog_single_related_style === 'style-2' ||
                        $blog_single_related_style === 'style-3'
                    )
            );
            $theme_options_files['lqdsep-blog-category-solid-colored'] = array(
                'conditions' =>
                    is_singular( 'post' ) &&
                    $blog_single_style === 'minimal'
            );
            $theme_options_files['lqdsep-blog-meta-solid-nopadding'] = array(
                'conditions' =>
                    is_singular( 'post' ) &&
                    $blog_single_related_style === 'style-1'
            );
            $theme_options_files['lqdsep-blog-date'] = array(
                'conditions' =>
                    is_singular( 'post' ) &&
                    $blog_single_related_style === 'style-2'
            );
            $theme_options_files['lqdsep-blog-content-overlay'] = array(
                'conditions' =>
                    is_singular( 'post' ) &&
                    $blog_single_related_style === 'style-3'
            );
            $theme_options_files['lqdsep-blog-style-6'] = array(
                'conditions' =>
                    is_singular( 'post' ) &&
                    $blog_single_related_style === 'style-1'
            );
            $theme_options_files['lqdsep-blog-style-11'] = array(
                'conditions' =>
                    is_singular( 'post' ) &&
                    $blog_single_related_style === 'style-2'
            );
            $theme_options_files['lqdsep-blog-style-10'] = array(
                'conditions' =>
                    is_singular( 'post' ) &&
                    $blog_single_related_style === 'style-3'
            );

            $theme_options_files['lqdsep-js-fastdom-base'] = array(
                'type' => 'js',
                'conditions' => $custom_cursor_enabled
            );
            $theme_options_files['lqdsep-js-imagesloaded-base'] = array(
                'type' => 'js',
                'conditions' => $back_to_top_enabled
            );
            $theme_options_files['lqdsep-js-lazyload'] = array(
                'type' => 'js',
                'conditions' => $lazyload_enabled
            );
            $theme_options_files['lqdsep-js-scrolltrigger-base'] = array(
                'type' => 'js',
                'conditions' =>
                    $titlebar_parallax_enabled ||
                    $back_to_top_scrl_ind_enabled ||
                    $top_scroll_ind_enabled
            );
            $theme_options_files['lqdsep-js-gsap-base'] = array(
                'type' => 'js',
                'conditions' =>
                    $preloader_enabled ||
                    $back_to_top_scrl_ind_enabled ||
                    $custom_cursor_enabled ||
                    $top_scroll_ind_enabled
            );

            $this->theme_options_files = array(
                'theme_options_files' => $theme_options_files,
                'widget_utils' => $widget_utils
            );
            
        }

        public function get_elementor_page_settings( $page_id ) {

            if ( $this->count > 0 ){
                return;
            }

            $page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers( 'page' );
            $header_settings_model = $page_settings_manager->get_model( liquid_get_custom_header_id() );
            $page_settings_model = $page_settings_manager->get_model( $page_id );
            $footer_settings_model = $page_settings_manager->get_model( liquid_get_custom_footer_id() );
            $elementor_page_settings = $widget_utils = array();

            // utils
            $this->merge_theme_and_page_settings(
                'widget_utils',
                'lqdsep-utils-flex-d',
                'css',
                (
                    $page_settings_model->get_settings( 'header_enable_switch' ) !== 'off' &&
                    $header_settings_model->get_settings( 'enable_mobile_header_builder' ) === ''
                ) ||
                is_singular( 'post' )
            );
            $this->merge_theme_and_page_settings(
                'widget_utils',
                'lqdsep-utils-block-inline-d',
                'css',
                $page_settings_model->get_settings( 'header_enable_switch' ) !== 'off' &&
                $header_settings_model->get_settings( 'enable_mobile_header_builder' ) === ''
            );
            $this->merge_theme_and_page_settings(
                'widget_utils',
                'lqdsep-utils-flex-column',
                'css',
                (
                    $page_settings_model->get_settings( 'header_enable_switch' ) !== 'off' &&
                    $header_settings_model->get_settings( 'enable_mobile_header_builder' ) === ''
                ) ||
                is_singular( 'post' )
            );
            $this->merge_theme_and_page_settings(
                'widget_utils',
                'lqdsep-utils-flex-wrap',
                'css',
                is_singular( 'post' )
            );
            $this->merge_theme_and_page_settings(
                'widget_utils',
                'lqdsep-utils-flex-align-items-center',
                'css',
                (
                    $page_settings_model->get_settings( 'header_enable_switch' ) !== 'off' &&
                    $header_settings_model->get_settings( 'enable_mobile_header_builder' ) === ''
                ) ||
                is_singular( 'post' )
            );
            $this->merge_theme_and_page_settings(
                'widget_utils',
                'lqdsep-utils-flex-justify-content-center',
                'css',
                $page_settings_model->get_settings( 'header_enable_switch' ) !== 'off' &&
                $header_settings_model->get_settings( 'enable_mobile_header_builder' ) === ''
            );
            $this->merge_theme_and_page_settings(
                'widget_utils',
                'lqdsep-utils-flex-justify-content-between',
                'css',
                is_singular( 'post' )
            );
            $this->merge_theme_and_page_settings(
                'widget_utils',
                'lqdsep-utils-flex-justify-content-end',
                'css',
                is_singular( 'post' ) &&
                (
                    $page_settings_model->get_settings( 'post_related_style' ) === 'style-3'
                )
            );
            $this->merge_theme_and_page_settings(
                'widget_utils',
                'lqdsep-utils-w-100',
                'css',
                $page_settings_model->get_settings( 'page_enable_liquid_bg' ) === 'on' ||
                (
                    $page_settings_model->get_settings( 'header_enable_switch' ) !== 'off' &&
                    $header_settings_model->get_settings( 'enable_mobile_header_builder' ) === ''
                ) ||
                (
                    is_singular( 'post' ) &&
                    $page_settings_model->get_settings( 'post_related_style' ) === 'style-3'
                )
            );
            $this->merge_theme_and_page_settings(
                'widget_utils',
                'lqdsep-utils-h-100',
                'css',
                (
                    $page_settings_model->get_settings( 'header_enable_switch' ) !== 'off' &&
                    $header_settings_model->get_settings( 'enable_mobile_header_builder' ) === ''
                ) ||
                (
                    is_singular( 'post' ) &&
                    $page_settings_model->get_settings( 'post_related_style' ) === 'style-3'
                )
            );
            $this->merge_theme_and_page_settings(
                'widget_utils',
                'lqdsep-utils-h-vh-100',
                'css',
                $page_settings_model->get_settings( 'page_enable_liquid_bg' ) === 'on'
            );
            $this->merge_theme_and_page_settings(
                'widget_utils',
                'lqdsep-utils-h-pt-80',
                'css',
                is_singular( 'post' ) &&
                (
                    $page_settings_model->get_settings( 'post_related_style' ) === 'style-3'
                )
            );
            $this->merge_theme_and_page_settings(
                'widget_utils',
                'lqdsep-utils-p-0',
                'css',
                is_singular( 'post' ) &&
                (
                    $page_settings_model->get_settings( 'post_related_style' ) === 'style-1'
                )
            );
            $this->merge_theme_and_page_settings(
                'widget_utils',
                'lqdsep-utils-p-4',
                'css',
                is_singular( 'post' ) &&
                (
                    $page_settings_model->get_settings( 'post_related_style' ) === 'style-3'
                )
            );
            $this->merge_theme_and_page_settings(
                'widget_utils',
                'lqdsep-utils-pt-2',
                'css',
                is_singular( 'post' ) &&
                (
                    $page_settings_model->get_settings( 'post_related_style' ) === 'style-1'
                )
            );
            $this->merge_theme_and_page_settings(
                'widget_utils',
                'lqdsep-utils-pb-2',
                'css',
                is_singular( 'post' ) &&
                (
                    $page_settings_model->get_settings( 'post_related_style' ) === 'style-1'
                )
            );
            $this->merge_theme_and_page_settings(
                'widget_utils',
                'lqdsep-utils-ps-3',
                'css',
                is_singular( 'post' ) &&
                (
                    $page_settings_model->get_settings( 'post_related_style' ) === 'style-1'
                )
            );
            $this->merge_theme_and_page_settings(
                'widget_utils',
                'lqdsep-utils-pe-3',
                'css',
                is_singular( 'post' ) &&
                (
                    $page_settings_model->get_settings( 'post_related_style' ) === 'style-1'
                )
            );
            $this->merge_theme_and_page_settings(
                'widget_utils',
                'lqdsep-utils-m-0',
                'css',
                is_singular( 'post' ) &&
                (
                    $page_settings_model->get_settings( 'post_related_style' ) === 'style-1' ||
                    $page_settings_model->get_settings( 'post_related_style' ) === 'style-2'
                )
            );
            $this->merge_theme_and_page_settings(
                'widget_utils',
                'lqdsep-utils-mt-2',
                'css',
                is_singular( 'post' ) &&
                (
                    $page_settings_model->get_settings( 'post_related_style' ) === 'style-3'
                )
            );
            $this->merge_theme_and_page_settings(
                'widget_utils',
                'lqdsep-utils-mb-2',
                'css',
                is_singular( 'post' )
            );
            $this->merge_theme_and_page_settings(
                'widget_utils',
                'lqdsep-utils-mb-3',
                'css',
                is_singular( 'post' ) &&
                (
                    $page_settings_model->get_settings( 'post_related_style' ) === 'style-1' ||
                    $page_settings_model->get_settings( 'post_related_style' ) === 'style-2'
                )
            );
            $this->merge_theme_and_page_settings(
                'widget_utils',
                'lqdsep-utils-mb-4',
                'css',
                is_singular( 'post' ) &&
                (
                    $page_settings_model->get_settings( 'post_related_style' ) === 'style-1'
                )
            );
            $this->merge_theme_and_page_settings(
                'widget_utils',
                'lqdsep-utils-me-3',
                'css',
                is_singular( 'post' )
            );
            $this->merge_theme_and_page_settings(
                'widget_utils',
                'lqdsep-utils-border-radius-4',
                'css',
                is_singular( 'post' ) &&
                (
                    $page_settings_model->get_settings( 'post_related_style' ) === 'style-3'
                )
            );
            $this->merge_theme_and_page_settings(
                'widget_utils',
                'lqdsep-utils-reset-ul',
                'css',
                is_singular( 'post' ) ||
                $header_settings_model->get_settings( 'enable_mobile_header_builder' ) === '' ||
                $page_settings_model->get_settings( 'title_bar_breadcrumb' ) === 'on'
            );
            $this->merge_theme_and_page_settings(
                'widget_utils',
                'lqdsep-utils-inline-ul',
                'css',
                is_singular( 'post' ) ||
                $page_settings_model->get_settings( 'title_bar_breadcrumb' ) === 'on'
            );
            $this->merge_theme_and_page_settings(
                'widget_utils',
                'lqdsep-utils-pos-rel',
                'css',
                (
                    $page_settings_model->get_settings( 'header_enable_switch' ) !== 'off' &&
                    $header_settings_model->get_settings( 'enable_mobile_header_builder' ) === ''
                ) ||
                is_singular( 'post' )
            );
            $this->merge_theme_and_page_settings(
                'widget_utils',
                'lqdsep-utils-pos-abs',
                'css',
                (
                    is_singular( 'post' ) &&
                    $page_settings_model->get_settings( 'post_related_style' ) === 'style-1'
                ) ||
                (
                    $page_settings_model->get_settings( 'header_enable_switch' ) !== 'off' &&
                    $header_settings_model->get_settings( 'header_megamenu_slide' ) === 'yes'
                )
            );
            $this->merge_theme_and_page_settings(
                'widget_utils',
                'lqdsep-utils-pos-sticky',
                'css',
                $page_settings_model->get_settings( 'page_enable_liquid_bg' ) === 'on'
            );
            $this->merge_theme_and_page_settings(
                'widget_utils',
                'lqdsep-utils-pos-tl',
                'css',
                $page_settings_model->get_settings( 'page_enable_liquid_bg' ) === 'on' ||
                (
                    $page_settings_model->get_settings( 'header_enable_switch' ) !== 'off' &&
                    $header_settings_model->get_settings( 'header_megamenu_slide' ) === 'yes'
                )
            );
            $this->merge_theme_and_page_settings(
                'widget_utils',
                'lqdsep-utils-pos-bl',
                'css',
                is_singular( 'post' ) &&
                (
                    $page_settings_model->get_settings( 'post_related_style' ) === 'style-1'
                )
            );
            $this->merge_theme_and_page_settings(
                'widget_utils',
                'lqdsep-utils-zindex--1',
                'css',
                $page_settings_model->get_settings( 'page_enable_liquid_bg' ) === 'on'
            );
            $this->merge_theme_and_page_settings(
                'widget_utils',
                'lqdsep-utils-zindex-1',
                'css',
                $page_settings_model->get_settings( 'header_enable_switch' ) !== 'off' &&
                $header_settings_model->get_settings( 'enable_mobile_header_builder' ) === ''
            );
            $this->merge_theme_and_page_settings(
                'widget_utils',
                'lqdsep-utils-zindex-2',
                'css',  
                is_singular( 'post' )
            );
            $this->merge_theme_and_page_settings(
                'widget_utils',
                'lqdsep-utils-overlay',
                'css',  
                $page_settings_model->get_settings( 'page_enable_liquid_bg' ) === 'on' ||
                is_singular( 'post' ) ||
                (
                    $page_settings_model->get_settings( 'title_bar_enable' ) === 'on' &&
                    $page_settings_model->get_settings( 'title_bar_parallax' ) === 'on'
                )
            );
            $this->merge_theme_and_page_settings(
                'widget_utils',
                'lqdsep-utils-overflow-hidden',
                'css',
                is_singular( 'post' )||
                (
                    $page_settings_model->get_settings( 'title_bar_enable' ) === 'on' &&
                    $page_settings_model->get_settings( 'title_bar_parallax' ) === 'on'
                )
            );
            $this->merge_theme_and_page_settings(
                'widget_utils',
                'lqdsep-utils-text-center',
                'css',  
                is_singular( 'post' )
            );
            $this->merge_theme_and_page_settings(
                'widget_utils',
                'lqdsep-utils-text-end',
                'css',  
                $page_settings_model->get_settings( 'title_bar_enable' ) === 'on' ||
                $page_settings_model->get_settings( 'title_bar_align' ) === 'text-end' ||
                $page_settings_model->get_settings( 'title_bar_align' ) === 'titlebar-split'
            );
            $this->merge_theme_and_page_settings(
                'widget_utils',
                'lqdsep-utils-text-uppercase',
                'css',  
                is_singular( 'post' )
            );
            $this->merge_theme_and_page_settings(
                'widget_utils',
                'lqdsep-utils-text-ltrsp-1',
                'css',  
                is_singular( 'post' )
            );
            $this->merge_theme_and_page_settings(
                'widget_utils',
                'lqdsep-utils-text-weight-bold',
                'css',  
                is_singular( 'post' )
            );
            $this->merge_theme_and_page_settings(
                'widget_utils',
                'lqdsep-utils-pointer-events-none',
                'css',
                $page_settings_model->get_settings( 'page_enable_liquid_bg' ) === 'on' ||
                (
                    $page_settings_model->get_settings( 'header_enable_switch' ) !== 'off' &&
                    $header_settings_model->get_settings( 'header_megamenu_slide' ) === 'yes'
                )
            );
            $this->merge_theme_and_page_settings(
                'widget_utils',
                'lqdsep-utils-bg-transparent',
                'css',
                $page_settings_model->get_settings( 'page_enable_liquid_bg' ) === 'on'
            );
            $this->merge_theme_and_page_settings(
                'widget_utils',
                'lqdsep-utils-objfit-cover',
                'css',
                is_singular( 'post' ) &&
                (
                    $page_settings_model->get_settings( 'post_related_style' ) === 'style-3'
                )
            );
            $this->merge_theme_and_page_settings(
                'widget_utils',
                'lqdsep-utils-objfit-center',
                'css',
                is_singular( 'post' ) &&
                (
                    $page_settings_model->get_settings( 'post_related_style' ) === 'style-3'
                )
            );

            // for header options
            $elementor_page_settings['lqdsep-header-base'] = array(
                'conditions' => $page_settings_model->get_settings( 'header_enable_switch' ) !== 'off'
            );
            $elementor_page_settings['lqdsep-header-overlay'] = array(
                'conditions' =>
                    $page_settings_model->get_settings( 'header_enable_switch' ) !== 'off' &&
                    $header_settings_model->get_settings( 'header_overlay' ) === 'main-header-overlay'
            );
            $elementor_page_settings['lqdsep-header-sticky'] = array(
                'conditions' =>
                    $page_settings_model->get_settings( 'header_enable_switch' ) !== 'off' &&
                    $header_settings_model->get_settings( 'header_sticky' ) === 'yes'
            );
            $elementor_page_settings['lqdsep-header-sticky-no-shadow'] = array(
                'conditions' =>
                    $page_settings_model->get_settings( 'header_enable_switch' ) !== 'off' &&
                    $header_settings_model->get_settings( 'header_sticky' ) === 'yes' &&
                    $header_settings_model->get_settings( 'header_sticky_shadow' ) === 'sticky-header-noshadow'
            );
            $elementor_page_settings['lqdsep-header-nav-trigger-base'] = array(
                'conditions' =>
                    $page_settings_model->get_settings( 'header_enable_switch' ) !== 'off' &&
                    $header_settings_model->get_settings( 'enable_mobile_header_builder' ) === ''
            );
            $elementor_page_settings['lqdsep-header-nav-trigger-style-1'] = array(
                'conditions' =>
                    $page_settings_model->get_settings( 'header_enable_switch' ) !== 'off' &&
                    $header_settings_model->get_settings( 'enable_mobile_header_builder' ) === ''
            );
            $elementor_page_settings['lqdsep-header-mobile-menu-base'] = array(
                'conditions' =>
                    $page_settings_model->get_settings( 'header_enable_switch' ) !== 'off' &&
                    $header_settings_model->get_settings( 'enable_mobile_header_builder' ) === ''
            );
            $elementor_page_settings['lqdsep-header-megamenu-slide-base'] = array(
                'conditions' =>
                    $page_settings_model->get_settings( 'header_enable_switch' ) !== 'off' &&
                    $header_settings_model->get_settings( 'header_megamenu_slide' ) === 'yes'
            );
            $elementor_page_settings['lqdsep-header-nav-trigger-base'] = array(
                'conditions' =>
                    $page_settings_model->get_settings( 'header_enable_switch' ) !== 'off' &&
                    $header_settings_model->get_settings( 'enable_mobile_header_builder' ) === ''
            );
            $elementor_page_settings['lqdsep-header-mobile-menu-base'] = array(
                'conditions' =>
                    $page_settings_model->get_settings( 'header_enable_switch' ) !== 'off' &&
                    $header_settings_model->get_settings( 'enable_mobile_header_builder' ) === ''
            );
            $elementor_page_settings['lqdsep-header-mobile-menu-base'] = array(
                'conditions' =>
                    $page_settings_model->get_settings( 'header_enable_switch' ) !== 'off' &&
                    $header_settings_model->get_settings( 'enable_mobile_header_builder' ) === ''
            );

            // for page, column, section
            $elementor_page_settings['lqdsep-page-blocks-base'] = array(
                'conditions' => $page_settings_model->get_settings( 'page_enable_stack' ) === 'on'
            );
            $elementor_page_settings['lqdsep-page-blocks-effect-fadeScale'] = array(
                'conditions' =>
                    $page_settings_model->get_settings( 'page_enable_stack' ) === 'on' &&
                    $page_settings_model->get_settings( 'page_stack_effect' ) === 'fadeScale'
            );
            $elementor_page_settings['lqdsep-page-blocks-effect-mask'] = array(
                'conditions' =>
                    $page_settings_model->get_settings( 'page_enable_stack' ) === 'on' &&
                    $page_settings_model->get_settings( 'page_stack_effect' ) === 'mask'
            );
            $elementor_page_settings['lqdsep-page-blocks-effect-slideOver'] = array(
                'conditions' =>
                    $page_settings_model->get_settings( 'page_enable_stack' ) === 'on' &&
                    $page_settings_model->get_settings( 'page_stack_effect' ) === 'slideOver'
            );
            $elementor_page_settings['lqdsep-page-blocks-nav-base'] = array(
                'conditions' =>
                    $page_settings_model->get_settings( 'page_enable_stack' ) === 'on' &&
                    $page_settings_model->get_settings( 'page_stack_nav' ) === 'on'
            );
            $elementor_page_settings['lqdsep-page-blocks-nav-style-1'] = array(
                'conditions' =>
                    $page_settings_model->get_settings( 'page_enable_stack' ) === 'on' &&
                    $page_settings_model->get_settings( 'page_stack_nav' ) === 'on' &&
                    $page_settings_model->get_settings( 'page_stack_nav_style' ) === 'lqd-stack-nav-style-1'
            );
            $elementor_page_settings['lqdsep-page-blocks-nav-style-2'] = array(
                'conditions' =>
                    $page_settings_model->get_settings( 'page_enable_stack' ) === 'on' &&
                    $page_settings_model->get_settings( 'page_stack_nav' ) === 'on' &&
                    $page_settings_model->get_settings( 'page_stack_nav_style' ) === 'lqd-stack-nav-style-2'
            );
            $elementor_page_settings['lqdsep-page-blocks-nav-style-3'] = array(
                'conditions' =>
                    $page_settings_model->get_settings( 'page_enable_stack' ) === 'on' &&
                    $page_settings_model->get_settings( 'page_stack_nav' ) === 'on' &&
                    $page_settings_model->get_settings( 'page_stack_nav_style' ) === 'lqd-stack-nav-style-3'
            );
            $elementor_page_settings['lqdsep-page-blocks-nav-style-4'] = array(
                'conditions' =>
                    $page_settings_model->get_settings( 'page_enable_stack' ) === 'on' &&
                    $page_settings_model->get_settings( 'page_stack_nav' ) === 'on' &&
                    $page_settings_model->get_settings( 'page_stack_nav_style' ) === 'lqd-stack-nav-style-4'
            );
            $elementor_page_settings['lqdsep-page-blocks-numbers-base'] = array(
                'conditions' =>
                    $page_settings_model->get_settings( 'page_stack_numbers' ) === 'on'
            );
            $elementor_page_settings['lqdsep-page-blocks-numbers-style-1'] = array(
                'conditions' =>
                    $page_settings_model->get_settings( 'page_stack_numbers' ) === 'on' &&
                    $page_settings_model->get_settings( 'page_stack_numbers_style' ) === 'lqd-stack-nums-style-1'
            );
            $elementor_page_settings['lqdsep-page-blocks-numbers-style-2'] = array(
                'conditions' =>
                    $page_settings_model->get_settings( 'page_stack_numbers' ) === 'on' &&
                    $page_settings_model->get_settings( 'page_stack_numbers_style' ) === 'lqd-stack-nums-style-2'
            );
            $elementor_page_settings['lqdsep-page-blocks-numbers-style-2-ind'] = array(
                'conditions' =>
                    $page_settings_model->get_settings( 'page_stack_numbers' ) === 'on' &&
                    $page_settings_model->get_settings( 'page_stack_numbers_style' ) === 'lqd-stack-nums-style-2' &&
                    $page_settings_model->get_settings( 'page_stack_numbers_indicator' ) === 'on'
            );
            $elementor_page_settings['lqdsep-page-blocks-prevnext-base'] = array(
                'conditions' =>
                    $page_settings_model->get_settings( 'page_stack_nav_prevnextbuttons' ) === 'on'
            );
            $elementor_page_settings['lqdsep-page-blocks-prevnext-style-1'] = array(
                'conditions' =>
                    $page_settings_model->get_settings( 'page_stack_nav_prevnextbuttons' ) === 'on' &&
                    $page_settings_model->get_settings( 'page_stack_buttons_style' ) === 'lqd-stack-buttons-style-1'
            );
            $elementor_page_settings['lqdsep-page-blocks-prevnext-style-2'] = array(
                'conditions' =>
                    $page_settings_model->get_settings( 'page_stack_nav_prevnextbuttons' ) === 'on' &&
                    $page_settings_model->get_settings( 'page_stack_buttons_style' ) === 'lqd-stack-buttons-style-2'
            );
            $elementor_page_settings['lqdsep-page-frame-base'] = array(
                'conditions' =>
                    $page_settings_model->get_settings( 'page_enable_frame' ) === 'on'
            );
            $this->merge_theme_and_page_settings(
                'theme_options_files',
                'lqdsep-sidebar-base',
                'css',
                ! empty ( $page_settings_model->get_settings( 'liquid_sidebar_one' ) ) &&
                $page_settings_model->get_settings( 'liquid_sidebar_one' ) !== 'none'
            );
            $this->merge_theme_and_page_settings(
                'theme_options_files',
                'lqdsep-titlebar-base',
                'css',
                $page_settings_model->get_settings( 'title_bar_enable' ) === 'on'
            );
            $this->merge_theme_and_page_settings(
                'theme_options_files',
                'lqdsep-breadcrumb-base',
                'css',
                $page_settings_model->get_settings( 'title_bar_enable' ) === 'on' &&
                $page_settings_model->get_settings( 'title_bar_breadcrumb' ) === 'on'
            );

            // blog posts
            $elementor_page_settings['lqdsep-blog-base'] = array(
                'conditions' => is_singular( 'post' )
            );
            $this->merge_theme_and_page_settings(
                'theme_options_files',
                'lqdsep-blog-image-hover-zoom',
                'css',
                 is_singular( 'post' )
            );
            $this->merge_theme_and_page_settings(
                'theme_options_files',
                'lqdsep-blog-animate-onhover',
                'css',                
                is_singular( 'post' ) &&
                $page_settings_model->get_settings( 'post_related_style' ) === 'style-3'
            );
            $this->merge_theme_and_page_settings(
                'theme_options_files',
                'lqdsep-blog-meta-solid',
                'css',
                is_singular( 'post' ) &&
                $page_settings_model->get_settings( 'post_related_style' ) === 'style-1'
            );
            $this->merge_theme_and_page_settings(
                'theme_options_files',
                'lqdsep-blog-category-shaped-base',
                'css',
                is_singular( 'post' ) &&
                (
                    $page_settings_model->get_settings( 'post_style' ) === 'minimal' ||
                    $page_settings_model->get_settings( 'post_related_style' ) === 'style-1' ||
                    $page_settings_model->get_settings( 'post_related_style' ) === 'style-3'
                )
            );
            $this->merge_theme_and_page_settings(
                'theme_options_files',
                'lqdsep-blog-category-solid',
                'css',
                is_singular( 'post' ) &&
                (
                    $page_settings_model->get_settings( 'post_related_style' ) === 'style-2' ||
                    $page_settings_model->get_settings( 'post_related_style' ) === 'style-3'
                )
            );
            $this->merge_theme_and_page_settings(
                'theme_options_files',
                'lqdsep-blog-category-solid-colored',
                'css',
                is_singular( 'post' ) &&
                $page_settings_model->get_settings( 'post_style' ) === 'minimal'
            );
            $this->merge_theme_and_page_settings(
                'theme_options_files',
                'lqdsep-blog-meta-solid-nopadding',
                'css',
                is_singular( 'post' ) &&
                $page_settings_model->get_settings( 'post_related_style' ) === 'style-1'
            );
            $this->merge_theme_and_page_settings(
                'theme_options_files',
                'lqdsep-blog-date',
                'css',
                is_singular( 'post' ) &&
                $page_settings_model->get_settings( 'post_related_style' ) === 'style-2'
            );
            $this->merge_theme_and_page_settings(
                'theme_options_files',
                'lqdsep-blog-content-overlay',
                'css',
                is_singular( 'post' ) &&
                $page_settings_model->get_settings( 'post_related_style' ) === 'style-3'
            );
            $this->merge_theme_and_page_settings(
                'theme_options_files',
                'lqdsep-blog-style-6',
                'css',
                is_singular( 'post' ) &&
                $page_settings_model->get_settings( 'post_related_style' ) === 'style-1'
            );
            $this->merge_theme_and_page_settings(
                'theme_options_files',
                'lqdsep-blog-style-11',
                'css',
                is_singular( 'post' ) &&
                $page_settings_model->get_settings( 'post_related_style' ) === 'style-2'
            );
            $this->merge_theme_and_page_settings(
                'theme_options_files',
                'lqdsep-blog-style-10',
                'css',
                is_singular( 'post' ) &&
                $page_settings_model->get_settings( 'post_related_style' ) === 'style-3'
            );
            
            // for footer
            $elementor_page_settings['lqdsep-footer-sticky'] = array(
                'conditions' => $footer_settings_model->get_settings( 'footer_fixed' ) === 'on'
            );

            // js files
            $this->merge_theme_and_page_settings(
                'theme_options_files',
                'lqdsep-js-bootstrap',
                'js',
                $page_settings_model->get_settings( 'header_enable_switch' ) !== 'off' &&
                $header_settings_model->get_settings( 'enable_mobile_header_builder' ) === ''
            );
            $this->merge_theme_and_page_settings(
                'theme_options_files',
                'lqdsep-js-fastdom-base',
                'js',
                (
                    $page_settings_model->get_settings( 'header_enable_switch' ) !== 'off' &&
                    $header_settings_model->get_settings( 'enable_mobile_header_builder' ) === ''
                ) ||
                $header_settings_model->get_settings( 'header_sticky' ) === 'yes' ||
                $page_settings_model->get_settings( 'page_enable_liquid_bg' ) === 'on' ||
                $page_settings_model->get_settings( 'page_enable_liquid_bg_frame' ) === 'on' ||
                $page_settings_model->get_settings( 'page_enable_stack' ) === 'on' ||
                $footer_settings_model->get_settings( 'footer_fixed' ) === 'on'
            );
            $this->merge_theme_and_page_settings(
                'theme_options_files',
                'lqdsep-js-imagesloaded-base',
                'js',
                $header_settings_model->get_settings( 'enable_mobile_header_builder' ) === '' ||
                $page_settings_model->get_settings( 'page_enable_liquid_bg' ) === 'on' ||
                $page_settings_model->get_settings( 'page_enable_liquid_bg_frame' ) === 'on' ||
                $footer_settings_model->get_settings( 'footer_fixed' ) === 'on'
            );
            $this->merge_theme_and_page_settings(
                'theme_options_files',
                'lqdsep-js-tinycolor',
                'js',
                $header_settings_model->get_settings( 'header_sticky' ) === 'yes' ||
                $page_settings_model->get_settings( 'page_enable_liquid_bg' ) === 'on' ||
                $page_settings_model->get_settings( 'page_enable_liquid_bg_frame' ) === 'on' ||
                $page_settings_model->get_settings( 'page_enable_stack' ) === 'on'
            );
            $this->merge_theme_and_page_settings(
                'theme_options_files',
                'lqdsep-js-scrolltrigger-base',
                'js',
                $page_settings_model->get_settings( 'page_enable_liquid_bg' ) === 'on' ||
                $page_settings_model->get_settings( 'page_enable_liquid_bg_frame' ) === 'on' ||
                (
                    is_singular( 'post' ) &&
                    $page_settings_model->get_settings( 'post_parallax_enable' ) === 'on' &&
                    (
                        $page_settings_model->get_settings( 'post_style' ) === 'modern' ||
                        $page_settings_model->get_settings( 'post_style' ) === 'modern-full-screen' ||
                        $page_settings_model->get_settings( 'post_style' ) === 'dark'
                    )
                ) ||
                (
                    $page_settings_model->get_settings( 'title_bar_enable' ) === 'on' &&
                    $page_settings_model->get_settings( 'title_bar_parallax' ) === 'on'
                )
            );
            $this->merge_theme_and_page_settings(
                'theme_options_files',
                'lqdsep-js-gsap-base',
                'js',
                $page_settings_model->get_settings( 'page_enable_liquid_bg' ) === 'on' ||
                $page_settings_model->get_settings( 'page_enable_liquid_bg_frame' ) === 'on'
            );

            // remove css if options are off
            if ( $page_settings_model->get_settings( 'title_bar_enable' ) === 'off' ) {
                unset( $this->theme_options_files['theme_options_files']['lqdsep-titlebar-base'] );
                unset( $this->theme_options_files['theme_options_files']['lqdsep-breadcrumb-base'] );
            }

            $this->count++;
            $this->elementor_page_settings = array(
                'elementor_page_settings' => $elementor_page_settings,
                'widget_utils' => $widget_utils
            );

        }

        public function widget_styles() {

            if ( \Elementor\Plugin::$instance->preview->is_preview_mode() ){
                return; // if preview mode, return
            }

            // load asset names
            $path = array_diff(scandir(__DIR__ . '/widget-assets/assets/'), array('.', '..'));
            foreach ($path as $file) {
                include "widget-assets/assets/$file";
            }

            $src = array_merge(
                $base,
                $animated_borders,
                $back_to_top,
                $custom_cursor,
                $lazyload,
                $preloader,
                $utils,
                $section,
                $column,
                $custom_animations,
                $footer_base,
                $header_base,
                $header_cart,
                $header_dropdown,
                $header_dropdown_menu,
                $header_fullscreen_nav,
                $header_logo,
                $header_module_trigger,
                $header_nav_trigger,
                $header_primary_menu,
                $header_scroll_indicator,
                $header_search,
                $header_side_drawer,
                $header_v_sep,
                $accordion,
                $animated_frame,
                $asymmetric_slider,
                $banner,
                $banner_bananas,
                $block_reveal,
                $blog,
                $breadcrumb,
                $button,
                $carousel,
                $contact_form,
                $countdown,
                $counter,
                $custom_list,
                $custom_menu,
                $fancy_box,
                $fancy_heading,
                $fancy_image,
                $fullscreen_project,
                $filter_list,
                $flipbox,
                $google_map,
                $highlight,
                $hotspot,
                $iconbox,
                $iconbox_circle,
                $image_comparison,
                $image_gallery,
                $image_text_overlay,
                $image_text_slider,
                $instagram_feed,
                $interactive_text_image,
                $lightbox,
                $mask_slider,
                $media_element,
                $milestone,
                $modal,
                $newsletter,
                $overlay_link,
                $page_blocks,
                $page_frame,
                $pagination,
                $particles,
                $portfolio_list,
                $portfolio_single_meta,
                $pricing_table,
                $process_box,
                $progressbar,
                $roadmap,
                $services_slideshow,
                $sidebar,
                $slideshow,
                $snickers_bar,
                $social_icon,
                $split_text,
                $tab,
                $team_member,
                $testimonial,
                $text_rotator,
                $titlebar,
                $typewriter,
                $v_line,
                $vertical_slider,
                $video_bg
            );

            // Register all seperated css files.
            foreach ( $src as $name => $path ){
                wp_register_style( 
                    $name, 
                    plugins_url( '/assets/css/', dirname(__FILE__)) . $src[$name],
                    [],
                    LD_ELEMENTOR_VERSION
                );
            }

            // JS
            $js_uri = plugins_url( '/assets/js/', dirname(__FILE__));
            $vendors_uri = get_template_directory_uri() . '/assets/vendors/';

            $animated_icon_js = array(
                'lqdsep-js-aniamted-icon' => $js_uri . 'animated-icon/js/vivus.min.js',
            );

            $append_template_js = array(
                'lqdsep-js-append-template' => $js_uri . 'liquid-append-template/liquid-append-template.min.js',
            );

            $bootstrap_js = array(
                'lqdsep-js-bootstrap' => $vendors_uri . 'bootstrap/js/bootstrap.min.js',
            );

            $carousel_js = array(
                'lqdsep-js-flickity-base' => $js_uri . 'carousel/flickity.pkgd.min.js',
                'lqdsep-js-flickity-fade' => $js_uri . 'carousel/flickity-fade.min.js',
            );

            $countdown_js = array(
                'lqdsep-js-countdown-base' => $vendors_uri . 'countdown/jquery.countdown.min.js',
                'lqdsep-js-countdown-jquery' => $vendors_uri . 'countdown/jquery.plugin.min.js',
            );

            $draggabilly_js = array(
                'lqdsep-js-draggabilly-base' => $vendors_uri . 'draggabilly.pkgd.min.js',
            );

            $fastdom_js = array(
                'lqdsep-js-fastdom-base' => $vendors_uri . 'fastdom/fastdom.min.js',
            );

            $fontface_observer_js = array(
                'lqdsep-js-fontface-observer-base' => $vendors_uri . 'fontfaceobserver.js',
            );

            $gsap_js = array(
                'lqdsep-js-gsap-base' => $vendors_uri . 'gsap/minified/gsap.min.js',
                'lqdsep-js-scrolltrigger-base' => $vendors_uri . 'gsap/minified/ScrollTrigger.min.js',
                'lqdsep-js-custom-ease' => $vendors_uri . 'gsap/utils/CustomEase.min.js',
            );

            $imagesloaded_js = array(
                'lqdsep-js-imagesloaded-base' => $vendors_uri . 'imagesloaded.pkgd.min.js',
            );

            $interactive_swap_js = array(
                'lqdsep-js-interactive-swap' => $js_uri . 'liquid-interactive-swap/liquid-interactive-swap.min.js',
            );

            $lightbox_js = array(
                'lqdsep-js-lightbox' => $js_uri . 'lightbox/fresco.min.js'
            );

            $jquery_ui_js = array(
                'lqdsep-js-jquery-ui-base' => $vendors_uri . 'jquery-ui/jquery-ui.min.js',
                'lqdsep-js-jquery-ui-touch' => $vendors_uri . 'jquery-ui/jquery.ui.touch-punch.min.js',
            );

            $lazyload_js = array(
                'lqdsep-js-lazyload' => $vendors_uri . 'lazyload.min.js',
            );

            $masonry_js = array(
                'lqdsep-js-isotope' => $js_uri . 'masonry/isotope.pkgd.min.js',
                'lqdsep-js-isotope-packery' => $js_uri . 'masonry/packery-mode.pkgd.min.js',
            );

            $modal_js = array(
                'lqdsep-js-modal' => $js_uri . 'modal/lity.min.js'
            );

            $mouse_pos_js = array(
                'lqdsep-js-mouse-pos' => $js_uri . 'liquid-mouse-pos/liquid-mouse-pos.min.js'
            );

            $particles_js = array(
                'lqdsep-js-particles' => $vendors_uri . 'particles.min.js',
            );

            $switch_active_js = array(
                'lqdsep-js-switch-active' => $js_uri . 'liquid-switch-active/liquid-switch-active.min.js',
            );

            $t_js = array(
                'lqdsep-js-t' => $vendors_uri . 't-js/t.min.js',
            );

            $three_js = array(
                'lqdsep-js-three' => $vendors_uri . 'threejs/three.min.js',
            );

            $tinycolor_js = array(
                'lqdsep-js-tinycolor' => $vendors_uri . 'tinycolor-min.js',
            );

            $splittext_js = array(
                'lqdsep-js-splittext-base' => $js_uri . 'splittext/SplitText.min.js'
            );

            $video_bg_js = array(
                'lqdsep-js-ytplayer' => $vendors_uri . 'jqury.mb.YTPlayer/jquery.mb.YTPlayer.min.js',
            );

            $src_js = array_merge(
                $animated_icon_js,
                $append_template_js,
                $bootstrap_js,
                $carousel_js,
                $countdown_js,
                $draggabilly_js,
                $fastdom_js,
                $fontface_observer_js,
                $gsap_js,
                $imagesloaded_js,
                $interactive_swap_js,
                $lightbox_js,
                $jquery_ui_js,
                $lazyload_js,
                $masonry_js,
                $modal_js,
                $mouse_pos_js,
                $particles_js,
                $switch_active_js,
                $t_js,
                $three_js,
                $tinycolor_js,
                $splittext_js,
                $video_bg_js
            );

            // Register all seperated js files.
            foreach ( $src_js as $name => $path ){
                wp_register_script( 
                    $name, 
                    $src_js[$name],
                    [],
                    LD_ELEMENTOR_VERSION
                );
            }
    
        }

        function enq_widget_assets( \Elementor\Element_Base $element ){

            if ( \Elementor\Plugin::$instance->preview->is_preview_mode() ){
                return; // if preview mode, return
            }

            $this->get_theme_options_files();
            $this->get_elementor_page_settings( get_the_ID() );
            
            $arr = $arr_js = array();
            $combined_css = true;
            $combined_js = $this->check_combine_js();
            $theme_option = get_option('liquid_one_opt');
            $element_name = $element->get_name();
            $base_files = array();
            $theme_options_files = $this->theme_options_files['theme_options_files'];
            $elementor_page_settings = $this->elementor_page_settings['elementor_page_settings'];
            $widget_options = array();
            $widget_utils = array();
            $to_enq = array();

            // load rules
            $path = array_diff(
                scandir(__DIR__ . '/widget-assets/rules/'),
                array(
                    '.',
                    '..',
                    'button.php',
                    'carousel.php',
                    'testimonials.php'
                )
            );
            foreach ($path as $file) {
                include "widget-assets/rules/$file";
            };

            $widget_utils = array_merge(
                $this->theme_options_files['widget_utils'],
                $this->elementor_page_settings['widget_utils'],
                $widget_utils
            );

            if (
                $element->get_settings( 'lqd_custom_animation' ) === 'yes' ||
                $element->get_settings( 'lqd_parallax' ) === 'yes'
            ){
                $widget_options['lqdsep-js-scrolltrigger-base'] = array( 'type' => 'js' );
                $widget_options['lqdsep-js-gsap-base'] = array( 'type' => 'js' );
            }

            if ( $element->get_settings( 'lqd_custom_animation' ) === 'yes' ){
                $widget_options['lqdsep-custom-animations'] = array();
            }

            if ( $element->get_settings( 'lqd_parallax' ) === 'yes' ){
                $widget_utils['lqdsep-utils-pos-abs'] = array();
                $widget_utils['lqdsep-utils-zindex--1'] = array();
                $widget_utils['lqdsep-utils-pointer-events-none'] = array();
                $widget_options['lqdsep-js-fastdom-base'] = array( 'type' => 'js' );
            }

            // DO NOT CHANGE THE ORDER
            $to_enq = array_merge(
                $base_files,
                $widget_utils,
                $theme_options_files,
                $elementor_page_settings,
                $header_files,
                $widget_options
            );

            if ( ! empty( $to_enq ) ) {
                $this->enq( $element, $combined_css, $combined_js, $arr, $arr_js, $to_enq );
            }
    
        }

        function get_button_param_options( $element, $prefix ) {

            if ( empty($element) ){
                return array();
            }

           if ( $element->get_settings( 'show_button' ) !== 'yes' ) {
                return array();
            }

            // load button rules
            include "widget-assets/rules/button.php";

            return $widget_options;
        }

        function get_carousel_param_options( $element ) {

            if ( empty($element) ){
                return array();
            }

            $element_name = $element->get_name();

            // load carousel rules
            include "widget-assets/rules/carousel.php";

            return $widget_options;
        }

        function get_testimonial_param_options( $element, $repeater ) {

            if ( empty($element) ){
                return array();
            }

            $repeater_name = '';

            if ( $repeater ){
                $repeater_name = $repeater;
            }

            $element_name = $element->get_name();

            include "widget-assets/rules/testimonials.php";

            // usage get this element value: 
            // $this->get_repeater_item_param($element, $repeater_name, 'template');

            /*
            example: 
            $widget_options = array(
                'lqdsep-btn-shape-solid' => array( 'conditions' => $this->get_repeater_item_param($element, $repeater_name, 'template') === 'btn-solid' ),
            );
            */

            $widget_options = array_merge( $widget_options, $widget_utils );

            return $widget_options;

        }

        function get_repeater_item_param( $element, $repeater, $control ){

            // check if element is not empty
            if ( empty($element) || empty($control) ){
                return;
            }

            // check if repeater is not empty
            if ( empty( $repeater ) ){
                return $element->get_settings( $control ); // if empty -- return default control value
            } else {
                return $element->get_settings( $repeater )[0][$control]; // if not empty -- return repeater control value
            }

        }

        function get_repeater_item_condition( $element, $repeater, $control, $condition ){ // return condition for repeater item

            // check if element is not empty
            if ( empty($element) || empty($control) ){
                return;
            }

            // check if repeater is not empty
            if ( empty( $repeater ) ){
                return $element->get_settings( $control ); // if empty -- return default control value
            } else {

                 foreach( $element->get_settings( $repeater ) as $item ){
                     if ( $item[$control] == $condition ){
                         return true;
                     }
                 }
                 return '';
                 
            }

        }

        /**
         * $files = array(
            * 'file-key' => array(
                * type => 'css' || 'js',
                * 'conditions' => e.g. $element->get_settings( 'active_style' ) === 'yes' || $element->get_settings( 'items_shadow' ) === 'yes',
            * ),
            * 'file-key' => ...,
            * 'file-key' => ...
         * );
         */
        function enq( $element, $combined_css, $combined_js, $arr, $arr_js, $files = [] ) {

            if ( empty( $files ) ) {
                return;
            }

            $has_css_file = false;
            $has_js_file = false;

            foreach ( $files as $key => $file ) {

                $type = isset($file['type']) ? $file['type'] : 'css';

                if ( $type === 'css' ) {
                    if ( ! isset( $file['conditions'] ) ) {
                        $combined_css ? $arr[] = $key : wp_enqueue_style( $key );
                    } else if ( $file['conditions'] ) {
                        $combined_css ? $arr[] = $key : wp_enqueue_style( $key );
                    }
                    $has_css_file = true;
                } else if ( $type === 'js' ) {
                    if ( ! isset( $file['conditions'] ) ) {
                        $combined_js ? $arr_js[] = $key : wp_enqueue_script( $key );
                    } else if ( $file['conditions'] ) {
                        $combined_js ? $arr_js[] = $key : wp_enqueue_script( $key );
                    }
                    $has_js_file = true;
                }

            }

            if ( $has_css_file && !is_bool($this->merged_css) ) {
                $this->merged_css = array_unique(array_merge($this->merged_css, $arr));
            }
            if ( $has_js_file && !is_bool($this->merged_js) ) {
                $this->merged_js = array_unique(array_merge($this->merged_js, $arr_js));
            }

        }

        function get_cache( $post_id = '' ) {

            $post_id = $post_id ? $post_id : get_the_ID();

            $get_cache = get_option( 'liquid_assets_cache' );

            if ( is_array( $get_cache ) ){
                if ( in_array( $post_id, $get_cache ) ){     
                    return true;
                }
            }

            return false;

        }

        function set_cache() {
            $get_cache = get_option('liquid_assets_cache');
            if ( !is_array($get_cache) ){
                $get_cache = array();
                $get_cache[] = get_the_ID();
                update_option('liquid_assets_cache', $get_cache , 'yes' );
            } else {
                $get_cache[] = get_the_ID();
                update_option('liquid_assets_cache', array_unique($get_cache), 'yes' );
            }
        }

        function check_optimization(){
            $theme_option = get_option('liquid_one_opt');
            if (isset($theme_option['enable_optimized_files']) && $theme_option['enable_optimized_files'] === 'on') {
                return true;
            } else {
                return false;
            }
        }
        
        function check_combine_js(){
            $theme_option = get_option('liquid_one_opt');
            if (isset($theme_option['combine_js']) && $theme_option['combine_js'] === 'on') {
                return true;
            } else {
                return false;
            }
        }

        function merge_theme_and_page_settings($options_obj, $key, $type, $conditions) {

            $theme_options_files = $this->theme_options_files[$options_obj];

            if ( isset( $this->theme_options_files[$options_obj][$key] ) ) {
                $this->theme_options_files[$options_obj][$key]['conditions'] = $theme_options_files[$key]['conditions'] || $conditions;
            } else {
                $obj = array();
                $type === 'js' && $obj['type'] = 'js';
                $obj['conditions'] = $conditions;
                $this->theme_options_files[$options_obj][$key] = $obj;
            }
            
        }

        function merge_button_settings($widget_options, $button_options) {

            if ( ! $widget_options && $button_options ) {
                return $button_options;
            }

            $w_opts = $widget_options;
            $btn_opts = $button_options;

            foreach ($w_opts as $w_opt_key => $w_opt_val) {
                foreach ($btn_opts as $btn_opt_key => $btn_opt_val) {
                    if ( $w_opt_key === $btn_opt_key ) {
                        // if one of conditions not set, it means we just need to load the asset without any condition :D
                        if ( ! isset( $w_opt_val['conditions'] ) || ! isset( $btn_opt_val['conditions'] ) ) {
                            $w_opts[$w_opt_key]['conditions'] = true;
                        } else {
                            $w_opts[$w_opt_key]['conditions'] = $w_opt_val['conditions'] || $btn_opt_val['conditions'];
                        }
                        unset($btn_opts[$btn_opt_key]);
                    }
                }
            }

            return array_merge($w_opts, $btn_opts);

        }

        function merge_all_separated_styles($wp_styles) {
            
            /*
                #1. Reorder the handles based on its dependency, 
                    The result will be saved in the to_do property ($wp_scripts->to_do)
            */

            $uploads = wp_upload_dir();
            
            $merged_file_location = $uploads['basedir'] . DIRECTORY_SEPARATOR . 'liquid-styles/liquid-merged-styles-' . get_the_ID() . '.css';
            
            $merged_script = '';

            $styles = $this->merged_css;

            // check
            if ( empty( $styles ) ) {
                //return;
            }

            // Loop javascript files and save to $merged_script variable
            foreach( $styles as $handle ) {
                # Clean up url

                $src = strtok($wp_styles->registered[$handle]->src, '?');
                #2. Combine CSS file.            

                // If src is url http / https
                
                if (strpos($src, 'http') !== false){
                    // Get our site url
                    $site_url = site_url();
                
                    /*
                        If we are on local server, then change url to relative path
                    */

                    if (strpos($src, $site_url) !== false)
                        $js_file_path = str_replace($site_url, '', $src);
                    else
                        $js_file_path = $src;
                    
                    /*
                        To be able to use file_get_contents function we need to remove slash
                    */

                    $js_file_path = ltrim($js_file_path, '/');
                }
                else {			
                    $js_file_path = ltrim($src, '/');
                }
                
                // Check wether file exists then merge

                if  (file_exists($js_file_path)) {
                    #3. Check for wp_localize_script

                    $localize = '' ;

                    if (@key_exists('after', $wp_styles->registered[$handle]->extra)) {
                        //$localize = $wp_styles->registered[$handle]->extra['after']['1'] . ';';
                    }

                    $merged_script .=  $localize . file_get_contents($js_file_path);
                }
            }
            
            // write the merged script into current theme directory
            file_put_contents ( $merged_file_location , $merged_script);

        }

        function merge_all_separated_scripts($wp_scripts) {
            
            /*
                #1. Reorder the handles based on its dependency, 
                    The result will be saved in the to_do property ($wp_scripts->to_do)
            */

            $uploads = wp_upload_dir();
            
            $merged_file_location = $uploads['basedir'] . DIRECTORY_SEPARATOR . 'liquid-styles/liquid-merged-scripts-' . get_the_ID() . '.js';
            
            $merged_script = '';

            $scripts = $this->merged_js;

            // check
            if ( empty( $scripts ) ) {
                //return;
            }

            // Loop javascript files and save to $merged_script variable
            foreach( $scripts as $handle ) {
                # Clean up url

                $src = strtok($wp_scripts->registered[$handle]->src, '?');
                #2. Combine CSS file.            

                // If src is url http / https
                
                if (strpos($src, 'http') !== false){
                    // Get our site url
                    $site_url = site_url();
                
                    /*
                        If we are on local server, then change url to relative path
                    */

                    if (strpos($src, $site_url) !== false)
                        $js_file_path = str_replace($site_url, '', $src);
                    else
                        $js_file_path = $src;
                    
                    /*
                        To be able to use file_get_contents function we need to remove slash
                    */

                    $js_file_path = ltrim($js_file_path, '/');
                }
                else {			
                    $js_file_path = ltrim($src, '/');
                }
                
                // Check wether file exists then merge

                if  (file_exists($js_file_path)) {
                    #3. Check for wp_localize_script

                    $localize = '' ;

                    if (@key_exists('after', $wp_scripts->registered[$handle]->extra)) {
                        //$localize = $wp_styles->registered[$handle]->extra['after']['1'] . ';';
                    }

                    $merged_script .=  $localize . file_get_contents($js_file_path) . ';';
                }
            }
            
            // write the merged script into current theme directory
            file_put_contents ( $merged_file_location , $merged_script);

        }

        function check_styles_folder() {
            $uploads = wp_upload_dir();
            $styles_folder = $uploads['basedir'] . DIRECTORY_SEPARATOR . 'liquid-styles';
            if ( !file_exists( $styles_folder ) ) {
                wp_mkdir_p( $styles_folder );
            }
        }

    }
    new Liquid_Elementor_Widget_Assets();

endif;