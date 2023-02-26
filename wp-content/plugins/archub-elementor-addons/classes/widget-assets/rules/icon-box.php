<?php
if ( $element_name === 'ld_icon_box' ) {
  $widget_utils['lqdsep-utils-flex-d'] = array();
  $widget_utils['lqdsep-utils-flex-inline-d'] = array();
  $widget_utils['lqdsep-utils-block-inline-d'] = array(
    'conditions' =>
      (
        $element->get_settings('show_label') === 'yes' &&
        ! empty( $element->get_settings('label') )
      ) ||
      $element->get_settings('heading_icon_onhover') === 'yes'
  );
  $widget_utils['lqdsep-utils-flex-column'] = array(
    'conditions' =>
        $element->get_settings('position') === 'iconbox-default'
  );
  $widget_utils['lqdsep-utils-flex-row-reverse'] = array(
    'conditions' =>
      $element->get_settings('alignment') === 'right' &&
      (
        $element->get_settings('position') !== 'iconbox-default'
      )
  );
  $widget_utils['lqdsep-utils-flex-wrap'] = array(
    'conditions' =>
        $element->get_settings('position') === 'iconbox-inline'
  );
  $widget_utils['lqdsep-utils-flex-grow-1'] = array();
  $widget_utils['lqdsep-utils-flex-align-items-center'] = array(
    'conditions' =>
        $element->get_settings('position') === 'iconbox-inline' ||
        (
          $element->get_settings('position') === 'iconbox-side' &&
          $element->get_settings('items_alignment') === 'align-items-center'
        )
  );
  $widget_utils['lqdsep-utils-flex-justify-content-center'] = array();
  $widget_utils['lqdsep-utils-flex-justify-content-start'] = array(
    'conditions' =>
        $element->get_settings('position') !== 'iconbox-default'
  );
  $widget_utils['lqdsep-utils-flex-justify-content-end'] = array(
    'conditions' =>
        $element->get_settings('position') === 'iconbox-inline' &&
        $element->get_settings('alignment') === 'right'
  );
  $widget_utils['lqdsep-utils-border-radius-circle'] = array(
    'conditions' =>
        $element->get_settings('i_shape') === 'circle' ||
        (
          $element->get_settings('show_label') === 'yes' &&
          ! empty( $element->get_settings('label') )
        )
  );
  $widget_utils['lqdsep-utils-pos-rel'] = array();
  $widget_utils['lqdsep-utils-pos-abs'] = array(
    'conditions' =>
      $element->get_settings('show_label') === 'yes' &&
      ! empty( $element->get_settings('label') )
  );
  $widget_utils['lqdsep-utils-overlay'] = array(
    'conditions' =>
      isset( $element->get_settings('link')['url'] ) &&
      ! empty( $element->get_settings('link')['url'] )
  );
  $widget_utils['lqdsep-utils-zindex-1'] = array(
    'conditions' =>
      $element->get_settings('i_shape') !== ''
  );
  $widget_utils['lqdsep-utils-zindex-2'] = array(
    'conditions' =>
      $element->get_settings('position') === 'iconbox-side' ||
      (
        isset( $element->get_settings('link')['url'] ) &&
        ! empty( $element->get_settings('link')['url'] )
      )
  );
  $widget_utils['lqdsep-utils-text-uppercase'] = array(
    'conditions' =>
        $element->get_settings('show_label') === 'yes' &&
        ! empty( $element->get_settings('label') )
  );
  $widget_utils['lqdsep-utils-text-ltrsp-1'] = array(
    'conditions' =>
        $element->get_settings('show_label') === 'yes' &&
        ! empty( $element->get_settings('label') )
  );
  $widget_utils['lqdsep-utils-text-weight-bold'] = array(
    'conditions' =>
        $element->get_settings('show_label') === 'yes' &&
        ! empty( $element->get_settings('label') )
  );
}