<?php
/**
 * TCI UET Sites demo main class
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.1
 */
namespace TCI_UET\Classes;

tci_exit();

class TCI_Sites {
	/**
	 * API URL which is used to get the response from.
	 *
	 * @since  0.0.1
	 * @var    (String) URL
	 */
	public static $api_url;

	/**
	 * Instance of TCI_Sites
	 *
	 * @since  0.0.1
	 * @var    (Object) TCI_Sites
	 */
	private static $_instance = null;

	/**
	 * Instance of TCI_Sites.
	 *
	 * @since  0.0.1
	 * @return object Class object.
	 */
	public static function tci_instance() {
		if ( ! isset( self::$_instance ) ) {
			self::$_instance = new self;
		}

		return self::$_instance;
	}

	/**
	 * Constructor.
	 *
	 * @since  0.0.1
	 */
	public function __construct() {
		$this->tci_set_api_url();
		//$this->includes();
		//add_action( 'admin_notices', [ $this, 'tci_add_notice' ], 1 );
		add_action( 'admin_notices', [ $this, 'tci_admin_notices' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'tci_admin_enqueue' ] );
		// AJAX.
		/*add_action( 'wp_ajax_astra-required-plugins', [ $this, 'required_plugin' ] );
		add_action( 'wp_ajax_astra-required-plugin-activate', [ $this, 'required_plugin_activate' ] );*/
	}

	/**
	 * Add Admin Notice.
	 *
	 * @since  0.0.1
	 */
	public function tci_add_notice() {

		Astra_Sites_Notices::add_notice(
			array(
				'id'               => 'astra-theme-activation-nag',
				'type'             => 'error',
				'show_if'          => ( ! defined( 'ASTRA_THEME_SETTINGS' ) ) ? true : false,
				/* translators: 1: theme.php file*/
				'message'          => sprintf( __( 'Astra Theme needs to be active for you to use currently installed "%1$s" plugin. <a href="%2$s">Install & Activate Now</a>', 'tci-uet' ), ASTRA_SITES_NAME, esc_url( admin_url( 'themes.php?theme=astra' ) ) ),
				'dismissible'      => true,
				'dismissible-time' => WEEK_IN_SECONDS,
			)
		);
	}

	/**
	 * Admin Notices
	 *
	 * @since 0.0.1
	 * @return void
	 */
	public function tci_admin_notices() {

		if ( ! defined( 'TCI_SETTINGS' ) ) {
			return;
		}

		add_action( 'plugin_action_links_' . tci_basename(), [ $this, 'tci_action_links' ] );
	}

	/**
	 * Show action links on the plugin screen.
	 *
	 * @param   mixed $links Plugin Action links.
	 *
	 * @return  array
	 * @since 0.0.1
	 */
	public function tci_action_links( $links ) {
		$action_links = [
			'settings' => '<a href="' . admin_url( 'themes.php?page=tci-sites' ) . '" aria-label="' . esc_attr__( 'See Library', 'tci-uet' ) . '">' . __( 'See Library', 'tci-uet' ) . '</a>',
		];

		return array_merge( $action_links, $links );
	}

	/**
	 * Setter for $api_url
	 *
	 * @since  0.0.1
	 */
	public function tci_set_api_url() {

		self::$api_url = apply_filters( 'tci_sites_api_url', 'https://plugin.themecat.org/tci-ultimate-elementor-themes/wp-json/wp/v2/' );

	}

	/**
	 * Enqueue admin scripts.
	 *
	 * @param  string $hook Current hook name.
	 *
	 * @return void
	 * @since  0.0.1
	 */
	public function tci_admin_enqueue( $hook = '' ) {

		if ( 'appearance_page_tci-sites' !== $hook ) {
			return;
		}

		global $is_IE;

		if ( $is_IE ) {
			wp_enqueue_script( 'tci-sites-eventsource', tci_uri( 'assets/js/eventsource.min.js' ), [
				'jquery',
				'wp-util',
				'updates',
			], '', true );
		}

		// API.
		wp_register_script( 'tci-sites-api', tci_uri( 'assets/js/astra-sites-api.js' ), [ 'jquery' ], '', true );

		// Admin Page.
		wp_enqueue_style( 'tci-sites-admin', tci_uri( 'assets/css/admin.css' ), '', true );
		wp_enqueue_script( 'tci-sites-admin-page', tci_uri( 'assets/js/admin-page.js' ), [
			'jquery',
			'wp-util',
			'updates',
		], '', true );
		wp_enqueue_script( 'tci-sites-render-grid', tci_uri( 'assets/js/render-grid.js' ), [
			'wp-util',
			'tci-sites-api',
			'imagesloaded',
			'jquery',
		], '', true );

		$data = [
			'ApiURL'  => self::$api_url,
			'filters' => [
				'page_builder' => [
					'title'   => __( 'Page Builder', 'tci-uet' ),
					'slug'    => 'astra-site-page-builder',
					'trigger' => 'astra-api-category-loaded',
				],
				'categories'   => [
					'title'   => __( 'Categories', 'tci-uet' ),
					'slug'    => 'astra-site-category',
					'trigger' => 'astra-api-category-loaded',
				],
			],
		];
		wp_localize_script( 'tci-sites-api', 'tciSitesApi', $data );

		// Use this for premium demos.
		$request_params = apply_filters(
			'tci_sites_api_params', [
				'purchase_key' => '',
				'site_url'     => '',
				'par-page'     => 15,
			]
		);

		$data = apply_filters(
			'tci_sites_localize_vars',
			[
				'sites'    => $request_params,
				'settings' => [],
			]
		);

		wp_localize_script( 'tci-sites-render-grid', 'astraRenderGrid', $data );

		$data = apply_filters(
			'tci_sites_localize_vars',
			[
				'debug'           => ( ( defined( 'WP_DEBUG' ) && WP_DEBUG ) || isset( $_GET['debug'] ) ) ? true : false,
				'ajaxurl'         => esc_url( admin_url( 'admin-ajax.php' ) ),
				'siteURL'         => site_url(),
				'getProText'      => __( 'Purchase', 'tci-uet' ),
				'getProURL'       => esc_url( 'https://wpastra.com/agency/?utm_source=demo-import-panel&utm_campaign=astra-sites&utm_medium=wp-dashboard' ),
				'getUpgradeText'  => __( 'Upgrade', 'tci-uet' ),
				'getUpgradeURL'   => esc_url( 'https://wpastra.com/agency/?utm_source=demo-import-panel&utm_campaign=astra-sites&utm_medium=wp-dashboard' ),
				'_ajax_nonce'     => wp_create_nonce( 'tci-sites' ),
				'requiredPlugins' => [],
				'strings'         => [
					'importFailedBtnSmall' => __( 'Error!', 'tci-uet' ),
					'importFailedBtnLarge' => __( 'Error! Read Possibilities.', 'tci-uet' ),
					'importFailedURL'      => esc_url( 'https://wpastra.com/docs/?p=1314&utm_source=demo-import-panel&utm_campaign=astra-sites&utm_medium=import-failed' ),
					'viewSite'             => __( 'Done! View Site', 'tci-uet' ),
					'btnActivating'        => __( 'Activating', 'tci-uet' ) . '&hellip;',
					'btnActive'            => __( 'Active', 'tci-uet' ),
					'importFailBtn'        => __( 'Import failed.', 'tci-uet' ),
					'importFailBtnLarge'   => __( 'Import failed. See error log.', 'tci-uet' ),
					'importDemo'           => __( 'Import This Site', 'tci-uet' ),
					'importingDemo'        => __( 'Importing..', 'tci-uet' ),
					'DescExpand'           => __( 'Read more', 'tci-uet' ) . '&hellip;',
					'DescCollapse'         => __( 'Hide', 'tci-uet' ),
					'responseError'        => __( 'There was a problem receiving a response from server.', 'tci-uet' ),
					'searchNoFound'        => __( 'No Demos found, Try a different search.', 'tci-uet' ),
					'importWarning'        => __( "Executing Demo Import will make your site similar as ours. Please bear in mind -\n\n1. It is recommended to run import on a fresh WordPress installation.\n\n2. Importing site does not delete any pages or posts. However, it can overwrite your existing content.\n\n3. Copyrighted media will not be imported. Instead it will be replaced with placeholders.", 'tci-uet' ),
				],
				'log'             => [
					'installingPlugin'        => __( 'Installing plugin ', 'tci-uet' ),
					'installed'               => __( 'Successfully plugin installed!', 'tci-uet' ),
					'activating'              => __( 'Activating plugin ', 'tci-uet' ),
					'activated'               => __( 'Successfully plugin activated ', 'tci-uet' ),
					'bulkActivation'          => __( 'Bulk plugin activation...', 'tci-uet' ),
					'activate'                => __( 'Successfully plugin activate - ', 'tci-uet' ),
					'activationError'         => __( 'Error! While activating plugin  - ', 'tci-uet' ),
					'bulkInstall'             => __( 'Bulk plugin installation...', 'tci-uet' ),
					'api'                     => __( 'Site API ', 'tci-uet' ),
					'importing'               => __( 'Importing..', 'tci-uet' ),
					'processingRequest'       => __( 'Processing requests...', 'tci-uet' ),
					'importCustomizer'        => __( '1) Importing "Customizer Settings"...', 'tci-uet' ),
					'importCustomizerSuccess' => __( 'Successfully imported customizer settings!', 'tci-uet' ),
					'importXMLPrepare'        => __( '2) Preparing "XML" Data...', 'tci-uet' ),
					'importXMLPrepareSuccess' => __( 'Successfully set XML data!', 'tci-uet' ),
					'importXML'               => __( '3) Importing "XML"...', 'tci-uet' ),
					'importXMLSuccess'        => __( 'Successfully imported XML!', 'tci-uet' ),
					'importOptions'           => __( '4) Importing "Options"...', 'tci-uet' ),
					'importOptionsSuccess'    => __( 'Successfully imported Options!', 'tci-uet' ),
					'importWidgets'           => __( '5) Importing "Widgets"...', 'tci-uet' ),
					'importWidgetsSuccess'    => __( 'Successfully imported Widgets!', 'tci-uet' ),
					'serverConfiguration'     => '',
					//esc_url( 'https://wpastra.com/docs/?p=1314&utm_source=demo-import-panel&utm_campaign=import-error&utm_medium=wp-dashboard' ),
					'success'                 => __( 'Site imported successfully! visit : ', 'tci-uet' ),
					'gettingData'             => __( 'Getting Site Information..', 'tci-uet' ),
					'importingCustomizer'     => __( 'Importing Customizer Settings..', 'tci-uet' ),
					'importXMLPreparing'      => __( 'Setting up import data..', 'tci-uet' ),
					'importingXML'            => __( 'Importing Pages, Posts & Media..', 'tci-uet' ),
					'importingOptions'        => __( 'Importing Site Options..', 'tci-uet' ),
					'importingWidgets'        => __( 'Importing Widgets..', 'tci-uet' ),
					'importComplete'          => __( 'Import Complete..', 'tci-uet' ),
					'preview'                 => __( 'Previewing ', 'tci-uet' ),
					'importLogText'           => __( 'See Error Log &rarr;', 'tci-uet' ),
				],
			]
		);

		wp_localize_script( 'tci-sites-admin-page', 'astraSitesAdmin', $data );

	}
}
