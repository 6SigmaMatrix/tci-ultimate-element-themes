<?php
/**
 * TCI UET WPForms plugin widget class
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.6
 */
namespace TCI_UET\TCI_UET_Widgets\TCI_UET_Forms_Widgets;

tci_uet_exit();

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class TCI_UET_Wpforms extends Widget_Base {

	/**
	 * Get widget name.
	 * Retrieve widget name.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'TCI_UET_Wpforms';
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
		return __( 'TCI UET WPForms', 'tci-uet' );
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
		return 'tci tci-uet-bear';
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
		return [ 'tci-uet-forms-widgets' ];
	}

	/**
	 * Register widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected function _register_controls() {
		if ( ! function_exists( 'wpforms' ) ) {
			$this->start_controls_section(
				TCI_UET_SETTINGS . '_wpforms_warning',
				[
					'label' => __( 'Warning!', 'tci-uet' ),
				]
			);
			$this->add_control(
				TCI_UET_SETTINGS . '_wpforms_warning_text',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => __( '<strong>WPForms</strong> is not installed/activated on your site. Please install and activate <strong>WPForms</strong> first.', 'tci-uet' ),
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
			TCI_UET_SETTINGS . '_wpforms',
			[
				'label' => __( 'WPForms', 'tci-uet' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_wpforms_slug',
			[
				'label'   => __( 'Forms List', 'tci-uet' ),
				'type'    => Controls_Manager::SELECT,
				'options' => tci_uet_get_post_list( 'wpforms' ),
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
		if ( ! function_exists( 'wpforms' ) ) {
			return false;
		}
		$this->add_render_attribute( 'wrapper', 'class', 'tci-uet-widget' );
		$settings = $this->get_settings_for_display();
		$settings = tci_uet_array( $settings );

		$post = get_page_by_path( $settings->get( TCI_UET_SETTINGS . '_wpforms_slug' ), OBJECT, 'wpforms' );

		if ( ! empty( $post ) ) {
			echo do_shortcode( '[wpforms id="' . $post->ID . '" title="false" description="false"]' );
		}
	}
}
