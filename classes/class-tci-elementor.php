<?php
/**
 * TCI UET Elementor class
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.3
 */
namespace TCI_UET\Widgets;

tci_exit();

use Elementor\Plugin;

class TCI_Elementor {

	/**
	 * Constructer
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function __construct() {
		$this->tci_elementor_init();
	}

	/**
	 * Initialize the plugin
	 * Load the plugin only after Elementor (and other plugins) are loaded.
	 * Checks for basic plugin requirements, if one check fail don't continue,
	 * if all check have passed load the files required to run the plugin.
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function tci_elementor_init() {

		add_action( 'elementor/elements/categories_registered', [ $this, 'tci_register_cat' ] );
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'tci_init_widgets' ] );
		//		add_action( 'elementor/controls/controls_registered', [ $this, 'tci_init_controls' ] );
	}


	/**
	 * Init Widgets
	 * Include widgets files and register them
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function tci_init_widgets() {

		$elements_folder = tci_dir_files_list( tci_root( "classes/elements/" ) );

		$tci_element_files = [];
		if ( ! empty( $elements_folder ) ) {
			foreach ( $elements_folder as $element ) {
				$tci_element_files [] = $element;
			}
		}

		$tci_element_files = array_merge( $this->tci_plugin_element_files(), $tci_element_files );

		foreach ( $tci_element_files as $file ) {
			include $file;
			$class_name = __NAMESPACE__ . '\\' . implode( '_', tci_generate_class_name( $file ) );
			// Register widget
			Plugin::instance()->widgets_manager->register_widget_type( new $class_name() );
		}

	}

	/**
	 * Register elements category
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function tci_register_cat( $elements_manager ) {
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
			'tci-widget-plugins' => [
				'title' => __( 'TCI UET Plugins Widgets', 'tci-uet' ),
				'icon'  => 'eicon-library-open',
			],
		];

		foreach ( $elemtner_category as $k => $v ) {
			$elements_manager->add_category( $k, $v );
		}
	}

	/**
	 * Init Controls
	 * Include controls files and register them
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function tci_init_controls() {

		// Include Control files
		//require_once( __DIR__ . '/controls/test-control.php' );

		// Register control
		//\Elementor\Plugin::$instance->controls_manager->register_control( 'control-type-', new \Test_Control() );

	}

	/**
	 * plugins Elements Files
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function tci_plugin_element_files() {
		$plugin_element_files = [];
		foreach ( tci_active_plugins_dir() as $dir ) {
			$elements_folder = tci_dir_files_list( WP_PLUGIN_DIR . "/{$dir}/classes/elements/" );
			foreach ( $elements_folder as $element ) {
				$plugin_element_files [] = $element;
			}
		}

		return apply_filters( 'tci_plugin_element_files', $plugin_element_files );
	}
}

new TCI_Elementor();
