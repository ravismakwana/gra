<?php
/**
 * Register Custom Post Types
 *
 * @package Asgard
 */

namespace ASGARD_THEME\Inc;

use ASGARD_THEME\Inc\Traits\Singleton;

class Register_Post_Types {
	use Singleton;

	protected function __construct() {
//		$this->setup_hooks();
	}

	protected function setup_hooks() {
		// actions and filters
		add_action( 'init', [ $this, 'create_movie_cpt' ], 0 );
		add_action( 'init', [ $this, 'create_genre_tax' ] );
	}

	// Register Custom Post Type Movie
	public function create_movie_cpt() {

		$labels = array(
			'name'                  => _x( 'Movies', 'Post Type General Name', 'asgard' ),
			'singular_name'         => _x( 'Movie', 'Post Type Singular Name', 'asgard' ),
			'menu_name'             => _x( 'Movies', 'Admin Menu text', 'asgard' ),
			'name_admin_bar'        => _x( 'Movie', 'Add New on Toolbar', 'asgard' ),
			'archives'              => __( 'Movie Archives', 'asgard' ),
			'attributes'            => __( 'Movie Attributes', 'asgard' ),
			'parent_item_colon'     => __( 'Parent Movie:', 'asgard' ),
			'all_items'             => __( 'All Movies', 'asgard' ),
			'add_new_item'          => __( 'Add New Movie', 'asgard' ),
			'add_new'               => __( 'Add New', 'asgard' ),
			'new_item'              => __( 'New Movie', 'asgard' ),
			'edit_item'             => __( 'Edit Movie', 'asgard' ),
			'update_item'           => __( 'Update Movie', 'asgard' ),
			'view_item'             => __( 'View Movie', 'asgard' ),
			'view_items'            => __( 'View Movies', 'asgard' ),
			'search_items'          => __( 'Search Movie', 'asgard' ),
			'not_found'             => __( 'Not found', 'asgard' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'asgard' ),
			'featured_image'        => __( 'Featured Image', 'asgard' ),
			'set_featured_image'    => __( 'Set featured image', 'asgard' ),
			'remove_featured_image' => __( 'Remove featured image', 'asgard' ),
			'use_featured_image'    => __( 'Use as featured image', 'asgard' ),
			'insert_into_item'      => __( 'Insert into Movie', 'asgard' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Movie', 'asgard' ),
			'items_list'            => __( 'Movies list', 'asgard' ),
			'items_list_navigation' => __( 'Movies list navigation', 'asgard' ),
			'filter_items_list'     => __( 'Filter Movies list', 'asgard' ),
		);
		$args   = array(
			'label'               => __( 'Movie', 'asgard' ),
			'description'         => __( 'all kind of movies', 'asgard' ),
			'labels'              => $labels,
			'menu_icon'           => 'dashicons-video-alt',
			'supports'            => array(
				'title',
				'editor',
				'excerpt',
				'thumbnail',
				'revisions',
				'author',
				'comments',
				'trackbacks',
				'page-attributes',
				'custom-fields'
			),
			'taxonomies'          => array(),
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 5,
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => true,
			'hierarchical'        => false,
			'exclude_from_search' => false,
			'show_in_rest'        => true,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
		);
		register_post_type( 'movies', $args );
	}

	// Register Taxonomy Genre
	public function create_genre_tax() {

		$labels = array(
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
		);
		$args = array(
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
		);
		register_taxonomy( 'genres', array('movies'), $args );

	}
}




