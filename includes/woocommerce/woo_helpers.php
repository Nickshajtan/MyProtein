<?php // see origin/woocommerce.php file for original underscores functions
/**
 * WooCommerce setup function.
 *
 */
add_action( 'after_setup_theme', 'hcc_add_woocommerce_support' );
function hcc_add_woocommerce_support() {
	add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
}

/**
 * Change currency symbols
 */
add_filter('woocommerce_currency_symbol', 'hcc_symbol_to_letter', 9999, 2); 
function hcc_symbol_to_letter( $valyuta_symbol, $valyuta_code ) {
	if( $valyuta_code === 'UAH' ) {
		return 'грн';
	}
	if( $valyuta_code === 'RUB' ) {
		return 'руб';
	}
	return $valyuta_symbol;
}

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 */
add_filter( 'body_class', 'hcc_woocommerce_active_body_class' );
function hcc_woocommerce_active_body_class( $classes ) {
	$classes[] = 'woocommerce-active';

	return $classes;
}

/**
 * Products per page.
 *
 */
//add_filter( 'loop_shop_per_page', 'hcc_woocommerce_products_per_page' );
function hcc_woocommerce_products_per_page() {
	return 12;
}

/**
 * Product gallery thumnbail columns.
 *
 */
//add_filter( 'woocommerce_product_thumbnails_columns', 'hcc_woocommerce_thumbnail_columns' );
function hcc_woocommerce_thumbnail_columns() {
	return 4;
}

/**
 * Default loop columns on product archives.
 *
 */
//add_filter( 'loop_shop_columns', 'hcc_woocommerce_loop_columns' );
function hcc_woocommerce_loop_columns() {
	return 3;
}

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
//add_filter( 'woocommerce_output_related_products_args', 'hcc_woocommerce_related_products_args' );
function hcc_woocommerce_related_products_args( $args ) {
	$defaults = array(
		'posts_per_page' => 3,
		'columns'        => 3,
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}
