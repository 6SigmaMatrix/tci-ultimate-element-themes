<?php
namespace TCI_UET\Dynamic_Tag\TCI_Dynamic_Tags_Modules;

use Elementor\Core\DynamicTags\Tag;
use Elementor\Modules\DynamicTags\Module;
use TCI_UET\Dynamic_Tag\TCI_Dynamic_Tags_Modules;

class TCI_UET_Archive_Description extends Tag {

	public function get_name() {
		return 'TCI_UET_Archive_Description';
	}

	public function get_title() {
		return __( 'Archive Description', 'tci-uet' );
	}

	public function get_group() {
		return TCI_Dynamic_Tags_Modules::ARCHIVE_GROUP;
	}

	public function get_categories() {
		return [ Module::TEXT_CATEGORY ];
	}

	public function render() {
		echo wp_kses_post( get_the_archive_description() );
	}
}
