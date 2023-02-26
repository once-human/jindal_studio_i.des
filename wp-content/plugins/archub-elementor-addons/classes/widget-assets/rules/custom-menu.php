<?php
 // Fancy box utils
 if ( $element_name === 'ld_custom_menu' ) {

  $widget_utils['lqdsep-utils-flex-d'] = array(
    'conditions' =>
      $element->get_settings('add_toggle') === 'yes' ||
      $element->get_settings('mobile_add_toggle') === 'yes' ||
      $element->get_settings('add_scroll_indicator') === 'yes'
  );
  $widget_utils['lqdsep-utils-flex-inline-d'] = array(
    // to load for link icons
    // 'conditions' =>
    //   $element->get_settings('add_toggle') === 'yes' ||
    //   $element->get_settings('mobile_add_toggle') === 'yes'
  );
  $widget_utils['lqdsep-utils-block-inline-d'] = array(
    'conditions' =>
      $element->get_settings('add_scroll_indicator') === 'yes'
  );
  $widget_utils['lqdsep-utils-hide-if-empty'] = array();
  $widget_utils['lqdsep-utils-flex-align-items-center'] = array(
    'conditions' =>
      $element->get_settings('add_toggle') === 'yes' ||
      $element->get_settings('mobile_add_toggle') === 'yes' ||
      $element->get_settings('add_scroll_indicator') === 'yes'
  );
  $widget_utils['lqdsep-utils-flex-grow-1'] = array(
    'conditions' =>
      $element->get_settings('add_scroll_indicator') === 'yes'
  );
  $widget_utils['lqdsep-utils-w-100'] = array(
    'conditions' =>
      $element->get_settings('add_toggle') === 'yes' ||
      $element->get_settings('mobile_add_toggle') === 'yes' ||
      $element->get_settings('add_scroll_indicator') === 'yes'
  );
  $widget_utils['lqdsep-utils-h-100'] = array(
    'conditions' =>
      $element->get_settings('add_scroll_indicator') === 'yes'
  );
  $widget_utils['lqdsep-utils-ms-auto'] = array(
    'conditions' =>
      $element->get_settings('add_toggle') === 'yes' ||
      $element->get_settings('mobile_add_toggle') === 'yes'
  );
  $widget_utils['lqdsep-utils-me-3'] = array(
    'conditions' =>
      $element->get_settings('add_toggle') === 'yes'
  );
  $widget_utils['lqdsep-utils-border-radius-4'] = array(
    'conditions' =>
      $element->get_settings('toggle_shape') === 'round'
  );
  $widget_utils['lqdsep-utils-border-radius-circle'] = array(
    'conditions' =>
      $element->get_settings('toggle_shape') === 'circle'
  );
  $widget_utils['lqdsep-utils-pos-rel'] = array();
  $widget_utils['lqdsep-utils-reset-ul'] = array();
  $widget_utils['lqdsep-utils-inline-ul'] = array(
    'conditions' =>
      $element->get_settings('inline') === 'yes' ||
      $element->get_settings('sticky') === 'yes'
  );
  $widget_utils['lqdsep-utils-overflow-hidden'] = array(
    'conditions' =>
      $element->get_settings('add_scroll_indicator') === 'yes'
  );
  $widget_utils['lqdsep-utils-text-ws-nowrap'] = array(
    'conditions' =>
      $element->get_settings('add_scroll_indicator') === 'yes'
  );

};