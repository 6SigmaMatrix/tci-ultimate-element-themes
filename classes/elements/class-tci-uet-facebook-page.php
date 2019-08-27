<?php
/**
 * TCI UET Facebook Page widget class
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.1
 */
namespace TCI_UET\Widgets;

tci_exit();

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use TCI_UET\TCI_Modules\TCI_Facebook_SDK_Manager;

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
		return esc_html__( 'TCI UET Facebook Page', 'elementor-pro' );
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
		return 'eicon-fb-feed';
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
				'label' => __( 'Page', 'elementor-pro' ),
			]
		);

		TCI_Facebook_SDK_Manager::add_app_id_control( $this );

		$this->add_control(
			'url',
			[
				'label'       => __( 'Link', 'elementor-pro' ),
				'placeholder' => 'https://www.facebook.com/your-page/',
				'default'     => 'https://www.facebook.com/elemntor/',
				'label_block' => true,
				'description' => __( 'Paste the URL of the Facebook page.', 'elementor-pro' ),
			]
		);

		$this->add_control(
			'tabs',
			[
				'label'       => __( 'Layout', 'elementor-pro' ),
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'label_block' => true,
				'default'     => [
					'timeline',
				],
				'options'     => [
					'timeline' => __( 'Timeline', 'elementor-pro' ),
					'events'   => __( 'Events', 'elementor-pro' ),
					'messages' => __( 'Messages', 'elementor-pro' ),
				],
			]
		);

		$this->add_control(
			'small_header',
			[
				'label'   => __( 'Small Header', 'elementor-pro' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => '',
			]
		);

		$this->add_control(
			'show_cover',
			[
				'label'   => __( 'Cover Photo', 'elementor-pro' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_facepile',
			[
				'label'   => __( 'Profile Photos', 'elementor-pro' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_cta',
			[
				'label'   => __( 'Custom CTA Button', 'elementor-pro' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'height',
			[
				'label'      => __( 'Height', 'elementor-pro' ),
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
			echo $this->get_title() . ': ' . esc_html__( 'Please enter a valid URL', 'elementor-pro' ); // XSS ok.

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
