<?php
/**
 * TCI UET Init class
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.1
 */
namespace TCI_UET\TCI_UET_Modules;

tci_uet_exit();

use Elementor\Plugin;
use TCI_UET\TCI_UET_Modules;

class TCI_UET_Dynamic extends TCI_UET_Modules {
	/**
	 * Author Module Group Constant
	 *
	 * @version 0.0.1
	 */
	const AUTHOR_GROUP = 'tci-uet-author';

	/**
	 * Post Module Group Constant
	 *
	 * @version 0.0.1
	 */
	const POST_GROUP = 'tci-uet-post';

	/**
	 * Comments Module Group Constant
	 *
	 * @version 0.0.1
	 */
	const COMMENTS_GROUP = 'tci-uet-comments';

	/**
	 * Site Module Group Constant
	 *
	 * @version 0.0.1
	 */
	const SITE_GROUP = 'tci-uet-site';

	/**
	 * Archive Module Group Constant
	 *
	 * @version 0.0.1
	 */
	const ARCHIVE_GROUP = 'tci-uet-archive';

	/**
	 * Request Module Group Constant
	 *
	 * @version 0.0.1
	 */
	const REQUEST_GROUP = 'tci-uet-request';

	/**
	 * Media Module Group Constant
	 *
	 * @version 0.0.1
	 */
	const MEDIA_GROUP = 'tci-uet-media';

	/**
	 * Action Group Constant
	 *
	 * @version 0.0.1
	 */
	const ACTION_GROUP = 'tci-uet-action';

	/**
	 * Constructer
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function __construct() {

		add_action( 'elementor/dynamic_tags/register_tags', [ $this, 'tci_uet_dynamic_tags' ] );
	}

	/**
	 * Init Dynamic Tags
	 * Include dynamic tag files and register them
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function tci_uet_dynamic_tags( $dynamic_tags ) {
		$tci_uet_dynamic_tag_files = tci_uet_dir_files_list( tci_uet_root( "classes/tci-uet-modules/tci-uet-dynamic/tags/" ) );
		foreach ( $tci_uet_dynamic_tag_files as $dynamic ) {
			include $dynamic;
			$class_name = __NAMESPACE__ . '\\TCI_UET_Dynamic\\' . implode( '_', tci_uet_generate_class_name( $dynamic ) );
			foreach ( $this->tci_get_groups() as $k => $v ) {
				Plugin::$instance->dynamic_tags->register_group( $k, $v );
			}
			$dynamic_tags->register_tag( $class_name );
		}

	}

	/**
	 * Get modules group names
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function tci_get_groups() {
		return [
			self::POST_GROUP     => [
				'title' => __( 'TCI UET Post', 'tci-uet' ),
			],
			self::ARCHIVE_GROUP  => [
				'title' => __( 'TCI UET Archive', 'tci-uet' ),
			],
			self::SITE_GROUP     => [
				'title' => __( 'TCI UET Site', 'tci-uet' ),
			],
			self::MEDIA_GROUP    => [
				'title' => __( 'TCI UET Media', 'tci-uet' ),
			],
			self::ACTION_GROUP   => [
				'title' => __( 'TCI UET Actions', 'tci-uet' ),
			],
			self::AUTHOR_GROUP   => [
				'title' => __( 'TCI UET Author', 'tci-uet' ),
			],
			self::COMMENTS_GROUP => [
				'title' => __( 'TCI UET Comments', 'tci-uet' ),
			],
		];
	}
}

