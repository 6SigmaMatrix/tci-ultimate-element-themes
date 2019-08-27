<?php
/**
 * TCI UET Enqueue
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.2
 */
namespace TCI_UET\Classes;

tci_exit();

abstract class TCI_Abstract_Enqueue {

	/**
	 * Constructer
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'tci_register_style' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'tci_register_script' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'tci_admin_script' ] );
		add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'tci_editor_style' ] );
		add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'tci_editor_script' ] );
		add_action( 'wp_head', [ $this, 'tci_wp_head_style' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'tci_localize_frontend_script' ] );
	}

	/**
	 * Register Style Files
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function tci_register_style() {
	}

	/**
	 * Register Script Files
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function tci_register_script() {
	}

	/**
	 * Print Editor Style Files
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function tci_editor_style() {
	}

	/**
	 * Print Editor Script Files
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function tci_editor_script() {
	}

	/**
	 * Print Style on WP Head
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function tci_wp_head_style() {
		do_action( 'tci_uet/plugins/style' );
	}

	/**
	 * Print Admin Script
	 *
	 * @since  0.0.3
	 * @access public
	 */
	public function tci_admin_script() {
	}

	/**
	 * Localize
	 *
	 * @since  0.0.3
	 * @access public
	 */
	public function tci_localize_frontend_script() {

	}
}