<?php
/**
 * TCI UET Breadcrumbs class
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.2
 */
namespace TCI_UET\TCI_UET_Widgets\TCI_UET_Single_Widgets;

tci_uet_exit();

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Widget_Base;

class TCI_UET_Breadcrumbs extends Widget_Base {
	/**
	 * Get widget name.
	 * Retrieve widget name.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'TCI_UET_Breadcrumbs';
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
		return __( 'TCI UET Breadcrumbs', 'tci-uet' );
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
		return 'tci tci-uet-site-map';
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
		return [ 'tci-uet-single-widgets' ];
	}

	/**
	 * Attach keywords.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_keywords() {
		return [ 'yoast', 'seo', 'breadcrumbs', 'internal links' ];
	}

	/**
	 * Get style dependencies.
	 * Retrieve the list of style dependencies the element requires.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return array Element style dependencies.
	 */
	public function get_style_depends() {
		return [ 'tci-uet-frontend' ];
	}

	/**
	 * Check Yoast SEO enable
	 *
	 * @since  0.0.1
	 * @access public
	 * @return bool True.
	 */
	private function is_breadcrumbs_enabled() {
		$breadcrumbs_enabled = current_theme_supports( 'yoast-seo-breadcrumbs' );
		if ( ! $breadcrumbs_enabled ) {
			$options             = get_option( 'wpseo_internallinks' );
			$breadcrumbs_enabled = true === $options['breadcrumbs-enable'];
		}

		return $breadcrumbs_enabled;
	}

	/**
	 * Register widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected function _register_controls() {

		if ( ! function_exists( 'yoast_breadcrumb' ) ) {
			$this->start_controls_section(
				TCI_UET_SETTINGS . '_breadcrumb_warning',
				[
					'label' => __( 'Warning!', 'tci-uet' ),
				]
			);
			$this->add_control(
				TCI_UET_SETTINGS . '_breadcrumb_warning_text',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => __( '<strong>Yoast SEO</strong> is not installed/activated on your site. Please install and activate <strong>Yoast SEO</strong> first.', 'tci-uet' ),
					'content_classes' => 'tci-uet-warning',
				]
			);
			$this->end_controls_section();

			return false;
		}

		$this->start_controls_section(
			'section_breadcrumbs_content',
			[
				'label' => __( 'Breadcrumbs', 'tci-uet' ),
			]
		);

		if ( ! $this->is_breadcrumbs_enabled() ) {
			$this->add_control(
				'html_disabled_alert',
				[
					'raw'             => __( 'Breadcrumbs are disabled in the Yoast SEO', 'tci-uet' ) . ' ' . sprintf( '<a href="%s" target="_blank">%s</a>', admin_url( 'admin.php?page=wpseo_titles#top#breadcrumbs' ), __( 'Breadcrumbs Panel', 'tci-uet' ) ),
					'type'            => Controls_Manager::RAW_HTML,
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-danger',
				]
			);
		}

		$this->add_responsive_control(
			'align',
			[
				'label'        => __( 'Alignment', 'tci-uet' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => [
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
				'prefix_class' => 'elementor%s-align-',
			]
		);

		$this->add_control(
			'html_tag',
			[
				'label'   => __( 'HTML Tag', 'tci-uet' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''     => __( 'Default', 'tci-uet' ),
					'p'    => 'p',
					'div'  => 'div',
					'nav'  => 'nav',
					'span' => 'span',
				],
				'default' => '',
			]
		);

		$this->add_control(
			'html_description',
			[
				'raw'             => __( 'Additional settings are available in the Yoast SEO', 'tci-uet' ) . ' ' . sprintf( '<a href="%s" target="_blank">%s</a>', admin_url( 'admin.php?page=wpseo_titles#top#breadcrumbs' ), __( 'Breadcrumbs Panel', 'tci-uet' ) ),
				'type'            => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-descriptor',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Breadcrumbs', 'tci-uet' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'typography',
				'selector' => '{{WRAPPER}}',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_2,
			]
		);

		$this->add_control(
			'text_color',
			[
				'label'     => __( 'Text Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}}' => 'color: {{VALUE}};',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_breadcrumbs_style' );

		$this->start_controls_tab(
			'tab_color_normal',
			[
				'label' => __( 'Normal', 'tci-uet' ),
			]
		);

		$this->add_control(
			'link_color',
			[
				'label'     => __( 'Link Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_color_hover',
			[
				'label' => __( 'Hover', 'tci-uet' ),
			]
		);

		$this->add_control(
			'link_hover_color',
			[
				'label'     => __( 'Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Retrive to get HTML tags
	 *
	 * @since  0.0.1
	 * @access private
	 * @return string.
	 */
	private function get_html_tag() {
		$html_tag = $this->get_settings( 'html_tag' );

		if ( empty( $html_tag ) ) {
			$html_tag = 'p';
		}

		return $html_tag;
	}

	/**
	 * Render widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected function render() {
		if ( ! function_exists( 'yoast_breadcrumb' ) ) {
			return;
		}
		$html_tag = $this->get_html_tag();
		yoast_breadcrumb( '<' . $html_tag . ' id="breadcrumbs">', '</' . $html_tag . '>' );
	}
}
