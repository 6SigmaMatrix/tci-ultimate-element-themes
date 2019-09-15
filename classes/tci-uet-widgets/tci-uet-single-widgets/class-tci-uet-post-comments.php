<?php
/**
 * TCI UET Post Comments widget class
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.2
 */
namespace TCI_UET\TCI_UET_Widgets\TCI_UET_Single_Widgets;

tci_uet_exit();

use Elementor\Controls_Manager;
use Elementor\Plugin;
use TCI_UET\TCI_UET_Modules\TCI_UET_Query_Control;
use TCI_UET\TCI_UET_Modules;
use Elementor\Widget_Base;

class TCI_UET_Post_Comments extends Widget_Base {
	/**
	 * Get widget name.
	 * Retrieve widget name.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'TCI_UET_Post_Comments';
	}

	/**
	 * Get widget title.
	 * Retrieve widget title.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'TCI UET Post Comments', 'tci-uet' );
	}

	/**
	 * Get widget icon.
	 * Retrieve widget icon.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'tci tci-uet-comment';
	}

	/**
	 * Get widget categories.
	 * Retrieve the list of categories the oEmbed widget belongs to.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'tci-uet-single-widgets' ];
	}

	/**
	 * Attach keywords.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'comments', 'post', 'response', 'form' ];
	}

	/**
	 * Register widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Comments', 'tci-uet' ),
			]
		);

		$this->add_control(
			'_skin',
			[
				'type' => Controls_Manager::HIDDEN,
			]
		);

		$this->add_control(
			'source_type',
			[
				'label'   => __( 'Source', 'tci-uet' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					TCI_UET_Modules::TCI_UET_Source_Type_Current_Post => __( 'Current Post', 'tci-uet' ),
					TCI_UET_Modules::TCI_UET_Source_Type_Custom       => __( 'Custom', 'tci-uet' ),
				],
				'default' => TCI_UET_Modules::TCI_UET_Source_Type_Current_Post,
				//'separator' => 'before',
			]
		);

		$this->add_control(
			'source_custom',
			[
				'label'       => __( 'Search & Select', 'tci-uet' ),
				'type'        => TCI_UET_Query_Control::QUERY_CONTROL_ID,
				'label_block' => true,
				'filter_type' => 'by_id',
				'object_type' => 'any',
				'condition'   => [
					'source_type' => TCI_UET_Modules::TCI_UET_Source_Type_Custom,
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	public function render() {
		$settings = $this->get_settings();

		if ( TCI_UET_Modules::TCI_UET_Source_Type_Custom === $settings['source_type'] ) {
			$post_id = (int) $settings['source_custom'];
			Plugin::instance()->db->switch_to_post( $post_id );
		}

		if ( ! comments_open() && ( Plugin::instance()->preview->is_preview_mode() || Plugin::instance()->editor->is_edit_mode() ) ) :
			?>
			<div class="elementor-alert elementor-alert-danger" role="alert">
				<span class="elementor-alert-title">
					<?php _e( 'Comments Are Closed!', 'tci-uet' ); ?>
				</span>
				<span class="elementor-alert-description">
					<?php _e( 'Switch on comments from either the discussion box on the WordPress post edit screen or from the WordPress discussion settings.', 'tci-uet' ); ?>
				</span>
			</div>
		<?php
		else :
			comments_template();
		endif;

		if ( TCI_UET_Modules::TCI_UET_Source_Type_Custom === $settings['source_type'] ) {
			Plugin::instance()->db->restore_current_post();
		}
	}
}
