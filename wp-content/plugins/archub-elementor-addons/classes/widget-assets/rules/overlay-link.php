<?php
 if ( $element_name === 'ld_overlay_link' ) {

    $widget_utils['lqdsep-utils-flex-inline-d'] = array(
        'conditions' =>
            $element->get_settings('enable_cc') === 'yes' &&
            ! empty($element->get_settings('cc_label'))
    );
    $widget_utils['lqdsep-utils-block-d'] = array();
    $widget_utils['lqdsep-utils-flex-align-items-center'] = array(
        'conditions' =>
            $element->get_settings('enable_cc') === 'yes' &&
            ! empty($element->get_settings('cc_label'))
    );
    $widget_utils['lqdsep-utils-flex-justify-content-center'] = array(
        'conditions' =>
            $element->get_settings('enable_cc') === 'yes' &&
            ! empty($element->get_settings('cc_label'))
    );
    $widget_utils['lqdsep-utils-p-2'] = array(
        'conditions' =>
            $element->get_settings('enable_cc') === 'yes' &&
            ! empty($element->get_settings('cc_label'))
    );
    $widget_utils['lqdsep-utils-pos-fix'] = array(
        'conditions' =>
            $element->get_settings('enable_cc') === 'yes'
    );
    $widget_utils['lqdsep-utils-overlay'] = array();
    $widget_utils['lqdsep-utils-zindex-3'] = array();
    $widget_utils['lqdsep-utils-pointer-events-none'] = array(
        'conditions' =>
            $element->get_settings('enable_cc') === 'yes'
    );

};