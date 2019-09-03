<?php
/**
 * TCI UET Role Manager class
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.5
 */
namespace TCI_UET\TCI_UET_Modules;

tci_uet_exit();

use Elementor\Plugin;
use Elementor\Settings_Page;
use Elementor\Core\RoleManager\Role_Manager as RoleManagerBase;
use TCI_UET\TCI_UET_Modules;

if ( defined( 'ELEMENTOR_PRO_VERSION' ) ) {
	return;
}

class TCI_UET_Role_Manager extends TCI_UET_Modules {
	/**
	 * Constant
	 *
	 * @since  0.0.5
	 * @access static
	 */
	const TCI_UET_ROLE_MANAGER_OPTION_NAME = 'role-manager';

	/**
	 * Constructer
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function __construct() {
		if ( is_admin() ) {
			add_action( 'elementor/admin/after_create_settings/' . RoleManagerBase::PAGE_ID, [
				$this,
				'tci_uet_role_manager_register_admin_fields',
			], 100 );
		}

		add_action( 'elementor/role/restrictions/controls', [
			$this,
			'tci_uet_role_manager_display_role_controls',
		], 10, 2 );

		add_filter( 'elementor/editor/user/restrictions', [ $this, 'tci_uet_role_manager_get_user_restrictions' ] );
	}

	public static function tci_uet_role_manager_remove_restrictions() {
		remove_action( 'elementor/role/restrictions/controls', [
			Plugin::instance()->role_manager,
			'get_go_pro_link_html',
		] );
	}

	public function tci_uet_role_manager_get_options() {
		return get_option( 'elementor_' . self::TCI_UET_ROLE_MANAGER_OPTION_NAME, [] );
	}

	public function tci_uet_role_manager_save_advanced_options( $input ) {
		return $input;
	}

	public function tci_uet_role_manager_get_user_restrictions() {
		return $this->tci_uet_role_manager_get_options();
	}

	public function tci_uet_role_manager_display_role_controls( $role_slug, $role_data ) {
		static $options = false;
		if ( ! $options ) {
			$options = [
				'excluded_options' => Plugin::instance()->role_manager->get_role_manager_options(),
				'advanced_options' => $this->tci_uet_role_manager_get_options(),
			];
		}
		$id      = self::TCI_UET_ROLE_MANAGER_OPTION_NAME . '_' . $role_slug . '_design';
		$name    = 'elementor_' . self::TCI_UET_ROLE_MANAGER_OPTION_NAME . '[' . $role_slug . '][]';
		$checked = isset( $options['advanced_options'][ $role_slug ] ) ? $options['advanced_options'][ $role_slug ] : [];

		?>
		<label for="<?php echo esc_attr( $id ); ?>">
			<input type="checkbox" name="<?php echo esc_attr( $name ); ?>" id="<?php echo esc_attr( $id ); ?>" value="design" <?php checked( in_array( 'design', $checked ), true ); ?>>
			<?php _e( 'Access to edit content only', 'tci-uet' ); ?>
		</label>
		<?php
	}

	public function tci_uet_role_manager_register_admin_fields( RoleManagerBase $role_manager ) {
		$role_manager->add_section( 'general', 'advanced-role-manager', [
			'fields' => [
				self::TCI_UET_ROLE_MANAGER_OPTION_NAME => [
					'field_args'   => [
						'type' => 'raw_html',
						'html' => '',
					],
					'setting_args' => [
						'sanitize_callback' => [ $this, 'tci_uet_role_manager_save_advanced_options' ],
					],
				],
			],
		] );
	}
}
