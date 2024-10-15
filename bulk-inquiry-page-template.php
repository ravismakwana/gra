<?php

/**
 * Template Name: Bulk Inquiry Page Template
 *
 * @package Asgard
 */

get_header();
$productTitle = isset($_GET['productName']) ? $_GET['productName'] : '';
?>
<div id="primary" class="container bg-white p-3 p-lg-5 my-3 my-lg-5 product-bulk" data-product="<?php echo esc_html($productTitle); ?>">
    <div class="row">
        <div class="col-12">
		<?php
            if ( have_posts() ) {
                while ( have_posts() ) : the_post();
                ?>
                    <header class="col-12 text-center">
                        <h1 class="page-title my-3 h3 fw-bold"><?php single_post_title(); ?></h1>
                    </header>
                <?php
                the_content();
                endwhile;
            }
		?>
        </div>
    </div>
</div>
<?php get_footer(); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Assuming the product element has a class 'product'
        const productElement = document.querySelector('.product-bulk');

        // Check if the product element exists
        if (productElement) {
            // Get the value of the data-product attribute
            const productTitle = productElement.getAttribute('data-product');

            // Log the product title to check if it is retrieved correctly
            console.log('Product title:', productTitle);

            // Find the Contact Form 7 input field by ID
            const productNameInput = document.querySelector('input#productName');

            // Log the input field element to check if it is found
            console.log('Product name input:', productNameInput);

            // Check if the input field exists
            if (productNameInput) {
                // Assign the product title to the value field of the input element
                productNameInput.value = productTitle;

                // Log the input field value to check if it is assigned correctly
                console.log('Input field value after assignment:', productNameInput.value);
            } else {
                console.error('Input field with ID "productName" not found');
            }
        } else {
            console.error('Product element with class "product" not found');
        }
    });


</script>

