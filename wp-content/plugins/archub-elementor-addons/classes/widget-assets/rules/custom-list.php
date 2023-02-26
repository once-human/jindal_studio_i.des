<?php

 if ( $element_name === 'ld_list' ) {

    $widget_utils['lqdsep-utils-flex-d'] = array();
    $widget_utils['lqdsep-utils-flex-align-items-center'] = array();
    $widget_utils['lqdsep-utils-reset-ul'] = array();
    $widget_utils['lqdsep-utils-inline-ul'] = array(
      'conditions' =>
        $element->get_settings('inline') === 'inline-nav'
    );

};