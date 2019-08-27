<?php
/**
 * TCI UET Sites demo class
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.1
 */
namespace TCI_UET\Classes;

tci_exit();

class TCI_Page_Sites {
	/**
	 * View all actions
	 *
	 * @since 0.0.1
	 * @var array $view_actions
	 */
	public $view_actions = [];
	/**
	 * Menu page title
	 *
	 * @since 0.0.1
	 * @var array $menu_page_title
	 */
	public $menu_page_title;
	/**
	 * Plugin slug
	 *
	 * @since 0.0.1
	 * @var array $plugin_slug
	 */
	public $plugin_slug = 'tci-sites';
	/**
	 * Default Menu Parent position
	 *
	 * @since 0.0.1
	 * @var array $default_menu_position
	 */
	public $default_menu_position = 'themes.php';
	/**
	 * Parent Page Slug
	 *
	 * @since 0.0.1
	 * @var array $parent_page_slug
	 */
	public $parent_page_slug = 'general';
	/**
	 * Current Slug
	 *
	 * @since 0.0.1
	 * @var array $current_slug
	 */
	public $current_slug = 'general';

	/**
	 * Constructor
	 *
	 * @since 0.0.1
	 */
	public function __construct() {
		if ( ! is_admin() ) {
			return;
		}
		add_action( 'after_setup_theme', [ $this, 'tci_init_admin_settings' ], 99 );
	}

	/**
	 * Admin settings init
	 *
	 * @since 0.0.1
	 */
	public function tci_init_admin_settings() {
		$this->menu_page_title = apply_filters( 'tci_site_menu_page_title', __( 'TCI Sites', 'tci-uet' ) );
		if ( isset( $_REQUEST['page'] ) AND false !== strpos( $_REQUEST['page'], $this->plugin_slug ) ) {
			$this->tci_save_settings();
		}
		add_action( 'admin_menu', [ $this, 'tci_add_admin_menu' ], 100 );
		add_action( 'admin_menu', [ $this, 'tci_add_admin_menu' ], 100 );
		add_action( 'tci_sites_menu_general_action', [ $this, 'tci_general_page' ] );
	}

	/**
	 * Save All admin settings here
	 *
	 * @since 0.0.1
	 */
	public function tci_save_settings() {
		// Only admins can save settings.
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		// Let extensions hook into saving.
		do_action( 'astra_sites_save_settings' );
	}

	/**
	 * Add main menu
	 *
	 * @since 0.0.1
	 */
	public function tci_add_admin_menu() {
		$page_title     = $this->menu_page_title;
		$capability     = 'manage_options';
		$page_menu_slug = $this->plugin_slug;
		add_theme_page( $page_title, $page_title, $capability, $page_menu_slug, [ $this, 'tci_menu_callback' ] );
	}

	/**
	 * Menu callback
	 *
	 * @since 0.0.1
	 */
	public function tci_menu_callback() {
		$current_slug = isset( $_GET['action'] ) ? $_GET['action'] : $this->current_slug;
		$active_tab   = str_replace( '_', '-', $current_slug );
		$current_slug = str_replace( '-', '_', $current_slug );
		?>
		<div class="astra-sites-menu-page-wrapper">
			<?php $this->tci_init_nav_menu( $active_tab ); ?>
			<?php do_action( 'tci_sites_menu_' . esc_attr( $current_slug ) . '_action' ); ?>
		</div>
		<?php
	}

	/**
	 * Init Nav Menu
	 *
	 * @param mixed $action Action name.
	 *
	 * @since 0.0.1
	 */
	public function tci_init_nav_menu( $action = '' ) {

		if ( '' !== $action ) :
			?>
			<div id="astra-sites-menu-page">
				<?php $this->tci_render( $action ); ?>
			</div>
		<?php
		endif;
	}

	/**
	 * Prints HTML content for tabs
	 *
	 * @param mixed $action Action name.
	 *
	 * @since 0.0.1
	 */
	public function tci_render( $action ) {
		?>
		<div class="nav-tab-wrapper">
			<h1 class='tci-sites-title'> <?php echo esc_html( $this->menu_page_title ); ?> </h1>
			<?php
			$view_actions = $this->tci_get_view_actions();

			foreach ( $view_actions as $slug => $data ) {

				if ( ! $data['show'] ) {
					continue;
				}

				$url = $this->tci_get_page_url( $slug );

				if ( $slug == $this->parent_page_slug ) {
					update_option( 'tci_parent_page_url', $url );
				}

				$active = ( $slug == $action ) ? 'nav-tab-active' : '';
				?>
				<a class='nav-tab <?php echo esc_attr( $active ); ?>' href='<?php echo esc_url( $url ); ?>'> <?php echo esc_html( $data['label'] ); ?> </a>
			<?php } ?>
		</div><!-- .nav-tab-wrapper -->
		<?php
		// Settings update message.
		if ( isset( $_REQUEST['message'] ) && ( 'saved' == $_REQUEST['message'] || 'saved_ext' == $_REQUEST['message'] ) ) {
			?>
			<span id="message" class="notice notice-success is-dismissive"><p> <?php esc_html_e( 'Settings saved successfully.', 'tci-uet' ); ?> </p></span>
			<?php
		}
	}

	/**
	 * View actions
	 *
	 * @since 0.0.1
	 */
	public function tci_get_view_actions() {

		if ( empty( $this->view_actions ) ) {

			$this->view_actions = apply_filters(
				'tci_sites_menu_item', []
			);
		}

		return $this->view_actions;
	}

	/**
	 * Get and return page URL
	 *
	 * @param string $menu_slug Menu name.
	 *
	 * @since 0.0.1
	 * @return  string page url
	 */
	public function tci_get_page_url( $menu_slug ) {

		$parent_page = $this->default_menu_position;

		if ( strpos( $parent_page, '?' ) !== false ) {
			$query_var = '&page=' . $this->plugin_slug;
		} else {
			$query_var = '?page=' . $this->plugin_slug;
		}

		$parent_page_url = admin_url( $parent_page . $query_var );

		$url = $parent_page_url . '&action=' . $menu_slug;

		return $url;
	}

	/**
	 * Include general page
	 *
	 * @since 0.0.1
	 */
	public function tci_general_page() {
		require_once tci_root( 'inc/tci-admin-page.php' );
	}
}
