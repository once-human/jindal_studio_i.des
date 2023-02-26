<?php
/**
* Liquid Themes Theme Framework
* The Liquid_Admin_Dashboard base class
*/

if( !defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly

class Liquid_Admin_About extends Liquid_Admin_Page {

	/**
	 * [__construct description]
	 * @method __construct
	 */
	public function __construct() {

		$this->id = 'liquid-about';
		$this->page_title = esc_html__( 'Update', 'archub' );
		$this->menu_title = esc_html__( 'Update', 'archub' );
		$this->parent = 'liquid';
		$this->position = '60';

		add_action( 'wp_ajax_lqd_about_update_escape', function(){
			set_transient( 'lqd_about_update_escape', [], 12 * HOUR_IN_SECONDS );
			wp_send_json_success('done');
		} );

		parent::__construct();
	}

	/**
	 * [display description]
	 * @method display
	 * @return [type]  [description]
	 */
	public function display() {
		include_once( get_template_directory() . '/liquid/admin/views/liquid-about.php' );
	}

	/**
	 * [save description]
	 * @method save
	 * @return [type] [description]
	 */
	public function save() {

	}
}
new Liquid_Admin_About;
