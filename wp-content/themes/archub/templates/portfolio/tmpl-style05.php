<div class="carousel-item col-xs-12 col-sm-6 col-md-4 <?php $this->entry_term_classes() ?>">

	<div class="carousel-item-inner">
		<div class="carousel-item-content">

			<article<?php echo liquid_helper()->html_attributes( $attributes ) ?>>
				<div class="lqd-pf-item-inner lqd-overlay d-flex align-items-end">
		
					<div class="lqd-pf-img overflow-hidden lqd-overlay">
						<?php $this->entry_thumbnail(); ?>
						<span class="lqd-pf-overlay-bg lqd-overlay"></span>
					</div>
		
					<div class="lqd-pf-details w-100 ps-4 pe-4 pos-rel">
						<?php the_title( '<h2 class="m-0 h5">', '</h2>'  ); ?>
						<?php $this->entry_cats() ?>
					</div>
		
					<?php $this->get_overlay_button(); ?>
		
				</div>
			</article>

		</div>
	</div>
	
</div>