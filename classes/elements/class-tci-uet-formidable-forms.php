<?php
/**
 * TCI UET Formidable plugin widget class
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.1
 */
namespace TCI_UET\Widgets;

tci_exit();

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class TCI_UET_Formidable_Forms extends Widget_Base {

	/**
	 * Get widget name.
	 * Retrieve widget name.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'TCI_UET_Formidable_Forms';
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
		return __( 'TCI UET Formidable Forms', 'tci-uet' );
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
		return 'tci tci-uet-edit';
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
		return [ 'tci-widget-plugins' ];
	}

	/**
	 * Attach keywords.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'contact', 'formidable', 'forms' ];
	}

	/**
	 * Register widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected function _register_controls() {
		if ( ! function_exists( 'load_formidable_forms' ) ) {
			$this->start_controls_section(
				TCI_SETTINGS . '_formidable_warning',
				[
					'label' => __( 'Warning!', 'tci-uet' ),
				]
			);
			$this->add_control(
				TCI_SETTINGS . '_formidable_warning_text',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => __( '<strong>Formidable</strong> is not installed/activated on your site. Please install and activate <strong>Formidable</strong> first.', 'tci-uet' ),
					'content_classes' => 'tci-uet-warning',
				]
			);
			$this->end_controls_section();

			return false;
		}
		/**
		 * Forms List
		 */
		$this->start_controls_section(
			TCI_SETTINGS . '_formidable',
			[
				'label' => __( 'Formidable', 'tci-uet' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			TCI_SETTINGS . '_formidable_id',
			[
				'label'   => __( 'Forms List', 'tci-uet' ),
				'type'    => Controls_Manager::SELECT,
				'options' => tci_formidable_table_query(),
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
		if ( ! function_exists( 'load_formidable_forms' ) ) {
			return false;
		}
		$settings = $this->get_settings_for_display();
		$settings = tci_array( $settings );
		echo do_shortcode( '[formidable id="' . $settings->get( TCI_SETTINGS . '_formidable_id' ) . '"]' );
	}
}
