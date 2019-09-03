<?php
/**
 * TCI UET Modules Loader class
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.1
 */
namespace TCI_UET;

tci_uet_exit();

use Elementor\Core\Base\Module;

class TCI_UET_Modules extends Module {

	const TCI_UET_Module_Path = 'classes/tci-uet-modules/';

	public function __construct() {

		$tci_uet_module = [
			'categories',
			'custom-attributes',
			'custom-css',
			//'custom-fonts',
			'dynamic',
			//'global',
			'query-control',
			'role-manager',
			'shortcode',
			'social',
			//'sticky',
			//'theme-builder',
			'wp-widget',
		];

		foreach ( $tci_uet_module as $module_name ) {
			$module_file = tci_uet_root( self::TCI_UET_Module_Path . "tci-uet-{$module_name}/class-tci-uet-{$module_name}.php" );
			if ( file_exists( $module_file ) ) {
				require_once $module_file;
				$class_name = str_replace( '-', ' ', $module_name );
				$class_name = str_replace( ' ', '_', ucwords( $class_name ) );
				$class_name = __NAMESPACE__ . '\TCI_UET_Modules\\TCI_UET_' . $class_name;
				new $class_name();
			}
		}


		add_action( 'widgets_init', [ $this, 'tci_uet_modules_register_wp_widgets' ] );
		add_action( 'admin_init', [ $this, 'tci_uet_modules_admin_init' ] );
	}

	public function get_name() {
		return 'TCI_UET_Modules';
	}

	/**
	 * Register Widget
	 *
	 * @since  0.0.5
	 * @access public
	 */
	public function tci_uet_modules_register_wp_widgets() {
		register_widget( '\TCI_UET\TCI_UET_Modules\TCI_UET_Wp_Widget' );
	}

	/**
	 * Fired by `admin_init` action hook.
	 *
	 * @since  0.0.5
	 * @access public
	 */
	public function tci_uet_modules_admin_init() {
		if ( class_exists( '\TCI_UET\TCI_UET_Modules\TCI_UET_Role_Manager' ) ) {
			add_action( 'admin_init', [
				'\TCI_UET\TCI_UET_Modules\TCI_UET_Role_Manager',
				'tci_uet_role_manager_remove_restrictions',
			], 100 );
		}
	}
}
