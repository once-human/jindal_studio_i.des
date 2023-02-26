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
class LD_Modal_Window extends Widget_Base {

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
		return 'ld_modal_window';
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
		return __( 'Liquid Modal Box', 'archub-elementor-addons' );
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
		return 'eicon-header lqd-element';
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
		return [ 'gdpr', 'alert', 'cookie'  ];
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

		if ( liquid_helper()->liquid_elementor_script_depends() ){
			return [ 'lity' ];
		} else {
			return [''];
		}
		
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
			'modal_type',
			[
				'label' => __( 'Modal Type', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => __( 'Default', 'archub-elementor-addons' ),
					'fullscreen' => __( 'Fullscreen', 'archub-elementor-addons' ),
					'box' => __( 'Box', 'archub-elementor-addons' ),
					'side' => __( 'Side', 'archub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'modal',
			[
				'label' => __( 'Select Modal', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '0',
				'options' => $this->get_block_posts(),
				'description'  => sprintf( __( 'Go to the <a href="%s" target="_blank">Elementor Templates</a> to manage your elements.', 'archub-elementor-addons' ), admin_url( 'edit.php?post_type=elementor_library&tabs_group=library' ) ),
				'frontend_available' => true,
			]
		);

		$this->add_responsive_control(
			'box_width',
			[
				'label' => esc_html__( 'Width', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px', 'vw' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
					'vw' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 350,
				],
				'selectors' => [
					'{{WRAPPER}}.lqd-lity[data-modal-type=box]' => 'width: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
				'condition' => [
					'modal_type' => 'box',
				],
			]
		);

		$this->add_responsive_control(
			'box_height',
			[
				'label' => esc_html__( 'Height', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px', 'vh' ],
				'range' => [
					'%' => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 1000,
					],
					'vh' => [
						'min' => 1,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 500,
				],
				'selectors' => [
					'{{WRAPPER}}.lqd-lity[data-modal-type=box]' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'modal_type' => 'box',
				],
			]
		);

		$this->add_control(
			'side_content',
			array(
				'label' => __( 'Side trigger label', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'dynamic' => array(
					'active' => true,
				),
				'rows' => '6',
				'default' => 'Begin building your dream house.',
				'selectors' => [
					'{{WRAPPER}}.lqd-lity' => '--close-txt: \'{{VALUE}}\';',
				],
				'condition' => [
					'modal_type' => 'side',
				],
			)
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
			'modal_bg_heading',
			[
					'label' => esc_html__( 'Modal background color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'modal_bg',
				'label' => __( 'Background', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],	
				'selector' => '{{WRAPPER}} .lqd-lity-container, {{WRAPPER}} .lqd-lity-close-btn-wrap',
			]
		);

		$this->add_control(
			'backdrop_bg_heading',
			[
					'label' => esc_html__( 'Backdrop background color', 'archub-elementor-addons' ),
					'type' => Controls_Manager::HEADING,
					'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'backdropl_bg',
				'label' => __( 'Background', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],	
				'selector' => '{{WRAPPER}} .lqd-lity-backdrop',
			]
		);

		$this->add_control(
		'close_btn_bg_color',
			array(
				'label' => __( 'Close button background color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .lqd-lity-close' => 'background-color:{{VALUE}}!important',
				],
				'separator' => 'before',
			)
		);

		$this->add_control(
		'close_btn_bg_h_color',
			array(
				'label' => __( 'Close button background hover color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .lqd-lity-close:hover' => 'background-color:{{VALUE}}!important',
				],
			)
		);

		$this->add_control(
		'close_btn_color',
			array(
				'label' => __( 'Close button icon color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .lqd-lity-close-btn-wrap, {{WRAPPER}} .lqd-lity-close-btn-wrap button' => 'color:{{VALUE}}',
				],
			)
		);

		$this->add_control(
		'close_btn_h_color',
			array(
				'label' => __( 'Close button icon hover color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .lqd-lity-close:hover' => 'color:{{VALUE}}',
				],
			)
		);

		$this->add_responsive_control(
			'modal_padding',
			[
				'label' => __( 'Modal padding', 'archub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .lqd-modal' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
		

	}

	protected function get_block_posts() {
		$posts = get_posts( array(
			'post_type' => 'elementor_library',
			'posts_per_page' => -1,
			'meta_query'  => array(
					array(
						'key' => '_elementor_template_type',
						'value' => 'kit',
						'compare' => '!=',
					),
				),
		) );
	
		$options = [ '0' => 'Select Modal' ];
	
		foreach ( $posts as $post ) {
		  $options[ $post->ID ] = $post->post_title;
		}
	
		return $options;
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
			'lqd-modal',
			'lqd-lity-hide',
		);

		?>		

		<?php if ($settings['modal'] != 0 && \Elementor\Plugin::$instance->editor->is_edit_mode()){ ?>
		<span class="lqd-modal-id">
			<?php echo esc_html( 'Available Modal ID: #modal-'.$settings['modal'] ); ?>
		</span>
		<?php } ?>
		<div id="<?php echo esc_attr( 'modal-'.$settings['modal'] ); ?>" class="<?php echo ld_helper()->sanitize_html_classes( $classes ); ?>" data-modal-type="<?php echo esc_attr( $settings['modal_type'] ) ?>">
		
			<div class="lqd-modal-inner">
				<div class="lqd-modal-content">
					<?php echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $settings['modal'] ); ?>
				</div>
			</div>

		</div>

		<?php
		
	}

}
