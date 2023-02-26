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
class LD_Google_Map extends Widget_Base {

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
		return 'ld_google_map';
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
		return __( 'Liquid Google Maps', 'elementor' );
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
		return 'eicon-google-maps lqd-element';
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
		return [ 'map', 'google' ];
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
			return [ 'google-maps-api', 'gsap' ];
		} else {
			return [ 'google-maps-api' ];
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
			'map_section',
			[
				'label' => __( 'Google Map', 'archub-elementor-addons' ),
			]
		);
		
		$this->add_control(
            'style',
            [
                'label' => __( 'Map Style', 'archub-elementor-addons' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'wy',
                'options' => [
                    'assassinsCreedIV' => __( 'Assassins Creed IV', 'archub-elementor-addons' ),
                    'blueEssence' => __( 'Blue Essence', 'archub-elementor-addons' ),
                    'classic' => __( 'Classic', 'archub-elementor-addons' ),
                    'lightMonochrome' => __( 'Light Monochrome', 'archub-elementor-addons' ),
                    'unsaturatedBrowns' => __( 'Unsaturated Browns', 'archub-elementor-addons' ),
                    'wy' => __( 'WY', 'archub-elementor-addons' ),
                    'evenLighter' => __( 'Even Lighter', 'archub-elementor-addons' ),
                    'shadesOfGray' => __( 'Shades of Gray', 'archub-elementor-addons' ),
                ],
            ]
        );

        $this->add_control(
			'address',
			[
				'label' => __( 'Address', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'rows' => 4,
				'default' => '7420 Shore Rd, Brooklyn, NY 11209, USA',
			]
		);

        $this->add_responsive_control(
			'map_height',
			[
				'label' => __( 'Height', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => '550px',
				'selectors' => [
					'{{WRAPPER}} .ld-gmap' => 'height: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'map_marker',
			[
				'label' => __( 'Marker', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'separator' => 'before',
				'options' => [
					'default' => __( 'Default', 'archub-elementor-addons' ),
					'image' => __( 'Image', 'archub-elementor-addons' ),
					'html' => __( 'Animated Cricles', 'archub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'color_marker',
			[
				'label' => __( 'Marker Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [ 
					'{{WRAPPER}} .lqd-custom-map-marker, .lqd-custom-map-marker div' => 'background-color: {{VALUE}}',
				],
				'condition' => [
					'map_marker' => 'html',
				]
			]
		);

		$this->add_control(
			'custom_marker',
			[
				'label' => __( 'Custom Marker', 'archub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'condition' => [
					'map_marker' => 'image',
				]
			]
		);

		$this->add_control(
			'multiple_markers',
			[
				'label' => __( 'Multiple markers?', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'archub-elementor-addons' ),
				'label_off' => __( 'No', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'title',
			[
				'label' => __( 'Title', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$repeater->add_control(
			'lat',
			[
				'label' => __( 'Latitude', 'archub-elementor-addons' ),
				'description' => esc_html__( 'Marker Latitude', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'long',
			[
				'label' => __( 'Longitude', 'archub-elementor-addons' ),
				'description' => esc_html__( 'Marker Longitude', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
			]
		);
		$this->add_control(
			'marker_coordinates',
			[
				'label' => __( 'Marker\'s coordinates', 'archub-elementor-addons' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
				'condition' => [
					'multiple_markers' => 'yes'
				]
			]
		);

		$this->add_control(
			'map_type',
			[
				'label'  => __( 'Map Type', 'archub-elementor-addons' ),
				'type'   => Controls_Manager::SELECT,
				'options' => [
					'roadmap'   => esc_html__( 'Roadmap', 'archub-elementor-addons' ),
					'satellite' => esc_html__( 'Satellite', 'archub-elementor-addons' ),
					'hybrid'    => esc_html__( 'Hybrid', 'archub-elementor-addons' ),
					'terrain'   => esc_Html__( 'Terrain', 'archub-elementor-addons' ),
				],
				'default' => 'roadmap',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'zoom',
			[
				'label' => __( 'Zoom', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 16,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 20,
					],
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'map_controls',
			[
				'label'  => __( 'Enable/Disable controls', 'archub-elementor-addons' ),
				'type'   => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'options' => [
					'fullscreenControl' => __( 'Fullscreen', 'archub-elementor-addons' ),
					'panControl'        => __( 'Pan', 'archub-elementor-addons' ),
					'rotateControl'     => __( 'Rotate', 'archub-elementor-addons' ),
					'scaleControl'      => __( 'Scale', 'archub-elementor-addons' ),
					'scrollwheel'       => __( 'Scrollwheel', 'archub-elementor-addons' ),
					'streetViewControl' => __( 'Street View', 'archub-elementor-addons' ),
					'zoomControl'       => __( 'Zoom', 'archub-elementor-addons' ),
				],
				'default' => [
					'zoomControl'
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'map_info_box_section',
			[
				'label' => __( 'Info Box', 'archub-elementor-addons' ),
			]
		);

		$this->add_control(
			'show_info_box',
			[
				'label' => esc_html__( 'Show Info Box', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'archub-elementor-addons' ),
				'label_off' => esc_html__( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes'
			]
		);

		$this->add_control(
			'content_type',
			[
				'label' => __( 'Content type', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'tinymce',
				'label_block' => true,
				'options' => [
					'tinymce' => __( 'Repeater Items', 'archub-elementor-addons' ),
					'el_template' => __( 'Elementor Template', 'archub-elementor-addons' ),
				],
				'show_info_box' => 'yes'
			]
		);

		$this->add_control(
			'templates',
			[
				'label' => __( 'Templates', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => true,
				'options' => $this->get_block_posts(),
				'default' => '0',
				'condition' => [
					'content_type' => 'el_template',
				]
			]
		);

		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Contact us', 'archub-elementor-addons' ),
				'placeholder' => esc_html__( 'Type your title here', 'archub-elementor-addons' ),
				'condition' => [
					'show_info_box' => 'yes',
					'content_type' => 'tinymce'
				]
			]
		);

		$repeater2 = new Repeater();

		$repeater2->add_control(
			'title', [
				'label' => esc_html__( 'Title', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'List Title' , 'archub-elementor-addons' ),
				'label_block' => true,
			]
		);

		$repeater2->add_control(
			'icon',
			[
				'label' => esc_html__( 'Icon', 'archub-elementor-addons' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'solid',
				],
			]
		);

		$this->add_control(
			'info_box_list',
			[
				'label' => esc_html__( 'Contact Info', 'archub-elementor-addons' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater2->get_controls(),
				'default' => [
					[
						'title' => esc_html__( '290 Maryam Springs 260, Courbevoie, Paris, France', 'archub-elementor-addons' ),
						'icon' => [
							'value' => 'fas fa-map-marker-alt',
							'library' => 'solid',
						],
					],
					[
						'title' => esc_html__( 'Phone:  +47 213 5941 295', 'archub-elementor-addons' ),
						'icon' => [
							'value' => 'fas fa-phone',
							'library' => 'solid',
						],
					],
				],
				'title_field' => '{{{ title }}}',
				'separator' => 'before',
				'condition' => [
					'show_info_box' => 'yes',
					'content_type' => 'tinymce'
				]
			]
		);

		$this->end_controls_section();
		
		$this->start_controls_section(
			'map_info_box_style_section',
			[
				'label' => __( 'Info Box Style', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_info_box' => 'yes'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'info_box_bg',
				'label' => __( 'Info box background', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .ld-gmap-contents',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'info_box_box_shadow',
				'label' => esc_html__( 'Box Shadow', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .ld-gmap-contents',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Title color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ld-gmap-contents > h3' => 'color: {{VALUE}};',
				],
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'label' => __( 'Title margin', 'archub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ld-gmap-contents > h3' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .ld-gmap-contents > h3',
			]
		);

		$this->add_control(
			'content_color',
			[
				'label' => __( 'Contact info color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ld-gmap-contents .iconbox h3' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'selector' => '{{WRAPPER}} .ld-gmap-contents .iconbox h3',
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => __( 'Icon color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ld-gmap-contents .iconbox .iconbox-icon-container' => 'color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'icon_size',
			[
				'label' => esc_html__( 'Icon size', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 500,
						'step' => 1,
					],
					'em' => [
						'min' => 1,
						'max' => 50,
					],
				],
				'default' => [
					'unit' => 'em',
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .ld-gmap-contents .iconbox .iconbox-icon-container' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'iconbox_margin',
			[
				'label' => __( 'Info box margin', 'archub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .iconbox' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		ld_el_btn($this, 'ib_', $condition = ['show_info_box' => 'yes']); // load button

	}

	protected function get_marker() {

		$map_marker = $this->get_settings_for_display('map_marker');

		if( empty( $map_marker ) || 'html' === $map_marker ) {
			return '';
		}

		if ( 'image' === $map_marker && isset( $this->get_settings_for_display('custom_marker')['url'] ) ) {
			return $this->get_settings_for_display('custom_marker')['url'];
		}

	}

	protected function get_coordinates() {

		$items = array();
		
		if( 'no' === $this->get_settings_for_display('multiple_markers') ) {
			return;
		}
		
		$items = is_array($this->get_settings_for_display('marker_coordinates')) ? array_filter( $this->get_settings_for_display('marker_coordinates') ) : null;
		
		if( empty( $items ) ) {
			return;
		}

		$data = array();

		foreach( $items as $item ) {
			$data[] = array( ''. esc_attr( $item['lat'] ) . '', '' . esc_attr( $item['long'] ) . '' );
		}

		return $data;

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

	protected function get_block_posts() {
		$posts = get_posts( array(
			'post_type' => 'elementor_library',
			'posts_per_page' => -1,
			'meta_query'  => array(
                array(
                    'key' => '_elementor_template_type',
                    'value' => 'kit',
                    'compare' => '!=',
                ),
            ),
		) );
	
		$options = [ '0' => 'Select Template' ];
	
		foreach ( $posts as $post ) {
		  $options[ $post->ID ] = $post->post_title;
		}
	
		return $options;
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
		extract($settings);

		if ( 0 === absint( $settings['zoom']['size'] ) ) {
			$settings['zoom']['size'] = 14;
		}
		
		$options = array(
			'style' => $settings['style'],
			'address' => $settings['address'],
			'marker_style' => $settings['map_marker'],
			'markers' => $this->get_coordinates(),
			'map'     => array(
				'zoom'      => $settings['zoom']['size'] ? intval( $settings['zoom']['size'] ) : 14,
				'mapTypeId' => $settings['map_type']
			)
		);

		if ( ! empty( $this->get_marker() ) ) {
			$options['marker'] = $this->get_marker();
		}

		// Map Controls
		$map_controls = $settings['map_controls'];
		
		if( $map_controls ) {
			$map = array();
			foreach( $map_controls as $control ) {
				$options['map'][ $control ] = true;
			}
		}
		
		?>

			<div class="ld-gmap-container pos-rel">
				<div class="ld-gmap h-100" data-plugin-map="true" data-plugin-options='<?php echo wp_json_encode( $options ) ?>'></div>

				<?php if ( 'yes' === $settings['show_info_box'] ) : ?>

				<div class="ld-gmap-contents">

					<?php if ( $settings['content_type'] === 'el_template' ){
						echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $settings['templates'] ); 
					} else {
					?>

					<?php printf( '<h3>%s</h3>', esc_html( $settings['title'] ) ); ?>

					<?php if ( $settings['info_box_list'] ) : ?>
						<?php foreach (  $settings['info_box_list'] as $item ) : ?>
							<div class="iconbox iconbox-inline d-flex flex-wrap flex-grow-1 align-items-center elementor-repeater-item-<?php echo esc_attr( $item['_id'] ); ?>">
								<div class="iconbox-icon-wrap">
									<span class="iconbox-icon-container">
										<?php Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'true' ] ); ?>
									</span>
								</div>
								<?php printf( '<h3>%s</h3>', esc_html( $item['title'] ) ); ?>
							</div>
						<?php endforeach; ?>
					<?php endif; ?>

					<?php $this->get_button(); ?>

				</div>

				<?php } ?>
				<?php endif; ?>

			</div>

		<?php

	}

}
