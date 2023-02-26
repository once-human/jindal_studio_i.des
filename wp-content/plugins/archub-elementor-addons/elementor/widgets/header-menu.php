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
class LD_Header_Menu extends Widget_Base {

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
		return 'ld_header_menu';
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
		return __( 'Liquid Primary Menu', 'archub-elementor-addons' );
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
		return 'eicon-nav-menu lqd-element';
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
				'label' => __( 'Menu', 'archub-elementor-addons' ),
			)
		);

		$this->add_control(
			'menu_redirect_info',
			[
				'type' => Controls_Manager::RAW_HTML,
				'raw' => sprintf( __( 'Go to the <strong><u>Header Settings (next to the Navigator)</u></strong> to customize the header.', 'archub-elementor-addons' ) ),
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
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
				]
			);
		}

		$this->add_control(
			'hover_style',
			[
				'label' => __( 'Hover style', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => __( 'Default', 'archub-elementor-addons' ),
					'fade-inactive' => __( 'Fade Inactive', 'archub-elementor-addons' ),
					'fill' => __( 'Fill', 'archub-elementor-addons' ),
					'underline' => __( 'Underline', 'archub-elementor-addons' ),
				],
			]
		);

		$this->add_responsive_control(
			'hover_underline_height',
			[
				'label' => __( 'Underline height', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
					'em' => [
						'min' => 0,
						'max' => 10,
						'step' => 0.1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 1
				],
				'selectors' => [
					'{{WRAPPER}} .main-nav-hover-underline' => '--nav-underline-height: {{SIZE}}{{UNIT}};',
				],
				'condition' => array(
					'hover_style' => array( 'underline' ),
				),
			]
		);

		$this->add_responsive_control(
			'hover_underline_bottom_offset',
			[
				'label' => __( 'Underline bottom offset', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'em' => [
						'min' => 0,
						'max' => 10,
						'step' => 0.1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10
				],
				'selectors' => [
					'{{WRAPPER}} .main-nav-hover-underline' => '--nav-underline-bottom-offset: {{SIZE}}{{UNIT}};',
				],
				'condition' => array(
					'hover_style' => array( 'underline' ),
				),
			]
		);

		$this->add_responsive_control(
			'hover_underline_left_offset',
			[
				'label' => __( 'Underline left offset', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
						'step' => 1,
					],
					'em' => [
						'min' => -10,
						'max' => 10,
						'step' => 0.1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 15
				],
				'selectors' => [
					'{{WRAPPER}} .main-nav-hover-underline' => '--nav-underline-left-offset: {{SIZE}}{{UNIT}};',
				],
				'condition' => array(
					'hover_style' => array( 'underline' ),
				),
			]
		);

		$this->add_responsive_control(
			'hover_underline_right_offset',
			[
				'label' => __( 'Underline right offset', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
						'step' => 1,
					],
					'em' => [
						'min' => -10,
						'max' => 10,
						'step' => 0.1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 15,
				],
				'selectors' => [
					'{{WRAPPER}} .main-nav-hover-underline' => '--nav-underline-right-offset: {{SIZE}}{{UNIT}};',
				],
				'condition' => array(
					'hover_style' => array( 'underline' ),
				),
			]
		);

		$this->add_responsive_control(
			'sticky_hover_underline_bottom_offset',
			[
				'label' => __( 'Sticky underline bottom offset', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'em' => [
						'min' => 0,
						'max' => 10,
						'step' => 0.1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'.is-stuck {{WRAPPER}} .main-nav-hover-underline' => '--nav-underline-bottom-offset: {{SIZE}}{{UNIT}};',
				],
				'condition' => array(
					'hover_style' => array( 'underline' ),
				),
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'sticky_hover_underline_left_offset',
			[
				'label' => __( 'Sticky underline left offset', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
						'step' => 1,
					],
					'em' => [
						'min' => -10,
						'max' => 10,
						'step' => 0.1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'.is-stuck {{WRAPPER}} .main-nav-hover-underline' => '--nav-underline-left-offset: {{SIZE}}{{UNIT}};',
				],
				'condition' => array(
					'hover_style' => array( 'underline' ),
				),
			]
		);

		$this->add_responsive_control(
			'sticky_hover_underline_right_offset',
			[
				'label' => __( 'Sticky underline right offset', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'range' => [
					'px' => [
						'min' => -100,
						'max' => 100,
						'step' => 1,
					],
					'em' => [
						'min' => -10,
						'max' => 10,
						'step' => 0.1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'.is-stuck {{WRAPPER}} .main-nav-hover-underline' => '--nav-underline-right-offset: {{SIZE}}{{UNIT}};',
				],
				'condition' => array(
					'hover_style' => array( 'underline' ),
				),
			]
		);

		$this->add_control(
			'menu_items_direction',
			[
				'label' => __( 'Items direction', 'archub-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'lqd-menu-items-inline' => [
						'title' => __( 'inline', 'archub-elementor-addons' ),
						'icon' => 'fa fa-ellipsis-h',
					],
					'lqd-menu-items-block' => [
						'title' => __( 'Block', 'archub-elementor-addons' ),
						'icon' => 'fa fa-ellipsis-v',
					],
				],
				'default' => 'lqd-menu-items-inline',
				'separator' => 'before',
				'toggle' => false,
			]
		);

		$this->add_control(
			'separator',
			[
				'label' => __( 'Add separator', 'archub-elementor-addons' ),
				'description' => __( 'Add a seperator between menu items', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'separator_type',
			[
				'label' => __( 'Select type', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'text',
				'options' => [
					'text'  => __( 'Text', 'archub-elementor-addons' ),
					'icon' => __( 'Icon', 'archub-elementor-addons' ),
				],
				'condition' => [
					'separator' => 'yes',
				],
			]
		);

		$this->add_control(
			'separator_text',
			[
				'label' => __( 'Separator text', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => '/',
				'condition' => [
					'separator' => 'yes',
					'separator_type' => 'text',
				],
			]
		);

		$this->add_control(
			'separator_icon',
			[
				'label' => __( 'Separator icon', 'archub-elementor-addons' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'lqd-icn-ess icon-ion-ios-remove',
					'library' => 'liquid-essentials',
				],
				'condition' => [
					'separator' => 'yes',
					'separator_type' => 'icon',
				],
			]
		);

		$this->add_control(
			'separator_color',
			[
				'label' => __( 'Separator color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .link-sep' => 'color: {{VALUE}};',
				],
				'condition' => [
					'separator' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'separator_margin',
			[
				'label' => __( 'Separator margin', 'archub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .link-sep' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' => [
					'right' => '15',
					'unit' => 'px',
					'isLinked' => false
				],
				'condition' => [
					'separator' => 'yes',
				],
				'separator' => 'after',
			]
		);
		
		$this->add_control(
			'visible',
			[
				'label' => __( 'Hide?', 'archub-elementor-addons' ),
				'description' => __( 'Hide menu and display it only if pressed on trigger button', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'navbar-visible-ontoggle',
				'default' => '',
			]
		);

		$this->add_control(
			'local_scroll',
			[
				'label' => __( 'Enable local scroll?', 'archub-elementor-addons' ),
				'description' => __( 'Check to use local scroll, to create one page navigation', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
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
			]
		);

		$this->add_control(
			'align_counter',
			[
				'label' => __( 'Counter/badge alignment', 'archub-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'lqd-menu-counter-left' => [
						'title' => __( 'Left', 'archub-elementor-addons' ),
						'icon' => 'fa fa-align-left',
					],
					'lqd-menu-counter-right' => [
						'title' => __( 'Right', 'archub-elementor-addons' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'lqd-menu-counter-right',
				'toggle' => false,
			]
		);

		$this->end_controls_section();

		// Spacing Section
		$this->start_controls_section(
			'spacing_section',
			array(
				'label' => __( 'Spacing', 'archub-elementor-addons' ),
			)
		);

		$this->add_responsive_control(
			'padding',
			[
				'label' => __( 'Menu items spacing (padding)', 'archub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}}' => '--lqd-menu-items-top-padding: {{TOP}}{{UNIT}};--lqd-menu-items-right-padding:{{RIGHT}}{{UNIT}};--lqd-menu-items-bottom-padding:{{BOTTOM}}{{UNIT}};--lqd-menu-items-left-padding:{{LEFT}}{{UNIT}};',
				],
				'default' => [
						'isLinked' => false,
						'unit' => 'px',
						'top' => '10',
						'right' => '15',
						'bottom' => '10',
						'left' => '15',                    
				]
			]
		);
        $this->end_controls_section();

        // Sticky Spacing Section
        $this->start_controls_section(
        'sticky_spacing_section',
            array(
                'label' => __( 'Sticky spacing', 'archub-elementor-addons' ),
            )
		);

		$this->add_responsive_control(
			'sticky_padding',
			[
				'label' => __( 'Menu items spacing (padding)', 'archub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.is-stuck {{WRAPPER}}' => '--lqd-menu-items-top-padding: {{TOP}}{{UNIT}};--lqd-menu-items-right-padding:{{RIGHT}}{{UNIT}};--lqd-menu-items-bottom-padding:{{BOTTOM}}{{UNIT}};--lqd-menu-items-left-padding:{{LEFT}}{{UNIT}};',
				],
				'default' => [
						'isLinked' => false,
						'unit' => 'px',
						'top' => '10',
						'right' => '15',
						'bottom' => '10',
						'left' => '15',                    
				]
			]
		);

		$this->end_controls_section();

		// Dropdown Section
		$this->start_controls_section(
		'dropdown_section',
				array(
						'label' => __( 'Dropdown options', 'archub-elementor-addons' ),
				)
		);
           
		$this->add_control(
			'ddmenu_hover_style',
			[
				'label' => __( 'Submenu style', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'lqd-submenu-default-style',
				'options' => [
					'lqd-submenu-default-style' => __( 'Default', 'archub-elementor-addons' ),
					'lqd-submenu-cover' => __( 'Cover', 'archub-elementor-addons' ),
				],
			]
		);
		
		$this->end_controls_section();

		// Menu typography section
		$this->start_controls_section(
				'menu_typography_section',
				[
						'label' => __( 'Menu typography', 'archub-elementor-addons' ),
						'tab' => Controls_Manager::TAB_STYLE,
				]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'menu_typography',
				'label' => __( 'Typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .main-nav > li > a',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'menu_icon_typography',
				'label' => __( 'Icons typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .main-nav > li > a > .link-icon',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'counter_typography',
				'label' => __( 'Counter number typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .main-nav .link-sup',
			]
		);

		$this->end_controls_section();

		// Menu Color Section
		$this->start_controls_section(
				'menu_color_section',
				[
						'label' => __( 'Menu color', 'archub-elementor-addons' ),
						'tab' => Controls_Manager::TAB_STYLE,
				]
		);

		$this->add_control(
			'link_color',
			[
				'label' => __( 'Menu color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .main-nav > li > a, .navbar-fullscreen {{WRAPPER}} .main-nav > li > a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'link_hcolor',
			[
				'label' => __( 'Menu hover color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .main-nav > li:hover > a, {{WRAPPER}} .main-nav > li.is-active > a, .navbar-fullscreen {{WRAPPER}} .main-nav > li > a:hover' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'link_active_color',
			[
				'label' => __( 'Menu active color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .main-nav > li.is-active > a, {{WRAPPER}} .main-nav > li.current_page_item > a, {{WRAPPER}} .main-nav > li.current-menu-item > a, {{WRAPPER}} .main-nav > li.current-menu-ancestor > a, .navbar-fullscreen {{WRAPPER}} .main-nav > li.is-active > a, .navbar-fullscreen {{WRAPPER}} .main-nav > li.current_page_item > a, .navbar-fullscreen {{WRAPPER}} .main-nav > li.current-menu-item > a, .navbar-fullscreen {{WRAPPER}} .main-nav > li.current-menu-ancestor > a' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'color',
			[
				'label' => __( 'Decoration color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .main-nav > li > a:after' => 'background: {{VALUE}}',
				],
                'condition' => array(
                    'hover_style' => 'underline-1',
                )
			]
		);

		$this->add_control(
			'fill_color_heading',
			[
				'label' => __( 'Fill color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'hover_style' => [ 'fill' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'fill_color',
				'label' => __( 'Fill color', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .main-nav > li > a:before',
				'condition' => [
					'hover_style' => [ 'fill' ],
				],
			]
		);

		$this->add_control(
			'underline_color_heading',
			[
				'label' => __( 'Underline color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'hover_style' => [ 'underline' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'underline_color',
				'label' => __( 'Underline color', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .main-nav > li > a:after',
				'condition' => [
					'hover_style' => [ 'underline' ],
				],
			]
		);

		$this->add_control(
			'counter_color',
			[
				'label' => __( 'Counter number color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .main-nav .link-sup' => 'color: {{VALUE}}',
				],
			]
		);
		
		$this->end_controls_section();

		// Dropdown typography Section
		$this->start_controls_section(
			'dropdown_typography_section',
			[
					'label' => __( 'Dropdown typography', 'archub-elementor-addons' ),
					'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'use_custom_fonts_ddmenu',
				'label' => __( 'Typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .nav-item-children > li > a',
			]
		);

		$this->end_controls_section();

		// Dropdown Color Section
		$this->start_controls_section(
				'dropdown_color_section',
				[
						'label' => __( 'Dropdown color', 'archub-elementor-addons' ),
						'tab' => Controls_Manager::TAB_STYLE,
				]
		);

		$this->add_control(
			'ddlink_color',
			[
				'label' => __( 'Dropdown menu color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .main-nav .nav-item-children > li > a' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'ddlink_hcolor',
			[
				'label' => __( 'Dropdown menu hover color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .main-nav .nav-item-children > li > a:hover' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'dd_bg',
			[
				'label' => __( 'Dropdown menu background', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .main-nav .nav-item-children:before' => 'background: {{VALUE}}',
				],
			]
		);
        $this->end_controls_section();

        // Sticky Color Section
        $this->start_controls_section(
            'sticky_color_section',
            [
                'label' => __( 'Sticky color', 'archub-elementor-addons' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
			'sticky_link_color',
			[
				'label' => __( 'Menu color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.is-stuck {{WRAPPER}} .navbar-collapse .main-nav > li > a' => 'color: {{VALUE}} !important',
				],
			]
		);

        $this->add_control(
			'sticky_link_hcolor',
			[
				'label' => __( 'Menu hover color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.is-stuck {{WRAPPER}} .navbar-collapse .main-nav > li:hover > a, .is-stuck {{WRAPPER}} .navbar-collapse .main-nav > li.is-active > a' => 'color: {{VALUE}} !important',
				],
			]
		);

        $this->add_control(
			'sticky_link_active_color',
			[
				'label' => __( 'Menu active color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.is-stuck {{WRAPPER}} .navbar-collapse .main-nav > li.is-active > a, .is-stuck {{WRAPPER}} .navbar-collapse .main-nav > li.current_page_item > a, .is-stuck {{WRAPPER}} .navbar-collapse .main-nav > li.current-menu-item > a, .is-stuck {{WRAPPER}} .navbar-collapse .main-nav > li.current-menu-ancestor > a' => 'color: {{VALUE}} !important',
				],
			]
		);

        $this->add_control(
			'sticky_color',
			[
				'label' => __( 'Decoration color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.is-stuck {{WRAPPER}} .navbar-collapse .main-nav > li > a:after' => 'background: {{VALUE}} !important',
				],
                'condition' => array(
                    'hover_style' => 'underline-1',
                )
			]
		);

		$this->add_control(
			'sticky_fill_color_heading',
			[
				'label' => __( 'Fill color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'hover_style' => [ 'fill' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'sticky_fill_color',
				'label' => __( 'Fill color', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '.is-stuck {{WRAPPER}} .main-nav > li > a:before',
				'condition' => array(
					'hover_style' => array( 'fill' ),
				),
			]
		);

		$this->add_control(
			'sticky_underline_color_heading',
			[
				'label' => __( 'Underline color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'hover_style' => [ 'underline' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'sticky_underline_color',
				'label' => __( 'Underline color', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '.is-stuck {{WRAPPER}} .main-nav > li > a:after',
				'condition' => [
					'hover_style' => [ 'underline' ],
				],
			]
		);

        $this->end_controls_section();

		 // Sticky Dropdown Color Section
		 $this->start_controls_section(
            'sticky_dd_color_section',
            [
                'label' => __( 'Sticky dropdown color', 'archub-elementor-addons' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_control(
			'sticky_ddlink_color',
			[
				'label' => __( 'Dropdown menu color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.is-stuck {{WRAPPER}} .main-nav .nav-item-children > li > a' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'sticky_ddlink_hcolor',
			[
				'label' => __( 'Dropdown menu hover color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.is-stuck {{WRAPPER}} .main-nav .nav-item-children > li > a:hover' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'sticky_dd_bg',
			[
				'label' => __( 'Dropdown menu background', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.is-stuck {{WRAPPER}} .main-nav .nav-item-children:before' => 'background: {{VALUE}}',
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
			'sticky_light_link_color',
			[
				'label' => __( 'Menu color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-light .navbar-collapse .main-nav > li > a' => 'color: {{VALUE}} !important',
				],
			]
		);

        $this->add_control(
			'sticky_light_link_hcolor',
			[
				'label' => __( 'Menu hover color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-light .navbar-collapse .main-nav > li:hover > a, {{WRAPPER}}.lqd-active-row-light .navbar-collapse .main-nav > li.is-active > a' => 'color: {{VALUE}} !important',
				],
			]
		);

        $this->add_control(
			'sticky_light_link_active_color',
			[
				'label' => __( 'Menu active color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-light .navbar-collapse .main-nav > li.is-active > a, {{WRAPPER}}.lqd-active-row-light .navbar-collapse .main-nav > li.current_page_item > a, {{WRAPPER}}.lqd-active-row-light .navbar-collapse .main-nav > li.current-menu-item > a, .main-header > .elementor > .elementor-section > .elementor-container > .elementor-column > .elementor-widget-wrap > .elementor-element.lqd-active-row-light> .navbar-collapse %1$s > li.current-menu-ancestor > a' => 'color: {{VALUE}} !important',
				],
			]
		);

        $this->add_control(
			'sticky_light_color',
			[
				'label' => __( 'Decoration color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-light .navbar-collapse .main-nav > li > a:after' => 'background: {{VALUE}} !important',
				],
                'condition' => array(
                    'hover_style' => 'underline-1',
                )
			]
		);

		$this->add_control(
			'sticky_light_fill_color_heading',
			[
				'label' => __( 'Fill color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'hover_style' => [ 'fill' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'sticky_light_fill_color',
				'label' => __( 'Fill color', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}}.lqd-active-row-light .main-nav > li > a:before',
				'condition' => array(
					'hover_style' => array( 'fill' ),
				),
			]
		);

		$this->add_control(
			'sticky_light_underline_color_heading',
			[
				'label' => __( 'Underline color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'hover_style' => [ 'underline' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'sticky_light_underline_color',
				'label' => __( 'Underline color', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}}.lqd-active-row-light .main-nav > li > a:after',
				'condition' => [
					'hover_style' => [ 'underline' ],
				],
			]
		);

		$this->end_controls_section();

		// Colors Over Dark Rows
		$this->start_controls_section(
			'sticky_dark_section',
			[
				'label' => __( 'Colors over dark rows', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );

		
        $this->add_control(
			'sticky_dark_link_color',
			[
				'label' => __( 'Menu color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-dark .navbar-collapse .main-nav > li > a' => 'color: {{VALUE}} !important',
				],
			]
		);

        $this->add_control(
			'sticky_dark_link_hcolor',
			[
				'label' => __( 'Menu hover color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-dark .navbar-collapse .main-nav > li:hover > a, {{WRAPPER}}.lqd-active-row-dark .navbar-collapse .main-nav > li.is-active > a' => 'color: {{VALUE}} !important',
				],
			]
		);

        $this->add_control(
			'sticky_dark_link_active_color',
			[
				'label' => __( 'Menu active color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-dark .navbar-collapse .main-nav > li.is-active > a, {{WRAPPER}}.lqd-active-row-dark .navbar-collapse .main-nav > li.current_page_item > a, {{WRAPPER}}.lqd-active-row-dark .navbar-collapse .main-nav > li.current-menu-item > a, {{WRAPPER}}.lqd-active-row-dark .navbar-collapse .main-nav > li.current-menu-ancestor > a' => 'color: {{VALUE}} !important',
				],
			]
		);

        $this->add_control(
			'sticky_dark_color',
			[
				'label' => __( 'Decoration color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-dark .navbar-collapse .main-nav > li > a:after' => 'background: {{VALUE}} !important',
				],
                'condition' => array(
                    'hover_style' => 'underline-1',
                )
			]
		);

		$this->add_control(
			'sticky_dark_fill_color_heading',
			[
				'label' => __( 'Fill color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'hover_style' => [ 'fill' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'sticky_dark_fill_color',
				'label' => __( 'Fill color', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}}.lqd-active-row-dark .main-nav > li > a:before',
				'condition' => array(
					'hover_style' => array( 'fill' ),
				),
			]
		);

		$this->add_control(
			'sticky_dark_underline_color_heading',
			[
				'label' => __( 'Underline color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'hover_style' => [ 'underline' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'sticky_dark_underline_color',
				'label' => __( 'Underline color', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}}.lqd-active-row-dark .main-nav > li > a:after',
				'condition' => [
					'hover_style' => [ 'underline' ],
				],
			]
		);

		$this->end_controls_section();

		// Dropwdown Colors Over Light Rows
		$this->start_controls_section(
			'dd_sticky_light_section',
			[
				'label' => __( 'Dropdown colors over light rows', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );
		
        $this->add_control(
			'sticky_light_ddlink_color',
			[
				'label' => __( 'Dropdown menu color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-light .navbar-collapse .main-nav .nav-item-children > li > a' => 'color: {{VALUE}} !important',
				],
			]
		);

        $this->add_control(
			'sticky_light_ddlink_hcolor',
			[
				'label' => __( 'Dropdown menu hover color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-light .navbar-collapse .main-nav .nav-item-children > li > a:hover' => 'color: {{VALUE}} !important',
				],
			]
		);

        $this->add_control(
			'sticky_light_dd_bg',
			[
				'label' => __( 'Dropdown menu background', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-light .navbar-collapse .main-nav .nav-item-children:before' => 'background: {{VALUE}} !important',
				],
			]
		);
		$this->end_controls_section();

		// Dropwdown Colors Over Dark Rows
		$this->start_controls_section(
			'dd_sticky_dark_section',
			[
				'label' => __( 'Dropdown colors over dark rows', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );
		
        $this->add_control(
			'sticky_dark_ddlink_color',
			[
				'label' => __( 'Dropdown menu color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-dark .navbar-collapse  .main-nav.nav-item-children > li > a' => 'color: {{VALUE}} !important',
				],
			]
		);

        $this->add_control(
			'sticky_dark_ddlink_hcolor',
			[
				'label' => __( 'Dropdown menu hover color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-dark .navbar-collapse  .main-nav.nav-item-children > li > a:hover' => 'color: {{VALUE}} !important',
				],
			]
		);

        $this->add_control(
			'sticky_dark_dd_bg',
			[
				'label' => __( 'Dropdown menu background', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-dark .navbar-collapse  .main-nav.nav-item-children:before' => 'background: {{VALUE}} !important',
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

		$ddmenu_hover_style = $settings['ddmenu_hover_style'];
		$visible = $settings['visible'];
		$menu_slug = isset($settings['menu_slug']) ? $settings['menu_slug'] : '';
		$hover_style = $settings['hover_style'];
		$magnetic_items = ( $settings['magnetic_items'] === 'yes') ? 'lqd-magnetic-items' : '';

		if ( $settings['separator'] === 'yes' ) {
			if ( $settings['separator_type'] === 'text' ) {
				$separator = $settings['separator_text'];
			} else {
				$separator = isset($settings['separator_icon']['value']) ? '<i class="' . esc_attr( $settings['separator_icon']['value'] ) . '"></i>' : '';
			}
		} else {
			$separator = '';
		}

		$classes = array(
			'main-nav',
			'd-flex',
			'reset-ul',
			$settings['menu_items_direction'] === 'lqd-menu-items-inline' ? 'inline-nav' : '',
			$settings['align_counter'],
			$settings['menu_items_direction'],
		);
		
		$args = '';
		
		if( !empty( $hover_style ) ) {
			$classes[] = "main-nav-hover-$hover_style";
		}
		
		$classes = apply_filters( 'liquid_header_nav_classes', $classes );
		
		$default_args = array(
			'toggleType' => 'fade',
			'handler' => 'mouse-in-out',	
		);

		if ( $settings['menu_items_direction'] === 'lqd-menu-items-block' ) {
			$default_args['toggleType'] = 'slide';
			$default_args['handler'] = 'click';
		}

		$args = wp_parse_args( $args, $default_args );
		$args = apply_filters( 'liquid_header_nav_args', $args );
		
		?>
		<div class="module-primary-nav d-flex">
			<div class="collapse navbar-collapse d-inline-flex p-0 <?php echo $ddmenu_hover_style; ?> <?php echo $visible; ?> <?php echo $magnetic_items; ?>" id="main-header-collapse" aria-expanded="false" role="navigation">
			<?php
			
				if( is_nav_menu( $menu_slug ) ) :
			
					wp_nav_menu( array(
						'theme_location' => 'primary',
						'menu'           => $menu_slug,
						'container'      => 'ul',
						'before'         => false,
						'after'          => false,
						'link_before'    => '',
						'link_after'     => '<span class="submenu-expander"><svg xmlns="http://www.w3.org/2000/svg" width="21" height="32" viewBox="0 0 21 32" style="width: 1em; height: 1em;"><path fill="currentColor" d="M10.5 18.375l7.938-7.938c.562-.562 1.562-.562 2.125 0s.562 1.563 0 2.126l-9 9c-.563.562-1.5.625-2.063.062L.437 12.562C.126 12.25 0 11.876 0 11.5s.125-.75.438-1.063c.562-.562 1.562-.562 2.124 0z"></path></svg></span>',
						'menu_id'        => 'primary-nav',
						'menu_class'     => esc_attr( implode( ' ', $classes ) ),
						'items_wrap'     => '<ul id="%1$s" class="%2$s" data-submenu-options=\'' . wp_json_encode( $args ) . '\' ' . $this->add_local_scroll() . '>%3$s</ul>',
						'item_separator' => $separator,
						'walker'         => class_exists( 'Liquid_Mega_Menu_Walker' ) ? new \Liquid_Mega_Menu_Walker : '',
					 ) );
			
				 else:
			
					wp_nav_menu( array(
						'container'      => 'ul',
						'before'         => false,
						'after'          => false,
						'link_before'    => '',
						'link_after'     => '<span class="submenu-expander"><svg xmlns="http://www.w3.org/2000/svg" width="21" height="32" viewBox="0 0 21 32" style="width: 1em; height: 1em;"><path fill="currentColor" d="M10.5 18.375l7.938-7.938c.562-.562 1.562-.562 2.125 0s.562 1.563 0 2.126l-9 9c-.563.562-1.5.625-2.063.062L.437 12.562C.126 12.25 0 11.876 0 11.5s.125-.75.438-1.063c.562-.562 1.562-.562 2.124 0z"></path></svg></span>',
						'menu_class'     => esc_attr( implode( ' ', $classes ) ),
						'items_wrap'     => '<ul id="%1$s" class="%2$s" data-submenu-options=\'' . wp_json_encode( $args ) . '\' >%3$s</ul>',
						'item_separator' => $separator,
						'walker'         => class_exists( 'Liquid_Mega_Menu_Walker' ) ? new \Liquid_Mega_Menu_Walker : '',
					));
			
				endif;
			?>
			</div>
		</div>
		<?php

	}

	protected function add_local_scroll() {
		$settings = $this->get_settings_for_display();
		
		if( !$settings['local_scroll'] ) {
			return;
		}
		
		return 'data-localscroll="true" data-localscroll-options=\'{"itemsSelector": "> li > a"}\'';

	}

}
