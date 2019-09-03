<?php
namespace TCI_UET\TCI_UET_Modules\TCI_UET_Dynamic;

use Elementor\Core\DynamicTags\Tag;
use Elementor\Controls_Manager;
use Elementor\Modules\DynamicTags\Module;
use TCI_UET\TCI_UET_Modules\TCI_UET_Dynamic;

class TCI_UET_User_Info extends Tag {

	public function get_name() {
		return 'TCI_UET_User_Info';
	}

	public function get_title() {
		return __( 'User Info', 'tci-uet' );
	}

	public function get_group() {
		return TCI_UET_Dynamic::SITE_GROUP;
	}

	public function get_categories() {
		return [ Module::TEXT_CATEGORY ];
	}

	public function render() {
		$type = $this->get_settings( 'type' );
		$user = wp_get_current_user();
		if ( empty( $type ) || 0 === $user->ID ) {
			return;
		}

		$value = '';
		switch ( $type ) {
			case 'login':
			case 'email':
			case 'url':
			case 'nicename':
				$field = 'user_' . $type;
				$value = isset( $user->$field ) ? $user->$field : '';
				break;
			case 'id':
			case 'description':
			case 'first_name':
			case 'last_name':
			case 'display_name':
				$value = isset( $user->$type ) ? $user->$type : '';
				break;
			case 'meta':
				$key = $this->get_settings( 'meta_key' );
				if ( ! empty( $key ) ) {
					$value = get_user_meta( $user->ID, $key, true );
				}
				break;
		}

		echo wp_kses_post( $value );
	}

	public function get_panel_template_setting_key() {
		return 'type';
	}

	protected function _register_controls() {
		$this->add_control(
			'type',
			[
				'label'   => __( 'Field', 'tci-uet' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''             => __( 'Choose', 'tci-uet' ),
					'id'           => __( 'ID', 'tci-uet' ),
					'display_name' => __( 'Display Name', 'tci-uet' ),
					'login'        => __( 'Username', 'tci-uet' ),
					'first_name'   => __( 'First Name', 'tci-uet' ),
					'last_name'    => __( 'Last Name', 'tci-uet' ),
					'description'  => __( 'Bio', 'tci-uet' ),
					'email'        => __( 'Email', 'tci-uet' ),
					'url'          => __( 'Website', 'tci-uet' ),
					'meta'         => __( 'User Meta', 'tci-uet' ),
				],
			]
		);

		$this->add_control(
			'meta_key',
			[
				'label'     => __( 'Meta Key', 'tci-uet' ),
				'condition' => [
					'type' => 'meta',
				],
			]
		);
	}
}
