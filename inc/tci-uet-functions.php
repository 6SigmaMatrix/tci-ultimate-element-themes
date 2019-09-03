<?php
/**
 * TCI UET Functions file
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.6
 */
tci_uet_exit();

use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Base;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Text_Shadow;

/**
 * Plugin directory security
 *
 * @since 0.0.5
 */
function tci_uet_exit() {
	if ( ! defined( 'ABSPATH' ) ) {
		exit; // Exit if accessed directly.
	}
}

/**
 * Get directory files list
 *
 * @since 0.0.5
 */
function tci_uet_dir_files_list( $path, $ext = '*.php' ) {
	return apply_filters( 'tci_uet_dir_files_list', glob( $path . $ext ) );
}

/**
 * Generate TCI UET Class Name
 *
 * @since 0.0.5
 */
function tci_uet_generate_class_name( $path ) {
	$class_name = pathinfo( $path );
	$class_name = explode( '-', $class_name['filename'] );
	$class_name = array_map( 'ucfirst', $class_name );
	unset( $class_name[0] );
	unset( $class_name[1] );
	unset( $class_name[2] );
	$class_name = array_merge( [ 'TCI', 'UET' ], $class_name );

	return apply_filters( 'tci_uet_generate_class_name', $class_name );
}

/**
 * TCI get value
 *
 * @since 0.0.5
 */
function tci_uet_get_have( $var, $key, $def = '' ) {

	if ( empty( $var ) && ! empty( $def ) ) {
		return $def;
	}
	if ( ! $var ) {
		return false;
	}
	if ( is_object( $var ) && ! empty( $var->$key ) ) {
		return $var->$key;
	}
	if ( is_array( $var ) && ! empty( $var[ $key ] ) ) {
		return $var[ $key ];
	} elseif ( $def ) {
		return $def;
	} else {
		return false;
	}
}

/**
 * TCI get array
 *
 * @since 0.0.5
 */
function tci_uet_array( $data = [] ) {
	return new \Arrayy\Arrayy( $data );
}

/**
 * TCI url control extract
 *
 * @since 0.0.5
 */
function tci_uet_url_control_extract( $data = [] ) {
	$data[0] = 'href="' . esc_url( $data[0] ) . '"';
	$data[1] = ( 'on' === $data[1] ) ? esc_attr( "target={$data[1]}" ) : '';
	$data[2] = ( 'on' === $data[2] ) ? esc_attr( 'rel=nofollow' ) : '';

	return apply_filters( 'tci_uet_url_control_extract', $data );
}

/**
 * TCI get post types
 *
 * @since 0.0.5
 */
function tci_uet_get_post_type_list() {
	return wp_list_pluck( get_post_types( [ 'publicly_queryable' => true ], 'object' ), 'label', 'name' );
}

/**
 * TCI get taxonomies list
 *
 * @since 0.0.5
 */
function tci_uet_get_taxonomies_list() {
	return wp_list_pluck( get_taxonomies( [ 'publicly_queryable' => true ], 'object' ), 'label', 'name' );
}

/**
 * TCI get user meta keys
 *
 * @since 0.0.5
 */
function tci_uet_get_user_meta_key() {
	return array_keys( get_user_meta( get_current_user_id() ) );
}

/**
 * TCI get user meta keys
 *
 * @since 0.0.5
 */
function tci_uet_get_post_type_meta_key( $query_s ) {
	global $wpdb;
	$query = $wpdb->get_results( $wpdb->prepare( "SELECT meta_key, post_id FROM {$wpdb->prefix}postmeta WHERE meta_key LIKE %s", [ $query_s ] ) );
	$key   = [];
	foreach ( $query as $keys ) {
		if ( '_' !== substr( $keys, 0, 1 ) ) {
			$key[] = [
				'id'   => tci_uet_get_have( $keys, 'meta_key' ) . ':' . tci_uet_get_have( $keys, 'post_id' ),
				'text' => 'Post ID (' . tci_uet_get_have( $keys, 'post_id' ) . ') : ' . tci_uet_get_have( $keys, 'meta_key' ),
			];
		}
	}

	return apply_filters( 'tci_uet_get_post_type_meta_key', $key );
}

/**
 * TCI get post
 *
 * @since 0.0.5
 */
function tci_uet_get_post_list( $post_type = 'post' ) {
	return wp_list_pluck( get_posts( [ 'post_type' => $post_type, 'numberposts' => - 1 ] ), 'post_title', 'ID' );
}

/**
 * TCI query post status
 *
 * @since 0.0.5
 */
function tci_uet_query_post_stats() {
	return apply_filters( 'tci_uet_query_post_stats', [
		'publish'    => __( 'Publish', 'tci-uet' ),
		// - a published post or page.
		'pending'    => __( 'Pending', 'tci-uet' ),
		// - post is pending review.
		'draft'      => __( 'Draft', 'tci-uet' ),
		// - a post in draft status.
		'auto-draft' => __( 'Auto Draft', 'tci-uet' ),
		// - a newly created post, with no content.
		'future'     => __( 'Future', 'tci-uet' ),
		// - a post to publish in the future.
		'private'    => __( 'Private', 'tci-uet' ),
		// - not visible to users who are not logged in.
		'inherit'    => __( 'Inherit', 'tci-uet' ),
		// - a revision. see get_children.
		'trash'      => __( 'Trash', 'tci-uet' )
		// - post is in trashbin (available with Version 2.9).
	] );
}


/**
 * TCI query post order
 *
 * @since 0.0.5
 */
function tci_uet_query_post_order() {
	return apply_filters( 'tci_uet_query_post_order', [
		'DESC' => __( 'Descending ', 'tci-uet' ),
		'ASC'  => __( 'Ascending ', 'tci-uet' ),
	] );
}

/**
 * TCI query post order by
 *
 * @since 0.0.5
 */
function tci_uet_query_post_orderby() {
	return apply_filters( 'tci_uet_query_post_orderby', [
		//(string) - Sort retrieved posts by parameter. Defaults to 'date'. One or more options can be passed. EX: 'orderby' => 'menu_order title'
		//Possible Values:
		'none'          => __( 'No Order', 'tci-uet' ),
		//'none' - No order (available with Version 2.8).
		'ID'            => __( 'Post ID', 'tci-uet' ),
		//'ID' - Order by post id. Note the captialization.
		'author'        => __( 'Post Author', 'tci-uet' ),
		//'author' - Order by author.
		'title'         => __( 'Post Title', 'tci-uet' ),
		//'title' - Order by title.
		'name'          => __( 'Post Name', 'tci-uet' ),
		//'name' - Order by post name (post slug).
		'date'          => __( 'Post Date', 'tci-uet' ),
		//'date' - Order by date.
		'modified'      => __( 'Post Modified Date', 'tci-uet' ),
		//'modified' - Order by last modified date.
		'parent'        => __( 'Post Parent ID', 'tci-uet' ),
		//'parent' - Order by post/page parent id.
		'rand'          => __( 'Random', 'tci-uet' ),
		//'rand' - Random order.
		'comment_count' => __( 'Post Comment Count', 'tci-uet' ),
		//'comment_count' - Order by number of comments (available with Version 2.9).
	] );
}


/**
 * TCI query controls
 *
 * @since 0.0.5
 */
function tci_uet_query_controls( $obj, $key_prefix = '' ) {
	$obj->add_control(
		$key_prefix . 'post_query_source',
		[
			'label'   => __( 'Post Type', 'tci-uet' ),
			'type'    => Controls_Manager::SELECT2,
			'options' => tci_uet_get_post_type_list(),
			'default' => 'post',
		]
	);

	$obj->add_control(
		$key_prefix . 'post_query_status',
		[
			'label'    => __( 'Post Status', 'tci-uet' ),
			'type'     => Controls_Manager::SELECT2,
			'multiple' => true,
			'options'  => tci_uet_query_post_stats(),
			'default'  => [ 'publish' ],
		]
	);

	$obj->add_control(
		$key_prefix . 'post_query_post_not_in',
		[
			'label'       => __( 'Exclude Post', 'tci-uet' ),
			'type'        => Controls_Manager::TEXT,
			'description' => __( 'Enter the post/page ID to stop loading those post/page. Note: IDs are comma separated.', 'tci-uet' ),
			'default'     => '',
		]
	);

	$obj->add_control(
		$key_prefix . 'post_query_number',
		[
			'label'   => __( 'Post Count', 'tci-uet' ),
			'type'    => Controls_Manager::NUMBER,
			'min'     => 1,
			'step'    => 1,
			'default' => 6,
		]
	);

	$obj->add_control(
		$key_prefix . 'post_query_offset_number',
		[
			'label'   => __( 'Post offset', 'tci-uet' ),
			'type'    => Controls_Manager::NUMBER,
			'min'     => 0,
			'step'    => 1,
			'default' => '',
		]
	);

	$obj->add_control(
		$key_prefix . 'post_query_orderby',
		[
			'label'   => __( 'Post Order By', 'tci-uet' ),
			'type'    => Controls_Manager::SELECT,
			'options' => tci_uet_query_post_orderby(),
			'default' => 'date',
		]
	);

	$obj->add_control(
		$key_prefix . 'post_query_order',
		[
			'label'   => __( 'Post Order', 'tci-uet' ),
			'type'    => Controls_Manager::SELECT,
			'options' => tci_uet_query_post_order(),
			'default' => 'DESC',
		]
	);

	$obj->add_control(
		$key_prefix . 'post_query_ignore_sticky',
		[
			'label'        => __( 'Igonore Stikcy posts', 'tci-uet' ),
			'type'         => Controls_Manager::SWITCHER,
			'return_value' => true,
			'default'      => '',
		]
	);

	$obj->add_control(
		$key_prefix . 'post_query_cache_results',
		[
			'label'        => __( 'Post Result Cache', 'tci-uet' ),
			'type'         => Controls_Manager::SWITCHER,
			'return_value' => true,
			'default'      => true,
		]
	);

	$obj->add_control(
		$key_prefix . 'post_query_update_post_term_cache',
		[
			'label'        => __( 'Post Term Cache', 'tci-uet' ),
			'type'         => Controls_Manager::SWITCHER,
			'return_value' => true,
			'default'      => true,
		]
	);

	$obj->add_control(
		$key_prefix . 'post_query_update_post_meta_cache',
		[
			'label'        => __( 'Post Meta Cache', 'tci-uet' ),
			'type'         => Controls_Manager::SWITCHER,
			'return_value' => true,
			'default'      => true,
		]
	);
}

/**
 * TCI column control
 *
 * @since 0.0.5
 */
function tci_uet_column_control( $obj, $key_prefix = '' ) {
	$obj->add_control(
		$key_prefix . 'post_column',
		[
			'label'   => __( 'Post Per Row', 'tci-uet' ),
			'type'    => Controls_Manager::SELECT,
			'options' => [
				'12' => __( '1', 'tci-uet' ),
				'6'  => __( '2', 'tci-uet' ),
				'4'  => __( '3', 'tci-uet' ),
				'3'  => __( '4', 'tci-uet' ),
			],
			'default' => '50',
		]
	);
}

/**
 * TCI controls query args
 *
 * @since 0.0.5
 */
function tci_uet_controls_query_args( $data, $prefix = '' ) {

	return apply_filters( 'tci_uet_controls_query_args', [
		'post_type'              => $data->get( $prefix . 'post_query_source' ),
		'offset'                 => $data->get( $prefix . 'post_query_offset_number' ),
		'post_status'            => $data->get( $prefix . 'post_query_status' )->getArray(),
		'showposts'              => $data->get( $prefix . 'post_query_number' ),
		'orderby'                => $data->get( $prefix . 'post_query_orderby' ),
		'order'                  => $data->get( $prefix . 'post_query_order' ),
		'ignore_sticky_posts'    => $data->get( $prefix . 'post_query_ignore_sticky' ),
		'cache_results'          => $data->get( $prefix . 'post_query_cache_results' ),
		'update_post_term_cache' => $data->get( $prefix . 'post_query_update_post_term_cache' ),
		'update_post_meta_cache' => $data->get( $prefix . 'post_query_update_post_meta_cache' ),
	] );
}

/**
 * TCI heading controls
 *
 * @since 0.0.5
 */
function tci_uet_heading_controls( $obj, $prefix = '' ) {
	$obj->add_control(
		$prefix . 'size',
		[
			'label'   => __( 'Size', 'tci-uet' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'default',
			'options' => [
				'default' => __( 'Default', 'tci-uet' ),
				'small'   => __( 'Small', 'tci-uet' ),
				'medium'  => __( 'Medium', 'tci-uet' ),
				'large'   => __( 'Large', 'tci-uet' ),
				'xl'      => __( 'XL', 'tci-uet' ),
				'xxl'     => __( 'XXL', 'tci-uet' ),
			],
		]
	);

	$obj->add_control(
		$prefix . 'header_size',
		[
			'label'   => __( 'HTML Tag', 'tci-uet' ),
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

	$obj->add_responsive_control(
		$prefix . 'align',
		[
			'label'     => __( 'Alignment', 'tci-uet' ),
			'type'      => Controls_Manager::CHOOSE,
			'options'   => [
				'left'    => [
					'title' => __( 'Left', 'tci-uet' ),
					'icon'  => 'eicon-text-align-left',
				],
				'center'  => [
					'title' => __( 'Center', 'tci-uet' ),
					'icon'  => 'eicon-text-align-center',
				],
				'right'   => [
					'title' => __( 'Right', 'tci-uet' ),
					'icon'  => 'eicon-text-align-right',
				],
				'justify' => [
					'title' => __( 'Justified', 'tci-uet' ),
					'icon'  => 'eicon-text-align-justify',
				],
			],
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}}.elementor-widget-heading' => 'text-align: {{VALUE}};',
			],
		]
	);
}

/**
 * TCI heading style controls
 *
 * @since 0.0.5
 */
function tci_uet_heading_style_controls( $obj, $prefix = '' ) {
	$obj->add_control(
		$prefix . 'title_color',
		[
			'label'     => __( 'Text Color', 'tci-uet' ),
			'type'      => Controls_Manager::COLOR,
			'scheme'    => [
				'type'  => Scheme_Color::get_type(),
				'value' => Scheme_Color::COLOR_1,
			],
			'selectors' => [
				// Stronger selector to avoid section style from overwriting
				'{{WRAPPER}}.elementor-widget-heading .elementor-heading-title' => 'color: {{VALUE}};',
			],
		]
	);

	$obj->add_group_control(
		Group_Control_Typography::get_type(),
		[
			'name'     => 'typography',
			'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
			'selector' => '{{WRAPPER}} .elementor-heading-title',
		]
	);

	$obj->add_group_control(
		Group_Control_Text_Shadow::get_type(),
		[
			'name'     => 'text_shadow',
			'selector' => '{{WRAPPER}} .elementor-heading-title',
		]
	);

	$obj->add_control(
		$prefix . 'blend_mode',
		[
			'label'     => __( 'Blend Mode', 'tci-uet' ),
			'type'      => Controls_Manager::SELECT,
			'options'   => [
				''            => __( 'Normal', 'tci-uet' ),
				'multiply'    => 'Multiply',
				'screen'      => 'Screen',
				'overlay'     => 'Overlay',
				'darken'      => 'Darken',
				'lighten'     => 'Lighten',
				'color-dodge' => 'Color Dodge',
				'saturation'  => 'Saturation',
				'color'       => 'Color',
				'difference'  => 'Difference',
				'exclusion'   => 'Exclusion',
				'hue'         => 'Hue',
				'luminosity'  => 'Luminosity',
			],
			'selectors' => [
				'{{WRAPPER}} .elementor-heading-title' => 'mix-blend-mode: {{VALUE}}',
			],
			'separator' => 'none',
		]
	);
}

/**
 * TCI file write
 *
 * @since 0.0.5
 */
function tci_uet_file_write( $data = [ '', '' ] ) {
	require_once( ABSPATH . 'wp-admin/includes/file.php' );
	$access_type = get_filesystem_method();

	if ( $access_type === 'direct' ) {
		/* you can safely run request_filesystem_credentials() without any issues and don't need to worry about passing in a URL */
		$creds = request_filesystem_credentials( tci_uet_root(), '', true, tci_uet_root(), array() );
		/* initialize the API */
		if ( ! WP_Filesystem( $creds ) ) {
			/* any problems and we exit */
			return false;
		}
		global $wp_filesystem;
		/* do our file manipulations below */
		$file = $wp_filesystem->put_contents( tci_uet_root( $data[0] ), $data[1], FS_CHMOD_FILE );

		return __( 'done', 'tci-uet' );
	} else {
		/* don't have direct write access. Prompt user with our notice */
		_e( 'Found error on content downloading.', 'tci-uet' );
	}
}


/**
 * TCI caldera table query
 *
 * @since 0.0.5
 */
function tci_uet_caldera_table_query() {
	global $wpdb;
	$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}cf_forms WHERE %d", [ 1 ] ) );
	$data    = [];
	foreach ( $results as $result ) {
		$data[ $result->form_id ] = unserialize( $result->config )['name'];
	}

	return apply_filters( 'tci_uet_caldera_table_query', $data );
}

/**
 * TCI formidable table query
 *
 * @since 0.0.5
 */
function tci_uet_formidable_table_query() {
	global $wpdb;
	$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}frm_forms WHERE %d", [ 1 ] ) );
	$data    = [];
	foreach ( $results as $result ) {
		$data[ $result->id ] = $result->name;
	}

	return apply_filters( 'tci_uet_formidable_table_query', $data );
}

/**
 * TCI ninja form table query
 *
 * @since 0.0.5
 */
function tci_uet_ninja_form_table_query() {
	global $wpdb;
	$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}nf3_forms WHERE %d", [ 1 ] ) );
	$data    = [];
	foreach ( $results as $result ) {
		$data[ $result->id ] = $result->title;
	}

	return apply_filters( 'tci_uet_ninja_form_table_query', $data );
}

/**
 * TCI revolution slider
 *
 * @since 0.0.5
 */
function tci_uet_rev_slider_table_query() {
	global $wpdb;
	$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}revslider_sliders WHERE %d", [ 1 ] ) );
	$data    = [];
	foreach ( $results as $result ) {
		$data[ $result->alias ] = $result->title;
	}

	return apply_filters( 'tci_uet_rev_slider_table_query', $data );
}

/**
 * TCI layer slider
 *
 * @since 0.0.6
 */
function tci_uet_layer_slider_table_query() {
	global $wpdb;
	$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}layerslider WHERE %d", [ 1 ] ) );
	$data    = [];
	foreach ( $results as $result ) {
		$data[ $result->id ] = $result->name;
	}

	return apply_filters( 'tci_uet_layer_slider_table_query', $data );
}

/**
 * TCI master slider
 *
 * @since 0.0.6
 */
function tci_uet_master_slider_table_query() {
	global $wpdb;
	$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}masterslider_sliders WHERE %d", [ 1 ] ) );
	$data    = [];
	foreach ( $results as $result ) {
		$data[ $result->ID ] = $result->title;
	}

	return apply_filters( 'tci_uet_layer_slider_table_query', $data );
}

/**
 * TCI smart slider
 *
 * @since 0.0.6
 */
function tci_uet_smart_slider_table_query() {
	global $wpdb;
	$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}nextend2_smartslider3_sliders WHERE %d", [ 1 ] ) );
	$data    = [];
	foreach ( $results as $result ) {
		$data[ $result->id ] = $result->title;
	}

	return apply_filters( 'tci_uet_layer_slider_table_query', $data );
}

/**
 * TCI plugin active check
 *
 * @since 0.0.5
 */
function tci_uet_is_plugin_active( $plugin ) {
	require_once ABSPATH . 'wp-admin/includes/plugin.php';

	return is_plugin_active( $plugin );
}

/**
 * TCI template source type
 *
 * @since 0.0.5
 */
function tci_uet_template_source_type() {
	return apply_filters( 'tci_uet_template_source_type', [
		'default' => __( 'Default', 'tci-uet' ),
		'tci-uet' => __( 'Elementor', 'tci-uet' ),
	] );
}

/**
 * TCI template logo type
 *
 * @since 0.0.5
 */
function tci_uet_template_logo_type() {
	return apply_filters( 'tci_uet_template_logo_type', [
		'img'  => __( 'Text/Image', 'tci-uet' ),
		'code' => __( 'HTML Code', 'tci-uet' ),
	] );
}

/**
 * TCI get elementor template print
 *
 * @since 0.0.5
 */
function tci_uet_get_elementor_template( $tpl_id = '' ) {
	if ( ! $tpl_id ) {
		return;
	}
	echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $tpl_id );
}

/**
 * TCI template load and data
 *
 * @since 0.0.5
 */
function tci_uet_tpl_load_w_data( $tpl_name = '', $plug_name = '', $comman_dir = '', $args = [] ) {
	$tpl = tci_uet_tpl_load( $tpl_name, $plug_name, $comman_dir );
	if ( empty( $args ) ) {
		extract( $args );
		unset( $args );
	}

	if ( ! is_array( $tpl ) AND file_exists( $tpl ) ) {
		include $tpl;
	} elseif ( is_array( $tpl ) ) {
		foreach ( $tpl as $tp ) {
			if ( file_exists( $tp ) ) {
				include $tp;
			}
		}
	} else {
		return;
	}
}

/**
 * TCI template load
 *
 * @since 0.0.5
 */
function tci_uet_tpl_load( $tpl_names, $plug_name = '', $comman_dir = '', $load = false, $require_once = true ) {
	$located = [];

	foreach ( (array) $tpl_names as $tpl_name ) {
		if ( ! $tpl_name ) {
			continue;
		}

		if ( file_exists( get_stylesheet_directory() . "/$plug_name/$comman_dir/$tpl_name" ) ) {
			$located[] = get_stylesheet_directory() . "/$plug_name/$comman_dir/$tpl_name";
			continue;
		} elseif ( file_exists( get_template_directory() . "/$plug_name/$comman_dir/$tpl_name" ) ) {
			$located[] = get_template_directory() . "/$plug_name/$comman_dir/$tpl_name";
			continue;
		} elseif ( file_exists( ABSPATH . WPINC . "/theme-compat/$plug_name/$comman_dir/$tpl_name" ) ) {
			$located[] = ABSPATH . WPINC . "/theme-compat/$plug_name/$comman_dir/$tpl_name";
			continue;
		} elseif ( file_exists( WP_PLUGIN_DIR . "/$plug_name/$comman_dir/$tpl_name" ) ) {
			$located[] = WP_PLUGIN_DIR . "/$plug_name/$comman_dir/$tpl_name";
			continue;
		}
	}

	if ( $load && '' != $located ) {
		return load_template( $located, $require_once );
	}

	return $located;
}

/**
 * TCI DB download
 *
 * @since 0.0.5
 */
function tci_uet_db_download( $data = [ '', '' ] ) {
	require_once( ABSPATH . 'wp-admin/includes/file.php' );
	$access_type = get_filesystem_method();
	if ( $access_type === 'direct' ) {
		$creds = request_filesystem_credentials( tci_uet_root(), '', true, tci_uet_root(), array() );
		if ( ! WP_Filesystem( $creds ) ) {
			return false;
		}
		global $wp_filesystem;
		$tci_uet_redux_opt = $data[1];
		$tci_uet_redux_opt = serialize( $tci_uet_redux_opt );
		$wp_filesystem->put_contents( tci_uet_root( $data[0] ), $tci_uet_redux_opt, FS_CHMOD_FILE );
	}
}
