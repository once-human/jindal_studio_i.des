<?php

$author_url = get_author_posts_url( get_the_author_meta( 'ID' ) );
$format = get_post_format();

if( 'audio' === $format ) {
	$this->entry_thumbnail();
}
/*
elseif( 'video' === $format ) {
?>
<div class="post-video">
	<?php $this->entry_thumbnail() ?>
	<?php $this->entry_tags() ?>
</div>
<?php
}
*/
?>

<?php if ('' !== get_the_post_thumbnail()) : ?>
	<div class="lqd-lp-img pos-rel mb-3 overflow-hidden">
		<?php $this->entry_thumbnail(); ?>
	</div>
<?php endif; ?>

<div class="lqd-lp-meta mb-3">
	<div class="entry-meta d-flex flex-wrap align-items-center text-center">
		<div class="byline">
			<span class="d-flex flex-column">
				<span class="screen-reader-text"><?php esc_html_e( 'Author', 'archub' ); ?></span>
				<?php liquid_author_link() ?>
			</span>
		</div>

		<div class="posted-on">
			<span class="screen-reader-text"><?php esc_html_e( 'Published on:', 'archub' ); ?></span>
			<a href="<?php the_permalink(); ?>" rel="bookmark">
				<?php
					$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
					printf( $time_string,
						esc_attr( get_the_date( 'c' ) ),
						get_the_date()
					);
				?>
			</a>
		</div>
		
		<?php $this->entry_tags( 'lqd-lp-cat lqd-lp-cat-shaped lqd-lp-cat-solid reset-ul inline-nav pos-rel z-index-3 font-weight-bold text-uppercase ltr-sp-1' ); ?>
	</div>
</div>
<header class="lqd-lp-header mb-2">
	<h2 class="lqd-lp-title h5 m-0">
		<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	</h2>
</header>

<?php $this->entry_content( 'lqd-lp-excerpt mb-3' ); ?>

<?php $this->overlay_link(); ?>

