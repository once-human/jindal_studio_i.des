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
class LD_Price_Table extends Widget_Base {

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
		return 'ld_price_table';
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
		return __( 'Liquid Price Table', 'archub-elementor-addons' );
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
		return 'eicon-price-table lqd-element';
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
		return [ 'price', 'table' ];
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

		$this->add_control(
			'template',
			[
				'label' => __( 'Style', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'style01',
				'options' => [
					'style01' => __( 'Style 1', 'archub-elementor-addons' ),
					'style02' => __( 'Style 2', 'archub-elementor-addons' ),
					'style03' => __( 'Style 3', 'archub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'title',
			[
				'label' => __( 'Title', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Title', 'archub-elementor-addons' ),
				'placeholder' => __( 'Type your title here', 'archub-elementor-addons' ),
			]
		);

		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Title Typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-pt-title',
			]
		);

		$this->add_control(
			'subtitle',
			[
				'label' => __( 'Subtitle', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Subtitle', 'archub-elementor-addons' ),
				'placeholder' => __( 'Type your title here', 'archub-elementor-addons' ),
				'condition' => [
					'template' => 'style03'
				],
			]
		);

		$this->add_control(
			'description',
			[
				'label' => __( 'Description', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( 'Subtitle', 'archub-elementor-addons' ),
				'placeholder' => __( 'Type your text here', 'archub-elementor-addons' ),
				'condition' => [
					'template' => [ 'style01', 'style03' ]
				],
			]
		);

		$this->add_control(
			'price',
			[
				'label' => __( 'Price', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( '$12', 'archub-elementor-addons' ),
				'placeholder' => __( 'Type your price here', 'archub-elementor-addons' ),
			]
		);

		$this->add_control(
			'featured_tag',
			[
				'label' => __( 'Show tag?', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'featured_label',
			[
				'label' => __( 'Tag label', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Featured', 'archub-elementor-addons' ),
				'placeholder' => __( 'Type your label here', 'archub-elementor-addons' ),
				'condition' => [
					'featured_tag' => 'yes' 
				],
			]
		);

		$this->add_control(
			'pt_scale_bg',
			[
				'label' => __( 'Scale up background?', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'content',
			[
				'label' => __( 'Features', 'archub-elementor-addons' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => '<ul><li>Free One Year Domain</li><li>10+ Pages Design</li><li>Full Organized Layered</li><li>Unlimited Revision</li><li>50% Discount Off</li><li>Free Logo Design</li><li>Free Stationary Design</li></ul>',
				'placeholder' => __( 'Type your text here', 'archub-elementor-addons' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => __( 'Content Typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-pt-body',
			]
		);

		$this->add_control(
			'footer_text',
			[
				'label' => __( 'Footer Text', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'placeholder' => __( 'Type your text here', 'archub-elementor-addons' ),
				'condition' => [
					'template' => [ 'style01' ]
				],
			]
		);
		$this->end_controls_section();

		// Colors
		$this->start_controls_section(
			'color_section',
			[
				'label' => __( 'Colors', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'pt_title_color',
			[
				'label' => __( 'Title Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-pt-title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'pt_subtitle_color',
			[
				'label' => __( 'Subtitle Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-pt-head p' => 'color: {{VALUE}}',
				],
				'condition' => [
					'template' => [ 'style01', 'style03' ]
				]
			]
		);

		$this->add_control(
			'pt_price_color',
			[
				'label' => __( 'Price Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-pt-price' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'pt_text_color',
			[
				'label' => __( 'Body Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-pt' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'pt_bg_heading',
			[
				'label' => __( 'Background color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'pt_bg',
				'label' => __( 'Background', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .lqd-pt-bg',
			]
		);

		$this->add_control(
			'pt_border_color',
			[
				'label' => __( 'Border Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-pt, {{WRAPPER}} .lqd-pt-foot, {{WRAPPER}} .lqd-pt-body, {{WRAPPER}} .lqd-pt-head p, {{WRAPPER}} .lqd-pt .lqd-pt-head, {{WRAPPER}} .lqd-pt .lqd-pt-head p, {{WRAPPER}} .lqd-pt figure' => 'border-color: {{VALUE}}',
				],
				'separator' => 'before'
			]
		);

		$this->add_control(
			'pt_tag_color',
			[
				'label' => __( 'Tag Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-pt-label' => 'color: {{VALUE}}',
				],
				'condition' => [
					'featured_tag' => 'yes' 
				],
				'separator' => 'before'
			]
		);

		$this->add_control(
			'pt_tag_bg_heading',
			[
				'label' => __( 'Tag Background', 'archub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'featured_tag' => 'yes' 
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'pt_tag_bg',
				'label' => __( 'Tag Background', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .lqd-pt-label',
				'condition' => [
					'featured_tag' => 'yes' 
				],
			]
		);
		
		$this->end_controls_section();

		ld_el_btn($this, 'ib_'); // load button

	}

	protected function ld_get_title( $classes = '' ) {

		$settings = $this->get_settings_for_display();

		// check
		if( empty( $settings['title'] ) ) {
			return '';
		}
		
		if( !empty( $classes ) ) {
			$class = 'class="lqd-pt-title ' . $classes . '"';
		}
		else {
			$class = 'class="lqd-pt-title"';
		}

		$title = wp_kses_post( $settings['title'] );
		
		// Default
		$title = sprintf( '<h4 %s> %s</h4>', $class, $title );

		echo $title;

	}
	
	protected function ld_get_description() {

		$settings = $this->get_settings_for_display();

		if( !$settings['description'] ) {
			return;
		}

		$style = $settings['template'];
		
		if( 'style01' === $style ) {
			echo '<p class="lqd-pt-description text-uppercase ltr-sp-1 mb-1">' . wp_kses_post( $settings['description'] ) . '</p>';	
		}
		elseif( 'style03' === $style ) {
			echo '<p class="lqd-pt-description mb-1">' . wp_kses_post( $settings['description'] ) . '</p>';	
		}
		else {
			echo '<p class="lqd-pt-description mb-0">' . wp_kses_post( $settings['description'] ) . '</p>';
		}
		
		
	}
	
	protected function ld_get_featured_tag() {

		$settings = $this->get_settings_for_display();
		
		if( !$settings['featured_tag'] ) {
			return;
		}
		$featured_label = '';
		if( !empty( $settings['featured_label'] ) ) {
			$featured_label = $settings['featured_label'];
		}
		
		printf( '<span class="lqd-pt-label text-uppercase ltr-sp-1 font-weight-semibold border-radius-4">%s</span>', wp_kses_post( $featured_label ) );
		
	}

	protected function ld_get_price() {

		$settings = $this->get_settings_for_display();

		// check
		if( empty( $settings['price'] ) ) {
			return '';
		}

		$out = '';

		$price = wp_kses_post( do_shortcode( $settings['price'] ) );
		
		if( 'style01' ===  $settings['template'] ) {
			$out .= sprintf( '<span class="lqd-pt-price mb-1">%s</span>', $price );
		}
		elseif( 'style02' === $settings['template'] ) {
			$out .= sprintf( '<span class="lqd-pt-price font-weight-bold mb-3">%s</span>', $price );
		}
		elseif( 'style03' === $settings['template'] ) {
			$out .= sprintf( '<span class="lqd-pt-price mb-4">%s</span>', $price );
		}
		else {
			$out .= sprintf( '<span class="lqd-pt-price">%s</span>', $price );	
		}

		echo $out;
	}
	
	protected function ld_get_features() {

		$settings = $this->get_settings_for_display();

		// check
		if( empty( $settings['content'] ) ) {
			return '';
		}

		$content = ld_helper()->do_the_content( $settings['content'] );

		echo wp_kses_post( $content );
	}

	protected function ld_get_footer_text() {

		$settings = $this->get_settings_for_display();
		
		// check
		if( empty( $settings['footer_text'] ) ) {
			return '';
		}

		$content = ld_helper()->do_the_content( $this->atts['footer_text'] );

		echo '<div class="lqd-pt-footer-extra mt-2">' . wp_kses_post( $content ) . '</div>';
		
	}

	protected function ld_get_button() {
		
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

	protected function ld_get_class( $style ) {

		$hash = array(
			'style01'  => 'lqd-pt-style-1 pos-rel text-center',
			'style02'  => 'lqd-pt-style-2 pos-rel border-radius-4',
			'style03'  => 'lqd-pt-style-3 pos-rel text-center',
		);

		return $hash[ $style ];
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
		extract( $settings );

		$classes = array( 
			'lqd-pt',
			$settings['pt_scale_bg'] === 'yes' ? 'lqd-pt-scale-bg' : '',
			$this->ld_get_class( $template ),
		);


		?> <div class="<?php echo ld_helper()->sanitize_html_classes( $classes ) ?>"><?php
		switch ($template){
			
			case 'style01':
			?>

				<div class="lqd-pt-inner pt-6 pb-6">

					<div class="lqd-pt-bg lqd-overlay"></div>

					<?php $this->ld_get_featured_tag(); ?>

					<div class="lqd-pt-head pos-rel ps-3 pe-3 pb-5">

						<?php $this->ld_get_title( 'font-weight-semibold text-uppercase ltr-sp-2 mt-0 mb-3' ); ?>
						<?php $this->ld_get_price(); ?>
						<?php $this->ld_get_description(); ?>

					</div>

					<div class="lqd-pt-body pos-rel ps-3 pe-3 pt-3 pb-3">
						<?php $this->ld_get_features() ?>
					</div>
					
					<div class="lqd-pt-foot pos-rel ps-3 pe-3 pt-5">
						<?php $this->ld_get_button(); ?>
						<?php $this->ld_get_footer_text(); ?>

					</div>

				</div>

			<?php
			break;
			
			case 'style02':
			?>

				<div class="lqd-pt-inner pt-6 pb-5">

					<div class="lqd-pt-bg lqd-overlay border-radius-4"></div>

					<?php $this->ld_get_featured_tag(); ?>

					<div class="lqd-pt-head pos-rel ps-5 pe-5 pb-4 text-center">
						<?php $this->ld_get_price(); ?>
						<?php $this->ld_get_title( 'font-weight-medium mb-1' ); ?>
					</div>

					<div class="lqd-pt-body pos-rel pt-3 ps-5 pe-5">
						<?php $this->ld_get_features() ?>
					</div>

					<?php if ($show_button === 'yes'): ?>
					<div class="lqd-pt-foot pos-rel pt-3 text-center">
						<?php $this->ld_get_button(); ?>
					</div>
					<?php endif; ?>

				</div>

			<?php
			break;
			
			case 'style03':
			?>

				<?php $this->ld_get_featured_tag(); ?>
				
				<div class="lqd-pt-inner pb-6">

					<div class="lqd-pt-bg lqd-overlay"></div>

					<div class="lqd-pt-head pos-rel">

						<?php if( !empty( $title ) ) { ?>
						<h4 class="lqd-pt-title mt-0 mb-0"><?php echo $title; ?></h4>
						<?php } ?>
						
						<?php if( !empty( $subtitle ) ) { ?>
						<p><?php echo $subtitle; ?></p>
						<?php } ?>

						<?php $this->ld_get_price(); ?>
						<?php $this->ld_get_description(); ?>

					</div>

					<div class="lqd-pt-body pos-rel ps-3 pe-3 pt-3 pb-3">
						<?php $this->ld_get_features() ?>
					</div>

					<?php if ($show_button === 'yes'): ?>
					<div class="lqd-pt-foot pos-rel p-3">
						<?php $this->ld_get_button(); ?>
					</div>
					<?php endif; ?>

				</div>

			<?php
			break;
		}
		?></div><?php
		
	}

	// Button Props

	protected function get_svg_attributes() {

		$settings = $this->get_settings_for_display();

		$i_type = $settings['i_type'];
		$icon = $settings['i_icon_fontawesome']['value'];
		$image = $settings['i_icon_image']['url'];

			
		$attributes = $svg = array();
		$color  = $color2 = $hcolor = $hcolor2 = '';
		
		
		if( isset( $i_type ) && 'image' === $i_type ) {
			return;
		}

		if( isset( $image ) ) {
			$filetype = wp_check_filetype( $image );
			$svg['file'] = $image;
			$attributes['data-animated-svg'] = true;	
		}

		$attributes['data-animate-icon'] = true;	
		if ( !empty( $settings['animation_delay'] ) ) {
			$svg['delay'] = $settings['animation_delay'];
		}
		/*
		if( 'yes' === $settings['hover_animation'] ) {
			$svg['resetOnHover'] = true;
		}
		*/

		if( !empty( $settings['i_color'] ) ) {
			$color = $settings['i_color'];	
		}
		if( !empty( $settings['i_color2'] ) && !empty( $settings['i_color'] ) ) {
			$color2 = ':' . $this->atts['i_color2'];
		}
		if( !empty( $settings['i_color2'] ) || !empty( $settings['i_color'] ) ) {
			$svg['color'] = $color . $color2;	
		}

		if( !empty( $settings['h_i_color'] ) ) {
			$hcolor = $settings['h_i_color'];
		}
		if ( !empty( $settings['h_i_color2'] ) && !empty( $settings['h_i_color'] ) ) {
			$hcolor2 = ':' . $settings['h_i_color2'];
		}
		if ( !empty( $settings['h_i_color2'] ) || !empty( $settings['h_i_color'] ) ) {
			$svg['hoverColor'] = $hcolor . $hcolor2;
		}

		if ( !empty( $svg ) ) {
			$attributes['data-plugin-options'] = wp_json_encode( $svg );
		}
		
		
		return $attributes;
		
	}


	protected function get_the_icon() {

	$settings = $this->get_settings_for_display();

	
	$i_type = $settings['i_type'];
	$icon = $settings['i_icon_fontawesome']['value'];
	$image = $settings['i_icon_image']['url'];

	$attributes = array(
		'class' => 'iconbox-icon-container'
	);
	
	echo  '<div class="iconbox-icon-wrap">';
	printf('<span%s>', ld_helper()->html_attributes( $attributes ) );

	if( !empty( $settings['shape_hcolor'] ) ) {
		echo '<span class="iconbox-icon-hover-bg"></span>';
	}
	
	$this->get_custom_bg_shape();
	
	if( ! empty( $i_type ) ) {			
		if( 'image' === $i_type || 'animated' === $i_type ) {
			$filetype = wp_check_filetype( $image );
			if( 'svg' === $filetype['ext'] ) {
				$request  = wp_remote_get( $image );
				$response = wp_remote_retrieve_body( $request );
				$svg_icon = $response;
				if( 'animated' !== $i_type ) {
					echo $svg_icon;	
				}
			} 
			else {
				printf( '<img src="%s" class="lqd-image-icon" />', esc_url( $image ) );
			}
		}
		else {
			printf( '<i class="%s"></i>', $icon );
		}
	}

	echo '</span>';
	echo  '</div>';
}

protected function get_custom_bg_shape() {

	$settings = $this->get_settings_for_display();
	
	$out = '';
	
	$shape = $settings['i_shape'];
	$bg_id = $settings['i_shape_custom_bg']['id'];
	if( 'custombg' !== $shape || empty( $bg_id ) ) {
		return'';
	}		
	
	$src = wp_get_attachment_url( $bg_id );
	$filetype = wp_check_filetype( $src );
	
	if( 'svg' === $filetype['ext'] ) {
		
		$request  = wp_remote_get( $src );
		$response = wp_remote_retrieve_body( $request );
		$svg_icon = $response;

		$out = $svg_icon;
		
	} 
	else {
		$out = sprintf( '<img src="%s" />', esc_url( $src ) );
	}

	echo '<span class="icon-custom-bg">';
	echo $out;
	echo '</span>';
}

protected function get_toggleable() {

	$settings = $this->get_settings_for_display();

	$toggleable = $settings['toggleable'];
	if( 'yes' !== $toggleable ) {
		return;
	}

	return "iconbox-contents-show-onhover";

}

protected function get_toggleable_opts() {

	$settings = $this->get_settings_for_display();

	$toggleable = $settings['toggleable'];
	if( 'yes' !== $toggleable ) {
		return;
	}

	return 'data-slideelement-onhover="true" data-slideelement-options=\'{ "visibleElement": ".iconbox-icon-wrap, p, h3", "hiddenElement": ".btn", "alignMid": true }\'';

}

protected function before_icon_box_content() {

	$settings = $this->get_settings_for_display();

	// check
	if( empty( $settings['content'] ) ) {
		return;
	}

	return '<div class="contents">';
}

protected function after_icon_box_content() {

	$settings = $this->get_settings_for_display();

	// check
	if( empty( $settings['content'] ) ) {
		return;
	}

	return '</div>';

}

protected function get_overlay_link() {

	$settings = $this->get_settings_for_display();
	
	$link['href']= $settings['link']['url'];
	
	if( empty( $link['href']) ) {
		return;
	}
	$link['class'] = 'liquid-overlay-link z-index-2';
	if( !empty($settings['localscroll_link']) ) {
		$link['data-localscroll'] = 'true';	
	}

	echo '<a'. ld_helper()->html_attributes( $link ) .'></a>';
	
}

}
