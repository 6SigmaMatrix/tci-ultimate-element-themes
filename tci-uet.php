<?php
/**
 * Plugin Name: TCI Ultimate Element Themes
 * Description: Themecat_Info(TCI) present the TCI Ultimate Element Themes. Plugin have the unlimited elements.
 * created themes.
 * Plugin URI: https://demo.themecat.org/tci-ultimate-elementor-themes
 * Author: Themecat_Info
 * Version: 0.0.5
 * Author URI: https://themecat.org/
 * Text Domain: tci-uet
 * Requires PHP: 7.0
 * Requires at least: 5.0
 * Tested up to: 5.2
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Domain Path: /languages/
 */


/**
 * Admin notice
 * Warning when the site doesn't have Elementor installed or activated.
 *
 * @since  0.0.5
 */
function tci_uet_admin_notice_missing_main_plugin() {

	$message = sprintf(
		esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'tci-uet' ),
		'<strong>' . esc_html__( 'TCI Ultimate Element Themes', 'tci-uet' ) . '</strong>',
		'<strong>' . esc_html__( 'Elementor', 'tci-uet' ) . '</strong>'
	);
	printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

}

if ( ! did_action( 'elementor/loaded' ) ) {
	add_action( 'admin_notices', 'tci_uet_admin_notice_missing_main_plugin' );

	return;
}

/**
 * Plugin DB settings
 *
 * @since  0.0.5
 */
define( 'TCI_UET_SETTINGS', 'tci_uet_uet_settings' );

/**
 * Plugin options
 *
 * @since  0.0.5
 */
define( 'TCI_UET', 'tci_uet_uet_main_' );

/**
 * Plugin Version
 *
 * @since  0.0.5
 */
define( 'TCI_UET_VERSION', '0.0.5' );

/**
 * Plugin file get form directory
 *
 * @since  0.0.5
 */
function tci_uet_root( $dir = '' ) {
	return plugin_dir_path( __FILE__ ) . $dir;
}

/**
 * Plugin file get form url
 *
 * @since  0.0.5
 */
function tci_uet_uri( $dir = '' ) {
	return plugin_dir_url( __FILE__ ) . $dir;
}

/**
 * Plugin file basename
 *
 * @since  0.0.5
 */
function tci_uet_basename() {
	return plugin_basename( __FILE__ );
}


/**
 * Fire on 'plugin_loaded'
 *
 * @since  0.0.5
 */
function tci_uet_plugin_loaded_action() {
	require tci_uet_root( 'inc/tci-uet-functions.php' );
	require tci_uet_root( 'classes/class-tci-uet-init.php' );
	new TCI_UET\TCI_UET_Init();
}

add_action( 'plugins_loaded', 'tci_uet_plugin_loaded_action', 0 );

