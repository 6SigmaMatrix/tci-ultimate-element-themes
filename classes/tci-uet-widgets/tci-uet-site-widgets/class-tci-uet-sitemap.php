<?php
/**
 * TCI UET Sitemap widget class
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.2
 */
namespace TCI_UET\TCI_UET_Widgets\TCI_UET_Site_Widgets;

tci_uet_exit();

use Elementor\Controls_Manager;
use TCI_UET\TCI_UET_Modules\TCI_UET_Query_Control;
use TCI_UET\TCI_Module\Controls\Group_Control_Query;
use TCI_UET\Classes\Elementor_Post_Query;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Widget_Base;
use TCI_UET\TCI_UET_Utils;

class TCI_UET_Sitemap extends Widget_Base {
	/**
	 * Get widget name.
	 * Retrieve widget name.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'TCI_UET_Sitemap';
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
		return __( 'TCI UET Sitemap', 'tci-uet' );
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
		return [ 'tci-uet-site-widgets' ];
	}

	/**
	 * Attach keywords.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_keywords() {
		return [ 'taxonomy', 'custom post type', 'cpt', 'sitemap', 'site map', 'link', 'menu', 'tree' ];
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
		return [
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
		$this->register_sitemap_tab();
		$this->register_style_tab();
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

		if ( empty( $settings['sitemap_items'] ) ) {
			return;
		}

		$title_tag = $settings['sitemap_title_tag'];

		$posts_query = [
			'post__not_in' => $settings['sitemap_exclude_ids'],
			'has_password' => 'yes' === $settings['sitemap_password_protected'] ? null : false,
		];

		$this->add_render_attribute( [
			'category_link' => [
				'class' => 'elementor-sitemap-category-title',
			],
			'wrapper'       => [
				'class' => 'elementor-sitemap-wrap',
			],
		] );

		if ( 'yes' === $settings['sitemap_add_nofollow'] ) {
			$this->add_render_attribute( 'a', 'rel', 'nofollow' );
		}

		echo '<div ' . $this->get_render_attribute_string( 'wrapper' ) . '>';
		foreach ( $settings['sitemap_items'] as $sitemap_item ) {
			echo $this->render_sitemap_item( $sitemap_item, $title_tag, $posts_query );
		}
		echo '</div>';
	}

	/**
	 * List Title
	 *
	 * @since  0.0.1
	 * @access private
	 */
	private function get_list_title( $current_title, $item_type, $is_taxonomy ) {
		if ( '' !== $current_title ) {
			return $current_title;
		}

		if ( $is_taxonomy ) {
			$obj = get_taxonomy( $item_type );
			if ( false === $obj ) {
				return '';
			}

			return $obj->label;
		}

		$obj = get_post_type_object( $item_type );
		if ( null === $obj ) {
			return '';
		}
		if ( '' === $obj->labels->name ) {
			return $obj->labels->singular_name;
		}

		return $obj->labels->name;
	}

	/**
	 * Render Sitemap Items
	 *
	 * @since  0.0.1
	 * @access private
	 */
	private function render_sitemap_item( $sitemap_item, $title_tag, $query_args ) {
		$hierarchical          = 'yes' === $sitemap_item['sitemap_hierarchical'];
		$max_depth             = $sitemap_item['sitemap_depth'];
		$query_args['orderby'] = $sitemap_item['sitemap_orderby_post_type'];
		$query_args['order']   = $sitemap_item['sitemap_order'];
		$is_taxonomy           = 'taxonomy' === $sitemap_item['sitemap_type_selector'];
		$item_type             = $is_taxonomy ? $sitemap_item['sitemap_source_taxonomy'] : $sitemap_item['sitemap_source_post_type'];
		$title                 = $this->get_list_title( $sitemap_item['sitemap_title'], $item_type, $is_taxonomy );

		$this->add_render_attribute( [
			'section' . $item_type  => [
				'class' => [
					'elementor-sitemap-section',
				],
			],
			'list' . $item_type     => [
				'class' => [
					'elementor-sitemap-list',
					'elementor-sitemap-' . $item_type . '-list',
				],
			],
			$title_tag . $item_type => [
				'class' => [
					'elementor-sitemap-title',
					'elementor-sitemap-' . $item_type . '-title',
				],
			],
			'item' . $item_type     => [
				'class' => [
					'elementor-sitemap-item',
					'elementor-sitemap-item-' . $item_type,
				],
			],
		] );

		$items_html = '';

		if ( $is_taxonomy ) {
			$items_html .= $this->sitemap_html_taxonomies( $item_type, $hierarchical, $max_depth, $sitemap_item, $query_args );
		} else {
			$items_html .= $this->sitemap_html_post_types( $item_type, $hierarchical, $max_depth, $query_args );
		}

		$title = empty( $title ) ? '' : sprintf( '<%s %s>%s</%1$s>', $title_tag, $this->get_render_attribute_string( $title_tag . $item_type ), $title );

		$html = sprintf( '<div %s>%s', $this->get_render_attribute_string( 'section' . $item_type ), $title );
		if ( empty( $items_html ) ) {
			$html .= sprintf( '<span %s>%s</span>', $this->get_render_attribute_string( 'list' . $item_type ), __( 'None', 'tci-uet' ) );
		} else {
			$html .= sprintf( '<ul %s>%s</ul>', $this->get_render_attribute_string( 'list' . $item_type ), $items_html );
		}
		$html .= '</div>';

		return $html;
	}

	/**
	 * Sitemap Taxonomies HTML
	 *
	 * @since  0.0.1
	 * @access private
	 */
	private function sitemap_html_taxonomies( $taxonomy, $hierarchical, $max_depth, $item_settings, $query_args ) {
		$query_args['hide_empty']       = 'yes' === $item_settings['sitemap_hide_empty'];
		$query_args['show_option_none'] = '';
		$query_args['taxonomy']         = $taxonomy;
		$query_args['title_li']         = '';
		$query_args['echo']             = false;
		$query_args['depth']            = $max_depth;
		$query_args['hierarchical']     = $hierarchical;
		$query_args['orderby']          = $item_settings['sitemap_orderby_taxonomy'];

		$taxonomy_list = wp_list_categories( $query_args );
		$taxonomy_list = $this->add_sitemap_item_classes( 'item' . $taxonomy, $taxonomy_list );

		return $taxonomy_list;
	}

	/**
	 * Post Type Query
	 *
	 * @param string $post_type
	 * @param array  $query_args
	 *
	 * @since  0.0.1
	 * @access private
	 * @return \WP_Query
	 */
	private function query_by_post_type( $post_type, $query_args ) {
		$args = [
			'posts_per_page'         => - 1,
			'update_post_meta_cache' => false,
			'post_type'              => $post_type,
			'filter'                 => 'ids',
			'post_status'            => 'publish',
		];

		$args = array_merge( $query_args, $args );

		$query = new \WP_Query( $args );

		return $query;
	}

	/**
	 * Post Types HTML
	 *
	 * @param string $post_type
	 * @param bool   $hierarchical
	 * @param int    $depth
	 * @param array  $query_args
	 *
	 * @since  0.0.1
	 * @access private
	 * @return string
	 */
	private function sitemap_html_post_types( $post_type, $hierarchical, $depth, $query_args ) {
		$html = '';

		$query_result = $this->query_by_post_type( $post_type, $query_args );

		if ( empty( $query_result ) ) {
			return '';
		}

		if ( $query_result->have_posts() ) {
			if ( ! $hierarchical ) {
				$depth = - 1;
			}
			$walker            = new \Walker_Page();
			$walker->tree_type = $post_type;
			$walker_str        = $walker->walk( $query_result->posts, $depth );
			$html              .= $this->add_sitemap_item_classes( 'item' . $post_type, $walker_str );
		}

		return $html;
	}

	/**
	 * Sitemap Item Classes
	 *
	 * @since  0.0.1
	 * @access private
	 */
	private function add_sitemap_item_classes( $element, $str ) {
		$element_str = $this->get_render_attribute_string( $element );
		/**  remove trailing " */
		$element_str = substr_replace( $element_str, ' ', - 1, 1 );
		$source      = [
			'class="',
		];
		$replace     = [
			$element_str,
		];

		if ( 'yes' === $this->get_settings_for_display( 'sitemap_add_nofollow' ) ) {
			$source[]  = 'href=';
			$replace[] = 'rel="nofollow" href=';
		}

		return str_replace( $source, $replace, $str );
	}

	/**
	 * Sitemap Tab
	 *
	 * @since  0.0.1
	 * @access private
	 */
	private function register_sitemap_tab() {
		$this->start_controls_section(
			'sitemap_section',
			[
				'label' => __( 'Sitemap', 'tci-uet' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->register_post_type_controls();

		$this->add_control(
			'sitemap_layout_divider',
			[
				'type' => Controls_Manager::DIVIDER,
			]
		);

		$this->register_layout_controls();

		$this->end_controls_section();

		$this->register_additional_settings_section();
	}

	/**
	 * Additional controls
	 *
	 * @since  0.0.1
	 * @access private
	 */
	private function register_additional_settings_section() {
		$this->start_controls_section(
			'sitemap_query_section',
			[
				'label' => __( 'Additional Options', 'tci-uet' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'sitemap_exclude',
			[
				'label'       => __( 'Exclude', 'tci-uet' ),
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'options'     => [
					'current_post'     => __( 'Current Post', 'tci-uet' ),
					'manual_selection' => __( 'Manual Selection', 'tci-uet' ),
				],
				'label_block' => true,
			]
		);

		$this->add_control(
			'sitemap_exclude_ids',
			[
				'label'       => __( 'Search & Select', 'tci-uet' ),
				'type'        => TCI_UET_Query_Control::QUERY_CONTROL_ID,
				'post_type'   => '',
				'options'     => [],
				'label_block' => true,
				'multiple'    => true,
				'filter_type' => 'by_id',
				'condition'   => [
					'sitemap_exclude' => 'manual_selection',
				],
			]
		);

		$this->add_control(
			'sitemap_password_protected',
			[
				'label'     => __( 'Protected Posts', 'tci-uet' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'tci-uet' ),
				'label_on'  => __( 'Show', 'tci-uet' ),
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Layout controls
	 *
	 * @since  0.0.1
	 * @access private
	 */
	private function register_layout_controls() {
		$this->add_responsive_control(
			'sitemap_columns',
			[
				'label'          => __( 'Columns', 'tci-uet' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '4',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options'        => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				],
				'selectors'      => [
					'{{WRAPPER}} .elementor-sitemap-section' => 'flex-basis: calc( 1 / {{VALUE}} * 100% );',
				],
			]
		);

		$this->add_control(
			'sitemap_title_tag',
			[
				'label'   => __( 'Title HTML Tag', 'tci-uet' ),
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
				'default' => 'h2',
			]
		);

		$this->add_control(
			'sitemap_add_nofollow',
			[
				'label' => __( 'Add nofollow', 'tci-uet' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);
	}

	/**
	 * Tab controls
	 *
	 * @since  0.0.1
	 * @access private
	 */
	private function register_post_type_controls() {
		$supported_taxonomies = [];

		$public_types = TCI_UET_Utils::get_public_post_types();

		foreach ( $public_types as $type => $title ) {
			$taxonomies = get_object_taxonomies( $type, 'objects' );
			foreach ( $taxonomies as $key => $tax ) {
				if ( ! in_array( $tax->name, $supported_taxonomies ) ) {
					$label                              = $tax->label . ' (' . $tax->name . ')';
					$supported_taxonomies[ $tax->name ] = $label;
				}
			}
		}

		$repeater = new Repeater();

		$repeater->add_control(
			'sitemap_type_selector',
			[
				'label'   => __( 'Type', 'tci-uet' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'post_type',
				'options' => [
					'post_type' => __( 'Post Type', 'tci-uet' ),
					'taxonomy'  => __( 'Taxonomy', 'tci-uet' ),
				],
			]
		);

		$repeater->add_control(
			'sitemap_source_post_type',
			[
				'label'     => __( 'Source', 'tci-uet' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'page',
				'options'   => $public_types,
				'condition' => [
					'sitemap_type_selector' => 'post_type',
				],
			]
		);

		$repeater->add_control(
			'sitemap_source_taxonomy',
			[
				'label'     => __( 'Source', 'tci-uet' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'category',
				'options'   => $supported_taxonomies,
				'condition' => [
					'sitemap_type_selector' => 'taxonomy',
				],
			]
		);

		$repeater->add_control(
			'sitemap_title',
			[
				'label' => __( 'Title', 'tci-uet' ),
				'type'  => Controls_Manager::TEXT,
			]
		);

		$repeater->add_control(
			'sitemap_orderby_post_type',
			[
				'label'     => __( 'Order By', 'tci-uet' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'post_date',
				'options'   => [
					'post_date'  => __( 'Date', 'tci-uet' ),
					'post_title' => __( 'Title', 'tci-uet' ),
					'menu_order' => __( 'Menu Order', 'tci-uet' ),
					'rand'       => __( 'Random', 'tci-uet' ),
				],
				'condition' => [
					'sitemap_type_selector' => 'post_type',
				],
			]
		);

		$repeater->add_control(
			'sitemap_orderby_taxonomy',
			[
				'label'     => __( 'Order By', 'tci-uet' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'name',
				'options'   => [
					'id'   => __( 'ID', 'tci-uet' ),
					'name' => __( 'Name', 'tci-uet' ),
				],
				'condition' => [
					'sitemap_type_selector' => 'taxonomy',
				],
			]
		);

		$repeater->add_control(
			'sitemap_order',
			[
				'label'   => __( 'Order', 'tci-uet' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'desc',
				'options' => [
					'asc'  => __( 'ASC', 'tci-uet' ),
					'desc' => __( 'DESC', 'tci-uet' ),
				],
			]
		);

		$repeater->add_control(
			'sitemap_hide_empty',
			[
				'label'     => __( 'Hide Empty', 'tci-uet' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'condition' => [
					'sitemap_type_selector' => 'taxonomy',
				],
			]
		);

		$repeater->add_control(
			'sitemap_hierarchical',
			[
				'label'   => __( 'Hierarchical View', 'tci-uet' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
			]
		);

		$repeater->add_control(
			'sitemap_depth',
			[
				'label'     => __( 'Depth', 'tci-uet' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '0',
				'options'   => [
					'0' => __( 'All', 'tci-uet' ),
					'1' => 1,
					'2' => 2,
					'3' => 3,
					'4' => 4,
					'5' => 5,
					'6' => 6,
				],
				'condition' => [
					'sitemap_hierarchical' => 'yes',
				],
			]
		);

		$this->add_control(
			'sitemap_items',
			[
				'label'       => '',
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'sitemap_type_selector'    => 'post_type',
						'sitemap_title'            => __( 'Pages', 'tci-uet' ),
						'sitemap_source_post_type' => 'page',
					],
					[
						'sitemap_type_selector'   => 'taxonomy',
						'sitemap_title'           => __( 'Categories', 'tci-uet' ),
						'sitemap_source_taxonomy' => 'category',
					],
				],
				'title_field' => '{{{ sitemap_title }}}',
			]
		);
	}

	/**
	 * Tab style
	 *
	 * @since  0.0.1
	 * @access private
	 */
	private function register_style_tab() {
		$this->start_controls_section(
			'section_sitemap_style',
			[
				'label' => __( 'List', 'tci-uet' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'sitemap_list_indent',
			[
				'label'     => __( 'Indent', 'tci-uet' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'body:not(.rtl) {{WRAPPER}} .elementor-sitemap-section ul' => 'margin-left: {{SIZE}}{{UNIT}};',
					'body.rtl {{WRAPPER}} .elementor-sitemap-section ul'       => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'sitemap_section_padding',
			[
				'label'      => __( 'Padding', 'tci-uet' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .elementor-sitemap-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'sitemap_title_style',
			[
				'label'     => __( 'Title', 'tci-uet' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'sitemap_title_color',
			[
				'label'     => __( 'Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-sitemap-title' => 'color: {{VALUE}};',
				],
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'sitemap_title_typography',
				'selector' => '{{WRAPPER}} .elementor-sitemap-title',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
			]
		);

		$this->add_control(
			'sitemap_list_style',
			[
				'label'     => __( 'List Item', 'tci-uet' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'sitemap_list_item_color',
			[
				'label'     => __( 'Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-sitemap-item, {{WRAPPER}} span.elementor-sitemap-list, {{WRAPPER}} .elementor-sitemap-item a' => 'color: {{VALUE}};',
				],
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'sitemap_list_item_typography',
				'selector' => '{{WRAPPER}} .elementor-sitemap-item, {{WRAPPER}} span.elementor-sitemap-list, {{WRAPPER}} .elementor-sitemap-item a',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
			]
		);

		$this->add_control(
			'sitemap_bullet_style',
			[
				'label'     => __( 'Bullet', 'tci-uet' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'sitemap_bullet_color',
			[
				'label'     => __( 'Color', 'tci-uet' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-sitemap-item' => 'color: {{VALUE}};',
				],
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
			]
		);

		$this->add_control(
			'sitemap_list_item_bullet_style',
			[
				'label'       => __( 'Style', 'tci-uet' ),
				'type'        => Controls_Manager::CHOOSE,
				'default'     => 'disc',
				'label_block' => true,
				'options'     => [
					'disc'   => [
						'title' => __( 'Disc', 'tci-uet' ),
						'icon'  => 'fa fa-circle',
					],
					'circle' => [
						'title' => __( 'Circle', 'tci-uet' ),
						'icon'  => 'fa fa-circle-o',
					],
					'square' => [
						'title' => __( 'Square', 'tci-uet' ),
						'icon'  => 'fa fa-square',
					],
					'none'   => [
						'title' => __( 'None', 'tci-uet' ),
						'icon'  => 'fa fa-ban',
					],
				],
				'selectors'   => [
					'{{WRAPPER}} .elementor-sitemap-list, {{WRAPPER}} .elementor-sitemap-list .children' => 'list-style-type: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}
}


