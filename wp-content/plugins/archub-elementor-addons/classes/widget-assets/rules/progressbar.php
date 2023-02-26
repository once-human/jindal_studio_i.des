<?php
 if ( $element_name === 'ld_progressbar' ) {

    $widget_utils['lqdsep-utils-flex-d'] = array(
      'conditions' =>
        ! empty( $element->get_settings('label') ) &&
        $element->get_settings('hide_percentage') !== 'yes' &&
        (
          'yes' !== $element->get_settings('hide_percentage') &&
          ! empty( $element->get_settings('percentage')['size'] )
        )
    );
    $widget_utils['lqdsep-utils-flex-column'] = array(
      'conditions' =>
        $element->get_settings('label_position') === 'lqd-progressbar-values-inline'
    );
    $widget_utils['lqdsep-utils-flex-align-items-center'] = array(
      'conditions' =>
        ! empty( $element->get_settings('label') ) &&
        $element->get_settings('hide_percentage') !== 'yes' &&
        (
          'yes' !== $element->get_settings('hide_percentage') &&
          ! empty( $element->get_settings('percentage')['size'] )
        )
    );
    $widget_utils['lqdsep-utils-flex-justify-content-center'] = array(
      'conditions' =>
        ! empty( $element->get_settings('label') ) &&
        (
          'yes' !== $element->get_settings('hide_percentage') &&
          ! empty( $element->get_settings('percentage')['size'] )
        )
    );
    $widget_utils['lqdsep-utils-flex-justify-content-between'] = array(
      'conditions' =>
        ! empty( $element->get_settings('label') ) &&
        (
          'yes' !== $element->get_settings('hide_percentage') &&
          ! empty( $element->get_settings('percentage')['size'] )
        )
    );
    $widget_utils['lqdsep-utils-flex-grow-1'] = array();
    $widget_utils['lqdsep-utils-w-100'] = array();
    $widget_utils['lqdsep-utils-h-100'] = array();
    $widget_utils['lqdsep-utils-pos-rel'] = array();
    $widget_utils['lqdsep-utils-pos-abs'] = array();
    $widget_utils['lqdsep-utils-pos-tl'] = array();
    $widget_utils['lqdsep-utils-lqd-overlay'] = array(
      'conditions' =>
        $element->get_settings('label_position') === 'lqd-progressbar-values-inline' ||
        $element->get_settings('label_position') === 'lqd-progressbar-values-inside'
    );
    $widget_utils['lqdsep-utils-zindex-3'] = array();
    $widget_utils['lqdsep-utils-overflow-hidden'] = array();
    $widget_utils['lqdsep-utils-text-ws-nowrap'] = array(
      'conditions' =>
        ! empty( $element->get_settings('label') )
    );

};