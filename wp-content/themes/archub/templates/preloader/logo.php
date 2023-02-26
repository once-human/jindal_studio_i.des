<?php

	$img = '';
	$logo_image = liquid_helper()->get_theme_option( 'preloader-logo-image' );

	if ( ! empty( $logo_image ) ) {
		$img = $logo_image['background-image'];
	}

?>

<div class="lqd-preloader-wrap lqd-preloader-logo" data-preloader-options='{ "animationType": "fade" }'>
	<div class="lqd-preloader-inner">

		<div class="lqd-preloader-el d-inline-block pos-rel">
			<img class="mb-3" src="<?php echo ! empty( $img ) ? esc_url( $img ) : liquid_logo_url() ?>" alt="<?php echo bloginfo( 'name' ) ?>" />
			<span class="lqd-preloader-logo-spinner pos-abs"></span>
		</div>

	</div>
</div>