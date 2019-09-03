<?php
namespace TCI_UET\TCI_UET_Modules\TCI_UET_Dynamic;

use Elementor\Core\DynamicTags\Data_Tag;
use Elementor\Modules\DynamicTags\Module;
use TCI_UET\TCI_UET_Modules\TCI_UET_Dynamic;

class TCI_UET_Post_Gallery extends Data_Tag {

	public function get_name() {
		return 'TCI_UET_Post_Gallery';
	}

	public function get_title() {
		return __( 'Post Image Attachments', 'tci-uet' );
	}

	public function get_group() {
		return TCI_UET_Dynamic::POST_GROUP;
	}

	public function get_categories() {
		return [ Module::GALLERY_CATEGORY ];
	}

	public function get_value( array $options = [] ) {
		$images = get_attached_media( 'image' );

		$value = [];

		foreach ( $images as $image ) {
			$value[] = [
				'id' => $image->ID,
			];
		}

		return $value;
	}
}
