<?php
/**
 * Blog Template
 *
 * @package Asgard
 */
$container_classes = ( ! empty( $args['container_classes'] ) || ( is_blog() ) ) ? ( $args['container_classes'] ?? '' ) : 'mb-5';

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( $container_classes ); ?>>
	<?php if ( ! is_single() ) { ?>
        <div class="card h-100">
			<?php
			get_template_part( 'template-parts/components/blog/entry-header' );
			//get_template_part( 'template-parts/components/blog/entry-meta' );
			get_template_part( 'template-parts/components/blog/entry-content' );
			//get_template_part( 'template-parts/components/blog/entry-footer' );
			?>
        </div>
	<?php } else {

        get_template_part( 'template-parts/components/blog/entry-header' );
        get_template_part( 'template-parts/components/blog/entry-meta' );
        get_template_part( 'template-parts/components/blog/entry-content' );
        // get_template_part( 'template-parts/components/blog/entry-footer' );
	}
	?>
</article>