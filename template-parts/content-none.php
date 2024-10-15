<?php
/**
 * Blog not found Template
 *
 * @package Asgard
 */
?>
<div class="not-found">
    <header class="page-header">
        <h1 class="page-title"><?php esc_html_e( 'Nothing found', 'asgard' ); ?></h1>
    </header>

    <div class="page-content">
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) {
			?>
            <p>
				<?php
				printf(
					wp_kses(
						__( 'Ready to publish your first post? <a href="%s">Get Started Here</a>', 'asgard' ),
						[
							'a' => [
								'href' => []
							]
						]
					),
					esc_url( admin_url( 'post-new.php' ) )
				)
				?>
            </p>
			<?php
		} elseif ( is_search() ) {
			?>
            <p><?php esc_html_e( 'Sorry not found, please try again with some different keyword' . 'asgard' ); ?></p>
			<?php
			get_search_form();
		} else {
			?>
            <p><?php esc_html_e( 'Sorry, not found', 'asgard' ); ?></p>
			<?php
			get_search_form();
		}
		?>
    </div>
</div>