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
class LD_Mask_Slider extends Widget_Base {

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
		return 'ld_mask_slider';
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
		return __( 'Liquid Mask Slider', 'archub-elementor-addons' );
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
		return 'eicon-slider-push lqd-element';
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
		return [ 'slider', 'mask', 'asymmetric', 'slideshow' ];
	}

	/**
	 * Retrieve the list of scripts the widget depended on.
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
      return ['jquery', 'liquid-switch-active'];
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
			array(
				'label' => __( 'General', 'archub-elementor-addons' ),
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'slide_images',
			[
				'label' => __( 'Slide images', 'archub-elementor-addons' ),
				'type' => \Elementor\Controls_Manager::GALLERY,
				'default' => [],
			]
		);

    $repeater->add_control(
			'images_widths',
			[
				'label' => __( 'Images widths', 'archub-elementor-addons' ),
				'description' => __( 'Set width for each image in the gallery in percentage. Separate by comma. E.g. if you have 2 images you can enter 50, 50. Which means 50% for each image.', 'archub-elementor-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( '50, 50', 'archub-elementor-addons' ),
			]
		);

		$this->add_control(
			'identities',
			[
				'label' => __( 'Items', 'archub-elementor-addons' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'label_block' => true,
			]
		);

		$this->add_responsive_control(
			'slider_height',
			[
				'label' => __( 'Height', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vh' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'vh' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 50,
				],
        'selectors' => [
          '{{WRAPPER}} .lqd-mask-slider-slides' => 'padding-top: {{SIZE}}{{UNIT}};',
        ],
			]
		);

		$this->add_control(
			'slider_duration',
			[
				'label' => __( 'Duration ( In seconds )', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 60,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 4,
				],
			]
		);

		$this->end_controls_section();

	}

  protected function get_slide_images($images, $widths) {

    $widths_array = explode(',', $widths);

    $i = 0;

    foreach ( $images as $image ) {

      $width = 100 / count($images);

      if ( isset($widths_array[$i]) && !empty($widths_array[$i]) ) {
        $width = $widths_array[$i];
      }

      $i++;

      $width_css = 'width: ' . $width . '%;';

    ?>
      <div class="lqd-mask-slider-img-wrap h-100 pos-rel overflow-hidden" style="<?php echo esc_attr($width_css) ?>">
        <div class="lqd-mask-slider-movin-part lqd-mask-slider-img-inner lqd-overlay overflow-hidden">
          <figure class="lqd-mask-slider-movin-part lqd-mask-slider-fig lqd-overlay overflow-hidden">
            <?php echo wp_get_attachment_image( $image['id'], 'full', false, [ 'class' => 'lqd-mask-slider-movin-part lqd-mask-slider-img w-100 h-100 objfit-cover objfit-center' ] ); ?>
          </figure>
        </div>
      </div>
    <?php }

  }

  protected function get_slides() {

    $settings = $this->get_settings_for_display();
		
		$identities = $settings['identities'];
		
		foreach ( $identities as $item ) { ?>
      <div class="lqd-mask-slider-slide d-flex lqd-overlay">
        <?php $this->get_slide_images( $item['slide_images'], $item['images_widths'] ); ?>
      </div>
    <?php }
		
	}

  protected function get_switch_options() {

    $settings = $this->get_settings_for_display();

    $duration = $settings['slider_duration']['size'];
		
		$opts = array(
			"waitForInview" => true,
      "prevClasses" => ["lqd-mask-slider-slide-active", "lqd-mask-slider-slide-prev"],
      "activeClasses" => ["lqd-mask-slider-slide-active", "lqd-mask-slider-slide-current", "z-index-2"],
      "nextClasses" => ["lqd-mask-slider-slide-next"],
      "duration" => $duration,
		);

		return wp_json_encode( $opts );
		
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
		
		$identities = $settings['identities'];

		if( empty( $identities ) )
			return;

		$this->add_render_attribute(
		'slides_attrs',
		[
			'class' => [ 
				'lqd-mask-slider-slides',
				'pos-rel',
				'overflow-hidden',
			],
			'data-lqd-switch-active' => 'true',
			'data-switch-options' => $this->get_switch_options(),
		]
		);

		?>

		<div <?php echo $this->get_render_attribute_string( 'slides_attrs' ); ?>>
			<?php
				$this->get_slides();
				// for loop bug fix
				if ( count( $identities ) <= 2 ) {
					$this->get_slides();
				}
			?>
		</div>
		
	<?php

	}

}
