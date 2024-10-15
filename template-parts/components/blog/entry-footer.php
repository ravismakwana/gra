<?php
/**
 * Template for entry footer
 *
 * @package Asgard
 */
$the_post_id = get_the_ID();
$the_posts_terms = wp_get_post_terms($the_post_id, ['category', 'post_tag'] );
if(empty($the_posts_terms) || !is_array($the_posts_terms)) {
	return;
}
?>
<div class="entry-footer mt-3">
	<?php
	$category_count = count($the_posts_terms);
	$category_text = _n('Category: ', 'Categories: ', $category_count);
	echo "<span>$category_text</span>";
		foreach ($the_posts_terms as $key => $the_posts_term) {
			?>
			<a href="<?php echo esc_url(get_term_link($the_posts_term->term_id)); ?>" class="btn-link mr-5 mb-2"><?php echo esc_html($the_posts_term->name); ?></a>
			<?php

		}
	?>
</div>
<?php if(!is_single()) { ?>
</div>
<?php } ?>
