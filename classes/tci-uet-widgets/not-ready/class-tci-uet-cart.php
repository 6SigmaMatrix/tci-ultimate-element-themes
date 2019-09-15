<?php
/**
 * TCI UET Cart widget class
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
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Repeater;
use Elementor\Widget_Base;

class TCI_UET_Cart extends Widget_Base {

	/**
	 * Get widget name.
	 * Retrieve widget name.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'TCI_UET_Cart';
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
		return __( 'TCI UET Cart', 'tci-uet' );
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
		return [ 'tci-uet-woocommerce-widget' ];
	}

	/**
	 * Attach keywords.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_keywords() {
		return [ 'cart', 'woocommerce' ];
	}

	/**
	 * Whether the reload preview is required or not.
	 * Used to determine whether the reload preview is required.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return bool Whether the reload preview is required.
	 */
	public function is_reload_preview_required() {
		return true;
	}

	/**
	 * Register widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected function _register_controls() {

		$this->empty_text_controls();

		$this->cart_item_column_controls();

		$this->empty_text_style_controls();

		$this->empty_button_style_controls();

		$this->cart_item_type_style_controls();

	}

	/**
	 * Empty text controls
	 *
	 * @since  0.0.1
	 * @access private
	 */
	private function empty_text_controls() {
		$this->start_controls_section(
			TCI_UET_SETTINGS . '_section_cart_empty',
			[
				'label' => __( 'Empty Cart Text', 'tci-uet' ),
			]
		);


		$this->add_control(
			TCI_UET_SETTINGS . '_cart_empty_text',
			[
				'label'       => __( 'Text', 'tci-uet' ),
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Enter your text', 'tci-uet' ),
				'default'     => __( 'Your cart is currently empty.', 'tci-uet' ),
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_cart_empty_text_size',
			[
				'label'   => __( 'Size', 'tci-uet' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => __( 'Default', 'tci-uet' ),
					'small'   => __( 'Small', 'tci-uet' ),
					'medium'  => __( 'Medium', 'tci-uet' ),
					'large'   => __( 'Large', 'tci-uet' ),
					'xl'      => __( 'XL', 'tci-uet' ),
					'xxl'     => __( 'XXL', 'tci-uet' ),
				],
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_cart_empty_text_tag',
			[
				'label'   => __( 'HTML Tag', 'tci-uet' ),
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
					'p'    => 'p',
				],
				'default' => 'p',
			]
		);

		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_cart_empty_text_align',
			[
				'label'     => __( 'Alignment', 'tci-uet' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'    => [
						'title' => __( 'Left', 'tci-uet' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'  => [
						'title' => __( 'Center', 'tci-uet' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'   => [
						'title' => __( 'Right', 'tci-uet' ),
						'icon'  => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => __( 'Justified', 'tci-uet' ),
						'icon'  => 'eicon-text-align-justify',
					],
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Cart item column controls
	 *
	 * @since  0.0.1
	 * @access private
	 */
	private function cart_item_column_controls() {
		$this->start_controls_section(
			TCI_UET_SETTINGS . '_section_cart_item_column',
			[
				'label' => __( 'Cart Data Column', 'tci-uet' ),
			]
		);


		$this->add_control(
			TCI_UET_SETTINGS . '_cart_item_remove_button',
			[
				'label'     => __( 'Remove Button', 'tci-uet' ),
				'type'      => Controls_Manager::SWITCHER,
				'selectors' => [
					'{{WRAPPER}} .tci-uet-widget form tr.woocommerce-cart-form__cart-item > td.product-remove' => 'display: {{VALUE}};',
					'{{WRAPPER}} .tci-uet-widget form .woocommerce-cart-form__contents th.product-remove' => 'display: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_cart_item_image',
			[
				'label' => __( 'Product Image', 'tci-uet' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_cart_item_title',
			[
				'label' => __( 'Product Title', 'tci-uet' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_cart_item_link',
			[
				'label'     => __( 'Product Link', 'tci-uet' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [
					TCI_UET_SETTINGS . '_cart_item_title[value]!' => 'yes',
				],
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_cart_item_price',
			[
				'label' => __( 'Product Price', 'tci-uet' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_cart_item_qty',
			[
				'label' => __( 'Product Quantity', 'tci-uet' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_cart_item_total',
			[
				'label' => __( 'Product Total', 'tci-uet' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Empty text style controls
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected function empty_text_style_controls() {
		$this->start_controls_section(
			TCI_UET_SETTINGS . '_section_empty_text_style',
			[
				'label' => __( 'Empty Cart Text', 'tci-uet' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_empty_text_margin',
			[
				'label'      => __( 'Margin', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget.elementor-widget-heading .elementor-heading-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_empty_text_padding',
			[
				'label'      => __( 'Padding', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget.elementor-widget-heading .elementor-heading-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'           => TCI_UET_SETTINGS . '_empty_text_bg',
				'label'          => __( 'Background', 'tci-uet' ),
				'types'          => [ 'classic', 'gradient' ],
				'fields_options' => [
					'color' => [
						'label' => __( 'Primary Color', 'tci-uet' ),
					],
				],
				'separator'      => 'before',
				'selector'       => '{{WRAPPER}} .tci-uet-widget.elementor-widget-heading .elementor-heading-title',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_empty_text_border',
				'selector' => '{{WRAPPER}} .tci-uet-widget.elementor-widget-heading .elementor-heading-title',
			]
		);

		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_empty_text_radius',
			[
				'label'      => __( 'Border Radius', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget.elementor-widget-heading .elementor-heading-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_empty_text_',
				'selector' => '{{WRAPPER}} .tci-uet-widget.elementor-widget-heading .elementor-heading-title',
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_empty_text_color',
			[
				'label'     => __( 'Text Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .tci-uet-widget.elementor-widget-heading .elementor-heading-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_empty_text_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .tci-uet-widget.elementor-widget-heading .elementor-heading-title',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_empty_text_shadow',
				'selector' => '{{WRAPPER}} .tci-uet-widget.elementor-widget-heading .elementor-heading-title',
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_empty_text_blend_mode',
			[
				'label'     => __( 'Blend Mode', 'tci-uet' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''            => __( 'Normal', 'tci-uet' ),
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
					'{{WRAPPER}} .tci-uet-widget.elementor-widget-heading .elementor-heading-title' => 'mix-blend-mode: {{VALUE}}',
				],
				'separator' => 'none',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Empty button style controls
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected function empty_button_style_controls() {
		$this->start_controls_section(
			TCI_UET_SETTINGS . '_section_empty_button_style',
			[
				'label' => __( 'Empty Cart Button', 'tci-uet' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_empty_button_margin',
			[
				'label'      => __( 'Margin', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget.elementor-widget-heading .return-to-shop a.button.wc-backward' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_empty_button_padding',
			[
				'label'      => __( 'Padding', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget.elementor-widget-heading .return-to-shop a.button.wc-backward' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_devider_1',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->start_controls_tabs( TCI_UET_SETTINGS . '_empty_button_tabs' );

		$this->start_controls_tab(
			TCI_UET_SETTINGS . '_empty_button_tab_normal',
			[
				'label' => __( 'Normal', 'tci-uet' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'           => TCI_UET_SETTINGS . '_empty_button_bg',
				'label'          => __( 'Background', 'tci-uet' ),
				'types'          => [ 'classic', 'gradient' ],
				'fields_options' => [
					'color' => [
						'label' => __( 'Primary Color', 'tci-uet' ),
					],
				],
				'selector'       => '{{WRAPPER}} .tci-uet-widget.elementor-widget-heading .return-to-shop a.button.wc-backward',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_empty_button_border',
				'selector' => '{{WRAPPER}} .tci-uet-widget.elementor-widget-heading .return-to-shop a.button.wc-backward',
			]
		);

		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_empty_button_radius',
			[
				'label'      => __( 'Border Radius', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget.elementor-widget-heading .return-to-shop a.button.wc-backward' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_empty_button_',
				'selector' => '{{WRAPPER}} .tci-uet-widget.elementor-widget-heading .return-to-shop a.button.wc-backward',
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_empty_button_color',
			[
				'label'     => __( 'Text Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .tci-uet-widget.elementor-widget-heading .return-to-shop a.button.wc-backward' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_empty_button_shadow',
				'selector' => '{{WRAPPER}} .tci-uet-widget.elementor-widget-heading .return-to-shop a.button.wc-backward',
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_devider_2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			TCI_UET_SETTINGS . '_empty_button_tab_hover',
			[
				'label' => __( 'Hover', 'tci-uet' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'           => TCI_UET_SETTINGS . '_empty_button_bg_hover',
				'label'          => __( 'Background', 'tci-uet' ),
				'types'          => [ 'classic', 'gradient' ],
				'fields_options' => [
					'color' => [
						'label' => __( 'Primary Color', 'tci-uet' ),
					],
				],
				'selector'       => '{{WRAPPER}} .tci-uet-widget.elementor-widget-heading .return-to-shop a.button.wc-backward:hover',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_empty_button_border_hover',
				'selector' => '{{WRAPPER}} .tci-uet-widget.elementor-widget-heading .return-to-shop a.button.wc-backward:hover',
			]
		);

		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_empty_button_radius_hover',
			[
				'label'      => __( 'Border Radius', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget.elementor-widget-heading .return-to-shop a.button.wc-backward:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_empty_button_hover_',
				'selector' => '{{WRAPPER}} .tci-uet-widget.elementor-widget-heading .return-to-shop a.button.wc-backward:hover',
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_empty_button_color_hover',
			[
				'label'     => __( 'Text Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .tci-uet-widget.elementor-widget-heading .return-to-shop a.button.wc-backward:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_empty_button_shadow_hover',
				'selector' => '{{WRAPPER}} .tci-uet-widget.elementor-widget-heading .return-to-shop a.button.wc-backward:hover',
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_devider_3',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_empty_button_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .tci-uet-widget.elementor-widget-heading .return-to-shop a.button.wc-backward',
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_empty_button_blend_mode',
			[
				'label'     => __( 'Blend Mode', 'tci-uet' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''            => __( 'Normal', 'tci-uet' ),
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
					'{{WRAPPER}} .tci-uet-widget.elementor-widget-heading .return-to-shop a.button.wc-backward' => 'mix-blend-mode: {{VALUE}}',
				],
				'separator' => 'none',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Cart item table style controls
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected function cart_item_type_style_controls() {
		$this->start_controls_section(
			TCI_UET_SETTINGS . '_section_cart_item_style',
			[
				'label' => __( 'Cart Item Table', 'tci-uet' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_cart_table_heading_settings',
			[
				'label'     => __( 'Table Heading', 'tci-uet' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'after',
			]
		);

		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_cart_table_heading_padding',
			[
				'label'      => __( 'Padding', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form .woocommerce-cart-form__contents th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'           => TCI_UET_SETTINGS . '_cart_table_heading_bg',
				'label'          => __( 'Background', 'tci-uet' ),
				'types'          => [ 'classic', 'gradient' ],
				'fields_options' => [
					'color' => [
						'label' => __( 'Primary Color', 'tci-uet' ),
					],
				],
				'separator'      => 'before',
				'selector'       => '{{WRAPPER}} .tci-uet-widget form .woocommerce-cart-form__contents th',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_cart_table_heading_border',
				'selector' => '{{WRAPPER}} .tci-uet-widget form .woocommerce-cart-form__contents th',
			]
		);

		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_cart_table_heading_radius',
			[
				'label'      => __( 'Border Radius', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form .woocommerce-cart-form__contents th' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_cart_table_heading_color',
			[
				'label'     => __( 'Text Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .tci-uet-widget form .woocommerce-cart-form__contents th' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_cart_table_heading_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .tci-uet-widget form .woocommerce-cart-form__contents th',
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . 'divider_4',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_cart_table_data_settings',
			[
				'label'     => __( 'Table Data', 'tci-uet' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'after',
			]
		);

		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_cart_table_data_padding',
			[
				'label'      => __( 'Padding', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form .woocommerce-cart-form__contents td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'           => TCI_UET_SETTINGS . '_cart_table_data_bg',
				'label'          => __( 'Background', 'tci-uet' ),
				'types'          => [ 'classic', 'gradient' ],
				'fields_options' => [
					'color' => [
						'label' => __( 'Primary Color', 'tci-uet' ),
					],
				],
				'separator'      => 'before',
				'selector'       => '{{WRAPPER}} .tci-uet-widget form .woocommerce-cart-form__contents td',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_cart_table_data_border',
				'selector' => '{{WRAPPER}} .tci-uet-widget form .woocommerce-cart-form__contents td',
			]
		);

		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_cart_table_data_radius',
			[
				'label'      => __( 'Border Radius', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form .woocommerce-cart-form__contents td' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_cart_table_data_color',
			[
				'label'     => __( 'Text Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .tci-uet-widget form .woocommerce-cart-form__contents td, {{WRAPPER}} .tci-uet-widget form .woocommerce-cart-form__contents td.product-name a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_cart_table_data_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .tci-uet-widget form .woocommerce-cart-form__contents td',
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . 'divider_5',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_cart_table_item_remove_settings',
			[
				'label'     => __( 'Item Remove Button', 'tci-uet' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'after',
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
		$settings = tci_uet_array( $this->get_settings_for_display() );

		$this->add_render_attribute( 'tci-uet-cart-empty-wrapper', 'class', [
			'tci-uet-widget',
			'elementor-widget-heading',
		] );

		remove_action( 'woocommerce_cart_is_empty', 'wc_empty_cart_message', 10 );
		add_action( 'woocommerce_cart_is_empty', [ $this, 'empty_cart_message' ], 10 );

		if ( 'yes' === $settings->get( TCI_UET_SETTINGS . '_cart_item_remove_button' ) ) {
			add_filter( 'woocommerce_cart_item_remove_link', '__return_false' );
		}

		if ( 'yes' === $settings->get( TCI_UET_SETTINGS . '_cart_item_image' ) ) {
			add_filter( 'woocommerce_cart_item_thumbnail', '__return_false' );
		}

		if ( 'yes' === $settings->get( TCI_UET_SETTINGS . '_cart_item_title' ) ) {
			add_filter( 'woocommerce_cart_item_name', '__return_false' );
		}

		if ( '' === $settings->get( TCI_UET_SETTINGS . '_cart_item_title' ) && 'yes' === $settings->get( TCI_UET_SETTINGS . '_cart_item_link' ) ) {
			add_filter( 'woocommerce_cart_item_permalink', '__return_false' );
		}

		if ( 'yes' === $settings->get( TCI_UET_SETTINGS . '_cart_item_price' ) ) {
			add_filter( 'woocommerce_cart_item_price', '__return_false' );
		}

		if ( 'yes' === $settings->get( TCI_UET_SETTINGS . '_cart_item_qty' ) ) {
			add_filter( 'woocommerce_cart_item_quantity', '__return_false' );
		}

		if ( 'yes' === $settings->get( TCI_UET_SETTINGS . '_cart_item_total' ) ) {
			add_filter( 'woocommerce_cart_item_subtotal', '__return_false' );
		}
		?>
		<div <?php echo $this->get_render_attribute_string( 'tci-uet-cart-empty-wrapper' ); ?>>
			<?php echo do_shortcode( '[woocommerce_cart]' ); ?>
		</div>
		<?php
	}

	/**
	 * Render empty cart output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function empty_cart_message() {
		$settings = tci_uet_array( $this->get_settings_for_display() );

		$this->add_render_attribute( 'tci-uet-cart-empty-title', 'class', 'elementor-heading-title' );

		if ( ! empty( $settings->get( TCI_UET_SETTINGS . '_cart_empty_text_size' ) ) ) {
			$this->add_render_attribute( 'tci-uet-cart-empty-title', 'class', 'elementor-size-' . $settings->get( TCI_UET_SETTINGS . '_cart_empty_text_size' ) );
		}

		echo sprintf(
			'<%1$s %2$s>%3$s</%1$s>',
			$settings->get( TCI_UET_SETTINGS . '_cart_empty_text_tag' ),
			$this->get_render_attribute_string( 'tci-uet-cart-empty-title' ),
			$settings->get( TCI_UET_SETTINGS . '_cart_empty_text' )
		);
	}
}
