<?php
/**
 * Default header template
 *
 * @package ArcHub
 */

$header = liquid_get_header_layout();
$cached = 0;

if( function_exists( 'icl_object_id' ) ) {
    $header['id'] = icl_object_id( $header['id'], 'page', false, ICL_LANGUAGE_CODE );
}
if ( function_exists( 'pll_get_post' ) ) {
    $header['id'] = pll_get_post( $header['id'] );
}

if ( ! is_admin() && is_singular() && liquid_helper()->get_option('enable-hub-optimization') === 'on' && liquid_helper()->get_option('enable-hub-header-cache') === 'on' &&
    ( ! isset( $_GET['preview'] ) || $_GET['preview'] !== 'true' ) ) {
    $header_content = get_post_meta($header['id'], '_post_content', true);
    if (!$header_content) {
        $header_content = get_post_field( 'post_content', $header['id'] );
    } else {
        $cached = 1;
    }
} else {
    $header_content = get_post_field( 'post_content', $header['id'] );
}

?>
<header <?php liquid_helper()->attr( 'header', $header['attributes'] ); ?>>
    <?php liquid_action( 'before_header_tag' ); ?>

    <?php  if ( defined( 'ELEMENTOR_VERSION' ) ) :

        echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $header['id'] );

    else :

        $header_content = str_replace( '[vc_row ', '[ld_header_row ', $header_content );
        $header_content = str_replace( '[vc_row]', '[ld_header_row]', $header_content );
        $header_content = str_replace( '[/vc_row]', '[/ld_header_row]', $header_content );

        $header_content = str_replace( '[vc_column ', '[ld_header_column ', $header_content );
        $header_content = str_replace( '[vc_column]', '[ld_header_column]', $header_content );
        $header_content = str_replace( '[/vc_column]', '[/ld_header_column]', $header_content );

        echo do_shortcode( $header_content );

    endif;

    if (!$cached) { liquid_action( 'after_header_tag' ); } ?>

</header>