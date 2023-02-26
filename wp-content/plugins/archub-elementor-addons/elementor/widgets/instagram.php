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
class LD_Instagram extends Widget_Base {

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
		return 'ld_instagram';
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
		return __( 'Liquid Instagram Feed', 'archub-elementor-addons' );
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
		return 'eicon-instagram-gallery lqd-element';
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
		return [ 'instagram', 'photo' ];
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
			'important_note',
			[
				'type' => Controls_Manager::RAW_HTML,
				'raw' => sprintf( __( 'Manage settings from plugin page<br>Go to the <a href="%s" target="_blank">plugin page</a>.', 'archub-elementor-addons' ), admin_url( 'admin.php?page=sbi-feed-builder' ) ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);

		$this->end_controls_section();

		ld_el_btn($this, 'ib_'); // load button
	}

	protected function get_button() {
		
		extract( $this->get_settings_for_display() );
		$ib_link = isset($ib_link['url']) ? $ib_link['url'] : '';
		$ib_i_icon = isset($ib_icon['value']) ? $ib_icon['value'] : '';

		$ib_classes = array( 
			'elementor-button',
			'btn',
			'ws-nowrap',
			$ib_style,
			$ib_i_separator,
			$ib_hover_txt_effect,
			$ib_border_w,
			$this->get_width(),
		
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

		$ib_attributes['href'] = trim($ib_link);
		$ib_attributes['class'] = ld_helper()->sanitize_html_classes( $ib_classes );

		if( !empty( $ib_image_caption ) ) {
			$ib_attributes['data-fresco-caption'] = $ib_image_caption;
		} 

		if( 'modal_window' === $ib_link_type ) {
			$ib_attributes['data-lity'] = isset( $ib_anchor_id ) ? esc_url( $ib_anchor_id ) : '#modal-box';
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
				<span class="btn-txt" data-text="<?php echo esc_attr( $ib_title ) ?>" <?php $this->get_hover_text_opts(); ?>><?php echo wp_kses_post( do_shortcode( $ib_title ) ); ?></span>
			<?php } ?>
			<?php
				if( $ib_i_icon ) {
					printf( '<span class="btn-icon"><i class="%s"></i></span>', $ib_i_icon );
				}
				if( 'btn-hover-swp' === $ib_i_hover_reveal ) {
					printf( '<span class="btn-icon"><i class="%s"></i></span>', $ib_i_icon );
				}
			?>
		</a>
		<?php

		}
	}
	
	protected function get_images() {

		if( !class_exists( 'SB_Instagram_Display_Elements' ) ) {
			return wp_kses_post( _e( '<div class="alert alert-danger">Please, install the <a href="https://wordpress.org/plugins/instagram-feed/" target="_blank">Instagram Feed</a> and activate it.</div>', 'archub-elementor-addons' ) );
		}
				
		$instagram_feed = display_instagram();
		
		echo $instagram_feed;

	}

	// Button functions

	protected function get_border() {

		$style = $this->get_settings_for_display('ib_style');
		
		if( 'btn-naked' == $style || 'btn-underlined' == $style ) {
			return;
		}

		$border = $this->get_settings_for_display('ib_border');

		if ( 'btn-solid' == $style) {
			return $border;	
		}
		
		return "btn-bordered $border";	
	}

	protected function get_width() {
		
		$style = $this->get_settings_for_display('ib_style');

		if( 'btn-naked' === $style || 'btn-underlined' === $style ) {
			return;
		}

		$width = $this->get_settings_for_display('ib_width');
		
		return "$width";	
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
			default:
				
				$out = 'data-transition-delay="true"
					    data-delay-options=\'{"elements": ".lqd-chars", "delayType": "animation", "startDelay": ' . $start_delay . ', "delayBetween": 32.5}\'
					    data-split-text="true"
					    data-split-options=\'{"type": "chars, words"}\'';
			break;
			
			case 'btn-hover-txt-liquid-x-alt':
				
				$out = 'data-transition-delay="true"
					    data-delay-options=\'{"elements": ".lqd-chars", "delayType": "animation", "startDelay": ' . $start_delay . ', "delayBetween": 32.5, "reverse": true}\'
					    data-split-text="true"
					    data-split-options=\'{"type": "chars, words"}\'';

			break;
			
			case 'btn-hover-txt-liquid-y':
				
				$out = 'data-transition-delay="true"
					    data-delay-options=\'{"elements": ".lqd-chars", "delayType": "animation", "startDelay": ' . $start_delay . ', "delayBetween": 32.5}\'
					    data-split-text="true"
					    data-split-options=\'{"type": "chars, words"}\'';
			break;

			case 'btn-hover-txt-liquid-y-alt':
				
				$out = 'data-transition-delay="true"
				        data-delay-options=\'{"elements": ".lqd-chars", "delayType": "animation", "startDelay": ' . $start_delay . ', "delayBetween": 32.5}\'
				        data-split-text="true"
				        data-split-options=\'{"type": "chars, words"}\'';
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

		extract( $settings );

		$classes = array( 
			'lqd-ig-feed',
		);

		?>

		<div class="<?php echo ld_helper()->sanitize_html_classes( $classes ); ?>">
			<?php $this->get_images(); ?>
			<?php $this->get_button() ?>
		</div>

		<?php

	}

}
