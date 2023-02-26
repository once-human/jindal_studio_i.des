<?php
 // Fancy box utils
 if ( $element_name === 'ld_flipbox' ) {

    $widget_utils['lqdsep-utils-flex-d'] = array();
    $widget_utils['lqdsep-utils-flex-column'] = array();
    $widget_utils['lqdsep-utils-flex-grow-1'] = array();
    $widget_utils['lqdsep-utils-flex-justify-content-center'] = array();
    $widget_utils['lqdsep-utils-flex-align-items-center'] = array();
    $widget_utils['lqdsep-utils-w-100'] = array();
    $widget_utils['lqdsep-utils-border-radius-2'] = array(
        'conditions' =>
            $element->get_settings('border_radius') === 'semi-round'
    );
    $widget_utils['lqdsep-utils-border-radius-4'] = array(
        'conditions' =>
            $element->get_settings('border_radius') === 'round'
    );
    $widget_utils['lqdsep-utils-border-radius-circle'] = array(
        'conditions' =>
            $element->get_settings('border_radius') === 'circle'
    );
    $widget_utils['lqdsep-utils-pos-rel'] = array();
    $widget_utils['lqdsep-utils-overlay'] = array();
    $widget_utils['lqdsep-utils-transform-perspective'] = array();
    $widget_utils['lqdsep-utils-transform-style-3d'] = array();
    $widget_utils['lqdsep-utils-backface-hidden'] = array();

};