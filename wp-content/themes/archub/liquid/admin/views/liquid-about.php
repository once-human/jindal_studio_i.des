<main>

	<div class="lqd-dsd-wrap" style="padding-top:4%">

	<?php 

	wp_enqueue_script( 'merlin', get_template_directory_uri() . '/liquid/libs/merlin/assets/js/merlin.js', array( 'jquery-core' ) );

	$tgmpa = TGM_Plugin_Activation::get_instance();
	$plugins = array(
		'all'      => array(), // Meaning: all plugins which still have open actions.
		'install'  => array(),
		'update'   => array(),
		'activate' => array(),
	);

	$texts = array(
		'something_went_wrong' => esc_html__( 'Something went wrong. Please refresh the page and try again!', 'archub' ),
	);

	// Localize the javascript.
	if ( class_exists( 'TGM_Plugin_Activation' ) ) {
		// Check first if TMGPA is included.
		wp_localize_script(
			'merlin', 'merlin_params', array(
				'tgm_plugin_nonce' => array(
					'update'  => wp_create_nonce( 'tgmpa-update' ),
					'install' => wp_create_nonce( 'tgmpa-install' ),
				),
				'tgm_bulk_url'     => $tgmpa->get_tgmpa_url(),
				'ajaxurl'          => admin_url( 'admin-ajax.php' ),
				'wpnonce'          => wp_create_nonce( 'merlin_nonce' ),
				'texts'            => $texts,
			)
		);
	} else {
		// If TMGPA is not included.
		wp_localize_script(
			'merlin', 'merlin_params', array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'wpnonce' => wp_create_nonce( 'merlin_nonce' ),
				'texts'   => $texts,
			)
		);
	}

	foreach ( $tgmpa->plugins as $slug => $plugin ) {
		if ( $tgmpa->is_plugin_active( $slug ) && false === $tgmpa->does_plugin_have_update( $slug ) ) {
			continue;
		} else {
			$plugins['all'][ $slug ] = $plugin;
			if ( ! $tgmpa->is_plugin_installed( $slug ) ) {
					$plugins['install'][ $slug ] = $plugin;
			} else {
				if ( false !== $tgmpa->does_plugin_have_update( $slug ) ) {
					$plugins['update'][ $slug ] = $plugin;
				}
				if ( $tgmpa->can_plugin_activate( $slug ) ) {
					$plugins['activate'][ $slug ] = $plugin;
				}
			}
		}
	}

	$required_plugins = array();
	$list_plugins     = array( 'archub-core' );
	$tgmpa->is_plugin_active( 'elementor' ) ? array_push( $list_plugins, 'archub-elementor-addons' ) : '';

	// Split the plugins into required and recommended.
	foreach ( $plugins['all'] as $slug => $plugin ) {
		if ( ! empty( $plugin['required'] ) && in_array( $slug, $list_plugins ) ) {
			$required_plugins[ $slug ] = $plugin;
		}
	}

	$count = count( $required_plugins );
	
	?>
	<?php if ( $count ) : ?>
	<div class="lqd-about-plugins-wrap lqd-row">

		<div class="lqd-col lqd-col-6">
			<h5>One last action is needed to complete the update</h5>
			<p>Update all plugins to discover the latest features and improvements. </p>

			<div class="about-button-wrapper">
				<a href="#install-about" class="merlin__button merlin__button--next button-next" data-callback="install_plugins">
					<span class="merlin__button--loading__text">Update Plugins</span>
				</a>
				<?php if ( false === get_transient('lqd_about_update_escape') ) : ?>
				<a class="lqd-about-update-escape">Auto-update not working? Try updating manually.</a>
				<?php endif; ?>
			</div>
		</div>

		<div class="lqd-col lqd-col-6">
			<form action="" method="post">
				<ul class="merlin__drawer--install-plugins">
				<?php if ( ! empty( $required_plugins ) ) : ?>
					<?php foreach ( $required_plugins as $slug => $plugin ) : ?>
						<li data-slug="<?php echo esc_attr( $slug ); ?>">
							<input type="checkbox" name="default_plugins[<?php echo esc_attr( $slug ); ?>]" class="checkbox" id="default_plugins_<?php echo esc_attr( $slug ); ?>" value="1" checked>

							<label for="default_plugins_<?php echo esc_attr( $slug ); ?>">
								<i></i>

								<span><?php echo esc_html( $plugin['name'] ); ?></span>

								<span class="badge">
									<span class="hint--top" aria-label="<?php esc_html_e( 'Required', 'archub' ); ?>">
										<?php esc_html_e( 'Required', 'archub' ); ?>
									</span>
								</span>
							</label>
						</li>
					<?php endforeach; ?>
				<?php endif; ?>
				</ul>
			</form>
		</div>

	</div>
	<?php endif; ?>

	<div class="lqd-about-plugins-wrap lqd-row" style="background:rgba(240, 196, 10, 0.23);">
		<div class="lqd-col lqd-col-1">
			<span 
				class="dashicons dashicons-warning"
				style="width:100%;height:100%;font-size:68px;color:#000"
			></span>
		</div>
		<div class="lqd-col lqd-col-11">
			<h5>Clear your cache</h5>
			<p>Please make sure to clear your browser and server-side cache after the update is completed. Otherwise your website might look broken to you.</p>
		</div>
	</div>
	
	<?php if ( defined('ELEMENTOR_VERSION') ): ?>
	<div class="lqd-about-plugins-wrap lqd-row" style="border-color:#92013c;background:rgba(240, 10, 10, 0.23);">
		<div class="lqd-col lqd-col-1">
			<span 
				class="dashicons dashicons-warning"
				style="width:100%;height:100%;font-size:68px;color:#000"
			></span>
		</div>
		<div class="lqd-col lqd-col-11">
			<h5>Elementor v3.6 may break your site.</h5>
			<p>Changes made with Elementor v3.6 may cause your site's style to look broken. Please make sure to regenerate CSS to fix the broken styles. <a href="https://docs.liquid-themes.com/article/465-hub-elementor-css-problem-on-the-page" target="_blank">How to Regenerate CSS?</a></p>
		</div>
	</div>
	<?php endif; ?>

	<div class="lqd-row">
		<img src="<?php echo esc_url(get_template_directory_uri() . '/liquid/assets/img/dashboard/about/v1-1.jpg'); ?>"  
			style="border-radius:18px" 
			alt="Hub"
		>
	</div>
	
	<div class="lqd-row lqd-about-iconbox-wrap">
		<div class="lqd-col-4 lqd-about-iconbox">
			<h4>Introducing v1.1</h4>
			<p>See ArcHub details</p>
			<a href="https://archub.liquid-themes.com/archub-v1-1" target="_blank" class="merlin__button">
				<span>See Landing Page
				<svg xmlns="http://www.w3.org/2000/svg" style="width:14px;height:14px;margin-left:.5em" fill="none" viewBox="0 0 24 24" stroke="currentColor">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
				</svg>
				</span>
			</a>
		</div>
		
		<div class="lqd-col-4 lqd-about-iconbox">
			<h4>What's new?</h4>
			<p>See what's changed in this version</p>
			<a href="https://hub.liquid-themes.com/arc-changelog/" target="_blank" class="merlin__button">
				<span>Changelog
				<svg xmlns="http://www.w3.org/2000/svg" style="width:14px;height:14px;margin-left:.5em" fill="none" viewBox="0 0 24 24" stroke="currentColor">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
				</svg>
				</span>
			</a>
		</div>
		
		<div class="lqd-col-4 lqd-about-iconbox">
			<h4>Performance Beta!</h4>
			<p>Try the HUB's performance features.</p>
			<?php if ( !$count ) : ?>
			<a href="<?php echo esc_url(admin_url('admin.php?page=liquid-theme-options')); ?>" target="_blank" class="merlin__button">
				<span>Open Theme Settings
				<svg xmlns="http://www.w3.org/2000/svg" style="width:14px;height:14px;margin-left:.5em" fill="none" viewBox="0 0 24 24" stroke="currentColor">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
				</svg>
				</span>
			</a>
			<?php endif; ?>
		</div>

	</div>

</main>

<script type="text/javascript">

	jQuery(".lqd-about-update-escape").on("click", function (e) {
		e.preventDefault();
		
		const link = e.target;
		var data = {
			'action': 'lqd_about_update_escape',
		};
	
		jQuery(".lqd-about-update-escape").text('Redirecting...');

		jQuery.post(ajaxurl, data, function (response) {
			window.location.href = '<?php echo esc_url(admin_url( 'plugins.php' )); ?>';
		});

	});
</script>
