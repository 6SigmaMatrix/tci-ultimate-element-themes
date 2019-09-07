<?php
/**
 * TCI UET Template module class
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.1
 */
namespace TCI_UET\TCI_UET_Modules;

tci_uet_exit();

use Elementor\Plugin;
use TCI_UET\TCI_UET_Modules;

class TCI_UET_Template extends TCI_UET_Modules {
	const TEMPLATE_TYPE = 'tci-uet-template-view';

	/**
	 * Constructer
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function __construct() {
		add_action( 'elementor/editor/init', [ $this, 'tci_uet_template_view' ] );
		add_filter( 'tci_uet/backend/localize', [ $this, 'tci_uet_template_localize' ] );
	}

	/**
	 * Replace Pro Custom CSS Control
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function tci_uet_template_view() {
		$tci_uet_template = tci_uet_dir_files_list( tci_uet_root( "classes/tci-uet-modules/tci-uet-template/tci-uet-view/" ) );
		foreach ( $tci_uet_template as $template ) {
			Plugin::instance()->common->add_template( $template );
		}
	}

	public function tci_uet_template_localize( $localize_data ) {
		$localize_data['modalRegions'] = $this->tci_uet_template_get_modal_region();

		return $localize_data;
	}

	/**
	 * Get Modal Region
	 * Get modal region in the editor.
	 *
	 * @since  0.0.6
	 * @access public
	 */
	public function tci_uet_template_get_modal_region() {

		return array(
			'modalHeader'  => '.dialog-header',
			'modalContent' => '.dialog-message',
		);

	}
}
