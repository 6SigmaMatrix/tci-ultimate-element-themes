<?php
/**
 * TCI UET Facebook Button widget class
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.6
 */
namespace TCI_UET\TCI_UET_Widgets\TCI_UET_Global_Widgets;

tci_uet_exit();

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use TCI_UET\TCI_UET_Modules\TCI_UET_Facebook_Sdk;
use TCI_UET\TCI_UET_Modules\TCI_UET_Social;
use Elementor\Plugin;

class TCI_UET_Facebook_Button extends Widget_Base {
	/**
	 * Get widget name.
	 * Retrieve widget name.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'TCI_UET_Facebook_Button';
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
		return __( 'TCI UET Facebook Button', 'tci-uet' );
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
		return 'tci tci-uet-social-media';
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
		return [ 'facebook', 'social', 'embed', 'button', 'like', 'share', 'recommend' ];
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
				'label' => __( 'Button', 'tci-uet' ),
			]
		);

		TCI_UET_Facebook_Sdk::tci_uet_facebook_sdk_add_app_id_control( $this );

		$this->add_control(
			'type',
			[
				'label'   => __( 'Type', 'tci-uet' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'like',
				'options' => [
					'like'      => __( 'Like', 'tci-uet' ),
					'recommend' => __( 'Recommend', 'tci-uet' ),
				],
			]
		);

		$this->add_control(
			'layout',
			[
				'label'   => __( 'Layout', 'tci-uet' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'standard',
				'options' => [
					'standard'     => __( 'Standard', 'tci-uet' ),
					'button'       => __( 'Button', 'tci-uet' ),
					'button_count' => __( 'Button Count', 'tci-uet' ),
					'box_count'    => __( 'Box Count', 'tci-uet' ),
				],
			]
		);

		$this->add_control(
			'size',
			[
				'label'   => __( 'Size', 'tci-uet' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'small',
				'options' => [
					'small' => __( 'Small', 'tci-uet' ),
					'large' => __( 'Large', 'tci-uet' ),
				],
			]
		);

		$this->add_control(
			'color_scheme',
			[
				'label'   => __( 'Color Scheme', 'tci-uet' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'light',
				'options' => [
					'light' => __( 'Light', 'tci-uet' ),
					'dark'  => __( 'Dark', 'tci-uet' ),
				],
			]
		);

		$this->add_control(
			'show_share',
			[
				'label'   => __( 'Share Button', 'tci-uet' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => '',
			]
		);

		$this->add_control(
			'show_faces',
			[
				'label'   => __( 'Faces', 'tci-uet' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => '',
			]
		);

		$this->add_control(
			'url_type',
			[
				'label'     => __( 'Target URL', 'tci-uet' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					TCI_UET_Social::URL_TYPE_CURRENT_PAGE => __( 'Current Page', 'tci-uet' ),
					TCI_UET_Social::URL_TYPE_CUSTOM       => __( 'Custom', 'tci-uet' ),
				],
				'default'   => TCI_UET_Social::URL_TYPE_CURRENT_PAGE,
				'separator' => 'before',
				'condition' => [
					'type' => [ 'like', 'recommend' ],
				],
			]
		);

		$this->add_control(
			'url_format',
			[
				'label'     => __( 'URL Format', 'tci-uet' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					TCI_UET_Social::URL_FORMAT_PLAIN  => __( 'Plain Permalink', 'tci-uet' ),
					TCI_UET_Social::URL_FORMAT_PRETTY => __( 'Pretty Permalink', 'tci-uet' ),
				],
				'default'   => TCI_UET_Social::URL_FORMAT_PLAIN,
				'condition' => [
					'url_type' => TCI_UET_Social::URL_TYPE_CURRENT_PAGE,
				],
			]
		);

		$this->add_control(
			'url',
			[
				'label'       => __( 'Link', 'tci-uet' ),
				'placeholder' => __( 'https://your-link.com', 'tci-uet' ),
				'label_block' => true,
				'condition'   => [
					'type'     => [ 'like', 'recommend' ],
					'url_type' => TCI_UET_Social::URL_TYPE_CUSTOM,
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

		// Validate URL
		switch ( $settings['type'] ) {
			case 'like':
			case 'recommend':
				if ( TCI_UET_Social::URL_TYPE_CUSTOM === $settings['url_type'] && ! filter_var( $settings['url'], FILTER_VALIDATE_URL ) ) {
					if ( Plugin::instance()->editor->is_edit_mode() ) {
						echo $this->get_title() . ': ' . esc_html__( 'Please enter a valid URL', 'tci-uet' ); // XSS ok.
					}

					return;
				}
				break;
		}

		$attributes = [
			'data-layout'      => $settings['layout'],
			'data-colorscheme' => $settings['color_scheme'],
			'data-size'        => $settings['size'],
			'data-show-faces'  => $settings['show_faces'] ? 'true' : 'false',
			// The style prevent's the `widget.handleEmptyWidget` to set it as an empty widget
			'style'            => 'min-height: 1px',
		];

		switch ( $settings['type'] ) {
			case 'like':
			case 'recommend':
				if ( TCI_UET_Social::URL_TYPE_CURRENT_PAGE === $settings['url_type'] ) {
					$permalink = TCI_UET_Facebook_Sdk::tci_uet_facebook_sdk_get_permalink( $settings );
				} else {
					$permalink = esc_url( $settings['url'] );
				}

				$attributes['class']       = 'elementor-facebook-widget fb-like';
				$attributes['data-href']   = $permalink;
				$attributes['data-share']  = $settings['show_share'] ? 'true' : 'false';
				$attributes['data-action'] = $settings['type'];
				break;
		}

		$this->add_render_attribute( 'embed_div', $attributes );

		echo '<div ' . $this->get_render_attribute_string( 'embed_div' ) . '></div>'; // XSS ok.
	}
}
