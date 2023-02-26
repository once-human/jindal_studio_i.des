<?php
/**
* Shortcode Base
*/

if( !defined( 'ABSPATH' ) ) 
	exit; // Exit if accessed directly

if( !class_exists( 'Liquid_Gdpr_Shortcode' ) ) :

/**
* Liquid_Gdpr_Shortcode
*/
class Liquid_Gdpr_Shortcode extends WPBakeryShortCode {

	/**
	 * Shortcode tag.
	 * @var string
	 */
	public $slug = '';

	/**
	 * Title for human reading.
	 * @var string
	 */
	public $title = '';

	/**
	 * List of shortcode attributes. Array which holds your shortcode params, these params will be editable in shortcode settings page.
	 * @var array
	 */
	public $params = array();

	/**
	 * Category which best suites to describe functionality of this shortcode.
	 * @var string
	 */
	public $category = null;

	/**
	 * Constructor
	 */
	public function __construct() {
		// validate
		if( ! isset( $this->slug ) && empty( $this->slug ) ) {
			wp_die( esc_html__( 'Please define slug', 'liquid-gdpr' ), esc_html__( 'Variable Missing', 'liquid-gdpr' ) );
		}

		// Add shortcode
		if ( !shortcode_exists( $this->slug ) ) {
			add_shortcode( $this->slug, array(
				&$this,
				'render',
			) );
		}

		// Prepare shortcode data
		$this->prepare_params();

		// Prepare VC data
		$this->set_config();

		// Map shortcode to VC
		vc_map( $this->settings );

	}

	/**
	 * [set_config description]
	 * @method set_config
	 */
	protected function set_config() {

		$keys = array(
			'description', 'icon', 'is_container', 'js_view', 'php_class_name', 'show_settings_on_create', 'custom_markup', 'deprecated',
			'default_content', 'js_view', 'allowed_container_element', 'admin_enqueue_js', 'as_parent', 'as_child'
		);

		// Required
		$shortcode = array(
			'base' => $this->slug,
			'name' => $this->title,
			'params' => $this->params,
			'category' => ! empty( $this->category ) ? $this->category : esc_html__( 'LiquidThemes', 'liquid-gdpr' )
		);

		foreach( $keys as $key ) {

			switch( $key ) {
				case 'is_container':

					if( ! empty( $this->is_container ) ) {
						$shortcode['is_container'] = $this->is_container;
						$shortcode['js_view'] = 'VcColumnView';
					}
					else {
						$shortcode['php_class_name'] = get_class( $this );
					}

					break;

				default:
					if( ! empty( $this->{$key} ) ) {
						$shortcode[ $key ] = $this->{$key};
					}
					break;
			}
		}

		$this->settings = $shortcode;
		$this->shortcode = $this->settings['base'];
	}

	/**
	 * [get_params description]
	 * @method get_params
	 * @return [type]     [description]
	 */
	public function get_params() {

	}

	/**
	 * [prepare_params description]
	 * @method prepare_params
	 * @return [type]         [description]
	 */
	public function prepare_params() {

		// Get params to process
		$this->get_params();

		// Process now!
		foreach( $this->params as $id => &$param ) {

			if( ! isset( $param['type'] ) && isset( $param['id'] ) && ! empty( $param['id'] ) ) {
				$this->params[$id] = liquid_events()->get_param( $param['id'], $param );
			}
			elseif( 'param_group' === $param['type'] ) {

				foreach( $param['params'] as $iid => &$iparam ) {

					if( ! isset( $iparam['type'] ) && isset( $iparam['id'] ) && ! empty( $iparam['id'] ) ) {
						$param['params'][$iid] = liquid_events()->get_param( $iparam['id'], $iparam );
					}
				}
			}

			// setData
			if( ! empty( $param['data'] ) && empty( $param['value'] ) ) {
				if ( empty( $param['args'] ) ) {
                    $param['args'] = array();
                }

				$param['value'] = $this->get_wordpress_data( $param['data'], $param['args'] );
			}

			// Set description
			if( empty( $param['description'] ) && isset( $param['heading'] ) && 'subheading' != $param['type'] ) {
				$prefix = esc_html__( 'Select ', 'liquid-gdpr' );

				if( in_array( $param['type'], array( 'textarea', 'textfield', 'textarea_html' ) ) ) {
					$prefix = esc_html__( 'Enter  ', 'liquid-gdpr' );
				}

				$param['description'] = $prefix . strtolower( $param['heading'] ) . '.';
			}
		}
	}

	/**
	 * [output description]
	 * @method output
	 * @return [type] [description]
	 */
	public function render( $atts, $content = '' ) {


		$atts = $this->prepareAtts( $atts );
		$atts = vc_map_get_attributes( $this->slug, $atts );
		$atts = $this->before_output( $atts, $content );
		$atts['_id'] = uniqid( $this->slug .'_' );

		// Locate template file
		$located = $this->locate_template( $atts );

		// If no file throw error
		if ( !$located ) {
			trigger_error( sprintf( esc_html__( 'Template file is missing for `%s` shortcode. Make sure you have `%s` file in your theme folder or default folder.', 'liquid-gdpr' ), $this->title, 'view.php' ) );
			return;
		}

		$this->atts = $atts;
		$this->atts['content'] = $content;

		// Generate Output
		ob_start();

		include $located;

		return ob_get_clean();
	}

	/**
	 * [before_output description]
	 * @method before_output
	 * @param  [type]        $atts    [description]
	 * @param  [type]        $content [description]
	 * @return [type]                 [description]
	 */
	public function before_output( $atts, &$content ) {
		return $atts;
	}

	/**
	 * Locate the shortcode view file
	 * @method locate_template
	 * @param  array 	$atts
	 * @return string	return located file
	 *
	 * Shortcode file looking order
	 *
	 * Theme Directory
	 * {slug}-{atts[template]}.php
	 * {slug}-view.php
	 *
	 * Plugin Directory
	 * {atts[template]}.php
	 * view.php
	 */
	public function locate_template( $atts ) {

		$located = $template_name = false;

		// Check template in theme directory
		if( isset( $atts['template'] ) && ! empty( $atts['template'] ) ) {
			$template_name = "{$this->slug}-{$atts['template']}.php";
			$user_template = vc_shortcodes_theme_templates_dir( $template_name );

			if ( is_file( $user_template ) ) {
				$located = $user_template;
			}
		}

		if( ! $located ) {
			$template_name = "{$this->slug}-view.php";
			$user_template = vc_shortcodes_theme_templates_dir( $template_name );
			if ( is_file( $user_template ) ) {
				$located = $user_template;
			}
		}

		// Check in shortcode directory
		if( ! $located ) {

			$template_name = false;
			$path = $this->get_path();

			if( isset( $atts['template'] ) && ! empty( $atts['template'] ) ) {
				$template_name = "{$atts['template']}.php";
			}

			if( $template_name && file_exists( $path . $template_name ) ) {
				$located = $path . $template_name;
			}
			elseif( file_exists( $path . 'view.php' ) ) {
				$located = $path . 'view.php';
			}
		}

		return $located;
	}
	
	/**
	 * [get_path description]
	 * @method get_path
	 * @return [type]   [description]
	 */
	protected function get_path() {
		$rc = new ReflectionClass( get_class( $this ) );
		return trailingslashit( dirname( $rc->getFilename() ) );
	}
	
	/**
	 * [sanitize_html_classes description]
	 * @method sanitize_html_classes
	 * @return (mixed: string / $fallback ) [description]
	 */
	public function sanitize_html_classes( $class, $fallback = null ) {

		// Make it a string
		if( is_array( $class ) ) {
			$class = join( ' ', $class );
		}

		// Explode it, if it's a string
		if ( is_string( $class ) ) {
			$class = explode( ' ', $class );
		}

		$class = array_filter( $class );

		if ( is_array( $class ) && !empty( $class ) ) {
			$class = array_map( 'sanitize_html_class', $class );
			return implode( ' ', $class );
		}
		else {
			return sanitize_html_class( $class, $fallback );
		}
	}
	
/**
	 * [dynamic_css_parser description]
	 * @method dynamic_css_parser
	 * @param  [type]             $id       [description]
	 * @param  [type]             $elements [description]
	 * @return [type]                       [description]
	 */
	public function dynamic_css_parser( $id, $elements ) {
		
		$final_css = $responsive_css = '';
		foreach ( $elements as $selector => $style_array ) {

				$css = '';
				foreach ( $style_array as $property => $value ) {

					if( empty( $value ) ) {
						continue;
					}
					
					if( 'media' === $selector && ! empty( $value ) ) {
						$responsive_css .= $value;
						continue;
					}

					if ( is_array( $value ) ) {
						foreach ( $value as $sub_property => $sub_value ) {

							if( empty( $sub_value ) ) {
								continue;
							}

							if ( false !== strpos( $sub_value, 'linear-gradient' ) ) {
								$css .= ( is_string($sub_property) ? $sub_property : $property ) . ':' . '-webkit-' . $sub_value . ';';
							}

							$css .= ( is_string($sub_property) ? $sub_property : $property ) . ':' . $sub_value . ';';
						}
					} else {

						if ( false !== strpos( $value, 'linear-gradient' ) ) {
							$css .= $property . ':' . '-webkit-' . $value . ';';
						}

						$css .= $property . ':' . $value . ';';
					}
				}

			$final_css .= $css ? sprintf( $selector, $id ) . '{' . $css . '}' : '';
			$final_css .= $responsive_css ? $responsive_css : '';
		}
		
		if( $final_css ) {
			//rella_add_inline_style( $final_css );
			printf('<style>%s</style>',  $final_css );
		}
	
	}
	
	/**
	 * Helper function.
	 * Merge and combine the CSS elements
	 */
	function liquid_implode( $elements = array() ) {
	
		if ( ! is_array( $elements ) ) {
			return $elements;
		}
	
		// Make sure our values are unique
		$elements = array_unique( array_filter( $elements ) );
		// Sort elements alphabetically.
		// This way all duplicate items will be merged in the final CSS array.
		sort( $elements );
	
		// Implode items and return the value.
		return implode( ',', $elements );
	
	}	

	/**
	 *
	 * Set WPAUTOP for shortcode output
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 */
	public function do_the_content( $content, $autop = true ) {

		if ( $autop ) {
			$content = wpautop( preg_replace( '/<\/?p\>/', "\n", $content ) . "\n" );
		}

		return do_shortcode( shortcode_unautop( $content ) );
	}
	

	// Params Helpers -------------------------------------------------------
	//

	// Build the string of values in an Array
	protected function get_fonts_data( $fontsString ) {

		// Font data Extraction
		$googleFontsParam = new Vc_Google_Fonts();
		$fieldSettings = array();
		$fontsData = strlen( $fontsString ) > 0 ? $googleFontsParam->_vc_google_fonts_parse_attributes( $fieldSettings, $fontsString ) : '';
		return $fontsData;

	}

	// Build the inline style starting from the data
	protected function google_fonts_style( $fontsData ) {

        // Inline styles
		$fontFamily = explode( ':', $fontsData['values']['font_family'] );
		$styles['font-family'] = $fontFamily[0] . '!important';
		$fontStyles = explode( ':', $fontsData['values']['font_style'] );
		$styles['font-weight'] = $fontStyles[1] . '!important';
		$styles['font-style'] = $fontStyles[2] . '!important';

		/*
			$inline_style = '';
			foreach( $styles as $attribute ){
			    $inline_style .= $attribute.'; ';
			}
		*/

		return $styles;

    }

	// Enqueue right google font from Googleapis
	protected function enqueue_google_fonts( $fontsData ) {

		// Get extra subsets for settings (latin/cyrillic/etc)
		$settings = get_option( 'wpb_js_google_fonts_subsets' );
		if ( is_array( $settings ) && ! empty( $settings ) ) {
		    $subsets = '&subset=' . implode( ',', $settings );
		} else {
		    $subsets = '';
		}

		// We also need to enqueue font from googleapis
		if ( isset( $fontsData['values']['font_family'] ) ) {
		    wp_enqueue_style(
		        'vc_google_fonts_' . vc_build_safe_css_class( $fontsData['values']['font_family'] ),
		        '//fonts.googleapis.com/css?family=' . $fontsData['values']['font_family'] . $subsets
		    );
		}

	}

	/**
	 * [add_extras description]
	 * @method add_extras
	 */
	public function add_extras() {

		$this->params = array_merge( $this->params, array(

			// ID
			array(
				'type'        => 'textfield',
				'param_name'  => 'el_id',
				'heading'     => esc_html__( 'Element ID', 'liquid-gdpr' ),
				'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add unique id and then refer to it in your css file.', 'liquid-gdpr' ),
				'group'       => esc_html__( 'Extras', 'liquid-gdpr' )
			),

			// CSS
			array(
				'type'        => 'textfield',
				'param_name'  => 'el_class',
				'heading'     => esc_html__( 'Extra class name', 'liquid-gdpr' ),
				'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'liquid-gdpr' ),
				'group'       => esc_html__( 'Extras', 'liquid-gdpr' )
			)
		));
	}

	// Helpers ------------------------------------------------------------
	//

	/**
	 * [get_id description]
	 * @method get_id
	 * @param  array  $atts [description]
	 * @return [type]       [description]
	 */
	protected function get_id( $atts = array(), $custom = true ) {

		$atts = empty( $atts ) ? $this->atts : $atts;

		if( !empty( $atts['el_id'] ) ) {
			return $atts['el_id'];
		}

		if( $custom && !empty( $atts['_id'] ) ) {
			return $atts['_id'];
		}
	}
}

endif;