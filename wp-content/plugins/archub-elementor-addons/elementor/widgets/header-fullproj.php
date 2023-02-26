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
class LD_Header_Fullproj extends Widget_Base {

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
		return 'ld_header_fullproj';
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
		return __( 'Liquid Header Fullscreen Project', 'archub-elementor-addons' );
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
		return 'eicon-site-identity lqd-element';
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
		return [ 'hub-header' ];
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
		return [ 'header', 'screen', 'project' ];
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
			array(
				'label' => __( 'General', 'archub-elementor-addons' ),
			)
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
			'image',
			[
				'label' => __( 'Image', 'archub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'condition' => [
					'media_type' => 'image'
				]
			]
		);

		$repeater->add_control(
			'text',
			[
				'label' => __( 'Title', 'archub-elementor-addons' ),
				'placeholder' => __( 'Add title', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'sup',
			[
				'label' => __( 'Super text', 'archub-elementor-addons' ),
				'placeholder' => __( 'Add super text', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'subtitle',
			[
				'label' => __( 'Subtitle', 'archub-elementor-addons' ),
				'placeholder' => __( 'Add subtitle', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'link',
			[
				'label' => __( 'URL (Link)', 'archub-elementor-addons' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'archub-elementor-addons' ),
				'show_external' => true,
				'default' => [
					'url' => '#',
				],
				'label_block' => true
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
			]
		);

		$this->add_control(
			'items_align',
			[
				'label' => __( 'Items alignment', 'archub-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'start'    => [
						'title' => __( 'Top', 'archub-elementor-addons' ),
						'icon' => 'eicon-v-align-top',
					],
					'center' => [
						'title' => __( 'Middle', 'archub-elementor-addons' ),
						'icon' => 'eicon-v-align-middle',
					],
					'end' => [
						'title' => __( 'Bottom', 'archub-elementor-addons' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'default' => 'center',
				'toggle' => false,
				'selectors' => [
					'{{WRAPPER}} .lqd-fullproj-scrn-inner' => 'align-items: {{VALUE}}'
				],
				'default' => '',
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'scr_padding',
			[
				'label' => __( 'Padding', 'archub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'vw' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-fullproj-scrn-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' => [
					'top' => 60,
					'right' => 60,
					'bottom' => 60,
					'left' => 60,
					'unit' => 'px',
				],
			]
		);

		$this->add_control(
			'inactive_items_opacity',
			[
				'label' => __( 'Inactive Items Opacity', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-fullproj-menu:hover .lqd-fullproj-title' => 'opacity: {{SIZE}};',
				],
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

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'custom_typography',
				'label' => __( 'Typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-fullproj-menu',
			]
		);

		$this->add_control(
			'overlay_background_heading',
			[
					'label' => esc_html__( 'Overlay background', 'archub-elementor-addons' ),
					'type' => Controls_Manager::HEADING,
					'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'overlay_background',
				'label' => __( 'Background', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .lqd-fullproj-overlay-bg',
			]
		);

		$this->add_control(
			'color',
			[
				'label' => __( 'Link color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-fullproj-menu a' => 'color: {{VALUE}}',
				],
				'separator' => 'before'
			]
		);

		$this->add_control(
			'hover_color',
			[
				'label' => __( 'Link active color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-fullproj-menu li.lqd-is-active a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		ld_el_nav_trigger($this, 'ib_');

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
		$id = uniqid('lqd-trigger-');
		$identities = $settings['identities'];

		if( empty( $identities ) )
			return;

		// classes
		$module_classes = array(
			'module-lqd-fullproj-scrn',
		);
		$fullproj_classes = array( 
			'lqd-fullproj-scrn',
			'overflow-hidden',
			'pos-fix',
			'collapse',
		);
		$trigger_wrap_classes = array( 
			'lqd-fullproj-trigger'
		);
		$i = 0;

		?>

			<div class="<?php echo ld_helper()->sanitize_html_classes( $module_classes ) ?>">

				<div class="<?php echo ld_helper()->sanitize_html_classes( $trigger_wrap_classes ) ?>">
				<?php ld_el_nav_trigger_render( $settings, 'ib_', $id, 'header-fullproj' ); ?>
				</div>

				<div id="<?php echo esc_attr( $id ); ?>" class="<?php echo ld_helper()->sanitize_html_classes( $fullproj_classes ); ?>" data-lqd-fullproj="true" aria-expanded="false">
					
					<span class="lqd-fullproj-loader d-inline-flex pos-abs z-index-3">
						<span class="d-inline-flex border-radius-circle"></span>
					</span>

					<div class="lqd-fullproj-scrn-inner">
					
						<div class="lqd-fullproj-menu h1 mt-0 mb-0">
							<ul class="reset-ul d-flex flex-wrap align-items-center" data-active-onhover="true" data-active-onhover-options='{ "triggerHandlers": ["mouseenter"], "lazyLoadImgVid": true }'>
								
								<?php foreach ( $identities as $item ) { 
									$i++;
									
									$href_atts = '';
									$alt = '';

									if( 'image' !== $item['media_type'] ) {
										$href_atts = ' data-video-trigger=true';
									} else {
										$alt = get_post_meta( $item['image'], '_wp_attachment_image_alt', true );
									}

									$src_attrs = array(
										'img_srcs' => array(
											'src' => 'data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=',
											'src-set' => null,
											'alt' => $alt
										),
										'vid_srcs' => array(
											'mp4' => array(
												'src' => null,
												'data-src' => null
											),
											'webm' => array(
												'src' => null,
												'data-src' => null
											),
										),
									);
				
									if ( $i === 1 ) {
				
										if ( 'image' === $item['media_type'] ) {
											$src_attrs['img_srcs']['src'] = wp_get_attachment_image_url( $item['image']['id'], 'full', false );
										} else {
											$mp4_url = $item['mp4_local_video'];
											$webm_url = $item['webm_local_video'];
											if ( isset($mp4_url) && ! empty($mp4_url) ) {
												$src_attrs['vid_srcs']['mp4']['src'] = $mp4_url;
											}
											if ( isset($webm_url) && ! empty($webm_url) ) {
												$src_attrs['vid_srcs']['webm']['src'] = $webm_url;
											}
										}
				
									} else {
				
										if ( $item['media_type'] === 'image' ) {
											$src_attrs['img_srcs']['data-src'] = wp_get_attachment_image_url( $item['image']['id'], 'full', false );
										} else {
											$mp4_url = $item['mp4_local_video'];
											$webm_url = $item['webm_local_video'];
											if ( isset($mp4_url) && ! empty($mp4_url) ) {
												$src_attrs['vid_srcs']['mp4']['data-src'] = $mp4_url;
											}
											if ( isset($webm_url) && ! empty($webm_url) ) {
												$src_attrs['vid_srcs']['webm']['data-src'] = $webm_url;
											}
										}
				
									}

									$this->add_link_attributes( 'link-' . $i , $item['link'] );

								?>

								<li class="d-inline-flex align-items-center justify-content-between <?php if( $i == 1 ) { echo 'lqd-is-active'; }?> elementor-repeater-item-<?php echo esc_attr( $item['_id'] ); ?>">
									<a class="lqd-fullproj-link <?php if( $i == 1 ) { echo 'active'; } ?>" <?php echo $this->get_render_attribute_string( 'link-' . $i ); ?> <?php echo esc_attr( $href_atts ); ?>>
									
									<?php if( !empty( $item['text'] ) ) { ?>
									<span class="lqd-fullproj-title pos-rel">
										<?php echo esc_html( $item['text'] )?>
										<?php if( !empty( $item['sup'] ) ) { ?>
											<sup class="d-inline-flex align-items-center justify-content-center pos-abs"><?php echo esc_html( $item['sup'] )?></sup>
										<?php } ?>
										<?php if( !empty( $item['subtitle'] ) ) { ?>
											<small><?php echo esc_html( $item['subtitle'] )?></small>
										<?php } ?>
									</span>
									<?php } ?>

									<span class="lqd-fullproj-media lqd-overlay pointer-events-none">
									<?php if( 'image' === $item['media_type'] ) { ?>
										<img <?php echo liquid_helper()->html_attributes($src_attrs['img_srcs']) ?> alt="<?php echo esc_attr( $alt ); ?>">
									<?php } else { ?>
										<video>
											<?php if( !empty( $item['mp4_local_video'] ) ) { ?>
												<source data-src="<?php echo esc_url( $item['mp4_local_video'] ) ?>" type="video/mp4">
											<?php } ?>
											<?php if( !empty( $item['webm_local_video'] ) ) { ?>
												<source data-src="<?php echo esc_url( $item['webm_local_video'] ) ?>" type="video/webm">
											<?php } ?>
										</video>
									<?php } ?>
									<span class="lqd-overlay lqd-fullproj-overlay-bg"></span>
									</span>
								</a>
								</li>
								<?php } ?>

							</ul>
						</div>

					</div>

				</div>
			</div>

		<?php

	}

}
