<?php
namespace TCI_UET\TCI_UET_Modules\TCI_UET_Dynamic;

use Elementor\Core\DynamicTags\Tag;
use Elementor\Modules\DynamicTags\Module;
use TCI_UET\TCI_UET_Modules\TCI_UET_Dynamic;

class TCI_UET_Author_Meta extends Tag {

	public function get_name() {
		return 'TCI_UET_Author_Meta';
	}

	public function get_title() {
		return __( 'Author Meta', 'tci-uet' );
	}

	public function get_group() {
		return TCI_UET_Dynamic::AUTHOR_GROUP;
	}

	public function get_categories() {
		return [ Module::TEXT_CATEGORY ];
	}

	public function get_panel_template_setting_key() {
		return 'key';
	}

	public function render() {
		$key = $this->get_settings( 'key' );
		if ( empty( $key ) ) {
			return;
		}

		$value = get_the_author_meta( $key );

		echo wp_kses_post( $value );
	}

	protected function _register_controls() {
		$this->add_control(
			'key',
			[
				'label' => __( 'Meta Key', 'tci-uet' ),
			]
		);
	}
}
