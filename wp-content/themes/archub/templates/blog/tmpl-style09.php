<header class="lqd-lp-header d-flex mb-4">

	<div class="lqd-lp-meta d-flex align-items-center p-0">
		<?php
			$time_string = '<time class="published updated lqd-lp-date" datetime="%1$s">%2$s</time>';
			printf( $time_string,
				esc_attr( get_the_date( 'c' ) ),
				get_the_date()
			);
		?>
	</div>

	<h2 class="lqd-lp-title h5 m-0">
		<a href="<?php the_permalink(); ?>" data-split-text="true" data-split-options='{"type": "lines", "disableOnMobile": true}'><?php the_title(); ?></a>
	</h2>

</header>

<div class="lqd-lp-img mb-5 overflow-hidden">
	<?php $this->entry_thumbnail(); ?>
</div>

