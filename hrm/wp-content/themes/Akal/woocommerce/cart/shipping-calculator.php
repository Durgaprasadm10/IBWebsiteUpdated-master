<?php
/**
 * Shipping Calculator
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.8
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;

if ( get_option( 'woocommerce_enable_shipping_calc' ) === 'no' || ! WC()->cart->needs_shipping() )
	return;
?>
<?php do_action( 'woocommerce_before_shipping_calculator' ); ?>

<form class="shipping_calculator" action="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" method="post">
  <h3><span><a href="#" class="shipping-calculator-button">
    <?php esc_html_e( 'Calculate Shipping', 'woocommerce' ); ?>
    </a></span></h3>
  <div class="shipping-calculator-form">
    <div class="input-wrapper">
      <select name="calc_shipping_country" id="calc_shipping_country" class="country_to_state" rel="calc_shipping_state">
        <option value="">
        <?php esc_html_e( 'Select a country&hellip;', 'woocommerce' ); ?>
        </option>
        <?php
					foreach( WC()->countries->get_shipping_countries() as $key => $value )
						echo '<option value="' . esc_attr( $key ) . '"' . selected( WC()->customer->get_shipping_country(), esc_attr( $key ), false ) . '>' . esc_html( $value ) . '</option>';
				?>
      </select>
    </div>
    <div class="row-fluid element-vpadding-small2">
      <?php
				$current_cc = WC()->customer->get_shipping_country();
				$current_r  = WC()->customer->get_shipping_state();
				$states     = WC()->countries->get_states( $current_cc );

				// Hidden Input
				if ( is_array( $states ) && empty( $states ) ) {

					?>
      <div class="span6">
        <div class="input-wrapper">
          <input type="hidden" name="calc_shipping_state" id="calc_shipping_state" placeholder="<?php esc_html_e( 'State / county', 'woocommerce' ); ?>" />
        </div>
      </div>
      <?php

				// Dropdown Input
				} elseif ( is_array( $states ) ) {

					?>
      <div class="span6">
        <div class="input-wrapper">
          <select name="calc_shipping_state" id="calc_shipping_state" placeholder="<?php esc_html_e( 'State / county', 'woocommerce' ); ?>">
            <option value="">
            <?php esc_html_e( 'Select a state&hellip;', 'woocommerce' ); ?>
            </option>
            <?php
								foreach ( $states as $ckey => $cvalue )
									echo '<option value="' . esc_attr( $ckey ) . '" ' . selected( $current_r, $ckey, false ) . '>' .  esc_html( $cvalue ).'</option>';
							?>
          </select>
        </div>
      </div>
      <?php

				// Standard Input
				} else {
 
					?>
      <div class="span6">
        <div class="input-wrapper">
          <input type="text" class="input-text" value="<?php echo esc_attr( $current_r ); ?>" placeholder="<?php esc_html_e( 'State / county', 'woocommerce' ); ?>" name="calc_shipping_state" id="calc_shipping_state" />
        </div>
      </div>
      <?php

				}
			?>
      <?php if ( apply_filters( 'woocommerce_shipping_calculator_enable_city', false ) ) : ?>
      <div class="span6">
        <div class="input-wrapper">
          <input type="text" class="input-text" value="<?php echo esc_attr( WC()->customer->get_shipping_city() ); ?>" placeholder="<?php esc_html_e( 'City', 'woocommerce' ); ?>" name="calc_shipping_city" id="calc_shipping_city" />
        </div>
      </div>
      <?php endif; ?>
      <?php if ( apply_filters( 'woocommerce_shipping_calculator_enable_postcode', true ) ) : ?>
      <div class="span6">
        <div class="input-wrapper">
          <input type="text" class="input-text" value="<?php echo esc_attr( WC()->customer->get_shipping_postcode() ); ?>" placeholder="<?php esc_html_e( 'Postcode / Zip', 'woocommerce' ); ?>" name="calc_shipping_postcode" id="calc_shipping_postcode" />
        </div>
      </div>
      <?php endif; ?>
      <p>
        <button type="submit" name="calc_shipping" value="1" class="button">
        <?php esc_html_e( 'Update Totals', 'woocommerce' ); ?>
        </button>
      </p>
    </div>
    <?php wp_nonce_field( 'woocommerce-cart' ); ?>
  </div>
</form>
<?php do_action( 'woocommerce_after_shipping_calculator' ); ?>
