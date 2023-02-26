<?php
if ( $element_name === 'ld_single_portfolio_cover' ) {
    $widget_utils['lqdsep-utils-flex-d'] = array();
    $widget_utils['lqdsep-utils-flex-align-items-center'] = array();
    $widget_utils['lqdsep-utils-flex-align-items-end'] = array();
    $widget_utils['lqdsep-utils-flex-justify-content-center'] = array();
    $widget_utils['lqdsep-utils-p-6'] = array();
    $widget_utils['lqdsep-utils-mt-0'] = array();
    $widget_utils['lqdsep-utils-mb-0'] = array();
    $widget_utils['lqdsep-utils-pos-rel'] = array();
    $widget_utils['lqdsep-utils-overlay'] = array();
    $widget_utils['lqdsep-utils-text-center'] = array();
}

if ( $element_name === 'ld_single_portfolio_meta' ) {
    $widget_utils['lqdsep-utils-flex-d'] = array();
    $widget_utils['lqdsep-utils-flex-wrap'] = array();
    $widget_utils['lqdsep-utils-flex-align-items-center'] = array(); // for share links with [ld_sc_share_links]
    $widget_utils['lqdsep-utils-flex-justify-content-between'] = array();
    $widget_utils['lqdsep-utils-mt-0'] = array();
    $widget_utils['lqdsep-utils-mb-0'] = array();
    $widget_utils['lqdsep-utils-me-3'] = array(); // for share links with [ld_sc_share_links]
    $widget_utils['lqdsep-utils-reset-ul'] = array(); // for share links with [ld_sc_share_links]
}

if ( $element_name === 'ld_single_portfolio_nav' ) {
    $widget_utils['lqdsep-utils-flex-d'] = array();
    $widget_utils['lqdsep-utils-flex-row-reverse'] = array();
    $widget_utils['lqdsep-utils-flex-column'] = array(
        'conditions' =>
            $element->get_settings('template') !== 'classic-minimal'
    );
    $widget_utils['lqdsep-utils-flex-align-items-center'] = array();
    $widget_utils['lqdsep-utils-flex-justify-content-center'] = array(
        'conditions' =>
            $element->get_settings('template') === 'no-classic' ||
            $element->get_settings('template') === 'no-classic-outline'
    );
    $widget_utils['lqdsep-utils-flex-justify-content-between'] = array(
        'conditions' =>
            $element->get_settings('template') === 'classic' ||
            $element->get_settings('template') === 'classic-minimal'
    );
    $widget_utils['lqdsep-utils-ms-3'] = array(
        'conditions' =>
            $element->get_settings('template') === 'classic'
    );
    $widget_utils['lqdsep-utils-me-3'] = array(
        'conditions' =>
            $element->get_settings('template') === 'classic'
    );
    $widget_utils['lqdsep-utils-text-end'] = array(
        'conditions' =>
            $element->get_settings('template') === 'classic'
    );
}

if ( $element_name === 'ld_single_portfolio_related' ) {
    $widget_utils['lqdsep-utils-flex-d'] = array();
    $widget_utils['lqdsep-utils-flex-column'] = array();
    $widget_utils['lqdsep-utils-flex-align-items-center'] = array();
    $widget_utils['lqdsep-utils-flex-justify-content-center'] = array();
    $widget_utils['lqdsep-utils-w-100'] = array();
    $widget_utils['lqdsep-utils-h-100'] = array();
    $widget_utils['lqdsep-utils-mt-0'] = array();
    $widget_utils['lqdsep-utils-mt-2'] = array();
    $widget_utils['lqdsep-utils-mb-1'] = array();
    $widget_utils['lqdsep-utils-mb-2'] = array();
    $widget_utils['lqdsep-utils-mb-3'] = array();
    $widget_utils['lqdsep-utils-border-radius-6'] = array();
    $widget_utils['lqdsep-utils-pos-rel'] = array();
    $widget_utils['lqdsep-utils-pos-abs'] = array();
    $widget_utils['lqdsep-utils-zindex-1'] = array();
    $widget_utils['lqdsep-utils-zindex-2'] = array();
    $widget_utils['lqdsep-utils-pos-abs'] = array();
    $widget_utils['lqdsep-utils-overlay'] = array();
    $widget_utils['lqdsep-utils-overflow-hidden'] = array();
    $widget_utils['lqdsep-utils-reset-ul'] = array();
    $widget_utils['lqdsep-utils-inline-ul'] = array();
}