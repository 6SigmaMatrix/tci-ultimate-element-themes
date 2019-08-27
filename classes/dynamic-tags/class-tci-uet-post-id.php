<?php
namespace TCI_UET\Dynamic_Tag\TCI_Dynamic_Tags_Modules;

use Elementor\Core\DynamicTags\Tag;
use Elementor\Modules\DynamicTags\Module;
use TCI_UET\Dynamic_Tag\TCI_Dynamic_Tags_Modules;

class TCI_UET_Post_Id extends Tag {
	public function get_name() {
		return 'TCI_UET_Post_ID';
	}

	public function get_title() {
		return __( 'Post ID', 'tci-uet' );
	}

	public function get_group() {
		return TCI_Dynamic_Tags_Modules::POST_GROUP;
	}

	public function get_categories() {
		return [ Module::TEXT_CATEGORY ];
	}

	public function render() {
		echo get_the_ID();
	}
}
