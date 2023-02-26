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
use Elementor\Icons_Manager;

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
class LD_Button extends Widget_Base {

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
		return 'ld_button';
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
		return __( 'Liquid Button', 'elementor' );
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
		return 'eicon-button lqd-element';
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
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'button', 'title', 'text' ];
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

		ld_el_btn($this, ''); // load button

		// Rotate
        $this->start_controls_section(
			'rotate_section',
			array(
				'label' => __( 'Rotate', 'archub-elementor-addons' ),
			)
		);

        $this->add_control(
			'rotate_x',
			[
				'label' => __( 'Button Rotate', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -360,
						'max' => 360,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .btn' => 'transform: rotate({{SIZE}}deg);',
				],
			]
		);

        $this->add_control(
			'rotate_x_icon',
			[
				'label' => __( 'Icon Rotate', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => -360,
						'max' => 360,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .btn-icon i' => 'transform: rotate({{SIZE}}deg);',
					'{{WRAPPER}} .btn-icon svg' => 'transform: rotate({{SIZE}}deg);',
				],
				'condition' => [
					'i_add_icon' => 'true',
				]
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
		$this->add_inline_editing_attributes( 'title', 'basic' );

		$args = array(

			# Button
			'title' => $settings['title'],
			'style' => $settings['style'],
			'link_type' => $settings['link_type'],
			'image_caption' => $settings['image_caption'],
			'anchor_id' => $settings['anchor_id'],
			'scroll_speed' => $settings['scroll_speed'],
			'link' => $settings['link'],

			# Styling
			'border_w' => $settings['border_w'],
			'hover_txt_effect' => $settings['hover_txt_effect'],
			'hover_bg_effect' => $settings['hover_bg_effect'],
			'extended_lines' => $settings['extended_lines'],
			'title_secondary' => $settings['title_secondary'],

			# Icon
			'i_add_icon' => ($settings['i_add_icon'] == true ? $settings['i_add_icon'] : ''),
			'i_type' => ($settings['i_add_icon'] == true ? 'fontawesome' : ''),
			'i_icon' => isset($settings['icon']['value']) ? $settings['icon']['value'] : '',
			'i_size' => (isset($settings['i_size']['size']) ? $settings['i_size']['size'].'px' : ''),
			'i_position' => $settings['i_position'],
			'i_shape' => $settings['i_shape'],
			'i_shape_style' => $settings['i_shape_style'],
			'i_shape_bw' => $settings['i_shape_bw'],
			'i_shape_size' => $settings['i_shape_size'],
			'i_hover_reveal' => $settings['i_hover_reveal'],
			'i_ripple' => $settings['i_ripple'],
			'i_separator' => $settings['i_separator'],

			'i_margin_left' => isset($settings['i_margin']['left']) ? $settings['i_margin']['left'].$settings['i_margin']['unit'] : '',
			'i_margin_right' => isset($settings['i_margin']['right']) ? $settings['i_margin']['right'].$settings['i_margin']['unit'] : '',
			'i_margin_top' => isset($settings['i_margin']['top']) ? $settings['i_margin']['top'].$settings['i_margin']['unit'] : '',
			'i_margin_bottom' => isset($settings['i_margin']['bottom']) ? $settings['i_margin']['bottom'].$settings['i_margin']['unit'] : '',

			#Colors
			
			// Same variables using elementor selector.
			'i_color' => $settings['i_color'],
			'i_hcolor' => $settings['i_hcolor'],
			'text_color' =>  $settings['text_color'],
			'htext_color' => $settings['htext_color'],
			'i_fill_color' => $settings['i_fill_color'],
			'i_fill_hcolor' => $settings['i_fill_hcolor'],
			
		);
		
		
		extract($args);

		$classes = array( 
			'elementor-button',
			'btn',
			'align-items-center',
			'justify-content-center',
			'pos-rel',
			'overflow-hidden',
			'ws-nowrap',
			$style,
			$i_separator,
			$hover_txt_effect,
			$style === 'btn-solid' ? $hover_bg_effect : '',
			$border_w,
		
			($link_type === 'lightbox') ? 'fresco' : '',
			
			//Icon Classes
			isset($i_position) ? $i_position : '',
			$i_shape,
			$i_add_icon === 'true' && $i_shape !== '' && $i_shape_style !== '' ? $i_shape_size : '',
			$i_add_icon === 'true' && $i_shape !== '' && $i_shape_style !== '' ? 'btn-icon-shaped' : '',
			$i_shape_style,
			$i_shape_bw,	
			$i_ripple,
			$i_add_icon === 'true' && ($i_position === 'btn-icon-left' || $i_position === 'btn-icon-right') ? $i_hover_reveal : '',
			!empty( $title ) ? 'btn-has-label' : 'btn-no-label',
			$style === 'btn-solid' && $extended_lines === 'yes' ?  'btn-extended-lines' : '',
		);

		$txt_class = array(
			'btn-txt',
			'd-block',
			'pos-rel',
			'z-index-3',
			'btn-hover-txt-switch btn-hover-txt-switch-x' === $settings['hover_txt_effect'] ||
			'btn-hover-txt-switch btn-hover-txt-switch-y' === $settings['hover_txt_effect'] ? 'overflow-hidden' : '',
		);
		$inline_edit_attr = '';
		$txt_attrs = [];

		$data_text = $title;

		$attributes['href'] = isset($link['url']) ? trim($link['url']) : '';
		$attributes['class'] = ld_helper()->sanitize_html_classes( $classes );

		if( !empty( $image_caption ) ) {
			$attributes['data-fresco-caption'] = $image_caption;
		} 

		if( 'modal_window' === $link_type ) {
			$attributes['data-lqd-lity'] = isset( $anchor_id ) ? esc_url( $anchor_id ) : '#modal-box';
			$attributes['href'] = isset( $anchor_id ) ? esc_url( $anchor_id ) : '#modal-box';
		}
		elseif( 'local_scroll' === $link_type ) {
			$attributes['data-localscroll'] = true;
			$attributes['href'] = isset( $anchor_id ) ? esc_url( $anchor_id ) : '#';
			if( !empty( $scroll_speed ) ) {
				$attributes['data-localscroll-options'] = wp_json_encode( array( 'scrollSpeed' => $scroll_speed ) );	
			}
			
		}
		elseif( 'scroll_to_section' === $link_type ) {
			$attributes['data-localscroll'] = true;
			if( !empty( $scroll_speed ) ) {
				$attributes['data-localscroll-options'] = wp_json_encode( array( 'scrollBelowSection' => true, 'scrollSpeed' => $scroll_speed ) );	
			}
			else {
				$attributes['data-localscroll-options'] = wp_json_encode( array( 'scrollBelowSection' => true ) );	
			}
			
			$attributes['href'] = '#';
		}

		if ( $hover_txt_effect === 'btn-hover-txt-switch-change btn-hover-txt-switch btn-hover-txt-switch-y' && ! empty($title_secondary) ) {
			$data_text = $title_secondary;
		}

		if ( \Elementor\Plugin::$instance->editor->is_edit_mode() && ! strpos( $settings['hover_txt_effect'], 'btn-hover-txt-switch' ) ) {
			array_push( $txt_class, 'elementor-inline-editing' );
			$txt_attrs['data-elementor-setting-key'] = 'title';
			$txt_attrs['data-elementor-inline-editing-toolbar'] = 'basic';
		}

		$target = isset($settings['link']['is_external']) && $settings['link']['is_external'] ? ' target="_blank"' : '';
		$nofollow = isset($settings['link']['nofollow']) && $settings['link']['nofollow'] ? ' rel="nofollow"' : '';

		?>

		<a <?php echo ld_helper()->html_attributes( $attributes ); echo $target . $nofollow ?> >
			<?php if( !empty( $title ) ) { ?>
				<span class="<?php echo ld_helper()->sanitize_html_classes( $txt_class ) ?>" <?php echo ld_helper()->html_attributes( $txt_attrs ); ?> data-text="<?php echo esc_attr( $data_text ) ?>" <?php $this->get_hover_text_opts(); ?>>
					<?php
						if(
							'btn-hover-txt-switch btn-hover-txt-switch-x' === $settings['hover_txt_effect'] ||
							'btn-hover-txt-switch btn-hover-txt-switch-y' === $settings['hover_txt_effect'] ||
							'btn-hover-txt-switch-change btn-hover-txt-switch btn-hover-txt-switch-y' === $settings['hover_txt_effect']
						) {
					?>
						<span class="btn-txt-inner d-inline-flex align-items-center justify-content-center"  data-text="<?php echo esc_attr( $data_text ) ?>">
							<?php echo wp_kses_post( do_shortcode( $title ) ); ?>
						</span>
					<?php } else { ?>
						<?php echo wp_kses_post( do_shortcode( $title ) ); ?>
					<?php } ?>
				</span>
			<?php } ?>
			<?php
				if( isset( $settings['icon']['value']) ) {
					?>
					<span class="btn-icon pos-rel z-index-3">
						<?php Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
					</span>
					<?php
				}
				if( 'btn-hover-swp' === $i_hover_reveal ) {
					?>
					<span class="btn-icon pos-rel z-index-3">
						<?php Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] ); ?>
					</span>
					<?php
				}
				if( 'yes' === $extended_lines && 'btn-solid' === $style ) {
					foreach (['tl', 'tr', 'br', 'bl'] as $side) { ?>
						<i class="btn-extended-line btn-extended-line-<?php echo $side ?> d-inline-block pos-abs pointer-events-none"></i>
					<?php }
				}
			?>
		</a>

		<?php
	}
	
	protected function content_template() {
		?>

			<#

				function getIcon() {

					const iconHTML = elementor.helpers.renderIcon( view, settings.icon, { 'aria-hidden': true }, 'i' , 'object' );
					const migrated = elementor.helpers.isIconMigrated( settings, 'icon' );

					if ( settings.icon ) {
						if ( settings.icon.library !== 'svg' ) {
							if ( ( migrated || ! settings.icon ) && iconHTML.rendered ) { #>
							{{{ iconHTML.value }}}
							<# } else { #>
								<i class="{{ settings.icon.value }}" aria-hidden="true"></i>
							<# }
						} else if ( settings.icon.library === 'svg' && iconHTML.rendered ) { #>
							{{{ iconHTML.value }}}
						<# }
					}

				};

				function getExtendedLines() {

					const sides = ['tl', 'tr', 'br', 'bl'];

					sides.forEach(side => { #>
						<i class="btn-extended-line btn-extended-line-{{ side }} d-inline-block pos-abs pointer-events-none"></i>
					<# });

				};

				const classnames = [
					'btn',
					'elementor-button',
					'align-items-center',
					'justify-content-center',
					'pos-rel',
					'overflow-hidden',
					'ws-nowrap',
					settings.style,
					settings.i_separator,
					settings.hover_txt_effect,
					settings.style === 'btn-solid' ? settings.hover_bg_effect : '',
					settings.size,
		
					settings.link_type === 'lightbox' ? 'fresco' : '',
					
					//Icon classnames
					settings.i_position,
					settings.i_shape,
					settings.i_add_icon === 'true' && settings.i_shape !== '' && settings.i_shape_style !== '' ? settings.i_shape_size : '',
					settings.i_add_icon === 'true' && settings.i_shape !== '' && settings.i_shape_style !== '' ? 'btn-icon-shaped' : '',
					settings.i_shape_style,	
					settings.i_shape_bw,	
					settings.i_ripple,
					settings.border_w,
					settings.i_add_icon === 'true' && (settings.i_position === 'btn-icon-left' || settings.i_position === 'btn-icon-right') ? settings.i_hover_reveal : '',
					settings.title != '' ? 'btn-has-label' : 'btn-no-label',
					settings.style === 'btn-solid' && settings.extended_lines === 'yes' ? 'btn-extended-lines' : '',
				].filter(classname => classname !== '');

				const {link_type} = settings;
				let link = settings.link.url;
				let linkAttrs = ``;
				let anchorId = settings.anchor_id === '' ? '#' : settings.anchor_id;
				let dataText = settings.title;

				if ( link_type === 'modal_window' || link_type === 'local_scroll' ) {
					link = anchorId;
				}
				if ( link_type === 'local_scroll' || link_type === 'scroll_to_section' ) {
					linkAttrs += ` data-localscroll="true"`;
				}

				if ( link_type === 'modal_window' ) {
					linkAttrs += ` data-lqd-lity="${anchorId}"`;
				} else if ( link_type === 'local_scroll' )  {
					linkAttrs += ` data-localscroll="true"`;
					if ( settings.scroll_speed !== '' ) {
						linkAttrs += ` data-localscroll-options='{"scrollSpeed": ${settings.scroll_speed}}'`
					}
				} else if ( link_type === 'scroll_to_section' ) {
					linkAttrs += ` data-localscroll-options='{"scrollBelowSection": true}'`
				}

				const {hover_txt_effect} = settings;
				let hoverEffectAttrs = ``;
				
				switch( hover_txt_effect ) {
					case 'btn-hover-txt-liquid-x':
					case 'btn-hover-txt-liquid-x-alt':
					case 'btn-hover-txt-liquid-y':
					case 'btn-hover-txt-liquid-y-alt':
						hoverEffectAttrs += `data-split-text="true" data-split-options='{"type": "chars, words"}'`;
					break;

					case 'btn-hover-txt-switch-change btn-hover-txt-switch btn-hover-txt-switch-y':
						if (settings.title_secondary !== '') dataText = settings.title_secondary;
					break;

					default:
						'';
					break;
				}

				const btn_txt_attrs = {};

				const btn_txt_classes = [
					'btn-txt',
					'd-block',
					'pos-rel',
					'z-index-3',
					'elementor-inline-editing',
				];

				if ( settings.hover_txt_effect.search('btn-hover-txt-switch') >= 0 ) {
					btn_txt_classes.push('overflow-hidden');
				} else {
					btn_txt_attrs['data-elementor-setting-key'] = 'title';
					btn_txt_attrs['data-elementor-inline-editing-toolbar'] = 'basic';
				}

				btn_txt_attrs['class'] = btn_txt_classes;

				view.addRenderAttribute( 'btn_txt_attributes', btn_txt_attrs);
						
			#>

			<a
			href="{{ link.trim() }}"
			class="{{ classnames.join(' ') }}"
			data-fresco-caption="{{settings.image_caption}}"
			{{{linkAttrs}}}
			{{{hoverEffectAttrs}}}
			>
				<span {{{ view.getRenderAttributeString('btn_txt_attributes') }}} data-text="{{{dataText}}}">
					<# if (
						settings.hover_txt_effect === 'btn-hover-txt-switch btn-hover-txt-switch-x' ||
						settings.hover_txt_effect === 'btn-hover-txt-switch btn-hover-txt-switch-y' ||
						settings.hover_txt_effect === 'btn-hover-txt-switch-change btn-hover-txt-switch btn-hover-txt-switch-y'
					) { #>
					<span class="btn-txt-inner d-inline-flex align-items-center justify-content-center" data-text="{{{dataText}}}">
						{{{settings.title}}}
					</span>
					<# } else { #>
						{{{settings.title}}}
					<# } #>
				</span>
				<# if ( settings.i_add_icon === 'true' ) { #>
					<span class="btn-icon pos-rel z-index-3">
						<# getIcon(); #>
					</span>
					<# if ( settings.i_hover_reveal === 'btn-hover-swp' ) { #>
					<span class="btn-icon pos-rel z-index-3">
						<# getIcon(); #>
					</span>
					<# }
				}
				if ( settings.extended_lines === 'yes' && settings.style === 'btn-solid' ) {
					getExtendedLines();
				} #>
			</a>
			
		<?php
	}

	protected function get_hover_text_opts() {

		$effect = $this->get_settings_for_display('hover_txt_effect');
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

}
