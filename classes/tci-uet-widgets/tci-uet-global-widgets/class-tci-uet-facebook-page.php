<?php
/**
 * TCI UET Facebook Page widget class
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.6
 */
namespace TCI_UET\TCI_UET_Widgets\TCI_UET_Global_Widgets;

tci_uet_exit();

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use TCI_UET\TCI_UET_Modules\TCI_UET_Facebook_Sdk;

class TCI_UET_Facebook_Page extends Widget_Base {
	/**
	 * Get widget name.
	 * Retrieve widget name.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'TCI_UET_Facebook_Page';
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
		return esc_html__( 'TCI UET Facebook Page', 'tci-uet' );
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
		return 'tci tci-uet-facebook-1';
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
	 * @return array Widget categories.
	 */
	public function get_keywords() {
		return [ 'facebook', 'social', 'embed', 'page' ];
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
				'label' => __( 'Page', 'tci-uet' ),
			]
		);

		TCI_UET_Facebook_Sdk::tci_uet_facebook_sdk_add_app_id_control( $this );

		$this->add_control(
			'url',
			[
				'label'       => __( 'Link', 'tci-uet' ),
				'placeholder' => 'https://www.facebook.com/your-page/',
				'default'     => 'https://web.facebook.com/pg/ThemecatInfo/',
				'label_block' => true,
				'description' => __( 'Paste the URL of the Facebook page.', 'tci-uet' ),
			]
		);

		$this->add_control(
			'tabs',
			[
				'label'       => __( 'Layout', 'tci-uet' ),
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'label_block' => true,
				'default'     => [
					'timeline',
				],
				'options'     => [
					'timeline' => __( 'Timeline', 'tci-uet' ),
					'events'   => __( 'Events', 'tci-uet' ),
					'messages' => __( 'Messages', 'tci-uet' ),
				],
			]
		);

		$this->add_control(
			'small_header',
			[
				'label'   => __( 'Small Header', 'tci-uet' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => '',
			]
		);

		$this->add_control(
			'show_cover',
			[
				'label'   => __( 'Cover Photo', 'tci-uet' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_facepile',
			[
				'label'   => __( 'Profile Photos', 'tci-uet' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_cta',
			[
				'label'   => __( 'Custom CTA Button', 'tci-uet' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'height',
			[
				'label'      => __( 'Height', 'tci-uet' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'unit' => 'px',
					'size' => 500,
				],
				'range'      => [
					'px' => [
						'min' => 70,
						'max' => 1000,
					],
				],
				'size_units' => [ 'px' ],
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

		if ( empty( $settings['url'] ) ) {
			echo $this->get_title() . ': ' . esc_html__( 'Please enter a valid URL', 'tci-uet' ); // XSS ok.

			return;
		}

		$height = $settings['height']['size'] . $settings['height']['unit'];

		$attributes = [
			'class'                      => 'elementor-facebook-widget fb-page',
			'data-href'                  => $settings['url'],
			'data-tabs'                  => implode( ',', $settings['tabs'] ),
			'data-height'                => $height,
			'data-small-header'          => $settings['small_header'] ? 'true' : 'false',
			'data-hide-cover'            => $settings['show_cover'] ? 'false' : 'true', // if `show` - don't hide.
			'data-show-facepile'         => $settings['show_facepile'] ? 'true' : 'false',
			'data-hide-cta'              => $settings['show_cta'] ? 'false' : 'true', // if `show` - don't hide.
			'data-adapt-container-width' => 'true', // try to adapt width (min 180px max 500px)
			// The style prevent's the `widget.handleEmptyWidget` to set it as an empty widget.
			'style'                      => 'min-height: 1px;height:' . $height,
		];

		$this->add_render_attribute( 'embed_div', $attributes );

		echo '<div ' . $this->get_render_attribute_string( 'embed_div' ) . '></div>'; // XSS ok.
	}
}
