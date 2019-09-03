<?php
/**
 * TCI UET WP Widgets class
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

class TCI_UET_Wp_Widget_Pages {

	/**
	 * Register widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since  0.0.1
	 * @access public|static
	 */
	public static function register_controls( $object ) {

		/*$object->add_control(
			'wp',
			[
				'label'   => __( 'Form', 'elementor' ),
				'type'    => Controls_Manager::WP_WIDGET,
				'widget'  => $obj->get_name(),
				'id_base' => $obj->get_widget_instance()->id_base,
			]
		);

		self::style_controls( $object );*/
	}

	/**
	 * Style Controls
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	public static function style_controls( $obj ) {
		$obj->start_controls_section(
			TCI_UET_SETTINGS . '_section_title_style',
			[
				'label' => __( 'Text', 'elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$obj->add_control(
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

		$obj->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .tci-uet-widget .elementor-heading-title',
			]
		);

		$obj->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_text_shadow',
				'selector' => '{{WRAPPER}} .tci-uet-widget .elementor-heading-title',
			]
		);

		$obj->add_control(
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

		$obj->end_controls_section();

		$obj->start_controls_section(
			TCI_UET_SETTINGS . '_section_animate_title_style',
			[
				'label' => __( 'Animated Text', 'elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$obj->add_control(
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

		$obj->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_animate_title_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .tci-uet-widget .tci-uet-animated-text',
			]
		);

		$obj->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_animate_title_text_shadow',
				'selector' => '{{WRAPPER}} .tci-uet-widget .tci-uet-animated-text',
			]
		);

		$obj->add_control(
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

		$obj->end_controls_section();
	}
}
