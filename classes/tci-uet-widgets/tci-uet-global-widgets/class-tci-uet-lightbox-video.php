<?php
/**
 * TCI UET Video Lightbox widget class
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.1
 */
namespace TCI_UET\TCI_UET_Widgets\TCI_UET_Global_Widgets;

tci_uet_exit();

use Elementor\Controls_Manager;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Utils;
use Elementor\Widget_Base;
use Elementor\Plugin;
use Elementor\Embed;
use TCI_UET\TCI_UET_Utils;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Box_Shadow;

class TCI_UET_Lightbox_Video extends Widget_Base {

	/**
	 * Get widget name.
	 * Retrieve widget name.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'TCI_UET_Lightbox_Video';
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
		return __( 'TCI UET Lightbox Video', 'tci-uet' );
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
		return 'tci tci-uet-film-strip';
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
		return [ 'video', 'video box', 'light box', 'popup', 'video popup', 'image popup' ];
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
		return [ 'tci-uet-frontend' ];
	}

	/**
	 * Register widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected function _register_controls() {

		$this->video_controls();

		$this->thumbnail_style_controls();

		$this->icon_style_controls();

	}

	/**
	 * Thumbnail controls.
	 *
	 * @since  0.0.1
	 * @access private
	 */
	private function thumbnail_style_controls() {
		$this->start_controls_section(
			'section_thumbnail_style',
			[
				'label' => __( 'Thumbnail', 'tci-uet' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_bg_border',
				'selector' => "{{WRAPPER}} .tci-uet-lightbox-image-wrapper.tci-uet-{{ID}}",
			]
		);

		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_bg_radius',
			[
				'label'      => __( 'Border Radius', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					"{{WRAPPER}} .tci-uet-lightbox-image-wrapper.tci-uet-{{ID}}" => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_bg_shadow',
				'selector' => "{{WRAPPER}} .tci-uet-lightbox-image-wrapper.tci-uet-{{ID}}",
			]
		);

		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_height',
			[
				'type'       => Controls_Manager::SLIDER,
				'label'      => __( 'Height', 'tci-uet' ),
				'size_units' => [ 'px', 'em', 'rem', 'vh' ],
				'default'    => [
					'unit' => 'vh',
				],
				'range'      => [
					'px'  => [
						'min' => 100,
						'max' => 1000,
					],
					'vh'  => [
						'min' => 20,
					],
					'em'  => [
						'min' => 5,
					],
					'rem' => [
						'min' => 10,
					],
				],
				'selectors'  => [
					"{{WRAPPER}} .tci-uet-lightbox-image-wrapper.tci-uet-{{ID}}" => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_width',
			[
				'type'       => Controls_Manager::SLIDER,
				'label'      => __( 'Width', 'tci-uet' ),
				'range'      => [
					'px'  => [
						'min' => 100,
						'max' => 1140,
					],
					'%'   => [
						'min' => 50,
					],
					'em'  => [
						'min' => 5,
					],
					'rem' => [
						'min' => 10,
					],
				],
				'size_units' => [ '%', 'px', 'em', 'rem', ],
				'default'    => [
					'unit' => '%',
				],
				'selectors'  => [
					"{{WRAPPER}} .tci-uet-lightbox-image-wrapper.tci-uet-{{ID}}" => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_size',
			[
				'label'     => __( 'Size', 'tci-uet' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => [
					''        => __( 'Default', 'tci-uet' ),
					'auto'    => __( 'Auto', 'tci-uet' ),
					'cover'   => __( 'Cover', 'tci-uet' ),
					'contain' => __( 'Contain', 'tci-uet' ),
				],
				'selectors' => [
					"{{WRAPPER}} .tci-uet-lightbox-image-wrapper.tci-uet-{{ID}}" => 'background-size: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_position', [
				'label'     => __( 'Position', 'tci-uet' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '',
				'options'   => [
					''              => __( 'Default', 'tci-uet' ),
					'top left'      => __( 'Top Left', 'tci-uet' ),
					'top center'    => __( 'Top Center', 'tci-uet' ),
					'top right'     => __( 'Top Right', 'tci-uet' ),
					'center left'   => __( 'Center Left', 'tci-uet' ),
					'center center' => __( 'Center Center', 'tci-uet' ),
					'center right'  => __( 'Center Right', 'tci-uet' ),
					'bottom left'   => __( 'Bottom Left', 'tci-uet' ),
					'bottom center' => __( 'Bottom Center', 'tci-uet' ),
					'bottom right'  => __( 'Bottom Right', 'tci-uet' ),
				],
				'selectors' => [
					"{{WRAPPER}} .tci-uet-lightbox-image-wrapper.tci-uet-{{ID}}" => 'background-position: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Video controls.
	 *
	 * @since  0.0.1
	 * @access private
	 */
	private function video_controls() {

		$this->start_controls_section(
			'section_video',
			[
				'label' => __( 'Video', 'tci-uet' ),
			]
		);

		$this->add_control(
			'image',
			[
				'label'   => __( 'Thumbnail Image', 'tci-uet' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [
					'active' => true,
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'video',
			[
				'label'         => __( 'Video Link', 'tci-uet' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => __( 'Enter your video link', 'tci-uet' ),
				'description'   => __( 'YouTube or Vimeo link', 'tci-uet' ),
				'show_external' => false,
			]
		);

		$this->add_control(
			'video_auto_play',
			[
				'label'   => __( 'Autoplay', 'tci-uet' ),
				'type'    => Controls_Manager::SWITCHER,
				'defualt' => 'yes',
			]
		);

		$this->add_control(
			'video_replay',
			[
				'label'   => __( 'Rel', 'tci-uet' ),
				'type'    => Controls_Manager::SWITCHER,
				'defualt' => 'yes',
			]
		);

		$this->add_control(
			'video_controls',
			[
				'label'   => __( 'Controls', 'tci-uet' ),
				'type'    => Controls_Manager::SWITCHER,
				'defualt' => 'yes',
			]
		);

		$this->add_control(
			'video_icon',
			[
				'label'   => __( 'Icon', 'tci-uet' ),
				'type'    => Controls_Manager::ICONS,
				'defualt' => [
					'value'   => 'far fa-play-circle',
					'library' => 'regular',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Icon controls.
	 *
	 * @since  0.0.1
	 * @access private
	 */
	private function icon_style_controls() {

		$this->start_controls_section(
			TCI_UET_SETTINGS . '_section_icon',
			[
				'label' => __( 'Icon', 'tci-uet' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_icon_margin',
			[
				'label'      => __( 'Top', 'tci-uet' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'range'      => [
					'px'  => [
						'min' => 0,
						'max' => 1000,
					],
					'em'  => [
						'min' => 0,
						'max' => 1000,
					],
					'rem' => [
						'min' => 0,
						'max' => 1000,
					],
					'%'   => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					"{{WRAPPER}} .tci-uet-lightbox-image-wrapper.tci-uet-{{ID}} .elementor-custom-embed-play" => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_icon_padding',
			[
				'label'      => __( 'Left', 'tci-uet' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'range'      => [
					'px'  => [
						'min' => 0,
						'max' => 1000,
					],
					'em'  => [
						'min' => 0,
						'max' => 1000,
					],
					'rem' => [
						'min' => 0,
						'max' => 1000,
					],
					'%'   => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors'  => [
					"{{WRAPPER}} .tci-uet-lightbox-image-wrapper.tci-uet-{{ID}} .elementor-custom-embed-play" => 'left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_icon_bg',
			[
				'label'     => __( 'Background', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					"{{WRAPPER}} .tci-uet-lightbox-image-wrapper.tci-uet-{{ID}} .elementor-custom-embed-play i" => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_icon_color',
			[
				'label'     => __( 'Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					"{{WRAPPER}} .tci-uet-lightbox-image-wrapper.tci-uet-{{ID}} .elementor-custom-embed-play i" => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_icon_border',
				'selector' => "{{WRAPPER}} .tci-uet-lightbox-image-wrapper.tci-uet-{{ID}} .elementor-custom-embed-play i",
			]
		);

		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_icon_radius',
			[
				'label'      => __( 'Border Radius', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					"{{WRAPPER}} .tci-uet-lightbox-image-wrapper.tci-uet-{{ID}} .elementor-custom-embed-play i" => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_play_icon_size',
			[
				'label'     => __( 'Size', 'tci-uet' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 20,
						'max' => 150,
					],
				],
				'selectors' => [
					"{{WRAPPER}} .tci-uet-lightbox-image-wrapper.tci-uet-{{ID}} .elementor-custom-embed-play i" => 'font-size: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_play_icon_opaticy',
			[
				'label'     => __( 'Opacity', 'tci-uet' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min'  => 0.1,
						'max'  => 1,
						'step' => 0.1,
					],
				],
				'selectors' => [
					"{{WRAPPER}} .tci-uet-lightbox-image-wrapper.tci-uet-{{ID}} .elementor-custom-embed-play i" => 'opacity: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'           => TCI_UET_SETTINGS . '_icon_text_shadow',
				'selector'       => "{{WRAPPER}} .tci-uet-lightbox-image-wrapper.tci-uet-{{ID}} .elementor-custom-embed-play i",
				'fields_options' => [
					'text_shadow_type' => [
						'label' => __( 'Shadow', 'tci-uet' ),
					],
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
	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['image']['url'] ) ) {
			return;
		}

		$this->add_render_attribute( 'wrapper', 'class', [ 'tci-widget', 'elementor-image' ] );

		$this->add_render_attribute( 'tci-uet-lightbox-image-wrapper', 'class', [
			'tci-uet-lightbox-image-wrapper',
			"tci-uet-{$this->get_id()}",
		] );

		if ( $settings['video'] ) {

			if ( Plugin::$instance->editor->is_edit_mode() ) {
				$this->add_render_attribute( 'link', [
					'class' => 'elementor-clickable',
				] );
			}

			$embed_url_params             = [];
			$embed_url_params['autoplay'] = ( 'yes' === $settings['video_auto_play'] ) ? 1 : 0;
			$embed_url_params['rel']      = ( 'yes' === $settings['video_replay'] ) ? 1 : 0;
			$embed_url_params['controls'] = ( 'yes' === $settings['video_controls'] ) ? 1 : 0;
			$this->add_render_attribute( 'link', 'href', TCI_UET_Utils::create_action_url( 'lightbox', $this->get_video_settings( $settings, $embed_url_params ) ) );

		}

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<a <?php echo $this->get_render_attribute_string( 'link' ); ?> id="<?php echo $this->get_id(); ?>">
				<div <?php echo $this->get_render_attribute_string( 'tci-uet-lightbox-image-wrapper' ); ?> style="background-image:url(<?php echo $settings['image']['url']; ?>)">
					<div class="elementor-custom-embed-play">
						<?php echo Icons_Manager::render_icon( $settings['video_icon'], [ 'aria-hidden' => 'true' ] ); ?>
						<span class="elementor-screen-only"><?php _e( 'Play', 'tci-uet' ); ?></span>
					</div>
				</div>
			</a>
		</div>
		<?php
	}

	private function get_video_settings( $settings, $options = [] ) {
		$video_properties = Embed::get_video_properties( $settings['video']['url'] );
		$video_url        = null;
		if ( ! $video_properties ) {
			$video_type = 'hosted';
			$video_url  = $settings['video']['url'];
		} else {
			$video_type = $video_properties['provider'];
			$video_url  = Embed::get_embed_url( $settings['video']['url'], $options );
		}

		if ( null === $video_url ) {
			return '';
		}

		return [
			'type'      => 'video',
			'videoType' => $video_type,
			'url'       => $video_url,
		];
	}
}
