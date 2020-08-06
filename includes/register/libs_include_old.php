<?php
add_action( 'get_footer', 'hcc_add_footer_libs', 10 );
add_action( 'enqueue_block_editor_assets', 'hcc_add_footer_libs', 10 );
function hcc_add_footer_libs() {
    $libs = get_field('options_libs', 'options');
    if( !empty( $libs ) ){
        foreach( $libs as $lib ){

            if( $lib === 'bootstrap_css' ){
                //Bootstrap CSS
                /*** If CDN available ***/
                $url = 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css';
                $response = wp_remote_get($url);
                $code = wp_remote_retrieve_response_code( $response );
                if ( !is_wp_error( $response ) && isset( $url ) && !empty( $url) && ( $code == '200') ){
                            wp_register_style( 'bootstrap', $url, array(), ' ' );
                            wp_enqueue_style( 'bootstrap' );
                }
                /*** Else ***/
                else{
                        wp_register_style( 'bootstrap', THEME_URI . '/assets/public/libs/bootstrap/bootstrap.min.css', array(), ' ' );
                        wp_enqueue_style( 'bootstrap' );
                }  
                //End Bootstrap CSS
            }
            if( $lib === 'bootstrap_grid_css' ){
                //Bootstrap CSS only grid
                 wp_register_style( 'bootstrap-grid', THEME_URI . '/assets/public/libs/bootstrap/bootstrap-grid.min.css', array(), ' ' );
                 wp_enqueue_style( 'bootstrap-grid' );
                //End
            }
            if( $lib === 'bootstrap_rebot_css' ){
                //Bootstrap CSS only rebot
                 wp_register_style( 'bootstrap-reboot', THEME_URI . '/assets/public/libs/bootstrap/bootstrap-reboot.min.css', array(), ' ' );
                 wp_enqueue_style( 'bootstrap-reboot' );
                //End
            }
            
            if( $lib === 'popper_js' ){
                //Bootstrap Popper JS
                /*** If CDN available ***/
                $popper_url = 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js';
                $response = wp_remote_get($popper_url);
                $code = wp_remote_retrieve_response_code( $response );
                if ( !is_wp_error( $response ) && isset( $popper_url ) && !empty( $popper_url ) && ( $code == '200') ){
                            wp_register_script( 'popper', $popper_url, array(), ' ' );
                            wp_enqueue_script( 'popper' );
                }
                /*** Else ***/
                else{
                        wp_register_script( 'popper', THEME_URI . '/assets/public/libs/bootstrap/popper.min.js', array('jquery'), '', true );
                        wp_enqueue_script( 'popper' );
                }  
                //End Bootstrap Popper JS
            }
            if( $lib === 'bootstrap_js' ){
                //Bootstrap JS
                /*** If CDN available ***/
                $url = 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js';
                $response = wp_remote_get($url);
                $code = wp_remote_retrieve_response_code( $response );
                if ( !is_wp_error( $response ) && isset( $url ) && !empty( $url ) && ( $code == '200') ){
                            wp_register_script( 'bootstrap', $url, array(), ' ' );
                            wp_enqueue_script( 'bootstrap' );
                }
                /*** Else ***/
                else{
                        wp_register_script( 'bootstrap', THEME_URI . '/assets/public/libs/bootstrap/bootstrap.min.js', array('jquery'), '', true );
                        wp_enqueue_script( 'bootstrap' );
                }  
                //End Bootstrap JS
            }
            if( $lib === 'slick' ){
                //Slick jQuery plugin
                 wp_register_style( 'slick-css', THEME_URI . '/assets/public/libs/slick/slick.min.css', array(), ' ' );
                 wp_enqueue_style( 'slick-css' );
                 wp_register_style( 'slick-theme-css', THEME_URI . '/assets/public/libs/slick/slick-theme.min.css', array(), ' ' );
                 wp_enqueue_style( 'slick-theme-css' );
                 wp_register_script( 'slick-js', THEME_URI . '/assets/public/libs/slick/slick.min.js', array('jquery'), '', true );
                 wp_enqueue_script( 'slick-js' );
                //End Slick
            }
            if( $lib === 'waterwall' ){
                //Waterwall jQuery plugin
                 wp_register_script( 'waterwall', THEME_URI . '/assets/public/libs/waterwall/waterwall.min.js', array('jquery'), '', true );
                 wp_enqueue_script( 'waterwall' );
                //End Waterwall
            }
            if( $lib === 'fancybox' ){
                //Fancybox jQuery plugin
                wp_register_style( 'fancybox-css', THEME_URI . '/assets/public/libs/fancybox/fancybox.min.css', array(), ' ' );
                wp_enqueue_style( 'fancybox-css' );
                wp_register_script( 'fancybox-js', THEME_URI . '/assets/public/libs/fancybox/fancybox.min.js', array('jquery'), '', true );
                wp_enqueue_script( 'fancybox-js' );
                //End Fancybox
            }
            if( $lib === 'progressive' ){
                //Progressive Image (Lazy loading) jQuery plugin
                wp_register_style( 'progressive-css', THEME_URI . '/assets/public/libs/progressive-image/progressive.min.css', array(), ' ' );
                wp_enqueue_style( 'progressive-css' );
                wp_register_script( 'progressive-js', THEME_URI . '/assets/public/libs/progressive-image/progressive.min.js', array('jquery'), '', true );
                wp_enqueue_script( 'progressive-js' );
                //End Progressive Image
            }
            if( $lib === 'ias' ){
                //Ias (scroll loading) jQuery plugin
                wp_register_script( 'ias-js', THEME_URI . '/assets/public/libs/ias/ias.min.js', array('jquery'), '', true );
                wp_localize_script( 'ias-js', 'hcc_ias', array(
                    'more_text' => __('Показать ещё', 'hcc'),
                ));
                wp_enqueue_script( 'ias-js' );
                //End Ias
            }
            if( $lib === 'waypoints' ){
                //Waypoints (scroll loading) jQuery plugin
                wp_register_script( 'waypoints-js', THEME_URI . '/assets/public/libs/waypoints/jquery.waypoints.min.js', array('jquery'), '', true );
                wp_enqueue_script( 'waypoints-js' );
                wp_register_script( 'waypoints-helper', THEME_URI . '/assets/public/libs/waypoints/infinite.min.js', array('jquery'), '', true );
                wp_enqueue_script( 'waypoints-helper' );
                //End Waypoints
            }
            if( $lib === 'remodal' ){
                wp_register_style( 'remodal', THEME_URI . '/assets/public/libs/remodal/remodal.min.css', array(), ' ' );
                wp_enqueue_style( 'remodal' );
                wp_register_style( 'remodal-theme', THEME_URI . '/assets/public/libs/remodal/remodal-default-theme.min.css', array(), ' ' );
                wp_enqueue_style( 'remodal-theme' );
                wp_register_script( 'remodal', THEME_URI . '/assets/public/libs/remodal/remodal.min.js', array('jquery'), '', true );
                wp_enqueue_script( 'remodal' );
            }
            if( $lib === 'revealator' ){
                wp_register_style( 'revealator', THEME_URI . '/assets/public/libs/revealator/fm.revealator.jquery.min.css', array(), ' ' );
                wp_enqueue_style( 'revealator' );
                wp_register_script( 'revealator', THEME_URI . '/assets/public/libs/revealator/fm.revealator.jquery.min.js', array('jquery'), '', true );
                wp_enqueue_script( 'revealator' );
            }
        }
    }   
}