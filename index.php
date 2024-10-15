<?php
/**
 *  Main Index file
 *
 * @package Asgard
 */

get_header();
?>
<div id="primary">
    <div id="main" class="mb-5">
        <?php
            if(have_posts()) {
                ?>
                <div class="container">
                    <?php
                        if(is_home() && (!is_front_page())) {
                            ?>
                            <header>
                                <h1 class="page-title my-3 h3 fw-bold"><?php single_post_title(); ?></h1>
                            </header>
                            <?php
                        }
                        ?>
                    <div class="row row-cols-1 row-cols-md-3">
                        <?php
                        while(have_posts()) : the_post();
	                        get_template_part( 'template-parts/content', '', [ 'container_classes' => 'mt-0 col-lg-4 col-md-6 col-sm-12 pb-3 pb-sm-4' ] );
                        endwhile;
                        ?>
                    </div>

                <?php
            } else {
	            get_template_part('template-parts/content', 'none');
            }
            asgard_pagination();
            ?></div><?php
        ?>
    </div>
</div>
<?php
get_footer();
