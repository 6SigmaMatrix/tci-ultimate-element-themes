<?php
/**
 * TCI UET Role Manager class
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.1
 */
namespace TCI_UET\TCI_Modules;

tci_exit();

use Elementor\Plugin;
use Elementor\Settings_Page;
use Elementor\Core\RoleManager\Role_Manager as RoleManagerBase;

if ( defined( 'ELEMENTOR_PRO_VERSION' ) ) {
	return;
}

class TCI_Role_Manager {
	/**
	 * Constant
	 *
	 * @since  0.0.1
	 * @access static
	 */
	const ROLE_MANAGER_OPTION_NAME = 'role-manager';

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
				'register_admin_fields',
			], 100 );
		}
		add_action( 'elementor/role/restrictions/controls', [ $this, 'display_role_controls' ], 10, 2 );
		add_filter( 'elementor/editor/user/restrictions', [ $this, 'get_user_restrictions' ] );
	}

	public static function remove_restrictions() {
		remove_action( 'elementor/role/restrictions/controls', [
			Plugin::instance()->role_manager,
			'get_go_pro_link_html',
		] );
	}

	public function get_role_manager_options() {
		return get_option( 'elementor_' . self::ROLE_MANAGER_OPTION_NAME, [] );
	}

	public function get_name() {
		return 'role-manager';
	}

	public function save_advanced_options( $input ) {
		return $input;
	}

	public function get_user_restrictions() {
		return $this->get_role_manager_options();
	}

	public function display_role_controls( $role_slug, $role_data ) {
		static $options = false;
		if ( ! $options ) {
			$options = [
				'excluded_options' => Plugin::instance()->role_manager->get_role_manager_options(),
				'advanced_options' => $this->get_role_manager_options(),
			];
		}
		$id      = self::ROLE_MANAGER_OPTION_NAME . '_' . $role_slug . '_design';
		$name    = 'elementor_' . self::ROLE_MANAGER_OPTION_NAME . '[' . $role_slug . '][]';
		$checked = isset( $options['advanced_options'][ $role_slug ] ) ? $options['advanced_options'][ $role_slug ] : [];

		?>
		<label for="<?php echo esc_attr( $id ); ?>">
			<input type="checkbox" name="<?php echo esc_attr( $name ); ?>" id="<?php echo esc_attr( $id ); ?>" value="design" <?php checked( in_array( 'design', $checked ), true ); ?>>
			<?php esc_html_e( 'Access to edit content only', 'tci-uet' ); ?>
		</label>
		<?php
	}

	public function register_admin_fields( RoleManagerBase $role_manager ) {
		$role_manager->add_section( 'general', 'advanced-role-manager', [
			'fields' => [
				self::ROLE_MANAGER_OPTION_NAME => [
					'field_args'   => [
						'type' => 'raw_html',
						'html' => '',
					],
					'setting_args' => [
						'sanitize_callback' => [ $this, 'save_advanced_options' ],
					],
				],
			],
		] );
	}


}

new TCI_Role_Manager();
