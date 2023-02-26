<div class="carousel-item col-sm-12 <?php $this->entry_term_classes() ?>">

	<div class="carousel-item-inner">
		<div class="carousel-item-content">

			<article<?php echo liquid_helper()->html_attributes( $attributes ) ?>>
				<div class="lqd-pf-item-inner">
		
					<div class="lqd-pf-img overflow-hidden pos-rel">
						<figure>
							<?php $this->entry_thumbnail( 'liquid-style4-pf' ); ?>
						</figure>
						<span class="lqd-pf-overlay-bg lqd-overlay">
						</span>
					</div>
		
					<div class="lqd-pf-details lqd-overlay d-flex justify-content-end">
						<div class="text-vertical p-4">
							<?php the_title( '<h2 class="mt-0 mb-0 h5">', '</h2>'  ); ?>
							<?php $this->entry_content(); ?>
						</div>
					</div>
		
					<?php $this->get_overlay_button(); ?>
		
				</div>
			</article>

		</div>
	</div>
	
</div>