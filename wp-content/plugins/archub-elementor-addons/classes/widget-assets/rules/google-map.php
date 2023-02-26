<?php
 if ( $element_name === 'ld_google_map' ) {

    $widget_utils['lqdsep-utils-flex-d'] = array(
        'conditions' =>
            $element->get_settings('show_info_box') === 'yes'
    );
    $widget_utils['lqdsep-utils-flex-wrap'] = array(
        'conditions' =>
            $element->get_settings('show_info_box') === 'yes'
    );
    $widget_utils['lqdsep-utils-flex-grow-1'] = array(
        'conditions' =>
            $element->get_settings('show_info_box') === 'yes'
    );
    $widget_utils['lqdsep-utils-flex-align-items-center'] = array(
        'conditions' =>
            $element->get_settings('show_info_box') === 'yes'
    );
    $widget_utils['lqdsep-utils-h-100'] = array();
    $widget_utils['lqdsep-utils-pos-rel'] = array();
    $widget_utils['lqdsep-utils-pos-abs'] = array(
        'conditions' =>
            $element->get_settings('map_marker') === 'html'
    );
    $widget_utils['lqdsep-utils-border-radius-circle'] = array(
        'conditions' =>
            $element->get_settings('map_marker') === 'html'
    );
    $widget_utils['lqdsep-utils-overlay'] = array(
        'conditions' =>
            $element->get_settings('map_marker') === 'html'
    );

};