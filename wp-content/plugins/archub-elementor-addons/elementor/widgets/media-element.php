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
class LD_Media_Element extends Widget_Base {

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
		return 'ld_media_element';
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
		return __( 'Liquid Media Elements (Gallery)', 'archub-elementor-addons' );
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
		return 'eicon-gallery-group lqd-element';
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
			return [ 'packery-mode', 'jquery-fresco' ];
		} else {
			return [''];
		}
		
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
		return [ 'media', 'image' ];
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

		$this->add_responsive_control(
			'columns_gap',
			[
				'label' => __( 'Columns gap', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw', 'vh' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'vw' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'vh' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} .ld-media-row' => 'margin-inline-start: -{{SIZE}}{{UNIT}}; margin-inline-end: -{{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .masonry-item' => 'padding-inline-start: {{SIZE}}{{UNIT}}; padding-inline-end: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'bottom_gap',
			[
				'label' => __( 'Bottom gap', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw', 'vh' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'vw' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'vh' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} .masonry-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->add_control(
			'enable_lightbox_caption',
			[
				'label' => __( 'Enable Lightbox Caption?', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => __( 'Typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .ld-media-txt h3',
			]
		);
		$this->end_controls_section();

		
		$this->start_controls_section(
			'items_section',
			[
				'label' => __( 'Items', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
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
			'subtitle', [
				'label' => __( 'Subtitle', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Title' , 'archub-elementor-addons' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'vertical_alignment',
			[
				'label' => __( 'Vertical Alignment', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => true,
				'default' => 'justify-content-center',
				'options' => [
					'justify-content-center'  => __( 'Center', 'archub-elementor-addons' ),
					'justify-content-end'  => __( 'Bottom', 'archub-elementor-addons' ),
				],
			]
		);

		$repeater->add_control(
			'image',
			[
				'label' => __( 'Choose Image', 'archub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'link_type',
			[
				'label' => __( 'Link Type', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'label_block' => true,
				'options' => [
					'default'  => __( 'Default', 'archub-elementor-addons' ),
					'image'  => __( 'Image', 'archub-elementor-addons' ),
					'video'  => __( 'Youtube', 'archub-elementor-addons' ),
					'iframe'  => __( 'Iframe', 'archub-elementor-addons' ),
				],
			]
		);

		$repeater->add_control(
			'link',
			[
				'label' => __( 'Link', 'archub-elementor-addons' ),
				'type' => Controls_Manager::URL,
				'label_block' => true,
				'placeholder' => __( 'https://your-link.com', 'archub-elementor-addons' ),
				'show_external' => true,
				'default' => [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		);

		
		$repeater->add_control(
			'add_icon',
			[
				'label' => __( 'Add Icon', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$repeater->add_control(
			'icon_type',
			[
				'label' => __( 'Border Style', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'zoom',
				'options' => [
					'zoom' => __( 'Zoom', 'archub-elementor-addons' ),
					'plus' => __( 'Plus', 'archub-elementor-addons' ),
					'video' => __( 'Video', 'archub-elementor-addons' ),
					'video2' => __( 'Video 2', 'archub-elementor-addons' ),
					'audio' => __( 'Audio', 'archub-elementor-addons' ),
				],
				'condition' => [
					'add_icon' => 'yes',
				]
			]
		);

		$repeater->add_control(
			'visible_content',
			[
				'label' => __( 'Content Visible', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$repeater->add_control(
			'shadow_content',
			[
				'label' => __( 'Shadow on hover', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$repeater->add_responsive_control(
			'width',
			[
				'label' => __( 'Width (Column)', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 1200,
						'step' => 1,
					],
					'%' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'width: {{SIZE}}{{UNIT}};',
				],
				'render_type' => 'template',
				'separator' => 'before',
			]
		);

		$repeater->add_responsive_control(
			'custom_height',
			[
				'label' => __( 'Element Height', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw', 'vh' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 500,
						'step' => 1,
					],
					'%' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
					'vw' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
					'vh' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} {{CURRENT_ITEM}} .ld-media-item, {{WRAPPER}} {{CURRENT_ITEM}} figure, {{WRAPPER}} {{CURRENT_ITEM}} img' => 'height: 100%;',
				],
				'render_type' => 'template'
			]
		);

		$this->add_control(
			'items',
			[
				'label' => __( 'Items', 'archub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
			]
		);

		$this->end_controls_section();

		// General Style
		$this->start_controls_section(
			'general_style_section',
			[
				'label' => __( 'General', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'color',
			[
				'label' => __( 'Text Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ld-media-item-overlay' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'overlay_bg',
				'label' => __( 'Background', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .ld-media-bg',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
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

		$wrapper_classes = array( 
			'ld-media-row',
			'd-flex',
			'flex-wrap',
		);

		$gallery_id = uniqid('gallery-');
	
		?>

		<div id="ld-media-<?php echo esc_attr( $this->get_id() ); ?>" class="<?php echo ld_helper()->sanitize_html_classes( $wrapper_classes ); ?>" data-liquid-masonry="true">
			
			<?php foreach ($settings['items'] as $item) : ?>
			<div class="masonry-item elementor-repeater-item-<?php echo esc_attr( $item['_id'] ); ?>">

				<div class="ld-media-item pos-rel overflow-hidden <?php echo esc_attr( !empty($item['visible_content']) ? 'contents-visible' : '' );?> <?php echo esc_attr( !empty($item['shadow_content']) ? 'shadow-onhover' : '' );?>">

					<figure class="bg-cover">
						<?php echo wp_get_attachment_image( $item['image']['id'], 'full', false, array( 'class' => 'w-100 objfit-cover objpos-center', 'alt' => esc_attr( $alt = !empty( $item['title'] ) ? $item['title'] : '' ) ) ); ?>
					</figure>

					<div class="ld-media-item-overlay d-flex flex-column align-items-center lqd-overlay text-center <?php echo esc_attr( $item['vertical_alignment'] ); ?>">

						<div class="ld-media-bg lqd-overlay"></div>

						<div class="ld-media-content pos-rel z-index-2">
							<div class="ld-media-txt">
								<h3 class="m-0"><?php echo esc_html( $item['title'] ); ?></h3>
								<h6 class="m-0 text-uppercase ltr-sp-135"><?php echo esc_html( $item['subtitle'] ); ?></h6>
								<?php 
									$enable = $item['add_icon'];
									if( 'yes' === $enable ) {
																			
										$icon = $item['icon_type'];
										$out = '';
										
										switch( $icon ) {
											
											case 'image':
											default:
												
												$out = '<span class="ld-media-icon d-inline-flex align-items-center justify-content-center">
															<span class="ld-media-icon-inner">
																<i class="lqd-icn-ess icon-ld-search"></i>
															</span>
														</span>';
											break;
											
											case 'plus':
												
												$out = '<span class="ld-media-icon d-inline-flex align-items-center justify-content-center" style="font-size: 44px;">
															<span class="ld-media-icon-inner">
																<i class="lqd-icn-ess icon-ion-ios-add"></i>
															</span>
														</span>';

											break;
											
											case 'video':
												
												$out = '<span class="ld-media-icon icon-play bordered d-inline-flex align-items-center justify-content-center border-radius-circle">
															<span class="ld-media-icon-inner d-flex align-items-center justify-content-center">
																<i class="lqd-icn-ess icon-ion-ios-play"></i>
															</span>
														</span>';
											break;

											case 'video2':
												
												$out = '<span class="ld-media-icon icon-play solid size-lg d-inline-flex align-items-center justify-content-center border-radius-circle">
															<span class="ld-media-icon-inner d-flex align-items-center justify-content-center">
																<i class="lqd-icn-ess icon-ion-ios-play"></i>
															</span>
														</span>';

											break;
											
											case 'audio':
											
												$out = '<span class="ld-media-icon">
															<span class="ld-media-icon-inner">
																<i class="lqd-icn-ess icon-lqd-volume-high"></i>
															</span>
														</span>';
											break;					
										}

										echo $out;
									}

								?>
							</div>
						</div>

					</div>

					<?php
					
					$link = $out = $data_caption = '';
					$link_type = $item['link_type'];
					
					if( $settings['enable_lightbox_caption'] ) {
						$data_caption = 'data-fresco-caption="' . $item['title'] . '"';	
					};
					
					
					if( 'image' === $link_type ) {
						$link = wp_get_attachment_url( $item['image']['id'] );
						$out = '<a href="' . esc_url( empty($link) ? '$': $link ) . '" class="lqd-overlay z-index-2 fresco" ' . $data_caption . ' data-fresco-group="'. esc_attr( $gallery_id ) .'"></a>';
					}
					elseif( 'video' === $link_type ) {
						$out = '<a ' . ld_helper()->elementor_link_attr( $item['link'] ). ' class="lqd-overlay z-index-2 fresco" ' . $data_caption . ' data-fresco-group="'. esc_attr( $gallery_id ) .'"></a>';
					}
					elseif( 'iframe' === $link_type ) {
						$out = '<a ' . ld_helper()->elementor_link_attr( $item['link'] ) . ' class="lqd-overlay z-index-2" ' . $data_caption . ' data-lqd-lity="iframe"></a>';
					}
					else {
						$out = '<a ' . ld_helper()->elementor_link_attr( $item['link'] ) . ' class="lqd-overlay z-index-2"></a>';
					}
					
					echo $out;


					?>

				</div>

			</div>
			<?php endforeach; ?>

		</div>



		<?php
		
	}

}
