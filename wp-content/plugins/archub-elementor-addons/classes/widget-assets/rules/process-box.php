<?php 
// Process box utils
if ( $element_name === 'ld_process_box' ) {

    $element_template = $element->get_settings('style');

    $widget_utils['lqdsep-utils-flex-d'] = array();
    $widget_utils['lqdsep-utils-flex-column'] = array(
        'conditions' =>
            $element_template === 'style02' ||
            $element_template === 'style04'
    );
    $widget_utils['lqdsep-utils-flex-align-items-center'] = array(
        'conditions' =>
            $element_template !== 'style01' &&
            $element_template !== 'style02' &&
            $element_template !== 'style05'
    );
    $widget_utils['lqdsep-utils-flex-justify-content-center'] = array(
        'conditions' =>
            $element_template === 'style03' ||
            $element_template === 'style04'
    );
    $widget_utils['lqdsep-utils-flex-grow-1'] = array();
    $widget_utils['lqdsep-utils-mt-0'] = array(
        'conditions' =>
            $element_template === 'style01' ||
            $element_template === 'style03' ||
            $element_template === 'style04' ||
            $element_template === 'style05'
    );
    $widget_utils['lqdsep-utils-mb-0'] = array(
        'conditions' =>
            $element_template === 'style03'
    );
    $widget_utils['lqdsep-utils-mb-2'] = array(
        'conditions' =>
            $element_template === 'style01'
    );
    $widget_utils['lqdsep-utils-mb-3'] = array(
        'conditions' =>
            $element_template === 'style04' ||
            $element_template === 'style05'
    );
    $widget_utils['lqdsep-utils-mb-4'] = array(
        'conditions' =>
            $element_template === 'style05'
    );
    $widget_utils['lqdsep-utils-mb-5'] = array(
        'conditions' =>
            $element_template === 'style01'
    );
    $widget_utils['lqdsep-utils-mx-auto'] = array(
        'conditions' =>
            $element_template === 'style01' ||
            $element_template === 'style05'
    );
    $widget_utils['lqdsep-utils-border-radius-circle'] = array();
    $widget_utils['lqdsep-utils-pos-rel'] = array();
    $widget_utils['lqdsep-utils-zindex-0'] = array(
        'conditions' =>
            $element_template === 'style01' ||
            $element_template === 'style02'
    );
    $widget_utils['lqdsep-utils-zindex-1'] = array();
    $widget_utils['lqdsep-utils-overlay'] = array(
        'conditions' =>
            $element_template === 'style01' ||
            $element_template === 'style02'
    );
    $widget_utils['lqdsep-utils-text-weight-medium'] = array(
        'conditions' =>
            $element_template === 'style01'
    );
    $widget_utils['lqdsep-utils-text-weight-bold'] = array(
        'conditions' =>
            $element_template === 'style01'
    );
    $widget_utils['lqdsep-utils-text-center'] = array(
        'conditions' =>
            $element_template === 'style01' ||
            $element_template === 'style05'
    );
}