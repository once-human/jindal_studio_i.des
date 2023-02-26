<?php

if (
  $element_name === 'ld_carousel' ||
  $element_name === 'ld_testimonial_carousel' ||
  $element_name === 'ld_woo_products'
) {
  
  $widget_utils['lqdsep-utils-flex-d'] = array();
  $widget_utils['lqdsep-utils-flex-inline-d'] = array(
    'conditions' =>
      $element->get_settings( 'marquee' ) !== 'yes' &&
      (
          $element->get_settings( 'pagenationdots' ) === 'yes' &&
          $element->get_settings( 'dots_type' ) === 'numbers'
      ) ||
      (
          $element->get_settings( 'navslidernumberstoarrows' ) === 'yes'
      )
  );
  $widget_utils['lqdsep-utils-block-inline-d'] = array(
    'conditions' =>
      $element->get_settings( 'marquee' ) !== 'yes' &&
      (
          $element->get_settings( 'pagenationdots' ) === 'yes' &&
          $element->get_settings( 'dots_type' ) === 'numbers'
      ) ||
      (
          $element->get_settings( 'navslidernumberstoarrows' ) === 'yes'
      )
  );
  $widget_utils['lqdsep-utils-flex-column'] = array();
  $widget_utils['lqdsep-utils-flex-align-items-start'] = array(
    'conditions' =>
      (
        $element->get_settings('marquee') !== 'yes' &&
        $element->get_settings('randomveroffset') === '' &&
        (
          $element->get_settings('equalheightcells') !== 'yes'  &&
          $element->get_settings('middlealigncontent') !== 'yes'
        )
      )
  );
  $widget_utils['lqdsep-utils-flex-align-items-center'] = array(
    'conditions' =>
      (
        $element->get_settings('marquee') === 'yes' &&
        $element->get_settings('randomveroffset') === '' &&
        (
          $element->get_settings('equalheightcells') === 'yes'  &&
          $element->get_settings('middlealigncontent') === 'yes'
        )
      ) ||
      (
        $element->get_settings( 'marquee' ) !== 'yes' &&
        (
            $element->get_settings( 'pagenationdots' ) === 'yes' &&
            $element->get_settings( 'dots_type' ) === 'numbers'
        ) ||
        (
            $element->get_settings( 'navslidernumberstoarrows' ) === 'yes'
        )
      )
  );
  $widget_utils['lqdsep-utils-flex-justify-content-center'] = array();
  $widget_utils['lqdsep-utils-flex-justify-content-end'] = array(
    'conditions' =>
      liquid_helper()->get_theme_option( 'disable_carousel_on_mobile' ) === 'on' &&
      $element->get_settings('mobile_align_dots') === 'carousel-dots-mobile-right'
  );
  $widget_utils['lqdsep-utils-w-100'] = array();
  $widget_utils['lqdsep-utils-h-100'] = array();
  $widget_utils['lqdsep-utils-pos-rel'] = array();
  $widget_utils['lqdsep-utils-pos-abs'] = array();
  $widget_utils['lqdsep-utils-overlay'] = array(
    'conditions' =>
      $element->get_settings( 'marquee' ) !== 'yes' &&
      (
          $element->get_settings( 'pagenationdots' ) === 'yes' &&
          $element->get_settings( 'dots_type' ) === 'numbers'
      ) ||
      (
          $element->get_settings( 'navslidernumberstoarrows' ) === 'yes'
      )
  );
  $widget_utils['lqdsep-utils-overflow-hidden'] = array();
  $widget_utils['lqdsep-utils-text-center'] = array(
    'conditions' =>
      $element->get_settings( 'marquee' ) !== 'yes' &&
      (
          $element->get_settings( 'pagenationdots' ) === 'yes' &&
          $element->get_settings( 'dots_type' ) === 'numbers'
      ) ||
      (
          $element->get_settings( 'navslidernumberstoarrows' ) === 'yes'
      )
  );
  $widget_utils['lqdsep-utils-text-ws-nowrap'] = array(
    'conditions' =>
      $element->get_settings( 'marquee' ) !== 'yes' &&
      (
          $element->get_settings( 'pagenationdots' ) === 'yes' &&
          $element->get_settings( 'dots_type' ) === 'numbers'
      ) ||
      (
          $element->get_settings( 'navslidernumberstoarrows' ) === 'yes'
      )
  );
  $widget_utils['lqdsep-utils-fade-sides'] = array(
    'conditions' =>
      $element->get_settings( 'fadesides' ) === 'lqd-fade-sides'
  );
  
};