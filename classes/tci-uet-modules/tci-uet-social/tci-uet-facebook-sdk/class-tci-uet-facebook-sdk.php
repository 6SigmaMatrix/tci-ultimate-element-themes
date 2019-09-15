<?php
/**
 * TCI UET Facebook SDK class
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.1
 */
namespace TCI_UET\TCI_UET_Modules;

tci_uet_exit();

use Elementor\Controls_Manager;
use Elementor\Settings;
use Elementor\Widget_Base;
use TCI_UET\TCI_UET_Modules\TCI_UET_Social;

class TCI_UET_Facebook_Sdk {

	const TCI_UET_FACEBOOK_SDK_OPTION_NAME_APP_ID = 'elementor_facebook_app_id';


	public function __construct() {
		add_action( 'wp_head', [ __CLASS__, 'tci_uet_facebook_sdk_enqueue_meta_app_id' ] );
		add_filter( 'tci_uet/frontend/localize', [ $this, 'tci_uet_facebook_sdk_localize_settings' ] );

		if ( ! empty( $_POST['option_page'] ) && 'tci-uet' === $_POST['option_page'] ) {
			$this->tci_uet_facebook_sdk_validate_sdk();
		}

		if ( is_admin() ) {
			add_action( 'elementor/admin/after_create_settings/' . Settings::PAGE_ID, [
				$this,
				'tci_uet_facebook_sdk_register_admin_fields',
			] );
		}
	}

	public static function tci_uet_facebook_sdk_get_app_id() {
		return get_option( self::TCI_UET_FACEBOOK_SDK_OPTION_NAME_APP_ID, '' );
	}

	public static function tci_uet_facebook_sdk_get_lang() {
		return get_locale();
	}

	public static function tci_uet_facebook_sdk_enqueue_meta_app_id() {
		$app_id = self::tci_uet_facebook_sdk_get_app_id();
		if ( $app_id ) {
			printf( '<meta property="fb:app_id" content="%s" />', esc_attr( $app_id ) );
		}
	}

	/**
	 * @param Widget_Base $widget
	 */
	public static function tci_uet_facebook_sdk_add_app_id_control( $widget ) {
		if ( ! self::tci_uet_facebook_sdk_get_app_id() ) {
			/* translators: %s: Setting Page link. */
			$html = sprintf( __( 'You can set your Facebook App ID in the <a href="%s" target="_blank">Integrations Settings</a>', 'tci-uet' ), Settings::get_url() . '#tab-integrations' );
		} else {
			/* translators: 1: App ID, 2: Setting Page link. */
			$html = sprintf( __( 'You are connected to Facebook App %1$s, <a href="%2$s" target="_blank">Change App</a>', 'tci-uet' ), self::tci_uet_facebook_sdk_get_app_id(), Settings::get_url() . '#tab-integrations' );
		}

		$widget->add_control(
			'app_id',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => $html,
				'content_classes' => 'elementor-descriptor',
			]
		);
	}

	public function tci_uet_facebook_sdk_localize_settings( $settings ) {
		$settings['facebook_sdk'] = [
			'lang'   => self::tci_uet_facebook_sdk_get_lang(),
			'app_id' => self::tci_uet_facebook_sdk_get_app_id(),
		];

		return $settings;
	}

	public static function tci_uet_facebook_sdk_get_permalink( $settings = [] ) {
		$post_id = get_the_ID();

		if ( isset( $settings['url_format'] ) && TCI_UET_Social::URL_FORMAT_PRETTY === $settings['url_format'] ) {
			return get_permalink( $post_id );
		}

		// Use plain url to avoid losing comments after change the permalink.
		return add_query_arg( 'p', $post_id, home_url() );
	}

	public function tci_uet_facebook_sdk_register_admin_fields( Settings $settings ) {
		$settings->add_section( Settings::TAB_INTEGRATIONS, 'facebook_sdk', [
			'callback' => function () {
				echo '<hr><h2>' . esc_html__( 'TCI UET Facebook SDK', 'tci-uet' ) . '</h2>';

				/* translators: %s: Facebook App Setting link. */
				echo sprintf( __( 'Facebook SDK lets you connect to your <a href="%s" target="_blank">dedicated application</a> so you can track the Facebook Widgets analytics on your site.', 'tci-uet' ), 'https://developers.facebook.com/docs/apps/register/' ) .
				     '<br>' .
				     '<br>' .
				     __( 'If you are using the Facebook Comments Widget, you can add moderating options through your application. Note that this option will not work on local sites and on domains that don\'t have public access.', 'tci-uet' );
			},
			'fields'   => [
				'facebook_app_id' => [
					'label'      => __( 'App ID', 'tci-uet' ),
					'field_args' => [
						'type' => 'text',
						/* translators: %s: Facebook App Setting link. */
						'desc' => sprintf( __( 'Remember to add the domain to your <a href="%s" target="_blank">App Domains</a>', 'tci-uet' ), $this->tci_uet_facebook_sdk_get_app_settings_url() ),
					],
				],
			],
		] );
	}

	private function tci_uet_facebook_sdk_get_app_settings_url() {
		$app_id = self::tci_uet_facebook_sdk_get_app_id();
		if ( $app_id ) {
			return sprintf( 'https://developers.facebook.com/apps/%d/settings/', $app_id );
		} else {
			return 'https://developers.facebook.com/apps/';
		}
	}

	private function tci_uet_facebook_sdk_validate_sdk() {
		$errors = [];

		if ( ! empty( $_POST['elementor_facebook_app_id'] ) ) {
			$response = wp_remote_get( 'https://graph.facebook.com/' . $_POST['elementor_facebook_app_id'] );

			if ( is_wp_error( $response ) || 200 !== (int) wp_remote_retrieve_response_code( $response ) ) {
				$errors[] = __( 'Facebook App ID is not valid', 'tci-uet' );
			}
		}

		$message = implode( '<br>', $errors );

		if ( ! empty( $errors ) ) {
			wp_die( $message, __( 'Facebook SDK', 'tci-uet' ), [ 'back_link' => true ] );
		}
	}
}

