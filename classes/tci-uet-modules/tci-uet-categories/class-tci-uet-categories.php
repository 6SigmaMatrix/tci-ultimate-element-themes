<?php
/**
 * TCI UET Elementor Category class
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.5
 */
namespace TCI_UET\TCI_UET_Modules;

tci_uet_exit();

use TCI_UET\TCI_UET_Modules;

class TCI_UET_Categories extends TCI_UET_Modules {

	/**
	 * Constructer
	 *
	 * @since  0.0.5
	 * @access public
	 */
	public function __construct() {
		add_action( 'elementor/elements/categories_registered', [ $this, 'tci_uet_categories_get' ] );
	}

	/**
	 * Category List
	 *
	 * @since  0.0.5
	 * @access public
	 */
	public function tci_uet_categories_get( $elements_manager ) {
		$elemtner_category = [
			'tci-widget'         => [
				'title' => __( 'TCI UET Widgets', 'tci-uet' ),
				'icon'  => 'eicon-library-open',
			],
			'tci-widget-single'  => [
				'title' => __( 'TCI UET Single Widgets', 'tci-uet' ),
				'icon'  => 'eicon-library-open',
			],
			'tci-widget-site'    => [
				'title' => __( 'TCI UET Site Widgets', 'tci-uet' ),
				'icon'  => 'eicon-library-open',
			],
			'tci-widget-forms' => [
				'title' => __( 'TCI UET Form Widgets', 'tci-uet' ),
				'icon'  => 'eicon-library-open',
			],
			'tci-widget-slider' => [
				'title' => __( 'TCI UET Slider Widgets', 'tci-uet' ),
				'icon'  => 'eicon-library-open',
			],
			'tci-wp-widget'      => [
				'title' => __( 'TCI UET WP Widgets', 'tci-uet' ),
				'icon'  => 'eicon-library-open',
			],
		];

		foreach ( $elemtner_category as $k => $v ) {
			$elements_manager->add_category( $k, $v );
		}
	}
}
