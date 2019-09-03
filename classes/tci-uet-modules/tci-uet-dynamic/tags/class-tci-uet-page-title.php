<?php
namespace TCI_UET\TCI_UET_Modules\TCI_UET_Dynamic;

use TCI_UET\TCI_UET_Utils;
use Elementor\Core\DynamicTags\Tag;
use Elementor\Modules\DynamicTags\Module;
use Elementor\Controls_Manager;
use TCI_UET\TCI_UET_Modules\TCI_UET_Dynamic;

class TCI_UET_Page_Title extends Tag {
	public function get_name() {
		return 'TCI_UET_Page_Title';
	}

	public function get_title() {
		return __( 'Page Title', 'tci-uet' );
	}

	public function get_group() {
		return TCI_UET_Dynamic::SITE_GROUP;
	}

	public function get_categories() {
		return [ Module::TEXT_CATEGORY ];
	}

	public function render() {
		if ( is_home() && 'yes' !== $this->get_settings( 'show_home_title' ) ) {
			return;
		}

		$include_context = 'yes' === $this->get_settings( 'include_context' );

		$title = TCI_UET_Utils::get_page_title( $include_context );

		echo wp_kses_post( $title );
	}

	protected function _register_controls() {
		$this->add_control(
			'include_context',
			[
				'label' => __( 'Include Context', 'tci-uet' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'show_home_title',
			[
				'label' => __( 'Show Home Title', 'tci-uet' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);
	}
}
