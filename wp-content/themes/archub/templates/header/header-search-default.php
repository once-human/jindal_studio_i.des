<?php

	$search_id = uniqid( 'search-' );

	if ( !isset($search_type) ){
		if( class_exists( 'WooCommerce' ) ) $search_type = "product"; else $search_type = "post"; 
	} 

?>
<div class="ld-module-search lqd-module-search-default d-flex align-items-center pos-rel">

	<?php if ( !isset( $atts ) ){
		$atts = array(
			'hmt_i_icon' => [
				'value' => 'lqd-icn-ess icon-ld-search-2',
			],
			'hmt_icon_text_align' => 'lqd-module-trigger-txt-left',
			'icon_style' => 'lqd-module-icon-plain',
			'hmt_trigger_type' => 'click',
			'render_type' => 'html'
		);
	} ?>
	<?php if ( function_exists( 'ld_el_module_trigger_render' ) ): ?>
	<?php ld_el_module_trigger_render( $data_target = $search_id, 'hmt_', $settings = $atts, $type = 'search' ); ?>
	<?php else: ?>
	<?php 
		$search_id = uniqid( 'search-' );
		$icon      = 'lqd-icn-ess icon-ld-search';

		if ( !isset($search_type) ){
			if( class_exists( 'WooCommerce' ) ) $search_type = "product"; else $search_type = "post"; 
		} 
	?>
	<span class="ld-module-trigger d-inline-flex align-items-center justify-content-center pos-rel border-radius-circle lqd-module-trigger-txt-left collapsed lqd-module-show-icon" role="button" data-ld-toggle="true" data-toggle="collapse" data-target="<?php echo '#' . esc_attr( $search_id ); ?>" aria-controls="<?php echo esc_attr( $search_id ) ?>" aria-expanded="false">
		<span class="ld-module-trigger-txt"></span>
		<span class="ld-module-trigger-icon d-flex align-items-center justify-content-center pos-rel">
			<i class="<?php echo esc_attr( $icon ) ?>"></i>
		</span>
	</span>
	<?php endif; ?>

	<div role="search" class="ld-module-dropdown collapse pos-abs" id="<?php echo esc_attr( $search_id ) ?>" aria-expanded="false">
		<div class="ld-search-form-container">
			<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ) ?>" class="ld-search-form pos-rel">
				<input class="w-100" type="search" placeholder="<?php echo esc_attr_x( 'Start searching', 'placeholder', 'archub' ) ?>" value="<?php echo get_search_query() ?>" name="s" />
				<span role="search" class="input-icon d-inline-block pos-abs" data-ld-toggle="true" data-toggle="collapse" data-target="<?php echo '#' . esc_attr( $search_id ); ?>" aria-controls="<?php echo esc_attr( $search_id ) ?>" aria-expanded="false"><i class="lqd-icn-ess icon-ld-search"></i></span>
				<input type="hidden" name="post_type" value="<?php echo esc_attr( $search_type  ); ?>" />
			</form>
		</div>
	</div>
	
</div>