<?php
/**
 * Custom Search Form
 *
 */
?>
<form method="get" class="search-form d-flex" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<span class="screen-reader-text"><?php echo esc_attr_x( 'Search for:', 'label', 'asgard' ); ?></span>
	<input class="form-control me-2 search-field" type="search" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder' ,'asgard' ); ?>" value="<?php echo get_search_query(); ?>" name="s" aria-label="Search">
	<button class="btn btn-outline-success search-submit" type="submit"><?php echo esc_attr_x( 'Search', 'submit button', 'asgard' ); ?></button>
</form>
