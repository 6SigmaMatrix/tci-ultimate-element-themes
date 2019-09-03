<?php
/**
 * TCI UET Revolution Slider plugin widget class
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.5
 */
namespace TCI_UET\TCI_UET_Widgets;

tci_uet_exit();

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class TCI_UET_Revolution_Slider extends Widget_Base {

	/**
	 * Get widget name.
	 * Retrieve widget name.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'TCI_UET_Revolution_Slider';
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
		return __( 'TCI UET Revolution Slider', 'tci-uet' );
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
		return 'tci tci-uet-refresh';
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
		return [ 'slider', 'revolution slider', 'recolution' ];
	}

	/**
	 * Register widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected function _register_controls() {
		if ( ! class_exists( 'RevSliderFront' ) ) {
			$this->start_controls_section(
				TCI_UET_SETTINGS . '_revolution_slider_warning',
				[
					'label' => __( 'Warning!', 'tci-uet' ),
				]
			);
			$this->add_control(
				TCI_UET_SETTINGS . '_revolution_slider_warning_text',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => __( '<strong>Revolution Slider</strong> is not installed/activated on your site. Please install and activate <strong>Revolution Slider</strong> first.', 'tci-uet' ),
					'content_classes' => 'tci-uet-warning',
				]
			);
			$this->end_controls_section();

			return false;
		}
		/**
		 * Slides List
		 */
		$this->start_controls_section(
			TCI_UET_SETTINGS . '_revolution_slider',
			[
				'label' => __( 'Revolution Slider', 'tci-uet' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_revolution_slider_slug',
			[
				'label'   => __( 'Slider List', 'tci-uet' ),
				'type'    => Controls_Manager::SELECT,
				'options' => tci_rev_slider_table_query(),
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
		if ( ! class_exists( 'RevSliderFront' ) ) {
			return false;
		}
		$this->add_render_attribute( 'wrapper', 'class', 'tci-uet-widget' );
		$settings = $this->get_settings_for_display();
		$settings = tci_uet_array( $settings );

		echo do_shortcode( '[rev_slider alias="' . $settings->get( TCI_UET_SETTINGS . '_revolution_slider_slug' ) . '"]' );
	}
}
