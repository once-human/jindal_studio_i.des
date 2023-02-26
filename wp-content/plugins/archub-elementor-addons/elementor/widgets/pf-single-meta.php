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
class LD_Pf_Single_Meta extends Widget_Base {

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
		return 'ld_single_portfolio_meta';
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
		return __( 'Liquid Portfolio Single Meta', 'archub-elementor-addons' );
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
		return 'eicon-meta-data lqd-element';
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
		return [ 'portfolio', 'meta' ];
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
			array(
				'label' => __( 'General', 'archub-elementor-addons' ),
			)
		);

        
		$this->add_control(
			'columns',
			[
				'label' => __( 'Columns', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 3,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 2,
				],
				'selectors' => [
					'{{WRAPPER}} .lqd-pf-single-meta-part' => 'width: calc(100% / {{SIZE}});',
				],
				'render_type' => 'template',
			]
		);

        $this->add_control(
			'color',
			[
				'label' => __( 'Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .lqd-pf-single-meta-part' => 'color: {{VALUE}}',
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

        ?>

        
            <div class="lqd-pf-single-meta d-flex flex-wrap justify-content-between <?php echo esc_attr( 'columns-'.$settings['columns']['size'] ); ?>">
                <?php $this->get_pf_single_meta(); ?>
            </div>

                        
        <?php


	}

    public function get_pf_single_meta() {

		$page_settings_manager = \Elementor\Core\Settings\Manager::get_settings_managers( 'page' );
		$page_settings_model = $page_settings_manager->get_model( get_the_ID() );
		$atts = explode("\n", str_replace("\r", "", $page_settings_model->get_settings( 'portfolio_attributes' )));
		
		if( !is_array( $atts ) ) {
			return;
		}
		
		$out = '';

		$settings = $this->get_settings_for_display();
		$part_classnames = array(
			'lqd-pf-single-meta-part',
			isset($settings['columns']['size']) && $settings['columns']['size'] == 1 ? 'd-flex align-items-center justify-content-between' : '',
		);
		
		foreach ( $atts as $attr ) {
	
			if( !empty( $attr ) ) {
				$attr = explode( "|", $attr );
				$label = isset( $attr[0] ) ? $attr[0] : '';
				$value = isset( $attr[1] ) ? $attr[1] : $label;	
				
				$out .= '<div class="' . ld_helper()->sanitize_html_classes( $part_classnames ) . '">';
				if( $label ) { 
					$out .= '<p class="mt-0 mb-0">' . esc_html( $label ) . '</p>';	
				}
				$out .= '<p class="mt-0 mb-0">'. do_shortcode( $value ) . '</p>';
				$out .= '</div>';
			}
		}
		
		echo $out;
	}

}
