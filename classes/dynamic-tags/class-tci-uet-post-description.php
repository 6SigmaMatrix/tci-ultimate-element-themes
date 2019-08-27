<?php
namespace TCI_UET\Dynamic_Tag\TCI_Dynamic_Tags_Modules;

use Elementor\Core\DynamicTags\Tag;
use Elementor\Modules\DynamicTags\Module;
use TCI_UET\Dynamic_Tag\TCI_Dynamic_Tags_Modules;

class TCI_UET_Post_Description extends Tag {
	public function get_name() {
		return 'TCI_UET_Post_Description';
	}

	public function get_title() {
		return __( 'Post Description', 'tci-uet' );
	}

	public function get_group() {
		return TCI_Dynamic_Tags_Modules::POST_GROUP;
	}

	public function get_categories() {
		return [ Module::TEXT_CATEGORY ];
	}

	public function render() {
		// Allow only a real `post_excerpt` and not the trimmed `post_content` from the `get_the_excerpt` filter
		$post = get_post();

		if ( ! $post || empty( $post->post_content ) ) {
			return;
		}

		echo $post->post_content;
	}
}
