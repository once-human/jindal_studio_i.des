<?php

 if ( $element_name === 'ld_header_cart' ) {

    $widget_utils['lqdsep-utils-flex-d'] = array();
    $widget_utils['lqdsep-utils-flex-inline-d'] = array();
    $widget_utils['lqdsep-utils-block-d'] = array();
    $widget_utils['lqdsep-utils-flex-wrap'] = array();
    $widget_utils['lqdsep-utils-flex-column'] = array();
    $widget_utils['lqdsep-utils-flex-align-items-start'] = array();
    $widget_utils['lqdsep-utils-flex-align-items-center'] = array();
    $widget_utils['lqdsep-utils-flex-justify-content-center'] = array();
    $widget_utils['lqdsep-utils-flex-justify-content-between'] = array();
    $widget_utils['lqdsep-utils-flex-grow-1'] = array();
    $widget_utils['lqdsep-utils-w-100'] = array();
    $widget_utils['lqdsep-utils-h-vh-100'] = array(
      'conditions' => $element->get_settings( 'enable_offcanvas' ) === 'yes'
    );
    $widget_utils['lqdsep-utils-border-radius-circle'] = array();
    $widget_utils['lqdsep-utils-mt-0'] = array();
    $widget_utils['lqdsep-utils-mb-0'] = array();
    $widget_utils['lqdsep-utils-ms-1'] = array();
    $widget_utils['lqdsep-utils-pos-rel'] = array();
    $widget_utils['lqdsep-utils-pos-abs'] = array();
    $widget_utils['lqdsep-utils-pos-fix'] = array(
      'conditions' => $element->get_settings( 'enable_offcanvas' ) === 'yes'
    );
    $widget_utils['lqdsep-utils-text-weight-bold'] = array();
    $widget_utils['lqdsep-utils-text-uppercase'] = array();
    $widget_utils['lqdsep-utils-text-ltrsp-2'] = array();
    $widget_utils['lqdsep-utils-text-center'] = array();
    $widget_utils['lqdsep-utils-will-change-transform'] = array(
      'conditions' => $element->get_settings( 'enable_offcanvas' ) === 'yes'
    );
    
};