<?php
/**
 * TCI UET Single post title widget class
 *
 * @package TCI Ultimate Element Themes
 * @version 0.0.1
 */
namespace TCI_UET\Widgets;

tci_exit();

use Elementor\Widget_Heading;
use Elementor\Plugin;

class TCI_UET_Post_Title extends Widget_Heading {

	/**
	 * Get widget name.
	 * Retrieve widget name.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'TCI_UET_Post_Title';
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
		return __( 'TCI UET Post Title', 'tci-uet' );
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
		return 'tci tci-uet-font-1';
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
		return [ 'tci-widget-single' ];
	}

	/**
	 * Attach keywords.
	 *
	 * @since  0.0.1
	 * @access public
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'title', 'heading', 'post' ];
	}

	/**
	 * Register widget controls.
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected function _register_controls() {
		parent::_register_controls();

		$this->update_control( 'title', [
			'dynamic' => [
				'default' => Plugin::$instance->dynamic_tags->tag_data_to_tag_text( null, 'TCI_UET_Post_Title' ),
			],
		], [
			'recursive' => true,
		] );


		$this->update_control( 'header_size', [
			'default' => 'h1',
		] );
	}

	/**
	 * Attach the css class.
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function get_common_args() {
		return [
			'_css_classes' => [
				'default' => 'entry-title',
			],
		];
	}

	/**
	 * Get HTML wrapper class.
	 * Retrieve the widget container class. Can be used to override the
	 * container class for specific widgets.
	 *
	 * @since  0.0.1
	 * @access protected
	 */
	protected function get_html_wrapper_class() {
		return parent::get_html_wrapper_class() . ' tci-uet-widget elementor-page-title elementor-widget-' . parent::get_name();
	}
}
