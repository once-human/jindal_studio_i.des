
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

<div class="lqd-lp-img pos-rel mb-4">

	<?php $this->entry_thumbnail( 'liquid-style06-lb' ); ?>

	<div class="lqd-lp-meta lqd-lp-meta-solid pos-b-l pos-abs pos-bl d-flex align-items-center p-0 no-padding">

		<time class="lqd-lp-date pt-2 pb-2 ps-3 pe-3" datetime="<?php echo get_the_date( 'c' ); ?>"><?php echo liquid_helper()->liquid_post_date(); ?></time>
		
		<?php $this->entry_tags( 'reset-ul inline-nav pos-rel z-index-3 pt-2 pb-2' ); ?>

	</div>

</div>

<header class="lqd-lp-header mb-2">
	<h2 class="lqd-lp-title h5 m-0">
		<a href="<?php the_permalink(); ?>" data-split-text="true" data-split-options='{"type": "lines", "disableOnMobile": true}'><?php the_title(); ?></a>
	</h2>
</header>

<?php $this->entry_content( 'lqd-lp-excerpt' ); ?>

<?php if( $show_read_more_button === 'yes' ) : ?>
<footer class="lqd-lp-footer pos-rel z-index-3 mt-3">
	<a href="<?php echo esc_url( get_permalink() ); ?>" class="btn btn-naked btn-hover-swp">
		<span class="btn-txt"><?php esc_html_e( 'read more', 'archub' ); ?></span>
		<span class="btn-icon">
			<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" style="height: 1em;"><path fill="currentColor" d="M17.806 25.788l8.631-8.375c.375-.363.563-.857.563-1.4v-.025c0-.544-.188-1.038-.563-1.4l-8.63-8.375c-.75-.782-1.957-.782-2.7 0s-.745 2.043 0 2.825L20.293 14H6.919C5.856 14 5 14.894 5 16c0 1.125.856 2 1.912 2h13.375L15.1 22.963a2.067 2.067 0 0 0 0 2.824c.75.782 1.956.782 2.706 0z"></path></svg>
		</span>
		<span class="btn-icon">
			<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" style="height: 1em;"><path fill="currentColor" d="M17.806 25.788l8.631-8.375c.375-.363.563-.857.563-1.4v-.025c0-.544-.188-1.038-.563-1.4l-8.63-8.375c-.75-.782-1.957-.782-2.7 0s-.745 2.043 0 2.825L20.293 14H6.919C5.856 14 5 14.894 5 16c0 1.125.856 2 1.912 2h13.375L15.1 22.963a2.067 2.067 0 0 0 0 2.824c.75.782 1.956.782 2.706 0z"></path></svg>
		</span>
	</a>
</footer>
<?php endif; ?>

<?php $this->overlay_link(); ?>