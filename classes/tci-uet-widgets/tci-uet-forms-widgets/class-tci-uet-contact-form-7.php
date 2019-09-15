<?php
/**
 * TCI UET Contact Form 7  plugin widget class
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.6
 */
namespace TCI_UET\TCI_UET_Widgets\TCI_UET_Forms_Widgets;

tci_uet_exit();

use Elementor\Widget_Base;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use \Elementor\Group_Control_Background;
use Elementor\Controls_Manager;

class TCI_UET_Contact_Form_7 extends Widget_Base {

	/**
	 * Get widget name.
	 * Retrieve widget name.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'TCI_UET_Contact_Forms_7';
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
		return __( 'TCI UET Contact Forms 7', 'tci-uet' );
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
		return 'tci tci-uet-contact-form';
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
		return [ 'tci-uet-forms-widgets' ];
	}

	/**
	 * Attach keywords.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_keywords() {
		return [ 'contact form 7', 'contact form', 'contact', 'file upload' ];
	}

	/**
	 * Register widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected function _register_controls() {
		if ( ! function_exists( 'wpcf7' ) ) {
			$this->start_controls_section(
				TCI_UET_SETTINGS . '_contactform7_warning',
				[
					'label' => __( 'Warning!', 'tci-uet' ),
				]
			);
			$this->add_control(
				TCI_UET_SETTINGS . '_contactform7_warning_text',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => __( '<strong>Contact Form 7</strong> is not installed/activated on your site. Please install and activate <strong>Contact Form 7</strong> first.', 'tci-uet' ),
					'content_classes' => 'tci-uet-warning',
				]
			);
			$this->end_controls_section();

			return false;
		}

		$this->get_forms_list();
		$this->get_forms_label_settings();
		$this->get_forms_text_settings();
		$this->get_forms_email_settings();
		$this->get_forms_url_settings();
		$this->get_forms_tel_settings();
		$this->get_forms_number_settings();
		$this->get_forms_date_settings();
		$this->get_forms_textarea_settings();
		$this->get_forms_select_settings();
		$this->get_forms_checkbox_settings();
		$this->get_forms_radio_settings();
		$this->get_forms_file_settings();
		$this->get_forms_submit_settings();
		$this->get_forms_field_typo_settings();
		$this->get_forms_error_settings();
		$this->get_forms_thank_settings();
	}

	/**
	 * Forms List.
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected function get_forms_list() {
		$this->start_controls_section(
			TCI_UET_SETTINGS . '_contactform7',
			[
				'label' => __( 'Contact Form 7', 'tci-uet' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			TCI_UET_SETTINGS . '_contact_form_7_slug',
			[
				'label'   => __( 'Forms List', 'tci-uet' ),
				'type'    => Controls_Manager::SELECT,
				'options' => tci_uet_get_post_list( 'wpcf7_contact_form' ),
				'default' => 'contact-form-1',
			]
		);
		$this->end_controls_section();
	}

	/**
	 * Forms Labels Settings.
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected function get_forms_label_settings() {
		$this->start_controls_section(
			TCI_UET_SETTINGS . '_contactform7_label_settings',
			[
				'label' => __( 'Label Settings', 'tci-uet' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_label_width',
			[
				'label'      => __( 'Width', 'tci-uet' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [ '{{WRAPPER}} .tci-uet-widget form.wpcf7-form label' => 'width: {{SIZE}}{{UNIT}};' ],
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_label_margin',
			[
				'label'      => __( 'Margin', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_label_padding',
			[
				'label'      => __( 'Padding', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			TCI_UET_SETTINGS . '_contactform7_label_normal_bg',
			[
				'label'     => __( 'Background Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form label' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_label_border',
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form label',
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_label_radius',
			[
				'label'      => __( 'Border Radius', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			TCI_UET_SETTINGS . '_contactform7_label_typography_color',
			[
				'label'     => __( 'Text Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'selectors' => [ '{{WRAPPER}} .tci-uet-widget form.wpcf7-form label' => 'color: {{VALUE}};' ],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_label',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form label',

			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_label',
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form label',
			]
		);
		$this->end_controls_section();
	}

	/**
	 * Forms Text Filed Settings.
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected function get_forms_text_settings() {

		$this->start_controls_section(
			TCI_UET_SETTINGS . '_contactform7_input_text_settings',
			[
				'label' => __( 'Text Field Settings', 'tci-uet' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_text_input_text_indent',
			[
				'label'      => __( 'Text Indent', 'tci-uet' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="text"]' => 'text-indent: {{SIZE}}{{UNIT}}',
				],
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_text_input_width',
			[
				'label'      => __( 'Width', 'tci-uet' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [ '{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="text"]' => 'width: {{SIZE}}{{UNIT}};' ],
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_text_input_margin',
			[
				'label'      => __( 'Margin', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="text"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_text_input_padding',
			[
				'label'      => __( 'Padding', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="text"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->start_controls_tabs( TCI_UET_SETTINGS . '_contactform7_text_tabs' );
		$this->start_controls_tab(
			TCI_UET_SETTINGS . '_contactform7_text_normal',
			[
				'label' => __( 'Normal', 'tci-uet' ),
			]
		);
		$this->add_control(
			TCI_UET_SETTINGS . '_contactform7_text_input_bg',
			[
				'label'     => __( 'Background Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tci-uet-widget .wpcf7-form input[type="text"]' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_text_input_border',
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="text"]',
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_text_input_radius',
			[
				'label'      => __( 'Border Radius', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="text"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_text_input',
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="text"]',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			TCI_UET_SETTINGS . '_contactform7_text_focus',
			[
				'label' => __( 'Focus', 'tci-uet' ),
			]
		);
		$this->add_control(
			TCI_UET_SETTINGS . '_contactform7_text_input_bg_focus',
			[
				'label'     => __( 'Background Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="text"]:focus' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_text_input_border_focus',
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="text"]:focus',
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_text_input_radius_focus',
			[
				'label'      => __( 'Border Radius', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="text"]:focus' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_text_input_focus',
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="text"]:focus',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
	}

	/**
	 * Forms Email Field Settings.
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected function get_forms_email_settings() {
		$this->start_controls_section(
			TCI_UET_SETTINGS . '_contactform7_input_emal_settings',
			[
				'label' => __( 'Email Field Settings', 'tci-uet' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_email_input_text_indent',
			[
				'label'      => __( 'Text Indent', 'tci-uet' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="email"]' => 'text-indent: {{SIZE}}{{UNIT}}',
				],
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_email_input_width',
			[
				'label'      => __( 'Width', 'tci-uet' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [ '{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="email"]' => 'width: {{SIZE}}{{UNIT}};' ],
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_email_input_margin',
			[
				'label'      => __( 'Margin', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="email"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_email_input_padding',
			[
				'label'      => __( 'Padding', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="email"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->start_controls_tabs( TCI_UET_SETTINGS . '_contactform7_email_tabs' );
		$this->start_controls_tab(
			TCI_UET_SETTINGS . '_contactform7_email_normal',
			[
				'label' => __( 'Normal', 'tci-uet' ),
			]
		);
		$this->add_control(
			TCI_UET_SETTINGS . '_contactform7_email_input_bg',
			[
				'label'     => __( 'Background Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tci-uet-widget .wpcf7-form input[type="email"]' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_email_input_border',
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="email"]',
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_email_input_radius',
			[
				'label'      => __( 'Border Radius', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="email"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_email_input',
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="email"]',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			TCI_UET_SETTINGS . '_contactform7_email_focus',
			[
				'label' => __( 'Focus', 'tci-uet' ),
			]
		);
		$this->add_control(
			TCI_UET_SETTINGS . '_contactform7_email_input_bg_focus',
			[
				'label'     => __( 'Background Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tci-uet-widget .wpcf7-form input[type="email"]:focus' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_email_input_border_focus',
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="email"]:focus',
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_email_input_radius_focus',
			[
				'label'      => __( 'Border Radius', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="email"]:focus' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_email_input_focus',
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="email"]:focus',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
	}

	/**
	 * Forms URL Field Settings.
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected function get_forms_url_settings() {
		$this->start_controls_section(
			TCI_UET_SETTINGS . '_contactform7_input_url_settings',
			[
				'label' => __( 'URL Field Settings', 'tci-uet' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_url_input_text_indent',
			[
				'label'      => __( 'Text Indent', 'tci-uet' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="url"]' => 'text-indent: {{SIZE}}{{UNIT}}',
				],
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_url_input_width',
			[
				'label'      => __( 'Width', 'tci-uet' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [ '{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="url"]' => 'width: {{SIZE}}{{UNIT}};' ],
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_url_input_margin',
			[
				'label'      => __( 'Margin', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="url"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_url_input_padding',
			[
				'label'      => __( 'Padding', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="url"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->start_controls_tabs( TCI_UET_SETTINGS . '_contactform7_url_tabs' );
		$this->start_controls_tab(
			TCI_UET_SETTINGS . '_contactform7_url_normal',
			[
				'label' => __( 'Normal', 'tci-uet' ),
			]
		);
		$this->add_control(
			TCI_UET_SETTINGS . '_contactform7_url_input_bg',
			[
				'label'     => __( 'Background Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tci-uet-widget .wpcf7-form input[type="url"]' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_url_input_border',
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="url"]',
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_url_input_radius',
			[
				'label'      => __( 'Border Radius', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="url"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_url_input',
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="url"]',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			TCI_UET_SETTINGS . '_contactform7_url_normal_focus',
			[
				'label' => __( 'Focus', 'tci-uet' ),
			]
		);
		$this->add_control(
			TCI_UET_SETTINGS . '_contactform7_url_input_bg_focus',
			[
				'label'     => __( 'Background Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tci-uet-widget .wpcf7-form input[type="url"]:focus' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_url_input_border_focus',
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="url"]:focus',
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_url_input_radius_focus',
			[
				'label'      => __( 'Border Radius', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="url"]:focus' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_url_input_focus',
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="url"]:focus',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
	}

	/**
	 * Forms Tel Field Settings.
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected function get_forms_tel_settings() {
		$this->start_controls_section(
			TCI_UET_SETTINGS . '_contactform7_input_tel_settings',
			[
				'label' => __( 'Tel Field Settings', 'tci-uet' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_tel_input_text_indent',
			[
				'label'      => __( 'Text Indent', 'tci-uet' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="tel"]' => 'text-indent: {{SIZE}}{{UNIT}}',
				],
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_tel_input_width',
			[
				'label'      => __( 'Width', 'tci-uet' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [ '{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="tel"]' => 'width: {{SIZE}}{{UNIT}};' ],
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_tel_input_margin',
			[
				'label'      => __( 'Margin', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="tel"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_tel_input_padding',
			[
				'label'      => __( 'Padding', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="tel"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->start_controls_tabs( TCI_UET_SETTINGS . '_contactform7_tel_tabs' );
		$this->start_controls_tab(
			TCI_UET_SETTINGS . '_contactform7_tel_normal',
			[
				'label' => __( 'Normal', 'tci-uet' ),
			]
		);
		$this->add_control(
			TCI_UET_SETTINGS . '_contactform7_tel_input_bg',
			[
				'label'     => __( 'Background Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tci-uet-widget .wpcf7-form input[type="tel"]' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_tel_input_border',
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="tel"]',
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_tel_input_radius',
			[
				'label'      => __( 'Border Radius', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="tel"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_tel_input',
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="tel"]',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			TCI_UET_SETTINGS . '_contactform7_tel_focus',
			[
				'label' => __( 'Focus', 'tci-uet' ),
			]
		);
		$this->add_control(
			TCI_UET_SETTINGS . '_contactform7_tel_input_bg_focus',
			[
				'label'     => __( 'Background Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tci-uet-widget .wpcf7-form input[type="tel"]:focus' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_tel_input_border_focus',
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="tel"]:focus',
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_tel_input_radius_focus',
			[
				'label'      => __( 'Border Radius', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="tel"]:focus' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_tel_input_focus',
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="tel"]:focus',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
	}

	/**
	 * Forms Number Field Settings.
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected function get_forms_number_settings() {
		$this->start_controls_section(
			TCI_UET_SETTINGS . '_contactform7_input_number_settings',
			[
				'label' => __( 'Number Field Settings', 'tci-uet' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_number_input_text_indent',
			[
				'label'      => __( 'Text Indent', 'tci-uet' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="number"]' => 'text-indent: {{SIZE}}{{UNIT}}',
				],
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_number_input_width',
			[
				'label'      => __( 'Width', 'tci-uet' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [ '{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="number"]' => 'width: {{SIZE}}{{UNIT}};' ],
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_number_input_margin',
			[
				'label'      => __( 'Margin', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="number"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_number_input_padding',
			[
				'label'      => __( 'Padding', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="number"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->start_controls_tabs( TCI_UET_SETTINGS . '_contactform7_number_tabs' );
		$this->start_controls_tab(
			TCI_UET_SETTINGS . '_contactform7_number_normal',
			[
				'label' => __( 'Normal', 'tci-uet' ),
			]
		);
		$this->add_control(
			TCI_UET_SETTINGS . '_contactform7_number_input_bg',
			[
				'label'     => __( 'Background Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tci-uet-widget .wpcf7-form input[type="number"]' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_number_input_border',
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="number"]',
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_number_input_radius',
			[
				'label'      => __( 'Border Radius', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="number"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_number_input',
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="number"]',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			TCI_UET_SETTINGS . '_contactform7_number_focus',
			[
				'label' => __( 'Focus', 'tci-uet' ),
			]
		);
		$this->add_control(
			TCI_UET_SETTINGS . '_contactform7_number_input_bg_focus',
			[
				'label'     => __( 'Background Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tci-uet-widget .wpcf7-form input[type="number"]:focus' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_number_input_border_focus',
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="number"]:focus',
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_number_input_radius_focus',
			[
				'label'      => __( 'Border Radius', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="number"]:focus' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_number_input_focus',
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="number"]:focus',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
	}

	/**
	 * Forms Date Field Settings.
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected function get_forms_date_settings() {
		$this->start_controls_section(
			TCI_UET_SETTINGS . '_contactform7_input_date_settings',
			[
				'label' => __( 'Date Field Settings', 'tci-uet' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_date_input_text_indent',
			[
				'label'      => __( 'Text Indent', 'tci-uet' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="date"]' => 'text-indent: {{SIZE}}{{UNIT}}',
				],
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_date_input_width',
			[
				'label'      => __( 'Width', 'tci-uet' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [ '{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="date"]' => 'width: {{SIZE}}{{UNIT}};' ],
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_date_input_margin',
			[
				'label'      => __( 'Margin', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="date"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_date_input_padding',
			[
				'label'      => __( 'Padding', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="date"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->start_controls_tabs( TCI_UET_SETTINGS . '_contactform7_date_tabs' );
		$this->start_controls_tab(
			TCI_UET_SETTINGS . '_contactform7_date_normal',
			[
				'label' => __( 'Normal', 'tci-uet' ),
			]
		);
		$this->add_control(
			TCI_UET_SETTINGS . '_contactform7_date_input_bg',
			[
				'label'     => __( 'Background Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tci-uet-widget .wpcf7-form input[type="date"]' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_date_input_border',
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="date"]',
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_date_input_radius',
			[
				'label'      => __( 'Border Radius', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="date"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_date_input',
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="date"]',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			TCI_UET_SETTINGS . '_contactform7_date_focus',
			[
				'label' => __( 'Focus', 'tci-uet' ),
			]
		);
		$this->add_control(
			TCI_UET_SETTINGS . '_contactform7_date_input_bg_focus',
			[
				'label'     => __( 'Background Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tci-uet-widget .wpcf7-form input[type="date"]:focus' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_date_input_border_focus',
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="date"]:focus',
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_date_input_radius_focus',
			[
				'label'      => __( 'Border Radius', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="date"]:focus' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_date_input_focus',
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="date"]:focus',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
	}

	/**
	 * Forms Textarea Field Settings.
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected function get_forms_textarea_settings() {
		$this->start_controls_section(
			TCI_UET_SETTINGS . '_contactform7_input_textarea_settings',
			[
				'label' => __( 'Textarea Field Settings', 'tci-uet' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_textarea_input_text_indent',
			[
				'label'      => __( 'Text Indent', 'tci-uet' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form textarea' => 'text-indent: {{SIZE}}{{UNIT}}',
				],
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_textarea_input_width',
			[
				'label'      => __( 'Width', 'tci-uet' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [ '{{WRAPPER}} .tci-uet-widget form.wpcf7-form textarea' => 'width: {{SIZE}}{{UNIT}};' ],
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_textarea_input_margin',
			[
				'label'      => __( 'Margin', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form textarea' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_textarea_input_padding',
			[
				'label'      => __( 'Padding', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->start_controls_tabs( TCI_UET_SETTINGS . '_contactform7_textarea_tabs' );
		$this->start_controls_tab(
			TCI_UET_SETTINGS . '_contactform7_textarea_normal',
			[
				'label' => __( 'Normal', 'tci-uet' ),
			]
		);
		$this->add_control(
			TCI_UET_SETTINGS . '_contactform7_textarea_input_bg',
			[
				'label'     => __( 'Background Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tci-uet-widget .wpcf7-form textarea' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_textarea_input_border',
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form textarea',
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_textarea_input_radius',
			[
				'label'      => __( 'Border Radius', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form textarea' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_textarea_input',
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form textarea',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			TCI_UET_SETTINGS . '_contactform7_textarea_focus',
			[
				'label' => __( 'Focus', 'tci-uet' ),
			]
		);
		$this->add_control(
			TCI_UET_SETTINGS . '_contactform7_textarea_input_bg_focus',
			[
				'label'     => __( 'Background Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tci-uet-widget .wpcf7-form textarea:focus' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_textarea_input_border_focus',
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form textarea:focus',
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_textarea_input_radius_focus',
			[
				'label'      => __( 'Border Radius', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form textarea:focus' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_textarea_input_focus',
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form textarea:focus',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
	}

	/**
	 * Forms Select Field Settings.
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected function get_forms_select_settings() {
		$this->start_controls_section(
			TCI_UET_SETTINGS . '_contactform7_input_select_settings',
			[
				'label' => __( 'Select Field Settings', 'tci-uet' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_select_input_text_indent',
			[
				'label'      => __( 'Text Indent', 'tci-uet' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form select' => 'text-indent: {{SIZE}}{{UNIT}}',
				],
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_select_input_width',
			[
				'label'      => __( 'Width', 'tci-uet' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [ '{{WRAPPER}} .tci-uet-widget form.wpcf7-form select' => 'width: {{SIZE}}{{UNIT}};' ],
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_select_input_margin',
			[
				'label'      => __( 'Margin', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form select' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_select_input_padding',
			[
				'label'      => __( 'Padding', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->start_controls_tabs( TCI_UET_SETTINGS . '_contactform7_select_tabs' );
		$this->start_controls_tab(
			TCI_UET_SETTINGS . '_contactform7_select_normal',
			[
				'label' => __( 'Normal', 'tci-uet' ),
			]
		);
		$this->add_control(
			TCI_UET_SETTINGS . '_contactform7_select_input_bg',
			[
				'label'     => __( 'Background Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tci-uet-widget .wpcf7-form select' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_select_input_border',
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form select',
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_select_input_radius',
			[
				'label'      => __( 'Border Radius', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_select_input',
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form select',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			TCI_UET_SETTINGS . '_contactform7_select_focus',
			[
				'label' => __( 'Focus', 'tci-uet' ),
			]
		);
		$this->add_control(
			TCI_UET_SETTINGS . '_contactform7_select_input_bg_focus',
			[
				'label'     => __( 'Background Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tci-uet-widget .wpcf7-form select:focus' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_select_input_border_focus',
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form select:focus',
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_select_input_radius_focus',
			[
				'label'      => __( 'Border Radius', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form select:focus' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_select_input_focus',
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form select:focus',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
	}

	/**
	 * Forms Checkbox/Accept Field Settings.
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected function get_forms_checkbox_settings() {
		$this->start_controls_section(
			TCI_UET_SETTINGS . '_contactform7_input_checkbox_settings',
			[
				'label' => __( 'Checkbox/Accept Field Settings', 'tci-uet' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_checkbox_input_width',
			[
				'label'      => __( 'Width', 'tci-uet' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [ '{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="checkbox"]' => 'width: {{SIZE}}{{UNIT}};' ],
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_checkbox_input_margin',
			[
				'label'      => __( 'Margin', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="checkbox"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_checkbox_input_padding',
			[
				'label'      => __( 'Padding', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="checkbox"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_checkbox_input_border',
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="checkbox"]',
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_checkbox_input_radius',
			[
				'label'      => __( 'Border Radius', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="checkbox"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_checkbox_input',
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="checkbox"]',
			]
		);
		$this->end_controls_section();
	}

	/**
	 * Forms Radio Button Field Settings.
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected function get_forms_radio_settings() {
		$this->start_controls_section(
			TCI_UET_SETTINGS . '_contactform7_input_radio_settings',
			[
				'label' => __( 'Radio Field Settings', 'tci-uet' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_radio_input_width',
			[
				'label'      => __( 'Width', 'tci-uet' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [ '{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="radio"]' => 'width: {{SIZE}}{{UNIT}};' ],
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_radio_input_margin',
			[
				'label'      => __( 'Margin', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="radio"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_radio_input_padding',
			[
				'label'      => __( 'Padding', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="radio"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_radio_input_border',
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="radio"]',
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_radio_input_radius',
			[
				'label'      => __( 'Border Radius', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="radio"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_radio_input',
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="radio"]',
			]
		);
		$this->end_controls_section();
	}

	/**
	 * Forms File Field Settings.
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected function get_forms_file_settings() {
		$this->start_controls_section(
			TCI_UET_SETTINGS . '_contactform7_input_file_settings',
			[
				'label' => __( 'File Field Settings', 'tci-uet' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_file_input_text_indent',
			[
				'label'      => __( 'Text Indent', 'tci-uet' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="file"]' => 'text-indent: {{SIZE}}{{UNIT}}',
				],
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_file_input_width',
			[
				'label'      => __( 'Width', 'tci-uet' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [ '{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="file"]' => 'width: {{SIZE}}{{UNIT}};' ],
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_file_input_margin',
			[
				'label'      => __( 'Margin', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="file"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_file_input_padding',
			[
				'label'      => __( 'Padding', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="file"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->start_controls_tabs( TCI_UET_SETTINGS . '_contactform7_file_tabs' );
		$this->start_controls_tab(
			TCI_UET_SETTINGS . '_contactform7_file_normal',
			[
				'label' => __( 'Normal', 'tci-uet' ),
			]
		);
		$this->add_control(
			TCI_UET_SETTINGS . '_contactform7_file_input_bg',
			[
				'label'     => __( 'Background Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tci-uet-widget .wpcf7-form input[type="file"]' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_file_input_border',
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="file"]',
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_file_input_radius',
			[
				'label'      => __( 'Border Radius', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="file"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_file_input',
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="file"]',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			TCI_UET_SETTINGS . '_contactform7_file_focus',
			[
				'label' => __( 'Focus', 'tci-uet' ),
			]
		);
		$this->add_control(
			TCI_UET_SETTINGS . '_contactform7_file_input_bg_focus',
			[
				'label'     => __( 'Background Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tci-uet-widget .wpcf7-form input[type="file"]:focus' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_file_input_border_focus',
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="file"]:focus',
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_file_input_radius_focus',
			[
				'label'      => __( 'Border Radius', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="file"]:focus' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_file_input_focus',
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="file"]:focus',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
	}

	/**
	 * Forms Submit Button Field Settings.
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected function get_forms_submit_settings() {
		$this->start_controls_section(
			TCI_UET_SETTINGS . '_contactform7_input_button_settings',
			[
				'label' => __( 'Submit Field Settings', 'tci-uet' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_button_input_width',
			[
				'label'      => __( 'Width', 'tci-uet' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="submit"]'  => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form button[type="submit"]' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_button_input_margin',
			[
				'label'      => __( 'Margin', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="submit"]'  => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form button[type="submit"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_button_input_padding',
			[
				'label'      => __( 'Padding', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="submit"]'  => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form button[type="submit"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->start_controls_tabs( TCI_UET_SETTINGS . '_contactform7_button_tabs' );
		$this->start_controls_tab(
			TCI_UET_SETTINGS . '_contactform7_button_normal',
			[
				'label' => __( 'Normal', 'tci-uet' ),
			]
		);
		$this->add_control(
			TCI_UET_SETTINGS . '_contactform7_button_input_bg',
			[
				'label'     => __( 'Background Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tci-uet-widget .wpcf7-form input[type="submit"]'  => 'background-color: {{VALUE}} !important',
					'{{WRAPPER}} .tci-uet-widget .wpcf7-form buttom[type="submit"]' => 'background-color: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			TCI_UET_SETTINGS . '_contactform7_button_typography_color',
			[
				'label'     => __( 'Text Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'selectors' => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="submit"]'  => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form button[type="submit"]' => 'color: {{VALUE}} !important;',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_button_input_border',
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="submit"], {{WRAPPER}} .tci-uet-widget form.wpcf7-form button[type="submit"]',
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_button_input_radius',
			[
				'label'      => __( 'Border Radius', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="submit"]'  => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form button[type="submit"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_button_input',
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="submit"], {{WRAPPER}} .tci-uet-widget form.wpcf7-form button[type="submit"]',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			TCI_UET_SETTINGS . '_contactform7_button_focus',
			[
				'label' => __( 'Focus', 'tci-uet' ),
			]
		);
		$this->add_control(
			TCI_UET_SETTINGS . '_contactform7_button_input_bg_focus',
			[
				'label'     => __( 'Background Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tci-uet-widget .wpcf7-form input[type="submit"]:focus'  => 'background-color: {{VALUE}} !important',
					'{{WRAPPER}} .tci-uet-widget .wpcf7-form button[type="submit"]:focus' => 'background-color: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			TCI_UET_SETTINGS . '_contactform7_button_typography_color_focus',
			[
				'label'     => __( 'Text Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'selectors' => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="submit"]:focus'  => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form button[type="submit"]:focus' => 'color: {{VALUE}} !important;',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_button_input_border_focus',
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="submit"]:focus, {{WRAPPER}} .tci-uet-widget form.wpcf7-form button[type="submit"]:focus',
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_button_input_radius_focus',
			[
				'label'      => __( 'Border Radius', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="submit"]:focus'  => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form button[type="submit"]:focus' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_button_input_focus',
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="submit"]:focus, {{WRAPPER}} .tci-uet-widget form.wpcf7-form button[type="submit"]:focus',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			TCI_UET_SETTINGS . '_contactform7_button_hover',
			[
				'label' => __( 'Hover', 'tci-uet' ),
			]
		);
		$this->add_control(
			TCI_UET_SETTINGS . '_contactform7_button_input_bg_hover',
			[
				'label'     => __( 'Background Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tci-uet-widget .wpcf7-form input[type="submit"]:hover'  => 'background-color: {{VALUE}} !important',
					'{{WRAPPER}} .tci-uet-widget .wpcf7-form button[type="submit"]:hover' => 'background-color: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			TCI_UET_SETTINGS . '_contactform7_button_typography_color_hover',
			[
				'label'     => __( 'Text Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'selectors' => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="submit"]:hover'  => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form button[type="submit"]:hover' => 'color: {{VALUE}} !important;',
				],
			]
		);
		$this->add_control(
			TCI_UET_SETTINGS . '_contactform7_button_input_border_hover',
			[
				'label'     => __( 'Border Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="submit"]:hover'  => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form button[type="submit"]:hover' => 'border-color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_button',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form input[type="submit"], {{WRAPPER}} .tci-uet-widget form.wpcf7-form button[type="submit"]',

			]
		);
		$this->end_controls_section();
	}

	/**
	 * Forms Field Typography Settings.
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected function get_forms_field_typo_settings() {
		$this->start_controls_section(
			TCI_UET_SETTINGS . '_contactform7_field_typography_settings',
			[
				'label' => __( 'Fields Typography', 'tci-uet' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->start_controls_tabs( TCI_UET_SETTINGS . '_contactform7_field_typography_tabs' );
		$this->start_controls_tab(
			TCI_UET_SETTINGS . '_contactform7_field_typography_normal',
			[
				'label' => __( 'Normal', 'tci-uet' ),
			]
		);
		$this->add_control(
			TCI_UET_SETTINGS . '_contactform7_field_typography_color',
			[
				'label'     => __( 'Text Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'selectors' => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-formn'                                               => 'color: {{VALUE}} !important',
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form .wpcf7-form-control'                            => 'color: {{VALUE}} !important',
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form label > span'                                   => 'color: {{VALUE}} !important',
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form .wpcf7-form-control::-webkit-input-placeholder' => 'color: {{VALUE}} !important',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			TCI_UET_SETTINGS . '_contactform7_field_typography_focus',
			[
				'label' => __( 'Focus', 'tci-uet' ),
			]
		);
		$this->add_control(
			TCI_UET_SETTINGS . '_contactform7_field_typography_color_focus',
			[
				'label'     => __( 'Text Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'selectors' => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-formn:focus'                                               => 'color: {{VALUE}} !important',
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form .wpcf7-form-control:focus'                            => 'color: {{VALUE}} !important',
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form label > span:focus'                                   => 'color: {{VALUE}} !important',
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form .wpcf7-form-control:focus::-webkit-input-placeholder' => 'color: {{VALUE}} !important',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_field',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form, {{WRAPPER}} .tci-uet-widget form.wpcf7-form .wpcf7-form-control, {{WRAPPER}} .tci-uet-widget form.wpcf7-form label > span',
			]
		);
		$this->end_controls_section();
	}

	/**
	 * Forms Error Message Settings.
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected function get_forms_error_settings() {
		$this->start_controls_section(
			TCI_UET_SETTINGS . '_contactform7_input_error_settings',
			[
				'label' => __( 'Errors Settings', 'tci-uet' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_error_input_width',
			[
				'label'      => __( 'Width', 'tci-uet' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form .wpcf7-validation-errors' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form span.wpcf7-not-valid-tip' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_error_input_margin',
			[
				'label'      => __( 'Margin', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form .wpcf7-validation-errors' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form span.wpcf7-not-valid-tip' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_error_input_padding',
			[
				'label'      => __( 'Padding', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form .wpcf7-validation-errors' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form span.wpcf7-not-valid-tip' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			TCI_UET_SETTINGS . '_contactform7_error_input_bg',
			[
				'label'     => __( 'Background Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tci-uet-widget .wpcf7-form .wpcf7-validation-errors' => 'background-color: {{VALUE}} !important',
					'{{WRAPPER}} .tci-uet-widget .wpcf7-form span.wpcf7-not-valid-tip' => 'background-color: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			TCI_UET_SETTINGS . '_contactform7_error_typography_color',
			[
				'label'     => __( 'Text Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'selectors' => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form .wpcf7-validation-errors' => 'color: {{VALUE}} !important;',
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form span.wpcf7-not-valid-tip' => 'color: {{VALUE}} !important;',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_error_input_border',
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form span.wpcf7-not-valid-tip, {{WRAPPER}} .tci-uet-widget form.wpcf7-form .wpcf7-validation-errors',
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_error_input_radius',
			[
				'label'      => __( 'Border Radius', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form .wpcf7-validation-errors' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form span.wpcf7-not-valid-tip' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_error_input',
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form span.wpcf7-not-valid-tip, {{WRAPPER}} .tci-uet-widget form.wpcf7-form .wpcf7-validation-errors',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_error',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form span.wpcf7-not-valid-tip, {{WRAPPER}} .tci-uet-widget form.wpcf7-form .wpcf7-validation-errors',

			]
		);
		$this->end_controls_section();
	}

	/**
	 * Forms Thank Message Settings.
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected function get_forms_thank_settings() {
		$this->start_controls_section(
			TCI_UET_SETTINGS . '_contactform7_input_done_settings',
			[
				'label' => __( 'Thank You Message Settings', 'tci-uet' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_done_input_width',
			[
				'label'      => __( 'Width', 'tci-uet' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form .wpcf7-mail-sent-ok' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_done_input_margin',
			[
				'label'      => __( 'Margin', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form .wpcf7-mail-sent-ok' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_done_input_padding',
			[
				'label'      => __( 'Padding', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form .wpcf7-mail-sent-ok' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			TCI_UET_SETTINGS . '_contactform7_done_input_bg',
			[
				'label'     => __( 'Background Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tci-uet-widget .wpcf7-form .wpcf7-mail-sent-ok' => 'background-color: {{VALUE}} !important',
				],
			]
		);
		$this->add_control(
			TCI_UET_SETTINGS . '_contactform7_done_typography_color',
			[
				'label'     => __( 'Text Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
				'selectors' => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form .wpcf7-mail-sent-ok' => 'color: {{VALUE}} !important;',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_done_input_border',
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form .wpcf7-mail-sent-ok',
			]
		);
		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_contactform7_done_input_radius',
			[
				'label'      => __( 'Border Radius', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget form.wpcf7-form .wpcf7-mail-sent-ok' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_done_input',
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form .wpcf7-mail-sent-ok',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_contactform7_done',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .tci-uet-widget form.wpcf7-form .wpcf7-mail-sent-ok',

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
		if ( ! function_exists( 'wpcf7' ) ) {
			return false;
		}
		$this->add_render_attribute( 'wrapper', 'class', 'tci-uet-widget' );
		$settings = $this->get_settings_for_display();
		$settings = tci_uet_array( $settings );

		$post = get_page_by_path( $settings->get( TCI_UET_SETTINGS . '_contact_form_7_slug' ), OBJECT, 'wpcf7_contact_form' );

		if ( ! empty( $post ) ) {
			echo '<div ' . wp_kses_post( $this->get_render_attribute_string( 'wrapper' ) ) . '>' . do_shortcode( '[contact-form-7 id="' . $post->ID . '"]' ) . '</div>';
		}
	}
}
