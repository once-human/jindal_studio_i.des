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

<?php $this->entry_thumbnail(); ?>

<header class="lqd-lp-header">

	<div class="lqd-lp-meta lqd-lp-meta-dot-between d-flex flex-wrap align-items-center font-weight-bold text-uppercase ltr-sp-1">
		
		<?php $this->entry_tags( 'lqd-lp-cat lqd-lp-cat-shaped lqd-lp-cat-solid lqd-lp-cat-solid-colored reset-ul inline-nav pos-rel z-index-3' ); ?>

		<?php $this->entry_time(); ?>

	</div>

	<?php $this->entry_title( 'mt-3 mb-4 h5' ); ?>

</header>

<?php $this->entry_content( 'lqd-lp-excerpt mb-5' ); ?>

<footer class="lqd-lp-footer">

	<div class="lqd-lp-meta">
		<div class="lqd-lp-author d-inline-flex flex-wrap align-items-center pos-rel z-index-3">

			<a href="<?php echo esc_url( $author_url ); ?>" class="lqd-overlay"></a>
			<figure class="border-radius-circle overflow-hidden">
				<?php echo get_avatar( get_the_author_meta( 'ID' ), '50', get_option( 'avatar_default', 'mystery' ), get_the_author(), array( 'class' => 'w-100' ) ); ?>
			</figure>
			<div class="lqd-lp-author-info ms-3">
				<h3 class="mt-0 mb-0 text-uppercase ltr-sp-1 font-weight-bold"><?php echo get_the_author(); ?></h3>
			</div>

		</div>
	</div>

</footer>

<?php $this->overlay_link(); ?>