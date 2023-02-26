<?php 	
	$description = $atts['description'];
	$scheme = isset( $atts['scheme'] ) ? $atts['scheme'] : '';

	if ( !isset($search_type) ){
		if( class_exists( 'WooCommerce' ) ) $search_type = "product"; else $search_type = "post"; 
	} 

?>
<div class="ld-module-search lqd-module-search-slide-top d-flex align-items-center <?php echo esc_attr( $scheme ); ?>" data-module-style='lqd-search-style-slide-top'>

<?php 
	$search_id = uniqid( 'search-' ); 
?>
	
	<?php ld_el_module_trigger_render( $data_target = $search_id, 'hmt_', $settings = $atts, $type = 'search' ); ?>
	
	<div class="ld-module-dropdown collapse d-flex w-100 flex-column pos-fix overflow-hidden backface-hidden" id="<?php echo esc_attr( $search_id ) ?>" aria-expanded="false">
		
		<div class="ld-search-form-container d-flex flex-column justify-content-center h-100 mx-auto backface-hidden">
			<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ) ?>" class="ld-search-form w-100">
				<input class="w-100" type="search" placeholder="<?php echo esc_attr_x( 'Search', 'placeholder', 'archub' ) ?>" value="<?php echo get_search_query() ?>" name="s">
				<span class="input-icon d-inline-flex align-items-center justify-content-center pos-abs" data-ld-toggle="true" data-toggle="collapse" data-target="<?php echo '#' . esc_attr( $search_id ); ?>" aria-controls="<?php echo esc_attr( $search_id ) ?>" aria-expanded="false"><i class="lqd-icn-ess icon-ld-search"></i></span>
				<input type="hidden" name="post_type" value="<?php echo esc_attr( $search_type ); ?>" />
			</form>
			<?php if( !empty( $description ) ) { ?>
			<p class="lqd-module-search-info"><?php echo esc_html( $description ); ?></p>
			<?php } ?>
		</div>
		
	</div>
	
</div>