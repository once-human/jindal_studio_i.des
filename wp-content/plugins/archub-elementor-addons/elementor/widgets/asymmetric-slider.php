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
class LD_Asymmetric_Slider extends Widget_Base {

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
		return 'ld_asymmetric_slider';
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
		return __( 'Liquid Asymmetric Slider', 'archub-elementor-addons' );
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
		return 'eicon-slider-video lqd-element';
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
		return [ 'frame', 'image', 'slider' ];
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
				'default' => __( 'Subtitle' , 'archub-elementor-addons' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'description', [
				'label' => __( 'Text', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( 'Text' , 'archub-elementor-addons' ),
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
			'btn_label', [
				'label' => __( 'Button label', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Button Label' , 'archub-elementor-addons' ),
				'label_block' => true,
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
					'url' => '#',
					'is_external' => false,
					'nofollow' => false,
				],
			]
		);

		$this->add_control(
			'identities',
			[
				'label' => __( 'Items', 'archub-elementor-addons' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'title' => __( 'Title', 'archub-elementor-addons' ),
						'subtitle' => __( 'Subtitle', 'archub-elementor-addons' ),
						'description' => __( 'Text', 'archub-elementor-addons' ),
						'image' => Utils::get_placeholder_image_src(),
						'btn_label' => __( 'Button Label', 'archub-elementor-addons' ),
						'url' => __( '#', 'archub-elementor-addons' ),
					],
					[
						'title' => __( 'Title 2', 'archub-elementor-addons' ),
						'subtitle' => __( 'Subtitle 2', 'archub-elementor-addons' ),
						'description' => __( 'Text 2', 'archub-elementor-addons' ),
						'image' => Utils::get_placeholder_image_src(),
						'btn_label' => __( 'Button Label 2', 'archub-elementor-addons' ),
						'url' => __( '#', 'archub-elementor-addons' ),
					],
				],
				'title_field' => '{{{ title }}}',
			]
		);

		$this->add_control(
		 'autoplay',
		 [
		   'label'   => esc_html__( 'Autoplay time', 'archub-elementor-addons' ),
		   'type'    => Controls_Manager::NUMBER
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
				'name' => 'title_typography',
				'label' => __( 'Title typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-asym-slider-content h2',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_num_typography',
				'label' => __( 'Title number typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-asym-slider-content .text-outline',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'subtitle_typography',
				'label' => __( 'Subtitle typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-asym-slider-content h4',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'text_typography',
				'label' => __( 'Text typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-asym-slider-content p',
			]
		);

		$this->add_control(
			'color',
			[
				'label' => __( 'Title color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .lqd-asym-slider-content h2' => 'color: {{VALUE}}',
					'{{WRAPPER}} .lqd-asym-slider-content .text-outline' => 'text-stroke-color: {{VALUE}}; -webkit-text-stroke-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label' => __( 'Subtitle color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-asym-slider-content h4' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => __( 'Text color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-asym-slider-content p' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'stroke_color',
			[
				'label' => __( 'Stroke color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-asym-slider-content hr' => 'color: {{VALUE}}',
				],
			]
		);

		// content padding
		$this->add_responsive_control(
			'content_padding',
			[
				'label' => __( 'Content padding', 'archub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .lqd-asym-slider-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->end_controls_section();

		ld_el_btn($this, 'ib_');
	}

	// Button Functions 
	protected function get_button() {
		
		extract( $this->get_settings_for_display() );
		$ib_link = isset($ib_link['url']) ? $ib_link['url'] : '';
		$ib_i_icon = isset($ib_icon['value']) ? $ib_icon['value'] : '';

		$ib_classes = array( 
			'elementor-button',
			'btn',
			'align-items-center',
			'justify-content-center',
			'pos-rel',
			'overflow-hidden',
			'ws-nowrap',
			$ib_style,
			$ib_i_separator,
			$ib_hover_txt_effect,
			$ib_style === 'btn-solid' ? $ib_hover_bg_effect : '',
			$ib_border_w,
		
			($ib_link_type === 'lightbox') ? 'fresco' : '',
			
			//Icon Classes
			$ib_i_position,
			$ib_i_shape,
			$ib_i_shape !== '' && $ib_i_shape_style !== '' ? $ib_i_shape_size : '',
			$ib_i_shape !== '' && $ib_i_shape_style !== '' ? 'btn-icon-shaped' : '',
			$ib_i_shape_style,	
			$ib_i_shape_bw,	
			$ib_i_ripple,
			$ib_i_add_icon === 'true' && ($ib_i_position === 'btn-icon-left' || $ib_i_position === 'btn-icon-right') ? $ib_i_hover_reveal : '',
			!empty( $ib_title ) ? 'btn-has-label' : 'btn-no-label',
		);

	 if ($show_button === 'yes'){	

		$txt_class = array(
			'btn-txt',
			'd-block',
			'pos-rel',
			'z-index-3',
			'btn-hover-txt-switch btn-hover-txt-switch-x' === $ib_hover_txt_effect ||
			'btn-hover-txt-switch btn-hover-txt-switch-y' === $ib_hover_txt_effect ? 'overflow-hidden' : '',
		);

		$data_text = $ib_title;

		if ( $ib_hover_txt_effect === 'btn-hover-txt-switch-change btn-hover-txt-switch btn-hover-txt-switch-y' && ! empty($ib_title_secondary) ) {
			$data_text = $ib_title_secondary;
		}

		$ib_attributes['href'] = trim($ib_link);
		$ib_attributes['class'] = ld_helper()->sanitize_html_classes( $ib_classes );

		if( !empty( $ib_image_caption ) ) {
			$ib_attributes['data-fresco-caption'] = $ib_image_caption;
		} 

		if( 'modal_window' === $ib_link_type ) {
			$ib_attributes['data-lqd-lity'] = isset( $ib_anchor_id ) ? esc_url( $ib_anchor_id ) : '#modal-box';
			$ib_attributes['href'] = isset( $ib_anchor_id ) ? esc_url( $ib_anchor_id ) : '#modal-box';
		}
		elseif( 'local_scroll' === $ib_link_type ) {
			$ib_attributes['data-localscroll'] = true;
			$ib_attributes['href'] = isset( $ib_anchor_id ) ? esc_url( $ib_anchor_id ) : '#';
			if( !empty( $ib_scroll_speed ) ) {
				$ib_attributes['data-localscroll-options'] = wp_json_encode( array( 'scrollSpeed' => $ib_scroll_speed ) );	
			}
			
		}
		elseif( 'scroll_to_section' === $ib_link_type ) {
			$ib_attributes['data-localscroll'] = true;
			if( !empty( $ib_scroll_speed ) ) {
				$ib_attributes['data-localscroll-options'] = wp_json_encode( array( 'scrollBelowSection' => true, 'scrollSpeed' => $ib_scroll_speed ) );	
			}
			else {
				$ib_attributes['data-localscroll-options'] = wp_json_encode( array( 'scrollBelowSection' => true ) );	
			}
			
			$ib_attributes['href'] = '#';
		}?>
		<a <?php echo ld_helper()->html_attributes( $ib_attributes ) ?> >
			<?php if( !empty( $ib_title ) ) { ?>
				<span class="<?php echo ld_helper()->sanitize_html_classes( $txt_class ) ?>" data-text="<?php echo esc_attr( $data_text ) ?>" <?php $this->get_hover_text_opts(); ?>>
					<?php
						if(
							'btn-hover-txt-switch btn-hover-txt-switch-x' === $ib_hover_txt_effect ||
							'btn-hover-txt-switch btn-hover-txt-switch-y' === $ib_hover_txt_effect ||
							'btn-hover-txt-switch-change btn-hover-txt-switch btn-hover-txt-switch-y' === $ib_hover_txt_effect
						) {
					?>
						<span class="btn-txt-inner d-inline-flex align-items-center justify-content-center"  data-text="<?php echo esc_attr( $data_text ) ?>">
							<?php echo wp_kses_post( do_shortcode( $ib_title ) ); ?>
						</span>
					<?php } else { ?>
						<?php echo wp_kses_post( do_shortcode( $ib_title ) ); ?>
					<?php } ?>
				</span>
			<?php } ?>
			<?php
				if( $ib_i_icon ) {
					printf( '<span class="btn-icon pos-rel z-index-3"><i class="%s"></i></span>', $ib_i_icon );
				}
				if( 'btn-hover-swp' === $ib_i_hover_reveal ) {
					printf( '<span class="btn-icon pos-rel z-index-3"><i class="%s"></i></span>', $ib_i_icon );
				}
				if( 'yes' === $ib_extended_lines && 'btn-solid' === $ib_style ) {
					foreach (['tl', 'tr', 'br', 'bl'] as $side) { ?>
						<i class="btn-extended-line btn-extended-line-<?php echo $side ?> d-inline-block pos-abs pointer-events-none"></i>
					<?php }
				}
			?>
		</a>
		<?php

		}
	}
	
	protected function get_border() {

		$style = $this->get_settings_for_display('ib_style');
		
		if( 'btn-naked' === $style || 'btn-underlined' === $style ) {
			return;
		}

		$border = $this->get_settings_for_display('ib_border');

		if ( 'btn-solid' === $style ) {
			return $border;	
		}
		
		return "btn-bordered $border";	
	}

	protected function get_hover_text_opts() {
		
		$effect = $this->get_settings_for_display('ib_hover_txt_effect');
		if( empty( $effect ) ) {
			return;
		}

		$start_delay = 0;
		$out = '';
		
		switch( $effect ) {
			
			case 'btn-hover-txt-liquid-x':
			case 'btn-hover-txt-liquid-x-alt':
			case 'btn-hover-txt-liquid-y':
			case 'btn-hover-txt-liquid-y-alt':
				$out = 'data-split-text="true" data-split-options=\'{"type": "chars, words"}\'';
				break;

			default:
				$out = '';
				break;

		}

		echo $out;

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
		$wrapper_attrs = [
			'id' => 'lqd-asym-slider-' . $this->get_id(),
			'class' => "lqd-asym-slider",
			'data-asym-slider' => true,
		];
		$autoplay = $settings['autoplay'];

		if ( !empty( $autoplay ) ) {
			$wrapper_attrs['data-asym-options'] = wp_json_encode([
				'autoplay' => $autoplay
			]);
		}

		$this->add_render_attribute('wrapper', $wrapper_attrs);

		?>

		<div <?php $this->print_render_attribute_string('wrapper') ?>>
			<div class="lqd-asym-slider-inner">

				<div class="container ps-0 pe-0">
					<div class="lqd-asym-slider-t pos-rel z-index-3">
						<div class="lqd-asym-slider-content d-flex flex-wrap align-items-center justify-content-between">
							<div class="lqd-asym-slider-title-wrap d-flex w-100 pos-rel">
	
								<?php $i = 0; foreach ( $settings['identities'] as $item ) {   
									if( !empty( $item['title'] ) ) { 
								?>
									<div class="lqd-asym-slider-title w-100 <?php echo esc_attr($i); echo esc_attr($i === 0 ? ' active' : ''); ?>">
										<h2 class="mt-0 mb-0 h1" data-fittext="true" data-fittext-options='{"compressor": 0.4, "maxFontSize": "currentFontSize"}'>
											<span class="d-block" data-split-text="true" data-split-options='{ "type": "chars, words" }'><?php echo esc_html($item['title']); ?></span>
											<span class="d-block text-outline" data-split-text="true" data-split-options='{ "type": "chars, words" }'>/<?php echo esc_html(($i + 1) < 10 ? '0' . ($i + 1) : ($i + 1)); ?></span>
										</h2>
									</div>
								<?php } $i++; } ?>
	
							</div>
							<div class="lqd-asym-slider-info-wrap d-flex w-100 pos-rel">
	
								<?php $i = 0; foreach ( $settings['identities'] as $item ) { ?>
									<div class="lqd-asym-slider-info w-100 <?php echo $i === 0 ? 'active' : ''; ?>">
										<?php if( isset( $item['subtitle'] ) ) { ?>
										<h4 class="mt-0 mb-0"><?php echo esc_html($item['subtitle']); ?></h4>
										<hr class="mt-3 mb-3">
										<?php } ?>
										<?php if( isset( $item['description'] ) ) { ?>
										<p class="h4 mt-0 mb-0"><?php echo wp_kses_post($item['description']); ?></p>
										<?php } ?>
									</div>
								<?php $i++; 
									} ?>
	
							</div>
						</div>
					</div>
				</div>

				<div class="lqd-asym-slider-b pos-rel">
					<div class="lqd-asym-slider-img-wrap pos-rel overflow-hidden">

						<?php $i = 0; foreach ( $settings['identities'] as $item ) { ?>
							<div class="lqd-asym-slider-img w-100 pos-rel overflow-hidden <?php echo $i === 0 ? 'active' : ''; ?>">
								<div class="lqd-asym-slider-img-inner w-100 overflow-hidden">
									<?php if( !empty( $item['image']['id'] ) ) { ?>
									<figure class="mt-0 mb-0 w-100">
										<?php echo wp_get_attachment_image( $item['image']['id'], 'full', false, array( 'class' => 'w-100 objfit-cover objpos-center', 'alt' => esc_attr( $alt = !empty( $item['title'] ) ? $item['title'] : '' ) ) ); ?>
									</figure>
									<?php } ?>
								</div>
								<div class="lqd-asym-slider-btn-wrap d-inline-flex pos-abs pos-bl z-index-2 overflow-hidden">
									<div class="lqd-asym-slider-btn">
										<?php $this->get_button( $item['btn_label'], $item['url'] ); ?>
									</div>
								</div>
							</div>
						<?php $i++; } ?>

					</div>

					<div class="lqd-asym-slider-arrows d-flex pos-abs pos-tr z-index-3">
						<button class="lqd-asym-slider-arrow lqd-asym-slider-prev pos-rel">
							<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" style="height: 1em;"><path d="M26.688 14.664H10.456l7.481-7.481L16 5.313 5.312 16 16 26.688l1.87-1.87-7.414-7.482h16.232v-2.672z" fill="currentColor"></path></svg>
						</button>
						<button class="lqd-asym-slider-arrow lqd-asym-slider-next pos-rel">
							<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" style="height: 1em;"><path d="M5.313 17.336h16.231l-7.481 7.481L16 26.687 26.688 16 16 5.312l-1.87 1.87 7.414 7.482H5.312v2.672z" fill="currentColor"></path></svg>
						</button>
					</div>

				</div>

			</div>
		</div>

		<?php
		
	}

}
