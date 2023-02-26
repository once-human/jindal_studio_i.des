<?php 


$element_template = $this->get_repeater_item_param($element, $repeater_name, 'template');

// Utils
$widget_utils['lqdsep-utils-flex-d'] = array();
$widget_utils['lqdsep-utils-flex-wrap'] = array();
$widget_utils['lqdsep-utils-flex-column'] = array(
    'conditions' =>
    $element_template === 'style06' ||
    $element_template === 'style18' ||
    $element_template === 'style19'
);
$widget_utils['lqdsep-utils-flex-column-reverse'] = array(
    'conditions' =>
    $element_template === 'style14'
);
$widget_utils['lqdsep-utils-flex-align-items-center'] = array();
$widget_utils['lqdsep-utils-flex-justify-content-center'] = array(
    'conditions' =>
    $element_template === 'style06' ||
    $element_template === 'style18'
);
$widget_utils['lqdsep-utils-flex-justify-content-between'] = array(
    'conditions' =>
    $element_template !== 'style14' &&
    $element_template !== 'style15'
);
$widget_utils['lqdsep-utils-star-rating-base'] = array(
    'conditions' =>
    $element_template === 'style18' ||
    $element_template === 'style19'
);
$widget_utils['lqdsep-utils-star-rating-shaped'] = array(
    'conditions' =>
    $element_template === 'style18' ||
    $element_template === 'style19'
);
$widget_utils['lqdsep-utils-star-rating-outline'] = array(
    'conditions' =>
    $element_template === 'style18'
);
$widget_utils['lqdsep-utils-star-rating-fill'] = array(
    'conditions' =>
    $element_template === 'style19'
);
$widget_utils['lqdsep-utils-w-80'] = array(
    'conditions' =>
    $element_template === 'style06'
);
$widget_utils['lqdsep-utils-p-6'] = array(
    'conditions' =>
    $element_template === 'style15'
);
$widget_utils['lqdsep-utils-pt-3'] = array(
    'conditions' =>
    $element_template === 'style06'
);
$widget_utils['lqdsep-utils-pt-4'] = array(
    'conditions' =>
    $element_template === 'style18'
);
$widget_utils['lqdsep-utils-pt-5'] = array(
    'conditions' =>
    $element_template === 'style07'
);
$widget_utils['lqdsep-utils-pt-6'] = array(
    'conditions' =>
    $element_template === 'style06' ||
    $element_template === 'style18'
);
$widget_utils['lqdsep-utils-pb-2'] = array(
    'conditions' =>
    $element_template === 'style06'
);
$widget_utils['lqdsep-utils-pb-3'] = array(
    'conditions' =>
    $element_template === 'style06'
);
$widget_utils['lqdsep-utils-pb-4'] = array(
    'conditions' =>
    $element_template === 'style18'
);
$widget_utils['lqdsep-utils-pb-6'] = array(
    'conditions' =>
    $element_template === 'style06'
);
$widget_utils['lqdsep-utils-ps-3'] = array(
    'conditions' =>
    $element_template === 'style18'
);
$widget_utils['lqdsep-utils-ps-4'] = array(
    'conditions' =>
    $element_template !== 'style15' &&
    $element_template !== 'style19'
);
$widget_utils['lqdsep-utils-pe-3'] = array(
    'conditions' =>
    $element_template === 'style18'
);
$widget_utils['lqdsep-utils-m-0'] = array(
    'conditions' =>
    $element_template === 'style19'
);
$widget_utils['lqdsep-utils-mt-4'] = array(
    'conditions' =>
    $element_template === 'style18'
);
$widget_utils['lqdsep-utils-mb-2'] = array(
    'conditions' =>
    $element_template === 'style19'
);
$widget_utils['lqdsep-utils-mb-4'] = array(
    'conditions' =>
    $element_template === 'style15' ||
    $element_template === 'style18' ||
    $element_template === 'style19'
);
$widget_utils['lqdsep-utils-mb-5'] = array(
    'conditions' =>
    $element_template === 'style14'
);
$widget_utils['lqdsep-utils-mb-6'] = array(
    'conditions' =>
    $element_template === 'style06'
);
$widget_utils['lqdsep-utils-mx-auto'] = array(
    'conditions' =>
    $element_template === 'style06'
);
$widget_utils['lqdsep-utils-pos-rel'] = array();
$widget_utils['lqdsep-utils-text-start'] = array(
    'conditions' =>
    $element_template === 'style18'
);
$widget_utils['lqdsep-utils-text-center'] = array(
    'conditions' =>
    $element_template === 'style06' ||
    $element_template === 'style18'
);
$widget_utils['lqdsep-utils-text-uppercase'] = array(
    'conditions' =>
    $element_template === 'style18'
);
$widget_utils['lqdsep-utils-text-weight-medium'] = array(
    'conditions' =>
    $element_template === 'style14' ||
    $element_template === 'style15'
);
$widget_utils['lqdsep-utils-text-weight-bold'] = array(
    'conditions' =>
    $element_template === 'style18'
);
$widget_utils['lqdsep-utils-text-ltrsp-1'] = array(
    'conditions' =>
    $element_template === 'style18'
);
$widget_utils['lqdsep-utils-overflow-hidden'] = array(
    'conditions' =>
    $element_template !== 'style15' &&
    $element_template !== 'style19'
);

$widget_options = array(
    'lqdsep-testimonial-base' => array(),
    'lqdsep-testimonial-avatar-48' => array(
        'conditions' =>
            $element_template === 'style06'
    ),
    'lqdsep-testimonial-avatar-60' => array(
        'conditions' =>
            $element_template === 'style19'
    ),
    'lqdsep-testimonial-avatar-68' => array(
        'conditions' =>
            $element_template === 'style18'
    ),
    'lqdsep-testimonial-avatar-90' => array(
        'conditions' =>
            $element_template === 'style14'
    ),
    'lqdsep-testimonial-bubble' => array(
        'conditions' =>
            $element_template === 'style15'
    ),
    'lqdsep-testimonial-card' => array(
        'conditions' =>
            $element_template !== 'style14' &&
            $element_template !== 'style15' &&
            $element_template !== 'style18'
    ),
    'lqdsep-testimonial-details-inline' => array(
        'conditions' =>
            $element_template === 'style19'
    ),
    'lqdsep-testimonial-details-same' => array(
        'conditions' =>
            $element_template === 'style19'
    ),
    'lqdsep-testimonial-details-sm' => array(
        'conditions' =>
            $element_template === 'style06' ||
            $element_template === 'style18'
    ),
    'lqdsep-testimonial-details-lg' => array(
        'conditions' =>
            $element_template === 'style15'
    ),
    'lqdsep-testimonial-details-xl' => array(
        'conditions' =>
            $element_template === 'style14'
    ),
    'lqdsep-testimonial-quote-18' => array(
        'conditions' =>
            $element_template === 'style18' ||
            $element_template === 'style19'
    ),
    'lqdsep-testimonial-quote-21' => array(
        'conditions' =>
            $element_template === 'style06'
    ),
    'lqdsep-testimonial-quote-22' => array(
        'conditions' =>
            $element_template === 'style14'
    ),
    'lqdsep-testimonial-quote-25' => array(
        'conditions' =>
            $element_template === 'style15'
    ),
    'lqdsep-testimonial-shadow-sm' => array(
        'conditions' =>
            $element_template === 'style19'
    ),
    'lqdsep-testimonial-shadow-sm2' => array(
        'conditions' =>
            $element_template === 'style18'
    ),
    'lqdsep-testimonial-star-rating' => array(
        'conditions' =>
            $element_template === 'style18' ||
            $element_template === 'style19'
    ),
    'lqdsep-testimonial-style-18' => array(
        'conditions' =>
            $element_template === 'style18'
    ),
    'lqdsep-testimonial-style-19' => array(
        'conditions' =>
            $element_template === 'style19'
    ),
);