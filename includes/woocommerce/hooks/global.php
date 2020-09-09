<?php
/*
 * Global WOO templates hooks
 * See also in file woo_helpers
 *
 */

/**
 * Remove default WooCommerce wrapper.
 */
add_action( 'woocommerce_init', function() {
  remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
  remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
});

if ( ! function_exists( 'hcc_woocommerce_wrapper_before' ) ) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function hcc_woocommerce_wrapper_before() {
		echo '<section id="primary" class="content-area woo-wrap woo-shop"><div class="container"><div class="row">';
	}
}
add_action( 'woocommerce_before_main_content', 'hcc_woocommerce_wrapper_before' );

if ( ! function_exists( 'hcc_woocommerce_wrapper_after' ) ) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 */
	function hcc_woocommerce_wrapper_after() {
        echo '</div></div></section>';
	}
}
add_action( 'woocommerce_after_main_content', 'hcc_woocommerce_wrapper_after' );
