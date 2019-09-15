<?php
/**
 * TCI UET Post list widget class
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.6
 */
namespace TCI_UET\TCI_UET_Widgets\TCI_UET_Global_Widgets;

tci_uet_exit();

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class TCI_UET_Post_Loop extends Widget_Base {

	/**
	 * Get widget name.
	 * Retrieve widget name.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'TCI_UET_Post_Loop';
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
		return __( 'TCI UET Post Loop', 'tci-uet' );
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
		return 'tci tci-uet-update';
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
		return [ 'tci-uet-global-widgets' ];
	}

	/**
	 * Attach keywords.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'post list', 'post' ];
	}

	/**
	 * Get style dependencies.
	 * Retrieve the list of style dependencies the element requires.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return array Element styles dependencies.
	 */
	public function get_style_depends() {
		return [ 'tci-uet-grid' ];
	}

	/**
	 * Register widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected function _register_controls() {

		$obj = $this;

		$obj->start_controls_section(
			TCI_UET_SETTINGS . 'elementor_template_setting',
			[
				'label' => __( 'Template Settings', 'tci-uet' ),
				'tab'   => Controls_Manager::TAB_CONTENT,

			]
		);
		$obj->add_control(
			TCI_UET_SETTINGS . 'elementor_template_source',
			[
				'label'   => __( 'Elementor Template', 'tci-uet' ),
				'type'    => Controls_Manager::SELECT2,
				'options' => tci_uet_get_post_list( 'elementor_library' ),
				'default' => '',
			]
		);
		$obj->end_controls_section();

		$obj->start_controls_section(
			TCI_UET_SETTINGS . 'column_setting',
			[
				'label' => __( 'Column Settings', 'tci-uet' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		tci_uet_column_control( $obj, TCI_UET_SETTINGS );
		$obj->end_controls_section();

		$obj->start_controls_section(
			TCI_UET_SETTINGS . 'post_loop_query_setting',
			[
				'label' => __( 'Query Settings', 'tci-uet' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		tci_uet_query_controls( $obj, TCI_UET_SETTINGS );
		$obj->end_controls_section();

	}

	/**
	 * Render widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected function render() {
		$this->add_render_attribute( 'wrapper', 'class', 'tci-uet-widget' );
		$settings = $this->get_settings_for_display();
		$settings = tci_uet_array( $settings );

		$file = get_theme_file_path( 'tci-ultimate-elementor-themes/inc/elementor/tci-uet-post-loop.php' );
		if ( ! file_exists( $file ) ) {
			$file = tci_uet_root( 'inc/elements/tci-uet-post-loop.php' );
		}
		$args  = tci_uet_controls_query_args( $settings, TCI_UET_SETTINGS );
		$query = new \WP_Query( $args );
		if ( $query->have_posts() ) {
			include $file;
		}
	}
}
