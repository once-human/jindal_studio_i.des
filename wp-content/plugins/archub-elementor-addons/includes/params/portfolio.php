<?php

if( ! defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly

class LD_PortfolioListing {
	
	protected function get_post_type_list() {

		$postTypesList[] = array(
			$this->post_type,
			esc_html__( 'Posts', 'archub-elementor-addons' ),
		);
		$postTypesList[] = array(
			'custom',
			esc_html__( 'Custom query', 'archub-elementor-addons' ),
		);
		$postTypesList[] = array(
			'ids',
			esc_html__( 'List of IDs', 'archub-elementor-addons' ),
		);

		return $postTypesList;
	}
	
	/**
	 * [before_output description]
	 * @method before_output
	 * @param  [type]        $atts    [description]
	 * @param  [type]        $content [description]
	 * @return [type]                 [description]
	 */
	public function before_output( $atts, &$content ) {


		if( 'style03' === $atts['style'] ) {
			$atts['template'] = 'carousel';
		}
		elseif( 'style04' === $atts['style'] ) {
			$atts['template'] = 'carousel-2';
		}
		elseif( 'style05' === $atts['style'] ) {
			$atts['template'] = 'carousel-3';
		}

		return $atts;
	}
	
	// Entry Helper ------------------------------------------------

	protected function entry_title() {

		if( !$this->atts['show_title'] ) {
			return;
		}

		$sub_style = $this->atts['item_style'];

		// Default
		the_title( sprintf( '<h2><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
	}
	
	protected function entry_subtitle( $before = '<p>', $after = '</p>' ) {
		
		$subtitle = get_post_meta( get_the_ID(), 'portfolio-subtitle', true );
		if( empty( $subtitle ) ) {
			return;
		}
		
		printf( '%1$s %2$s %3$s', $before, esc_html( $subtitle ), $after  );
	}
	
	protected function entry_read_more() {

		if( !$this->atts['show_link'] ) {
			return;
		}

		$link = '<a href="' . esc_url( get_permalink() ) . '" class="read-more">
					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
					 	viewBox="0 0 268.832 268.832" style="enable-background:new 0 0 268.832 268.832;"
						 xml:space="preserve">
						<g>
							<path d="M265.171,125.577l-80-80c-4.881-4.881-12.797-4.881-17.678,0c-4.882,4.882-4.882,12.796,0,17.678l58.661,58.661H12.5
								c-6.903,0-12.5,5.597-12.5,12.5c0,6.902,5.597,12.5,12.5,12.5h213.654l-58.659,58.661c-4.882,4.882-4.882,12.796,0,17.678
								c2.44,2.439,5.64,3.661,8.839,3.661s6.398-1.222,8.839-3.661l79.998-80C270.053,138.373,270.053,130.459,265.171,125.577z"/>
						</g>
					</svg>
				</a>';

		echo $link;
	}

	protected function entry_content() {

	?>
	    <div class="portfolio-summary">
	        <p><?php liquid_portfolio_the_excerpt(); ?></p>
	    </div>
	<?php
	}

	public function add_excerpt_hooks() {
		add_filter( 'excerpt_more', array( $this, 'excerpt_more' ) );
		add_filter( 'excerpt_length', array( $this, 'excerpt_length' ) );
	}

	public function remove_excerpt_hooks() {
		remove_filter( 'excerpt_more', array( $this, 'excerpt_more' ) );
		remove_filter( 'excerpt_length', array( $this, 'excerpt_length' ) );
	}

	public function excerpt_more() {
		return '';
	}

	public function excerpt_length() {
		return 10;
	}

	protected function entry_cats() {
		
		$style = $this->atts['style'];
		
		$terms = get_the_terms( get_the_ID(), 'liquid-portfolio-category' );
		$term = $terms[0];


		if( !isset( $term->name ) ) {
			return;
		}
		
		$out = '';
		
		if( 'carousel' === $style ) {
			$out = sprintf( '<span class="ld-pf-category-item font-style-italic" data-split-text="true" data-split-options=\'{ "type": "chars, words" }\' data-custom-animations="true" data-ca-options=\'{ "triggerHandler": "mouseenter", "triggerTarget": ".lqd-pf-item", "triggerRelation": "closest", "offTriggerHandler": "mouseleave", "animationTarget": "all-childs", "duration": 170, "delay": 20, "offDuration": 100, "ease": "circ.out", "initValues": { "y": 0, "opacity": 1 }, "animations": { "y": -10, "opacity": 0 } }\'>%s</span>', $term->name );
		
		}
		elseif( 'grid' === $style ){
			$out = sprintf( '<div class="ld-pf-category size-sm"><a href="%s" class="text-uppercase ltr-sp-1" data-split-text="true" data-split-options=\'{ "type": "lines" }\'>%s</a></div>', get_term_link( $term->slug, $term->taxonomy ), $term->name );

		}
		elseif( 'packery' === $style ) {
			$out = sprintf( '<div class="ld-pf-category size-lg"><p data-split-text="true" data-split-options=\'{ "type": "words" }\'>%s</p></div>', $term->name  );
		} 
		elseif( 'grid-hover-3d' === $style ) {
			$out = sprintf( '<div class="ld-pf-category text-uppercase ltr-sp-1 size-sm"><a href="%s">%s</a></div>', get_term_link( $term->slug, $term->taxonomy ), $term->name );
		}
		elseif( 'grid-hover-classic' === $style ) {
			$out = sprintf( '<div class="ld-pf-category size-sm text-uppercase ltr-sp-135" data-split-text="true" data-split-options=\'{ "type": "lines" }\'><a href="%s">%s</a></div>', get_term_link( $term->slug, $term->taxonomy ), $term->name );
		}
		elseif( 'packery-2' === $style ) {
			$out = sprintf( '<div class="ld-pf-category size-md" data-split-text="true" data-split-options=\'{ "type": "lines" }\'><a href="%s">%s</a></div>', get_term_link( $term->slug, $term->taxonomy ), $term->name );
		}
		else {
			$out = sprintf( '<ul class="reset-ul inline-nav lqd-pf-cat d-inline-flex pos-rel z-index-2"><li><a href="%s">%s</a></li></ul>', get_term_link( $term->slug, $term->taxonomy ), $term->name );
		}

		echo $out;

	}
	
	protected function get_options() {

		extract( $this->atts );
		
		if( !$enable_item_animation ) {
			return;
		}
		
		$animation_opts = $this->get_animation_opts();

		$opts = $split_opts = array();
		$opts[] = 'data-custom-animations="true"';
		$opts[] = 'data-ca-options=\'' . stripslashes( wp_json_encode( $animation_opts ) ) . '\'';
	
		return join( ' ', $opts );

	}
	
	protected function get_animation_opts() {

		extract( $this->atts );
		
		$opts = $init_values = $animations_values = $arr = array();
		$opts['triggerHandler'] = 'inview';
		$opts['animationTarget'] = '.lqd-pf-item';
		$opts['duration'] = !empty( $pf_duration ) ? $pf_duration : 700;
		if( !empty( $pf_start_delay ) ) {
			$opts['startDelay'] = $pf_start_delay;
		}
		$opts['delay'] = !empty( $pf_delay ) ? $pf_delay : 100;
		$opts['ease'] = $pf_easing;
		
		//Init values
		if ( !empty( $pf_init_translate_x ) ) { $init_values['x'] = ( int ) $pf_init_translate_x; }
		if ( !empty( $pf_init_translate_y ) ) { $init_values['y'] = ( int ) $pf_init_translate_y; }
		if ( !empty( $pf_init_translate_z ) ) { $init_values['z'] = ( int ) $pf_init_translate_z; }
	
		if ( '1' !== $pf_init_scale_x ) { $init_values['scaleX'] = ( float ) $pf_init_scale_x; }
		if ( '1' !== $pf_init_scale_y ) { $init_values['scaleY'] = ( float ) $pf_init_scale_y; }
	
		if ( !empty( $pf_init_rotate_x ) ) { $init_values['rotationX'] = ( int ) $pf_init_rotate_x; }
		if ( !empty( $pf_init_rotate_y ) ) { $init_values['rotationY'] = ( int ) $pf_init_rotate_y; }
		if ( !empty( $pf_init_rotate_z ) ) { $init_values['rotationZ'] = ( int ) $pf_init_rotate_z; }
		
		if ( isset( $pf_init_opacity ) && '1' !== $pf_init_opacity ) { $init_values['opacity'] = ( float ) $pf_init_opacity; }
	
		//Animation values
		if ( !empty( $pf_init_translate_x ) ) { $animations_values['x'] = ( int ) $pf_an_translate_x; }
		if ( !empty( $pf_init_translate_y ) ) { $animations_values['y'] = ( int ) $pf_an_translate_y; }
		if ( !empty( $pf_init_translate_z ) ) { $animations_values['z'] = ( int ) $pf_an_translate_z; }
	
		if ( isset( $pf_an_scale_x ) && '1' !== $pf_init_scale_x ) { $animations_values['scaleX'] = ( float ) $pf_an_scale_x; }
		if ( isset( $pf_an_scale_y ) && '1' !== $pf_init_scale_y ) { $animations_values['scaleY'] = ( float ) $pf_an_scale_y; }
	
		if ( !empty( $pf_init_rotate_x ) ) { $animations_values['rotationX'] = ( int ) $pf_an_rotate_x; }
		if ( !empty( $pf_init_rotate_y ) ) { $animations_values['rotationY'] = ( int ) $pf_an_rotate_y; }
		if ( !empty( $pf_init_rotate_z ) ) { $animations_values['rotationZ'] = ( int ) $pf_an_rotate_z; }
	
		if ( isset( $pf_an_opacity ) && '1' !== $pf_init_opacity ) { $animations_values['opacity'] = ( float ) $pf_an_opacity; }	

		$opts['initValues'] = !empty( $init_values ) ? $init_values : array( 'scale' => 1 );
		$opts['animations'] = !empty( $animations_values ) ? $animations_values : array( 'scale' => 1 );
		
		return $opts;
		
	}
	
	protected function get_button() {

		if ( 'yes' !== $this->atts['show_button'] ) {
			return;
		}

		$data = vc_map_integrate_parse_atts( $this->slug, 'ld_button', $this->atts, 'ib_' );
		if ( $data ) {

			$btn = visual_composer()->getShortCode( 'ld_button' )->shortcodeClass();

			if ( is_object( $btn ) ) {
				echo $btn->render( array_filter( $data ) );
			}
		}
	}
	
	protected function get_overlay_button() {
		
		$ext_url   = get_post_meta( get_the_ID(), 'portfolio-website', true );
		$local_url = get_the_permalink( get_the_ID() );
		$enable_gallery = isset($this->atts['enable_gallery']) ? $this->atts['enable_gallery'] : '';
		$cc_style = isset($this->atts['custom_cursor_style']) ? $this->atts['custom_cursor_style'] : '';
		
		$target = '';
		
		$enable_ext = isset($this->atts['enable_ext']) ? $this->atts['enable_ext'] : '';
		if( $enable_ext ) {
			$url = !empty( $ext_url ) ? esc_url( $ext_url ) : $local_url;
			$target = 'target="_blank"';
		}
		else {
			$url = esc_url( $local_url );	
		}
		
		if( 'listing-lightbox-gallery' === $enable_gallery ) {
			$url = wp_get_attachment_image_url( get_post_thumbnail_id(), 'full' );
			printf( '<a href="%s" class="lqd-overlay lqd-pf-overlay-link fresco %s" data-fresco-group="'. esc_attr( $this->get_id() ) .'"></a>', $url, $cc_style);	
		}
		else {
			printf( '<a href="%s" %s class="lqd-overlay lqd-pf-overlay-link %s"></a>', $url, $target, $cc_style);
		}
		
	}
	
	protected function get_badge() {
		
		$badge = get_post_meta( get_the_ID(), 'portfolio-badge', true );
		if( !empty( $badge ) ) {
			printf( '<span class="lqd-pf-badge">%s</span>', esc_html( $badge ) );
		}
	}
	
	protected function entry_button() {
		
		if ( 'yes' !== ( $this->atts['show_button'] ) ) {
			return;
		}
		
		$target = '';
		$ext_url   = get_post_meta( get_the_ID(), 'portfolio-website', true );
		$local_url = get_the_permalink( get_the_ID() );
		
		$enable_ext = $this->atts['enable_ext'];
		if( $enable_ext ) {
			$url = !empty( $ext_url ) ? esc_url( $ext_url ) : $local_url;
			$target = ' target="_blank"';
		}
		else {
			$url = esc_url( $local_url );	
		}
		
		$btn_text = !empty( $this->atts['btn_text'] ) ? esc_html( $this->atts['btn_text'] ) : esc_html__( 'Discover more', 'archub-elementor-addons' );
		
		echo '<a href="' . $url . '" ' . $target . ' class="btn btn-xsm btn-naked text-uppercase font-weight-bold">
					<span>
						<span class="btn-txt">' . $btn_text . '</span>
					</span>
				</a>';		
	}
	
	// https://codex.wordpress.org/Making_Custom_Queries_using_Offset_and_Pagination
	// check it
	protected function build_query() {

		extract( $this->atts );
		$settings = array();

		if( 'custom' === $post_type && ! empty( $custom_query ) ) {
			$query = html_entity_decode( vc_value_from_safe( $custom_query ), ENT_QUOTES, 'utf-8' );
			$settings = wp_parse_args( $query );
		}
		elseif( 'ids' === $post_type ) {

			if ( empty( $include ) ) {
				$include = - 1;
			}

			$incposts = wp_parse_id_list( $include );
			$settings = array(
				'post__in'       => $incposts,
				'posts_per_page' => count( $incposts ),
				'post_type'      => 'any',
				'orderby'        => 'post__in',
			);
		}
		else {

			$orderby = !empty( $_GET['orderby'] ) ? $_GET['orderby'] : $orderby;
			$order   = !empty( $_GET['order'] ) ? $_GET['order'] : $order;

			$settings = array(
				'posts_per_page' => isset( $posts_per_page ) ? (int) $posts_per_page : 100,
				'orderby'        => $orderby,
				'order'          => $order,
				'meta_key'       => in_array( $orderby, array(
					'meta_value',
					'meta_value_num',
				) ) ? $meta_key : '',
				'post_type'           => $post_type,
				'ignore_sticky_posts' => true,
			);

			if( $exclude ) {
				$settings['post__not_in'] = wp_parse_id_list( $exclude );
			}

			if( 'none' === $pagination ) {
				$settings['no_found_rows'] = true;
			}
			else {
				$settings['paged'] = ld_helper()->get_paged();
			}

			if ( $settings['posts_per_page'] < 1 ) {
				$settings['posts_per_page'] = 1000;
			}

			if ( ! empty( $taxonomies ) ) {
				$taxonomies = ld_helper()->terms_are_ids_or_slugs( $taxonomies, $this->taxonomies[0] );

				$terms = get_terms( $this->taxonomies, array(
					'hide_empty' => false,
					'include' => $taxonomies,
				) );
				$settings['tax_query'] = array();
				$tax_queries = array(); // List of taxnonimes
				foreach ( $terms as $t ) {
					if ( ! isset( $tax_queries[ $t->taxonomy ] ) ) {
						$tax_queries[ $t->taxonomy ] = array(
							'taxonomy' => $t->taxonomy,
							'field'    => 'id',
							'terms'    => array( $t->term_id ),
							'relation' => 'IN',
						);
					} else {
						$tax_queries[ $t->taxonomy ]['terms'][] = $t->term_id;
					}
				}
				$settings['tax_query'] = array_values( $tax_queries );
				$settings['tax_query']['relation'] = 'OR';
			}
		}

		return $settings;
	}
	
	protected function get_item_classes() {
		
		$style = $this->atts['style'];
		$item_classes = array();


		if( 'style01' === $style ) {
			$item_classes[] = 'lqd-pf-item-style-1';
			$item_classes[] = !empty( $this->atts['color_type'] ) ? $this->atts['color_type'] : 'lqd-pf-light';
			$item_classes[] = !empty( $this->atts['horizontal_alignment'] ) ? $this->atts['horizontal_alignment'] : 'pf-details-h-end';
			$item_classes[] = 'pos-rel';
			$item_classes[] = 'overflow-hidden';
		}
		elseif( 'style02' === $style ) {
			$item_classes[] = 'lqd-pf-item-style-2';
			$item_classes[] = !empty( $this->atts['color_type'] ) ? $this->atts['color_type'] : 'lqd-pf-dark';
			$item_classes[] = !empty( $this->atts['horizontal_alignment'] ) ? $this->atts['horizontal_alignment'] : 'pf-details-h-str';
		}
		elseif( 'style03' === $style ) {
			$item_classes[] = 'lqd-pf-item-style-3';
			$item_classes[] = !empty( $this->atts['color_type'] ) ? $this->atts['color_type'] : 'lqd-pf-dark';
			$item_classes[] = !empty( $this->atts['horizontal_alignment'] ) ? $this->atts['horizontal_alignment'] : 'pf-details-h-str';
		}
		elseif( 'style06' === $style ) {
			$item_classes[] = 'lqd-pf-item-style-6';
			$item_classes[] = 'border-radius-6';
			$item_classes[] = 'p-3';
			$item_classes[] = 'pt-4';
			$item_classes[] = !empty( $this->atts['color_type'] ) ? $this->atts['color_type'] : 'lqd-pf-dark';
		}
		elseif( 'metro' === $style ) {
			$item_classes[] = !empty( $this->atts['color_type'] ) ? $this->atts['color_type'] : 'lqd-pf-light';			
			$item_classes[] = 'pf-details-inside';
			$item_classes[] = 'pf-details-full';
			$item_classes[] = !empty( $this->atts['horizontal_alignment'] ) ? $this->atts['horizontal_alignment'] : 'pf-details-h-mid';
			$item_classes[] = !empty( $this->atts['vertical_alignment'] ) ? $this->atts['vertical_alignment'] : 'pf-details-v-mid';
			$item_classes[] = 'pf-hover-masktext';
			//$item_classes[] = 'pf-hover-blurimage';
		}
		elseif( 'masonry-creative' === $style ) {
			$item_classes[] = !empty( $this->atts['color_type'] ) ? $this->atts['color_type'] : 'lqd-pf-light';
			$item_classes[] = 'pf-details-inside';
			$item_classes[] = 'pf-details-full';
			$item_classes[] = !empty( $this->atts['horizontal_alignment'] ) ? $this->atts['horizontal_alignment'] : 'pf-details-h-mid';
			$item_classes[] = !empty( $this->atts['vertical_alignment'] ) ? $this->atts['vertical_alignment'] : 'pf-details-v-mid';
			$item_classes[] = 'title-size-42';
			$item_classes[] = 'ld-pf-semiround';
		}
		elseif( 'masonry-classic' === $style ) {
			$item_classes[] = !empty( $this->atts['color_type'] ) ? $this->atts['color_type'] : 'lqd-pf-dark';
			$item_classes[] = 'pf-bg-hidden';
			$item_classes[] = 'pf-details-visible';
			$item_classes[] = 'title-size-30';
			$item_classes[] = 'pf-hover-shadow';
			$item_classes[] = 'pf-hover-shadow-alt';
		}
		elseif( 'carousel' === $style ) {
			$item_classes[] = !empty( $this->atts['color_type'] ) ? $this->atts['color_type'] : 'lqd-pf-light lqd-pf-light-alt';
			$item_classes[] = 'pf-details-inside';
			$item_classes[] = 'pf-details-visible';
			$item_classes[] = 'pf-details-full';
			$item_classes[] = !empty( $this->atts['horizontal_alignment'] ) ? $this->atts['horizontal_alignment'] : 'pf-details-h-str';
			$item_classes[] = !empty( $this->atts['vertical_alignment'] ) ? $this->atts['vertical_alignment'] : 'pf-details-v-end';
			$item_classes[] = 'title-size-48';
			$item_classes[] = 'pf-hover-shadow';
		}
		elseif( 'grid' === $style ) {
			$item_classes[] = !empty( $this->atts['color_type'] ) ? $this->atts['color_type'] : 'lqd-pf-light';
			$item_classes[] = 'pf-details-inside';
			$item_classes[] = 'pf-details-full';
			$item_classes[] = !empty( $this->atts['horizontal_alignment'] ) ? $this->atts['horizontal_alignment'] : 'pf-details-h-mid';
			$item_classes[] = !empty( $this->atts['vertical_alignment'] ) ? $this->atts['vertical_alignment'] : 'pf-details-v-mid';
			$item_classes[] = 'pf-hover-masktext';
			//$item_classes[] = 'pf-hover-blurimage';
		}
		elseif( 'grid-alt' === $style ) {
			$item_classes[] = !empty( $this->atts['color_type'] ) ? $this->atts['color_type'] : 'lqd-pf-dark';
			$item_classes[] = 'title-size-18';
			$item_classes[] = 'pf-details-visible';
			$item_classes[] = 'text-center';
			$item_classes[] = 'pf-hover-rise';
			//$item_classes[] = 'pf-hover-blurimage';
		}
		elseif( 'grid-hover-overlay' === $style ) {
			$item_classes[] = !empty( $this->atts['color_type'] ) ? $this->atts['color_type'] : 'lqd-pf-dark';
			$item_classes[] = 'pf-bg-shadow';
			$item_classes[] = 'pf-details-visible';
			$item_classes[] = 'pf-details-boxed';
			$item_classes[] = 'pf-details-pull-right';
			$item_classes[] = 'pf-details-pull-up-half';
			$item_classes[] = 'title-size-24';
			$item_classes[] = !empty( $this->atts['horizontal_alignment'] ) ? $this->atts['horizontal_alignment'] : 'pf-details-h-str';
			$item_classes[] = !empty( $this->atts['vertical_alignment'] ) ? $this->atts['vertical_alignment'] : 'pf-details-v-end';
		}
		elseif( 'grid-hover-alt' === $style ) {
			$item_classes[] = !empty( $this->atts['color_type'] ) ? $this->atts['color_type'] : 'lqd-pf-dark';
			$item_classes[] = 'title-size-18';
			$item_classes[] = 'pf-details-inside';
			$item_classes[] = 'overflow-visible';
			$item_classes[] = 'pf-details-full';			
			$item_classes[] = !empty( $this->atts['horizontal_alignment'] ) ? $this->atts['horizontal_alignment'] : 'pf-details-h-mid';
			$item_classes[] = !empty( $this->atts['vertical_alignment'] ) ? $this->atts['vertical_alignment'] : 'pf-details-v-end';
			$item_classes[] = 'pf-btns-mid';
			$item_classes[] = 'pf-hover-animate-btn';
			$item_classes[] = 'pf-hover-shadow';
			$item_classes[] = 'pf-hover-shadow-alt-2';
			$item_classes[] = 'text-center';
		}
		elseif( 'grid-hover-classic' === $style ) {
			$item_classes[] = 'title-size-26';
			$item_classes[] = !empty( $this->atts['color_type'] ) ? $this->atts['color_type'] : 'lqd-pf-light';
			$item_classes[] = 'pf-details-inside';
			$item_classes[] = 'pf-details-full';
			$item_classes[] = !empty( $this->atts['horizontal_alignment'] ) ? $this->atts['horizontal_alignment'] : 'pf-details-h-mid';
			$item_classes[] = !empty( $this->atts['vertical_alignment'] ) ? $this->atts['vertical_alignment'] : 'pf-details-v-mid';
			$item_classes[] = 'pf-btns-mid';
			$item_classes[] = 'pf-hover-animate-btn';
			$item_classes[] = 'pf-hover-masktext';

		}
		elseif( 'grid-hover-3d' === $style ) {
			$item_classes[] = !empty( $this->atts['color_type'] ) ? $this->atts['color_type'] : 'lqd-pf-light';
			$item_classes[] = 'pf-details-inside';
			$item_classes[] = 'pf-details-full';
			$item_classes[] = 'pf-details-inner-full';
			$item_classes[] = 'title-size-48';
			$item_classes[] = 'hover-3d';
			$item_classes[] = !empty( $this->atts['horizontal_alignment'] ) ? $this->atts['horizontal_alignment'] : 'pf-details-h-mid';
			$item_classes[] = !empty( $this->atts['vertical_alignment'] ) ? $this->atts['vertical_alignment'] : 'pf-details-v-mid';
		}
		elseif( 'grid-caption' === $style ) {
			$item_classes[] = !empty( $this->atts['color_type'] ) ? $this->atts['color_type'] : 'lqd-pf-dark';
			$item_classes[] = 'pf-details-visible';
			$item_classes[] = 'title-size-24';
			$item_classes[] = 'pf-hover-img-border';
		}
		elseif( 'vertical-overlay' === $style ) {
			$item_classes[] = !empty( $this->atts['color_type'] ) ? $this->atts['color_type'] : 'lqd-pf-dark';
			$item_classes[] = 'pf-details-visible';
			$item_classes[] = 'pf-details-boxed';
			$item_classes[] = !empty( $this->atts['horizontal_alignment'] ) ? $this->atts['horizontal_alignment'] : 'pf-details-h-str';
			$item_classes[] = !empty( $this->atts['vertical_alignment'] ) ? $this->atts['vertical_alignment'] : 'pf-details-v-end';
			$item_classes[] = 'pf-details-pull-up';
			$item_classes[] = 'title-size-30';
		}
		elseif( 'packery' === $style ) {
			$item_classes[] = !empty( $this->atts['color_type'] ) ? $this->atts['color_type'] : 'lqd-pf-dark';
			$item_classes[] = 'title-size-30';
			$item_classes[] = 'pf-details-inside';
			$item_classes[] = 'pf-details-full';
			$item_classes[] = !empty( $this->atts['horizontal_alignment'] ) ? $this->atts['horizontal_alignment'] : 'pf-details-h-mid';
			$item_classes[] = !empty( $this->atts['vertical_alignment'] ) ? $this->atts['vertical_alignment'] : 'pf-details-v-mid';
			$item_classes[] = 'pf-hover-masktext';
		}
		elseif( 'packery-2' === $style ) {
			       
			$item_classes[] = !empty( $this->atts['color_type'] ) ? $this->atts['color_type'] : 'lqd-pf-dark';
			$item_classes[] = 'title-size-18';			
			$item_classes[] = 'pf-details-inside';
			$item_classes[] = 'pf-details-boxed';
			$item_classes[] = 'pf-details-circle';
			$item_classes[] = 'pf-details-pull-down';
			$item_classes[] = 'pf-details-pull-left';
			$item_classes[] = 'pf-contents-mid';
			$item_classes[] = !empty( $this->atts['horizontal_alignment'] ) ? $this->atts['horizontal_alignment'] : 'pf-details-h-str';
			$item_classes[] = !empty( $this->atts['vertical_alignment'] ) ? $this->atts['vertical_alignment'] : 'pf-details-v-end';
			$item_classes[] = 'pf-hover-masktext';
		}
		elseif( 'packery-3' === $style ) {
			$item_classes[] = !empty( $this->atts['color_type'] ) ? $this->atts['color_type'] : 'lqd-pf-dark';
			$item_classes[] = 'title-size-26';
			$item_classes[] = 'pf-details-boxed';
			$item_classes[] = 'pf-details-inside';
			$item_classes[] = 'pf-details-w-auto';
			$item_classes[] = !empty( $this->atts['horizontal_alignment'] ) ? $this->atts['horizontal_alignment'] : 'pf-details-h-mid';
			$item_classes[] = !empty( $this->atts['vertical_alignment'] ) ? $this->atts['vertical_alignment'] : 'pf-details-v-mid';
			$item_classes[] = 'pf-hover-masktext';
		}
		
		return join( ' ', $item_classes );
		
	}
	
	protected function get_thumb_size() {

		$size = get_post_meta( get_the_ID(), '_portfolio_image_size', true );

		if( ! empty( $size ) ) {
			return $size;
		}

	}
	
	protected function get_grid_class() {

		$column = $this->atts['grid_columns'];

		if ( !$column ){
			$column = '2';
		}

		$hash = array(
			'1' => '12',
			'2' => '6',
			'3' => '4',
			'4' => '3',
			'6' => '2'
		);

		printf( 'col-md-%s col-sm-6 col-xs-12', $hash[$column] );
	}

	protected function get_column_class() {

		$width = get_post_meta( get_the_ID(), 'portfolio-width', true );

		if ( !empty( $width ) && 'auto' !=  $width ) {
			echo $width;
			return;
		}

		$img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'post-thumbnail' );
		$width = $img[1];

		if( $width > 260 && $width < 370 ) {
			echo '3';
			return;
		}

		if( $width > 360 && $width < 470 ) {
			echo '4';
			return;
		}

		if( $width > 471 && $width < 600 ) {
			echo '5';
			return;
		}

		if( $width > 600 ) {
			echo '6';
			return;
		}
	}
	
	protected function get_parallax() {

		if( 'no' === $this->atts['enable_parallax'] ) {
			return;
		}

		return 'data-responsive-bg="true" data-parallax="true" data-parallax-options=\'{ "parallaxBG": true }\'';
	}
	
	protected function entry_thumbnail( $size = 'full', $bg = false ) {
	
		if ( post_password_required() || is_attachment() ) {
			return;
		}
		
		$format = get_post_format();
		$style  = $this->atts['style'];
		
		$figure_classname = in_array( $style, array( 'metro', 'masonry-creative', 'carousel', 'grid', 'grid-hover-3d', 'grid-hover-alt', 'grid-hover-classic', 'packery', 'packery-2', 'packery-3' ) ) ? 'data-responsive-bg="true"' : '';

		if  ( 'yes' === $this->atts['disable_postformat'] ) {
			$format = 'image';
		}
		
		$thumb_size = $this->get_thumb_size();
		if( ! empty( $thumb_size ) ) {
			$size = $thumb_size;
		}
		
		$image_src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
		$resized_image = liquid_get_resized_image_src( $image_src, $size );
		
		if( 'grid-hover-3d' === $style ) {
			printf( '<figure %s class="transition-none" data-custom-animations="true" data-ca-options=\'{ "triggerHandler": "mouseenter", "triggerRelation": "closest", "triggerTarget": ".lqd-pf-item", "offTriggerHandler": "mouseleave", "ease": "power4.out", "duration": 850, "offDuration": 850, "initValues": { "scale": 1.1 }, "animations": { "scale": 1 } }\'>', $figure_classname );
			liquid_the_post_thumbnail( $size, array( 'class' => 'w-100' ) );
		}
		elseif( 'grid-caption' === $style ) {
				printf( '<figure data-stacking-factor="1" %s %s>', $figure_classname, $this->get_parallax() );
				liquid_the_post_thumbnail( $size, array( 'class' => 'w-100' ) );			
		}
		elseif( 'style05' === $style ) {
				echo '<figure class="bg-cover bg-center h-100" data-responsive-bg="true">';
				liquid_the_post_thumbnail( $size, array( 'class' => 'w-100 invisible' ) );			
		}
		else {
			if( $bg ) {
				printf( '<figure %s %s>', $figure_classname, $this->get_parallax() );
				liquid_the_post_thumbnail( $size, array( 'class' => 'w-100' ) );
			}
			else {
				echo '<figure ' . $figure_classname . '>';
				liquid_the_post_thumbnail( $size, array( 'class' => 'w-100' ) );
			}			
		}
		echo '</figure>';
	
	}
	
	/**
	 * [entry_term_classes description]
	 * @method entry_term_classes
	 * @return [type]             [description]
	 */
	protected function entry_term_classes() {

		$terms = get_the_terms( get_the_ID(), 'liquid-portfolio-category' );
		if( !$terms ) {
			return;
		}
		$terms = wp_list_pluck( $terms, 'slug' );
		echo join( ' ', $terms );

	}

	// AJAX Helpers ------------------------------------------------

	/**
	 * @param $search_string
	 *
	 * @return array
	 */
	public function include_field_search( $search_string ) {
		$query = $search_string;
		$data = array();
		$args = array(
			's' => $query,
			'post_type' => $this->post_type,
		);
		$args['vc_search_by_title_only'] = true;
		$args['numberposts'] = - 1;
		if ( 0 === strlen( $args['s'] ) ) {
			unset( $args['s'] );
		}
		add_filter( 'posts_search', 'vc_search_by_title_only', 500, 2 );
		$posts = get_posts( $args );
		if ( is_array( $posts ) && ! empty( $posts ) ) {
			foreach ( $posts as $post ) {
				$data[] = array(
					'value' => $post->ID,
					'label' => $post->post_title
				);
			}
		}

		return $data;
	}

	/**
	 * @param $data_arr
	 *
	 * @return array
	 */
	function exclude_field_search( $data_arr ) {

		$term = isset( $data_arr['term'] ) ? $data_arr['term'] : '';
		$data = array();
		$args = array(
			's' => $term,
			'post_type' => $this->post_type,
		);
		$args['vc_search_by_title_only'] = true;
		$args['numberposts'] = - 1;
		if ( 0 === strlen( $args['s'] ) ) {
			unset( $args['s'] );
		}
		add_filter( 'posts_search', 'vc_search_by_title_only', 500, 2 );
		$posts = get_posts( $args );
		if ( is_array( $posts ) && ! empty( $posts ) ) {
			foreach ( $posts as $post ) {
				$data[] = array(
					'value' => $post->ID,
					'label' => $post->post_title
				);
			}
		}

		return $data;
	}

	/**
	 * @since 4.5.2
	 *
	 * @param $search_string
	 *
	 * @return array|bool
	 */
	function autocomplete_taxonomies_field_search( $search_string ) {
		$data = array();
		$vc_taxonomies = get_terms( $this->taxonomies, array(
			'hide_empty' => false,
			'search'     => $search_string,
		) );
		if ( is_array( $vc_taxonomies ) && ! empty( $vc_taxonomies ) ) {
			foreach ( $vc_taxonomies as $t ) {
				if ( is_object( $t ) ) {
					$data[] = ld_helper()->get_term_object( $t );
				}
			}
		}

		return $data;
	}

	function render_autocomplete_field( $term ) {
		return ld_helper()->vc_autocomplete_taxonomies_field_render($term, 'liquid-portfolio-category');
	}
}
new LD_PortfolioListing;