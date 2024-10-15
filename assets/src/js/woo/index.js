(function ($) {
	class AsgardWoocommerce {
		constructor() {
			this.addToCartAjax();
			this.dropZoneCheckout();
			this.updateQuantity();
		}

		addToCartAjax() {
			if (jQuery('.btn-add-to-cart-ajax').length) {
				$(document).on('click', '.btn-add-to-cart-ajax', function () {
					const btn = jQuery(this);
					const product_id = btn.attr('data-product_id');
					const variation_id = btn.attr('data-variation_id');
					const qty = btn.attr('data-quantity');
					const data_variation = btn
						.attr( 'data-variation' )
						.split('=');
					const var_data = { [data_variation[0]]: data_variation[1] };

					btn.html(
						'<div class="spinner-border spinner-border-sm text-white" role="status"> <span class="visually-hidden">Loading...</span> </div>'
					);

					btn.parent('.footable-last-visible')
						.find( '.checkout_button' )
						.remove();

					jQuery.ajax({
						url: ajax_object.ajax_url,
						data: {
							action: 'woocommerce_add_variation_to_cart',
							product_id: product_id,
							variation_id: variation_id,
							quantity: qty,
							variation: var_data,
						},
						type: 'POST',
						success: function (data) {
							btn.html(
								'<svg width="25" height="25" fill="var(--bs-white)"><use href="#icon-cart"></use></svg>'
							);

							setTimeout(function () {
								btn.html(
									'<svg class="d-block mx-auto m-0" width="25" height="25" fill="var(--bs-white)"><use href="#icon-cart"></use></svg>'
								);
							}, 1000);

							btn.parent('.footable-last-visible').append(
								`<a href="${ajax_object.checkout_url}" title="Checkout" alt="Checkout" class="btn checkout_button p-0 ms-2">
									<svg width="25" height="25" fill="var(--bs-primary)"><use href="#icon-circle-check"></use></svg>
								</a>`
							);

							jQuery('.mini-cart').replaceWith(
								data.fragments['.mini-cart']
							);
							jQuery('div.offcanvas-body-inner').replaceWith(
								data.fragments['div.offcanvas-body-inner']
							);
							jQuery('div.right_cart-subtotal-right').replaceWith(
								data.fragments['div.right_cart-subtotal-right']
							);

							jQuery(
								'div.button-group-single-product'
							).replaceWith(
								data.fragments[
									'div.button-group-single-product'
								]
							);

							jQuery(
								'div.widget_shopping_cart_content'
							).replaceWith(
								data.fragments[
									'div.widget_shopping_cart_content'
								]
							);

							// Trigger the offcanvas to open
							const offcanvasElement =
								document.getElementById( 'offcanvasRight' );
							const bsOffcanvas = new bootstrap.Offcanvas(
								offcanvasElement
							);
							bsOffcanvas.show();
						},
					});
				});
			}
		}

		dropZoneCheckout() {
			const prescription_upload_url =
				ajax_object.ajax_url + '?action=upload_prescription';
			const prescription_delete_url =
				ajax_object.ajax_url + '?action=delete_prescription';
			/* file upload at checkout page*/
			if (jQuery('#uploader').length) {
				$('#uploader').uploadFile({
					url: prescription_upload_url,
					fileName: 'prescription',
					showDelete: true,
					returnType: 'json',
					multiple: false,
					dragDrop: true,
					uploadButtonClass: 'ajax-file-upload lh-1 bg-primary',
					dragDropContainerClass: 'ajax-upload-dragdrop w-100',
					allowedTypes: 'pdf,jpg,jpeg,png',
					onSuccess: function (files, data, xhr, pd) {
						$('#prescription_name').val(data);
					},
					deleteCallback: function (data, pd) {
						$.post(
							prescription_delete_url,
							{ op: 'delete', name: data },
							function (resp, textStatus, jqXHR) {}
						);
						pd.statusbar.hide(); //You choice.
					},
				});
			}
		}

		updateQuantity() {
			if (jQuery('.select-qty').length) {
				$('.select-qty').on('change', function () {
					// Get the selected value
					const selectedQuantity = $( this ).val();
					// Find the corresponding button
					const button = $( this )
						.closest('tr')
						.find( '.btn-add-to-cart-ajax' );
					// Set the data-quantity attribute
					button.attr('data-quantity', selectedQuantity);
				});
			}
		}
	}
	new AsgardWoocommerce();
} )( jQuery );
