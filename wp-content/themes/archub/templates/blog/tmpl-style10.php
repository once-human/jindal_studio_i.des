<div class="lqd-lp-img pos-rel mb-4 overflow-hidden">
	<?php $this->entry_thumbnail() ?>
	<footer class="lqd-lp-footer d-flex align-items-end justify-content-end pos-abs w-100 h-100">

		<a href="<?php the_permalink(); ?>" class="btn btn-solid border-none btn-xsm text-uppercase">
			<span class="btn-txt"><?php esc_html_e( 'read', 'archub' ); ?></span>
			<span class="btn-icon">
				<i class="lqd-icn-ess icon-ion-ios-add"></i>
			</span>
		</a>

	</footer>

</div>

<div class="lqd-lp-meta d-flex align-items-center p-0 mb-3">
	
	<?php $this->entry_tags( 'reset-ul inline-nav pos-rel z-index-3 text-uppercase ltr-sp-1' ); ?>

</div>

<header class="lqd-lp-header mt-2 mb-3">
	<h2 class="lqd-lp-title h5 m-0 pos-rel z-index-2">
		<a href="<?php the_permalink(); ?>" data-split-text="true" data-split-options='{"type": "lines", "disableOnMobile": true}'><?php the_title(); ?></a>
	</h2>
</header>

<?php $this->overlay_link(); ?>