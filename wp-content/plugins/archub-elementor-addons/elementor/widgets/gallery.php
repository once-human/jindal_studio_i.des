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
class LD_Gallery extends Widget_Base {

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
		return 'ld_gallery';
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
		return __( 'Liquid Gallery', 'archub-elementor-addons' );
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
		return 'eicon-gallery-grid lqd-element';
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
		return [ 'gallery', 'image' ];
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
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'General', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'gallery',
			[
				'label' => __( 'Add Images', 'archub-elementor-addons' ),
				'type' => Controls_Manager::GALLERY,
				'default' => [],
			]
		);

		$this->add_control(
			'lightbox',
			[
				'label' => esc_html__( 'Enable Lightbox', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'archub-elementor-addons' ),
				'label_off' => esc_html__( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'separator' => 'before'
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
		$el_id = uniqid( 'lqd-image-gallery-' );

		$origin = is_rtl() ? 'right' : 'left';

		?>

		<div class="lqd-img-gal">

			<div class="lqd-img-gal-imgs">

				<div class="carousel-container pos-rel carousel-nav-floated carousel-nav-center carousel-nav-middle carousel-nav-lg carousel-nav-solid carousel-nav-circle carousel-nav-appear-onhover carousel-dots-mobile-inside">
					<div class="carousel-items pos-rel" data-lqd-flickity='{ "prevNextButtons": true, "navArrow": "6", "parallax": true, "adaptiveHeight": true }' id="<?php echo esc_attr( $el_id ) ?>main-carousel">

						<div class="flickity-viewport pos-rel w-100 overflow-hidden">
							<div class="flickity-slider d-flex w-100 h-100 pos-rel" style="<?php echo esc_attr( $origin ); ?>: 0; transform: translateX(0%);">

								<?php foreach ( $settings['gallery'] as $image ) : ?>
								<div class="carousel-item d-flex flex-column justify-content-center w-100 flex-auto has-one-child">
									<div class="carousel-item-inner pos-rel w-100">
										<div class="carousel-item-content pos-rel w-100">
											<figure class="w-100">
												<?php 
													echo wp_get_attachment_image( $image['id'], 'full', false, array('class' => 'w-100') );
													if ( $settings['lightbox'] === 'yes' ){
														printf( '<a href="%s" data-fresco-group="%s" target="_blank" rel="nofollow" class="fresco d-block lqd-overlay z-index-3"></a>', esc_url( $image['url'] ), esc_attr( 'lqd-gallery-' . $this->get_id() ) );
													}
												?>
											</figure>
										</div>
									</div>
								</div>
								<?php endforeach; ?>

							</div>
						</div>
					</div>
				</div>

			</div>

			<div class="lqd-img-gal-thumbs">

				<div class="carousel-container">
					<div class="carousel-items pos-rel" data-lqd-flickity='{ "contain": false, "pageDots": false, "asNavFor": "#<?php echo esc_attr( $el_id ); ?>main-carousel" }'>

						<div class="flickity-viewport pos-rel w-100 overflow-hidden">
							<div class="flickity-slider d-flex w-100 h-100" style="<?php echo esc_attr( $origin ); ?>: 0; transform: translateX(0%);">

								<?php foreach ( $settings['gallery'] as $image ) : ?>
								<div class="carousel-item d-flex flex-column justify-content-center flex-auto has-one-child">
									<div class="carousel-item-inner pos-rel w-100">
										<div class="carousel-item-content pos-rel w-100">
											<figure class="w-100 pos-rel">
												<?php 
													echo wp_get_attachment_image( $image['id'], array( 160, 70 ), false, array('class' => 'w-100 h-100 objfit-cover objfit-center') );
													if ( $settings['lightbox'] === 'yes' ){
														printf( '<a href="%s" data-fresco-group="%s" target="_blank" rel="nofollow" class="fresco d-block lqd-overlay z-index-3"></a>', esc_url( $image['url'] ), esc_attr( 'lqd-gallery-' . $this->get_id() . '-t' ) );
													}
												?>
											</figure>
										</div>
									</div>
								</div>
								<?php endforeach; ?>

							</div>
						</div>
					</div>
				</div>

			</div>

		</div>

		<?php
		
	}

}
