<?php
/**
 * TCI UET Elementor Template
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.5
 */
namespace TCI_UET\TCI_UET_Widgets;

tci_uet_exit();

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Plugin;

class TCI_UET_Elementor_Template extends Widget_Base {
	/**
	 * Get widget name.
	 * Retrieve widget name.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'TCI_UET_Elementor_Template';
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
		return __( 'TCI UET Elementor Template', 'tci-uet' );
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
		return 'tci tci-uet-layout';
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
		return [ 'tci-widget' ];
	}

	/**
	 * Attach keywords.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_keywords() {
		return [ 'elementor', 'template' ];
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
			TCI_UET_SETTINGS . 'section_template',
			[
				'label' => __( 'Template', 'tci-uet' ),
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . 'template_id',
			[
				'label'       => __( 'Choose Template', 'tci-uet' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => tci_uet_get_post_list( 'elementor_library' ),
				'filter_type' => 'library_widget_templates',
				'label_block' => true,
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
	protected function render() {
		$template_id = $this->get_settings( TCI_UET_SETTINGS . 'template_id' );

		if ( 'publish' !== get_post_status( $template_id ) ) {
			return;
		}

		?>
		<div class="tci-uet-widget elementor-template">
			<?php echo do_shortcode( "[tci-uet-template id='{$template_id}']" ); ?>
		</div>
		<?php
	}

	/**
	 * Render widget plain content.
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function render_plain_content() { }
}
