<?php
/**
 * Email Footer
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-footer.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates/Emails
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
															</div>
														</td>
													</tr>
												</table>
												<!-- End Content -->
											</td>
											<tr>
											<td align="center" valign="top">
												<!-- Footer Bottom -->
												<table border="0" cellpadding="0" cellspacing="0" width="100%" id="template_header">
													<tr>
														<td id="header_wrapper" class="footer-bottom" style="display: block;padding: 10px 48px;color: #fff;text-align: center;font-size: 12px;">
															<table width="100%">
																<tr>
																	<td><a href="https://www.goodrxaustralia.com/shipping-and-payment/" style="color: #fff; text-decoration: none;">Refund And Returns</a></td>
																	<td><a href="https://www.goodrxaustralia.com/cancellation-policy/" style="color: #fff;text-decoration: none;">Cancellation Policy</a></td>
																	<td><a href="https://www.goodrxaustralia.com/terms-condition/" style="color: #fff;text-decoration: none;">Terms And Conditions</a></td>
																</tr>
															</table>
														</td>
													</tr>
												</table>
												<!-- End Footer Bottom -->
											</td>
										</tr>
									</table>
									<!-- End Body -->
								</td>
							</tr>
							<tr>
								<td align="center" valign="top">
									<!-- Footer -->
									<table border="0" cellpadding="10" cellspacing="0" width="800" id="template_footer">
										<tr>
											<td valign="top">
												<table border="0" cellpadding="10" cellspacing="0" width="100%">
													<tr>
														<td colspan="2" valign="middle" id="credit">
															<?php echo wpautop( wp_kses_post( wptexturize( apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) ) ) ) ); ?>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
									<!-- End Footer -->
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
	</body>
</html>
