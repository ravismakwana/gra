<?php
/**
 * Woocommerce Hooks Customization
 *
 * @package Asgard
 */

namespace ASGARD_THEME\Inc;

use ASGARD_THEME\Inc\Traits\Singleton;
use WC_Product_Variable;
use WC_AJAX;
use WC_Email_Customer_Shipped_Order;
use WC_Email_Customer_Feedback_Order;


class Asgard_Woocommerce {
	use Singleton;

	protected function __construct() {
		$this->setup_hooks();
	}

	protected function setup_hooks() {
		// actions and filters
		add_action( 'woocommerce_add_to_cart_fragments', [ $this, 'asgard_woocommerce_header_add_to_cart_fragment' ] );
		add_action( 'pre_get_posts', [ $this, 'exclude_specific_query_from_homepage' ] );
		add_filter( 'woocommerce_product_add_to_cart_text', [ $this, 'asgard_woocommerce_product_add_to_cart_text' ] );
		add_filter( 'woocommerce_blocks_product_grid_item_html', [
			$this,
			'asgard_custom_render_product_block'
		], 10, 3 );
		add_filter( 'woocommerce_product_get_image', [
			$this,
			'asgard_add_class_product_thumbnail'
		], 10, 6 );
		add_filter( 'woocommerce_add_to_cart_fragments', [
			$this,
			'asgard_cart_count_fragments'
		], 10, 1 );
		add_filter( 'use_block_editor_for_post_type', [
			$this,
			'enable_gutenberg_for_product_page'
		], 10, 2 );


		// add_filter( 'woocommerce_variable_price_html', [ $this, 'asgard_custom_variation_price' ], 10, 2 );
		add_action( 'woocommerce_single_product_summary', [ $this, 'woocommerce_add_attributes' ], 15 );
		add_action( 'woocommerce_after_single_product_summary', [ $this, 'display_variation_in_table_format' ], 5 );
		add_action( 'woocommerce_share', [ $this, 'product_share_single_product_page' ], 10 );
		add_action( 'wp_ajax_nopriv_woocommerce_add_variation_to_cart', [
			$this,
			'asgard_add_variation_to_cart_ajax'
		], 10 );
		add_action( 'wp_ajax_woocommerce_add_variation_to_cart', [ $this, 'asgard_add_variation_to_cart_ajax' ], 10 );
		add_action( 'woocommerce_after_single_product_summary', [
			$this,
			'asgard_woocommerce_template_product_checkout_button'
		], 8 );
		add_action( 'woocommerce_before_single_product_summary', [ $this, 'asgard_woocommerce_show_product_images' ] );
		add_action( 'woocommerce_before_single_product_summary', [
			$this,
			'asgard_single_product_images_and_summary_div_start'
		], 5 );
		add_action( 'woocommerce_after_single_product_summary', [
			$this,
			'asgard_single_product_images_and_summary_div_end'
		], 1 );

		add_filter( 'woocommerce_product_tabs', [ $this, 'asgard_remove_woo_additional_product_tabs' ], 98, 1 );
		add_filter( 'woocommerce_form_field', [ $this, 'asgard_remove_checkout_optional_text' ], 10, 4 );
		add_filter( 'woocommerce_account_menu_item_classes', [ $this, 'asgard_custom_wc_account_menu_item_classes' ], 10, 2 );
		add_filter( 'woocommerce_product_loop_title_classes', [ $this, 'asgard_woocommerce_product_loop_title_classes' ], 10, 1 );
		add_filter( 'woocommerce_loop_add_to_cart_link', [ $this, 'asgard_woocommerce_loop_add_to_cart_link' ], 10, 2 );
		add_action( 'woocommerce_after_order_notes', [
			$this,
			'asgard_woocommerce_checkout_page_add_medical_condition_custom_checkout_field'
		], 10 );
        add_action( 'woocommerce_checkout_update_order_meta', [
			$this,
			'asgard_woocommerce_checkout_page_update_medical_condition_custom_checkout_field'
		], 10, 1 );
        add_action( 'woocommerce_admin_order_data_after_billing_address', [
			$this,
			'asgard_woocommerce_checkout_page_display_medical_condition_custom_checkout_field'
		], 10, 1 );

		add_action( 'wp_ajax_upload_prescription', [ $this, 'asgard_upload_prescription' ], 10 );
		add_action( 'wp_ajax_nopriv_upload_prescription', [ $this, 'asgard_upload_pcription' ], 10 );
		add_action( 'wp_ajax_delete_prescription', [ $this, 'asgard_delete_prescription_action' ], 10 );
		add_action( 'wp_ajax_nopriv_delete_prescription', [ $this, 'asgard_delete_prescription_action' ], 10 );
		add_action( 'woocommerce_thankyou', [ $this, 'asgard_display_thankyou_popup' ], 10 );
		add_action( 'woocommerce_before_shop_loop_item', [ $this, 'asgard_woocommerce_before_shop_loop_item_add_div' ], 5 );
		add_action( 'woocommerce_after_shop_loop_item', [ $this, 'asgard_woocommerce_after_shop_loop_item_end_div' ], 15 );

		add_action( 'woocommerce_after_shop_loop_item', [ $this, 'asgard_add_start_div_for_bootstrap_card' ], 6 );
		add_action( 'woocommerce_after_shop_loop_item', [ $this, 'asgard_add_end_div_for_bootstrap_card' ], 14 );
		add_action( 'product_cat_add_form_fields', [ $this, 'asgard_taxonomy_add_new_category_description_field' ], 10, 1 );
		add_action( 'product_cat_edit_form_fields', [ $this, 'asgard_taxonomy_add_edit_category_description_field' ], 10, 1 );
		add_action( 'edited_product_cat', [ $this, 'asgard_save_taxonomy_custom_meta' ], 10, 1 );
		add_action( 'create_product_cat', [ $this, 'asgard_save_taxonomy_custom_meta' ], 10, 1 );
		add_action( 'create_product_cat', [ $this, 'asgard_save_taxonomy_custom_meta' ], 10, 1 );
		add_action( 'woocommerce_after_main_content', [ $this, 'asgard_display_content_on_archive_page' ], 10 );
		add_action( 'woocommerce_register_form_start', [ $this, 'asgard_add_registration_fields' ], 10 );
		add_action( 'woocommerce_register_form', [ $this, 'asgard_add_registration_password_confirm_field' ], 10 );
		add_filter( 'woocommerce_registration_errors', [ $this, 'asgard_validate_registration_fields' ], 10, 3);
        add_action( 'woocommerce_created_customer', [ $this, 'asgard_save_registration_fields' ], 10, 1 );
        add_action( 'woocommerce_after_checkout_validation', [ $this, 'asgard_woocommerce_confirm_password_validation_on_checkout_page' ], 10, 2 );
        add_action( 'woocommerce_checkout_init', [ $this, 'asgard_woocommerce_confirm_password_checkout_page' ], 10, 1 );
        add_filter( 'woocommerce_checkout_fields', [ $this, 'asgard_woocommerce_create_password_checkout_page' ], 15, 1 );
        add_filter( 'woocommerce_package_rates', [ $this, 'asgard_hide_shipping_when_free_is_available' ], 100, 1 );
        add_filter( 'gettext', [ $this, 'asgard_translate_bic_to_swift_code' ], 10, 3 );
        add_filter( 'woocommerce_cart_item_thumbnail', [ $this, 'asgard_woocommerce_add_class_to_cart_item_thumbnail' ], 10, 3 );


        //email
//        add_filter( 'woocommerce_email_order_items_args', [ $this, 'asgard_add_sku_to_wc_emails' ], 10, 1 );
        add_filter( 'woocommerce_cod_process_payment_order_status', [ $this, 'asgard_change_cod_payment_order_status' ], 15 );
        add_action( 'woocommerce_email_before_order_table', [ $this, 'asgard_add_content_specific_email' ], 20, 4 );
        add_action( 'wp_mail_from_name', [ $this, 'asgard_wp_mail_from_name' ], 10, 1 );
        add_action( 'wp_mail_from', [ $this, 'asgard_wp_mail_from' ], 10, 1 );
        add_filter( 'woocommerce_credit_card_form_fields', [ $this, 'asgard_change_cvc_cvv_text' ], 10, 2 );
        add_action( 'init', [ $this, 'asgard_remove_output_structured_data' ], 10);
        add_filter( 'woocommerce_order_number', [ $this, 'asgard_change_woocommerce_order_number' ], 10, 1 );
        add_filter( 'woocommerce_email_recipient_cancelled_order', [ $this, 'asgard_wc_cancelled_order_add_customer_email' ], 10, 2 );
        add_filter( 'woocommerce_email_recipient_failed_order', [ $this, 'asgard_wc_cancelled_order_add_customer_email' ], 10, 2 );
        add_filter( 'woocommerce_shop_order_search_results', [ $this, 'asgard_custom_shop_order_search_results_filter' ], 10, 3 );
        add_filter( 'woocommerce_currency_symbol', [ $this, 'asgard_woocommerce_change_existing_currency_symbol' ], 10, 2 );
        add_filter( 'default_checkout_billing_country', [ $this, 'asgard_woocommerce_change_default_checkout_country' ], 10, 2 );

        add_filter( 'woocommerce_email_recipient_customer_completed_order', [ $this, 'asgard_admin_email_recipient_filter_function' ], 10, 2 );
        add_filter( 'woocommerce_email_recipient_customer_shipped_order', [ $this, 'asgard_admin_email_recipient_filter_function' ], 10, 2 );
        add_filter( 'woocommerce_email_recipient_customer_on_hold_order', [ $this, 'asgard_admin_email_recipient_filter_function' ], 10, 2 );
        add_filter( 'woocommerce_email_recipient_customer_processing_order', [ $this, 'asgard_admin_email_recipient_filter_function' ], 10, 2 );
        add_filter( 'woocommerce_email_recipient_customer_note', [ $this, 'asgard_admin_email_recipient_filter_function' ], 10, 2 );
        add_filter( 'woocommerce_email_recipient_customer_refunded_order', [ $this, 'asgard_admin_email_recipient_filter_function' ], 10, 2 );

        // Add New order status "Shipped"
        add_action( 'init', [ $this, 'asgard_register_shipped_order_status' ], 10);
        add_filter( 'wc_order_statuses', [ $this, 'asgard_add_shipped_to_order_statuses' ], 10, 1);
        add_action( 'woocommerce_order_status_changed', [ $this, 'asgard_shipped_status_custom_notification' ], 10, 4);
        add_action( 'woocommerce_order_status_wc-shipped', [ WC(), 'send_transactional_email' ], 10, 1);
        add_filter( 'woocommerce_email_actions', [ $this, 'asgard_filter_woocommerce_email_actions' ], 10, 1);
        add_filter( 'woocommerce_email_classes', [ $this, 'asgard_add_shipped_order_woocommerce_email' ], 10, 1);
        add_filter( 'woocommerce_min_password_strength', [ $this, 'asgard_change_password_strength' ], 10, 1);
        add_filter( 'asgard_change_password_strength', [ $this, 'asgard_change_the_text_for_password_hint' ], 10, 1);
        add_filter( 'woocommerce_email_classes', [ $this, 'asgard_add_feedback_order_woocommerce_email' ], 10, 1);
        add_filter( 'cron_schedules', [ $this, 'asgard_add_every_seven_days' ], 10, 1);
        add_action( 'asgard_add_every_seven_days', [ $this, 'asgard_every_seven_days_event_func' ], 10 );
        add_action( 'woocommerce_single_product_summary', [ $this, 'asgard_add_view_counter' ], 13 );
        add_filter( 'woocommerce_order_item_name', [ $this, 'asgard_add_mg_attribute_in_order_email_' ], 10, 2 );
        add_action( 'woocommerce_after_single_product_summary', [ $this, 'asgard_single_product_author' ], 9 );
        add_action( 'woocommerce_review_order_before_payment', [ $this, 'asgard_woocommerce_review_order_before_payment' ], 10 );
        add_action( 'kt_amp_build_product', [ $this, 'asgard_display_variation_in_table_format_amp' ], 10 );
        add_action( 'kt_amp_header_after', [ $this, 'asgard_amp_search_for_product' ], 10 );
        add_action( 'kt_amp_header_content_up', [ $this, 'asgard_kt_amp_header_content_up_function' ], 10 );

        // Medicine type
        add_action('woocommerce_product_options_advanced', [ $this, 'asgard_woocommerce_custom_product_data_tab_content'], 10);
        add_action('woocommerce_process_product_meta', [ $this, 'asgard_woocommerce_save_custom_product_data'], 10, 1);
	}

	public function asgard_woocommerce_header_add_to_cart_fragment() {
		global $woocommerce;
		ob_start();
		?>
        <div class="mini-cart m-0 text-start">
            <div data-hover="dropdown" class="basket fs-14 p-0 d-flex align-items-center justify-content-end">
                <a id="cart_badge" href="<?php echo esc_url( wc_get_cart_url() ); ?>"
                   class="m-0 d-flex text-decoration-none align-items-center" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                    <div class="position-relative p-0 cart-icon-button d-flex justify-content-center align-items-center h-auto w-auto">
                        <svg class="" width="32px" height="32px" fill="#067e69">
                            <use href="#icon-basket"></use>
                        </svg>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger rounded-circle fw-normal">
                            <?php echo esc_html( $woocommerce->cart->cart_contents_count ); ?>
                            <span class="visually-hidden">New alerts</span>
                        </span>
                    </div>
                </a>
            </div>
        </div>
		<?php
		$fragments['.mini-cart'] = ob_get_clean();

		return $fragments;
	}

	public function exclude_specific_query_from_homepage( $query ) {
		global $wpdb;
		if ( is_home() && $query->is_main_query() ) {
			$excluded_option_name  = '_transient_timeout_wc_shipping_method_count_legacy';
			$excluded_option_query = "SELECT option_value FROM {$wpdb->prefix}options WHERE option_name = '{$excluded_option_name}' LIMIT 1";

			$query_vars       = $query->query_vars;
			$excluded_queries = isset( $query_vars['excluded_queries'] ) ? $query_vars['excluded_queries'] : array();

			// Add the excluded query to the list
			$excluded_queries[] = $excluded_option_query;

			// Store the list of excluded queries in the query vars
			$query->set( 'excluded_queries', $excluded_queries );
		}
	}

	public function asgard_woocommerce_product_add_to_cart_text() {
		return __( 'View Detail', 'woocommerce' );
	}

	public function asgard_custom_render_product_block( $html, $data, $post ) {
        // echo '<pre>';
        // print_r($post->id); 
        $product_id = $post->id; // Replace with your product ID
        $product_category = get_single_product_category_by_id($product_id);
        $product_categories_name = $product_category->name;
    
		return '<li class="wc-block-grid__product">
                <div class="p-3">
				<a href="' . $data->permalink . '" class="wc-block-grid__product-link text-decoration-none">
					' . $data->image . '
                    <div class="product-cat-handpick mb-2 body-text text-uppercase opacity-50">'. $product_categories_name .'</div>
					<span class="fs-6 text-decoration-none body-text">' . $data->title . '</span>
				</a>
                ' . $data->rating . '
				<div class="product-price fw-bold fs-14">' . $data->price . '</div>
				<a href="' . $data->permalink . '" class="fs-14 btn btn-primary rounded-pill mb-3 d-none" aria-label="view detail button">View detail</a>
				</div>
			</li>';
	}

	public function asgard_add_class_product_thumbnail( $image, $product, $size, $attr, $placeholder, $image_id ) {
		// Add your custom class here

		if ( is_product() ) {
			$custom_class = 'img-fluid img-thumbnail mx-auto d-block border border-primary border-opacity-25';
			// Append the custom class to the existing classes
			if ( strpos( $image, 'class="' ) !== false ) {
				$image = str_replace( 'class="', 'class="' . $custom_class . ' ', $image );
			} else {
				$image = str_replace( '<img', '<img class="' . $custom_class . '"', $image );
			}
		} else {
			$custom_class = '';
			// Append the custom class to the existing classes
			if ( strpos( $image, 'class="' ) !== false ) {
				$image = str_replace( 'class="', 'class="' . $custom_class . ' ', $image );
			} else {
				$image = str_replace( '<img', '<img class="' . $custom_class . '"', $image );
			}
		}


		return $image;
	}

	public function asgard_custom_variation_price( $price, $product ) {
		/**
		 * Only display price per piece for WooCommerce variable products
		 */
		$product_variations = $product->get_available_variations();
		$min_price          = [];

		foreach ( $product_variations as $key => $product_variation ) {
			$attribute       = array_values( $product_variation['attributes'] );
			$tablets         = explode( ' ', $attribute[0] );
			$min_price_value = floatval( $tablets[0] ); // Convert the string to a float
			if ( $min_price_value > 0 ) {
				$min_price[] = $min_price_value;
			}
		}

		if ( empty( $min_price ) ) {
			// Handle the case when all values in $min_price are zero or empty
			// For example, set a default price or display an error message.
			return 'No valid variation prices found.';
		}

		$prices     = array(
			$product->get_variation_price( 'max', true ),
			$product->get_variation_price( 'min', true )
		);
		$price      = max( $prices );
		$unit_price = $price / max( $min_price );
		$final_unit = round( number_format( $unit_price, 2 ), 2 );
        $medicineType = !empty(get_post_meta($product->get_id(), '_medicine_type', true)) ? get_post_meta($product->get_id(), '_medicine_type', true) : 'Piece'; // Corrected variable name and added get_id()
		return 'Just '.get_woocommerce_currency_symbol() . $final_unit . ' / '.$medicineType;
	}

	public function woocommerce_add_attributes() {
		global $product;
		$attributes = $product->get_attributes();
		?>
        <div class="table-responsive">
        <table class="shop_attributes table border border-primary border-opacity-10 mt-2 align-middle">
			<?php if ( $product->get_sku() ) { ?>
                <tr>
                    <th class="table-light">Product Code:</th>
                    <td class="p-2"><?php echo $product->get_sku(); ?></td>
                </tr>
				<?php
			}
			foreach ( $attributes as $attribute ) :
				$visible = $attribute->get_visible();
				if ( $visible ) {
					?>
                    <tr>
                        <th class="table-light"><?php echo wc_attribute_label( $attribute->get_name() ); ?></th>
                        <td class="p-2"><em><?php
								$values = array();

								if ( $attribute->is_taxonomy() ) {
									$attribute_taxonomy = $attribute->get_taxonomy_object();
									$attribute_values   = wc_get_product_terms( $product->get_id(), $attribute->get_name(), array( 'fields' => 'all' ) );

									foreach ( $attribute_values as $attribute_value ) {
										$value_name = esc_html( $attribute_value->name );

										if ( $attribute_taxonomy->attribute_public ) {
											$values[] = '<a href="' . esc_url( get_term_link( $attribute_value->term_id, $attribute->get_name() ) ) . '" rel="tag">' . $value_name . '</a>';
										} else {
											$values[] = $value_name;
										}
									}
								} else {
									$values = $attribute->get_options();

									foreach ( $values as &$value ) {
										$value = make_clickable( esc_html( $value ) );
									}
								}

								echo apply_filters( 'woocommerce_attribute', wptexturize( implode( ', ', $values ) ), $attribute, $values );
								?></em></td>
                    </tr>
					<?php
				}
			endforeach;
			?></table></div><?php
	}

	public function display_variation_in_table_format() {
		global $product;
		// Get current product ID
		$current_product_id = $product->get_id();

		$upsell_ids = $product->get_upsell_ids();
		if ( ! empty( $current_product_id ) ) {
			// added current products Id into Upsell products.
			array_unshift( $upsell_ids, $current_product_id );
		}
		if ( ! empty( $upsell_ids ) ) {
			foreach ( $upsell_ids as $upsell_id ) {
				$this->display_current_and_upsell_product_variation_in_table_format( $upsell_id );
			}
		}

	}

	public function display_current_and_upsell_product_variation_in_table_format( $id ) {
		?>
        <div class="product-variation-display-section table-responsive">
			<?php
			$product = new WC_Product_Variable( $id );
			// get the product variations
			$product_variations = $product->get_available_variations();
			$attributes         = $product->get_attributes();
			foreach ( $attributes as $key => $attribute ) {
				if ( $attribute->get_variation() ) {
					$attribute_name = $attribute->get_name();
				}
			}
			if ( ! empty( $product_variations ) ) {
				?>
                <table class="product_type table align-middle table-borderless mb-0">
                    <tbody>
                    <tr>
                        <td class="block d-lg-table-cell d-md-block d-block px-0">
                            <table class="text-center table footable footable-1 table-bordered table-hover border border-dark border-opacity-25"
                                   data-toggle-column="last" product-id="<?php echo $id; ?>">
                                <thead>
                                <tr class="row-title">
                                    <th colspan="5"><h2
                                                class="variation-product-title h5 mb-0 py-1 text-dark"><?php echo $product->get_title() . ' - ' . $attribute_name; ?></h2>
                                    </th>
                                </tr>
                                <tr class="footable-header">
                                    <th class="footable-first-visible text-dark"><?php echo $attribute_name; ?></th>
                                    <th class="text-dark">Price</th>
                                    <th class="hide-mobile text-dark d-none d-lg-table-cell">Price/unit</th>
                                    <th class="text-dark">Quantity</th>
                                    <th class="footable-last-visible text-dark">Add To Cart</th>
                                </tr>
                                </thead>
                                <tbody>
								<?php
								foreach ( $product_variations as $key => $product_variation ) {
//                                    echo '<pre>';
//                                    print_r($product_variation);
//                                    echo '</pre>';
									$attribute = array_values( $product_variation['attributes'] );
                                    $medicineTpe = !empty(get_post_meta($id, '_medicine_type', true)) ? get_post_meta($id, '_medicine_type', true) : 'Piece';
									?>
                                    <tr>
                                        <td class="footable-first-visible align-middle"><?php echo( $attribute[0] ); ?></td>
                                        <td class="align-middle"><?php echo get_woocommerce_currency_symbol() . $product_variation['display_price']; ?></td>
                                        <td class="hide-mobile align-middle d-none d-lg-table-cell">
											<?php
											$tablets    = explode( ' ', $attribute[0] );
											$unit_price = $product_variation['display_price'] / $tablets[0];
											$final_unit = round( number_format( $unit_price, 2 ), 2 );
											echo get_woocommerce_currency_symbol() . $final_unit . ' /' . $medicineTpe;
											?>
                                        </td>
                                        <td class="align-middle">
                                            <select class="form-control select-qty form-select form-select-sm border border-dark border-opacity-50"
                                                    aria-label="Select Qty">
                                                <option selected="selected">1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                            </select>
                                        </td>
                                        <td class="footable-last-visible align-middle d-table-cell justify-content-center align-items-center">
											<?php
											$attr  = '';
											$attrs = $product_variation['attributes'];
											foreach ( $attrs as $key => $attr ) {
												if ( ! empty( $attr ) ) {
													$attr = $key . '=' . $attr;
												} else {
													$attr .= '&' . $key . '=' . $attr;
												}
											}
											$key        = '_stock_status';
											$checkStock = get_post_meta( $product_variation["variation_id"], $key, true );
											if ( ! empty( $checkStock ) && $checkStock == 'outofstock' ) {
												?><span class="text-danger">Out of stock</span><?php
											} else {
												?>
                                            <button type="button"
                                                    class="btn-add-to-cart-ajax btn btn-success"
                                                    data-product_id="<?php echo abs( $id ); ?>"
                                                    data-variation_id="<?php echo abs( $product_variation["variation_id"] ); ?>"
                                                    data-quantity="1" data-variation="<?php echo $attr; ?>">
                                                    <svg class="d-block mx-auto m-0" width="25" height="25"
                                                         fill="var(--bs-white)">
                                                        <use href="#icon-cart"></use>
                                                    </svg>
                                                </button><?php
											}
											?>
                                        </td>
                                    </tr>
									<?php
								}
								?>
								<tr class="text-center">
                                    <td colspan="5">Want to order in bulk / B2B price? <a href="/bulk-inquiry?productName=<?php echo $product->get_title(); ?>" class="btn btn-sm btn-primary ms-sm-2" >Send Inquiry</a></td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
				<?php
			}
			?>
        </div>
		<?php
	}

	public function product_share_single_product_page() {
		global $product;
		$product_id = $product->get_id();
		?>
        <div class="product_share_single d-flex align-items-center">
            <div class="product_share_title me-2">
                <h6 class="fs-14 mb-0">Share:</h6>
            </div>
            <ul class="product_share_icon list-inline p-0 m-0 list-unstyled">
                <li class="list-inline-item">
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_permalink( $product_id ); ?>"
                       target="_blank">
                        <svg width="20" height="20" fill="var(--bs-primary)">
                            <use href="#icon-facebook"></use>
                        </svg>
                    </a>
                </li>
                <li class="list-inline-item">
                    <a href="https://twitter.com/share?url=<?php echo get_permalink( $product_id ); ?>" target="_blank">
                        <svg width="20" height="20" fill="var(--bs-primary)">
                            <use href="#icon-twitter"></use>
                        </svg>
                    </a>
                </li>
                <li class="list-inline-item">
                    <a href="https://pinterest.com/pin/create/button/?url=<?php echo get_permalink( $product_id ); ?>"
                       target="_blank">
                        <svg width="20" height="20" fill="var(--bs-primary)">
                            <use href="#icon-pinterest"></use>
                        </svg>
                    </a>
                </li>
                <li class="list-inline-item">
                    <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo get_permalink( $product_id ); ?>"
                       target="_blank">
                        <svg width="20" height="20" fill="var(--bs-primary)">
                            <use href="#icon-linkedin"></use>
                        </svg>
                    </a>
                </li>
<!--                <li class="list-inline-item">-->
<!--                    <a href="https://api.whatsapp.com/send?&text=%20--><?php //echo get_permalink( $product_id ); ?><!--"-->
<!--                       target="_blank">-->
<!--                        <svg width="20" height="20" fill="var(--bs-primary)">-->
<!--                            <use href="#icon-whatsapp"></use>-->
<!--                        </svg>-->
<!--                    </a>-->
<!--                </li>-->
            </ul>
        </div>
		<?php
	}

	public function asgard_add_variation_to_cart_ajax() {
		// Add variation product to the cart using ajax

		$product_id = apply_filters( 'woocommerce_add_to_cart_product_id', absint( $_POST['product_id'] ) );
		$quantity   = empty( $_POST['quantity'] ) ? 1 : wc_stock_amount( $_POST['quantity'] );

		$variation_id = isset( $_POST['variation_id'] ) ? absint( $_POST['variation_id'] ) : '';
		$variations   = ! empty( $_POST['variation'] ) ? (array) $_POST['variation'] : '';
		$variations   = array( $variations[0] => $variations[1] );

		$passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity, $variation_id, $variations, $cart_item_data );

		if ( $passed_validation && WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variations ) ) {

			do_action( 'woocommerce_ajax_added_to_cart', $product_id );

			if ( get_option( 'woocommerce_cart_redirect_after_add' ) == 'yes' ) {
				wc_add_to_cart_message( $product_id );
			}

			// Return fragments
			WC_AJAX::get_refreshed_fragments();

		} else {
			// If there was an error adding to the cart, send a JSON error response
			wp_send_json_error( array(
				'error'   => true,
				'message' => __( 'Error adding product to cart', 'your-theme-domain' ),
			) );
		}
		die();
	}

	public function asgard_cart_count_fragments( $fragments ) {
		$fragments['span.cart-items-count'] = '<span class="cart-items-count">' . count( WC()->cart->get_cart() ) . '</span>';

		$cart_count                                   = count( WC()->cart->get_cart() );
		$itemClass                                    = ( ( ! empty( $cart_count ) ) && ( $cart_count > 0 ) ) ? 'd-flex' : 'd-none';
		$fragments['div.button-group-single-product'] = '<div class="button-group-single-product">
            <div class="check-out-buttons ' . $itemClass . '  align-items-end flex-column">
				<ul class="list-inline mb-2 p-0 ">
					<li class="list-inline-item">
						<a href="' . wc_get_cart_url() . '" class="text-white view-cart btn btn-success  text-decoration-none text-uppercase fs-12">View cart</a>
					</li>
					<li class="list-inline-item">
						<a href="' . wc_get_checkout_url() . '" class="text-white view-checkout btn btn-secondary text-decoration-none text-uppercase fs-12">Checkout</a>
					</li>
				</ul>
				<div class="secure-img">
					<img src="' . ASGARD_BUILD_IMG_URI . '/secure-with-macfee.webp" alt="Secure with macfee" width="229" height="37" class="img-fluid">
				</div>
			</div>
        </div>';

        $fragments['div.offcanvas-body-inner'] = '<div class="right_cart-up offcanvas-body-inner">';
if (WC()->cart->get_cart_contents_count() > 0) {
    $fragments['div.offcanvas-body-inner'] .= '
    <ul class="mini-products-list list-unstyled mb-0 position-relative ms-0" id="cart-sidebar">';
    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
        $_product = apply_filters("woocommerce_cart_item_product", $cart_item["data"], $cart_item, $cart_item_key);
        if ($_product && $_product->exists() && $cart_item["quantity"] > 0 && apply_filters("woocommerce_widget_cart_item_visible", true, $cart_item, $cart_item_key)) {
            $product_name = apply_filters("woocommerce_cart_item_name", $_product->get_name(), $cart_item, $cart_item_key);
            $thumbnail = apply_filters("woocommerce_cart_item_thumbnail", $_product->get_image(), $cart_item, $cart_item_key);
            $product_price = apply_filters("woocommerce_cart_item_price", WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
            $product_permalink = $_product->is_visible() ? $_product->get_permalink($cart_item) : '';
            $fragments['div.offcanvas-body-inner'] .= '
            <li class="item d-inline-block border-bottom border-opacity-25 border-primary p-3 w-100">
                <div class="item-inner d-flex">
                    <a class="product-image flex-shrink-0 border-1 border-primary border-opacity-25" href="' . esc_url($product_permalink) . '" title="' . esc_html($product_name) . '">
                        ' . wp_kses_post($thumbnail) . '
                    </a>
                    <div class="product-details flex-grow-1 ms-3 position-relative">
                        <div class="access d-flex justify-content-end position-absolute top-0 end-0">
                            <a class="btn-edit" title="' . esc_attr__("Edit item", "asgard") . '" href="' . esc_url(wc_get_cart_url()) . '">
                                <svg class="icon-pencil" width="12" height="12">
                                    <use href="#icon-pencil"></use>
                                </svg>
                                <span class="hidden d-none">' . esc_attr__("Edit item", "asgard") . '</span>
                            </a>
                            <a href="' . esc_url(wc_get_cart_remove_url($cart_item_key)) . '" title="' . esc_attr__("Remove This Item", "asgard") . '" class="btn-remove1 ms-3">
                                <svg class="icon-close" width="12" height="12">
                                    <use href="#icon-close"></use>
                                </svg>
                            </a>
                        </div>
                        <strong>' . esc_html($cart_item["quantity"]) . '</strong> x
                        <span class="price">' . wp_kses_post($product_price) . '</span>
                        <a class="product-name mb-0 d-block text-decoration-none fs-12 link-primary" href="' . esc_url($product_permalink) . '" title="' . esc_html($product_name) . '">
                            ' . esc_html($product_name) . '
                        </a>
                    </div>
                    ' . wc_get_formatted_cart_item_data($cart_item) . '
                </div>
            </li>';
        }
    }
    $fragments['div.offcanvas-body-inner'] .= '</ul>';
} else {
    $fragments['div.offcanvas-body-inner'] .= '
    <p class="a-center noitem p-2 text-center">
        <svg class="d-block mx-auto m-3" width="28" height="28" fill="#ccc">
            <use href="#icon-cart"></use>
        </svg>
        ' . esc_attr__("No products in the cart.", "asgard") . '
    </p>';
}
$fragments['div.offcanvas-body-inner'] .= '</div>';
$fragments['div.right_cart-subtotal-right'] .= '<div class="right_cart-subtotal-right">' . wp_kses_post(WC()->cart->get_cart_subtotal()) . '</div>';



		return $fragments;
	}

	public function asgard_woocommerce_template_product_checkout_button() {
		$cart_count = count( WC()->cart->get_cart() );
		$itemClass  = ( ( ! empty( $cart_count ) ) && ( $cart_count > 0 ) ) ? 'd-flex' : 'd-none';
		?>
        <div class="button-group-single-product mb-4">
            <div class="check-out-buttons <?php echo $itemClass; ?>  align-items-end flex-column">
                <ul class="list-inline mb-2 p-0 ">
                    <li class="list-inline-item">
                        <a href="<?php echo wc_get_cart_url(); ?>"
                           class="text-white view-cart btn btn-success  text-decoration-none text-uppercase fs-12">View cart</a>
                    </li>
                    <li class="list-inline-item">
                        <a href="<?php echo wc_get_checkout_url(); ?>"
                           class="text-white view-checkout btn btn-secondary text-white text-decoration-none text-uppercase fs-12 ">Checkout</a>
                    </li>
                </ul>
                <div class="secure-img">
                    <img src="<?php echo ASGARD_BUILD_IMG_URI . '/secure-with-macfee.webp'; ?>" alt="Secure with macfee"
                         width="229" height="37" class="img-fluid">
                </div>
            </div>
        </div>
		<?php
	}

	public function asgard_single_product_images_and_summary_div_start() {
		echo '<div class="row product-image-plus-summary">';
	}

	public function asgard_single_product_images_and_summary_div_end() {
		echo '</div>';
	}

	public function asgard_woocommerce_show_product_images() {
		global $product;
		echo "<div class='col-lg-6 mt-4 mt-lg-0 order-2 order-lg-1 d-lg-block single-product-image'>" . $product->get_image('woocommerce_single') . "</div>";
	}

	public function enable_gutenberg_for_product_page( $can_edit, $post_type ) {
		if ( $post_type === 'product' ) {
			return true;
		}

		return $can_edit;
	}

	public function asgard_woocommerce_output_product_content_and_reviews() {

		woocommerce_product_description_tab();

		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}

	}

	public function asgard_woocommerce_checkout_page_add_medical_condition_custom_checkout_field( $checkout ) {
		echo '<div class="health-form step-title"><h4>' . __( 'Medical Condition' ) . '</h4>';
		woocommerce_form_field( 'physician_name', array(
			'type'        => 'text',
			'class'       => array( 'physician-name', 'mb-3' ),
			'label'       => __( "Your Physician's Name: " ),
			'placeholder' => __( '' ),
			'maxlength'   => 32,
			'text-danger'    => false,
			'label_class' => array( 'form-label fs-14 lh-1' ),
			'input_class' => array( 'input-text form-control border border-primary border-opacity-25' ),
		), $checkout->get_value( 'physician_name' ) );

		woocommerce_form_field( 'physician_phone', array(
			'type'        => 'tel',
			'class'       => array( 'physician-phone', 'mb-3' ),
			'label'       => __( "Physician's Telephone No:" ),
			'placeholder' => __( '' ),
			'maxlength'   => 10,
			'text-danger'    => false,
			'label_class' => array( 'form-label fs-14 lh-1' ),
			'input_class' => array( 'input-text form-control border border-primary border-opacity-25' ),
		), $checkout->get_value( 'physician_phone' ) );

		woocommerce_form_field( 'drug_allergies', array(
			'type'        => 'text',
			'class'       => array( 'drug-allergies', 'mb-3' ),
			'label'       => __( "Drug Allergies:" ),
			'placeholder' => __( '' ),
			'maxlength'   => 32,
			'text-danger'    => false,
			'label_class' => array( 'form-label fs-14 lh-1' ),
			'input_class' => array( 'input-text form-control border border-primary border-opacity-25' ),
		), $checkout->get_value( 'drug_allergies' ) );
		woocommerce_form_field( 'current_medications', array(
			'type'        => 'text',
			'class'       => array( 'current-medications', 'mb-3' ),
			'label'       => __( "Current Medications:" ),
			'placeholder' => __( '' ),
			'maxlength'   => 32,
			'text-danger'    => false,
			'label_class' => array( 'form-label fs-14 lh-1' ),
			'input_class' => array( 'input-text form-control border border-primary border-opacity-25' ),
		), $checkout->get_value( 'current_medications' ) );
		woocommerce_form_field( 'current_treatments', array(
			'type'        => 'text',
			'class'       => array( 'current-treatments', 'mb-3' ),
			'label'       => __( "Current Treatments:" ),
			'placeholder' => __( '' ),
			'maxlength'   => 32,
			'text-danger'    => false,
			'label_class' => array( 'form-label fs-14 lh-1' ),
			'input_class' => array( 'input-text form-control border border-primary border-opacity-25' ),
		), $checkout->get_value( 'current_treatments' ) );
		echo '<div class="d-flex">';
		woocommerce_form_field( 'smoke', array(
			'type'        => 'radio',
			'class'       => array( 'smoke', 'form-check', 'col' ),
			'label'       => __( "Do you Smoke?" ),
			'text-danger'    => false,
			'default'     => 0,
			'options'     => array( 'No', 'Yes' ),
			'label_class' => array( 'fs-14 lh-1 form-check-label flex-fill mt-0' ),
			'input_class' => array( 'form-check-input border border-primary border-opacity-25 mt-0 ms-0 me-2' ),
		), $checkout->get_value( 'smoke' ) );
		woocommerce_form_field( 'drink_alcohol', array(
			'type'        => 'radio',
			'class'       => array( 'drink-alcohol', 'form-check', 'col' ),
			'label'       => __( "Do you drink Alcohol?" ),
			'text-danger'    => false,
			'default'     => 0,
			'options'     => array( 'No', 'Yes' ),
			'label_class' => array( 'fs-14 lh-1 form-check-label flex-fill mt-0' ),
			'input_class' => array( 'form-check-input border border-primary border-opacity-25 mt-0 ms-0 me-2' ),
		), $checkout->get_value( 'drink_alcohol' ) );
		echo '</div>';
		echo ''
		     . "<p class='certify-text text-primary lh-lg bg-primary-subtle p-3'><strong>I certify that I am 'over 18 years' and that I am under the supervision of a doctor. The ordered medication is for my own personal use and is strictly not meant for a re-sale. I also accept that I am taking the medicine /s at my own risk and that I am duly aware of all the effects / side effects of the medicine / s. If my order contain Tadalafil, I confirm that the same is not meant for consumption in the USA. I acknowledge that the drugs are as per the norms of the country of destination.</strong></p>"
		     . '<p class="form-row file-upload" id="fileupload_field" data-priority=""><label for="fileupload_field" class="lh-1 mb-0">Upload Prescription&nbsp;</label><span class="woocommerce-input-wrapper"><div class="uploader" id="uploader"></div></span><input type="hidden" name="prescription_name" id="prescription_name" /></p>'
		     . '</div>';
	}

    public function asgard_woocommerce_checkout_page_update_medical_condition_custom_checkout_field($order_id) {
        if (!empty($_POST['physician_name'])) {
            update_post_meta($order_id, '_medical_physician_name', sanitize_text_field($_POST['physician_name']));
        }
        if (!empty($_POST['physician_phone'])) {
            update_post_meta($order_id, '_medical_physician_phone', sanitize_text_field($_POST['physician_phone']));
        }
        if (!empty($_POST['drug_allergies'])) {
            update_post_meta($order_id, '_medical_drug_allergies', sanitize_text_field($_POST['drug_allergies']));
        }
        if (!empty($_POST['current_medications'])) {
            update_post_meta($order_id, '_medical_current_medications', sanitize_text_field($_POST['current_medications']));
        }
        if (!empty($_POST['current_treatments'])) {
            update_post_meta($order_id, '_medical_current_treatments', sanitize_text_field($_POST['current_treatments']));
        }
        if (!empty($_POST['smoke'])) {
            update_post_meta($order_id, '_medical_smoke', ($_POST['smoke']));
        }
        if (!empty($_POST['drink_alcohol'])) {
            update_post_meta($order_id, '_medical_drink_alcohol', ($_POST['drink_alcohol']));
        }
        if (!empty($_POST['prescription_name'])) {
            update_post_meta($order_id, '_prescription', ($_POST['prescription_name']));
        }
    }

    public function asgard_woocommerce_checkout_page_display_medical_condition_custom_checkout_field($order) {
        $smoke = get_post_meta($order->id, '_medical_smoke', true);
        $smoke = (($smoke == 1) ? "Yes" : "No");
        $drink_alcohol = get_post_meta($order->id, '_medical_drink_alcohol', true);
        $drink_alcohol = (($drink_alcohol == 1) ? "Yes" : "No");
        $baseUploadUrl = wp_get_upload_dir();
        $output_dir = $baseUploadUrl['baseurl'] . '/';
        $fileName = get_post_meta($order->id, '_prescription', true);
        $prescript_attach = "Not found";
        if (!empty($fileName)) {
            $prescript_attach = '<a href="' . $output_dir . $fileName . '" target="_blank">Download</a>';
        }
        echo '<p><strong>' . __("Physician's Name") . ':</strong> <br/>' . get_post_meta($order->id, '_medical_physician_name', true) . '</p>';
        echo '<p><strong>' . __("Physician's Telephone No") . ':</strong> <br/>' . get_post_meta($order->id, '_medical_physician_phone', true) . '</p>';
        echo '<p><strong>' . __('Drug Allergies') . ':</strong> <br/>' . get_post_meta($order->id, '_medical_drug_allergies', true) . '</p>';
        echo '<p><strong>' . __('Current Medications') . ':</strong> <br/>' . get_post_meta($order->id, '_medical_current_medications', true) . '</p>';
        echo '<p><strong>' . __('Current Treatments') . ':</strong> <br/>' . get_post_meta($order->id, '_medical_current_treatments', true) . '</p>';
        echo '<p><strong>' . __('Smoke?') . ':</strong> ' . $smoke . '</p>';
        echo '<p><strong>' . __('Drink Alcohol') . ':</strong> ' . $drink_alcohol . '</p>';
        echo '<p><strong>' . __('Prescription') . ':</strong> <br/>' . $prescript_attach . '</p>';
    }

	public function asgard_remove_checkout_optional_text( $field, $key, $args, $value ) {
		if ( is_checkout() && ! is_wc_endpoint_url() ) {
			$optional = '&nbsp;<span class="optional">(' . esc_html__( 'optional', 'woocommerce' ) . ')</span>';
			$field    = str_replace( $optional, '', $field );
		}

		return $field;
	}

	public function asgard_upload_prescription() {
		$fileName      = '';
		$baseUploadUrl = wp_get_upload_dir();
		$output_dir    = $baseUploadUrl['basedir'] . '/';
		$yearMonth     = $baseUploadUrl['subdir'] . '/';
		if ( isset( $_FILES["prescription"] ) ) {
			$error = $_FILES["prescription"]["error"];
			if ( ! is_array( $_FILES["prescription"]["name"] ) ) { //single file
				$fileName = $_FILES["prescription"]["name"];
				$fileName = $yearMonth . $fileName;
				move_uploaded_file( $_FILES["prescription"]["tmp_name"], $output_dir . $fileName );
				$ret[] = $fileName;
			} else {  //Multiple files, file[]
				$fileCount = count( $_FILES["prescription"]["name"] );
				for ( $i = 0; $i < $fileCount; $i ++ ) {
					$fileName = $_FILES["prescription"]["name"][ $i ];
					$fileName = $yearMonth . $fileName;
					move_uploaded_file( $_FILES["prescription"]["tmp_name"][ $i ], $output_dir . $fileName );
					$ret[] = $fileName;
				}
			}
			wp_send_json( $ret );
			wp_die();
		}
	}

	public function asgard_delete_prescription_action() {
		$baseUploadUrl = wp_get_upload_dir();
		$output_dir    = $baseUploadUrl['basedir'] . "/";
		if ( isset( $_POST["op"] ) && $_POST["op"] == "delete" && isset( $_POST['name'] ) ) {
			$fileCount = count( $_POST['name'] );
			for ( $i = 0; $i < $fileCount; $i ++ ) {
				$fileName = $_POST['name'][ $i ];
				//$fileName =$_POST['name'];
				$fileName = str_replace( "..", ".", $fileName ); //text-danger. if somebody is trying parent folder files
				$filePath = $output_dir . $fileName;
				if ( file_exists( $filePath ) ) {
					@unlink( $filePath );
				}
			}
		}
		wp_die();
	}

	public function asgard_display_thankyou_popup( $order_id ) {
		if ( is_wc_endpoint_url( 'order-received' ) ) {
			$order = wc_get_order($order_id);
			?>
            <script type="text/javascript">
                jQuery(document).ready(function ($) {
	                <?php if ($order->has_status('failed')) { ?>
                    $('#order-failed-popup').modal('show');
	                <?php } else { ?>
                    $('#thankyou-popup').modal('show');
	                <?php } ?>
                });
            </script>
            <div class="modal fade" id="thankyou-popup" tabindex="-1" role="dialog"
                 aria-labelledby="thankyou-popup-label" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="d-flex justify-content-center align-items-center py-3 py-sm-5 flex-column">

                                    <div class="mb-4 text-center">
                                        <svg width="75" height="75" fill="var(--bs-primary)"><use href="#icon-circle-check"></use></svg>
                                    </div>
                                    <div class="text-center text-main">
                                        <h1>Thank You !</h1>
                                        <p>Your order has been received. We've send the link to your inbox.</p>
                                        <button class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                                    </div>

                            </div>
                        </div>
                    </div>
                </div>

            <div class="modal fade" id="order-failed-popup" tabindex="-1" role="dialog"
                 aria-labelledby="order-failed-popup-label" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="d-flex justify-content-center align-items-center py-3 py-sm-5 flex-column">

                                    <div class="mb-4 text-center">
                                        <svg width="75" height="75" fill="var(--bs-danger)"><use href="#icon-close"></use></svg>
                                    </div>
                                    <div class="text-center">
                                        <h1>Ohh, Order failed !</h1>
                                        <p>Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.</p>
                                        <button class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                    </div>

                            </div>
                        </div>
                    </div>
                </div>
			<?php
		}
	}

    public function asgard_custom_wc_account_menu_item_classes( $classes, $endpoint ) {
	    global $wp;

	    $additional_classes = array(
		    'active', // Replace 'is-active' with 'active'.
	    );

	    $current = isset( $wp->query_vars[ $endpoint ] );
	    if ( 'dashboard' === $endpoint && ( isset( $wp->query_vars['page'] ) || empty( $wp->query_vars ) ) ) {
		    $current = true;
	    } elseif ( 'orders' === $endpoint && isset( $wp->query_vars['view-order'] ) ) {
		    $current = true;
	    } elseif ( 'payment-methods' === $endpoint && isset( $wp->query_vars['add-payment-method'] ) ) {
		    $current = true;
	    }

	    if ( $current ) {
		    $classes = array_merge( $classes, $additional_classes );
	    }

	    return $classes;
    }

    public function asgard_woocommerce_product_loop_title_classes($classes){
	    $classes = 'h6 woo-title text-truncate-2 fw-semibold';
	    return $classes;
    }
    public function asgard_woocommerce_loop_add_to_cart_link($link, $product) {
	    $args = array();
	    $args['class'] = isset($args['class']) ? $args['class'] : 'btn btn-primary rounded-pill'; // Default class if not set
	    $args['class'] .= ' d-none fs-14 '; // Add the custom class

	    $link = preg_replace('/class="([^"]*)"/', 'class="' . esc_attr($args['class']) . '"', $link);

	    return $link;
    }

    public function asgard_woocommerce_before_shop_loop_item_add_div(){
        echo "<div class='card border-0 border-primary border-opacity-75 px-2'>";
    }
	public function asgard_woocommerce_after_shop_loop_item_end_div(){
		echo "</div>";
	}
    public function asgard_add_start_div_for_bootstrap_card(){
		echo "<div class='card-body text-center'>";
	}

    public function asgard_add_end_div_for_bootstrap_card(){
        echo "</div>";
    }

    public function asgard_taxonomy_add_new_category_description_field(){
        ?>
    <div class="form-field">
        <label for="rv_cate_desc"><?php _e('Second Category Description', 'asgard'); ?></label>
        <textarea name="rv_cate_desc" id="rv_cate_desc"></textarea>
        <p class="description"><?php _e('Enter a second category description', 'asgard'); ?></p>
    </div>
    <?php
    }
    public function asgard_taxonomy_add_edit_category_description_field($term){
//getting term ID
    $term_id = $term->term_id;
    // retrieve the existing value(s) for this meta field.
    $rv_cate_desc = get_term_meta($term_id, 'rv_cate_desc', true);
    ?>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="rv_cate_desc"><?php _e('Second Category Description', 'asgard'); ?></label></th>
        <td>
           <?php
            $args = array(
                'media_buttons' => false, // This setting removes the media button.
            );
            $content = ($rv_cate_desc) ? ($rv_cate_desc) : '';

            wp_editor($content, 'rv_cate_desc', $args); ?>
            <p class="description"><?php _e('Enter a second category description', 'asgard'); ?></p>
        </td>
    </tr>
    <?php
    }

    public function asgard_save_taxonomy_custom_meta($term_id){
        $rv_cate_desc = filter_input(INPUT_POST, 'rv_cate_desc');
        update_term_meta($term_id, 'rv_cate_desc', $rv_cate_desc);
    }

    public function asgard_display_content_on_archive_page(){
        if(!is_shop()) {
            $queried_object = get_queried_object();
            $term_id = $queried_object->term_id;
            $rv_cate_desc = get_term_meta($term_id, 'rv_cate_desc', true);
            if (!empty($rv_cate_desc)) {
                ?>
                <div class="archive-custom-content my-4">
                    <?php echo wpautop($rv_cate_desc); ?>
                </div>
                <?php
            }
        }

    }

    public function asgard_add_registration_fields(){
        ?>
    <div class="row">
        <div class="form-group col-sm-6 mb-3">
            <label for="reg_billing_first_name" class="form-label fs-14 lh-1"><?php _e('First name', 'woocommerce'); ?> <span class="text-danger">*</span></label>
            <input type="text" class="form-control border border-secondary border-opacity-75" name="billing_first_name" id="reg_billing_first_name" value="<?php if (!empty($_POST['billing_first_name'])) {esc_attr_e($_POST['billing_first_name']);} ?>" maxlength="32" />
        </div>

        <div class="form-group col-sm-6 mb-3">
            <label for="reg_billing_last_name" class="form-label fs-14 lh-1"><?php _e('Last name', 'woocommerce'); ?> <span class="text-danger">*</span></label>
            <input type="text" class="form-control border border-secondary border-opacity-75" name="billing_last_name" id="reg_billing_last_name" value="<?php if (!empty($_POST['billing_last_name'])) {esc_attr_e($_POST['billing_last_name']);} ?>" maxlength="32" />
        </div>
        <div class="form-group col-sm-12 mb-3">
            <label for="reg_billing_phone" class="form-label fs-14 lh-1"><?php _e('Phone number', 'woocommerce'); ?> <span class="text-danger">*</span></label>
            <input type="text" class="form-control border border-secondary border-opacity-75" name="billing_phone" id="reg_billing_phone" value="<?php if (!empty($_POST['billing_phone'])) {esc_attr_e($_POST['billing_phone']);} ?>" maxlength="10" />
        </div>
    </div>
    <div class="clear"></div>

    <?php
    }
    public function asgard_add_registration_password_confirm_field(){
        ?>
        <div class="form-row form-group col-sm-12 mb-3">
            <label for="reg_password2" class="form-label fs-14 lh-1"><?php _e('Password Confirm', 'woocommerce'); ?> <span class="text-danger">*</span></label>
            <input type="password" class="form-control border border-secondary border-opacity-75" name="password2" id="reg_password2" value="<?php if (!empty($_POST['password2'])) {echo esc_attr($_POST['password2']);} ?>" />
        </div>
        <?php
    }
    public function asgard_validate_registration_fields($errors, $username, $email){
        extract($_POST);

        if (isset($_POST['billing_first_name']) && empty($_POST['billing_first_name'])) {
            $errors->add('billing_first_name_error', __('First name is text-danger!', 'woocommerce'));
        }
        if (isset($_POST['billing_last_name']) && empty($_POST['billing_last_name'])) {
            $errors->add('billing_last_name_error', __('Last name is text-danger!.', 'woocommerce'));
        }
        if (isset($_POST['billing_phone']) && empty($_POST['billing_phone'])) {
            $errors->add('billing_phone_error', __('Phone number is text-danger!.', 'woocommerce'));
        }
        if (isset($_POST['billing_phone']) && (!preg_match('/^[0-9]{10}+$/', $_POST['billing_phone']))) {
            $errors->add('billing_phone_error', __('Phone number is invalid!.', 'woocommerce'));
        }

        if (strcmp($password, $password2) !== 0) {
            $errors->add('registration-error', __('Passwords do not match.', 'woocommerce'));
        }
    return $errors;
    }

    public function asgard_save_registration_fields($customer_id){
        if (isset($_POST['billing_first_name'])) {
            update_user_meta($customer_id, 'billing_first_name', sanitize_text_field($_POST['billing_first_name']));
            update_user_meta($customer_id, 'first_name', sanitize_text_field($_POST['billing_first_name']));
        }
        if (isset($_POST['billing_last_name'])) {
            update_user_meta($customer_id, 'billing_last_name', sanitize_text_field($_POST['billing_last_name']));
            update_user_meta($customer_id, 'last_name', sanitize_text_field($_POST['billing_last_name']));
        }
        if (isset($_POST['billing_phone'])) {
            // Mobile No. input filed (Billing Phone of WooCommerce)
            update_user_meta($customer_id, 'billing_phone', sanitize_text_field($_POST['billing_phone']));
        }
    }

    public function asgard_woocommerce_confirm_password_validation_on_checkout_page($fields, $errors){
        $checkout = WC()->checkout;
        if (!is_user_logged_in() && ( $checkout->must_create_account || !empty($posted['createaccount']) )) {
            if (strcmp($fields['account_password'], $fields['account_confirm_password']) !== 0) {
                $errors->add(__('Passwords do not match.', 'woocommerce'));
            }
        }
    }

    public function asgard_woocommerce_confirm_password_checkout_page($checkout){
        if (get_option('woocommerce_registration_generate_password') == 'no') {

            $fields = $checkout->get_checkout_fields();

            $fields['account']['account_confirm_password'] = array(
                'type' => 'password',
                'label' => __('Confirm password', 'woocommerce'),
                'label_class' => 'form-label fs-14 lh-1',
                'input_class' => ['form-control', 'border', 'border-secondary', 'border-opacity-75'],
                'required' => true,
                'placeholder' => _x('Confirm Password', 'placeholder', 'woocommerce')
            );

            $checkout->__set('checkout_fields', $fields);
        }
    }
    public function asgard_woocommerce_create_password_checkout_page($fields){
//        echo "<pre>";
//        print_r($fields);
//        echo "</pre>";
        $fields['account']['account_password']['input_class'] = ['form-control'];
        $fields['account']['account_password']['label_class'] = ['fs-14 lh-1 form-check-label flex-fill mt-0'];
        return $fields;
    }

    public function asgard_hide_shipping_when_free_is_available($rates){
        $free = array();
        foreach ($rates as $rate_id => $rate) {
            if ('free_shipping' === $rate->method_id) {
                $free[$rate_id] = $rate;
                break;
            }
        }
        return !empty($free) ? $free : $rates;
    }

    public function asgard_translate_bic_to_swift_code($translation, $text, $domain){
        if ($domain == 'woocommerce') {
            switch ($text) {
                case 'BIC':
                    $translation = 'SWIFT CODE';
                    break;
            }
        }

        return $translation;
    }

    public function asgard_add_sku_to_wc_emails(){
        $args['show_sku'] = true;
        return $args;
    }
    public function asgard_change_cod_payment_order_status(){
        return 'on-hold';
    }
    public function asgard_add_content_specific_email($order, $sent_to_admin, $plain_text, $email){
//        global $linea_Options;
        $paypal_url = 'https://www.paypal.me/';
//        $paypal_id = (!empty($linea_Options['paypal_url'])) ? $linea_Options['paypal_url'] : '';
//        $paypal_name = (!empty($linea_Options['paypal_name'])) ? $linea_Options['paypal_name'] : '';
        $cart_total = $order->get_total();
        $paypal_url = $paypal_url . $paypal_id . '/' . $cart_total . 'usd';
        $payment_title = $order->get_payment_method_title();

        if ($payment_title == 'Pay By Credit/Debit Card') {
            if ($email->id == 'customer_on_hold_order') {
                if((!empty($paypal_name)) && (!empty($paypal_id))) {
                echo '<p style="margin:0 0 16px;">Thanks for your valuable Order with us.
                    <br/>Hope you and your loved ones are safe from Covid-19.</p>';

                echo '<p style="margin:0 0 16px;">Before you make Payment , we would like to clarify the following.</p>';

                echo '<p>1). Our PayPal Name : <strong>'.$paypal_name.'</strong> (Please do not describe any medicine name during payment or afterward as PayPal doesn\'t allow the medicinal transaction.)</p>';
                echo '<p>2). We will be able to ship your order within <strong>1-2 days</strong> after confirmation of your payment.</p>';
                echo '<p>3). There might be a little bit of delay in order delivery due to COVID-19.</p>';
                echo '<p>4). Estimated delivery time is around <strong>3-4 Weeks</strong>.</p>';

                echo '<p>If you agree, Then make payment <strong>BY CLICK ON BELOW PAY NOW BUTTON</strong> and pay for your order.</p>';
                echo '<p style="margin:0 0 16px;text-align:center;"><a href="'.$paypal_url.'" target="_blank" style="font-weight: normal;text-align: center;background-color: #55c0a1;color: #ffffff;padding: 10px 20px;display: inline-block;border-radius: 4px;text-decoration: none;text-transform: uppercase;">Pay Now</a></p>';

                echo '<p><strong>100% Satisfaction Guarantee.</strong> (If somehow your package is Delayed or not delivered, Then we can reship your package or refund your full payment).</p>';
                } else {
                    echo '<p>Your order has been successfully placed.</p>';
                    echo '<p><strong>We will send you the PAYMENT LINK within 12 hours to your email. After your payment confirmation, Your order will be shipped within 24 hours and provide you the tracking number.</strong></p>';
                }
                echo '<p>Stay Tuned with your Email...!</p>';
            }
        } else if ($payment_title == 'Pay By Credit Card') {
            if ($email->id == 'customer_on_hold_order') {
                echo '<p>Your card will be charged within 24-36 hours and we will update you the status of your order.</p>';
            }
        }
        if ( $email->id == 'customer_shipped_order' ) {
            echo '<p>However, you can also track your order from below links, (use your tracking number)</p>';
            echo '<table style="border-color:#dddddd;margin:0 0 16px;" width="100%" cellspacing="0" cellpadding="3" border="1">';
            echo '<tr>';
            echo '<th style="text-align:left;background:#efefef;font-weight:500;" width="35%">For USA Customers (USPS) : </th>';
            echo '<td><a href="https://www.usps.com" target="_blank">https://www.usps.com</a>';
            echo '</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<th style="text-align:left;background:#efefef;font-weight:500;" width="35%">For UK Customers (ParcelForce) : </th>';
            echo '<td><a href="https://www.parcelforce.com/track-trace" target="_blank">https://www.parcelforce.com/track-trace</a>';
            echo '</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<th style="text-align:left;background:#efefef;font-weight:500;" width="35%">For AUS Customers (AUSPOST) : </th>';
            echo '<td><a href="https://auspost.com.au" target="_blank">https://auspost.com.au</a>';
            echo '</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<th style="text-align:left;background:#efefef;font-weight:500;" width="35%">For All countries :  </th>';
            echo '<td><a href="https://www.indiapost.gov.in/_layouts/15/dop.portal.tracking/trackconsignment.aspx" target="_blank">https://www.indiapost.gov.in/_layouts/15/dop.portal.tracking/trackconsignment.aspx</a>';
            echo '</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<th style="text-align:left;background:#efefef;font-weight:500;" width="35%">For Singapore Post: </th>';
            echo '<td><a href="https://www.aftership.com/track" target="_blank">https://www.aftership.com/track</a>';
            echo '</td>';
            echo '</tr>';
            echo '</table>';
            echo '<p><b>MUST NOTE :</b><br>You can track shipment after 3-4 days of shipment.</p>';
            echo '<p>Average normal shipping time is 15-22 days, please (Delivery may be take up to 30 days from date of dispatch, due to if any disruption in postal services due to weather issue or natural disaster).</p>';
        }
        echo '<p><b>Our Operation time:</b><br/>9am to 9pm (Indian Time Only)</p>';
        if ($email->id == 'customer_shipped_order') {
            $trackingCode = get_post_meta($order->id, 'ywot_tracking_code', true);
            $trackingName = get_post_meta($order->id, 'ywot_carrier_name', true);
            $trackingDate = get_post_meta($order->id, 'ywot_pick_up_date', true);
            if ((!empty($trackingDate)) && (!empty($trackingName)) && (!empty($trackingCode))) {
                echo '<p>Your order has been shipped up by <b>' . $trackingName . '</b> on <b>' . $trackingDate . '</b>. Your track code is <b>' . $trackingCode . '.</b></p>';
            }
        }
    }

    public function asgard_wp_mail_from_name( $name ){
        return 'Arrow Meds';
    }
    public function asgard_wp_mail_from( $email ){
        return 'admin@goodrxaustralia.com';
    }
    public function asgard_change_cvc_cvv_text( $default_fields, $id ){
        $search = 'Card code';
        $replace = 'CVV Code';
        $default_fields = str_replace($search, $replace, $default_fields);
        $search1 = 'CVC';
        $replace1 = 'CVV';
        $default_fields = str_replace($search1, $replace1, $default_fields);
        return $default_fields;
    }
    public function asgard_remove_output_structured_data(){
        remove_action('wp_footer', array(WC()->structured_data, 'output_structured_data'), 10); // Frontend pages
        remove_action('woocommerce_email_order_details', array(WC()->structured_data, 'output_email_structured_data'), 30); // Emails
    }
    public function asgard_change_woocommerce_order_number( $order_id ){
        $prefix = 'GMA';
        $new_order_id = $prefix . $order_id;
        return $new_order_id;
    }
    public function asgard_wc_cancelled_order_add_customer_email( $recipient, $order ){
        return $recipient . ',' . $order->billing_email;
    }
    public function asgard_custom_shop_order_search_results_filter( $order_ids, $term, $search_fields ){
        global $wpdb;
        if(strpos($term, '#') !== false){
            $term = preg_replace('/#[[:<:]]GMA/', '', $term); //  <===  <===  <===  Your change
        } else{
            $term = preg_replace('/[[:<:]]GMA/', '', $term); //  <===  <===  <===  Your change
        }
        $order_ids = array();

        if (is_numeric($term)) {
            $order_ids[] = absint($term);
        }

        if (!empty($search_fields)) {
            $order_ids = array_unique(
                array_merge(
                    $order_ids,
                    $wpdb->get_col(
                        $wpdb->prepare(
                            "SELECT DISTINCT p1.post_id FROM {$wpdb->postmeta} p1 WHERE p1.meta_value LIKE %s AND p1.meta_key IN ('" . implode("','", array_map('esc_sql', $search_fields)) . "')", // @codingStandardsIgnoreLine
                            '%' . $wpdb->esc_like(wc_clean($term)) . '%'
                        )
                    ),
                    $wpdb->get_col(
                        $wpdb->prepare(
                            "SELECT order_id
                                FROM {$wpdb->prefix}woocommerce_order_items as order_items
                                WHERE order_item_name LIKE %s",
                            '%' . $wpdb->esc_like(wc_clean($term)) . '%'
                        )
                    )
                )
            );
        }
        return $order_ids;
    }

    public function asgard_register_shipped_order_status(){
        register_post_status('wc-shipped', array(
            'label' => 'Shipped',
            'public' => true,
            'show_in_admin_status_list' => true,
            'show_in_admin_all_list' => true,
            'exclude_from_search' => false,
            'label_count' => _n_noop('Shipped <span class="count">(%s)</span>', 'Shipped <span class="count">(%s)</span>')
        ));
    }
    public function asgard_add_shipped_to_order_statuses($order_statuses){
        $new_order_statuses = array();
        foreach ($order_statuses as $key => $status) {
            $new_order_statuses[$key] = $status;
            if ('wc-processing' === $key) {
                $new_order_statuses['wc-shipped'] = 'Shipped';
            }
        }
        return $new_order_statuses;
    }

    public function asgard_shipped_status_custom_notification($order_id, $from_status, $to_status, $order){
        if ($order->has_status('shipped')) {

            // Getting all WC_emails objects
            $email_notifications = WC()->mailer()->get_emails();

            // Sending the customized email
            $email_notifications['WC_Email_Customer_Shipped_Order']->trigger($order_id);
        }
    }
    public function asgard_filter_woocommerce_email_actions($actions){
        $actions[] = 'woocommerce_order_status_wc-shipped';
        return $actions;
    }
    public function asgard_add_shipped_order_woocommerce_email($email_classes){
        // include our custom email class
        wc_get_template_part('class', 'wc-email-customer-shipped-order');

        // add the email class to the list of email classes that WooCommerce loads
        $email_classes['WC_Email_Customer_Shipped_Order'] = new WC_Email_Customer_Shipped_Order();

        return $email_classes;
    }
    public function asgard_change_password_strength($strength){
        /* * Strength Settings
         * 4 = Strong
         * 3 = Medium (default)
         * 2 = Also Weak but a little stronger
         * 1 = Password should be at least Weak
         * 0 = Very Weak / Anything*/
        return 2;
    }
    public function asgard_change_the_text_for_password_hint($hint){
        $hint = 'Hint: The password should be at least 7 characters long. To make it stronger, use upper and lower case letters, numbers, and symbols like ! " ? $ % ^ &amp; )';
        return $hint;
    }
    public function asgard_admin_email_recipient_filter_function($recipient, $object){
        $recipient = $recipient . ', admin@goodrxaustralia.com';
        return $recipient;
    }

    public function asgard_add_feedback_order_woocommerce_email($email_classes) {

        wc_get_template_part('class', 'wc-email-customer-feedback-order');
        // add the email class to the list of email classes that WooCommerce loads
        $email_classes['WC_Email_Customer_Feedback_Order'] = new WC_Email_Customer_Feedback_Order();

        return $email_classes;
    }
    public function asgard_add_every_seven_days($schedules) {

        $schedules['every_seven_days'] = array(
            'interval' => 604800,
            'display' => __('Every 7 days', 'textdomain')
        );
        return $schedules;
    }
    public function asgard_every_seven_days_event_func() {

        global $wpdb;
//        global $linea_Options;
        $range = 10080; // 7 days in minutes
        $completed_orders = bbloomer_get_completed_orders_before_after(strtotime('-' . absint($range) . ' MINUTES', current_time('timestamp')), current_time('timestamp'));
        if ($completed_orders) {
            foreach ($completed_orders as $order_id) {
                ob_start();
                $email_data = '';
                $template = 'emails/email-header-feedback.php';
                $email_heading = "Give Rating";
                wc_get_template($template, array('email_heading' => $email_heading));
                // 1) Get the Order object
                $order = wc_get_order($order_id);
                // Get the order meta data in an unprotected array
                $email_ad = $order->get_billing_email();
                $order_items = $order->get_items();
                // OUTPUT
                ?>
                <p><?php printf(esc_html__('Dear %s,', 'woocommerce'), esc_html($order->get_billing_first_name())); ?></p>
                <?php /* translators: %s: Order number */ ?>
                <?php $blog_title = get_bloginfo('name'); ?>
                <p>Thank you for choosing <a href="<?php echo home_url(); ?>" target="_blank"><?php echo $blog_title; ?></a>
                </p>
                <p><?php esc_html_e('To improve the satisfaction of our customers, to collect reviews for better service with best quality products.', 'woocommerce'); ?></p>
                <p>
                    <?php esc_html_e('All reviews, good, bad or otherwise will be visible immediately.', 'woocommerce'); ?>
                </p>
                <?php
                foreach ($order_items as $item_id => $item) {
                    $product = $item->get_product();
                    $is_visible = $product && $product->is_visible();
                    $product_permalink = apply_filters('woocommerce_order_item_permalink', $is_visible ? $product->get_permalink($item) : '', $item, $order);
                    ?>
                    <p>
                        <a href="<?php echo $product_permalink . '#comments' ?>" style="color:#0c59f2;font-weight:normal;line-height:1em;text-decoration:underline;font-size:18px;">Click here to review us on </a><?php //echo apply_filters('woocommerce_order_item_name', $product_permalink ? sprintf('<a href="%s#comments" style="color:#0c59f2;font-weight:normal;line-height:1em;text-decoration:underline;font-size:18px;" target="_blank">%s</a>', $product_permalink, $item->get_name()) : $item->get_name(), $item, $is_visible); ?>
                        <?php
//                        $trustImage = $linea_Options['feedback_image']['url'];
                        ?><br/>
<!--                        <a href="--><?php //echo $product_permalink . '#comments' ?><!--" target="_blank"><img src="--><?php //echo $trustImage; ?><!--"  width="--><?php //echo $linea_Options['feedback_image']['width']; ?><!--" height="--><?php //echo $linea_Options['feedback_image']['height']; ?><!--" /></a>-->
                    </p>
                    <?php
                }?>
                <p>
                    <b>Thanks for your time,</b><br/>
                    Team goodrxaustralia
                </p>
                <p><b>Please note:</b> This email is sent automatically, so you may have received this review invitation before the arrival of your package or service. In this case, you are welcome to wait with writing your review until your package or service arrives.</p>
                <p></p>
                <?php

                $template_footer = 'emails/email-footer.php';
                wc_get_template($template_footer);
                $email_data = ob_get_clean();
                // To send HTML mail, the Content-type header must be set
                $headers = 'MIME-Version: 1.0' . "\r\n";

                $mailer = WC()->mailer();
                $subject = __("⭐ ⭐ ⭐ ⭐ ⭐ How many stars would you give our Medicine(s)?", 'woocommerce');
                $headers = "Content-Type: text/html\r\n";
                //send the email through wordpress
                $mailer->send($email_ad, $subject, $email_data, $headers);
            }

        }
    }

    public function asgard_add_view_counter(){
        if ( shortcode_exists( 'post-views' ) ) {
		    ?>
		    <div class="d-flex align-items-center justify-content-between mb-3">
            <div class="view-counter d-flex align-items-center">
			    <?php echo do_shortcode( '[post-views]' ).'<div class="ms-2 viewd"> Viewed</div>'; ?>
            </div>
			<div class="woocommerce-product-rating mb-0">
			    <a class="d-flex align-items-center text-primary lh-1" href="https://tawk.to/goodrxaustralia" target="_blank">
                    <svg width="20" height="20" fill="var(--bs-primary)" class="me-2"><use href="#icon-chat"></use></svg>
					Talk to Expert
				</a>
            </div>
                </div>
		    <?php
	    }
    }

    public function asgard_add_mg_attribute_in_order_email_($item_name, $item){
        $item_meta_data = $item->get_meta_data();
        $item_attribute = (!empty($item_meta_data[0]->key) ? $item_meta_data[0]->key: '');
        return $item_name.'&nbsp;('.$item_attribute.')';
    }
    public function asgard_single_product_author(){
         global $product;
// 		echo '<pre>';
// 		print_r($product);
// 		echo '</pre>';
 		$user = get_avatar(get_the_author_meta('ID'), 30, '', '', ['class'=>'rounded-pill']);
		$modifiedDate = $product->get_date_modified()->date('d/m/Y');
		?>
		<div class="product-author product-author d-flex align-items-center flex-wrap mb-3 p-3 border border-secondary border-opacity-50 rounded-4">
			<div class="last-updated w-100 fs-12">
				<span>Last Updated on </span>
				<time><?php echo $modifiedDate; ?></time>
			</div>
			<div class="reviwed me-2 fs-6 d-flex align-items-center lh-1">
				<svg class="me-1" width="20" height="20" fill="var(--bs-primary)"><use href="#icon-circle-check"></use></svg>
				 Medically Reviewed by
			</div>
			<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="author-profile d-inline-flex align-items-center bg-primary-subtle rounded-pill text-decoration-none text-primary pe-3 text-capitalize">
				<div class="author-asgard">
					<?php echo $user; ?>
				</div>
				<span class="ms-2 name"><?php the_author(); ?></span>
			</a>
		</div>
		<?php
    }

    public function asgard_woocommerce_review_order_before_payment(){
        echo '<a href="javascript:void()" class="float-start pt-4 ps-3 pb-2 w-100"><img src="' . ASGARD_BUILD_IMG_URI . '/secure-with-macfee.webp" alt="Secure with macfee" width="229" height="37" class="img-fluid"></a>';
    }
    public function asgard_display_variation_in_table_format_amp(){
        ?>
        <div class="product-variation-display-section table-responsive">
            <?php
            global $product;
            $id = $product->get_id();
            $product = new WC_Product_Variable($id);
            // get the product variations
            $product_variations = $product->get_available_variations();
            $attributes = $product->get_attributes();
            //            echo "<pre>";
            //            print_r($attributes);
            foreach ($attributes as $key => $attribute) {
                if ($attribute->get_variation()) {
                    $attribute_name = $attribute->get_name();
                }
            }
            if (!empty($product_variations)) {
                ?>
                <table class="product_type">
                    <tbody>
                    <tr class="main-tr">
                        <td class="block">
                            <table class="table footable footable-1 breakpoint-lg table-bordered"
                                   data-toggle-column="last">
                                <thead>
                                <tr class="row-title">
                                    <th colspan="5"><h2 class="variation-product-title"><?php echo $product->get_title() . ' - ' . $attribute_name; ?></h2>
                                    </th>
                                </tr>
                                <tr class="footable-header">
                                    <th class="footable-first-visible"><?php echo $attribute_name; ?></th>
                                    <th>Price:</th>
                                    <th class="hide-mobile">Price/unit</th>
                                    <th>Quantity</th>
                                    <th class="footable-last-visible">Add To Cart</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($product_variations as $key => $product_variation) {
                                    $attribute = array_values($product_variation['attributes']);
                                    $medicineTpe = !empty(get_post_meta($id, '_medicine_type', true)) ? get_post_meta($id, '_medicine_type', true) : 'Piece';
                                    ?>
                                    <tr>
                                        <td class="footable-first-visible"><?php echo($attribute[0]); ?></td>
                                        <td> <?php echo $product_variation['price_html']; ?></td>
                                        <td class="hide-mobile">
                                            <?php
                                            $tablets = explode(' ', $attribute[0]);
                                            $unit_price = $product_variation['display_price'] / $tablets[0];
                                            $final_unit = round(number_format($unit_price, 2), 2);
                                            echo get_woocommerce_currency_symbol() . $final_unit . ' /' . $medicineTpe;
                                            ?>
                                        </td>
                                        <td>
											<select class="form-control select-qty">
<!--                                             <select class="form-control select-qty"> -->
                                                <option selected="selected">1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                            </select>
                                        </td>
                                        <td class="footable-last-visible">
                                            <?php
                                            $attr = '';
                                            $attrs = $product_variation['attributes'];
                                            foreach ($attrs as $key => $attr) {
                                                if (!empty($attr)) {
                                                    $attr = $key . '=' . $attr;
                                                } else {
                                                    $attr .= '&' . $key . '=' . $attr;
                                                }
                                            }
                                            $key = '_stock_status';
                                            $checkStock = get_post_meta($product_variation["variation_id"], $key, true);
                                            if (!empty($checkStock) && $checkStock == 'outofstock') {
                                                ?><span class="text-danger">Out of stock</span><?php
                                            } else {
                                                ?>
                                            <a href="<?php echo get_the_permalink() . '?add-to-cart=' . $id . '&quantity=1&variation_id=' . $product_variation["variation_id"] . '&' . $attr . ''; ?>" class="btn btn-primary btn-add-to-cart-ajax"> <svg id="icon-cart" width="20px" height="20px" fill="#fff" xmlns="http://www.w3.org/2000/svg" class="bi bi-cart3"
         viewBox="0 0 16 16">
        <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l.84 4.479 9.144-.459L13.89 4H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
    </svg></a><?php
                                            }
                                            ?>
                                            <!--<a href="<?php echo get_the_permalink() . '?add-to-cart=' . $id . '&quantity=1&variation_id=' . $product_variation["variation_id"] . '&' . $attr . ''; ?>" class="btn btn-primary btn-add-to-cart-ajax">add to cart</a>-->
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>

                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <?php
            }
            ?>
        </div>
        <?php
    }

    public function asgard_amp_search_for_product(){
        if(is_front_page() || is_product()) {
		 ?>
        <div class="visible-xs mobile-search-new-place amp-search">
            <form method="GET" id="searchform" action="<?php echo home_url( '/' ); ?>" target="_top" on="" novalidate>
                <input type="text"  name="s" id="s" placeholder='Search Product' />
                <input type="submit" id="searchsubmit" />
                <input type="hidden" name="post_type" value="product">
            </form>
        </div>
        <?php
        }
    }

    public function asgard_kt_amp_header_content_up_function(){
    ?>
	<div class="custom_amp_support">
		<div class="amp_support_left">
			<a href="tel:+1(877) 925-1112">
				<p>
					+1(877) 925-1112
				</p>
				<span>Call Us</span>
			</a>
		</div>
		<div class="amp_support_right">
			<a href="javascript:void(0)" target="_blank">
				<p>
					+1(877) 925-1112
				</p>
				<span>Click To Chat</span>
			</a>
		</div>
	</div>
	<?php
    }

    public function asgard_woocommerce_add_class_to_cart_item_thumbnail($thumbnail, $cart_item, $cart_item_key) {
         // Get the attachment ID from the thumbnail URL
         $thumbnail_url = '';
         if (preg_match('/<img.*?src=["\'](.*?)["\'].*?>/i', $thumbnail, $matches)) {
            $thumbnail_url = $matches[1];
        }

        // Add classes to the <img> tag
        $classes = 'img-fluid img-thumbnail mx-auto d-block border border-primary border-opacity-25 attachment-thumbnail size-thumbnail';
        $img_tag = '<img src="' . esc_url($thumbnail_url) . '" class="' . esc_attr($classes) . '" alt="' . esc_attr__('Product thumbnail', 'woocommerce') . '" width="150" height="150" />';

        return $img_tag;
    }

    public function asgard_remove_woo_additional_product_tabs( $tabs ){
        unset( $tabs['additional_information'] );  	// Remove the additional information tab
        return $tabs;
    }

    public function asgard_woocommerce_change_default_checkout_country() {
      return 'AU'; // country code
    }

    public function asgard_woocommerce_change_existing_currency_symbol( $currency_symbol, $currency ){
        switch( $currency ) {
              case 'AUD': $currency_symbol = 'AUD$'; break;
         }
         return $currency_symbol;
    }

    public function asgard_woocommerce_custom_product_data_tab_content(){
        global $post;

        // Select box options
        $options = array(
            'Accuhaler'          => __('Accuhaler', 'gma'),
            'Ampoule'            => __('Ampoule', 'gma'),
            'Box'                => __('Box', 'gma'),
            'Bottle'             => __('Bottle', 'gma'),
            'Cream'              => __('Cream', 'gma'),
            'Capsules'           => __('Capsules', 'gma'),
            'Eye Drop'           => __('Eye Drop', 'gma'),
            'ED Pack'            => __('ED Pack', 'gma'),
            'Gel'                => __('Gel', 'gma'),
            'Glucometer'         => __('Glucometer', 'gma'),
            'Gum'                => __('Gum', 'gma'),
            'Injection'          => __('Injection', 'gma'),
            'Inhaler'            => __('Inhaler', 'gma'),
            'Jelly'              => __('Jelly', 'gma'),
            'Kit'                => __('Kit', 'gma'),
            'Lancets'            => __('Lancets', 'gma'),
            'Multihaler'         => __('Multihaler', 'gma'),
            'Needle'             => __('Needle', 'gma'),
            'Ointment'           => __('Ointment', 'gma'),
            'Oral film'          => __('Oral film', 'gma'),
            'Pack'               => __('Pack', 'gma'),
            'Patche'             => __('Patche', 'gma'),
            'Pen'                => __('Pen', 'gma'),
            'Prefilled Syringe'  => __('Prefilled Syringe', 'gma'),
            'Respules'           => __('Respules', 'gma'),
            'Rotacaps'           => __('Rotacaps', 'gma'),
            'Tablet'             => __('Tablet', 'gma'),
            'Tube'               => __('Tube', 'gma'),
            'Turbuhaler'         => __('Turbuhaler', 'gma'),
            'Sachet'             => __('Sachet', 'gma'),
            'Shampoo'            => __('Shampoo', 'gma'),
            'Suppositorie'       => __('Suppositorie', 'gma'),
            'Sof Capsules'       => __('Sof Capsules', 'gma'),
            'Spray'              => __('Spray', 'gma'),
            'Lotion'              => __('Lotion', 'gma'),
            'Vial'               => __('Vial', 'gma'),
            'Vials'              => __('Vials', 'gma'),
            'Syrup'              => __('Syrup', 'gma'),
            'Syringe'              => __('Syringe', 'gma'),
            'Nasal Spray'              => __('Nasal Spray', 'gma'),
            'Pill'              => __('Pill', 'gma'),
            'Strip'              => __('Strip', 'gma'),
            'Patche'              => __('Patche', 'gma'),
            'Unit'              => __('Unit', 'gma'),
        );


        // Get the selected value
        $selected_value = get_post_meta($post->ID, '_medicine_type', true);

        // Output the select box
        echo '<div class="options_group">';

        woocommerce_wp_select(
            array(
                'id'      => '_medicine_type',
                'label'   => __('Medicine Type', 'gma'),
                'options' => $options,
            )
        );

        echo '</div>';
    }

    public function asgard_woocommerce_save_custom_product_data( $post_id ){
        $medicine_type = isset($_POST['_medicine_type']) ? sanitize_text_field($_POST['_medicine_type']) : '';
        update_post_meta($post_id, '_medicine_type', $medicine_type);
    }

}