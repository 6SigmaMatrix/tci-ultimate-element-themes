<?php
namespace TCI_UET\TCI_UET_Modules\TCI_UET_Dynamic;

use Elementor\Core\DynamicTags\Tag;
use Elementor\Modules\DynamicTags\Module;
use Elementor\Controls_Manager;
use TCI_UET\TCI_UET_Modules\TCI_UET_Dynamic;

class TCI_UET_Featured_Image_Data extends Tag {

	public function get_name() {
		return 'TCI_UET_Featured_Image_Data';
	}

	public function get_group() {
		return TCI_UET_Dynamic::MEDIA_GROUP;
	}

	public function get_categories() {
		return [
			Module::TEXT_CATEGORY,
			Module::URL_CATEGORY,
			Module::POST_META_CATEGORY,
		];
	}

	public function get_title() {
		return __( 'Featured Image Data', 'tci-uet' );
	}

	private function get_attacment() {
		$settings = $this->get_settings();
		$id       = get_post_thumbnail_id();

		if ( ! $id ) {
			return false;
		}

		return get_post( $id );
	}

	public function render() {
		$settings   = $this->get_settings();
		$attachment = $this->get_attacment();

		if ( ! $attachment ) {
			return '';
		}

		$value = '';

		switch ( $settings['attachment_data'] ) {
			case 'alt':
				$value = get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true );
				break;
			case 'caption':
				$value = $attachment->post_excerpt;
				break;
			case 'description':
				$value = $attachment->post_content;
				break;
			case 'href':
				$value = get_permalink( $attachment->ID );
				break;
			case 'src':
				$value = $attachment->guid;
				break;
			case 'title':
				$value = $attachment->post_title;
				break;
		}
		echo wp_kses_post( $value );
	}

	protected function _register_controls() {

		$this->add_control(
			'attachment_data',
			[
				'label'   => __( 'Data', 'tci-uet' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'title',
				'options' => [
					'title'       => __( 'Title', 'tci-uet' ),
					'alt'         => __( 'Alt', 'tci-uet' ),
					'caption'     => __( 'Caption', 'tci-uet' ),
					'description' => __( 'Description', 'tci-uet' ),
					'src'         => __( 'File URL', 'tci-uet' ),
					'href'        => __( 'Attachment URL', 'tci-uet' ),
				],
			]
		);
	}
}
