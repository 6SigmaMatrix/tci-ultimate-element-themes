<?php
namespace TCI_UET\TCI_UET_Modules\TCI_UET_Dynamic;

use TCI_UET\TCI_UET_Utils;
use Elementor\Modules\DynamicTags\Module;
use TCI_UET\TCI_UET_Modules\TCI_UET_Dynamic;
use Elementor\Core\DynamicTags\Data_Tag;

class TCI_UET_Archive_Url extends Data_Tag {

	public function get_name() {
		return 'TCI_UET_Archive_Url';
	}

	public function get_group() {
		return TCI_UET_Dynamic::ARCHIVE_GROUP;
	}

	public function get_categories() {
		return [ Module::URL_CATEGORY ];
	}

	public function get_title() {
		return __( 'Archive URL', 'tci-uet' );
	}

	public function get_panel_template() {
		return ' ({{ url }})';
	}

	public function get_value( array $options = [] ) {
		return TCI_UET_Utils::get_the_archive_url();
	}
}

