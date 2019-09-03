<?php
namespace TCI_UET\TCI_UET_Modules\TCI_UET_Dynamic;

use Elementor\Core\DynamicTags\Data_Tag;
use Elementor\Utils;
use Elementor\Modules\DynamicTags\Module;
use TCI_UET\TCI_UET_Modules\TCI_UET_Dynamic;

class TCI_UET_Site_Logo extends Data_Tag {
	public function get_name() {
		return 'TCI_UET_Site_Logo';
	}

	public function get_title() {
		return __( 'Site Logo', 'tci-uet' );
	}

	public function get_group() {
		return TCI_UET_Dynamic::SITE_GROUP;
	}

	public function get_categories() {
		return [ Module::IMAGE_CATEGORY ];
	}

	public function get_value( array $options = [] ) {
		$custom_logo_id = get_theme_mod( 'custom_logo' );

		if ( $custom_logo_id ) {
			$url = wp_get_attachment_image_src( $custom_logo_id, 'full' )[0];
		} else {
			$url = Utils::get_placeholder_image_src();
		}

		return [
			'id'  => $custom_logo_id,
			'url' => $url,
		];
	}
}
