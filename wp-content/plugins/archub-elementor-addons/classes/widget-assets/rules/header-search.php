<?php
if ( $element_name === 'ld_header_search' ) {
  
  $widget_utils['lqdsep-utils-flex-d'] = array();
  $widget_utils['lqdsep-utils-flex-inline-d'] = array();
  $widget_utils['lqdsep-utils-block-inline-d'] = array();
  $widget_utils['lqdsep-utils-block-d'] = array();
  $widget_utils['lqdsep-utils-flex-column'] = array(
    'conditions' =>
      $element->get_settings('style') === 'frame' ||
      $element->get_settings('style') === 'slide-top'
  );
  $widget_utils['lqdsep-utils-flex-align-items-center'] = array();
  $widget_utils['lqdsep-utils-flex-justify-content-center'] = array();
  $widget_utils['lqdsep-utils-w-100'] = array(
    'conditions' =>
      $element->get_settings('style') === 'default' ||
      $element->get_settings('style') === 'slide-top' ||
      $element->get_settings('style') === 'zoom-out'
  );
  $widget_utils['lqdsep-utils-w-50'] = array(
    'conditions' =>
      $element->get_settings('style') === 'zoom-out'
  );
  $widget_utils['lqdsep-utils-h-100'] = array(
    'conditions' =>
      $element->get_settings('style') === 'slide-top' ||
      $element->get_settings('style') === 'zoom-out'
  );
  $widget_utils['lqdsep-utils-mt-0'] = array(
    'conditions' => $element->get_settings('style') === 'frame'
  );
  $widget_utils['lqdsep-utils-mb-0'] = array(
    'conditions' => $element->get_settings('style') === 'frame'
  );
  $widget_utils['lqdsep-utils-mx-auto'] = array(
    'conditions' => 
      $element->get_settings('style') === 'frame' ||
      $element->get_settings('style') === 'slide-top' ||
      $element->get_settings('style') === 'zoom-out'
  );
  $widget_utils['lqdsep-utils-pos-rel'] = array(
    'conditions' => $element->get_settings('style') === 'default'
  );
  $widget_utils['lqdsep-utils-pos-abs'] = array();
  $widget_utils['lqdsep-utils-pos-fix'] = array(
    'conditions' => $element->get_settings('style') !== 'default'
  );
  $widget_utils['lqdsep-utils-pos-tl'] = array(
    'conditions' =>
      $element->get_settings('style') === 'frame' ||
      $element->get_settings('style') === 'zoom-out'
  );
  $widget_utils['lqdsep-utils-border-radius-circle'] = array();
  $widget_utils['lqdsep-utils-text-weight-bold'] = array(
    'conditions' =>
      $element->get_settings('style') === 'frame' ||
      $element->get_settings('style') === 'zoom-out'
  );
  $widget_utils['lqdsep-utils-text-start'] = array(
    'conditions' =>
      $element->get_settings('style') === 'frame' ||
      $element->get_settings('style') === 'zoom-out'
  );
  $widget_utils['lqdsep-utils-text-center'] = array(
    'conditions' =>
      $element->get_settings('style') === 'frame' ||
      $element->get_settings('style') === 'zoom-out'
  );
  $widget_utils['lqdsep-utils-text-end'] = array(
    'conditions' =>
      $element->get_settings('style') === 'frame' ||
      $element->get_settings('style') === 'zoom-out'
  );
  $widget_utils['lqdsep-utils-overflow-hidden'] = array(
    'conditions' => $element->get_settings('style') === 'slide-top'
  );
  $widget_utils['lqdsep-utils-pointer-events-none'] = array(
    'conditions' => $element->get_settings('style') === 'frame'
  );
  $widget_utils['lqdsep-utils-backface-hidden'] = array(
    'conditions' => $element->get_settings('style') === 'slide-top'
  );
  
};