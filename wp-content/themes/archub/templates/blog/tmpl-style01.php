<?php

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
<header class="lqd-lp-header mb-6">
	
	<div class="lqd-lp-meta">
		<?php $this->entry_tags( 'lqd-lp-cat-shaped lqd-lp-cat-solid lqd-lp-cat-solid-colored reset-ul inline-nav pos-rel z-index-3 font-weight-bold text-uppercase ltr-sp-1' ); ?>
	</div>

	<?php $this->entry_title( 'mt-3 mb-3 h5' ); ?>

	<div class="lqd-lp-meta">
		<time class="lqd-lp-date d-inline-flex align-items-center" datetime="<?php echo get_the_date( 'c' ); ?>"><?php echo liquid_helper()->liquid_post_date(); ?></time>
	</div>
</header>
<?php $this->entry_thumbnail(); ?>
<?php $this->overlay_link(); ?>
