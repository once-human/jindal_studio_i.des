<?php
if ( $element_name === 'ld_header_image' ) {

   $widget_utils['lqdsep-utils-flex-d'] = array();
   $widget_utils['lqdsep-utils-flex-inline-d'] = array(
      'conditions' =>
         $element->get_settings('hover_image') !== null &&
         ! empty( $element->get_settings('hover_image')['url'] )
   );
   $widget_utils['lqdsep-utils-flex-align-items-center'] = array(
      'conditions' =>
         $element->get_settings('hover_image') !== null &&
         ! empty( $element->get_settings('hover_image')['url'] )
   );
   $widget_utils['lqdsep-utils-flex-justify-content-center'] = array(
      'conditions' =>
         $element->get_settings('hover_image') !== null &&
         ! empty( $element->get_settings('hover_image')['url'] )
   );
   $widget_utils['lqdsep-utils-flex-grow-1'] = array(
      'conditions' =>
         $element->get_settings('hover_image') !== null &&
         ! empty( $element->get_settings('hover_image')['url'] )
   );
   $widget_utils['lqdsep-utils-p-0'] = array();
   $widget_utils['lqdsep-utils-pos-rel'] = array();
   $widget_utils['lqdsep-utils-pos-abs'] = array();
   $widget_utils['lqdsep-utils-overlay'] = array(
      'conditions' =>
         $element->get_settings('hover_image') !== null &&
         ! empty( $element->get_settings('hover_image')['url'] )
   );

};