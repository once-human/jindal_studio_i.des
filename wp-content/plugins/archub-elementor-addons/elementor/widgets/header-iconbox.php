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
class LD_Header_Iconbox extends Widget_Base {

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
		return 'ld_header_iconbox';
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
		return __( 'Liquid Header Iconbox', 'archub-elementor-addons' );
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
		return 'eicon-dot-circle-o lqd-element';
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
		return [ 'header', 'icon', 'box' ];
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
				'label' => __( 'Icon Box', 'archub-elementor-addons' ),
			)
		);

        $this->add_control(
			'i_type',
			[
				'label' => __( 'Icon Library', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'fontawesome',
				'options' => [
					'fontawesome'  => __( 'Icon Library', 'archub-elementor-addons' ),
					'image' => __( 'Image', 'archub-elementor-addons' ),
				],
			]
		);

        $this->add_control(
			'i_icon_fontawesome',
			[
				'label' => __( 'Icon', 'archub-elementor-addons' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fa fa-star',
					'library' => 'solid',
				],
                'condition' => array(
                    'i_type' => 'fontawesome',
                ),
			]
		);

		$this->add_control(
			'i_icon_image',
			[
				'label' => __( 'Image', 'archub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'condition' => array(
                    'i_type' => 'image',
                ),
			]
		);
		$this->add_control(
			'i_icon_size',
			[
				'label' => __( 'Icon Size', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 500,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 24,
				],
				'selectors' => [
					'{{WRAPPER}} .iconbox-icon-container' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => array(
					'i_type' => 'fontawesome',
				),
			]
		);

		$this->add_control(
			'custom_size',
			[
				'label' => __( 'Custom Icon Size', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 500,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 24,
				],
				'selectors' => [
				//	'{{WRAPPER}} .box' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => array(
					'i_type' => 'image',
				),
			]
		);

        $this->add_control(
			'icon_mb',
			[
				'label' => __( 'Icon Spacing', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 24,
				],
				'selectors' => [
					'{{WRAPPER}} .iconbox-icon-wrap' => 'margin-inline-end: {{SIZE}}{{UNIT}};',
				],
				'condition' => array(
					'i_type' => array( 'fontawesome', 'image' ),
				),
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
				'selector' => '{{WRAPPER}} h3',
			]
		);

		$this->add_control(
			'content',
			[
				'label' => __( 'Content', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'rows' => 10,
				'default' => __( 'Content', 'archub-elementor-addons' ),
				'placeholder' => __( 'Type your description here', 'archub-elementor-addons' ),
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => __( 'Content Typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} p',
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
			'i_color',
			[
				'label' => __( 'Icon Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .iconbox-icon-container' => 'color: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'h_color',
			[
				'label' => __( 'Heading Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} h3' => 'color: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'p_color',
			[
				'label' => __( 'Content Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} p' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'sticky_color_section',
			[
				'label' => __( 'Sticky Colors', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'sticky_i_color',
			[
				'label' => __( 'Icon Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.is-stuck {{WRAPPER}} .iconbox-icon-container' => 'color: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'sticky_h_color',
			[
				'label' => __( 'Heading Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.is-stuck {{WRAPPER}} h3' => 'color: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'sticky_p_color',
			[
				'label' => __( 'Content Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.is-stuck {{WRAPPER}} p' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'sticky_light_color_section',
			[
				'label' => __( 'Colors Over Light Rows', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'sticky_light_i_color',
			[
				'label' => __( 'Icon Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-light .iconbox-icon-container' => 'color: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'sticky_light_h_color',
			[
				'label' => __( 'Heading Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-light h3' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'sticky_light_p_color',
			[
				'label' => __( 'Content Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-light p' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'sticky_dark_color_section',
			[
				'label' => __( 'Colors Over Dark Rows', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'sticky_dark_i_color',
			[
				'label' => __( 'Icon Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-dark .iconbox-icon-container' => 'color: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'sticky_dark_h_color',
			[
				'label' => __( 'Heading Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-dark h3' => 'color: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'sticky_dark_p_color',
			[
				'label' => __( 'Content Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-dark p' => 'color: {{VALUE}}',
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
			'iconbox',
			'iconbox-side',
			'd-flex',
			'align-items-center',
			'flex-grow-1'
		);

		?>
		
			<div class="<?php echo ld_helper()->sanitize_html_classes( $classes ) ?>" id="header-iconbox-<?php echo esc_attr( $this->get_id() ); ?>">
										
				<?php $this->get_the_icon(); ?>
				<?php if( !empty( $settings['content'] ) ) { ?>
					<div class="contents">
				<?php } ?>
				<h3 style="margin: 0"><?php echo $settings['title']; ?></h3>
				<?php echo wp_kses_post( ld_helper()->do_the_content( $settings['content'] ) ); ?>
				<?php if( !empty( $settings['content'] ) ) { ?>
					</div>
				<?php } ?>
				
			</div>
			
		<?php

	}

	protected function get_the_icon() {

		$settings = $this->get_settings_for_display();
		
		echo '<div class="iconbox-icon-wrap">';
		echo '<span class="iconbox-icon-container flex-grow-1">';

		
		if( ! empty( $settings['i_type'] ) ) {			
			if( 'image' === $settings['i_type'] || 'animated' === $settings['i_type'] ) {
				$filetype = wp_check_filetype( $settings['i_icon_image']['url'] );
				if( 'svg' === $filetype['ext'] ) {
					$request  = wp_remote_get( $settings['i_icon_image']['url'] );
					$response = wp_remote_retrieve_body( $request );
					$svg_icon = $response;

					echo $svg_icon;
				} 
				else {
					printf( '<img src="%s" class="lqd-image-icon" />', esc_url( $settings['i_icon_image']['url'] ) );
				}
			}
			else {
				Icons_Manager::render_icon( $settings['i_icon_fontawesome'], [ 'aria-hidden' => 'true' ] );
			}
		}

		echo '</span>';
		echo '</div>';
	}

}
