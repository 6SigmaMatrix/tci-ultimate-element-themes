<?php
namespace TCI_UET\Dynamic_Tag\TCI_Dynamic_Tags_Modules;

use Elementor\Core\DynamicTags\Data_Tag;
use Elementor\Modules\DynamicTags\Module;
use TCI_UET\Dynamic_Tag\TCI_Dynamic_Tags_Modules;

class TCI_UET_Comments_Url extends Data_Tag {

	public function get_name() {
		return 'TCI_UET_Comments_Url';
	}

	public function get_title() {
		return __( 'Comments URL', 'tci-uet' );
	}

	public function get_group() {
		return TCI_Dynamic_Tags_Modules::COMMENTS_GROUP;
	}

	public function get_categories() {
		return [ Module::URL_CATEGORY ];
	}

	public function get_value( array $options = [] ) {
		return get_comments_link();
	}
}
