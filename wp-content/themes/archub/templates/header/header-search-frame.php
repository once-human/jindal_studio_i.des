<?php 
	$description = $atts['description'];
	$suggestions_title = $atts['suggestions_title'];
	$suggestions_title2 = $atts['suggestions_title2'];
	$suggestions_title3 = $atts['suggestions_title3'];
	
	$suggestions = $atts['suggestions'];
	$suggestions2 = $atts['suggestions2'];
	$suggestions3 = $atts['suggestions3'];

	if ( !isset($search_type) ){
		if( class_exists( 'WooCommerce' ) ) $search_type = "product"; else $search_type = "post"; 
	} 
	
?>
<div class="ld-module-search lqd-module-search-frame d-flex align-items-center" data-module-style='lqd-search-style-frame' >

	<?php 
		$search_id = uniqid( 'search-' ); 
	?>
	
	<?php ld_el_module_trigger_render( $data_target = $search_id, 'hmt_', $settings = $atts, $type = 'search' ); ?>
	
	<div class="ld-module-dropdown collapse d-flex flex-column align-items-center justify-content-center pos-fix pos-tl text-center pointer-events-none" id="<?php echo esc_attr( $search_id ) ?>" aria-expanded="false">
		
		<div class="ld-search-form-container">

			<span class="lqd-module-search-close input-icon d-inline-block pos-abs" aria-label="Close search form" data-ld-toggle="true" data-toggle="collapse" data-target="<?php echo '#' . esc_attr( $search_id ); ?>" aria-controls="<?php echo esc_attr( $search_id ) ?>" aria-expanded="false"><i class="lqd-icn-ess icon-ion-ios-close"></i></span>
			<form class="ld-search-form" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ) ?>">
				<input class="d-block mx-auto" value="<?php echo get_search_query() ?>" name="s" type="search" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" />
				<input type="hidden" name="post_type" value="<?php echo esc_attr( $search_type ); ?>" />
				<?php if( !empty( $description ) ) { ?>
					<span class="lqd-module-search-info d-block font-weight-bold text-end"><?php echo esc_html( $description ); ?></span>
				<?php } ?>
			</form>
			<div class="lqd-module-search-related d-flex mx-auto mt-0 mb-0">
				
				<?php if( !empty( $suggestions_title ) && !empty( $suggestions ) ) { ?>
				<div class="lqd-module-search-suggestion text-start">
					<h3><?php echo esc_html( $suggestions_title ); ?></h3>
					<p><?php echo esc_html( $suggestions ); ?></p>
				</div>
				<?php } ?>
				
				<?php if( !empty( $suggestions_title2 ) && !empty( $suggestions2 ) ) { ?>
				<div class="lqd-module-search-suggestion text-start">
					<h3><?php echo esc_html( $suggestions_title2 ); ?></h3>
					<p><?php echo esc_html( $suggestions2 ); ?></p>
				</div>
				<?php } ?>
				
				<?php if( !empty( $suggestions_title3 ) && !empty( $suggestions3 ) ) { ?>
				<div class="lqd-module-search-suggestion text-start">
					<h3><?php echo esc_html( $suggestions_title3 ); ?></h3>
					<p><?php echo esc_html( $suggestions3 ); ?></p>
				</div>
				<?php } ?>
				
			</div>
			
		</div>
		
	</div>
	
</div>