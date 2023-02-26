<?php 
$widget_options = array(
    'lqdsep-carousel-base' => array(),
    'lqdsep-carousel-draggable' => array(
        'conditions' =>
            $element->get_settings( 'draggable' ) === ''
    ),
    'lqdsep-carousel-equal-cells' => array(
        'conditions' =>
            $element->get_settings( 'equalheightcells' ) === 'yes' ||
            $element->get_settings( 'marquee' ) === 'yes'
    ),
    'lqdsep-carousel-fade' => array(
        'conditions' =>
            $element->get_settings( 'fadeeffect' ) === 'yes'
    ),
    'lqdsep-carousel-random-v-offset' => array(
        'conditions' =>
            $element->get_settings( 'randomveroffset' ) === 'yes'
    ),
    'lqdsep-carousel-shadow-active' => array(
        'conditions' =>
            $element->get_settings( 'shadow' ) === 'carousel-shadow-active'
    ),
    'lqdsep-carousel-shadow-all' => array(
        'conditions' =>
            $element->get_settings( 'shadow' ) === 'carousel-shadow-all'
    ),
    'lqdsep-carousel-dots-base' => array(
        'conditions' =>
            $element->get_settings( 'marquee' ) !== 'yes'
    ),
    'lqdsep-carousel-dots-align-h-center' => array(
        'conditions' =>
            $element->get_settings( 'marquee' ) !== 'yes' &&
            $element->get_settings( 'pagenationdots' ) === 'yes' &&
            $element->get_settings( 'align_dots' ) === ''
    ),
    'lqdsep-carousel-dots-align-h-left' => array(
        'conditions' =>
            $element->get_settings( 'marquee' ) !== 'yes' &&
            $element->get_settings( 'pagenationdots' ) === 'yes' &&
            $element->get_settings( 'align_dots' ) === 'carousel-dots-left'
    ),
    'lqdsep-carousel-dots-align-h-right' => array(
        'conditions' =>
            $element->get_settings( 'marquee' ) !== 'yes' &&
            $element->get_settings( 'pagenationdots' ) === 'yes' &&
            $element->get_settings( 'align_dots' ) === 'carousel-dots-right'
    ),
    'lqdsep-carousel-dots-align-v-bottom' => array(
        'conditions' =>
            $element->get_settings( 'marquee' ) !== 'yes' &&
            $element->get_settings( 'pagenationdots' ) === 'yes' &&
            $element->get_settings( 'dots_vertical_align' ) === ''
    ),
    'lqdsep-carousel-dots-align-v-middle' => array(
        'conditions' =>
            $element->get_settings( 'marquee' ) !== 'yes' &&
            $element->get_settings( 'pagenationdots' ) === 'yes' &&
            $element->get_settings( 'dots_vertical_align' ) === 'carousel-dots-middle'
    ),
    'lqdsep-carousel-dots-align-v-top' => array(
        'conditions' =>
            $element->get_settings( 'marquee' ) !== 'yes' &&
            $element->get_settings( 'pagenationdots' ) === 'yes' &&
            $element->get_settings( 'dots_vertical_align' ) === 'carousel-dots-top'
    ),
    'lqdsep-carousel-dots-inside' => array(
        'conditions' =>
            $element->get_settings( 'marquee' ) !== 'yes' &&
            $element->get_settings( 'pagenationdots' ) === 'yes' &&
            $element->get_settings( 'dots_position' ) === 'carousel-dots-inside'
    ),
    'lqdsep-carousel-dots-mobile-inside' => array(
        'conditions' =>
            $element->get_settings( 'marquee' ) !== 'yes' &&
            $element->get_settings( 'mobile_dots_position' ) === 'carousel-dots-mobile-inside'
    ),
    'lqdsep-carousel-dots-mobile-left' => array(
        'conditions' =>
            $element->get_settings( 'marquee' ) !== 'yes' &&
            $element->get_settings( 'mobile_align_dots' ) === 'carousel-dots-mobile-left'
    ),
    'lqdsep-carousel-dots-mobile-right' => array(
        'conditions' =>
            $element->get_settings( 'marquee' ) !== 'yes' &&
            $element->get_settings( 'mobile_align_dots' ) === 'carousel-dots-mobile-right'
    ),
    'lqdsep-carousel-dots-size-lg' => array(
        'conditions' =>
            $element->get_settings( 'marquee' ) !== 'yes' &&
            $element->get_settings( 'pagenationdots' ) === 'yes' &&
            $element->get_settings( 'size_dots' ) === 'carousel-dots-lg'
    ),
    'lqdsep-carousel-dots-size-sm' => array(
        'conditions' =>
            $element->get_settings( 'marquee' ) !== 'yes' &&
            $element->get_settings( 'pagenationdots' ) === 'yes' &&
            $element->get_settings( 'size_dots' ) === 'carousel-dots-sm'
    ),
    'lqdsep-carousel-dots-slides-numbers' => array(
        'conditions' =>
            $element->get_settings( 'marquee' ) !== 'yes' &&
            (
                $element->get_settings( 'pagenationdots' ) === 'yes' &&
                $element->get_settings( 'dots_type' ) === 'numbers'
            ) ||
            (
                $element->get_settings( 'navslidernumberstoarrows' ) === 'yes'
            )
    ),
    'lqdsep-carousel-dots-slides-line' => array(
        'conditions' =>
            $element->get_settings( 'marquee' ) !== 'yes' &&
            $element->get_settings( 'pagenationdots' ) === 'yes' &&
            $element->get_settings( 'dots_type' ) === 'numbers' &&
            $element->get_settings( 'number_style' ) === 'line'
    ),
    'lqdsep-carousel-dots-style-2' => array(
        'conditions' =>
            $element->get_settings( 'marquee' ) !== 'yes' &&
            $element->get_settings( 'pagenationdots' ) === 'yes' &&
            $element->get_settings( 'dots_style' ) === 'carousel-dots-style2'
    ),
    'lqdsep-carousel-dots-style-3' => array(
        'conditions' =>
            $element->get_settings( 'marquee' ) !== 'yes' &&
            $element->get_settings( 'pagenationdots' ) === 'yes' &&
            $element->get_settings( 'dots_style' ) === 'carousel-dots-style3'
    ),
    'lqdsep-carousel-dots-style-4' => array(
        'conditions' =>
            $element->get_settings( 'marquee' ) !== 'yes'
    ),
    'lqdsep-carousel-dots-vertical' => array(
        'conditions' =>
            $element->get_settings( 'marquee' ) !== 'yes' &&
            $element->get_settings( 'pagenationdots' ) === 'yes' &&
            $element->get_settings( 'dots_orientation' ) === 'carousel-dots-vertical'
    ),
    'lqdsep-carousel-nav-base' => array(
        'conditions' =>
            $element->get_settings( 'marquee' ) !== 'yes' &&
            $element->get_settings( 'prevnextbuttons' ) === 'yes'
    ),
    'lqdsep-carousel-nav-align-h-bottom' => array(
        'conditions' =>
            $element->get_settings( 'marquee' ) !== 'yes' &&
            $element->get_settings( 'prevnextbuttons' ) === 'yes' &&
            $element->get_settings( 'navvalign' ) === 'carousel-nav-bottom'
    ),
    'lqdsep-carousel-nav-align-h-middle' => array(
        'conditions' =>
            $element->get_settings( 'marquee' ) !== 'yes' &&
            $element->get_settings( 'prevnextbuttons' ) === 'yes' &&
            $element->get_settings( 'navvalign' ) === 'carousel-nav-middle'
    ),
    'lqdsep-carousel-nav-align-h-top' => array(
        'conditions' =>
            $element->get_settings( 'marquee' ) !== 'yes' &&
            $element->get_settings( 'prevnextbuttons' ) === 'yes' &&
            $element->get_settings( 'navvalign' ) === 'carousel-nav-top'
    ),
    'lqdsep-carousel-nav-align-v-center' => array(
        'conditions' =>
            $element->get_settings( 'marquee' ) !== 'yes' &&
            $element->get_settings( 'prevnextbuttons' ) === 'yes' &&
            $element->get_settings( 'navhalign' ) === 'carousel-nav-center'
    ),
    'lqdsep-carousel-nav-align-v-left' => array(
        'conditions' =>
            $element->get_settings( 'marquee' ) !== 'yes' &&
            $element->get_settings( 'prevnextbuttons' ) === 'yes' &&
            $element->get_settings( 'navhalign' ) === 'carousel-nav-left'
    ),
    'lqdsep-carousel-nav-align-v-right' => array(
        'conditions' =>
            $element->get_settings( 'marquee' ) !== 'yes' &&
            $element->get_settings( 'prevnextbuttons' ) === 'yes' &&
            $element->get_settings( 'navhalign' ) === 'carousel-nav-right'
    ),
    'lqdsep-carousel-nav-dot-between' => array(
        'conditions' =>
            $element->get_settings( 'marquee' ) !== 'yes' &&
            $element->get_settings( 'prevnextbuttons' ) === 'yes' &&
            $element->get_settings( 'navline' ) === 'carousel-nav-dot-between'
    ),
    'lqdsep-carousel-nav-floated' => array(
        'conditions' =>
            $element->get_settings( 'marquee' ) !== 'yes' &&
            $element->get_settings( 'prevnextbuttons' ) === 'yes' &&
            $element->get_settings( 'navfloated' ) === 'carousel-nav-floated'
    ),
    'lqdsep-carousel-nav-floated-left' => array(
        'conditions' =>
            $element->get_settings( 'marquee' ) !== 'yes' &&
            $element->get_settings( 'prevnextbuttons' ) === 'yes' &&
            $element->get_settings( 'navfloated' ) === 'carousel-nav-floated' &&
            $element->get_settings( 'navhalign' ) === 'carousel-nav-left'
    ),
    'lqdsep-carousel-nav-floated-right' => array(
        'conditions' =>
            $element->get_settings( 'marquee' ) !== 'yes' &&
            $element->get_settings( 'prevnextbuttons' ) === 'yes' &&
            $element->get_settings( 'navfloated' ) === 'carousel-nav-floated' &&
            $element->get_settings( 'navhalign' ) === 'carousel-nav-right'
    ),
    'lqdsep-carousel-nav-shadowed-onhover' => array(
        'conditions' =>
            $element->get_settings( 'marquee' ) !== 'yes' &&
            $element->get_settings( 'prevnextbuttons' ) === 'yes' &&
            $element->get_settings( 'navshadow' ) === 'carousel-nav-shadowed-onhover'
    ),
    'lqdsep-carousel-nav-shadowed' => array(
        'conditions' =>
            $element->get_settings( 'marquee' ) !== 'yes' &&
            $element->get_settings( 'prevnextbuttons' ) === 'yes' &&
            $element->get_settings( 'navshadow' ) === 'carousel-nav-shadowed'
    ),
    'lqdsep-carousel-nav-shape-circle' => array(
        'conditions' =>
            $element->get_settings( 'marquee' ) !== 'yes' &&
            $element->get_settings( 'prevnextbuttons' ) === 'yes' &&
            $element->get_settings( 'navshape' ) === 'carousel-nav-circle'
    ),
    'lqdsep-carousel-nav-shape-square' => array(
        'conditions' =>
            $element->get_settings( 'marquee' ) !== 'yes' &&
            $element->get_settings( 'prevnextbuttons' ) === 'yes' &&
            $element->get_settings( 'navshape' ) === 'carousel-nav-square'
    ),
    'lqdsep-carousel-nav-shaped-base' => array(
        'conditions' =>
            $element->get_settings( 'marquee' ) !== 'yes' &&
            $element->get_settings( 'prevnextbuttons' ) === 'yes' &&
            $element->get_settings( 'navfill' ) !== ''
    ),
    'lqdsep-carousel-nav-shaped-bordered' => array(
        'conditions' =>
            $element->get_settings( 'marquee' ) !== 'yes' &&
            $element->get_settings( 'prevnextbuttons' ) === 'yes' &&
            $element->get_settings( 'navfill' ) === 'carousel-nav-bordered'
    ),
    'lqdsep-carousel-nav-shaped-solid' => array(
        'conditions' =>
            $element->get_settings( 'marquee' ) !== 'yes' &&
            $element->get_settings( 'prevnextbuttons' ) === 'yes' &&
            $element->get_settings( 'navfill' ) === 'carousel-nav-solid'
    ),
    'lqdsep-carousel-nav-size-lg' => array(
        'conditions' =>
            $element->get_settings( 'marquee' ) !== 'yes' &&
            $element->get_settings( 'prevnextbuttons' ) === 'yes' &&
            $element->get_settings( 'navsize' ) === 'carousel-nav-lg'
    ),
    'lqdsep-carousel-nav-size-md' => array(
        'conditions' =>
            $element->get_settings( 'marquee' ) !== 'yes' &&
            $element->get_settings( 'prevnextbuttons' ) === 'yes' &&
            $element->get_settings( 'navsize' ) === 'carousel-nav-md'
    ),
    'lqdsep-carousel-nav-size-sm' => array(
        'conditions' =>
            $element->get_settings( 'marquee' ) !== 'yes' &&
            $element->get_settings( 'prevnextbuttons' ) === 'yes' &&
            $element->get_settings( 'navsize' ) === 'carousel-nav-sm'
    ),
    'lqdsep-carousel-nav-size-xl' => array(
        'conditions' =>
            $element->get_settings( 'marquee' ) !== 'yes' &&
            $element->get_settings( 'prevnextbuttons' ) === 'yes' &&
            $element->get_settings( 'navsize' ) === 'carousel-nav-xl'
    ),
    'lqdsep-carousel-nav-vertical' => array(
        'conditions' =>
            $element->get_settings( 'marquee' ) !== 'yes' &&
            $element->get_settings( 'prevnextbuttons' ) === 'yes' &&
            $element->get_settings( 'navdirection' ) === 'carousel-nav-vertical'
    ),
    'lqdsep-carousel-nav-vertical-center' => array(
        'conditions' =>
            $element->get_settings( 'marquee' ) !== 'yes' &&
            $element->get_settings( 'prevnextbuttons' ) === 'yes' &&
            $element->get_settings( 'navdirection' ) === 'carousel-nav-vertical' &&
            $element->get_settings( 'navhalign' ) === 'carousel-nav-center'
    ),
    'lqdsep-carousel-nav-vertical-left' => array(
        'conditions' =>
            $element->get_settings( 'marquee' ) !== 'yes' &&
            $element->get_settings( 'prevnextbuttons' ) === 'yes' &&
            $element->get_settings( 'navdirection' ) === 'carousel-nav-vertical' &&
            $element->get_settings( 'navhalign' ) === 'carousel-nav-left'
    ),
    'lqdsep-carousel-nav-vertical-right' => array(
        'conditions' =>
            $element->get_settings( 'marquee' ) !== 'yes' &&
            $element->get_settings( 'prevnextbuttons' ) === 'yes' &&
            $element->get_settings( 'navdirection' ) === 'carousel-nav-vertical' &&
            $element->get_settings( 'navhalign' ) === 'carousel-nav-right'
    ),
    'lqdsep-carousel-scroll-badge' => array(
        'conditions' =>
            liquid_helper()->get_theme_option( 'disable_carousel_on_mobile' ) === 'on'
    ),
    'lqdsep-carousel-cells-scale-ondrag' => array(
        'conditions' =>
            $element->get_settings( 'scale_cells_ondrag' ) === 'on'
    ),
    'lqdsep-js-imagesloaded-base' => array( 'type' => 'js' ),
    'lqdsep-js-flickity-base' => array( 'type' => 'js' ),
    'lqdsep-js-flickity-fade' => array(
        'type' => 'js',
        'conditions' =>
            $element->get_settings( 'fadeeffect' ) === 'yes'
    ),
);