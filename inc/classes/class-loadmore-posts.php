<?php
/**
 * Ajax Load more posts
 *
 * @package Asgard
 */

namespace ASGARD_THEME\Inc;

use ASGARD_THEME\Inc\Traits\Singleton;
use \WP_Query;

class Loadmore_Posts {
	use Singleton;
	protected function __construct(){
		$this->setup_hooks();
	}

	protected function setup_hooks() {
		// actions and filters
		add_action('wp_ajax_loadmore_posts', [$this, 'asgard_loadmore_posts_data']);
		add_action('wp_ajax_nopriv_loadmore_posts', [$this, 'asgard_loadmore_posts_data']);

		/**
		 * Usage: echo do_shortcode('[POST_LISTING]');
		 */
		add_shortcode('POST_LISTING', [$this, 'post_script_load_more']);
	}

	public function asgard_loadmore_posts_data( $initial_request = false ) {
		if ( ! $initial_request && ! check_ajax_referer( 'loadmore_posts_nonce', 'ajax_nonce', false ) ) {
			wp_send_json_error( __('Invalid security token sent', 'asgard'));
			wp_die('0', 400 );
		}

		// Check if it's an ajax call.
		$is_ajax_request = ! empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) &&
		                   strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) === 'xmlhttprequest';

		$paged = get_query_var('paged') ? get_query_var('paged') : 1;
		$paged = !empty($_POST['page']) ? filter_var( $_POST['page'], FILTER_VALIDATE_INT ) + 1 : $paged;

		$args = [
			'post_type'         => 'post',
			'post_status'       => 'publish',
			'posts_per_page'    => 4,
			'paged'             => $paged
		];

		$query = new WP_Query( $args );

		if($query->have_posts()) {
			while($query->have_posts()) : $query->the_post();
				get_template_part('template-parts/components/post-card');
			endwhile;
		} else {
			wp_die( '0');
		}
		wp_reset_postdata();

		/**
		 * Check if it's an ajax call, and not initial request
		 */
		if( $is_ajax_request && ! $initial_request) {
			wp_die();
		}
	}

	public function post_script_load_more() {
		// Initial Post Load.
		?>
		<div class="load-more-content-wrap">
			<div id="load-more-content" class="row">
				<?php
				$this->asgard_loadmore_posts_data( true );
				// If user is not in editor and on page one, show the load more.
				?>
			</div>
			<button id="load-more" data-page="1" class="load-more-btn my-4 d-flex flex-column mx-auto px-4 py-2 border-0 bg-transparent">
				<span><?php esc_html_e( 'Loading...', 'asgard' ); ?></span>
				<?php get_template_part( 'template-parts/svgs/loading' ); ?>
			</button>
		</div>
		<?php
	}
}