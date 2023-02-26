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
class LD_Overlay_Link extends Widget_Base {

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
		return 'ld_overlay_link';
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
		return __( 'Liquid Overlay Link', 'archub-elementor-addons' );
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
		return 'eicon-parallax lqd-element';
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
		return [ 'overlay link', 'link', 'button' ];
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
		return [ '' ];
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
			'link_type',
			[
				'label' => __( 'Link type', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''  => __( 'Simple Click', 'archub-elementor-addons' ),
					'lightbox' => __( 'Lightbox', 'archub-elementor-addons' ),
					'modal_window' => __( 'Modal Window', 'archub-elementor-addons' ),
					'local_scroll' => __( 'Local Scroll', 'archub-elementor-addons' ),
				],
			]
		);

    $this->add_control(
			'link',
			[
				'label' => __( 'URL (Link)', 'archub-elementor-addons' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'archub-elementor-addons' ),
				'show_external' => true,
				'default' => [
					'url' => '#',
				],
			]
		);

		$this->add_control(
			'enable_cc',
			[
				'label' => __( 'Custom cursor', 'archub-elementor-addons' ),
				'description' => __( 'You need to turn on this custom cursor feature from the theme options. "Theme Options > Extra > Custom Cursor"', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'archub-elementor-addons' ),
				'label_off' => __( 'Hide', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'cc_size',
			[
				'label' => esc_html__( 'Custom cursor size', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 390,
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-extra-cursor' => '--extra-cc-w: {{SIZE}}{{UNIT}}; --extra-cc-h: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'enable_cc' => 'yes'
				],
			]
		);

		$this->add_control(
			'cc_label',
			[
				'label' => __( 'Custom cursor label', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'condition' => [
					'enable_cc' => 'yes'
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'style_section',
			[
				'label' => __( 'Style', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'overlay_link_bg_label',
			[
					'label' => esc_html__( 'Background color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'overlay_link_bg',
				'label' => __( 'Background color', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} a',
				'separator' => 'after',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'cc_label_typography',
				'label' => __( 'Custom cursor typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-extra-cursor',
				'condition' => [
					'enable_cc' => 'yes'
				]
			]
		);

		$this->add_control(
			'cc_label_color',
			[
				'label' => __( 'Custom cursor label color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-extra-cursor' => 'color: {{VALUE}}',
				],
				'condition' => [
					'enable_cc' => 'yes'
				]
			]
		);

		$this->add_control(
			'cc_bg_label',
			[
					'label' => esc_html__( 'Custom cursor color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::HEADING,
					'condition' => [
						'enable_cc' => 'yes'
					],
					'separator' => 'before',
			]
	);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'cc_bg',
				'label' => __( 'Custom cursor background', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .lqd-extra-cursor',
				'condition' => [
					'enable_cc' => 'yes'
				]
			]
		);

		$this->end_controls_section();

	}

	protected function add_render_attributes() {
		parent::add_render_attributes();

		$settings = $this->get_settings();

		$classnames = ['lqd-overlay'];

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
		
		$link_attrs = [
			'class' => [ 
				'd-block',
				'lqd-overlay',
				'z-index-3',
			],
		];
		
		if ( $settings['link_type'] === 'lightbox' ) {
			$link_attrs['class'][] = 'fresco';
		}
		if ( $settings['link_type'] === 'modal_window' ) {
			$link_attrs['data-lqd-lity'] = $settings['link']['url'];
		}
		if ( $settings['link_type'] === 'local_scroll' ) {
			$link_attrs['data-localscroll'] = true;
		}
			
		$this->add_link_attributes( 'link', $settings['link'] );
		$this->add_render_attribute( 'link_attrs', $link_attrs );

		?>

			<a <?php echo $this->get_render_attribute_string( 'link' ); echo $this->get_render_attribute_string( 'link_attrs' ); ?>>
				<?php if ( $settings['enable_cc'] === 'yes' ) : ?>
					<span class="lqd-extra-cursor pos-fix d-inline-flex align-items-center justify-content-center p-2 pointer-events-none">
						<?php
						if ( ! empty($settings['cc_label']) ) {
							echo esc_html( $settings['cc_label'] );
						}
						?>
					</span>
				<?php endif; ?>
			</a>
		
		<?php
   
	}

}
