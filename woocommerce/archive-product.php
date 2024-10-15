<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;
$taxonomyArg = $taxonomyTermArg = '';
get_header( 'shop' );
$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$paged = !empty($_POST['page']) ? filter_var( $_POST['page'], FILTER_VALIDATE_INT ) + 1 : $paged;
?>
    <div class="container bg-white p-3 p-lg-5 my-3 my-lg-5">
        <div class="row">
            <div class="col-lg-12 mt-3"><?php
				/**
				 * Hook: woocommerce_before_main_content.
				 *
				 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
				 * @hooked woocommerce_breadcrumb - 20
				 * @hooked WC_Structured_Data::generate_website_data() - 30
				 */
				do_action( 'woocommerce_before_main_content' );

				?>

                <header class="woocommerce-products-header">
					<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
                        <!-- <h1 class="h3 woocommerce-products-header__title page-title"><?php //woocommerce_page_title(); ?></h1> -->
					<?php endif; ?>

					<?php
					/**
					 * Hook: woocommerce_archive_description.
					 *
					 * @hooked woocommerce_taxonomy_archive_description - 10
					 * @hooked woocommerce_product_archive_description - 10
					 */
					do_action( 'woocommerce_archive_description' );
					?>
                </header>
				<?php
				if ( woocommerce_product_loop() ) {

					/**
					 * Hook: woocommerce_before_shop_loop.
					 *
					 * @hooked woocommerce_output_all_notices - 10
					 * @hooked woocommerce_result_count - 20
					 * @hooked woocommerce_catalog_ordering - 30
					 */
					do_action( 'woocommerce_before_shop_loop' );

					woocommerce_product_loop_start();

					if ( wc_get_loop_prop( 'total' ) ) {
//					while ( have_posts() ) {
//						the_post();

						/**
						 * Hook: woocommerce_shop_loop.
						 */
//						do_action( 'woocommerce_shop_loop' );
						$search_text = isset( $_GET['s'] ) ? $_GET['s'] : '';
						$post_type   = isset( $_GET['post_type'] ) ? $_GET['post_type'] : '';
						do_action( 'woocommerce_shop_loop' );
						if ( ! empty( $search_text ) || ! empty( $post_type ) ) {
							$args = array(
								'post_type' => $post_type,
								'posts_per_page' => '8',
								'button_label' => 'Show More Products',
								'button_loading_label' => 'Loading...',
								'scroll' => 'false',
								'transition_container_classes'=> "row",
								'search' => $search_text,
								'orderby'        => 'meta_value_num',
								'meta_key'       => '_wc_review_count',
								'order'          => 'DESC',
								'meta_query'     => array(
									'relation' => 'AND',
									array(
										'key'     => '_wc_review_count',
										'value'   => 0,
										'compare' => '>',
										'type'    => 'NUMERIC',
									),
								),
							);
							if(function_exists('alm_render')){
								alm_render($args);
							}
                            wp_reset_postdata();
//							echo do_shortcode( '[ajax_load_more transition_container_classes="row" woocommerce="true" search="' . $search_text . '" post_type="' . $post_type . '" taxonomy="product_cat" taxonomy_operator="IN" css_classes="" posts_per_page="12" transition="fade" button_label="View More Products" button_loading_label="Loading Products..." container_type="ul"]' );
						} else {
							if ( is_archive() ) {

								if ( ! is_shop() ) {
									$obj         = get_queried_object();
									$taxonomy    = $obj->taxonomy;
									$taxonomyArg = ( ! empty( $taxonomy ) ) ? $taxonomy : '';

									$taxonomy_term   = $obj->slug;
									$taxonomyTermArg = ( ! empty( $taxonomy_term ) ) ? $taxonomy_term : '';
								}
								$args = array(
									'post_type' => 'product',
									'posts_per_page' => '8',
									'button_label' => 'Show More Products',
									'button_loading_label' => 'Loading...',
									'scroll' => 'false',
									'transition_container_classes'=> "row",
                                    'taxonomy' => $taxonomyArg,
                                    'taxonomy_terms' => $taxonomyTermArg,
									'orderby'        => 'meta_value_num',
									'meta_key'       => '_wc_review_count',
									'order'          => 'DESC',
									'meta_query'     => array(
										'relation' => 'AND',
										array(
											'key'     => '_wc_review_count',
											'value'   => 0,
											'compare' => '>',
											'type'    => 'NUMERIC',
										),
									),
								);
								if(function_exists('alm_render')){
									alm_render($args);
								}
								wp_reset_postdata();
								// Product Taxonomy Archive
//								echo do_shortcode( '[ajax_load_more transition_container_classes="row" woocommerce="true" post_type="product" "' . $taxonomyArg . '" "' . $taxonomyTermArg . '"  taxonomy_operator="IN" css_classes="" posts_per_page="12" transition="fade" button_label="View More Products" button_loading_label="Loading Products..."]' );
							} else {
//                                     Shop Landing Page
								echo "<p>" . woocommerce_page_title() . " category have not products.</p>";
							}
						}

//						wc_get_template_part( 'content', 'product' );
//					}
					}

					woocommerce_product_loop_end();

					/**
					 * Hook: woocommerce_after_shop_loop.
					 *
					 * @hooked woocommerce_pagination - 10
					 */
					do_action( 'woocommerce_after_shop_loop' );
				} else {
					/**
					 * Hook: woocommerce_no_products_found.
					 *
					 * @hooked wc_no_products_found - 10
					 */
					do_action( 'woocommerce_no_products_found' );
				}

				/**
				 * Hook: woocommerce_after_main_content.
				 *
				 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
				 */
				do_action( 'woocommerce_after_main_content' );
				wp_reset_postdata();
				?>
            </div>
        </div>
    </div>

<?php

get_footer( 'shop' );