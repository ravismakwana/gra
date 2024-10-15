<?php
/**
 * Three Columns Block Template Content
 *
 * @package Asgard
 */
$column1 = ASGARD_BUILD_IMG_URI.'/patterns/c1-150x150.jpeg';
$column2 = ASGARD_BUILD_IMG_URI.'/patterns/c2-150x150.jpeg';
$column3 = ASGARD_BUILD_IMG_URI.'/patterns/c3-150x150.jpeg';
?>
<!-- wp:group -->
<div class="wp-block-group"><!-- wp:columns {"verticalAlignment":null} -->
	<div class="wp-block-columns"><!-- wp:column {"verticalAlignment":"center"} -->
		<div class="wp-block-column is-vertically-aligned-center"><!-- wp:image {"align":"center","id":1994,"width":150,"height":150,"sizeSlug":"thumbnail","linkDestination":"none","className":"is-style-rounded"} -->
			<div class="wp-block-image is-style-rounded"><figure class="aligncenter size-thumbnail is-resized"><img src="<?php echo esc_url($column1); ?>" alt="" class="wp-image-1994" width="150" height="150"/></figure></div>
			<!-- /wp:image -->

			<!-- wp:heading {"textAlign":"center"} -->
			<h2 class="has-text-align-center">Heading One</h2>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"align":"center"} -->
			<p class="has-text-align-center"><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
			<!-- /wp:paragraph --></div>
		<!-- /wp:column -->

		<!-- wp:column {"verticalAlignment":"center"} -->
		<div class="wp-block-column is-vertically-aligned-center"><!-- wp:gallery {"linkTo":"none","sizeSlug":"thumbnail","align":"center"} -->
			<figure class="wp-block-gallery aligncenter has-nested-images columns-default is-cropped"><!-- wp:image {"id":2020,"sizeSlug":"thumbnail","linkDestination":"none","style":{"color":{"duotone":["#000000","#00a5ff"]}},"className":"is-style-rounded"} -->
				<figure class="wp-block-image size-thumbnail is-style-rounded"><img src="<?php echo esc_url($column2); ?>" alt="" class="wp-image-2020"/></figure>
				<!-- /wp:image --></figure>
			<!-- /wp:gallery -->

			<!-- wp:heading {"textAlign":"center"} -->
			<h2 class="has-text-align-center">Heading Two</h2>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"align":"center"} -->
			<p class="has-text-align-center"><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
			<!-- /wp:paragraph --></div>
		<!-- /wp:column -->

		<!-- wp:column {"verticalAlignment":"center"} -->
		<div class="wp-block-column is-vertically-aligned-center"><!-- wp:image {"align":"center","id":1953,"sizeSlug":"thumbnail","linkDestination":"none","className":"is-style-rounded"} -->
			<div class="wp-block-image is-style-rounded"><figure class="aligncenter size-thumbnail"><img src="<?php echo esc_url($column3); ?>" alt="" class="wp-image-1953"/></figure></div>
			<!-- /wp:image -->

			<!-- wp:heading {"textAlign":"center"} -->
			<h2 class="has-text-align-center">Heading Three</h2>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"align":"center"} -->
			<p class="has-text-align-center"><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
			<!-- /wp:paragraph --></div>
		<!-- /wp:column --></div>
	<!-- /wp:columns --></div>
<!-- /wp:group -->
