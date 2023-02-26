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
class LD_Hotspots extends Widget_Base {

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
		return 'ld_hotspots';
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
		return __( 'Liquid HotSpots', 'archub-elementor-addons' );
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
		return 'eicon-hotspot lqd-element';
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
		return [ 'image', 'button', 'hotspot' ];
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
			'content_section',
			[
				'label' => __( 'Content', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'image',
			[
				'label' => __( 'Choose Image', 'archub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'custom_height',
			[
				'label' => __( 'Image Height', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}}' => 'height: {{SIZE}}{{UNIT}}; overflow: hidden;',
					'{{WRAPPER}} figure, {{WRAPPER}} img, {{WRAPPER}} .elementor-widget-container, {{WRAPPER}} .lqd-hotspot, {{WRAPPER}} .lqd-hotspot-inner, {{WRAPPER}} .lqd-hotspot-img' => 'height: 100%;',
					'{{WRAPPER}} img' => 'object-fit: cover; object-position: center;',
				],
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'title', [
				'label' => __( 'Title', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Title' , 'archub-elementor-addons' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'description', [
				'label' => __( 'Tooltip Content', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( 'Tooltip Content' , 'archub-elementor-addons' ),
				'label_block' => true,
			]
		);

		
		$repeater->add_control(
			'position',
			[
				'label' => __( 'Tooltip Alignment', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'lqd-hotspot-l',
				'options' => [
					'lqd-hotspot-t' => __( 'Top', 'archub-elementor-addons' ),
					'lqd-hotspot-r' => __( 'Right', 'archub-elementor-addons' ),
					'lqd-hotspot-l' => __( 'Left', 'archub-elementor-addons' ),
					'lqd-hotspot-b' => __( 'Bottom', 'archub-elementor-addons' ),
				],
			]
		);

		$repeater->add_control(
			'pos',
			[
				'label' => __( 'Position', 'archub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'isLinked' => false,
				]
			]
		);

		$this->add_control(
			'identities',
			[
				'label' => __( 'Items', 'archub-elementor-addons' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
			]
		);

		$this->end_controls_section();

		// Style Section
		$this->start_controls_section(
			'style_section',
			[
				'label' => __( 'Style', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Title typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-hotspot-content h2',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Title color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-hotspot-content h2' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'desc_typography',
				'label' => __( 'Content typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-hotspot-content p',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'content_color',
			[
				'label' => __( 'Content color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-hotspot-content p' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'bg_color',
			[
				'label' => __( 'Content background color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-hotspot-content' => 'background-color: {{VALUE}}',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'mark_bg_color',
			[
				'label' => __( 'Mark background color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-hotspot-mark' => 'background-color: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'mark_icon_color',
			[
				'label' => __( 'Mark icon color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-hotspot-mark' => 'color: {{VALUE}}',
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

		$classes = array( 
			'lqd-hotspot', 
			'pos-rel',
		);

		$style = '';

		?>

			<div class="<?php echo ld_helper()->sanitize_html_classes( $classes ) ?>">
				<div class="lqd-hotspot-inner">

					<div class="lqd-hotspot-img">
						<figure>
							<?php echo wp_get_attachment_image( $settings['image']['id'], 'full', false, array( 'class' => 'w-100' ) ); ?>
						</figure>
					</div>
					<div class="lqd-hotspot-items lqd-overlay">

						<?php foreach ($settings['identities'] as $item) : ?>
						
						<?php 
						if ( $item['position'] === 'lqd-hotspot-r' || $item['position'] === 'lqd-hotspot-l' ) {
							$dir = 'lqd-hotspot-x';
						} else {
							$dir = 'lqd-hotspot-y';
						}
						if( !empty( $item['pos']['top'] ) || !empty( $item['pos']['bottom'] ) || !empty( $item['pos']['left'] ) || !empty( $item['pos']['right'] ) )  {

							$style = 'style=';   

							if( !empty( $item['pos']['top'] ) ) {
								$style .= 'top:' . $item['pos']['top'].$item['pos']['unit'] . ';';	
							}
							if( !empty( $item['pos']['bottom'] ) ) {
								$style .= 'bottom:' . $item['pos']['bottom'].$item['pos']['unit'] . ';';
							}
							if( !empty( $item['pos']['left'] ) ) {
								$style .= 'left:' . $item['pos']['left'].$item['pos']['unit'] . ';';
							}
							if( !empty( $item['pos']['right'] ) ) {
								$style .= 'right:' . $item['pos']['right'].$item['pos']['unit'] . ';';
							}	

						}
						?>
						<div class="lqd-hotspot-item <?php echo esc_attr( $dir ); ?> <?php echo esc_attr( $item['position'] ); ?> pos-abs elementor-repeater-item-<?php echo esc_attr( $item['_id'] ); ?>" <?php echo esc_attr( $style ); ?>>
							<span class="lqd-hotspot-mark d-inline-flex align-items-center justify-content-center border-radius-circle">
							<svg class="pos-rel" width="32" height="32" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" style="width: 1em; height: 1em;"><path d="M16.03 6a1 1 0 0 1 1 1v8.02h8.02a1 1 0 1 1 0 2.01h-8.02v8.02a1 1 0 1 1-2.01 0v-8.02h-8.02a1 1 0 1 1 0-2.01h8.02v-8.01a1 1 0 0 1 1.01-1.01z" fill="currentColor"></path></svg>
							</span>
							<div class="lqd-hotspot-content p-4 border-radius-4 pos-abs z-index-5 text-center">
								<h2 class="h5 mt-0"><?php echo esc_html( $item['title'] ) ?></h2>
								<p class="mb-0"><?php echo wp_kses_post( $item['description'] ); ?></p>
							</div>
						</div>

						<?php endforeach; ?>
						
					</div>

				</div>
			</div>

		<?php
		
	}

}
