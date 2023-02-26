<?php
 if ( $element_name === 'ld_counter' ) {

    $widget_utils['lqdsep-utils-flex-inline-d'] = array(
     'conditions' =>
        ! empty( $element->get_settings('count') )
    );

    $widget_utils['lqdsep-utils-block-d'] = array(
     'conditions' =>
        ! empty( $element->get_settings('count') )
    );

    $widget_utils['lqdsep-utils-w-100'] = array();
    $widget_utils['lqdsep-utils-h-100'] = array();

    $widget_utils['lqdsep-utils-p-4'] = array(
      'conditions' =>
      $element->get_settings('template') === 'solid'
    );

    $widget_utils['lqdsep-utils-border-radius-6'] = array(
      'conditions' =>
        $element->get_settings('template') === 'solid'
    );

    $widget_utils['lqdsep-utils-pos-rel'] = array();

    $widget_utils['lqdsep-utils-pos-abs'] = array(
      'conditions' =>
        $element->get_settings('add_icon')
    );

    $widget_utils['lqdsep-utils-overlay'] = array(
      'conditions' =>
        ! empty( $element->get_settings('count') )
    );

    $widget_utils['lqdsep-utils-overflow-hidden'] = array(
      'conditions' =>
        ! empty( $element->get_settings('count') )
    );
    
    $widget_utils['lqdsep-utils-reset-ul'] = array(
      'conditions' =>
        ! empty( $element->get_settings('count') )
    );
    
};