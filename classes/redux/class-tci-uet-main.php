<?php
/**
 * TCI Ultimate Element Themes Plugin Main
 *
 * @since 0.0.1
 */

namespace TCI_UET\Redux;

class TCI_UET_Main {

	/**
	 * Constructor.
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function __construct() {
		add_action( 'tci_uet/redux', [ $this, 'tci_uet_redux_opt' ], 20 );
	}

	/**
	 * Template Main Options.
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function tci_uet_redux_opt() {
		\Redux::set_section( 'tci_uet_opt', [
			'id'               => TCI_UET . 'main_opt',
			'title'            => __( 'Plugin Main', 'tci-uet' ),
			'desc'             => __( 'This is TCI UET Plugin main options section to performs many actions for every extenstion.', 'tci-uet' ),
			'customizer_width' => '400px',
			'icon'             => 'el el-home-alt',
			'subsection'       => false,
			'fields'           => apply_filters( 'tci_uet_main_redux_section_opt', [
					[
						'id'     => TCI_UET . 'logo_st',
						'type'   => 'section',
						'title'  => __( 'Plugin Logo Settings', 'tci-uet' ),
						'indent' => true,
					],
					[
						'id'       => TCI_UET . 'logo_img_dimensions',
						'type'     => 'dimensions',
						'title'    => __( 'Logo Image dimensions', 'tci-uet' ),
						'subtitle' => __( 'Set the logo image dimensions like width and height to show on header.', 'tci-uet' ),
						'units'    => false,
						'default'  => [
							'width'  => 125,
							'height' => 38,
						],
						'validate' => 'numeric',
					],
					[
						'id'       => TCI_UET . 'header_logo_img',
						'type'     => 'info',
						'title'    => __( 'Logo Image', 'tci-uet' ),
						'subtitle' => sprintf( __( 'Set the logo image for headers. %s', 'tci-uet' ), '<a href="' . esc_url( get_admin_url() ) . 'customize.php?autofocus[section]=title_tagline">' . __( 'Set the logo', 'tci-uet' ) . '</a>' ),
						'style'    => 'critical',
					],
					[
						'id'     => TCI_UET . 'log_section_en',
						'type'   => 'section',
						'indent' => false,
					],
				]
			),
		] );
	}
}

new TCI_UET_Main();
