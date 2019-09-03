<?php
namespace TCI_UET\TCI_UET_Modules\TCI_UET_Dynamic;

use Elementor\Core\DynamicTags\Tag;
use Elementor\Controls_Manager;
use Elementor\Modules\DynamicTags\Module;
use TCI_UET\TCI_UET_Modules\TCI_UET_Dynamic;
use TCI_UET\TCI_UET_Modules\TCI_UET_Query_Control as QueryModule;


class TCI_UET_Post_Custom_Field extends Tag {

	public function get_name() {
		return 'TCI_UET_Post_Custom_Field';
	}

	public function get_title() {
		return __( 'Post Custom Field', 'tci-uet' );
	}

	public function get_group() {
		return TCI_UET_Dynamic::POST_GROUP;
	}

	public function get_categories() {
		return [
			Module::TEXT_CATEGORY,
			Module::URL_CATEGORY,
			Module::POST_META_CATEGORY,
		];
	}

	public function get_panel_template_setting_key() {
		return 'key';
	}

	public function is_settings_required() {
		return true;
	}

	protected function _register_controls() {

		$this->add_control(
			TCI_UET_SETTINGS . '_key_type',
			[
				'label'       => __( 'Type', 'tci-uet' ),
				'type'        => Controls_Manager::SELECT,
				'label_block' => true,
				'options'     => [
					'ct' => __( 'Current', 'tci-uet' ),
					'cm' => __( 'Custom', 'tci-uet' ),
				],
			]
		);

		$this->add_control(
			'key',
			[
				'label'       => __( 'Key', 'tci-uet' ),
				'type'        => Controls_Manager::SELECT2,
				'label_block' => true,
				'options'     => $this->get_current_keys_array(),
				'condition'   => [
					TCI_UET_SETTINGS . '_key_type' => 'ct',
				],
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_key_post_types',
			[
				'label'        => __( 'Search & Select Key', 'tci-uet' ),
				'type'         => QueryModule::QUERY_CONTROL_ID,
				'post_type'    => '',
				'options'      => [],
				'label_block'  => true,
				'filter_type'  => 'post_type_keys',
				'object_type'  => 'any',
				'include_type' => true,
				'condition'    => [
					TCI_UET_SETTINGS . '_key_type' => 'cm',
				],
			]
		);
	}

	public function render() {
		$settings = $this->get_settings_for_display();
		$settings = tci_uet_array( $settings );

		if ( 'cm' === $settings->get( TCI_UET_SETTINGS . '_key_type' ) AND ! empty( $settings->get( TCI_UET_SETTINGS . '_key_post_types' ) ) ) {

			$data  = explode( ':', $settings->get( TCI_UET_SETTINGS . '_key_post_types' ) );
			$value = get_post_meta( $data[1], $data[0], true );

			echo wp_kses_post( $value );

		} else {
			if ( empty( $key ) ) {
				return;
			}

			$value = get_post_meta( get_the_ID(), $key, true );

			echo wp_kses_post( $value );
		}


	}

	private function get_current_keys_array() {
		$custom_keys = get_post_custom_keys();
		$options     = [
			'' => __( 'Select...', 'tci-uet' ),
		];

		if ( ! empty( $custom_keys ) ) {
			foreach ( $custom_keys as $custom_key ) {
				if ( '_' !== substr( $custom_key, 0, 1 ) ) {
					$options[ $custom_key ] = $custom_key;
				}
			}
		}

		return $options;
	}

}
