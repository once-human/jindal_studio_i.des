<?php
 $fancy_box = array(
    'lqdsep-fancybox-base' => 'elements/fancy-box/fancy-box-base.css',
    'lqdsep-fancybox-content-overlay' => 'elements/fancy-box/fancy-box-content-overlay.css',
    'lqdsep-fancybox-image' => 'elements/fancy-box/fancy-box-image.css',
    'lqdsep-fancybox-img-zoom-onhover' => 'elements/fancy-box/fancy-box-img-zoom-onhover.css',
    'lqdsep-fancybox-overlay-hover' => 'elements/fancy-box/fancy-box-overlay-hover.css',
);
for ( $i = 1; $i <= 11; $i++ ) { 
    $fancy_box['lqdsep-fancybox-style-' . $i] = 'elements/fancy-box/fancy-box-style-' . $i . '.css';
    if ( $i === 1 ) {
        $fancy_box['lqdsep-fancybox-style-' . $i . '-1'] = 'elements/fancy-box/fancy-box-style-' . $i . '-1.css';
        $fancy_box['lqdsep-fancybox-style-' . $i . '-2'] = 'elements/fancy-box/fancy-box-style-' . $i . '-2.css';
        $fancy_box['lqdsep-fancybox-style-' . $i . '-3'] = 'elements/fancy-box/fancy-box-style-' . $i . '-3.css';
        $fancy_box['lqdsep-fancybox-style-' . $i . '-base'] = 'elements/fancy-box/fancy-box-style-' . $i . '-base.css';
    }
};