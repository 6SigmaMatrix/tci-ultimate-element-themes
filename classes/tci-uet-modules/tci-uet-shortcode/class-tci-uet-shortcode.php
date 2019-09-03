<?php
/**
 * TCI UET Template Shortcode Generator
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.1
 */
namespace TCI_UET\TCI_UET_Modules;

tci_uet_exit();

use Elementor\TemplateLibrary\Source_Local;
use Elementor\Plugin;
use TCI_UET\TCI_UET_Modules;

class TCI_UET_Shortcode extends TCI_UET_Modules {
	/**
	 * Constant
	 *
	 * @since  0.0.1
	 * @access static
	 */
	const TCI_TUET_SHORTCODE = 'tci-uet-template';

	/**
	 * Constructer
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function __construct() {
		$this->tci_uet_shortcode_add_actions();
	}

	/**
	 * Add Admin Column Header
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function tci_uet_shortcode_admin_columns_headers( $defaults ) {
		$defaults['tci_uet_shortcode'] = __( 'TCI UET Shortcode', 'tci-uet' );

		return $defaults;
	}

	/**
	 * Add Admin Column Content
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function tci_uet_shortcode_admin_columns_content( $column_name, $post_id ) {
		if ( 'tci_uet_shortcode' === $column_name ) {
			// %s = shortcode, %d = post_id
			$shortcode = esc_attr( sprintf( '[%s id="%d"]', self::TCI_TUET_SHORTCODE, $post_id ) );
			printf( '<input class="tci-uet-shortcode-input" type="text" readonly onfocus="this.select()" value="%s" />', $shortcode );
		}
	}

	/**
	 * Shortcode
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function tci_uet_shortcode( $attributes = [] ) {
		if ( empty( $attributes['id'] ) ) {
			return '';
		}

		$include_css = false;

		if ( isset( $attributes['css'] ) && 'false' !== $attributes['css'] ) {
			$include_css = (bool) $attributes['css'];
		}

		return Plugin::instance()->frontend->get_builder_content_for_display( $attributes['id'], $include_css );
	}

	/**
	 * Patch Admin Column
	 *
	 * @since  0.0.1
	 * @access public
	 */
	private function tci_uet_shortcode_add_actions() {
		if ( is_admin() ) {
			add_action( 'manage_' . Source_Local::CPT . '_posts_columns', [ $this, 'tci_uet_shortcode_admin_columns_headers' ] );
			add_action( 'manage_' . Source_Local::CPT . '_posts_custom_column', [
				$this,
				'tci_uet_shortcode_admin_columns_content',
			], 10, 2 );
		}

		add_shortcode( self::TCI_TUET_SHORTCODE, [ $this, 'tci_uet_shortcode' ] );
	}
}
