<?php
/**
 * TCI UET Animated Text widget class
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.5
 */
namespace TCI_UET\TCI_UET_Widgets\TCI_UET_WP_Widgets;

tci_uet_exit();

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Widget_Base;

class TCI_UET_Wp_Widget extends Widget_Base {

	/**
	 * WordPress widget name.
	 *
	 * @access private
	 * @var string
	 */
	private $_widget_name = null;

	/**
	 * WordPress widget instance.
	 *
	 * @access private
	 * @var \WP_Widget
	 */
	private $_widget_instance = null;

	/**
	 * Get widget name.
	 * Retrieve WordPress widget name.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'TCI_UET_WP_Widget_' . ucfirst( $this->get_widget_instance()->id_base );
	}

	/**
	 * Get widget title.
	 * Retrieve WordPress widget title.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title() {
		return sprintf( __( 'TCI UET %s', 'tci-uet' ), str_replace( 'TCI UET', '', $this->get_widget_instance()->name ) );
	}

	/**
	 * Get widget categories.
	 * Retrieve the list of categories the WordPress/Pojo widget belongs to.
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return array Widget categories. Returns either a WordPress category or Pojo category.
	 */
	public function get_categories() {
		return [ 'tci-uet-wp-widgets' ];
	}

	/**
	 * Get widget icon.
	 * Retrieve WordPress widget icon.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return string Widget icon. Returns either a WordPress icon or Pojo icon.
	 */
	public function get_icon() {
		return 'eicon-wordpress';
	}

	/**
	 * Whether the reload preview is required or not.
	 * Used to determine whether the reload preview is required.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return bool Whether the reload preview is required.
	 */
	public function is_reload_preview_required() {
		return true;
	}

	/**
	 * Retrieve WordPress widget form.
	 * Returns the WordPress widget form, to be used in Elementor.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return string Widget form.
	 */
	public function get_form() {
		$instance = $this->get_widget_instance();
		ob_start();
		echo '<div class="widget-inside media-widget-control"><div class="form wp-core-ui">';
		echo '<input type="hidden" class="id_base" value="' . esc_attr( $instance->id_base ) . '" />';
		echo '<input type="hidden" class="widget-id" value="widget-' . esc_attr( $this->get_id() ) . '" />';
		echo '<div class="widget-content">';
		$widget_data = $this->get_settings( 'wp' );
		$instance->form( $widget_data );
		do_action( 'in_widget_form', $instance, null, $widget_data );
		echo '</div></div></div>';

		return ob_get_clean();
	}

	/**
	 * Retrieve WordPress widget instance.
	 * Returns an instance of WordPress widget, to be used in Elementor.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return \WP_Widget
	 */
	public function get_widget_instance() {
		if ( is_null( $this->_widget_instance ) ) {
			global $wp_widget_factory;

			if ( isset( $wp_widget_factory->widgets[ $this->_widget_name ] ) ) {
				$this->_widget_instance = $wp_widget_factory->widgets[ $this->_widget_name ];
				$this->_widget_instance->_set( 'REPLACE_TO_ID' );
			} elseif ( class_exists( $this->_widget_name ) ) {
				$this->_widget_instance = new $this->_widget_name();
				$this->_widget_instance->_set( 'REPLACE_TO_ID' );
			}
		}

		return $this->_widget_instance;
	}

	/**
	 * Retrieve WordPress widget parsed settings.
	 * Returns the WordPress widget settings, to be used in Elementor.
	 *
	 * @access protected
	 * @since  0.0.1
	 * @return \WP_Widget
	 */
	protected function _get_parsed_settings() {
		$settings = parent::_get_parsed_settings();

		if ( ! empty( $settings['wp'] ) ) {
			$settings['wp'] = $this->get_widget_instance()->update( $settings['wp'], [] );
		}

		return $settings;
	}

	/**
	 * Get script dependencies.
	 * Retrieve the list of script dependencies the element requires.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return array Element script dependencies.
	 */
	public function get_style_depends() {
		return [ 'tci-uet-frontend' ];
	}

	/**
	 * Register WordPress
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected function _register_controls() {

	}

	/**
	 * Render WordPress output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();
		$settings = tci_uet_array( $settings );

		$this->add_render_attribute( 'tci-uet-wp-widget-wrapper', 'class', [
			'tci-uet-widget',
			$this->get_id(),
			'elementor-widget-heading',
		] );

		$this->add_render_attribute( 'tci-uet-wp-widget-title', 'class', [
			'elementor-heading-title',
			'elementor-size-' . $settings->get( TCI_UET_SETTINGS . '_size' ),
			'tci-uet-wp-widget-title',
		] );

		$this->add_render_attribute( 'tci-uet-wp-widget-before-title', 'class', [
			'elementor-heading-title',
			'elementor-size-' . $settings->get( TCI_UET_SETTINGS . '_before_title_size' ),
			'tci-uet-wp-widget-before-title',
		] );

		$this->add_render_attribute( 'tci-uet-wp-widget-after-title', 'class', [
			'elementor-heading-title',
			'elementor-size-' . $settings->get( TCI_UET_SETTINGS . '_after_title_size' ),
			'tci-uet-wp-widget-after-title',
		] );

		if ( 'yes' === $settings->get( TCI_UET_SETTINGS . '_before_title_set' ) AND 'f_w' === $settings->get( TCI_UET_SETTINGS . '_before_title_type' ) ) {
			$before_title = sprintf(
				'<%1$s %2$s>%3$s</%1$s>',
				$settings->get( TCI_UET_SETTINGS . '_before_title_header_size' ),
				$this->get_render_attribute_string( 'tci-uet-wp-widget-before-title' ),
				$settings->get( TCI_UET_SETTINGS . '_before_title' )
			);
		} elseif ( 'yes' === $settings->get( TCI_UET_SETTINGS . '_before_title_set' ) AND 'f_t' === $settings->get( TCI_UET_SETTINGS . '_before_title_type' ) ) {
			$before_title = do_shortcode( "[tci-uet-template id='{$settings->get( TCI_UET_SETTINGS . '_before_title_type_f_t' )}']" );
		} else {
			$before_title = '';
		}


		if ( 'yes' === $settings->get( TCI_UET_SETTINGS . '_after_title_set' ) AND 'f_w' === $settings->get( TCI_UET_SETTINGS . '_after_title_type' ) ) {
			$after_title = sprintf(
				'<%1$s %2$s>%3$s</%1$s>',
				$settings->get( TCI_UET_SETTINGS . '_after_title_header_size' ),
				$this->get_render_attribute_string( 'tci-uet-wp-widget-after-title' ),
				$settings->get( TCI_UET_SETTINGS . '_after_title' )
			);
		} elseif ( 'yes' === $settings->get( TCI_UET_SETTINGS . '_after_title_set' ) AND 'f_t' === $settings->get( TCI_UET_SETTINGS . '_after_title_type' ) ) {
			$after_title = do_shortcode( "[tci-uet-template id='{$settings->get( TCI_UET_SETTINGS . '_after_title_type_f_t' )}']" );
		} else {
			$after_title = '';
		}


		?>
		<div <?php echo $this->get_render_attribute_string( 'tci-uet-wp-widget-wrapper' ); ?>>

			<?php
			$default_widget_args = [
				'widget_id'     => $this->get_name(),
				'before_widget' => '',
				'after_widget'  => '',
				'before_title'  => "{$before_title}<{$settings->get( TCI_UET_SETTINGS . '_header_size' )} {$this->get_render_attribute_string( 'tci-uet-wp-widget-title' )}>",
				'after_title'   => "</{$settings->get( TCI_UET_SETTINGS . '_header_size' )}>{$after_title}",
			];

			$default_widget_args = apply_filters( 'elementor/widgets/wordpress/widget_args', $default_widget_args, $this ); // WPCS: spelling ok.

			$this->get_widget_instance()->widget( $default_widget_args, $this->get_settings( 'wp' ) );
			?>
		</div>
		<?php
	}

	/**
	 * Render WordPress output in the editor.
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected function content_template() { }

	/**
	 * WordPress widget constructor.
	 * Used to run WordPress widget constructor.
	 *
	 * @since  0.0.1
	 * @access public
	 *
	 * @param array $data Widget data. Default is an empty array.
	 * @param array $args Widget arguments. Default is null.
	 */
	public function __construct( $data = [], $args = null ) {
		$this->_widget_name = $args['widget_name'];

		parent::__construct( $data, $args );
	}

	/**
	 * Render WordPress widget as plain content.
	 * Override the default render behavior, don't render widget content.
	 *
	 * @since  0.0.1
	 * @access public
	 *
	 * @param array $instance Widget instance. Default is empty array.
	 */
	public function render_plain_content( $instance = [] ) { }
}