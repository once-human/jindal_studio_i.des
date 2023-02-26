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
class LD_Header_Dropdown extends Widget_Base {

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
		return 'ld_header_dropdown';
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
		return __( 'Liquid Header Dropdown', 'archub-elementor-addons' );
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
		return [ 'icon', 'box', 'header' ];
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
				'label' => __( 'Header dropdown', 'archub-elementor-addons' ),
			)
		);

		$this->add_control(
			'source',
			[
				'label' => __( 'Data source', 'archub-elementor-addons' ),
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
					'condition' => array(
						'source' => 'wp_menus'
					)
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
					'condition' => array(
						'source' => 'wp_menus'
					)
				]
			);
		}

		$repeater = new Repeater();

		$repeater->add_control(
			'label', [
				'label' => __( 'Label', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Menu' , 'archub-elementor-addons' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'link',
			[
				'label' => __( 'Link', 'archub-elementor-addons' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'archub-elementor-addons' ),
				'show_external' => true,
				'default' => [
					'url' => ''
				],
			]
		);


		$this->add_control(
			'items',
			[
				'label' => __( 'Items', 'archub-elementor-addons' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'label' => __( 'Menu #1', 'archub-elementor-addons' ),
						'link' => '#',
					],
					[
						'label' => __( 'Menu #2', 'archub-elementor-addons' ),
						'link' => '#',
					],
				],
				'title_field' => '{{{ label }}}',
				'condition' => [
					'source' => 'custom'
				]
			]
		);


		$this->add_control(
			'hover_style',
			[
				'label' => __( 'Dropdown links hover style', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Default', 'archub-elementor-addons' ),
					'ld-dropdown-menu-underlined' => __( 'Underlined', 'archub-elementor-addons' ),
				],
			]
		);


		$this->end_controls_section();
		
		$this->start_controls_section(
			'style_section',
			[
				'label' => __( 'Dropdown style', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'dropdown_typography',
					'label' => __( 'Typography', 'archub-elementor-addons' ),
					'selector' => '{{WRAPPER}} .ld-dropdown-menu-content',
				]
			);

			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name' => 'dropdown_background',
					'label' => __( 'Background', 'archub-elementor-addons' ),
					'types' => [ 'classic', 'gradient' ],
					'selector' => '{{WRAPPER}} .ld-module-dropdown',
					'fields_options' => [
						'background' => [
							'default' => 'classic',
						],
						'color' => [
							'default' => '#fff',
						],
					],
					'separator' => 'before',
				]
			);

			$this->add_control(
				'color',
				[
					'label' => __( 'Dropdown links color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ld-dropdown-menu li > a' => 'color: {{VALUE}}',
					],
					'separator' => 'before',
				]
			);

			$this->add_control(
				'hcolor',
				[
					'label' => __( 'Dropdown links hover color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .ld-dropdown-menu li > a:hover' => 'color: {{VALUE}}',
					],
				]
			);
			
		$this->end_controls_section();

		ld_el_module_trigger( $this, 'hmt_' );
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

		$source = $settings['source'];
		$menu_slug = isset($settings['menu_slug']) ? $settings['menu_slug'] : '';
		
		$classes = array(
			'ld-dropdown-menu',
			'd-flex',
			'align-items-center',
			'pos-rel',
			$settings['hover_style'],
		);
		
		$data_target = uniqid( 'dropdown-' );

		?>
			<div id="lqd-dropdown-<?php echo esc_attr( $this->get_id() ); ?>" class="<?php echo ld_helper()->sanitize_html_classes( $classes ); ?>">

				<?php ld_el_module_trigger_render( $data_target, 'hmt_', $settings ); ?>

				<div class="ld-module-dropdown left collapse pos-abs" id="<?php echo esc_attr( $data_target ); ?>" aria-expanded="false" role="menu">
					<div class="ld-dropdown-menu-content">
					<?php if( 'wp_menus' === $source ) : ?>
					<?php
					
						if( is_nav_menu( $menu_slug ) ) {
							wp_nav_menu( array(
								'menu'           => $menu_slug,
								'container'      => 'ul',
								'menu_id'        => false,
								'before'         => false,
								'after'          => false,
								'link_before'    => '',
								'link_after'     => '',
								'menu_class'     => false,
								'depth' => 1,
								'walker'         => class_exists( 'Liquid_Mega_Menu_Walker' ) ? new \Liquid_Mega_Menu_Walker : '',
							) );
						}
						else {
							wp_nav_menu( array(
								'container'   => 'ul',
								'container_id'   => false,
								'before'      => false,
								'after'       => false,
								'link_before'    => '',
								'link_after'     => '',
								'menu_class'  => false,
								'depth' => 1,
								'walker'         => class_exists( 'Liquid_Mega_Menu_Walker' ) ? new \Liquid_Mega_Menu_Walker : '',
							));
					
						};
					?>
					<?php else: ?>
						<ul>
						<?php
							foreach ( $settings['items'] as $item ) {
								if ( $item['link']['url'] ){
									$this->add_link_attributes( 'link' . $item['_id'], $item['link'] );
								}
								$attr = $this->get_render_attribute_string( 'link' . $item['_id'] );
								printf( '<li><a %s>%s</a></li>', $attr, esc_html( $item['label'] ) );
							}
						?>
						</ul>
					<?php endif; ?>
					</div>
				</div>
				
			</div>

		<?php

	}

	protected function get_the_icon() {

		$settings = $this->get_settings_for_display();

	

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
				printf( '<i class="%s"></i>', esc_attr( $settings['i_icon_fontawesome']['value'] ) );
			}
		}
		else {
			echo '<i class="lqd-icn-ess icon-ion-ios-arrow-down"></i>';
		}

	}

}
