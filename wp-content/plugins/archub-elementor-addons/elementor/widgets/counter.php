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
class LD_Counter extends Widget_Base {

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
		return 'ld_counter';
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
		return __( 'Liquid Counter', 'archub-elementor-addons' );
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
		return 'eicon-counter lqd-element';
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
		return [ 'counter' ];
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
				'default' => 'default',
				'options' => [
					'default' => __( 'Default', 'archub-elementor-addons' ),
					'solid' => __( 'Solid', 'archub-elementor-addons' ),
					'bordered' => __( 'Bordered', 'archub-elementor-addons' ),
				],
			]
		);
		
		$this->add_control(
			'count',
			[
				'label' => __( 'Counter', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => '100',
			]
		);

		$this->add_control(
			'tag_to_inherite',
			[
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
				'condition' => [
					'use_inheritance' => 'true',
				],

			]
		);

		$this->add_control(
			'label',
			[
				'label' => __( 'Label', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Title', 'archub-elementor-addons' ),
				'placeholder' => __( 'Type your title here', 'archub-elementor-addons' ),
			]
		);

		$this->add_control(
			'start_delay',
			[
				'label' => __( 'Start Delay', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'millisecond', 'archub-elementor-addons' ),
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'content_align',
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
			]
		);

		$this->add_control(
			'counter_mb_checkbox',
			[
				'label' => __( 'Custom Counter Bottom Margin', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		
		$this->add_control(
			'counter_mb',
			[
				'label' => __( 'Counter Bottom Space', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-counter-element' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'counter_mb_checkbox' => 'yes'
				],
			]
		);

		$this->add_control(
			'add_icon',
			[
				'label' => __( 'Add Icon', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'true',
				'default' => 'false',
				'condition' => [
					'template' => 'solid',
				]
			]
		);

		$this->add_control(
			'i_icon',
			[
				'label' => __( 'Icon', 'archub-elementor-addons' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'solid',
				],
				'condition' => [
					'add_icon' => 'true',
				],
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'typo_section',
			[
				'label' => __( 'Typography', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'counter_typography',
				'label' => __( 'Counter', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-counter-element',
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
			]
		);

		$this->add_control(
			'tag_to_inherite_counter',
			[
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
				'condition' => [
					'use_inheritance' => 'true',
				],
				'separator' => 'after',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'label_typography',
				'label' => __( 'Label', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-counter-text',
			]
		);

		$this->add_control(
			'use_inheritance_label',
			[
				'label' => __( 'Inherit font styles?', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'true',
				'default' => 'false',
			]
		);

		$this->add_control(
			'tag_to_inherite_label',
			[
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
				'condition' => [
					'use_inheritance_label' => 'true',
				],

			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'colors_section',
			[
				'label' => __( 'Colors', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs(
			'colors_tabs'
		);

		$this->start_controls_tab(
			'colors_normal_tab',
			[
				'label' => __( 'Normal', 'archub-elementor-addons' ),
			]
		);

			$this->add_control(
				'color',
				[
					'label' => __( 'Title Color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'label_color',
				[
					'label' => __( 'Label Color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .lqd-counter-text' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'bg_color',
				[
					'label' => __( 'Background Color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .lqd-counter-overlay-bg' => 'background: {{VALUE}}',
					],
					'condition' => [
						'template' => [ 'solid', 'bordered' ],
					],
				]
			);

			$this->add_control(
				'border_color',
				[
					'label' => __( 'Border Color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .lqd-counter-bordered' => 'border-color: {{VALUE}}',
					],
					'condition' => [
						'template' => [ 'bordered' ],
					],
				]
			);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'colors_hover_tab',
			[
				'label' => __( 'Hover', 'archub-elementor-addons' ),
			]
		);

			$this->add_control(
				'color_h',
				[
					'label' => __( 'Color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}:hover' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'label_color_h',
				[
					'label' => __( 'Label Color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}:hover .lqd-counter-text' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'bg_color_h',
				[
					'label' => __( 'Background Color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}:hover .lqd-counter-overlay-bg' => 'background: {{VALUE}}',
					],
					'condition' => [
						'template' => [ 'solid', 'bordered' ],
					],
				]
			);

			$this->add_control(
				'border_color_h',
				[
					'label' => __( 'Border Color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}}:hover .lqd-counter-bordered' => 'border-color: {{VALUE}}',
					],
					'condition' => [
						'template' => [ 'bordered' ],
					],
				]
			);

		$this->end_controls_tab();
		$this->end_controls_tabs();
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
		$template = $settings['template'];
		$counter_tag_to_inherite = $settings['use_inheritance'] === 'true' ? $settings['tag_to_inherite_counter'] : '';
		$label = $settings['label'];
		$counter = $settings['count'];
		$icon = isset($settings['i_icon']['value']) ? $settings['i_icon']['value'] : '';

		$classes = array( 
			'lqd-counter',
			'pos-rel',
			$settings['content_align'],
		);

		if ( 'solid' === $template ){
			array_push( $classes, 'lqd-counter-solid', 'p-4', 'border-radius-6');
		} elseif ( 'bordered' === $template ){
			array_push( $classes, 'lqd-counter-bordered', 'w-100');
		} else {
			array_push( $classes, 'lqd-counter-default');
		}

		?>

		<div id="<?php echo esc_attr($this->get_id()); ?>" class="<?php echo ld_helper()->sanitize_html_classes( $classes ) ?>">

			<?php if ( 'solid' === $template || 'bordered' === $template ) : ?>
				<span class="lqd-counter-overlay-bg lqd-overlay"></span>
			<?php endif ?>

			<div class="lqd-counter-element pos-rel <?php echo esc_attr($counter_tag_to_inherite); ?>" data-enable-counter="true" <?php echo $this->get_data_options(); ?>>
				<?php
					// Counter
					if ( ! empty( $counter ) ) {
						printf( '<span class="d-block">%s</span>', esc_html( $counter ) );
					}
				?>
			</div>

			<?php 
				// Label
				$classname = '';

				if( $settings['use_inheritance_label'] ) {
					$classname = $settings['tag_to_inherite_label']; 
				}

				if (! empty( $label ) ) {
					printf( '<span class="lqd-counter-text %s">%s</span>', $classname, esc_html( $label ) );
				}

				// Icon
				$icon_html = '';

				if( $settings['add_icon'] ) {
					$icon_html = '<span class="lqd-counter-icon pos-abs"><i class="' . esc_attr( $icon ) . '"></i></span>';
				}

				echo $icon_html;
			?>
			

		</div>
				

		<?php
		
	}

	protected function get_data_options() {
		
		$opts = array();
		$counter = $this->get_settings_for_display('count');
		$start_delay = $this->get_settings_for_display('start_delay');
		
		if( ! empty( $counter ) ) {
			$opts['targetNumber'] = esc_html( $counter );	
		}
		if( ! empty( $start_delay ) ) {
			$opts['startDelay'] = esc_html( $start_delay );	
		}
		
		return 'data-counter-options=\'' . wp_json_encode( $opts ) . '\'';
		
	}

}
