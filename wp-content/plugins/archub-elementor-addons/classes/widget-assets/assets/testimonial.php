<?php
$testimonial = array(
    'lqdsep-testimonial-base' => 'elements/testimonial/testimonial-base.css',
    'lqdsep-testimonial-bubble-all' => 'elements/testimonial/testimonial-bubble-all.css',
    'lqdsep-testimonial-bubble-alt' => 'elements/testimonial/testimonial-bubble-alt.css',
    'lqdsep-testimonial-bubble' => 'elements/testimonial/testimonial-bubble.css',
    'lqdsep-testimonial-card' => 'elements/testimonial/testimonial-card.css',
    'lqdsep-testimonial-card-nospace' => 'elements/testimonial/testimonial-card-nospace.css',
    'lqdsep-testimonial-details-inline' => 'elements/testimonial/testimonial-details-inline.css',
    'lqdsep-testimonial-star-rating' => 'elements/testimonial/testimonial-star-rating.css',
);
foreach ( array('48', '60', '68', '90') as $avatar_size) {
    $testimonial['lqdsep-testimonial-avatar-' . $avatar_size] = 'elements/testimonial/testimonial-avatar-' . $avatar_size . '.css';
}
foreach ( array('same', 'sm', 'lg', 'xl') as $details_size) {
    $testimonial['lqdsep-testimonial-details-' . $details_size] = 'elements/testimonial/testimonial-details-' . $details_size . '.css';
}
foreach ( array('16', '18', '21', '22', '25') as $quote_size) {
    $testimonial['lqdsep-testimonial-quote-' . $quote_size] = 'elements/testimonial/testimonial-quote-' . $quote_size . '.css';
}
foreach ( array( 'sm', 'sm2' ) as $shadow_size) {
    $testimonial['lqdsep-testimonial-shadow-' . $shadow_size] = 'elements/testimonial/testimonial-shadow-' . $shadow_size . '.css';
}
foreach ( array('18', '19') as $testi_style) {
    $testimonial['lqdsep-testimonial-style-' . $testi_style] = 'elements/testimonial/testimonial-style-' . $testi_style . '.css';
}