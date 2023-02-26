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
class LD_Icon_Box_Circle extends Widget_Base {

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
		return 'ld_icon_box_circle';
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
		return __( 'Liquid Icon Box Circle', 'archub-elementor-addons' );
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
		return 'eicon-circle-o lqd-element';
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
		return [ 'icon', 'box', 'circle' ];
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
			return [ 'jquery-vivus' ];
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

        $repeater = new Repeater();

        $repeater->add_control(
			'i_type',
			[
				'label' => __( 'Icon Library', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'fontawesome',
				'options' => [
					'fontawesome'  => __( 'Icon Library', 'archub-elementor-addons' ),
					'image' => __( 'Image', 'archub-elementor-addons' ),
				],
			]
		);

		$repeater->add_control(
			'i_icon_fontawesome',
			[
				'label' => __( 'Icon', 'archub-elementor-addons' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fa fa-star',
					'library' => 'solid',
				],
				'condition' => [
						'i_type' => 'fontawesome',
				],
			]
		);

		$repeater->add_control(
			'i_icon_image',
			[
				'label' => __( 'Image', 'archub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'condition' => [
						'i_type' => 'image',
				],
			]
		);

		$repeater->add_control(
			'image_size',
			[
				'label' => __( 'Image Size', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-ib-circ-icn img' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};object-fit: contain;',
				],
				'condition' => [
					'i_type' => 'image',
				],
			]
		);
		
		$repeater->add_control(
			'icon_size',
			[
				'label' => __( 'Icon Size', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-ib-circ-icn' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-ib-circ-icn svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'i_type' => 'fontawesome',
				],
			]
		);

		$repeater->add_control(
			'list_title', [
				'label' => __( 'Title', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'List Title' , 'archub-elementor-addons' ),
				'label_block' => true,
				'separator' => 'before',
			]
		);

		$repeater->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} h3',
			]
		);

		$repeater->add_control(
			'list_content', [
				'label' => __( 'Content', 'archub-elementor-addons' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => __( 'List Content' , 'archub-elementor-addons' ),
				'separator' => 'before',
			]
		);

		$repeater->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => __( 'Content Typography', 'archub-elementor-addons' ),
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} p',
			]
		);

		$repeater->add_control(
			'colors_heading',
			[
				'label' => __( 'Colors', 'archub-elementor-addons' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$repeater->start_controls_tabs(
			'style_tabs'
		);

		$repeater->start_controls_tab(
			'style_normal_tab',
			[
				'label' => __( 'Normal', 'archub-elementor-addons' ),
			]
		);

		$repeater->add_control(
			'icon_color',
			[
				'label' => __( 'Icon Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-ib-circ-icn span' => 'color: {{VALUE}}',
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-ib-circ-icn svg' => 'fill: {{VALUE}}',
				],
				'condition' => [
					'i_type' => 'fontawesome',
				],
			]
		);

		$repeater->add_control(
			'icon_bg_color',
			[
				'label' => __( 'Icon Background Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-ib-circ-icn span' => 'background: {{VALUE}}',
				],
				'condition' => [
					'i_type' => 'fontawesome',
				],
			]
		);

		$repeater->add_control(
			'title_color',
			[
				'label' => __( 'Title Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} h3' => 'color: {{VALUE}}',
				],
			]
		);

		$repeater->add_control(
			'content_color',
			[
				'label' => __( 'Content Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} p' => 'color: {{VALUE}}',
				],
			]
		);
		$repeater->end_controls_tab();
		$repeater->start_controls_tab(
			'style_hover_tab',
			[
				'label' => __( 'Hover', 'archub-elementor-addons' ),
			]
		);

		$repeater->add_control(
			'icon_h_color',
			[
				'label' => __( 'Icon Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-ib-circ-icn:hover span' => 'color: {{VALUE}}',
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-ib-circ-icn svg' => 'fill: {{VALUE}}',
				],
				'condition' => [
					'i_type' => 'fontawesome',
				],
			]
		);

		$repeater->add_control(
			'icon_bg_h_color',
			[
				'label' => __( 'Icon Background Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .lqd-ib-circ-icn:hover span' => 'background: {{VALUE}}',
				],
				'condition' => [
					'i_type' => 'fontawesome',
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
						'list_title' => __( 'Title #1', 'archub-elementor-addons' ),
						'list_content' => __( 'Item content. Click the edit button to change this text.', 'archub-elementor-addons' ),
					],
					[
						'list_title' => __( 'Title #2', 'archub-elementor-addons' ),
						'list_content' => __( 'Item content. Click the edit button to change this text.', 'archub-elementor-addons' ),
					],
				],
				'title_field' => '{{{ list_title }}}',
			]
		);

		$this->add_control(
			'enable_animation',
			[
				'label' => __( 'Enable 3D Animation?', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'border_color',
			[
				'label' => __( 'Border Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-ib-circ-wrap, {{WRAPPER}} .lqd-ib-circ-cnt hr' => 'border-color: {{VALUE}}',
				],
			]
		);

        $this->end_controls_section();

	}

    protected function ibc_get_animation() {
        
		if( 'yes' === $this->get_settings_for_display('enable_animation') ) {
			echo 'data-hover3d="true"';
		}

	}

    protected function ibc_get_the_icon( $i_type, $i_value, $i_image ) {

        
        $icon = isset($i_value) ? $i_value : '';
        
		if (isset($i_value['url'])){
            $icon = $i_value['url'];
		}

		if ($i_type === 'image'){
			$icon = $i_image;
		}
		
		echo '<div class="lqd-ib-circ-icn d-inline-flex lqd-overlay border-radius-circle">';
		echo '<span class="d-inline-flex align-items-center justify-content-center pos-rel">';
		
		if( ! empty( $i_type ) ) {			
			if( 'image' === $i_type || 'animated' === $i_type ) {
				$filetype = wp_check_filetype( $icon );
				if( 'svg' === $filetype['ext']) {
					$request  = wp_remote_get( $icon );
					$response = wp_remote_retrieve_body( $request );
					$svg_icon = $response;
					if( 'animated' !== $i_type ) {
						echo $svg_icon;	
					}
				} 
				else {
					printf( '<img src="%s" class="lqd-image-icon" />', esc_url( $icon ) );
				}
			}
			else {
				if ( wp_http_validate_url($icon) ){
					printf( '<img src="%s" class="lqd-image-icon" />', esc_url( $icon ) );
				} else {
					printf( '<i class="%s"></i>', esc_attr( $icon ) );
				}
			}
		}

		echo '</span>';
		echo '</div>';
        
	}

    protected function ibc_get_title( $title = '' ) {

		if( empty( $title ) ) {
			return '';
		}

		$title = sprintf( '<h3>%s</h3>', esc_html( $title ) );

		echo $title;
	}

    protected function ibc_get_content( $content = '' ) {

		if( empty( $content ) ) {
			return '';
		}

		$content = ld_helper()->do_the_content( $content );

		echo  wp_kses_post( '<hr>' . $content );
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

        <div id="icon-box-circle-<?php echo esc_attr( $this->get_id() ); ?>" class="lqd-ib-circ h-pt-100 pos-rel perspective" data-spread-incircle="true" <?php $this->ibc_get_animation(); ?>>
            <div class="lqd-ib-circ-wrap lqd-overlay transform-style-3d" data-stacking-factor="0.95">
                <div class="lqd-ib-circ-inner pos-abs">

                <?php
					if ( $settings['list'] ) {
						foreach (  $settings['list'] as $item ) { ?>
							<div class="lqd-ib-circ-item d-flex flex-column align-items-center justify-content-center pos-abs text-center elementor-repeater-item-<?php echo $item['_id'] ?> ">
							<?php
								if( isset( $item['i_icon_fontawesome']['value']) ) {
									?>
									<div class="lqd-ib-circ-icn d-inline-flex lqd-overlay border-radius-circle"><span class="d-inline-flex align-items-center justify-content-center pos-rel">
										<?php Icons_Manager::render_icon( $item['i_icon_fontawesome'], [ 'aria-hidden' => 'true' ] ); ?>
									</span></div>
									<?php
								} else {
									$this->ibc_get_the_icon($item['i_type'], null, isset($item['i_icon_image']['url']) ? $item['i_icon_image']['url'] : null);
								}
							?>

							<div class="lqd-ib-circ-cnt">
								<?php $this->ibc_get_title( $item['list_title'] ); ?>
								<?php $this->ibc_get_content( $item['list_content'] ) ?>
							</div>
							</div>
							<?php
						}
					}
                ?>
                   
                </div>
            </div>
        </div>

        <?php
   
	}

}
