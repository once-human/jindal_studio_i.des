<?php
/**
* Shortcode Schedule Table
*/

if( !defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly
	
/**
* LE_Shortcode
*/
class LD_Gdpr_Box extends Liquid_Gdpr_Shortcode {

	/**
	 * Construct
	 * @method __construct
	 */
	public function __construct() {

		// Properties
		$this->slug            = 'ld_gdpr_box';
		$this->title           = esc_html__( 'GDPR Box', 'liquid-gdpr' );
		$this->description     = esc_html__( 'Add GDPR Box', 'liquid-events' );
		$this->icon            = 'fa fa-calendar-plus-o';

		parent::__construct();
	}

	public function get_params() {
		
		$this->params = array(
			
			array(
				'type'       => 'textarea_html',
				'param_name' => 'content',
				'heading'    => esc_html__( 'Text', 'liquid-events' ),
				'holder'     => 'div'
			),
			array(
				'type'       => 'textfield',
				'param_name' => 'accept_text',
				'heading'    => esc_html__( 'Accept Button Text', 'liquid-events' ),
			),
		);

		$this->add_extras();
	}
	
	protected function get_image() {

		// check value
		if( empty( $this->atts['image'] ) ) {
			return;
		}

		$img_src = $image = '';
		$alt = get_post_meta( $this->atts['image'], '_wp_attachment_image_alt', true );

		$image = wp_get_attachment_image( $this->atts['image'], 'full', false, array( 'alt' => esc_html( $alt ) , 'class' => 'w-100') );
		
		echo $image;

	}
	
	protected function generate_css() {

		$elements = array();
		extract( $this->atts );
		$id = '.' .$this->get_id();

		$this->dynamic_css_parser( $id, $elements );
	}

}
new LD_Gdpr_Box;