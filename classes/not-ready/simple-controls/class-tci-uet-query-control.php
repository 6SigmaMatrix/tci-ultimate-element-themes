<?php
namespace TCI_UET\Controls;

tci_exit();

use Elementor\Control_Select2;

class TCI_UET_Query_Control extends Control_Select2 {

	public function get_type() {
		return 'TCI_UET_Query_Control';
	}

	/**
	 * 'query' can be used for passing query args in the structure and format used by WP_Query.
	 *
	 * @return array
	 */
	protected function get_default_settings() {
		return array_merge(
			parent::get_default_settings(), [
				'query' => '',
			]
		);
	}
}
