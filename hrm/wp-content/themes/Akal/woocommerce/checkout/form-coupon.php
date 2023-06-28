<?php
/**
 * Checkout coupon form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;

if ( ! WC()->cart->coupons_enabled() )
	return;

$info_message = apply_filters( 'woocommerce_checkout_coupon_message', esc_html__( 'Have a coupon?', 'woocommerce' ) );
$info_message .= ' <a href="#" class="showcoupon">' . esc_html__( 'Click here to enter your code', 'woocommerce' ) . '</a>';
?>

<div class="box woocommerce-box border-box"> <?php echo $info_message;?>
  <form class="checkout_coupon brad-woocommerce-form" method="post" style="display:none">
    <p class="form-row form-row-first">
      <input type="text" name="coupon_code" class="input-text" placeholder="<?php esc_html_e( 'Coupon code', 'woocommerce' ); ?>" id="coupon_code" value="" />
    </p>
    <p class="form-row form-row-last">
      <input type="submit" class="button" name="apply_coupon" value="<?php esc_html_e( 'Apply Coupon', 'woocommerce' ); ?>" />
    </p>
    <div class="clear"></div>
  </form>
</div>
