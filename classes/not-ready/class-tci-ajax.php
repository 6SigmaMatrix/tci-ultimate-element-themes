<?php
/**
 * TCI UET Ajax class
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.1
 */
namespace TCI_UET\Classes;

tci_exit();

use Elementor\Core\Common\Modules\Ajax\Module;

class TCI_Ajax {

	/**
	 * Constructer
	 *
	 * @since 0.0.1
	 */

	public function __construct() {

		add_action( 'wp_ajax_nopriv_tci_method', [ $this, 'tci_method' ] );
		add_action( 'wp_ajax_tci_method', [ $this, 'tci_method' ] );
		add_action( 'elementor/ajax/register_actions', [ $this, 'tci_register_elementor_ajax_actions' ] );

	}

	/**
	 * Method Check
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function tci_method() {
		$request = sanitize_text_field( $_REQUEST['subaction'] );
		$method  = isset( $request ) ? $request : '';

		if ( method_exists( $this, $method ) ) {
			$this->$method();
		}
		exit;
	}

	/**
	 * Plugins Check
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	/*protected function tci_required_plugin() {
		check_ajax_referer( 'tci-sites', '_ajax_nonce' );

		$response = array(
			'active'       => [],
			'inactive'     => [],
			'notinstalled' => [],
		);

		if ( ! current_user_can( 'customize' ) ) {
			wp_send_json_error( $response );
		}

		$required_plugins = ( isset( $_POST['required_plugins'] ) ) ? $_POST['required_plugins'] : [];

		if ( count( $required_plugins ) > 0 ) {
			foreach ( $required_plugins as $key => $plugin ) {

				// Lite - Installed but Inactive.
				if ( file_exists( WP_PLUGIN_DIR . '/' . sanitize_text_field( $plugin['init'] ) ) && is_plugin_inactive( sanitize_text_field( $plugin['init'] ) ) ) {

					$response['inactive'][] = $plugin;

					// Lite - Not Installed.
				} elseif ( ! file_exists( WP_PLUGIN_DIR . '/' . $plugin['init'] ) ) {

					$response['notinstalled'][] = $plugin;

					// Lite - Active.
				} else {
					$response['active'][] = $plugin;
				}
			}
		}

		// Send response.
		wp_send_json_success( $response );
	}*/

	/**
	 * Plugins Activate
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	/*protected function tci_required_plugin_active() {

		if ( ! current_user_can( 'install_plugins' ) || ! isset( $_POST['init'] ) || ! $_POST['init'] ) {
			wp_send_json_error(
				[
					'success' => false,
					'message' => __( 'No plugin specified', 'tci-uet' ),
				]
			);
		}

		$data               = [];
		$plugin_init        = ( isset( $_POST['init'] ) ) ? esc_attr( $_POST['init'] ) : '';
		$astra_site_options = ( isset( $_POST['options'] ) ) ? json_decode( stripslashes( $_POST['options'] ) ) : '';
		$enabled_extensions = ( isset( $_POST['enabledExtensions'] ) ) ? json_decode( stripslashes( $_POST['enabledExtensions'] ) ) : '';

		$activate = activate_plugin( $plugin_init, '', false, true );

		if ( is_wp_error( $activate ) ) {
			wp_send_json_error(
				array(
					'success' => false,
					'message' => $activate->get_error_message(),
				)
			);
		}

		wp_send_json_success(
			array(
				'success' => true,
				'message' => __( 'Plugin Successfully Activated', 'tci-uet' ),
			)
		);
	}*/

	/**
	 * Demo Data
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	/*protected function tci_demo_import() {

		$this->tci_demo_file_write( tci_array( $_POST )->get( 'api_url' ) );
		if ( file_exists( tci_root( 'content/pages-demo.json' ) ) ) {
			$this->tci_demo_page_import( tci_uri( 'content/pages-demo.json' ) );
		}
		exit;
		if ( 'done' === $data ) {
			$data = wp_remote_get( tci_uri( 'content/demo.json' ) );
			$data = $data['body'];
			$log  = ( new \Elementor\TemplateLibrary\Source_Local() )->import_template( 'demo.json', tci_root( 'content/demo.json' ) );
			$log  = ( isset( $log[0]['template_id'] ) ) ? 'done' : 'not-done';
			wp_send_json( [ 'success' => $log ] );
		}
	}*/

	/**
	 * File Write
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	/*protected function tci_demo_file_write( $data_url ) {
		$data = wp_remote_get( $data_url );
		$data = json_decode( $data['body'] );
		$data = [ 'pages' => $data->meta[2] ];
		foreach ( $data as $data_key => $data ) {
			return tci_file_write( [ "content/{$data_key}-demo.json", $data ] );
		}
	}*/

	/**
	 * File Import
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	/*protected function tci_demo_page_import( $file_url ) {
		$file_get  = wp_remote_get( $file_url );
		$file_data = json_decode( $file_get['body'], true );
		foreach ( $file_data as $data ) {
			$this->tci_insert_page( $data );
		}
	}*/

	/**
	 * Insert Data
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	/*protected function tci_insert_page( $data ) {
		$data_array = [
			'post_title'    => $data['title']['rendered'],
			'post_name'     => $data['slug'],
			'post_content'  => $data['content']['rendered'],
			'post_status'   => $data['status'],
			'post_type'     => $data['type'],
			'page_template' => $data['template'],
			'meta_input'    => [
				'_elementor_css'  => $data['meta'][3],
				'_elementor_data' => $data['meta'][4],
			],
		];
		wp_insert_post( $data_array );
	}*/

	/**
	 * Insert Data
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected function tci_register_elementor_ajax_actions( $ajax_manager ) {
		$ajax_manager->register_ajax_action( 'query_control_value_titles', [
			$this,
			'ajax_posts_control_value_titles',
		] );
		$ajax_manager->register_ajax_action( 'pro_panel_posts_control_filter_autocomplete', [
			$this,
			'ajax_posts_filter_autocomplete',
		] );
	}
}
