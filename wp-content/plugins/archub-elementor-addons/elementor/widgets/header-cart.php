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
class LD_Header_Cart extends Widget_Base {

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
		return 'ld_header_cart';
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
		return __( 'Liquid Header Cart', 'archub-elementor-addons' );
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
		return 'eicon-cart lqd-element';
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
		return [ 'hub-header', 'hub-woo' ];
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
		return [ 'woocommerce', 'cart', 'header' ];
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
			'cart_style_section',
			[
				'label' => __( 'Cart Style', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'enable_offcanvas',
			[
				'label' => __( 'Offcanvas?', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);	
		$this->end_controls_section();

		// Show/Hide Parts
		$this->start_controls_section(
			'show_hide_parts_section',
			[
				'label' => __( 'Show/Hide Parts', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_icon',
			[
				'label' => __( 'Show Icon', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'archub-elementor-addons' ),
				'label_off' => __( 'No', 'archub-elementor-addons' ),
				'return_value' => 'yes', 
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_counter',
			[
				'label' => __( 'Show Counter Badge?', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'archub-elementor-addons' ),
				'label_off' => __( 'No', 'archub-elementor-addons' ),
				'return_value' => 'yes', 
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_subtotal',
			[
				'label' => __( 'Show Subtotal?', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'archub-elementor-addons' ),
				'label_off' => __( 'No', 'archub-elementor-addons' ),
				'return_value' => 'yes', 
			]
		);

		$this->add_control(
			'offcanvas_placement',
			[
				'label' => __( 'Placement', 'archub-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'ld-module-to-left' => [
						'title' => __( 'Left', 'archub-elementor-addons' ),
						'icon' => 'eicon-arrow-left',
					],
					'ld-module-to-right' => [
						'title' => __( 'Right', 'archub-elementor-addons' ),
						'icon' => 'eicon-arrow-right',
					],
				],
				'default' => 'ld-module-to-left',
				'toggle' => false,
				'condition' => [
					'enable_offcanvas' => 'yes'
				],
			]
		);

		$current_header_id = liquid_get_custom_header_id(); 
		$page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers( 'page' );
		$page_settings_model = $page_settings_manager->get_model( $current_header_id );

		if ( $page_settings_model->get_settings( 'enable_mobile_header_builder' ) === 'yes' ){
			$hide_for_mhb = array('lqd_hide' => 'true');
		} else {
			$hide_for_mhb = '';
		}

		$this->add_control(
			'show_on_mobile',
			[
				'label' => __( 'Show on Mobile', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'archub-elementor-addons' ),
				'label_off' => __( 'No', 'archub-elementor-addons' ),
				'return_value' => 'lqd-show-on-mobile', // null
				'default' => '',
				'condition' => $hide_for_mhb
			]
		);
		$this->end_controls_section();

		//Parts Stlyling
		$this->start_controls_section(
			'parts_styles_section',
			[
				'label' => __( 'Parts Stlyling', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'icon_style',
			[
				'label' => __( 'Icon Style', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'lqd-module-icon-plain',
				'options' => [
					'lqd-module-icon-plain'  => __( 'Plain', 'archub-elementor-addons' ),
					'lqd-module-icon-outline'  => __( 'Outlined', 'archub-elementor-addons' ),
				],
				'condition' => [
					'show_icon' => 'yes'
				],
			]
		);

		$this->add_control(
			'counter_style',
			[
				'label' => __( 'Counter Style', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'lqd-module-badge-fill',
				'options' => [
					'lqd-module-badge-fill'  => __( 'Filled', 'archub-elementor-addons' ),
					'lqd-module-badge-outline'  => __( 'Outline', 'archub-elementor-addons' ),
				],
				'condition' => [
					'show_counter' => 'yes'
				],
			]
		);
		$this->end_controls_section();

		// Extra Texts
		$this->start_controls_section(
			'extra_texts_content_section',
			[
				'label' => __( 'Extra Texts', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'cart_text',
			[
				'label' => __( 'Cart Footer Text', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => __( 'Type your text', 'archub-elementor-addons' ),
			]
		);
		$this->end_controls_section();

		// Style 
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Style', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => __( 'Typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .ld-module-cart .ld-module-trigger-txt, {{WRAPPER}} .ld-module-cart .ld-module-trigger .ld-module-trigger-count',
			]
		);


		$this->add_control(
			'badge_color',
			[
				'label' => __( 'Badge Text Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ld-module-cart .ld-module-trigger .ld-module-trigger-count' => 'color: {{VALUE}}',
				],
				'condition' => [
					'show_counter' => 'yes'
				],
			]
		);

		$this->add_control(
			'badge_bgcolor',
			[
				'label' => __( 'Badge Fill/Outline Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ld-module-cart .lqd-module-badge-fill.ld-module-trigger .ld-module-trigger-count' => 'background: {{VALUE}}',
					'{{WRAPPER}} .ld-module-cart .ld-module-trigger .ld-module-trigger-count' => 'border-color: {{VALUE}}',
				],
				'condition' => [
					'show_counter' => 'yes'
				],
			]
		);

		$this->add_control(
			'sticky_colors',
			[
				'label' => __( 'Sticky Colors', 'archub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'sticky_primary_color',
			[
				'label' => __( 'Primary Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.is-stuck {{WRAPPER}} .ld-module-cart .ld-module-trigger' => 'color: {{VALUE}}',
					'.is-stuck {{WRAPPER}} .ld-module-cart .ld-module-trigger svg' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'sticky_badge_color',
			[
				'label' => __( 'Badge Text Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.is-stuck {{WRAPPER}} .ld-module-cart .ld-module-trigger .ld-module-trigger-count' => 'color: {{VALUE}}',
				],
				'condition' => [
					'show_counter' => 'yes'
				],
			]
		);

		$this->add_control(
			'sticky_badge_bgcolor',
			[
				'label' => __( 'Badge Fill/Outline Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.is-stuck {{WRAPPER}} .ld-module-cart .lqd-module-badge-fill.ld-module-trigger .ld-module-trigger-count' => 'background: {{VALUE}}',
					'.is-stuck {{WRAPPER}} .ld-module-cart .ld-module-trigger .ld-module-trigger-count' => 'border-color: {{VALUE}}',
				],
				'condition' => [
					'show_counter' => 'yes'
				],
			]
		);

		$this->add_control(
			'sticky_light_colors',
			[
				'label' => __( 'Colors Over Light Rows', 'archub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'sticky_light_primary_color',
			[
				'label' => __( 'Primary Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-light .ld-module-cart .ld-module-trigger' => 'color: {{VALUE}}',
					'{{WRAPPER}}.lqd-active-row-light .ld-module-cart .ld-module-trigger svg' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'sticky_light_badge_color',
			[
				'label' => __( 'Badge Text Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-light .ld-module-cart .ld-module-trigger .ld-module-trigger-count' => 'color: {{VALUE}}',
				],
				'condition' => [
					'show_counter' => 'yes'
				],
			]
		);

		$this->add_control(
			'sticky_light_badge_bgcolor',
			[
				'label' => __( 'Badge Fill/Outline Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-light .ld-module-cart .lqd-module-badge-fill.ld-module-trigger .ld-module-trigger-count' => 'background: {{VALUE}}',
					'{{WRAPPER}}.lqd-active-row-light .ld-module-cart .ld-module-trigger .ld-module-trigger-count' => 'border-color: {{VALUE}}',
				],
				'condition' => [
					'show_counter' => 'yes'
				],
			]
		);

		$this->add_control(
			'sticky_dark_colors',
			[
				'label' => __( 'Colors Over Dark Rows', 'archub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'sticky_dark_primary_color',
			[
				'label' => __( 'Primary Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-dark .ld-module-cart .ld-module-trigger' => 'color: {{VALUE}}',
					'{{WRAPPER}}.lqd-active-row-dark .ld-module-cart .ld-module-trigger svg' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'sticky_dark_badge_color',
			[
				'label' => __( 'Badge Text Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-dark .ld-module-cart .ld-module-trigger .ld-module-trigger-count' => 'color: {{VALUE}}',
				],
				'condition' => [
					'show_counter' => 'yes'
				],
			]
		);

		$this->add_control(
			'sticky_dark_badge_bgcolor',
			[
				'label' => __( 'Badge Fill/Outline Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.lqd-active-row-dark .ld-module-cart .lqd-module-badge-fill.ld-module-trigger .ld-module-trigger-count' => 'background: {{VALUE}}',
					'{{WRAPPER}}.lqd-active-row-dark .ld-module-cart .ld-module-trigger .ld-module-trigger-count' => 'border-color: {{VALUE}}',
				],
				'condition' => [
					'show_counter' => 'yes'
				],
			]
		);

		$this->end_controls_section();

		ld_el_module_trigger( $pf = $this, $pf2 = 'hmt_', $type = 'cart' );

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
		
		$atts = $this->get_settings_for_display();
		extract($atts);

		// global $product;
		// $product = wc_get_product();
		
		?>
		<div class="d-flex <?php echo esc_attr( $atts['show_on_mobile'] . ' ' . $atts['offcanvas_placement'] ); ?>">

		<?php 
		if ( \Elementor\Plugin::instance()->editor->is_edit_mode() ){
			$show_icon = ($show_icon === 'yes') ? 'lqd-module-show-icon' : 'lqd-module-hide-icon';
			$cart_id = uniqid( 'cart-' );
			$trigger_class = array(
				'ld-module-trigger',
				'collapsed',
				$hmt_icon_text_align,
				$show_icon,
				$icon_style,
				$counter_style
			);
			?>
			<div class="ld-module-cart ld-module-cart-dropdown d-flex align-items-center">
			<span class="<?php echo liquid_helper()->sanitize_html_classes( $trigger_class ) ?>" data-ld-toggle="true" data-toggle="collapse" data-target="<?php echo '#' . esc_attr( $cart_id ); ?>" aria-controls="<?php echo esc_attr( $cart_id ) ?>" aria-expanded="false" data-toggle-options='{ "type": "hoverFade" }'>
				<?php if ( 'lqd-module-show-icon' === $show_icon )  { ?>
					<span class="ld-module-trigger-icon">
						<?php if ( empty($atts['hmt_i_icon']['value']) ): ?>
							<svg xmlns="http://www.w3.org/2000/svg" width="32" height="30" viewBox="0 0 32 30" style="width: 1em; height: 1em;"><path fill="currentColor" d="M.884.954c-.435.553-.328 1.19.25 1.488.272.141.878.183 2.641.183h2.287l1.67 7.657c.917 4.21 1.778 7.909 1.912 8.218.296.683.854 1.284 1.606 1.73l.563.333h15.125l.527-.283c.703-.375 1.39-1.079 1.667-1.706.231-.525 2.368-10.476 2.368-11.028 0-.17-.138-.445-.307-.614l-.307-.307H19.952c-10.306 0-10.939-.013-11.002-.219-.037-.12-.318-1.37-.624-2.778-.452-2.078-.608-2.602-.83-2.782C7.25.648 6.906.625 4.183.625h-3.04l-.259.33M29.25 8.733c0 .492-1.89 8.957-2.056 9.211-.443.676-.49.68-7.846.68-6.505 0-6.802-.011-7.185-.245-.22-.133-.487-.376-.594-.54-.106-.162-.634-2.303-1.172-4.755l-.978-4.46h9.915c5.553 0 9.916.048 9.916.109M12.156 25.118c-1.06.263-1.802 1.153-1.882 2.256-.07.971.13 1.506.792 2.116l.553.51h1.186c1.16 0 1.197-.01 1.648-.405 1.374-1.207 1.136-3.45-.455-4.282-.424-.221-1.345-.32-1.842-.196m12.74 0c-.594.15-1.288.745-1.615 1.386-.537 1.052-.261 2.333.669 3.1.461.38.53.397 1.59.397 1.272 0 1.65-.156 2.162-.895.62-.895.651-1.845.093-2.82-.525-.92-1.818-1.44-2.899-1.167M13.18 27.196a.716.716 0 0 1 .196.429c0 .248-.312.625-.517.625a.618.618 0 0 1-.608-.623c0-.553.55-.808.929-.43m12.704-.068c.37.198.325.838-.07 1.018-.258.118-.355.103-.563-.084-.304-.276-.317-.531-.043-.834.238-.264.342-.279.676-.1"></path></svg>
						<?php else: ?>
							<?php \Elementor\Icons_Manager::render_icon( $atts['hmt_i_icon'], [ 'aria-hidden' => 'true' ] ); ?>
						<?php endif;?>
						<span class="ld-module-trigger-close-cross"></span>
					</span>
				<?php } ?>
				<span class="ld-module-trigger-txt">
					<?php echo esc_html( $hmt_trigger_label ); ?>
					<?php if ( $show_subtotal === 'yes' ) : ?>
					<span class="ld-module-cart-subtotal">$39.90</span>
					<?php endif; ?>
				</span>
				<?php if ( $show_counter )  { ?>
					<?php printf( '<span class="ld-module-trigger-count ld-module-trigger-count-sup header-cart-fragments d-inline-flex align-items-center justify-content-center border-radius-circle">%s</span>', '0' ); ?>
				<?php } ?>
			</span>
			</div>
			<?php
		} else {
			// if ( empty( $product ) ) { return; }

			if( $enable_offcanvas ) {
				$located = locate_template( 'templates/header/header-cart-offcanvas.php' );
			} else {
				$located = locate_template( 'templates/header/header-cart.php' );
			}
			include $located;
		}

		?>
		</div>
		<?php
		
	}

}
