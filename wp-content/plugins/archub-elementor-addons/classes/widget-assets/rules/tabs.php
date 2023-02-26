<?php
// Tabs utils
if ( $element_name === 'ld_tabs' ) {

    $element_template = $element->get_settings('style');
    $is_reverse = $element->get_settings('reverse_direction') === 'yes';

    $widget_utils['lqdsep-utils-block-d'] = array();
    $widget_utils['lqdsep-utils-flex-d'] = array();
    $widget_utils['lqdsep-utils-flex-inline-d'] = array(
        'conditions' =>
            $element_template === 'style04'
    );
    $widget_utils['lqdsep-utils-flex-wrap'] = array();
    $widget_utils['lqdsep-utils-flex-row-reverse'] = array(
        'conditions' =>
            $is_reverse &&
            (
                $element_template === 'style03' ||
                $element_template === 'style04' ||
                $element_template === 'style05'
            )
    );
    $widget_utils['lqdsep-utils-flex-column-reverse'] = array(
        'conditions' =>
            $is_reverse &&
            (
                $element_template === 'style06' ||
                $element_template === 'style07' ||
                $element_template === 'style08'
            )
    );
    $widget_utils['lqdsep-utils-flex-column'] = array(
        'conditions' =>
            (
                ! $is_reverse &&
                (
                    $element_template === 'style06' ||
                    $element_template === 'style07' ||
                    $element_template === 'style08'
                )
            ) ||
            $element_template === 'style03' ||
            $element_template === 'style04' ||
            $element_template === 'style05'
    );
    $widget_utils['lqdsep-utils-flex-justify-content-start'] = array(
        'conditions' =>
            $element->get_settings('nav_alignment') === 'justify-content-start' ||
            $element->get_settings('nav_alignment_style9') === 'justify-content-start'
    );
    $widget_utils['lqdsep-utils-flex-justify-content-center'] = array(
        'conditions' =>
            (
                $element_template === 'style01' ||
                $element_template === 'style02' ||
                $element_template === 'style03' ||
                $element_template === 'style04' ||
                $element_template === 'style08'
            ) ||
            (
                $element->get_settings('nav_alignment') === 'justify-content-center' ||
                $element->get_settings('nav_alignment_style9') === 'justify-content-center'
            )
    );
    $widget_utils['lqdsep-utils-flex-justify-content-end'] = array(
        'conditions' =>
            $element->get_settings('nav_alignment') === 'justify-content-end' ||
            $element->get_settings('nav_alignment_style9') === 'justify-content-end'
    );
    $widget_utils['lqdsep-utils-flex-justify-content-between'] = array(
        'conditions' =>
            (
                $element_template === 'style02'
            ) ||
            (
                $element->get_settings('nav_alignment') === 'justify-content-between' &&
                (
                    $element_template === 'style01' ||
                    $element_template === 'style06' ||
                    $element_template === 'style07'
                )
            )
    );
    $widget_utils['lqdsep-utils-pos-rel'] = array();
    $widget_utils['lqdsep-utils-pt-1'] = array(
        'conditions' =>
            $element_template === 'style05'
    );
    $widget_utils['lqdsep-utils-pt-3'] = array(
        'conditions' =>
            $element_template === 'style04'
    );
    $widget_utils['lqdsep-utils-pb-1'] = array(
        'conditions' =>
            $element_template === 'style05'
    );
    $widget_utils['lqdsep-utils-pb-3'] = array(
        'conditions' =>
            $element_template === 'style04'
    );
    $widget_utils['lqdsep-utils-ps-5'] = array(
        'conditions' =>
            ! $is_reverse &&
            (
                $element_template === 'style03' ||
                $element_template === 'style04'
            )
    );
    $widget_utils['lqdsep-utils-ps-6'] = array(
        'conditions' =>
            ! $is_reverse &&
            $element_template === 'style05'
    );
    $widget_utils['lqdsep-utils-pe-5'] = array(
        'conditions' =>
            $is_reverse &&
            (
                $element_template === 'style03' ||
                $element_template === 'style04'
            )
    );
    $widget_utils['lqdsep-utils-pe-6'] = array(
        'conditions' =>
            $is_reverse &&
            $element_template === 'style05'
    );
    $widget_utils['lqdsep-utils-mt-0'] = array(
        'conditions' =>
            $element_template === 'style01' ||
            $element_template === 'style02' ||
            $element_template === 'style03'
    );
    $widget_utils['lqdsep-utils-mt-5'] = array(
        'conditions' =>
            $is_reverse &&
            $element_template === 'style06'
    );
    $widget_utils['lqdsep-utils-mt-6'] = array(
        'conditions' =>
            $is_reverse &&
            $element_template === 'style07'
    );
    $widget_utils['lqdsep-utils-mb-0'] = array(
        'conditions' =>
            $element_template === 'style01' ||
            $element_template === 'style02' ||
            $element_template === 'style03'
    );
    $widget_utils['lqdsep-utils-mb-2'] = array(
        'conditions' =>
            $element_template === 'style05'
    );
    $widget_utils['lqdsep-utils-mb-3'] = array(
        'conditions' =>
            (
                ! $is_reverse && $element_template === 'style08'
            ) ||
            (
                $element_template === 'style03' ||
                $element_template === 'style07'
            )
    );
    $widget_utils['lqdsep-utils-mb-4'] = array(
        'conditions' =>
            $element_template === 'style02'
    );
    $widget_utils['lqdsep-utils-mb-5'] = array(
        'conditions' =>
            ! $is_reverse &&
            (
                $element_template === 'style01' ||
                $element_template === 'style02' ||
                $element_template === 'style06'
            )
    );
    $widget_utils['lqdsep-utils-mb-6'] = array(
        'conditions' =>
            (
                ! $is_reverse &&
                $element_template === 'style07'
            ) ||
            $element_template === 'style08'
    );
    $widget_utils['lqdsep-utils-me-5'] = array(
        'conditions' =>
            $element_template === 'style01' ||
            $element_template === 'style02' ||
            $element_template === 'style03' ||
            $element_template === 'style04'
    );
    $widget_utils['lqdsep-utils-border-radius-circle'] = array(
        'conditions' =>
            $element_template === 'style01' ||
            $element_template === 'style02' ||
            $element_template === 'style03' ||
            $element_template === 'style04' ||
            $element_template === 'style08'
    );
    $widget_utils['lqdsep-utils-border-radius-4'] = array(
        'conditions' =>
            $element_template === 'style04'
    );
    $widget_utils['lqdsep-utils-reset-ul'] = array();

}