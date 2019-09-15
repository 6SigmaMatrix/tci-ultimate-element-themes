<?php
/**
 * TCI UET WP Widget class
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.1
 */
namespace TCI_UET\TCI_UET_Modules;

tci_uet_exit();

use Elementor\Core\Base\Document;
use Elementor\Plugin;


class TCI_UET_Wp_Widget extends \WP_Widget {
	/**
	 * Sidebar ID
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected $sidebar_id;

	/**
	 * Constructer
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function __construct() {
		parent::__construct(
			'tci-uet-elementor-template',
			esc_html__( 'TCI UET Elementor Template', 'tci-uet' ),
			[
				'description' => esc_html__( 'Embed your saved elements.', 'tci-uet' ),
			]
		);
	}

	/**
	 * Constant
	 *
	 * @param array $args
	 * @param array $instance
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];

		if ( ! empty( $instance[ TCI_UET_SETTINGS . 'title' ] ) ) {
			/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
			echo $args['before_title'] . apply_filters( 'widget_title', $instance[ TCI_UET_SETTINGS . 'title' ] ) . $args['after_title'];
		}

		if ( ! empty( $instance[ TCI_UET_SETTINGS . 'template_id' ] ) && 'publish' === get_post_status( $instance[ TCI_UET_SETTINGS . 'template_id' ] ) ) {
			$this->sidebar_id = $args['id'];

			add_filter( 'elementor/frontend/builder_content_data', [ $this, 'filter_content_data' ] );

			echo Plugin::instance()->frontend->get_builder_content_for_display( $instance[ TCI_UET_SETTINGS . 'template_id' ] );

			remove_filter( 'elementor/frontend/builder_content_data', [ $this, 'filter_content_data' ] );

			unset( $this->sidebar_id );
		}

		echo $args['after_widget'];
	}

	/**
	 * Avoid nesting a sidebar within a template that will appear in the sidebar itself
	 *
	 * @param array $data
	 *
	 * @return mixed
	 * @since  0.0.1
	 * @access public
	 */
	public function filter_content_data( $data ) {
		if ( ! empty( $data ) ) {
			$data = Plugin::instance()->db->iterate_data( $data, function ( $element ) {
				if ( 'widget' === $element['elType'] && 'sidebar' === $element['widgetType'] && $this->sidebar_id === $element['settings']['sidebar'] ) {
					$element['settings']['sidebar'] = null;
				}

				return $element;
			} );
		}

		return $data;
	}

	/**
	 * Add Widget Form
	 *
	 * @param array $instance
	 *
	 * @return void
	 * @since  0.0.1
	 * @access public
	 */
	public function form( $instance ) {
		$default = [
			TCI_UET_SETTINGS . 'title'       => '',
			TCI_UET_SETTINGS . 'template_id' => '',
		];

		$instance = array_merge( $default, $instance );

		$templates = $this->get_templates();

		if ( ! $templates ) {
			echo $this->empty_templates_message();

			return;
		}
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( TCI_UET_SETTINGS . 'title' ) ); ?>"><?php esc_attr_e( 'Title', 'tci-uet' ); ?>:</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( TCI_UET_SETTINGS . 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( TCI_UET_SETTINGS . 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance[ TCI_UET_SETTINGS . 'title' ] ); ?>">
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( TCI_UET_SETTINGS . 'template_id' ) ); ?>"><?php esc_attr_e( 'Choose Template', 'tci-uet' ); ?>:</label>
			<select class="widefat elementor-widget-template-select" id="<?php echo esc_attr( $this->get_field_id( TCI_UET_SETTINGS . 'template_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( TCI_UET_SETTINGS . 'template_id' ) ); ?>">
				<option value="">— <?php _e( 'Select', 'tci-uet' ); ?> —</option>
				<?php
				foreach ( $templates as $template ) :
					$selected = selected( $template['template_id'], $instance[ TCI_UET_SETTINGS . 'template_id' ] );
					?>
					<option value="<?php echo $template['template_id']; ?>" <?php echo $selected; ?> data-type="<?php echo esc_attr( $template['type'] ); ?>">
						<?php echo $template['title']; ?> (<?php echo $template['type']; ?>)
					</option>
				<?php endforeach; ?>
			</select>
			<?php
			$style = ' style="display:none"';

			$template_type = get_post_meta( $instance[ TCI_UET_SETTINGS . 'template_id' ], Document::TYPE_META_KEY, true );

			// 'widget' is editable only from an Elementor page
			if ( 'page' === $template_type ) {
				$style = '';
			}
			?>
			<a target="_blank" class="elementor-edit-template"<?php echo $style; ?> href="<?php echo esc_url( add_query_arg( 'tci-uet', '', get_permalink( $instance[ TCI_UET_SETTINGS . 'template_id' ] ) ) ); ?>">
				<i class="fa fa-pencil"></i> <?php echo __( 'Edit Template', 'tci-uet' ); ?>
			</a>
		</p>
		<?php
	}

	/**
	 * Update Widget
	 *
	 * @param array $new_instance
	 * @param array $old_instance
	 *
	 * @return array
	 * @return void
	 * @since  0.0.1
	 * @access public
	 */
	public function update( $new_instance, $old_instance ) {
		$instance                                 = [];
		$instance[ TCI_UET_SETTINGS . 'title' ]       = ( ! empty( $new_instance[ TCI_UET_SETTINGS . 'title' ] ) ) ? strip_tags( $new_instance[ TCI_UET_SETTINGS . 'title' ] ) : '';
		$instance[ TCI_UET_SETTINGS . 'template_id' ] = $new_instance[ TCI_UET_SETTINGS . 'template_id' ];

		return $instance;
	}

	/**
	 * Add Empty Message
	 *
	 * @since  0.0.1
	 * @access static
	 */
	public function empty_templates_message() {
		return '<div id="elementor-widget-template-empty-templates">
				<div class="elementor-widget-template-empty-templates-icon"><i class="eicon-nerd" aria-hidden="true"></i></div>
				<div class="elementor-widget-template-empty-templates-title">' . __( 'You Haven’t Saved Templates Yet.', 'tci-uet' ) . '</div>
				<div class="elementor-widget-template-empty-templates-footer">' . __( 'Want to learn more about Elementor library?', 'tci-uet' ) . ' <a class="elementor-widget-template-empty-templates-footer-url" href="https://go.elementor.com/docs-library/" target="_blank">' . __( 'Click Here', 'tci-uet' ) . '</a>
				</div>
				</div>';
	}

	/**
	 * Get Template List
	 *
	 * @since  0.0.1
	 * @access static
	 */
	public static function get_templates() {
		return Plugin::instance()->templates_manager->get_source( 'local' )->get_items();
	}
}

