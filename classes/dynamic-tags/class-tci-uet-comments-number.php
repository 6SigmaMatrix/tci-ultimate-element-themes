<?php
namespace TCI_UET\Dynamic_Tag\TCI_Dynamic_Tags_Modules;

use Elementor\Core\DynamicTags\Tag;
use Elementor\Modules\DynamicTags\Module;
use Elementor\Controls_Manager;
use TCI_UET\Dynamic_Tag\TCI_Dynamic_Tags_Modules;

class TCI_UET_Comments_Number extends Tag {

	public function get_name() {
		return 'TCI_UET_Comments_Number';
	}

	public function get_title() {
		return __( 'Comments Number', 'tci-uet' );
	}

	public function get_group() {
		return TCI_Dynamic_Tags_Modules::COMMENTS_GROUP;
	}

	public function get_categories() {
		return [ Module::TEXT_CATEGORY ];
	}

	protected function _register_controls() {
		$this->add_control(
			'format_no_comments',
			[
				'label'   => __( 'No Comments Format', 'tci-uet' ),
				'default' => __( 'No Responses', 'tci-uet' ),
			]
		);

		$this->add_control(
			'format_one_comments',
			[
				'label'   => __( 'One Comment Format', 'tci-uet' ),
				'default' => __( 'One Response', 'tci-uet' ),
			]
		);

		$this->add_control(
			'format_many_comments',
			[
				'label'   => __( 'Many Comment Format', 'tci-uet' ),
				'default' => __( '{number} Responses', 'tci-uet' ),
			]
		);

		$this->add_control(
			'link_to',
			[
				'label'   => __( 'Link', 'tci-uet' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''              => __( 'None', 'tci-uet' ),
					'comments_link' => __( 'Comments Link', 'tci-uet' ),
				],
			]
		);
	}

	public function render() {
		$settings = $this->get_settings();

		$comments_number = get_comments_number();

		if ( ! $comments_number ) {
			$count = $settings['format_no_comments'];
		} elseif ( 1 === $comments_number ) {
			$count = $settings['format_one_comments'];
		} else {
			$count = strtr( $settings['format_many_comments'], [
				'{number}' => number_format_i18n( $comments_number ),
			] );
		}

		if ( 'comments_link' === $this->get_settings( 'link_to' ) ) {
			$count = sprintf( '<a href="%s">%s</a>', get_comments_link(), $count );
		}

		echo wp_kses_post( $count );
	}
}
