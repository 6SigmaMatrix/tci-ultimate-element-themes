<?php
namespace TCI_UET\Dynamic_Tag\TCI_Dynamic_Tags_Modules;

use Elementor\Core\DynamicTags\Tag;
use Elementor\Modules\DynamicTags\Module;
use TCI_UET\Dynamic_Tag\TCI_Dynamic_Tags_Modules;

class TCI_UET_Author_Name extends Tag {

	public function get_name() {
		return 'TCI_UET_Author_Name';
	}

	public function get_title() {
		return __( 'Author Name', 'tci-uet' );
	}

	public function get_group() {
		return TCI_Dynamic_Tags_Modules::AUTHOR_GROUP;
	}

	public function get_categories() {
		return [ Module::TEXT_CATEGORY ];
	}

	public function render() {
		echo wp_kses_post( get_the_author() );
	}
}
