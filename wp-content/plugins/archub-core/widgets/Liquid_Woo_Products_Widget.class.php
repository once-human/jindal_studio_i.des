<?php
/**
 * List products. One widget to rule them all.
 *
 * @package WooCommerce/Widgets
 * @version 3.3.0
 */


defined( 'ABSPATH' ) || exit;

/**
 * Widget products.
 */
class Liquid_Woo_Products_Widget extends WC_Widget {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->widget_cssclass    = 'liquid_woocommerce widget_products';
		$this->widget_description = __( "A list of your store's products.", 'woocommerce' );
		$this->widget_id          = 'liquid_woocommerce_products';
		$this->widget_name        = __( 'Liquid Woo Products', 'woocommerce' );
		$this->settings           = array(
			'title'       => array(
				'type'  => 'text',
				'std'   => __( 'Products', 'woocommerce' ),
				'label' => __( 'Title', 'woocommerce' ),
			),
			'number'      => array(
				'type'  => 'number',
				'step'  => 1,
				'min'   => 1,
				'max'   => '',
				'std'   => 5,
				'label' => __( 'Number of products to show', 'woocommerce' ),
			),
			'show'        => array(
				'type'    => 'select',
				'std'     => '',
				'label'   => __( 'Show', 'woocommerce' ),
				'options' => array(
					''         => __( 'All products', 'woocommerce' ),
					'featured' => __( 'Featured products', 'woocommerce' ),
					'onsale'   => __( 'On-sale products', 'woocommerce' ),
				),
			),
			'orderby'     => array(
				'type'    => 'select',
				'std'     => 'date',
				'label'   => __( 'Order by', 'woocommerce' ),
				'options' => array(
					'date'  => __( 'Date', 'woocommerce' ),
					'price' => __( 'Price', 'woocommerce' ),
					'rand'  => __( 'Random', 'woocommerce' ),
					'sales' => __( 'Sales', 'woocommerce' ),
				),
			),
			'order'       => array(
				'type'    => 'select',
				'std'     => 'desc',
				'label'   => _x( 'Order', 'Sorting order', 'woocommerce' ),
				'options' => array(
					'asc'  => __( 'ASC', 'woocommerce' ),
					'desc' => __( 'DESC', 'woocommerce' ),
				),
			),
			'hide_free'   => array(
				'type'  => 'checkbox',
				'std'   => 0,
				'label' => __( 'Hide free products', 'woocommerce' ),
			),
			'show_hidden' => array(
				'type'  => 'checkbox',
				'std'   => 0,
				'label' => __( 'Show hidden products', 'woocommerce' ),
			),
		);

		parent::__construct();
	}

	/**
	 * Query the products and return them.
	 *
	 * @param array $args     Arguments.
	 * @param array $instance Widget instance.
	 *
	 * @return WP_Query
	 */
	public function get_products( $args, $instance ) {
		$number                      = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : $this->settings['number']['std'];
		$show                        = ! empty( $instance['show'] ) ? sanitize_title( $instance['show'] ) : $this->settings['show']['std'];
		$orderby                     = ! empty( $instance['orderby'] ) ? sanitize_title( $instance['orderby'] ) : $this->settings['orderby']['std'];
		$order                       = ! empty( $instance['order'] ) ? sanitize_title( $instance['order'] ) : $this->settings['order']['std'];
		$product_visibility_term_ids = wc_get_product_visibility_term_ids();

		$query_args = array(
			'posts_per_page' => $number,
			'post_status'    => 'publish',
			'post_type'      => 'product',
			'no_found_rows'  => 1,
			'order'          => $order,
			'meta_query'     => array(),
			'tax_query'      => array(
				'relation' => 'AND',
			),
		); // WPCS: slow query ok.

		if ( empty( $instance['show_hidden'] ) ) {
			$query_args['tax_query'][] = array(
				'taxonomy' => 'product_visibility',
				'field'    => 'term_taxonomy_id',
				'terms'    => is_search() ? $product_visibility_term_ids['exclude-from-search'] : $product_visibility_term_ids['exclude-from-catalog'],
				'operator' => 'NOT IN',
			);
			$query_args['post_parent'] = 0;
		}

		if ( ! empty( $instance['hide_free'] ) ) {
			$query_args['meta_query'][] = array(
				'key'     => '_price',
				'value'   => 0,
				'compare' => '>',
				'type'    => 'DECIMAL',
			);
		}

		if ( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
			$query_args['tax_query'][] = array(
				array(
					'taxonomy' => 'product_visibility',
					'field'    => 'term_taxonomy_id',
					'terms'    => $product_visibility_term_ids['outofstock'],
					'operator' => 'NOT IN',
				),
			); // WPCS: slow query ok.
		}

		switch ( $show ) {
			case 'featured':
				$query_args['tax_query'][] = array(
					'taxonomy' => 'product_visibility',
					'field'    => 'term_taxonomy_id',
					'terms'    => $product_visibility_term_ids['featured'],
				);
				break;
			case 'onsale':
				$product_ids_on_sale    = wc_get_product_ids_on_sale();
				$product_ids_on_sale[]  = 0;
				$query_args['post__in'] = $product_ids_on_sale;
				break;
		}

		switch ( $orderby ) {
			case 'price':
				$query_args['meta_key'] = '_price'; // WPCS: slow query ok.
				$query_args['orderby']  = 'meta_value_num';
				break;
			case 'rand':
				$query_args['orderby'] = 'rand';
				break;
			case 'sales':
				$query_args['meta_key'] = 'total_sales'; // WPCS: slow query ok.
				$query_args['orderby']  = 'meta_value_num';
				break;
			default:
				$query_args['orderby'] = 'date';
		}

		return new WP_Query( apply_filters( 'woocommerce_products_widget_query_args', $query_args ) );
	}

	/**
	 * Output widget.
	 *
	 * @param array $args     Arguments.
	 * @param array $instance Widget instance.
	 *
	 * @see WP_Widget
	 */
	public function widget( $args, $instance ) {
		
		if ( $this->get_cached_widget( $args ) ) {
			return;
		}

		ob_start();

		$products = $this->get_products( $args, $instance );
		if ( $products && $products->have_posts() ) {
			$this->widget_start( $args, $instance );

			//echo wp_kses_post( apply_filters( 'woocommerce_before_widget_product_list', '<ul class="product_list_widget">' ) );

			echo '<div class="ld-bsp-carousel">';
			echo '<div class="carousel-container carousel-dots-style2 carousel-dots-mobile-left">';
			echo '<div class="carousel-items row mx-0" data-lqd-flickity=\'{ "prevNextButtons": true, "navArrow": { "prev": "<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"12\" height=\"32\" viewBox=\"0 0 12 32\" style=\"width: 1em; height: 1em;\"><path fill=\"currentColor\" d=\"M3.625 16l7.938 7.938c.562.562.562 1.562 0 2.125-.313.312-.688.437-1.063.437s-.75-.125-1.063-.438L.376 17c-.563-.563-.5-1.5.063-2.063l9-9c.562-.562 1.562-.562 2.124 0s.563 1.563 0 2.125z\"></path></svg>", "next": "<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"12\" height=\"32\" viewBox=\"0 0 12 32\" style=\"width: 1em; height: 1em;\"><path fill=\"currentColor\" d=\"M8.375 16L.437 8.062C-.125 7.5-.125 6.5.438 5.938s1.563-.563 2.126 0l9 9c.562.562.624 1.5.062 2.062l-9.063 9.063c-.312.312-.687.437-1.062.437s-.75-.125-1.063-.438c-.562-.562-.562-1.562 0-2.125z\"></path></svg>"} }\'>';
			
			$template_args = array(
				'widget_id'   => isset( $args['widget_id'] ) ? $args['widget_id'] : $this->widget_id,
				'show_rating' => true,
			);
			
			$number = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : $this->settings['number']['std'];

			$posts_sz = count( $products->posts );
			if( $number > $posts_sz ) {
				$all = $posts_sz;
			} else {
				$all = $number;
			}
			$i = $last = 0;

			while ( $products->have_posts() ) {
				

				
				$products->the_post(); $i++; $last++;
				
				if( $i == 1 ) { 
					echo '<div class="carousel-item px-0 col-xs-12">';
				}
				
				wc_get_template( 'content-product-widget.php', $template_args );
				
				if( $i == 3 || $last == $all ) { 
					echo '</div>'; 
					$i = 0;				
				} 

			}

			
			echo '</div><!-- /.carousel-items row -->';
			echo '</div><!-- /.carousel-container -->';
			echo '</div><!-- /.ld-bsp-carousel -->';	


			//echo wp_kses_post( apply_filters( 'woocommerce_after_widget_product_list', '</ul>' ) );

			$this->widget_end( $args );
		}

		wp_reset_postdata();

		echo $this->cache_widget( $args, ob_get_clean() ); // WPCS: XSS ok.
	}
}