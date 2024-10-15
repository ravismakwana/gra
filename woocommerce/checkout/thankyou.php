<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="woocommerce-order mt-4">

	<?php
	if ( $order ) :

		do_action( 'woocommerce_before_thankyou', $order->get_id() );
		?>

		<?php if ( $order->has_status( 'failed' ) ) : ?>

			<p class="mb-3 alert alert-danger woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
				<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php esc_html_e( 'Pay', 'woocommerce' ); ?></a>
				<?php if ( is_user_logged_in() ) : ?>
					<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php esc_html_e( 'My account', 'woocommerce' ); ?></a>
				<?php endif; ?>
			</p>

		<?php else : ?>

			<div class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received alert alert-success"><?php echo apply_filters('woocommerce_thankyou_order_received_text', __('Thank you. Your order has been received.', 'woocommerce'), $order); ?>
							<br><?php echo apply_filters('woocommerce_thankyou_order_received_check_mail', __('Please check your email for payment process.', 'woocommerce'), $order); ?>
              <br><?php echo apply_filters('woocommerce_thankyou_order_received_check_spam', __('If you do not receive email, Kindly check your spam folder.', 'woocommerce'), $order); ?>
            </div>

			<ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details alert alert-success row mb-4">

				<li class="woocommerce-order-overview__order order col-12 col-sm-6 col-lg-4 col-xl-2 fs-6 px-3 me-0 border-end-0 mb-3 mb-xl-0">
					<?php esc_html_e( 'Order number:', 'woocommerce' ); ?>
					<strong class="lh-base fs-6"><?php echo $order->get_order_number(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</li>

				<li class="woocommerce-order-overview__date date col-12 col-sm-6 col-lg-4 col-xl-2 fs-6 px-3 me-0 border-end-0 mb-3 mb-xl-0">
					<?php esc_html_e( 'Date:', 'woocommerce' ); ?>
					<strong class="lh-base fs-6"><?php echo wc_format_datetime( $order->get_date_created() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</li>

				<?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
					<li class="woocommerce-order-overview__email email col-12 col-sm-6 col-lg-4 col-xl-3 fs-6 px-3 me-0 border-end-0 mb-3 mb-xl-0">
						<?php esc_html_e( 'Email:', 'woocommerce' ); ?>
						<strong class="lh-base fs-6"><?php echo $order->get_billing_email(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
					</li>
				<?php endif; ?>

				<li class="woocommerce-order-overview__total total col-12 col-sm-6 col-lg-4 col-xl-2 fs-6 px-3 me-0 border-end-0 mb-3 mb-lg-0 mb-xl-0">
					<?php esc_html_e( 'Total:', 'woocommerce' ); ?>
					<strong class="lh-base fs-6"><?php echo $order->get_formatted_order_total(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
				</li>

				<?php if ( $order->get_payment_method_title() ) : ?>
					<li class="woocommerce-order-overview__payment-method method col-12 col-sm-6 col-lg-4 col-xl-3 fs-6 px-3 me-0 border-end-0 mb-0 mb-xl-0">
						<?php esc_html_e( 'Payment method:', 'woocommerce' ); ?>
						<strong class="lh-base fs-6"><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
					</li>
				<?php endif; ?>

			</ul>

		<?php endif; ?>

		<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
		<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

	<?php else : ?>

		<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'woocommerce' ), null ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>

	<?php endif; ?>

</div>
