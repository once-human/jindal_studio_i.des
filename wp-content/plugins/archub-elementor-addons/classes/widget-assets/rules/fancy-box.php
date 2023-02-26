<?php
// Fancy box utils
if ( $element_name === 'ld_content_box' ) {

  $element_template = $element->get_settings('template');

  $width_options = array(
      's08' => 'ct_width',
  );
  $widths = array();
  for ( $i = 50; $i <= 100; $i += 10 ) {
      $key = 'w-' . $i;
      $widths[$key] = $key;
  };

  $height_options = array(
      's01' => 'box_height',
      's01a' => 'box_height_a',
      's01b' => 'box_height_b',
      's06' => 'box_height_6',
  );
  $heights = array();
  for ( $i = 50; $i <= 125; $i += 10 ) {
      $key = 'h-pt-' . $i;
      $heights[$key] = $key;
      $i === 100 && $i += 15;
  };

  foreach ( $width_options as $style => $width_opt ) {
      foreach ( $widths as $width ) {
          if (
              $element->get_settings( 'template' ) === $style &&
              $element->get_settings( $width_opt ) === $width
          ) {
              $widget_utils['lqdsep-utils-' . $width] = array();
          }
      }
  }
  foreach ( $height_options as $style => $height_opt ) {
      foreach ( $heights as $height ) {
          if (
              $element->get_settings( 'template' ) === $style &&
              $element->get_settings( $height_opt ) === $height
          ) {
              $widget_utils['lqdsep-utils-' . $height] = array();
          }
      }
  }
  
  $widget_utils['lqdsep-utils-flex-d'] = array(
    'conditions' => 
        $element_template === 's01a' ||
        $element_template === 's01b' ||
        $element_template === 's02' ||
        $element_template === 's05' ||
        $element_template === 's06' ||
        $element_template === 's07' ||
        $element_template === 's08' ||
        $element_template === 's09' ||
        $element_template === 's11'
  );
  $widget_utils['lqdsep-utils-flex-wrap'] = array(
    'conditions' => 
        $element_template === 's01a' ||
        $element_template === 's02' ||
        $element_template === 's05' ||
        $element_template === 's06' ||
        $element_template === 's07' ||
        $element_template === 's08'
  );
  $widget_utils['lqdsep-utils-flex-column'] = array(
    'conditions' => 
        $element_template === 's01b' ||
        $element_template === 's03' ||
        $element_template === 's06' ||
        $element_template === 's09'
  );
  $widget_utils['lqdsep-utils-flex-align-items-center'] = array(
    'conditions' => 
        $element_template === 's01a' ||
        $element_template === 's02' ||
        $element_template === 's05' ||
        $element_template === 's06' ||
        $element_template === 's08' ||
        $element_template === 's10' ||
        $element_template === 's11'
  );
  $widget_utils['lqdsep-utils-flex-align-items-end'] = array(
    'conditions' => 
        $element_template === 's01' ||
        $element_template === 's01a' ||
        $element_template === 's01b' ||
        $element_template === 's02' ||
        $element_template === 's06'
  );
  $widget_utils['lqdsep-utils-flex-justify-content-between'] = array(
    'conditions' => 
        (
          ! empty( $element->get_settings('label') ) &&
          $element_template === 's01b'
        ) ||
        $element_template === 's08'
  );
  $widget_utils['lqdsep-utils-flex-justify-content-center'] = array(
    'conditions' =>
        $element_template === 's11'
  );
  $widget_utils['lqdsep-utils-flex-justify-content-end'] = array(
    'conditions' => 
        (
          empty( $element->get_settings('label') ) &&
          $element_template === 's01b'
        ) ||
        $element_template === 's06' ||
        $element_template === 's08'
  );
  $widget_utils['lqdsep-utils-w-100'] = array(
    'conditions' => 
        $element_template !== 's01' &&
        $element_template !== 's10' &&
        $element_template !== 's11'
  );
  $widget_utils['lqdsep-utils-w-80'] = array(
    'conditions' => 
        $element_template === 's01a' ||
        $element_template === 's08'
  );
  $widget_utils['lqdsep-utils-w-70'] = array(
    'conditions' => 
        $element_template === 's05' ||
        $element_template === 's08'
  );
  $widget_utils['lqdsep-utils-w-60'] = array(
    'conditions' => 
        $element_template === 's02' ||
        $element_template === 's07'
  );
  $widget_utils['lqdsep-utils-w-40'] = array(
    'conditions' => 
        $element_template === 's02' ||
        $element_template === 's07'
  );
  $widget_utils['lqdsep-utils-w-20'] = array(
    'conditions' => 
        $element_template === 's01a' ||
        $element_template === 's05' ||
        $element_template === 's08'
  );
  $widget_utils['lqdsep-utils-h-100'] = array(
    'conditions' =>
        $element_template === 's01' ||
        $element_template === 's01a' ||
        $element_template === 's01b' ||
        $element_template === 's02' ||
        $element_template === 's03' ||
        $element_template === 's04'
  );
  $widget_utils['lqdsep-utils-h-pt-50'] = array(
    'conditions' =>
        $element_template === 's01' ||
        $element_template === 's01a' ||
        $element_template === 's01b' ||
        $element_template === 's07'
  );
  $widget_utils['lqdsep-utils-p-3'] = array(
    'conditions' =>
        $element_template === 's11'
  );
  $widget_utils['lqdsep-utils-p-4'] = array(
    'conditions' =>
        $element_template === 's01b' ||
        $element_template === 's06'
  );
  $widget_utils['lqdsep-utils-p-5'] = array(
    'conditions' =>
        $element_template === 's04'
  );
  $widget_utils['lqdsep-utils-pt-4'] = array(
    'conditions' =>
        $element_template === 's02' ||
        $element_template === 's03' ||
        $element_template === 's08' ||
        $element_template === 's09'
  );
  $widget_utils['lqdsep-utils-pt-5'] = array(
    'conditions' =>
        $element_template === 's01a'
  );
  $widget_utils['lqdsep-utils-pt-6'] = array(
    'conditions' =>
        $element_template === 's05' ||
        $element_template === 's07'
  );
  $widget_utils['lqdsep-utils-pb-4'] = array(
    'conditions' =>
        $element_template === 's02' ||
        $element_template === 's03' ||
        $element_template === 's08' ||
        $element_template === 's09'
  );
  $widget_utils['lqdsep-utils-pb-5'] = array(
    'conditions' =>
        $element_template === 's01a'
  );
  $widget_utils['lqdsep-utils-pb-6'] = array(
    'conditions' =>
        $element_template === 's05' ||
        $element_template === 's07'
  );
  $widget_utils['lqdsep-utils-ps-2'] = array(
    'conditions' =>
        $element_template === 's01a'
  );
  $widget_utils['lqdsep-utils-ps-3'] = array(
    'conditions' =>
        $element_template === 's02' ||
        $element_template === 's09'
  );
  $widget_utils['lqdsep-utils-ps-4'] = array(
    'conditions' =>
        $element_template === 's05'
  );
  $widget_utils['lqdsep-utils-ps-5'] = array(
    'conditions' =>
        $element_template === 's07' ||
        $element_template === 's08'
  );
  $widget_utils['lqdsep-utils-pe-2'] = array(
    'conditions' =>
        $element_template === 's01a' ||
        $element_template === 's11'
  );
  $widget_utils['lqdsep-utils-pe-3'] = array(
    'conditions' =>
        $element_template === 's02' ||
        $element_template === 's09'
  );
  $widget_utils['lqdsep-utils-pe-4'] = array(
    'conditions' =>
        $element_template === 's05'
  );
  $widget_utils['lqdsep-utils-pe-5'] = array(
    'conditions' =>
        $element_template === 's07' ||
        $element_template === 's08'
  );
  $widget_utils['lqdsep-utils-m-0'] = array(
    'conditions' =>
        $element_template === 's11'
  );
  $widget_utils['lqdsep-utils-mt-0'] = array();
  $widget_utils['lqdsep-utils-mb-0'] = array(
    'conditions' =>
        $element_template !== 's05' &&
        $element_template !== 's06' &&
        $element_template !== 's07' &&
        $element_template !== 's09'
  );
  $widget_utils['lqdsep-utils-mb-2'] = array(
    'conditions' =>
        $element_template === 's01b' ||
        $element_template === 's03' ||
        $element_template === 's10'
  );
  $widget_utils['lqdsep-utils-mb-3'] = array(
    'conditions' =>
        $element_template === 's01' ||
        $element_template === 's01b' ||
        $element_template === 's04' ||
        $element_template === 's05' ||
        $element_template === 's06' ||
        $element_template === 's07' ||
        $element_template === 's10'
  );
  $widget_utils['lqdsep-utils-mb-4'] = array(
    'conditions' =>
        $element_template === 's01'
  );
  $widget_utils['lqdsep-utils-mb-5'] = array(
    'conditions' =>
        $element_template === 's06'
  );
  $widget_utils['lqdsep-utils-ms-auto'] = array(
    'conditions' =>
        $element_template === 's05'
  );
  $widget_utils['lqdsep-utils-border-radius-4'] = array(
    'conditions' =>
        $element_template === 's01' ||
        $element_template === 's01a' ||
        $element_template === 's01b' ||
        $element_template === 's06' ||
        $element_template === 's07' ||
        $element_template === 's08' ||
        $element_template === 's11'
  );
  $widget_utils['lqdsep-utils-border-radius-4'] = array(
    'conditions' =>
        $element_template === 's01' ||
        $element_template === 's01a' ||
        $element_template === 's01b' ||
        $element_template === 's06' ||
        $element_template === 's07' ||
        $element_template === 's08'
  );
  $widget_utils['lqdsep-utils-border-radius-circle'] = array(
    'conditions' =>
        $element_template === 's05' ||
        $element_template === 's11'
  );
  $widget_utils['lqdsep-utils-overlay'] = array();
  $widget_utils['lqdsep-utils-pos-rel'] = array();
  $widget_utils['lqdsep-utils-pos-abs'] = array(
    'conditions' =>
        $element_template === 's11'
  );
  $widget_utils['lqdsep-utils-pos-mid'] = array(
    'conditions' =>
        $element_template === 's11'
  );
  $widget_utils['lqdsep-utils-overflow-hidden'] = array(
    'conditions' =>
        $element_template !== 's10'
  );
  $widget_utils['lqdsep-utils-objfit-cover'] = array(
    'conditions' =>
        $element_template === 's01' ||
        $element_template === 's01a' ||
        $element_template === 's01b' ||
        $element_template === 's02' ||
        $element_template === 's05' ||
        $element_template === 's06' ||
        $element_template === 's07'
  );
  $widget_utils['lqdsep-utils-objfit-center'] = array(
    'conditions' =>
        $element_template === 's01a' ||
        $element_template === 's01b' ||
        $element_template === 's02' ||
        $element_template === 's05' ||
        $element_template === 's06' ||
        $element_template === 's07'
  );
  $widget_utils['lqdsep-utils-text-weight-normal'] = array(
    'conditions' =>
        $element_template === 's04'
  );
  $widget_utils['lqdsep-utils-text-weight-semibold'] = array(
    'conditions' =>
        $element_template === 's07'
  );
  $widget_utils['lqdsep-utils-text-weight-bold'] = array(
    'conditions' =>
        $element_template === 's06'
  );
  $widget_utils['lqdsep-utils-text-center'] = array(
    'conditions' =>
        $element_template === 's01a' ||
        $element_template === 's04'
  );
  $widget_utils['lqdsep-utils-backface-hidden'] = array(
    'conditions' =>
        $element_template === 's06'
  );
  $widget_utils['lqdsep-utils-transform-style-3d'] = array(
    'conditions' =>
        $element_template === 's06' ||
        $element_template === 's01b'
  );
  $widget_utils['lqdsep-utils-transform-perspective'] = array(
    'conditions' =>
        $element_template === 's01b'
  );
  $widget_utils['lqdsep-utils-will-change-transform'] = array(
    'conditions' =>
        $element_template === 's06'
  );
    
};