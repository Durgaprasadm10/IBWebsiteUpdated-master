<?php
/**
 * Edit account form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.7
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;
?>
<?php wc_print_notices(); ?>
<div class="woocommerce-box border-box">
<form action="" method="post" class="brad-woocommerce-form">
  <p class="form-row form-row-first">
    <label for="account_first_name">
      <?php esc_html_e( 'First name', 'woocommerce' ); ?>
      <span class="required">*</span></label>
    <input type="text" class="input-text" name="account_first_name" id="account_first_name" value="<?php esc_attr( $user->first_name ); ?>" />
  </p>
  <p class="form-row form-row-last">
    <label for="account_last_name">
      <?php esc_html_e( 'Last name', 'woocommerce' ); ?>
      <span class="required">*</span></label>
    <input type="text" class="input-text" name="account_last_name" id="account_last_name" value="<?php esc_attr( $user->last_name ); ?>" />
  </p>
  <p class="form-row form-row-wide">
    <label for="account_email">
      <?php esc_html_e( 'Email address', 'woocommerce' ); ?>
      <span class="required">*</span></label>
    <input type="email" class="input-text" name="account_email" id="account_email" value="<?php esc_attr( $user->user_email ); ?>" />
  </p>
  <p class="form-row form-row-first">
    <label for="password_1">
      <?php esc_html_e( 'Password (leave blank to leave unchanged)', 'woocommerce' ); ?>
    </label>
    <input type="password" class="input-text" name="password_1" id="password_1" />
  </p>
  <p class="form-row form-row-last">
    <label for="password_2">
      <?php esc_html_e( 'Confirm new password', 'woocommerce' ); ?>
    </label>
    <input type="password" class="input-text" name="password_2" id="password_2" />
  </p>
  <div class="clear"></div>
  <p>
    <input type="submit" class="button  button_small" name="save_account_details" value="<?php esc_html_e( 'Save changes', 'woocommerce' ); ?>" />
  </p>
  <?php wp_nonce_field( 'save_account_details' ); ?>
  <input type="hidden" name="action" value="save_account_details" />
</form>
</div>
