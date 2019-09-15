<?php
namespace TCI_UET\TCI_UET_Modules\TCI_UET_Dynamic;

use Elementor\Core\DynamicTags\Tag;
use Elementor\Modules\DynamicTags\Module;
use Elementor\Controls_Manager;
use Elementor\Embed;
use TCI_UET\TCI_UET_Modules\TCI_UET_Dynamic;
use TCI_UET\TCI_UET_Utils;


class TCI_UET_Lightbox extends Tag {

	public function get_name() {
		return 'TCI_UET_Lightbox';
	}

	public function get_title() {
		return __( 'Lightbox', 'tci-uet' );
	}

	public function get_group() {
		return TCI_UET_Dynamic::ACTION_GROUP;
	}

	public function get_categories() {
		return [ Module::URL_CATEGORY ];
	}

	// Keep Empty to avoid default advanced section
	protected function register_advanced_section() {
	}

	public function _register_controls() {
		$this->add_control(
			'type',
			[
				'label'       => __( 'Type', 'tci-uet' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
					'video' => [
						'title' => __( 'Video', 'tci-uet' ),
						'icon'  => 'fa fa-video-camera',
					],
					'image' => [
						'title' => __( 'Image', 'tci-uet' ),
						'icon'  => 'fa fa-image',
					],
				],
			]
		);

		$this->add_control(
			'image',
			[
				'label'     => __( 'Image', 'tci-uet' ),
				'type'      => Controls_Manager::MEDIA,
				'condition' => [
					'type' => 'image',
				],
			]
		);

		$this->add_control(
			'video_url',
			[
				'label'       => __( 'Video URL', 'tci-uet' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'condition'   => [
					'type' => 'video',
				],
			]
		);
	}

	private function get_image_settings( $settings ) {
		return [
			'url'  => $settings['image']['url'],
			'type' => 'image',
		];
	}

	private function get_video_settings( $settings ) {
		$video_properties = Embed::get_video_properties( $settings['video_url'] );
		$video_url        = null;
		if ( ! $video_properties ) {
			$video_type = 'hosted';
			$video_url  = $settings['video_url'];
		} else {
			$video_type = $video_properties['provider'];
			$video_url  = Embed::get_embed_url( $settings['video_url'] );
		}

		if ( null === $video_url ) {
			return '';
		}

		return [
			'type'      => 'video',
			'videoType' => $video_type,
			'url'       => $video_url,
		];
	}

	public function render() {
		$settings = $this->get_settings();

		$value = [];

		if ( ! $settings['type'] ) {
			return;
		}

		if ( 'image' === $settings['type'] && $settings['image'] ) {
			$value = $this->get_image_settings( $settings );
		} elseif ( 'video' === $settings['type'] && $settings['video_url'] ) {
			$value = $this->get_video_settings( $settings );
		}

		if ( ! $value ) {
			return;
		}

		echo TCI_UET_Utils::create_action_url( 'lightbox', $value );
	}
}
