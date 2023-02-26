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
class LD_Content_Box extends Widget_Base {

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
		return 'ld_content_box';
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
		return __( 'Liquid Box', 'elementor' );
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
		return 'eicon-info-box lqd-element';
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
		return [ 'box', 'image'  ];
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
		return array();
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
				'default' => 's01',
				'options' => [
					's01' => __( 'Style 1', 'archub-elementor-addons' ),
					's01a' => __( 'Style 1 A', 'archub-elementor-addons' ),
					's01b' => __( 'Style 1 B', 'archub-elementor-addons' ),
					's02' => __( 'Style 2', 'archub-elementor-addons' ),
					's03' => __( 'Style 3', 'archub-elementor-addons' ),
					's04' => __( 'Style 4', 'archub-elementor-addons' ),
					's05' => __( 'Style 5', 'archub-elementor-addons' ),
					's06' => __( 'Style 6', 'archub-elementor-addons' ),
					's07' => __( 'Style 7', 'archub-elementor-addons' ),
					's08' => __( 'Style 8', 'archub-elementor-addons' ),
					's09' => __( 'Style 9', 'archub-elementor-addons' ),
					's10' => __( 'Style 10', 'archub-elementor-addons' ),
					's11' => __( 'Style 11', 'archub-elementor-addons' ),
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

		$this->add_control(
			'subtitle',
			[
				'label' => __( 'Subtitle', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Subtitle', 'archub-elementor-addons' ),
				'placeholder' => __( 'Type your subtitle here', 'archub-elementor-addons' ),
				'condition' => [
					'template' => 's06'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'subtitle_typography',
				'label' => __( 'Subtitle Typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} h6',
				'condition' => [
					'template' => 's06'
				]
			]
		);

		$this->add_control(
			'content_alignment',
			[
				'label' => __( 'Content Alignment', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Default', 'archub-elementor-addons' ),
					'lqd-fb-content-br' => __( 'Bottom Right', 'archub-elementor-addons' ),
					'lqd-fb-content-bc' => __( 'Bottom Center', 'archub-elementor-addons' ),
					'lqd-fb-content-mid' => __( 'Middle', 'archub-elementor-addons' ),
				],
				'condition' => [
					'template' => 's08'
				]
			]
		);

		$this->add_control(
			'ct_width',
			[
				'label' => __( 'Content Width', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'w-60',
				'options' => [
					'w-50' => __( '50%', 'archub-elementor-addons' ),
					'w-60' => __( '60%', 'archub-elementor-addons' ),
					'w-70' => __( '70%', 'archub-elementor-addons' ),
					'w-80' => __( '80%', 'archub-elementor-addons' ),
					'w-90' => __( '90%', 'archub-elementor-addons' ),
					'w-100' => __( '100%', 'archub-elementor-addons' ),
				],
				'condition' => [
					'template' => 's08'
				],
			]
		);

		$this->add_responsive_control(
			'ct_alignment',
			[
				'label' => __( 'Alignment', 'archub-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left'    => [
						'title' => __( 'Left', 'archub-elementor-addons' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'archub-elementor-addons' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'archub-elementor-addons' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'prefix_class' => 'elementor%s-align-',
				'default' => 'center',
				'condition' => [
					'template' => ['s09', 's11']
				],
			]
		);

		$this->add_control(
			'box_height',
			[
				'label' => __( 'Box Height', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'h-pt-50',
				'options' => [
					'h-pt-50' => __( '50%', 'archub-elementor-addons' ),
					'h-pt-60' => __( '60%', 'archub-elementor-addons' ),
					'h-pt-70' => __( '70%', 'archub-elementor-addons' ),
					'h-pt-80' => __( '80%', 'archub-elementor-addons' ),
					'h-pt-90' => __( '90%', 'archub-elementor-addons' ),
					'h-pt-100' => __( '100%', 'archub-elementor-addons' ),
					'h-custom' => __( 'Custom', 'archub-elementor-addons' ),
				],
				'condition' => [
					'template' => 's01'
				]
			]
		);

		$this->add_responsive_control(
			'box_height_custom',
			[
				'label' => __( 'Height', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vw', 'vh' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
				],
				'condition' => [
					'box_height' => 'h-custom',
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-fb' => 'height: {{SIZE}}{{UNIT}}; padding: 0 !important;',
				]
			]
		);

		$this->add_control(
			'box_height_a',
			[
				'label' => __( 'Box Height', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'h-pt-100',
				'options' => [
					'h-pt-50' => __( '50%', 'archub-elementor-addons' ),
					'h-pt-60' => __( '60%', 'archub-elementor-addons' ),
					'h-pt-70' => __( '70%', 'archub-elementor-addons' ),
					'h-pt-80' => __( '80%', 'archub-elementor-addons' ),
					'h-pt-100' => __( '100%', 'archub-elementor-addons' ),
					'h-custom' => __( 'Custom', 'archub-elementor-addons' ),
				],
				'condition' => [
					'template' => 's01a'
				]
			]
		);

		$this->add_responsive_control(
			'box_height_custom_a',
			[
				'label' => __( 'Height', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vw', 'vh' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
				],
				'condition' => [
					'box_height_a' => 'h-custom',
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-fb' => 'height: {{SIZE}}{{UNIT}}; padding: 0 !important;',
				]
			]
		);

		$this->add_control(
			'box_height_b',
			[
				'label' => __( 'Box Height', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'h-pt-80',
				'options' => [
					'h-pt-50' => __( '50%', 'archub-elementor-addons' ),
					'h-pt-60' => __( '60%', 'archub-elementor-addons' ),
					'h-pt-70' => __( '70%', 'archub-elementor-addons' ),
					'h-pt-80' => __( '80%', 'archub-elementor-addons' ),
					'h-pt-100' => __( '100%', 'archub-elementor-addons' ),
					'h-custom' => __( 'Custom', 'archub-elementor-addons' ),
				],
				'condition' => [
					'template' => 's01b'
				]
			]
		);

		$this->add_responsive_control(
			'box_height_custom_b',
			[
				'label' => __( 'Height', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vw', 'vh' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
				],
				'condition' => [
					'box_height_b' => 'h-custom',
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-fb' => 'height: {{SIZE}}{{UNIT}}; padding: 0 !important;',
				]
			]
		);

		$this->add_control(
			'box_height_6',
			[
				'label' => __( 'Box Height', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'h-pt-125',
				'options' => [
					'h-pt-50' => __( '50%', 'archub-elementor-addons' ),
					'h-pt-60' => __( '60%', 'archub-elementor-addons' ),
					'h-pt-70' => __( '70%', 'archub-elementor-addons' ),
					'h-pt-80' => __( '80%', 'archub-elementor-addons' ),
					'h-pt-90' => __( '90%', 'archub-elementor-addons' ),
					'h-pt-100' => __( '100%', 'archub-elementor-addons' ),
					'h-pt-125' => __( '125%', 'archub-elementor-addons' ),
					'h-custom' => __( 'Custom', 'archub-elementor-addons' ),
				],
				'condition' => [
					'template' => 's06'
				]
			]
		);

		$this->add_responsive_control(
			'box_height_custom_6',
			[
				'label' => __( 'Height', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vw', 'vh' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					],
				],
				'condition' => [
					'box_height_6' => 'h-custom',
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-fb' => 'height: {{SIZE}}{{UNIT}}; padding: 0 !important;',
				]
			]
		);

		$this->add_control(
			'label',
			[
				'label' => __( 'Label', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Label', 'archub-elementor-addons' ),
				'placeholder' => __( 'Type your label here', 'archub-elementor-addons' ),
				'condition' => [
					'template' => [
						's01', 's01b', 's03'
					]
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'label_typography',
				'label' => __( 'Label Typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-fb-content h6',
				'condition' => [
					'template' => [
						's01', 's01b', 's03'
					]
				]
			]
		);

		$this->add_responsive_control(
			'label_padding',
			[
				'label' => __( 'Label Padding', 'archub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-fb-content h6' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => array(
					'template' => [
						's01', 's01b', 's03'
					]
				),
			]
		);

		$this->add_control(
			'image',
			[
				'label' => __( 'Image', 'archub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'template!' => ['s10']
				],
			]
		);

		
		$this->add_control(
			'img_link',
			[
				'label' => __( 'Link', 'archub-elementor-addons' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'archub-elementor-addons' ),
			]
		);

		$this->add_control(
			'content2',
			[
				'label' => __( 'Text', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'placeholder' => __( 'Type your text here', 'archub-elementor-addons' ),
				'condition' => [
					'template' => [
						's01', 's01a', 's01b', 's02', 's04', 's05', 's06', 's10' 
					]
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => __( 'Content Typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} p',
				'condition' => [
					'template' => [
						's01', 's01a', 's01b', 's02', 's04', 's05', 's06', 's10' 
					]
				]
			]
		);

		$this->add_control(
			'i_type',
			[
				'label' => __( 'Icon Library', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'fontawesome',
				'options' => [
					'fontawesome'  => __( 'Icon Library', 'archub-elementor-addons' ),
					//'image' => __( 'Image', 'archub-elementor-addons' ),
				],
				'condition' => [
					'template' => [ 's06', 's08' ],
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
				'condition' => [
					'template' => [ 's06', 's08' ],
				],
			]
		);
		$this->end_controls_section();
		
		// Style Tab
		$this->start_controls_section(
			'style_section',
			[
				'label' => __( 'Style Section', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Title Typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-fb-content h2',
			]
		);

		$this->add_responsive_control(
			'title_padding',
			[
				'label' => __( 'Title Padding', 'archub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-fb-content h2' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => array(
					'template' => [
						's01', 's01b', 's03'
					]
				),
			]
		);

		$this->add_control(
			'overlay_color_heading',
			[
				'label' => __( 'Overlay color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'template!' => [
						's04', 's05', 's07', 's08', 's10', 's11'
					]
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'overlay_color',
				'label' => __( 'Hover image overlay color', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .lqd-fb-bg',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
				'condition' => [
					'template!' => [
						's04', 's05', 's07', 's08', 's10', 's11'
					]
				],
			]
		);

		
		$this->add_control(
			'overlay_hcolor_heading',
			[
				'label' => __( 'Hover image overlay color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'template!' => [
						's04', 's05', 's07', 's08', 's10', 's11'
					]
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'overlay_hcolor',
				'label' => __( 'Hover image overlay color', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .lqd-fb-hover-overlay',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
				'condition' => [
					'template!' => [
						's08', 's10', 's11'
					]
				],
			]
		);

		$this->add_control(
			'content_bg',
			[
				'label' => __( 'Content background', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-fb-content' => 'background: {{VALUE}}',
				],
				'condition' => [
					'template!' => [
						's10'
					]
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'content_bg_hover',
			[
				'label' => __( 'Content hover background', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-fb:hover .lqd-fb-content' => 'background: {{VALUE}}',
				],
				'condition' => [
					'template!' => [
						's10'
					]
				],
			]
		);

		$this->add_control(
			'revealer_color',
			[
				'label' => __( 'Revealer color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .block-revealer__element' => 'background: {{VALUE}}',
				],
				'condition' => [
					'template!' => [
						's02', 's03', 's08', 's11'
					]
				]
			]
		);

		$this->add_control(
			'hover_revealer_color',
			[
				'label' => __( 'Revealer hover color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .block-revealer__element:before' => 'background: {{VALUE}}',
				],
				'condition' => [
					'template' => [
						's08'
					]
				]
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label' => __( 'Heading color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-fb-content h2' => 'color: {{VALUE}}',
					'{{WRAPPER}} .lqd-fb-title i' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'heading_hcolor',
			[
				'label' => __( 'Heading hover color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-fb:hover .lqd-fb-content h2' => 'color: {{VALUE}}',
					'{{WRAPPER}} .lqd-fb:hover .lqd-fb-title i' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'content_color',
			[
				'label' => __( 'Content color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-fb-content p' => 'color: {{VALUE}}',
				],
				'condition' => [
					'template!' => [
						's11'
					]
				]
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label' => __( 'Subtitle color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-fb-style-6 h6' => 'color: {{VALUE}}',
				],
				'condition' => [
					'template' => [
						's06'
					]
				]
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => __( 'Icon color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-fb-content i' => 'color: {{VALUE}}',
				],
				'condition' => [
					'template' => [
						's08'
					]
				]
			]
		);

		$this->add_control(
			'icon_bg_label',
			[
				'label' => __( 'Icon background', 'archub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'template' => [
						's11'
					]
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'icon_bg',
				'label' => __( 'Icon background color', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .lqd-fb-icn',
				'condition' => [
					'template' => [
						's11'
					]
				]
			]
		);

		$this->add_control(
			'icon_color_s11',
			[
				'label' => __( 'Icon color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-fb-icn' => 'color: {{VALUE}}',
				],
				'condition' => [
					'template' => [
						's11'
					]
				]
			]
		);

		$this->add_control(
			'hover_icon_color',
			[
				'label' => __( 'Hover icon color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-fb:hover .lqd-fb-content i' => 'color: {{VALUE}}',
				],
				'condition' => [
					'template' => [
						's08'
					]
				]
			]
		);

		$this->add_control(
			'label_bg_heading',
			[
				'label' => __( 'Label background', 'archub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'template' => [
						's01', 's01b', 's03'
					]
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'label_bg',
				'label' => __( 'Hover image overlay color', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .lqd-fb-content h6',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
				'condition' => [
					'template' => [
						's01', 's01b', 's03'
					]
				],
			]
		);

		$this->add_control(
			'label_color',
			[
				'label' => __( 'Label color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-fb-content h6' => 'color: {{VALUE}}',
				],
				'condition' => [
					'template' => [
						's01', 's01b', 's03'
					]
				]
			]
		);

		$this->end_controls_section();

		ld_el_btn($this, 'ib_', $condition = ['template' => ['s01', 's01a', 's01b', 's02', 's04', 's05', 's06', 's10']]); // load button
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

		$classes = array(
			'lqd-fb',
			'pos-rel'
		);
		$wrapper_attr = array();

		if ( ! empty( $settings['img_link']['url'] ) ) {
			$this->add_link_attributes( 'img_link', $settings['img_link'] );
		}

		
		switch($settings['template']){
			case 's01':
				array_push($classes, 'lqd-fb-style-1', 'lqd-fb-style-1-1', 'lqd-fb-content-overlay', 'lqd-fb-zoom-img-onhover', $settings['box_height']);
				$wrapper_attr['data-inview'] = 'true';
			break;
			case 's01a':
				array_push($classes, 'lqd-fb-style-1', 'lqd-fb-style-1-2', 'lqd-fb-content-overlay', 'lqd-fb-zoom-img-onhover', $settings['box_height_a']);
				$wrapper_attr['data-inview'] = 'true';
			break;
			case 's01b':
				array_push($classes, 'lqd-fb-style-1', 'lqd-fb-style-1-3', 'lqd-fb-content-overlay', 'lqd-fb-zoom-img-onhover', 'transform-style-3d', 'perspective', $settings['box_height_b']);
				$wrapper_attr['data-inview'] = 'true';
				$wrapper_attr[' data-hover3d'] = 'true';
			break;
			case 's02':
				array_push($classes, 'lqd-fb-style-2', 'lqd-fb-content-overlay');
			break;
			case 's03':
				array_push($classes, 'lqd-fb-style-3', 'lqd-fb-zoom-img-onhover');
			break;
			case 's04':
				array_push($classes, 'lqd-fb-style-4', 'lqd-fb-zoom-img-onhover');
			break;
			case 's05':
				array_push($classes, 'lqd-fb-style-5', 'overflow-hidden');
			break;
			case 's06':
				array_push($classes, 'lqd-fb-style-6', 'border-radius-4', $settings['box_height_6']);
				$wrapper_attr['data-lqd-zindex'] = 'true';
			break;
			case 's07':
				array_push($classes, 'lqd-fb-style-7', 'border-radius-4', 'overflow-hidden');
			break;
			case 's08':
				array_push($classes, 'lqd-fb-style-8' , $settings['content_alignment'] );
			break;
			case 's09':
				array_push($classes, 'lqd-fb-style-9', 'border-radius-10', 'overflow-hidden');
			break;
			case 's10':
				array_push($classes, 'lqd-fb-style-10');
			break;
			case 's11':
				array_push($classes, 'lqd-fb-style-11', 'lqd-fb-zoom-img-onhover', 'border-radius-4', 'overflow-hidden');
			break;
		}
		
		?> 

		<div class="<?php echo ld_helper()->sanitize_html_classes( $classes ); ?>" <?php echo ld_helper()->html_attributes( $wrapper_attr ) ?> >
		<?php
		
		switch($settings['template']){
			case 's01':
			?>

			<div class="lqd-fb-inner lqd-overlay border-radius-4 overflow-hidden" data-slideelement-onhover="true" data-slideelement-options='{ "visibleElement": "h6, h2", "hiddenElement": ".lqd-fb-txt", "waitForSplitText": true }'>

				<div class="lqd-fb-img lqd-overlay overflow-hidden">

					<figure class="w-100 h-100">
						<?php echo '<img class="w-100 h-100 objfit-cover objfit-center" src="' . esc_url( $settings['image']['url'] ) . '">'; ?>
					</figure>

				</div>

				<div class="lqd-fb-content lqd-overlay d-flex align-items-end">
					<div class="lqd-fb-bg lqd-overlay"></div>
					<div
					class="lqd-fb-content-inner pos-rel w-100"
					data-custom-animations="true"
					data-ca-options='{ "triggerHandler": "inview", "animationTarget": "all-childs", "duration": 1200, "delay": 120,  "startDelay": 250, "initValues": { "y": 30, "opacity": 0 }, "animations": { "y": 0, "opacity": 1 } }'>
						
						<?php if( !empty( $settings['label'] ) ) { ?>
						<h6 class="mt-0 mb-4">
							<?php echo esc_html($settings['label']); ?>
						</h6>
						<?php } ?>
						
						<?php if( !empty( $settings['title'] ) ) { ?>
						<h2
						class="mt-0 mb-0"
						data-split-text="true" data-split-options='{ "type": "lines" }'>
							<?php echo esc_html( $settings['title'] ); ?>
						</h2>
						<?php } ?>
						
						<?php if( !empty( $settings['content2'] ) || 'yes' === $settings['show_button'] ) { ?>
							<div class="lqd-fb-txt">
							<?php if( !empty( $settings['content2'] ) ) { ?>
								<p class="mt-0 mb-3"><?php echo wp_kses_post( $settings['content2'] ); ?></p>
							<?php } ?>
							<?php if( 'yes' === $settings['show_button'] ) { ?>
								<?php $this->get_button() ?>
							<?php } ?>
							</div>
						<?php } ?>

						<?php if( $settings['img_link']['url'] ): ?>
							<a <?php echo $this->get_render_attribute_string( 'img_link' ); ?> class="lqd-overlay"></a>
						<?php endif; ?>
						
					</div>
				</div>

			</div>

			<?php
			break;
			case 's01a':
			?>
			<div class="lqd-fb-inner lqd-overlay border-radius-4 overflow-hidden">

				<div class="lqd-fb-img lqd-overlay overflow-hidden">

					<figure class="w-100 h-100">
						<?php echo '<img class="w-100 h-100 objfit-cover objpos-center" src="' . esc_url( $settings['image']['url'] ) . '">'; ?>
					</figure>

				</div>

				<div class="lqd-fb-content lqd-overlay d-flex align-items-end">
					<div class="lqd-fb-bg lqd-overlay"></div>
					<div class="lqd-fb-hover-overlay lqd-overlay"></div>
					<div class="lqd-fb-content-inner d-flex flex-wrap align-items-center pos-rel ps-2 pe-2 pt-5 pb-5 w-100">
						<?php if( 'yes' === $settings['show_button'] ) { ?>
						<div
						class="lqd-fb-content-holder lqd-fb-content-left w-20 ps-2 pe-2 text-center"
						data-custom-animations="true"
						data-ca-options='{ "triggerHandler": "inview", "animationTarget": "all-childs", "duration": 1000, "delay": 120,  "startDelay": 250, "initValues": { "scale": 1.2, "opacity": 0 }, "animations": { "scale": 1, "opacity": 1 } }'>
						<?php $this->get_button() ?>
						</div>
						<?php } ?>
						
						<?php if( !empty( $settings['title'] ) ) { ?>
						<div
						class="lqd-fb-content-holder lqd-fb-content-right w-80 ps-2 pe-2"
						data-custom-animations="true"
						data-ca-options='{ "triggerHandler": "inview", "animationTarget": "all-childs", "duration": 1000, "delay": 120,  "startDelay": 250, "initValues": { "y": 20, "opacity": 0 }, "animations": { "y": 0, "opacity": 1 } }'>
							<h3
							class="mt-0 mb-0"
							data-split-text="true" data-split-options='{ "type": "lines" }'><?php echo esc_html( $settings['title'] ); ?></h3>
						</div>
						<?php } ?>

						<?php if( $settings['img_link']['url'] ): ?>
							<a <?php echo $this->get_render_attribute_string( 'img_link' ); ?> class="lqd-overlay"></a>
						<?php endif; ?>

					</div>
				</div>

			</div>
			<?php
			break;
			case 's01b':
			?>
			<div class="lqd-fb-inner lqd-overlay transform-style-3d" data-stacking-factor="1.15">

				<div class="lqd-fb-img lqd-overlay border-radius-4 overflow-hidden">

					<figure class="w-100 h-100">
						<?php echo '<img class="w-100 h-100 objfit-cover objpos-center" src="' . esc_url( $settings['image']['url'] ) . '">'; ?>
						<div class="lqd-fb-bg lqd-overlay"></div>
						<div class="lqd-fb-hover-overlay lqd-overlay"></div>
					</figure>

				</div>

				<div class="lqd-fb-content lqd-overlay d-flex align-items-end border-radius-4 overflow-hidden">
					<div class="lqd-fb-content-inner d-flex flex-column <?php echo esc_attr( empty( $settings['label'] ) ? 'justify-content-end' : 'justify-content-between' ); ?> pos-rel h-100 w-100 p-4">
						
						<?php if( !empty( $settings['label'] ) ) { ?>
						<div class="lqd-fb-content-top">
							<h6 class="mt-0 mb-0"><?php echo esc_html( $settings['label'] ); ?></h6>
						</div>
						<?php } ?>
						
						<div class="lqd-fb-content-bottom">
							
							<?php if( !empty( $settings['title'] ) ) { ?>
							<h2 class="mt-0 mb-2"><?php echo esc_html( $settings['title'] ); ?></h2>
							<?php } ?>
							
							
							<?php if( !empty( $settings['content2'] ) ) { ?>
							<p class="mt-0 mb-3"><?php echo wp_kses_post( $settings['content2'] ); ?></p>
							<?php } ?>

							<?php $this->get_button() ?>

						</div>

						<?php if( $settings['img_link']['url'] ): ?>
							<a <?php echo $this->get_render_attribute_string( 'img_link' ); ?> class="lqd-overlay"></a>
						<?php endif; ?>
						
					</div>
				</div>

				</div>
			<?php
			break;
			case 's02':
			?>
			<div class="lqd-fb-inner lqd-overlay">

				<div class="lqd-fb-img lqd-overlay overflow-hidden">
			
					<figure class="w-100 h-100">
						<?php echo '<img class="w-100 h-100 objfit-cover objpos-center" src="' . esc_url( $settings['image']['url'] ) . '">'; ?>
					</figure>
						
					<?php if( $settings['img_link']['url'] ): ?>
						<a <?php echo $this->get_render_attribute_string( 'img_link' ); ?> class="lqd-overlay"></a>
					<?php endif; ?>

				</div>

				<div class="lqd-fb-content lqd-overlay d-flex align-items-end">
					<div class="lqd-fb-content-inner d-flex flex-wrap align-items-center pos-rel pt-4 pb-4 ps-3 pe-3 w-100">
						<div class="lqd-overlay" data-reveal="true" data-reveal-options='{ "direction": "bt", "bgcolor": "#000", "delay": 150, "duration": 500 }'>
							<div class="lqd-fb-bg lqd-overlay"></div>
							<div class="lqd-fb-hover-overlay lqd-overlay"></div>
						</div>

						<?php if( !empty( $settings['title'] ) ) { ?>
						<div
						class="lqd-fb-content-holder lqd-fb-content-left w-60 pos-rel"
						data-custom-animations="true"
						data-ca-options='{ "triggerHandler": "inview", "animationTarget": "all-childs", "duration": 1200, "delay": 120,  "startDelay": 800, "initValues": { "y": 30, "opacity": 0 }, "animations": { "y": 0, "opacity": 1 } }'>
							<h2
							class="mt-0 mb-0"
							data-split-text="true" data-split-options='{ "type": "lines" }'><?php echo esc_html( $settings['title'] ); ?></h2>
						</div>
						<?php } ?>
						
						<div
						class="lqd-fb-content-holder lqd-fb-content-right w-40 pos-rel"
						data-custom-animations="true"
						data-ca-options='{ "triggerHandler": "inview", "animationTarget": "all-childs", "duration": 1200, "delay": 120,  "startDelay": 950, "initValues": { "y": 30, "opacity": 0 }, "animations": { "y": 0, "opacity": 1 } }'>
						<?php $this->get_button() ?>
						</div>
					</div>
				</div>

				</div>
			<?php
			break;
			case 's03':
			?>

			<div class="lqd-fb-inner" data-reveal="true" data-reveal-options='{ "direction": "bt", "bgcolor": "#000", "duration": 500 }'>

				<div class="lqd-fb-img overflow-hidden">
				
					<figure class="w-100">
						<?php echo '<img class="w-100" src="' . esc_url( $settings['image']['url'] ) . '">'; ?>
					</figure>
						
					<?php if( $settings['img_link']['url'] ): ?>
						<a <?php echo $this->get_render_attribute_string( 'img_link' ); ?> class="lqd-overlay"></a>
					<?php endif; ?>

				</div>

				<div class="lqd-fb-content pos-rel">
					<div class="lqd-fb-bg lqd-overlay"></div>
					<div class="lqd-fb-hover-overlay lqd-overlay"></div>
					<div
					class="lqd-fb-content-inner d-flex flex-column pos-rel ps-6 pe-6 pt-4 pb-4"
					data-custom-animations="true"
					data-ca-options='{ "triggerHandler": "inview", "animationTarget": "all-childs", "duration": 1200, "delay": 120,  "startDelay": 500, "initValues": { "y": 30, "opacity": 0 }, "animations": { "y": 0, "opacity": 1 } }'>
						<?php if( !empty( $settings['title'] ) ) { ?>
						<h2
						class="mt-0 mb-2"
						data-split-text="true" data-split-options='{ "type": "lines" }'><?php echo esc_html( $settings['title'] ); ?></h2>
						<?php } ?>
						
						<?php if( !empty( $settings['label'] ) ) { ?>
						<h6
						class="mt-0 mb-0"
						data-split-text="true" data-split-options='{ "type": "lines" }'><?php echo esc_html( $settings['label'] ); ?></h6>
						<?php } ?>
					</div>
				</div>

			</div>

			<?php
			break;
			case 's04':
			?>
			<div class="lqd-fb-inner">

				<div class="lqd-fb-img pos-rel overflow-hidden">
					
					<figure class="w-100">
						<?php echo '<img class="w-100" src="' . esc_url( $settings['image']['url'] ) . '">'; ?>
					</figure>
						
					<?php if( $settings['img_link']['url'] ): ?>
						<a <?php echo $this->get_render_attribute_string( 'img_link' ); ?> class="lqd-overlay"></a>
					<?php endif; ?>

				</div>

				<div class="lqd-fb-content pos-rel">
					<div class="lqd-fb-bg lqd-overlay"></div>
					<div class="lqd-fb-hover-overlay lqd-overlay"></div>
					<div class="lqd-fb-content-inner pos-rel text-center p-5">

						<?php if( !empty( $settings['title'] ) ) { ?>
						<h2 class="mt-0 mb-3 font-weight-normal"><?php echo esc_html( $settings['title'] ); ?></h2>
						<?php } ?>
						
						<?php if( !empty( $settings['content2'] ) ) { ?>
						<p class="mt-0 mb-0"> <?php echo wp_kses_post( $settings['content2'] ); ?></p>
						<?php } ?>

					</div>
					
					
					<?php if( 'yes' === $settings['show_button'] ) { ?>
					<div class="lqd-fb-footer text-center py-3 px-5">
						<?php $this->get_button() ?>
					</div>
					<?php } ?>
					
				</div>

			</div>
			<?php
			break;
			case 's05':
			?>
			<div class="lqd-fb-inner d-flex flex-wrap align-items-center">

				<div class="lqd-fb-content-holder lqd-fb-content-left w-20">
					<div class="lqd-fb-img">
						<figure class="w-100 border-radius-circle overflow-hidden">

							<?php echo '<img class="w-100 h-100 objfit-cover objpos-center border-radius-circle" src="' . esc_url( $settings['image']['url'] ) . '">'; ?>
							
							<?php if( $settings['img_link']['url'] ): ?>
								<a <?php echo $this->get_render_attribute_string( 'img_link' ); ?> class="lqd-overlay"></a>
							<?php endif; ?>

						</figure>
					</div>
				</div>

				<div class="lqd-fb-content-holder lqd-fb-content-right w-70 ms-auto">
					<div class="lqd-fb-content pos-rel">
						<div class="lqd-fb-bg lqd-overlay"></div>
						<div class="lqd-fb-hover-overlay lqd-overlay"></div>
						<div class="lqd-fb-content-inner pos-rel pt-6 pb-6 ps-4 pe-4">
							
							<?php if( !empty( $settings['title'] ) ) { ?>
							<h2 class="mt-0 mb-3 font-weight-bold"><?php echo esc_html( $settings['title'] ); ?></h2>
							<?php } ?>
							
							<?php if( !empty( $settings['content2'] ) ) { ?>
							<p class="mt-0 mb-3"><?php echo wp_kses_post( $settings['content2'] ); ?></p>
							<?php } ?>
							
							<?php $this->get_button() ?>
						</div>
					</div>
				</div>

			</div>
			<?php
			break;
			case 's06':
			?>
				
			<div class="lqd-fb-shadow"></div>

			<div class="d-flex flex-wrap align-items-center lqd-overlay" data-hover3d="true">

				<div class="lqd-fb-content-wrap lqd-overlay flex-column align-items-end transform-style-3d backface-hidden will-change-transform" data-stacking-factor="0.5">

					<div class="lqd-fb-img lqd-overlay border-radius-4 overflow-hidden backface-hidden">
						<figure class="w-100 h-100">
							<?php echo '<img class="w-100 h-100 objfit-cover objfit-center" src="' . esc_url( $settings['image']['url'] ) . '">'; ?>
						</figure>
						<div class="lqd-fb-bg lqd-overlay"></div>
						<div class="lqd-fb-hover-overlay lqd-overlay"></div>
					</div>

					<div class="lqd-fb-content d-flex flex-column justify-content-end lqd-overlay p-4 backface-hidden">

						<span class="lqd-fb-icon d-flex mb-5">
							<?php \Elementor\Icons_Manager::render_icon( $settings['i_icon_fontawesome'], [ 'aria-hidden' => 'true' ] ); ?>
						</span>

						<?php if( !empty( $settings['subtitle'] ) ) { ?>
						<h6 class="mt-0 mb-3 font-weight-bold"><?php echo esc_html( $settings['subtitle'] ); ?></h6>
						<?php } ?>
						
						<?php if( !empty( $settings['title'] ) ) { ?>
						<h2 class="mt-0 mb-3 font-weight-bold"><?php echo esc_html( $settings['title'] ); ?></h2>
						<?php } ?>
						
						<?php $this->get_button() ?>

					</div>
					
				</div>

				<?php if( $settings['img_link']['url'] ): ?>
					<a <?php echo $this->get_render_attribute_string( 'img_link' ); ?> class="lqd-overlay"></a>
				<?php endif; ?>

			</div>
		
			<?php
			break;
			case 's07':
			?>
			<div class="lqd-fb-inner d-flex flex-wrap">

				<div class="w-40 h-pt-50 pos-rel">
					<div class="lqd-fb-img lqd-overlay">
						<figure class="w-100 h-100 pos-rel">
							<?php echo '<img class="objfit-cover objpos-center lqd-overlay" src="' . esc_url( $settings['image']['url'] ) . '">'; ?>
							<?php if( $settings['img_link']['url'] ): ?>
								<a <?php echo $this->get_render_attribute_string( 'img_link' ); ?> class="lqd-overlay"></a>
							<?php endif; ?>
						</figure>
					</div>
				</div>

				<div class="w-60">
					<div class="lqd-fb-content pos-rel">
						<div class="lqd-fb-bg lqd-overlay"></div>
						<div class="lqd-fb-hover-overlay lqd-overlay"></div>
						<div class="lqd-fb-content-inner pos-rel pt-6 pb-6 ps-5 pe-5">
							
							<?php if( !empty( $settings['title'] ) ) { ?>
							<h2 class="mt-0 mb-3 font-weight-semibold"><?php echo esc_html( $settings['title'] ); ?></h2>
							<?php } ?>
							
							<?php if( !empty( $settings['content2'] ) ) { ?>
							<p class="mt-0 mb-3"><?php echo wp_kses_post( $settings['content2'] ); ?></p>
							<?php } ?>

						</div>
					</div>
				</div>

			</div>

			<?php
			break;
			case 's08':
			?>
			<div class="lqd-fb-inner">

				<div
				class="lqd-fb-img border-radius-4 overflow-hidden"
				data-custom-animations="true"
				data-ca-options='{ "triggerHandler": "inview", "animationTarget": "figure", "duration": 1200, "initValues": { "scale": 1.075, "opacity": 0 }, "animations": { "scale": 1, "opacity": 1 } }'>
					<figure class="w-100">
							<?php echo '<img class="w-100" src="' . esc_url( $settings['image']['url'] ) . '">'; ?>
							<?php if( $settings['img_link']['url'] ): ?>
								<a <?php echo $this->get_render_attribute_string( 'img_link' ); ?> class="lqd-overlay"></a>
							<?php endif; ?>
					</figure>
				</div>

				<div class="lqd-fb-content border-radius-4 pos-rel <?php echo esc_attr( $settings['ct_width'] ); ?>">
					<div class="lqd-fb-content-inner d-flex flex-wrap align-items-center justify-content-between pos-rel border-radius-4 pt-4 pb-4 ps-5 pe-5">
						<div class="lqd-overlay" data-reveal="true" data-reveal-options='{ "direction": "bt", "delay": 150, "duration": 500, "coverArea": 100 }'>
							<div class="lqd-fb-bg lqd-overlay"></div>
						</div>
						<?php if( !empty( $settings['title'] ) ) { ?>
						<div
						class="lqd-fb-content-holder lqd-fb-content-left w-70 pos-rel"
						data-custom-animations="true"
						data-ca-options='{ "triggerHandler": "inview", "animationTarget": "all-childs", "duration": 1200, "delay": 120,  "startDelay": 800, "initValues": { "y": 30, "opacity": 0 }, "animations": { "y": 0, "opacity": 1 } }'>
							<h2 class="mt-0 mb-0" data-split-text="true" data-split-options='{ "type": "lines" }'><?php echo esc_html( $settings['title'] ); ?></h2>
						</div>
						<?php } ?>
						<div
						class="lqd-fb-content-holder lqd-fb-content-right d-flex justify-content-end w-20 pos-rel"
						data-custom-animations="true"
						data-ca-options='{ "triggerHandler": "inview", "animationTarget": "all-childs", "duration": 1100, "delay": 120,  "startDelay": 950, "initValues": { "y": 30, "opacity": 0 }, "animations": { "y": 0, "opacity": 1 } }'>
							<?php \Elementor\Icons_Manager::render_icon( $settings['i_icon_fontawesome'], [ 'aria-hidden' => 'true' ] ); ?>
						</div>
					</div>
				
					<a <?php echo $this->get_render_attribute_string( 'img_link' ); ?> class="lqd-overlay"></a>
				</div>

				<a <?php echo $this->get_render_attribute_string( 'img_link' ); ?> class="lqd-overlay"></a>

			</div>
			<?php
			break;
			case 's09':
			?>
			<div class="lqd-fb-inner">

				<div
				class="lqd-fb-img overflow-hidden"
				data-custom-animations="true"
				data-ca-options='{ "triggerHandler": "inview", "animationTarget": "figure", "duration": 1200, "initValues": { "scale": 1.15, "opacity": 0 }, "animations": { "scale": 1, "opacity": 1 } }'>
					<figure class="w-100">
						<?php echo '<img class="w-100" src="' . esc_url( $settings['image']['url'] ) . '">'; ?>
					</figure>
				</div>

				<div class="lqd-fb-content pos-rel pt-4 pb-4 ps-3 pe-3 d-flex flex-column">
					<div class="lqd-fb-content-inner pos-rel">
						<?php if( !empty( $settings['title'] ) ) { ?>
						<h2 class="mt-0 h4"><?php echo esc_html( $settings['title'] ); ?></h2>
						<?php } ?>
						<?php if( !empty( $settings['content2'] ) ) { ?>
						<?php echo wp_kses_post( ld_helper()->do_the_content( $item['conten2'] ) ); ?>
						<?php } ?>
					</div>
				</div>

				<a <?php echo $this->get_render_attribute_string( 'img_link' ); ?> class="lqd-overlay"></a>

			</div>
			<?php
			break;
			case 's10':
			?>
			<div class="lqd-fb-inner">

				<div class="lqd-fb-content">
					<div class="lqd-fb-content-inner">
						
						<?php if( !empty( $settings['title'] ) ) { ?>
						<div class="lqd-fb-title mb-2">
							<h2 class="mt-0 mb-0">
								<?php echo esc_html( $settings['title'] ); ?>
								<i class="lqd-icn-ess icon-ion-ios-arrow-forward"></i>
							</h2>
						</div>
						<?php } ?>
						
						<?php if( !empty( $settings['content2'] ) ) { ?>
						<p class="mt-0 mb-3"><?php echo wp_kses_post( $settings['content2'] ); ?></p>
						<?php } ?>
						
						<?php $this->get_button() ?>
					</div>
				</div>

			</div>
			<?php
			break;
			case 's11':
				?>
				<div class="lqd-fb-img pos-rel overflow-hidden">
					<figure>
						<?php echo '<img src="' . esc_url( $settings['image']['url'] ) . '">'; ?>
					</figure>
					<span class="lqd-fb-icn d-flex align-items-center justify-content-center border-radius-circle pos-abs pos-mid">
						<svg width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg"><path d="M7.875 4.76837e-07V7.875H0V9.73H7.875V17.605H9.73V9.73H17.605V7.875H9.73V4.76837e-07H7.875Z" fill="currentColor"/></svg>
					</span>
				</div>

				<div class="lqd-fb-content p-3">
					<?php if( !empty( $settings['title'] ) ) { ?>
					<h2 class="m-0"><?php echo esc_html( $settings['title'] ); ?></h2>
					<?php } ?>
					
				</div>

				<a <?php echo $this->get_render_attribute_string( 'img_link' ); ?> class="lqd-overlay"></a>

				<?php
				break;
		}
		?> 
		</div>
		<?php


	}

}
