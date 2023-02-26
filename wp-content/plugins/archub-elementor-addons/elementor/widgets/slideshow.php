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
 * @since 1.0.1
 */
class LD_Slideshow extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve heading widget name.
	 *
	 * @since 1.0.1
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ld_slideshow';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve heading widget title.
	 *
	 * @since 1.0.1
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Liquid Slideshow', 'archub-elementor-addons' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve heading widget icon.
	 *
	 * @since 1.0.1
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-slideshow lqd-element';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the heading widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since 1.0.1
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
	 * @since 1.0.1
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'slide', 'slider', 'carousel' ];
	}

	/**
	 * Retrieve the list of scripts the counter widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.0.1
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
	 * @since 1.0.1
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
			'columns',
			[
				'label' => __( 'Number of columns', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 10,
						'step' => 0.5,
					],
				],
			'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 3,
					'unit' => 'px',
				],
				'tablet_default' => [
					'size' => 2,
					'unit' => 'px',
				],
				'mobile_default' => [
					'size' => 1,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .carousel-item' => 'width: calc(100% / {{SIZE}}); flex: 0 0 calc(100% / {{SIZE}});',
				],
			]
		);

		$this->add_control(
			'lqd_slideshow_draggable',
			[
				'label' => __( 'Draggable', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'separator' => 'before'
			]
		);

		$this->add_control(
			'lqd_slideshow_loop',
			[
				'label' => __( 'Loop', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'lqd_slideshow_arrows',
			[
				'label' => __( 'Show arrows', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'title', [
				'label' => __( 'Title', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Title' , 'archub-elementor-addons' ),
				'label_block' => true,
			]
		);
		
		$repeater->add_control(
			'description', [
				'label' => __( 'Description', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Description' , 'archub-elementor-addons' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'image',
			[
				'label' => __( 'Image', 'archub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'url',
			[
				'label' => __( 'URL (link)', 'archub-elementor-addons' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'archub-elementor-addons' ),
				'show_external' => true,
				'default' => [
					'url' => '',
				],
			]
		);

		$repeater->add_control(
			'btn_label', [
				'label' => __( 'Button label', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Button' , 'archub-elementor-addons' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'identities',
			[
				'label' => __( 'Slides', 'archub-elementor-addons' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[],[],
				],
				'title_field' => '{{{ title }}}',
				'separator' => 'before'
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'style_section',
			[
				'label' => __( 'General', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Title typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-slsh h2',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Title color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-slsh h2' => 'color: {{VALUE}}',
				],
				'separator' => 'after',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'desc_typography',
				'label' => __( 'Description typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-slsh p',
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label' => __( 'Description color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-slsh p' => 'color: {{VALUE}}',
				],
				'separator' => 'after',
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'label' => __( 'Button typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-slsh .btn',
			]
		);

		$this->add_control(
			'button_color',
			[
				'label' => __( 'Button color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-slsh .btn' => 'color: {{VALUE}}',
				],
				'separator' => 'after',
			]
		);

		$this->add_control(
			'overlay_bg',
			[
				'label' => __( 'Overlay background', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-slsh-overlay-bg' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'item_inner_padding',
			[
				'label' => __( 'Cells padding', 'archub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-slsh-content-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Render heading widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.1
	 * @access protected
	 */
	protected function render() {
		
		$settings = $this->get_settings_for_display();
		$origin = is_rtl() ? 'right' : 'left';

		?>

		<div id="lqd-slsh-<?php echo $this->get_id() ?>" class="lqd-slsh"  data-active-onhover="true" data-active-onhover-options='{ "triggerHandlers": ["mouseenter"], "triggers": ".carousel-container .carousel-item", "targets": ".lqd-slsh-img-container .lqd-slsh-img-full" }'>

		<div class="carousel-container carousel-nav-floated carousel-nav-top carousel-nav-lg carousel-nav-square carousel-nav-solid">

			<div class="carousel-items pos-rel z-index-2" data-lqd-flickity='{ "draggable": <?php echo $settings['lqd_slideshow_draggable'] === 'yes' ? 'true' : 'false' ?>, "prevNextButtons": <?php echo $settings['lqd_slideshow_arrows'] === 'yes' ? 'true' : 'false' ?>, "wrapAround": <?php echo $settings['lqd_slideshow_loop'] === 'yes' ? 'true' : 'false' ?>, "equalHeightCells": true, "groupCells": false, "navArrow": 6, "buttonsAppendTo": "#lqd-slsh-<?php echo $this->get_id() ?>" }'>

				<div class="flickity-viewport pos-rel w-100 overflow-hidden">
					<div class="flickity-slider d-flex w-100 h-100" style="<?php echo $origin ?>: 0; transform: translateX(0%);">

						<?php 
						if ( $settings['identities'] ) {
							
							$i = 1; 
							foreach ( $settings['identities'] as $slide ) { 
							
						?>

						<div class="carousel-item d-flex flex-column justify-content-center">
							<div class="carousel-item-inner pos-rel w-100">
								<div class="carousel-item-content pos-rel w-100">

									<div
									class="lqd-slsh-item pos-rel w-100 h-pt-150"
									data-active-onhover="true"
									data-active-onhover-options='{ "triggers": "self" }'
									data-slideelement-onhover="true"
									data-slideelement-options='{ "visibleElement": "h2", "hiddenElement": "p, .lqd-slsh-btn" }'>
										
										<?php if( isset( $slide['image']['url'] ) ) { ?>
										<div class="lqd-slsh-img lqd-overlay">
											<figure class="w-100 ">
												<?php
													
													$alt    = get_post_meta( $slide['image']['id'], '_wp_attachment_image_alt', true );
													$image  = wp_get_attachment_image( $slide['image']['id'], 'full', false, array( 'class' => 'lqd-overlay objfit-cover objpos-center', 'alt' => esc_attr( $alt ) ) );
													
													echo $image;

												?>
											</figure>
											<div class="lqd-slsh-overlay-bg lqd-overlay"></div>
										</div>
										<?php } ?>
										<div class="lqd-slsh-content lqd-overlay d-flex flex-column justify-content-end ps-3 pe-3 pt-4 pb-4">
											<div class="lqd-slsh-content-inner pos-rel ps-3 pe-3 pt-2 pb-2">
												<h2 class="lqd-slsh-h-org m-0 pos-rel"><?php echo esc_html( $slide['title'] ); ?></h2>
												
												<?php if( !empty( $slide['description'] ) ) { ?>
												<p class="mt-3 pos-rel"><?php echo $slide['description'] ?></p><?php } ?>
												
												<?php if( isset( $slide['url']['url'] ) && !empty( $slide['url']['url'] ) ) { ?>
												<div class="lqd-slsh-btn mt-4 pos-rel">
													<a <?php echo ld_helper()->elementor_link_attr($slide['url']); ?> class="btn btn-naked btn-hover-swp">
														<span class="btn-txt"><?php echo $slide['btn_label'] ?></span>
														<span class="btn-icon">
															<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" style="height: 1em;"><path fill="currentColor" d="M17.806 25.788l8.631-8.375c.375-.363.563-.857.563-1.4v-.025c0-.544-.188-1.038-.563-1.4l-8.63-8.375c-.75-.782-1.957-.782-2.7 0s-.745 2.043 0 2.825L20.293 14H6.919C5.856 14 5 14.894 5 16c0 1.125.856 2 1.912 2h13.375L15.1 22.963a2.067 2.067 0 0 0 0 2.824c.75.782 1.956.782 2.706 0z"></path></svg>
														</span>
														<span class="btn-icon">
															<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" style="height: 1em;"><path fill="currentColor" d="M17.806 25.788l8.631-8.375c.375-.363.563-.857.563-1.4v-.025c0-.544-.188-1.038-.563-1.4l-8.63-8.375c-.75-.782-1.957-.782-2.7 0s-.745 2.043 0 2.825L20.293 14H6.919C5.856 14 5 14.894 5 16c0 1.125.856 2 1.912 2h13.375L15.1 22.963a2.067 2.067 0 0 0 0 2.824c.75.782 1.956.782 2.706 0z"></path></svg>
														</span>
													</a>
												</div>
												<?php } ?>

												
											</div>
										</div>

										<?php if( !empty( $slide['url']['url'] ) ) { ?>
											<a <?php echo ld_helper()->elementor_link_attr($slide['url']); ?> class="liquid-overlay-link lqd-overlay z-index-3"></a>
										<?php } ?>

									</div>

								</div>
							</div>
						</div>

						<?php $i++; } } ?>
				
					</div>
				</div>
			</div>

			<div class="lqd-slsh-img-container lqd-overlay">
			
			<?php foreach ( $settings['identities'] as $slide ) { ?>

				<figure class="lqd-slsh-img-full lqd-overlay">
				<?php
				
				if( isset( $slide['image']['url'] ) ) { 
					
					$alt    = get_post_meta( $slide['image']['id'], '_wp_attachment_image_alt', true );
					$image  = wp_get_attachment_image( $slide['image']['id'], 'full', false, array( 'class' => 'objfit-cover objpos-center lqd-overlay', 'alt' => esc_attr( $alt ) ) );
					
					echo $image;

				}

				?>
				</figure>
				
			<?php } ?>


			</div>

		</div>

		</div>

		<?php
		
	}

}
