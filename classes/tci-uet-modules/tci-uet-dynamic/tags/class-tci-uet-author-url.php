<?php
namespace TCI_UET\TCI_UET_Modules\TCI_UET_Dynamic;

use Elementor\Modules\DynamicTags\Module;
use Elementor\Core\DynamicTags\Data_Tag;
use Elementor\Controls_Manager;
use TCI_UET\TCI_UET_Modules\TCI_UET_Dynamic;

class TCI_UET_Author_Url extends Data_Tag {

	public function get_name() {
		return 'TCI_UET_Author_Url';
	}

	public function get_group() {
		return TCI_UET_Dynamic::AUTHOR_GROUP;
	}

	public function get_categories() {
		return [ Module::URL_CATEGORY ];
	}

	public function get_title() {
		return __( 'Author URL', 'tci-uet' );
	}

	public function get_panel_template_setting_key() {
		return 'url';
	}

	public function get_value( array $options = [] ) {
		$value = '';

		if ( 'archive' === $this->get_settings( 'url' ) ) {
			global $authordata;

			if ( $authordata ) {
				$value = get_author_posts_url( $authordata->ID, $authordata->user_nicename );
			}
		} else {
			$value = get_the_author_meta( 'url' );
		}

		return $value;
	}

	protected function _register_controls() {
		$this->add_control(
			'url',
			[
				'label' => __( 'URL', 'tci-uet' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'archive',
				'options' => [
					'archive' => __( 'Author Archive', 'tci-uet' ),
					'website' => __( 'Author Website', 'tci-uet' ),
				],
			]
		);
	}
}
