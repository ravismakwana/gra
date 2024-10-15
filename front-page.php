<?php

/**
 * Front Page Template
 *
 * @package Asgard
 */

get_header();

?>
<div id="primary" class="front-page">


		<?php
		if ( have_posts() ) {

			while ( have_posts() ) : the_post();
//				get_template_part( 'template-parts/content', 'page' );
            the_content();
			endwhile;

		} else {
			get_template_part( 'template-parts/content', 'none' );
		}
		?>
</div>
<?php get_footer(); ?>

