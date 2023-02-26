<?php
 // Fancy box utils
 if ( $element_name === 'hub_fancy_heading' ) {

    $widget_utils['lqdsep-utils-block-inline-d'] = array();
    $widget_utils['lqdsep-utils-pos-rel'] = array();
    $widget_utils['lqdsep-utils-text-ws-nowrap'] = array(
        'conditions' =>
            $element->get_settings('whitespace') === 'ws-nowrap'
    );

};