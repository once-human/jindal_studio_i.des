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
class LD_Pf_Single_Nav extends Widget_Base {

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
		return 'ld_single_portfolio_nav';
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
		return __( 'Liquid Portfolio Single Navigation', 'archub-elementor-addons' );
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
		return 'eicon-post-navigation lqd-element';
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
		return [ 'hub-portfolio' ];
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
		return [ 'portfolio', 'meta', 'navigation' ];
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

		// General
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'archub-elementor-addons' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'template',
			[
				'label' => __( 'Style', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'classic',
				'options' => [
					'classic' => __( 'Classic', 'archub-elementor-addons' ),
					'classic-minimal' => __( 'Classic - Minimal', 'archub-elementor-addons' ),
					'no-classic' => __( 'Modern', 'archub-elementor-addons' ),
					'no-classic-outline' => __( 'Modern - Outline', 'archub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'url_type',
			[
				'label' => esc_html__( 'URL', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'global',
				'options' => [
					'global' => esc_html__( 'Theme Options', 'archub-elementor-addons' ),
					'custom' => esc_html__( 'Custom', 'archub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'url',
			[
				'label' => esc_html__( 'Link', 'archub-elementor-addons' ),
				'type' => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'archub-elementor-addons' ),
				'default' => [
					'url' => '',
				],
				'label_block' => true,
				'condition' => [
					'url_type' => 'custom',
				],
			]
		);

		$this->add_control(
			'url_notice',
			[
				'type' => Controls_Manager::RAW_HTML,
				'raw' => sprintf( __( '<strong>Theme Options > Portfolio > Portfolio Single > Portfolio Archive URL. </strong><a href="%1$s" target="_blank">Open Theme Settings</a>', 'archub-elementor-addons' ), admin_url( 'admin.php?page=liquid-theme-options' ) ),
				'separator' => 'after',
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				'default' => 0,
				'condition' => [
					'url_type' => 'global',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'label' => __( 'Typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} .lqd-pf-nav-link-title',
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
				'condition' => [
					'template' => [ 'no-classic', 'no-classic-outline' ]
				],
			]
		);

		$this->add_control(
			'tag_to_inherite',
			array(
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
				'condition' => array(
					'use_inheritance' => 'true',
				),

			)
		);
		
		$this->add_control(
			'color',
			[
				'label' => __( 'Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-pf-meta-nav' => 'color: {{VALUE}}',
					'{{WRAPPER}} .lqd-pf-meta-nav .lqd-pf-nav-link-title' => '-webkit-text-stroke-color: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'hcolor',
			[
				'label' => __( 'Hover Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-pf-nav-link:hover' => 'color: {{VALUE}} !important',
					'{{WRAPPER}} .lqd-pf-meta-nav .lqd-pf-nav-link:hover .lqd-pf-nav-link-title' => '-webkit-text-stroke-color: {{VALUE}}; color: {{VALUE}} !important;',
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
		$template = $settings['template'];

		$classes = array(
			'lqd-pf-meta-nav', 
			'd-flex'
		);

		if ( ! empty( $settings['url']['url'] ) ) {
			$this->add_link_attributes( 'url', $settings['url'] );
		}

		global $post;

		$prev_post_obj   = get_adjacent_post( false, '', true, 'liquid-portfolio-category' );
		$prev_post_ID    = isset( $prev_post_obj->ID ) ? $prev_post_obj->ID : '';
		$prev_post_link  = get_permalink( $prev_post_ID );
		$prev_post_title = get_the_title( $prev_post_ID );

		$next_post_obj   = get_adjacent_post( false, '', false, 'liquid-portfolio-category' );
		$next_post_ID    = isset( $next_post_obj->ID ) ? $next_post_obj->ID : '';
		$next_post_link  = get_permalink( $next_post_ID );
		$next_post_title = get_the_title( $next_post_ID );

		switch ($template){
			case 'classic': 
				array_push($classes, 'lqd-pf-meta-nav-classic', 'align-items-center', 'justify-content-between');
				?>
					<div class="<?php echo ld_helper()->sanitize_html_classes( $classes ); ?>">
						<?php if( $prev_post_ID ): ?>
						<a href="<?php echo esc_url( $prev_post_link ); ?>" class="lqd-pf-nav-link lqd-pf-nav-prev d-flex align-items-center">
							<i class="lqd-icn-ess icon-ion-ios-arrow-back"></i>
							<span class="ms-3 d-flex flex-column">
								<span class="lqd-pf-nav-link-subtitle"><?php esc_html_e( 'Previous', 'archub-elementor-addons' ); ?></span>
								<span class="lqd-pf-nav-link-title"><?php echo esc_html( $prev_post_title ); ?></span>
							</span>
						</a>
						<?php endif; ?>

						<?php if ( $settings['url_type'] === 'custom' ) : ?>
							<a <?php echo $this->get_render_attribute_string( 'url' ); ?> class="lqd-pf-nav-link lqd-pf-nav-all"><span></span></a>
						<?php else: ?>
							<?php if( function_exists( 'liquid_portfolio_archive_link' ) ) { ?>
								<?php echo liquid_portfolio_archive_link(); ?>
							<?php } ?>
						<?php endif; ?>

						<?php if( $next_post_ID ): ?>
						<a href="<?php echo esc_url( $next_post_link ); ?>" class="lqd-pf-nav-link lqd-pf-nav-next d-flex flex-row-reverse align-items-center text-end">
							<i class="lqd-icn-ess icon-ion-ios-arrow-forward"></i>
							<span class="me-3 d-flex flex-column">
								<span class="lqd-pf-nav-link-subtitle"><?php esc_html_e( 'Next', 'archub-elementor-addons' ); ?></span>
								<span class="lqd-pf-nav-link-title"><?php echo esc_html( $next_post_title ); ?></span>
							</span>
						</a>
						<?php endif; ?>
					</div>
				<?php
			break;
			case 'no-classic':
				array_push($classes, 'lqd-pf-meta-nav-not-classic', 'align-items-center', 'justify-content-center');
				?>
					<div class="<?php echo ld_helper()->sanitize_html_classes( $classes ); ?>">
						<?php if( $next_post_ID ): ?>
						<a href="<?php echo esc_url( $next_post_link ); ?>" class="lqd-pf-nav-link lqd-pf-nav-next d-flex flex-row-reverse align-items-center">
							<span class="d-flex flex-column">
								<span class="lqd-pf-nav-link-subtitle">
									<span><?php esc_html_e( 'next project', 'archub-elementor-addons' ); ?></span>
									<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" style="height: 1em;"><path fill="currentColor" d="M17.806 25.788l8.631-8.375c.375-.363.563-.857.563-1.4v-.025c0-.544-.188-1.038-.563-1.4l-8.63-8.375c-.75-.782-1.957-.782-2.7 0s-.745 2.043 0 2.825L20.293 14H6.919C5.856 14 5 14.894 5 16c0 1.125.856 2 1.912 2h13.375L15.1 22.963a2.067 2.067 0 0 0 0 2.824c.75.782 1.956.782 2.706 0z"></path></svg>
								</span>
								<span class="lqd-pf-nav-link-title <?php echo $settings['tag_to_inherite']; ?>"><?php echo esc_html( $next_post_title ); ?></span>
							</span>
						</a>
						<?php elseif( $prev_post_ID ): ?>
						<a href="<?php echo esc_url( $prev_post_link ); ?>" class="lqd-pf-nav-link lqd-pf-nav-next d-flex flex-row-reverse align-items-center">
							<span class="d-flex flex-column">
								<span class="lqd-pf-nav-link-subtitle">
									<span><?php esc_html_e( 'previous project', 'archub-elementor-addons' ); ?></span>
									<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" style="height: 1em;"><path fill="currentColor" d="M17.806 25.788l8.631-8.375c.375-.363.563-.857.563-1.4v-.025c0-.544-.188-1.038-.563-1.4l-8.63-8.375c-.75-.782-1.957-.782-2.7 0s-.745 2.043 0 2.825L20.293 14H6.919C5.856 14 5 14.894 5 16c0 1.125.856 2 1.912 2h13.375L15.1 22.963a2.067 2.067 0 0 0 0 2.824c.75.782 1.956.782 2.706 0z"></path></svg>
								</span>
								<span class="lqd-pf-nav-link-title h1"><?php echo esc_html( $prev_post_title ); ?></span>
							</span>
						</a>
						<?php endif; ?>
					</div>
				<?php
			break;
			case 'classic-minimal':
				array_push($classes, 'lqd-pf-meta-nav-classic', 'lqd-pf-meta-nav-classic-minimal', 'align-items-center', 'justify-content-between');
				?>
					<div class="<?php echo ld_helper()->sanitize_html_classes( $classes ); ?>">
						<?php if( $prev_post_ID ): ?>
						<a href="<?php echo esc_url( $prev_post_link ); ?>" class="lqd-pf-nav-link lqd-pf-nav-prev d-flex align-items-center">
							<span class="d-flex">
								<span class="lqd-pf-nav-link-title d-flex align-items-center"><i class="lqd-icn-ess icon-ion-ios-arrow-back"></i> <?php esc_html_e( 'Previous', 'archub-elementor-addons' ); ?></span>
							</span>
						</a>
						<?php endif; ?>

						<?php if ( $settings['url_type'] === 'custom' ) : ?>
							<a <?php echo $this->get_render_attribute_string( 'url' ); ?> class="lqd-pf-nav-link lqd-pf-nav-all"><span></span></a>
						<?php else: ?>
							<?php if( function_exists( 'liquid_portfolio_archive_link' ) ) { ?>
								<?php echo liquid_portfolio_archive_link(); ?>
							<?php } ?>
						<?php endif; ?>

						<?php if( $next_post_ID ): ?>
						<a href="<?php echo esc_url( $next_post_link ); ?>" class="lqd-pf-nav-link lqd-pf-nav-next d-flex flex-row-reverse align-items-center">
							<span class="d-flex text-end">
								<span class="lqd-pf-nav-link-title d-flex align-items-center"><?php esc_html_e( 'Next', 'archub-elementor-addons' ); ?> <i class="lqd-icn-ess icon-ion-ios-arrow-forward"></i></span>
							</span>
						</a>
						<?php endif; ?>
					</div>
				<?php
			break;
			case 'no-classic-outline':
				array_push($classes, 'lqd-pf-meta-nav-not-classic', 'lqd-pf-meta-nav-not-classic-outline', 'align-items-center', 'justify-content-center');
				?>
					<div class="<?php echo ld_helper()->sanitize_html_classes( $classes ); ?>">
						<?php if( $next_post_ID ): ?>
						<a href="<?php echo esc_url( $next_post_link ); ?>" class="lqd-pf-nav-link lqd-pf-nav-next d-flex flex-row-reverse align-items-center">
							<span class="d-flex flex-column">
								<span class="lqd-pf-nav-link-subtitle">
									<span><?php esc_html_e( 'next project', 'archub-elementor-addons' ); ?></span>
									<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" style="height: 1em;"><path fill="currentColor" d="M17.806 25.788l8.631-8.375c.375-.363.563-.857.563-1.4v-.025c0-.544-.188-1.038-.563-1.4l-8.63-8.375c-.75-.782-1.957-.782-2.7 0s-.745 2.043 0 2.825L20.293 14H6.919C5.856 14 5 14.894 5 16c0 1.125.856 2 1.912 2h13.375L15.1 22.963a2.067 2.067 0 0 0 0 2.824c.75.782 1.956.782 2.706 0z"></path></svg>
								</span>
								<span class="lqd-pf-nav-link-title <?php echo $settings['tag_to_inherite']; ?>"><?php echo esc_html( $next_post_title ); ?></span>
							</span>
						</a>
						<?php elseif( $prev_post_ID ): ?>
						<a href="<?php echo esc_url( $prev_post_link ); ?>" class="lqd-pf-nav-link lqd-pf-nav-next d-flex flex-row-reverse align-items-center">
							<span class="d-flex flex-column">
								<span class="lqd-pf-nav-link-subtitle">
									<span><?php esc_html_e( 'previous project', 'archub-elementor-addons' ); ?></span>
									<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" style="height: 1em;"><path fill="currentColor" d="M17.806 25.788l8.631-8.375c.375-.363.563-.857.563-1.4v-.025c0-.544-.188-1.038-.563-1.4l-8.63-8.375c-.75-.782-1.957-.782-2.7 0s-.745 2.043 0 2.825L20.293 14H6.919C5.856 14 5 14.894 5 16c0 1.125.856 2 1.912 2h13.375L15.1 22.963a2.067 2.067 0 0 0 0 2.824c.75.782 1.956.782 2.706 0z"></path></svg>
								</span>
								<span class="lqd-pf-nav-link-title h1"><?php echo esc_html( $prev_post_title ); ?></span>
							</span>
						</a>
						<?php endif; ?>
					</div>
				<?php
			break;
		}

	}

}
