<?php
/**
 * TCI UET Functions file
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.1
 */
tci_exit();

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
 * @since 0.0.1
 */
function tci_exit() {
	if ( ! defined( 'ABSPATH' ) ) {
		exit; // Exit if accessed directly.
	}
}

/**
 * Get active plugins
 *
 * @since 0.0.1
 */
function tci_wp_active_plugins() {
	$active_plugins = get_option( 'active_plugins' );
	if ( is_multisite() ) {
		$active_plugins = array_merge( $active_plugins, get_site_option( 'active_sitewide_plugins', [] ) );
	}

	return apply_filters( 'tci_wp_active_plugins', $active_plugins );
}

/**
 * Get active plugins directory
 *
 * @since 0.0.1
 */
function tci_active_plugins_dir() {
	$plugins_list = tci_wp_active_plugins();

	if ( empty( $plugins_list ) ) {
		return;
	}

	$plugin_dir = [];
	foreach ( $plugins_list as $plugin => $value ) {
		if ( is_numeric( $plugin ) ) {
			$plugin = $value;
		}
		$_plugin_dir = dirname( $plugin );
		if ( strpos( $_plugin_dir, 'ci-uet-' ) == true ) {
			$plugin_dir[] = $_plugin_dir;
		}
	}

	return apply_filters( 'tci_active_plugins_dir', $plugin_dir );
}

/**
 * Get directory files list
 *
 * @since 0.0.1
 */
function tci_dir_files_list( $path, $ext = '*.php' ) {
	return apply_filters( 'tci_dir_files_list', glob( $path . $ext ) );
}

/**
 * Get file name
 *
 * @since 0.0.1
 */
function tci_file_name( $path ) {
	return apply_filters( 'tci_file_name', basename( $path ) );
}

/**
 * Generate TCI UET Class Name
 *
 * @since 0.0.1
 */
function tci_generate_class_name( $path ) {
	$class_name = pathinfo( $path );
	$class_name = explode( '-', $class_name['filename'] );
	$class_name = array_map( 'ucfirst', $class_name );
	unset( $class_name[0] );
	unset( $class_name[1] );
	unset( $class_name[2] );
	$class_name = array_merge( [ 'TCI', 'UET' ], $class_name );

	return apply_filters( 'tci_generate_class_name', $class_name );
}

/**
 * Get registered nav menus
 *
 * @since 0.0.1
 */
function tci_get_nav_menus_list() {
	foreach ( get_registered_nav_menus() as $k => $v ) {
		$menu_list[ $k ] = $v;
	}

	return apply_filters( 'tci_get_nav_menus_list', $menu_list );
}


/**
 * TCI get value
 *
 * @since 0.0.1
 */
function tci_get_have( $var, $key, $def = '' ) {

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
 * @since 0.0.1
 */
function tci_array( $data = [] ) {
	return new \Arrayy\Arrayy( $data );
}

/**
 * TCI get array
 *
 * @since 0.0.1
 */
function tci_enqueue( $style = [], $script = [] ) {
	if ( ! empty( $style ) ) {
		foreach ( $style as $name ) {
			wp_enqueue_style( $name );
		}
	}

	if ( ! empty( $script ) ) {
		wp_enqueue_scripts( $script );
	}
}

/**
 * TCI url control extract
 *
 * @since 0.0.1
 */
function tci_url_control_extract( $data = [] ) {
	$data[0] = 'href="' . esc_url( $data[0] ) . '"';
	$data[1] = ( 'on' === $data[1] ) ? esc_attr( "target={$data[1]}" ) : '';
	$data[2] = ( 'on' === $data[2] ) ? esc_attr( 'rel=nofollow' ) : '';

	return apply_filters( 'tci_url_control_extract', $data );
}

/**
 * TCI get post types
 *
 * @since 0.0.1
 */
function tci_get_post_type_list() {
	return wp_list_pluck( get_post_types( [ 'publicly_queryable' => true ], 'object' ), 'label', 'name' );
}

/**
 * TCI get post
 *
 * @since 0.0.1
 */
function tci_get_post_list( $post_type = 'post' ) {
	return wp_list_pluck( get_posts( [ 'post_type' => $post_type, 'numberposts' => - 1 ] ), 'post_title', 'ID' );
}

/**
 * TCI query post status
 *
 * @since 0.0.1
 */
function tci_query_post_stats() {
	return apply_filters( 'tci_query_post_stats', [
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
 * @since 0.0.1
 */
function tci_query_post_order() {
	return apply_filters( 'tci_query_post_order', [
		'DESC' => __( 'Descending ', 'tci-uet' ),
		'ASC'  => __( 'Ascending ', 'tci-uet' ),
	] );
}

/**
 * TCI query post order by
 *
 * @since 0.0.1
 */
function tci_query_post_orderby() {
	return apply_filters( 'tci_query_post_orderby', [
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
 * @since 0.0.1
 */
function tci_query_controls( $obj, $key_prefix = '' ) {
	$obj->add_control(
		$key_prefix . 'post_query_source',
		[
			'label'   => __( 'Post Type', 'tci-uet' ),
			'type'    => Controls_Manager::SELECT2,
			'options' => tci_get_post_type_list(),
			'default' => 'post',
		]
	);

	$obj->add_control(
		$key_prefix . 'post_query_status',
		[
			'label'    => __( 'Post Status', 'tci-uet' ),
			'type'     => Controls_Manager::SELECT2,
			'multiple' => true,
			'options'  => tci_query_post_stats(),
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
			'options' => tci_query_post_orderby(),
			'default' => 'date',
		]
	);

	$obj->add_control(
		$key_prefix . 'post_query_order',
		[
			'label'   => __( 'Post Order', 'tci-uet' ),
			'type'    => Controls_Manager::SELECT,
			'options' => tci_query_post_order(),
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
 * @since 0.0.1
 */
function tci_column_control( $obj, $key_prefix = '' ) {
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
 * @since 0.0.1
 */
function tci_controls_query_args( $data, $prefix = '' ) {

	return apply_filters( 'tci_controls_query_args', [
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
 * @since 0.0.1
 */
function tci_heading_controls( $obj, $prefix = '' ) {
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
 * @since 0.0.1
 */
function tci_heading_style_controls( $obj, $prefix = '' ) {
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
 * @since 0.0.1
 */
function tci_file_write( $data = [ '', '' ] ) {
	require_once( ABSPATH . 'wp-admin/includes/file.php' );
	$access_type = get_filesystem_method();

	if ( $access_type === 'direct' ) {
		/* you can safely run request_filesystem_credentials() without any issues and don't need to worry about passing in a URL */
		$creds = request_filesystem_credentials( tci_root(), '', true, tci_root(), array() );
		/* initialize the API */
		if ( ! WP_Filesystem( $creds ) ) {
			/* any problems and we exit */
			return false;
		}
		global $wp_filesystem;
		/* do our file manipulations below */
		$file = $wp_filesystem->put_contents( tci_root( $data[0] ), $data[1], FS_CHMOD_FILE );

		return __( 'done', 'tci-uet' );
	} else {
		/* don't have direct write access. Prompt user with our notice */
		_e( 'Found error on content downloading.', 'tci-uet' );
	}
}


/**
 * TCI caldera table query
 *
 * @since 0.0.1
 */
function tci_caldera_table_query() {
	global $wpdb;
	$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}cf_forms WHERE %d", [ 1 ] ) );
	$data    = [];
	foreach ( $results as $result ) {
		$data[ $result->form_id ] = unserialize( $result->config )['name'];
	}

	return apply_filters( 'tci_caldera_table_query', $data );
}

/**
 * TCI formidable table query
 *
 * @since 0.0.1
 */
function tci_formidable_table_query() {
	global $wpdb;
	$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}frm_forms WHERE %d", [ 1 ] ) );
	$data    = [];
	foreach ( $results as $result ) {
		$data[ $result->id ] = $result->name;
	}

	return apply_filters( 'tci_formidable_table_query', $data );
}

/**
 * TCI ninja form table query
 *
 * @since 0.0.1
 */
function tci_ninja_form_table_query() {
	global $wpdb;
	$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}nf3_forms WHERE %d", [ 1 ] ) );
	$data    = [];
	foreach ( $results as $result ) {
		$data[ $result->id ] = $result->title;
	}

	return apply_filters( 'tci_ninja_form_table_query', $data );
}

/**
 * TCI revolution slider
 *
 * @since 0.0.1
 */
function tci_rev_slider_table_query() {
	global $wpdb;
	$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}revslider_sliders WHERE %d", [ 1 ] ) );
	$data    = [];
	foreach ( $results as $result ) {
		$data[ $result->alias ] = $result->title;
	}

	return apply_filters( 'tci_rev_slider_table_query', $data );
}

/**
 * TCI plugin active check
 *
 * @since 0.0.1
 */
function tci_is_plugin_active( $plugin ) {
	require_once ABSPATH . 'wp-admin/includes/plugin.php';

	return is_plugin_active( $plugin );
}

/**
 * TCI set wp color scheme in db
 *
 * @since 0.0.1
 */
function tci_get_wp_color_scheme() {
	$opt                        = tci_db_opt();
	$result                     = get_user_option( 'admin_color', get_current_user_id() );
	$opt['tci_wp_color_scheme'] = $result;

	update_option( TCI_SETTINGS, $opt );
}

/**
 * TCI set options
 *
 * @since 0.0.1
 */
function tci_db_opt() {
	$opt_array = [ 'tci_wp_color_scheme' => '' ];
	if ( ! get_option( TCI_SETTINGS ) ) {
		add_option( TCI_SETTINGS, $opt_array );
	}

	return apply_filters( 'tci_db_opt', get_option( TCI_SETTINGS ) );
}

/**
 * TCI template source type
 *
 * @since 0.0.1
 */
function tci_template_source_type() {
	return apply_filters( 'tci_template_source_type', [
		'default'   => __( 'Default', 'tci-uet' ),
		'tci-uet' => __( 'Elementor', 'tci-uet' ),
	] );
}

/**
 * TCI template logo type
 *
 * @since 0.0.1
 */
function tci_template_logo_type() {
	return apply_filters( 'tci_template_logo_type', [
		'img'  => __( 'Text/Image', 'tci-uet' ),
		'code' => __( 'HTML Code', 'tci-uet' ),
	] );
}

/**
 * TCI get elementor template print
 *
 * @since 0.0.1
 */
function tci_get_elementor_template( $tpl_id = '' ) {
	if ( ! $tpl_id ) {
		return;
	}
	echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $tpl_id );
}

/**
 * TCI template load and data
 *
 * @since 0.0.1
 */
function tci_tpl_load_w_data( $tpl_name = '', $plug_name = '', $comman_dir = '', $args = [] ) {
	$tpl = tci_tpl_load( $tpl_name, $plug_name, $comman_dir );
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
 * @since 0.0.1
 */
function tci_tpl_load( $tpl_names, $plug_name = '', $comman_dir = '', $load = false, $require_once = true ) {
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
 * @since 0.0.1
 */
function tci_db_download( $data = [ '', '' ] ) {
	require_once( ABSPATH . 'wp-admin/includes/file.php' );
	$access_type = get_filesystem_method();
	if ( $access_type === 'direct' ) {
		$creds = request_filesystem_credentials( tci_root(), '', true, tci_root(), array() );
		if ( ! WP_Filesystem( $creds ) ) {
			return false;
		}
		global $wp_filesystem;
		$tci_redux_opt = $data[1];
		$tci_redux_opt = serialize( $tci_redux_opt );
		$wp_filesystem->put_contents( tci_root( $data[0] ), $tci_redux_opt, FS_CHMOD_FILE );
	}
}

/**
 * TCI get redux options
 *
 * @since 0.0.1
 */
function tci_redux_get_opt() {

	tci_db_download( [ 'content/tci_uet_opt.txt', get_theme_mod( 'tci_uet_opt-mods', [] ) ] );
}

/**
 * TCI redux options
 *
 * @since 0.0.1
 */
function tci_redux_opt() {
	if ( file_exists( tci_root( 'content/tci_uet_opt.txt' ) ) ) {
		$viral_buzz_db_opt = wp_remote_get( tci_uri( 'content/tci_uet_opt.txt' ) );

		return unserialize( $viral_buzz_db_opt['body'] );
	}
}

/**
 * TCI global array
 *
 * @since 0.0.1
 */
function tci_setup_theme() {
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );


	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );


	/*
	 * Enable support for Post Formats on posts.
	 *
	 * @link https://wordpress.org/support/article/post-formats/
	 */
	add_theme_support( 'post-formats', [
		'standard',
		'aside',
		'chat',
		'gallery',
		'link',
		'image',
		'quote',
		'status',
		'video',
		'audio',
	] );


	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		[
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		]
	);

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	$tci_opt = tci_array( tci_redux_opt() );
	add_theme_support(
		'custom-logo',
		[
			'height'      => $tci_opt->get( TCI_UET . 'logo_img_dimensions.width' ),
			'width'       => $tci_opt->get( TCI_UET . 'logo_img_dimensions.hight' ),
			'flex-width'  => true,
			'flex-height' => true,
		]
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Add support for Block Styles.
	add_theme_support( 'wp-block-styles' );


	// Add support for full and wide align images.
	add_theme_support( 'align-wide' );


	// Add support for editor styles.
	add_theme_support( 'editor-styles' );


	// Add custom editor font sizes.
	add_theme_support( 'editor-font-sizes', [
		[
			'name' => __( 'Small', 'tci-uet' ),
			'size' => 12,
			'slug' => 'small',
		],
		[
			'name' => __( 'Normal', 'tci-uet' ),
			'size' => 16,
			'slug' => 'normal',
		],
		[
			'name' => __( 'Large', 'tci-uet' ),
			'size' => 36,
			'slug' => 'large',
		],
		[
			'name' => __( 'Huge', 'tci-uet' ),
			'size' => 50,
			'slug' => 'huge',
		],
	] );


	// Editor color palette.
	add_theme_support( 'editor-color-palette', [
		[
			'name'  => __( 'strong magenta', 'tci-uet' ),
			'slug'  => 'strong-magenta',
			'color' => '#a156b4',
		],
		[
			'name'  => __( 'light grayish magenta', 'tci-uet' ),
			'slug'  => 'light-grayish-magenta',
			'color' => '#d0a5db',
		],
		[
			'name'  => __( 'very light gray', 'tci-uet' ),
			'slug'  => 'very-light-gray',
			'color' => '#eee',
		],
		[
			'name'  => __( 'very dark gray', 'tci-uet' ),
			'slug'  => 'very-dark-gray',
			'color' => '#444',
		],
	] );


	// Add support for responsive embedded content.
	add_theme_support( 'responsive-embeds' );

	// Add support for woocommerce content.
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus(
		[
			'tci-uet-menu' => __( 'TCI UET MENU', 'tci-uet' ),
		]
	);
}

/**
 * Used to overcome core bug when taxonomy is in more then one post type
 *
 * @see   https://core.trac.wordpress.org/ticket/27918
 * @global array $wp_taxonomies The registered taxonomies.
 * @since 0.0.1
 *
 * @param array  $args
 * @param string $output
 * @param string $operator
 *
 * @return array
 */
function tci_get_taxonomies( $args = [], $output = 'names', $operator = 'and' ) {
	global $wp_taxonomies;

	$field = ( 'names' === $output ) ? 'name' : false;

	// Handle 'object_type' separately.
	if ( isset( $args['object_type'] ) ) {
		$object_type = (array) $args['object_type'];
		unset( $args['object_type'] );
	}

	$taxonomies = wp_filter_object_list( $wp_taxonomies, $args, $operator );

	if ( isset( $object_type ) ) {
		foreach ( $taxonomies as $tax => $tax_data ) {
			if ( ! array_intersect( $object_type, $tax_data->object_type ) ) {
				unset( $taxonomies[ $tax ] );
			}
		}
	}

	if ( $field ) {
		$taxonomies = wp_list_pluck( $taxonomies, $field );
	}

	return $taxonomies;
}

/**
 * TCI Get page title
 *
 * @since 0.0.1
 */
function tci_get_page_title( $include_context = true ) {
	$title = '';

	if ( is_singular() ) {
		/* translators: %s: Search term. */
		$title = get_the_title();

		if ( $include_context ) {
			$post_type_obj = get_post_type_object( get_post_type() );
			$title         = sprintf( '%s: %s', $post_type_obj->labels->singular_name, $title );
		}
	} elseif ( is_search() ) {
		/* translators: %s: Search term. */
		$title = sprintf( __( 'Search Results for: %s', 'tci-uet' ), get_search_query() );

		if ( get_query_var( 'paged' ) ) {
			/* translators: %s is the page number. */
			$title .= sprintf( __( '&nbsp;&ndash; Page %s', 'tci-uet' ), get_query_var( 'paged' ) );
		}
	} elseif ( is_category() ) {
		$title = single_cat_title( '', false );

		if ( $include_context ) {
			/* translators: Category archive title. 1: Category name */
			$title = sprintf( __( 'Category: %s', 'tci-uet' ), $title );
		}
	} elseif ( is_tag() ) {
		$title = single_tag_title( '', false );
		if ( $include_context ) {
			/* translators: Tag archive title. 1: Tag name */
			$title = sprintf( __( 'Tag: %s', 'tci-uet' ), $title );
		}
	} elseif ( is_author() ) {
		$title = '<span class="vcard">' . get_the_author() . '</span>';

		if ( $include_context ) {
			/* translators: Author archive title. 1: Author name */
			$title = sprintf( __( 'Author: %s', 'tci-uet' ), $title );
		}
	} elseif ( is_year() ) {
		$title = get_the_date( _x( 'Y', 'yearly archives date format', 'tci-uet' ) );

		if ( $include_context ) {
			/* translators: Yearly archive title. 1: Year */
			$title = sprintf( __( 'Year: %s', 'tci-uet' ), $title );
		}
	} elseif ( is_month() ) {
		$title = get_the_date( _x( 'F Y', 'monthly archives date format', 'tci-uet' ) );

		if ( $include_context ) {
			/* translators: Monthly archive title. 1: Month name and year */
			$title = sprintf( __( 'Month: %s', 'tci-uet' ), $title );
		}
	} elseif ( is_day() ) {
		$title = get_the_date( _x( 'F j, Y', 'daily archives date format', 'tci-uet' ) );

		if ( $include_context ) {
			/* translators: Daily archive title. 1: Date */
			$title = sprintf( __( 'Day: %s', 'tci-uet' ), $title );
		}
	} elseif ( is_tax( 'post_format' ) ) {
		if ( is_tax( 'post_format', 'post-format-aside' ) ) {
			$title = _x( 'Asides', 'post format archive title', 'tci-uet' );
		} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
			$title = _x( 'Galleries', 'post format archive title', 'tci-uet' );
		} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
			$title = _x( 'Images', 'post format archive title', 'tci-uet' );
		} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
			$title = _x( 'Videos', 'post format archive title', 'tci-uet' );
		} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
			$title = _x( 'Quotes', 'post format archive title', 'tci-uet' );
		} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
			$title = _x( 'Links', 'post format archive title', 'tci-uet' );
		} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
			$title = _x( 'Statuses', 'post format archive title', 'tci-uet' );
		} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
			$title = _x( 'Audio', 'post format archive title', 'tci-uet' );
		} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
			$title = _x( 'Chats', 'post format archive title', 'tci-uet' );
		}
	} elseif ( is_post_type_archive() ) {
		$title = post_type_archive_title( '', false );

		if ( $include_context ) {
			/* translators: Post type archive title. 1: Post type name */
			$title = sprintf( __( 'Archives: %s', 'tci-uet' ), $title );
		}
	} elseif ( is_tax() ) {
		$title = single_term_title( '', false );

		if ( $include_context ) {
			$tax = get_taxonomy( get_queried_object()->taxonomy );
			/* translators: Taxonomy term archive title. 1: Taxonomy singular name, 2: Current taxonomy term */
			$title = sprintf( __( '%1$s: %2$s', 'tci-uet' ), $tax->labels->singular_name, $title );
		}
	} elseif ( is_404() ) {
		$title = __( 'Page Not Found', 'tci-uet' );
	} // End if().

	/**
	 * The archive title.
	 * Filters the archive title.
	 *
	 * @since 1.0.0
	 *
	 * @param string $title Archive title to be displayed.
	 */
	$title = apply_filters( 'elementor/utils/get_the_archive_title', $title );

	return $title;
}

/**
 * TCI Get Archive URL
 *
 * @since 0.0.1
 */
function tci_get_the_archive_url() {
	$url = '';
	if ( is_category() || is_tag() || is_tax() ) {
		$url = get_term_link( get_queried_object() );
	} elseif ( is_author() ) {
		$url = get_author_posts_url( get_queried_object_id() );
	} elseif ( is_year() ) {
		$url = get_year_link( get_query_var( 'year' ) );
	} elseif ( is_month() ) {
		$url = get_month_link( get_query_var( 'year' ), get_query_var( 'monthnum' ) );
	} elseif ( is_day() ) {
		$url = get_day_link( get_query_var( 'year' ), get_query_var( 'monthnum' ), get_query_var( 'day' ) );
	} elseif ( is_post_type_archive() ) {
		$url = get_post_type_archive_link( get_post_type() );
	}

	return $url;
}