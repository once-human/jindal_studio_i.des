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
class LD_Accordion extends Widget_Base {

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
		return 'ld_accordion';
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
		return __( 'Liquid Accordion', 'archub-elementor-addons' );
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
		return 'eicon-accordion lqd-element';
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
		return [ 'accordion', 'tab', 'toggle' ];
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

		// Items Section
		$this->start_controls_section(
			'items_section',
			[
				'label' => __( 'Items', 'archub-elementor-addons' ),
			]
		);

		$this->add_control(
			'active_tab',
			[
				'label' => __( 'Active tab', 'archub-elementor-addons' ),
				'description' => __( 'Enter active tab. Set this to -1 if you want all the tabs closed.', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => '1',
			]
		);
		
		$repeater = new Repeater();

		$repeater->add_control(
			'title',
			array(
				'label' => __( 'Title', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Accordion Title', 'archub-elementor-addons' ),
				'dynamic' => array(
					'active' => true,
				),
				'label_block' => true,
			)
		);
		$repeater->add_control(
			'content',
			array(
				'label' => __( 'Content', 'archub-elementor-addons' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => __( 'Accordion Content', 'archub-elementor-addons' ),
				'show_label' => false,
			)
		);

		$this->add_control(
			'items',
			array(
				'label' => __( 'Accordion Items', 'archub-elementor-addons' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'title' => __( 'Accordion #1', 'archub-elementor-addons' ),
						'content' => __( '<p>Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>', 'archub-elementor-addons' ),
					],
					[
						'title' => __( 'Accordion #2', 'archub-elementor-addons' ),
						'content' => __( '<p>Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>', 'archub-elementor-addons' ),
					],
				],
				'title_field' => '{{{ title }}}',
			)
		);

		$this->add_control(
			'title_tag',
			array(
				'label' => esc_html__( 'Title Element Tag', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
					'span' => 'span',
					'p' => 'p',
				],
				'default' => 'h4',
			)
		);
		$this->end_controls_section();

		// General Section
		$this->start_controls_section(
			'general_section',
			array(
				'label' => __( 'Accordion', 'archub-elementor-addons' ),
			)
		);

		$this->add_control(
			'size',
			[
				'label' => __( 'Title height', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'sm',
				'options' => [
					'xs' => __( 'Shortest', 'archub-elementor-addons' ),
					'sm' => __( 'Short', 'archub-elementor-addons' ),
					'md' => __( 'Medium', 'archub-elementor-addons' ),
					'lg' => __( 'Tall', 'archub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'borders',
			[
				'label' => __( 'Border style', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'None', 'archub-elementor-addons' ),
					'accordion-title-bordered' => __( 'Title Bordered', 'archub-elementor-addons' ),
					'accordion-title-underlined' => __( 'Title Underlined', 'archub-elementor-addons' ),
					'accordion-body-underlined' => __( 'Content Underlined', 'archub-elementor-addons' ),
					'accordion-body-bordered' => __( 'Content Bordered', 'archub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'border_round',
			[
				'label' => __( 'Title border round', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'None', 'archub-elementor-addons' ),
					'accordion-title-round' => __( 'Round', 'archub-elementor-addons' ),
					'accordion-title-circle' => __( 'Circle', 'archub-elementor-addons' ),
				],
				'condition' => array(
					'borders' => 'accordion-title-bordered',
				)
			]
		);

		$this->add_control(
			'body_border_round',
			[
				'label' => __( 'Items border round', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'None', 'archub-elementor-addons' ),
					'accordion-body-round' => __( 'Round', 'archub-elementor-addons' ),
				],
				'condition' => array(
					'borders' => 'accordion-body-bordered',
				)
			]
		);

		$this->add_control(
			'items_shadow',
			[
				'label' => __( 'Items Shadow', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'heading_shadow',
			[
				'label' => __( 'Headings shadow', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'active_style',
			[
				'label' => __( 'Active heading shadow', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => ''
			]
		);

		$this->end_controls_section();

		// Expander Section
		$this->start_controls_section(
			'expander_section',
			[
				'label' => __( 'Expander', 'archub-elementor-addons' ),
			]
		);

		$this->add_control(
			'show_icon',
			[
				'label' => __( 'Enable expander', 'archub-elementor-addons' ),
				'description' => __( 'If enabled will show icons in expander', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'expander_position',
			[
				'label' => __( 'Expander position', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Default', 'archub-elementor-addons' ),
					'accordion-expander-left' => __( 'Left', 'archub-elementor-addons' ),
				],
				'condition' => array(
					'show_icon' => 'yes',
				)
			]
		);

		$this->add_control(
			'expander_size',
			[
				'label' => __( 'Expander size', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Normal', 'archub-elementor-addons' ),
					'accordion-expander-lg' => __( 'Large ( 22px )', 'archub-elementor-addons' ),
					'accordion-expander-xl' => __( 'xLarge ( 26px )', 'archub-elementor-addons' ),
				],
				'condition' => array(
					'show_icon' => 'yes',
				)
			]
		);

		$this->add_control(
			'i_type',
			[
				'label' => __( 'Icon library', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'fontawesome',
				'options' => [
					'fontawesome'  => __( 'Icon Library', 'archub-elementor-addons' ),
					'image' => __( 'Image', 'archub-elementor-addons' ),
				],
				'condition' => array(
					'show_icon' => 'yes'
				)
			]
		);

		$this->add_control(
			'i_icon_fontawesome',
			[
				'label' => __( 'Icon', 'archub-elementor-addons' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fa fa-chevron-down',
					'library' => 'solid',
				],
				'condition' => array(
					'i_type' => 'fontawesome',
					'show_icon' => 'yes'
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
					'show_icon' => 'yes'
				),
			]
		);

		// active icon
		$this->add_control(
			'active_type',
			[
				'label' => __( 'Icon library', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'fontawesome',
				'options' => [
					'fontawesome'  => __( 'Icon Library', 'archub-elementor-addons' ),
					'image' => __( 'Image', 'archub-elementor-addons' ),
				],
				'condition' => array(
					'show_icon' => 'yes'
				)
			]
		);

		$this->add_control(
			'active_icon_fontawesome',
			[
				'label' => __( 'Icon', 'archub-elementor-addons' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fa fa-chevron-up',
					'library' => 'solid',
				],
				'condition' => array(
					'active_type' => 'fontawesome',
					'show_icon' => 'yes'
				),
			]
		);

		$this->add_control(
			'active_icon_image',
			[
				'label' => __( 'Image', 'archub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'condition' => array(
					'active_type' => 'image',
					'show_icon' => 'yes'
					),
			]
		);

		$this->end_controls_section();

		// Style Tab
		$this->start_controls_section(
			'items_style_section',
			[
				'label' => __( 'Items', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'accordion_item_border',
				'selector' => '{{WRAPPER}} .accordion-item'
			]
		);

		$this->add_control(
			'accordion_item_border_radius',
			[
				'label' => __( 'Item border radius', 'archub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .accordion-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before'
			]
		);
		
		$this->add_responsive_control(
			'bottom_margin',
			[
				'label' => __( 'Items bottom space', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .accordion-item:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'label' => __( 'Item box shadow', 'archub-elementor-addons' ),
				'name' => 'accordion_item_boxshadow',
				'selector' => '{{WRAPPER}} .accordion-item',
				'separator' => 'before'
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'heading_style_section',
			[
				'label' => __( 'Heading', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'heading_typography',
				'label' => __( 'Heading typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .accordion-title a',
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label' => __( 'Heading color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .accordion-title a' => 'color: {{VALUE}}',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'active_heading_color',
			[
				'label' => __( 'Active heading color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .accordion-item.active .accordion-title a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'heading_option',
			[
				'label' => __( 'Heading background', 'archub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'heading_bg_color',
				'label' => __( 'Heading background', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .accordion-title a',
			]
		);

		$this->add_control(
			'active_heading_option',
			[
				'label' => __( 'Active heading background', 'archub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'heading_active_bg_color',
				'label' => __( 'Active heading background', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .accordion-item.active .accordion-title a',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'accordion_heading_border',
				'selector' => '{{WRAPPER}} .accordion-title a',
				'separator' => 'before'
			]
		);

		$this->add_control(
			'border_color',
			[
				'label' => __( 'Heading border color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .accordion-title a, {{WRAPPER}} .accordion-item' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'active_border_color',
			[
				'label' => __( 'Active heading border color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .accordion-item.active .accordion-title a, {{WRAPPER}} .accordion-item.active' => 'border-color: {{VALUE}}',
				],
			]
		);		

		$this->add_responsive_control(
			'accordion_heading_padding',
			[
				'label' => __( 'Heading padding', 'archub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .accordion-title a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'accordion_heading_border_radius',
			[
				'label' => __( 'Heading border radius', 'archub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .accordion-title a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'accordion_active_heading_border_radius',
			[
				'label' => __( 'Active Heading border radius', 'archub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .accordion-item.active .accordion-title a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'label' => __( 'Heading box shadow', 'archub-elementor-addons' ),
				'name' => 'accordion_heading_boxshadow',
				'selector' => '{{WRAPPER}} .accordion-title a',
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'label' => __( 'Active heading box shadow', 'archub-elementor-addons' ),
				'name' => 'accordion_active_heading_boxshadow',
				'selector' => '{{WRAPPER}} .accordion-item.active .accordion-title a',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'content_style_section',
			[
				'label' => __( 'Content', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => __( 'Content typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .accordion-content',
			]
		);

		$this->add_control(
			'content_color',
			[
				'label' => __( 'Content text color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .accordion-content' => 'color: {{VALUE}}',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'bg_options',
			[
				'label' => __( 'Content background', 'archub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'content_bg',
				'label' => __( 'Content background', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .accordion-content'
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label' => __( 'Content padding', 'archub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .accordion-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before'
			]
		);

		$this->end_controls_section();

		// Expander color section
		$this->start_controls_section(
			'expander_style_section',
			[
				'label' => __( 'Expander', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'show_icon' => 'yes',
				)
			]
		);

		$this->add_control(
			'expander_size_slider',
			[
				'label' => __( 'Expander size', 'archub-elementor-addons' ),
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
					'size' => 16,
				],
				'selectors' => [
					'{{WRAPPER}} .accordion-expander' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => array(
					'show_icon' => 'yes',
				)
			]
		);

		$this->add_control(
			'exp_color',
			[
				'label' => __( 'Expander color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .accordion-expander' => 'color: {{VALUE}}',
				],
				'condition' => array(
					'show_icon' => 'yes'
				)
			]
		);

		$this->add_control(
			'active_exp_color',
			[
				'label' => __( 'Expander active color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .accordion-item.active .accordion-expander' => 'color: {{VALUE}}',
				],
				'condition' => array(
					'show_icon' => 'yes'
				)
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

		$wrapper_class = array(
			'accordion',
			'accordion-' . $settings['size'],
			$settings['expander_position'],
		);

		$settings['active_tab'] = ! empty( $settings['active_tab'] ) ? intval( $settings['active_tab'] ) - 1 : 0;
		$parent = uniqid( 'accordion-' );

		?>

		<div class="<?php echo ld_helper()->sanitize_html_classes( $wrapper_class ); ?>" id="<?php echo esc_attr($parent) ?>" role="tablist" aria-multiselectable="true">
			<?php $id_int = substr( $this->get_id_int(), 0, 3 ); ?>
			<?php foreach (  $settings['items'] as $i => $item ) : ?>
			<?php
			$tab_count = $i + 1;
			$tab_content_setting_key = $this->get_repeater_setting_key( 'content', 'items', $i );
			$this->add_render_attribute( $tab_content_setting_key, [
				'class' => [ 'accordion-content' ],
			] );
	
			$this->add_inline_editing_attributes( $tab_content_setting_key, 'advanced' );

			$in = $i == $settings['active_tab'] ? ' in' : '';
			$active = $i == $settings['active_tab'] ? ' active' : '';
			$expanded = $i == $settings['active_tab'] ? 'true' : 'false';
			$body_roundness = '';
			$collapsed = $i == $settings['active_tab'] ? '' : 'collapsed';

			?>
			<div class="accordion-item panel <?php echo esc_attr($active); ?>">
				
				<div class="accordion-heading" role="tab" id="<?php echo esc_attr('heading-'.$id_int . $tab_count) ?>">
				<<?php echo $settings['title_tag'];?> class="accordion-title">
					<a class="<?php echo esc_attr($collapsed) ?>" role="button" data-toggle="collapse" 
					data-parent="#<?php echo esc_attr($parent) ?>" href="#<?php echo esc_attr('collapse-'.$id_int . $tab_count); ?>" 
					aria-expanded="<?php echo esc_attr($expanded) ?>" aria-controls="<?php echo esc_attr('collapse-'.$id_int . $tab_count); ?>">
						<?php if ( $settings['show_icon'] === 'yes' && $settings['expander_position'] === 'accordion-expander-left' ) : ?>
							<?php echo $this->get_expander(); ?>
						<?php endif; ?>
						<span class="accordion-title-txt"><?php echo esc_html($item['title']); ?></span>
						<?php if ( $settings['show_icon'] === 'yes' && $settings['expander_position'] === '' ) : ?>
							<?php echo $this->get_expander(); ?>
						<?php endif; ?>
					</a>
				</<?php echo $settings['title_tag'];?>>
				</div>
				
				<div id="<?php echo esc_attr('collapse-'.$id_int . $tab_count); ?>" class="accordion-collapse collapse <?php echo esc_attr($in) ?>" role="tabpanel" aria-labelledby="<?php echo esc_attr('heading-'.$id_int . $tab_count); ?>">

				<div <?php echo $this->get_render_attribute_string( $tab_content_setting_key ); ?>>
					<?php echo wp_kses_post($item['content']); ?>
				</div>
						
				</div>
				
			</div>
			<?php endforeach; ?>
			
		</div>

		<?php

	}

	protected function content_template() {
		?>

		<#

		const wrapper_class = [
			'accordion', 
			'accordion-' + settings.size,
			settings.expander_position,
		].filter(classname => classname !== '');

		const parent = 'accordion-' + Date.now();
		view.addRenderAttribute(
			'wrapper',
			{
				'class': [ wrapper_class.join(' ') ],
				'id': parent,
				'role': 'tablist',
				'aria-multiselectable': 'true',
			}
		);

		settings.active_tab = settings.active_tab ? settings.active_tab - 1 : 0;

		#>
		<div {{{ view.getRenderAttributeString( 'wrapper' ) }}}>
		<#
			if ( settings.items ) {

				var tabindex = view.getIDInt().toString().substr( 0, 3 );

				_.each( settings.items, function( item, i ) {

					function get_expander() {

						return `<span class="accordion-expander">
							<i class="${settings.i_icon_fontawesome.value}"></i>
							<i class="${settings.active_icon_fontawesome.value}"></i>
						</span>`;

					}

					var tabCount = i + 1,
						__in = i == settings.active_tab ? ' in' : '',
						active = i == settings.active_tab ? ' active' : '',
						expanded = i == settings.active_tab ? 'true' : 'false',
						collapsed = i == settings.active_tab ? '' : 'collapsed',
						tabTitleKey = view.getRepeaterSettingKey( 'title', 'items', i ),
						tabContentKey = view.getRepeaterSettingKey( 'content', 'items', i );

					view.addRenderAttribute( tabTitleKey, {
						'class': collapsed,
						'role': 'button',
						'data-toggle': 'collapse',
						'data-parent': '#' + parent,
						'href': '#collapse-' + tabindex + tabCount,
						'aria-expanded': expanded,
						'aria-controls': 'collapse-' + tabindex + tabCount
					} );

					view.addRenderAttribute( tabContentKey, {
						'class': [ 'accordion-content' ],
					} );

					view.addInlineEditingAttributes( tabContentKey, 'advanced' );

				#>

				<div class="accordion-item panel{{{ active }}}">
					<div class="accordion-heading" role="tab" id="heading-{{{ tabindex + tabCount }}}">
					<{{{settings.title_tag}}} class="accordion-title">
						<a {{{ view.getRenderAttributeString( tabTitleKey ) }}} >
							<# if ( settings.show_icon && settings.expander_position === 'accordion-expander-left' ) { #>
								{{{get_expander()}}}
							<# } #>
							<span class="accordion-title-txt">{{{ item.title }}}</span>
							<# if ( settings.show_icon && settings.expander_position === '' ) { #>
								{{{get_expander()}}}
							<# } #>
						</a>
					</{{{settings.title_tag}}}>
					</div>
					
					<div id="collapse-{{{ tabindex + tabCount }}}" class="accordion-collapse collapse {{{ __in }}}" role="tabpanel" aria-labelledby="heading-{{{ tabindex + tabCount }}}">

					<div {{{ view.getRenderAttributeString( tabContentKey ) }}}>{{{ item.content }}}</div>
							
					</div>
				</div>
				
				<#
				} );
			}
		#>
		</div>
		<?php
	}

	protected function get_expander() {

		$settings = $this->get_settings_for_display();
		$normal_icon = $settings['i_icon_fontawesome']['value'];
		$active_icon = $settings['active_icon_fontawesome']['value'];

		return sprintf('<span class="accordion-expander"><i class="%1$s"></i><i class="%2$s"></i></span>', $normal_icon, $active_icon);

	}

}
