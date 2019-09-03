<?php
/**
 * TCI UET WP Widgets Commen class
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
use Elementor\Group_Control_Border;

class TCI_UET_Wp_Widget_Commen {
	/**
	 * Constructer
	 *
	 * @since  0.0.1
	 * @access protected
	 */

	public function __construct( $class_object, $control_extends = '' ) {
		$this->register_controls( $class_object, $control_extends );
	}

	/**
	 * Register widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since  0.0.5
	 * @access protected
	 */
	protected function register_controls( $class_object, $control_extends = '' ) {

		$class_object->add_control(
			'wp',
			[
				'label'   => __( 'Widget Form', 'elementor' ),
				'type'    => Controls_Manager::WP_WIDGET,
				'widget'  => $class_object->get_name(),
				'id_base' => $class_object->get_widget_instance()->id_base,
			]
		);

		$this->title_settings_controls( $class_object );

		$this->before_title_controls( $class_object );

		$this->after_title_controls( $class_object );

		$this->before_title_style_controls( $class_object );

		$this->title_style_controls( $class_object );

		$this->after_title_style_controls( $class_object );

		$this->extend_controls( $control_extends );
	}

	/**
	 * Settings Controls
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected function title_settings_controls( $class_object ) {

		$class_object->start_controls_section(
			TCI_UET_SETTINGS . 'section_title_settings',
			[
				'label' => __( 'Widget Title', 'elementor' ),
				'tab'   => Controls_Manager::TAB_SETTINGS,
			]
		);

		$class_object->add_control(
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

		$class_object->add_control(
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
				'default' => 'h5',
			]
		);

		$class_object->add_responsive_control(
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
					'{{WRAPPER}} .tci-uet-widget .tci-uet-wp-widget-title' => 'text-align: {{VALUE}};',
				],
			]
		);


		$class_object->add_control(
			TCI_UET_SETTINGS . '_before_title_set_str',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$class_object->add_control(
			TCI_UET_SETTINGS . '_before_title_str_header',
			[
				'label'     => __( 'Widget Before Title', 'elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'after',
			]
		);

		$class_object->add_control(
			TCI_UET_SETTINGS . '_before_title_set',
			[
				'label' => __( 'Title', 'elementor' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$class_object->add_control(
			TCI_UET_SETTINGS . '_before_title_type',
			[
				'label'     => __( 'Type', 'elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'f_w' => __( 'From Widget', 'tci-uet' ),
					'f_t' => __( 'From Elementor Template', 'tci-uet' ),
				],
				'default'   => 'f_w',
				'condition' => [
					TCI_UET_SETTINGS . '_before_title_set' => 'yes',
				],
			]
		);

		$class_object->add_control(
			TCI_UET_SETTINGS . '_before_title_type_f_t',
			[
				'label'       => __( 'Elementor Template', 'tci-uet' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => tci_uet_get_post_list( 'elementor_library' ),
				'filter_type' => 'library_widget_templates',
				'label_block' => true,
				'conditions'  => [
					'relation' => 'AND',
					'terms'    => [
						[
							'name'  => TCI_UET_SETTINGS . '_before_title_set',
							'value' => 'yes',
						],
						[
							'name'  => TCI_UET_SETTINGS . '_before_title_type',
							'value' => 'f_t',
						],
					],
				],
			]
		);

		$class_object->add_control(
			TCI_UET_SETTINGS . '_after_title_set_str',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$class_object->add_control(
			TCI_UET_SETTINGS . '_after_title_str_header',
			[
				'label'     => __( 'Widget After Title', 'elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'after',
			]
		);

		$class_object->add_control(
			TCI_UET_SETTINGS . '_after_title_set',
			[
				'label' => __( 'Title', 'elementor' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$class_object->add_control(
			TCI_UET_SETTINGS . '_after_title_type',
			[
				'label'     => __( 'Type', 'elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'f_w' => __( 'From Widget', 'tci-uet' ),
					'f_t' => __( 'From Elementor Template', 'tci-uet' ),
				],
				'default'   => 'f_w',
				'condition' => [
					TCI_UET_SETTINGS . '_after_title_set' => 'yes',
				],
			]
		);

		$class_object->add_control(
			TCI_UET_SETTINGS . '_after_title_type_f_t',
			[
				'label'       => __( 'Elementor Template', 'tci-uet' ),
				'type'        => Controls_Manager::SELECT2,
				'options'     => tci_uet_get_post_list( 'elementor_library' ),
				'filter_type' => 'library_widget_templates',
				'label_block' => true,
				'conditions'  => [
					'relation' => 'AND',
					'terms'    => [
						[
							'name'  => TCI_UET_SETTINGS . '_after_title_set',
							'value' => 'yes',
						],
						[
							'name'  => TCI_UET_SETTINGS . '_after_title_type',
							'value' => 'f_t',
						],
					],
				],
			]
		);

		$class_object->end_controls_section();
	}

	/**
	 * Before Title Controls
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected function before_title_controls( $class_object ) {
		$class_object->start_controls_section(
			TCI_UET_SETTINGS . 'section_before_title_settings',
			[
				'label'      => __( 'Widget Before Ttitle', 'elementor' ),
				'tab'        => Controls_Manager::TAB_SETTINGS,
				'conditions' => [
					'relation' => 'AND',
					'terms'    => [
						[
							'name'  => TCI_UET_SETTINGS . '_before_title_set',
							'value' => 'yes',
						],
						[
							'name'  => TCI_UET_SETTINGS . '_before_title_type',
							'value' => 'f_w',
						],
					],
				],
			]
		);

		$class_object->add_control(
			TCI_UET_SETTINGS . '_before_title_size',
			[
				'label'   => __( 'Size', 'elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'small',
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

		$class_object->add_control(
			TCI_UET_SETTINGS . '_before_title_header_size',
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
				'default' => 'span',
			]
		);

		$class_object->add_responsive_control(
			TCI_UET_SETTINGS . '_before_title_align',
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
					'{{WRAPPER}} .tci-uet-widget .tci-uet-wp-widget-before-title' => 'text-align: {{VALUE}};',
				],
			]
		);

		$class_object->add_control(
			TCI_UET_SETTINGS . '_before_title',
			[
				'label'       => __( 'Text', 'elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => __( 'Enter your title', 'elementor' ),
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$class_object->end_controls_section();

	}

	/**
	 * After Title Controls
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected function after_title_controls( $class_object ) {
		$class_object->start_controls_section(
			TCI_UET_SETTINGS . 'section_after_title_settings',
			[
				'label'      => __( 'Widget After Title', 'elementor' ),
				'tab'        => Controls_Manager::TAB_SETTINGS,
				'conditions' => [
					'relation' => 'AND',
					'terms'    => [
						[
							'name'  => TCI_UET_SETTINGS . '_after_title_set',
							'value' => 'yes',
						],
						[
							'name'  => TCI_UET_SETTINGS . '_after_title_type',
							'value' => 'f_w',
						],
					],
				],
			]
		);

		$class_object->add_control(
			TCI_UET_SETTINGS . '_after_title_size',
			[
				'label'   => __( 'Size', 'elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'small',
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

		$class_object->add_control(
			TCI_UET_SETTINGS . '_after_title_header_size',
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
				'default' => 'span',
			]
		);

		$class_object->add_responsive_control(
			TCI_UET_SETTINGS . '_after_title_align',
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
					'{{WRAPPER}} .tci-uet-widget .tci-uet-wp-widget-after-title' => 'text-align: {{VALUE}};',
				],
			]
		);

		$class_object->add_control(
			TCI_UET_SETTINGS . '_after_title',
			[
				'label'       => __( 'Text', 'elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => __( 'Enter your title', 'elementor' ),
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$class_object->end_controls_section();

	}

	/**
	 * Before Title Style Controls
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected function before_title_style_controls( $class_object ) {

		$class_object->start_controls_section(
			TCI_UET_SETTINGS . '_section_before_title_style',
			[
				'label'      => __( 'Widget Before Title', 'elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'AND',
					'terms'    => [
						[
							'name'  => TCI_UET_SETTINGS . '_before_title_set',
							'value' => 'yes',
						],
						[
							'name'  => TCI_UET_SETTINGS . '_before_title_type',
							'value' => 'f_w',
						],
					],
				],
			]
		);

		$class_object->add_responsive_control(
			TCI_UET_SETTINGS . '_before_title_margin',
			[
				'label'      => __( 'Margin', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget .tci-uet-wp-widget-before-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$class_object->add_responsive_control(
			TCI_UET_SETTINGS . '_before_title_padding',
			[
				'label'      => __( 'Padding', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget .tci-uet-wp-widget-before-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$class_object->add_control(
			TCI_UET_SETTINGS . '_before_title_background_color',
			[
				'label'     => __( 'Background Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					// Stronger selector to avoid section style from overwriting
					'{{WRAPPER}} .tci-uet-widget .tci-uet-wp-widget-before-title' => 'background-color: {{VALUE}};',
				],
			]
		);

		$class_object->add_control(
			TCI_UET_SETTINGS . '_before_title_color',
			[
				'label'     => __( 'Text Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'default'   => '#000000',
				'selectors' => [
					// Stronger selector to avoid section style from overwriting
					'{{WRAPPER}} .tci-uet-widget .tci-uet-wp-widget-before-title' => 'color: {{VALUE}};',
				],
			]
		);

		$class_object->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_before_title_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .tci-uet-widget .tci-uet-wp-widget-before-title',
			]
		);

		$class_object->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_before_title_text_shadow',
				'selector' => '{{WRAPPER}} .tci-uet-widget .tci-uet-wp-widget-before-title',
			]
		);

		$class_object->add_control(
			TCI_UET_SETTINGS . '_before_title_blend_mode',
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
					'{{WRAPPER}} .tci-uet-widget .tci-uet-wp-widget-before-title' => 'mix-blend-mode: {{VALUE}}',
				],
				'separator' => 'none',
			]
		);

		$class_object->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_before_title_border',
				'selector' => '{{WRAPPER}} .tci-uet-widget .tci-uet-wp-widget-before-title',
			]
		);

		$class_object->add_responsive_control(
			TCI_UET_SETTINGS . '_before_title_border_radius',
			[
				'label'      => __( 'Border Radius', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget .tci-uet-wp-widget-before-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$class_object->end_controls_section();
	}

	/**
	 * Title Style Controls
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected function title_style_controls( $class_object ) {

		$class_object->start_controls_section(
			TCI_UET_SETTINGS . '_section_title_style',
			[
				'label' => __( 'Widget Title', 'elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$class_object->add_responsive_control(
			TCI_UET_SETTINGS . '_title_margin',
			[
				'label'      => __( 'Margin', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget .tci-uet-wp-widget-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$class_object->add_responsive_control(
			TCI_UET_SETTINGS . '_title_padding',
			[
				'label'      => __( 'Padding', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget .tci-uet-wp-widget-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$class_object->add_control(
			TCI_UET_SETTINGS . '_title_background_color',
			[
				'label'     => __( 'Background Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					// Stronger selector to avoid section style from overwriting
					'{{WRAPPER}} .tci-uet-widget .tci-uet-wp-widget-title' => 'background-color: {{VALUE}};',
				],
			]
		);

		$class_object->add_control(
			TCI_UET_SETTINGS . '_title_color',
			[
				'label'     => __( 'Text Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'default'   => '#000000',
				'selectors' => [
					// Stronger selector to avoid section style from overwriting
					'{{WRAPPER}} .tci-uet-widget .tci-uet-wp-widget-title' => 'color: {{VALUE}};',
				],
			]
		);

		$class_object->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_title_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .tci-uet-widget .tci-uet-wp-widget-title',
			]
		);

		$class_object->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_title_text_shadow',
				'selector' => '{{WRAPPER}} .tci-uet-widget .tci-uet-wp-widget-title',
			]
		);

		$class_object->add_control(
			TCI_UET_SETTINGS . '_title_blend_mode',
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
					'{{WRAPPER}} .tci-uet-widget .tci-uet-wp-widget-title' => 'mix-blend-mode: {{VALUE}}',
				],
				'separator' => 'none',
			]
		);

		$class_object->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_title_border',
				'selector' => '{{WRAPPER}} .tci-uet-widget .tci-uet-wp-widget-title',
			]
		);

		$class_object->add_responsive_control(
			TCI_UET_SETTINGS . '_title_border_radius',
			[
				'label'      => __( 'Border Radius', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget .tci-uet-wp-widget-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$class_object->end_controls_section();
	}

	/**
	 * After Title Style Controls
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected function after_title_style_controls( $class_object ) {

		$class_object->start_controls_section(
			TCI_UET_SETTINGS . '_section_after_title_style',
			[
				'label'      => __( 'Widget After Title', 'elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => [
					'relation' => 'AND',
					'terms'    => [
						[
							'name'  => TCI_UET_SETTINGS . '_after_title_set',
							'value' => 'yes',
						],
						[
							'name'  => TCI_UET_SETTINGS . '_after_title_type',
							'value' => 'f_w',
						],
					],
				],
			]
		);

		$class_object->add_responsive_control(
			TCI_UET_SETTINGS . '_after_title_margin',
			[
				'label'      => __( 'Margin', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget .tci-uet-wp-widget-after-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$class_object->add_responsive_control(
			TCI_UET_SETTINGS . '_after_title_padding',
			[
				'label'      => __( 'Padding', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget .tci-uet-wp-widget-after-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$class_object->add_control(
			TCI_UET_SETTINGS . '_after_title_background_color',
			[
				'label'     => __( 'Background Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					// Stronger selector to avoid section style from overwriting
					'{{WRAPPER}} .tci-uet-widget .tci-uet-wp-widget-after-title' => 'background-color: {{VALUE}};',
				],
			]
		);

		$class_object->add_control(
			TCI_UET_SETTINGS . '_after_title_color',
			[
				'label'     => __( 'Text Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'default'   => '#000000',
				'selectors' => [
					'{{WRAPPER}} .tci-uet-widget .tci-uet-wp-widget-after-title' => 'color: {{VALUE}};',
				],
			]
		);

		$class_object->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_after_title_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .tci-uet-widget .tci-uet-wp-widget-after-title',
			]
		);

		$class_object->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_after_title_text_shadow',
				'selector' => '{{WRAPPER}} .tci-uet-widget .tci-uet-wp-widget-after-title',
			]
		);

		$class_object->add_control(
			TCI_UET_SETTINGS . '_after_title_blend_mode',
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
					'{{WRAPPER}} .tci-uet-widget .tci-uet-wp-widget-after-title' => 'mix-blend-mode: {{VALUE}}',
				],
				'separator' => 'none',
			]
		);

		$class_object->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_after_title_border',
				'selector' => '{{WRAPPER}} .tci-uet-widget .tci-uet-wp-widget-after-title',
			]
		);

		$class_object->add_responsive_control(
			TCI_UET_SETTINGS . '_after_title_border_radius',
			[
				'label'      => __( 'Border Radius', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget .tci-uet-wp-widget-after-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$class_object->end_controls_section();
	}

	/**
	 * Extend Controls
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected function extend_controls( $control_extends = '' ) {
		return $control_extends;
	}
}
