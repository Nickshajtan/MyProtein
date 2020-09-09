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
function hcc_woocommerce_products_per_page() {
	return 12;
}
//add_filter( 'loop_shop_per_page', 'hcc_woocommerce_products_per_page' );

/**
 * Product gallery thumnbail columns.
 *
 */
function hcc_woocommerce_thumbnail_columns() {
	return 4;
}
//add_filter( 'woocommerce_product_thumbnails_columns', 'hcc_woocommerce_thumbnail_columns' );

/**
 * Default loop columns on product archives.
 *
 */
function hcc_woocommerce_loop_columns() {
	return 3;
}
//add_filter( 'loop_shop_columns', 'hcc_woocommerce_loop_columns' );

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function hcc_woocommerce_related_products_args( $args ) {
	$defaults = array(
		'posts_per_page' => 3,
		'columns'        => 3,
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'hcc_woocommerce_related_products_args' );

if ( ! function_exists( 'hcc_woocommerce_product_columns_wrapper' ) ) {
	/**
	 * Product columns wrapper.
	 *
	 * @return  void
	 */
	function hcc_woocommerce_product_columns_wrapper() {
		$columns = hcc_woocommerce_loop_columns();
		echo '<div class="columns-' . absint( $columns ) . '">';
	}
}
add_action( 'woocommerce_before_shop_loop', 'hcc_woocommerce_product_columns_wrapper', 40 );

if ( ! function_exists( 'hcc_woocommerce_product_columns_wrapper_close' ) ) {
	/**
	 * Product columns wrapper close.
	 *
	 * @return  void
	 */
	function hcc_woocommerce_product_columns_wrapper_close() {
		echo '</div>';
	}
}
add_action( 'woocommerce_after_shop_loop', 'hcc_woocommerce_product_columns_wrapper_close', 40 );

