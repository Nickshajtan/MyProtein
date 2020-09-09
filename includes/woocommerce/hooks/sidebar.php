<?php
/*
 * WOO sidebar template hooks
 * 
 */

/**
 * Remove default WooCommerce sidebar on shop & products pages.
 */
add_action( 'woocommerce_init', function() {
  if( is_shop() || is_product() ) {
    remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
  }
});
