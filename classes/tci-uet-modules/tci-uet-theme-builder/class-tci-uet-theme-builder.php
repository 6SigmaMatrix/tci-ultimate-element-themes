<?php
namespace TCI_UET\TCI_UET_Modules;

use Elementor\Plugin;
use TCI_UET\TCI_UET_Modules\TCI_UET_Documents;
use TCI_UET\TCI_UET_Modules;

class TCI_UET_Theme_Builder extends TCI_UET_Modules {
	private $docs_types = [];

	public function __construct() {
		if ( ! defined( 'ELEMENTOR_PRO_VERSION' ) ) {
			$this->tci_uet_theme_builder_template();
			add_action( 'elementor/documents/register', [ $this, 'tci_uet_theme_builder_register_documents' ] );
			add_action( 'elementor/page_templates/canvas/before_content', [ $this, 'do_header' ], 0 );
			add_action( 'elementor/page_templates/canvas/after_content', [ $this, 'do_footer' ], 0 );
		}
	}

	public function tci_uet_theme_builder_register_documents() {
		$this->docs_types = [
			'header' => TCI_UET_Documents\TCI_UET_Header::get_class_full_name(),
			'footer' => TCI_UET_Documents\TCI_UET_Footer::get_class_full_name(),
		];

		foreach ( $this->docs_types as $type => $class_name ) {
			Plugin::instance()->documents->register_document_type( $type, $class_name );
		}
	}

	public function theme_do_location( $location ) {
		/** @var Theme_Builder_Module $theme_builder_module */

		return $this->get_locations_manager()->do_location( $location );
	}

	public function do_header() {

		$this->theme_do_location( 'header' );
	}

	public function do_footer() {
		$this->theme_do_location( 'footer' );
	}

	public function get_locations_manager() {
		return $this->get_component( 'locations' );
	}

	public function tci_uet_theme_builder_template() {
		require_once tci_uet_root( 'classes/tci-uet-modules/tci-uet-theme-builder/tci-uet-documents/class-tci-uet-header.php' );
		require_once tci_uet_root( 'classes/tci-uet-modules/tci-uet-theme-builder/tci-uet-documents/class-tci-uet-footer.php' );
	}
}