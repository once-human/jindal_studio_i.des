<?php
if ( $element_name === 'ld_header_menu' ) {

  $widget_utils['lqdsep-utils-flex-d'] = array();
  $widget_utils['lqdsep-utils-flex-inline-d'] = array();
  $widget_utils['lqdsep-utils-hide-if-empty'] = array();
  $widget_utils['lqdsep-utils-p-0'] = array();
  $widget_utils['lqdsep-utils-reset-ul'] = array();
  $widget_utils['lqdsep-utils-inline-ul'] = array(
    'conditions' =>
      $element->get_settings('menu_items_direction') === 'lqd-menu-items-inline'
  );

};