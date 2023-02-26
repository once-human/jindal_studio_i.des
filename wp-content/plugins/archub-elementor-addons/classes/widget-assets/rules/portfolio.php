<?php
// Portfolio utils
if ( $element_name === 'ld_portfolio' ) {

    $element_template = $element->get_settings('style');

    $widget_utils['lqdsep-utils-flex-d'] = array();
    $widget_utils['lqdsep-utils-flex-inline-d'] = array(
        'conditions' =>
            $element->get_settings( 'show_filter' ) === 'yes' &&
            $element_template === 'style04'
    );
    $widget_utils['lqdsep-utils-block-d'] = array(
        'conditions' =>
            $element->get_settings( 'pagination' ) === 'ajax'
    );
    $widget_utils['lqdsep-utils-block-inline-d'] = array(
        'conditions' =>
            $element->get_settings( 'pagination' ) === 'ajax'
    );
    $widget_utils['lqdsep-utils-flex-wrap'] = array(
        'conditions' =>
            $element_template === 'style01' ||
            $element_template === 'style04'
    );
    $widget_utils['lqdsep-utils-flex-grow-1'] = array(
        'conditions' =>
            $element->get_settings( 'show_filter' ) === 'yes' &&
            $element_template !== 'style04'
    );
    $widget_utils['lqdsep-utils-flex-align-items-start'] = array(
        'conditions' =>
            $element_template === 'style04'
    );
    $widget_utils['lqdsep-utils-flex-align-items-center'] = array();
    $widget_utils['lqdsep-utils-flex-align-items-end'] = array(
        'conditions' =>
            $element_template === 'style05'
    );
    $widget_utils['lqdsep-utils-flex-justify-content-center'] = array(
        'conditions' =>
            $element_template === 'style02' ||
            $element_template === 'style03' ||
            $element_template === 'style06'
    );
    $widget_utils['lqdsep-utils-flex-justify-content-between'] = array(
        'conditions' =>
            $element_template === 'style01'
    );
    $widget_utils['lqdsep-utils-flex-justify-content-end'] = array(
        'conditions' =>
            $element_template === 'style04' ||
            $element_template === 'style05'
    );
    $widget_utils['lqdsep-utils-w-100'] = array();
    $widget_utils['lqdsep-utils-h-100'] = array(
        'conditions' =>
            $element_template === 'style05' ||
            $element->get_settings('enable_parallax_img') === 'yes'
    );
    $widget_utils['lqdsep-utils-h-vh-100'] = array(
        'conditions' =>
            $element_template === 'style05'
    );
    $widget_utils['lqdsep-utils-p-3'] = array(
        'conditions' =>
            $element_template === 'style06'
    );
    $widget_utils['lqdsep-utils-p-4'] = array(
        'conditions' =>
            $element_template === 'style01' ||
            $element_template === 'style04'
    );
    $widget_utils['lqdsep-utils-pt-4'] = array(
        'conditions' =>
            $element_template === 'style06'
    );
    $widget_utils['lqdsep-utils-ps-3'] = array(
        'conditions' =>
            $element_template === 'style05'
    );
    $widget_utils['lqdsep-utils-ps-5'] = array(
        'conditions' =>
            $element_template === 'style05'
    );
    $widget_utils['lqdsep-utils-pe-5'] = array(
        'conditions' =>
            $element_template === 'style05'
    );
    $widget_utils['lqdsep-utils-mt-0'] = array();
    $widget_utils['lqdsep-utils-mt-1'] = array(
        'conditions' =>
            $element->get_settings( 'pagination' ) === 'ajax'
    );
    $widget_utils['lqdsep-utils-mt-2'] = array(
        'conditions' =>
            $element->get_settings( 'show_filter' ) === 'yes' &&
            $element_template === 'style04'
    );
    $widget_utils['lqdsep-utils-mb-0'] = array(
        'conditions' =>
            $element_template === 'style01' ||
            $element_template === 'style04'
    );
    $widget_utils['lqdsep-utils-mb-1'] = array(
        'conditions' =>
            $element_template === 'style02' ||
            $element_template === 'style03'
    );
    $widget_utils['lqdsep-utils-mb-3'] = array(
        'conditions' =>
            $element_template === 'style02' ||
            $element_template === 'style06'
    );
    $widget_utils['lqdsep-utils-mb-5'] = array(
        'conditions' =>
            $element_template === 'style03' ||
            $element_template === 'style05'
    );
    $widget_utils['lqdsep-utils-border-radius-4'] = array(
        'conditions' =>
            $element_template === 'style01'
    );
    $widget_utils['lqdsep-utils-border-radius-6'] = array(
        'conditions' =>
            $element_template !== 'style01'
    );
    $widget_utils['lqdsep-utils-border-radius-10'] = array(
        'conditions' =>
            $element_template !== 'style06'
    );
    $widget_utils['lqdsep-utils-pos-rel'] = array();
    $widget_utils['lqdsep-utils-pos-abs'] = array(
        'conditions' =>
            $element->get_settings( 'pagination' ) === 'ajax'
    );
    $widget_utils['lqdsep-utils-overlay'] = array();
    $widget_utils['lqdsep-utils-transform-perspective'] = array(
        'conditions' =>
            $element->get_settings( 'show_filter' ) === 'yes' &&
            $element_template === 'style04'
    );
    $widget_utils['lqdsep-utils-text-uppercase'] = array(
        'conditions' =>
            $element->get_settings( 'show_filter' ) === 'yes' &&
            $element_template === 'style04'
    );
    $widget_utils['lqdsep-utils-text-ltrsp-1'] = array(
        'conditions' =>
            $element->get_settings( 'show_filter' ) === 'yes' &&
            $element_template === 'style04'
    );
    $widget_utils['lqdsep-utils-text-vertical'] = array(
        'conditions' =>
            $element_template === 'style04' ||
            $element_template === 'style05'
    );
    $widget_utils['lqdsep-utils-text-center'] = array(
        'conditions' =>
            $element->get_settings( 'pagination' ) === 'ajax'
    );
    $widget_utils['lqdsep-utils-text-ws-nowrap'] = array(
        'conditions' =>
            $element->get_settings( 'pagination' ) === 'ajax'
    );
    $widget_utils['lqdsep-utils-overflow-hidden'] = array();
    $widget_utils['lqdsep-utils-objfit-cover'] = array(
        'conditions' =>
            $element_template === 'style03' ||
            $element_template === 'style04' ||
            $element_template === 'style05' ||
            $element->get_settings('enable_parallax_img') === 'yes'
    );
    $widget_utils['lqdsep-utils-objfit-center'] = array(
        'conditions' =>
            $element_template === 'style03' ||
            $element_template === 'style04' ||
            $element_template === 'style05' ||
            $element->get_settings('enable_parallax_img') === 'yes'
    );

}