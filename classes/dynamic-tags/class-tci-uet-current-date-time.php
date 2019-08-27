<?php
namespace TCI_UET\Dynamic_Tag\TCI_Dynamic_Tags_Modules;

use Elementor\Core\DynamicTags\Tag;
use Elementor\Modules\DynamicTags\Module;
use Elementor\Controls_Manager;
use TCI_UET\Dynamic_Tag\TCI_Dynamic_Tags_Modules;

class TCI_UET_Current_Date_Time extends Tag {
	public function get_name() {
		return 'TCI_UET_Current_Date_Time';
	}

	public function get_title() {
		return __( 'Current Date Time', 'tci-uet' );
	}

	public function get_group() {
		return TCI_Dynamic_Tags_Modules::SITE_GROUP;
	}

	public function get_categories() {
		return [ Module::TEXT_CATEGORY ];
	}

	protected function _register_controls() {
		$this->add_control(
			'date_format',
			[
				'label'   => __( 'Date Format', 'tci-uet' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'default' => __( 'Default', 'tci-uet' ),
					''        => __( 'None', 'tci-uet' ),
					'F j, Y'  => date( 'F j, Y' ),
					'Y-m-d'   => date( 'Y-m-d' ),
					'm/d/Y'   => date( 'm/d/Y' ),
					'd/m/Y'   => date( 'd/m/Y' ),
					'custom'  => __( 'Custom', 'tci-uet' ),
				],
				'default' => 'default',
			]
		);

		$this->add_control(
			'time_format',
			[
				'label'     => __( 'Time Format', 'tci-uet' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'default' => __( 'Default', 'tci-uet' ),
					''        => __( 'None', 'tci-uet' ),
					'g:i a'   => date( 'g:i a' ),
					'g:i A'   => date( 'g:i A' ),
					'H:i'     => date( 'H:i' ),
				],
				'default'   => 'default',
				'condition' => [
					'date_format!' => 'custom',
				],
			]
		);

		$this->add_control(
			'custom_format',
			[
				'label'       => __( 'Custom Format', 'tci-uet' ),
				'default'     => get_option( 'date_format' ) . ' ' . get_option( 'time_format' ),
				'description' => sprintf( '<a href="https://codex.wordpress.org/Formatting_Date_and_Time" target="_blank">%s</a>', __( 'Documentation on date and time formatting', 'tci-uet' ) ),
				'condition'   => [
					'date_format' => 'custom',
				],
			]
		);
	}

	public function render() {
		$settings = $this->get_settings();

		if ( 'custom' === $settings['date_format'] ) {
			$format = $settings['custom_format'];
		} else {
			$date_format = $settings['date_format'];
			$time_format = $settings['time_format'];
			$format      = '';

			if ( 'default' === $date_format ) {
				$date_format = get_option( 'date_format' );
			}

			if ( 'default' === $time_format ) {
				$time_format = get_option( 'time_format' );
			}

			if ( $date_format ) {
				$format   = $date_format;
				$has_date = true;
			} else {
				$has_date = false;
			}

			if ( $time_format ) {
				if ( $has_date ) {
					$format .= ' ';
				}
				$format .= $time_format;
			}
		}

		$value = date_i18n( $format );

		echo wp_kses_post( $value );
	}
}
