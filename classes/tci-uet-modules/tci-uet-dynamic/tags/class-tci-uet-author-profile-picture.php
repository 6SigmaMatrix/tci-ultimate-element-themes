<?php
namespace TCI_UET\TCI_UET_Modules\TCI_UET_Dynamic;

use Elementor\Modules\DynamicTags\Module;
use Elementor\Core\DynamicTags\Data_Tag;
use TCI_UET\TCI_UET_Modules\TCI_UET_Dynamic;

class TCI_UET_Author_Profile_Picture extends Data_Tag {

	public function get_name() {
		return 'TCI_UET_Author_Profile_Picture';
	}

	public function get_title() {
		return __( 'Author Profile Picture', 'tci-uet' );
	}

	public function get_group() {
		return TCI_UET_Dynamic::AUTHOR_GROUP;
	}

	public function get_categories() {
		return [ Module::IMAGE_CATEGORY ];
	}

	public function get_value( array $options = [] ) {
		Utils::set_global_authordata();

		return [
			'id'  => '',
			'url' => get_avatar_url( (int) get_the_author_meta( 'ID' ) ),
		];
	}
}
