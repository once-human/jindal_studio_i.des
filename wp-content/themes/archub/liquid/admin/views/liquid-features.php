<div class="lqd-dsd-box lqd-dsd-activation-tut-box">

	<h4><?php esc_html_e( 'How can I activate my Theme', 'archub' ); ?></h4>
	<p><?php esc_html_e( 'Here is a video tutorial to assist you:', 'archub' ); ?></p>

	<div class="lqd-dsd-vid">
		<button class="lqd-dsd-vid-trigger" data-lqd-dsd-lightbox="#lqd-dsd-activation-tut-vid">
			<img src="<?php echo get_template_directory_uri() . '/liquid/assets/img/dashboard/theme-activation.jpg' ?>" alt="<?php esc_attr_e( 'Theme activation', 'archub' ); ?>">
		</button>
	</div>

	<p style="text-align: center;"><a href="https://docs.liquid-themes.com/" target="_blank">Go to Help Center</a></p>

	<dialog class="lqd-dsd-dialog" id="lqd-dsd-activation-tut-vid">
		<form method="dialog" class="lqd-dsd-dialog-backdrop">
			<button></button>
		</form>
		<div class="lqd-dsd-dialog-content">
			<iframe width="1200" height="800" data-src="https://www.youtube.com/embed/1xla8KAEiCE" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
		</div>
	</dialog>

</div>
