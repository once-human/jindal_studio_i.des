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
class LD_Images_Text_Overlay extends Widget_Base {

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
		return 'ld_image_text_overlay';
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
		return __( 'Liquid Image Text Overlay', 'archub-elementor-addons' );
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
		return 'eicon-image-rollover lqd-element';
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
		return [ 'image', 'rgb', 'text', 'overlay' ];
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
			return [ 'imagesloaded', 'gsap' ];
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
			array(
				'label' => __( 'Image text overlay', 'archub-elementor-addons' ),
			)
		);

		$this->add_control(
			'image',
			[
				'label' => __( 'Choose Image', 'archub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
			]
		);

		$this->add_control(
			'img_link',
			[
				'label' => __( 'Link', 'archub-elementor-addons' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'archub-elementor-addons' ),
				'show_external' => true,
			]
		);

		$this->add_control(
			'title',
			[
				'label' => __( 'Title', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Japay', 'archub-elementor-addons' ),
				'placeholder' => __( 'Type your title here', 'archub-elementor-addons' ),
			]
		);

		$this->add_control(
			'subtitle',
			[
				'label' => __( 'Subtitle', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Japay App', 'archub-elementor-addons' ),
				'placeholder' => __( 'Type your subtitle here', 'archub-elementor-addons' ),
			]
		);

		$this->add_control(
			'category',
			[
				'label' => __( 'Category', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Mobile app', 'archub-elementor-addons' ),
				'placeholder' => __( 'Type your category here', 'archub-elementor-addons' ),
			]
		);
			
		$this->end_controls_section();

		$this->start_controls_section(
			'reveal_effect_section',
			[
				'label' => __( 'Reveal effect', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'enable_reveal',
			[
				'label' => __( 'Reveal Effect', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'reveal_color',
				'label' => __( 'Background', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .block-revealer__element',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
				'condition' => [
					'enable_reveal' => 'yes'
				]
			]
		);

		$this->add_control(
			'reveal_direction',
			[
				'label' => __( 'Direction', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'lr',
				'options' => [
					'lr' => __( 'Left - Right', 'archub-elementor-addons' ),
					'tb' => __( 'Top - Bottom', 'archub-elementor-addons' ),
					'rl' => __( 'Right - Left', 'archub-elementor-addons' ),
					'bt' => __( 'Bottom - Top', 'archub-elementor-addons' ),
				],
				'condition' => [
					'enable_reveal' => 'yes'
				]
			]
		);

		$this->add_control(
			'reveal_delay',
			[
				'label' => __( 'Dellay in (ms)', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'condition' => [
					'enable_reveal' => 'yes'
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'image_style_section',
			[
				'label' => __( 'Image style', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'image_width',
			[
				'label' => __( 'Image max width', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vw', 'vh' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1170,
						'step' => 1,
					],
					'vw' => [
						'min' => 0,
						'max' => 100,
					],
					'vh' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-iot-img-wrap' => 'max-width: {{SIZE}}{{UNIT}}; flex: 0 0 {{SIZE}}{{UNIT}};',
				],
				'render_type' => 'template',
			]
		);
			
		$this->end_controls_section();

		$this->start_controls_section(
			'title_style_section',
			[
				'label' => __( 'Title style', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Title typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} h2',
			]
		);

		$this->add_control(
			'title_fill_color',
			[
				'label' => __( 'Title fill color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-iot h2' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'title_stroke_size',
			[
				'label' => __( 'Title stroke size', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-iot h2' => '-webkit-text-stroke-width: {{SIZE}}{{UNIT}}; text-stroke-width: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->add_control(
			'title_stroke_color',
			[
				'label' => __( 'Title stroke color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-iot h2' => '-webkit-text-stroke-color: {{VALUE}}; text-stroke-color: {{VALUE}};',
				],
			]
		);
			
		$this->end_controls_section();

		$this->start_controls_section(
			'subtitle_style_section',
			[
				'label' => __( 'Subtitle style', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'subtitle_typography',
				'label' => __( 'Subtitle typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-iot-subtitle h3',
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label' => __( 'Subtitle color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-iot-subtitle h3' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'subtitle_space',
			[
				'label' => __( 'Text space', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'vw', 'vh' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'em' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'vw' => [
						'min' => 0,
						'max' => 100,
					],
					'vh' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-iot-content' => 'margin-inline-end: {{SIZE}}{{UNIT}};',
				],
				'render_type' => 'ui',
			]
		);
			
		$this->end_controls_section();

		$this->start_controls_section(
			'category_style_section',
			[
				'label' => __( 'Category style', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'category_typography',
				'label' => __( 'Category typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-iot-cat',
			]
		);

		$this->add_control(
			'category_color',
			[
				'label' => __( 'Category color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-iot-cat' => 'color: {{VALUE}}',
				],
			]
		);
			
		$this->end_controls_section();

		ld_el_btn($this, 'ib_'); // load button

	}

    protected function get_reveal_data() {
		
		$settings = $this->get_settings_for_display();
		
		$reveal = $settings['enable_reveal'];

		$data = array();

		if( $reveal ) {

			$reveal_opts = array( 'direction' => $settings['reveal_direction'] );
			
			if ( isset( $settings['reveal_delay'] ) && ! empty( $settings['reveal_delay'] ) ) {
				$reveal_opts['delay'] = $settings['reveal_delay'];
			}

			$data[] = 'data-reveal="true"';
			$data[] = 'data-reveal-options=\'' . wp_json_encode( $reveal_opts ) . '\'';

		}

		if ( empty( $data ) ) {
			return;
		}

		return implode( ' ', $data );	

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

			?>
						
            <div class="lqd-iot lqd-iot-type-img pos-rel" data-inview="true" data-hover3d="true" data-inview-options='{ "onImagesLoaded": true }'>
                <div class="lqd-iot-inner d-flex pos-rel perspective">

                    <div class="lqd-iot-img-wrap pos-rel mx-auto transform-style-3d" data-stacking-factor="0.5">

                        <div class="lqd-iot-img pos-rel overflow-hidden">
                            <div class="lqd-iot-img-inner">
                                <figure <?php echo $this->get_reveal_data(); ?>>
                                    <?php echo wp_get_attachment_image( $settings['image']['id'], 'full', false, array( 'class' => 'w-100', 'alt' => esc_attr( $alt = !empty( $settings['title'] ) ? $settings['title'] : '' ) ) ); ?>
                                </figure>
                            </div>
                        </div>

                        <?php if( !empty( $settings['title'] ) ) : ?>
                        <div class="lqd-iot-overlay-txt lqd-overlay d-flex align-items-center justify-content-center overflow-hidden">
                            <div class="lqd-overlay lqd-iot-overlay-txt-inner d-flex align-items-center justify-content-center text-center">
                                <h2 class="m-0"><?php echo esc_html( $settings['title'] ); ?></h2>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if( 'yes' === $settings['show_button'] ) : ?>
                        <div class="lqd-iot-overlay-btn pos-abs justify-content-end z-index-2">
                            <?php $this->get_button() ?>
                        </div>
                        <?php endif; ?>

						<?php if( $settings['img_link']['url'] ) { $this->add_link_attributes( 'link', $settings['img_link'] ); ?>
							<a <?php echo $this->get_render_attribute_string( 'link' ); ?> class="lqd-overlay lqd-iot-link lqd-cc-label-trigger"></a>
						<?php } ?>
                    </div>
                    
                    <?php if( !empty( $settings['subtitle'] ) || !empty( $settings['category'] ) ) : ?>
                    <div class="lqd-iot-content lqd-iot-content-left d-flex align-items-end">
                        <div class="lqd-iot-content-inner d-flex align-items-center">
                            <?php if( !empty( $settings['subtitle'] ) ) : ?>
                            <div class="lqd-iot-subtitle">
                                <h3 class="mt-0 mb-0 me-3 h6"><?php echo esc_html( $settings['subtitle'] ); ?></h3>
                            </div>
                            <?php endif; ?>

                            <?php if( !empty( $settings['category'] ) ) : ?>
                            <div class="lqd-iot-cat">
                                <ul class="reset-ul inline-nav">
                                    <li><?php echo esc_html( $settings['category'] ); ?></li>
                                </ul>
                            </div>
                            <?php endif; ?>

                        </div>
                    </div>
                    <?php endif; ?>

                </div>
            </div>		

			<?php

	}

}
