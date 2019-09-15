<?php
/**
 * TCI UET Facebook Embed widget class
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.6
 */
namespace TCI_UET\TCI_UET_Widgets\TCI_UET_Global_Widgets;

tci_uet_exit();

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use TCI_UET\TCI_UET_Modules\TCI_UET_Facebook_Sdk;

class TCI_UET_Facebook_Embed extends Widget_Base {
	/**
	 * Get widget name.
	 * Retrieve widget name.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'TCI_UET_Facebook_Embed';
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
		return __( 'TCI UET Facebook Embed', 'tci-uet' );
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
		return 'tci tci-uet-bullhorn';
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
		return [ 'facebook', 'social', 'embed', 'video', 'post', 'comment' ];
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
				'label' => __( 'Embed', 'tci-uet' ),
			]
		);

		TCI_UET_Facebook_Sdk::tci_uet_facebook_sdk_add_app_id_control( $this );

		$this->add_control(
			'type',
			[
				'label'   => __( 'Type', 'tci-uet' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'post',
				'options' => [
					'post'    => __( 'Post', 'tci-uet' ),
					'video'   => __( 'Video', 'tci-uet' ),
					'comment' => __( 'Comment', 'tci-uet' ),
				],
			]
		);

		$this->add_control(
			'post_url',
			[
				'label'       => __( 'URL', 'tci-uet' ),
				'default'     => 'https://www.facebook.com/elemntor/posts/1823653464612271',
				'label_block' => true,
				'condition'   => [
					'type' => 'post',
				],
				'description' => __( 'Hover over the date next to the post, and copy its link address.', 'tci-uet' ),
			]
		);

		$this->add_control(
			'video_url',
			[
				'label'       => __( 'URL', 'tci-uet' ),
				'default'     => 'https://www.facebook.com/elemntor/videos/1683988961912056/',
				'label_block' => true,
				'condition'   => [
					'type' => 'video',
				],
				'description' => __( 'Hover over the date next to the video, and copy its link address.', 'tci-uet' ),
			]
		);

		$this->add_control(
			'comment_url',
			[
				'label'       => __( 'URL', 'tci-uet' ),
				'default'     => 'https://www.facebook.com/elemntor/videos/1811703749140576/?comment_id=1812873919023559',
				'label_block' => true,
				'condition'   => [
					'type' => 'comment',
				],
				'description' => __( 'Hover over the date next to the comment, and copy its link address.', 'tci-uet' ),
			]
		);

		$this->add_control(
			'include_parent',
			[
				'label'       => __( 'Parent Comment', 'tci-uet' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => '',
				'description' => __( 'Set to include parent comment (if URL is a reply).', 'tci-uet' ),
				'condition'   => [
					'type' => 'comment',
				],
			]
		);

		$this->add_control(
			'show_text',
			[
				'label'       => __( 'Full Post', 'tci-uet' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => '',
				'description' => __( 'Show the full text of the post', 'tci-uet' ),
				'condition'   => [
					'type' => [ 'post', 'video' ],
				],
			]
		);

		$this->add_control(
			'video_allowfullscreen',
			[
				'label'     => __( 'Allow Full Screen', 'tci-uet' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => '',
				'condition' => [
					'type' => 'video',
				],
			]
		);

		$this->add_control(
			'video_autoplay',
			[
				'label'     => __( 'Autoplay', 'tci-uet' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => '',
				'condition' => [
					'type' => 'video',
				],
			]
		);

		$this->add_control(
			'video_show_captions',
			[
				'label'       => __( 'Captions', 'tci-uet' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => '',
				'description' => __( 'Show captions if available (only on desktop).', 'tci-uet' ),
				'condition'   => [
					'type' => 'video',
				],
			]
		);
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

		if ( empty( $settings['type'] ) ) {
			esc_html_e( 'Please set the embed type', 'tci-uet' );

			return;
		}

		if ( 'comment' === $settings['type'] && empty( $settings['comment_url'] ) || 'post' === $settings['type'] && empty( $settings['post_url'] ) || 'video' === $settings['type'] && empty( $settings['video_url'] ) ) {
			esc_html_e( 'Please enter a valid URL', 'tci-uet' );

			return;
		}

		$attributes = [
			// The style prevent's the `widget.handleEmptyWidget` to set it as an empty widget
			'style' => 'min-height: 1px',
		];

		switch ( $settings['type'] ) {
			case 'comment':
				$attributes['class']               = 'elementor-facebook-widget fb-comment-embed';
				$attributes['data-href']           = esc_url( $settings['comment_url'] );
				$attributes['data-include-parent'] = 'yes' === $settings['include_parent'] ? 'true' : 'false';
				break;
			case 'post':
				$attributes['class']          = 'elementor-facebook-widget fb-post';
				$attributes['data-href']      = esc_url( $settings['post_url'] );
				$attributes['data-show-text'] = 'yes' === $settings['show_text'] ? 'true' : 'false';
				break;
			case 'video':
				$attributes['class']                = 'elementor-facebook-widget fb-video';
				$attributes['data-href']            = esc_url( $settings['video_url'] );
				$attributes['data-show-text']       = 'yes' === $settings['show_text'] ? 'true' : 'false';
				$attributes['data-allowfullscreen'] = 'yes' === $settings['video_allowfullscreen'] ? 'true' : 'false';
				$attributes['data-autoplay']        = 'yes' === $settings['video_autoplay'] ? 'true' : 'false';
				$attributes['data-show-captions']   = 'yes' === $settings['video_show_captions'] ? 'true' : 'false';
				break;
		}

		$this->add_render_attribute( 'embed_div', $attributes );

		echo '<div ' . $this->get_render_attribute_string( 'embed_div' ) . '></div>'; // XSS ok.
	}
}
