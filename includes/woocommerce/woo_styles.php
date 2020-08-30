<?php
/*
 * Styles settings for WOO
 *
 *
 */

/**
 * Disable the default WooCommerce stylesheet.
 *
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * WooCommerce specific scripts & stylesheets.
 *
 */
add_action( 'wp_enqueue_scripts', 'hcc_woocommerce_scripts' );
function hcc_woocommerce_scripts() {
	wp_enqueue_style( 'hcc-woocommerce-style', THEME_URI . '/woocommerce.css' );

	$font_path   = WC()->plugin_url() . '/assets/fonts/';
	$inline_font = '@font-face {
			font-family: "star";
			src: url("' . $font_path . 'star.eot");
			src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
				url("' . $font_path . 'star.woff") format("woff"),
				url("' . $font_path . 'star.ttf") format("truetype"),
				url("' . $font_path . 'star.svg#star") format("svg");
			font-weight: normal;
			font-style: normal;
		}';

	wp_add_inline_style( 'hcc-woocommerce-style', $inline_font );
}
