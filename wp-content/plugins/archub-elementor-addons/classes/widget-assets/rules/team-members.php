<?php
 // Testimonial utils
 if ( $element_name === 'ld_team_member' ) {

    $element_template = $element->get_settings('template');

    $widget_utils['lqdsep-utils-flex-d'] = array(
        'conditions' =>
            $element_template !== 'lqd-tm-style-1'
    );
    $widget_utils['lqdsep-utils-flex-column'] = array(
        'conditions' =>
            $element_template === 'lqd-tm-style-3' ||
            $element_template === 'lqd-tm-style-4'
    );
    $widget_utils['lqdsep-utils-flex-align-items-center'] = array(
        'conditions' =>
            $element_template === 'lqd-tm-style-2' ||
            $element_template === 'lqd-tm-style-3' ||
            $element_template === 'lqd-tm-style-4' ||
            $element_template === 'lqd-tm-style-5'
    );
    $widget_utils['lqdsep-utils-flex-align-items-end'] = array(
        'conditions' =>
            $element_template === 'lqd-tm-style-4' ||
            $element_template === 'lqd-tm-style-5'
    );
    $widget_utils['lqdsep-utils-flex-justify-content-center'] = array(
        'conditions' =>
            $element_template === 'lqd-tm-style-2'
    );
    $widget_utils['lqdsep-utils-flex-justify-content-end'] = array(
        'conditions' =>
            $element_template === 'lqd-tm-style-2' ||
            $element_template === 'lqd-tm-style-3' ||
            $element_template === 'lqd-tm-style-5'
    );
    $widget_utils['lqdsep-utils-flex-justify-content-between'] = array(
        'conditions' =>
            $element_template === 'lqd-tm-style-4'
    );
    $widget_utils['lqdsep-utils-w-100'] = array();
    $widget_utils['lqdsep-utils-p-4'] = array(
        'conditions' =>
            $element_template === 'lqd-tm-style-2'
    );
    $widget_utils['lqdsep-utils-p-5'] = array(
        'conditions' =>
            $element_template === 'lqd-tm-style-5'
    );
    $widget_utils['lqdsep-utils-p-6'] = array(
        'conditions' =>
            $element_template === 'lqd-tm-style-3'
    );
    $widget_utils['lqdsep-utils-pt-4'] = array(
        'conditions' =>
            $element_template === 'lqd-tm-style-1'
    );
    $widget_utils['lqdsep-utils-pt-5'] = array(
        'conditions' =>
            $element_template === 'lqd-tm-style-4'
    );
    $widget_utils['lqdsep-utils-pb-4'] = array(
        'conditions' =>
            $element_template === 'lqd-tm-style-1'
    );
    $widget_utils['lqdsep-utils-pb-5'] = array(
        'conditions' =>
            $element_template === 'lqd-tm-style-4'
    );
    $widget_utils['lqdsep-utils-ps-6'] = array(
        'conditions' =>
            $element_template === 'lqd-tm-style-1' ||
            $element_template === 'lqd-tm-style-4'
    );
    $widget_utils['lqdsep-utils-pe-6'] = array(
        'conditions' =>
            $element_template === 'lqd-tm-style-1' ||
            $element_template === 'lqd-tm-style-4' 
    );
    $widget_utils['lqdsep-utils-mt-0'] = array();
    $widget_utils['lqdsep-utils-mb-0'] = array();
    $widget_utils['lqdsep-utils-mb-2'] = array();
    $widget_utils['lqdsep-utils-ms-auto'] = array(
        'conditions' =>
            $element_template === 'lqd-tm-style-4' || 
            $element_template === 'lqd-tm-style-5' 
    );
    $widget_utils['lqdsep-utils-pos-rel'] = array();
    $widget_utils['lqdsep-utils-zindex-3'] = array(
        'conditions' =>
            $element->get_settings( 'list' ) &&
            (
                $element_template === 'lqd-tm-style-2' ||
                $element_template === 'lqd-tm-style-3'
            )
    );
    $widget_utils['lqdsep-utils-overlay'] = array();
    $widget_utils['lqdsep-utils-border-radius-4'] = array(
        'conditions' =>
            $element_template === 'lqd-tm-style-2' ||
            $element_template === 'lqd-tm-style-3' ||
            $element_template === 'lqd-tm-style-4'
    );
    $widget_utils['lqdsep-utils-overflow-hidden'] = array(
        'conditions' =>
            $element_template !== 'lqd-tm-style-1'
    );
    $widget_utils['lqdsep-utils-text-weight-normal'] = array(
        'conditions' =>
            $element_template === 'lqd-tm-style-1'
    );
    $widget_utils['lqdsep-utils-text-center'] = array(
        'conditions' =>
            $element_template === 'lqd-tm-style-1'
    );
    $widget_utils['lqdsep-utils-text-vertical'] = array(
        'conditions' =>
            $element_template === 'lqd-tm-style-5'
    );

}