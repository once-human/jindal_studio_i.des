<?php

if (
  $element_name === 'ld_button'
) {
  
  $widget_utils['lqdsep-utils-flex-inline-d'] = array();
  $widget_utils['lqdsep-utils-block-inline-d'] = array(
    'conditions' =>
    $element->get_settings( 'style' ) === 'btn-solid' &&
    $element->get_settings( 'extended_lines' ) === 'yes'
  );
  $widget_utils['lqdsep-utils-flex-align-items-center'] = array();
  $widget_utils['lqdsep-utils-flex-justify-content-center'] = array();
  $widget_utils['lqdsep-utils-pos-rel'] = array();
  $widget_utils['lqdsep-utils-zindex-3'] = array();
  $widget_utils['lqdsep-utils-text-ws-nowrap'] = array();
  $widget_utils['lqdsep-utils-pointer-events-none'] = array(
    'conditions' =>
      $element->get_settings( 'style' ) === 'btn-solid' &&
      $element->get_settings( 'extended_lines' ) === 'yes'
  );
}