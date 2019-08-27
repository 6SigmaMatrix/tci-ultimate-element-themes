<?php
/**
 * TCI Ultimate Element Themes loader file
 */
/**
 * Plugin functions file
 */
require tci_root( 'inc/tci-functions.php' );

/**
 * Plugin main class file
 */
require tci_root( 'vendor/autoload.php' );
//require tci_root( 'classes/class-tci-ajax.php' );
//require tci_root( 'classes/class-tci-page-sites.php' );
//require tci_root( 'classes/class-tci-sites.php' );
//require tci_root( 'classes/class-tci-controls.php' );
//require tci_root( 'classes/class-tci-post-query.php' );
//require tci_root( 'classes/class-tci-related-query.php' );
//require tci_root( 'classes/class-tci-query-module.php' );
require tci_root( 'classes/class-tci-abstract-enqueue.php' );
require tci_root( 'classes/class-tci-enqueue.php' );
require tci_root( 'classes/class-tci-utils.php' );
require tci_root( 'classes/class-tci-init.php' );
require tci_root( 'classes/class-tci-elementor.php' );
require tci_root( 'classes/class-tci-dynamic-tags-modules.php' );
require tci_root( 'classes/modules/class-tci-custom-css.php' );
require tci_root( 'classes/modules/class-tci-role-manager.php' );
require tci_root( 'classes/modules/class-tci-template-shortcode.php' );
require tci_root( 'classes/modules/class-tci-widget-elementor-library.php' );
require tci_root( 'classes/modules/class-tci-custom-attributes.php' );
//require tci_root( 'classes/modules/class-tci-global-widget.php' );
//require tci_root( 'classes/modules/class-tci-global-load.php' );
//require tci_root( 'classes/modules/class-tci-global-widget-library.php' );
//require tci_root( 'classes/modules/custom-fonts/class-tci-assets-base.php' );
//require tci_root( 'classes/modules/custom-fonts/class-tci-font-base.php' );
//require tci_root( 'classes/modules/custom-fonts/class-tci-custom-fonts.php' );
//require tci_root( 'classes/modules/custom-fonts/class-tci-typekit-fonts.php' );
//require tci_root( 'classes/modules/custom-fonts/class-tci-fonts-manager.php' );
//require tci_root( 'classes/modules/class-tci-assets-manager.php' );
require tci_root( 'classes/modules/class-tci-facebook-sdk-manager.php' );
require tci_root( 'classes/modules/class-tci-modules.php' );

//new TCI_UET\Classes\TCI_Ajax();
new TCI_UET\Classes\TCI_Enqueue();
new TCI_UET\Classes\TCI_Init();
//new TCI_UET\Classes\TCI_Page_Sites();
//new TCI_UET\Classes\TCI_Sites();

if ( class_exists( '\Redux_Framework_Plugin' ) ) {
	require tci_root( 'classes/class-tci-redux.php' );
	require tci_root( 'classes/redux/class-tci-uet-main.php' );
}
