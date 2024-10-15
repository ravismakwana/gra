<?php
/**
 * Bootstrap supported theme
 *
 * @package Asgard
 */

namespace ASGARD_THEME\Inc;
use ASGARD_THEME\Inc\Traits\Singleton;

class ASGARD_THEME {
	use Singleton;

	protected function __construct(){
		// Load class
		Assets::get_instance(); // it calls the Assets class methods
		Menus::get_instance();
		MetaBox::get_instance();
		Sidebar::get_instance();
		Blocks::get_instance();
		Block_Patterns::get_instance();
		Loadmore_Posts::get_instance();
		Register_Post_Types::get_instance();
		Register_Taxonomies::get_instance();
		Archive_Settings::get_instance();
		Asgard_Woocommerce::get_instance();
		Asgard_Shortcodes::get_instance();
		Store_Information::get_instance();
		Schema::get_instance();
		$this->setup_hooks();
	}

	protected function setup_hooks() {
		// actions and filters
		add_action('after_setup_theme', [$this, 'setup_theme']);
		add_action( 'wp_head', [$this, 'ga_head_code'] );
		add_action( 'wp_body_open', [$this, 'ga_body_code'] );
	}

	public function setup_theme(){


		add_theme_support('title-tag');

		add_theme_support( 'custom-logo', [
			'height'      => 53,
			'width'       => 230,
			'flex-height' => true,
			'flex-width'  => true,
			'header-text' => [ 'site-title', 'site-description' ],
		] );
		/** custom background **/
		$bg_defaults = array(
			'default-color'          => 'ff0000',
			'default-image'          => '',
			'default-preset'         => 'default',
			'default-size'           => 'cover',
			'default-repeat'         => 'no-repeat',
			'default-attachment'     => 'scroll',
		);
		add_theme_support( 'custom-background', $bg_defaults );

		/** post thumbnail **/
		add_theme_support( 'post-thumbnails' );
		add_image_size('featured-thumbnail', 514, 206, true);
		add_image_size('blog-thumbnail', 1000, 1000, true);

		/** Feed Links **/
		add_theme_support( 'automatic-feed-links' );

		/** HTML5 **/
		add_theme_support( 'html5', [ 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script' ] );

		add_theme_support('editor-styles');

		add_editor_style( 'assets/build/css/editor.css' );

		add_theme_support('wp-block-styles');

		add_theme_support('align-wide');

		// Removed core block patterns
		remove_theme_support('core-block-patterns');

		remove_theme_support( 'wc-product-gallery-zoom' );
		remove_theme_support( 'wc-product-gallery-lightbox' );
		remove_theme_support( 'wc-product-gallery-slider' );
		// Add WooCommerce Support
		add_theme_support( 'woocommerce' );

		global $content_width;
		if(!isset($content_width)) {
			$content_width = 1240;
		}

	}

	public function ga_head_code(){
		?>
		<!-- Google Tag Manager -->

		<!-- End Google Tag Manager -->
		<?php
	}

	public function ga_body_code(){
        ?>
        <!-- Google Tag Manager (noscript) -->

        <!-- End Google Tag Manager (noscript) -->
        <?php
    }
}