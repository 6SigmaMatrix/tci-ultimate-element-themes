<?php
/**
 * TCI UET Page Extend module class
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.1
 */
namespace TCI_UET\TCI_UET_Modules;

tci_uet_exit();

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Core\DocumentTypes\Post;
use TCI_UET\TCI_UET_Modules;
use Elementor\Core\Settings\Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;

class TCI_UET_Page_Extend extends TCI_UET_Modules {

	/**
	 * Constructer
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function __construct() {
		add_action( 'template_redirect', [ $this, 'tci_uet_page_extend_classes' ] );
		add_action( 'elementor/element/post/section_page_style/after_section_end', [
			$this,
			'tci_uet_page_controls',
		], 10, 2 );
	}

	public function tci_uet_page_controls( Post $page ) {
		$this->tci_uet_page_advance_controls( $page );

		$this->tci_uet_page_paragraph_controls( $page );

		$this->tci_uet_page_paragraph_size_controls( $page );

		$this->tci_uet_page_heading_controls( $page );

		$this->tci_uet_page_heading_size_controls( $page );
	}

	private function tci_uet_page_advance_controls( $page ) {

		$page->start_controls_section(
			TCI_UET_SETTINGS . '_section_page_advanced',
			[
				'label' => __( 'TCI UET Advanced', 'tci-uet' ),
				'tab'   => Controls_Manager::TAB_ADVANCED,
			]
		);

		$page->remove_control( 'padding' );

		$page->add_responsive_control(
			TCI_UET_SETTINGS . '_page_margin',
			[
				'label'      => __( 'Margin', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}}' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$page->add_responsive_control(
			TCI_UET_SETTINGS . '_page_padding',
			[
				'label'      => __( 'Padding', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}}' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$page->add_control(
			TCI_UET_SETTINGS . '_page_classes',
			[
				'label'   => __( 'CSS Classes', 'tci-uet' ),
				'type'    => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$page->end_controls_section();

	}

	private function tci_uet_page_heading_controls( $page ) {

		$page->start_controls_section(
			TCI_UET_SETTINGS . '_section_page_heading_style',
			[
				'label' => __( 'TCI UET Heading Typography', 'tci-uet' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		for ( $i = 1; $i < 7; $i ++ ) {

			$page->add_responsive_control(
				TCI_UET_SETTINGS . "_page_heading_{$i}_margin",
				[
					'label'      => __( "Heading {$i} Margin", 'tci-uet' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', 'rem', '%' ],
					'selectors'  => [
						"{{WRAPPER}} .elementor-widget-heading h{$i}.elementor-heading-title"   => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
						"{{WRAPPER}} .elementor-widget-heading h{$i}.elementor-heading-title a" => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
						"{{WRAPPER}} h{$i}"                                                     => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
						"{{WRAPPER}} h{$i} a"                                                   => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
					],
				]
			);

			$page->add_responsive_control(
				TCI_UET_SETTINGS . "_page_heading_{$i}_padding",
				[
					'label'      => __( "Heading {$i} Padding", 'tci-uet' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', 'rem', '%' ],
					'selectors'  => [
						"{{WRAPPER}} .elementor-widget-heading h{$i}.elementor-heading-title"   => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
						"{{WRAPPER}} .elementor-widget-heading h{$i}.elementor-heading-title a" => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
						"{{WRAPPER}} h{$i}"                                                     => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
						"{{WRAPPER}} h{$i} a"                                                   => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
					],
				]
			);

			$page->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => TCI_UET_SETTINGS . '_page_heading_' . $i,
					'label'    => sprintf( __( 'Heading %s Typography', 'tci-uet' ), $i ),
					'selector' => "{{WRAPPER}} h{$i}, {{WRAPPER}} .elementor-widget-heading h{$i}.elementor-heading-title, {{WRAPPER}} h{$i} a, {{WRAPPER}} .elementor-widget-heading h{$i}.elementor-heading-title a",
					'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				]
			);

			$page->add_control(
				TCI_UET_SETTINGS . '_page_heading_' . $i . '_divider',
				[
					'type' => 'divider',
				]
			);
		}

		$page->end_controls_section();

	}

	private function tci_uet_page_heading_size_controls( $page ) {

		$page->start_controls_section(
			TCI_UET_SETTINGS . '_section_page_heading_size',
			[
				'label' => __( 'TCI UET Heading Size', 'tci-uet' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$settings = [
			[ 'xxl', __( 'XXL', 'tci-uet' ) ],
			[ 'xl', __( 'XL', 'tci-uet' ) ],
			[ 'large', __( 'Large', 'tci-uet' ) ],
			[ 'medium', __( 'Medium', 'tci-uet' ) ],
			[ 'small', __( 'Small', 'tci-uet' ) ],
		];

		foreach ( $settings as $setting ) {
			$page->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => TCI_UET_SETTINGS . '_heading_size_' . $setting[0],
					'label'    => $setting[1],
					'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
					'selector' => "
						{{WRAPPER}} .elementor-widget-heading h1.elementor-heading-title.elementor-size-{$setting[0]},
						{{WRAPPER}} .elementor-widget-heading h2.elementor-heading-title.elementor-size-{$setting[0]},
						{{WRAPPER}} .elementor-widget-heading h3.elementor-heading-title.elementor-size-{$setting[0]},
						{{WRAPPER}} .elementor-widget-heading h4.elementor-heading-title.elementor-size-{$setting[0]},
						{{WRAPPER}} .elementor-widget-heading h5.elementor-heading-title.elementor-size-{$setting[0]},
						{{WRAPPER}} .elementor-widget-heading h6.elementor-heading-title.elementor-size-{$setting[0]},
						{{WRAPPER}} h1.elementor-size-{$setting[0]},
						{{WRAPPER}} h2.elementor-size-{$setting[0]},
						{{WRAPPER}} h3.elementor-size-{$setting[0]},
						{{WRAPPER}} h4.elementor-size-{$setting[0]},
						{{WRAPPER}} h5.elementor-size-{$setting[0]},
						{{WRAPPER}} h6.elementor-size-{$setting[0]}
					",
					'exclude'  => [
						'font_family',
						'font_weight',
						'text_transform',
						'text_decoration',
						'font_style',
						'letter_spacing',
						'line_height',
					],
				]
			);
		}

		$page->end_controls_section();

	}

	private function tci_uet_page_paragraph_controls( $page ) {

		$page->start_controls_section(
			TCI_UET_SETTINGS . '_section_page_paragraph_style',
			[
				'label' => __( 'TCI UET Paragraph Typography', 'tci-uet' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$page->add_responsive_control(
			TCI_UET_SETTINGS . "_page_paragraph_margin",
			[
				'label'      => __( "Margin", 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .elementor-text-editor'   => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
					'{{WRAPPER}} .elementor-text-editor p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
					'{{WRAPPER}} p'                        => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$page->add_responsive_control(
			TCI_UET_SETTINGS . "_page_paragraph_padding",
			[
				'label'      => __( "Padding", 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .elementor-text-editor'   => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
					'{{WRAPPER}} .elementor-text-editor p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
					'{{WRAPPER}} p'                        => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$page->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => TCI_UET_SETTINGS . '_page_paragraph_',
				'label'    => __( 'Paragraph Typography', 'tci-uet' ),
				'selector' => '{{WRAPPER}} p, {{WRAPPER}} .elementor-text-editor p, {{WRAPPER}} .elementor-text-editor',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
			]
		);

		$page->end_controls_section();

	}

	private function tci_uet_page_paragraph_size_controls( $page ) {

		$page->start_controls_section(
			TCI_UET_SETTINGS . '_section_page_paragraph_size',
			[
				'label' => __( 'TCI UET Paragraph Size', 'tci-uet' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$settings = [
			[ 'xxl', __( 'XXL', 'tci-uet' ) ],
			[ 'xl', __( 'XL', 'tci-uet' ) ],
			[ 'large', __( 'Large', 'tci-uet' ) ],
			[ 'medium', __( 'Medium', 'tci-uet' ) ],
			[ 'small', __( 'Small', 'tci-uet' ) ],
		];

		foreach ( $settings as $setting ) {
			$page->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => TCI_UET_SETTINGS . '_paragraph_size_' . $setting[0],
					'label'    => $setting[1],
					'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
					'selector' => "{{WRAPPER}} .elementor-widget-heading .elementor-heading-title.elementor-size-{$setting[0]}:not(h1):not(h2):not(h3):not(h4):not(h5):not(h6)",
					'exclude'  => [
						'font_family',
						'font_weight',
						'text_transform',
						'text_decoration',
						'font_style',
						'letter_spacing',
						'line_height',
					],
				]
			);
		}

		$page->end_controls_section();

	}

	public function tci_uet_page_extend_classes() {

		add_filter( 'body_class', function ( $classes ) {

			$post_id               = get_queried_object_ID();
			$page_settings_manager = Manager::get_settings_managers( 'page' );
			$page_settings_model   = $page_settings_manager->get_model( $post_id );
			$_classes              = $page_settings_model->get_settings_for_display( TCI_UET_SETTINGS . '_page_classes' );
			array_push( $classes, $_classes );

			return $classes;
		} );
	}
}
