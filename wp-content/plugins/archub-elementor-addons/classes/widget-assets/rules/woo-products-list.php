<?php
 if ( $element_name === 'ld_woo_products_list' ) {

  $widget_utils['lqdsep-utils-flex-d'] = array();
  $widget_utils['lqdsep-utils-flex-align-items-center'] = array();
  $widget_utils['lqdsep-utils-flex-justify-content-between'] = array();
  $widget_utils['lqdsep-utils-block-d'] = array(
    'conditions' =>
      $element->get_settings( 'pagination' ) === 'ajax'
  );
  $widget_utils['lqdsep-utils-block-inline-d'] = array(
    'conditions' =>
      $element->get_settings( 'pagination' ) === 'ajax'
  );
  $widget_utils['lqdsep-utils-ps-2'] = array();
  $widget_utils['lqdsep-utils-mt-0'] = array();
  $widget_utils['lqdsep-utils-mt-1'] = array(
    'conditions' =>
      $element->get_settings( 'pagination' ) === 'ajax'
);
  $widget_utils['lqdsep-utils-mb-0'] = array();
  $widget_utils['lqdsep-utils-pos-rel'] = array();
  $widget_utils['lqdsep-utils-pos-abs'] = array(
    'conditions' =>
      $element->get_settings( 'pagination' ) === 'ajax'
  );
  $widget_utils['lqdsep-utils-overlay'] = array();
  $widget_utils['lqdsep-utils-text-center'] = array(
    'conditions' =>
      $element->get_settings( 'pagination' ) === 'ajax'
  );
  $widget_utils['lqdsep-utils-text-ws-nowrap'] = array(
      'conditions' =>
        $element->get_settings( 'pagination' ) === 'ajax'
  );

};