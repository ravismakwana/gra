<?php
/**
 * Archive Page template file.
 *
 * @package Asgard
 */

get_header();

?>
    <div id="primary">
        <main id="main" class="site-main mb-5" role="main">
            <div class="container">

                <header class="page-header">
					<?php
					if ( ! empty( single_term_title( '', false ) ) ) {
						printf(
							'<h1 class="page-title my-3 h3 fw-bold">Category: %s</h1>',
							single_term_title( '', false )
						);
					}
					if ( ! empty( get_the_archive_description() ) ) {
						the_archive_description( '<div class="archive-description">', '</div>' );
					}
					?>
                </header>
                <!-- .page-header -->
                <div class="site-content">
                    <div class="row">
						<?php
						if ( have_posts() ) :
							while ( have_posts() ) : the_post();
								get_template_part( 'template-parts/content', '', [ 'container_classes' => 'mt-0 col-lg-4 col-md-6 col-sm-12 pb-3 pb-sm-4' ] );
							endwhile;
						else :
							get_template_part( 'template-parts/content-none' );
						endif;
						?>
                    </div>
                    <div>
						<?php asgard_pagination(); ?>
                    </div>
                </div>
            </div>
        </main>
    </div>

<?php

get_footer();