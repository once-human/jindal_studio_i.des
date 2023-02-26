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
class LD_Custom_Menu extends Widget_Base {

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
		return 'ld_custom_menu';
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
		return __( 'Liquid Custom Menu', 'archub-elementor-addons' );
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
		return 'eicon-menu-toggle lqd-element';
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

    private function get_available_menus() {
		$menus = wp_get_nav_menus();
		$options = [];
		foreach ( $menus as $menu ) {
			$options[ $menu->slug ] = $menu->name;
		}
		return $options;
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
		return [ 'header', 'menu' ];
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
				'label' => __( 'General', 'archub-elementor-addons' ),
			)
		);

		$this->add_control(
			'source',
			[
				'label' => __( 'Data source', 'archub-elementor-addons' ),
				'description' => __( 'Select Data source of the custom menu, it can be an existent wp menu or custom menu items added here the Items option.', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'wp_menus',
				'options' => [
					'wp_menus' => __( 'WP Menus', 'archub-elementor-addons' ),
					'custom' => __( 'Custom', 'archub-elementor-addons' ),
				],
			]
		);

        $menus = $this->get_available_menus();
	
		if ( ! empty( $menus ) ) {
			$this->add_control(
				'menu_slug',
				[
					'label' => __( 'Menu', 'archub-elementor-addons' ),
					'type' => Controls_Manager::SELECT,
					'options' => $menus,
					'default' => array_keys( $menus )[0],
					'save_default' => true,
					'separator' => 'after',
					'description'  => sprintf( __( 'Go to the <a href="%s" target="_blank">Menus screen</a> to manage your menus.', 'archub-elementor-addons' ), admin_url( 'nav-menus.php' ) ),
					'condition' => [
						'source' => 'wp_menus'
					],
 				]
			);
		} else {
			$this->add_control(
				'menu_slug',
				[
					'type' => Controls_Manager::RAW_HTML,
					'raw' => sprintf( __( '<strong>There are no menus in your site.</strong><br>Go to the <a href="%s" target="_blank">Menus screen</a> to create one.', 'archub-elementor-addons' ), admin_url( 'nav-menus.php?action=edit&menu=0' ) ),
					'separator' => 'after',
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
					'condition' => [
						'source' => 'wp_menus'
					],
				]
			);
		}

		$this->add_control(
			'localscroll',
			[
				'label' => __( 'Local scroll?', 'archub-elementor-addons' ),
				'description' => __( 'Enable to use localscroll feature for the menu items on the page', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'label', [
				'label' => __( 'Label', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'url', [
				'label' => __( 'URL (link)', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => '#',
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'target',
			[
				'label' => esc_html__( 'Open in new window', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'your-plugin' ),
				'label_off' => esc_html__( 'No', 'your-plugin' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$repeater->add_control(
			'badge', [
				'label' => __( 'Badge', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'badge_color',
			[
				'label' => __( 'Badge color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
			]
		);

		$repeater->add_control(
			'badge_bg',
			[
				'label' => __( 'Badge background', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
			]
		);

		$repeater->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'badge_bg',
				'label' => __( 'Background', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .block-revealer__element',
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
				],
				'condition' => [
					'enable_reveal' => 'yes'
				]
			]
		);
		
		$repeater->add_control(
			'icon_alignment',
			[
				'label' => __( 'Icon alignment', 'archub-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left-icon' => [
						'title' => __( 'Left', 'archub-elementor-addons' ),
						'icon' => 'fa fa-align-left',
					],
					'right-icon' => [
						'title' => __( 'Right', 'archub-elementor-addons' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'left-icon',
				'toggle' => false,
			]
		);

		$repeater->add_control(
			'icon_classname',
			[
				'label' => __( 'Icon', 'archub-elementor-addons' ),
				'type' => Controls_Manager::ICONS,
			]
		);

		$this->add_control(
			'items',
			[
				'label' => __( 'Items', 'archub-elementor-addons' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ label }}}',
				'condition' => [
					'source' => 'custom'
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'menu_alignment',
			[
				'label' => __( 'Menu alignment', 'archub-elementor-addons' ),
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
				],
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}}',
					'{{WRAPPER}} ul li a' => 'justify-content: {{VALUE}}',
				],
				'toggle' => true,
				'condition' => [
					'cm_sticky_type!' => 'lqd-sticky-menu-floating-vertical',
				],
			]
		);

		$this->add_control(
			'icon_pos',
			[
				'label' => __( 'Icon position', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'icon-next-to-label',
				'options' => [
					'icon-next-to-label' => __( 'Next to menu label', 'archub-elementor-addons' ),
					'icon-push-to-edge' => __( 'Push to the edge', 'archub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'sticky',
			[
				'label' => __( 'Sticky?', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'cm_sticky_type',
			[
				'label' => __( 'Sticky type', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'lqd-sticky-menu-default',
				'options' => [
					'lqd-sticky-menu-default' => __( 'Default', 'archub-elementor-addons' ),
					'lqd-sticky-menu-floating' => __( 'Floating horizontal', 'archub-elementor-addons' ),
					'lqd-sticky-menu-floating-vertical' => __( 'Floating vertical', 'archub-elementor-addons' ),
				],
				'condition' => [
					'sticky' => 'yes'
				],
			]
		);

		$this->add_responsive_control(
			'cm_sticky_vertical_pos',
			[
				'label' => __( 'Menu alignment', 'archub-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'archub-elementor-addons' ),
						'icon' => 'eicon-h-align-left',
					],
					'right' => [
						'title' => __( 'Right', 'archub-elementor-addons' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => 'right',
				'toggle' => false,
				'condition' => [
					'sticky' => 'yes',
					'cm_sticky_type' => 'lqd-sticky-menu-floating-vertical',
				],
			]
		);

		$this->add_responsive_control(
			'cm_sticky_vertical_offset_right',
			[
				'label' => __( 'Offset', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'vw' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 60,
					'unit' => 'px'
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-sticky-menu' => 'right: {{SIZE}}{{UNIT}}; left: auto;',
				],
				'condition' => [
					'sticky' => 'yes',
					'cm_sticky_type' => 'lqd-sticky-menu-floating-vertical',
					'cm_sticky_vertical_pos' => 'right'
				],
			]
		);

		$this->add_responsive_control(
			'cm_sticky_vertical_offset_left',
			[
				'label' => __( 'Offset', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vw' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'vw' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'size' => 60,
					'unit' => 'px'
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-sticky-menu' => 'left: {{SIZE}}{{UNIT}}; right: auto;',
				],
				'condition' => [
					'sticky' => 'yes',
					'cm_sticky_type' => 'lqd-sticky-menu-floating-vertical',
					'cm_sticky_vertical_pos' => 'left'
				],
			]
		);

		$this->add_control(
			'inline',
			[
				'label' => __( 'Inline?', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
				'condition' => [
					'sticky!' => 'yes'
				],
			]
		);

		$this->add_control(
			'auto_expand_items',
			[
				'label' => __( 'Auto expand items?', 'archub-elementor-addons' ),
				'description' => __( 'Expand items to fill the container', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'inline-nav',
				'default' => '',
				'condition' => [
					'sticky' => 'yes',
					'cm_sticky_type!' => 'lqd-sticky-menu-floating-vertical',
				],
			]
		);

		$this->add_control(
			'add_separator',
			[
				'label' => __( 'Add separator?', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
				'condition' => [
					'inline' => 'inline-nav',
					'cm_sticky_type!' => 'lqd-sticky-menu-floating-vertical',
				],
			]
		);

		$this->add_control(
			'separator',
			[
				'label' => __( 'Separator', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Add separator', 'archub-elementor-addons' ),
				'condition' => [
					'add_separator' => 'yes',
					'cm_sticky_type!' => 'lqd-sticky-menu-floating-vertical',
				],
			]
		);

		$this->add_responsive_control(
			'spacing',
			[
				'label' => __( 'Space bottom', 'archub-elementor-addons' ),
				'description' => __( 'Space between items. Does not work if "Auto Expand Items?" is enabled.', 'archub-elementor-addons' ),
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
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-custom-menu > ul > li:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'spacing2',
			[
				'label' => __( 'Space between', 'archub-elementor-addons' ),
				'description' => __( 'Space between items. Does not work if "Auto Expand Items?" is enabled.', 'archub-elementor-addons' ),
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
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-custom-menu > ul > li:not(:last-child)' => 'margin-inline-end: {{SIZE}}{{UNIT}};'
				],
				'condition' => [
					'inline' => 'yes',
					'cm_sticky_type!' => 'lqd-sticky-menu-floating-vertical',
				]
			]
		);

		$this->add_control(
			'add_toggle',
			[
				'label' => __( 'Add toggle button?', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
				'condition' => [
					'sticky' => ''
				],
			]
		);

		$this->add_control(
			'dropdown_collapsed',
			[
				'label' => __( 'Collapsed?', 'archub-elementor-addons' ),
				'description' => __( 'Enable if you want the dropdown collapsed by default.', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
				'condition' => [
					'add_toggle' => 'yes'
				],
			]
		);

		$this->add_control(
			'mobile_add_toggle',
			[
				'label' => __( 'Collapsible on mobile?', 'archub-elementor-addons' ),
				'description' => __( 'Enable this option if you want to make the menu collapsible on mobile', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
				'condition' => [
					'cm_sticky_type!' => 'lqd-sticky-menu-floating-vertical',
				],
			]
		);

		$this->add_control(
			'toggle_button_text',
			[
				'label' => __( 'Toggle text', 'archub-elementor-addons' ),
				'description' => __( 'Add text for toggle button', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Add separator', 'archub-elementor-addons' ),
				'condition' => [
					'add_toggle' => 'yes'
				],
			]
		);

		$this->add_control(
			'mobile_toggle_button_text',
			[
				'label' => __( 'Mobile toggle text', 'archub-elementor-addons' ),
				'description' => __( 'Add text for mobile toggle button', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Add separator', 'archub-elementor-addons' ),
				'condition' => [
					'mobile_add_toggle' => 'yes'
				],
			]
		);

		$this->add_control(
			'toggle_shape',
			[
				'label' => __( 'Toggle shape', 'archub-elementor-addons' ),
				'description' => __( 'Select a shape for the toggle button', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Sharp', 'archub-elementor-addons' ),
					'round' => __( 'Round', 'archub-elementor-addons' ),
					'circle' => __( 'Circle', 'archub-elementor-addons' ),
				],
				'condition' => [
					'add_toggle' => 'yes'
				],
			]
		);

		$this->add_control(
			'toggle_icon',
			[
				'label' => __( 'Toggle icon', 'archub-elementor-addons' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fa fa-bars',
					'library' => 'solid',
				],
				'condition' => [
					'add_toggle' => 'yes'
				],
				'separator' => 'after',
			]
		);

		$this->add_control(
			'add_scroll_indicator',
			[
				'label' => __( 'Scroll indicator?', 'archub-elementor-addons' ),
				'description' => __( 'Add scroll indicator to each menu item.', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
				'condition' => [
					'sticky' => 'yes',
					'cm_sticky_type!' => 'lqd-sticky-menu-floating-vertical',
				],
			]
		);

		$this->add_control(
			'magnetic_items',
			[
				'label' => __( 'Magnetic items?', 'archub-elementor-addons' ),
				'description' => __( 'Enables magnetic menu items, If custom cursor is enabled from Theme Options.', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
				'condition' => [
					'cm_sticky_type!' => 'lqd-sticky-menu-floating-vertical',
				],
			]
		);

		$this->add_control(
			'items_decoration',
			[
				'label' => __( 'Border style', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'lqd-menu-td-none',
				'options' => [
					'lqd-menu-td-none' => __( 'None', 'archub-elementor-addons' ),
					'lqd-menu-td-underline' => __( 'Underline', 'archub-elementor-addons' ),
				],
				'condition' => [
					'cm_sticky_type!' => 'lqd-sticky-menu-floating-vertical',
				],
			]
		);
        $this->end_controls_section();

		$this->start_controls_section(
			'tyopgraphys_section',
			[
				'label' => __( 'Typography', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'menu_typographys',
				'label' => __( 'Menu typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} ul > li > a',
			]
		);
		$this->end_controls_section();

		// Navigation Container Styling
		$this->start_controls_section(
			'container_section',
			[
				'label' => __( 'Navigation container styling', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'bgcolor',
			[
				'label' => __( 'Navigation background color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-fancy-menu' => 'background: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'container_border_color',
			[
				'label' => __( 'Navigation border color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-fancy-menu' => 'border-bottom:1px solid {{VALUE}}',
				],
			]
		);
		$this->end_controls_section();

		// Menu Items Styling
		$this->start_controls_section(
			'menu_items_section',
			[
				'label' => __( 'Menu items styling', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'color',
			[
				'label' => __( 'Links color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-fancy-menu > ul > li > a' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'hcolor',
			[
				'label' => __( 'Links hover/active color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-fancy-menu > ul > li > a:hover, {{WRAPPER}} .lqd-fancy-menu li.is-active > a' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'bg_color',
			[
				'label' => __( 'Link background color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-fancy-menu > ul > li > a' => 'background: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'bg_hcolor',
			[
				'label' => __( 'Hover link background color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-fancy-menu > ul > li > a:hover, {{WRAPPER}} .lqd-fancy-menu li.is-active > a' => 'background: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'border_color',
			[
				'label' => __( 'Links border color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-fancy-menu.menu-items-has-border > ul > li > a' => 'border-color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'border_hcolor',
			[
				'label' => __( 'Links hover border color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-fancy-menu.menu-items-has-border > ul > li > a:hover, {{WRAPPER}} .lqd-fancy-menu.menu-items-has-border > ul > li.is-active > a' => 'border-color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'icon_color',
			[
				'label' => __( 'Icon color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-fancy-menu > ul > li .link-icon' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'icon_hcolor',
			[
				'label' => __( 'Hover icon color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-fancy-menu > ul > li > a:hover .link-icon, {{WRAPPER}} .lqd-fancy-menu li.is-active .link-icon' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'toggle_color',
			[
				'label' => __( 'Toggle color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-fancy-menu .lqd-custom-menu-dropdown-btn' => 'color: {{VALUE}}',
				],
				'condition' => [
					'add_toggle' => 'yes'
				],
			]
		);
		$this->add_control(
			'toggle_active_color',
			[
				'label' => __( 'Toggle active color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-fancy-menu .lqd-custom-menu-dropdown-btn.is-active' => 'color: {{VALUE}}',
				],
				'condition' => [
					'add_toggle' => 'yes'
				],
			]
		);
		$this->add_control(
			'toggle_bg_color',
			[
				'label' => __( 'Toggle bg color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-fancy-menu .lqd-custom-menu-dropdown-btn' => 'background: {{VALUE}}',
				],
				'condition' => [
					'add_toggle' => 'yes'
				],
			]
		);
		$this->add_control(
			'toggle_active_bg_color',
			[
				'label' => __( 'Toggle active bg color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-fancy-menu .lqd-custom-menu-dropdown-btn.is-active' => 'background: {{VALUE}}',
				],
				'condition' => [
					'add_toggle' => 'yes'
				],
			]
		);
		$this->add_control(
			'scroll_indicator_bg',
			[
				'label' => __( 'Scroll indicator bg', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-fancy-menu .lqd-scrl-indc .lqd-scrl-indc-line' => 'background: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'scroll_indicator_progress',
			[
				'label' => __( 'Scroll indicator progress', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-fancy-menu .lqd-scrl-indc .lqd-scrl-indc-el' => 'background: {{VALUE}}',
				],
			]
		);
		$this->end_controls_section();

		// Sticky Colors
		$this->start_controls_section(
			'sticky_colors_section',
			[
				'label' => __( 'Sticky colors', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'sticky_bgcolor',
			[
				'label' => __( 'Background color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.is-stuck {{WRAPPER}} .lqd-fancy-menu' => 'background: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			'sticky_color',
			[
				'label' => __( 'Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.is-stuck {{WRAPPER}} .lqd-fancy-menu > ul > li > a' => 'color: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			'sticky_hcolor',
			[
				'label' => __( 'Hover color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.is-stuck {{WRAPPER}} .lqd-fancy-menu > ul > li > a:hover, .is-stuck .lqd-fancy-menu li.is-active > a' => 'color: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			'sticky_bg_color',
			[
				'label' => __( 'Background color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.is-stuck {{WRAPPER}} .lqd-fancy-menu > ul > li > a' => 'background: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			'sticky_bg_hcolor',
			[
				'label' => __( 'Hover background color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.is-stuck {{WRAPPER}} .lqd-fancy-menu > ul > li > a:hover, .is-stuck .lqd-fancy-menu li.is-active > a' => 'background: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			'sticky_border_color',
			[
				'label' => __( 'Links border color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.is-stuck {{WRAPPER}} .lqd-fancy-menu.menu-items-has-border > ul > li > a' => 'border-color: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			'sticky_border_hcolor',
			[
				'label' => __( 'Links hover border color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.is-stuck {{WRAPPER}} .lqd-fancy-menu.menu-items-has-border > ul > li > a:hover, .is-stuck {{WRAPPER}} .lqd-fancy-menu.menu-items-has-border > ul > li.is-active > a' => 'border-color: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			'sticky_icon_color',
			[
				'label' => __( 'Icon color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.is-stuck {{WRAPPER}} .lqd-fancy-menu > ul > li .link-icon' => 'color: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			'sticky_icon_hcolor',
			[
				'label' => __( 'Hover icon color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.is-stuck {{WRAPPER}} .lqd-fancy-menu > ul > li > a:hover .link-icon, .is-stuck .lqd-fancy-menu li.is-active .link-icon' => 'color: {{VALUE}} !important',
				],
			]
		);
		$this->end_controls_section();

		// Colors Over Light Rows
		$this->start_controls_section(
			'sticky_light_section',
			[
				'label' => __( 'Colors over light rows', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'sticky_light_bgcolor',
			[
				'label' => __( 'Background color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-light .lqd-fancy-menu' => 'background: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			'sticky_light_color',
			[
				'label' => __( 'Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-light .lqd-fancy-menu > ul > li > a' => 'color: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			'sticky_light_hcolor',
			[
				'label' => __( 'Hover color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-light .lqd-fancy-menu > ul > li > a:hover, {{WRAPPER}}.lqd-active-row-light .lqd-fancy-menu li.is-active > a' => 'color: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			'sticky_light_bg_color',
			[
				'label' => __( 'Background color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-light .lqd-fancy-menu > ul > li > a' => 'background: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			'sticky_light_bg_hcolor',
			[
				'label' => __( 'Hover background color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-light .lqd-fancy-menu > ul > li > a:hover, {{WRAPPER}}.lqd-active-row-light .lqd-fancy-menu li.is-active > a' => 'background: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			'sticky_light_border_color',
			[
				'label' => __( 'Border color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-light .lqd-fancy-menu.menu-items-has-border > ul > li > a' => 'border-color: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			'sticky_light_border_hcolor',
			[
				'label' => __( 'Hover border color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-light .lqd-fancy-menu.menu-items-has-border > ul > li > a:hover, {{WRAPPER}}.lqd-active-row-light .lqd-fancy-menu.menu-items-has-border > ul > li.is-active > a' => 'border-color: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			'sticky_light_icon_color',
			[
				'label' => __( 'Icon color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-light .lqd-fancy-menu > ul > li .link-icon' => 'color: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			'sticky_light_icon_hcolor',
			[
				'label' => __( 'Hover icon color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-light .lqd-fancy-menu > ul > li > a:hover .link-icon, {{WRAPPER}}.lqd-active-row-light .lqd-fancy-menu li.is-active .link-icon' => 'color: {{VALUE}} !important',
				],
			]
		);
		$this->end_controls_section();

		// Colors Over Light Rows
		$this->start_controls_section(
			'sticky_dark_section',
			[
				'label' => __( 'Colors over dark rows', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'sticky_dark_bgcolor',
			[
				'label' => __( 'Background color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-dark .lqd-fancy-menu' => 'background: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			'sticky_dark_color',
			[
				'label' => __( 'Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-dark .lqd-fancy-menu > ul > li > a' => 'color: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			'sticky_dark_hcolor',
			[
				'label' => __( 'Hover color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-dark .lqd-fancy-menu > ul > li > a:hover, {{WRAPPER}}.lqd-active-row-dark .lqd-fancy-menu li.is-active > a' => 'color: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			'sticky_dark_bg_color',
			[
				'label' => __( 'Background color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-dark .lqd-fancy-menu > ul > li > a' => 'background: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			'sticky_dark_bg_hcolor',
			[
				'label' => __( 'Hover background color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-dark .lqd-fancy-menu > ul > li > a:hover, {{WRAPPER}}.lqd-active-row-dark .lqd-fancy-menu li.is-active > a' => 'background: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			'sticky_dark_border_color',
			[
				'label' => __( 'Border color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-dark .lqd-fancy-menu.menu-items-has-border > ul > li > a' => 'border-color: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			'sticky_dark_border_hcolor',
			[
				'label' => __( 'Hover border color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-dark .lqd-fancy-menu.menu-items-has-border > ul > li > a:hover, {{WRAPPER}}.lqd-active-row-dark .lqd-fancy-menu.menu-items-has-border > ul > li.is-active > a' => 'border-color: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			'sticky_dark_icon_color',
			[
				'label' => __( 'Icon color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-dark .lqd-fancy-menu > ul > li .link-icon' => 'color: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			'sticky_dark_icon_hcolor',
			[
				'label' => __( 'Hover icon color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-dark .lqd-fancy-menu > ul > li > a:hover .link-icon, {{WRAPPER}}.lqd-active-row-dark .lqd-fancy-menu li.is-active .link-icon' => 'color: {{VALUE}} !important',
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

		extract( $settings );

		$menu_slug = (isset($settings['menu_slug'] )? $settings['menu_slug'] : '' );
		
		$menu_fill =
		$bg_color || $bg_hcolor ||
		$sticky_bg_color || $sticky_bg_hcolor ||
		$sticky_light_bg_color || $sticky_light_bg_hcolor ||
		$sticky_dark_bg_color || $sticky_dark_bg_hcolor ? 'menu-items-has-fill' : '';
		
		$toggle_fill = ( $add_toggle && ( $toggle_bg_color || $toggle_active_bg_color ) ) ? 'toggle-has-fill' : '';
		
		$items_border = $border_color || $border_hcolor ? 'menu-items-has-border' : '';
		
		$pos_classname = 'pos-rel';

		if ( $sticky ) {
			if ( $cm_sticky_type === 'lqd-custom-menu-floating-vertical' ) {
				$pos_classname = 'pos-fix';
			} else {
				$pos_classname = 'pos-abs';
			}
		}
		
		$classes = array(
			'lqd-fancy-menu',
			'lqd-custom-menu',
			$pos_classname,
			$menu_fill,
			$items_border,
			$toggle_fill,
			$menu_alignment,
			$items_decoration,
			$sticky ? 'lqd-sticky-menu' : '',
			$sticky && $cm_sticky_type ? $cm_sticky_type : '',
			$sticky && $cm_sticky_type === 'lqd-custom-menu-floating-vertical' ? $cm_sticky_vertical_pos : '',
			$mobile_add_toggle === 'yes' ? 'lqd-custom-menu-mobile-collapsible' : '',
			$magnetic_items === 'yes' ? 'lqd-magnetic-items' : '',
			$auto_expand_items === 'inline-nav' ? 'lqd-custom-menu-expand-items' : '', 
		);
		
		$ul_classes = array(
			'reset-ul',
			($inline || $sticky) ? 'inline-nav' : '',
			$add_toggle === 'yes' && $settings['dropdown_collapsed'] !== 'yes' ? 'in is-active' : '',
			$add_toggle ? 'collapse lqd-custom-menu-dropdown w-100' : ''
		);
		
		$toggle_classes = array(
			'lqd-custom-menu-dropdown-btn',
			'd-flex',
			'align-items-center',
			$toggle_shape === 'round' ? 'border-radius-4' ? 'circle' : 'border-radius-circle' : '',
			$add_toggle === 'yes' && $settings['dropdown_collapsed'] !== 'yes' ? 'is-active' : ''
		);

		$scroll_ind = '';
		$scroll_data = array();
		if ( 'yes' === $localscroll ) { 
			$scroll_data['data-localscroll'] = true;
			$scroll_data['data-localscroll-options'] = wp_json_encode( array(
				"itemsSelector" => "> li > a",
				"trackWindowScroll" => true,
				"includeParentAsOffset" => $sticky ? true : false,
				"offsetElements" => "[data-sticky-header] .lqd-head-sec-wrap:not(.lqd-hide-onstuck), #wpadminbar, body.elementor-page .main-header[data-sticky-header] > .elementor > .elementor-section:not(.lqd-hide-onstuck):not(.lqd-stickybar-wrap)"
			));
		}

		$is_sticky_default = $sticky && $cm_sticky_type === 'lqd-sticky-menu-default';
		$is_sticky_floating = $sticky && $cm_sticky_type === 'lqd-sticky-menu-floating';
		$is_floating_vertical = $sticky && $cm_sticky_type === 'lqd-sticky-menu-floating-vertical';

		?>

			<div  
				class="<?php echo ld_helper()->sanitize_html_classes( $classes ) ?>"
				<?php if( $is_sticky_default ) { ?>
					data-pin="true" 
					data-pin-options='{ "start": "top+=1 top", "offset": "[data-sticky-header] .lqd-head-sec-wrap:not(.lqd-hide-onstuck), [data-sticky-header] .lqd-mobile-sec, #wpadminbar, body.elementor-page .main-header[data-sticky-header] > .elementor > .elementor-section:not(.lqd-hide-onstuck):not(.lqd-stickybar-wrap)", "duration": "last-link" }' 
					data-move-element='{ "target": ".vc_row" }'
				<?php } else if ( $is_sticky_floating ) { ?>
					data-inview="true"
					data-inview-options='{ "toggleBehavior": "toggleInView" }'
				<?php } else if ( $is_floating_vertical ) { ?>
					data-move-element='{ "target": ".vc_row" }'
				<?php }  ?>
			>
			<?php if( 'yes' === $add_toggle || 'yes' === $mobile_add_toggle ) { ?>
			<span class="<?php echo ld_helper()->sanitize_html_classes( $toggle_classes ) ?>" data-target="#<?php echo esc_attr($this->get_id()); ?>" data-toggle="collapse" data-ld-toggle="true" data-toggle-options='{ "closeOnOutsideClick": {"ifNotIn": "#lqd-site-content"} }'>

				<?php if ( 'yes' === $add_toggle ) { ?>
				<span class="d-inline-flex me-3">
					<?php Icons_Manager::render_icon( $settings['toggle_icon'], [ 'aria-hidden' => 'true' ] ); ?>
				</span>
				<?php } ?>
				
				<?php if( !empty( $toggle_button_text ) || ! empty($mobile_toggle_button_text) ) { ?>
					<span class="toggle-label">
						<?php if( !empty( $toggle_button_text ) ) { ?>
							<?php echo wp_kses_post( do_shortcode( $toggle_button_text ) )?>
						<?php } else if ( ! empty($mobile_toggle_button_text) ) { ?>
							<?php echo wp_kses_post( do_shortcode( $mobile_toggle_button_text ) )?>
						<?php } ?>
					</span>
				<?php } ?>

				<span class="expander-icon ms-auto d-inline-flex">
					<i class="lqd-icn-ess icon-ion-ios-arrow-down"></i>
				</span>
			</span>
			<?php } ?>

			<?php if( 'wp_menus' === $source ) : ?>
			<?php

				if ( 'yes' === $add_scroll_indicator ) {
					$scroll_ind = '<span class="lqd-scrl-indc lqd-scrl-indc-h lqd-scrl-indc-scale d-flex w-100 ws-nowrap" data-lqd-scroll-indicator="true" data-scrl-indc-options=\'{ "scrollingTarget": "siblingsHref", "dir": "x", "scale": true, "start": "top bottom", "end": "top top-=99.65%", "waitForElementMove": '. $is_sticky_default .' }\'>
						<span class="lqd-scrl-indc-inner d-flex align-items-center w-100 h-100 overflow-hidden">
							<span class="lqd-scrl-indc-line flex-grow-1 pos-rel">
								<span class="lqd-scrl-indc-el d-inline-block"></span>
							</span>
						</span>
					</span>';
				}

				if( is_nav_menu( $menu_slug ) ) {
					wp_nav_menu( array(
						'menu'           => $menu_slug,
						'container'      => 'ul',
						'container_id'   => '',
						'menu_id'        => $this->get_id(),
						'before'         => false,
						'after'          => $scroll_ind,
						'menu_class'     => esc_attr( implode( ' ', $ul_classes ) ),
						'items_wrap'     => '<ul id="%1$s" class="%2$s" ' . ld_helper()->html_attributes( $scroll_data ) . '>%3$s</ul>',
						'walker'         => class_exists( 'Liquid_Mega_Menu_Walker' ) ? new \Liquid_Mega_Menu_Walker : '',
					) );
				}
				else {
					wp_nav_menu( array(
						'container'   => 'ul',
						'container_id'   => '',
						'menu_id'        => $this->get_id(),
						'before'      => false,
						'after'       => $scroll_ind,
						'menu_class'     => esc_attr( implode( ' ', $ul_classes ) ),
						'items_wrap'     => '<ul id="%1$s" class="%2$s" ' . ld_helper()->html_attributes( $scroll_data ) . '>%3$s</ul>',
						'walker'         => class_exists( 'Liquid_Mega_Menu_Walker' ) ? new \Liquid_Mega_Menu_Walker : '',
					));

				};
			?>
			<?php else: ?>
				<ul class="<?php echo ld_helper()->sanitize_html_classes( $ul_classes ) ?>" id="<?php echo $this->get_id() ?>" <?php echo ld_helper()->html_attributes( $scroll_data ); ?>>
				<?php
					foreach ( $items as $item ) {
						if ( empty( $item['url'] ) ) {
							continue;
						}

						$badge = $badge_color = $badge_bg = '';
						
						$attr = array( 
							'href' => esc_url( $item['url'] ), 
							'target' => esc_attr( isset($item['target']) ? $item['target'] : '' )
						);

						if ( 'yes' === $add_scroll_indicator ) {
							$scroll_ind = '<span class="lqd-scrl-indc lqd-scrl-indc-h lqd-scrl-indc-scale d-flex w-100 ws-nowrap" data-lqd-scroll-indicator="true" data-scrl-indc-options=\'{ "scrollingTarget": "' . $attr['href'] . '", "dir": "x", "scale": true, "start": "top bottom", "end": "top top-=99.65%", "waitForElementMove": '. $is_sticky_default .' }\'>
								<span class="lqd-scrl-indc-inner d-flex align-items-center w-100 h-100 overflow-hidden">
									<span class="lqd-scrl-indc-line flex-grow-1 pos-rel">
										<span class="lqd-scrl-indc-el d-inline-block"></span>
									</span>
								</span>
							</span>';
						}
						
						if( !empty( $item['badge'] ) ) {
							$badge_style = 'style="';
							if( !empty( $item['badge_color'] ) ) {
								$badge_style .= '--badge-color: ' . $item['badge_color'] . ';';
							}
							if( !empty( $item['badge_bg'] ) ) {
								$badge_style .= '--badge-bg: ' . $item['badge_bg'] . '; --badge-bg-opacity: 1;';
							}
							$badge_style .= '"';
							$badge = '<span class="link-badge" ' . $badge_style . '>' . $item['badge'] . '</span>';
						}
						?>

						<li>
							<a <?php echo ld_helper()->html_attributes( $attr ); ?> > 

								<?php if( isset( $item['icon_classname']['value'] ) ) : ?>
									<span class="link-icon d-inline-flex hide-if-empty align-items-center <?php echo esc_attr( $item['icon_alignment'] . ' ' . $icon_pos ); ?>"><?php Icons_Manager::render_icon( $item['icon_classname'], [ 'aria-hidden' => 'true' ] ); ?></span>	
								<?php endif; ?>

								<?php if ( $sticky && 'lqd-sticky-menu-floating-vertical' === $cm_sticky_type ) : ?>
								<span class="link-txt">
								<?php endif; ?>
									<?php echo do_shortcode( $item['label'] ); ?>  
								<?php if ( $sticky && 'lqd-sticky-menu-floating-vertical' === $cm_sticky_type ) : ?>
								</span>
								<?php endif; ?>
								<?php echo $badge ?>
							</a>
							<?php echo $scroll_ind ?>
						</li>

						<?php
						
					}
				?>
				</ul>
			<?php endif; ?>
			</div>
		<?php
		
	}

}
