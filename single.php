<?php
/**
 *  Single Blog Page
 *
 * @package Asgard
 */

get_header();
?>

    <div id="primary">
        <div id="main" class="">
			<?php
			if(have_posts()) {
			?>
            <div class="container bg-white p-3 p-lg-5 mt-3 mt-lg-5">
                <div class="row">
                    <div class="col-12 mt-3">
						<?php
						if(is_home() && (!is_front_page())) {
							?>
                            <header>
                                <h1 class="page-title mb-5"><?php single_post_title(); ?></h1>
                            </header>
							<?php
						}
						?>

						<?php

						while(have_posts()) : the_post();
							get_template_part('template-parts/content');
						endwhile;
						?>


						<?php
						} else {
							get_template_part('template-parts/content', 'none');
						}
						?>
                    </div>
                </div>
            </div>
        </div>
    </div>
		<div class="container py-4">
			<div class="row">
					<div class="col-6 text-left">
							<?php previous_post_link('%link', '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16"><path d="M15 18l-6-6 6-6" fill="none" stroke="currentColor" stroke-width="2"/></svg> Previous Post', TRUE); ?>
					</div>
					<div class="col-6 text-right">
							<?php next_post_link('%link', 'Next Post <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16"><path d="M9 6l6 6-6 6" fill="none" stroke="currentColor" stroke-width="2"/></svg>', TRUE); ?>
					</div>
			</div>
		</div>
		<div class="container  bg-white p-3 mb-4">
			<div class="single-last-comment">
				<?php comment_form(); ?>
			</div>
		</div>
<?
get_footer();