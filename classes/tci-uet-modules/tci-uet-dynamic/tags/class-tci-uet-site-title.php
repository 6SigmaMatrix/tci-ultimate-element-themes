<?php
namespace TCI_UET\TCI_UET_Modules\TCI_UET_Dynamic;

use Elementor\Core\DynamicTags\Tag;
use Elementor\Modules\DynamicTags\Module;
use TCI_UET\TCI_UET_Modules\TCI_UET_Dynamic;

class TCI_UET_Site_Title extends Tag {
	public function get_name() {
		return 'TCI_UET_Site_Title';
	}

	public function get_title() {
		return __( 'Site Title', 'tci-uet' );
	}

	public function get_group() {
		return TCI_UET_Dynamic::SITE_GROUP;
	}

	public function get_categories() {
		return [ Module::TEXT_CATEGORY ];
	}

	public function render() {
		echo wp_kses_post( get_bloginfo() );
	}
}
