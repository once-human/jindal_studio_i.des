<?php 
	
	$theme = liquid_helper()->get_current_theme();
	
?>
<nav class="lqd-dsd-menubard">

	<span class="lqd-dsd-logo">
		<img src="<?php echo get_template_directory_uri() . '/liquid/assets/img/dashboard/hubbig.png'; ?>" alt="<?php echo esc_attr( $theme->name ); ?>">
		<?php printf( '<span class="lqd-v">%s</span>', $theme->version ); ?>
	</span>

	<ul class="lqd-dsd-menu">
		<li class="<?php echo liquid_helper()->active_tab( 'liquid' ); ?>">
			<a href="<?php echo liquid_helper()->dashboard_page_url(); ?>">
				<span><?php esc_html_e( 'Activation', 'archub' ); ?></span>
			</a>
		</li>
		<li>
			<a href="<?php echo esc_url(admin_url( 'admin.php?page=liquid-setup' )); ?>">
				<span><?php esc_html_e( 'Setup Wizard', 'archub' ); ?></span>
			</a>
		</li>
		<li>
			<a href="https://liquidthemes.freshdesk.com/" target="_blank">
				<span><?php esc_html_e( 'Support', 'archub' ); ?></span>
			</a>
		</li>
		<li>
			<a href="https://docs.liquid-themes.com/collection/481-architecture-hub" target="_blank">
				<span><?php esc_html_e( 'Documentations', 'archub' ); ?></span>
			</a>
		</li>
	</ul>

</nav>
