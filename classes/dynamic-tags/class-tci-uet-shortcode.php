<?php
namespace TCI_UET\Dynamic_Tag\TCI_Dynamic_Tags_Modules;

use Elementor\Core\DynamicTags\Tag;
use Elementor\Controls_Manager;
use Elementor\Modules\DynamicTags\Module;
use TCI_UET\Dynamic_Tag\TCI_Dynamic_Tags_Modules;

class TCI_UET_Shortcode extends Tag {
	public function get_name() {
		return 'shortcode';
	}

	public function get_title() {
		return __( 'Shortcode', 'tci-uet' );
	}

	public function get_group() {
		return TCI_Dynamic_Tags_Modules::SITE_GROUP;
	}

	public function get_categories() {
		return [
			Module::TEXT_CATEGORY,
			Module::URL_CATEGORY,
			Module::POST_META_CATEGORY,
			Module::GALLERY_CATEGORY,
			Module::IMAGE_CATEGORY,
			Module::MEDIA_CATEGORY,
		];
	}

	protected function _register_controls() {
		$this->add_control(
			'shortcode',
			[
				'label' => __( 'Shortcode', 'tci-uet' ),
				'type'  => Controls_Manager::TEXTAREA,
			]
		);
	}

	public function render() {
		$settings = $this->get_settings();

		if ( empty( $settings['shortcode'] ) ) {
			return;
		}

		$shortcode_string = $settings['shortcode'];

		$value = do_shortcode( $shortcode_string );

		/**
		 * Should Escape.
		 *
		 * Used to allow 3rd party to avoid shortcode dynamic from escaping
		 *
		 * @since 2.2.1
		 *
		 * @param bool defaults to true
		 */
		$should_escape = apply_filters( 'elementor_pro/dynamic_tags/shortcode/should_escape', true );

		if ( $should_escape ) {
			$value = wp_kses_post( $value );
		}

		echo $value;
	}
}
