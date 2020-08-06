<?php
/*
 * @param $url        is string
 * @param $name       is string
 * @param $extension  is string : file extension
 * @param $asset_type is string : file including type, script or style
 * 
 */
function hcc_remote_get( $url, $name, $extension, $asset_type ) {
    try {
        if( !isset( $url ) || empty( $url ) ) {
            throw new Exception( __('URL must be a not null string ', 'hcc') );
        }
        else {
            $url = (string) esc_url( $url );
        }
        if( !isset( $name ) || empty( $name ) ) {
            throw new Exception( __('NAME must be a not null string ', 'hcc') );
        }
        else {
            $name = (string) trim( $name );
        }
        if( !isset( $extension ) || empty( $extension ) ) {
            throw new Exception( __('Type of assets is required param ', 'hcc') );
        }
        else {
            $extension = (string) trim( $extension );
        }
        if( !isset( $asset_type ) || empty( $asset_type ) ) {
            throw new Exception( __('Type of assets is required param ', 'hcc') );
        }
        if( $asset_type !== 'style' && $asset_type !== 'script' ) {
            throw new Exception( __('Invalid parameter value (valid Script or Style) ', 'hcc') );
        }
        else {
            $asset_type = (string) trim( $asset_type );
        }
        $response = wp_remote_get($url);
        $code     = wp_remote_retrieve_response_code( $response );
        if ( !is_wp_error( $response ) && isset( $url ) && !empty( $url) && ( $code == '200') ){ 
            if( $asset_type === 'style' ) {
                wp_register_style( $name, $url, array(), ' ' );
                wp_enqueue_style( $name );
            }
            if( $asset_type === 'script' ) {
                wp_register_script( $name, $url, array('jquery'), '', true );
                wp_enqueue_script( $name );
            }
        }
        else{
            if( $asset_type === 'script' ) {
                wp_register_style( $name, THEME_URI . '/assets/public/libs/' . $name . '/' . $name . $asset_type, array(), ' ' );
                wp_enqueue_style( $name );
            }
            if( $asset_type === 'script' ) {
                wp_register_script( $name, THEME_URI . '/assets/public/libs/' . $name . '/' . $name . $asset_type, array('jquery'), '', true );
                wp_enqueue_script( $name );
            }
        }  
    }
    catch(Exception $e){
        $e = $e->getMessage();
        add_action('admin_notices', function() use( $e ){
            echo '<div class="error notice-error"><p>' .  $e . '; </p></div>';
        }, 10, 1);
    }
}

add_action( 'get_footer', 'hcc_add_footer_libs', 10 );
add_action( 'enqueue_block_editor_assets', 'hcc_add_footer_libs', 10 );
function hcc_add_footer_libs() {
    $libs = get_field('options_libs', 'options');
    if( !empty( $libs ) ){
        foreach( $libs as $lib ){
            switch( $lib ) {
              case 'bootstrap_css' :
                hcc_remote_get('https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css', 'bootstrap', '.min.css', 'style' );
                break;
              case 'bootstrap_grid_css' :
                wp_register_style( 'bootstrap-grid', THEME_URI . '/assets/public/libs/bootstrap/bootstrap-grid.min.css', array(), ' ' );
                wp_enqueue_style( 'bootstrap-grid' );
                break;
              case 'bootstrap_rebot_css' :
                wp_register_style( 'bootstrap-reboot', THEME_URI . '/assets/public/libs/bootstrap/bootstrap-reboot.min.css', array(), ' ' );
                wp_enqueue_style( 'bootstrap-reboot' );
                break;
              case 'popper_js' :
                hcc_remote_get('https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js', 'popper', '.min.js', 'script');
                break;
              case 'bootstrap_js' :
                hcc_remote_get('https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js', 'bootstrap', '.min.js', 'script');
                break;
              case 'slick' :
                wp_register_style( 'slick-css', THEME_URI . '/assets/public/libs/slick/slick.min.css', array(), ' ' );
                wp_enqueue_style( 'slick-css' );
                wp_register_style( 'slick-theme-css', THEME_URI . '/assets/public/libs/slick/slick-theme.min.css', array(), ' ' );
                wp_enqueue_style( 'slick-theme-css' );
                wp_register_script( 'slick-js', THEME_URI . '/assets/public/libs/slick/slick.min.js', array('jquery'), '', true );
                wp_enqueue_script( 'slick-js' );
                break;
              case 'waterwall' :
                wp_register_script( 'waterwall', THEME_URI . '/assets/public/libs/waterwall/waterwall.min.js', array('jquery'), '', true );
                wp_enqueue_script( 'waterwall' );
                break;
              case 'fancybox' :
                wp_register_style( 'fancybox-css', THEME_URI . '/assets/public/libs/fancybox/fancybox.min.css', array(), ' ' );
                wp_enqueue_style( 'fancybox-css' );
                wp_register_script( 'fancybox-js', THEME_URI . '/assets/public/libs/fancybox/fancybox.min.js', array('jquery'), '', true );
                wp_enqueue_script( 'fancybox-js' );
                break;
              case 'progressive' :
                wp_register_style( 'progressive-css', THEME_URI . '/assets/public/libs/progressive-image/progressive.min.css', array(), ' ' );
                wp_enqueue_style( 'progressive-css' );
                wp_register_script( 'progressive-js', THEME_URI . '/assets/public/libs/progressive-image/progressive.min.js', array('jquery'), '', true );
                wp_enqueue_script( 'progressive-js' );
                break;
              case 'ias' :
                wp_register_script( 'ias-js', THEME_URI . '/assets/public/libs/ias/ias.min.js', array('jquery'), '', true );
                wp_localize_script( 'ias-js', 'hcc_ias', array(
                    'more_text' => __('Показать ещё', 'hcc'),
                ));
                wp_enqueue_script( 'ias-js' );
                break;
              case 'waypoints' :
                wp_register_script( 'waypoints-js', THEME_URI . '/assets/public/libs/waypoints/jquery.waypoints.min.js', array('jquery'), '', true );
                wp_enqueue_script( 'waypoints-js' );
                wp_register_script( 'waypoints-helper', THEME_URI . '/assets/public/libs/waypoints/infinite.min.js', array('jquery'), '', true );
                wp_enqueue_script( 'waypoints-helper' );
                break;
               case 'remodal' :
                wp_register_style( 'remodal', THEME_URI . '/assets/public/libs/remodal/remodal.min.css', array(), ' ' );
                wp_enqueue_style( 'remodal' );
                wp_register_style( 'remodal-theme', THEME_URI . '/assets/public/libs/remodal/remodal-default-theme.min.css', array(), ' ' );
                wp_enqueue_style( 'remodal-theme' );
                wp_register_script( 'remodal', THEME_URI . '/assets/public/libs/remodal/remodal.min.js', array('jquery'), '', true );
                wp_enqueue_script( 'remodal' );
                break;
               case 'revealator' :
                wp_register_style( 'revealator', THEME_URI . '/assets/public/libs/revealator/fm.revealator.jquery.min.css', array(), ' ' );
                wp_enqueue_style( 'revealator' );
                wp_register_script( 'revealator', THEME_URI . '/assets/public/libs/revealator/fm.revealator.jquery.min.js', array('jquery'), '', true );
                wp_enqueue_script( 'revealator' );
                break;
            }
        }
    }   
}