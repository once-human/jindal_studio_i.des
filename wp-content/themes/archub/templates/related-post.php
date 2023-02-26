<?php

$col = '3';
if( '2' === $number_of_posts ) {
	$col = '6';
}
elseif( '3' === $number_of_posts ) {
	$col = '4';
}

if( empty( $related_posts_view ) ) {
	$related_posts_view = 'style-1';
}

?>
<div class="related-posts">
	
	<div class="container">
		
		<?php if( !empty( $heading ) ) { ?>
			<h3 class="related-posts-title"><?php echo esc_html( $heading ) ?></h3>
		<?php } ?>

		<div class="row">

			<?php while( $related_posts->have_posts() ): $related_posts->the_post(); ?>
	
				<div class="col-lg-<?php echo esc_attr( $col ) ?> col-sm-6 col-xs-12">
			
				<?php if ( $related_posts_view === 'style-1' ) { ?>
				<article class="lqd-lp lqd-lp-style-6 text-start">
	
					<div class="lqd-lp-img pos-rel mb-4">

						<?php if( '' !== get_the_post_thumbnail() ) : ?>
							<figure class="pos-rel">
								<?php liquid_the_post_thumbnail( 'liquid-related-post', array( 'class' => 'w-100' ), false ); ?>
							</figure>
						<?php endif; ?>

						<div class="lqd-lp-meta lqd-lp-meta-solid pos-abs pos-bl d-flex align-items-center p-0 no-padding">
							<span class="lqd-lp-date pt-2 pb-2 ps-3 pe-3"><?php printf( _x( '%s ago', '%s = human-readable time difference', 'archub' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) ); ?></span>
							<ul class="reset-ul inline-nav pos-rel z-index-3 pt-2 pb-2 pe-3">
								<li><?php echo liquid_get_category(); ?></li>
							</ul>
						</div>
					</div>
	
					<header class="lqd-lp-header mb-2">
						<h2 class="lqd-lp-title h5 m-0">
							<a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
						</h2>
					</header>
					
					<?php if( has_excerpt() ) { ?>
					<div class="lqd-lp-excerpt">
						<p><?php the_excerpt( ) ?></p>
					</div>
					<?php } ?>
	
					<a href="<?php the_permalink() ?>" class="lqd-lp-overlay-link lqd-overlay z-index-2"></a>
	
				</article>

				<?php } else if ( $related_posts_view === 'style-2' ) { ?>
				<article class="lqd-lp lqd-lp-style-11 lqd-lp-hover-img-zoom text-start">
					
					<?php if( '' !== get_the_post_thumbnail() ) : ?>
					<div class="lqd-lp-img pos-rel mb-3 overflow-hidden">
						<figure class="pos-rel">
							<?php liquid_the_post_thumbnail( 'liquid-related-post', array( 'class' => 'w-100' ), false ); ?>
						</figure>
					</div>
					<?php endif; ?>
	
					<div class="lqd-lp-meta mb-2">
						<ul class="lqd-lp-cat reset-ul inline-nav lqd-lp-cat-shaped lqd-lp-cat-solid font-weight-bold">
							<li><?php echo liquid_get_category(); ?></li>
						</ul>
					</div>
					<header class="lqd-lp-header mb-2">
						<h2 class="lqd-lp-title h5 m-0">
							<a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
						</h2>
					</header>
	
					<?php if( has_excerpt() ) { ?>
					<div class="lqd-lp-excerpt mb-2">
						<p><?php the_excerpt( ) ?></p>
					</div>
					<?php } ?>
	
					<a href="<?php the_permalink() ?>" class="lqd-lp-overlay-link lqd-overlay z-index-2"></a>
	
				</article>

				<?php } else if ( $related_posts_view === 'style-3' ) { ?>
				<article class="lqd-lp lqd-lp-style-10 lqd-lp-content-overlay pos-rel d-flex flex-wrap border-radius-4 overflow-hidden h-pt-80 lqd-lp-hover-img-zoom">
	
					<?php if( '' !== get_the_post_thumbnail() ) : ?>
					<div class="lqd-lp-img lqd-overlay">
						<figure class="w-100 h-100">
							<?php liquid_the_post_thumbnail( 'liquid-related-post-sq', array( 'class' => 'w-100 h-100 objfit-cover objfit-center' ), false ); ?>
						</figure>
					</div>
					<?php endif; ?>
					
					<header class="lqd-lp-header lqd-overlay d-flex flex-column justify-content-end p-4">
						<div class="lqd-lp-content-bg lqd-overlay"></div>
						<div class="lqd-lp-header-bottom pos-rel">
							<span class="lqd-lp-date text-uppercase ltr-sp-1 font-weight-bold pos-rel z-index-2"><?php echo liquid_helper()->liquid_post_date(); ?></span>
							<h2 class="lqd-lp-title mt-2 mb-0 h5 lh-135"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
						</div>
					</header>
	
					<a href="<?php the_permalink() ?>" class="lqd-lp-overlay-link lqd-overlay z-index-2"></a>
	
				</article>
				<?php } ?>
	
			</div>
					
			<?php endwhile; ?>
	
		</div>
	</div>

</div>
<?php wp_reset_postdata();