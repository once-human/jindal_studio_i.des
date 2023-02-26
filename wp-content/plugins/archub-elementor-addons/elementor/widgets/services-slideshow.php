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
class LD_Services_Slideshow extends Widget_Base {

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
		return 'ld_services_slideshow';
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
		return __( 'Liquid Services Slideshow', 'archub-elementor-addons' );
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
		return 'eicon-post-slider lqd-element';
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
		return [ 'hub-core' ];
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
		return [ 'services', 'slide' ];
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
		
		return [''];
		
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

		$repeater = new Repeater();

		$repeater->add_control(
			'title', [
				'label' => esc_html__( 'Title', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'subtitle', [
				'label' => esc_html__( 'Subtitle', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'description', [
				'label' => esc_html__( 'Description', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXTAREA,
			]
		);

		$repeater->add_control(
			'image',
			[
				'label' => esc_html__( 'Image', 'archub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'items',
			[
				'label' => esc_html__( 'Slides', 'archub-elementor-addons' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'title' => esc_html__( 'Functional', 'archub-elementor-addons' ),
						'subtitle' => esc_html__( 'Functional Interior Design', 'archub-elementor-addons' ),
						'description' => esc_html__( 'Through a unique combination of engineering, construction and design disciplines and expertise.', 'archub-elementor-addons' ),
					],
					[
						'title' => esc_html__( 'Residential', 'archub-elementor-addons' ),
						'subtitle' => esc_html__( 'Residential Interior Design', 'archub-elementor-addons' ),
						'description' => esc_html__( 'Through a unique combination of engineering, construction and design disciplines and expertise.', 'archub-elementor-addons' ),
					],
					[
						'title' => esc_html__( 'Schematic', 'archub-elementor-addons' ),
						'subtitle' => esc_html__( 'Schematic Interior Design', 'archub-elementor-addons' ),
						'description' => esc_html__( 'Through a unique combination of engineering, construction and design disciplines and expertise', 'archub-elementor-addons' ),
					],
					[
						'title' => esc_html__( 'Renovation', 'archub-elementor-addons' ),
						'subtitle' => esc_html__( 'Renovation Interior Design', 'archub-elementor-addons' ),
						'description' => esc_html__( 'Through a unique combination of engineering, construction and design disciplines and expertise', 'archub-elementor-addons' ),
					],
				],
				'title_field' => '{{{ title }}}',
			]
		);

		$this->add_responsive_control(
			'image_width',
			[
				'label' => esc_html__( 'Image width (px)', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1440,
						'step' => 1,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 460,
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-services-slideshow-img img' => 'width: {{SIZE}}{{UNIT}};',
				],
				'render_type' => 'template',
			]
		);

		$this->end_controls_section();

		// start controls section

		$this->start_controls_section(
			'style_section',
			[
				'label' => __( 'Style', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Title color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} h2:after' => 'color: {{VALUE}};',
					'{{WRAPPER}} h2:before' => 'text-stroke-color: {{VALUE}}; -webkit-text-stroke-color: {{VALUE}};',
				],
				'separator' => 'before'
			]
		);

		$this->add_control(
			'title_active_color',
			[
				'label' => esc_html__( 'Title active color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} h2:after' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} h2',
			]
		);

		$this->add_responsive_control(
			'title_outline_size',
			[
				'label' => esc_html__( 'Title outline size', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 20,
						'step' => 1,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 2,
				],
				'selectors' => [
					'{{WRAPPER}} h2:before' => 'text-stroke-width: {{SIZE}}{{UNIT}}; -webkit-text-stroke-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label' => esc_html__( 'Subtitle color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} h4' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'subtitle_typography',
				'selector' => '{{WRAPPER}} h4',
			]
		);

		$this->add_control(
			'description_color',
			[
				'label' => esc_html__( 'Description color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} p' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography',
				'selector' => '{{WRAPPER}} p',
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

		$image_carousel_id = esc_attr( uniqid('lqd-services-slideshow-img-') );
		$title_carousel_id = esc_attr( uniqid('lqd-services-slideshow-title-') );
		$desc_carousel_id = esc_attr( uniqid('lqd-services-slideshow-desc-') );

		$i = 1;

		if ( $settings['items'] ) :
        ?>

		<div class="lqd-services-slideshow text-center">

			<div class="lqd-services-slideshow-top mb-5 pb-5 pos-rel">

				<div class="carousel-container lqd-services-slideshow-img">
					<div id="<?php echo $image_carousel_id; ?>" class="carousel-items" data-lqd-flickity='{ "pageDots": false, "forceDisablePageDots": true, "draggable": false, "cellAlign": "center", "groupCells": false, "fade": true, "skipWrapItems": true, "wrapAround": true, "asNavFor": "#<?php echo $title_carousel_id ?>" }'>
						<div class="flickity-viewport pos-rel w-100 overflow-hidden">
							<div class="flickity-slider d-flex w-100 h-100 pos-rel" style="left: 0; transform: translateX(0%);">
							<?php foreach ( $settings['items'] as $item ) : ?>
								<div class="carousel-item w-100 flex-auto elementor-repeater-item-<?php echo esc_attr( $item['_id'] ) ?>">
									<img class="mx-auto" src="<?php echo esc_url( $item['image']['url'] ) ?>" alt="<?php echo esc_html( $item['subtitle'] ) ?>">
								</div>
							<?php endforeach; ?>
							</div>
						</div>
					</div>
				</div>

				<div class="carousel-container lqd-services-slideshow-title lqd-overlay d-flex flex-wrap align-items-center lqd-fade-sides">
					<div id="<?php echo $title_carousel_id; ?>" class="carousel-items d-flex align-items-center w-100 h-100" data-lqd-flickity='{ "pageDots": false, "forceDisablePageDots": true, "cellAlign": "center", "groupCells": false, "skipWrapItems": true, "wrapAround": true }'>
						<div class="flickity-viewport pos-rel w-100 overflow-hidden">
							<div class="flickity-slider d-flex w-100 h-100 pos-rel" style="left: 0; transform: translateX(0%);">
							<?php foreach ( $settings['items'] as $item ) : ?>
								<div class="carousel-item d-flex flex-auto h-100 align-items-center justify-content-center <?php echo $i === 1 ? 'is-selected' : ''; ?> elementor-repeater-item-<?php echo esc_attr( $item['_id'] ); ?>">
									<h2 class="m-0 pos-rel" data-text="<?php echo esc_html( $item['title'] ); ?>"><?php echo esc_html( $item['title'] ); ?></h2>
								</div>
							<?php $i++; endforeach; ?>
							</div>
						</div>
					</div>
				</div>

			</div>

			<div class="carousel-container lqd-services-slideshow-desc mt-5 pt-5 mx-auto">
				<div id="<?php echo $desc_carousel_id; ?>" class="carousel-items" data-lqd-flickity='{ "pageDots": false, "forceDisablePageDots": true, "draggable": false, "cellAlign": "center", "groupCells": false, "fade": true, "skipWrapItems": true, "wrapAround": true, "asNavFor": "#<?php echo $title_carousel_id ?>" }'>
					<div class="flickity-viewport pos-rel w-100 overflow-hidden">
						<div class="flickity-slider d-flex w-100 h-100 pos-rel" style="left: 0; transform: translateX(0%);">
							<?php foreach ( $settings['items'] as $item ) : ?>
								<div class="carousel-item w-100 flex-auto elementor-repeater-item-<?php echo esc_attr( $item['_id'] ) ?>">
									<h4 class="mt-0 mb-4"><?php echo esc_html( $item['subtitle'] ); ?></h4>
									<p><?php echo esc_html( $item['description'] ); ?></p>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>

		</div>

        <?php
		endif;
   
	}

}
