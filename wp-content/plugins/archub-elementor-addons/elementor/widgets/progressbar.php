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
 * @since 2.0.0
 */
class LD_Progressbar extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve heading widget name.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ld_progressbar';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve heading widget title.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Liquid Progress Bar', 'archub-elementor-addons' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve heading widget icon.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-skill-bar lqd-element';
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
	 * @since 2.0.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'progressbar', 'skill', 'bar' ];
	}

	/**
	 * Retrieve the list of scripts the counter widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 2.0.0
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
	 * @since 2.0.0
	 * @access protected
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'label',
			[
				'label' => esc_html__( 'Label', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'My skill', 'archub-elementor-addons' ),
				'placeholder' => esc_html__( 'My skill', 'archub-elementor-addons' ),
			]
		);

		$this->add_control(
			'label_position',
			[
				'label' => esc_html__( 'Label position', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''  => esc_html__( 'Default', 'archub-elementor-addons' ),
					'lqd-progressbar-values-bottom'  => esc_html__( 'Bottom', 'archub-elementor-addons' ),
					'lqd-progressbar-values-inside'  => esc_html__( 'Inside', 'archub-elementor-addons' ),
					'lqd-progressbar-values-inline'  => esc_html__( 'Inline', 'archub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'hide_percentage',
			[
				'label' => esc_html__( 'Hide percentage', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'archub-elementor-addons' ),
				'label_off' => esc_html__( 'No', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'percentage',
			[
				'label' => esc_html__( 'Percentage', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 75,
				],
			]
		);
		
		$this->add_control(
			'prefix',
			[
				'label' => esc_html__( 'Prefix', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'condition' => [
					'hide_percentage' => '',
				],
			]
		);
		
		$this->add_control(
			'suffix',
			[
				'label' => esc_html__( 'Suffix', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( '%', 'archub-elementor-addons' ),
				'condition' => [
					'hide_percentage' => '',
				],
			]
		);

		$this->add_responsive_control(
			'size',
			[
				'label' => esc_html__( 'Size', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 15,
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-progressbar-inner' => 'height: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);
		
		$this->add_control(
			'border_radius',
			[
				'label' => esc_html__( 'Border radius', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-progressbar-inner' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'info_padding',
			[
				'label' => __( 'Info spacing', 'archub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-progressbar' => '--details-pt: {{TOP}}{{UNIT}}; --details-pe: {{RIGHT}}{{UNIT}}; --details-pb: {{BOTTOM}}{{UNIT}}; --details-ps: {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'label' => __( 'Title margin', 'archub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-progressbar' => '--title-mt: {{TOP}}{{UNIT}}; --title-me: {{RIGHT}}{{UNIT}}; --title-mb: {{BOTTOM}}{{UNIT}}; --title-ms: {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		// Style Section
		$this->start_controls_section(
			'style_section',
			[
				'label' => esc_html__( 'Style', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Title typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-progressbar-title',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'percentage_typography',
				'label' => __( 'Percentage typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-progressbar-percentage',
			]
		);

		$this->add_control(
			'label_color',
			[
				'label' => esc_html__( 'Label Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-progressbar-title' => 'color: {{VALUE}}',
				],
				'separator' => 'before',
			]
		);
		
		$this->add_control(
			'percentage_color',
			[
				'label' => esc_html__( 'Percentage Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-progressbar-value,{{WRAPPER}} .lqd-progressbar-suffix,{{WRAPPER}} .lqd-progressbar-prefix' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'bar_heading',
			[
				'label' => esc_html__( 'Bar Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'bar',
				'label' => esc_html__( 'Bar Color', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .lqd-progressbar-bar',
			]
		);

		$this->add_control(
			'background_heading',
			[
				'label' => esc_html__( 'Bar Background Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background',
				'label' => esc_html__( 'Bar Background', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .lqd-progressbar-inner',
			]
		);

		$this->end_controls_section();

	}

	protected function get_progressbar_data_options() {
		
		$opts   = array(
			'skipCreateMarkup' => true,
		);
		$percentage  = $this->get_settings_for_display()['percentage']['size'];

		if( !empty( $percentage ) ) {
			$opts['value'] = intval( $percentage );
		}

		return wp_json_encode( $opts );
		
	}

	/**
	 * Render heading widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 2.0.0
	 * @access protected
	 */
	protected function render() {
		
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute(
			'wrapper',
			[
				'id' => 'lqd-progressbar-' . $this->get_ID(),
				'class' => [ 
					'lqd-progressbar',
					'pos-rel',
					$settings['label_position'],
					$settings['label_position'] === 'lqd-progressbar-values-inline' ? 'd-flex' : '',
					$settings['label_position'] === 'lqd-progressbar-values-inline' ? 'flex-column' : '',
				 ],
				 'data-progressbar' => 'true',
				 'data-progressbar-options' => $this->get_progressbar_data_options(),
			]
		);

		$this->add_render_attribute(
			'label',
			[
				'class' => [ 
					'lqd-progressbar-title',
					'ws-nowrap',
				 ],
			]
		);

		$this->add_render_attribute(
			'details',
			[
				'class' => [ 
					'lqd-progressbar-details',
					'd-flex',
					'align-items-center',
					'justify-content-between',
					$settings['label_position'] !== 'lqd-progressbar-values-inside' ? 'pos-rel' : 'lqd-overlay',
					'z-index-3',
				],
			]
		);

		$this->add_render_attribute(
			'inner_details',
			[
				'class' => [ 
					'lqd-progressbar-details',
					'd-flex',
					'align-items-center',
					'justify-content-between',
					'lqd-overlay',
					'z-index-3',
				],
			]
		);

		?>

		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?> >

			<?php if( 'lqd-progressbar-values-bottom' !== $settings['label_position'] ) { ?>
				<div <?php echo $this->get_render_attribute_string( 'details' ); ?>>

					<?php if( !empty( $settings['label'] ) ) : ?>
					<h3 <?php echo $this->get_render_attribute_string( 'label' ); ?> ><?php echo esc_html( $settings['label'] ); ?></h3>
					<?php endif; ?>

					<?php if (
						'yes' !== $settings['hide_percentage'] &&
						'lqd-progressbar-values-inside' !== $settings['label_position'] &&
						'lqd-progressbar-values-inline' !== $settings['label_position']
					) : ?>
					<div class="lqd-progressbar-percentage d-flex align-items-center">

						<?php if( ! empty( $settings['prefix'] ) ) : ?>
						<div class="lqd-progressbar-prefix"><?php echo esc_html( $settings['prefix'] ); ?></div>
						<?php endif; ?>

						<div class="lqd-progressbar-value"></div>
						
						<?php if( ! empty( $settings['suffix'] ) ) : ?>
						<div class="lqd-progressbar-suffix"><?php echo esc_html( $settings['suffix'] ); ?></div>
						<?php endif; ?>

					</div>
					<?php endif; ?>
					
				</div>
			<?php } ?>

			<div class="lqd-progressbar-inner pos-rel w-100 flex-grow-1 overflow-hidden">
				<div class="lqd-progressbar-bar h-100 pos-abs pos-tl">
				<?php if( 'lqd-progressbar-values-inline' === $settings['label_position'] || 'lqd-progressbar-values-inside' === $settings['label_position'] ) { ?>
					<div <?php echo $this->get_render_attribute_string( 'inner_details' ); ?>>

						<?php if ( 'yes' !== $settings['hide_percentage'] ) : ?>
						<span class="lqd-progressbar-percentage d-flex align-items-center ms-auto">

							<?php if( ! empty( $settings['prefix'] ) ) : ?>
							<span class="lqd-progressbar-prefix"><?php echo esc_html( $settings['prefix'] ); ?></span>
							<?php endif; ?>

							<span class="lqd-progressbar-value"></span>
							
							<?php if( ! empty( $settings['suffix'] ) ) : ?>
							<span class="lqd-progressbar-suffix"><?php echo esc_html( $settings['suffix'] ); ?></span>
							<?php endif; ?>

						</span>
						<?php endif; ?>
						
					</div>
				<?php } ?>
				</div>
			</div>

			<?php if( 'lqd-progressbar-values-bottom' === $settings['label_position'] ) { ?>
				<div <?php echo $this->get_render_attribute_string( 'details' ); ?>>

					<?php if( !empty( $settings['label'] ) ) : ?>
					<h3 <?php echo $this->get_render_attribute_string( 'label' ); ?> ><?php echo esc_html( $settings['label'] ); ?></h3>
					<?php endif; ?>

					<?php if ( 'yes' !== $settings['hide_percentage'] ) : ?>
					<div class="lqd-progressbar-percentage d-flex align-items-center">

						<?php if( ! empty( $settings['prefix'] ) ) : ?>
						<div class="lqd-progressbar-prefix"><?php echo esc_html( $settings['prefix'] ); ?></div>
						<?php endif; ?>

						<div class="lqd-progressbar-value"></div>
						
						<?php if( ! empty( $settings['suffix'] ) ) : ?>
						<div class="lqd-progressbar-suffix"><?php echo esc_html( $settings['suffix'] ); ?></div>
						<?php endif; ?>

					</div>
					<?php endif; ?>
					
				</div>
			<?php } ?>

		</div>

		<?php

	}

}
