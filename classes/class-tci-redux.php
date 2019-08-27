<?php
/**
 * TCI UET Redux class
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.1
 */
namespace TCI_UET\Classes;

tci_exit();

class TCI_Redux {
	/**
	 * TCI WP Color Scheme
	 *
	 * @since  0.0.1
	 * @access Protected
	 */
	protected $tci_wp_color_scheme;

	/**
	 * Constructer
	 *
	 * @since  0.0.1
	 */
	public function __construct() {

		\Redux::setArgs( 'tci_uet_opt', $this->tci_redux_args() );
	}

	/**
	 * TCI Redux Arguments
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected function tci_redux_args() {

		$tci_redux_args = [
			'admin_theme'               => tci_db_opt()['tci_wp_color_scheme'],
			'admin_bar'                 => true,
			'admin_bar_icon'            => 'dashicons-admin-generic',
			'allow_sub_menu'            => true,
			'async_typography'          => true,
			'cdn_check_time'            => 1440,
			'class'                     => 'tci-uet-redux',
			'customizer'                => false,
			'customizer_only'           => false,
			'database'                  => 'theme_mods',
			'default_mark'              => '*',
			'default_show'              => true,
			'dev_mode'                  => false,
			'disable_google_fonts_link' => true,
			'disable_save_warn'         => false,
			'display_name'              => 'TCI Ultimate Element Themes',
			'display_version'           => TCI_VERSION,
			'footer_text'               => ' ',
			'global_variable'           => '',
			'google_api_key'            => '',
			'google_update_weekly'      => true,
			'hide_expand'               => false,
			'hide_reset'                => false,
			'intro_text'                => ' ',
			'hints'                     => [
				'icon'          => 'el icon-question-sign',
				'icon_position' => 'right',
				'icon_color'    => 'lightgray',
				'icon_size'     => 'normal',
				'tip_style'     => [
					'color'   => 'light',
					'shadow'  => true,
					'rounded' => false,
					'style'   => '',
				],
				'tip_position'  => [
					'my' => 'top left',
					'at' => 'bottom left',
				],
				'tip_effect'    => [
					'show' => [
						'effect'   => 'slide',
						'duration' => '500',
						'event'    => 'mouseover',
					],
					'hide' => [
						'effect'   => 'slide',
						'duration' => '500',
						'event'    => 'click mouseleave',
					],
				],
			],
			'last_tab'                  => '',
			'menu_icon'                 => 'dashicons-admin-generic',
			'menu_type'                 => 'menu',
			'menu_title'                => __( 'TCI UET Options', 'tci-uet' ),
			'network_admin'             => true,
			'network_sites'             => true,
			'open_expanded'             => false,
			'opt_name'                  => 'tci_uet_opt',
			'output'                    => true,
			'output_tag'                => true,
			'page_icon'                 => 'dashicons-admin-generic',
			'page_parent'               => 'themes.php',
			'page_priority'             => 2,
			'page_permissions'          => 'manage_options',
			'page_slug'                 => 'tci_uet_opt',
			'page_title'                => __( 'TCI UET Options', 'tci-uet' ),
			'save_defaults'             => true,
			'settings_api'              => true,
			'share_icons'               => [
				[
					'url'   => '#',
					'title' => 'Like on Facebook',
					'icon'  => 'el el-facebook',
				],
				[
					'url'   => '#',
					'title' => 'Follow us on Twitter',
					'icon'  => 'el el-twitter',
				],
				[
					'url'   => '#',
					'title' => 'Find us on LinkedIn',
					'icon'  => 'el el-linkedin',
				],
			],
			'show_import_export'        => true,
			'system_info'               => true,
			'transient_time'            => 60 * MINUTE_IN_SECONDS,
			'update_notice'             => true,
			'use_cdn'                   => false,
		];

		return apply_filters( 'tci_redux_args', $tci_redux_args );
	}

	/**
	 * TCI Get the current admin color scheme from WordPress user.
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function tci_get_current_admin_color( $result ) {
		$this->tci_wp_color_scheme = $result;
	}
}

new TCI_Redux();
