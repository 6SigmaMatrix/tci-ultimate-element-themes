<?php
namespace TCI_UET\TCI_UET_Modules;

tci_uet_exit();

use Elementor\Controls_Manager;
use Elementor\Core\Common\Modules\Ajax\Module as Ajax;
use Elementor\Widget_Base;
use TCI_UET\TCI_Module\Controls\Group_Control_Posts;
use TCI_UET\TCI_Module\Controls\Group_Control_Query;
use TCI_UET\TCI_Module\Controls\Group_Control_Related;
use TCI_UET\Classes\Elementor_Post_Query;
use TCI_UET\Classes\Elementor_Related_Query;
use TCI_UET\TCI_Module\Controls\Query;
use Elementor\Plugin;
use TCI_UET\TCI_UET_Modules;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class TCI_UET_Query_Control extends TCI_UET_Modules {

	const QUERY_CONTROL_ID = 'query';

	public static $displayed_ids = [];

	public function __construct() {
		$this->add_actions();
	}

	public static function add_to_avoid_list( $ids ) {
		self::$displayed_ids = array_merge( self::$displayed_ids, $ids );
	}

	public static function get_avoid_list_ids() {
		return self::$displayed_ids;
	}

	/**
	 * @deprecated use Group_Control_Query capabilities
	 *
	 * @param Widget_Base $widget
	 */
	public static function add_exclude_controls( $widget ) {
		// _deprecated_function( __METHOD__, '2.5.0', 'class Group_Control_Query' );

		$widget->add_control(
			'exclude',
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

		$widget->add_control(
			'exclude_ids',
			[
				'label'       => __( 'Search & Select', 'tci-uet' ),
				'type'        => self::QUERY_CONTROL_ID,
				'post_type'   => '',
				'options'     => [],
				'label_block' => true,
				'multiple'    => true,
				'filter_type' => 'by_id',
				'condition'   => [
					'exclude' => 'manual_selection',
				],
			]
		);

		$widget->add_control(
			'avoid_duplicates',
			[
				'label'       => __( 'Avoid Duplicates', 'tci-uet' ),
				'type'        => Controls_Manager::SWITCHER,
				'default'     => '',
				'description' => __( 'Set to Yes to avoid duplicate posts from showing up on the page. This only affects the frontend.', 'tci-uet' ),
			]
		);

	}

	public function get_name() {
		return 'query-control';
	}

	/**
	 * @param array $data
	 *
	 * @return array
	 * @throws \Exception
	 */
	public function ajax_posts_filter_autocomplete( array $data ) {
		if ( empty( $data['filter_type'] ) || empty( $data['q'] ) ) {
			throw new \Exception( 'Bad Request' );
		}

		$results = [];

		switch ( $data['filter_type'] ) {
			case 'taxonomy':
				$query_params = [
					'taxonomy'   => $this->extract_post_type( $data ),
					'search'     => $data['q'],
					'hide_empty' => false,
				];

				$terms = get_terms( $query_params );

				global $wp_taxonomies;

				foreach ( $terms as $term ) {
					$term_name = $this->get_term_name_with_parents( $term );
					if ( ! empty( $data['include_type'] ) ) {
						$text = $wp_taxonomies[ $term->taxonomy ]->labels->name . ': ' . $term_name;
					} else {
						$text = $term_name;
					}

					$results[] = [
						'id'   => $term->term_taxonomy_id,
						'text' => $text,
					];
				}

				break;

			case 'by_id':
			case 'post':
				$query_params = [
					'post_type'      => $this->extract_post_type( $data ),
					's'              => $data['q'],
					'posts_per_page' => - 1,
				];

				if ( 'attachment' === $query_params['post_type'] ) {
					$query_params['post_status'] = 'inherit';
				}

				$query = new \WP_Query( $query_params );

				foreach ( $query->posts as $post ) {
					$post_type_obj = get_post_type_object( $post->post_type );
					if ( ! empty( $data['include_type'] ) ) {
						$text = $post_type_obj->labels->name . ': ' . $post->post_title;
					} else {
						$text = ( $post_type_obj->hierarchical ) ? $this->get_post_name_with_parents( $post ) : $post->post_title;
					}

					$results[] = [
						'id'   => $post->ID,
						'text' => $text,
					];
				}
				break;

			case 'post_type_keys':
				$results = tci_uet_get_post_type_meta_key( '%' . $data['q'] . '%' );
				break;

			case 'author':
				$query_params = [
					'who'                 => 'authors',
					'has_published_posts' => true,
					'fields'              => [
						'ID',
						'display_name',
					],
					'search'              => '*' . $data['q'] . '*',
					'search_columns'      => [
						'user_login',
						'user_nicename',
					],
				];

				$user_query = new \WP_User_Query( $query_params );

				foreach ( $user_query->get_results() as $author ) {
					$results[] = [
						'id'   => $author->ID,
						'text' => $author->display_name,
					];
				}
				break;
			default:
				$results = apply_filters( 'elementor/query_control/get_autocomplete/' . $data['filter_type'], [], $data );
		}

		return [
			'results' => $results,
		];
	}

	public function ajax_posts_control_value_titles( $request ) {
		$ids = (array) $request['id'];

		$results = [];

		switch ( $request['filter_type'] ) {
			case 'taxonomy':
				$terms = get_terms(
					[
						'term_taxonomy_id' => $ids,
						'hide_empty'       => false,
					]
				);

				global $wp_taxonomies;
				foreach ( $terms as $term ) {
					$term_name = $this->get_term_name_with_parents( $term );
					if ( ! empty( $request['include_type'] ) ) {
						$text = $wp_taxonomies[ $term->taxonomy ]->labels->name . ': ' . $term_name;
					} else {
						$text = $term_name;
					}
					$results[ $term->term_taxonomy_id ] = $text;
				}
				break;

			case 'by_id':
			case 'post':
				$query = new \WP_Query(
					[
						'post_type'      => 'any',
						'post__in'       => $ids,
						'posts_per_page' => - 1,
					]
				);

				foreach ( $query->posts as $post ) {
					$results[ $post->ID ] = $post->post_title;
				}
				break;

			case 'author':
				$query_params = [
					'who'                 => 'authors',
					'has_published_posts' => true,
					'fields'              => [
						'ID',
						'display_name',
					],
					'include'             => $ids,
				];

				$user_query = new \WP_User_Query( $query_params );

				foreach ( $user_query->get_results() as $author ) {
					$results[ $author->ID ] = $author->display_name;
				}
				break;
			default:
				$results = apply_filters( 'elementor_pro/query_control/get_value_titles/' . $request['filter_type'], [], $request );
		}

		return $results;
	}

	public function register_controls() {
		$controls_manager = Plugin::instance()->controls_manager;


		include tci_uet_root( 'classes/tci-uet-modules/tci-uet-query-control/controls/group-control-posts.php' );
		$controls_manager->add_group_control( Group_Control_Posts::get_type(), new Group_Control_Posts() );

		include tci_uet_root( 'classes/tci-uet-modules/tci-uet-query-control/controls/group-control-query.php' );
		$controls_manager->add_group_control( Group_Control_Query::get_type(), new Group_Control_Query() );

		include tci_uet_root( 'classes/tci-uet-modules/tci-uet-query-control/controls/group-control-related.php' );
		$controls_manager->add_group_control( Group_Control_Related::get_type(), new Group_Control_Related() );

		include tci_uet_root( 'classes/tci-uet-modules/tci-uet-query-control/controls/query.php' );
		$controls_manager->register_control( self::QUERY_CONTROL_ID, new Query() );
	}

	private function extract_post_type( $data ) {

		if ( ! empty( $data['query'] ) && ! empty( $data['query']['post_type'] ) ) {
			return $data['query']['post_type'];
		}

		return $data['object_type'];
	}

	/**
	 * get_term_name_with_parents
	 *
	 * @param \WP_Term $term
	 * @param int      $max
	 *
	 * @return string
	 */
	private function get_term_name_with_parents( \WP_Term $term, $max = 3 ) {
		if ( 0 === $term->parent ) {
			return $term->name;
		}
		$separator = is_rtl() ? ' < ' : ' > ';
		$test_term = $term;
		$names     = [];
		while ( $test_term->parent > 0 ) {
			$test_term = get_term_by( 'term_taxonomy_id', $test_term->parent );
			if ( ! $test_term ) {
				break;
			}
			$names[] = $test_term->name;
		}

		$names = array_reverse( $names );
		if ( count( $names ) < ( $max ) ) {
			return implode( $separator, $names ) . $separator . $term->name;
		}

		$name_string = '';
		for ( $i = 0; $i < ( $max - 1 ); $i ++ ) {
			$name_string .= $names[ $i ] . $separator;
		}

		return $name_string . '...' . $separator . $term->name;
	}

	/**
	 * get post name with parents
	 *
	 * @param \WP_Post $post
	 * @param int      $max
	 *
	 * @return string
	 */
	private function get_post_name_with_parents( $post, $max = 3 ) {
		if ( 0 === $post->post_parent ) {
			return $post->post_title;
		}
		$separator = is_rtl() ? ' < ' : ' > ';
		$test_post = $post;
		$names     = [];
		while ( $test_post->post_parent > 0 ) {
			$test_post = get_post( $test_post->post_parent );
			if ( ! $test_post ) {
				break;
			}
			$names[] = $test_post->post_title;
		}

		$names = array_reverse( $names );
		if ( count( $names ) < ( $max ) ) {
			return implode( $separator, $names ) . $separator . $post->post_title;
		}

		$name_string = '';
		for ( $i = 0; $i < ( $max - 1 ); $i ++ ) {
			$name_string .= $names[ $i ] . $separator;
		}

		return $name_string . '...' . $separator . $post->post_title;
	}

	/**
	 * @deprecated use Elementor_Post_Query capabilities
	 *
	 * @param string $control_id
	 * @param array  $settings
	 *
	 * @return array
	 */
	public function get_query_args( $control_id, $settings ) {
		// _deprecated_function( __METHOD__, '2.5.0', 'class Elementor_Post_Query' );

		$controls_manager = Plugin::instance()->controls_manager;

		/** @var Group_Control_Posts $posts_query */
		$posts_query = $controls_manager->get_control_groups( Group_Control_Posts::get_type() );

		return $posts_query->get_query_args( $control_id, $settings );
	}

	/**
	 * @param \ElementorPro\Base\Base_Widget $widget
	 * @param string                         $name
	 * @param array                          $query_args
	 * @param array                          $fallback_args
	 *
	 * @return \WP_Query
	 */
	public function get_query( $widget, $name, $query_args = [], $fallback_args = [] ) {
		$prefix    = $name . '_';
		$post_type = $widget->get_settings( $prefix . 'post_type' );
		if ( 'related' === $post_type ) {
			include tci_uet_root( 'classes/tci-uet-modules/tci-uet-query-control/classes/elementor-related-query.php' );
			$elementor_query = new Elementor_Related_Query( $widget, $name, $query_args, $fallback_args );
		} else {
			include tci_uet_root( 'classes/tci-uet-modules/tci-uet-query-control/classes/elementor-post-query.php' );
			$elementor_query = new Elementor_Post_Query( $widget, $name, $query_args );
		}

		return $elementor_query->get_query();
	}

	/**
	 * @deprecated 2.5.0
	 *
	 * @param \WP_Query &$query
	 */
	public function fix_query_offset( &$query ) {
		if ( ! empty( $query->query_vars['offset_to_fix'] ) ) {
			if ( $query->is_paged ) {
				$query->query_vars['offset'] = $query->query_vars['offset_to_fix'] + ( ( $query->query_vars['paged'] - 1 ) * $query->query_vars['posts_per_page'] );
			} else {
				$query->query_vars['offset'] = $query->query_vars['offset_to_fix'];
			}
		}
	}

	/**
	 * @deprecated 2.5.0
	 *
	 * @param int       $found_posts
	 * @param \WP_Query $query
	 *
	 * @return mixed
	 */
	public static function fix_query_found_posts( $found_posts, $query ) {
		$offset_to_fix = $query->get( 'offset_to_fix' );

		if ( $offset_to_fix ) {
			$found_posts -= $offset_to_fix;
		}

		return $found_posts;
	}

	/**
	 * @param Ajax $ajax_manager
	 */
	public function register_ajax_actions( $ajax_manager ) {
		$ajax_manager->register_ajax_action( 'query_control_value_titles', [
			$this,
			'ajax_posts_control_value_titles',
		] );
		$ajax_manager->register_ajax_action( 'panel_posts_control_filter_autocomplete', [
			$this,
			'ajax_posts_filter_autocomplete',
		] );
	}

	protected function add_actions() {
		add_action( 'elementor/ajax/register_actions', [ $this, 'register_ajax_actions' ] );
		add_action( 'elementor/controls/controls_registered', [ $this, 'register_controls' ] );

		/**
		 * @see https://codex.wordpress.org/Making_Custom_Queries_using_Offset_and_Pagination
		 */
		add_action( 'pre_get_posts', [ $this, 'fix_query_offset' ], 1 );
		add_filter( 'found_posts', [ $this, 'fix_query_found_posts' ], 1, 2 );
	}
}