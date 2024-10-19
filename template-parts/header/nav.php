<?php
/**
 * Header Navigation Template
 *
 * @package Asgard
 */

$menu_class     = \ASGARD_THEME\Inc\Menus::get_instance();
$header_menu_id = $menu_class->get_menu_id( 'asgard-main-menu' );

$header_menus = wp_get_nav_menu_items( $header_menu_id );
?>
<nav class="navbar navbar-expand-lg  navbar-main border-bottom border-opacity-10 border-success bg-primary" data-bs-theme="light">
    <div class="container position-relative">
        <div class="mega-menu-title d-flex align-items-center position-relative d-none d-sm-none d-md-block">
            <!-- Offcanvas code is added on footer.php -->
            <!-- <a data-bs-toggle="offcanvas" href="#offcanvasGMA" role="button" aria-controls="offcanvasGMA"
               class="canvas-btn bg-primary p-1 rounded-1 d-md-none d-block pb-2 fw-semibold">
                <svg width="30" height="30" fill="green">
                    <use href="#icon-bar"></use>
                </svg>
            </a> -->

            <span class="nav-link fs-16 text-uppercase all-cate-text pt-0 pb-0 d-none d-sm-none d-md-flex align-items-center fw-semibold  px-3 text-bg-dark text-white border border-1 border-white rounded">
				<svg width="16" height="16" fill="green" class="me-2">
                    <use href="#icon-bar"></use>
                </svg> <span>All Categories </span>
			</span>
        </div>
        <div class="d-block d-sm-block d-md-none">
			<?php
			if ( shortcode_exists( 'fibosearch' ) ) {
				echo do_shortcode( '[fibosearch]' );
			}
			?>
        </div>
        <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse ms-lg-3 ms-md-0" id="navbarSupportedContent">
			<?php
			if ( ! empty( $header_menus ) && is_array( $header_menus ) ) {
				?>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-0 pt-sm-4 pt-md-4 pt-lg-0 pb-sm-2 pb-md-2 pb-lg-0">
				<?php
				foreach ( $header_menus as $menu_item ) {
					// Compare menu object with current page menu object
					$active = ( $menu_item->object_id == get_queried_object_id() ) ? 'active' : '';
					if ( ! $menu_item->menu_item_parent ) {
						$child_menu_items   = $menu_class->get_child_menu_items( $header_menus, $menu_item->ID );
						$has_children       = ! empty( $child_menu_items ) && is_array( $child_menu_items );
						$has_sub_menu_class = ! empty( $has_children ) ? 'has-submenu' : '';
						$link_target        = ! empty( $menu_item->target ) && '_blank' === $menu_item->target ? '_blank' : '_self';
						if ( ! $has_children ) {
							?>
                            <li class="nav-item">
                                <a class="text-white text-capitalize fs-14 nav-link px-lg-3 px-md-0 nav-link text-decoration-none fw-semibold <?php echo $active; ?>"
                                   aria-current="page"
                                   target="<?php echo esc_attr( $link_target ); ?>"
                                   href="<?php echo esc_url( $menu_item->url ); ?>"><?php echo esc_html( $menu_item->title ); ?></a>
                            </li>
							<?php
						} else {
							?>
                            <li class="nav-item dropdown">
                                <a class="text-white text-capitalize fs-14 nav-link dropdown-toggle px-lg-3 px-md-0 nav-link text-decoration-none fw-semibold"
                                   href="<?php echo esc_url( $menu_item->url ); ?>" id="navbarDropdown" role="button"
                                   data-bs-toggle="dropdown" aria-expanded="false">
									<?php echo esc_html( $menu_item->title ); ?>
                                </a>
                                <ul class="dropdown-menu shadow" aria-labelledby="navbarDropdown">
									<?php foreach ( $child_menu_items as $child_menu_item ) {
										$activeChild = ( $child_menu_item->object_id == get_queried_object_id() ) ? 'active' : '';
										?>
                                        <li class="sub-menu-items"><a
                                                    class="fs-14 dropdown-item px-3 text-decoration-none fw-semibold <?php echo $activeChild; ?>"
                                                    href="<?php echo esc_url( $child_menu_item->url ); ?>"><?php echo esc_html( $child_menu_item->title ); ?></a>
                                        </li>
									<?php } ?>
                                </ul>
                            </li>
							<?php
						}
					}
				}
				?>
                <li class="nav-item d-block d-sm-block d-md-none d-lg-none"><a
                            href="<?php echo get_permalink( wc_get_page_id( 'myaccount' ) ); ?>"
                            class="text-uppercase fs-14 nav-link px-lg-3 px-md-0 nav-link text-decoration-none fw-semibold">My account</a></li>
				<?php
				if ( is_user_logged_in() ) {
					if ( class_exists( 'WooCommerce' ) ) {
						$logout_link = wp_logout_url( get_permalink( wc_get_page_id( 'myaccount' ) ) );
					} else {
						$logout_link = wp_logout_url( get_home_url() );
					}
					?>
                    <li class="nav-item d-block d-sm-block d-md-none d-lg-none">

                        <a href="<?php echo esc_url( $logout_link ); ?>"
                           class="text-uppercase fs-14 nav-link px-lg-3 px-md-0 nav-link text-decoration-none fw-semibold ">Logout</a>

                    </li>
					<?php
				} else {
					$login_link = $register_link = '';
					if ( class_exists( 'WooCommerce' ) ) {
						$login_link = wc_get_page_permalink( 'myaccount' );
						if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) {
							$register_link = wc_get_page_permalink( 'myaccount' );
						}
					} else {
						$login_link    = wp_login_url( get_home_url() );
						$active_signup = get_site_option( 'registration', 'none' );
						$active_signup = apply_filters( 'wpmu_active_signup', $active_signup );
						if ( $active_signup != 'none' ) {
							$register_link = wp_registration_url( get_home_url() );
						}
					}
					?>
                    <li class="nav-item d-block d-sm-block d-md-none d-lg-none"><a
                                href="<?php echo esc_url( $login_link ); ?>"
                                class="text-uppercase fs-14 nav-link px-lg-3 px-md-0 nav-link text-decoration-none fw-semibold">Login</a>
                    </li>
					<?php
					if ( $register_link ) {
						?>
                        <li class="nav-item d-block d-sm-block d-md-none d-lg-none"><a
                                    href="<?php echo esc_url( $register_link ); ?>"
                                    class="text-uppercase fs-14 nav-link px-lg-3 px-md-0 nav-link text-decoration-none fw-semibold">Register</a>
                        </li>
						<?php
					}
				}
				?>
                </ul><?php
			}
			?>
            <div class="offer-zone pb-sm-4 pb-md-4 pb-lg-0">
                <?php
//                $category = get_term_by( 'slug', 'offer-zone', 'product_cat' );
//                if(!empty($category)) {
//	                $cat_id = $category->term_id;
//	                $category_link = get_category_link( $cat_id );
//                } else {
//                    echo 'category slug not found';
//                }

                ?>
<!--                <a href="--><?php //echo esc_url( $category_link ); ?><!--" class="badge text-bg-danger fs-14 text-decoration-none fw-normal">Offer Zone</a>-->
            </div>
        </div>
        <div class="show_mega_menu_block bg-white position-absolute start-0 end-0 mx-auto my-0 border-start border-end border-bottom border-opacity-25 border-secondary shadow rounded-bottom d-none invisible"
             id="mega_menu_block">
            <div class="row mx-0">
				<?php
				echo do_shortcode( '[display_mega_menu]' );
				?>
            </div>
        </div>
    </div>
</nav>

<?php

?>
