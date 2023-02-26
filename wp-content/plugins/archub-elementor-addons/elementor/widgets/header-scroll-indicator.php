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
class LD_Header_Scroll_Indicator extends Widget_Base {

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
		return 'ld_header_scroll_indicator';
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
		return __( 'Liquid Scroll Indicator', 'archub-elementor-addons' );
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
		return 'eicon-scroll lqd-element';
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
		return [ 'header', 'separator' ];
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

        // general_section
		$this->start_controls_section(
			'general_section',
			array(
				'label' => __( 'General', 'archub-elementor-addons' ),
			)
		);

		$this->add_control(
			'text',
			[
				'label' => __( 'Text', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'scroll', 'archub-elementor-addons' ),
				'placeholder' => __( 'scroll', 'archub-elementor-addons' ),
			]
		);

		$this->add_control(
			'indicator_type',
			[
				'label' => __( 'Indicator type', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'line' => __( 'Line', 'archub-elementor-addons' ),
					'dot' => __( 'Dot', 'archub-elementor-addons' ),
				],
				'default' => 'line',
			]
		);

		$this->end_controls_section();

		// colors_section
		$this->start_controls_section(
			'colors_section',
			array(
				'label' => __( 'Colors', 'archub-elementor-addons' ),
			)
		);

        $this->add_control(
			'primary_color',
			[
				'label' => __( 'Primary Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a' => 'color: {{VALUE}}',
					'{{WRAPPER}} .lqd-scrl-indc-line' => 'background-color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'bar_color',
			[
				'label' => __( 'Bar Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-scrl-indc-line' => 'background-color: {{VALUE}}!important',
				],
			]
		);

        $this->add_control(
			'indicator_color',
			[
				'label' => __( 'Indicator Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-scrl-indc-el' => 'background-color: {{VALUE}}',
				],
			]
		);	
		$this->end_controls_section();

        // Sticky Colors
        $this->start_controls_section(
			'sticky_colors_section',
			array(
				'label' => __( 'Sticky Colors', 'archub-elementor-addons' ),
			)
		);

        $this->add_control(
			'sticky_primary_color',
			[
				'label' => __( 'Primary Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.is-stuck {{WRAPPER}} a' => 'color: {{VALUE}}',
					'.is-stuck {{WRAPPER}} .lqd-scrl-indc-line' => 'background-color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'sticky_bar_color',
			[
				'label' => __( 'Bar Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.is-stuck {{WRAPPER}} .lqd-scrl-indc-line' => 'background-color: {{VALUE}}!important',
				],
			]
		);

        $this->add_control(
			'sticky_indicator_color',
			[
				'label' => __( 'Indicator Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.is-stuck {{WRAPPER}} .lqd-scrl-indc-el' => 'background-color: {{VALUE}}',
				],
			]
		);	
		$this->end_controls_section();

        // Colors Over Light Rows
        $this->start_controls_section(
			'sticky_light_sh_colors',
			array(
				'label' => __( 'Colors Over Light Rows', 'archub-elementor-addons' ),
			)
		);

        $this->add_control(
			'sticky_light_primary_color',
			[
				'label' => __( 'Primary Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-light a' => 'color: {{VALUE}}',
					'{{WRAPPER}}.lqd-active-row-light .lqd-scrl-indc-line' => 'background-color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'sticky_light_bar_color',
			[
				'label' => __( 'Bar Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-light .lqd-scrl-indc-line' => 'background-color: {{VALUE}}!important',
				],
			]
		);

        $this->add_control(
			'sticky_light_indicator_color',
			[
				'label' => __( 'Indicator Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-light .lqd-scrl-indc-el' => 'background-color: {{VALUE}}',
				],
			]
		);	
		$this->end_controls_section();

        // Colors Over Dark Rows
        $this->start_controls_section(
			'sticky_dark_sh_colors',
			array(
				'label' => __( 'Colors Over Dark Rows', 'archub-elementor-addons' ),
			)
		);

        $this->add_control(
			'sticky_dark_primary_color',
			[
				'label' => __( 'Primary Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-dark a' => 'color: {{VALUE}}',
					'{{WRAPPER}}.lqd-active-row-dark .lqd-scrl-indc-line' => 'background-color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'sticky_dark_bar_color',
			[
				'label' => __( 'Bar Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-dark .lqd-scrl-indc-line' => 'background-color: {{VALUE}}!important',
				],
			]
		);

        $this->add_control(
			'sticky_dark_indicator_color',
			[
				'label' => __( 'Indicator Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-dark .lqd-scrl-indc-el' => 'background-color: {{VALUE}}',
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

		$el_classnames = array(
			'lqd-scrl-indc',
			'd-flex',
			'ws-nowrap',
			'lqd-scrl-indc-style-'.$settings['indicator_type'],
		);

		$indicator_el_classnames = array(
			'lqd-scrl-indc-el',
			'd-inline-block',
		);

		if ( $settings['indicator_type'] === 'line' ) {
			$indicator_el_classnames[] = 'lqd-overlay';
			$indicator_el_classnames[] = 'border-radius-2';
		} else {
			$indicator_el_classnames[] = 'pos-abs';
			$indicator_el_classnames[] = 'border-radius-4';
		}

		$options = wp_json_encode(
			array(
				'scale' => $settings['indicator_type'] === 'line' ? true : false,
				'end' => 'bottom bottom'
			)
		);

		?>

			<div class="<?php echo ld_helper()->sanitize_html_classes( $el_classnames ); ?>" data-lqd-scroll-indicator="true" data-scrl-indc-options='<?php echo $options ?>'>
					<a href="#wrap" data-localscroll="true">
							<span class="lqd-scrl-indc-inner d-flex align-items-center">
									<span class="lqd-scrl-indc-txt"><?php echo esc_html( $settings['text'] ) ?></span>
									<span class="lqd-scrl-indc-line border-radius-2 flex-grow-1 pos-rel">
											<span class="<?php echo ld_helper()->sanitize_html_classes( $indicator_el_classnames ); ?>"></span>
									</span>
							</span>
					</a>
			</div>
						
		<?php

	}

}
