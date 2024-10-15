<?php
/**
 * Woocommerce Hooks Customization
 *
 * @package Asgard
 */

namespace ASGARD_THEME\Inc;

use ASGARD_THEME\Inc\Traits\Singleton;

class Asgard_Shortcodes {
	use Singleton;

	protected function __construct() {
		$this->setup_hooks();
	}

	protected function setup_hooks() {
		// shortcodes
		add_shortcode( 'display_mega_menu', [ $this, 'mega_menu_function' ] );
		add_shortcode( 'current_year', [ $this, 'asgard_current_year' ] );
	}

	public function get_worldcollection_category_tree( $cat ) {
		$next = get_categories( 'taxonomy=product_cat&depth=2&hide_empty=0&orderby=title&order=ASC&parent=' . $cat );
		if ( $next ) :
			foreach ( $next as $cat ) {
				global $allCount;
				$allCount ++;
				$this->get_worldcollection_category_tree( $cat->term_id );
			}
		endif;
	}

	public function mega_menu_function() {
		/**
		 * Display Mega Menu On home page hover on all categories.
		 * Use shortcode: [display_mega_menu]
		 */
		global $allCount;
		$product_cat = '';

		$this->get_worldcollection_category_tree( 0 );

		$args        = array(
			'taxonomy'   => 'product_cat',
			'hide_empty' => false,
			'parent'     => 0
		);
		$product_cat = get_terms( $args );

		$countchildren               = count( $product_cat );
		$totalCategoryInSingleColumn = (int)$allCount / 4;
		$cnt                         = 1;
		$total                       = 0;
		ob_start();
		echo '<div class="col-sm-3 single-menu-column p-3">';

		foreach ( $product_cat as $parent_product_cat ) {
			$total = $cnt % (int)$totalCategoryInSingleColumn;

			if ( $total == 0 ) {
				echo '</div><div class="col-sm-3 single-menu-column p-3">';
			}
			echo '<ul class="parent-category list-unstyled m-0 ' . $cnt ++ . '===' . $totalCategoryInSingleColumn . '==' . $total . '">
                        <li><a href="' . get_term_link( $parent_product_cat->term_id ) . '" class="parent-category-a text-decoration-none text-primary p-1 position-relative lh-2 d-inline-block text-left w-100">' . $parent_product_cat->name . '<span class="arrow-menu"></span></a>
                      <ul class="list-unstyled my-1">';

			$child_args         = array(
				'taxonomy'   => 'product_cat',
				'hide_empty' => false,
				'parent'     => $parent_product_cat->term_id
			);
			$child_product_cats = get_terms( $child_args );
			foreach ( $child_product_cats as $child_product_cat ) {
				$total = $cnt % (int)$totalCategoryInSingleColumn;
				echo '<li class="' . $cnt ++ . '===' . $totalCategoryInSingleColumn . '==' . $total . '"><a href="' . get_term_link( $child_product_cat->term_id ) . '" class="text-decoration-none text-primary p-1 position-relative lh-1 d-inline-block text-left w-100 fw-200">' . $child_product_cat->name . '</a></li>';

				if ( $total == 0 ) {
					echo '</ul></div><div class="col-sm-3 single-menu-column p-3"><ul class="list-unstyled my-1 sub-categories">';
				}
			}
			echo '</ul>
                </li>
              </ul>';
		}
		echo '</div>';
		$data     = ob_get_clean();
		$allCount = 0;
		wp_reset_query();

		return $data;
	}

	public function asgard_current_year(){
		return date_i18n ('Y');
	}

}