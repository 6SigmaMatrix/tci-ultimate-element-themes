<?php
namespace TCI_UET\TCI_UET_Modules\TCI_UET_Documents;

use Elementor\Modules\Library\Documents\Library_Document;
use Elementor\Core\DocumentTypes\Post;


/**
 * Elementor section library document.
 * Elementor section library document handler class is responsible for
 * handling a document of a section type.
 *
 * @since 2.0.0
 */
class TCI_UET_Footer extends Library_Document {

	public static function get_properties() {
		$properties = parent::get_properties();

		$properties['location'] = 'footer';

		return $properties;
	}

	public function get_name() {
		return 'footer';
	}

	public static function get_title() {
		return __( 'Footer', 'auxin-elements' );
	}

	public function get_css_wrapper_selector() {
		return '.elementor-' . $this->get_main_id();
	}

	protected static function get_editor_panel_categories() {
		// Move to top as active.
		$categories = [
			'auxin-theme-elements' => [
				'title'  => __( 'Site', 'auxin-elements' ),
				'active' => true,
			],
		];

		return $categories + parent::get_editor_panel_categories();
	}


	protected function _register_controls() {
		parent::_register_controls();

		Post::register_style_controls( $this );
	}
}