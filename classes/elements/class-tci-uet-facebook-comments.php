<?php
/**
 * TCI UET Facebook Comments widget class
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.1
 */
namespace TCI_UET\Widgets;

tci_exit();

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use TCI_UET\TCI_Modules\TCI_Facebook_SDK_Manager;
use TCI_UET\TCI_Modules\TCI_Modules;

class TCI_UET_Facebook_Comments extends Widget_Base {
	/**
	 * Get widget name.
	 * Retrieve widget name.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'TCI_UET_Facebook_Comments';
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
		return __( 'TCI UET Facebook Comments', 'elementor-pro' );
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
		return 'tci tci-uet-facebook';
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
		return [ 'facebook', 'comments', 'embed' ];
	}

	/**
	 * Get script dependencies.
	 * Retrieve the list of script dependencies the element requires.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return array Element script dependencies.
	 */
	public function get_script_depends() {
		return [
			'tci-uet-frontend',
		];
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
				'label' => __( 'Comments Box', 'elementor-pro' ),
			]
		);

		TCI_Facebook_SDK_Manager::add_app_id_control( $this );

		$this->add_control(
			'comments_number',
			[
				'label'       => __( 'Comment Count', 'elementor-pro' ),
				'type'        => Controls_Manager::NUMBER,
				'min'         => 5,
				'max'         => 100,
				'default'     => '10',
				'description' => __( 'Minimum number of comments: 5', 'elementor-pro' ),
			]
		);

		$this->add_control(
			'order_by',
			[
				'label'   => __( 'Order By', 'elementor-pro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'social',
				'options' => [
					'social'       => __( 'Social', 'elementor-pro' ),
					'reverse_time' => __( 'Reverse Time', 'elementor-pro' ),
					'time'         => __( 'Time', 'elementor-pro' ),
				],
			]
		);

		$this->add_control(
			'url_type',
			[
				'label'     => __( 'Target URL', 'elementor-pro' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					TCI_Modules::URL_TYPE_CURRENT_PAGE => __( 'Current Page', 'elementor-pro' ),
					TCI_Modules::URL_TYPE_CUSTOM       => __( 'Custom', 'elementor-pro' ),
				],
				'default'   => TCI_Modules::URL_TYPE_CURRENT_PAGE,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'url_format',
			[
				'label'     => __( 'URL Format', 'elementor-pro' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					TCI_Modules::URL_FORMAT_PLAIN  => __( 'Plain Permalink', 'elementor-pro' ),
					TCI_Modules::URL_FORMAT_PRETTY => __( 'Pretty Permalink', 'elementor-pro' ),
				],
				'default'   => TCI_Modules::URL_FORMAT_PLAIN,
				'condition' => [
					'url_type' => TCI_Modules::URL_TYPE_CURRENT_PAGE,
				],
			]
		);

		$this->add_control(
			'url',
			[
				'label'       => __( 'Link', 'elementor-pro' ),
				'placeholder' => __( 'https://your-link.com', 'elementor-pro' ),
				'label_block' => true,
				'condition'   => [
					'url_type' => TCI_Modules::URL_TYPE_CUSTOM,
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

		if ( TCI_Modules::URL_TYPE_CURRENT_PAGE === $settings['url_type'] ) {
			$permalink = TCI_Facebook_SDK_Manager::get_permalink( $settings );
		} else {
			if ( ! filter_var( $settings['url'], FILTER_VALIDATE_URL ) ) {
				echo $this->get_title() . ': ' . esc_html__( 'Please enter a valid URL', 'elementor-pro' ); // XSS ok.

				return;
			}

			$permalink = esc_url( $settings['url'] );
		}

		$attributes = [
			'class'         => 'elementor-facebook-widget fb-comments',
			'data-href'     => $permalink,
			'data-numposts' => $settings['comments_number'],
			'data-order-by' => $settings['order_by'],
			// The style prevent's the `widget.handleEmptyWidget` to set it as an empty widget
			'style'         => 'min-height: 1px',
		];

		$this->add_render_attribute( 'embed_div', $attributes );

		echo '<div ' . $this->get_render_attribute_string( 'embed_div' ) . '></div>'; // XSS ok.
	}
}
