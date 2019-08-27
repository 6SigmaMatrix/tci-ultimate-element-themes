<?php
/**
 * TCI UET Init class
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.2
 */
namespace TCI_UET\Classes;

tci_exit();

class TCI_Init {
	/**
	 * Constructer
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'tci_init_fire' ] );
		add_action( 'admin_init', [ $this, 'tci_admin_init' ] );
		//add_action( 'after_setup_theme', 'tci_setup_theme', 20 );
		add_action( 'widgets_init', [ $this, 'register_wp_widgets' ] );
	}

	/**
	 * Fired by `init` action hook.
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function tci_init_fire() {
		load_plugin_textdomain( 'tci-uet' );
		do_action( 'tci_uet/plugins/post_type' );
		do_action( 'tci_uet/plugins/taxonomy' );
		do_action( 'tci_uet/redux' );
		tci_get_wp_color_scheme();
	}

	/**
	 * Fired by `admin_init` action hook.
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function tci_admin_init() {
		add_action( 'admin_init', [ '\TCI_UET\TCI_Modules\TCI_Role_Manager', 'remove_restrictions' ], 100 );
		tci_redux_get_opt();
	}

	/**
	 * Register Widget
	 *
	 * @since  0.0.1
	 * @access static
	 */
	public function register_wp_widgets() {
		register_widget( '\TCI_UET\TCI_Modules\TCI_UET_Widget_Elementor_Library' );
	}
}
