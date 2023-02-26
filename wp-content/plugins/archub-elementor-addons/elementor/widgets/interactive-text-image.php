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
 * @since 2.0.0
 */
class LD_Interactive_Text_Image extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve heading widget name.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ld_interactive_text_image';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve heading widget title.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Liquid Interactive Text Image', 'archub-elementor-addons' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve heading widget icon.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-featured-image lqd-element';
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
	 * @since 2.0.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'interactive', 'menu', 'image', 'text' ];
	}

	/**
	 * Retrieve the list of scripts the counter widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
		if ( liquid_helper()->liquid_elementor_script_depends() ){
			return [ 'gsap', 'liquid-mouse-pos' ];
		} else {
			return [''];
		}
	}

	/**
	 * Register heading widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 2.0.0
	 * @access protected
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

    $repeater->add_control(
			'title',
			array(
				'label' => __( 'Title', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Item title', 'archub-elementor-addons' ),
				'dynamic' => array(
					'active' => true,
				),
				'label_block' => true,
			)
		);

    $repeater->add_control(
			'image',
			[
				'label' => __( 'Image', 'archub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
        'dynamic' => array(
					'active' => true,
				),
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_responsive_control(
			'item_images_width',
			[
				'label' => esc_html__( 'Images width', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
				],
        'selectors' => [
          '{{WRAPPER}} {{CURRENT_ITEM}}' => 'width: {{SIZE}}{{UNIT}};',
        ],
        'separator' => true
			]
		);

    $repeater->add_responsive_control(
			'item_images_height',
			[
				'label' => esc_html__( 'Images height', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
				],
        'selectors' => [
          '{{WRAPPER}} {{CURRENT_ITEM}}' => 'height: {{SIZE}}{{UNIT}};',
        ]
			]
		);

    $repeater->add_control(
			'link',
			[
				'label' => __( 'Link', 'archub-elementor-addons' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'archub-elementor-addons' ),
				'show_external' => true,
        'dynamic' => array(
					'active' => true,
				),
				'default' => [
					'url' => '#',
				],
			]
		);

    $this->add_control(
			'items',
			array(
				'label' => __( 'Items', 'archub-elementor-addons' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
			)
		);

    $this->add_responsive_control(
			'images_width',
			[
				'label' => esc_html__( 'Images width', 'archub-elementor-addons' ),
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
					'size' => 350,
				],
        'selectors' => [
          '{{WRAPPER}} .lqd-iti-items' => '--iti-img-width: {{SIZE}}{{UNIT}};',
        ],
        'separator' => true
			]
		);

    $this->add_responsive_control(
			'images_height',
			[
				'label' => esc_html__( 'Images height', 'archub-elementor-addons' ),
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
					'size' => 350,
				],
        'selectors' => [
          '{{WRAPPER}} .lqd-iti-items' => '--iti-img-height: {{SIZE}}{{UNIT}};',
        ]
			]
		);

    $this->add_responsive_control(
			'items_h_gap',
			[
				'label' => esc_html__( 'Items horizontal gap', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
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
				],
				'default' => [
					'unit' => 'em',
					'size' => 1,
				],
        'selectors' => [
          '{{WRAPPER}} .lqd-iti-items' => '--iti-h-gap: {{SIZE}}{{UNIT}};',
        ]
			]
		);

		$this->add_responsive_control(
			'alignment',
			[
				'label' => __( 'Alignment', 'archub-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => __( 'Left', 'archub-elementor-addons' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'archub-elementor-addons' ),
						'icon' => 'fa fa-align-center',
					],
					'flex-end' => [
						'title' => __( 'Right', 'archub-elementor-addons' ),
						'icon' => 'fa fa-align-right',
					],
					'space-between' => [
						'title' => __( 'Justify', 'archub-elementor-addons' ),
						'icon' => 'fa fa-align-justify',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-iti-links' => 'justify-content: {{VALUE}}',
				],
				'toggle' => true,
				'separator' => 'before'
			]
		);

		$this->end_controls_section();

		// Style Section
		$this->start_controls_section(
			'style_section',
			[
				'label' => esc_html__( 'Style', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

    $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'mennu_typography',
				'label' => __( 'Links typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-iti-links',
			]
		);
		
		$this->add_control(
			'link_color',
			[
				'label' => esc_html__( 'Link color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-iti-link' => 'color: {{VALUE}}',
				],
        'separator' => 'before'
			]
		);
		
		$this->add_control(
			'link_color_hover',
			[
				'label' => esc_html__( 'Link hover color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-iti-link:hover' => 'color: {{VALUE}}',
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
	 * @since 2.0.0
	 * @access protected
	 */
	protected function render() {
		
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute(
			'wrapper',
			[
				'id' => 'lqd-iti-' . $this->get_ID(),
				'class' => [ 
					'lqd-iti-items',
					'pos-rel',
				 ],
				 'data-lqd-mouse-pos' => 'true',
				 'data-active-onhover' => 'true',
				 'data-active-onhover-options' => wp_json_encode(array(
          "triggers" => ".lqd-iti-links li",
          "targets" => ".lqd-iti-imgs .lqd-iti-img-wrap"
         )),
			]
		);

    $menu_i = 1;

		?>

    <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
      <ol class="lqd-iti-links d-flex flex-wrap reset-ul">
        <?php
          foreach( $settings['items'] as $item ) {
            $this->add_link_attributes( 'link-' . $menu_i, $item['link'] );
        ?>
          <li class="lqd-iti-link-item d-flex pos-rel">
            <a class="lqd-iti-link" <?php echo $this->get_render_attribute_string( 'link-' . $menu_i ); ?>>
              <span class="lqd-iti-title"><?php echo esc_html( $item['title'] ); ?></span>
            </a>
          </li>
        <?php $menu_i++; } ?>
      </ol>
      <div class="lqd-iti-imgs pos-abs pos-tl z-index-1 pointer-events-none">
        <?php foreach( $settings['items'] as $item ) { ?>
          <div class="lqd-iti-img-wrap lqd-overlay overflow-hidden <?php echo 'elementor-repeater-item-' . $item['_id'] ?>">
            <div class="lqd-iti-img-inner lqd-overlay overflow-hidden">
			<?php
				echo wp_get_attachment_image( $item['image']['id'], 'full', false, array( 'class' => 'lqd-iti-img w-100 h-100 objfit-cover objfit-center' ) );
			?>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>

	<?php

	}

}
