<?php
/**
 *  Main Page file
 *
 * @package Asgard
 */

get_header();
?>
    <div id="primary">
        <div id="main">
			<?php
			if ( have_posts() ) {
			?>
            <div class="container bg-white p-3 p-lg-5 my-3 my-lg-5">
                <div class="row">
					<?php
					if ( ! is_order_received_page() ) {
						?>
                        <header class="col-12">
                            <h1 class="page-title my-3 h3 fw-bold"><?php single_post_title(); ?></h1>
                        </header>
						<?php
					}
					?>
                    <div class="col-12"><?php
						while ( have_posts() ) : the_post();
							the_content();
						endwhile;
						?>
                    </div>
                </div>

				<?php
				} else {
					get_template_part( 'template-parts/content', 'none' );
				}
				?></div><?php
			?>
        </div>
    </div>
<?php
get_footer();