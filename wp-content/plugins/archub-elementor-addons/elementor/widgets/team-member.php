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
class LD_Team_Member extends Widget_Base {

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
		return 'ld_team_member';
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
		return __( 'Liquid Team Member', 'archub-elementor-addons' );
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
		return 'eicon-person lqd-element';
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
		return [ 'team', 'user', 'member'  ];
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
			return [ 'gsap' ];
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

		$this->add_control(
			'template',
			[
				'label' => __( 'Style', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'lqd-tm-style-1',
				'options' => [
					'lqd-tm-style-1' => __( 'Style 1', 'archub-elementor-addons' ),
					'lqd-tm-style-2' => __( 'Style 2', 'archub-elementor-addons' ),
					'lqd-tm-style-3' => __( 'Style 3', 'archub-elementor-addons' ),
					'lqd-tm-style-4' => __( 'Style 4', 'archub-elementor-addons' ),
					'lqd-tm-style-5' => __( 'Style 5', 'archub-elementor-addons' ),
				],
			]
		);

		$this->add_control(
			'image',
			[
				'label' => __( 'Team Member Image', 'archub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'name',
			[
				'label' => __( 'Name', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'John Doe', 'archub-elementor-addons' ),
				'placeholder' => __( 'Name', 'archub-elementor-addons' ),
			]
		);
		
		$this->add_control(
			'position',
			[
				'label' => __( 'Position', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Developer', 'archub-elementor-addons' ),
				'placeholder' => __( 'Position', 'archub-elementor-addons' ),
			]
		);

		$this->add_control(
			'link',
			[
				'label' => __( 'Link (URL)', 'archub-elementor-addons' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://twitter.com', 'archub-elementor-addons' ),
				'show_external' => true,
				'default' => [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		);

		$this->add_responsive_control(
			'ct_alignment',
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
				'condition' => [
					'template' => ['lqd-tm-style-2', 'lqd-tm-style-3'],
				],
			]
		);

		$this->add_control(
			'ct_shadow',
			[
				'label' => __( 'Disable Shadow', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'archub-elementor-addons' ),
				'label_off' => __( 'No', 'archub-elementor-addons' ),
				'condition' => [
					'template' => [ 'lqd-tm-style-2' ],
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-tm-style-2' => 'box-shadow: none;',
				],
			]
		);

		$this->add_responsive_control(
			'ct_padding',
			[
				'label' => __( 'Custom content padding', 'archub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .lqd-tm-details' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'icon',
			[
				'label' => __( 'Icon', 'archub-elementor-addons' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'solid',
				],
			]
		);

		$repeater->add_control(
			'link',
			[
				'label' => __( 'Link (URL)', 'archub-elementor-addons' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://twitter.com', 'archub-elementor-addons' ),
				'show_external' => true,
				'default' => [
					'url' => '#',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		);

		$this->add_control(
			'list',
			[
				'label' => __( 'Social Profile', 'archub-elementor-addons' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'separator' => 'before',
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
			'title_color',
			[
				'label' => __( 'Name color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} h3' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Name typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} h3',
			]
		);

		$this->add_control(
			'pos_color',
			[
				'label' => __( 'Position color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-tm-style-1 h6, {{WRAPPER}} .lqd-tm-style-2 h6, {{WRAPPER}} .lqd-tm-style-3 h6, {{WRAPPER}} .lqd-tm-style-4 h6, {{WRAPPER}} .lqd-tm-style-5 h6' => 'color: {{VALUE}}',
				],
				'separator' => 'before',
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'position_typography',
				'label' => __( 'Position typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} h6',
				'separator' => 'before'
			]
		);

		$this->add_control(
			'bg_color_heading',
			[
				'label' => esc_html__( 'Background', 'archub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
	);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'bg_color',
				'label' => __( 'Nav background', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .lqd-tm .lqd-tm-details',
				'condition' => [
					'template' => ['lqd-tm-style-3', 'lqd-tm-style-4', 'lqd-tm-style-5'],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'bg_color_style1',
				'label' => __( 'Nav background', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .lqd-tm-style-1 .block-revealer__element',
				'condition' => [
					'template' => 'lqd-tm-style-1',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'bg_color_style2',
				'label' => __( 'Nav background', 'archub-elementor-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .lqd-tm-style-2 .lqd-tm-socials, {{WRAPPER}} .lqd-tm-style-2 .block-revealer__element',
				'condition' => [
					'template' => 'lqd-tm-style-2',
				],
			]
		);

		$this->add_control(
			'arrow_color',
			[
				'label' => __( 'Arrow color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-tm-details-icon' => 'color: {{VALUE}}',
				],
				'condition' => [
					'template' => ['lqd-tm-style-4', 'lqd-tm-style-5']
				],
				'separator' => 'before'
			]
		);

		$this->add_control(
			'social_color',
			[
				'label' => __( 'Social icon color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .social-icon a' => 'color: {{VALUE}}',
				],
				'separator' => 'before'
			]
		);

		$this->add_control(
			'social_hcolor',
			[
				'label' => __( 'Social icon hover color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .social-icon a:hover' => 'color: {{VALUE}}',
				],
				'separator' => 'before'
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
		$name = $settings['name'];
		$position = esc_html($settings['position']); 
		$image_url = esc_url($settings['image']['url']); 
		$image_id = $settings['image']['id']; 
		$gradient_id = uniqid('grandient-');
		$member_link = esc_url($settings['link']['url']);


		$wrapper_class = array(
			'lqd-tm',
			'pos-rel',
			$template,
		);

		if( $template === 'lqd-tm-style-2' || $template === 'lqd-tm-style-3' ){
			array_push($wrapper_class, 'border-radius-4', 'overflow-hidden');
		}
		if ($template === 'lqd-tm-style-4'){
			array_push($wrapper_class, 'overflow-hidden');
		}
		if ($template === 'lqd-tm-style-5'){
			array_push($wrapper_class, 'overflow-hidden');
		}

		?>

		<div class="<?php echo esc_attr( implode(' ', $wrapper_class) ); ?>" <?php if ( $template === 'lqd-tm-style-1' ) echo 'data-inview="true"'; ?>>

			<?php
			switch ($template){
				case 'lqd-tm-style-1':
				?>
					<div class="lqd-tm-img">
						<figure>
							<?php echo wp_get_attachment_image( $image_id, 'full', false, [ 'alt' => esc_attr( $name ), 'class' => 'w-100' ] ); ?>
						</figure>
					</div>

					<div
						class="lqd-tm-details ps-6 pe-6 pt-4 pb-4"
						data-custom-animations="true"
						data-ca-options='{ "triggerHandler": "inview", "animationTarget": "h3,h6", "duration": 1200, "delay": 120,  "startDelay": 350, "direction": "backward", "initValues": { "translateY": -30, "opacity": 0 }, "animations": { "translateY": 0, "opacity": 1 } }'
					>
						<div class="lqd-tm-bg lqd-overlay" data-reveal="true" data-reveal-options='{ "direction": "tb", "bgcolor": "#fff", "duration": 700, "coverArea": 100 }'></div>
						<h3 class="mt-0 mb-2"><?php echo esc_html( $name ); ?></h3>
						<h6 class="mt-0 mb-0 font-weight-normal"><?php echo $position; ?></h6>
						<?php if( !empty( $member_link ) ) : ?>
							<a class="lqd-overlay" href="<?php echo $member_link ?>"></a>
						<?php endif; ?>
					</div>
					<?php if( !empty( $member_link ) ) : ?>
						<a class="lqd-overlay" href="<?php echo $member_link ?>"></a>
					<?php endif; ?>
				<?php
				break;
				case 'lqd-tm-style-2':
				?>
					<div class="lqd-tm-img pos-rel">
						<figure>
							<?php echo wp_get_attachment_image( $image_id, 'full', false, [ 'alt' => esc_attr( $name ), 'class' => 'w-100' ] ); ?>
						</figure>
						<div class="lqd-tm-socials lqd-overlay d-flex align-items-center justify-content-center p-4">
							<?php if($settings['list']): ?> 
							<ul class="social-icon social-icon-vertical pos-rel z-index-3 w-100">
							<?php foreach (  $settings['list'] as $item ) : ?>
								<li <?php echo 'class="elementor-repeater-item-' . esc_attr( $item['_id'] ) . '"'; ?>>
									<a href="<?php echo esc_url($item['link']['url']);?>">
									<i class="<?php echo esc_attr( $item['icon']['value'] ); ?>"></i></a>
								</li>
							<?php endforeach; ?>
							</ul>
							<?php endif; ?>
						</div>
					</div>

					<div
						class="lqd-tm-details p-4 pos-rel"
						data-custom-animations="true"
						data-ca-options='{ "triggerHandler": "inview", "animationTarget": "h3,h6", "duration": 1200, "delay": 120,  "startDelay": 500, "direction": "backward", "initValues": { "translateY": -30, "opacity": 0 }, "animations": { "translateY": 0, "opacity": 1 } }'
					>

						<div class="lqd-tm-bg lqd-overlay" data-reveal="true" data-reveal-options='{ "direction": "tb", "bgcolor": "rgba(0,0,0,0.1)", "duration": 400 }'></div>

						<h3 class="mt-0 mb-2"><?php echo esc_html( $name ); ?></h3>
						<h6 class="mt-0 mb-0"><?php echo $position; ?></h6>

					</div>
					<?php if( !empty( $member_link ) ) : ?>
						<a class="lqd-overlay" href="<?php echo $member_link ?>"></a>
					<?php endif; ?>
				<?php
				break;
				case 'lqd-tm-style-3':
				?>
					<div class="lqd-tm-img pos-rel">
						<figure>
							<?php echo wp_get_attachment_image( $image_id, 'full', false, [ 'alt' => esc_attr( $name ), 'class' => 'w-100' ] ); ?>
						</figure>
					</div>
						
					<div class="lqd-tm-details lqd-overlay d-flex flex-column align-items-center justify-content-end p-6">
						<?php if($settings['list']): ?> 
						<ul class="social-icon social-icon-vertical pos-rel z-index-3 w-100">
							<?php foreach (  $settings['list'] as $item ) : ?>
								<li <?php echo 'class="elementor-repeater-item-' . esc_attr( $item['_id'] ) . '"'; ?>>
									<a href="<?php echo esc_url($item['link']['url']);?>">
									<i class="<?php echo esc_attr( $item['icon']['value'] ); ?>"></i></a>
								</li>
							<?php endforeach; ?>
						</ul>
						<?php endif; ?>
						<div class="lqd-tm-details-inner w-100">
							<h3 class="mt-0 mb-2"><?php echo esc_html( $name ); ?></h3>
							<h6 class="mt-0 mb-0"><?php echo $position; ?></h6>
						</div>
					</div>
					<?php if( !empty( $member_link ) ) : ?>
						<a class="lqd-overlay" href="<?php echo $member_link ?>"></a>
					<?php endif; ?>
				<?php
				break;
				case 'lqd-tm-style-4':
				?>
					<div class="lqd-tm-img pos-rel">
						<figure>
							<?php echo wp_get_attachment_image( $image_id, 'full', false, [ 'alt' => esc_attr( $name ), 'class' => 'w-100' ] ); ?>
						</figure>
					</div>
						
					<div class="lqd-tm-details lqd-overlay d-flex align-items-end">
						<div class="lqd-tm-details-inner d-flex align-items-center justify-content-between w-100 ps-6 pe-6 pt-5 pb-5">
							<div class="d-flex flex-column">
								<h3 class="mt-0 mb-2"><?php echo esc_html( $name ); ?></h3>
								<h6 class="mt-0 mb-0"><?php echo $position; ?></h6>
							</div>
							<div class="lqd-tm-details-icon ms-auto">
								<i class="lqd-icn-ess icon-md-arrow-forward"></i>
							</div>
						</div>
					</div>
					<?php if( !empty( $member_link ) ) : ?>
						<a class="lqd-overlay" href="<?php echo $member_link ?>"></a>
					<?php endif; ?>
				<?php
				break;
				case 'lqd-tm-style-5':
				?>
					<div class="lqd-tm-img pos-rel">
						<figure>
							<?php echo wp_get_attachment_image( $image_id, 'full', false, [ 'alt' => esc_attr( $name ), 'class' => 'w-100' ] ); ?>
						</figure>
					</div>
						
					<div class="lqd-tm-details d-flex lqd-overlay align-items-end">
						<div class="lqd-tm-details-inner d-flex align-items-end justify-content-between w-100 p-5">
							<div class="d-flex text-vertical align-items-center">
								<h3 class="mt-0 mb-2"><?php echo esc_html( $name ); ?></h3>
								<h6 class="mt-0 mb-0"><?php echo $position; ?></h6>
							</div>
							<div class="lqd-tm-details-icon ms-auto">
								<i class="lqd-icn-ess icon-md-arrow-forward"></i>
							</div>
						</div>
					</div>
					<?php if( !empty( $member_link ) ) : ?>
						<a class="lqd-overlay" href="<?php echo $member_link ?>"></a>
					<?php endif; ?>
				<?php
				break;
			}
			?>

		</div>

		<?php
	}

}
