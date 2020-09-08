<?php
/*
 * Theme defenitions
 *
 */
define( 'SITE_FOR_CLIENT', false );
// Core
if( !is_admin() && !defined( 'DISALLOW_FILE_EDIT' ) ){
    define( 'DISALLOW_FILE_EDIT', true );
}
if( !defined( 'USED_THEME' ) ){
    define( 'USED_THEME', 'HCC' );
}
if( !defined( 'THEME' ) ){
    define( 'THEME', get_template_directory() );
}
if( !defined( 'THEME_URI' ) ){
    define( 'THEME_URI', get_template_directory_uri() );
}
if( !defined( 'THEME_STYLE' ) ){
    define( 'THEME_STYLE', get_stylesheet_directory() );
}
if( !defined( 'THEME_STYLE_URI' ) ){
    define( 'THEME_STYLE_URI', get_stylesheet_directory_uri() );
}
if( !defined( 'STYLESHEET_URI' ) ){
    define( 'STYLESHEET_URI', get_stylesheet_uri() );
}
if( !defined( 'THEME_HOME_URL' ) ){
    define( 'THEME_HOME_URL', home_url('/') );
}
if( !defined( 'GET_THEME_HOME_URL' ) ){
    define( 'GET_THEME_HOME_URL', get_home_url() );
}
if( !defined( 'SITE_URL' ) ){
    define( 'SITE_URL', site_url() );
}
if( !defined( 'SITE_NAME' ) ){
    define( 'SITE_NAME', wp_kses_post( get_bloginfo('name') ) );
}
if( !defined( 'SITE_CUSTOMIZE' ) ){
    define('SITE_CUSTOMIZE', get_option('hcc-theme-wp-customizing') );
}
// Plugins
if( !defined( 'WOO_SUPPORT' ) ){
  
  $woo_active = is_plugin_active( 'woocommerce/woocommerce.php' );
  $woo_in_arr = in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
  
  if( $woo_active === true || $woo_in_arr === true ) {
    $woo = true;
  }
  else {
    $woo = false;
  }
  
  define( 'WOO_SUPPORT', $woo );
}
// ACF, Site options as define 
if( !defined( 'API_KEY' ) ){
    define( 'API_KEY', get_field('google_key', 'options') );
}

if( !defined( 'COPYRIGHT' ) ){
    define( 'COPYRIGHT', str_ireplace( "%year%", date('Y', time()), get_field('copyright', 'options') ) );
}

$acf_logo = get_field('site_logo', 'options')['ID'];
if( !empty( $acf_logo ) && !defined( 'SITE_LOGO' ) ){
    define( 'SITE_LOGO', wp_get_attachment_image( $acf_logo, array(220, 100), false, array( 'class'    => 'custom-logo', 'itemprop' => 'logo', ) ) );
}
elseif( function_exists( 'the_custom_logo' ) && !defined( 'SITE_LOGO' ) ){
    $logo_img = '';
    if( $custom_logo_id = get_theme_mod('custom_logo') ){
        $logo_img = wp_get_attachment_image( $custom_logo_id, array(220, 100), false, array(
            'class'    => 'custom-logo',
            'itemprop' => 'logo',
        ) );
    }
    define( 'SITE_LOGO', $logo_img );
}

// Meta
if( !defined( 'SITE_INFO' ) ){
    define( 'SITE_INFO', get_bloginfo('description') );
}
if( !defined( 'SITE_NAME' ) ){
    define( 'SITE_NAME', get_bloginfo('name') );
}

//Classes
if( !defined('CORE_CLASSES_DIR') ) {
  define('CORE_CLASSES_DIR', wp_normalize_path( get_stylesheet_directory() . '/includes/classes/core/' ) );
}

if( !defined('APP_CLASSES_DIR') ) {
  define('APP_CLASSES_DIR', wp_normalize_path( get_stylesheet_directory() . '/includes/classes/app/' ) );
}
