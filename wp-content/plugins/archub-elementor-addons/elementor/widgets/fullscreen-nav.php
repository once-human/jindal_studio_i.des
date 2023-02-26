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
class LD_Fullscreen_Nav extends Widget_Base {

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
		return 'ld_fullscreen_nav';
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
		return __( 'Liquid Fullscreen Nav', 'archub-elementor-addons' );
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
		return 'eicon-star lqd-element';
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
		return [ 'hub-header' ];
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
		return [ 'menu', 'navigation' ];
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
			'modal',
			[
				'label' => __( 'Select Fullscreen Menu', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => true,
				'default' => '0',
				'options' => $this->get_block_posts(),
				'description'  => sprintf( __( 'Go to the <a href="%s" target="_blank">Elementor Templates</a> to manage your elements.', 'archub-elementor-addons' ), admin_url( 'edit.php?post_type=elementor_library&tabs_group=library' ) ),
			]
		);

		$this->add_control(
			'menu_id',
			[
				'label' => __( 'Menu ID', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'main-header-collapse',
				'placeholder' => __( 'your-id', 'archub-elementor-addons' ),
			]
		);

		$this->add_responsive_control(
			'nav_padding',
			[
				'label' => __( 'Content Padding', 'archub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'unit' => 'px',
					'top' => '150',
					'right' => '0',
					'bottom' => '50',
					'left' => '0',
					'isLinked' => false
				],
				'selectors' => [
					'{{WRAPPER}} .navbar-fullscreen-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before'
			]
		);

		$this->add_control(
			'position',
			[
				'label' => __( 'Close button position', 'archub-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left:4em;right:auto;' => [
						'title' => __( 'Left', 'archub-elementor-addons' ),
						'icon' => 'eicon-h-align-left',
					],
					'right:4em;left:auto;' => [
						'title' => __( 'Right', 'archub-elementor-addons' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => 'right:4em;left:auto',
				'toggle' => false,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .navbar-fullscreen .main-nav-trigger' => '{{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		// Style Tab
		$this->start_controls_section(
			'style_section',
			[
				'label' => __( 'Style', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'bg_color',
			[
				'label' => __( 'Background Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .navbar-fullscreen .lqd-fsh-bg-side-container span,{{WRAPPER}} .navbar-fullscreen .lqd-fsh-bg-col span' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'lines_color',
			[
				'label' => __( 'Lines Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .navbar-fullscreen .lqd-fsh-bg-side-container:before, {{WRAPPER}} .navbar-fullscreen .lqd-fsh-bg-col:before' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'trigger_color_active',
			[
				'label' => __( 'Trigger Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .nav-trigger.is-active .bar, {{WRAPPER}} .nav-trigger.is-active .bar:before, {{WRAPPER}} .nav-trigger.is-active .bar:after' => 'background: {{VALUE}}',
					'{{WRAPPER}} .nav-trigger.is-active' => 'color: {{VALUE}}',
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
	
		$options = [ '0' => 'Select Element' ];
	
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

		?>

		<?php if (! \Elementor\Plugin::$instance->preview->is_preview_mode() ) : ?>

		<div class="navbar-fullscreen flex-wrap pos-fix pos-tl overflow-hidden invisible" id="<?php echo esc_attr( ($settings['menu_id'] !== '' ? $settings['menu_id'] : 'main-header-collapse') ); ?>">
			<div class="navbar-fullscreen-inner h-100 flex-grow-1">
				<div class="lqd-fsh-bg d-flex w-100 h-100 pos-fix pos-tl">
					<div class="lqd-fsh-bg-side-container lqd-fsh-bg-before-container h-100 pos-rel flex-grow-1">
						<span class="d-inline-block w-100 h-100"></span>
					</div>
					<div class="container lqd-fsh-bg-container h-100 p-0 m-0 flex-grow-1">
						<div class="lqd-fsh-bg-row d-flex h-100">
							<div class="flex-grow-1 lqd-fsh-bg-col h-100 pos-rel">
								<span class="d-inline-block w-100 h-100"></span>
							</div>
							<div class="flex-grow-1 lqd-fsh-bg-col h-100 pos-rel">
								<span class="d-inline-block w-100 h-100"></span>
							</div>
							<div class="flex-grow-1 lqd-fsh-bg-col h-100 pos-rel">
								<span class="d-inline-block w-100 h-100"></span>
							</div>
							<div class="flex-grow-1 lqd-fsh-bg-col h-100 pos-rel">
								<span class="d-inline-block w-100 h-100"></span>
							</div>
						</div>
					</div>
					<div class="lqd-fsh-bg-side-container lqd-fsh-bg-after-container h-100 pos-rel flex-grow-1">
						<span class="d-inline-block w-100 h-100"></span>
					</div>
				</div>
			
				<div class="header-modules-container d-flex flex-column flex-grow-1">
					<div class="d-flex flex-column p-0 flex-grow-1">
	
						<?php echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $settings['modal'] ); ?>
						
					</div>
				</div>
			</div>
		</div>

		<?php endif; 
		
	}

}
