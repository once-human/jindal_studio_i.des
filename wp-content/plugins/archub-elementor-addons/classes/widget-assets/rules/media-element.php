<?php
 if ( $element_name === 'ld_media_element' ) {

    $widget_utils['lqdsep-utils-flex-d'] = array();
    $widget_utils['lqdsep-utils-flex-inline-d'] = array(
        'conditions' =>
            $this->get_repeater_item_param($element, 'items', 'add_icon') === 'yes'
    );
    $widget_utils['lqdsep-utils-flex-wrap'] = array();
    $widget_utils['lqdsep-utils-flex-column'] = array();
    $widget_utils['lqdsep-utils-flex-align-items-center'] = array();
    $widget_utils['lqdsep-utils-flex-justify-content-center'] = array(
        'conditions' =>
            $this->get_repeater_item_param($element, 'items', 'vertical_alignment') === 'justify-content-center' ||
            (
                $this->get_repeater_item_param($element, 'items', 'add_icon') === 'yes' &&
                (
                    $this->get_repeater_item_param($element, 'items', 'icon_type') === 'video' ||
                    $this->get_repeater_item_param($element, 'items', 'icon_type') === 'video2'
                )
            )
    );
    $widget_utils['lqdsep-utils-flex-justify-content-end'] = array(
        'conditions' =>
            $this->get_repeater_item_param($element, 'items', 'vertical_alignment') === 'justify-content-end'
    );
    $widget_utils['lqdsep-utils-w-100'] = array();
    $widget_utils['lqdsep-utils-m-0'] = array();
    $widget_utils['lqdsep-utils-border-radius-circle'] = array(
        'conditions' =>
            $this->get_repeater_item_param($element, 'items', 'add_icon') === 'yes'
    );
    $widget_utils['lqdsep-utils-pos-rel'] = array();
    $widget_utils['lqdsep-utils-zindex-2'] = array();
    $widget_utils['lqdsep-utils-overlay'] = array();
    $widget_utils['lqdsep-utils-bg-cover'] = array();
    $widget_utils['lqdsep-utils-overflow-hidden'] = array();
    $widget_utils['lqdsep-utils-objfit-cover'] = array();
    $widget_utils['lqdsep-utils-objfit-center'] = array();
    $widget_utils['lqdsep-utils-text-center'] = array();

};