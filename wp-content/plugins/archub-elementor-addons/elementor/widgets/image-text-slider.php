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
class LD_Image_Text_Slider extends Widget_Base {

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
		return 'ld_imgtxt_slider';
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
		return __( 'Liquid Image + Text Slider', 'elementor' );
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
		return 'eicon-featured-image lqd-element';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the heading widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since 2.0.0
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
	 * @since 2.1.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'heading', 'title', 'text' ];
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
	public function get_style_depends() {

		if ( liquid_helper()->liquid_elementor_script_depends() ){
			return [ 'fresco', 'jquery-ytplayer' ];
		} else {
			return [''];
		}
		
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
			return [ 'jquery-ytplayer', 'wp-mediaelement' ];
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
			'general_section',
			[
				'label' => __( 'General', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'media_type',
			[
				'label' => __( 'Media Type', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'image',
				'options' => [
					'image' => __( 'Image', 'archub-elementor-addons' ),
					'local_video' => __( 'Video (Local)', 'archub-elementor-addons' ),
					'yt_video' => __( 'Video (Youtube)', 'archub-elementor-addons' ),
				],
			]
		);

		$repeater->add_control(
			'mp4_local_video',
			[
				'label' => __( 'Local Video (mp4)', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'condition' => [
					'media_type' => 'local_video'
				],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'webm_local_video',
			[
				'label' => __( 'Local Video (webm)', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'condition' => [
					'media_type' => 'local_video'
				],
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'yt_video_url',
			[
				'label' => __( 'Youtube Link', 'archub-elementor-addons' ),
				'placeholder' => __( 'Add YouTube link', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'https://www.youtube.com/watch?v=cVEemOmHw9Y',
				'condition' => [
					'media_type' => 'yt_video'
				],
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
				'condition' => [
					'media_type' => 'image'
				]
			]
		);

		$repeater->add_control(
			'text',
			[
				'label' => __( 'Text', 'archub-elementor-addons' ),
				'placeholder' => __( 'Add text', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'url',
			[
				'label' => __( 'URL (Link)', 'archub-elementor-addons' ),
				'placeholder' => __( 'Add link', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
			]
		);


		$this->add_control(
			'identities',
			[
				'label' => __( 'Identities', 'archub-elementor-addons' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ text }}}',
				'label_block' => true,
				'default' => [
					[
						'text' => __( 'Title #1', 'archub-elementor-addons' ),
						'image' =>  Utils::get_placeholder_image_src(),
					],
				],
			]
		);

		$this->add_responsive_control(
			'items_margin',
			[
				'label' => __( 'Item margin', 'archub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-imgtxt-slider-nav li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'hover_style',
			[
				'label' => __( 'Hover Style', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Default', 'archub-elementor-addons' ),
					'lqd-imgtxt-slider-fade' => __( 'Fade', 'archub-elementor-addons' ),
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'blend_mode',
			[
				'label' => __( 'Blend Mode', 'archub-elementor-addons' ),
				'description' => __( 'Select blend mode for the hover state of the link', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'normal',
				'options' => [
					'normal' => 'normal',
					'multiply' => 'multiply',
					'screen' => 'screen',
					'overlay' => 'overlay',
					'darken' => 'darken',
					'lighten' => 'lighten',
					'color-dodge' => 'color-dodge',
					'color-burn' => 'color-burn',
					'hard-light' => 'hard-light',
					'soft-light' => 'soft-light',
					'difference' => 'difference',
					'exclusion' => 'exclusion',
					'hue' => 'hue',
					'saturation' => 'saturation',
					'color' => 'color',
					'luminosity' => 'luminosity'
				],
				'selectors' => [
					'{{WRAPPER}} lqd-imgtxt-slider .lqd-imgtxt-slider-nav a:hover' => 'mix-blend-mode: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Title Typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-imgtxt-slider-nav',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'style_section',
			[
				'label' => __( 'Style', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'color',
			[
				'label' => __( 'Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#555555',
				'selectors' => [
					'{{WRAPPER}} .lqd-imgtxt-slider-link' => 'color: {{VALUE}}',
					'{{WRAPPER}} .lqd-imgtxt-slider-link:before' => '-webkit-text-stroke-color: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'hover_color',
			[
				'label' => __( 'Hover Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-imgtxt-slider-link:hover' => 'color: {{VALUE}}',
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

		$classes = array( 
			'lqd-imgtxt-slider',
			'pos-rel',
			'text-center',
			$settings['hover_style'],
		);

		?>

			<div id="<?php echo esc_attr( 'lqd-imgtxt-slider-' . $this->get_id() ); ?>" class="<?php echo ld_helper()->sanitize_html_classes( $classes ); ?>">
				<div class="lqd-imgtxt-slider-inner" data-active-onhover="true" data-active-onhover-options='{ "triggers": ".lqd-imgtxt-slider-nav a", "targets": ".lqd-imgtxt-slider-images .lqd-imgtxt-slider-img" }'>

					<div class="lqd-imgtxt-slider-images lqd-overlay z-index-1 pointer-events-none">
						
						<?php foreach ( $settings['identities'] as $key => $item ) { ?>
						
						<div class="lqd-imgtxt-slider-img elementor-repeater-item-<?php echo esc_attr( $item['_id'] ); ?>">
							<figure class="w-100">
							<?php if( 'image' == $item['media_type'] ) { ?>
								<?php echo wp_get_attachment_image( $item['image']['id'], 'full', false ); ?>
							<?php } elseif( 'local_video' == $item['media_type'] ) { ?>
								<video class="w-100" data-video-bg="true" autoplay loop playsinline muted>
									<?php if( !empty( $item['mp4_local_video'] ) ) { ?>
										<source src="<?php echo esc_url( $item['mp4_local_video'] ); ?>" type="video/mp4">
									<?php } ?>
									<?php if( !empty( $item['webm_local_video'] ) ) { ?>
										<source src="<?php echo esc_url( $item['webm_local_video'] ); ?>" type="video/webm">
									<?php } ?>
								</video>
							<?php } elseif( 'yt_video' == $item['media_type'] ) { ?>
								<div
									data-video-bg="true"
									data-youtube-options='{ "videoURL": "<?php echo esc_url( $item['yt_video_url'] ); ?>" }'
								></div>
							<?php } ?>
							</figure>
						</div>
						<?php } ?>
						
					</div>

					<nav class="lqd-imgtxt-slider-nav h4 d-inline-flex">

						<ul class="reset-ul d-inline-flex flex-column align-items-center">
							
							<?php foreach ( $settings['identities'] as $key => $item ) { ?>
							<li class="d-inline-flex elementor-repeater-item-<?php echo esc_attr( $item['_id'] ); ?>">
								<a
								href="<?php echo $url = ( !empty( $item['url'] ) ? esc_url( $item['url'] ) : '#' ); ?>"
								class="lqd-imgtxt-slider-link d-block pos-rel z-index-2"
								data-text="<?php echo esc_html( $item['text'] ); ?>">
									<span><?php echo wp_kses_post( $item['text'] ); ?></span>
								</a>
							</li>
							<?php } ?>				

						</ul>
					</nav>
					
				</div>
			</div>

		<?php
		
	}

}
