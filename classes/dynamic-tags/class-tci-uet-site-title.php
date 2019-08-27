<?php
namespace TCI_UET\Dynamic_Tag\TCI_Dynamic_Tags_Modules;

use Elementor\Core\DynamicTags\Tag;
use Elementor\Modules\DynamicTags\Module;
use TCI_UET\Dynamic_Tag\TCI_Dynamic_Tags_Modules;

class TCI_UET_Site_Title extends Tag {
	public function get_name() {
		return 'TCI_UET_Site_Title';
	}

	public function get_title() {
		return __( 'Site Title', 'tci-uet' );
	}

	public function get_group() {
		return TCI_Dynamic_Tags_Modules::SITE_GROUP;
	}

	public function get_categories() {
		return [ Module::TEXT_CATEGORY ];
	}

	public function render() {
		echo wp_kses_post( get_bloginfo() );
	}
}
