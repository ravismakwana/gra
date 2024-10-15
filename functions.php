<?php
/**
 * Theme Functions
 *
 * @package Asgard
 */

if ( ! defined( 'ASGARD_DIR_PATH' ) ) {
	define( 'ASGARD_DIR_PATH', untrailingslashit( get_template_directory() ) );
}
if ( ! defined( 'ASGARD_DIR_URI' ) ) {
	define( 'ASGARD_DIR_URI', untrailingslashit( get_template_directory_uri() ) );
}

if ( ! defined( 'ASGARD_BUILD_DIR_URI' ) ) {
	define( 'ASGARD_BUILD_DIR_URI', untrailingslashit( get_template_directory_uri() ) . '/assets/build' );
}
if ( ! defined( 'ASGARD_BUILD_LIB_URI' ) ) {
	define( 'ASGARD_BUILD_LIB_URI', untrailingslashit( get_template_directory_uri() ) . '/assets/build/library' );
}
if ( ! defined( 'ASGARD_BUILD_DIR_PATH' ) ) {
	define( 'ASGARD_BUILD_DIR_PATH', untrailingslashit( get_template_directory() ) . '/assets/build' );
}
if ( ! defined( 'ASGARD_BUILD_JS_URI' ) ) {
	define( 'ASGARD_BUILD_JS_URI', untrailingslashit( get_template_directory_uri() ) . '/assets/build/js' );
}
if ( ! defined( 'ASGARD_BUILD_JS_DIR_PATH' ) ) {
	define( 'ASGARD_BUILD_JS_DIR_PATH', untrailingslashit( get_template_directory() ) . '/assets/build/js' );
}
if ( ! defined( 'ASGARD_BUILD_IMG_URI' ) ) {
	define( 'ASGARD_BUILD_IMG_URI', untrailingslashit( get_template_directory_uri() ) . '/assets/build/src/img' );
}
if ( ! defined( 'ASGARD_BUILD_CSS_URI' ) ) {
	define( 'ASGARD_BUILD_CSS_URI', untrailingslashit( get_template_directory_uri() ) . '/assets/build/css' );
}
if ( ! defined( 'ASGARD_BUILD_CSS_DIR_PATH' ) ) {
	define( 'ASGARD_BUILD_CSS_DIR_PATH', untrailingslashit( get_template_directory() ) . '/assets/build/css' );
}
if ( ! defined( 'ASGARD_ARCHIVE_POST_PER_PAGE' ) ) {
	define( 'ASGARD_ARCHIVE_POST_PER_PAGE', 6 );
}
if ( ! defined( 'ASGARD_SEARCH_RESULTS_POST_PER_PAGE' ) ) {
	define( 'ASGARD_SEARCH_RESULTS_POST_PER_PAGE', 10 );
}

// Helper folder includes
require_once ASGARD_DIR_PATH . '/inc/helpers/autoloader.php';
require_once ASGARD_DIR_PATH . '/inc/helpers/template-tags.php';


function asgard_get_theme_instance() {

	\ASGARD_THEME\Inc\ASGARD_THEME::get_instance();
}

asgard_get_theme_instance();

// To check Blocks attributes
//$my_post = get_post(2);
//$parsed_blocks = parse_blocks($my_post->post_content);
//echo '<pre>';
//print_r($parsed_blocks);
//wp_die();

remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
//remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
//remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
remove_filter( 'the_excerpt', 'wpautop' );

add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_title', 7 );
add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_rating', 8 );
add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 9 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 14 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 21 );

add_action('woocommerce_after_single_product_summary', 'genericmedsaustralia_trust_pilot_section', 8);
add_shortcode('SITE_REVIEW', 'genericmedsaustralia_trust_pilot_section_shortcode');

add_filter( 'woocommerce_product_get_rating_html', 'custom_add_star_rating_class', 10, 3 );
add_filter( 'woocommerce_product_price_class', 'asgard_woocommerce_add_product_price_class' );

function custom_add_star_rating_class( $html, $rating, $count ) {

	if ( 0 < $rating ) {
		// Add your custom class to the existing classes
		if(is_single()) {
			$html = str_replace( 'star-rating', 'star-rating', $html );
        } else {
			$html = str_replace( 'star-rating', 'star-rating mx-auto d-block', $html );
        }

	}
	if ( $html === '' ) {
		/* translators: %s: rating */
		$label = sprintf( __( 'Rated %s out of 5', 'woocommerce' ), 0 );
        if(is_single()) {
	        $html  = '<div class="star-rating" role="img" aria-label="' . esc_attr( $label ) . '">' . wc_get_star_rating_html( 0, 0 ) . '</div>';
        } else {
	        $html  = '<div class="star-rating mx-auto d-block" role="img" aria-label="' . esc_attr( $label ) . '">' . wc_get_star_rating_html( 0, 0 ) . '</div>';
        }

	}

	return $html;
}

function asgard_woocommerce_comments( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	?>
    <li <?php comment_class( 'd-flex align-items-start' ); ?> id="comment-<?php comment_ID(); ?>">
        <div class="flex-shrink-0">
            <img class="mr-3 rounded-circle img-fluid img-thumbnail border border-primary border-opacity-25"
                 src="<?php echo get_avatar_url( $comment, [ 'size' => '60' ] ); ?>"
                 alt="<?php echo esc_attr( get_comment_author() ); ?>">
        </div>
        <div class="flex-grow-1 ms-3 p-3 border border-primary border-opacity-25">
            <h5 class="mt-0 text-capitalize lh-1"><?php echo get_comment_author(); ?></h5>
            <p class="comment-metadata lh-1">
                <small class="text-muted"><?php printf( '%1$s at %2$s', get_comment_date(), get_comment_time() ); ?></small>
            </p>
			<?php if ( $comment->comment_approved == '0' ) : ?>
                <p class="comment-awaiting-moderation alert alert-info"><?php _e( 'Your comment is awaiting moderation.', 'woocommerce' ); ?></p>
			<?php endif; ?>
            <div class="comment-content">
				<?php comment_text(); ?>
            </div>
            <div class="comment-reply d-flex">
				<?php edit_comment_link( '(Edit)', '<span class="edit-link me-3">', '</span>' ); ?>
				<?php comment_reply_link( array_merge( $args, array( 'depth'     => $depth,
				                                                     'max_depth' => $args['max_depth']
				) ) ); ?>
            </div>
        </div>
    </li>
	<?php
}

function asgard_wc_display_item_meta( $item, $args = array() ) {
	$strings = array();
	$html    = '';
	$args    = wp_parse_args(
		$args,
		array(
			'before'       => '<ul class="wc-item-meta ms-0 ps-0"><li>',
			'after'        => '</li></ul>',
			'separator'    => '</li><li>',
			'echo'         => true,
			'autop'        => false,
			'label_before' => '<strong class="wc-item-meta-label">',
			'label_after'  => ':</strong> ',
		)
	);

	foreach ( $item->get_all_formatted_meta_data() as $meta_id => $meta ) {
		$value     = $args['autop'] ? wp_kses_post( $meta->display_value ) : wp_kses_post( make_clickable( trim( $meta->display_value ) ) );
		$strings[] = $args['label_before'] . wp_kses_post( $meta->display_key ) . $args['label_after'] . $value;
	}

	if ( $strings ) {
		$html = $args['before'] . implode( $args['separator'], $strings ) . $args['after'];
	}

	$html = apply_filters( 'woocommerce_display_item_meta', $html, $item, $args );

	if ( $args['echo'] ) {
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $html;
	} else {
		return $html;
	}
}
/* Trust pilot Reviews */
require get_stylesheet_directory() . '/template-parts/trust-pilot.php';
if(!function_exists('genericmedsaustralia_trust_pilot_section')) {
    function genericmedsaustralia_trust_pilot_section(){
        ?>
        <div class="clearfix"></div>
        <div class="trust-pilot-section trust-pilot-row row">
			<div class="trust-pilot-heading">
                <h3>What Our Customer Says</h3>
            </div>
            <div class="signle-post-testimonial left">
			    <?php echo do_shortcode('[TRUST_PILOT_AVG]'); ?>
            </div>
            <div class="signle-post-testimonial right">
			    <?php echo do_shortcode('[TRUSTPILOT_REVIEWS]'); ?>
            </div>
        </div>
        <?php
    }
}
if(!function_exists('genericmedsaustralia_trust_pilot_section_shortcode')) {
	function genericmedsaustralia_trust_pilot_section_shortcode(){
		ob_start();
			?>
			<div class="clearfix"></div>
			<div class="trust-pilot-section trust-pilot-row row">
		<div class="trust-pilot-heading">
							<h3>What Our Customer Says</h3>
					</div>
					<div class="signle-post-testimonial left">
				<?php echo do_shortcode('[TRUST_PILOT_AVG]'); ?>
					</div>
					<div class="signle-post-testimonial right">
				<?php echo do_shortcode('[TRUSTPILOT_REVIEWS]'); ?>
					</div>
			</div>
			<?php
			$data = ob_get_clean();
			wp_reset_postdata();
			return $data;
	}
}

function asgard_woocommerce_add_product_price_class( $class ){
	// Add additional classes
	$additional_classes = 'price text-dark fw-bold fs-4 mb-2';

	// Combine the original class with the additional classes
	return $class . ' ' . $additional_classes;
}