<?php
/**
 * TCI UET Font assets manager class
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.1
 */
namespace TCI_UET\TCI_Modules;

tci_uet_exit();

use TCI_UET\TCI_Modules\Custom_Fonts;

class TCI_Assets_Manager {

	private $asset_managers = [];

	public function get_name() {
		return 'assets-manager';
	}

	public function add_asset_manager( $name, $instance ) {
		$this->asset_managers[ $name ] = $instance;
	}

	public function get_assets_manager( $id = null ) {
		if ( $id ) {
			if ( ! isset( $this->asset_managers[ $id ] ) ) {
				return null;
			}

			return $this->asset_managers[ $id ];
		}

		return $this->asset_managers;
	}

	public function __construct() {

		$this->add_asset_manager( 'font', new Custom_Fonts\TCI_Fonts_Manager() );
	}
}

new TCI_Assets_Manager();
