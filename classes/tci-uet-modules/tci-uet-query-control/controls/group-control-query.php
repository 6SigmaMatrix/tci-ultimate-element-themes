<?php
namespace TCI_UET\TCI_Module\Controls;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Base;
use TCI_UET\Classes\TCI_Utils;
use TCI_UET\TCI_Module\Module as Query_Module;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Group_Control_Query extends Group_Control_Base {

	protected static $presets;
	protected static $fields;

	public static function get_type() {
		return 'query-group';
	}

	protected function init_args( $args ) {
		parent::init_args( $args );
		$args           = $this->get_args();
		static::$fields = $this->init_fields_by_name( $args['name'] );
	}

	protected function init_fields() {
		$args = $this->get_args();

		return $this->init_fields_by_name( $args['name'] );
	}

	/**
	 * Build the group-controls array
	 * Note: this method completely overrides any settings done in Group_Control_Posts
	 *
	 * @param string $name
	 *
	 * @return array
	 */
	protected function init_fields_by_name( $name ) {
		$fields = [];

		$fields['post_type'] = [
			'label'   => __( 'Source', 'tci-uet' ),
			'type'    => Controls_Manager::SELECT,
			'options' => [
				'by_id'         => __( 'Manual Selection', 'tci-uet' ),
				'current_query' => __( 'Current Query', 'tci-uet' ),
			],
		];

		$fields['query_args'] = [
			'type' => Controls_Manager::TABS,
		];

		$tabs_wrapper    = $name . '_query_args';
		$include_wrapper = $name . '_query_include';
		$exclude_wrapper = $name . '_query_exclude';

		$fields['query_include'] = [
			'type'         => Controls_Manager::TAB,
			'label'        => __( 'Include', 'tci-uet' ),
			'tabs_wrapper' => $tabs_wrapper,
			'condition'    => [
				'post_type!' => [
					'current_query',
					'by_id',
				],
			],
		];

		$fields['posts_ids'] = [
			'label'        => __( 'Search & Select', 'tci-uet' ),
			'type'         => Query_Module::QUERY_CONTROL_ID,
			'post_type'    => '',
			'options'      => [],
			'label_block'  => true,
			'multiple'     => true,
			'filter_type'  => 'by_id',
			'condition'    => [
				'post_type' => 'by_id',
			],
			'tabs_wrapper' => $tabs_wrapper,
			'inner_tab'    => $include_wrapper,
			'export'       => false,
		];

		$fields['include'] = [
			'label'        => __( 'Include By', 'tci-uet' ),
			'type'         => Controls_Manager::SELECT2,
			'multiple'     => true,
			'options'      => [
				'terms'   => __( 'Term', 'tci-uet' ),
				'authors' => __( 'Author', 'tci-uet' ),
			],
			'condition'    => [
				'post_type!' => [
					'by_id',
					'current_query',
				],
			],
			'label_block'  => true,
			'tabs_wrapper' => $tabs_wrapper,
			'inner_tab'    => $include_wrapper,
		];

		$fields['include_term_ids'] = [
			'label'        => __( 'Term', 'tci-uet' ),
			'type'         => Query_Module::QUERY_CONTROL_ID,
			'post_type'    => '',
			'options'      => [],
			'label_block'  => true,
			'multiple'     => true,
			'filter_type'  => 'taxonomy',
			'include_type' => true,
			'condition'    => [
				'include'    => 'terms',
				'post_type!' => [
					'by_id',
					'current_query',
				],
			],
			'tabs_wrapper' => $tabs_wrapper,
			'inner_tab'    => $include_wrapper,
		];

		$fields['include_authors'] = [
			'label'        => __( 'Author', 'tci-uet' ),
			'label_block'  => true,
			'type'         => Query_Module::QUERY_CONTROL_ID,
			'multiple'     => true,
			'default'      => [],
			'options'      => [],
			'filter_type'  => 'author',
			'condition'    => [
				'include'    => 'authors',
				'post_type!' => [
					'by_id',
					'current_query',
				],
			],
			'tabs_wrapper' => $tabs_wrapper,
			'inner_tab'    => $include_wrapper,
			'export'       => false,
		];

		$fields['query_exclude'] = [
			'type'         => Controls_Manager::TAB,
			'label'        => __( 'Exclude', 'tci-uet' ),
			'tabs_wrapper' => $tabs_wrapper,
			'condition'    => [
				'post_type!' => [
					'by_id',
					'current_query',
				],
			],
		];

		$fields['exclude'] = [
			'label'        => __( 'Exclude By', 'tci-uet' ),
			'type'         => Controls_Manager::SELECT2,
			'multiple'     => true,
			'options'      => [
				'current_post'     => __( 'Current Post', 'tci-uet' ),
				'manual_selection' => __( 'Manual Selection', 'tci-uet' ),
				'terms'            => __( 'Term', 'tci-uet' ),
				'authors'          => __( 'Author', 'tci-uet' ),
			],
			'condition'    => [
				'post_type!' => [
					'by_id',
					'current_query',
				],
			],
			'label_block'  => true,
			'tabs_wrapper' => $tabs_wrapper,
			'inner_tab'    => $exclude_wrapper,
		];

		$fields['exclude_ids'] = [
			'label'        => __( 'Search & Select', 'tci-uet' ),
			'type'         => Query_Module::QUERY_CONTROL_ID,
			'post_type'    => '',
			'options'      => [],
			'label_block'  => true,
			'multiple'     => true,
			'filter_type'  => 'by_id',
			'condition'    => [
				'exclude'    => 'manual_selection',
				'post_type!' => [
					'by_id',
					'current_query',
				],
			],
			'tabs_wrapper' => $tabs_wrapper,
			'inner_tab'    => $exclude_wrapper,
			'export'       => false,
		];

		$fields['exclude_term_ids'] = [
			'label'        => __( 'Term', 'tci-uet' ),
			'type'         => Query_Module::QUERY_CONTROL_ID,
			'post_type'    => '',
			'options'      => [],
			'label_block'  => true,
			'multiple'     => true,
			'filter_type'  => 'taxonomy',
			'include_type' => true,
			'condition'    => [
				'exclude'    => 'terms',
				'post_type!' => [
					'by_id',
					'current_query',
				],
			],
			'tabs_wrapper' => $tabs_wrapper,
			'inner_tab'    => $exclude_wrapper,
			'export'       => false,
		];

		$fields['exclude_authors'] = [
			'label'        => __( 'Author', 'tci-uet' ),
			'type'         => Query_Module::QUERY_CONTROL_ID,
			'post_type'    => '',
			'options'      => [],
			'label_block'  => true,
			'multiple'     => true,
			'filter_type'  => 'author',
			'include_type' => true,
			'condition'    => [
				'exclude'    => 'authors',
				'post_type!' => [
					'by_id',
					'current_query',
				],
			],
			'tabs_wrapper' => $tabs_wrapper,
			'inner_tab'    => $exclude_wrapper,
			'export'       => false,
		];

		$fields['avoid_duplicates'] = [
			'label'        => __( 'Avoid Duplicates', 'tci-uet' ),
			'type'         => Controls_Manager::SWITCHER,
			'default'      => '',
			'description'  => __( 'Set to Yes to avoid duplicate posts from showing up. This only effects the frontend.', 'tci-uet' ),
			'tabs_wrapper' => $tabs_wrapper,
			'inner_tab'    => $exclude_wrapper,
			'condition'    => [
				'post_type!' => [
					'by_id',
					'current_query',
				],
			],
		];

		$fields['offset'] = [
			'label'        => __( 'Offset', 'tci-uet' ),
			'type'         => Controls_Manager::NUMBER,
			'default'      => 0,
			'condition'    => [
				'post_type!' => [
					'by_id',
					'current_query',
				],
			],
			'description'  => __( 'Use this setting to skip over posts (e.g. \'2\' to skip over 2 posts).', 'tci-uet' ),
			'tabs_wrapper' => $tabs_wrapper,
			'inner_tab'    => $exclude_wrapper,
		];

		$fields['select_date'] = [
			'label'        => __( 'Date', 'tci-uet' ),
			'type'         => Controls_Manager::SELECT,
			'post_type'    => '',
			'options'      => [
				'anytime' => __( 'All', 'tci-uet' ),
				'today'   => __( 'Past Day', 'tci-uet' ),
				'week'    => __( 'Past Week', 'tci-uet' ),
				'month'   => __( 'Past Month', 'tci-uet' ),
				'quarter' => __( 'Past Quarter', 'tci-uet' ),
				'year'    => __( 'Past Year', 'tci-uet' ),
				'exact'   => __( 'Custom', 'tci-uet' ),
			],
			'default'      => 'anytime',
			'label_block'  => false,
			'multiple'     => false,
			'filter_type'  => 'date',
			'include_type' => true,
			'condition'    => [
				'post_type!' => [
					'by_id',
					'current_query',
				],
			],
			'separator'    => 'before',
		];

		$fields['date_before'] = [
			'label'        => __( 'Before', 'tci-uet' ),
			'type'         => Controls_Manager::DATE_TIME,
			'post_type'    => '',
			'label_block'  => false,
			'multiple'     => false,
			'filter_type'  => 'date',
			'include_type' => true,
			'placeholder'  => __( 'Choose', 'tci-uet' ),
			'condition'    => [
				'select_date' => 'exact',
				'post_type!'  => [
					'by_id',
					'current_query',
				],
			],
		];

		$fields['date_after'] = [
			'label'        => __( 'After', 'tci-uet' ),
			'type'         => Controls_Manager::DATE_TIME,
			'post_type'    => '',
			'label_block'  => false,
			'multiple'     => false,
			'filter_type'  => 'date',
			'include_type' => true,
			'placeholder'  => __( 'Choose', 'tci-uet' ),
			'condition'    => [
				'select_date' => 'exact',
				'post_type!'  => [
					'by_id',
					'current_query',
				],
			],
			'description'  => __( 'Before & After dates are inclusive', 'tci-uet' ),
		];

		$fields['orderby'] = [
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
				'post_type!' => 'current_query',
			],
		];

		$fields['order'] = [
			'label'     => __( 'Order', 'tci-uet' ),
			'type'      => Controls_Manager::SELECT,
			'default'   => 'desc',
			'options'   => [
				'asc'  => __( 'ASC', 'tci-uet' ),
				'desc' => __( 'DESC', 'tci-uet' ),
			],
			'condition' => [
				'post_type!' => 'current_query',
			],
		];

		$fields['posts_per_page'] = [
			'label'     => __( 'Posts Per Page', 'tci-uet' ),
			'type'      => Controls_Manager::NUMBER,
			'default'   => 3,
			'condition' => [
				'post_type!' => 'current_query',
			],
		];

		$fields['ignore_sticky_posts'] = [
			'label'       => __( 'Ignore Sticky Posts', 'tci-uet' ),
			'type'        => Controls_Manager::SWITCHER,
			'default'     => 'yes',
			'condition'   => [
				'post_type' => 'post',
			],
			'description' => __( 'Sticky-posts ordering is visible on frontend only', 'tci-uet' ),
		];

		$fields['query_id'] = [
			'label'       => __( 'Query ID', 'tci-uet' ),
			'type'        => Controls_Manager::TEXT,
			'default'     => '',
			'description' => __( 'Give your Query a custom unique id to allow server side filtering', 'tci-uet' ),
			'separator'   => 'before',
		];

		static::init_presets();

		return $fields;
	}

	/**
	 * Presets: filter controls subsets to be be used by the specific Group_Control_Query instance.
	 * Possible values:
	 * 'full' : (default) all presets
	 * 'include' : the 'include' tab - by id, by taxonomy, by author
	 * 'exclude': the 'exclude' tab - by id, by taxonomy, by author
	 * 'advanced_exclude': extend the 'exclude' preset with 'avoid-duplicates' & 'offset'
	 * 'date': date query controls
	 * 'pagination': posts per-page
	 * 'order': sort & ordering controls
	 * 'query_id': allow saving a specific query for future usage.
	 * Usage:
	 * full: build a Group_Controls_Query with all possible controls,
	 * when 'full' is passed, the Group_Controls_Query will ignore all other preset values.
	 * $this->add_group_control(
	 * Group_Control_Query::get_type(),
	 * [
	 * ...
	 * 'presets' => [ 'full' ],
	 *  ...
	 *  ] );
	 * Subset: build a Group_Controls_Query with subset of the controls,
	 * in the following example, the Query controls will set only the 'include' & 'date' query args.
	 * $this->add_group_control(
	 * Group_Control_Query::get_type(),
	 * [
	 * ...
	 * 'presets' => [ 'include', 'date' ],
	 *  ...
	 *  ] );
	 */
	protected static function init_presets() {

		$tabs = [
			'query_args',
			'query_include',
			'query_exclude',
		];

		static::$presets['include'] = array_merge( $tabs, [
			'include',
			'include_ids',
			'include_term_ids',
			'include_authors',
		] );

		static::$presets['exclude'] = array_merge( $tabs, [
			'exclude',
			'exclude_ids',
			'exclude_term_ids',
			'exclude_authors',
		] );

		static::$presets['advanced_exclude'] = array_merge( static::$presets['exclude'], [
			'avoid_duplicates',
			'offset',
		] );

		static::$presets['date'] = [
			'select_date',
			'date_before',
			'date_after',
		];

		static::$presets['pagination'] = [
			'posts_per_page',
			'ignore_sticky_posts',
		];

		static::$presets['order'] = [
			'orderby',
			'order',
		];

		static::$presets['query_id'] = [
			'query_id',
		];
	}

	private function filter_by_presets( $presets, $fields ) {

		if ( in_array( 'full', $presets, true ) ) {
			return $fields;
		}

		$control_ids = [];
		foreach ( static::$presets as $key => $preset ) {
			$control_ids = array_merge( $control_ids, $preset );
		}

		foreach ( $presets as $preset ) {
			if ( array_key_exists( $preset, static::$presets ) ) {
				$control_ids = array_diff( $control_ids, static::$presets[ $preset ] );
			}
		}

		foreach ( $control_ids as $remove ) {
			unset( $fields[ $remove ] );
		}

		return $fields;

	}

	protected function prepare_fields( $fields ) {

		$args = $this->get_args();

		if ( ! empty( $args['presets'] ) ) {
			$fields = $this->filter_by_presets( $args['presets'], $fields );
		}

		$post_type_args = [];
		if ( ! empty( $args['post_type'] ) ) {
			$post_type_args['post_type'] = $args['post_type'];
		}

		$post_types = TCI_Utils::get_public_post_types( $post_type_args );

		$fields['post_type']['options']     = array_merge( $post_types, $fields['post_type']['options'] );
		$fields['post_type']['default']     = key( $post_types );
		$fields['posts_ids']['object_type'] = array_keys( $post_types );

		//skip parent, go directly to grandparent
		return Group_Control_Base::prepare_fields( $fields );
	}

	protected function get_child_default_args() {
		$args            = parent::get_child_default_args();
		$args['presets'] = [ 'full' ];

		return $args;
	}

	protected function get_default_options() {
		return [
			'popover' => false,
		];
	}
}
