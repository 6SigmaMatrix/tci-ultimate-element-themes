<?php
namespace TCI_UET\Dynamic_Tag\TCI_Dynamic_Tags_Modules;

use Elementor\Modules\DynamicTags\Module;
use TCI_UET\Dynamic_Tag\TCI_Dynamic_Tags_Modules;
use Elementor\Core\DynamicTags\Data_Tag;

class TCI_UET_Archive_Url extends Data_Tag {

	public function get_name() {
		return 'TCI_UET_Archive_Url';
	}

	public function get_group() {
		return TCI_Dynamic_Tags_Modules::ARCHIVE_GROUP;
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
		return tci_get_the_archive_url();
	}
}

