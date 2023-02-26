<?php

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if( class_exists( 'Typekit' ) ) {
	
	class Liquid_Elementor_Typekit extends Typekit {

		/**
		 * [$params description]
		 * @var string
		 */
		private $typekit_id = null;
	
		/**
		 * [$params description]
		 * @var array
		 */
		private $typekit_fonts = null;
	
		/**
		 * [__construct description]
		 * @method __construct
		 */
		function __construct() {

			add_action( 'redux/loaded', [ $this, 'get_typekit_options' ] );
            // Add Group Fonts
			add_filter( 'elementor/fonts/additional_fonts', [ $this, 'get_typekit_fonts_array' ] );
	
		}
		

		/**
		 * get_typekit_options get values of the typekit theme options
		 * @return none
		 */
		function get_typekit_options() {

			global $liquid_options;

			$this->typekit_id  = isset( $liquid_options['typekit_id'] ) ? $liquid_options['typekit_id'] : null;

			$this->typekit_fonts = $this->get_typekit_fonts_array( $this->typekit_id );
		}
		

		/**
		 * get_typekit_fonts_array
		 * 
		 * @param  string $kit_id optional
		 * @return [arr] fonts array
		 */
		function get_typekit_fonts_array( $kit_id = false ) {

			$force 	= $kit_id !== false ? true : false;
			$kit_id = $kit_id ? $kit_id : $this->typekit_id;

			if ( !$kit_id ) {
				return array();
			}
			
			if ( $force ) {
				$kit = $this->get( $kit_id );			
			}
			
			$ret = array();

			if ( isset( $kit['kit']['families'] ) ) {
                // Add Fonts Group
                add_filter( 'elementor/fonts/groups', function( $font_groups ) {
                    $font_groups['liquid_typekit_fonts'] = __( 'Typekit Fonts' );
                    return $font_groups;
                } );

                
				foreach ( $kit['kit']['families'] as $family ) {
					
					if( isset( $family['css_names'][0] ) ) {
						$slug = $family['css_names'][0];	
					} else {
						$slug = $family['slug'];
					}

                    $ret[$family['slug']] = 'liquid_typekit_fonts';
				}

                //print_r($ret);
				
				return $ret;
			} else {
				return false;
			}
		}
	
	}

	new Liquid_Elementor_Typekit;

}