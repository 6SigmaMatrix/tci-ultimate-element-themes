<?php
/**
 * TCI UET Facebook Page widget class
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.2
 */
namespace TCI_UET\TCI_UET_Widgets;

tci_uet_exit();

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;


class TCI_UET_Price_Table extends Widget_Base {
	/**
	 * Get widget name.
	 * Retrieve widget name.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'TCI_UET_Price_Table';
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
		return __( 'TCI UET Price Table', 'tci-uet' );
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
		return 'tci tci-uet-pricing';
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
		return [ 'pricing', 'table', 'product', 'image', 'plan', 'button' ];
	}

	/**
	 * Get style dependencies.
	 * Retrieve the list of style dependencies the element requires.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return array Element styles dependencies.
	 */
	public function get_style_depends() {
		return [
			'font-awesome',
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
			'section_header',
			[
				'label' => __( 'Header', 'tci-uet' ),
			]
		);

		$this->add_control(
			'heading',
			[
				'label'   => __( 'Title', 'tci-uet' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Enter your title', 'tci-uet' ),
			]
		);

		$this->add_control(
			'sub_heading',
			[
				'label'   => __( 'Description', 'tci-uet' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Enter your description', 'tci-uet' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_pricing',
			[
				'label' => __( 'Pricing', 'tci-uet' ),
			]
		);

		$this->add_control(
			'currency_symbol',
			[
				'label'   => __( 'Currency Symbol', 'tci-uet' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''             => __( 'None', 'tci-uet' ),
					'dollar'       => '&#36; ' . _x( 'Dollar', 'Currency Symbol', 'tci-uet' ),
					'euro'         => '&#128; ' . _x( 'Euro', 'Currency Symbol', 'tci-uet' ),
					'baht'         => '&#3647; ' . _x( 'Baht', 'Currency Symbol', 'tci-uet' ),
					'franc'        => '&#8355; ' . _x( 'Franc', 'Currency Symbol', 'tci-uet' ),
					'guilder'      => '&fnof; ' . _x( 'Guilder', 'Currency Symbol', 'tci-uet' ),
					'krona'        => 'kr ' . _x( 'Krona', 'Currency Symbol', 'tci-uet' ),
					'lira'         => '&#8356; ' . _x( 'Lira', 'Currency Symbol', 'tci-uet' ),
					'peseta'       => '&#8359 ' . _x( 'Peseta', 'Currency Symbol', 'tci-uet' ),
					'peso'         => '&#8369; ' . _x( 'Peso', 'Currency Symbol', 'tci-uet' ),
					'pound'        => '&#163; ' . _x( 'Pound Sterling', 'Currency Symbol', 'tci-uet' ),
					'real'         => 'R$ ' . _x( 'Real', 'Currency Symbol', 'tci-uet' ),
					'ruble'        => '&#8381; ' . _x( 'Ruble', 'Currency Symbol', 'tci-uet' ),
					'rupee'        => '&#8360; ' . _x( 'Rupee', 'Currency Symbol', 'tci-uet' ),
					'indian_rupee' => '&#8377; ' . _x( 'Rupee (Indian)', 'Currency Symbol', 'tci-uet' ),
					'shekel'       => '&#8362; ' . _x( 'Shekel', 'Currency Symbol', 'tci-uet' ),
					'yen'          => '&#165; ' . _x( 'Yen/Yuan', 'Currency Symbol', 'tci-uet' ),
					'won'          => '&#8361; ' . _x( 'Won', 'Currency Symbol', 'tci-uet' ),
					'custom'       => __( 'Custom', 'tci-uet' ),
				],
				'default' => 'dollar',
			]
		);

		$this->add_control(
			'currency_symbol_custom',
			[
				'label'     => __( 'Custom Symbol', 'tci-uet' ),
				'type'      => Controls_Manager::TEXT,
				'condition' => [
					'currency_symbol' => 'custom',
				],
			]
		);

		$this->add_control(
			'price',
			[
				'label'   => __( 'Price', 'tci-uet' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '39.99',
			]
		);

		$this->add_control(
			'currency_format',
			[
				'label'   => __( 'Currency Format', 'tci-uet' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''  => '1,234.56 (Default)',
					',' => '1.234,56',
				],
			]
		);

		$this->add_control(
			'sale',
			[
				'label'     => __( 'Sale', 'tci-uet' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => __( 'On', 'tci-uet' ),
				'label_off' => __( 'Off', 'tci-uet' ),
				'default'   => '',
			]
		);

		$this->add_control(
			'original_price',
			[
				'label'     => __( 'Original Price', 'tci-uet' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => '59',
				'condition' => [
					'sale' => 'yes',
				],
			]
		);

		$this->add_control(
			'period',
			[
				'label'   => __( 'Period', 'tci-uet' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Monthly', 'tci-uet' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_features',
			[
				'label' => __( 'Features', 'tci-uet' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'item_text',
			[
				'label'   => __( 'Text', 'tci-uet' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'List Item', 'tci-uet' ),
			]
		);

		$repeater->add_control(
			'item_icon',
			[
				'label'   => __( 'Icon', 'tci-uet' ),
				'type'    => Controls_Manager::ICON,
				'default' => 'fa fa-check-circle',
			]
		);

		$repeater->add_control(
			'item_icon_color',
			[
				'label'     => __( 'Icon Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} i' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'features_list',
			[
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'item_text' => __( 'List Item #1', 'tci-uet' ),
						'item_icon' => 'fa fa-check-circle',
					],
					[
						'item_text' => __( 'List Item #2', 'tci-uet' ),
						'item_icon' => 'fa fa-check-circle',
					],
					[
						'item_text' => __( 'List Item #3', 'tci-uet' ),
						'item_icon' => 'fa fa-check-circle',
					],
				],
				'title_field' => '{{{ item_text }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_footer',
			[
				'label' => __( 'Footer', 'tci-uet' ),
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'   => __( 'Button Text', 'tci-uet' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Click Here', 'tci-uet' ),
			]
		);

		$this->add_control(
			'link',
			[
				'label'       => __( 'Link', 'tci-uet' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'tci-uet' ),
				'default'     => [
					'url' => '#',
				],
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'footer_additional_info',
			[
				'label'   => __( 'Additional Info', 'tci-uet' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => __( 'This is text element', 'tci-uet' ),
				'rows'    => 2,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_ribbon',
			[
				'label' => __( 'Ribbon', 'tci-uet' ),
			]
		);

		$this->add_control(
			'show_ribbon',
			[
				'label'     => __( 'Show', 'tci-uet' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'ribbon_title',
			[
				'label'     => __( 'Title', 'tci-uet' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Popular', 'tci-uet' ),
				'condition' => [
					'show_ribbon' => 'yes',
				],
			]
		);

		$this->add_control(
			'ribbon_horizontal_position',
			[
				'label'       => __( 'Position', 'tci-uet' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
					'left'  => [
						'title' => __( 'Left', 'tci-uet' ),
						'icon'  => 'eicon-h-align-left',
					],
					'right' => [
						'title' => __( 'Right', 'tci-uet' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'condition'   => [
					'show_ribbon' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_header_style',
			[
				'label'      => __( 'Header', 'tci-uet' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_control(
			'header_bg_color',
			[
				'label'     => __( 'Background Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-price-table__header' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'header_padding',
			[
				'label'      => __( 'Padding', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .elementor-price-table__header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'heading_heading_style',
			[
				'label'     => __( 'Title', 'tci-uet' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label'     => __( 'Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-price-table__heading' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				'selector' => '{{WRAPPER}} .elementor-price-table__heading',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
			]
		);

		$this->add_control(
			'heading_sub_heading_style',
			[
				'label'     => __( 'Sub Title', 'tci-uet' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'sub_heading_color',
			[
				'label'     => __( 'Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-price-table__subheading' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'sub_heading_typography',
				'selector' => '{{WRAPPER}} .elementor-price-table__subheading',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_2,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_pricing_element_style',
			[
				'label'      => __( 'Pricing', 'tci-uet' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_control(
			'pricing_element_bg_color',
			[
				'label'     => __( 'Background Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-price-table__price' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'pricing_element_padding',
			[
				'label'      => __( 'Padding', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .elementor-price-table__price' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'price_color',
			[
				'label'     => __( 'Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-price-table__currency, {{WRAPPER}} .elementor-price-table__integer-part, {{WRAPPER}} .elementor-price-table__fractional-part' => 'color: {{VALUE}}',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'price_typography',
				'selector' => '{{WRAPPER}} .elementor-price-table__price',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
			]
		);

		$this->add_control(
			'heading_currency_style',
			[
				'label'     => __( 'Currency Symbol', 'tci-uet' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'currency_symbol!' => '',
				],
			]
		);

		$this->add_control(
			'currency_size',
			[
				'label'     => __( 'Size', 'tci-uet' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-price-table__currency' => 'font-size: calc({{SIZE}}em/100)',
				],
				'condition' => [
					'currency_symbol!' => '',
				],
			]
		);

		$this->add_control(
			'currency_position',
			[
				'label'       => __( 'Position', 'tci-uet' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'default'     => 'before',
				'options'     => [
					'before' => [
						'title' => __( 'Before', 'tci-uet' ),
						'icon'  => 'eicon-h-align-left',
					],
					'after'  => [
						'title' => __( 'After', 'tci-uet' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
			]
		);

		$this->add_control(
			'currency_vertical_position',
			[
				'label'                => __( 'Vertical Position', 'tci-uet' ),
				'type'                 => Controls_Manager::CHOOSE,
				'label_block'          => false,
				'options'              => [
					'top'    => [
						'title' => __( 'Top', 'tci-uet' ),
						'icon'  => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => __( 'Middle', 'tci-uet' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => __( 'Bottom', 'tci-uet' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'default'              => 'top',
				'selectors_dictionary' => [
					'top'    => 'flex-start',
					'middle' => 'center',
					'bottom' => 'flex-end',
				],
				'selectors'            => [
					'{{WRAPPER}} .elementor-price-table__currency' => 'align-self: {{VALUE}}',
				],
				'condition'            => [
					'currency_symbol!' => '',
				],
			]
		);

		$this->add_control(
			'fractional_part_style',
			[
				'label'     => __( 'Fractional Part', 'tci-uet' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'fractional-part_size',
			[
				'label'     => __( 'Size', 'tci-uet' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-price-table__fractional-part' => 'font-size: calc({{SIZE}}em/100)',
				],
			]
		);

		$this->add_control(
			'fractional_part_vertical_position',
			[
				'label'                => __( 'Vertical Position', 'tci-uet' ),
				'type'                 => Controls_Manager::CHOOSE,
				'label_block'          => false,
				'options'              => [
					'top'    => [
						'title' => __( 'Top', 'tci-uet' ),
						'icon'  => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => __( 'Middle', 'tci-uet' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => __( 'Bottom', 'tci-uet' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'default'              => 'top',
				'selectors_dictionary' => [
					'top'    => 'flex-start',
					'middle' => 'center',
					'bottom' => 'flex-end',
				],
				'selectors'            => [
					'{{WRAPPER}} .elementor-price-table__after-price' => 'justify-content: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'heading_original_price_style',
			[
				'label'     => __( 'Original Price', 'tci-uet' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'sale'            => 'yes',
					'original_price!' => '',
				],
			]
		);

		$this->add_control(
			'original_price_color',
			[
				'label'     => __( 'Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-price-table__original-price' => 'color: {{VALUE}}',
				],
				'condition' => [
					'sale'            => 'yes',
					'original_price!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'original_price_typography',
				'selector'  => '{{WRAPPER}} .elementor-price-table__original-price',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_1,
				'condition' => [
					'sale'            => 'yes',
					'original_price!' => '',
				],
			]
		);

		$this->add_control(
			'original_price_vertical_position',
			[
				'label'                => __( 'Vertical Position', 'tci-uet' ),
				'type'                 => Controls_Manager::CHOOSE,
				'label_block'          => false,
				'options'              => [
					'top'    => [
						'title' => __( 'Top', 'tci-uet' ),
						'icon'  => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => __( 'Middle', 'tci-uet' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => __( 'Bottom', 'tci-uet' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'selectors_dictionary' => [
					'top'    => 'flex-start',
					'middle' => 'center',
					'bottom' => 'flex-end',
				],
				'default'              => 'bottom',
				'selectors'            => [
					'{{WRAPPER}} .elementor-price-table__original-price' => 'align-self: {{VALUE}}',
				],
				'condition'            => [
					'sale'            => 'yes',
					'original_price!' => '',
				],
			]
		);

		$this->add_control(
			'heading_period_style',
			[
				'label'     => __( 'Period', 'tci-uet' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'period!' => '',
				],
			]
		);

		$this->add_control(
			'period_color',
			[
				'label'     => __( 'Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-price-table__period' => 'color: {{VALUE}}',
				],
				'condition' => [
					'period!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'period_typography',
				'selector'  => '{{WRAPPER}} .elementor-price-table__period',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_2,
				'condition' => [
					'period!' => '',
				],
			]
		);

		$this->add_control(
			'period_position',
			[
				'label'       => __( 'Position', 'tci-uet' ),
				'type'        => Controls_Manager::SELECT,
				'label_block' => false,
				'options'     => [
					'below'  => __( 'Below', 'tci-uet' ),
					'beside' => __( 'Beside', 'tci-uet' ),
				],
				'default'     => 'below',
				'condition'   => [
					'period!' => '',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_features_list_style',
			[
				'label'      => __( 'Features', 'tci-uet' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_control(
			'features_list_bg_color',
			[
				'label'     => __( 'Background Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .elementor-price-table__features-list' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'features_list_padding',
			[
				'label'      => __( 'Padding', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .elementor-price-table__features-list' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'features_list_color',
			[
				'label'     => __( 'Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .elementor-price-table__features-list' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'features_list_typography',
				'selector' => '{{WRAPPER}} .elementor-price-table__features-list li',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
			]
		);

		$this->add_control(
			'features_list_alignment',
			[
				'label'       => __( 'Alignment', 'tci-uet' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
					'left'   => [
						'title' => __( 'Left', 'tci-uet' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'tci-uet' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => __( 'Right', 'tci-uet' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'selectors'   => [
					'{{WRAPPER}} .elementor-price-table__features-list' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'item_width',
			[
				'label'     => __( 'Width', 'tci-uet' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'%' => [
						'min' => 25,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-price-table__feature-inner' => 'margin-left: calc((100% - {{SIZE}}%)/2); margin-right: calc((100% - {{SIZE}}%)/2)',
				],
			]
		);

		$this->add_control(
			'list_divider',
			[
				'label'     => __( 'Divider', 'tci-uet' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'divider_style',
			[
				'label'     => __( 'Style', 'tci-uet' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'solid'  => __( 'Solid', 'tci-uet' ),
					'double' => __( 'Double', 'tci-uet' ),
					'dotted' => __( 'Dotted', 'tci-uet' ),
					'dashed' => __( 'Dashed', 'tci-uet' ),
				],
				'default'   => 'solid',
				'condition' => [
					'list_divider' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-price-table__features-list li:before' => 'border-top-style: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'divider_color',
			[
				'label'     => __( 'Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ddd',
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'condition' => [
					'list_divider' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-price-table__features-list li:before' => 'border-top-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'divider_weight',
			[
				'label'     => __( 'Weight', 'tci-uet' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 2,
					'unit' => 'px',
				],
				'range'     => [
					'px' => [
						'min' => 1,
						'max' => 10,
					],
				],
				'condition' => [
					'list_divider' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-price-table__features-list li:before' => 'border-top-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'divider_width',
			[
				'label'     => __( 'Width', 'tci-uet' ),
				'type'      => Controls_Manager::SLIDER,
				'condition' => [
					'list_divider' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-price-table__features-list li:before' => 'margin-left: calc((100% - {{SIZE}}%)/2); margin-right: calc((100% - {{SIZE}}%)/2)',
				],
			]
		);

		$this->add_control(
			'divider_gap',
			[
				'label'     => __( 'Gap', 'tci-uet' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 15,
					'unit' => 'px',
				],
				'range'     => [
					'px' => [
						'min' => 1,
						'max' => 50,
					],
				],
				'condition' => [
					'list_divider' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-price-table__features-list li:before' => 'margin-top: {{SIZE}}{{UNIT}}; margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_footer_style',
			[
				'label'      => __( 'Footer', 'tci-uet' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_control(
			'footer_bg_color',
			[
				'label'     => __( 'Background Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-price-table__footer' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'footer_padding',
			[
				'label'      => __( 'Padding', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .elementor-price-table__footer' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'heading_footer_button',
			[
				'label'     => __( 'Button', 'tci-uet' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_size',
			[
				'label'     => __( 'Size', 'tci-uet' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'md',
				'options'   => [
					'xs' => __( 'Extra Small', 'tci-uet' ),
					'sm' => __( 'Small', 'tci-uet' ),
					'md' => __( 'Medium', 'tci-uet' ),
					'lg' => __( 'Large', 'tci-uet' ),
					'xl' => __( 'Extra Large', 'tci-uet' ),
				],
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label'     => __( 'Normal', 'tci-uet' ),
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'     => __( 'Text Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-price-table__button' => 'color: {{VALUE}};',
				],
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'button_typography',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
				'selector'  => '{{WRAPPER}} .elementor-price-table__button',
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label'     => __( 'Background Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_4,
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-price-table__button' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(), [
				'name'      => 'button_border',
				'selector'  => '{{WRAPPER}} .elementor-price-table__button',
				'condition' => [
					'button_text!' => '',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label'      => __( 'Border Radius', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .elementor-price-table__button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_text_padding',
			[
				'label'      => __( 'Text Padding', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .elementor-price-table__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'button_text!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label'     => __( 'Hover', 'tci-uet' ),
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_hover_color',
			[
				'label'     => __( 'Text Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-price-table__button:hover' => 'color: {{VALUE}};',
				],
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label'     => __( 'Background Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-price-table__button:hover' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label'     => __( 'Border Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-price-table__button:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_hover_animation',
			[
				'label'     => __( 'Animation', 'tci-uet' ),
				'type'      => Controls_Manager::HOVER_ANIMATION,
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'heading_additional_info',
			[
				'label'     => __( 'Additional Info', 'tci-uet' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'footer_additional_info!' => '',
				],
			]
		);

		$this->add_control(
			'additional_info_color',
			[
				'label'     => __( 'Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-price-table__additional_info' => 'color: {{VALUE}}',
				],
				'condition' => [
					'footer_additional_info!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'additional_info_typography',
				'selector'  => '{{WRAPPER}} .elementor-price-table__additional_info',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_3,
				'condition' => [
					'footer_additional_info!' => '',
				],
			]
		);

		$this->add_control(
			'additional_info_margin',
			[
				'label'      => __( 'Margin', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'    => 15,
					'right'  => 30,
					'bottom' => 0,
					'left'   => 30,
					'unit'   => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .elementor-price-table__additional_info' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
				'condition'  => [
					'footer_additional_info!' => '',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_ribbon_style',
			[
				'label'      => __( 'Ribbon', 'tci-uet' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
				'condition'  => [
					'show_ribbon' => 'yes',
				],
			]
		);

		$this->add_control(
			'ribbon_bg_color',
			[
				'label'     => __( 'Background Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_4,
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-price-table__ribbon-inner' => 'background-color: {{VALUE}}',
				],
			]
		);

		$ribbon_distance_transform = is_rtl() ? 'translateY(-50%) translateX({{SIZE}}{{UNIT}}) rotate(-45deg)' : 'translateY(-50%) translateX(-50%) translateX({{SIZE}}{{UNIT}}) rotate(-45deg)';

		$this->add_responsive_control(
			'ribbon_distance',
			[
				'label'     => __( 'Distance', 'tci-uet' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-price-table__ribbon-inner' => 'margin-top: {{SIZE}}{{UNIT}}; transform: ' . $ribbon_distance_transform,
				],
			]
		);

		$this->add_control(
			'ribbon_text_color',
			[
				'label'     => __( 'Text Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .elementor-price-table__ribbon-inner' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'ribbon_typography',
				'selector' => '{{WRAPPER}} .elementor-price-table__ribbon-inner',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'box_shadow',
				'selector' => '{{WRAPPER}} .elementor-price-table__ribbon-inner',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render Currency Symbol.
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	private function render_currency_symbol( $symbol, $location ) {
		$currency_position = $this->get_settings( 'currency_position' );
		$location_setting  = ! empty( $currency_position ) ? $currency_position : 'before';
		if ( ! empty( $symbol ) && $location === $location_setting ) {
			echo '<span class="elementor-price-table__currency elementor-currency--' . $location . '">' . $symbol . '</span>';
		}
	}

	/**
	 * Get Currency Symbol.
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	private function get_currency_symbol( $symbol_name ) {
		$symbols = [
			'dollar'       => '&#36;',
			'euro'         => '&#128;',
			'franc'        => '&#8355;',
			'pound'        => '&#163;',
			'ruble'        => '&#8381;',
			'shekel'       => '&#8362;',
			'baht'         => '&#3647;',
			'yen'          => '&#165;',
			'won'          => '&#8361;',
			'guilder'      => '&fnof;',
			'peso'         => '&#8369;',
			'peseta'       => '&#8359',
			'lira'         => '&#8356;',
			'rupee'        => '&#8360;',
			'indian_rupee' => '&#8377;',
			'real'         => 'R$',
			'krona'        => 'kr',
		];

		return isset( $symbols[ $symbol_name ] ) ? $symbols[ $symbol_name ] : '';
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
		$symbol   = '';

		if ( ! empty( $settings['currency_symbol'] ) ) {
			if ( 'custom' !== $settings['currency_symbol'] ) {
				$symbol = $this->get_currency_symbol( $settings['currency_symbol'] );
			} else {
				$symbol = $settings['currency_symbol_custom'];
			}
		}
		$currency_format = empty( $settings['currency_format'] ) ? '.' : $settings['currency_format'];
		$price           = explode( $currency_format, $settings['price'] );
		$intpart         = $price[0];
		$fraction        = '';
		if ( 2 === count( $price ) ) {
			$fraction = $price[1];
		}

		$this->add_render_attribute( 'button_text', 'class', [
			'elementor-price-table__button',
			'elementor-button',
			'elementor-size-' . $settings['button_size'],
		] );

		if ( ! empty( $settings['link']['url'] ) ) {
			$this->add_render_attribute( 'button_text', 'href', $settings['link']['url'] );

			if ( ! empty( $settings['link']['is_external'] ) ) {
				$this->add_render_attribute( 'button_text', 'target', '_blank' );
			}

			if ( $settings['link']['nofollow'] ) {
				$this->add_render_attribute( 'button_text', 'rel', 'nofollow' );
			}
		}

		if ( ! empty( $settings['button_hover_animation'] ) ) {
			$this->add_render_attribute( 'button_text', 'class', 'elementor-animation-' . $settings['button_hover_animation'] );
		}

		$this->add_render_attribute( 'heading', 'class', 'elementor-price-table__heading' );
		$this->add_render_attribute( 'sub_heading', 'class', 'elementor-price-table__subheading' );
		$this->add_render_attribute( 'period', 'class', [
			'elementor-price-table__period',
			'elementor-typo-excluded',
		] );
		$this->add_render_attribute( 'footer_additional_info', 'class', 'elementor-price-table__additional_info' );
		$this->add_render_attribute( 'ribbon_title', 'class', 'elementor-price-table__ribbon-inner' );

		$this->add_inline_editing_attributes( 'heading', 'none' );
		$this->add_inline_editing_attributes( 'sub_heading', 'none' );
		$this->add_inline_editing_attributes( 'period', 'none' );
		$this->add_inline_editing_attributes( 'footer_additional_info' );
		$this->add_inline_editing_attributes( 'button_text' );
		$this->add_inline_editing_attributes( 'ribbon_title' );

		$period_position = $settings['period_position'];
		$period_element  = '<span ' . $this->get_render_attribute_string( 'period' ) . '>' . $settings['period'] . '</span>';
		?>

		<div class="elementor-price-table">
			<?php if ( $settings['heading'] || $settings['sub_heading'] ) : ?>
				<div class="elementor-price-table__header">
					<?php if ( ! empty( $settings['heading'] ) ) : ?>
						<h3 <?php echo $this->get_render_attribute_string( 'heading' ); ?>><?php echo $settings['heading']; ?></h3>
					<?php endif; ?>

					<?php if ( ! empty( $settings['sub_heading'] ) ) : ?>
						<span <?php echo $this->get_render_attribute_string( 'sub_heading' ); ?>><?php echo $settings['sub_heading']; ?></span>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<div class="elementor-price-table__price">
				<?php if ( 'yes' === $settings['sale'] && ! empty( $settings['original_price'] ) ) : ?>
					<div class="elementor-price-table__original-price elementor-typo-excluded"><?php echo $symbol . $settings['original_price']; ?></div>
				<?php endif; ?>
				<?php $this->render_currency_symbol( $symbol, 'before' ); ?>
				<?php if ( ! empty( $intpart ) || 0 <= $intpart ) : ?>
					<span class="elementor-price-table__integer-part"><?php echo $intpart; ?></span>
				<?php endif; ?>

				<?php if ( '' !== $fraction || ( ! empty( $settings['period'] ) && 'beside' === $period_position ) ) : ?>
					<div class="elementor-price-table__after-price">
						<span class="elementor-price-table__fractional-part"><?php echo $fraction; ?></span>

						<?php if ( ! empty( $settings['period'] ) && 'beside' === $period_position ) : ?>
							<?php echo $period_element; ?>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<?php $this->render_currency_symbol( $symbol, 'after' ); ?>

				<?php if ( ! empty( $settings['period'] ) && 'below' === $period_position ) : ?>
					<?php echo $period_element; ?>
				<?php endif; ?>
			</div>

			<?php if ( ! empty( $settings['features_list'] ) ) : ?>
				<ul class="elementor-price-table__features-list">
					<?php
					foreach ( $settings['features_list'] as $index => $item ) :
						$repeater_setting_key = $this->get_repeater_setting_key( 'item_text', 'features_list', $index );
						$this->add_inline_editing_attributes( $repeater_setting_key );
						?>
						<li class="elementor-repeater-item-<?php echo $item['_id']; ?>">
							<div class="elementor-price-table__feature-inner">
								<?php if ( ! empty( $item['item_icon'] ) ) : ?>
									<i class="<?php echo esc_attr( $item['item_icon'] ); ?>" aria-hidden="true"></i>
								<?php endif; ?>
								<?php if ( ! empty( $item['item_text'] ) ) : ?>
									<span <?php echo $this->get_render_attribute_string( $repeater_setting_key ); ?>>
										<?php echo $item['item_text']; ?>
									</span>
								<?php
								else :
									echo '&nbsp;';
								endif;
								?>
							</div>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>

			<?php if ( ! empty( $settings['button_text'] ) || ! empty( $settings['footer_additional_info'] ) ) : ?>
				<div class="elementor-price-table__footer">
					<?php if ( ! empty( $settings['button_text'] ) ) : ?>
						<a <?php echo $this->get_render_attribute_string( 'button_text' ); ?>><?php echo $settings['button_text']; ?></a>
					<?php endif; ?>

					<?php if ( ! empty( $settings['footer_additional_info'] ) ) : ?>
						<div <?php echo $this->get_render_attribute_string( 'footer_additional_info' ); ?>><?php echo $settings['footer_additional_info']; ?></div>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>

		<?php
		if ( 'yes' === $settings['show_ribbon'] && ! empty( $settings['ribbon_title'] ) ) :
			$this->add_render_attribute( 'ribbon-wrapper', 'class', 'elementor-price-table__ribbon' );

			if ( ! empty( $settings['ribbon_horizontal_position'] ) ) :
				$this->add_render_attribute( 'ribbon-wrapper', 'class', 'elementor-ribbon-' . $settings['ribbon_horizontal_position'] );
			endif;

			?>
			<div <?php echo $this->get_render_attribute_string( 'ribbon-wrapper' ); ?>>
				<div <?php echo $this->get_render_attribute_string( 'ribbon_title' ); ?>><?php echo $settings['ribbon_title']; ?></div>
			</div>
		<?php
		endif;
	}
}
