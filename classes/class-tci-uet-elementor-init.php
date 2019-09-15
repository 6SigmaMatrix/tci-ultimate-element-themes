<?php
/**
 * TCI UET Elementor class
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.6
 */
namespace TCI_UET;

tci_uet_exit();

use Elementor\Plugin;
use TCI_UET\TCI_UET_Modules\TCI_UET_Categories;

final class TCI_UET_Elementor_Init {

	/**
	 * Constructer
	 *
	 * @since  0.0.5
	 * @access public
	 */
	public function __construct() {
		$this->tci_uet_elementor_init_modules();
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'tci_uet_init_widgets' ] );
	}

	/**
	 * Init Widgets
	 * Include widgets files and register them
	 *
	 * @since  0.0.5
	 * @access public
	 */
	public function tci_uet_init_widgets() {

		foreach ( TCI_UET_Categories::tci_uet_categories_list() as $category => $name ) {

			$elements = tci_uet_dir_files_list( tci_uet_root( "classes/tci-uet-widgets/{$category}/" ) );
			$space    = implode( '_', tci_uet_generate_class_name( 'class-' . $category ) );
			$method   = 'tci_uet_init_' . str_replace( [ 'tci-uet-', '-' ], [ '', '_' ], $category );
			if ( method_exists( $this, $method ) ) {
				call_user_func( [ $this, $method ], compact( 'elements', 'space' ) );
			}

		}

		/*foreach ( $tci_uet_elements as $element ) {

			if ( strpos( $element, 'tci-uet-wp-widget' ) == true ) {
				$this->tci_uet_init_wp_widget( $element );
				continue;
			}

			include $element;
			$class_name = __NAMESPACE__ . '\\TCI_UET_Widgets\\' . implode( '_', tci_uet_generate_class_name( $element ) );
			// Register widget
			Plugin::instance()->widgets_manager->register_widget_type( new $class_name() );
		}

		$this->tci_uet_init_woocommerce_widget();*/

		$this->tci_uet_init_wp_widgets();

	}

	/**
	 * Init For Forms Widgets
	 * Include widgets files and register them
	 *
	 * @since  0.0.8
	 * @access public
	 */
	private function tci_uet_init_forms_widgets( $data_set ) {

		foreach ( $data_set['elements'] as $element ) {
			include $element;
			$class_name = __NAMESPACE__ . "\\TCI_UET_Widgets\\{$data_set['space']}\\" . implode( '_', tci_uet_generate_class_name( $element ) );
			Plugin::instance()->widgets_manager->register_widget_type( new $class_name() );
		}
	}

	/**
	 * Init For Global Widgets
	 * Include widgets files and register them
	 *
	 * @since  0.0.8
	 * @access public
	 */
	private function tci_uet_init_global_widgets( $data_set ) {

		foreach ( $data_set['elements'] as $element ) {
			include $element;
			$class_name = __NAMESPACE__ . "\\TCI_UET_Widgets\\{$data_set['space']}\\" . implode( '_', tci_uet_generate_class_name( $element ) );
			Plugin::instance()->widgets_manager->register_widget_type( new $class_name() );
		}
	}

	/**
	 * Init For Separator Widgets
	 * Include widgets files and register them
	 *
	 * @since  0.0.8
	 * @access public
	 */
	private function tci_uet_init_separator_widgets( $data_set ) {

		foreach ( $data_set['elements'] as $element ) {
			include $element;
			$class_name = __NAMESPACE__ . "\\TCI_UET_Widgets\\{$data_set['space']}\\" . implode( '_', tci_uet_generate_class_name( $element ) );
			Plugin::instance()->widgets_manager->register_widget_type( new $class_name() );
		}
	}

	/**
	 * Init For Single Widgets
	 * Include widgets files and register them
	 *
	 * @since  0.0.8
	 * @access public
	 */
	private function tci_uet_init_single_widgets( $data_set ) {

		foreach ( $data_set['elements'] as $element ) {
			include $element;
			$class_name = __NAMESPACE__ . "\\TCI_UET_Widgets\\{$data_set['space']}\\" . implode( '_', tci_uet_generate_class_name( $element ) );
			Plugin::instance()->widgets_manager->register_widget_type( new $class_name() );
		}
	}

	/**
	 * Init For Site Widgets
	 * Include widgets files and register them
	 *
	 * @since  0.0.8
	 * @access public
	 */
	private function tci_uet_init_site_widgets( $data_set ) {

		foreach ( $data_set['elements'] as $element ) {
			include $element;
			$class_name = __NAMESPACE__ . "\\TCI_UET_Widgets\\{$data_set['space']}\\" . implode( '_', tci_uet_generate_class_name( $element ) );
			Plugin::instance()->widgets_manager->register_widget_type( new $class_name() );
		}
	}

	/**
	 * Init For Slider Widgets
	 * Include widgets files and register them
	 *
	 * @since  0.0.8
	 * @access public
	 */
	private function tci_uet_init_slider_widgets( $data_set ) {

		foreach ( $data_set['elements'] as $element ) {
			include $element;
			$class_name = __NAMESPACE__ . "\\TCI_UET_Widgets\\{$data_set['space']}\\" . implode( '_', tci_uet_generate_class_name( $element ) );
			Plugin::instance()->widgets_manager->register_widget_type( new $class_name() );
		}
	}

	/**
	 * Init For WooCommerce Widgets
	 * Include widgets files and register them
	 *
	 * @since  0.0.8
	 * @access public
	 */
	private function tci_uet_init_woocommerce_widgets( $data_set ) {

		foreach ( $data_set['elements'] as $element ) {
			include $element;
			$class_name = __NAMESPACE__ . "\\TCI_UET_Widgets\\{$data_set['space']}\\" . implode( '_', tci_uet_generate_class_name( $element ) );
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
	private function tci_uet_init_wp_widgets() {

		global $wp_widget_factory;
		$file = 'classes/tci-uet-widgets/tci-uet-wp-widgets/class-tci-uet-wp-widget.php';
		include tci_uet_root( $file );
		include tci_uet_root( 'classes/tci-uet-widgets/tci-uet-wp-widgets/class-tci-uet-wp-widget-commen.php' );

		foreach ( $wp_widget_factory->widgets as $widget_class => $widget_obj ) {
			//unregister widget
			Plugin::instance()->widgets_manager->unregister_widget_type( 'wp-widget-' . $widget_obj->id_base );

			$class_name = __NAMESPACE__ . '\\TCI_UET_Widgets\TCI_UET_WP_Widgets\\' . implode( '_', tci_uet_generate_class_name( $file ) );
			$object     = new $class_name( [], [
				'widget_name' => $widget_class,
			] );

			$widget_file_name = 'class-tci-uet-' . str_replace( '_', '-', strtolower( $widget_class ) );
			$widget_file      = tci_uet_root( "classes/tci-uet-widgets/tci-uet-wp-widgets/{$widget_file_name}.php" );

			if ( file_exists( $widget_file ) ) {
				include $widget_file;
				$class_name                 = __NAMESPACE__ . '\\TCI_UET_Widgets\TCI_UET_WP_Widgets\\' . implode( '_', tci_uet_generate_class_name( $widget_file ) );
				$object->_register_controls = new TCI_UET_Widgets\TCI_UET_WP_Widgets\TCI_UET_Wp_Widget_Commen( $object, $class_name::register_controls( $object ) );
			} else {
				$object->_register_controls = new TCI_UET_Widgets\TCI_UET_WP_Widgets\TCI_UET_Wp_Widget_Commen( $object );
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
	private function tci_uet_elementor_init_modules() {
		require_once tci_uet_root( 'classes/tci-uet-modules/class-tci-uet-modules.php' );
		new TCI_UET_Modules();
	}
}
