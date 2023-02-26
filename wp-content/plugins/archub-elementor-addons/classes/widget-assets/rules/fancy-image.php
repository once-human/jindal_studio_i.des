<?php
 // Fancy box utils
 if ( $element_name === 'ld_fancy_image' ) {

    $widget_utils['lqdsep-utils-flex-d'] = array(
      'conditions' =>
        $element->get_settings('enable_lines') === 'yes'
    );

    $widget_utils['lqdsep-utils-flex-inline-d'] = array();

    $widget_utils['lqdsep-utils-h-100'] = array(
      'conditions' =>
        $element->get_settings('enable_lines') === 'yes'
    );

    $widget_utils['lqdsep-utils-flex-align-items-start'] = array(
      'conditions' =>
        $element->get_settings('enable_side_label') === 'yes' &&
        $element->get_settings('enable_side_label_overlay') !== 'yes' &&
        $element->get_settings('label_pos') === 'start'
    );
    $widget_utils['lqdsep-utils-flex-align-items-center'] = array(
      'conditions' =>
        $element->get_settings('enable_side_label') === 'yes' &&
        $element->get_settings('enable_side_label_overlay') !== 'yes' &&
        $element->get_settings('label_pos') === 'center'
    );
    $widget_utils['lqdsep-utils-flex-align-items-end'] = array(
      'conditions' =>
        $element->get_settings('enable_side_label') === 'yes' &&
        $element->get_settings('enable_side_label_overlay') !== 'yes' &&
        $element->get_settings('label_pos') === 'end'
    );
    
    $widget_utils['lqdsep-utils-flex-justify-content-start'] = array(
      'conditions' =>
        $element->get_settings('enable_lines') === 'yes'
    );

    $widget_utils['lqdsep-utils-flex-justify-content-center'] = array();

    $widget_utils['lqdsep-utils-flex-grow-1'] = array(
      'conditions' =>
        $element->get_settings('enable_lines') === 'yes'
    );

    $widget_utils['lqdsep-utils-block-d'] = array();

    $widget_utils['lqdsep-utils-m-0'] = array(
      'conditions' =>
        ! empty( $element->get_settings( 'label' ) ) &&
        $element->get_settings( 'enable_side_label' ) === 'yes'
    );

    $widget_utils['lqdsep-utils-overlay'] = array(
      'conditions' =>
        $element->get_settings('enable_lines') === 'yes' ||
        $element->get_settings('enable_lightbox') === 'yes' ||
        $element->get_settings('enable_overlay_bg') === 'yes' ||
        $element->get_settings( 'enable_interactive_swap' ) === 'yes' ||
        ! empty ( $element->get_settings('img_link')['url'] )
    );

    $widget_utils['lqdsep-utils-pos-rel'] = array();

    $widget_utils['lqdsep-utils-zindex-10'] = array();

    $widget_utils['lqdsep-utils-transform-style-3d'] = array(
      'conditions' =>
        $element->get_settings('enable_hover3d') === 'yes'
    );

};