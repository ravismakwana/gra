<?php
/**
 * Enqueue theme scripts
 *
 * @package Asgard
 */

namespace ASGARD_THEME\Inc;

use ASGARD_THEME\Inc\Traits\Singleton;

class Assets {
	use Singleton;

	protected function __construct() {
		$this->setup_hooks();
	}

	protected function setup_hooks() {
		// actions and filters
		add_action( 'wp_enqueue_scripts', [ $this, 'register_styles' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'register_scripts' ] );
		add_action( 'enqueue_block_assets', [ $this, 'enqueue_editor_assets' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'dequeue_block_styles' ], 100 );
	}

	public function register_styles() {
//		wp_register_style('bootstrap', ASGARD_BUILD_LIB_URI.'/css/bootstrap.min.css', [], false, 'all');
		wp_register_style( 'main-css', ASGARD_BUILD_CSS_URI . '/main.css', [], filemtime( ASGARD_BUILD_CSS_DIR_PATH . '/main.css' ), 'all' );
		wp_register_style( 'home-css', ASGARD_BUILD_CSS_URI . '/home.css', [], filemtime( ASGARD_BUILD_CSS_DIR_PATH . '/home.css' ), 'all' );
		wp_register_style( 'review-css', ASGARD_BUILD_CSS_URI . '/review.css', [], filemtime( ASGARD_BUILD_CSS_DIR_PATH . '/review.css' ), 'all' );
		wp_register_style( 'contact-css', ASGARD_BUILD_CSS_URI . '/contact.css', [], filemtime( ASGARD_BUILD_CSS_DIR_PATH . '/contact.css' ), 'all' );
		wp_register_style( 'single-css', ASGARD_BUILD_CSS_URI . '/single.css', [], filemtime( ASGARD_BUILD_CSS_DIR_PATH . '/single.css' ), 'all' );
		wp_register_style( 'product-css', ASGARD_BUILD_CSS_URI . '/product.css', [], filemtime( ASGARD_BUILD_CSS_DIR_PATH . '/product.css' ), 'all' );
		wp_register_style( 'slick-css', ASGARD_BUILD_LIB_URI . '/css/slick/slick.css', [], false, 'all' );
		wp_register_style( 'slick-theme-css', ASGARD_BUILD_LIB_URI . '/css/slick/slick-theme.css', [ 'slick-css' ], false, 'all' );

//		wp_enqueue_style('bootstrap');
		wp_enqueue_style( 'main-css' );
		if(is_front_page()) {
			wp_enqueue_style( 'home-css' );
			wp_enqueue_style( 'review-css' );
		}
		if(is_single()) {
			wp_enqueue_style( 'single-css' );
		}
		if(is_product()) {
			wp_enqueue_style( 'product-css' );
			wp_enqueue_style( 'review-css' );
		}
		wp_enqueue_style( 'slick-css' );
		wp_enqueue_style( 'slick-theme-css' );
		
		if(is_page(9989)) {
			wp_enqueue_style( 'review-css' );
		}
		if(is_page(15)) {
			wp_enqueue_style( 'contact-css' );
		}
	}

	public function register_scripts() {

		wp_register_script( 'main', ASGARD_BUILD_JS_URI . '/main.js', [
			'jquery',
		], filemtime( ASGARD_BUILD_JS_DIR_PATH . '/main.js' ), true );
		wp_register_script( 'author-js', ASGARD_BUILD_JS_URI . '/author.js', [ 'jquery' ], filemtime( ASGARD_BUILD_JS_DIR_PATH . '/author.js' ), true );
		wp_register_script( 'bootstrap', ASGARD_BUILD_LIB_URI . '/js/bootstrap.min.js', [ 'jquery' ], false, true );
		wp_register_script( 'slick-slider', ASGARD_BUILD_LIB_URI . '/js/slick.min.js', [ 'jquery' ], false, true );

		wp_enqueue_script( 'bootstrap' );
		wp_enqueue_script( 'main' );
		wp_enqueue_script( 'slick-slider' );

		if ( is_author() ) {
			wp_enqueue_script( 'author-js' );
		}


		wp_localize_script( 'main', 'ajax_object',
			[
				'ajax_url'   => admin_url( 'admin-ajax.php' ),
				'ajax_nonce' => wp_create_nonce( 'loadmore_posts_nonce' ),
				'checkout_url' => get_permalink(wc_get_page_id('checkout'))
			]
		);
	}

	/**
	 * Enqueue editor scripts and styles.
	 */
	public function enqueue_editor_assets() {

		$asset_config_file = sprintf( '%s/assets.php', ASGARD_BUILD_DIR_PATH );

		if ( ! file_exists( $asset_config_file ) ) {
			return;
		}

		$asset_config = require_once $asset_config_file;

		if ( empty( $asset_config['js/editor.js'] ) ) {
			return;
		}

		$editor_asset    = $asset_config['js/editor.js'];
		$js_dependencies = ( ! empty( $editor_asset['dependencies'] ) ) ? $editor_asset['dependencies'] : [];
		$version         = ( ! empty( $editor_asset['version'] ) ) ? $editor_asset['version'] : filemtime( $asset_config_file );

		// Theme Gutenberg blocks JS.
		if ( is_admin() ) {
			wp_enqueue_script(
				'asgard-blocks-js',
				ASGARD_BUILD_JS_URI . '/blocks.js',
				$js_dependencies,
				$version,
				true
			);
		}

		// Theme Gutenberg blocks CSS.
		$css_dependencies = [

		];

		wp_enqueue_style(
			'asgard-blocks-css',
			ASGARD_BUILD_CSS_URI . '/blocks.css',
			$css_dependencies,
			filemtime( ASGARD_BUILD_CSS_DIR_PATH . '/blocks.css' ),
			'all'
		);
		if(is_checkout()) {
			wp_enqueue_script(
				'asgard-upload-js',
				ASGARD_BUILD_LIB_URI.'/js/jquery.uploadfile.min.js',
				$js_dependencies,
				'1.0',
				true
			);
			wp_enqueue_style(
				'asgard-upload-css',
				ASGARD_BUILD_LIB_URI.'/css/uploadfile.css',
				$css_dependencies,
				'1.0',
				'all'
			);
		}
		// Remove CSS on the front end.
		wp_dequeue_style( 'wp-block-library' );
	}

	public function dequeue_block_styles() {


		if ( is_front_page() || is_page(15) ) {
			// Remove CSS on the front end.
			wp_dequeue_style( 'wp-block-library' );

			// Remove Gutenberg theme.
			wp_dequeue_style( 'wp-block-library-theme' );

			// Remove inline global CSS on the front end.
			wp_dequeue_style( 'global-styles' );
			wp_dequeue_style( 'wc-blocks-vendors-style' );

			wp_dequeue_style( 'woocommerce-layout' );
			wp_dequeue_style( 'woocommerce-smallscreen' );
			// wp_dequeue_style( 'woocommerce-general' );
			wp_dequeue_style( 'wc-blocks-vendors-style' );
			wp_dequeue_style( 'wc-blocks-style' );
			wp_dequeue_style( 'classic-theme-styles' );

			wp_dequeue_script( 'jquery-blockui' );
			wp_dequeue_script( 'wc-add-to-cart' );
			wp_dequeue_script( 'woocommerce' );
			if ( ! is_user_logged_in() ) {
				wp_deregister_style( 'dashicons' );
			}
			wp_deregister_style( 'woocommerce-inline' );
		}
		if(is_product()) {
			wp_dequeue_script( 'wc-add-to-cart-variation' );
			wp_dequeue_script( 'jquery-blockui' );

//			wp_dequeue_style( 'woocommerce-general' );
			wp_dequeue_style( 'woocommerce-layout' );
			wp_dequeue_style( 'woocommerce-smallscreen' );
			wp_dequeue_style( 'woocommerce-smallscreen' );

			wp_dequeue_style( 'wc-blocks-style' );
		}
		if(is_shop() || is_product_category() ) {
//			wp_dequeue_style( 'woocommerce-general' );
			wp_dequeue_style( 'woocommerce-layout' );
			wp_dequeue_style( 'woocommerce-smallscreen' );
			wp_dequeue_style( 'woocommerce-smallscreen' );
		}
	}
}