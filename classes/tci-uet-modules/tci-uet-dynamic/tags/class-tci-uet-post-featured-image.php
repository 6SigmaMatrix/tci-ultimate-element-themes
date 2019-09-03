<?php
namespace TCI_UET\TCI_UET_Modules\TCI_UET_Dynamic;

use Elementor\Controls_Manager;
use Elementor\Core\DynamicTags\Data_Tag;
use Elementor\Modules\DynamicTags\Module;
use TCI_UET\TCI_UET_Modules\TCI_UET_Dynamic;


class TCI_UET_Post_Featured_Image extends Data_Tag {

	public function get_name() {
		return 'TCI_UET_Post_Featured_Image';
	}

	public function get_group() {
		return TCI_UET_Dynamic::POST_GROUP;
	}

	public function get_categories() {
		return [ Module::IMAGE_CATEGORY ];
	}

	public function get_title() {
		return __( 'Featured Image', 'tci-uet' );
	}

	public function get_value( array $options = [] ) {
		$thumbnail_id = get_post_thumbnail_id();

		if ( $thumbnail_id ) {
			$image_data = [
				'id'  => $thumbnail_id,
				'url' => wp_get_attachment_image_src( $thumbnail_id, 'full' )[0],
			];
		} else {
			$image_data = $this->get_settings( 'fallback' );
		}

		return $image_data;
	}

	protected function _register_controls() {
		$this->add_control(
			'fallback',
			[
				'label' => __( 'Fallback', 'tci-uet' ),
				'type'  => Controls_Manager::MEDIA,
			]
		);
	}
}
