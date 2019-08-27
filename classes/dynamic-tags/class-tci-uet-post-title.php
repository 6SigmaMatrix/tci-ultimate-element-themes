<?php
namespace TCI_UET\Dynamic_Tag\TCI_Dynamic_Tags_Modules;

use Elementor\Core\DynamicTags\Tag;
use Elementor\Modules\DynamicTags\Module;
use TCI_UET\Dynamic_Tag\TCI_Dynamic_Tags_Modules;

class TCI_UET_Post_Title extends Tag {
	/**
	 * Get Name
	 * Returns the Name of the tag
	 *
	 * @since  0.0.1
	 * @access public
	 * @return string
	 */
	public function get_name() {
		return 'TCI_UET_Post_Title';
	}

	/**
	 * Get Title
	 * Returns the title of the Tag
	 *
	 * @since  0.0.1
	 * @access public
	 * @return string
	 */
	public function get_title() {
		return __( 'Post Title', 'tci-uet' );
	}

	/**
	 * Get Group
	 * Returns the Group of the tag
	 *
	 * @since  0.0.1
	 * @access public
	 * @return string
	 */
	public function get_group() {
		return TCI_Dynamic_Tags_Modules::POST_GROUP;
	}

	/**
	 * Get Categories
	 * Returns an array of tag categories
	 *
	 * @since  0.0.1
	 * @access public
	 * @return array
	 */
	public function get_categories() {
		return [ Module::TEXT_CATEGORY ];
	}

	/**
	 * Register Controls
	 * Registers the Dynamic tag controls
	 *
	 * @since  0.0.1
	 * @access protected
	 * @return void
	 */

	protected function _register_controls() {

	}

	/**
	 * Render
	 * Prints out the value of the Dynamic tag
	 *
	 * @since  0.0.1
	 * @access public
	 * @return void
	 */
	public function render() {
		echo wp_kses_post( get_the_title() );
	}
}