<?php
/**
 * TCI UET Custom Attributes module class
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.1
 */
namespace TCI_UET\TCI_Modules;

tci_exit();

use Elementor\Controls_Stack;
use Elementor\Controls_Manager;
use Elementor\Element_Base;
use Elementor\Element_Column;
use Elementor\Element_Section;
use Elementor\Widget_Base;

if ( defined( 'ELEMENTOR_PRO_VERSION' ) ) {
	return;
}

class TCI_Custom_Attributes {
	/**
	 * Constructer
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function __construct() {

		$this->add_actions();
	}

	public function get_name() {
		return 'custom-attributes';
	}

	/**
	 * Black List Attributes
	 *
	 * @since  0.0.1
	 * @access public
	 */
	private function get_black_list_attributes() {
		static $black_list = null;

		if ( null === $black_list ) {
			$black_list = [
				'id',
				'class',
				'data-id',
				'data-settings',
				'data-element_type',
				'data-widget_type',
				'data-model-cid',
				'onload',
				'onclick',
				'onfocus',
				'onblur',
				'onchange',
				'onresize',
				'onmouseover',
				'onmouseout',
				'onkeydown',
				'onkeyup',
			];

			/**
			 * Elementor attributes black list.
			 * Filters the attributes that won't be rendered in the wrapper element.
			 * By default Elementor don't render some attributes to prevent things
			 * from breaking down. But this list of attributes can be changed.
			 *
			 * @since 2.2.0
			 *
			 * @param array $black_list A black list of attributes.
			 */
			$black_list = apply_filters( 'elementor_pro/element/attributes/black_list', $black_list );
		}

		return $black_list;
	}

	/**
	 * Register Controls
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function register_controls( Controls_Stack $element, $section_id ) {
		$required_section_id = '';
		if ( $element instanceof Element_Section || $element instanceof Widget_Base ) {
			$required_section_id = '_section_responsive';
		} elseif ( $element instanceof Element_Column ) {
			$required_section_id = 'section_advanced';
		}

		if ( $required_section_id !== $section_id ) {
			return;
		}

		$element->start_controls_section(
			'_section_attributes',
			[
				'label' => __( 'TCI UET Attributes', 'tci-uet' ),
				'tab'   => Controls_Manager::TAB_ADVANCED,
			]
		);

		$element->add_control(
			'_attributes',
			[
				'label'       => __( 'Custom Attributes', 'tci-uet' ),
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'key|value', 'tci-uet' ),
				'description' => sprintf( __( 'Set custom attributes for the wrapper element. Each attribute in a separate line. Separate attribute key from the value using %s character.', 'tci-uet' ), '<code>|</code>' ),
				'classes'     => 'elementor-control-direction-ltr',
			]
		);

		$element->end_controls_section();

	}

	/**
	 * Render Attributes
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function render_attributes( Element_Base $element ) {
		$settings = $element->get_settings_for_display();

		if ( ! empty( $settings['_attributes'] ) ) {
			$attributes = explode( "\n", $settings['_attributes'] );

			$black_list = $this->get_black_list_attributes();

			foreach ( $attributes as $attribute ) {
				if ( ! empty( $attribute ) ) {
					$attr = explode( '|', $attribute, 2 );
					if ( ! isset( $attr[1] ) ) {
						$attr[1] = '';
					}

					if ( ! in_array( strtolower( $attr[0] ), $black_list ) ) {
						$element->add_render_attribute( '_wrapper', trim( $attr[0] ), trim( $attr[1] ) );
					}
				}
			}
		}
	}

	/**
	 * Add Actions
	 *
	 * @since  0.0.1
	 * @access public
	 */
	protected function add_actions() {
		add_action( 'elementor/element/after_section_end', [ $this, 'register_controls' ], 10, 2 );
		add_action( 'elementor/element/after_add_attributes', [ $this, 'render_attributes' ] );
	}
}

new TCI_Custom_Attributes();