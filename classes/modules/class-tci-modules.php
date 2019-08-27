<?php
/**
 * TCI UET Modules Loader class
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.1
 */
namespace TCI_UET\TCI_Modules;

tci_exit();

use Elementor\Core\Base\Module;

class TCI_Modules extends Module {
	const URL_TYPE_CURRENT_PAGE = 'current_page';

	const URL_TYPE_CUSTOM       = 'custom';

	const URL_FORMAT_PLAIN      = 'plain';

	const URL_FORMAT_PRETTY     = 'pretty';

	public function get_name() {
		return 'TCI_UET_Social';
	}

	public function __construct() {

		$this->add_component( 'facebook_sdk', new TCI_Facebook_SDK_Manager() );
	}
}

new TCI_Modules();
