<?php
/**
 * TCI UET Ajax class
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.1
 */
namespace TCI_UET;

tci_uet_exit();

use Elementor\Plugin;

class TCI_UET_Ajax {

	const TCI_UET_API = [
		'api' => [
			'enabled'   => true,
			'base'      => 'https://pa.premiumtemplates.io/',
			'path'      => 'wp-json/patemp/v2',
			'id'        => 9,
			'endpoints' => [
				'templates'  => '/templates/',
				'keywords'   => '/keywords/',
				'categories' => '/categories/',
				'template'   => '/template/',
				'info'       => '/info/',
				'template'   => '/template/',
			],
		],
	];

	/**
	 * Constructer
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function __construct() {
		add_action( 'wp_ajax_tci_uet_ajax', array( $this, 'tci_uet_ajax_have_method' ) );
		add_action( 'wp_ajax_nopriv_tci_uet_ajax', array( $this, 'tci_uet_ajax_have_method' ) );
	}

	public function tci_uet_ajax_have_method() {
		$method = tci_uet_get_have( $_REQUEST, 'subaction' );
		if ( method_exists( $this, $method ) ) {
			$this->$method();
		}
		exit;
	}
}
