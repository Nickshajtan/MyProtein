<?php
/*
 * Styles for header
 *
 */
add_action( 'wp_enqueue_scripts', 'hcc_add_head_styles' );
function hcc_add_head_styles(){
    //Base theme styles
    $path     = '/assets/public/css/base-theme-styles.min.css';
    $filename =  wp_normalize_path( PATH . $path );
    if( is_admin() || file_exists($filename) && filesize($filename) > 0 ){
        wp_register_style( 'base', THEME_URI . $path, array(), '' );
        wp_enqueue_style( 'base' );
    }
    //Compile theme less for first screen
    $path     = '/assets/public/css/less-header-theme-styles.min.css';
    $filename =  wp_normalize_path( PATH . $path );
    if( is_admin() || file_exists($filename) && filesize($filename) > 0 ){
        wp_register_style( 'less-head', THEME_URI . $path, array(), '' );
        wp_enqueue_style( 'less-head' );
    }
    //Compile theme sass for first screen
    $path     = '/assets/public/css/sass-header-theme-styles.min.css';
    $filename =  wp_normalize_path( PATH . $path );
    if( is_admin() || file_exists($filename) && filesize($filename) > 0 ){
        wp_register_style( 'sass-head', THEME_URI . $path, array(), '' );
        wp_enqueue_style( 'sass-head' );
    }
    //Compile theme scss for first screen
    $path     = '/assets/public/css/scss-header-theme-styles.min.css';
    $filename =  wp_normalize_path( PATH . $path );
    if( is_admin() || file_exists($filename) && filesize($filename) > 0 ){
        wp_register_style( 'scss-head', THEME_URI . $path, array(), '' );
        wp_enqueue_style( 'scss-head' );
    }
    //Compile theme stylus for first screen
    $path     = '/assets/public/css/stylus-header-theme-styles.min.css';
    $filename =  wp_normalize_path( PATH . $path );
    if( is_admin() || file_exists($filename) && filesize($filename) > 0 ){
        wp_register_style( 'stylus-head', THEME_URI . $path, array(), '' );
        wp_enqueue_style( 'stylus-head' );
    }
}
