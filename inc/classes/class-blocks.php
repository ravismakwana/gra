<?php
/**
 * Blocks
 *
 * @package Asgard
 */

namespace ASGARD_THEME\Inc;

use ASGARD_THEME\Inc\Traits\Singleton;

class Blocks {
	use Singleton;

	protected function __construct() {
		$this->setup_hooks();
	}

	protected function setup_hooks() {
		// actions and filters
		add_filter( 'block_categories_all', [ $this, 'add_custom_block_categories' ] );
	}

	public function add_custom_block_categories( $categories ) {
		// Plugin’s block category title and slug.
		$block_category = [
			'title' => esc_html__( 'Asgard Blocks', 'asgard' ),
			'slug'  => 'asgard'
		];
		$category_slugs = wp_list_pluck( $categories, 'slug' );

		if ( ! in_array( $block_category['slug'], $category_slugs, true ) ) {
			$categories = array_merge(
				$categories,
				[
					[
						'title' => $block_category['title'], // Required
						'slug'  => $block_category['slug'], // Required
						'icon'  => 'dashicons-table-row-after', // Slug of a WordPress Dashicon or custom SVG
					],
				]
			);
		}

		return $categories;
	}

}