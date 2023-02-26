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
class LD_Slideshow_2 extends Widget_Base {

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
		return 'ld_slideshow_2';
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
		return __( 'Liquid Vertical Slider', 'archub-elementor-addons' );
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
		return 'eicon-slider-vertical lqd-element';
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
		return [ 'slide', 'carousel' ];
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
			return [ 'flickity' ];
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

		// General Section
		$this->start_controls_section(
			'general_section',
			[
				'label' => __( 'General', 'archub-elementor-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		
		$this->add_responsive_control(
			'height',
			[
				'label' => __( 'Height', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => '400px',
				'placeholder' => __( 'ex. 400px', 'archub-elementor-addons' ),
				'selectors' => [
					'{{WRAPPER}} .lqd-vslider-scrn' => 'height: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'enable_custom_cursor',
			[
				'label' => __( 'Custom Cursor', 'archub-elementor-addons' ),
				'description' => __( 'You need to turn on this custom cursor feature from the theme options. "Theme Options > Extra > Custom Cursor"', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'archub-elementor-addons' ),
				'label_off' => __( 'Hide', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'list_title', [
				'label' => __( 'Title', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'List Title' , 'archub-elementor-addons' ),
				'label_block' => true,
				'condition'=> [
				],
			]
		);

		$repeater->add_control(
			'list_image',
			[
				'label' => __( 'Image', 'archub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'content_type',
			[
				'label' => __( 'Content Type', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'tinymce',
				'label_block' => true,
				'options' => [
					'tinymce' => __( 'TinyMCE', 'archub-elementor-addons' ),
					'el_template' => __( 'Elementor Template', 'archub-elementor-addons' ),
				],
				'separator' => 'before',
			]
		);

		$repeater->add_control(
			'templates',
			[
				'label' => __( 'Templates', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'label_block' => true,
				'options' => $this->get_block_posts(),
				'default' => '0',
				'condition' => [
					'content_type' => 'el_template',
				]
			]
		);

		$repeater->add_control(
			'list_content', [
				'label' => __( 'Content', 'archub-elementor-addons' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => __( 'List Content' , 'archub-elementor-addons' ),
				'label_block' => true,
				'condition'=> [
					'content_type' => 'tinymce'
				],
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
						'list_title' => __( 'Title #1', 'archub-elementor-addons' ),
						'list_content' => __( 'Item content. Click the edit button to change this text.', 'archub-elementor-addons' ),
					],
					[
						'list_title' => __( 'Title #2', 'archub-elementor-addons' ),
						'list_content' => __( 'Item content. Click the edit button to change this text.', 'archub-elementor-addons' ),
					],
				],
				'title_field' => '{{{ list_title }}}',
				'separator' => 'before'
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

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => __( 'Typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} li',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'overlay_bg',
				'label' => __( 'Overlay Background', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .lqd-vslider-scrn:after',
			]
		);

		$this->add_control(
			'color',
			[
				'label' => __( 'Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'hover_color',
			[
				'label' => __( 'Hover Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a:hover' => 'color: {{VALUE}}',
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
	
		$options = [ '0' => 'Select Template' ];
	
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

		<div class="lqd-vslider">

			<div class="lqd-vslider-scrn w-100 pos-rel overflow-hidden" data-lqd-slideshow="true" data-inview="true">

				<span class="lqd-vslider-loader d-inline-flex align-items-center justify-content-center border-radius-6 pos-abs z-index-3">
					<span class="d-inline-flex border-radius-circle"></span>
				</span>

				<div class="lqd-vslider-scrn-inner pos-rel overflow-hidden h-100">

					<div class="lqd-vslider-ext lqd-overlay">
					
						<ul class="reset-ul pos-rel">
							<?php $first = true; ?>
							<?php foreach (  $settings['list'] as $item ) : ?>
								<li class="z-index-3 pt-3 ps-3 pe-3 m-0 pos-abs <?php echo esc_attr( $first ? 'is-active' : '' );?>">
								<?php 
								if ( $item['content_type'] === 'tinymce' ){
									echo $item['list_content']; 
								}else{
									echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $item['templates'] ); 
								}
								?>
								</li>
							<?php $first = false; ?>
							<?php endforeach; ?>
						</ul>

					</div>

					<div class="lqd-vslider-images lqd-overlay z-index-0">
						<?php $first = true; ?>
						<?php foreach (  $settings['list'] as $item ) : ?>
							<figure class="pos-abs overflow-hidden <?php echo esc_attr( $first ? 'is-active' : '' ); ?>">
							<?php 
								$alt = get_post_meta( $item['list_image']['id'], '_wp_attachment_image_alt', true );
								echo '<img class="w-100 h-100 lqd-overlay objfit-cover objfit-center" src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs=" data-src="' . wp_get_attachment_image_url( $item['list_image']['id'], 'full', false  ) . '" alt="' . esc_attr( $alt ) . '" />';
							?>
							</figure>
						<?php $first = false; ?>
						<?php endforeach; ?>
					</div>
				
					
					<div class="lqd-vslider-menu lqd-overlay z-index-2">

						<ul class="reset-ul d-flex flex-column lqd-overlay text-vertical">
							<?php $first = true; ?>
							<?php foreach (  $settings['list'] as $item ) : ?>
								<li class="d-flex align-items-end p-4 m-0 pos-rel <?php echo esc_attr( $first ? 'is-active' : '' ); ?>">
									<a class="lqd-webgl-slideshow-link p-4" href="#">
										<span class="d-inline-flex"><?php echo esc_html( $item['list_title'] ); ?></span>
									</a>
								</li>
							<?php $first = false; ?>
							<?php endforeach; ?>
						</ul>

					</div>

				</div>

				<?php if ( $settings['enable_custom_cursor'] === 'yes' ) : ?>
					<span class="lqd-extra-cursor pos-fix pointer-events-none"></span>
				<?php endif; ?>

			</div>

		</div>
		
		<?php
	}

}
