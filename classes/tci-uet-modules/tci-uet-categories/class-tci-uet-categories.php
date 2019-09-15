<?php
/**
 * TCI UET Elementor Category class
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.7
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
		add_action( 'elementor/elements/categories_registered', [ $this, 'tci_uet_categories_reg' ] );
	}

	/**
	 * Category List
	 *
	 * @since  0.0.7
	 * @access public
	 */
	public static function tci_uet_categories_list() {
		return [
			'tci-uet-global-widgets'      => [
				'title' => __( 'TCI UET Global Elements', 'tci-uet' ),
				'icon'  => 'eicon-library-open',
			],
			'tci-uet-forms-widgets'       => [
				'title' => __( 'TCI UET Forms Elements', 'tci-uet' ),
				'icon'  => 'eicon-library-open',
			],
			'tci-uet-separator-widgets'   => [
				'title' => __( 'TCI UET Separator Elements', 'tci-uet' ),
				'icon'  => 'eicon-library-open',
			],
			'tci-uet-single-widgets'      => [
				'title' => __( 'TCI UET Single Elements', 'tci-uet' ),
				'icon'  => 'eicon-library-open',
			],
			'tci-uet-site-widgets'        => [
				'title' => __( 'TCI UET Site Elements', 'tci-uet' ),
				'icon'  => 'eicon-library-open',
			],
			'tci-uet-slider-widgets'      => [
				'title' => __( 'TCI UET Sliders Elements', 'tci-uet' ),
				'icon'  => 'eicon-library-open',
			],
			'tci-uet-woocommerce-widgets' => [
				'title' => __( 'TCI UET WooCommerce Elements', 'tci-uet' ),
				'icon'  => 'eicon-library-open',
			],
		];
	}

	/**
	 * Category register
	 *
	 * @since  0.0.7
	 * @access public
	 */
	public function tci_uet_categories_reg( $elements_manager ) {
		$categories                       = $this->tci_uet_categories_list();
		$categories['tci-uet-wp-widgets'] = [
			'title' => __( 'TCI UET WP Widgets', 'tci-uet' ),
			'icon'  => 'eicon-library-open',
		];
		foreach ( $categories as $k => $v ) {
			$elements_manager->add_category( $k, $v );
		}
	}
}
