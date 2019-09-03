<?php
/**
 * TCI UET Sticky class
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.1
 */
namespace TCI_UET\TCI_Modules;

tci_uet_exit();

use Elementor\Controls_Manager;
use Elementor\Element_Base;
use Elementor\Widget_Base;

class TCI_Sticky {

	public function __construct() {
		$this->add_actions();
	}

	public function get_name() {
		return 'sticky';
	}

	public function register_controls( Element_Base $element ) {
		$element->add_control(
			'sticky',
			[
				'label'              => __( 'Sticky', 'tci-uet' ),
				'type'               => Controls_Manager::SELECT,
				'options'            => [
					''       => __( 'None', 'tci-uet' ),
					'top'    => __( 'Top', 'tci-uet' ),
					'bottom' => __( 'Bottom', 'tci-uet' ),
				],
				'separator'          => 'before',
				'render_type'        => 'none',
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'sticky_on',
			[
				'label'              => __( 'Sticky On', 'tci-uet' ),
				'type'               => Controls_Manager::SELECT2,
				'multiple'           => true,
				'label_block'        => 'true',
				'default'            => [ 'desktop', 'tablet', 'mobile' ],
				'options'            => [
					'desktop' => __( 'Desktop', 'tci-uet' ),
					'tablet'  => __( 'Tablet', 'tci-uet' ),
					'mobile'  => __( 'Mobile', 'tci-uet' ),
				],
				'condition'          => [
					'sticky!' => '',
				],
				'render_type'        => 'none',
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'sticky_offset',
			[
				'label'              => __( 'Offset', 'tci-uet' ),
				'type'               => Controls_Manager::NUMBER,
				'default'            => 0,
				'min'                => 0,
				'max'                => 500,
				'required'           => true,
				'condition'          => [
					'sticky!' => '',
				],
				'render_type'        => 'none',
				'frontend_available' => true,
			]
		);

		$element->add_control(
			'sticky_effects_offset',
			[
				'label'              => __( 'Effects Offset', 'tci-uet' ),
				'type'               => Controls_Manager::NUMBER,
				'default'            => 0,
				'min'                => 0,
				'max'                => 1000,
				'required'           => true,
				'condition'          => [
					'sticky!' => '',
				],
				'render_type'        => 'none',
				'frontend_available' => true,
			]
		);

		if ( $element instanceof Widget_Base ) {
			$element->add_control(
				'sticky_parent',
				[
					'label'              => __( 'Stay In Column', 'tci-uet' ),
					'type'               => Controls_Manager::SWITCHER,
					'condition'          => [
						'sticky!' => '',
					],
					'render_type'        => 'none',
					'frontend_available' => true,
				]
			);
		}

		$element->add_control(
			'sticky_divider',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);
	}

	private function add_actions() {
		add_action( 'elementor/element/section/section_effects/after_section_start', [ $this, 'register_controls' ] );
		add_action( 'elementor/element/common/section_effects/after_section_start', [ $this, 'register_controls' ] );
	}
}

new TCI_Sticky();