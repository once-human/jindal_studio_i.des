<?php

$author_url = get_author_posts_url( get_the_author_meta( 'ID' ) );
$format = get_post_format();

if ( class_exists( 'Liquid_Elementor_Addons' ) && defined( 'ELEMENTOR_VERSION' )){
	$show_read_more_button = $this->entry_read_more_button();
} else {
	$show_read_more_button = 'yes';
}

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

<div class="lqd-lp-img w-100 pos-rel overflow-hidden mb-4">
	<?php $this->entry_thumbnail(); ?>
</div>

<div class="lqd-lp-contents w-100 d-flex flex-column">

	<header class="lqd-lp-header">
		<div class="lqd-lp-meta d-flex align-items-center justify-content-between mb-3">
			<?php $this->entry_time(); ?>
		</div>
		<h2 class="lqd-lp-title mt-1 mb-3 h5"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	</header>

	<?php $this->entry_content( 'lqd-lp-excerpt' ); ?>

	<?php if( $show_read_more_button === 'yes' ) : ?>
	<footer class="lqd-lp-footer pt-3">
		<a href="<?php the_permalink(); ?>" class="btn btn-naked lqd-lp-read-more">
			<span class="btn-icon">
				<svg width="22" height="22" viewBox="0 0 22 22" xmlns="http://www.w3.org/2000/svg" style="height: 1em;"><path fill="currentColor" d="M0.312997 12.336H16.544L9.063 19.817L11 21.687L21.688 11L11 0.311996L9.13 2.182L16.544 9.664H0.311996V12.336H0.312997Z"/></svg>
			</span>
		</a>
	</footer>
	<?php endif; ?>

</div>

<?php $this->overlay_link(); ?>
