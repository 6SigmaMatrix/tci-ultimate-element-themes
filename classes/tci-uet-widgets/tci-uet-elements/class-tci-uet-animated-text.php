<?php
/**
 * TCI UET Animated Text widget class
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.5
 */
namespace TCI_UET\TCI_UET_Widgets;

tci_uet_exit();

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Repeater;
use Elementor\Widget_Base;

class TCI_UET_Animated_Text extends Widget_Base {

	/**
	 * Get widget name.
	 * Retrieve widget name.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'TCI_UET_Animated_Text';
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
		return __( 'TCI UET Animated Text', 'tci-uet' );
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
		return 'tci-uet-ver tci tci-uet-abc-block';
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
		return [ 'animated', 'heading', 'title', 'text' ];
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
			'tci-uet-typeit',
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
			TCI_UET_SETTINGS . 'section_title_settings',
			[
				'label' => __( 'Title', 'elementor' ),
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_size',
			[
				'label'   => __( 'Size', 'elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => __( 'Default', 'elementor' ),
					'small'   => __( 'Small', 'elementor' ),
					'medium'  => __( 'Medium', 'elementor' ),
					'large'   => __( 'Large', 'elementor' ),
					'xl'      => __( 'XL', 'elementor' ),
					'xxl'     => __( 'XXL', 'elementor' ),
				],
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_header_size',
			[
				'label'   => __( 'HTML Tag', 'elementor' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
					'p'    => 'P',
				],
				'default' => 'h1',
			]
		);

		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_align',
			[
				'label'     => __( 'Alignment', 'elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'    => [
						'title' => __( 'Left', 'elementor' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'  => [
						'title' => __( 'Center', 'elementor' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'   => [
						'title' => __( 'Right', 'elementor' ),
						'icon'  => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'elementor' ),
						'icon'  => 'eicon-text-align-justify',
					],
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_view',
			[
				'label'   => __( 'View', 'elementor' ),
				'type'    => Controls_Manager::HIDDEN,
				'default' => 'traditional',
			]
		);

		$this->before_text_controls();

		$this->animated_text_controls();

		$this->after_text_controls();

		$this->end_controls_section();

		$this->js_controls();

		$this->style_controls();
	}

	/**
	 * Before Text
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected function before_text_controls() {
		$this->add_control(
			TCI_UET_SETTINGS . '_section_title_before_hr',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_section_title_before',
			[
				'label'     => __( 'Before Text', 'elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'after',
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_title_before',
			[
				'label'       => __( 'Text', 'elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => __( 'Enter your title', 'elementor' ),
				'default'     => __( 'Before Text Here', 'elementor' ),
			]
		);
	}

	/**
	 * Animated Text
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected function animated_text_controls() {
		$this->add_control(
			TCI_UET_SETTINGS . '_section_animated_title_hr',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_section_animated_title',
			[
				'label'     => __( 'Animated Text', 'elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'after',
			]
		);

		$repeat = new Repeater();

		$repeat->add_control(
			TCI_UET_SETTINGS . '_animated_title',
			[
				'label'       => __( 'Text', 'elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => __( 'Enter your title', 'elementor' ),
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_animated_title_list',
			[
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeat->get_controls(),
				'default'     => [
					[
						TCI_UET_SETTINGS . '_animated_title' => __( 'Designer', 'tci-uet' ),
					],
					[
						TCI_UET_SETTINGS . '_animated_title' => __( 'Developer', 'tci-uet' ),
					],
					[
						TCI_UET_SETTINGS . '_animated_title' => __( 'Awesome', 'tci-uet' ),
					],
				],
				'title_field' => '{{{ ' . TCI_UET_SETTINGS . '_animated_title }}}',
			]
		);
	}

	/**
	 * After Text
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected function after_text_controls() {
		$this->add_control(
			TCI_UET_SETTINGS . '_section_title_after_hr',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_section_title_after',
			[
				'label'     => __( 'After Text', 'elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'after',
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_title_after',
			[
				'label'       => __( 'Text', 'elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => __( 'Enter your title', 'elementor' ),
				'default'     => __( 'After Text Here', 'elementor' ),
			]
		);
	}

	/**
	 * Js Controls
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected function js_controls() {
		$this->start_controls_section(
			TCI_UET_SETTINGS . '_section_title_js',
			[
				'label' => __( 'Animation', 'elementor' ),
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_animation_t_speed',
			[
				'label'       => __( 'Typing Speed', 'elementor' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => __( 'Measured in milliseconds between each step.', 'tci-uet' ),
				'min'         => 100,
				'step'        => 100,
				'default'     => 100,
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_animation_d_speed',
			[
				'label'       => __( 'Delete Speed', 'elementor' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => __( 'Measured in milliseconds between each step.', 'tci-uet' ),
				'min'         => 100,
				'step'        => 100,
				'default'     => 100,
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_animation_k_speed',
			[
				'label'       => __( 'Cursor Speed', 'elementor' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => __( 'The blinking speed of the cursor, measured in milliseconds.', 'tci-uet' ),
				'min'         => 100,
				'step'        => 100,
				'default'     => 1000,
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_animation_n_s_delay',
			[
				'label'       => __( 'Next String Delay', 'elementor' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => __( 'The amount of time (in milliseconds) between typing multiple strings.', 'tci-uet' ),
				'min'         => 100,
				'step'        => 10,
				'default'     => 750,
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_animation_s_delay',
			[
				'label'       => __( 'Start Delay', 'elementor' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => __( 'The amount of time before the plugin begins typing after being initialized.', 'tci-uet' ),
				'min'         => 100,
				'step'        => 10,
				'default'     => 250,
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_animation_loop',
			[
				'label'        => __( 'Loop', 'elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => __( 'Whether your strings will continuously loop after completing.', 'tci-uet' ),
				'return_value' => true,
				'default'      => true,
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_animation_life_like',
			[
				'label'        => __( 'Life Like', 'elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => __( 'Makes the typing pace irregular, as a real person is doing it.', 'tci-uet' ),
				'return_value' => true,
				'default'      => true,
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_animation_cursor',
			[
				'label'        => __( 'Cursor', 'elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => __( 'Show a blinking cursor at the end of the string(s).', 'tci-uet' ),
				'return_value' => true,
				'default'      => true,
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_animation_break_lines',
			[
				'label'        => __( 'Break Lines', 'elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => __( 'Controls whether multiple strings are printed on top of each other or if they’re deleted and replaced by each other.', 'tci-uet' ),
				'return_value' => true,
				'default'      => true,
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_animation_s_Delete',
			[
				'label'        => __( 'Start Delete', 'elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => __( 'Whether to begin instance by deleting strings inside element, and then typing what strings are defined via companion functions.', 'tci-uet' ),
				'return_value' => true,
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style Controls
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected function style_controls() {
		$this->start_controls_section(
			TCI_UET_SETTINGS . '_section_title_style',
			[
				'label' => __( 'Text', 'elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_title_color',
			[
				'label'     => __( 'Text Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					// Stronger selector to avoid section style from overwriting
					'{{WRAPPER}} .tci-uet-widget.tci-uet-widget.elementor-widget-heading .elementor-heading-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .tci-uet-widget .elementor-heading-title',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_text_shadow',
				'selector' => '{{WRAPPER}} .tci-uet-widget .elementor-heading-title',
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_blend_mode',
			[
				'label'     => __( 'Blend Mode', 'elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''            => __( 'Normal', 'elementor' ),
					'multiply'    => 'Multiply',
					'screen'      => 'Screen',
					'overlay'     => 'Overlay',
					'darken'      => 'Darken',
					'lighten'     => 'Lighten',
					'color-dodge' => 'Color Dodge',
					'saturation'  => 'Saturation',
					'color'       => 'Color',
					'difference'  => 'Difference',
					'exclusion'   => 'Exclusion',
					'hue'         => 'Hue',
					'luminosity'  => 'Luminosity',
				],
				'selectors' => [
					'{{WRAPPER}} .tci-uet-widget .elementor-heading-title' => 'mix-blend-mode: {{VALUE}}',
				],
				'separator' => 'none',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			TCI_UET_SETTINGS . '_section_animate_title_style',
			[
				'label' => __( 'Animated Text', 'elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_animate_title_color',
			[
				'label'     => __( 'Text Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					// Stronger selector to avoid section style from overwriting
					'{{WRAPPER}} .tci-uet-widget.elementor-widget-heading .tci-uet-animated-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_animate_title_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .tci-uet-widget .tci-uet-animated-text',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_animate_title_text_shadow',
				'selector' => '{{WRAPPER}} .tci-uet-widget .tci-uet-animated-text',
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_animate_title_blend_mode',
			[
				'label'     => __( 'Blend Mode', 'elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''            => __( 'Normal', 'elementor' ),
					'multiply'    => 'Multiply',
					'screen'      => 'Screen',
					'overlay'     => 'Overlay',
					'darken'      => 'Darken',
					'lighten'     => 'Lighten',
					'color-dodge' => 'Color Dodge',
					'saturation'  => 'Saturation',
					'color'       => 'Color',
					'difference'  => 'Difference',
					'exclusion'   => 'Exclusion',
					'hue'         => 'Hue',
					'luminosity'  => 'Luminosity',
				],
				'selectors' => [
					'{{WRAPPER}} .tci-uet-widget .tci-uet-animated-text' => 'mix-blend-mode: {{VALUE}}',
				],
				'separator' => 'none',
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
		$settings = tci_uet_array( $settings );

		$this->add_render_attribute( 'tci-uet-text-wrapper', 'class', [
			'tci-uet-widget',
			'elementor-widget-heading',
		] );
		$this->add_render_attribute( 'tci-uet-animated-text-wrapper', 'class', 'tci-uet-animated-text' );
		$this->add_render_attribute( 'tci-uet-text-title', 'class', 'elementor-heading-title' );

		if ( ! empty( $settings->get( TCI_UET_SETTINGS . '_size' ) ) ) {
			$this->add_render_attribute( 'tci-uet-text-title', 'class', 'elementor-size-' . $settings->get( TCI_UET_SETTINGS . '_size' ) );
		}

		$this->add_inline_editing_attributes( 'title' );

		$title_before   = $settings->get( TCI_UET_SETTINGS . '_title_before' );
		$title_animated = $settings->get( TCI_UET_SETTINGS . '_animated_title_list.0.' . TCI_UET_SETTINGS . '_animated_title' );
		$title_after    = $settings->get( TCI_UET_SETTINGS . '_title_after' );
		?>
		<div <?php echo $this->get_render_attribute_string( 'tci-uet-text-wrapper' ); ?>>
			<?php
			$title_html = sprintf(
				'<%1$s %2$s>%3$s <span %7$s id="tci-uet-animated-%6$s">%4$s</span> %5$s</%1$s>',
				$settings->get( TCI_UET_SETTINGS . '_header_size' ),
				$this->get_render_attribute_string( 'tci-uet-text-title' ),
				$title_before,
				'',
				$title_after,
				$this->get_id(),
				$this->get_render_attribute_string( 'tci-uet-animated-text-wrapper' )
			);

			echo $title_html;
			?>
		</div>
		<?php

		$title_animated = '';
		foreach ( $settings->get( TCI_UET_SETTINGS . '_animated_title_list' ) as $t ) {
			$title_animated .= '"' . $t->get( TCI_UET_SETTINGS . '_animated_title' ) . '",';
		}

		$speed           = tci_uet_get_have( $settings, TCI_UET_SETTINGS . '_animation_t_speed' ) ? $settings->get( TCI_UET_SETTINGS . '_animation_t_speed' ) : '1000';
		$deleteSpeed     = tci_uet_get_have( $settings, TCI_UET_SETTINGS . '_animation_d_speed' ) ? $settings->get( TCI_UET_SETTINGS . '_animation_d_speed' ) : '100';
		$lifeLike        = tci_uet_get_have( $settings, TCI_UET_SETTINGS . '_animation_life_like' ) ? $settings->get( TCI_UET_SETTINGS . '_animation_life_like' ) : 'false';
		$cursor          = tci_uet_get_have( $settings, TCI_UET_SETTINGS . '_animation_cursor' ) ? $settings->get( TCI_UET_SETTINGS . '_animation_cursor' ) : 'false';
		$cursorSpeed     = tci_uet_get_have( $settings, TCI_UET_SETTINGS . '_animation_k_speed' ) ? $settings->get( TCI_UET_SETTINGS . '_animation_k_speed' ) : '1000';
		$breakLines      = tci_uet_get_have( $settings, TCI_UET_SETTINGS . '_animation_break_lines' ) ? $settings->get( TCI_UET_SETTINGS . '_animation_break_lines' ) : 'false';
		$nextStringDelay = tci_uet_get_have( $settings, TCI_UET_SETTINGS . '_animation_n_s_delay' ) ? $settings->get( TCI_UET_SETTINGS . '_animation_n_s_delay' ) : '720';
		$startDelay      = tci_uet_get_have( $settings, TCI_UET_SETTINGS . '_animation_s_Delete' ) ? $settings->get( TCI_UET_SETTINGS . '_animation_s_Delete' ) : 'false';
		$loop            = tci_uet_get_have( $settings, TCI_UET_SETTINGS . '_animation_loop' ) ? $settings->get( TCI_UET_SETTINGS . '_animation_loop' ) : 'false';
		$loopDelay       = tci_uet_get_have( $settings, TCI_UET_SETTINGS . '_animation_s_Delete' ) ? $settings->get( TCI_UET_SETTINGS . '_animation_s_Delete' ) : '100';
		$tci_uet_script = "var typeit = new TypeIt('#tci-uet-animated-{$this->get_id()}', {
			strings: [" . rtrim( $title_animated, ',' ) . "],
			speed:" . $speed . ",
			deleteSpeed:" . $deleteSpeed . ",
			lifeLike:" . $lifeLike . ",
			cursor:" . $cursor . ",
			cursorSpeed:" . $cursorSpeed . ",
			breakLines:" . $breakLines . ",
			nextStringDelay:" . $nextStringDelay . ",
			startDelete:" . $startDelay . ",
			loop:" . $loop . ",
			loopDelay:" . $loopDelay . "
		}).go();";
		wp_add_inline_script( 'tci-uet-typeit', $tci_uet_script );
	}
}
