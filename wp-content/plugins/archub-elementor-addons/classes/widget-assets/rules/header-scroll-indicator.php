<?php
if ( $element_name === 'ld_header_scroll_indicator' ) {

  $widget_utils['lqdsep-utils-flex-d'] = array();
  $widget_utils['lqdsep-utils-block-inline-d'] = array();
  $widget_utils['lqdsep-utils-flex-align-items-center'] = array();
  $widget_utils['lqdsep-utils-flex-grow-1'] = array();
  $widget_utils['lqdsep-utils-border-radius-2'] = array(
    'conditions' =>
      $element->get_settings('indicator_type') === 'line'
  );
  $widget_utils['lqdsep-utils-border-radius-4'] = array(
    'conditions' =>
      $element->get_settings('indicator_type') === 'dot'
  );
  $widget_utils['lqdsep-utils-pos-rel'] = array();
  $widget_utils['lqdsep-utils-pos-abs'] = array(
    'conditions' =>
      $element->get_settings('indicator_type') === 'dot'
  );
  $widget_utils['lqdsep-utils-overlay'] = array(
    'conditions' =>
      $element->get_settings('indicator_type') === 'line'
  );
  $widget_utils['lqdsep-utils-text-ws-nowrap'] = array();

};