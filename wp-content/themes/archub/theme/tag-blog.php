<?php
/**
 * Liquid_TagBlog class for blog posts page and blog archives
 */

class Liquid_TagBlog extends LD_Blog {

	/**
	 * [__construct description]
	 * @method __construct
	 */
	public function __construct() {
		
		$style = liquid_helper()->get_option( 'tag-blog-style' );
 		if( empty( $style ) ) {
	 		$style = 'style01';
 		}
		
		$this->atts = array(
			'style' => $style,
			'enable_parallax' => liquid_helper()->get_option( 'tag-blog-enable-parallax' ),
			'show_meta' => liquid_helper()->get_option( 'tag-blog-show-meta' ),
			'meta_type' => liquid_helper()->get_option( 'tag-blog-meta-type' ),
			'one_category' => liquid_helper()->get_option( 'tag-blog-one-category' ),
			'post_excerpt_length' => liquid_helper()->get_option( 'tag-blog-excerpt-length' ),
			'grid_columns' => liquid_helper()->get_option( 'blog-tag-columns' ),
			'pagination'      => 'pagination',
		);

		$this->render( $this->atts );

	}

	/**
	 * [render description]
	 * @method render
	 * @return [type] [description]
	 */
	public function render( $atts, $content = '' ) {

		extract($atts);

		// check
		$located = locate_template( "templates/blog/tmpl-$style.php" );
		if ( ! file_exists( $located ) ) {
			return;
		}
		$i = 0;

		$before = $after = $filter_id = '';

		if ( class_exists( 'Liquid_Elementor_Addons' ) ) {
			echo '<div class="lqd-lp-grid">';
			$items_height = 'items_height';
		} else {
			echo '<div class="lqd-lp-grid ' . $this->get_id() . '">';
			$fiter_id = $atts['filter_id'];
		}

			
			if( 'style05' === $style || 'style07' === $style ) {
				echo '<div class="lqd-lp-row row d-flex flex-wrap" data-liquid-masonry="true" data-masonry-options=\'{ "filtersID": "#' . $filter_id . '","itemSelector": ".lqd-lp-column" }\'>';
				$before = '<div class="lqd-lp-column ' . $this->get_grid_class() . ' ' . $this->entry_term_classes() . '">';
				$after  = '</div>';
			}
			elseif( 'style14' === $style ) {
				echo '<div class="lqd-lp-row row d-flex flex-wrap" data-liquid-masonry="true" data-masonry-options=\'{ "itemSelector": ".lqd-lp-column" }\'>';
				$before = '<div class="lqd-lp-column col-xs-12 col-md-4 ' . $this->entry_term_classes() . '">';
				$after  = '</div>';
			}
			else {
				echo '<div class="lqd-lp-row row d-flex flex-wrap">';
				$before = '<div class="lqd-lp-column ' . $this->get_grid_class() . ' ' . $this->entry_term_classes() . '">';
				$after  = '</div>';
			}

			while( have_posts() ): the_post();

				$post_classes = array( 'lqd-lp', 'pos-rel' );
				if( 'style01' === $style ) {
					$post_classes[] = 'lqd-lp-style-1 text-start';
				}
				elseif( 'style02' === $style ) {
					$post_classes[] = 'lqd-lp-style-2 text-start';
				}
				elseif( 'style03' === $style ) {
					$post_classes[] = 'lqd-lp-style-3 lqd-lp-hover-img-zoom text-start';
					$before = '<div class="lqd-lp-column d-flex flex-column col-md-12 ' . $this->entry_term_classes() . '">';
				}
				elseif( 'style04' === $style ) {
					$post_classes[] = 'lqd-lp-style-4 lqd-lp-animate-onhover p-5 border-radius-4 overflow-hidden text-start';
				}
				elseif( 'style05' === $style ) {
					$post_classes[] = 'lqd-lp-style-5 d-flex flex-wrap text-start';
				}
				elseif( 'style06' === $style  ) {
					$post_classes[] = 'lqd-lp-style-6 text-start';
				}
				elseif( 'style07' === $style  ) {
					$post_classes[] = 'lqd-lp-style-7 lqd-lp-hover-img-zoom text-start';
				}
				elseif( 'style08' === $style  ) {
					$post_classes[] = 'lqd-lp-style-8 lqd-lp-img-cover d-flex flex-wrap border-radius-4 overflow-hidden ' . $items_height . ' text-start';
				}
				elseif( 'style09' === $style  ) {
					$post_classes[] = 'lqd-lp-style-9 d-md-block text-start';
				}
				elseif( 'style10' === $style  ) {
					$post_classes[] = 'lqd-lp-style-10 lqd-lp-title-highlight text-start';
				}
				elseif( 'style11' === $style  ) {
					$post_classes[] = 'lqd-lp-style-11 lqd-lp-hover-img-zoom text-start';
				}
				elseif( 'style12' === $style  ) {
					$post_classes[] = 'lqd-lp-style-12 d-flex flex-wrap text-start';
				}
				elseif( 'style13' === $style  ) {
					$post_classes[] = 'lqd-lp-style-13 lqd-lp-hover-img-zoom text-start';
				}
				elseif( 'style14' === $style  ) {
					$post_classes[] = 'lqd-lp-style-14 lqd-lp-hover-img-zoom lqd-lp-hover-img-zoom-out text-start';
				}
			
				$post_classes = join( ' ', get_post_class( $post_classes, get_the_ID() ) );
			
				$attributes = array(
					'id'    => 'post-' . get_the_ID(),
					'class' => $post_classes
				);

				printf( '%s <article%s>', $before, ld_helper()->html_attributes( $attributes ) );

					if( 'quote' === get_post_format() ) {
						$quote_located = locate_template( 'templates/blog/format-quote.php' );
						include $quote_located;
					}
					else {
						include $located;
					}

				echo '</article>' . $after;

				// Adjust the timestamp settings for next loop
				if( 'timeline' === $style ) {
					$prev_post_timestamp = $post_timestamp;
					$prev_post_month = $post_month;
					$prev_post_year = $post_year;
					$post_count++;
				}

			endwhile;

			echo '</div>';
			
			// Pagination
			if( 'pagination' === $atts['pagination'] ) {
				
				$max = $GLOBALS['wp_query']->max_num_pages;
		
				// Set up paginated links.
		        $links = paginate_links( array(
					'type' => 'array',
					'prev_next' => true,
					'prev_text' => '<span aria-hidden="true">' . wp_kses( __( '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="32" viewBox="0 0 12 32" style="width: 1em; height: 1em;"><path fill="currentColor" d="M3.625 16l7.938 7.938c.562.562.562 1.562 0 2.125-.313.312-.688.437-1.063.437s-.75-.125-1.063-.438L.376 17c-.563-.563-.5-1.5.063-2.063l9-9c.562-.562 1.562-.562 2.124 0s.563 1.563 0 2.125z"></path></svg>', 'archub' ), 'svg' ) . '</span>',
					'next_text' => '<span aria-hidden="true">' . wp_kses( __( '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="32" viewBox="0 0 12 32" style="width: 1em; height: 1em;"><path fill="currentColor" d="M8.375 16L.437 8.062C-.125 7.5-.125 6.5.438 5.938s1.563-.563 2.126 0l9 9c.562.562.624 1.5.062 2.062l-9.063 9.063c-.312.312-.687.437-1.062.437s-.75-.125-1.063-.438c-.562-.562-.562-1.562 0-2.125z"></path></svg>', 'archub' ), 'svg' ) . '</span>'
				) );
		
				if( !empty( $links ) ) {
					printf( '<div class="page-nav"><nav aria-label="'. esc_attr__( 'Page navigation', 'archub' ) .'"><ul class="pagination"><li>%s</li></ul></nav></div>', join( "</li>\n\t<li>", $links ) );
				}
			}
		echo '</div>';
	}
}
new Liquid_TagBlog;