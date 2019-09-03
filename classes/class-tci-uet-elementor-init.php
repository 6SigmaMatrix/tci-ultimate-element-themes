<?php
/**
 * TCI UET Elementor class
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.5
 */
namespace TCI_UET;

tci_uet_exit();

use Elementor\Plugin;

final class TCI_UET_Elementor_Init {

	/**
	 * Constructer
	 *
	 * @since  0.0.5
	 * @access public
	 */
	public function __construct() {
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'tci_uet_init_widgets' ] );
		$this->tci_uet_uet_elementor_init_modules();
	}

	/**
	 * Init Widgets
	 * Include widgets files and register them
	 *
	 * @since  0.0.5
	 * @access public
	 */
	public function tci_uet_init_widgets() {

		$tci_uet_uet_elements = tci_uet_dir_files_list( tci_uet_root( "classes/tci-uet-widgets/tci-uet-elements/" ) );

		foreach ( $tci_uet_uet_elements as $element ) {

			if ( strpos( $element, 'tci-uet-wp-widget' ) == true ) {
				$this->tci_uet_init_wp_widget( $element );
				continue;
			}

			include $element;
			$class_name = __NAMESPACE__ . '\\TCI_UET_Widgets\\' . implode( '_', tci_uet_generate_class_name( $element ) );
			// Register widget
			Plugin::instance()->widgets_manager->register_widget_type( new $class_name() );
		}

	}

	/**
	 * Init For WP Widgets
	 * Include widgets files and register them
	 *
	 * @since  0.0.5
	 * @access public
	 */
	public function tci_uet_init_wp_widget( $file ) {

		global $wp_widget_factory;
		include $file;
		include tci_uet_root( 'classes/tci-uet-widgets/tci-uet-elements/wp-widgets/class-tci-uet-wp-widget-commen.php' );

		foreach ( $wp_widget_factory->widgets as $widget_class => $widget_obj ) {
			//unregister widget
			Plugin::instance()->widgets_manager->unregister_widget_type( 'wp-widget-' . $widget_obj->id_base );

			$class_name = __NAMESPACE__ . '\\TCI_UET_Widgets\\' . implode( '_', tci_uet_generate_class_name( $file ) );
			$object     = new $class_name( [], [
				'widget_name' => $widget_class,
			] );

			$widget_file_name = 'class-tci-uet-' . str_replace( '_', '-', strtolower( $widget_class ) );
			$widget_file      = tci_uet_root( "classes/tci-uet-widgets/tci-uet-elements/wp-widgets/{$widget_file_name}.php" );

			if ( file_exists( $widget_file ) ) {
				include $widget_file;
				$class_name                 = __NAMESPACE__ . '\\TCI_UET_Widgets\\' . implode( '_', tci_uet_generate_class_name( $widget_file ) );
				$object->_register_controls = new TCI_UET_Widgets\TCI_UET_Wp_Widget_Commen( $object, $class_name::register_controls( $object ) );
			} else {
				$object->_register_controls = new TCI_UET_Widgets\TCI_UET_Wp_Widget_Commen( $object );
			}
			//register widget
			Plugin::instance()->widgets_manager->register_widget_type( $object );
		}
	}

	/**
	 * Modules Init
	 *
	 * @since  0.0.5
	 * @access public
	 */
	public function tci_uet_uet_elementor_init_modules() {
		require_once tci_uet_root( 'classes/tci-uet-modules/class-tci-uet-modules.php' );
		new TCI_UET_Modules();
	}
}
