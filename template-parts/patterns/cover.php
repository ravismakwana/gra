<?php
/**
 * Cover Block Template Content
 *
 * @package Asgard
 */
$cover_default_img_url = ASGARD_BUILD_IMG_URI.'/patterns/bg.jpeg';
?>
<!-- wp:cover {"url":"<?php echo esc_attr($cover_default_img_url); ?>","id":2020,"dimRatio":50,"minHeight":600,"align":"full","style":{"color":{"duotone":["#000000","#00a5ff"]}}} -->
<div class="wp-block-cover alignfull" style="min-height:600px"><span aria-hidden="true" class="wp-block-cover__gradient-background has-background-dim"></span><img class="wp-block-cover__image-background wp-image-2020" alt="" src="<?php echo esc_attr($cover_default_img_url); ?>" data-object-fit="cover"/><div class="wp-block-cover__inner-container"><!-- wp:paragraph {"align":"center","fontSize":"large"} -->
		<p class="has-text-align-center has-large-font-size">&nbsp;“<strong><em>Life is really simple, but men insist on making it complicated.” </em></strong></p>
		<!-- /wp:paragraph -->

		<!-- wp:paragraph {"align":"center","textColor":"cyan-bluish-gray"} -->
		<p class="has-text-align-center has-cyan-bluish-gray-color has-text-color">- Confucius</p>
		<!-- /wp:paragraph --></div></div>
<!-- /wp:cover -->