<?php
/**
 * TCI UET Init class
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.5
 */
namespace TCI_UET;

tci_uet_exit();

final class TCI_UET_Init {
	/**
	 * Constructer
	 *
	 * @since  0.0.5
	 * @access public
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'tci_uet_init_fire' ] );
		$this->tci_uet_init_load();
	}

	/**
	 * Fired by `init` action hook.
	 *
	 * @since  0.0.5
	 * @access public
	 */
	public function tci_uet_init_fire() {
		load_plugin_textdomain( 'tci-uet' );
		do_action( 'tci_uet/plugins/post_type' );
		do_action( 'tci_uet/plugins/taxonomy' );
	}

	/**
	 * Register Elementor
	 *
	 * @since  0.0.5
	 * @access public
	 */
	public function tci_uet_init_load() {
		require_once tci_uet_root( 'vendor/autoload.php' );
		require_once tci_uet_root( 'classes/tci-uet-enqueue/class-tci-uet-enqueue-base.php' );
		require_once tci_uet_root( 'classes/tci-uet-enqueue/class-tci-uet-enqueue.php' );
		require_once tci_uet_root( 'classes/class-tci-uet-ajax.php' );
		require_once tci_uet_root( 'classes/class-tci-uet-utils.php' );
		require_once tci_uet_root( 'classes/class-tci-uet-elementor-init.php' );

		new TCI_UET_Enqueue_Base\TCI_UET_Enqueue();
		new TCI_UET_Elementor_Init();
	}
}
