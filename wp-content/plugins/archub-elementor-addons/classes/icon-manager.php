<?php
//namespace LiquidElementor\Elementor;

defined( 'ABSPATH' ) || die();

class Icons_Manager {

    public static function init() {
        add_filter( 'elementor/icons_manager/additional_tabs', [ __CLASS__, 'add_liquid_icons_tab' ] );
    }

    public static function add_liquid_icons_tab( $tabs ) {
        // Append new icons
        $icons = array(
            'speech-bubble',
            'ld-search',
            'num-10',
            'num-9',
            'num-8',
            'num-7',
            'num-6',
            'num-5',
            'num-4',
            'num-3',
            'num-2',
            'num-1',
            'lqd-check',
            'lqd-compass',
            'lqd-atom',
            'lqd-laptop',
            'lqd-stack',
            'lqd-pen-2',
            'lqd-user',
            'lqd-envelope',
            'lqd-pen',
            'lqd-dollar',
            'ion-ios-play',
            'ld-cart',
            'ion-ios-add',
            'ion-ios-checkmark',
            'ion-ios-remove',
            'ion-ios-close',
            'ion-caret-up',
            'ion-caret-back',
            'ion-caret-forward',
            'ion-ios-arrow-back',
            'ion-ios-arrow-up',
            'ion-ios-arrow-forward',
            'ion-caret-down',
            'ion-ios-arrow-down',
            'md-arrow-down',
            'md-arrow-forward',
            'md-arrow-up',
            'md-arrow-back',
            'ion-ios-arrow-round-back',
            'ion-ios-arrow-round-down',
            'md-arrow-round-up',
            'md-arrow-round-down',
            'md-arrow-round-back',
            'ion-ios-arrow-round-forward',
            'ion-ios-arrow-round-up',
            'md-arrow-round-forward',
            'md-arrow-round-up-2',
            'md-arrow-round-down-2',
            'md-arrow-round-back-2',
            'md-arrow-round-forward-2',
            'lqd-eye',
            'lqd-sync',
            'lqd-bars',
            'lqd-dots',
            'lqd-dots-alt',
            'ld-search-2',
            'lqd-user-2',
            'lqd-volume-low',
            'lqd-volume-high',
            'compare',
            'lqd-presentation',
            'lqd-cogs',
            'lqd-tools',
            'lqd-mobile',
            'lqd-target',
            'lqd-path',
            'lqd-feather',
            'lqd-smile',
            'lqd-circle',
        );
        
        $tabs['lqd-essentials'] = array(
            'name'          => 'lqd-essentials',
            'label'         => esc_html__( 'Liquid Essentials', 'archub-elementor-addons' ),
            'labelIcon'     => 'lqd-icn-ess icon-lqd-check',
            'prefix'        => 'icon-',
            'displayPrefix' => 'lqd-icn-ess',
            'url'           => get_template_directory_uri() . '/assets/vendors/liquid-icon/lqd-essentials/lqd-essentials.min.css',
            'icons'         => $icons,
            'ver'           => '1.0.0',
        );
        return $tabs;
    }

}

Icons_Manager::init();