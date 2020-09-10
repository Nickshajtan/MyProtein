<?php
/*
 * WOO categories loop template hooks
 *
 */

/**
 * Remove defaults
 */
add_action( 'woocommerce_init', function() {
  remove_filter( 'woocommerce_product_loop_start', 'woocommerce_maybe_show_product_subcategories' );
});
