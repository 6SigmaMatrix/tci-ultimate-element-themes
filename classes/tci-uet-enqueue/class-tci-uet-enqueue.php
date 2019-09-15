<?php
/**
 * TCI UET Enqueue
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.5
 */
namespace TCI_UET\TCI_UET_Enqueue_Base;

tci_uet_exit();

class TCI_UET_Enqueue extends TCI_UET_Enqueue_Base {

	/**
	 * Constructer
	 *
	 * @since  0.0.5
	 * @access public
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Register Style Files
	 *
	 * @since  0.0.5
	 * @access public
	 */
	public function tci_uet_enqueue_base_register_style() {
		$tci_style_array = [
			'tci-uet-grid'     => 'assets/css/tci-uet-grid.min.css',
			'tci-uet-frontend' => 'assets/css/tci-uet-frontend.css',
		];

		foreach ( $tci_style_array as $style_k => $style_v ) {
			wp_register_style( $style_k, tci_uet_uri( $style_v ) );
		}
	}

	/**
	 * Register Script Files
	 *
	 * @since  0.0.5
	 * @access public
	 */
	public function tci_uet_enqueue_base_register_script() {
		$tci_script_array = [
			'tci-uet-nav-menu' => 'assets/js/tci-uet-nav-menu.min.js',
			'tci-uet-typeit'   => 'assets/js/tci-uet-typeit.min.js',
			'tci-uet-vticker'  => 'assets/js/tci-uet-vticker.min.js',
			'tci-uet-frontend' => 'assets/js/tci-uet-frontend.js',
		];

		foreach ( $tci_script_array as $script_k => $script_v ) {
			wp_register_script( $script_k, tci_uet_uri( $script_v ), '', '', true );
		}
	}

	/**
	 * Print Editor Style Files
	 *
	 * @since  0.0.5
	 * @access public
	 */
	public function tci_uet_enqueue_base_editor_style() {
		$tci_style_array = [
			'tci-uet-icons'  => 'assets/css/tci-uet-icons.css',
			'tci-uet-editor' => 'assets/css/tci-uet-editor.css',
		];

		foreach ( $tci_style_array as $style_k => $style_v ) {
			wp_enqueue_style( $style_k, tci_uet_uri( $style_v ) );
		}
	}

	/**
	 * Print Editor Script Files
	 *
	 * @since  0.0.5
	 * @access public
	 */
	public function tci_uet_enqueue_base_editor_script() {
		$tci_script_array = [
			//	'tci-uet-template-editor'       => 'assets/js/tci-uet-template-editor.js',
			'tci-uet-editor' => 'assets/js/tci-uet-editor.js',
		];

		foreach ( $tci_script_array as $script_k => $script_v ) {
			wp_enqueue_script( $script_k, tci_uet_uri( $script_v ), '', '', true );
		}
	}

	/**
	 * Print Admin Script
	 *
	 * @since  0.0.5
	 * @access public
	 */
	public function tci_uet_enqueue_base_admin_script() {
		$tci_script_array = [
			'tci-uet-elementor-admin' => 'assets/js/tci-uet-elementor-admin.js',
		];

		foreach ( $tci_script_array as $script_k => $script_v ) {
			wp_enqueue_script( $script_k, tci_uet_uri( $script_v ), [ 'jquery' ], '', true );
		}
	}

	/**
	 * Localize
	 *
	 * @since  0.0.5
	 * @access public
	 */
	public function tci_uet_enqueue_base_localize_frontend_script() {
		$localize_data = [
			'tci_uet_ajaxurl' => admin_url( 'admin-ajax.php' ),
			'tci_uet_nonce'   => wp_create_nonce( 'tci_uet_nonce' ),
		];
		$localize_data = apply_filters( 'tci_uet/frontend/localize', $localize_data );
		wp_localize_script( 'jquery', 'tci_uet_localize', $localize_data );
	}

	/**
	 * Localize
	 *
	 * @since  0.0.5
	 * @access public
	 */
	public function tci_uet_enqueue_base_localize_editor_script() {
		$localize_data = [
			'tci_uet_ajaxurl' => admin_url( 'admin-ajax.php' ),
			'tci_uet_nonce'   => wp_create_nonce( 'tci_uet_nonce' ),
		];
		$localize_data = apply_filters( 'tci_uet/backend/localize', $localize_data );
		wp_localize_script( 'jquery', 'tci_uet_localize', $localize_data );
	}

	/**
	 * Editor Preview
	 *
	 * @since  0.0.5
	 * @access public
	 */
	public function tci_uet_enqueue_base_editor_preview_style() {
		$style = "
		.elementor-add-section-area-button.tci-uet-add-section-button{background-color:#ffcc00;color:#000;margin-right:5px;}
		.elementor-add-section-area-button.tci-uet-add-section-button:hover{color:#fff;}
		";
		wp_add_inline_style( 'editor-preview', $style );
	}

	/**
	 * Frontend Enqueue
	 *
	 * @since  0.0.5
	 * @access public
	 */
	public function tci_uet_enqueue_base_frontend_script() {
		wp_enqueue_style('tci-uet-frontend');
		wp_enqueue_script('tci-uet-frontend');
	}
}
