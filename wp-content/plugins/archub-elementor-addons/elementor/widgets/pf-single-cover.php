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
class LD_Pf_Single_Cover extends Widget_Base {

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
		return 'ld_single_portfolio_cover';
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
		return __( 'Liquid Portfolio Single Cover', 'archub-elementor-addons' );
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
		return 'eicon-folder-o lqd-element';
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
		return [ 'portfolio', 'meta', 'cover' ];
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
			'general_section',
			[
				'label' => __( 'General', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'height',
			[
				'label' => esc_html__( 'Height', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
				],
				'tablet_default' => [
					'unit' => 'px',
				],
				'mobile_default' => [
					'unit' => 'px',
				],
				'size_units' => [ 'px', '%', 'vh' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 500,
					],
					'vh' => [
						'min' => 1,
						'max' => 100,
					],
					'%' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} figure' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} img' => 'height: 100%; object-fit: cover; object-position: center;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'label' => __( 'Typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-pf-single-cover .lqd-pf-single-title',
				'separator' => 'before',
			]
		);

		
		$this->add_control(
			'color',
			[
				'label' => __( 'Heading Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-pf-single-cover .lqd-pf-single-title' => 'color: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'color_link',
			[
				'label' => __( 'Heading Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-pf-single-cover .pf-scroll-down-link' => 'color: {{VALUE}}',
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

		?>
			<div class="lqd-pf-single-cover pos-rel">

				<figure class="lqd-pf-single-cover-img d-flex">
					<?php liquid_the_post_thumbnail( 'liquid-large', array()); ?>
				</figure>

				<div class="lqd-pf-single-cover-title lqd-overlay d-flex align-items-center justify-content-center text-center p-6">
					<?php the_title( '<h1 class="lqd-pf-single-title p-4 mt-0 mb-0">', '</h1>' ); ?>
				</div>

				<div class="lqd-overlay d-flex align-items-end justify-content-center text-center pb-6">
					<a class="pf-scroll-down-link" href="#" data-localscroll="true" data-localscroll-options='{"scrollBelowSection": true}'>
						<i class="lqd-icn-ess icon-ion-ios-arrow-down"></i>
					</a>
				</div>

			</div>
		<?php

	}

}
