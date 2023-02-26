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
class LD_Milestone extends Widget_Base {

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
		return 'ld_milestone';
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
		return __( 'Liquid Milestone Box', 'archub-elementor-addons' );
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
		return 'eicon-date lqd-element';
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
	 * @since 2.1.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'milestone', 'box' ];
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
			'title',
			[
				'label' => __( 'Title', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Title', 'archub-elementor-addons' ),
				'placeholder' => __( 'Type your text here', 'archub-elementor-addons' ),
			]
		);

		$this->add_control(
			'date',
			[
				'label' => __( 'Date/Time', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( '2021', 'archub-elementor-addons' ),
				'placeholder' => __( 'Type your text here', 'archub-elementor-addons' ),
			]
		);

		$this->add_control(
			'content',
			[
				'label' => __( 'Text', 'archub-elementor-addons' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => __( 'Type your text here', 'archub-elementor-addons' ),
				'placeholder' => __( 'Type your text here', 'archub-elementor-addons' ),
			]
		);

		$this->add_control(
			'primary_color',
			[
				'label' => __( 'Primary Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-milestone-time' => 'color: {{VALUE}}',
				],
				'separator' => 'before',
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

		?>
		<div class="lqd-milestone d-flex align-items-start">

			<?php 
				if ( !empty( $settings['date'] ) )
					printf( '<div class="lqd-milestone-time h3 mt-0 font-weight-bold text-center me-3"><span>%s</span></div>', esc_html( $settings['date'] ) );
			?>

			<div class="lqd-milestone-content flex-grow-1">
				<?php 
					if ( !empty( $settings['title'] ) )
					printf( '<h5 class="mt-0 text-uppercase">%s</h5>', esc_html( $settings['title'] ) );
			
					if ( !empty( $settings['content'] ) )
					echo wp_kses_post( ld_helper()->do_the_content( $settings['content'] ) );
				?>
			</div>

		</div>
		<?php
	}

}
