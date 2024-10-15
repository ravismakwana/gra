<?php
/**
 * Footer Template
 *
 * @package Asgard
 */
?>

</div>
<footer>
    <div class="footer-widget bg-primary pt-sm-0 pt-md-0">
        <div class="footer-top mb-5 border-bottom border-black py-4 py-lg-0">
            <div class="container">
            <div class="row align-items-center ">
			<div class="col-lg-3 col-sm-12 col-12 justify-content-start py-3">
					<h5 class="text-white d-flex align-items-center justify-content-center justify-content-lg-start mb-0">
						<svg height="28px" fill="#fff" width="28px" class="me-2"><use href="#icon-email"></use></svg> Sign up to&nbsp;Newsletter
					</h5>
				</div>
				<div class="col-lg-6 col-sm-12 col-12 justify-content-center py-3">
					<?php echo do_shortcode('[fluentform id="2"]'); ?>
				</div>
				<div class="col-lg-3 col-sm-12 col-12 d-flex justify-content-center justify-content-lg-end py-3">
					<ul class="list-inline mb-0">
						<li class="list-inline-item">
						<a href="https://www.facebook.com/goodrxaustralia" target="_blank" title="Facebook" rel="nofollow" aria-label="Facebook"><svg height="25" width="25" fill="#ffffff"><use href="#icon-facebook"></use></svg></a>
						</li>
						<li class="list-inline-item">
						<a href="https://twitter.com/GRxaustralia" target="_blank" title="Twitter" rel="nofollow" aria-label="Twitter"><svg height="25" width="25" fill="#ffffff"><use href="#icon-twitter"></use></svg></a>
							</li>
						<li class="list-inline-item">
						<a href="https://www.instagram.com/goodrxaustralia/" target="_blank" title="Instagram" rel="nofollow" aria-label="Instagram"><svg height="25" width="25" fill="#ffffff"><use href="#icon-instagram"></use></svg></a> 
							</li>
						<li class="list-inline-item">
						<a href="https://in.pinterest.com/goodrxaustralia/" target="_blank" title="Pinterest" rel="nofollow" aria-label="Pinterest"><svg height="25" width="25" fill="#ffffff"><use href="#icon-pinterest"></use></svg></a> 
							</li>
						<li class="list-inline-item">
						<a href="https://www.linkedin.com/in/goodrxaustralia-online-pharmacy-09bb362bb/" target="_blank" title="Linked IN" rel="nofollow" aria-label="Linked IN"><svg height="25" width="25" fill="#ffffff"><use href="#icon-linkedin"></use></svg></a>
							</li>
					</ul>
				</div>			
		</div>
            </div>
        </div>
        <div class="container">
        
        <div class="row">
            <div class="col-lg-3 col-md-6 col-12 pt-2 pt-md-0 pb-md-5 mb-4 mb-md-0">
                <?php if ( is_active_sidebar( 'footer-1' ) ) { ?>
                    <?php dynamic_sidebar( 'footer-1' ); ?>
                <?php } ?>
            </div>
            <div class="col-lg-3 col-md-6 col-12 pt-2 pt-md-0 pb-md-5 mb-4 mb-md-0">
                <?php if ( is_active_sidebar( 'footer-2' ) ) { ?>
                    <?php dynamic_sidebar( 'footer-2' ); ?>
                <?php } ?>
            </div>
            <div class="col-lg-3 col-md-6 col-12 pt-2 pt-md-0 pb-md-5 mb-4 mb-md-0">
                <?php if ( is_active_sidebar( 'footer-3' ) ) { ?>
                    <?php dynamic_sidebar( 'footer-3' ); ?>
                <?php } ?>
            </div>
            <div class="col-lg-3 col-md-6 col-12 pt-2 pt-md-0 pb-md-5 mb-4 mb-md-0">
                <?php if ( is_active_sidebar( 'footer-4' ) ) { ?>
                    <?php dynamic_sidebar( 'footer-4' ); ?>
                <?php } ?>
            </div>
        </div>
        </div>
    </div>
    <div class="footer-copyright bg-primary text-center text-white py-3 border-top border-black">
        <div class="container">
            <div class="row">
	            <?php
	            $domain = get_option('siteurl'); //or home
	            $domain = str_replace('https://www.', '', $domain);
	            ?>
                <div class="col-12 fs-12 text-center">Copyright © <?php echo date( 'Y' ); ?> | <a href="<?php echo home_url(); ?>" class="text-white text-decoration-none"><?php echo get_option( 'blogname' ); ?>.</a> All Rights Reserved.
                </div>
                <!-- <div class="col-md-6 col-12 fs-12 text-md-end text-center my-1">Powered By <?php echo get_option( 'blogname' ); ?></div> -->
            </div>
        </div>
    </div>
</footer>
</div>

<?php
wp_footer();
get_template_part( 'template-parts/content', 'svgs' );
?>
<a href="https://api.whatsapp.com/send?phone=61731032369" class="whatsapp-btn position-fixed d-none" target="_blank" aria-label="whatsapp message"><svg class="" width="60px" height="60px" fill="#067e69"><use href="#icon-whatsapp"></use></svg></a>
<!-- <div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="offcanvasGMA" aria-labelledby="offcanvasGMALabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasAMLabel">All Categories</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
		<?php //echo asgard_canvas_menu(); ?>
    </div>
</div> -->
<?php echo asgard_canvas_right_cart(); ?>
</body>
</html>
