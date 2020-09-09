<?php
/*
 * Loop WOO templates hooks
 *
 */

/**
 * Remove default WooCommerce notices & result count blocks.
 */
add_action( 'woocommerce_init', function() {
  remove_action('woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10);
  remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
});

/**
 * Remove default WooCommerce pagination.
 */
/*
add_action( 'woocommerce_init', function() {
  remove_action('woocommerce_after_shop_loop', 'woocommerce_pagination', 10);
});
*/

/**
 * WOO loop wrap wrapper start
 */
//add_action( 'woocommerce_before_shop_loop', 'hcc_woocommerce_product_columns_wrapper', 40 );
if ( ! function_exists( 'hcc_woocommerce_product_columns_wrapper' ) ) {
	/**
	 * Product columns wrapper.
	 *
	 * @return  void
	 */
	function hcc_woocommerce_product_columns_wrapper() {
        echo '';
	}
}

/**
 * WOO loop wrap wrapper end
 */
//add_action( 'woocommerce_after_shop_loop', 'hcc_woocommerce_product_columns_wrapper_close', 40 );
if ( ! function_exists( 'hcc_woocommerce_product_columns_wrapper_close' ) ) {
	/**
	 * Product columns wrapper close.
	 *
	 * @return  void
	 */
	function hcc_woocommerce_product_columns_wrapper_close() {
		echo '';
	}
}
