<?php
/**
 * Sidebar template
 *
 * @package Asgard
 */

namespace ASGARD_THEME\Inc;

use ASGARD_THEME\Inc\Traits\Singleton;

class Sidebar {
	use Singleton;
	protected function __construct(){
		$this->setup_hooks();
	}
	protected function setup_hooks() {
		// actions and filters
		add_action('widgets_init', [$this, 'register_sidebars']);
		add_action('widgets_init', [$this, 'register_clock_widget']);
	}
	public function register_sidebars(){
		/* Register the 'primary' sidebar. */
		register_sidebar(
			[
				'id'            => 'sidebar-1',
				'name'          => __( 'Sidebar', 'asgard' ),
				'description'   => __( 'A short description of the sidebar.', 'asgard' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s mb-4">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			]
		);
		register_sidebar(
			[
				'id'            => 'footer-newsletter',
				'name'          => __( 'Footer Newsletter', 'asgard' ),
				'description'   => __( 'Put the newsletter shortcode here', 'asgard' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			]
		);
		
		register_sidebar(
			[
				'id'            => 'footer-1',
				'name'          => __( 'Footer Sidebar 1', 'asgard' ),
				'description'   => __( 'A short description of the sidebar.', 'asgard' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="h4 widget-title text-white mb-4 fw-normal mt-2">',
				'after_title'   => '</h3>',
			]
		);
		register_sidebar(
			[
				'id'            => 'footer-2',
				'name'          => __( 'Footer Sidebar 2', 'asgard' ),
				'description'   => __( 'A short description of the sidebar.', 'asgard' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="h4 widget-title text-white mb-4 fw-normal mt-2">',
				'after_title'   => '</h3>',
			]
		);
		register_sidebar(
			[
				'id'            => 'footer-3',
				'name'          => __( 'Footer Sidebar 3', 'asgard' ),
				'description'   => __( 'A short description of the sidebar.', 'asgard' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="h4 widget-title text-white mb-4 fw-normal mt-2">',
				'after_title'   => '</h3>',
			]
		);
		register_sidebar(
			[
				'id'            => 'footer-4',
				'name'          => __( 'Footer Sidebar 4', 'asgard' ),
				'description'   => __( 'A short description of the sidebar.', 'asgard' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="h4 widget-title text-white mb-4 fw-normal mt-2">',
				'after_title'   => '</h3>',
			]
		);

	}
	public function register_clock_widget(){
		register_widget( 'ASGARD_THEME\Inc\Clock_Widget' );
	}
}