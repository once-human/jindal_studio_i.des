<?php
 if (
   $element_name === 'section' ||
   $element_name === 'container'
  ) {

    $section_scroll_enabled = $element->get_settings('lqd_section_scroll') === 'yes';
    $animated_borders_enabled = $element->get_settings('enable_animated_borders') === 'yes';

    $widget_utils['lqdsep-utils-flex-align-items-center'] = array(
      'conditions' => $section_scroll_enabled
    );
    $widget_utils['lqdsep-utils-flex-justify-content-center'] = array(
      'conditions' => $section_scroll_enabled
    );
    $widget_utils['lqdsep-utils-w-100'] = array(
      'conditions' => $animated_borders_enabled
    );
    $widget_utils['lqdsep-utils-h-100'] = array(
      'conditions' => $animated_borders_enabled
    );
    $widget_utils['lqdsep-utils-border-radius-circle'] = array(
      'conditions' => $section_scroll_enabled
    );
    $widget_utils['lqdsep-utils-pos-rel'] = array(
      'conditions' => $section_scroll_enabled
    );
    $widget_utils['lqdsep-utils-pos-abs'] = array(
      'conditions' => $section_scroll_enabled
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
      'conditions' =>
        $section_scroll_enabled ||
        $animated_borders_enabled
    );
    $widget_utils['lqdsep-utils-zindex-5'] = array(
      'conditions' => $section_scroll_enabled
    );
    $widget_utils['lqdsep-utils-text-center'] = array(
      'conditions' => $section_scroll_enabled
    );
    $widget_utils['lqdsep-utils-will-change-transform'] = array(
      'conditions' => $section_scroll_enabled
    );
    $widget_utils['lqdsep-utils-pointer-events-none'] = array(
      'conditions' => $animated_borders_enabled
    );

};