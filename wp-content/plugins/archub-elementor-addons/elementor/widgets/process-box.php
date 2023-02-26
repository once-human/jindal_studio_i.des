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
 * @since 1.0.0
 */
class LD_Process_Box extends Widget_Base {

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
		return 'ld_process_box';
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
		return __( 'Liquid Process Box', 'elementor' );
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
		return 'eicon-animation lqd-element';
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
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'process', 'box', 'icon' ];
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
			'processbox_section',
			[
				'label' => __( 'Process Box', 'archub-elementor-addons' ),
			]
		);

        $this->add_control(
			'style',
			[
				'label' => __( 'Style', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'style01',
				'options' => [
					'style01' => __('Style 1', 'archub-elementor-addons'),
					'style02' => __('Style 2', 'archub-elementor-addons'),
					'style03' => __('Style 3', 'archub-elementor-addons'),
					'style04' => __('Style 4', 'archub-elementor-addons'),
					'style05' => __('Style 5', 'archub-elementor-addons'),
				]
			]
		);

        $this->add_control(
			'seperator_color',
			[
				'label' => __( 'Separator Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-pb-icon-between .lqd-pb-column:not(:last-child)::after, .lqd-pb-icon-between-middle .lqd-pb-column:not(:last-child)::after' => 'color: {{VALUE}}',
				],
				'condition' => array(
					'style' => array( 'style01', 'style03' ),
				)
			]
		);


        $repeater = new Repeater();

		$repeater->add_control(
			'title', [
				'label' => __( 'Title', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'List Title' , 'archub-elementor-addons' ),
				'label_block' => true, 
			]
		);

		$repeater->add_control(
			'content', [
				'label' => __( 'Content', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => __( 'List Content' , 'archub-elementor-addons' ),
                'description' => __('Only use for: Style 1, Style 2, Style 4, Style 5', 'archub-elementor-addons'),
                'separator' => 'before',
			]
		);

        $repeater->add_control(
			'add_icon',
			[
				'label' => __( 'Add Icon or Image?', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'no',
                'separator' => 'before',
			]
		);

        $repeater->add_control(
			'icon_type',
			[
				'label' => __( 'Select Type', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'font_icon',
				'options' => [
					'font_icon' => __( 'Font Icon', 'archub-elementor-addons' ),
					'image' => __( 'Image', 'archub-elementor-addons' ),
				],
                'condition' => array(
                    'add_icon' => 'yes',
                )
			]
		);

        $repeater->add_control(
			'icon',
			[
				'label' => __( 'Icon', 'archub-elementor-addons' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-star',
					'library' => 'solid',
				],
                'condition' => array(
                    'icon_type' => 'font_icon',
                    'add_icon' => 'yes',
                )
			]
		);

        $repeater->add_control(
			'image',
			[
				'label' => __( 'Image', 'archub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
                'condition' => array(
                    'icon_type' => 'image',
                    'add_icon' => 'yes',
                )
			]
		);

        $repeater->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .lqd-pb-content h3',
                'separator' => 'before',
			]
		);

        $repeater->add_control(
			'colors_option_heading',
			[
				'label' => __( 'Colors', 'archub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        // Style Tabs
        $repeater->start_controls_tabs(
			'style_tabs'
		);

        // Normal State
		$repeater->start_controls_tab(
			'style_normal_tab',
			[
				'label' => __( 'Normal', 'archub-elementor-addons' ),
			]
		);

        $repeater->add_control(
			'title_color',
			[
				'label' => __( 'Title Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-pb-content h3' => 'color: {{VALUE}}'
				],
			]
		);

        $repeater->add_control(
			'shape_bg',
			[
				'label' => __( 'Shape Background', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-pb-active-shape' => 'background: {{VALUE}}'
				],
			]
		);

		$repeater->add_control(
			'shape_border',
			[
				'label' => __( 'Shape Border', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-pb-active-shape' => 'border-color: {{VALUE}}'
				],
			]
		);

		$repeater->add_control(
			'number_color',
			[
				'label' => __( 'Number Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-pb-active-shape, {{WRAPPER}} {{CURRENT_ITEM}} .lqd-pb-num-container' => 'color: {{VALUE}}',
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-pb-icon-arrow path' => 'fill: {{VALUE}}' 
				],
			]
		);

		$repeater->add_control(
			'icon_color',
			[
				'label' => __( 'Icon Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-pb-icon i' => 'color: {{VALUE}}',
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-pb-icon-arrow path' => 'fill: {{VALUE}}' 
				],
			]
		);

		$repeater->add_control(
			'secondary_color',
			[
				'label' => __( 'Secondary Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-pb-shape-border path' => 'stroke: {{VALUE}}'
				],
			]
		);
        
		$repeater->end_controls_tab();

        // Hover State
		$repeater->start_controls_tab(
			'style_hover_tab',
			[
				'label' => __( 'Hover', 'archub-elementor-addons' ),
			]
		);

        $repeater->add_control(
			'title_hover_color',
			[
				'label' => __( 'Title Hover Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}:hover .lqd-pb-content h3' => 'color: {{VALUE}}'
				],
			]
		);

        $repeater->add_control(
			'shape_hover_bg',
			[
				'label' => __( 'Shape Hover Background', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}:hover .lqd-pb-active-shape' => 'background: {{VALUE}}'
				],
			]
		);

        $repeater->add_control(
			'shape_hover_border',
			[
				'label' => __( 'Shape Hover Border', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}:hover .lqd-pb-active-shape' => 'border-color: {{VALUE}}'
				],
			]
		);

        $repeater->add_control(
			'number_hover_color',
			[
				'label' => __( 'Number Hover Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}:hover .lqd-pb-active-shape' => 'color: {{VALUE}}',
                    '{{WRAPPER}} {{CURRENT_ITEM}}:hover .lqd-pb-num-container' => 'color: {{VALUE}}' 
				],
			]
		);

        $repeater->add_control(
			'icon_hover_color',
			[
				'label' => __( 'Icon Hover Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}:hover .lqd-pb-icon i' => 'color: {{VALUE}}'
				],
			]
		);

		$repeater->end_controls_tab();
		$repeater->end_controls_tabs();      

		$this->add_control(
			'list',
			[
				'label' => __( 'Items', 'archub-elementor-addons' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'title' => __( 'Title #1', 'archub-elementor-addons' ),
						'content' => __( 'Item content. Click the edit button to change this text.', 'archub-elementor-addons' ),
					],
					[
						'title' => __( 'Title #2', 'archub-elementor-addons' ),
						'content' => __( 'Item content. Click the edit button to change this text.', 'archub-elementor-addons' ),
					],
				],
				'title_field' => '{{{ title }}}',
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

		$container_class = array('lqd-pb-container');
		$row_class = array('lqd-pb-row', 'row');

		switch($settings['style']){
			case 'style01':
				array_push($container_class, 'lqd-pb-nums', 'lqd-pb-icon-between');
			break;
			case 'style02':
				array_push($container_class, 'lqd-pb-nums', 'lqd-pb-zigzag');
				array_push($row_class, 'flex-column');
			break;
			case 'style03':
				array_push($container_class, 'lqd-pb-nums', 'lqd-pb-icon-between', 'lqd-pb-icon-between-middle');
			break;
			case 'style04':
				array_push($container_class, 'lqd-pb-nums', 'lqd-pb-icons');
				array_push($row_class, 'flex-column');
			break;
			case 'style05':
				array_push($container_class, 'lqd-pb-nums');
			break;
		}

		$item_index = 1;
		
		?>

		<div class="<?php echo ld_helper()->sanitize_html_classes( $container_class ); ?>">

			<div class="<?php echo ld_helper()->sanitize_html_classes( $row_class ); ?>">
			
			<?php
			switch($settings['style']){
				case 'style01':
					foreach (  $settings['list'] as $item ) {
						$items_count = count($settings['list']);
						?>
						<div class="lqd-pb-column col-md-4 elementor-repeater-item-<?php echo esc_attr( $item['_id'] ); ?>">
							<div class="lqd-pb lqd-pb-style-1 lqd-pb-shaped lqd-pb-circle text-center">
								<div class="lqd-pb-in-container lqd-pb-num-container pos-rel font-weight-bold mb-5">
									<div class="lqd-pb-in lqd-pb-active-shape d-flex border-radius-circle mx-auto pos-rel z-index-1 <?php echo esc_attr( $item['add_icon'] === 'yes' ? ' justify-content-center align-items-center' : 'lqd-pb-num' ); ?>">
										<?php Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'true' ] ); ?>
										<?php if($item['image']):?>
											<figure>
												<?php echo Group_Control_Image_Size::get_attachment_image_html( $item ); ?>
											</figure>
										<?php endif; ?>
										<div class="lqd-pb-shape-border lqd-overlay z-index-0">
											<svg class="lqd-overlay" xmlns="http://www.w3.org/2000/svg" width="127" height="126" viewBox="0 0 127 126">
												<path fill="none" stroke-dasharray="0 9.9" stroke-linecap="round" stroke-width="2.2" d="M61.5,123 C95.4655121,123 123,95.4655121 123,61.5 C123,27.5344879 95.4655121,0 61.5,0 C27.5344879,0 0,27.5344879 0,61.5 C0,95.4655121 27.5344879,123 61.5,123 Z" transform="translate(2 1)"/>
											</svg>
										</div>
									</div>
								</div>
								<div class="lqd-pb-content">
									<h3 class="font-weight-medium mt-0 mb-2 h5"><?php echo esc_html( $item['title'] ); ?></h3>
									<?php echo wp_kses_post( ld_helper()->do_the_content( $item['content'] ) ); ?>
								</div>
							</div>
							<?php if ( $item_index < $items_count ) : ?>
								<div class="lqd-pb-icon-arrow">
									<svg xmlns="http://www.w3.org/2000/svg" width="12" height="32" viewBox="0 0 12 32" style="width: 1em; height: 1em;"><path fill="currentColor" d="M8.375 16L.437 8.062C-.125 7.5-.125 6.5.438 5.938s1.563-.563 2.126 0l9 9c.562.562.624 1.5.062 2.062l-9.063 9.063c-.312.312-.687.437-1.062.437s-.75-.125-1.063-.438c-.562-.562-.562-1.562 0-2.125z"></path></svg>
								</div>
							<?php endif; ?>
						</div>
						<?php
						$item_index++;
					}
				break;
				case 'style02':
					foreach (  $settings['list'] as $item ) {
						?>
						<div class="lqd-pb-column col-sm-6 elementor-repeater-item-<?php echo esc_attr( $item['_id'] ); ?>">
							<div class="lqd-pb lqd-pb-style-2 lqd-pb-shaped lqd-pb-circle d-flex">
								<div class="lqd-pb-in-container lqd-pb-num-container pos-rel">
									<div class="lqd-pb-in lqd-pb-active-shape d-flex border-radius-circle pos-rel z-index-1 <?php echo esc_attr( $item['add_icon'] === 'yes' ? ' justify-content-center align-items-center' : 'lqd-pb-num' ); ?>">
										<?php Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'true' ] ); ?>
										<?php if($item['image']):?>
											<figure>
												<?php echo Group_Control_Image_Size::get_attachment_image_html( $item ); ?>
											</figure>
										<?php endif; ?>
										<div class="lqd-pb-shape-border lqd-overlay z-index-0">
											<svg class="lqd-overlay" xmlns="http://www.w3.org/2000/svg" width="127" height="126" viewBox="0 0 127 126">
												<path fill="none" stroke-dasharray="0 9.9" stroke-linecap="round" stroke-width="2.2" d="M61.5,123 C95.4655121,123 123,95.4655121 123,61.5 C123,27.5344879 95.4655121,0 61.5,0 C27.5344879,0 0,27.5344879 0,61.5 C0,95.4655121 27.5344879,123 61.5,123 Z" transform="translate(2 1)"/>
											</svg>
										</div>
									</div>
								</div>
								<div class="lqd-pb-content">
									<h3 class="h5"><?php echo esc_html( $item['title'] ); ?></h3>
									<?php echo wp_kses_post( ld_helper()->do_the_content( $item['content'] ) ); ?>
								</div>
							</div>
						</div>
						<?php
					}
				break;
				case 'style03':
					foreach (  $settings['list'] as $item ) {
						$items_count = count($settings['list']);
						?>
						<div class="lqd-pb-column col-md-4 elementor-repeater-item-<?php echo esc_attr( $item['_id'] ); ?>">
							<div class="lqd-pb lqd-pb-style-3 lqd-pb-shaped lqd-pb-circle d-flex align-items-center justify-content-center">
								<div class="lqd-pb-in-container lqd-pb-num-container pos-rel">
									<div class="lqd-pb-in lqd-pb-active-shape d-flex border-radius-circle pos-rel z-index-1 <?php echo esc_attr( $item['add_icon'] === 'yes' ? ' justify-content-center align-items-center' : 'lqd-pb-num' ); ?>">
										<?php Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'true' ] ); ?>
										<?php if($item['image']):?>
											<figure>
												<?php echo Group_Control_Image_Size::get_attachment_image_html( $item ); ?>
											</figure>
										<?php endif; ?>
									</div>
								</div>
								<div class="lqd-pb-content">
									<h3 class="mt-0 mb-0 h5"><?php echo esc_html( $item['title'] ); ?></h3>
								</div>
							</div>
							<?php if ( $item_index < $items_count ) : ?>
								<div class="lqd-pb-icon-arrow">
									<svg xmlns="http://www.w3.org/2000/svg" width="12" height="32" viewBox="0 0 12 32" style="width: 1em; height: 1em;"><path fill="#2c2e30" d="M8.375 16L.437 8.062C-.125 7.5-.125 6.5.438 5.938s1.563-.563 2.126 0l9 9c.562.562.624 1.5.062 2.062l-9.063 9.063c-.312.312-.687.437-1.062.437s-.75-.125-1.063-.438c-.562-.562-.562-1.562 0-2.125z"></path></svg>
								</div>
							<?php endif; ?>
						</div>
						<?php
						$item_index++;
					}
				break;
				case 'style04':
					foreach (  $settings['list'] as $item ) {
						?>
						<div class="lqd-pb-column col-md-12 elementor-repeater-item-<?php echo esc_attr( $item['_id'] ); ?>">
							<div class="lqd-pb lqd-pb-style-4 lqd-pb-shaped lqd-pb-circle d-flex">
								<div class="lqd-pb-in-container lqd-pb-icon-container pos-rel">
									<div class="lqd-pb-in lqd-pb-icon lqd-pb-active-shape d-flex align-items-center justify-content-center border-radius-circle pos-rel z-index-1">
										<?php Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'true' ] ); ?>
										<?php if($item['image']):?>
											<figure>
												<?php echo Group_Control_Image_Size::get_attachment_image_html( $item ); ?>
											</figure>
										<?php endif; ?>
									</div>
									<div class="lqd-pb-in-container lqd-pb-num-container pos-rel">
										<div class="lqd-pb-in lqd-pb-num lqd-pb-active-shape d-flex border-radius-circle pos-rel z-index-1"></div>
									</div>
								</div>
								<div class="lqd-pb-content pos-rel">
									<h3 class="mt-0 mb-3 h5"><?php echo esc_html( $item['title'] ); ?></h3>
									<?php echo wp_kses_post( ld_helper()->do_the_content( $item['content'] ) ); ?>
								</div>
							</div>
						</div>
						<?php
					}
				break;
				case 'style05':
					foreach (  $settings['list'] as $item ) {
						?>
						<div class="lqd-pb-column col-md-3 col-sm-6 elementor-repeater-item-<?php echo esc_attr( $item['_id'] ); ?>">
							<div class="lqd-pb lqd-pb-style-5 lqd-pb-shaped lqd-pb-circle text-center">
								<div class="lqd-pb-in-container lqd-pb-num-container pos-rel mb-4">
									<div class="lqd-pb-in lqd-pb-active-shape d-flex mx-auto border-radius-circle pos-rel z-index-1 <?php echo esc_attr( $item['add_icon'] === 'yes' ? ' justify-content-center align-items-center' : 'lqd-pb-num' ); ?>">
									<?php Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'true' ] ); ?>
										<?php if($item['image']):?>
											<figure>
												<?php echo Group_Control_Image_Size::get_attachment_image_html( $item ); ?>
											</figure>
										<?php endif; ?>
									</div>
								</div>
								<div class="lqd-pb-content">
									<h3 class="mt-0 mb-3 h5"><?php echo esc_html( $item['title'] ); ?></h3>
									<?php echo wp_kses_post( ld_helper()->do_the_content( $item['content'] ) ); ?>
								</div>
							</div>
						</div>
						<?php
					}
				break;
			}
			?>

			</div>

		</div>

		<?php

	}

}
