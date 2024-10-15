<?php
/**
 * Gets the thumbnail with Lazy Load.
 * Should be called in the WordPress Loop.
 *
 * @param int|null $post_id Post ID.
 * @param string $size The registered image size.
 * @param array $additional_attributes Additional attributes.
 *
 * @return string
 */
function get_the_post_custom_thumbnail( $post_id, $size = 'featured-thumbnail', $additional_attributes = [] ) {
	$custom_thumbnail = '';

	if ( null === $post_id ) {
		$post_id = get_the_ID();
	}

	if ( has_post_thumbnail( $post_id ) ) {
		$default_attributes = [
			'loading' => 'lazy'
		];

		$attributes = array_merge( $additional_attributes, $default_attributes );

		$custom_thumbnail = wp_get_attachment_image(
			get_post_thumbnail_id( $post_id ),
			$size,
			false,
			$attributes
		);
	}

	return $custom_thumbnail;
}

/**
 * Renders Custom Thumbnail with Lazy Load.
 *
 * @param int $post_id Post ID.
 * @param string $size The registered image size.
 * @param array $additional_attributes Additional attributes.
 */
function the_post_custom_thumbnail( $post_id, $size = 'featured-thumbnail', $additional_attributes = [] ) {
	echo get_the_post_custom_thumbnail( $post_id, $size, $additional_attributes );
}

/**
 * Shows the published date and modified date of posts
 */
/**
 * Prints HTML with meta information for the current post-date/time.
 *
 * @return void
 */
function asgard_posted_on() {

	$year                        = get_the_date( 'Y' );
	$month                       = get_the_date( 'n' );
	$day                         = get_the_date( 'j' );
	$post_date_archive_permalink = get_day_link( $year, $month, $day );

	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

	// Post is modified ( when post published time is not equal to post modified time )
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( DATE_W3C ) ),
		esc_attr( get_the_date() ),
		esc_attr( get_the_modified_date( DATE_W3C ) ),
		esc_attr( get_the_modified_date() )
	);

	$posted_on = sprintf(
		esc_html_x( 'Posted on %s', 'post date', 'asgard' ),
		'<a href="' . esc_url( $post_date_archive_permalink ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	echo '<span class="posted-on text-secondary">' . $posted_on . '</span>';
}

function asgard_posted_on_show_only_updated() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

	// Post is modified
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date updated" datetime="%1$s">%2$s</time>';
	}
	$time_string = sprintf( $time_string,
		esc_attr( get_the_modified_date( DATE_W3C ) ),
		esc_attr( get_the_modified_date() ),
	);
	$posted_on   = sprintf(
		esc_html_x( 'Posted on %s', 'post date', 'asgard' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);
	echo '<span class="posted-on text-secondary">' . $posted_on . '</span>';
}

/**
 * Show Author of post
 */
function asgard_posted_by() {
	$byline = sprintf(
		esc_html_x( ' by %s', 'post author', 'asgard' ),
		'<span class="author vcard"><a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);
	echo '<span class="byline text-secondary">' . $byline . '</span>';
}

/**
 * Get the trimmed version of post excerpt.
 *
 * This is for modifing manually entered excerpts,
 * NOT automatic ones WordPress will grab from the content.
 *
 * It will display the first given characters ( e.g. 100 ) characters of a manually entered excerpt,
 * but instead of ending on the nth( e.g. 100th ) character,
 * it will truncate after the closest word.
 *
 * @param int $trim_character_count Charter count to be trimmed
 *
 * @return bool|string
 */
function asgard_the_excerpt( $trim_character_count = 0 ) {
	$post_ID = get_the_ID();

	if ( empty( $post_ID ) ) {
		return null;
	}
	if ( has_excerpt() || 0 === $trim_character_count ) {
		the_excerpt();

		return;
	}
	$excerpt = wp_html_excerpt( get_the_excerpt( $post_ID ), $trim_character_count, '[...]' );
	echo $excerpt;
}

function asgard_excerpt_more() {
	if ( ! is_single() ) {
		$more = sprintf( '<a class="asgard-read-more text-white mt-3 btn btn-primary" href="%1$s">%2$s</a>',
			get_permalink( get_the_ID() ),
			__( 'Read more', 'asgard' )
		);
	}

	return $more;
}

function asgard_pagination() {
	$allowed_tags = [
		'span' => [
			'class' => []
		],
		'ul'   => [
			'class' => [],
		],
		'li'   => [
			'class' => [],
		],
		'a'    => [
			'class' => [],
			'href'  => [],
		],
	];
	$args         = [
		'type'      => 'array',
		'prev_next' => true,
		'prev_text' => __( '« Prev' ),
		'next_text' => __( 'Next »' ),
	];
	$pages        = paginate_links( $args );
	$pagination   = '';
	if ( is_array( $pages ) ) {
		$pagination = '<ul class="pagination justify-content-center">';
		foreach ( $pages as $page ) {
			$current_class = strpos( $page, 'current' ) ? 'active' : '';
			$pagination    .= '<li class="page-item ' . $current_class . '">' . str_replace( 'page-numbers', 'page-link', $page ) . '</li>';
		}
		$pagination .= '</ul>';
	}
	printf( '<nav class="asgard-pagination">%s</nav>', wp_kses( $pagination, $allowed_tags ) );
}

/**
 * Display Post pagination with prev next, first last, to, from
 *
 * @param $current_page_no
 * @param $posts_per_page
 * @param $article_query
 * @param $first_page_url
 * @param $last_page_url
 * @param bool $is_query_param_structure
 */
function asgard_the_post_pagination( $current_page_no, $posts_per_page, $article_query, $first_page_url, $last_page_url, bool $is_query_param_structure = true ) {
	$prev_posts  = ( $current_page_no - 1 ) * $posts_per_page;
	$from        = 1 + $prev_posts;
	$to          = count( $article_query->posts ) + $prev_posts;
	$of          = $article_query->found_posts;
	$total_pages = $article_query->max_num_pages;

	$base   = ! empty( $is_query_param_structure ) ? add_query_arg( 'page', '%#%' ) : get_pagenum_link( 1 ) . '%_%';
	$format = ! empty( $is_query_param_structure ) ? '?page=%#%' : 'page/%#%';

	?>
    <div class="mt-0 md:mt-10 mb-10 lg:my-5 flex items-center justify-end posts-navigation">
		<?php
		if ( 1 < $total_pages && ! empty( $first_page_url ) ) {
			printf(
				'<span class="mr-2">Showing %1$s - %2$s Of %3$s</span>',
				$from,
				$to,
				$of
			);
		}


		// First Page
		if ( 1 !== $current_page_no && ! empty( $first_page_url ) ) {
			printf( '<a class="first-pagination-link btn border border-secondary mr-2" href="%1$s" title="first-pagination-link">%2$s</a>', esc_url( $first_page_url ), __( 'First', 'asgard' ) );
		}

		echo paginate_links( [
			'base'      => $base,
			'format'    => $format,
			'current'   => $current_page_no,
			'total'     => $total_pages,
			'prev_text' => __( 'Prev', 'asgard' ),
			'next_text' => __( 'Next', 'asgard' ),
		] );

		// Last Page
		if ( $current_page_no < $total_pages && ! empty( $last_page_url ) ) {

			printf( '<a class="last-pagination-link btn border border-secondary ml-2" href="%1$s" title="last-pagination-link">%2$s</a>', esc_url( $last_page_url ), __( 'Last', 'asgard' ) );
		}

		?>
    </div>
	<?php
}

/**
 * Checks to see if the specified user id has a uploaded the image via wp_admin.
 *
 * @return bool  Whether or not the user has a gravatar
 */
function asgard_is_uploaded_via_wp_admin( $gravatar_url ) {

	$parsed_url = wp_parse_url( $gravatar_url );

	$query_args = ! empty( $parsed_url['query'] ) ? $parsed_url['query'] : '';

	// If query args is empty means, user has uploaded gravatar.
	return empty( $query_args );

}

/**
 * If the gravatar is uploaded returns true.
 *
 * There are two things we need to check, If user has uploaded the gravatar:
 * 1. from WP Dashboard, or
 * 2. or gravatar site.
 *
 * If any of the above condition is true, user has valid gravatar,
 * and the function will return true.
 *
 * 1. For Scenario 1: Upload from WP Dashboard:
 * We check if the query args is present or not.
 *
 * 2. For Scenario 2: Upload on Gravatar site:
 * When constructing the URL, use the parameter d=404.
 * This will cause Gravatar to return a 404 error rather than an image if the user hasn't set a picture.
 *
 * @param $user_email
 *
 * @return bool
 */
function asgard_has_gravatar( $user_email ) {

	$gravatar_url = get_avatar_url( $user_email );

	if ( asgard_is_uploaded_via_wp_admin( $gravatar_url ) ) {
		return true;
	}

	$gravatar_url = sprintf( '%s&d=404', $gravatar_url );

	// Make a request to $gravatar_url and get the header
	$headers = @get_headers( $gravatar_url );

	// If request status is 200, which means user has uploaded the avatar on gravatar site
	return preg_match( "|200|", $headers[0] );
}

function is_blog() {
	return ( is_archive() || is_author() || is_category() || is_home() || is_single() || is_tag() ) && 'post' == get_post_type();
}

if ( ! function_exists( 'asgard_mini_cart' ) ) {
	function asgard_mini_cart() {

		global $woocommerce;
		?>

        <div class="mini-cart m-0 text-start">
            <div data-hover="dropdown" class="basket fs-14 p-0 d-flex align-items-center justify-content-end">
                <a id="cart_badge" href="<?php echo esc_url( wc_get_cart_url() ); ?>"
                   class="m-0 d-flex text-decoration-none align-items-center" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                    <div class="position-relative p-0 cart-icon-button d-flex justify-content-center align-items-center h-auto w-auto">
                        <svg class="" width="25px" height="25px" fill="#818a91">
                            <use href="#icon-basket"></use>
                        </svg>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger fw-normal">
                            <?php echo esc_html( $woocommerce->cart->cart_contents_count ); ?>
                            <span class="visually-hidden">New alerts</span>
                        </span>
                    </div>
                </a>
            </div>
        </div>
		<?php
	}
}

/* Mobile Menu */
if (!class_exists('Canvas_Menu')) {
	class Canvas_Menu extends Walker_Nav_Menu {

		// add classes to ul sub menus
		function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
			$id_field = $this->db_fields['id'];
			if ( is_object( $args[0] ) ) {
				$args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
			}
			return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
		}

		// add main/sub classes to li's and links
		function start_lvl( &$output, $depth = 0, $args = array() ) {
			$indent = str_repeat("\t", $depth);
			$output .= "\n$indent<span class=\"arrow bg-primary position-absolute end-0 align-items-center justify-content-center d-flex rounded-1\"></span><ul class=\"sub-menu\">\n";
		}

		function end_lvl( &$output, $depth = 0, $args = array() ) {
			$indent = str_repeat("\t", $depth);
			$output .= "$indent</ul>\n";
		}

		// add main/sub classes to li's and links
		function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

			global $wp_query;

			$sub = "";
			$indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent
			if ( ( $depth >= 0 && $args->has_children ) || ( $depth >= 0 && $item->recentpost != "" ) )
				$sub = ' has-sub';

			$active = "";

			if ( $item->current || $item->current_item_ancestor || $item->current_item_parent )
				$active = 'active';

			// passed classes
			$classes = empty( $item->classes ) ? array() : (array) $item->classes;

			$class_names = esc_html( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );

			// build html
			$output .= $indent . '<li id="accordion-menu-item-'. esc_html($item->ID) . '" class=" position-relative bg-transparent text-white px-0 ' . $class_names . ' ' . $active . $sub .'">';

			$current_a = "";

			// link attributes
			$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_html( $item->attr_title ) .'"' : '';
			$attributes .= ! empty( $item->target )     ? ' target="' . esc_html( $item->target     ) .'"' : '';
			$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_html( $item->xfn        ) .'"' : '';
			$attributes .= ! empty( $item->url )        ? ' href="'   . esc_url( $item->url        ) .'"' : '';
			if ( ( $item->current && $depth == 0 ) || ( $item->current_item_ancestor && $depth == 0 ) )
				$current_a .= '   current  parent-list-group-item position-relative bg-transparent text-white px-0 border-0 ';

			$attributes .= ' class="'. $current_a . '"';
			$item_output = $args->before;

			if ( $item->hide == "" && $item->mobile_hide == "" ) {
				if ( $item->nolink == "" ) {
					$item_output .= '<a'. $attributes .'>';
				} else {
					$item_output .= '<h5>';
				}
				$item_output .= $args->link_before . ($item->icon ? '<i class="fa fa-' . str_replace('fa-', '', $item->icon) . '"></i>' : '') . apply_filters( 'the_title', $item->title, $item->ID );
				$item_output .= $args->link_after;
				if ($item->tip_label) {
					$item_style = '';
					$item_arrow_style = '';
					if ($item->tip_color) {
						$item_style .= 'color:'.$item->tip_color.';';
					}
					if ($item->tip_bg) {
						$item_style .= 'background:'.$item->tip_bg.';';
						$item_arrow_style .= 'color:'.$item->tip_bg.';';
					}
					$item_output .= '<span class="tip" style="'.$item_style.'"><span class="tip-arrow" style="'.$item_arrow_style.'"></span>'.$item->tip_label.'</span>';
				}
				if ( $item->nolink == "" ) {
					$item_output .= '</a>';
				} else {
					$item_output .= '</h5>';
				}
			}
			$item_output .= $args->after;


			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	}
}
if ( ! function_exists ( 'asgard_canvas_menu' ) ) {
	function asgard_canvas_menu() {

		$html = '';

		ob_start();
		if ( has_nav_menu( 'canvas-menu' ) ) :

			$args = array(
				'container' => '',
				'menu_class' => 'accordion-menu list-group list-group-flush bg-transparent m-0',
				'before' => '',
				'after' => '',
				'link_before' => '',
				'link_after' => '',
				'fallback_cb' => false,
				'walker' => new Canvas_Menu
			);

			$args['theme_location'] = 'canvas-menu';

			wp_nav_menu($args);
		endif;

		$output = str_replace('&nbsp;', '', ob_get_clean());


		if ($output && $html) {
			$output = preg_replace('/<\/ul>$/', $html . '</ul>', $output, 1);
		}

		return $output;
	}
}

function asgard_get_completed_orders_before_after($date_one, $date_two) {
	global $wpdb;
	$completed_orders = $wpdb->get_col(
		$wpdb->prepare(
			"SELECT posts.ID
         FROM {$wpdb->prefix}posts AS posts
         WHERE posts.post_type = 'shop_order'
         AND posts.post_status = 'wc-completed'
         AND posts.post_modified >= '%s'
         AND posts.post_modified <= '%s'",
			date('Y/m/d H:i:s', absint($date_one)),
			date('Y/m/d H:i:s', absint($date_two))
		)
	);

	return $completed_orders;
}
// Schedule an action if it's not already scheduled
if (!wp_next_scheduled('asgard_add_every_seven_days')) {
	wp_schedule_event(time(), 'every_seven_days', 'asgard_add_every_seven_days');
}

if ( ! function_exists ( 'asgard_canvas_right_cart' ) ) {
	function asgard_canvas_right_cart() {
		?>
        <div class="offcanvas offcanvas-end asgard_canvas_right_cart-main" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header border-bottom border-primary border-opacity-25">
                <h6 class="offcanvas-title text-primary" id="offcanvasRightLabel">Shopping Cart</h6>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body p-0">
                <div class="right_cart-main d-flex flex-column justify-content-between h-100">
                    <div class="right_cart-up offcanvas-body-inner">
				        <?php if (WC()->cart->get_cart_contents_count() > 0) : ?>
                            <ul class="mini-products-list list-unstyled mb-0 position-relative ms-0" id="cart-sidebar">
						        <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) : ?>
							        <?php
							        $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
							        if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key)) :
								        $product_name = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);
								        $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);
								        $product_price = apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
								        $product_permalink = $_product->is_visible() ? $_product->get_permalink($cart_item) : '';
								        ?>
                                        <li class="item d-inline-block border-bottom border-opacity-25 border-primary p-3 w-100">
                                            <div class="item-inner d-flex">
                                                <a class="product-image flex-shrink-0 border-1 border-primary border-opacity-25"
                                                   href="<?php echo esc_url($product_permalink); ?>"
                                                   title="<?php echo esc_html($product_name); ?>">
											        <?php echo wp_kses_post($thumbnail); ?>
                                                </a>
                                                <div class="product-details flex-grow-1 ms-3 position-relative">
                                                    <div class="access d-flex justify-content-end position-absolute top-0 end-0">
                                                        <a class="btn-edit"
                                                           title="<?php esc_attr_e('Edit item', 'asgard'); ?>"
                                                           href="<?php echo esc_url(wc_get_cart_url()); ?>">
                                                            <svg class="icon-pencil" width="12" height="12">
                                                                <use href="#icon-pencil"></use>
                                                            </svg>
                                                            <span class="hidden d-none"><?php esc_attr_e('Edit item', 'asgard'); ?></span>
                                                        </a>
                                                        <a href="<?php echo esc_url(wc_get_cart_remove_url($cart_item_key)); ?>"
                                                           title="<?php esc_attr_e('Remove This Item', 'asgard'); ?>"
                                                           class="btn-remove1 ms-3">
                                                            <svg class="icon-close" width="12" height="12">
                                                                <use href="#icon-close"></use>
                                                            </svg>
                                                        </a>
                                                    </div>
                                                    <strong><?php echo esc_html($cart_item['quantity']); ?></strong> x
                                                    <span class="price"><?php echo wp_kses_post($product_price); ?></span>
                                                    <a class="product-name mb-0 d-block text-decoration-none fs-12 link-primary"
                                                       href="<?php echo esc_url($product_permalink); ?>"
                                                       title="<?php echo esc_html($product_name); ?>">
												        <?php echo esc_html($product_name); ?>
                                                    </a>
                                                </div>
										        <?php echo wc_get_formatted_cart_item_data($cart_item); ?>
                                            </div>
                                        </li>
							        <?php endif; ?>
						        <?php endforeach; ?>
                            </ul>
				        <?php else: ?>
                            <p class="a-center noitem p-2 text-center">
                                <svg class="d-block mx-auto m-3" width="28" height="28" fill="#ccc">
                                    <use href="#icon-cart"></use>
                                </svg>
						        <?php esc_attr_e('No products in the cart.', 'asgard'); ?>
                            </p>
				        <?php endif; ?>
                    </div>

                </div>
            </div>
            <div class="offcanvas-footer right_cart-down border-top border-primary border-opacity-25 pb-3">
                <div class="right_cart-subtotal d-flex justify-content-between align-items-center p-3">
                    <h6 class="right_cart-subtotal-left text-primary mb-0">
				        <?php esc_html_e('Subtotal:', 'asgard'); ?>
                    </h6>
                    <div class="right_cart-subtotal-right">
				        <?php echo wp_kses_post(WC()->cart->get_cart_subtotal()); ?>
                    </div>
                </div>
                <div class="actions d-flex justify-content-center px-3 flex-column gap-2">
                    <a class="view-cart btn btn-success text-decoration-none text-uppercase"
                       href="<?php echo esc_js(wc_get_cart_url()); ?>">
                        <svg width="20" height="20" fill="#fff" class="me-1">
                            <use href="#icon-cart"></use>
                        </svg>
                        <span class="text-white"><?php esc_attr_e('View Cart', 'asgard'); ?></span>
                    </a>
                    <a class="btn-checkout btn btn-secondary text-uppercase text-white text-decoration-none"
                            title="<?php esc_attr_e('Checkout', 'asgard'); ?>"
                            type="button"
                            href="<?php echo esc_js(wc_get_checkout_url()); ?>">
                        <svg width="20" height="20" fill="#fff" class="me-1">
                            <use href="#icon-check"></use>
                        </svg>
                        <span><?php esc_attr_e('Checkout', 'asgard'); ?></span>
                    </a>

                </div>
            </div>

        </div>
		<?php
	}
}

if( ! function_exists('extractPhoneNumber')) {
	function extractPhoneNumber($text) {
		// Remove all characters except digits
		$phoneNumber = preg_replace("/[^0-9]/", "", $text);

		return $phoneNumber;
	}
}
if( ! function_exists('extractAndCreateWhatsAppLink')) {
	function extractAndCreateWhatsAppLink($text) {
		// Remove all characters except digits
		$phoneNumber = preg_replace("/[^0-9]/", "", $text);

		// Check if the phone number starts with a country code
		if (substr($phoneNumber, 0, 2) == '61') {
			// Remove the country code (assuming Australian number)
			$phoneNumber = substr($phoneNumber, 2);
		}

		// Create the WhatsApp API link
		$whatsappLink = 'https://api.whatsapp.com/send?phone=61' . $phoneNumber;

		return $whatsappLink;
	}
}

function get_single_product_category_by_id($product_id) {
	// Get the terms (categories) for the product
	$terms = wp_get_post_terms($product_id, 'product_cat');

	// Check if there are any terms and return the first one
	if (!empty($terms) && !is_wp_error($terms)) {
			return $terms[0]; // Return the first category found
	}

	// Return false if no terms found
	return false;
}

function my_custom_comment_form($fields) {
	// Modify the author field
	$fields['author'] = '<p class="comment-form-author">' .
											'<input id="author" name="author" type="text" placeholder="Name*" size="30" maxlength="245" required="required" /></p>';
	
	// Modify the email field
	$fields['email'] = '<p class="comment-form-email">' .
										 '<input id="email" name="email" type="email" placeholder="Email*" size="30" maxlength="100" required="required" /></p>';
	
	// Modify the url field
	$fields['url'] = '<p class="comment-form-url">' .
									 '<input id="url" name="url" type="url" placeholder="Website" size="30" maxlength="200" /></p>';

	return $fields;
}

function my_custom_comment_textarea($defaults) {
	// Modify the comment field
	$defaults['comment_field'] = '<p class="comment-form-comment">' .
															 '<textarea id="comment" name="comment" placeholder="Type here..." cols="45" rows="8" maxlength="65525" required="required"></textarea></p>';
	return $defaults;
}

add_filter('comment_form_default_fields', 'my_custom_comment_form');
add_filter('comment_form_defaults', 'my_custom_comment_textarea');
