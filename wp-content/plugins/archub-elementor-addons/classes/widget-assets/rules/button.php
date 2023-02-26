<?php
$text_padding_is_empty = 
    empty($element->get_settings( $prefix.'text_padding' )['top']) &&
    empty($element->get_settings( $prefix.'text_padding' )['right']) &&
    empty($element->get_settings( $prefix.'text_padding' )['bottom']) &&
    empty($element->get_settings( $prefix.'text_padding' )['left']);
$widget_options = array(
    'lqdsep-split-text-base' => array(
        'conditions' =>
            $element->get_settings( $prefix.'hover_txt_effect' ) !== ''
    ),
    'lqdsep-split-text-word' => array(
        'conditions' =>
            $element->get_settings( $prefix.'hover_txt_effect' ) !== '' &&
            (
                $element->get_settings( $prefix.'hover_txt_effect' ) === 'btn-hover-txt-liquid-x' ||
                $element->get_settings( $prefix.'hover_txt_effect' ) === 'btn-hover-txt-liquid-x-alt' ||
                $element->get_settings( $prefix.'hover_txt_effect' ) === 'btn-hover-txt-liquid-y' ||
                $element->get_settings( $prefix.'hover_txt_effect' ) === 'btn-hover-txt-liquid-y-alt'
            )
    ),
    'lqdsep-split-text-char' => array(
        'conditions' =>
            $element->get_settings( $prefix.'hover_txt_effect' ) !== '' &&
            (
                $element->get_settings( $prefix.'hover_txt_effect' ) === 'btn-hover-txt-liquid-x' ||
                $element->get_settings( $prefix.'hover_txt_effect' ) === 'btn-hover-txt-liquid-x-alt' ||
                $element->get_settings( $prefix.'hover_txt_effect' ) === 'btn-hover-txt-liquid-y' ||
                $element->get_settings( $prefix.'hover_txt_effect' ) === 'btn-hover-txt-liquid-y-alt'
            )
    ),
    'lqdsep-btn-base' => array(),
    // style
    'lqdsep-btn-shape-solid' => array(
        'conditions' =>
            $element->get_settings( $prefix.'style' ) === 'btn-solid'
    ),
    'lqdsep-btn-shape-plain' => array(
        'conditions' =>
            $element->get_settings( $prefix.'style' ) === 'btn-naked'
    ),
    'lqdsep-btn-shape-underlined' => array(
        'conditions' =>
            $element->get_settings( $prefix.'style' ) === 'btn-underlined'
    ),
    // link type
    'lqdsep-lightbox-base' => array(
        'conditions' =>
            $element->get_settings( $prefix.'link_type' ) === 'lightbox'
    ),
    'lqdsep-js-lightbox' => array(
        'type' => 'js',
        'conditions' => $element->get_settings( $prefix.'link_type' ) === 'lightbox'
    ),
    // border width
    'lqdsep-btn-shape-underlined-border-thin' => array(
        'conditions' =>
            $element->get_settings( $prefix.'style' ) === 'btn-underlined' &&
            $element->get_settings( $prefix.'border_w' ) === 'border-thin'
    ),
    'lqdsep-btn-shape-underlined-border-thick' => array(
        'conditions' =>
            $element->get_settings( $prefix.'style' ) === 'btn-underlined' &&
            $element->get_settings( $prefix.'border_w' ) === 'border-thick'
    ),
    'lqdsep-btn-shape-underlined-border-thicker' => array(
        'conditions' =>
            $element->get_settings( $prefix.'style' ) === 'btn-underlined' &&
            $element->get_settings( $prefix.'border_w' ) === 'border-thicker'
    ),
    // hover bg effect
    'lqdsep-btn-hover-bg-unfill-base' => array(
        'conditions' =>
            $element->get_settings( $prefix.'hover_bg_effect' ) !== ''
    ),
    'lqdsep-btn-hover-bg-unfill-x' => array(
        'conditions' =>
            $element->get_settings( $prefix.'hover_bg_effect' ) === 'btn-hover-bg-unfill btn-hover-bg-unfill-y btn-hover-bg-unfill-left' ||
            $element->get_settings( $prefix.'hover_bg_effect' ) === 'btn-hover-bg-unfill btn-hover-bg-unfill-y btn-hover-bg-unfill-right'
    ),
    'lqdsep-btn-hover-bg-unfill-y' => array(
        'conditions' =>
            $element->get_settings( $prefix.'hover_bg_effect' ) === 'btn-hover-bg-unfill btn-hover-bg-unfill-y btn-hover-bg-unfill-top' ||
            $element->get_settings( $prefix.'hover_bg_effect' ) === 'btn-hover-bg-unfill btn-hover-bg-unfill-y btn-hover-bg-unfill-bottom'
    ),
    'lqdsep-btn-hover-bg-unfill-top' => array(
        'conditions' =>
            $element->get_settings( $prefix.'hover_bg_effect' ) === 'btn-hover-bg-unfill btn-hover-bg-unfill-y btn-hover-bg-unfill-top'
    ),
    'lqdsep-btn-hover-bg-unfill-bottom' => array(
        'conditions' =>
            $element->get_settings( $prefix.'hover_bg_effect' ) === 'btn-hover-bg-unfill btn-hover-bg-unfill-y btn-hover-bg-unfill-bottom'
    ),
    'lqdsep-btn-hover-bg-unfill-left' => array(
        'conditions' =>
            $element->get_settings( $prefix.'hover_bg_effect' ) === 'btn-hover-bg-unfill btn-hover-bg-unfill-y btn-hover-bg-unfill-left'
    ),
    'lqdsep-btn-hover-bg-unfill-right' => array(
        'conditions' =>
            $element->get_settings( $prefix.'hover_bg_effect' ) === 'btn-hover-bg-unfill btn-hover-bg-unfill-y btn-hover-bg-unfill-right'
    ),
    // hover text effect
    'lqdsep-btn-hover-txt-liquid-x-alt' => array(
        'conditions' =>
            $element->get_settings( $prefix.'hover_txt_effect' ) === 'btn-hover-txt-liquid-x-alt'
    ),
    'lqdsep-btn-hover-txt-liquid-x' => array(
        'conditions' =>
            $element->get_settings( $prefix.'hover_txt_effect' ) === 'btn-hover-txt-liquid-x'
    ),
    'lqdsep-btn-hover-txt-liquid-y-alt' => array(
        'conditions' =>
            $element->get_settings( $prefix.'hover_txt_effect' ) === 'btn-hover-txt-liquid-y-alt'
    ),
    'lqdsep-btn-hover-txt-liquid-y' => array(
        'conditions' =>
            $element->get_settings( $prefix.'hover_txt_effect' ) === 'btn-hover-txt-liquid-y'
    ),
    'lqdsep-btn-hover-txt-switch-base' => array(
        'conditions' =>
            $element->get_settings( $prefix.'hover_txt_effect' ) === 'btn-hover-txt-switch btn-hover-txt-switch-x' ||
            $element->get_settings( $prefix.'hover_txt_effect' ) === 'btn-hover-txt-switch btn-hover-txt-switch-y' ||
            $element->get_settings( $prefix.'hover_txt_effect' ) === 'btn-hover-txt-switch-change btn-hover-txt-switch btn-hover-txt-switch-y'
    ),
    'lqdsep-btn-hover-txt-switch-x' => array(
        'conditions' =>
            $element->get_settings( $prefix.'hover_txt_effect' ) === 'btn-hover-txt-switch btn-hover-txt-switch-x'
    ),
    'lqdsep-btn-hover-txt-switch-y' => array(
        'conditions' =>
            $element->get_settings( $prefix.'hover_txt_effect' ) === 'btn-hover-txt-switch btn-hover-txt-switch-y' ||
            $element->get_settings( $prefix.'hover_txt_effect' ) === 'btn-hover-txt-switch-change btn-hover-txt-switch btn-hover-txt-switch-y'
    ),
    'lqdsep-btn-hover-txt-change' => array(
        'conditions' =>
            $element->get_settings( $prefix.'hover_txt_effect' ) === 'btn-hover-txt-switch-change btn-hover-txt-switch btn-hover-txt-switch-y'
    ),
    'lqdsep-btn-hover-txt-marquee-base' => array(
        'conditions' =>
            $element->get_settings( $prefix.'hover_txt_effect' ) === 'btn-hover-txt-marquee btn-hover-txt-marquee-x' ||
            $element->get_settings( $prefix.'hover_txt_effect' ) === 'btn-hover-txt-marquee btn-hover-txt-marquee-y'
    ),
    'lqdsep-btn-hover-txt-marquee-x' => array(
        'conditions' =>
            $element->get_settings( $prefix.'hover_txt_effect' ) === 'btn-hover-txt-marquee btn-hover-txt-marquee-x'
    ),
    'lqdsep-btn-hover-txt-marquee-y' => array(
        'conditions' =>
            $element->get_settings( $prefix.'hover_txt_effect' ) === 'btn-hover-txt-marquee btn-hover-txt-marquee-y'
    ),
    // icon
    'lqdsep-btn-icon-base' => array(
        'conditions' =>
            $element->get_settings( $prefix.'i_add_icon' ) === 'true'
    ),
    'lqdsep-btn-icon-left' => array(
        'conditions' =>
            $element->get_settings( $prefix.'i_add_icon' ) === 'true' &&
            $element->get_settings( $prefix.'i_position' ) === 'btn-icon-left'
    ),
    'lqdsep-btn-icon-block' => array(
        'conditions' =>
            $element->get_settings( $prefix.'i_add_icon' ) === 'true' &&
            (
                $element->get_settings( $prefix.'i_position' ) === 'btn-icon-block btn-icon-top' ||
                $element->get_settings( $prefix.'i_position' ) === 'btn-icon-block'
            )
    ),
    'lqdsep-btn-icon-top' => array(
        'conditions' =>
            $element->get_settings( $prefix.'i_add_icon' ) === 'true' &&
            $element->get_settings( $prefix.'i_position' ) === 'btn-icon-block btn-icon-top'
    ),
    // icon shape style
    'lqdsep-btn-icon-shape' => array(
        'conditions' =>
            $element->get_settings( $prefix.'i_add_icon' ) === 'true' &&
            (
                $element->get_settings( $prefix.'i_shape_style' ) === 'btn-icon-solid' ||
                $element->get_settings( $prefix.'i_shape_style' ) === 'btn-icon-bordered'
            )
    ),
    'lqdsep-btn-icon-shape-solid' => array(
        'conditions' =>
            $element->get_settings( $prefix.'i_add_icon' ) === 'true' &&
            $element->get_settings( $prefix.'i_shape_style' ) === 'btn-icon-solid'
    ),
    // icon shape
    'lqdsep-btn-icon-shape-semiround' => array(
        'conditions' =>
            $element->get_settings( $prefix.'i_add_icon' ) === 'true' &&
            $element->get_settings( $prefix.'i_shape' ) === 'btn-icon-semi-round'
    ),
    'lqdsep-btn-icon-shape-round' => array(
        'conditions' =>
            $element->get_settings( $prefix.'i_add_icon' ) === 'true' &&
            $element->get_settings( $prefix.'i_shape' ) === 'btn-icon-round'
    ),
    'lqdsep-btn-icon-shape-circle' => array(
        'conditions' =>
            $element->get_settings( $prefix.'i_add_icon' ) === 'true' &&
            $element->get_settings( $prefix.'i_shape' ) === 'btn-icon-circle'
    ),
    // icon shape border width
    'lqdsep-btn-icon-border-thick' => array(
        'conditions' =>
            $element->get_settings( $prefix.'i_add_icon' ) === 'true' &&
            $element->get_settings( $prefix.'i_shape_bw' ) === 'btn-icon-border-thick'
    ),
    'lqdsep-btn-icon-border-thicker' => array(
        'conditions' =>
            $element->get_settings( $prefix.'i_add_icon' ) === 'true' &&
            $element->get_settings( $prefix.'i_shape_bw' ) === 'btn-icon-border-thicker'
    ),
    'lqdsep-btn-icon-border-thickest' => array(
        'conditions' =>
            $element->get_settings( $prefix.'i_add_icon' ) === 'true' &&
            $element->get_settings( $prefix.'i_shape_bw' ) === 'btn-icon-border-thickest'
    ),
    // size
    'lqdsep-btn-size-xsm' => array(
        'conditions' =>
            $element->get_settings( $prefix.'size' ) === 'btn-xsm' &&
            $text_padding_is_empty
    ),
    'lqdsep-btn-size-sm' => array(
        'conditions' =>
            $element->get_settings( $prefix.'size' ) === 'btn-sm' &&
            $text_padding_is_empty
    ),
    'lqdsep-btn-size-md' => array(
        'conditions' =>
            $element->get_settings( $prefix.'size' ) === 'btn-md' &&
            $text_padding_is_empty
    ),
    'lqdsep-btn-size-lg' => array(
        'conditions' =>
            $element->get_settings( $prefix.'size' ) === 'btn-lg' &&
            $text_padding_is_empty
    ),
    'lqdsep-btn-size-xlg' => array(
        'conditions' =>
            $element->get_settings( $prefix.'size' ) === 'btn-xlg' &&
            $text_padding_is_empty
    ),
    'lqdsep-btn-size-custom' => array(
        'conditions' =>
            $element->get_settings( $prefix.'size' ) === 'btn-custom-size'
    ),
    'lqdsep-btn-extended-lines' => array(
        'conditions' =>
            $element->get_settings( $prefix.'style' ) === 'btn-solid' &&
            $element->get_settings( $prefix.'extended_lines' ) === 'yes'
    ),
    // icon shape size
    'lqdsep-btn-icon-size-xsm' => array(
        'conditions' =>
            $element->get_settings( $prefix.'i_add_icon' ) === 'true' &&
            $element->get_settings( $prefix.'i_shape_size' ) === 'btn-icon-xsm'
    ),
    'lqdsep-btn-icon-size-sm' => array(
        'conditions' =>
            $element->get_settings( $prefix.'i_add_icon' ) === 'true' &&
            $element->get_settings( $prefix.'i_shape_size' ) === 'btn-icon-sm'
    ),
    'lqdsep-btn-icon-size-md' => array(
        'conditions' =>
            $element->get_settings( $prefix.'i_add_icon' ) === 'true' &&
            $element->get_settings( $prefix.'i_shape_size' ) === 'btn-icon-md'
    ),
    'lqdsep-btn-icon-size-lg' => array(
        'conditions' =>
            $element->get_settings( $prefix.'i_add_icon' ) === 'true' &&
            $element->get_settings( $prefix.'i_shape_size' ) === 'btn-icon-lg'
    ),
    'lqdsep-btn-icon-size-xlg' => array(
        'conditions' =>
            $element->get_settings( $prefix.'i_add_icon' ) === 'true' &&
            $element->get_settings( $prefix.'i_shape_size' ) === 'btn-icon-xlg'
    ),
    // icon hover
    'lqdsep-btn-hover-reveal' => array(
        'conditions' =>
            $element->get_settings( $prefix.'i_add_icon' ) === 'true' &&
            $element->get_settings( $prefix.'i_hover_reveal' ) === 'btn-hover-reveal'
    ),
    'lqdsep-btn-hover-swap' => array(
        'conditions' =>
            $element->get_settings( $prefix.'i_add_icon' ) === 'true' &&
            $element->get_settings( $prefix.'i_hover_reveal' ) === 'btn-hover-swp'
    ),
    // icon ripple
    'lqdsep-btn-icon-ripple' => array(
        'conditions' =>
            $element->get_settings( $prefix.'i_add_icon' ) === 'true' &&
            $element->get_settings( $prefix.'i_ripple' ) === 'btn-icon-ripple'
    ),
    // icon separator
    'lqdsep-btn-icon-sep' => array(
        'conditions' =>
            $element->get_settings( $prefix.'i_add_icon' ) === 'true' &&
            $element->get_settings( $prefix.'i_separator' ) === 'btn-icon-sep'
    ),
    // js
    'lqdsep-js-fastdom-base' => array(
        'type' => 'js',
        'conditions' =>
            $element->get_settings( $prefix.'hover_txt_effect' ) !== ''
    ),
    'lqdsep-js-imagesloaded-base' => array(
        'type' => 'js',
        'conditions' =>
            $element->get_settings( $prefix.'link_type' ) === 'local_scroll'
    ),
    'lqdsep-js-fontface-observer-base' => array(
        'type' => 'js',
        'conditions' =>
            $element->get_settings( $prefix.'hover_txt_effect' ) !== ''
    ),
    'lqdsep-js-splittext-base' => array(
        'type' => 'js',
        'conditions' =>
            $element->get_settings( $prefix.'hover_txt_effect' ) !== ''
    ),
);