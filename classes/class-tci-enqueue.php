<?php
/**
 * TCI UET Enqueue
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.2
 */
namespace TCI_UET\Classes;

tci_exit();

class TCI_Enqueue extends TCI_Abstract_Enqueue {

	/**
	 * Constructer
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Register Style Files
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function tci_register_style() {
		$tci_style_array = [
			'tci-uet-grid'        => 'assets/css/tci-uet-grid.min.css',
			'tci-uet-nav-menu'    => 'assets/css/tci-uet-nav-menu.css',
			'tci-uet-search-form' => 'assets/css/tci-uet-search-form.css',
			'tci-uet-author-box'  => 'assets/css/tci-uet-author-box.css',
			'tci-uet-post-info'   => 'assets/css/tci-uet-post-info.css',
			'tci-uet-blockquote'  => 'assets/css/tci-uet-blockquote.css',
			'tci-uet-price-list'  => 'assets/css/tci-uet-price-list.css',
			'tci-uet-price-table' => 'assets/css/tci-uet-price-table.css',
		];

		foreach ( $tci_style_array as $style_k => $style_v ) {
			wp_register_style( $style_k, tci_uri( $style_v ) );
		}
	}

	/**
	 * Register Script Files
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function tci_register_script() {
		$tci_script_array = [
			'tci-uet-nav-menu' => 'assets/js/tci-uet-nav-menu.min.js',
			'tci-uet-typeit'   => 'assets/js/tci-uet-typeit.min.js',
			'tci-uet-vticker'  => 'assets/js/tci-uet-vticker.min.js',
			'tci-uet-frontend' => 'assets/js/tci-uet-frontend.js',
		];

		foreach ( $tci_script_array as $script_k => $script_v ) {
			wp_register_script( $script_k, tci_uri( $script_v ), '', '', true );
		}
	}

	/**
	 * Print Editor Style Files
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function tci_editor_style() {
		$tci_style_array = [
			'tci-uet-icons'  => 'assets/css/tci-uet-icons.css',
			'tci-uet-editor' => 'assets/css/tci-uet-editor.css',
		];

		foreach ( $tci_style_array as $style_k => $style_v ) {
			wp_enqueue_style( $style_k, tci_uri( $style_v ) );
		}
	}

	/**
	 * Print Editor Script Files
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function tci_editor_script() {
		/*	$tci_script_array = [
				'tci-uet-typeit' => 'assets/js/tci-uet-typeit.min.js',
			];

			foreach ( $tci_script_array as $script_k => $script_v ) {
				wp_enqueue_script( $script_k, tci_uri( $script_v ), [ 'jquery' ], '', true );
			}*/
	}

	/**
	 * Print Admin Script
	 *
	 * @since  0.0.3
	 * @access public
	 */
	public function tci_admin_script() {
		$tci_script_array = [
			'tci-uet-elementor-admin' => 'assets/js/tci-uet-elementor-admin.js',
		];

		foreach ( $tci_script_array as $script_k => $script_v ) {
			wp_enqueue_script( $script_k, tci_uri( $script_v ), [ 'jquery' ], '', true );
		}
	}

	/**
	 * Localize
	 *
	 * @since  0.0.3
	 * @access public
	 */
	public function tci_localize_frontend_script() {
		$localize_data = [
			'tci_uet_ajaxurl' => admin_url( 'admin-ajax.php' ),
			'tci_uet_nonce'   => wp_create_nonce( 'tci_uet_nonce' ),
		];
		$localize_data = apply_filters( 'tci_uet/frontend/localize', $localize_data );
		wp_localize_script( 'jquery', 'tci_uet_localize', $localize_data );
	}
}