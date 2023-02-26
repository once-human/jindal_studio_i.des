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
class LD_Fancy_Heading extends Widget_Base {

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
		return 'hub_fancy_heading';
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
		return __( 'Liquid Text', 'elementor' );
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
		return 'eicon-t-letter lqd-element';
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
		return [ 'heading', 'title', 'text' ];
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
			return [ 'splittext' ];
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

		$this->start_controls_section(
			'section_section_title',
			array(
				'label' => __( 'Title', 'archub-elementor-elementor' ),
			)
		);
		
		$this->add_control(
			'content',
			array(
				'label' => __( 'Title', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'dynamic' => array(
					'active' => true,
				),
				'rows' => '6',
				'default' => 'Add Your Heading Text Here',
			)
		);

		$this->add_control(
			'content_description',
			[
				'type' => Controls_Manager::RAW_HTML,
				'raw' => sprintf( __( '<div style="font-style:normal">If you want to use highlighted text use shortcode. Example:<br/><br/> <span style="font-weight:bold">[ld_highlight]</span> Your Text <span style="font-weight:bold">[/ld_highlight]</span></div>', 'archub-elementor-addons' ) ),
				'separator' => 'after',
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);

		$this->add_control(
			'tag',
			array(
				'label' => esc_html__( 'Element Tag', 'archub-elementor-addons' ),
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
				'default' => 'h2',
			)
		);

		$this->add_responsive_control(
			'alignment',
			[
				'label' => __( 'Alignment', 'archub-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'archub-elementor-addons' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'archub-elementor-addons' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'archub-elementor-addons' ),
						'icon' => 'fa fa-align-right',
					],
					'justify' => [
						'title' => __( 'Justify', 'archub-elementor-addons' ),
						'icon' => 'fa fa-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ld-fancy-heading' => 'text-align: {{VALUE}}',
				],
				'toggle' => true,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'title_format_section',
			[
				'label' => __( 'Style', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'color',
			array(
				'label' => __( 'Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ld-fh-element, {{WRAPPER}} .ld-fh-element a' => 'color:{{VALUE}}',
				],
				'separator' => 'before',
				'condition' => [
					'add_gradient' => ''
				]
			)
		);

		$this->add_control(
			'color_hover',
			array(
				'label' => __( 'Hover color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .ld-fancy-heading:hover .ld-fh-element, {{WRAPPER}} .ld-fancy-heading:hover .ld-fh-element a' => 'color:{{VALUE}}',
				],
				'condition' => [
					'add_gradient' => ''
				]
			)
		);

		$this->add_control(
			'add_gradient',
			[
				'label' => __( 'Gradient and mask image?', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
				'separator' => 'before'
			]
		);


		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'color2',
				'label' => __( 'Fancy heading background', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],	
				'selector' => '{{WRAPPER}} .ld-fh-element',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
				'condition' => array(
					'add_gradient' => 'yes',
				)
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => __( 'Typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .ld-fh-element',
				'separator' => 'before'
			]
		);

		$this->add_control(
			'use_inheritance',
			[
				'label' => __( 'Inherit font styles?', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'true',
				'default' => 'false',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'tag_to_inherite',
			array(
				'label' => esc_html__( 'Element Tag', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
				],
				'default' => 'h1',
				'condition' => array(
					'use_inheritance' => 'true',
				),

			)
		);

		$this->add_control(
			'link',
			[
				'label' => __( 'URL (link)', 'archub-elementor-addons' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'archub-elementor-addons' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => false,
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		// Animation Section
		$this->start_controls_section(
			'animation_section',
			[
				'label' => __( 'Effects', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'enable_split',
			[
				'label' => __( 'Enable text split?', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'true',
				'default' => '',
				'separator' => 'before',
				'frontend_available' => true
			]
		);

		$this->add_control(
			'split_type',
			[
				'label' => __( 'Splitting type', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'lines',
				'options' => [
					'lines'  => __( 'Lines', 'archub-elementor-addons' ),
					'words' => __( 'Words', 'archub-elementor-addons' ),
					'chars, words' => __( 'Characters', 'archub-elementor-addons' ),
				],
				'condition' => [
					'enable_split' => 'true',
				],
				'frontend_available' => true
			]
		);

		$this->add_control(
			'use_mask',
			[
				'label' => __( 'Enabled mask?', 'archub-elementor-addons' ),
				'description' => __('Check to enable mask on title to use it in animation', 'archub-elementor-addons'),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'true',
				'default' => '',
				'condition' => [
					'enable_split' => 'true',
				],
			]
		);

		$this->add_control(
			'enable_txt_rotator',
			[
				'label' => __( 'Enable text rotator?', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'no',
				'separator' => 'before'
			]
		);

		$this->add_control(
			'rotator_delay', [
				'label' => __( 'Words stay time', 'archub-elementor-addons' ),
				'description' => __( 'Stay time for each word in seconds. Default is 2 seconds', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'condition' => array(
					'enable_txt_rotator' => 'yes',
				),
			]
		);

		$this->add_control(
			'rotator_type',
			[
				'label' => __( 'Animation type', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''  => __( 'Slide', 'archub-elementor-addons' ),
					'basic' => __( 'Basic', 'archub-elementor-addons' ),
				],
				'condition' => array(
					'enable_txt_rotator' => 'yes',
				),
			]
		);

		$this->add_control(
			'word_colors',
			[
				'label' => __( 'Words color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'condition' => array(
					'enable_txt_rotator' => 'yes',
				),
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .txt-rotate-keywords' => 'color: {{VALUE}}',
				],
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'word', [
				'label' => __( 'Title word', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'word_color',
			[
				'label' => __( 'Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
			]
		);

		$this->add_control(
			'items',
			[
				'label' => __( 'Text rotator words', 'archub-elementor-addons' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ word }}}',
				'condition' => array(
					'enable_txt_rotator' => 'yes',
				),
			]
		);

		$this->end_controls_section();

		// White Space Section
		$this->start_controls_section(
			'white_space_section',
			[
				'label' => __( 'White space', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'whitespace',
			[
				'label' => __( 'Whitespace', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'normal',
				'options' => [
					'normal'  => __( 'Normal', 'archub-elementor-addons' ),
					'nowrap' => __( 'Nowrap', 'archub-elementor-addons' ),
				],
				'selectors' => [
					'{{WRAPPER}} .ld-fh-element' => 'white-space: {{VALUE}}',
				]
			]
		);
		
		$this->end_controls_section();

		// Highlight Section
		$this->start_controls_section(
			'highlight_section',
			[
				'label' => __( 'Highlight', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'highlight_type',
			[
				'label' => __( 'Type', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'lqd-highlight-underline',
				'options' => [
					''  => __( 'None', 'archub-elementor-addons' ),
					'lqd-highlight-underline'  => __( 'Classic', 'archub-elementor-addons' ),
					'lqd-highlight-custom-underline' => __( 'Custom 1', 'archub-elementor-addons' ),
					'lqd-highlight-custom-underline lqd-highlight-custom-underline-alt' => __( 'Custom 2', 'archub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'highlight_animation',
			[
				'label' => __( 'Animation', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'lqd-highlight-grow-left',
				'options' => [
					'lqd-highlight-grow-left'  => __( 'Grow From Left', 'archub-elementor-addons' ),
					'lqd-highlight-grow-bottom' => __( 'Grow From Bottom', 'archub-elementor-addons' ),
					'lqd-highlight-fadein' => __( 'Fade In', 'archub-elementor-addons' ),
				],
				'condition' => array(
					'highlight_type' => 'lqd-highlight-underline',
				),
			]
		);

		$this->add_control(
			'highlight_reset_onhover',
			[
				'label' => __( 'Fill text on hover?', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'no',
				'condition' => array(
					'highlight_type' => 'lqd-highlight-underline',
				),
			]
		);

		$this->add_control(
			'highlight_color',
			[
				'label' => __( 'Backround color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'condition' => array(
					'highlight_type' => 'lqd-highlight-underline',
				),
				'selectors' => [
					'{{WRAPPER}} .lqd-highlight-inner' => 'background: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'highlight_alt_color',
			[
				'label' => __( 'Backround color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'highlight_type' => 'lqd-highlight-custom-underline lqd-highlight-custom-underline-alt',
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-highlight-inner .lqd-highlight-brush-svg-2' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'highlight_color_brush',
			[
				'label' => __( 'Backround color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'condition' => array(
					'highlight_type' => 'lqd-highlight-custom-underline',
				),
				'selectors' => [
					'{{WRAPPER}} .lqd-highlight-inner .lqd-highlight-brush-svg' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'highlight_height',
			[
				'label' => __( 'Height', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => '0.275em',
				'placeholder' => __( 'Add line height in px, for ex 2px', 'archub-elementor-addons' ),
				'condition' => array(
					'highlight_type!' => array(
						'',
						'lqd-highlight-custom-underline lqd-highlight-custom-underline-alt'
					),
				),
				'selectors' => [
					'{{WRAPPER}} .lqd-highlight-inner' => 'height: {{VALUE}}',
					'{{WRAPPER}} .lqd-highlight-inner .lqd-highlight-brush-svg' => 'height: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'highlight_offset',
			[
				'label' => __( 'Bottom offset', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => '0em',
				'placeholder' => __( 'Add line bottom offset, for ex -10px', 'archub-elementor-addons' ),
				'condition' => array(
					'highlight_type!' => '',
				),
				'selectors' => [
					'{{WRAPPER}} .lqd-highlight-inner' => 'bottom: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'highlight_roudness',
			[
				'label' => __( 'Roundness', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Add line roudness in px, for ex 5px', 'archub-elementor-addons' ),
				'condition' => array(
					'highlight_type' => 'lqd-highlight-underline',
				),
				'selectors' => [
					'{{WRAPPER}} .lqd-highlight-inner' => 'border-radius: {{VALUE}}',
				],
			]
		);
		$this->end_controls_section();

		// Outline Section
		$this->start_controls_section(
			'outline_section',
			[
				'label' => __( 'Outline', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'hover_text_outline',
			[
				'label' => __( 'Outline text', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'ld-fh-outline',
				'default' => '',
			]
		);

		$this->add_control(
			'outline_appearance',
			[
				'label' => __( 'Appearance', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''  => __( 'None', 'archub-elementor-addons' ),
					'ld-fh-outline-static' => __( 'Default', 'archub-elementor-addons' ),
					'ld-fh-outline' => __( 'On Hover', 'archub-elementor-addons' ),
				],
				'condition' => array(
					'hover_text_outline' => 'ld-fh-outline',
				),
			]
		);

		$this->add_control(
			'hover_text_outline_color',
			[
				'label' => __( 'Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ld-fh-txt-outline' => '-webkit-text-stroke-color: {{VALUE}}', 
				],
				'condition' => array(
					'hover_text_outline' => 'ld-fh-outline',
				),
			]
		);

		$this->add_control(
			'hover_text_hover_outline_color',
			[
				'label' => __( 'Hover color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ld-fancy-heading:hover .ld-fh-txt-outline' => '-webkit-text-stroke-color: {{VALUE}}', 
				],
				'condition' => array(
					'hover_text_outline' => 'ld-fh-outline',
					'outline_appearance' => 'ld-fh-outline-static'
				),
			]
		);

		$this->add_control(
			'hover_text_outline_width',
			[
				'label' => __( 'Width', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => '2px',
				'placeholder' => __( 'Set hover text outline width in px. for ex. 5px', 'archub-elementor-addons' ),
				'selectors' => [
					'{{WRAPPER}} .ld-fh-txt-outline' => '-webkit-text-stroke-width: {{VALUE}}', 
				],
				'condition' => array(
					'hover_text_outline' => 'ld-fh-outline',
				),
			]
		);

		$this->end_controls_section();


		// Vertical Text Section
		$this->start_controls_section(
			'vertical_txt_section',
			[
				'label' => __( 'Vertical text', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'vertical_txt',
			[
				'label' => __( 'Vertical text?', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'true',
				'default' => 'false',
			]
		);
		$this->end_controls_section();


		// Style Tab
		$this->start_controls_section(
			'style_section',
			[
				'label' => __( 'Style', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'ld_inner_margin',
			[
				'label' => __( 'Heading margin', 'archub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'bottom' => '0.5',
					'unit' => 'em',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .ld-fh-element' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'ld_inner_padding',
			[
				'label' => __( 'Heading padding', 'archub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ld-fh-element' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();

		$color_sections_hide = get_post_type() === 'liquid-header' ? '' : '_hide';

		// Sticky Header
		$this->start_controls_section(
			'sticky_colors' . $color_sections_hide,
			[
				'label' => __( 'Sticky color', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'sticky_color',
			array(
				'label' => __( 'Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'.is-stuck {{WRAPPER}} .ld-fh-element, .is-stuck {{WRAPPER}} .ld-fh-element span' => 'color:{{VALUE}} !important;',
				],
				'condition' => [
					'add_gradient' => ''
				]
			)
		);

		$this->end_controls_section();

		// Colors Over Light Rows
		$this->start_controls_section(
			'sticky_light_colors' . $color_sections_hide,
			[
				'label' => __( 'Colors over light rows', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'sticky_light_color',
			array(
				'label' => __( 'Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-light .ld-fh-element, {{WRAPPER}}.lqd-active-row-light .ld-fh-element span' => 'color:{{VALUE}} !important;',
				],
				'condition' => [
					'add_gradient' => ''
				]
			)
		);

		$this->end_controls_section();

		// Colors Over Dark Rows
		$this->start_controls_section(
			'sticky_dark_colors' . $color_sections_hide,
			[
				'label' => __( 'Colors over dark rows', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'sticky_dark_color',
			array(
				'label' => __( 'Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-dark .ld-fh-element, {{WRAPPER}}.lqd-active-row-dark .ld-fh-element span' => 'color:{{VALUE}} !important;',
				],
				'condition' => [
					'add_gradient' => ''
				]
			)
		);

		$this->end_controls_section();
		
		$this->end_controls_tab();

	}

	protected function add_render_attributes() {
		parent::add_render_attributes();

		$settings = $this->get_settings();

		$classnames = [];

		if ( $settings['enable_split'] !== '' ) {
			array_push($classnames, 'lqd-el-has-inner-anim');
		}

		$this->add_render_attribute( '_wrapper', 'class', $classnames );
		
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
		$this->add_inline_editing_attributes( 'content', 'basic' );

		$classes = array( 
			'ld-fancy-heading',
			'pos-rel',
			($settings['use_mask'] === 'true' ? 'mask-text' : ''),
			$settings['hover_text_outline'],
			$settings['outline_appearance'],
		);

		$id = uniqid("ld-fancy-heading-");

		?>

		<div id="<?php echo esc_attr( $id ); ?>" class="<?php echo ld_helper()->sanitize_html_classes( $classes ); ?>">
			<?php $this->fancy_title(); ?>
		</div>

		<?php
	}

	protected function content_template() {

		?>
		<#

		const wrapperClassnames = [
			settings.use_mask === 'true' ? 'mask-text' : '',
			settings.hover_text_outline,
			settings.outline_appearance,
		].filter(classname => classname !== '');

		const highlightType = settings.highlight_type;
		let highlightClassname = highlightType;

		if ( highlightType === 'lqd-highlight-underline' ) {
			highlightClassname = 'lqd-highlight-classic';
		} else if ( highlightType === 'lqd-highlight-custom-underline' ) {
			highlightClassname = 'lqd-highlight-custom lqd-highlight-custom-1';
		} else if ( highlightType === 'lqd-highlight-custom-underline lqd-highlight-custom-underline-alt' ) {
			highlightClassname = 'lqd-highlight-custom lqd-highlight-custom-2';
		}

		const titleClassnames = [
			settings.add_gradient === 'yes' && settings.color2 !== '' ? 'ld-gradient-heading' : '',
			settings.whitespace,
			highlightClassname,
			settings.highlight_animation,
			settings.highlight_reset_onhover === 'yes' ? 'lqd-highlight-reset-onhover' : '',
			settings.vertical_txt === 'true' ? 'text-vertical' : '',
			settings.enable_split === 'true' ? getSplitClassnames() : '',
			settings.use_inheritance === 'true' ? settings.tag_to_inherite : settings.tag,
			settings.tag !== 'p' && settings.tag !== 'div' && settings.tag !== 'span' ? 'elementor-heading-title' : ''
		].filter(classname => classname !== '');

		const title = settings.content;
		const link = settings.link.url;

		const wrapperAttrs = {
			'class': ['ld-fancy-heading', 'pos-rel', wrapperClassnames.join(' ')],
			'id': view.model.get('id')
		};

		const titleAttrs = {
			'class': [ 'ld-fh-element', 'd-inline-block', 'pos-rel', titleClassnames.join(' '), 'elementor-inline-editing' ],
			'data-elementor-setting-key': 'content',
			'data-elementor-inline-editing-toolbar': 'basic'
		};

		function getSplitClassnames() {
			const {split_type} = settings;
			let classname = 'lqd-split-';

			if ( split_type === 'chars, words' ) {
				classname += `${classname}chars`;
			} else {
				classname += `${classname}${split_type}`;
			}
			return classname;
		}

		function getTextRotatorWords() {

			if (settings.enable_txt_rotator !== 'yes'){
				return '';
			}

			const words = settings.items;
			let out = '';
			let style_word = '';

			out += ' <span class="txt-rotate-keywords">';
			if ( words ) {
				_.each( words, function( word, i ) {
					var active = ( i === 0 ) ? ' active' : '';
					style_word = ( word.word_color ) ? 'style="color:' + word.word_color + '"' : '';					
					out += '<span class="txt-rotate-keyword" ' + style_word + '><span>' + word.word + '</span></span>';
				} );
			}
			
			out += '</span>';
			return out;
		}

		const getRotatorOpts = (() => {

			if( settings.enable_txt_rotator !== 'yes' ) {
				return '';
			}

			titleAttrs['data-text-rotator'] = true;
			const options = {};

			if( settings.rotator_type === 'basic' ) {
				options['animationType'] = "basic";
			}
			if ( settings.rotator_delay !== '' ) {
				options['delay'] = settings.rotator_delay;
			}

			if ( options ) {
				titleAttrs['data-text-rotator-options'] = JSON.stringify( options );
			}

		})();

		const getHighlightOpts = (() => {

			if ( ! settings.content.includes("ld_highlight") ){
				return;
			}

			titleAttrs['data-inview'] = true;
			titleAttrs['data-transition-delay'] = true;
			titleAttrs['data-delay-options'] = JSON.stringify({ "elements": ".lqd-highlight-inner", "delayType": "transition" });

		})();
		
		// Split Animation
		const getSplitOptions = (() => {

			if( settings.enable_split === '' ) {
				return;
			}

			titleAttrs['data-split-text'] = true;
			titleAttrs['data-split-options'] = JSON.stringify( { "type": settings.split_type } );
			
		})();

		function getSVGHighlight() {

			let svg = '';

			if ( settings.highlight_type === 'lqd-highlight-custom-underline' ) {
				svg = '<svg class="lqd-highlight-brush-svg lqd-highlight-brush-svg-1" xmlns="http://www.w3.org/2000/svg" width="235.509" height="13.504" viewBox="0 0 235.509 13.504" aria-hidden="true" preserveAspectRatio="none"><path d="M163,.383a13.044,13.044,0,0,1,1.517-.072,3.528,3.528,0,0,1,1.237-.134q.618.044,1.237.044a.249.249,0,0,1-.1.178.337.337,0,0,0-.1.266q3.092.088,6.184-.044T178.953.4l-.206-.088a12,12,0,0,0,4.123,0,13.467,13.467,0,0,1,5.772,0q1.443-.178,2.68-.266A5.978,5.978,0,0,1,193.8.4,16.707,16.707,0,0,1,198.01.045q2.164.088,4.844.088-.618.088-.824.134L201.412.4a3.893,3.893,0,0,0,2.061,0,5.413,5.413,0,0,1,1.649-.356q.618.088,1.134.178a9.762,9.762,0,0,0,1.544.09,17,17,0,0,1,3.092-.266q1.649,0,3.5.178,2.886.088,5.875.044t5.875-.222q0,.088.206.088h.412a21.975,21.975,0,0,0,2.577.889A12.458,12.458,0,0,1,232.12,2.18a3.962,3.962,0,0,1,1.031.622A3.349,3.349,0,0,1,234.8,3.825a5.079,5.079,0,0,1,.618,1.111q.412.534-1.031.98-1.031.444-.618.98a2.09,2.09,0,0,1,.206.889q0,.444.825.889.618.8-.206,1.245l-1.237.534q-1.443-.088-2.68-.134a17.255,17.255,0,0,1-2.267-.222,3.128,3.128,0,0,0-.928-.044,3.129,3.129,0,0,1-.928-.044q-2.267-.178-4.432-.266T217.7,9.476q-1.649-.088-2.886-.088a17.343,17.343,0,0,1-2.474-.178q-3.916,0-7.73-.088t-7.73-.266l-12.471-.178q-6.287-.088-12.883-.088h-1.958q-.928,0-1.958.088h-2.061q-1.031,0-2.061-.088-2.68-.088-5.256-.134t-5.256.044h-5.462q-2.577,0-5.462.088-4.535.088-8.76.178t-8.554.088q-2.886.088-5.875.088t-5.875.088q-1.443.088-2.886.134t-3.092.044q-4.741.178-9.791.312t-9.791.312q-2.267.088-4.329.088T78.77,10.1q-4.329.266-8.863.49t-9.276.49q-1.237.088-2.68.134a24.356,24.356,0,0,0-2.683.224q-2.68.178-5.462.312t-5.668.4q-2.474.266-4.741.312t-4.741.044q-1.031-.088-1.958-.134a9.684,9.684,0,0,1-1.958-.312,12.5,12.5,0,0,0-1.443-.312q-.825-.134-1.856-.31-2.886.356-6.39.666t-6.8.845a26.709,26.709,0,0,1-2.886.356,20.758,20.758,0,0,1-9.482-.889Q.232,11.962.026,11.25T1.263,9.917q0-.266.825-.266a13.039,13.039,0,0,0,2.886-.444A17.187,17.187,0,0,1,7.86,8.672q3.092-.266,6.184-.8,1.649-.178,3.3-.312t3.5-.312q4.123-.354,8.039-.712t8.039-.622q9.478-.8,18.758-1.338,2.68-.178,5.153-.356t4.741-.356q2.474-.178,5.05-.356T75.88,3.24h1.34a4.829,4.829,0,0,0,1.34-.178q2.267-.178,4.329-.222t4.329-.134a7.256,7.256,0,0,1,2.267,0,3.459,3.459,0,0,0,1.031-.088,6.009,6.009,0,0,1,2.37-.266,14.745,14.745,0,0,0,2.783-.088q1.649,0,2.474.088a1.308,1.308,0,0,1,.185.011,1.226,1.226,0,0,1,.33-.1,3.656,3.656,0,0,0,.515-.088,4.433,4.433,0,0,1,2.886.266q.412-.088,1.031-.178l1.237-.178q.412,0,1.031.044a5.761,5.761,0,0,0,1.237-.044q2.886-.088,5.772-.044a53.829,53.829,0,0,0,5.772-.222,9.505,9.505,0,0,1,1.34-.088h1.34a4.428,4.428,0,0,1,.821-.258l.825-.178a15.178,15.178,0,0,1,1.855.444,3.028,3.028,0,0,1,1.031-.534,4.039,4.039,0,0,1,1.443-.178,6.158,6.158,0,0,1,1.649.178,5.05,5.05,0,0,0,2.267.268q1.855-.088,3.813-.134T138.13,1.2q1.031,0,2.164-.044t2.37-.044q-.206-.088.412-.534h3.092q.412,0,.309.266t.928,0a5.845,5.845,0,0,1,1.443,0,31.833,31.833,0,0,0,5.359.088,21.471,21.471,0,0,1,6.8.178,5.236,5.236,0,0,0,1.031-.4q.412-.222.825-.4a.694.694,0,0,1,.137.07Z" transform="translate(0 0.002)"/></svg>';
			} else if ( settings.highlight_type === 'lqd-highlight-custom-underline lqd-highlight-custom-underline-alt' ) {
				svg = '<svg class="lqd-highlight-pen" width="51" height="51" viewBox="0 0 51 51" xmlns="http://www.w3.org/2000/svg"><path d="M36.204 1.044C32.02 2.814 5.66 31.155 4.514 35.116c-.632 2.182-1.75 5.516-2.483 7.409-3.024 7.805-1.54 9.29 6.265 6.265 1.893-.733 5.227-1.848 7.41-2.477 3.834-1.105 4.473-1.647 19.175-16.27 0 0 10.63-10.546 15.21-15.125C53 8.997 42.021-1.418 36.203 1.044Zm7.263 5.369c3.56 3.28 4.114 4.749 2.643 6.995l-1.115 1.7-4.586-4.543-4.585-4.544 1.42-1.157C39.311 3.18 40.2 3.4 43.467 6.413ZM37.863 13.3l4.266 4.304-11.547 11.561-11.547 11.561-4.48-4.446-4.481-4.447 11.404-11.418c6.273-6.28 11.566-11.42 11.762-11.42.197 0 2.277 1.938 4.623 4.305ZM12.016 39.03l3.54 3.584-3.562 1.098-5.316 1.641c-1.665.516-1.727.455-1.211-1.21l1.614-5.226c1.289-4.177.685-4.191 4.935.113Z"/></svg><svg class="lqd-highlight-brush-svg lqd-highlight-brush-svg-2" width="233" height="13" viewBox="0 0 233 13" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="none"><path d="m.624 9.414-.312-2.48C0 4.454.001 4.454.002 4.454l.035-.005.102-.013.398-.047c.351-.042.872-.102 1.557-.179 1.37-.152 3.401-.368 6.05-.622C13.44 3.081 21.212 2.42 31.13 1.804 50.966.572 79.394-.48 113.797.24c34.387.717 63.927 2.663 84.874 4.429a1048.61 1048.61 0 0 1 24.513 2.34 641.605 641.605 0 0 1 8.243.944l.432.054.149.02-.318 2.479-.319 2.48-.137-.018c-.094-.012-.234-.03-.421-.052a634.593 634.593 0 0 0-8.167-.936 1043.26 1043.26 0 0 0-24.395-2.329c-20.864-1.76-50.296-3.697-84.558-4.413-34.246-.714-62.535.332-82.253 1.556-9.859.612-17.574 1.269-22.82 1.772-2.622.251-4.627.464-5.973.614a213.493 213.493 0 0 0-1.901.22l-.094.01-.028.004Z"/></svg>';
			}
			return svg;
		}

		view.addRenderAttribute( 'wrapperAttributes', wrapperAttrs);

		view.addRenderAttribute( 'titleAttributes', titleAttrs);

		let {content} = settings;

		content = content.replace('/<p>/g', '');
		content = content.replace('/</p>/g', '');

		#>
			<div {{{ view.getRenderAttributeString('wrapperAttributes') }}}>
				<{{{ settings.tag }}} {{{ view.getRenderAttributeString('titleAttributes') }}} >
					<# if( settings.hover_text_outline === 'ld-fh-outline' ) { #>
						<span class="ld-fh-txt-outline">{{{content}}}</span>
					<# } #>
					<# if ( content.includes("[ld_highlight]") && content.includes("[/ld_highlight]") ) {
						content = content.replace('[ld_highlight]', '<mark class="lqd-highlight"><span class="lqd-highlight-txt">');
						content = content.replace('[/ld_highlight]', '</span><span class="lqd-highlight-inner">'+ getSVGHighlight() + '</span></mark>');
						#> {{{content + getTextRotatorWords()}}} <#
					} else { #>
						{{{ content + getTextRotatorWords() }}}
					<# } #>
				</{{{ settings.tag }}}>
			</div>
		<?php

	}

	protected function fancy_title() {

		$settings = $this->get_settings_for_display();
		
		$tag = $settings['tag'];
		
		$classnames = $outline_title = '';
		$classnames_arr = array('ld-fh-element', 'd-inline-block', 'pos-rel');

		if ( $tag !== 'p' && $tag !== 'div' && $tag !== 'span' ) {
			array_push($classnames_arr, 'elementor-heading-title');
		}

		if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
			$classnames_arr[] = 'elementor-inline-editing';
			$inline_edit_attr = 'data-elementor-setting-key="content" data-elementor-inline-editing-toolbar="basic"';
		} else {
			$inline_edit_attr = '';
		}

		$link = isset($settings['link']['url']) ? $settings['link']['url'] : '';
		
		if( !empty( $settings['add_gradient'] ) ) {
			$classnames_arr[] = 'ld-gradient-heading';
		}

		if( !empty( $settings['whitespace'] ) ) {
			$classnames_arr[] = $settings['whitespace'];
		}
		if( !empty( $settings['highlight_type'] ) ) {
			$highlight_type = $settings['highlight_type'];
			$highlight_classname = $highlight_type;
			if ( $highlight_type === 'lqd-highlight-underline' ) {
				$highlight_classname = 'lqd-highlight-classic';
			} else if ( $highlight_type === 'lqd-highlight-custom-underline' ) {
				$highlight_classname = 'lqd-highlight-custom lqd-highlight-custom-1';
			} else if ( $highlight_type === 'lqd-highlight-custom-underline lqd-highlight-custom-underline-alt' ) {
				$highlight_classname = 'lqd-highlight-custom lqd-highlight-custom-2';
			}

			$classnames_arr[] = $highlight_classname;
		}
		if( !empty( $settings['highlight_animation'] ) ) {
			$classnames_arr[] = $settings['highlight_animation'];
		}
		if( !empty( $settings['highlight_reset_onhover'] ) && $settings['highlight_reset_onhover'] === 'yes' ) {
			$classnames_arr[] = 'lqd-highlight-reset-onhover';
		}

		if( $settings['vertical_txt'] === 'true' ) {
			$classnames_arr[] = 'text-vertical';
		}

		if ( $settings['enable_split'] ) {
			$classnames_arr[] = $this->get_split_classname();
		}

		$title = $settings['content'];
		$title = preg_replace('/^<p[^>]*>(.*)<\/p[^>]*>/', '$1', $title);
		$title = do_shortcode( wp_kses_post( $title ) ) . $this->get_title_words();
		$tag_inherit = '';
		if( $settings['use_inheritance'] === 'true' ){
			$classnames_arr[] = $settings['tag_to_inherite'];
		} else {
			$classnames_arr[] = $tag;
		}
		
		if( !empty( $classnames_arr ) ) {
			$classnames = 'class="' . join( ' ', $classnames_arr ) . '"';
		}
		
		if( 'ld-fh-outline' === $settings['hover_text_outline'] ) {
			$outline_title = '<span class="ld-fh-txt-outline">' .  ld_helper()->do_the_content( $title, false ) . '</span>';
		}
		
		// Title
		if( $title ) {
			if ( !empty ( $link ) ) {
				$link_target = $settings['link']['is_external'] === 'on' ? '_blank' : '_self';
				$link = " href=$link " . " target=$link_target ";
				printf( '<%1$s %3$s %4$s><a%5$s %7$s'. $this->get_split_options() .'>%6$s %2$s</a></%1$s>', !empty( $tag ) ? $tag : 'h2', ld_helper()->do_the_content( $title, false ), $classnames, $this->get_data_opts(), esc_attr( $link ), $outline_title, $inline_edit_attr);
			}
			else {
				printf( '<%1$s %3$s %4$s %6$s'. $this->get_split_options() .'>%5$s %2$s</%1$s>', !empty( $tag ) ? $tag : 'h2', ld_helper()->do_the_content( $title, false ), $classnames, $this->get_data_opts(), $outline_title, $inline_edit_attr);
			}
			
		}
		
	}
	
	protected function get_text_rotator_options() {

		$settings = $this->get_settings_for_display();
		
		if( $settings['enable_txt_rotator'] !== 'yes' ) {
			return;
		}
		
		if( $settings['enable_txt_rotator'] !== 'yes' ) {
			return;
		}

		$attrs = array(
			'data-text-rotator' => true,
		);
		$options = array();

		if( 'basic' === $settings['rotator_type'] ) {
			$options['animationType'] = 'basic';
		}

		if ( ! empty( $settings['rotator_delay'] ) ) {
			$options['delay'] = (float) $settings['rotator_delay'];
		}

		if ( ! empty( $options ) ) {
			$attrs['data-text-rotator-options'] = wp_json_encode( $options );
		}
		
		return $attrs;
		
	}

	protected function get_data_opts() {

		
		$opts = array();
		$rotator_opts = $this->get_text_rotator_options();
		$highlight_opts = $this->get_highlight_opts();
		
		if( is_array( $rotator_opts ) && ! empty( $rotator_opts ) ) {
			$opts = array_merge( $opts, $rotator_opts );
		}
		if( is_array( $highlight_opts ) && ! empty( $highlight_opts ) ) {
			$opts = array_merge( $opts, $highlight_opts );
		}
		
		return ld_helper()->html_attributes( $opts );
		
	}

	protected function get_highlight_opts() {

		$settings = $this->get_settings_for_display();
		
		if( !has_shortcode( $settings['content'], 'ld_highlight' )  ) {
			return;
		}
		
		$opts = array(
			'data-inview' => true,
			'data-transition-delay' => true,
			'data-delay-options' => wp_json_encode(
				array(
					'elements' => '.lqd-highlight-inner',
					'delayType' => 'transition'
				)
			)
		);
		
		return $opts;
	
	}

	protected function get_split_classname() {

		$settings = $this->get_settings_for_display();

		$classname = '';
		$prefix = 'lqd-split-';
		$split_type = $settings['split_type'];

		if ( ! $settings['enable_split'] ) {
			return $classname;
		};

		if ( $split_type === 'chars, words' ) {
			$classname = $prefix . 'chars';
		} else {
			$classname = $prefix . $split_type;
		}

		return $classname;

	}

	protected function get_title_words() {

		$settings = $this->get_settings_for_display();
		
		if( $settings['enable_txt_rotator'] !== 'yes' ) {
			return;
		}

		if( empty( $settings['items'] ) ) {
			return;
		}

		$words = $settings['items'] ;

		if( empty( $words ) ) {
			return;
		}
		
		$out = $style_word = '';
		
		$out .= ' <span class="txt-rotate-keywords">';
		$i = 1;
		foreach ( $words as $word ) {
			$active = ( $i == 1 ) ? ' active' : '';
			$style_word = !empty( $word['word_color'] ) ? 'style="color:' . esc_attr( $word['word_color'] ) . '"' : '';
			
			$out .= '<span class="txt-rotate-keyword' . $active . '" ' . $style_word . '><span>' . wp_kses( $word['word'], 'lqd_post' ) . '</span></span>';
			$i++;
		}
		$out .= '</span>';

		return $out;
		
	}

	protected function get_split_options() {

		extract( $this->get_settings_for_display() );

		if( !$enable_split ) {
			return;
		}
		
		$opts = $split_opts = array();
		$split_opts['type'] = $split_type;
		$opts[] = 'data-split-text="true"';
		$opts[] = 'data-split-options=\'' . wp_json_encode( $split_opts ) . '\'';

		return join( ' ', $opts );

	}

}
