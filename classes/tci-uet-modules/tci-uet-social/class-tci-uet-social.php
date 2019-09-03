<?php
/**
 * TCI UET Modules Loader class
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.1
 */
namespace TCI_UET\TCI_UET_Modules;

tci_uet_exit();

use TCI_UET\TCI_UET_Modules;

class TCI_UET_Social extends TCI_UET_Modules {

	const URL_TYPE_CURRENT_PAGE = 'current_page';

	const URL_TYPE_CUSTOM       = 'custom';

	const URL_FORMAT_PLAIN      = 'plain';

	const URL_FORMAT_PRETTY     = 'pretty';


	public function __construct() {
		require_once tci_uet_root( 'classes/tci-uet-modules/tci-uet-social/tci-uet-facebook-sdk/class-tci-uet-facebook-sdk.php' );
		$this->add_component( 'facebook_sdk', new TCI_UET_Facebook_Sdk() );
	}

	public function get_name() {
		return 'TCI_UET_Social';
	}
}

