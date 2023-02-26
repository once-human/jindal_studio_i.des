<?php
 if ( $element_name === 'column' ) {

    $animated_borders_enabled = $element->get_settings('enable_animated_borders') === 'yes';

    $widget_utils['lqdsep-utils-w-100'] = array(
      'conditions' => $animated_borders_enabled
    );
    $widget_utils['lqdsep-utils-h-100'] = array(
      'conditions' => $animated_borders_enabled
    );
    $widget_utils['lqdsep-utils-pos-tl'] = array(
      'conditions' => $animated_borders_enabled
    );
    $widget_utils['lqdsep-utils-pos-tr'] = array(
      'conditions' => $animated_borders_enabled
    );
    $widget_utils['lqdsep-utils-pos-bl'] = array(
      'conditions' => $animated_borders_enabled
    );
    $widget_utils['lqdsep-utils-overlay'] = array(
      'conditions' => $animated_borders_enabled
    );
    $widget_utils['lqdsep-utils-pointer-events-none'] = array(
      'conditions' => $animated_borders_enabled
    );

};