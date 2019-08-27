<?php
/**
 * TCI UET Controls
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.1
 */
namespace TCI_UET\Controls;

tci_exit();

use Elementor\Plugin;
use Elementor\Core\Common\Modules\Ajax\Module as Ajax;

class TCI_Controls {
	const QUERY_CONTROL_ID = 'query';

	public static $displayed_ids = [];

	/**
	 * Constructer
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function __construct() {
		add_action( 'elementor/controls/controls_registered', [ $this, 'tci_register_controls' ] );
		add_action( 'elementor/controls/controls_registered', [ $this, 'tci_register_group_controls' ] );
		add_action( 'elementor/ajax/register_actions', [ $this, 'tci_register_ajax_actions' ] );
		add_filter( 'elementor/editor/localize_settings', [ $this, 'tci_localize_settings' ] );
	}

	/**
	 * Simple Controls
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function tci_register_controls() {
		$controls_folder = tci_dir_files_list( tci_root( "classes/simple-controls/" ) );

		$controls_manager = Plugin::$instance->controls_manager;
		foreach ( $controls_folder as $file ) {
			include $file;
			$class_name = __NAMESPACE__ . '\\' . implode( '_', tci_generate_class_name( $file ) );
			$controls_manager->register_control( $class_name::get_type(), new $class_name() );
		}

	}

	/**
	 * Group Controls
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function tci_register_group_controls() {
		$controls_folder = tci_dir_files_list( tci_root( "classes/group-controls/" ) );

		$controls_manager = Plugin::$instance->controls_manager;
		foreach ( $controls_folder as $file ) {
			include $file;
			$class_name = __NAMESPACE__ . '\\' . implode( '_', tci_generate_class_name( $file ) );
			$controls_manager->add_group_control( $class_name::get_type(), new $class_name() );
		}


	}


	/**
	 * @param Ajax $ajax_manager
	 */
	public function tci_register_ajax_actions( $ajax_manager ) {
		$ajax_manager->register_ajax_action( 'query_control_value_titles', [
			$this,
			'ajax_posts_control_value_titles',
		] );
		$ajax_manager->register_ajax_action( 'pro_panel_posts_control_filter_autocomplete', [
			$this,
			'ajax_posts_filter_autocomplete',
		] );
	}

	public function tci_localize_settings( $settings ) {
		$settings = array_replace_recursive( $settings, [
			'i18n' => [
				'all' => __( 'All', 'tci-uet' ),
			],
		] );

		return $settings;
	}

	public static function add_to_avoid_list( $ids ) {
		self::$displayed_ids = array_merge( self::$displayed_ids, $ids );
	}

	/**
	 * @param \ElementorPro\Base\Base_Widget $widget
	 * @param string                         $name
	 * @param array                          $query_args
	 * @param array                          $fallback_args
	 *
	 * @return \WP_Query
	 */
	public function get_query( $widget, $name, $query_args = [], $fallback_args = [] ) {
		$prefix    = $name . '_';
		$post_type = $widget->get_settings( $prefix . 'post_type' );
		if ( 'related' === $post_type ) {
			$elementor_query = new TCI_Related_Query( $widget, $name, $query_args, $fallback_args );
		} else {
			$elementor_query = new TCI_Post_Query( $widget, $name, $query_args );
		}

		return $elementor_query->get_query();
	}
}

new TCI_Controls();
