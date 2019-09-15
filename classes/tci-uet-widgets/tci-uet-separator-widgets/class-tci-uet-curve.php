<?php
/**
 * TCI UET Curve Separator widget class
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.1
 */
namespace TCI_UET\TCI_UET_Widgets\TCI_UET_Separator_Widgets;

tci_uet_exit();

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Scheme_Color;

class TCI_UET_Curve extends Widget_Base {

	/**
	 * Get widget name.
	 * Retrieve widget name.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'TCI_UET_Curve';
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
		return __( 'TCI UET Curve', 'tci-uet' );
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
		return 'eicon-v-align-middle';
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
		return [ 'tci-uet-separator-widgets' ];
	}

	/**
	 * Attach keywords.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_keywords() {
		return [ 'separator' ];
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
			TCI_UET_SETTINGS . 'section_separator_settings',
			[
				'label' => __( 'Separator', 'tci-uet' ),
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_transform_position',
			[
				'label'      => __( 'Rotation', 'tci-uet' ),
				'type'       => Controls_Manager::SLIDER,
				'responsive' => true,
				'range'      => [
					'deg' => [
						'min' => - 180,
						'max' => 180,
					],
				],
				'default'    => [
					'unit' => 'deg',
					'size' => 0,
				],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget.tci-uet-shap-wrapper > .tci-uet-shap-inner' => 'transform: rotate({{SIZE}}{{UNIT}})',
				],
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_container_width',
			[
				'label'      => __( 'Parent Width', 'tci-uet' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', '%' ],
				'responsive' => true,
				'range'      => [
					'px'  => [
						'min' => 1,
						'max' => 1000,
					],
					'em'  => [
						'min' => 1,
						'max' => 100,
					],
					'rem' => [
						'min' => 1,
						'max' => 100,
					],
					'%'   => [
						'min' => 1,
						'max' => 100,
					],
				],
				'default'    => [
					'unit' => '%',
					'size' => 100,
				],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget.tci-uet-shap-wrapper > .tci-uet-shap-inner' => 'width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_boder_width',
			[
				'label'          => __( 'Shap Width', 'tci-uet' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => [ '%', 'em', 'rem' ],
				'responsive'     => true,
				'range'          => [
					'em'  => [
						'min' => 100,
						'max' => 1000,
					],
					'rem' => [
						'min' => 100,
						'max' => 1000,
					],
					'%'   => [
						'min' => 100,
						'max' => 1000,
					],
				],
				'default'        => [
					'unit' => '%',
					'size' => 100,
				],
				'tablet_default' => [
					'unit' => '%',
				],
				'mobile_default' => [
					'unit' => '%',
				],
				'selectors'      => [
					'{{WRAPPER}} .tci-uet-widget.tci-uet-shap-wrapper > .tci-uet-shap-inner > svg.tci-uet-shap' => 'width: calc({{SIZE}}{{UNIT}} + 1.3px)',
				],
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_boder_height',
			[
				'label'          => __( 'Height', 'tci-uet' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => [ 'px', 'em', 'rem' ],
				'default'        => [
					'unit' => 'px',
					'size' => 100,
				],
				'tablet_default' => [
					'unit' => 'px',
				],
				'mobile_default' => [
					'unit' => 'px',
				],
				'range'          => [
					'px'  => [
						'max' => 1000,
					],
					'em'  => [
						'max' => 1000,
					],
					'rem' => [
						'max' => 1000,
					],
				],
				'selectors'      => [
					'{{WRAPPER}} .tci-uet-widget.tci-uet-shap-wrapper > .tci-uet-shap-inner > svg.tci-uet-shap' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .tci-uet-widget.tci-uet-shap-wrapper > .tci-uet-shap-inner'                    => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_h_position',
			[
				'label'   => __( 'Shap Horizontal Orientation', 'tci-uet' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left'  => [
						'title' => __( 'Left', 'tci-uet' ),
						'icon'  => 'eicon-h-align-left',
					],
					'right' => [
						'title' => __( 'Right', 'tci-uet' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default' => 'left',
				'toggle'  => false,
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_h_l_position_set',
			[
				'label'      => __( 'Offset', 'tci-uet' ),
				'type'       => Controls_Manager::SLIDER,
				'responsive' => true,
				'range'      => [
					'%' => [
						'min' => - 100,
						'max' => 100,
					],
				],
				'default'    => [
					'unit' => '%',
					'size' => 0,
				],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget.tci-uet-shap-wrapper > .tci-uet-shap-inner > svg.tci-uet-shap' => 'left: {{SIZE}}{{UNIT}}',
				],
				'condition'  => [
					TCI_UET_SETTINGS . '_h_position' => 'left',
				],
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_h_r_position_set',
			[
				'label'      => __( 'Offset', 'tci-uet' ),
				'type'       => Controls_Manager::SLIDER,
				'responsive' => true,
				'range'      => [
					'%' => [
						'min' => - 100,
						'max' => 100,
					],
				],
				'default'    => [
					'unit' => '%',
					'size' => 0,
				],
				'selectors'  => [
					'{{WRAPPER}} .tci-uet-widget.tci-uet-shap-wrapper > .tci-uet-shap-inner > svg.tci-uet-shap' => 'right: {{SIZE}}{{UNIT}}',
				],
				'condition'  => [
					TCI_UET_SETTINGS . '_h_position' => 'right',
				],
			]
		);

		$this->add_responsive_control(
			TCI_UET_SETTINGS . '_align',
			[
				'label'   => __( 'Alignment', 'tci-uet' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left'   => [
						'title' => __( 'Left', 'tci-uet' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'tci-uet' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => __( 'Right', 'tci-uet' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default' => '',
			]
		);

		$this->add_control(
			TCI_UET_SETTINGS . '_color',
			[
				'label'     => __( 'Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'default'   => '#000000',
				'selectors' => [
					'{{WRAPPER}} .tci-uet-widget.tci-uet-shap-wrapper > .tci-uet-shap-inner > svg.tci-uet-shap > .tci-uet-shape-fill' => 'fill: {{VALUE}}',
				],
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

		$this->add_render_attribute( 'tci-uet-wrapper', 'class', [
			'tci-uet-widget',
			'tci-uet-shap-wrapper',
			"tci-uet-shap-align-{$settings->get(TCI_UET_SETTINGS . '_align')}",
		] );
		?>
		<div <?php echo $this->get_render_attribute_string( 'tci-uet-wrapper' ); ?>>
			<div class="tci-uet-shap-inner"><?php echo tci_uet_shap( 'tci-uet-curve.svg' ); ?></div>
		</div>
		<?php
	}
}
