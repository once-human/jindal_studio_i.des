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
class LD_Header_Sidedrawer extends Widget_Base {

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
		return 'ld_header_sidedrawer';
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
		return __( 'Liquid Side Drawer', 'archub-elementor-addons' );
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
		return 'eicon-sidebar lqd-element';
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
		return [ 'menu', 'drawer' ];
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
				'label' => __( 'Select Drawer Template', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => true,
				'default' => '0',
				'options' => $this->get_block_posts(),
				'description'  => sprintf( __( 'Go to the <a href="%s" target="_blank">Elementor Templates</a> to manage your elements.', 'archub-elementor-addons' ), admin_url( 'edit.php?post_type=elementor_library&tabs_group=library' ) ),
				'separator' => 'after',
			]
		);

		$this->add_control(
			'drawer_pos',
			[
				'label' => __( 'Drawer Position', 'archub-elementor-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'ld-module-sd-left' => [
						'title' => __( 'Left', 'archub-elementor-addons' ),
						'icon' => 'eicon-h-align-left',
					],
					'ld-module-sd-right' => [
						'title' => __( 'Right', 'archub-elementor-addons' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => 'ld-module-sd-right',
				'toggle' => false,
			]
		);

		$this->add_responsive_control(
			'drawer_width',
			[
				'label' => __( 'Drawer Width', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => '350px',
				'placeholder' => __( 'ex. 350px', 'archub-elementor-addons' ),
				'selectors' => [
					'{{WRAPPER}} .ld-module-sd > .ld-module-dropdown' => 'width: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'drawer_bg_color',
				'label' => esc_html__( 'Background', 'plugin-name' ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .ld-module-sd > .ld-module-dropdown',
			]
		);

		$this->end_controls_section();

		ld_el_nav_trigger($this, 'ib_');

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

		extract( $settings );
		$id = uniqid('lqd-trigger-');


		$module_classes = array(
			'ld-module-sd',
			'ld-module-sd-hover',
			$drawer_pos
		);

		$dropdown_classes = array(
			'ld-module-dropdown',
			'collapse',
			'pos-abs',
			$id,
		);

		$inner_classes = array(
			'ld-sd-inner',
			'justify-content-center',
		);
		?>

		<div class="<?php echo ld_helper()->sanitize_html_classes( $module_classes ) ?>">

		<?php ld_el_nav_trigger_render( $settings, 'ib_', $id ); ?>
			
			<div class="<?php echo ld_helper()->sanitize_html_classes( $dropdown_classes ) ?>" aria-expanded="false" id="<?php echo esc_attr( $id ); ?>" role="dialog">
				<div class="ld-sd-wrap">
				<?php if (! \Elementor\Plugin::$instance->preview->is_preview_mode() ) : ?>
					<div class="<?php echo ld_helper()->sanitize_html_classes( $inner_classes ) ?>">
					<?php echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $settings['modal'] ); ?>
					</div>
				<?php endif; ?>
				</div>
			</div>

			<div class="lqd-module-backdrop"></div>
			
		</div>
		<?php
		
	}

}
