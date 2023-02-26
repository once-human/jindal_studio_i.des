
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

<div class="lqd-lp-img border-radius-4 overflow-hidden pos-rel mb-4">
	<?php $this->entry_thumbnail( 'liquid-style07-lb' ); ?>
</div>

<header class="lqd-lp-header mb-4">
	<div class="lqd-lp-meta d-flex align-items-center mb-2">
		<?php $this->entry_tags( 'reset-ul inline-nav pos-rel z-index-3' ); ?>
		<span class="ms-1 me-1">/</span>
		<?php $this->entry_time(); ?>
	</div>
	<?php $this->entry_title( 'h5 m-0' ); ?>
</header>

<?php $this->entry_content( 'lqd-lp-excerpt mb-2' ); ?>

<?php if( $show_read_more_button === 'yes' ) : ?>
<footer class="lqd-lp-footer pos-rel z-index-2 pt-1">
	<a href="<?php the_permalink(); ?>" class="btn btn-naked lqd-lp-read-more">
		<span class="btn-txt"><?php esc_html_e( 'Read more', 'archub' ); ?></span>
		<span class="btn-icon">
			<svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 0.56em;height: 0.56em;"><path fill="currentColor" d="M4.275 0V4.275H0V5.282H4.275V9.557H5.282V5.282H9.557V4.275H5.282V0H4.275Z"/> </svg>
		</span>
	</a>
</footer>
<?php endif; ?>

<?php $this->overlay_link(); ?>

