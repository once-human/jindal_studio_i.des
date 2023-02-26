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
class LD_Icon_Box extends Widget_Base {

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
		return 'ld_icon_box';
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
		return __( 'Liquid Icon Box', 'archub-elementor-addons' );
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
		return 'eicon-icon-box lqd-element';
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
		return [ 'icon', 'box' ];
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

		// Icon Section
		$this->start_controls_section(
			'iconn_section',
			[
				'label' => __( 'Icon', 'archub-elementor-addons' ),
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
			'i_animated',
			[
				'label' => __( 'Animated icons', 'archub-elementor-addons' ),
				'description' => __( 'It only works with the "Upload SVG" option. ', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'archub-elementor-addons' ),
				'label_off' => __( 'Hide', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
				'condition' => [
					'i_type' => 'fontawesome',
					'disable' => 'disable'
				],
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
		$this->add_responsive_control(
			'icon_size',
			[
				'label' => __( 'Icon size', 'archub-elementor-addons' ),
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

		$this->add_responsive_control(
			'custom_size',
			[
				'label' => __( 'Custom icon size', 'archub-elementor-addons' ),
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
					'{{WRAPPER}} .iconbox-icon-container' => 'min-width: {{SIZE}}{{UNIT}}; font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .iconbox-icon-container > img' => 'width: {{SIZE}}{{UNIT}};', // for image
				],
				'condition' => array(
					'i_type' => 'image',
				),
			]
		);

		$this->add_responsive_control(
			'icon_mb',
			[
				'label' => __( 'Icon bottom space', 'archub-elementor-addons' ),
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
					'{{WRAPPER}} .iconbox-default .iconbox-icon-container' => 'margin-bottom: {{SIZE}}{{UNIT}};'
				],
				'condition' => array(
					'i_type' => array( 'fontawesome', 'image' ),
					'position' => array( 'iconbox-default' ),
				),
			]
		);

		$this->add_responsive_control(
			'icon_mb_side',
			[
				'label' => __( 'Icon side space', 'archub-elementor-addons' ),
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
					'{{WRAPPER}} .iconbox-side .iconbox-icon-wrap' => 'margin-inline-end: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.elementor-align-right .iconbox-side .iconbox-icon-wrap' => 'margin-inline-start: {{SIZE}}{{UNIT}}; margin-inline-end: 0;',
				],
				'condition' => array(
					'i_type' => array( 'fontawesome', 'image' ),
					'position' => array( 'iconbox-side' ),
				),
			]
		);

		$this->add_responsive_control(
			'icon_mb_inline',
			[
				'label' => __( 'Icon bottom space', 'archub-elementor-addons' ),
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
					'{{WRAPPER}} .iconbox-inline .contents' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
				'condition' => array(
					'i_type' => array( 'fontawesome', 'image' ),
					'position' => array( 'iconbox-inline' ),
				),
			]
		);

		$this->add_responsive_control(
			'icon_mb_inline_side',
			[
				'label' => __( 'Icon side space', 'archub-elementor-addons' ),
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
					'{{WRAPPER}} .iconbox-inline .iconbox-icon-wrap' => 'margin-inline-end: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.elementor-align-right .iconbox-inline .iconbox-icon-wrap' => 'margin-inline-start: {{SIZE}}{{UNIT}}; margin-inline-end: 0;',
				],
				'condition' => array(
					'i_type' => array( 'fontawesome', 'image' ),
					'position' => array( 'iconbox-inline' ),
				),
			]
		);

		// Shape Props
		$this->add_control(
			'i_shape',
			[
				'label' => __( 'Shape', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'None', 'archub-elementor-addons' ),
					'square' => __( 'Square', 'archub-elementor-addons' ),
					'circle' => __( 'Circle', 'archub-elementor-addons' ),
					'lozenge' => __( 'Lozenge', 'archub-elementor-addons' ),
					'custombg' => __( 'Custom', 'archub-elementor-addons' ),
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'i_shape_options',
			[
				'label' => __( 'Shape options', 'archub-elementor-addons' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'label_off' => __( 'Default', 'archub-elementor-addons' ),
				'label_on' => __( 'Custom', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'condition' => [
					'i_shape!' => '',
				],
			]
		);
		$this->start_popover();

		$this->add_control(
			'i_shape_custom_bg',
			[
				'label' => __( 'Choose image', 'archub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
                'condition' => [
                    'i_shape' => 'custombg',
					'i_shape_options' => 'yes',
				],
			]
		);

		$this->add_control(
			'i_shape_custom_bg_color',
			[
				'label' => __( 'SVG background color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .icon-custom-bg svg path' => 'fill: {{VALUE}}',
				],
				'condition' => [
					'i_shape' => 'custombg',
					'i_shape_options' => 'yes',
				],
				'separator' => 'after',
			]
		);

        $this->add_control(
			'custom_i_top_offset',
			[
				'label' => __( 'Top offset', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .iconbox-icon-container .icon-custom-bg > *' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'i_shape' => 'custombg',
					'i_shape_options' => 'yes',
				],
			]
		);

        $this->add_control(
			'custom_i_left_offset',
			[
				'label' => __( 'Left offset', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .iconbox-icon-container .icon-custom-bg > *' => 'margin-inline-start: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'i_shape' => 'custombg',
					'i_shape_options' => 'yes',
				],
			]
		);

        $this->add_control(
			'custom_i_width',
			[
				'label' => __( 'Width', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .iconbox-icon-container .icon-custom-bg > *' => 'width: {{SIZE}}{{UNIT}}; max-width: none;',
				],
                'condition' => [
                    'i_shape' => 'custombg',
					'i_shape_options' => 'yes',
				],
			]
		);

        $this->add_control(
			'custom_i_height',
			[
				'label' => __( 'Height', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .iconbox-icon-container .icon-custom-bg > *' => 'height: {{SIZE}}{{UNIT}};',
				],
                'condition' => [
                    'i_shape' => 'custombg',
					'i_shape_options' => 'yes',
				],
			]
		);

        $this->add_control(
			'i_shape_border_radius',
			[
				'label' => __( 'Border radius', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .iconbox-icon-container' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'i_shape' => 'square',
					'i_shape_options' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'custom_i_size',
			[
				'label' => __( 'Custom shape size', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 100,
				],
				'selectors' => [
					'{{WRAPPER}} .iconbox-icon-container' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'i_shape' => [ 'square' , 'circle' ],
					'i_shape_options' => 'yes',
				],
			]
		);

		$this->add_control(
			'i_border',
			[
				'label' => __( 'Border width', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'None', 'archub-elementor-addons' ),
					'1' => __( '1', 'archub-elementor-addons' ),
					'2' => __( '2', 'archub-elementor-addons' ),
					'3' => __( '3', 'archub-elementor-addons' ),
				],
				'condition' => [
					'i_shape' => ['square' , 'circle', 'lozenge'],
					'i_shape_options' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .iconbox-icon-container' => 'border-width: {{VALUE}}px;',
				],
			]
		);

		$this->add_control(
			'i_ripple_effect',
			[
				'label' => __( 'Ripple effect', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
				'condition' => [
					'i_shape' => ['square' , 'circle', 'lozenge'],
					'i_shape_options' => 'yes',
				],
			]
		);

		$this->end_popover(); // Shape Options

		$this->add_control(
			'position',
			[
				'label' => __( 'Position', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'iconbox-default',
				'options' => [
					'iconbox-default' => __( 'Icon on top', 'archub-elementor-addons' ),
					'iconbox-inline' => __( 'Icon and heading inline', 'archub-elementor-addons' ),
					'iconbox-side' => __( 'Icon and content inline', 'archub-elementor-addons' ),
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'alignment',
			[
				'label' => __( 'Iconbox alignment', 'archub-elementor-addons' ),
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
				'prefix_class' => 'elementor-align-',
				'selectors' => [
					'{{WRAPPER}} .iconbox' => 'text-align: {{VALUE}}; '
				],
				'default' => 'left',
				'toggle' => false,
			]
		);

		$this->add_control(
			'items_alignment',
			[
				'label' => __( 'Align icon to middle', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'align-items-center',
				'default' => '',
				'condition' => array(
					'position' => array('iconbox-side'),
				),
			]
		);

		$this->add_control(
			'i_linked',
			[
				'label' => __( 'Icons linked', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'iconbox-icon-linked',
				'default' => '',
				'condition' => array(
					'position' => array('iconbox-side'),
				),
			]
		);
		$this->end_controls_section();

		// Heading Section
		$this->start_controls_section(
			'heading_section',
			array(
				'label' => __( 'Heading', 'archub-elementor-addons' ),
			)
		);

		$this->add_control(
			'title',
			[
				'label' => __( 'Title', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( 'Heading', 'archub-elementor-addons' ),
				'placeholder' => __( 'Type your title here', 'archub-elementor-addons' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_el_typography',
				'label' => __( 'Heading typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-iconbox-heading',
			]
		);

		$this->add_control(
			'heading_icon_onhover',
			[
				'label' => __( 'Title icon on hover', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->add_responsive_control(
			'title_mb',
			[
				'label' => __( 'Heading margin', 'archub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'unit' => 'em',
					'bottom' => '0.7',
					'isLinked' => false
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-iconbox-heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Content Section
		$this->start_controls_section(
			'content_section',
			array(
				'label' => __( 'Content', 'archub-elementor-addons' ),
			)
		);

		$this->add_control(
			'content',
			[
				'label' => __( 'Content', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( 'Type your description here', 'archub-elementor-addons' ),
				'placeholder' => __( 'Type your description here', 'archub-elementor-addons' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'iconbox_content_typography',
				'label' => __( 'Content typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .contents p',
			]
		);

		$this->add_control(
			'link',
			[
				'label' => __( 'Link', 'archub-elementor-addons' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'archub-elementor-addons' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		);

		$this->add_control(
			'get_bubble_classname',
			[
				'label' => __( 'Show content in bubble box', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'iconbox-bubble',
				'default' => '',
			]
		);
		
		$this->add_control(
			'get_content_hover_classname',
			[
				'label' => __( 'Show content on hover', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'iconbox-contents-show-onhover',
				'default' => '',
				'condition' => array(
					'get_bubble_classname' => 'iconbox-bubble',
				),
			]
		);

		$this->add_control(
			'toggleable',
			[
				'label' => __( 'Toggle icon and button on hover', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
				'condition' => array(
					'get_bubble_classname' => '',
				),
			]
		);

		$this->add_responsive_control(
			'content_mb',
			[
				'label' => __( 'Content margin', 'archub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'unit' => 'em',
					'isLinked' => false
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-iconbox-content,{{WRAPPER}} p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Label Section
		$this->start_controls_section(
			'label_section',
			array(
				'label' => __( 'Label', 'archub-elementor-addons' ),
			)
		);
		
		$this->add_control(
			'show_label',
			[
				'label' => __( 'Add label to iconbox', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'label',
			[
				'label' => __( 'Content', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( 'Label', 'archub-elementor-addons' ),
				'placeholder' => __( 'Add label text', 'archub-elementor-addons' ),
				'condition' => array(
					'show_label' => 'yes',
				),
			]
		);

		
		$this->add_control(
			'label_position',
			[
				'label' => __( 'Label position', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'floating',
				'options' => [
					'floating' => __( 'Floating', 'archub-elementor-addons' ),
					'in_content' => __( 'In Content', 'archub-elementor-addons' ),
				],
				'condition' => array(
					'show_label' => 'yes',
				),
			]
		);

		$this->add_responsive_control(
			'label_offset_top',
			[
				'label' => __( 'Label top offset', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
						'step' => 1,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .iconbox-label' => 'top: {{SIZE}}{{UNIT}};',
				],
				'condition' => array(
					'show_label' => 'yes',
				),
			]
		);

		$this->add_responsive_control(
			'label_offset_right',
			[
				'label' => __( 'Label right offset', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => -500,
						'max' => 500,
						'step' => 1,
					],
					'%' => [
						'min' => -100,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .iconbox-label' => 'right: {{SIZE}}{{UNIT}};',
				],
				'condition' => array(
					'show_label' => 'yes',
				),
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

		$this->add_control(
			'animations_heading',
			[
				'label' => __( 'Animations', 'archub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'enable_scale_animation',
			[
				'label' => __( 'Scale animation?', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'style_colors_heading',
			[
				'label' => __( 'Colors', 'archub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		
		$this->add_control(
			'enable_gradient_icon',
			[
				'label' => __( 'Gradient icon?', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
				'condition' => [
					'i_type!' => [ 'image' ]
				],
			]
		);

		$this->start_controls_tabs(
			'style_color_tabs'
		);

		// Normal State
		$this->start_controls_tab(
			'style_color_normal_tab',
			[
				'label' => __( 'Normal', 'archub-elementor-addons' ),
			]
		);

			$this->add_control(
				'i_color',
				[
					'label' => __( 'Icon color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .iconbox-icon-container' => 'color: {{VALUE}}',
					],
					'condition' => [
						'enable_gradient_icon!' => 'yes',
						'i_type!' => [ 'image' ]
					]
				]
			);

			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name' => 'i_color2',
					'label' => __( 'Gradient color', 'archub-elementor-addons' ),
					'types' => [ 'classic', 'gradient' ],	
					'exclude' => [ 'image', 'classic' ],
					'selector' => '{{WRAPPER}} .iconbox-icon-container i',
					'fields_options' => [
						'background' => [
							'default' => 'gradient',
						],
					],
					'condition' => array(
						'enable_gradient_icon' => 'yes',
						'i_type!' => [ 'image' ]
					)
				]
			);
			
			$this->add_control(
				'svg_stroke_color',
				[
					'label' => __( 'SVG stroke color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .iconbox-icon-container > svg path:not([stroke=none])' => 'stroke: {{VALUE}}',
						'{{WRAPPER}} .iconbox-icon-container > svg rect:not([stroke=none])' => 'stroke: {{VALUE}}',
						'{{WRAPPER}} .iconbox-icon-container > svg ellipse:not([stroke=none])' => 'stroke: {{VALUE}}',
						'{{WRAPPER}} .iconbox-icon-container > svg circle:not([stroke=none])' => 'stroke: {{VALUE}}',
						'{{WRAPPER}} .iconbox-icon-container > svg polygon:not([stroke=none])' => 'stroke: {{VALUE}}',
						'{{WRAPPER}} .iconbox-icon-container > svg polyline:not([stroke=none])' => 'stroke: {{VALUE}}',
					],
					'condition' => [
						'i_type' => [ 'image' ]
					],
					'separator' => 'before'
				]
			);

			$this->add_control(
				'svg_fill_color',
				[
					'label' => __( 'SVG fill color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .iconbox-icon-container > svg path:not([stroke=none])' => 'fill: {{VALUE}}',
						'{{WRAPPER}} .iconbox-icon-container > svg rect:not([stroke=none])' => 'fill: {{VALUE}}',
						'{{WRAPPER}} .iconbox-icon-container > svg ellipse:not([stroke=none])' => 'fill: {{VALUE}}',
						'{{WRAPPER}} .iconbox-icon-container > svg circle:not([stroke=none])' => 'fill: {{VALUE}}',
						'{{WRAPPER}} .iconbox-icon-container > svg polygon:not([stroke=none])' => 'fill: {{VALUE}}',
						'{{WRAPPER}} .iconbox-icon-container > svg polyline:not([stroke=none])' => 'fill: {{VALUE}}',
					],
					'condition' => [
						'i_type' => [ 'image' ]
					]
				]
			);

			$this->add_control(
				'shape_color_heading',
				[
					'label' => __( 'Icon shape fill', 'archub-elementor-addons' ),
					'type' => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'i_shape' => [ 'square', 'circle', 'lozenge' ],
					],
				]
			);

			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name' => 'shape_color',
					'label' => __( 'Icon shape fill', 'archub-elementor-addons' ),
					'types' => [ 'classic', 'gradient' ],
					'selector' => '{{WRAPPER}} .iconbox-icon-container',
					'fields_options' => [
						'background' => [
							'default' => 'classic',
						],
					],
					'condition' => [
						'i_shape' => [ 'square', 'circle', 'lozenge' ],
					],
				]
			);

			$this->add_control(
				'border_shape_color',
				[
					'label' => __( 'Icon shape border color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .iconbox-icon-container' => 'border-color: {{VALUE}}',
					],
					'condition' => [
						'i_border' => [ '1', '2', '3' ],
					],
					'separator' => 'before'
				]
			);

			$this->add_control(
				'iconbox_ripple_color',
				[
					'label' => __( 'Ripple color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .iconbox-icon-ripple .iconbox-icon-container:before' => 'border-color: {{VALUE}}',
					],
					'condition' => [
						'i_ripple_effect' => 'yes',
					],
				]
			);

			$this->add_control(
				'h_color',
				[
					'label' => __( 'Heading color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} h3' => 'color: {{VALUE}}',
					],
					'separator' => 'before'
				]
			);

			$this->add_control(
				'content_color',
				[
					'label' => __( 'Content color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .contents p' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name' => 'label_bg',
					'label' => __( 'Gradient color', 'archub-elementor-addons' ),
					'types' => [ 'classic', 'gradient' ],	
					'exclude' => [ 'image', 'classic' ],
					'selector' => '{{WRAPPER}} .iconbox-label',
					'condition' => array(
						'show_label' => 'yes',
					),
					'separator' => 'before',
				]
			);

			$this->add_control(
				'label_color',
				[
					'label' => __( 'Label color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .iconbox-label' => 'color: {{VALUE}}',
					],
					'condition' => array(
						'show_label' => 'yes',
					),
				]
			);
	
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'icn_box_icon_shadow',
					'label' => __( 'Icon shape shadow', 'archub-elementor-addons' ),
					'selector' => '{{WRAPPER}} .iconbox-icon-container',
					'separator' => 'before',
					'condition' => [
						'i_shape' => [
							'square', 'circle'
						]
					]
				]
			);

		$this->end_controls_tab();

		// Hover State
		$this->start_controls_tab(
			'style_color_hover_tab',
			[
				'label' => __( 'Hover', 'archub-elementor-addons' ),
			]
		);

			$this->add_control(
				'h_i_color',
				[
					'label' => __( 'Icon color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}:hover .iconbox-icon-container' => 'color: {{VALUE}}',
					],
					'condition' => [
						'enable_gradient_icon!' => 'yes',
						'i_type!' => [ 'image' ]
					]
				]
			);

			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name' => 'h_i_color2',
					'label' => __( 'Gradient color', 'archub-elementor-addons' ),
					'types' => [ 'classic', 'gradient' ],	
					'exclude' => [ 'image', 'classic' ],
					'selector' => '{{WRAPPER}}:hover .iconbox-icon-container i',
					'fields_options' => [
						'background' => [
							'default' => 'gradient',
						],
					],
					'condition' => array(
						'enable_gradient_icon' => 'yes',
						'i_type!' => [ 'image' ]
					)
				]
			);

			$this->add_control(
				'h_svg_stroke_color',
				[
					'label' => __( 'SVG hover stroke color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}:hover .iconbox-icon-container > svg *:not([stroke=none])' => 'stroke: {{VALUE}}',
					],
					'condition' => [
						'i_type' => [ 'image' ]
					],
					'separator' => 'before'
				]
			);

			$this->add_control(
				'h_svg_fill_color',
				[
					'label' => __( 'SVG hover fill color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}:hover .iconbox-icon-container > svg path:not([stroke=none])' => 'fill: {{VALUE}}',
					],
					'condition' => [
						'i_type' => [ 'image' ]
					]
				]
			);

			$this->add_control(
				'shape_hcolor_heading',
				[
					'label' => __( 'SVG hover fill color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name' => 'shape_hcolor',
					'label' => __( 'Icon shape fill', 'archub-elementor-addons' ),
					'types' => [ 'classic', 'gradient' ],
					'selector' => '{{WRAPPER}}:hover .iconbox-icon-container',
					'fields_options' => [
						'background' => [
							'default' => 'classic',
						],
					],
					'condition' => [
						'i_shape' => [ 'square', 'circle', 'lozenge' ],
					],
				]
			);

			$this->add_control(
				'border_shape_hcolor',
				[
					'label' => __( 'Icon shape border color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}:hover .iconbox-icon-container' => 'border-color: {{VALUE}}',
					],
					'condition' => [
						'i_border' => [ '1', '2', '3' ],
					],
					'separator' => 'before'
				]
			);

			$this->add_control(
				'h_hcolor',
				[
					'label' => __( 'Heading color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}:hover h3' => 'color: {{VALUE}}',
					],
					'separator' => 'before',
				]
			);

			$this->add_control(
				'content_hcolor',
				[
					'label' => __( 'Content color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}:hover .contents p' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name' => 'h_label_bg',
					'label' => __( 'Gradient Color', 'archub-elementor-addons' ),
					'types' => [ 'classic', 'gradient' ],	
					'exclude' => [ 'image', 'classic' ],
					'selector' => '{{WRAPPER}}:hover .iconbox-label',
					'condition' => array(
						'show_label' => 'yes',
					),
					'separator' => 'before',
				]
			);

			$this->add_control(
				'h_label_color',
				[
					'label' => __( 'Label Color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}:hover .iconbox-label' => 'color: {{VALUE}}',
					],
					'condition' => array(
						'show_label' => 'yes',
					),
				]
			);
	
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'h_icn_box_icon_shadow',
					'label' => __( 'Icon Shape Shadow', 'archub-elementor-addons' ),
					'selector' => '{{WRAPPER}}:hover .iconbox-icon-container',
					'condition' => [
						'i_shape' => [
							'square', 'circle'
						]
					],
					'separator' => 'before'
				]
			);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		ld_el_btn($this, 'ib_'); // load button

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
		$this->add_inline_editing_attributes( 'title', 'basic' );
		$this->add_inline_editing_attributes( 'ib_title', 'none' );

		$atts = array(

			# General Section
			'i_type' => $settings['i_type'],
			'i_animated' => $settings['i_animated'],
			'i_icon_image' => isset($settings['i_icon_image']['id']) ? $settings['i_icon_image']['id'] : '',
			'i_icon_fontawesome' => isset($settings['i_icon_fontawesome']['value']) ? $settings['i_icon_fontawesome']['value'] : '',
			'icon_size' => isset($settings['icon_size']['size']) ? $settings['icon_size']['size'].$settings['icon_size']['unit'] : '', // will use selector

			## Shape prop
			'i_shape' => $settings['i_shape'],
			'i_shape_custom_bg' => isset($settings['i_shape_custom_bg']['id']) ? $settings['i_shape_custom_bg']['id'] : '',
			'custom_i_top_offset' => isset($settings['custom_i_top_offset']['size']) ? $settings['custom_i_top_offset']['size'].$settings['custom_i_top_offset']['unit'] : '',  
			'custom_i_left_offset' => isset($settings['custom_i_left_offset']['size']) ? $settings['custom_i_left_offset']['size'].$settings['custom_i_left_offset']['unit'] : '',
			'custom_i_width' => isset($settings['custom_i_width']['size']) ? $settings['custom_i_width']['size'].$settings['custom_i_width']['unit'] : '',
			'custom_i_height' => isset($settings['custom_i_height']['size']) ? $settings['custom_i_height']['size'].$settings['custom_i_height']['unit'] : '',
			'i_shape_border_radius' => isset($settings['i_shape_border_radius']['size']) ? $settings['i_shape_border_radius']['size'] : '',
			
			'custom_i_size' => isset($settings['custom_i_size']['size']) ? $settings['custom_i_size']['size'].$settings['custom_i_size']['unit'] : '',
			'i_border' => $settings['i_border'],
			'position' => $settings['position'],
			'alignment' => $settings['alignment'],
			'items_alignment' => $settings['items_alignment'],
			'i_linked' => $settings['i_linked'],
			'i_ripple_effect' => $settings['i_ripple_effect'],
			'custom_size' => isset($settings['custom_size']['size']) ? $settings['custom_size']['size'].$settings['custom_size']['unit'] : '',

			# Heading Section
			'title' => $settings['title'],
			'heading_icon_onhover' => $settings['heading_icon_onhover'],

			# Content Section
			'content' => $settings['content'],
			'link' => $settings['link']['url'],
			'get_bubble_classname' => $settings['get_bubble_classname'],
			'get_content_hover_classname' => $settings['get_content_hover_classname'],
			'toggleable' => $settings['toggleable'],

			# Label Section
			'show_label' => $settings['show_label'],
			'label' => $settings['label'],
			'label_position' => $settings['label_position'],

			# Style Tab
			'enable_gradient_icon' => $settings['enable_gradient_icon'],
			'i_color' => $settings['i_color'],
			'h_i_color' => $settings['h_i_color'],
			'h_color' => $settings['h_color'],
			'h_hcolor' => $settings['h_hcolor'],
			
			'svg_stroke_color' => $settings['svg_stroke_color'],
			'svg_fill_color' => $settings['svg_fill_color'],
			'h_svg_stroke_color' => $settings['h_svg_stroke_color'],
			'h_svg_fill_color' => $settings['h_svg_fill_color'],
			
			// Button
			'show_button' => $settings['show_button'],

			# Button
			'ib_title' => $settings['ib_title'],
			'ib_style' => $settings['ib_style'],
			'ib_link_type' => $settings['ib_link_type'],
			'ib_image_caption' => $settings['ib_image_caption'],
			'ib_anchor_id' => $settings['ib_anchor_id'],
			'ib_scroll_speed' => $settings['ib_scroll_speed'],
			'ib_link' => $settings['ib_link'],

			# Styling
			'ib_border_w' => $settings['ib_border_w'],
			'ib_hover_txt_effect' => $settings['ib_hover_txt_effect'],

			# Icon
			'ib_i_add_icon' => ($settings['ib_i_add_icon'] == true ? $settings['ib_i_add_icon'] : ''),
			'ib_i_type' => ($settings['ib_i_add_icon'] == true ? 'fontawesome' : ''),
			'ib_i_icon' => isset($settings['ib_icon']['value']) ? $settings['ib_icon']['value'] : '',
			'ib_i_size' => (isset($settings['ib_i_size']['size']) ? $settings['ib_i_size']['size'].'px' : ''),
			'ib_i_position' => $settings['ib_i_position'],
			'ib_i_shape' => $settings['ib_i_shape'],
			'ib_i_shape_style' => $settings['ib_i_shape_style'],
			'ib_i_shape_bw' => $settings['ib_i_shape_bw'],
			'ib_i_shape_size' => $settings['ib_i_shape_size'],
			'ib_i_hover_reveal' => $settings['ib_i_hover_reveal'],
			'ib_i_ripple' => $settings['ib_i_ripple'],
			'ib_i_separator' => $settings['ib_i_separator'],

		);

		extract( $atts );

		$classes = array( 
			'iconbox', 
			'd-flex',
			'flex-grow-1',
			'pos-rel',
			$position === 'iconbox-default' ? 'flex-column' : '',
			$position !== 'iconbox-default' && $alignment === 'right' ? 'flex-row-reverse' : '',
			$position === 'iconbox-inline' ? 'flex-wrap' : '',
			$position === 'iconbox-inline' || ( $position === 'iconbox-side' && $items_alignment === 'align-items-center' ) ? 'align-items-center' : '',
			$position === 'iconbox-inline' && $alignment === 'right' ? 'justify-content-end' : '',
			$position === 'iconbox-side' && $i_linked === 'iconbox-icon-linked' ? 'z-index-2' : '',
			$position,
			($enable_gradient_icon === 'yes') ? 'iconbox-icon-gradient' : '',
			($i_shape && $i_shape !== 'custombg') ? 'iconbox-icon-shaped' : '',
			($i_shape) ? 'iconbox-'.$i_shape : '',
			($heading_icon_onhover === 'yes') ? 'iconbox-heading-arrow-onhover' : '',
			$this->get_toggleable(),
			($i_ripple_effect === 'yes') ? 'iconbox-icon-ripple' : '',
			($i_animated === 'yes' ? 'lqd-animated-icon' : ''),
			$get_bubble_classname === 'iconbox-bubble' ? 'p-0' : '',
			$get_bubble_classname,
			$get_content_hover_classname,
			$i_linked,
		);
		
		$svg_attributes = $this->get_svg_attributes();

		// Button

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
			$ib_style === 'btn-solid' ? $settings['ib_hover_bg_effect'] : '',
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

		$ib_txt_class = array(
			'btn-txt',
			'd-block',
			'pos-rel',
			'z-index-3',
			'btn-hover-txt-switch btn-hover-txt-switch-x' === $ib_hover_txt_effect ||
			'btn-hover-txt-switch btn-hover-txt-switch-y' === $ib_hover_txt_effect ? 'overflow-hidden' : '',
		);
		$ib_inline_edit_attr = '';
		$ib_txt_attrs = [];

		$ib_data_text = $ib_title;

		if ( ! empty( $settings['ib_link']['url'] ) ) {
			$this->add_link_attributes( 'ib_link', $settings['ib_link'] );
		}

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
		}

		if ( $ib_hover_txt_effect === 'btn-hover-txt-switch-change btn-hover-txt-switch btn-hover-txt-switch-y' && ! empty($ib_title_secondary) ) {
			$ib_data_text = $ib_title_secondary;
		}

		if ( \Elementor\Plugin::$instance->editor->is_edit_mode() && ! strpos( $ib_hover_txt_effect, 'btn-hover-txt-switch' ) ) {
			array_push( $ib_txt_class, 'elementor-inline-editing' );
			$ib_txt_attrs['data-elementor-setting-key'] = 'ib_title';
			$ib_txt_attrs['data-elementor-inline-editing-toolbar'] = 'basic';
		}
		
		?>

			<div id="<?php echo esc_attr( 'ld_icon_box_'.$this->get_id() ); ?>" class="<?php echo ld_helper()->sanitize_html_classes( $classes ) ?>" <?php echo ld_helper()->html_attributes( $svg_attributes ) ?> <?php echo $this->get_border_opts() ?> <?php echo $this->get_toggleable_opts() ?>>
				
				<?php if( 'floating' === $label_position ) { ?>
					<?php printf( '<span class="iconbox-label d-inline-block pos-abs border-radius-circle font-weight-bold text-uppercase ltr-sp-1">%s</span>', esc_html( $label ) ); ?>
				<?php } ?>	
				
				<?php $this->get_the_icon() ?>
				
				<?php if( 
						'iconbox-inline' === $position || 
						'yes' === $toggleable          || 
						'iconbox-bubble' === $get_bubble_classname 
						) {
					$this->get_ib_title();
				} ?>
				
				<?php echo $this->before_icon_box_content() ?>
				
				<?php if( 'in_content' === $label_position ) { ?>
					<?php printf( '<span class="iconbox-label">%s</span>', esc_html( $label ) ); ?>
				<?php } ?>
				
				<?php if( 
						'iconbox-inline' !== $position && 
						'yes' !== $toggleable && 
						'iconbox-bubble' !== $get_bubble_classname 
						) { $this->get_ib_title(); } 
				?>
				<?php echo wp_kses_post( '<p class="lqd-iconbox-content"' . $this->get_render_attribute_string( 'content' )  . ' >' . $content . '</p>'); ?>

				<?php if ($show_button === 'yes') : ?>	
				<a <?php echo $this->get_render_attribute_string( 'ib_link' ); if ( isset($ib_attributes) ) echo ld_helper()->html_attributes( $ib_attributes ); ?> class="<?php echo ld_helper()->sanitize_html_classes( $ib_classes ); ?>" >
					<?php if( !empty( $ib_title ) ) { ?>
					<span class="<?php echo ld_helper()->sanitize_html_classes( $ib_txt_class ) ?>" <?php echo ld_helper()->html_attributes( $ib_txt_attrs ); ?> data-text="<?php echo esc_attr( $ib_data_text ) ?>" <?php $this->get_hover_text_opts(); ?>>
						<?php
							if(
								'btn-hover-txt-switch btn-hover-txt-switch-x' === $ib_hover_txt_effect ||
								'btn-hover-txt-switch btn-hover-txt-switch-y' === $ib_hover_txt_effect ||
								'btn-hover-txt-switch-change btn-hover-txt-switch btn-hover-txt-switch-y' === $ib_hover_txt_effect
							) {
						?>
							<span class="btn-txt-inner d-inline-flex align-items-center justify-content-center"  data-text="<?php echo esc_attr( $ib_data_text ) ?>">
								<?php echo wp_kses_post( do_shortcode( $ib_title ) ); ?>
							</span>
						<?php } else { ?>
							<?php echo wp_kses_post( do_shortcode( $ib_title ) ); ?>
						<?php } ?>
					</span>
				<?php } ?>
					<?php
						if( $ib_i_icon ) {
							printf( '<span class="btn-icon pos-rel z-index-3"><i class="%s"></i></span>', esc_attr( $ib_i_icon ) );
						}
						if( 'btn-hover-swp' === $ib_i_hover_reveal ) {
							printf( '<span class="btn-icon pos-rel z-index-3"><i class="%s"></i></span>', esc_attr( $ib_i_icon ) );
						}
						if( 'yes' === $settings['ib_extended_lines'] && 'btn-solid' === $ib_style ) {
							foreach (['tl', 'tr', 'br', 'bl'] as $side) { ?>
								<i class="btn-extended-line btn-extended-line-<?php echo esc_attr( $side ); ?> d-inline-block pos-abs pointer-events-none"></i>
							<?php }
						}
					?>
				</a>

				<?php endif; ?>
				
				<?php echo $this->after_icon_box_content() ?>
				
				<?php $this->get_overlay_link(); ?>

			</div>

		<?php
	}

	protected function content_template() {
		?>
		<#

		const classes = [
			settings.position === 'iconbox-default' ? 'flex-column' : '',
			settings.position !== 'iconbox-default' && settings.alignment === 'right' ? 'flex-row-reverse' : '',
			settings.position === 'iconbox-inline' ? 'flex-wrap' : '',
			settings.position === 'iconbox-inline' || ( settings.position === 'iconbox-side' && settings.items_alignment === 'align-items-center' ) ? 'align-items-center' : '',
			settings.position === 'iconbox-inline' && settings.alignment === 'right' ? 'justify-content-end' : '',
			settings.position === 'iconbox-side' && settings.i_linked === 'iconbox-icon-linked' ? 'z-index-2' : '',
			settings.position,
			(settings.enable_gradient_icon === 'yes') ? 'iconbox-icon-gradient' : '',
			(settings.i_shape && settings.i_shape !== 'custombg') ? 'iconbox-icon-shaped' : '',
			(settings.i_shape) ? 'iconbox-'+ settings.i_shape : '',
			(settings.heading_icon_onhover === 'yes') ? 'iconbox-heading-arrow-onhover' : '',
			(settings.toggleable === 'yes') ? 'iconbox-contents-show-onhover' : '',
			(settings.i_ripple_effect === 'yes') ? 'iconbox-icon-ripple' : '',
			(settings.i_animated === 'yes' ? 'lqd-animated-icon' : ''),
			settings.get_bubble_classname === 'iconbox-bubble' ? 'p-0' : '',
			settings.get_bubble_classname,
			settings.get_content_hover_classname,
			settings.i_linked,
		].filter(classname => classname !== '');

		view.addRenderAttribute( 'iconboxWrapper', {
			'class': [ 'iconbox', 'd-flex', 'flex-grow-1', 'pos-rel', classes.join(' ') ],			
		});

		function get_svg_attributes() {
			
			var i_type = settings.i_type;
			var icon = settings.i_icon_fontawesome.value;

			if ( settings.i_animated === 'yes' && settings.i_icon_fontawesome.value.url ){
				i_type = 'animated';
			}

			if ( settings.i_icon_fontawesome.value.url ){
				icon = settings.i_icon_fontawesome.value.url;
			}

			if (i_type === 'image'){
				icon = settings.i_icon_image.url;
			}
				
			var attributes = svg = [];
			var color = color2 = hcolor = hcolor2 = '';
			

			if ( i_type && 'image' === i_type ) {
				return '';
			}

			if (!(settings.i_animated === 'yes')){
				return '';
			}

			/* disabled
			if( icon ) {
				$filetype = wp_check_filetype( $icon );
				$svg['file'] =$icon;
				$attributes['data-animated-svg'] = true;	
			}
			
	
			if ( settings.animation_delay ) {
				$svg['delay'] = $settings['animation_delay'];
			}
			
			if( 'yes' === $settings['hover_animation'] ) {
				$svg['resetOnHover'] = true;
			}
			*/

			if ( settings.i_color ) {
				var color = settings.i_color;	
			}
			if ( settings.i_color2 && settings.i_color ) {
				var color2 = ':' + settings.i_color2;
			}
			if ( settings.i_color2 || settings.i_color ) {
				svg['color'] = color + color2;	
			}

			if ( settings.h_i_color ) {
				var hcolor = settings.h_i_color;
			}
			if ( settings.h_i_color2 && settings.h_i_color ) {
				var hcolor2 = ':' + settings.h_i_color2;
			}
			if ( settings.h_i_color2 || settings.h_i_color ) {
				svg['hoverColor'] = hcolor + hcolor2;
			}

			if ( svg ) {
				attributes['data-plugin-options'] = JSON.stringify( svg );
			}

			return attributes;

		}

		function get_toggleable_opts() {
			if( 'yes' !== settings.toggleable ) {
				return '';
			}
			return 'data-slideelement-onhover="true" data-slideelement-options=\'{ "visibleElement": ".iconbox-icon-wrap, p, h3", "hiddenElement": ".btn", "alignMid": true, "triggerElement": ".elementor-widget-container" }\'';
		}

		function get_border_opts() {
			var border = settings.i_border;
			var attr = '';
			if( border !== '' ) {
				attr = `data-shape-border="${border}"`;
			}
			return attr;
		}

		function get_the_icon() {

			var icon_html = '';
			var i_type = settings.i_type;
			var icon = settings.i_icon_fontawesome.value;
			var iconRender = elementor.helpers.renderIcon( view, settings.i_icon_fontawesome, { 'aria-hidden': true }, 'i' , 'object' );

			if (settings.i_animated === 'yes'){
				i_type = 'animated';
			}

			if ( i_type === 'image'){
				icon = settings.i_icon_image.url;
			}

			var icon_wrap_classnames = [
				'iconbox-icon-wrap',
				settings.position === 'iconbox-side' && settings.i_linked === 'iconbox-icon-linked' && settings.items_alignment === 'align-items-center' ? 'd-flex align-items-center' : '',
				settings.i_linked === 'iconbox-icon-linked' ? 'pos-rel' : '',
			];

			var icon_container_classnames = [
				'iconbox-icon-container',
				'd-inline-flex',
				settings.i_shape !== '' ? 'pos-rel' : '',
				settings.i_shape !== '' ? 'z-index-1' : '',
				settings.i_shape === 'circle' ? 'border-radius-circle' : '',
			];

			icon_html += '<div class="' + icon_wrap_classnames.join(' ') + '">';
			icon_html += '<div class="' + icon_container_classnames.join(' ') + '">';

			if ( settings.i_shape_custom_bg.url && 'custombg' === settings.i_shape){
				icon_html += '<span class="icon-custom-bg"><img src="' + settings.i_shape_custom_bg.url + '" /></span>';
			}
			
			if( i_type ) {			
				if( 'image' === i_type) {
					icon_html += '<img src="' + icon + '" class="lqd-image-icon" />'; 
				} else {
					if ( iconRender.value == undefined ){
						icon_html += '<i class="' + icon + '" aria-hidden="true"></i>';
					} else {
						icon_html += iconRender.value;
					}
				}
			}

			icon_html += '</div>';
			icon_html += '</div>';
			
			return icon_html;
			
		}

		function isValidURL(string) {
			var res = string.match(/(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g);
			return (res !== null)
		};

		// inline editing
		view.addInlineEditingAttributes( 'content', 'basic' );
		const ib_titleAttrs = {
			'class': [ 'lqd-iconbox-heading', 'elementor-inline-editing'],
			'data-elementor-setting-key': 'ib_title',
			'data-elementor-inline-editing-toolbar': 'basic'
		};
		view.addRenderAttribute( 'ib_titleAttributes', ib_titleAttrs);

		const btn_txt_attrs = {};

		const btn_txt_classes = [
			'btn-txt',
			'd-block',
			'pos-rel',
			'z-index-3',
			'elementor-inline-editing',
		];

		if ( settings.ib_hover_txt_effect.search('btn-hover-txt-switch') >= 0 ) {
			btn_txt_classes.push('overflow-hidden');
		} else {
			btn_txt_attrs['data-elementor-setting-key'] = 'title';
			btn_txt_attrs['data-elementor-inline-editing-toolbar'] = 'basic';
		}

		btn_txt_attrs['class'] = btn_txt_classes;

		view.addRenderAttribute( 'btn_txt_attributes', btn_txt_attrs);

		function get_ib_title() {

			if( ! settings.title ) {
				return '';
			}

			let heading_icon_svg = '';

			if ( settings.heading_icon_onhover === 'yes' ) {
				heading_icon_svg = '<svg class="d-inline-block" xmlns="http://www.w3.org/2000/svg" width="12" height="32" viewBox="0 0 12 32"><path fill="currentColor" d="M8.375 16L.437 8.062C-.125 7.5-.125 6.5.438 5.938s1.563-.563 2.126 0l9 9c.562.562.624 1.5.062 2.062l-9.063 9.063c-.312.312-.687.437-1.062.437s-.75-.125-1.063-.438c-.562-.562-.562-1.562 0-2.125z" fill="currentColor"></path></svg>';
			}
			
			return `<h3 ${view.getRenderAttributeString('ib_titleAttributes')}>${settings.title} ${heading_icon_svg}</h3>`;
		}

		// Button
		const ib_classes = [
			settings.ib_style,
			settings.ib_i_separator,
			settings.ib_hover_txt_effect,
			settings.ib_style === 'btn-solid' ? settings.ib_hover_bg_effect : '',

			settings.ib_link_type === 'lightbox' ? 'fresco' : '',
			
			//Icon classnames
			settings.ib_i_position,
			settings.ib_i_shape,
			settings.ib_i_shape !== '' && settings.ib_i_shape_style !== '' ? settings.ib_i_shape_size : '',
			settings.ib_i_shape !== '' && settings.ib_i_shape_style !== '' ? 'btn-icon-shaped' : '',
			settings.ib_i_shape_style,	
			settings.ib_i_shape_bw,	
			settings.ib_i_ripple,
			settings.ib_border_w,
			settings.ib_i_add_icon === 'true' && (settings.ib_i_position === 'btn-icon-left' || settings.ib_i_position === 'btn-icon-right') ? settings.ib_i_hover_reveal : '',
			settings.ib_title != '' ? 'btn-has-label' : 'btn-no-label',
		].filter(ib_class => ib_class !== '');

		function getExtendedLines() {

			const sides = ['tl', 'tr', 'br', 'bl'];

			sides.forEach(side => { #>
				<i class="btn-extended-line btn-extended-line-{{ side }} d-inline-block pos-abs pointer-events-none"></i>
			<# });

		};

		view.addRenderAttribute( 'buttonAttrs', {
			'class' : [
				'btn',
				'elementor-button',
				'align-items-center',
				'justify-content-center',
				'pos-rel',
				'overflow-hidden',
				'ws-nowrap',
				ib_classes.join(' ')
			],
		});

		const {ib_link_type} = settings;
		let link = settings.ib_link.url;
		let linkAttrs = ``;
		let anchorId = settings.ib_anchor_id === '' ? '#' : settings.ib_anchor_id;
		let dataText = settings.ib_title;

		if ( ib_link_type === 'modal_window' || ib_link_type === 'local_scroll' ) {
			link = anchorId;
		}
		if ( ib_link_type === 'local_scroll' || ib_link_type === 'scroll_to_section' ) {
			linkAttrs += ` data-localscroll="true"`;
		}

		if ( ib_link_type === 'modal_window' ) {
			linkAttrs += ` data-lqd-lity="${anchorId}"`;
		} else if ( ib_link_type === 'local_scroll' )  {
			linkAttrs += ` data-localscroll="true"`;
			if ( settings.scroll_speed !== '' ) {
				linkAttrs += ` data-localscroll-options='{"scrollSpeed": ${settings.ib_scroll_speed}}'`
			}
		} else if ( ib_link_type === 'scroll_to_section' ) {
			linkAttrs += ` data-localscroll-options='{"scrollBelowSection": true}'`
		}

		const {ib_hover_txt_effect} = settings;
		let hoverEffectAttrs = ``;
		
		switch( ib_hover_txt_effect ) {
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

		#>
		<div {{{ view.getRenderAttributeString('iconboxWrapper') }}} {{{ get_svg_attributes() }}} {{{ get_border_opts() }}} {{{ get_toggleable_opts() }}}  >
			<# if( 'floating' === settings.label_position && 'yes' === settings.show_label ) {  #>
				<span class="iconbox-label d-inline-block pos-abs border-radius-circle font-weight-bold text-uppercase ltr-sp-1"> {{{ settings.label }}} </span>
			<# } #>

			{{{ get_the_icon() }}}

			<# if( 'iconbox-inline' === settings.position || 'yes' === settings.toggleable || 'iconbox-bubble' === settings.get_bubble_classname ) { #>
				{{{ get_ib_title() }}}
			<# } #>

			<# if ( settings.content ) {#>
				<div class="contents ' + settings.get_bubble_classname === 'iconbox-bubble' ? 'border-radius-4' : '' + '">
			<# } #>

				<# if( 'in_content' === settings.label_position && 'yes' === settings.show_label ) { #>
						<span class="iconbox-label"> {{{ settings.label }}} </span> 
				<# } #>

				<# if( 'iconbox-inline' !== settings.position && 'yes' !== settings.toggleable && 'iconbox-bubble' !== settings.get_bubble_classname ) { #>
					{{{ get_ib_title() }}}
				<# } #>

				<p class="lqd-iconbox-content" {{{ view.getRenderAttributeString( 'content' ) }}} >{{{ settings.content }}}</p>

				<# if( settings.show_button === 'yes' ) { #>
					<a 
					href="{{ link.trim() }}"
					{{{ view.getRenderAttributeString('buttonAttrs') }}}
					data-fresco-caption="{{settings.ib_image_caption}}"
					{{{linkAttrs}}}
					>
						<# if ( settings.ib_title ) { #>
							<span {{{ view.getRenderAttributeString('btn_txt_attributes') }}} data-text="{{{dataText}}}">
					<# if (
						settings.hover_txt_effect === 'btn-hover-txt-switch btn-hover-txt-switch-x' ||
						settings.hover_txt_effect === 'btn-hover-txt-switch btn-hover-txt-switch-y' ||
						settings.hover_txt_effect === 'btn-hover-txt-switch-change btn-hover-txt-switch btn-hover-txt-switch-y'
					) { #>
					<span class="btn-txt-inner d-inline-flex align-items-center justify-content-center" data-text="{{{dataText}}}">
						{{{settings.ib_title}}}
					</span>
					<# } else { #>
						{{{settings.ib_title}}}
					<# } #>
				</span>
						<# } #>

						<# if ( settings.ib_i_add_icon ) { #>
							<span class="btn-icon pos-rel z-index-3"><i class="{{{ settings.ib_icon.value }}}"></i></span>
						<# } #>

						<# if ( 'btn-hover-swp' === settings.ib_i_hover_reveal && settings.ib_i_add_icon ) { #>
							<span class="btn-icon pos-rel z-index-3"><i class="{{{ settings.ib_icon.value }}}"></i></span>
						<# }
						if ( settings.ib_extended_lines === 'yes' && settings.ib_style === 'btn-solid' ) {
							getExtendedLines();
						} #>
					</a>
				<# } #>

			<# if ( settings.content ) { #>
				</div>
			<# } #>

			<# if ( settings.link.url ) { #>
				<a class="lqd-overlay z-index-2" href="{{{ settings.link.url  }}}"></a>
			<# } #>

		</div>
		<?php
	}

		protected function get_svg_attributes() {

			$settings = $this->get_settings_for_display();
			
			$i_type = $settings['i_type'];
			$icon = isset($settings['i_icon_fontawesome']['value']) ? $settings['i_icon_fontawesome']['value'] : '';
	
			if ($settings['i_animated'] === 'yes' && isset($settings['i_icon_fontawesome']['value']['url'])){
				$i_type = 'animated';
			}
	
			if (isset($settings['i_icon_fontawesome']['value']['url'])){
				$icon = $settings['i_icon_fontawesome']['value']['url'];
			}
	
			if ($i_type === 'image'){
				$icon = isset($settings['i_icon_image']['url']) ? $settings['i_icon_image']['url'] : '';
			}
				
			$attributes = $svg = array();
			$color  = $color2 = $hcolor = $hcolor2 = '';
			
			
			if( isset( $i_type ) && 'image' === $i_type ) {
				return;
			}

			if (!($settings['i_animated'] === 'yes')){
				return;
			}

			if( isset( $icon ) ) {
				$filetype = wp_check_filetype( $icon );
				$svg['file'] =$icon;
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
				$color2 = ':' . $settings['i_color2'];
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

		protected function get_border_opts() {

			$settings = $this->get_settings_for_display();
		
			$border = $settings['i_border'];
			if( empty( $border ) ) {
				return;
			}
	
			return 'data-shape-border="' . $border . '"';		
		}

	

	protected function get_the_icon() {

		$settings = $this->get_settings_for_display();

		$i_type = $settings['i_type'];
		$icon = isset($settings['i_icon_fontawesome']['value']) ? $settings['i_icon_fontawesome']['value'] : '';

		if ($settings['i_animated'] === 'yes'){
			$i_type = 'animated';
		}

		if (isset($settings['i_icon_fontawesome']['value']['url'])){
			$icon = $settings['i_icon_fontawesome']['value']['url'];
		}

		if ($i_type === 'image'){
			$icon = $settings['i_icon_image']['url'];
		}
		
		$icon_wrap_classnames = array(
			'iconbox-icon-wrap',
			$settings['position'] === 'iconbox-side' && $settings['i_linked'] === 'iconbox-icon-linked' && $settings['items_alignment'] === 'align-items-center' ? 'd-flex align-items-center' : '',
			$settings['i_linked'] === 'iconbox-icon-linked' ? 'pos-rel' : '',
		);

		$icon_container_classnames = array(
			'iconbox-icon-container',
			'd-inline-flex',
			$settings['i_shape'] !== '' ? 'pos-rel' : '',
			$settings['i_shape'] !== '' ? 'z-index-1' : '',
			$settings['i_shape'] === 'circle' ? 'border-radius-circle' : '',
		);
		
		echo  '<div class="' . implode(' ', $icon_wrap_classnames) . '">';
		echo ('<div class="' . implode(' ', $icon_container_classnames) . '">' );
		
		$this->get_custom_bg_shape();
		
		if( ! empty( $i_type ) ) {			
			if( 'image' === $i_type || 'animated' === $i_type ) {
				$filetype = wp_check_filetype( $icon );
				if( 'svg' === $filetype['ext']) {
					$request  = wp_remote_get( $icon );
					$response = wp_remote_retrieve_body( $request );
					$svg_icon = $response;
					if( 'animated' !== $i_type ) {
						echo $svg_icon;	
					}
				} 
				else {
					printf( '<img src="%s" class="lqd-image-icon" />', esc_url( $icon ) );
				}
			}
			else {
				Icons_Manager::render_icon( $settings['i_icon_fontawesome'], [ 'aria-hidden' => 'true' ] );
			}
		}

		echo '</div>';
		echo  '</div>';
	}

	protected function get_custom_bg_shape() {

		$settings = $this->get_settings_for_display();
		
		$out = '';
		
		$shape = $settings['i_shape'];
		$bg_id = isset($settings['i_shape_custom_bg']['id']) ? $settings['i_shape_custom_bg']['id'] : '';
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

		return 'data-slideelement-onhover="true" data-slideelement-options=\'{ "visibleElement": ".iconbox-icon-wrap, p, h3", "hiddenElement": ".btn", "alignMid": true, "triggerElement": ".elementor-widget-container" }\'';

	}

	protected function before_icon_box_content() {

		$settings = $this->get_settings_for_display();

		// check
		if( empty( $settings['content'] ) ) {
			return;
		}

		$get_bubble_classname = $settings['get_bubble_classname'];
		$classnames = array(
			'contents',
			$get_bubble_classname === 'iconbox-bubble' ? 'border-radius-4' : '',
		);

		return '<div class="' . implode(' ', $classnames) . '">';
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
		
		$link['href'] = $settings['link']['url'];
		
		if( empty( $link['href']) ) {
			return;
		}
		$link['class'] = 'lqd-overlay z-index-2';
		if( !empty($settings['localscroll_link']) ) {
			$link['data-localscroll'] = 'true';	
		}

		$link['target'] = $settings['link']['is_external'] ? '_blank"' : '_self';
		$link['rel'] = $settings['link']['nofollow'] ? 'nofollow' : '';

		echo '<a'. ld_helper()->html_attributes( $link ) .'></a>';
		
	}

	protected function get_ib_title() {

		$settings = $this->get_settings_for_display();

		// check
		if( empty( $settings['title'] ) ) {
			return;
		}

		$title  = wp_kses_post( do_shortcode( $settings['title'] ) );
		$hover_arrow_svg = '';

		if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
			$class = 'class="lqd-iconbox-heading elementor-inline-editing"';
			$inline_edit_attr = 'data-elementor-setting-key="title" data-elementor-inline-editing-toolbar="basic"';
		} else {
			$inline_edit_attr = '';
			$class = 'class="lqd-iconbox-heading"';
		}

		if( $settings['heading_icon_onhover'] === 'yes' ) {
			$hover_arrow_svg = '<svg class="d-inline-block" xmlns="http://www.w3.org/2000/svg" width="12" height="32" viewBox="0 0 12 32"><path fill="currentColor" d="M8.375 16L.437 8.062C-.125 7.5-.125 6.5.438 5.938s1.563-.563 2.126 0l9 9c.562.562.624 1.5.062 2.062l-9.063 9.063c-.312.312-.687.437-1.062.437s-.75-.125-1.063-.438c-.562-.562-.562-1.562 0-2.125z" fill="currentColor"></path></svg>';
		}

		printf( '<h3 %s %s>%s %s</h3>', $class, $inline_edit_attr, $title, $hover_arrow_svg );
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

}
