<?php
/*
 * Override WP jQuery
 * Main sripts
 *
 */
add_action( 'wp_enqueue_scripts', 'hcc_add_scripts' );
function hcc_add_scripts(){
    
    // jQuery
    wp_deregister_script( 'jquery-core' );
    wp_deregister_script( 'jquery' );
    /*** If CDN available ***/
    $url = 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js';
    $response = wp_remote_get( wp_normalize_path( $url ) );
    $code = wp_remote_retrieve_response_code( $response );
    if ( !is_wp_error( $response ) && isset( $url ) && !empty( $url) && ( $code == '200') ){
	        wp_register_script( 'jquery', $url ,array(), null, true);
	        wp_enqueue_script( 'jquery' );
    }
    /*** Else ***/
    else{
            wp_register_script( 'jquery', THEME_URI . '/assets/public/libs/jquery/jquery.min.js', array(), null, true);
	        wp_enqueue_script( 'jquery');
    }	
    
    // Compile theme scripts
    if( !empty( API_KEY ) && !is_404() ){
        wp_register_script( 'google_map_js', wp_normalize_path( '//maps.googleapis.com/maps/api/js?key=' . API_KEY ), array('jquery'), '', true );
        wp_enqueue_script( 'google_map_js');   
    }
    
}