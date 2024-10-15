<?php
/**
 * Posts carousel
 *
 * @package Asgard
 */

$args = [
	'posts_per_page'            => 5,
	'post_type'                 => 'post',
	'update_post_meta_cache'    => false,
	'update_post_term_cache'    => false,
];

$post_query = new WP_Query( $args );
?>
<div class="container">
	<div class="posts-slider-section">
		<div class="row posts-slider">
<!--			<div class="posts-slider">-->
			<?php
			if($post_query->have_posts()) {
				while( $post_query->have_posts() ) {
					$post_query->the_post();
					?>
					<div class="col m-3">
					<div class="card h-100">
						<?php if( has_post_thumbnail() ) {
							the_post_custom_thumbnail(
								get_the_ID(),
								'featured-thumbnail',
								[
									'sizes' => '(max-width: 350px) 350px, 233px',
									'class' => 'card-img-top'
								]
							);
						} ?>
						<div class="card-body">
							<?php the_title('<h3 class="card-title">', '</h5>'); ?></h3>
							<p class="card-text"><?php asgard_the_excerpt(); ?></p>
							<a href="<?php echo esc_url(get_the_permalink()); ?>" class="fs-14 btn btn-primary rounded-pill"><?php esc_html_e('View more', 'asgard'); ?></a>
                            <button class="btn btn-feature btn-danger">Feature</button>
						</div>
					</div>
					</div>
					<?php
				}
			}
			wp_reset_postdata();
			?>
<!--			</div>-->
		</div>
	</div>
</div>
