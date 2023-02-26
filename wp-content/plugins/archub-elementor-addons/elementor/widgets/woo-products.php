<?php
namespace LiquidElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Utils;
use Elementor\Control_Media;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor heading widget.
 *
 * Elementor widget that displays an eye-catching headlines.
 *
 * @since 1.0.0
 */
class LD_Woo_Products extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve heading widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ld_woo_products';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve heading widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Liquid Woo Products Carousel', 'archub-elementor-addons' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve heading widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-posts-carousel lqd-element';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the heading widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'hub-woo' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'woocommerce', 'product', 'carousel', 'slider' ];
	}

	/**
	 * Retrieve the list of scripts the counter widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {

		if ( liquid_helper()->liquid_elementor_script_depends() ){
			return [ 'flickity' ];
		} else {
			return [''];
		}
		
	}

	/**
	 * Register heading widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {

		// General Section
		$this->start_controls_section(
			'general_section',
			[
				'label' => __( 'General', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'taxonomies',
			[
				'label' => __( 'Categories', 'archub-elementor-addons' ),
				'description' => __( 'Show products only from these categories', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => $this->get_available_categories(),
			]
		);

		$this->add_control(
			'orderby',
			[
				'label' => __( 'Order by', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'rand'  => __( 'Rand', 'archub-elementor-addons' ),
					'date'  => __( 'Date', 'archub-elementor-addons' ),
					'price'  => __( 'Price', 'archub-elementor-addons' ),
					'popularity'  => __( 'Popularity', 'archub-elementor-addons' ),
					'rating'  => __( 'Rating', 'archub-elementor-addons' ),
					'title'  => __( 'Title', 'archub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label' => __( 'Order', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'desc',
				'options' => [
					'ASC' => __( 'Ascending', 'archub-elementor-addons' ),
					'DESC' => __( 'Descending', 'archub-elementor-addons' ),
				],
				'condition' => [
					'orderby' => [ 'date', 'price', 'title' ],
				],
			]
		);

		$this->add_control(
			'show',
			[
				'label' => __( 'Show', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'All Products', 'archub-elementor-addons' ),
					'featured' => __( 'Featured Products', 'archub-elementor-addons' ),
					'onsale' => __( 'On-sale Products', 'archub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'limit',
			[
				'label' => __( 'Limit', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => '8',
				'placeholder' => __( 'Set product limit', 'archub-elementor-addons' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'colors_section',
			[
				'label' => __( 'Style', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs(
			'colors_tabs'
		);

		$this->start_controls_tab(
			'colors_normal_tab',
			[
				'label' => __( 'Normal', 'archub-elementor-addons' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'arrow_background',
				'label' => __( 'Background', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .flickity-button',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
			]
		);
		$this->add_control(
			'arrow_color',
			[
				'label' => __( 'Arrow Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .flickity-button' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'colors_hover_tab',
			[
				'label' => __( 'Hover', 'archub-elementor-addons' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'hover_arrow_background',
				'label' => __( 'Background', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .flickity-button:hover',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
			]
		);
		$this->add_control(
			'hover_arrow_color',
			[
				'label' => __( 'Arrow Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .flickity-button:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	protected function get_available_categories() {
	
		$taxonomies = get_categories(  
			array( 
				'taxonomy' => 'product_cat',
				'orderby' => 'name',
			)
		);

		$options = [ '' => '' ];

		foreach ( $taxonomies as $taxonomy ) {
			$options[ $taxonomy->cat_ID ] = $taxonomy->name;
		}

		return $options;
	}

	/**
	 * Render heading widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		
		$settings = $this->get_settings_for_display();

		// check
		if( !liquid_helper()->is_woocommerce_active() ) {
			return;
		}

		extract( $settings );

		global $wpdb, $product;


		//query args
		$args = array(
			'posts_per_page' => intval( $limit ) ? intval( $limit ) : 12,
			'post_type'      => 'product',
			'post_status'    => 'publish',
		);

		if ( $taxonomies ) {

			$args['tax_query'] = array(
				array(
					'taxonomy' => 'product_cat',
					'field'    => 'id',
					'terms'    => $taxonomies
				)
			);
		}

		$args['meta_query']   = array();
		$args['meta_query'][] = WC()->query->stock_status_meta_query();
		$args['meta_query']   = array_filter( $args['meta_query'] );

		// default - menu_order
		$args['orderby'] = 'menu_order title';
		$args['order'] = $order == 'DESC' ? 'DESC' : 'ASC';
		$args['meta_key'] = '';

		switch ( $orderby ) {
			case 'rand' :
				$args['orderby'] = 'rand';
			break;
			case 'date' :
				$args['orderby'] = 'date';
				$args['order'] = $order == 'ASC' ? 'ASC' : 'DESC';
			break;
			case 'price' :
				$args['orderby'] = "meta_value_num {$wpdb->posts}.ID";
				$args['order'] = $order == 'DESC' ? 'DESC' : 'ASC';
				$args['meta_key'] = '_price';
			break;
			case 'popularity' :
				$args['meta_key'] = 'total_sales';
				// Sorting handled later though a hook
				add_filter('posts_clauses', 'liquid_woocommerce_order_by_popularity_post_clauses');
			break;
			case 'rating' :
				// Sorting handled later though a hook
				add_filter('posts_clauses', 'liquid_woocommerce_order_by_rating_post_clauses');
			break;
			case 'title' :
				$args['orderby'] = 'title';
				$args['order'] = $order == 'DESC' ? 'DESC' : 'ASC';
			break;
		}

		switch ( $show ) {
			case 'featured' :
				$args['meta_query'][] = array(
					'key'   => '_featured',
					'value' => 'yes'
				);
			break;
			case 'onsale' :
				$product_ids_on_sale   = wc_get_product_ids_on_sale();
				$product_ids_on_sale[] = 0;
				$args['post__in']      = $product_ids_on_sale;
			break;
		}

		$products_query = new \WP_Query( $args );

		if( !$products_query->have_posts() ) {
			return '';
		}

		$origin = is_rtl()  ? 'right' : 'left';
		$carousel_item_classname = array(
			'carousel-item',
			'd-flex',
			'flex-column',
			'justify-content-center',
			'w-100',
			'flex-grow-1',
		);

		?>
		<div class="ld-bsp-carousel">
			<div class="carousel-container carousel-dots-style2 carousel-dots-mobile-left">
				<div
					class="carousel-items pos-rel"
					data-lqd-flickity='{
						"imagesLoaded": true,
						"adaptiveHeight": true,
						"prevNextButtons": true,
						"navArrow": {
							"prev": "<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"12\" height=\"32\" viewBox=\"0 0 12 32\" style=\"width: 1em; height: 1em;\"><path fill=\"currentColor\" d=\"M3.625 16l7.938 7.938c.562.562.562 1.562 0 2.125-.313.312-.688.437-1.063.437s-.75-.125-1.063-.438L.376 17c-.563-.563-.5-1.5.063-2.063l9-9c.562-.562 1.562-.562 2.124 0s.563 1.563 0 2.125z\"></path></svg>",
							"next": "<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"12\" height=\"32\" viewBox=\"0 0 12 32\" style=\"width: 1em; height: 1em;\"><path fill=\"currentColor\" d=\"M8.375 16L.437 8.062C-.125 7.5-.125 6.5.438 5.938s1.563-.563 2.126 0l9 9c.562.562.624 1.5.062 2.062l-9.063 9.063c-.312.312-.687.437-1.062.437s-.75-.125-1.063-.438c-.562-.562-.562-1.562 0-2.125z\"></path></svg>"
						}
					}'>
					<div class="flickity-viewport pos-rel w-100 overflow-hidden">
						<div class="flickity-slider d-flex w-100 h-100" style="<?php echo esc_attr( $origin ); ?>: 0; transform: translateX(0%);">
							
							<?php

								$posts_sz = count( $products_query->posts );
								if( $limit > $posts_sz ) {
									$all = $posts_sz;
								} else {
									$all = $limit;
								}
							?>
							<?php $i = $last = 0; ?>
							<?php

								while ( $products_query->have_posts() ) :

									$products_query->the_post(); $i++; $last++;
									$product = new \WC_Product( get_the_ID() );
							?>		
							<?php

								if( $i == 1 ) { 
									echo '<div class="' . ld_helper()->sanitize_html_classes( $carousel_item_classname ) . '" style="flex: 0 0 auto;"><div class="carousel-item-inner pos-rel w-100"><div class="carousel-item-content pos-rel w-100">';
								}
							?>
							<?php
									if( function_exists( 'wc_get_template' ) ) { 
										wc_get_template( 'content-product-widget.php' );			
									}
							?>
							<?php

								if( $i == 3 || $last == $all ) { 
									echo '</div></div></div>'; 
									$i = 0;				
								} 

							?>
							<?php
								endwhile; // end of the loop.
								
								wp_reset_postdata();
									
								remove_filter('posts_clauses', 'liquid_woocommerce_order_by_popularity_post_clauses');
								remove_filter('posts_clauses', 'liquid_woocommerce_order_by_rating_post_clauses');

							?>
				</div>
			</div>
		</div>
		<?php
		
	}

}
