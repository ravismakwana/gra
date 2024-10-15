<?php

/**
 * Header MiddleBar Template
 *
 * @package Asgard
 */

$menu_class = \ASGARD_THEME\Inc\Menus::get_instance();
$header_menu_id = $menu_class->get_menu_id('asgard-main-menu');
?>
<div class="middle-bar py-3 border-top border-bottom border-opacity-10 border-success">
    <div class="container">
        <div class="row d-flex justify-content-between align-items-center">
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-6 logo-block">
	            <?php
	            if ( function_exists( 'the_custom_logo' ) ) {
		            the_custom_logo();
	            }
	            ?>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-3 category-search-form d-none d-sm-none d-md-block">
                <?php
                if ( shortcode_exists( 'fibosearch' ) ) {
	                echo do_shortcode('[fibosearch]');
                }
                ?>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-6 card_wishlist_area">
	            <?php if (class_exists('WooCommerce')) { ?>
                <div class="top-cart-contain position-relative d-flex justify-content-end align-items-center">
                    <div class="header-whatsapp me-2 me-md-3 d-none">
                        <a href="https://api.whatsapp.com/send?phone=61731032369" target="_blank"><svg class="" width="32px" height="32px" fill="#067e69"><use href="#icon-whatsapp"></use></svg></a>
                    </div>
                    <div class="header-whatsapp me-2 me-md-3">
                        <a href="/my-account/"><svg class="" width="22px" height="25px" fill="#000"><use href="#icon-user-outline"></use></svg></a>
                    </div>
		            <?php asgard_mini_cart(); ?>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>