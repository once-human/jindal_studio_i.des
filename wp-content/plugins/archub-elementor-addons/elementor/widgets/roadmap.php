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
 * @since 1.1
 */
class LD_Roadmap extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve heading widget name.
	 *
	 * @since 1.1
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ld_roadmap';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve heading widget title.
	 *
	 * @since 1.1
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Liquid Roadmap', 'archub-elementor-addons' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve heading widget icon.
	 *
	 * @since 1.1
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-time-line lqd-element';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the heading widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since 1.1
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
	 * @since 1.1
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'road', 'map', 'time', 'line' ];
	}

	/**
	 * Register heading widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.1
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

		$repeater = new Repeater();
		$repeater->add_control(
			'title', [
				'label' => __( 'Title', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'content', [
				'label' => __( 'Content', 'archub-elementor-addons' ),
				'type' => Controls_Manager::WYSIWYG,
			]
		);

		$repeater->add_control(
			'checked_item',
			[
				'label' => __( 'Checked Item?', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'list',
			[
				'label' => __( 'Items', 'archub-elementor-addons' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'title' => __( 'Title #1', 'archub-elementor-addons' ),
						'content' => __( 'Content #1', 'archub-elementor-addons' ),
					],
					[
						'title' => __( 'Title #2', 'archub-elementor-addons' ),
						'content' => __( 'Content #2', 'archub-elementor-addons' ),
					],
				],
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

		$this->add_control(
			'primary_color',
			[
				'label' => __( 'Primary Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-roadmap-bar:before, {{WRAPPER}} .lqd-roadmap-bar:after' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'checkmark_color',
			[
				'label' => __( 'Checkmark Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-roadmap-mark' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Title Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-roadmap-item h6' => 'color: {{VALUE}}',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Title Typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-roadmap-item h6',
			]
		);
		
		$this->add_control(
			'color',
			[
				'label' => __( 'Text Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-roadmap-item p' => 'color: {{VALUE}}',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => __( 'Content Typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-roadmap-item p',
			]
		);
		$this->end_controls_section();

	}

	/**
	 * Render heading widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.1
	 * @access protected
	 */
	protected function render() {
		
		$settings = $this->get_settings_for_display();
			
		?>
		<div id="lqd-roadmap-<?php echo esc_attr( $this->get_id() ); ?>" class="lqd-roadmap">

			<div class="lqd-roadmap-inner">	
				<?php 
				if ( $settings['list'] ) {

					foreach (  $settings['list'] as $item ) {

						$classes = array( 
							'lqd-roadmap-item',
							'd-flex',
							'flex-wrap',
							'align-items-center',
							'pos-rel',
							'text-start',
							'elementor-repeater-item-' . $item['_id'],
							$item['checked_item'] === 'yes' ? 'lqd-roadmap-item-checked' : '',
						
						);

						?>
						<div class="<?php echo ld_helper()->sanitize_html_classes( $classes ); ?>">

							<span class="lqd-roadmap-bar lqd-overlay border-radius-circle"></span>

							<div class="lqd-roadmap-info">
								<?php 

									if ( !empty( $item['title'] ) ){
										printf('<h6 class="m-0">%s</h6>', esc_html( $item['title'] ) );
									}
								
									if ( !empty( $item['content'] ) ){
										echo wp_kses_post( ld_helper()->do_the_content( $item['content'] ) );
									}
								
								?>
							</div>

							<span class="lqd-roadmap-mark d-inline-flex align-items-center justify-content-center ms-auto">
								<?php 
									if( 'yes' === $item['checked_item'] ) {
										echo '<svg width="32" height="29" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 29" style="height: 1em;"><path fill="currentColor" d="M25.74 6.23c0.38 0.34 0.42 0.9 0.09 1.28l-12.77 14.58a0.91 0.91 0 0 1-1.33 0.04l-5.46-5.46a0.91 0.91 0 1 1 1.29-1.29l4.77 4.78 12.12-13.85a0.91 0.91 0 0 1 1.29-0.08z"></path></svg>';
									}	
								?>
							</span>

						</div>
						<?php
					}
					
				}
				?>
			</div>

		</div>

		<?php
		
	}

}
