<?php
 $utils = array(
    'lqdsep-utils-flex-d' => 'utils/flex/d-flex.css',
    'lqdsep-utils-flex-inline-d' => 'utils/flex/d-inline-flex.css',
    'lqdsep-utils-block-d' => 'utils/d-block.css',
    'lqdsep-utils-block-inline-d' => 'utils/d-inline-block.css',
    'lqdsep-utils-none-d' => 'utils/d-none.css',
    'lqdsep-utils-hide-if-empty' => 'utils/hide-if-empty.css',
    'lqdsep-utils-flex-wrap' => 'utils/flex/flex-wrap.css',
    'lqdsep-utils-flex-row' => 'utils/flex/flex-row.css',
    'lqdsep-utils-flex-row-reverse' => 'utils/flex/flex-row-reverse.css',
    'lqdsep-utils-flex-column' => 'utils/flex/flex-column.css',
    'lqdsep-utils-flex-column-reverse' => 'utils/flex/flex-column-reverse.css',
    'lqdsep-utils-flex-align-items-center' => 'utils/flex/align-items-center.css',
    'lqdsep-utils-flex-align-items-end' => 'utils/flex/align-items-end.css',
    'lqdsep-utils-flex-align-items-start' => 'utils/flex/align-items-start.css',
    'lqdsep-utils-flex-justify-content-between' => 'utils/flex/justify-content-between.css',
    'lqdsep-utils-flex-justify-content-center' => 'utils/flex/justify-content-center.css',
    'lqdsep-utils-flex-justify-content-end' => 'utils/flex/justify-content-end.css',
    'lqdsep-utils-flex-justify-content-start' => 'utils/flex/justify-content-start.css',
    'lqdsep-utils-flex-grow-1' => 'utils/flex/flex-grow-1.css',
    'lqdsep-utils-flex-auto' => 'utils/flex/flex-auto.css',
    'lqdsep-utils-w-fullwidth' => 'utils/width/fullwidth.css',
    'lqdsep-utils-h-vh-100' => 'utils/height/h-vh/h-vh-100.css',
    'lqdsep-utils-ms-auto' => 'utils/margin/ms/ms-auto.css',
    'lqdsep-utils-me-auto' => 'utils/margin/me/me-auto.css',
    'lqdsep-utils-mx-auto' => 'utils/margin/mx-auto.css',
    'lqdsep-utils-pos-rel' => 'utils/position/pos-rel.css',
    'lqdsep-utils-pos-abs' => 'utils/position/pos-abs.css',
    'lqdsep-utils-pos-fix' => 'utils/position/pos-fix.css',
    'lqdsep-utils-pos-mid' => 'utils/position/pos-mid.css',
    'lqdsep-utils-pos-sticky' => 'utils/position/pos-sticky.css',
    'lqdsep-utils-pos-tl' => 'utils/position/pos-tl.css',
    'lqdsep-utils-pos-tr' => 'utils/position/pos-tr.css',
    'lqdsep-utils-pos-bl' => 'utils/position/pos-bl.css',
    'lqdsep-utils-pos-br' => 'utils/position/pos-br.css',
    'lqdsep-utils-bg-cover' => 'utils/bg/bg-cover.css',
    'lqdsep-utils-bg-center' => 'utils/bg/bg-center.css',
    'lqdsep-utils-bg-transparent' => 'utils/bg/bg-transparent.css',
    'lqdsep-utils-reset-ul' => 'utils/reset-ul.css',
    'lqdsep-utils-inline-ul' => 'utils/inline-ul.css',
    'lqdsep-utils-overflow-hidden' => 'utils/overflow/overflow-hidden.css',
    'lqdsep-utils-objfit-cover' => 'utils/object-fit/objfit-cover.css',
    'lqdsep-utils-objfit-center' => 'utils/object-fit/objfit-center.css',
    'lqdsep-utils-overlay' => 'utils/overlay.css',
    'lqdsep-utils-text-center' => 'utils/text/text-center.css',
    'lqdsep-utils-text-end' => 'utils/text/text-end.css',
    'lqdsep-utils-text-start' => 'utils/text/text-start.css',
    'lqdsep-utils-text-uppercase' => 'utils/text/text-uppercase.css',
    'lqdsep-utils-text-ltrsp-1' => 'utils/text/letter-spacing-1em.css',
    'lqdsep-utils-text-ltrsp-115' => 'utils/text/letter-spacing-115em.css',
    'lqdsep-utils-text-ltrsp-15' => 'utils/text/letter-spacing-15em.css',
    'lqdsep-utils-text-ltrsp-2' => 'utils/text/letter-spacing-2em.css',
    'lqdsep-utils-text-vertical' => 'utils/text/text-vertical.css',
    'lqdsep-utils-text-ws-nowrap' => 'utils/text/ws-nowrap.css',
    'lqdsep-utils-pointer-events-none' => 'utils/pointer-events-none.css',
    'lqdsep-utils-backface-hidden' => 'utils/transform/backface-hidden.css',
    'lqdsep-utils-transform-style-3d' => 'utils/transform/transform-style-3d.css',
    'lqdsep-utils-transform-perspective' => 'utils/transform/transform-perspective.css',
    'lqdsep-utils-will-change-opacity' => 'utils/transform/will-change-opacity.css',
    'lqdsep-utils-will-change-transform' => 'utils/transform/will-change-transform.css',
    'lqdsep-utils-star-rating-base' => 'utils/star-rating/star-rating-base.css',
    'lqdsep-utils-star-rating-shaped' => 'utils/star-rating/star-rating-shaped.css',
    'lqdsep-utils-star-rating-outline' => 'utils/star-rating/star-rating-outline.css',
    'lqdsep-utils-star-rating-fill' => 'utils/star-rating/star-rating-fill.css',
    'lqdsep-utils-fade-sides' => 'utils/fade-sides.css',
);
// width
for ( $i = 10; $i <= 100; $i += 5 ) {
    $utils['lqdsep-utils-w-' . $i] = 'utils/width/w-' . $i . '.css';
    $i >= 50 && $i += 5;
};
// height
for ( $i = 25; $i <= 150; $i += 25 ) {
    $utils['lqdsep-utils-h-' . $i] = 'utils/height/h-' . $i . '.css';
};
// height with padding
for ( $i = 35; $i <= 150; $i += 5 ) {
    $utils['lqdsep-utils-h-pt-' . $i] = 'utils/height/h-pt/h-pt-' . $i . '.css';
};
// border radius
for ( $i = 2; $i <= 12; $i += 2 ) {
    if ( $i === 12 ) {
       $utils['lqdsep-utils-border-radius-circle'] = 'utils/border-radius/border-radius-circle.css';
       continue;
    }
    $utils['lqdsep-utils-border-radius-' . $i] = 'utils/border-radius/border-radius-' . $i . '.css';
};
// padding and margin
for ( $i = 0; $i <= 6; $i++ ) {
    $utils['lqdsep-utils-pt-' . $i] = 'utils/padding/pt/pt-' . $i . '.css';
};
for ( $i = 0; $i <= 6; $i++ ) {
    $utils['lqdsep-utils-p-' . $i] = 'utils/padding/p/p-' . $i . '.css';
};
for ( $i = 0; $i <= 6; $i++ ) {
    $utils['lqdsep-utils-pb-' . $i] = 'utils/padding/pb/pb-' . $i . '.css';
};
for ( $i = 0; $i <= 6; $i++ ) {
    $utils['lqdsep-utils-ps-' . $i] = 'utils/padding/ps/ps-' . $i . '.css';
};
for ( $i = 0; $i <= 6; $i++ ) {
    $utils['lqdsep-utils-pe-' . $i] = 'utils/padding/pe/pe-' . $i . '.css';
};
for ( $i = 0; $i <= 6; $i++ ) {
    $utils['lqdsep-utils-mt-' . $i] = 'utils/margin/mt/mt-' . $i . '.css';
};
for ( $i = 0; $i <= 6; $i++ ) {
    $utils['lqdsep-utils-m-' . $i] = 'utils/margin/m/m-' . $i . '.css';
};
for ( $i = 0; $i <= 6; $i++ ) {
    $utils['lqdsep-utils-mb-' . $i] = 'utils/margin/mb/mb-' . $i . '.css';
};
for ( $i = 0; $i <= 6; $i++ ) {
    $utils['lqdsep-utils-ms-' . $i] = 'utils/margin/ms/ms-' . $i . '.css';
};
for ( $i = 0; $i <= 6; $i++ ) {
    $utils['lqdsep-utils-me-' . $i] = 'utils/margin/me/me-' . $i . '.css';
};
// font weights
foreach ( array( 'bold', 'medium', 'normal', 'semibold' ) as $font ) {
    $utils['lqdsep-utils-text-weight-' . $font] = 'utils/text/font-weight-' . $font . '.css';
};
// z-index
for ( $i = -1; $i <= 10; $i++ ) { 
    $utils['lqdsep-utils-zindex-' . $i] = 'utils/z-index/z-index-' . $i . '.css';
};