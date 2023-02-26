<?php
/**
 * Liquid Themes Theme Framework
 * The Liquid_Register initiate the theme engine
 */

if( !defined( 'ABSPATH' ) ) 
	exit; // Exit if accessed directly

class Liquid_Register {

	/**
	 * Variables required for the theme updater
	 *
	 * @since 1.0.0
	 * @type string
	 */
	 protected $remote_api_url = null;
	 protected $theme_slug = null;
	 protected $version = null;
	 protected $renew_url = null;
	 protected $strings = null;

	/**
	 * Initialize the class.
	 *
	 * @since 1.0.0
	 */
	function __construct( $config = array(), $strings = array() ) {

		$config = wp_parse_args( $config, array(
			'remote_api_url' => 'http://api.liquid-themes.com/archub',
			'theme_slug'     => 'archub',
			'version'        => '',
			'author'         => 'Liquid Themes',
			'renew_url'      => ''
		) );

		// Set config arguments
		$this->remote_api_url = $config['remote_api_url'];
		$this->theme_slug     = sanitize_key( $config['theme_slug'] );
		$this->version        = $config['version'];
		$this->author         = $config['author'];
		$this->renew_url      = $config['renew_url'];

		// Populate version fallback
		if ( '' == $config['version'] ) {
			$theme = wp_get_theme( $this->theme_slug );
			$this->version = $theme->get( 'Version' );
		}

		// Strings passed in from the updater config
		$this->strings = $strings;

		add_action( 'after_setup_theme', array( $this, 'init_hooks' ) );
		add_action( 'admin_init', array( $this, 'updater' ) );
		add_action( 'admin_init', array( $this, 'register_option' ) );
		add_filter( 'http_request_args', array( $this, 'disable_wporg_request' ), 5, 2 );

		$this->check_license();
		$this->check_domain();

	}

	/**
	 * Creates the updater class.
	 *
	 * since 1.0.0
	 */
	function updater() {

		/* If there is no valid license key status, don't allow updates. */
		if ( get_option( $this->theme_slug . '_purchase_code_status', false ) != 'valid' ) {
			return;
		}

		if ( !class_exists( 'Liquid_Updater' ) ) {
			// Load our custom theme updater
			include( get_template_directory() . '/liquid/admin/updater/liquid-updater-class.php' );
		}

		new Liquid_Updater(
			array(
				'remote_api_url' => $this->remote_api_url,
				'version' 		 => $this->version,
				'purchase_code'  => trim( get_option( $this->theme_slug . '_purchase_code' ) ),
			),
			$this->strings
		);
	}
	
	/**
	 * [init_hooks description]
	 * @method init_hooks
	 * @return [type]     [description]
	 */
	public function init_hooks() {

        if ( 'valid' != get_option( $this->theme_slug . '_purchase_code_status', false ) ) {

            if ( ( ! isset( $_GET['page'] ) || 'liquid' != $_GET['page'] ) ) {
                add_action( 'admin_notices', array( $this, 'admin_error' ) );
            } 
			
        }
	}
	
	function admin_error() {
		echo '<div class="error"><p>' . sprintf( wp_kses( __( 'The %s theme needs to be registered. %sRegister Now%s', 'archub' ), 'a' ), 'ArcHub', '<a href="' . admin_url( 'admin.php?page=liquid') . '">' , '</a>' ) . '</p></div>';
	}
	
	function messages() {

		set_transient( $this->theme_slug . '_license_message', $this->check_license(), ( 60 * 60 * 24 ) );
		$message = get_transient( $this->theme_slug . '_license_message' );
		echo wp_kses_post( $message );
		return;
		
		$license = trim( get_option( $this->theme_slug . '_purchase_code' ) );
		$status = get_option( $this->theme_slug . '_purchase_code_status', false );
		$env = get_option( $this->theme_slug . '_register_env', false );

		// Checks license status to display under license key
		
		if ( $status === false ) {
			delete_transient( $this->theme_slug . '_license_message' );
		}

		if ( ! $license ) {

			global $wp;
			$url = add_query_arg( $_GET, $wp->request );

			$tag = $url == '?page=liquid' ? 'h4' : 'h1';
			$message = '<'.$tag.'>Activate ArcHub</'.$tag.'><p>Go to <a href="https://portal.liquid-themes.com/">portal.liquid-themes.com</a> and create your Liquid account before activating your theme</p>';
		} 
		else {
			$message = get_transient( $this->theme_slug . '_license_message' );
		}
		
		echo wp_kses( $message, 'lqd_post' );
		
	}
	
	/**
	 * Outputs the markup used on the theme license page.
	 *
	 * since 1.0.0
	 */
	function form() {

		global $wp;
		$url = add_query_arg( $_GET, $wp->request );
		$strings = $this->strings;
		$license = trim( get_option( $this->theme_slug . '_purchase_code' ) );
		$email = get_option( $this->theme_slug . '_register_email', false );
		$env = get_option( $this->theme_slug . '_register_env', false );
		$status = get_option( $this->theme_slug . '_purchase_code_status', false );

		if ( get_option( $this->theme_slug . '_purchase_code_status', false ) != 'valid' || ( isset($_GET['liquid_license_status']) && $_GET['liquid_license_status'] != 'valid' ) ):
		?>
		<form action="https://portal.liquid-themes.com/license/activate" method="GET" target="_blank" class="lqd-dsd-register-form">
			<?php settings_fields( $this->theme_slug . '-license' ); ?>
			<input type="hidden" name="envato_item_id" value="37523798" />
			<input type="hidden" name="theme" value="<?php echo esc_attr($this->theme_slug) ?>" />
			<input type="hidden" name="domain" value="<?php echo site_url(); ?>" />
			<input type="hidden" name="return_url" value="<?php echo admin_url( 'admin.php' . $url ); ?>" />
			<div class="lqd-dsd-register-radio">
				<p>Choose license type: </p>
				<div>
					<input type="radio" id="development" name="register_env" value="development" <?php echo esc_attr(($env === 'development' || empty($env)) ? 'checked' : ''); ?>>
					<label for="development">Development</label>
				</div>
				<div>
					<input type="radio" id="production" name="register_env" value="production" <?php echo esc_attr($env === 'production' ? 'checked' : ''); ?>>
					<label for="production">Production</label>
				</div>
			</div>
			<div class="notice notice-warning notice-warning-orange" style="display: none;">
				<p><b>Heads up!</b> You can repeat registration on the same domain <b><u><i>5</i> times on development</u></b> and <b><u><i>3</i> times on production</u></b>.</p>
			</div>
			<button type="submit">
				<?php esc_html_e( 'Connect to Liquid Portal', 'archub' ) ?>
			</button>
		</form>
		<?php
		else:
		?>
		<div class="lqd-dsd-box-foot">
			<a href="https://portal.liquid-themes.com/" target="_blank"><?php esc_html_e( 'Manage Licenses in Liquid Portal', 'archub' ); ?></a>
		</div>
		<?php
		endif;
	}
	
	/**
	 * Registers the option used to store the license key in the options table.
	 *
	 * since 1.0.0
	 */
	function register_option() {
		register_setting(
			$this->theme_slug . '-license',
			$this->theme_slug . '_purchase_code',
			array( $this, 'sanitize_license' )
		);
		register_setting(
			$this->theme_slug . '-license',
			$this->theme_slug . '_register_email'
		);
		register_setting(
			$this->theme_slug . '-license',
			$this->theme_slug . '_register_env'
		);
	}

	/**
	 * Sanitizes the license key.
	 *
	 * since 1.0.0
	 *
	 * @param string $new License key that was submitted.
	 * @return string $new Sanitized license key.
	 */
	function sanitize_license( $new ) {

		$old = get_option( 'archub_purchase_code' );

		if ( $old && $old != $new ) {
			// New license has been entered, so must reactivate
			delete_option( $this->theme_slug . '_purchase_code_status' );
			delete_transient( $this->theme_slug . '_license_message' );
		}

		return $new;
	}
	
	/**
	 * Makes a call to the API.
	 *
	 * @since 1.0.0
	 *
	 * @param array $api_params to be used for wp_remote_get.
	 * @return array $response decoded JSON response.
	 */
	 function get_api_response( $api_params ) {

		 // Call the custom API.
		$response = wp_remote_get(
			add_query_arg( $api_params, $this->remote_api_url ),
			array( 'timeout' => 15, 'sslverify' => false )
		);

		// Make sure the response came back okay.
		if ( is_wp_error( $response ) ) {
			return false;
		}

		$response = json_decode( wp_remote_retrieve_body( $response ) );

		return $response;
	 }

	/**
     * Makes a call to the API.
     *
     * @since 1.5
     *
     * @param array $api_params to be used for wp_remote_get.
     * @return array $response decoded JSON response.
     */
	function ld_api_response( $api_params ) {

		$api_response = wp_remote_post('https://portal.liquid-themes.com/api/license/activate', $api_params);

		$status = [];
		$response = json_decode( wp_remote_retrieve_body( $api_response ), true );
        // Make sure the response came back okay.
		if ( is_wp_error( $api_response ) || wp_remote_retrieve_response_code( $api_response ) != 200 ) {
			$status['success'] = 'false';
			$status['valid'] = 'false';
			if ( isset( $response['error'][0] ) ) {
				$status['message'] = $response['error'][0];
			} else {
				$status['message'] = esc_html( 'Something went wrong. Please try again later.');
			}
			return $status;
		
		}
		$status['success'] = 'true';
		$status['valid'] = 'valid';

        return $status;
     }

	 
	/**
	 * Checks if license is valid and gets expire date.
	 *
	 * @since 1.0.0
	 *
	 * @return string $message License status message.
	 */
	function check_license() {

		//update_option( $this->theme_slug . '_purchase_code_status', $license_data->license );
		$message = '<div class="lqd-dsd-confirmation success">
							<h4>Thanks for the verification!</h4>
							<p>You can now enjoy Archub and build great websites. Looking for help? Visit <a href="https://docs.liquid-themes.com/" target="_blank">our help center</a> or <a href="https://liquidthemes.freshdesk.com/support/home" target="_blank">submit a ticket</a>.</p>
						</div><!-- /.lqd-dsd-confirmation success -->';
		return $message;
		
		if ( ! isset( $_GET['liquid_license_status'] ) && ! isset( $_GET['liquid_license_key'] ) && ! isset( $_GET['liquid_license_domain_key'] ) ) {
			return;
		}

		global $wp;
		$url = add_query_arg( $_GET, $wp->request );

		if ( $_GET['liquid_license_status'] === 'valid' ) {

			update_option( $this->theme_slug . '_purchase_code_status', $_GET['liquid_license_status'] );
			update_option( $this->theme_slug . '_purchase_code', $_GET['liquid_license_key'] );
			update_option( $this->theme_slug . '_purchase_code_domain_key', $_GET['liquid_license_domain_key'] );
			update_option( $this->theme_slug . '_purchase_code_domain', str_replace(array("http://","https://"),"",site_url()) );
			set_transient( $this->theme_slug . '_purchase_code_domain', str_replace(array("http://","https://"),"",site_url()), 12 * HOUR_IN_SECONDS );

			$message = '<div class="lqd-dsd-confirmation success">
							<h4>
								Thanks for the verification!
								<svg xmlns="http://www.w3.org/2000/svg" width="21" height="22" viewBox="0 0 21 22">
									<path fill="currentColor" fill-rule="evenodd" d="M398.4,76.475 L407.775,67.1 L406.3,65.575 L398.4,73.5 L394.7,69.775 L393.225,71.25 L398.4,76.475 Z M400.5,60.85 C402.40001,60.85 404.158325,61.3249952 405.775,62.275 C407.341675,63.1750045 408.574995,64.4083255 409.475,65.975 C410.425005,67.5916747 410.9,69.3499905 410.9,71.25 C410.9,73.1500095 410.425005,74.9083252 409.475,76.525 C408.574995,78.0916745 407.341675,79.3249955 405.775,80.225 C404.158325,81.1750047 402.40001,81.65 400.5,81.65 C398.59999,81.65 396.841675,81.1750047 395.225,80.225 C393.658325,79.3083287 392.425005,78.0666745 391.525,76.5 C390.574995,74.8833252 390.1,73.1333427 390.1,71.25 C390.1,69.3666573 390.574995,67.6166747 391.525,66 C392.441671,64.4333255 393.683326,63.1916712 395.25,62.275 C396.866675,61.3249952 398.616657,60.85 400.5,60.85 Z" transform="translate(-390 -60)"/>
								</svg>
							</h4>
							<p>You can now enjoy ArcHub and build great websites. Looking for help? Visit <a href="https://docs.liquid-themes.com/" target="_blank">our help center</a> or <a href="https://liquidthemes.freshdesk.com/support/home" target="_blank">submit a ticket</a>.</p>
						</div><!-- /.lqd-dsd-confirmation success -->';

		} else {

			if ( isset($_GET['liquid_license_message']) && ! empty( $_GET['liquid_license_message'] ) ) {
				$message_text = $_GET['liquid_license_message'];
			} else {
				$message_text = 'Something went wrong! Contact to support.';
			}

			$message = '<div class="lqd-dsd-confirmation fail">
							<h4>
								Activation is invalid.
								<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15">
									<polygon fill="currentColor" fill-rule="evenodd" points="274.775 64.45 268.975 70.25 274.775 76.05 273.3 77.525 267.5 71.725 261.7 77.525 260.225 76.05 266.025 70.25 260.225 64.45 261.7 62.975 267.5 68.775 273.3 62.975" transform="translate(-260 -63)"/>
								</svg>
							</h4>
							<p>' . $message_text . '</p>
							<p> Looking for help? Visit <a href="https://docs.liquid-themes.com/" target="_blank">our help center</a> or <a href="https://liquidthemes.freshdesk.com/support/home" target="_blank">submit a ticket</a>.</p>
						</div><!-- /.lqd-dsd-confirmation fail -->';
		}

		set_transient( $this->theme_slug . '_license_message', $message, ( 60 * 60 * 24 ) ); // message

		if ( false !== strpos( $url, '?page=liquid-setup&step=license') ) {
			wp_redirect(admin_url('admin.php?page=liquid-setup&step=license'));
		} else {
			wp_redirect(admin_url('admin.php?page=liquid'));
		}

	}

	/**
	 * Checks domain expire date.
	 *
	 * @since 1.0.0
	 *
	 * @return string $message License status message.
	 */
	function check_domain() {

		if ( !get_option( $this->theme_slug . '_purchase_code_domain' ) ){
			update_option( $this->theme_slug . '_purchase_code_domain', str_replace(array("http://","https://"),"",site_url()) );
			set_transient( $this->theme_slug . '_purchase_code_domain', str_replace(array("http://","https://"),"",site_url()), 12 * HOUR_IN_SECONDS );
		} else {
			if ( false === get_transient( $this->theme_slug . '_purchase_code_domain' ) ) {
				if ( str_replace(array("http://","https://"),"",site_url()) != get_option( $this->theme_slug . '_purchase_code_domain' ) ){
					delete_option( $this->theme_slug . '_purchase_code_status' );
					delete_option( $this->theme_slug . '_purchase_code'  );
					delete_option( $this->theme_slug . '_purchase_code_domain_key' );
					delete_option( $this->theme_slug . '_purchase_code_domain' );
					update_option( $this->theme_slug . '_purchase_code_domain_migrated', 'Migrate detected!' );
				} else {
					set_transient( $this->theme_slug . '_purchase_code_domain', str_replace(array("http://","https://"),"",site_url()), 12 * HOUR_IN_SECONDS );
				}
			}
		}
		
	}

	/**
	 * Disable requests to wp.org repository for this theme.
	 *
	 * @since 1.0.0
	 */
	function disable_wporg_request( $r, $url ) {

		// If it's not a theme update request, bail.
		if ( 0 !== strpos( $url, 'https://api.wordpress.org/themes/update-check/1.1/' ) ) {
 			return $r;
 		}

 		// Decode the JSON response
 		$themes = json_decode( $r['body']['themes'] );

 		// Remove the active parent and child themes from the check
 		$parent = get_option( 'template' );
 		$child = get_option( 'stylesheet' );
 		unset( $themes->themes->$parent );
 		unset( $themes->themes->$child );

 		// Encode the updated JSON response
 		$r['body']['themes'] = json_encode( $themes );

 		return $r;
	}
	
}

new Liquid_Register;