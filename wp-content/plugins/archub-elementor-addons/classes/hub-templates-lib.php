<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Plugin;
use Elementor\TemplateLibrary\Source_Base;
use Elementor\TemplateLibrary\Source_Local;
use Elementor\Core\Common\Modules\Ajax\Module as Ajax;
use Elementor\User;

/**
 * HubCollectons Library.
 *
 * @since 1.6.0
 */
class Hub_Templates_Lib {
	/**
	 * HubCollectons library option key.
	 */
	const LIBRARY_OPTION_KEY = 'hub_templates_library';

	/**
	 * API templates URL.
	 *
	 * Holds the URL of the templates API.
	 *
	 * @access public
	 * @static
	 *
	 * @var string API URL.
	 */
	public static $api_url = 'http://archubcollection.liquid-themes.com/wp-json/HubCollections/v1/templates';

	/**
	 * Init.
	 *
	 * Initializes the hooks.
	 *
	 * @since 1.6.0
	 * @access public
	 *
	 * @return void
	 */
	public static function init() {
		add_action( 'elementor/init', [ __CLASS__, 'register_source' ] );
		add_action( 'elementor/editor/after_enqueue_scripts', [ __CLASS__, 'enqueue_editor_scripts' ] );
		add_action( 'elementor/ajax/register_actions', [ __CLASS__, 'register_ajax_actions' ] );
		add_action( 'elementor/editor/footer', [ __CLASS__, 'render_template' ] );
		//add_action( 'wp_ajax_elementor_reset_library', [ __CLASS__, 'ajax_reset_api_data' ] );

	}

	/**
	 * Register source.
	 *
	 * Registers the library source.
	 *
	 * @since 1.6.0
	 * @access public
	 *
	 * @return void
	 */
	public static function register_source() {
		Plugin::$instance->templates_manager->register_source( __NAMESPACE__ . '\HUB_Source' );
	}

	/**
	 * Enqueue Editor Scripts.
	 *
	 * Enqueues required scripts in Elementor edit mode.
	 *
	 * @since 1.6.0
	 * @access public
	 *
	 * @return void
	 */
	public static function enqueue_editor_scripts() {
		wp_enqueue_script(
			'hub-templates-lib',
			LD_ELEMENTOR_URL . 'assets/js/hub-templates-lib.js',
			[
				'jquery',
				'backbone-marionette',
				'backbone-radio',
				'elementor-common-modules',
				'elementor-dialog',
			],
			LD_ELEMENTOR_VERSION,
			true
		);

		wp_localize_script( 'hub-templates-lib', 'hub_templates_lib', array(
			'logoUrl'	=> LD_ELEMENTOR_URL . 'assets/img/logo/liquid-logo.svg',
		) );
	}

	/**
	 * Init ajax calls.
	 *
	 * Initialize template library ajax calls for allowed ajax requests.
	 *
	 * @since 1.6.0
	 * @access public
	 *
	 * @param Ajax $ajax Elementor's Ajax object.
	 * @return void
	 */
	public static function register_ajax_actions( Ajax $ajax ) {
		$library_ajax_requests = [
			'hub_get_library_data',
		];

		foreach ( $library_ajax_requests as $ajax_request ) {
			$ajax->register_ajax_action( $ajax_request, function( $data ) use ( $ajax_request ) {
				return self::handle_ajax_request( $ajax_request, $data );
			} );
		}
	}

	/**
	 * Handle ajax request.
	 *
	 * Fire authenticated ajax actions for any given ajax request.
	 *
	 * @since 1.6.0
	 * @access private
	 *
	 * @param string $ajax_request Ajax request.
	 * @param array  $data Elementor data.
	 *
	 * @return mixed
	 * @throws \Exception Throws error message.
	 */
	private static function handle_ajax_request( $ajax_request, array $data ) {
		if ( ! User::is_current_user_can_edit_post_type( Source_Local::CPT ) ) {
			throw new \Exception( 'Access Denied' );
		}

		if ( ! empty( $data['editor_post_id'] ) ) {
			$editor_post_id = absint( $data['editor_post_id'] );

			if ( ! get_post( $editor_post_id ) ) {
				throw new \Exception( esc_html__( 'Post not found.', 'element-ready' ) );
			}

			Plugin::$instance->db->switch_to_post( $editor_post_id );
		}

		$result = call_user_func( [ __CLASS__, $ajax_request ], $data );

		if ( is_wp_error( $result ) ) {
			throw new \Exception( $result->get_error_message() );
		}

		return $result;
	}

	/**
	 * Get library data.
	 *
	 * Get data for template library.
	 *
	 * @since 1.6.0
	 * @access public
	 *
	 * @param array $args Arguments.
	 *
	 * @return array Collection of templates data.
	 */
	public static function hub_get_library_data( array $args ) {
		$library_data = self::get_library_data( ! empty( $args['sync'] ) );

		// Ensure all document are registered.
		Plugin::$instance->documents->get_document_types();

		return [
			'templates' => self::get_templates(),
			'config' => $library_data['types_data'],
		];
	}

	/**
	 * Get templates.
	 *
	 * Retrieve all the templates from all the registered sources.
	 *
	 * @since 1.16.0
	 * @access public
	 *
	 * @return array Templates array.
	 */
	public static function get_templates() {
		$source = Plugin::$instance->templates_manager->get_source( 'hub_collections' );
		return $source->get_items();
	}

	/**
	 * Ajax reset API data.
	 *
	 * Reset Elementor library API data using an ajax call.
	 *
	 * @since 1.6.0
	 * @access public
	 * @static
	 */
	public static function ajax_reset_api_data() {
		check_ajax_referer( 'elementor_reset_library', '_nonce' );

		self::get_templates_data( true );

		wp_send_json_success();
	}

	/**
	 * Get templates data.
	 *
	 * This function the templates data.
	 *
	 * @since 1.6.0
	 * @access private
	 * @static
	 *
	 * @param bool $force_update Optional. Whether to force the data retrieval or
	 *                                     not. Default is false.
	 *
	 * @return array|false Templates data, or false.
	 */
	private static function get_templates_data( $force_update = false ) {
		$cache_key = 'hub_templates_data_' . LD_ELEMENTOR_VERSION;

		$templates_data = get_transient( $cache_key );

		if ( $force_update || false === $templates_data ) {
			$timeout = ( $force_update ) ? 25 : 8;

			$response = wp_remote_get( self::$api_url, [
				'timeout' => $timeout,
				'body' => [
					// Which API version is used.
					'api_version' => LD_ELEMENTOR_VERSION,
					// Which language to return.
					'site_lang' => get_bloginfo( 'language' ),
				],
			] );

			if ( is_wp_error( $response ) || 200 !== (int) wp_remote_retrieve_response_code( $response ) ) {
				set_transient( $cache_key, [], 2 * HOUR_IN_SECONDS );

				return false;
			}

			$templates_data = json_decode( wp_remote_retrieve_body( $response ), true );

			if ( empty( $templates_data ) || ! is_array( $templates_data ) ) {
				set_transient( $cache_key, [], 2 * HOUR_IN_SECONDS );

				return false;
			}

			if ( isset( $templates_data['library'] ) ) {
				update_option( self::LIBRARY_OPTION_KEY, $templates_data['library'], 'no' );

				unset( $templates_data['library'] );
			}

			set_transient( $cache_key, $templates_data, 12 * HOUR_IN_SECONDS );
		}

		return $templates_data;
	}

	/**
	 * Get templates data.
	 *
	 * Retrieve the templates data from a remote server.
	 *
	 * @since 1.6.0
	 * @access public
	 * @static
	 *
	 * @param bool $force_update Optional. Whether to force the data update or
	 *                                     not. Default is false.
	 *
	 * @return array The templates data.
	 */
	public static function get_library_data( $force_update = false ) {
		self::get_templates_data( $force_update );

		$library_data = get_option( self::LIBRARY_OPTION_KEY );

		if ( empty( $library_data ) ) {
			return [];
		}

		return $library_data;
	}

	/**
	 * Get template content.
	 *
	 * Retrieve the templates content received from a remote server.
	 *
	 * @since 1.6.0
	 * @access public
	 * @static
	 *
	 * @param int $template_id The template ID.
	 *
	 * @return object|\WP_Error The template content.
	 */
	public static function get_template_content( $template_id ) {
		$url = self::$api_url . '/' . $template_id;

		if ( 'valid' != get_option( 'archub_purchase_code_status', false ) ) {
			return new \WP_Error( 'no_license', esc_html__( 'Please Active The ArcHub Theme') );
		}

		$args = [
			'body' => [
				// Which API version is used.
				'api_version' 	=> LD_ELEMENTOR_VERSION,
				'home_url' 		=> trailingslashit( home_url() ),
			],
			'timeout' => 25,
		];

		$response = wp_remote_get( $url, $args );

		if ( is_wp_error( $response ) ) {
			// @codingStandardsIgnoreStart WordPress.XSS.EscapeOutput.
			wp_die( $response, [
				'back_link' => true,
			] );
			// @codingStandardsIgnoreEnd WordPress.XSS.EscapeOutput.
		}

		$body = wp_remote_retrieve_body( $response );
		$response_code = (int) wp_remote_retrieve_response_code( $response );

		if ( ! $response_code ) {
			return new \WP_Error( 500, 'No Response' );
		}

		// Server sent a success message without content.
		if ( 'null' === $body ) {
			$body = true;
		}

		$as_array = true;
		$body = json_decode( $body, $as_array );

		if ( false === $body ) {
			return new \WP_Error( 422, esc_html__('Wrong Server Response','element-ready') );
		}

		if ( 200 !== $response_code ) {
			// In case $as_array = true.
			$body = (object) $body;

			$message = isset( $body->message ) ? $body->message : wp_remote_retrieve_response_message( $response );
			$code = isset( $body->code ) ? $body->code : $response_code;

			return new \WP_Error( $code, $message );
		}

		return $body;
	}

	/**
	 * Render template.
	 *
	 * Library modal template.
	 *
	 * @since 1.6.0
	 * @access public
	 * @static
	 *
	 * @return void
	 */
	public static function render_template() {
		?>
		<script type="text/template" id="tmpl-elementor-template-library-header-actions-hub">
			<div id="elementor-template-library-header-sync" class="elementor-templates-modal__header__item">
				<i class="eicon-sync" aria-hidden="true" title="<?php esc_attr_e( 'Sync Templates', 'archub-elementor-addons' ); ?>"></i>
				<span class="elementor-screen-only"><?php echo esc_html__( 'Sync Templates', 'archub-elementor-addons' ); ?></span>
			</div>
		</script>
		<script type="text/template" id="tmpl-elementor-templates-modal__header__logo_hub">
			<span class="elementor-templates-modal__header__logo__icon-wrapper">
				<img src="<?php echo esc_url( LD_ELEMENTOR_URL . 'assets/img/logo/liquid-logo.svg' ); ?>" style="height: 30px;" />
			</span>
			<span class="elementor-templates-modal__header__logo__title">{{{ title }}}</span>
		</script>
		<script type="text/template" id="tmpl-elementor-template-library-header-preview-hub">
			<div id="elementor-template-library-header-preview-insert-wrapper" class="elementor-templates-modal__header__item">
				{{{ hub_templates_lib.templates.layout.getTemplateActionButton( obj ) }}}
			</div>
		</script>
		<script type="text/template" id="tmpl-elementor-template-library-templates-hub">
			<#
				var activeSource = hub_templates_lib.templates.getFilter('source');
			#>
			<div id="elementor-template-library-toolbar">
				<# if ( 'hub_collections' === activeSource ) {
					var activeType = hub_templates_lib.templates.getFilter('type');
					#>
					<div id="elementor-template-library-filter-toolbar-remote" class="elementor-template-library-filter-toolbar">
						<# if ( 'new_page' === activeType ) { #>
							<div id="elementor-template-library-order">
								<input type="radio" id="elementor-template-library-order-new" class="elementor-template-library-order-input" name="elementor-template-library-order" value="date">
								<label for="elementor-template-library-order-new" class="elementor-template-library-order-label"><?php echo esc_html__( 'New', 'archub-elementor-addons' ); ?></label>
								<input type="radio" id="elementor-template-library-order-trend" class="elementor-template-library-order-input" name="elementor-template-library-order" value="trendIndex">
								<label for="elementor-template-library-order-trend" class="elementor-template-library-order-label"><?php echo esc_html__( 'Trend', 'archub-elementor-addons' ); ?></label>
								<input type="radio" id="elementor-template-library-order-popular" class="elementor-template-library-order-input" name="elementor-template-library-order" value="popularityIndex">
								<label for="elementor-template-library-order-popular" class="elementor-template-library-order-label"><?php echo esc_html__( 'Popular', 'archub-elementor-addons' ); ?></label>
							</div>
						<# } else {
							var config = hub_templates_lib.templates.getConfig( activeType );
							if ( config.categories ) { #>
								<div id="elementor-template-library-filter">
									<select id="elementor-template-library-filter-subtype" class="elementor-template-library-filter-select" data-elementor-filter="subtype">
										<option></option>
										<# config.categories.forEach( function( category ) {
											var selected = category === hub_templates_lib.templates.getFilter( 'subtype' ) ? ' selected' : '';
											#>
											<option value="{{ category }}"{{{ selected }}}>{{{ category }}}</option>
										<# } ); #>
									</select>
								</div>
							<# }
						} #>
						<div id="elementor-template-library-my-favorites">
							<# var checked = hub_templates_lib.templates.getFilter( 'favorite' ) ? ' checked' : ''; #>
							<input id="elementor-template-library-filter-my-favorites" type="checkbox"{{{ checked }}}>
							<label id="elementor-template-library-filter-my-favorites-label" for="elementor-template-library-filter-my-favorites">
								<i class="eicon" aria-hidden="true"></i>
								<?php echo esc_html__( 'My Favorites', 'archub-elementor-addons' ); ?>
							</label>
						</div>
						<div class="elementor-template-library-expanded-template-alert">
							<div>Some templates (tabs and carousels) might require additional templates. <a href="<?php echo esc_url('https://docs.liquid-themes.com/article/522-archub-archub-collections'); ?>" target="_blank">More info ></a></div>
						</div>
					</div>
				<# } #>
				<div id="elementor-template-library-filter-text-wrapper">
					<label for="elementor-template-library-filter-text" class="elementor-screen-only"><?php echo esc_html__( 'Search Templates:', 'archub-elementor-addons' ); ?></label>
					<input id="elementor-template-library-filter-text" placeholder="<?php echo esc_attr__( 'Search', 'archub-elementor-addons' ); ?>">
					<i class="eicon-search"></i>
				</div>
			</div>
			<div id="elementor-template-library-templates-container"></div>
			<# if ( 'hub_collections' === activeSource ) { #>
				<div id="elementor-template-library-footer-banner">
					<img class="elementor-nerd-box-icon" src="<?php echo esc_url( ELEMENTOR_ASSETS_URL . 'images/information.svg' ); ?>" />
					<div class="elementor-excerpt"><?php echo esc_html__( 'Stay tuned! More awesome templates coming real soon.', 'archub-elementor-addons' ); ?></div>
				</div>
			<# } #>
		</script>
		<script type="text/template" id="tmpl-elementor-template-library-template-hub">
			<div class="elementor-template-library-template-body">
				<# if ( 'page' === type ) { #>
					<# if ( alert ) { #>
						<div class="elementor-template-library-expanded-template">{{{ alert }}}</div>
					<# } #>
					<div class="elementor-template-library-template-screenshot" style="background-image: url({{ thumbnail }});"></div>
				<# } else { #>
					<img loading="lazy" src="{{ thumbnail }}" width="{{img_width}}" height="{{img_height}}" style="height: auto;" />
				<# } #>
				<div class="elementor-template-library-template-preview">
					<i class="eicon-zoom-in-bold" aria-hidden="true"></i>
				</div>
			</div>
			<# if ( 'block' === type ) { #>
				<div class="elementor-template-library-hub-title">{{{ title }}} - <span>{{{ subtype }}}</span></div>
			<# } #>
			<# if ( 'Expansion' === subtype && alert) { #>
				<div class="elementor-template-library-expanded-template">{{{ alert }}}</div>
			<# } #>
			<# if ( alert ) { #>
				<div class="elementor-template-library-expanded-template">{{{ alert }}}</div>
			<# } #>
			<div class="elementor-template-library-template-footer">
				{{{ hub_templates_lib.templates.layout.getTemplateActionButton( obj ) }}}
				<div class="elementor-template-library-template-name">{{{ title }}} - {{{ type }}}</div>
				<div class="elementor-template-library-favorite">
					<input id="elementor-template-library-template-{{ template_id }}-favorite-input" class="elementor-template-library-template-favorite-input" type="checkbox"{{ favorite ? " checked" : "" }}>
					<label for="elementor-template-library-template-{{ template_id }}-favorite-input" class="elementor-template-library-template-favorite-label">
						<i class="eicon-heart-o" aria-hidden="true"></i>
						<span class="elementor-screen-only"><?php echo esc_html__( 'Favorite', 'archub-elementor-addons' ); ?></span>
					</label>
				</div>
			</div>
		</script>
		<script type="text/template" id="tmpl-elementor-template-library-get-pro-button-hub">
			<a class="elementor-template-library-template-action elementor-button elementor-go-pro" href="https://hubcollection.liquid-themes.com" target="_blank">
				<i class="eicon-external-link-square" aria-hidden="true"></i>
				<span class="elementor-button-title"><?php echo __( 'Go Pro', 'archub-elementor-addons' ); ?></span>
			</a>
		</script>
		<script type="text/template" id="tmpl-elementor-pro-template-library-activate-license-button-hub">
			<a class="elementor-template-library-template-action elementor-button elementor-go-pro" href="#" target="_blank">
				<i class="eicon-external-link-square"></i>
				<span class="elementor-button-title"><?php _e( 'Activate License', 'archub-elementor-addons' ); ?></span>
			</a>
		</script>
		<?php
	}
}

Hub_Templates_Lib::init();

/**
 * Custom source.
 */
class HUB_Source extends Source_Base {
	/**
	 * Get remote template ID.
	 *
	 * Retrieve the remote template ID.
	 *
	 * @since 1.14.5
	 * @access public
	 *
	 * @return string The remote template ID.
	 */
	public function get_id() {
		return 'hub_collections';
	}

	/**
	 * Get remote template title.
	 *
	 * Retrieve the remote template title.
	 *
	 * @since 1.14.5
	 * @access public
	 *
	 * @return string The remote template title.
	 */
	public function get_title() {
		return 'HubCollections';
	}

	/**
	 * Register remote template data.
	 *
	 * Used to register custom template data like a post type, a taxonomy or any
	 * other data.
	 *
	 * @since 1.14.5
	 * @access public
	 */
	public function register_data() {}

	/**
	 * Get remote templates.
	 *
	 * Retrieve remote templates from hubcollection.liquid-themes.com servers.
	 *
	 * @since 1.14.5
	 * @access public
	 *
	 * @param array $args Optional. Nou used in remote source.
	 *
	 * @return array Remote templates.
	 */
	public function get_items( $args = [] ) {

		$library_data = Hub_Templates_Lib::get_library_data();
		$status = apply_filters( 'element_ready/template/service/status', 200 );

		$templates = [];

		if ( ! empty( $library_data['templates'] ) ) {

			foreach ( $library_data['templates'] as $template_data ) {
				$data = $this->prepare_template( $template_data );
				$data['proStatus'] = $status;
				$templates[] = $data;
			}

		}

		return $templates;
	}

	/**
	 * Get remote template.
	 *
	 * Retrieve a single remote template from hubcollection.liquid-themes.com servers.
	 *
	 * @since 1.14.5
	 * @access public
	 *
	 * @param int $template_id The template ID.
	 *
	 * @return array Remote template.
	 */
	public function get_item( $template_id ) {
		$templates = $this->get_items();

		return $templates[ $template_id ];
	}

	/**
	 * Save remote template.
	 *
	 * Remote template from hubcollection.liquid-themes.com servers cannot be saved on the
	 * database as they are retrieved from remote servers.
	 *
	 * @since 1.14.5
	 * @access public
	 *
	 * @param array $template_data Remote template data.
	 *
	 * @return \WP_Error
	 */
	public function save_item( $template_data ) {
		return new \WP_Error( 'invalid_request', 'Cannot save template to a remote source' );
	}

	/**
	 * Update remote template.
	 *
	 * Remote template from hubcollection.liquid-themes.com servers cannot be updated on the
	 * database as they are retrieved from remote servers.
	 *
	 * @since 1.14.5
	 * @access public
	 *
	 * @param array $new_data New template data.
	 *
	 * @return \WP_Error
	 */
	public function update_item( $new_data ) {
		return new \WP_Error( 'invalid_request', 'Cannot update template to a remote source' );
	}

	/**
	 * Delete remote template.
	 *
	 * Remote template from hubcollection.liquid-themes.com servers cannot be deleted from the
	 * database as they are retrieved from remote servers.
	 *
	 * @since 1.14.5
	 * @access public
	 *
	 * @param int $template_id The template ID.
	 *
	 * @return \WP_Error
	 */
	public function delete_template( $template_id ) {
		return new \WP_Error( 'invalid_request', 'Cannot delete template from a remote source' );
	}

	/**
	 * Export remote template.
	 *
	 * Remote template from hubcollection.liquid-themes.com servers cannot be exported from the
	 * database as they are retrieved from remote servers.
	 *
	 * @since 1.14.5
	 * @access public
	 *
	 * @param int $template_id The template ID.
	 *
	 * @return \WP_Error
	 */
	public function export_template( $template_id ) {
		return new \WP_Error( 'invalid_request', 'Cannot export template from a remote source' );
	}

	/**
	 * Get remote template data.
	 *
	 * Retrieve the data of a single remote template from hubcollection.liquid-themes.com servers.
	 *
	 * @since 1.14.5
	 * @access public
	 *
	 * @param array  $args    Custom template arguments.
	 * @param string $context Optional. The context. Default is `display`.
	 *
	 * @return array|\WP_Error Remote Template data.
	 */
	public function get_data( array $args, $context = 'display' ) {
		$data = Hub_Templates_Lib::get_template_content( $args['template_id'] );

		if ( is_wp_error( $data ) ) {
			return $data;
		}

		$data = (array) $data;

		$data['content'] = $this->replace_elements_ids( $data['content'] );
		$data['content'] = $this->process_export_import_content( $data['content'], 'on_import' );

		$post_id = $args['editor_post_id'];
		$document = Plugin::$instance->documents->get( $post_id );
		if ( $document ) {
			$data['content'] = $document->get_elements_raw_data( $data['content'], true );
		}

		return $data;
	}

	/**
	 * Prepare template.
	 *
	 * Prepare template data.
	 *
	 * @since 1.6.0
	 * @access private
	 *
	 * @param array $template_data Collection of template data.
	 * @return array Collection of template data.
	 */
	private function prepare_template( array $template_data ) {
		$favorite_templates = $this->get_user_meta( 'favorites' );

		return [
			'template_id' => $template_data['id'],
			'source' => $this->get_id(),
			'type' => $template_data['type'],
			'subtype' => $template_data['subtype'],
			'title' => $template_data['title'],
			'thumbnail' => $template_data['thumbnail'],
			'img_width' => $template_data['img_width'],
			'img_height' => $template_data['img_height'],
			'date' => $template_data['tmpl_created'],
			'url' => $template_data['url'],
			'alert' => $template_data['alert'],
			'favorite' => ! empty( $favorite_templates[ $template_data['id'] ] ),
		];
	}
}
