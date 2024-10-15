<?php
/**
 * Register Custom Taxonomies
 *
 * @package Asgard
 */

namespace ASGARD_THEME\Inc;

use ASGARD_THEME\Inc\Traits\Singleton;

class Register_Taxonomies {
	use Singleton;

	protected function __construct() {
		$this->setup_hooks();
	}

	protected function setup_hooks() {
		// actions and filters
		add_action( 'init', [ $this, 'create_genre_tax' ] );
		add_action( 'init', [ $this, 'create_year_tax' ] );
	}

	// Register Taxonomy Genre
	public function create_genre_tax() {

		$labels = [
			'name'              => _x( 'Genres', 'taxonomy general name', 'asgard' ),
			'singular_name'     => _x( 'Genre', 'taxonomy singular name', 'asgard' ),
			'search_items'      => __( 'Search Genres', 'asgard' ),
			'all_items'         => __( 'All Genres', 'asgard' ),
			'parent_item'       => __( 'Parent Genre', 'asgard' ),
			'parent_item_colon' => __( 'Parent Genre:', 'asgard' ),
			'edit_item'         => __( 'Edit Genre', 'asgard' ),
			'update_item'       => __( 'Update Genre', 'asgard' ),
			'add_new_item'      => __( 'Add New Genre', 'asgard' ),
			'new_item_name'     => __( 'New Genre Name', 'asgard' ),
			'menu_name'         => __( 'Genre', 'asgard' ),
		];
		$args = [
			'labels' => $labels,
			'description' => __( 'Genre of Movies', 'asgard' ),
			'hierarchical' => true,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'show_in_nav_menus' => true,
			'show_tagcloud' => true,
			'show_in_quick_edit' => true,
			'show_admin_column' => false,
			'show_in_rest' => true,
		];
		register_taxonomy( 'genres', ['movies'], $args );

	}

	// Register Taxonomy Year
	public function create_year_tax() {

		$labels = [
			'name'              => _x( 'Years', 'taxonomy general name', 'asgard' ),
			'singular_name'     => _x( 'Year', 'taxonomy singular name', 'asgard' ),
			'search_items'      => __( 'Search Years', 'asgard' ),
			'all_items'         => __( 'All Years', 'asgard' ),
			'parent_item'       => __( 'Parent Year', 'asgard' ),
			'parent_item_colon' => __( 'Parent Year:', 'asgard' ),
			'edit_item'         => __( 'Edit Year', 'asgard' ),
			'update_item'       => __( 'Update Year', 'asgard' ),
			'add_new_item'      => __( 'Add New Year', 'asgard' ),
			'new_item_name'     => __( 'New Year Name', 'asgard' ),
			'menu_name'         => __( 'Year', 'asgard' ),
		];
		$args = [
			'labels' => $labels,
			'description' => __( 'Released Year of Movies', 'asgard' ),
			'hierarchical' => false,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'show_in_nav_menus' => true,
			'show_tagcloud' => true,
			'show_in_quick_edit' => true,
			'show_admin_column' => false,
			'show_in_rest' => true,
		];
		register_taxonomy( 'movie-year', ['movies'], $args );

	}
}




