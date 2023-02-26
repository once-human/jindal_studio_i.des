<?php
namespace LiquidElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Schemes\Color;
use Elementor\Schemes\Typography;
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
class LD_Pf_Single_Related extends Widget_Base {

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
		return 'ld_single_portfolio_related';
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
		return __( 'Liquid Portfolio Single Related', 'archub-elementor-addons' );
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
		return 'eicon-posts-grid lqd-element';
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
		return [ 'hub-portfolio' ];
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
		return [ 'portfolio', 'related', 'post' ];
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

		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'archub-elementor-addons' ),
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label' => esc_html__( 'Title Element Tag', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
					'span' => 'span',
					'p' => 'p',
				],
				'default' => 'h2',
			]
		);

		$this->add_control(
			'use_inheritance',
			[
				'label' => __( 'Inherit font styles?', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'true',
			]
		);

		$this->add_control(
			'tag_to_inherite',
			[
				'label' => esc_html__( 'Element Tag', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'p' => 'p',
				],
				'default' => 'h1',
				'condition' => [
					'use_inheritance' => 'true',
				],
			]
		);

		$this->add_control(
			'one_category',
			[
				'label' => __( 'Show Only One Post Meta', 'archub-elementor-addons' ),
				'description' => __( 'Enable to show one category/tag', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'heading',
			[
				'label' => __( 'Styles', 'archub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typo',
				'label' => __( 'Title Typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-pf-single-related-title',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Title Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-pf-single-related-title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'category_typo',
				'label' => __( 'Category Typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-pf-cat a',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'category_color',
			[
				'label' => __( 'Category Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-pf-cat a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	
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

		$related_posts = false;
		if( function_exists( 'liquid_get_post_type_related_posts' ) ) {
			$related_posts = liquid_get_post_type_related_posts( get_the_ID(), 6, 'liquid-portfolio', 'liquid-portfolio-category' );	
		}

		if( !$related_posts ) {
			return;
		}

		$origin = is_rtl() ? 'right' : 'left';

		?>
			
			<div class="lqd-pf-grid lqd-pf-related-projects">

				<div class="lqd-pf-row carousel-container carousel-nav-floated carousel-nav-center carousel-nav-middle carousel-nav-square carousel-nav-solid carousel-nav-lg carousel-nav-appear-onhover">

					<div class="carousel-items  pos-rel" data-lqd-flickity='{ "wrapAround": true, "prevNextButtons": true, "navArrow": 6, "navOffsets": {"nav": { "top": "35%" }, "prev": "15px", "next": "15px" } }'>
						<div class="flickity-viewport pos-rel w-100 overflow-hidden">
							<div class="flickity-slider d-flex w-100 h-100" style="<?php echo $origin ?>: 0; transform: translateX(0%);">

								<?php while( $related_posts->have_posts() ): $related_posts->the_post(); ?>

								<div class="lqd-pf-column carousel-item d-flex flex-column justify-content-center col-xs-6 col-sm-4 col-md-3">

									<div class="carousel-item-inner pos-rel w-100">
										<div class="carousel-item-content pos-rel w-100">

											<div class="lqd-pf-item lqd-pf-item-style-2 pos-rel mb-2 mt-2">
												<div class="lqd-pf-item-inner">
								
													<div class="lqd-pf-img mb-3 pos-rel border-radius-6 overflow-hidden">

														<figure>
															<?php echo liquid_the_post_thumbnail( 'liquid-portfolio-sq', array( 'class' => 'w-100' ), false ); ?>
														</figure>

														<span class="lqd-pf-overlay-bg lqd-overlay d-flex align-items-center justify-content-center">
															<i class="lqd-icn-ess icon-md-arrow-forward"></i>
														</span>
													</div>
								
													<div class="lqd-pf-details">
														<?php the_title( sprintf( '<%1$s class="lqd-pf-single-related-title mt-0 mb-1 %2$s"><a href="%3$s" rel="bookmark">', $settings['title_tag'], $settings['tag_to_inherite'] ? $settings['tag_to_inherite'] : 'h5', esc_url( get_permalink() ) ), sprintf( '</a></%s>' , $settings['title_tag']) ) ?>
														<?php
															$terms = get_the_terms( get_the_ID(), 'liquid-portfolio-category' );
															$term = $terms[0];
															if( isset( $term ) ) {
																if( 'yes' === $settings['one_category'] ) {
																	echo '<ul class="reset-ul inline-ul lqd-pf-cat pos-rel z-index-2"><li><a href="' . get_term_link( $term->slug, 'liquid-portfolio-category' ) . '">' . esc_html( $term->name ) . '</a></li></ul>';
																} else {
																	echo '<ul class="reset-ul inline-ul lqd-pf-cat lqd-lp-cat pos-rel z-index-2">';
																	foreach( $terms as $t ) {
																		printf('<li><a href="%s">%s</a></li>', get_term_link( $t->slug, $t->taxonomy ), $t->name );
																	}
																	echo '</ul>';
																}
															}
														?>
													</div>
								
													<a href="<?php the_permalink() ?>" class="lqd-pf-overlay-link lqd-overlay z-index-1"></a>
								
												</div>
											</div>

										</div>
									</div>
									
								</div>

								<?php endwhile; ?>

							</div>
						</div>
					</div>

				</div>
			</div>
		<?php wp_reset_postdata();

	}

}
