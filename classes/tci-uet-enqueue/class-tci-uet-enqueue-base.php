<?php
/**
 * TCI UET Enqueue
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.1
 */
namespace TCI_UET\TCI_UET_Enqueue_Base;

tci_uet_exit();

abstract class TCI_UET_Enqueue_Base {

	/**
	 * Constructer
	 *
	 * @since  0.0.5
	 * @access public
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'tci_uet_enqueue_base_register_style' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'tci_uet_enqueue_base_register_script' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'tci_uet_enqueue_base_admin_script' ] );
		add_action( 'elementor/editor/before_enqueue_scripts', [ $this, 'tci_uet_enqueue_base_editor_style' ] );
		add_action( 'elementor/editor/before_enqueue_scripts', [ $this, 'tci_uet_enqueue_base_editor_script' ] );
		add_action( 'elementor/editor/before_enqueue_scripts', [
			$this,
			'tci_uet_enqueue_base_localize_editor_script',
		] );
		add_action( 'wp_head', [ $this, 'tci_uet_enqueue_base_wp_head_style' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'tci_uet_enqueue_base_localize_frontend_script' ] );
	}

	/**
	 * Register Style Files
	 *
	 * @since  0.0.5
	 * @access public
	 */
	public function tci_uet_enqueue_base_register_style() { }

	/**
	 * Register Script Files
	 *
	 * @since  0.0.5
	 * @access public
	 */
	public function tci_uet_enqueue_base_register_script() { }

	/**
	 * Print Editor Style Files
	 *
	 * @since  0.0.5
	 * @access public
	 */
	public function tci_uet_enqueue_base_editor_style() { }

	/**
	 * Print Editor Script Files
	 *
	 * @since  0.0.5
	 * @access public
	 */
	public function tci_uet_enqueue_base_editor_script() { }

	/**
	 * Print Style on WP Head
	 *
	 * @since  0.0.5
	 * @access public
	 */
	public function tci_uet_enqueue_base_wp_head_style() {
		do_action( 'tci_uet/plugins/style' );
	}

	/**
	 * Print Admin Script
	 *
	 * @since  0.0.5
	 * @access public
	 */
	public function tci_uet_enqueue_base_admin_script() { }

	/**
	 * Localize
	 *
	 * @since  0.0.5
	 * @access public
	 */
	public function tci_uet_enqueue_base_localize_frontend_script() { }

	/**
	 * Localize
	 *
	 * @since  0.0.5
	 * @access public
	 */
	public function tci_uet_enqueue_base_localize_editor_script() { }
}