<?php

if ( class_exists( 'Liquid_Elementor_Addons' ) && defined( 'ELEMENTOR_VERSION' ) ){
	$page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers( 'page' );
	$page_settings_model = $page_settings_manager->get_model( get_the_ID() );

	$sticky_share_view = $page_settings_model->get_settings( 'post_floating_box_social_style' );
	$sticky_share_view = $sticky_share_view ? $sticky_share_view : liquid_helper()->get_option( 'post-floating-box-social-style' );
	$author_in_sticky = $page_settings_model->get_settings( 'post_floating_box_author_enable' );
	$author_in_sticky = $author_in_sticky ? $author_in_sticky : liquid_helper()->get_option( 'post-floating-box-author-enable' );
} else {
	$sticky_share_view = liquid_helper()->get_option( 'post-floating-box-social-style' );
	$author_in_sticky = liquid_helper()->get_option( 'post-floating-box-author-enable' );
}

$social_icons_classname = 'social-icon social-icon-vertical ';

if ( $sticky_share_view === 'with-text-outline' ) {
	$social_icons_classname .= 'reset-ul social-icon-sm social-icon-underline social-icon-with-label';
} else {
	$social_icons_classname .= 'reset-ul social-icon-lg';
}

$pinterest_image = wp_get_attachment_url( get_post_thumbnail_id(), 'full' );

?>
<div class="lqd-post-sticky-stuff">
	<div class="lqd-post-sticky-stuff-inner">

		<?php if ( 'on' == $author_in_sticky ) : ?>
		<div class="entry-meta">
			<div class="byline">
				<figure>
					<?php echo get_avatar( get_the_author_meta( 'user_email' ), 80 ); ?>
				</figure>
				<span>
					<span><?php esc_html_e( 'Author', 'archub' ); ?></span>
					<?php liquid_author_link( array( 'before' => '', ) ); ?>
				</span>
			</div>
		</div>
		<?php endif; ?>

		<div class="lqd-post-share">
			<?php if ( $sticky_share_view === 'with-text-outline' ) :?>
			<span><?php esc_html_e( 'Share', 'archub' ); ?></span>
			<?php endif; ?>
			<ul class="<?php echo liquid_helper()->sanitize_html_classes( $social_icons_classname ); ?>">
				<li>
					<a rel="nofollow" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" style="width: 1em; height: 1em;"><path fill="currentColor" d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"/></svg>
						<?php if ( $sticky_share_view === 'with-text-outline' ) echo '<span style="margin-inline-start: 1em;">' . esc_html__( 'Facebook', 'archub' ) . '</span>' ?>
					</a>
				</li>
				<li>
					<a rel="nofollow" target="_blank" href="https://twitter.com/intent/tweet?text=<?php echo urlencode( get_the_title() ); ?>&amp;url=<?php the_permalink(); ?>">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width: 1em; height: 1em;"><path fill="currentColor" d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"/></svg>
						<?php if ( $sticky_share_view === 'with-text-outline' ) echo '<span style="margin-inline-start: 1em;">' . esc_html__( 'Twitter', 'archub' ) . '</span>' ?>
					</a>
				</li>
				<li>
					<a rel="nofollow" target="_blank" href="https://pinterest.com/pin/create/button/?url=&amp;media=<?php echo esc_url( $pinterest_image ); ?>&amp;description=<?php echo urlencode( get_the_title() ); ?>">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" style="width: 1em; height: 1em;"><path fill="currentColor" d="M204 6.5C101.4 6.5 0 74.9 0 185.6 0 256 39.6 296 63.6 296c9.9 0 15.6-27.6 15.6-35.4 0-9.3-23.7-29.1-23.7-67.8 0-80.4 61.2-137.4 140.4-137.4 68.1 0 118.5 38.7 118.5 109.8 0 53.1-21.3 152.7-90.3 152.7-24.9 0-46.2-18-46.2-43.8 0-37.8 26.4-74.4 26.4-113.4 0-66.2-93.9-54.2-93.9 25.8 0 16.8 2.1 35.4 9.6 50.7-13.8 59.4-42 147.9-42 209.1 0 18.9 2.7 37.5 4.5 56.4 3.4 3.8 1.7 3.4 6.9 1.5 50.4-69 48.6-82.5 71.4-172.8 12.3 23.4 44.1 36 69.3 36 106.2 0 153.9-103.5 153.9-196.8C384 71.3 298.2 6.5 204 6.5z"/></svg>
						<?php if ( $sticky_share_view === 'with-text-outline' ) echo '<span style="margin-inline-start: 1em;">' . esc_html__( 'Pinterest', 'archub' ) . '</span>' ?>
					</a>
				</li>
				<li>
					<a rel="nofollow" target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>&amp;title=<?php echo get_the_title(); ?>&amp;source=<?php echo get_bloginfo( 'name' ); ?>">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" style="width: 1em; height: 1em;"><path fill="currentColor" d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z"/></svg>
						<?php if ( $sticky_share_view === 'with-text-outline' ) echo '<span style="margin-inline-start: 1em;">' . esc_html__( 'Linkedin', 'archub' ) . '</span>' ?>
					</a>
				</li>
			</ul>
		</div>
	</div>
</div>