<?php

// Fallback
if( !class_exists( 'LD_Blog' ) ) {
	// Start the Loop.
	while ( have_posts() ) : the_post();

		/*
		 * Include the Post-Format-specific template for the content.
		 * If you want to override this in a child theme, then include a file
		 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
		 */
		liquid_get_content_template();

	// End the loop.
	endwhile;

	// Set up paginated links.
    $links = paginate_links( array(
		'type' => 'array',
		'prev_next' => true,
		'prev_text' => '<span aria-hidden="true">' . wp_kses( __( '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="32" viewBox="0 0 12 32" style="width: 1em; height: 1em;"><path fill="currentColor" d="M3.625 16l7.938 7.938c.562.562.562 1.562 0 2.125-.313.312-.688.437-1.063.437s-.75-.125-1.063-.438L.376 17c-.563-.563-.5-1.5.063-2.063l9-9c.562-.562 1.562-.562 2.124 0s.563 1.563 0 2.125z"></path></svg>', 'archub' ), 'svg' ) . '</span>',
		'next_text' => '<span aria-hidden="true">' . wp_kses( __( '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="32" viewBox="0 0 12 32" style="width: 1em; height: 1em;"><path fill="currentColor" d="M8.375 16L.437 8.062C-.125 7.5-.125 6.5.438 5.938s1.563-.563 2.126 0l9 9c.562.562.624 1.5.062 2.062l-9.063 9.063c-.312.312-.687.437-1.062.437s-.75-.125-1.063-.438c-.562-.562-.562-1.562 0-2.125z"></path></svg>', 'archub' ), 'svg' ) . '</span>'
	));

	if( !empty( $links ) ) {

		printf( '<div class="blog-nav"><nav aria-label="%s"><ul class="pagination"><li>%s</li></ul></nav></div>', esc_attr__( 'Page navigation', 'archub' ), join( "</li>\n\t<li>", $links ) );
	}

	return;
}

get_template_part( 'theme/category-blog' );