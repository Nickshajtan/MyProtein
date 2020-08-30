<?php
/*
 * Woo breadcrumbs settings
 *
 *
 */

// Disable
add_action( 'init', 'hcc_woo_no_breadcrumbs' );
function hcc_woo_no_breadcrumbs() {
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
}

// Home url link
add_filter( 'woocommerce_breadcrumb_home_url', 'hcc_woo_breadcrumbs_home_url' );
function hcc_woo_breadcrumbs_home_url() {
	return home_url();
}

// Settings
add_filter( 'woocommerce_breadcrumb_defaults', 'hcc_woo_breadcrumbs_array' );
function hcc_woo_breadcrumbs_array( $defaults ) {
    $sep   = get_option('wpseo_titles')['separator'];
    $title = wp_kses_post( get_the_title( get_option('page_on_front') ) );
  
    $defaults[ 'home' ]      = ( !empty( $title ) ) ? $title : __('Главная', 'hcc');
    $defaults[ 'delimiter' ] = ( !empty( $sep ) )   ? $sep   : '&nbsp;&rarr;&nbsp;';
    return $defaults;
}
