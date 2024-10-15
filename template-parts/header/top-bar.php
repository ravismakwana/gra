<?php

/**
 * Header TopBar Template
 *
 * @package Asgard
 */

$menu_class     = \ASGARD_THEME\Inc\Menus::get_instance();
$header_menu_id = $menu_class->get_menu_id( 'asgard-main-menu' );
?>
<div class="header-top-bar-main bg-success text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xs-12 col-sm-4 col-md-6 col-lg-6 hidden-xs d-none d-sm-none d-md-block">
                <div class="links d-flex justify-content-start align-self-center align-self-stretch fw-normal gap-1">
                Get a 20% discount on all medicine: Use code<strong> DMA20</strong>
                </div>
                <!-- End Header Top Links -->
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 text-center text-sm-center text-md-end">
                <div class="block-currency-wrapper">
                    <ul class="list-inline list-unstyled mx-0 text-white">
                        <li class="">
                            <a href="mailto:admin@goodrxaustralia.com" class="text-decoration-none fw-normal text-white" aria-label="Mail Us ">admin@goodrxaustralia.com
                            </a>
                        </li>
                        <li class="d-inline-block px-md-3">
                            <ul class="list-inline list-unstyled mx-0 text-white top-social-icons">
                                <li>
                                    <a href="https://www.facebook.com/goodrxaustralia" target="_blank" class="icon-facebook d-flex justify-content-center align-items-center rounded-1">
                                        <svg class="" width="11px" height="11px" fill="#fff"><use href="#icon-facebook"></use></svg>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://twitter.com/GRxaustralia"  target="_blank" class="icon-twitter d-flex justify-content-center align-items-center rounded-1">
                                        <svg class="" width="11px" height="11px" fill="#fff"><use href="#icon-twitter"></use></svg>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="px-md-0 d-none d-sm-inline-block">
                            <div class="track-btn">
                                <a href="javascript:void(0)" target="_blank"
                                   class="text-decoration-none fw-bold text-white">Ship To Wordwide</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>