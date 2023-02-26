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
class LD_Header_Image extends Widget_Base {

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
		return 'ld_header_image';
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
		return __( 'Liquid Site Logo', 'archub-elementor-addons' );
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
		return 'eicon-site-logo lqd-element';
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
		return [ 'hub-header' ];
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
		return [ 'header', 'logo', 'image' ];
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
				'label' => __( 'Logo', 'archub-elementor-addons' ),
			)
		);

		$this->add_control(
			'logo_redirect_info',
			[
				'type' => Controls_Manager::RAW_HTML,
				'raw' => sprintf( __( 'Go to the <strong><u>Elementor Site Settings > Site Identity</u></strong> to add your logo.', 'archub-elementor-addons' ) ),
				'separator' => 'after',
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			]
		);

		$this->add_control(
			'uselogo',
			[
				'label' => __( 'Use Logo From Site Settings?', 'archub-elementor-addons' ),
				'description' => __( 'Use logo set in elementor site settings panel', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'image',
			[
				'label' => __( 'Choose Image', 'archub-elementor-addons' ),
				'description' => __( 'Add image from gallery or upload new', 'archub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'condition' => array(
					'uselogo' => ''
				)
			]
		);

		$this->add_control(
			'retina_image',
			[
				'label' => __( 'Retina Image', 'archub-elementor-addons' ),
				'description' => __( 'Add retina image from gallery or upload new', 'archub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'condition' => array(
					'uselogo' => ''
				)
			]
		);

		$this->add_control(
			'hover_image',
			[
				'label' => __( 'Hover image', 'archub-elementor-addons' ),
				'description' => __( 'Add image from gallery or upload new', 'archub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'condition' => array(
					'uselogo' => ''
				)
			]
		);

		$this->add_control(
			'retina_hover_image',
			[
				'label' => __( 'Retina hover image', 'archub-elementor-addons' ),
				'description' => __( 'Add retina image from gallery or upload new', 'archub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'condition' => array(
					'uselogo' => ''
				)
			]
		);

		$this->add_control(
			'light_image',
			[
				'label' => __( 'Light Image', 'archub-elementor-addons' ),
				'description' => __( 'Add image from gallery or upload new', 'archub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'condition' => array(
					'uselogo' => ''
				)
			]
		);

		$this->add_control(
			'retina_light_image',
			[
				'label' => __( 'Retina Light Image', 'archub-elementor-addons' ),
				'description' => __( 'Add retina image from gallery or upload new', 'archub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'condition' => array(
					'uselogo' => ''
				)
			]
		);

		$this->add_control(
			'dark_image',
			[
				'label' => __( 'Dark Image', 'archub-elementor-addons' ),
				'description' => __( 'Add retina image from gallery or upload new', 'archub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'condition' => array(
					'uselogo' => ''
				)
			]
		);

		$this->add_control(
			'retina_dark_image',
			[
				'label' => __( 'Retina Dark Image', 'archub-elementor-addons' ),
				'description' => __( 'Add retina image from gallery or upload new', 'archub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'condition' => array(
					'uselogo' => ''
				)
			]
		);
		
		$this->add_control(
			'linkhome',
			[
				'label' => __( 'Link to homepage?', 'archub-elementor-addons' ),
				'description' => __( 'Link the logo to homepage', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'link',
			[
				'label' => __( 'Link', 'archub-elementor-addons' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'archub-elementor-addons' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
				'condition' => array(
					'linkhome' => ''
				)
			]
		);

		$this->add_control(
			'sticky_show_onsticky',
			[
				'label' => __( 'Show Only on Sticky?', 'archub-elementor-addons' ),
				'description' => __( 'Enable if you want the logo to show when header is sticky.', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'usestickylogo',
			[
				'label' => __( 'Use Sticky Logo From Site Settings?', 'archub-elementor-addons' ),
				'description' => __( 'Use sticky logo set in site settings panel', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'sticky_image',
			[
				'label' => __( 'Sticky Image', 'archub-elementor-addons' ),
				'description' => __( 'Add image from gallery or upload new', 'archub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'condition' => array(
					'usestickylogo' => ''
				)
			]
		);

		$this->add_control(
			'retina_sticky_image',
			[
				'label' => __( 'Retina Sticky Image', 'archub-elementor-addons' ),
				'description' => __( 'Add retina image from gallery or upload new', 'archub-elementor-addons' ),
				'type' => Controls_Manager::MEDIA,
				'condition' => array(
					'usestickylogo' => ''
				)
			]
		);

		$this->add_control(
			'useshapelogo',
			[
				'label' => __( 'Use Shape for Logo?', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'archub-elementor-addons' ),
				'label_off' => __( 'Off', 'archub-elementor-addons' ),
				'return_value' => 'navbar-brand-solid',
				'default' => '',
			]
		);
		
		$this->add_control(
			'shape_logo_style',
			[
				'label' => __( 'Shape Logo Style', 'archub-elementor-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Default', 'archub-elementor-addons' ),
					'navbar-brand-round' => __( 'Round', 'archub-elementor-addons' ),
					'navbar-brand-circle' => __( 'Circle', 'archub-elementor-addons' ),
				],
				'condition' => array(
					'useshapelogo' => 'navbar-brand-solid'
				)
			]
		);

		$this->add_control(
			'shape_color',
			[
				'label' => __( 'Shape Color', 'archub-elementor-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .navbar-brand-inner' => 'background: {{VALUE}}',
				],
				'condition' => array(
					'useshapelogo' => 'navbar-brand-solid'
				)
			]
		);

		$this->add_control(
			'custom_dimension',
			[
				'label' => esc_html__( 'Logo Dimension', 'archub-elementor-addons' ),
				'type' => Controls_Manager::IMAGE_DIMENSIONS,
				'description' => esc_html__( 'Crop the original image size to any custom size. Set custom width or height to keep the original size ratio.', 'archub-elementor-addons' ),
				'default' => [
					'width' => '',
					'height' => '',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'padding',
			[
				'label' => __( 'Logo Padding', 'archub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .module-logo' => 'padding-top: {{TOP}}{{UNIT}};padding-inline-end:{{RIGHT}}{{UNIT}};padding-bottom:{{BOTTOM}}{{UNIT}};padding-inline-start:{{LEFT}}{{UNIT}};',
				],
				'default' => [
					'top' => '30',
					'right' => '0',
					'bottom' => '30',
					'left' => '0',
					'isLinked' => false,
					'unit' => 'px'
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'sticky_padding',
			[
				'label' => __( 'Sticky Logo Padding', 'archub-elementor-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'.is-stuck {{WRAPPER}} .module-logo' => 'padding-top: {{TOP}}{{UNIT}};padding-inline-end:{{RIGHT}}{{UNIT}};padding-bottom:{{BOTTOM}}{{UNIT}};padding-inline-start:{{LEFT}}{{UNIT}};',
				],
				'default' => [
					'top' => '30',
					'right' => '0',
					'bottom' => '30',
					'left' => '0',
					'isLinked' => false,
					'unit' => 'px'
				],
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

		$classes = array(
			'module-logo',
			'd-flex',
			$settings['sticky_show_onsticky'],
			$settings['shape_logo_style'],
			$this->get_shape(),
		);
	
		?>
		
		<div class="<?php echo ld_helper()->sanitize_html_classes( $classes ) ?>">

			<?php $this->get_logo(); ?>
			
		</div>

		<?php
	}

	protected function get_shape() {
		
		$settings = $this->get_settings_for_display();

		$classname = 'navbar-brand-plain';

		if ( 'navbar-brand-solid' === $settings['useshapelogo'] ) {
			$classname = 'navbar-brand-solid';
		}

		return $classname;

	}

	protected function get_logo() {

		$global_settings = \Elementor\Plugin::$instance->kits_manager->get_active_kit_for_frontend()->get_settings_for_display();
		
		$image        = $this->get_image();
		$hover_image	= $this->get_hover_image();
		$sticky_image = $this->get_sticky_image();
		
		$light_image  = $this->get_light_image();
		$dark_image   = $this->get_dark_image();

		if( empty( $image ) ) {
			return;
		}
		
		if( !empty( $mobile_logo ) ) {
			$image = $mobile_logo . $image;
		}
		
		$href = esc_url( home_url( '/' ) );
		
		if( isset( $this->get_settings_for_display('link')['url'] ) && !$settings['linkhome'] ) {
			$href = $this->get_settings_for_display('link')['url'];	
		}
		
		printf( '<a class="navbar-brand d-flex p-0 pos-rel" href="%s" rel="home"><span class="navbar-brand-inner post-rel">%s %s %s %s %s</span></a>', $href, $light_image, $dark_image, $hover_image, $sticky_image, $image ) ;
		
	}

	protected function get_image() {

		$global_settings = \Elementor\Plugin::$instance->kits_manager->get_active_kit_for_frontend()->get_settings_for_display();

		$settings = $this->get_settings_for_display();
		
		$src         = get_template_directory_uri() . '/assets/img/logo/logo-dark.svg';
		$retina_src  = $scrset = '';
		
		$logo = $settings['image'];
		$retina_logo = $settings['retina_image'];
		
		if( $settings['uselogo'] ) {
			$img_array    = $global_settings['header_logo'];
			$retina_array = $global_settings['header_logo_retina'];
			
			if( is_array( $img_array ) && !empty( $img_array['url'] ) ) {
				$src = esc_url( $img_array['url'] );
			}
			
			if( is_array( $retina_array ) && !empty( $retina_array['url'] ) ) {
				$retina_src = esc_url( $retina_array['url'] );
			}
			else {
				$retina_src = '';
			}
		}
		else {
			if( $logo ) {
				$src = $logo['url'];
			}
			if( $retina_logo ) {
				$retina_src = $retina_logo['url'];
			}
		}
		
		$alt = get_bloginfo( 'title' );
		$image_opts = array(
			'class' => 'logo-default',
			'alt' => esc_attr( $alt ),
		);

		if( !empty( $retina_src ) ) {
			$scrset = 'srcset="' . $retina_src . ' 2x"';
		}

		$ratio = $this->custom_image_dimension( $settings['custom_dimension']['width'], $settings['custom_dimension']['height'] );
		$image = sprintf( '<img class="logo-default" src="%s" alt="%s" %s %s />', $src, $alt, $scrset, $ratio );
		
		return $image;

	}

	protected function get_sticky_image() {

		$settings = $this->get_settings_for_display();
		$global_settings = \Elementor\Plugin::$instance->kits_manager->get_active_kit_for_frontend()->get_settings_for_display();
	
		$src = $retina_src  = $scrset = $image = '';
		
		$logo = $settings['sticky_image'];
		$retina_logo = $settings['retina_sticky_image'];

		if( $settings['usestickylogo'] ) {
			$img_array    = $global_settings['header_sticky_logo'];
			$retina_array = $global_settings['header_sticky_logo_retina'];
			
			if( is_array( $img_array ) && !empty( $img_array['url'] ) ) {
				$src = esc_url( $img_array['url'] );
			}
			
			if( is_array( $retina_array ) && !empty( $retina_array['url'] ) ) {
				$retina_src = esc_url( $retina_array['url'] );
			}
			else {
				$retina_src = '';
			}
		}
		else {
			if( $logo ) {
				$src = $logo['url'];
			}
			if( $retina_logo ) {
				$retina_src = $retina_logo['url'];
			}
		}
		
		$alt = get_bloginfo( 'title' );
		$image_opts = array(
			'class' => 'logo-sticky',
			'alt' => esc_attr( $alt ),
		);

		if( !empty( $retina_src ) ) {
			$scrset = 'srcset="' . $retina_src . ' 2x"';
		}

		if( !empty( $src ) ) {
			$ratio = $this->custom_image_dimension( $settings['custom_dimension']['width'], $settings['custom_dimension']['height'] );
			$image = sprintf( '<img class="logo-sticky" src="%s" alt="%s" %s %s />', $src, $alt, $scrset, $ratio );	
		}
		
		return $image;
		
	}

	protected function get_hover_image() {
		
		$settings = $this->get_settings_for_display();
		$global_settings = \Elementor\Plugin::$instance->kits_manager->get_active_kit_for_frontend()->get_settings_for_display();
	
		$src = $retina_src  = $scrset = $image = '';
		
		$logo = $settings['hover_image'];
		$retina_logo = $settings['retina_hover_image'];

		if( $settings['uselogo'] ) {
			$img_array    = $global_settings['hover_header_logo'];
			$retina_array = $global_settings['hover_header_logo_retina'];
			
			if( is_array( $img_array ) && !empty( $img_array['url'] ) ) {
				$src = esc_url( $img_array['url'] );
			}
			
			if( is_array( $retina_array ) && !empty( $retina_array['url'] ) ) {
				$retina_src = esc_url( $retina_array['url'] );
			}
			else {
				$retina_src = '';
			}
		}
		else {
			if( $logo ) {
				$src = $logo['url'];
			}
			if( $retina_logo ) {
				$retina_src = $retina_logo['url'];
			}
		}
		
		$alt = get_bloginfo( 'title' );
		$image_opts = array(
			'class' => 'logo-sticky',
			'alt' => esc_attr( $alt ),
		);

		if( !empty( $retina_src ) ) {
			$scrset = 'srcset="' . $retina_src . ' 2x"';
		}
		
		if( !empty( $src ) ) {
			$ratio = $this->custom_image_dimension( $settings['custom_dimension']['width'], $settings['custom_dimension']['height'] );
			$image = sprintf( '<span class="navbar-brand-hover lqd-overlay d-flex align-items-center justify-content-center"><span class="navbar-brand-hover-inner d-inline-flex align-items-center justify-content-center flex-grow-1"><img class="logo-default" src="%s" alt="%s" %s %s /></span></span>', $src, $alt, $scrset, $ratio );	
		}
		
		return $image;

	}

	protected function get_light_image() {

		$settings = $this->get_settings_for_display();
		$global_settings = \Elementor\Plugin::$instance->kits_manager->get_active_kit_for_frontend()->get_settings_for_display();
	
		$src = $retina_src  = $scrset = $image = '';
		
		$logo = $settings['light_image'];
		$retina_logo = $settings['retina_light_image'];

		if( $settings['uselogo'] ) {
			$img_array    = $global_settings['header_light_logo'];
			$retina_array = $global_settings['header_light_logo_retina'];
			
			if( is_array( $img_array ) && !empty( $img_array['url'] ) ) {
				$src = esc_url( $img_array['url'] );
			}
			
			if( is_array( $retina_array ) && !empty( $retina_array['url'] ) ) {
				$retina_src = esc_url( $retina_array['url'] );
			}
			else {
				$retina_src = '';
			}
		}
		else {
			if( $logo ) {
				$src = $logo['url'];
			}
			if( $retina_logo ) {
				$retina_src = $retina_logo['url'];
			}
		}
		
		$alt = get_bloginfo( 'title' );
		$image_opts = array(
			'class' => 'logo-sticky',
			'alt' => esc_attr( $alt ),
		);

		if( !empty( $retina_src ) ) {
			$scrset = 'srcset="' . $retina_src . ' 2x"';
		}

		if( !empty( $src ) ) {
			$ratio = $this->custom_image_dimension( $settings['custom_dimension']['width'], $settings['custom_dimension']['height'] );
			$image = sprintf( '<img class="logo-light pos-abs" src="%s" alt="%s" %s %s />', $src, $alt, $scrset, $ratio );	
		}
		
		return $image;
		
	}
	
	protected function get_dark_image() {

		$settings = $this->get_settings_for_display();
		$global_settings = \Elementor\Plugin::$instance->kits_manager->get_active_kit_for_frontend()->get_settings_for_display();
	
		$src = $retina_src  = $scrset = $image = '';
		
		$logo = $settings['dark_image'];
		$retina_logo = $settings['retina_dark_image'];

		if( $settings['uselogo'] ) {
			$img_array    = $global_settings['header_dark_logo'];
			$retina_array = $global_settings['header_dark_logo_retina'];
			
			if( is_array( $img_array ) && !empty( $img_array['url'] ) ) {
				$src = esc_url( $img_array['url'] );
			}
			
			if( is_array( $retina_array ) && !empty( $retina_array['url'] ) ) {
				$retina_src = esc_url( $retina_array['url'] );
			}
			else {
				$retina_src = '';
			}
		}
		else {
			if( $logo ) {
				$src = $logo['url'];
			}
			if( $retina_logo ) {
				$retina_src = $retina_logo['url'];
			}
		}
		
		$alt = get_bloginfo( 'title' );
		$image_opts = array(
			'class' => 'logo-sticky',
			'alt' => esc_attr( $alt ),
		);

		if( !empty( $retina_src ) ) {
			$scrset = 'srcset="' . $retina_src . ' 2x"';
		}

		if( !empty( $src ) ) {
			$ratio = $this->custom_image_dimension( $settings['custom_dimension']['width'], $settings['custom_dimension']['height'] );
			$image = sprintf( '<img class="logo-dark pos-abs" src="%s" alt="%s" %s %s />', $src, $alt, $scrset, $ratio );	
		}
		
		return $image;
		
	}

	protected function custom_image_dimension( $width, $height ) {

		if ( empty( $width ) && empty( $height ) ) {
			return;
		}

		$ratio = esc_attr("width={$width} height={$height}");

		return $ratio;

	}
	

}
