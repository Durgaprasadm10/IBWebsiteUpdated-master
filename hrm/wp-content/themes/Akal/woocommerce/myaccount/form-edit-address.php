<?php
/**
 * Edit address form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce, $current_user;

$page_title = ( $load_address == 'billing' ) ? esc_html__( 'Billing Address', 'woocommerce' ) : esc_html__( 'Shipping Address', 'woocommerce' );

get_currentuserinfo();
?>
<?php wc_print_notices(); ?>
<?php if ( ! $load_address ) : ?>
<?php wc_get_template( 'myaccount/my-address.php' ); ?>
<?php else : ?>
<div class="brad-woommerce-box brad-woocommerce-form woocommerce-box border-box">
<div class="woocommerce-billing-fields">
<form method="post">
  <h3 class=""><span><?php echo apply_filters( 'woocommerce_my_account_edit_address_title', $page_title ); ?></span></h3>
  <?php foreach ( $address as $key => $field ) : ?>
  <?php woocommerce_form_field( $key, $field, ! empty( $_POST[ $key ] ) ? wc_clean( $_POST[ $key ] ) : $field['value'] ); ?>
  <?php endforeach; ?>
  <p>
    <input type="submit" class="button  button_small" name="save_address" value="<?php esc_html_e( 'Save Address', 'woocommerce' ); ?>" />
    <?php wp_nonce_field( 'woocommerce-edit_address' ); ?>
    <input type="hidden" name="action" value="edit_address" />
  </p>
</form>
</div></div>
<?php endif; ?>
