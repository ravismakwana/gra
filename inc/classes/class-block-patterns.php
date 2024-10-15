<?php
/**
 * Block Pattern Class
 *
 * @package Asgard
 */

namespace ASGARD_THEME\Inc;

use ASGARD_THEME\Inc\Traits\Singleton;

class Block_Patterns{
	use Singleton;
	protected function __construct(){
		$this->setup_hooks();
	}

	protected function setup_hooks() {
		// actions and filters
		add_action('init', [$this, 'register_block_patterns']);
		add_action('init', [$this, 'register_block_patterns_categories']);
	}

	public function register_block_patterns(){

		$cover_content = $this->get_pattern_content('template-parts/patterns/cover');
		register_block_pattern(
			'asgard/cover',
			[
				'title'         => __( 'Cover Block', 'asgard' ),
				'description'   => __( 'Asgard Cover Block', 'asgard' ),
				'categories'    => ['cover'],
				'content'       =>  $cover_content
			]
		);
		$three_columns_content = $this->get_pattern_content('template-parts/patterns/three-columns');
		register_block_pattern(
			'asgard/three-columns',
			[
				'title'         => __( 'Three Columns Block', 'asgard' ),
				'description'   => __( 'Asgard Three Columns Block', 'asgard' ),
				'categories'    => ['columns'],
				'content'       =>  $three_columns_content
			]
		);

	}
	public function register_block_patterns_categories(){
		$pattern_categories = [
			'cover'     => __('Cover', 'asgard'),
			'columns'  => __('Columns', 'asgard')
		];
		if(!empty($pattern_categories) && is_array($pattern_categories)) {
			foreach ($pattern_categories as $pattern_category => $pattern_category_label) {
				register_block_pattern_category(
					$pattern_category,
					['label' => $pattern_category_label ]
				);
			}

		}

	}

	/**
	 * Get the pattern content from the pattern components and return it.
	 *
	 * @param $pattern_path
	 *
	 * @return false|string
	 */
	public function get_pattern_content( $pattern_path ){
		ob_start();
		get_template_part( $pattern_path );
		$pattern_content = ob_get_contents();
		ob_end_clean();
		return $pattern_content;
	}
}