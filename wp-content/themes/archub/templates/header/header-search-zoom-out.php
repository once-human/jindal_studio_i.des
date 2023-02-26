<?php 	
	$description = $atts['description'];
	$suggestions_title = $atts['suggestions_title'];
	$suggestions_title2 = $atts['suggestions_title2'];
	$suggestions = $atts['suggestions'];
	$suggestions2 = $atts['suggestions2'];

	if ( !isset($search_type) ){
		if( class_exists( 'WooCommerce' ) ) $search_type = "product"; else $search_type = "post"; 
	} 

?>
<div class="ld-module-search lqd-module-search-zoom-out d-flex align-items-center" data-module-style='lqd-search-style-zoom-out'>

<?php 
	$search_id = uniqid( 'search-' ); 
?>
	
	<?php ld_el_module_trigger_render( $data_target = $search_id, 'hmt_', $settings = $atts, $type = 'search' ); ?>
	
	<div class="ld-module-dropdown collapse w-100 pos-fix pos-tl text-center invisible" id="<?php echo esc_attr( $search_id ) ?>" aria-expanded="false">
		
		<div class="ld-search-form-container h-100">

			<span class="lqd-module-search-close input-icon pos-abs" aria-label="Close search form" data-ld-toggle="true" data-toggle="collapse" data-target="<?php echo '#' . esc_attr( $search_id ); ?>" aria-controls="<?php echo esc_attr( $search_id ) ?>" aria-expanded="false"><i class="lqd-icn-ess icon-ion-ios-close"></i></span>
			<form class="ld-search-form" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ) ?>">
				<input class="d-block w-100" value="<?php echo get_search_query() ?>" name="s" type="search" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" />
				<input type="hidden" name="post_type" value="<?php echo esc_attr( $search_type ); ?>" />
				<?php if( !empty( $description ) ) { ?>
				<span class="lqd-module-search-info d-block font-weight-bold text-end"><?php echo esc_html( $description ); ?></span>
				<?php } ?>
			</form>
			<div class="lqd-module-search-related d-flex mx-auto text-start">
				<?php if( !empty( $suggestions_title ) && !empty( $suggestions ) ) { ?>
				<div class="lqd-module-search-suggestion w-50">
					<h3><?php echo esc_html( $suggestions_title ); ?></h3>
					<p><?php echo esc_html( $suggestions ); ?></p>
				</div>
				<?php } ?>
				
				<?php if( !empty( $suggestions_title2 ) && !empty( $suggestions2 ) ) { ?>
				<div class="lqd-module-search-suggestion w-50">
					<h3><?php echo esc_html( $suggestions_title2 ); ?></h3>
					<p><?php echo esc_html( $suggestions2 ); ?></p>
				</div>
				<?php } ?>
			</div>
			
		</div>
		
	</div>
	
</div>