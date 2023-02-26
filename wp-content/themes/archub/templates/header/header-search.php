<?php

	$search_id = uniqid( 'search-' );

?>
<div class="ld-module-search d-flex align-items-center">
	
	<?php ld_el_module_trigger_render( $data_target = $search_id, 'hmt_', $settings = $atts, $type = 'search' ); ?>
	
	<div role="search" class="ld-module-dropdown collapse pos-abs" id="<?php echo esc_attr( $search_id ) ?>" aria-expanded="false">
		<div class="ld-search-form-container">
			<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ) ?>" class="ld-search-form pos-rel">
				<input type="search" placeholder="<?php echo esc_attr_x( 'Start searching', 'placeholder', 'archub' ) ?>" value="<?php echo get_search_query() ?>" name="s" />
				<span role="search" class="input-icon" data-ld-toggle="true" data-toggle="collapse" data-target="<?php echo '#' . esc_attr( $search_id ); ?>" aria-controls="<?php echo esc_attr( $search_id ) ?>" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" style="height: 1em;"><path fill="currentColor" d="M13.365 2.001c-4.37.74-8.093 3.493-10.055 7.435-.845 1.697-1.269 3.163-1.413 4.887-.357 4.252 1.082 8.17 4.06 11.062 1.242 1.206 2.144 1.85 3.606 2.58 4.546 2.27 10.248 1.75 14.209-1.295.39-.3.756-.545.813-.545.058 0 1.425 1.322 3.04 2.938L30.561 32H32v-1.44l-2.938-2.935c-1.615-1.615-2.937-2.968-2.937-3.008 0-.04.23-.377.51-.75 1.08-1.442 1.933-3.263 2.396-5.117.219-.876.265-1.436.265-3.188-.002-1.89-.037-2.257-.325-3.329-1.406-5.227-5.42-9.053-10.604-10.11-1.274-.26-3.822-.321-5.002-.122m5.572 2.306c1.993.59 3.96 1.8 5.283 3.246 1.302 1.425 2.126 2.905 2.744 4.93.296.972.33 1.278.331 3.08.002 2.311-.196 3.263-1.051 5.053-.657 1.374-1.38 2.367-2.512 3.455-1.558 1.496-3.104 2.373-5.098 2.89-6.421 1.668-12.828-2.11-14.456-8.524-.394-1.552-.442-3.702-.117-5.25.906-4.306 4.206-7.789 8.462-8.928 1.369-.366 1.395-.369 3.415-.326 1.591.034 2.044.09 3 .374"></path></svg></span>
			</form>
		</div>
	</div>
	
</div>