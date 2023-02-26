<?php
 if ( $element_name === 'ld_image_text_overlay' ) {

    $widget_utils['lqdsep-utils-flex-d'] = array();
    $widget_utils['lqdsep-utils-flex-align-items-center'] = array();
    $widget_utils['lqdsep-utils-flex-align-items-end'] = array();
    $widget_utils['lqdsep-utils-flex-justify-content-center'] = array();
    $widget_utils['lqdsep-utils-flex-justify-content-end'] = array(
      'conditions' =>
        $element->get_settings('show_button') === 'yes'
    );
    $widget_utils['lqdsep-utils-transform-perspective'] = array();
    $widget_utils['lqdsep-utils-transform-style-3d'] = array();
    $widget_utils['lqdsep-utils-w-100'] = array();
    $widget_utils['lqdsep-utils-m-0'] = array();
    $widget_utils['lqdsep-utils-mt-0'] = array();
    $widget_utils['lqdsep-utils-mb-0'] = array();
    $widget_utils['lqdsep-utils-pos-rel'] = array();
    $widget_utils['lqdsep-utils-pos-abs'] = array(
      'conditions' =>
        $element->get_settings('show_button') === 'yes'
    );
    $widget_utils['lqdsep-utils-pos-tr'] = array(
      'conditions' =>
        $element->get_settings('show_button') === 'yes'
    );
    $widget_utils['lqdsep-utils-overlay'] = array();
    $widget_utils['lqdsep-utils-zindex-2'] = array();
    $widget_utils['lqdsep-utils-zindex-3'] = array();
    $widget_utils['lqdsep-utils-reset-ul'] = array();
    $widget_utils['lqdsep-utils-inline-ul'] = array();
    $widget_utils['lqdsep-utils-text-center'] = array();
    $widget_utils['lqdsep-utils-overflow-hidden'] = array();
    $widget_utils['lqdsep-utils-pointer-events-none'] = array();

};