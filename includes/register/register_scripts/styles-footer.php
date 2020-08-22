<?php
/*
 * Styles for footer
 *
 */
add_action( 'wp_footer', 'hcc_add_footer_styles' );
function hcc_add_footer_styles() {
    //Compile theme fonts
    $path     = '/assets/public/fonts.min.css';
    $filename =  wp_normalize_path( PATH . $path );
    if( is_admin() || file_exists($filename) && filesize($filename) > 0 ){
        wp_register_style( 'fonts', THEME_URI . $path );
        wp_enqueue_style( 'fonts' );
    }
    //Compile theme less
    $path     = '/assets/public/css/less-other-theme-styles.min.css';
    $filename =  wp_normalize_path( PATH . $path );
    if( is_admin() || file_exists($filename) && filesize($filename) > 0 ){
        wp_register_style( 'less-other', THEME_URI . $path );
        wp_enqueue_style( 'less-other' );
    }
    $path     = '/assets/public/css/less-vendor-styles.min.css';
    $filename =  PATH . $path;
    if( is_admin() || file_exists($filename) && filesize($filename) > 0 ){
        wp_register_style( 'less-vendor', THEME_URI . $path );
        wp_enqueue_style( 'less-vendor' );
    }
    //Compile theme sass
    $path     = '/assets/public/css/sass-other-theme-styles.min.css';
    $filename =  wp_normalize_path( PATH . $path );
    if( is_admin() || file_exists($filename) && filesize($filename) > 0 ){
        wp_register_style( 'sass-other', THEME_URI . $path );
        wp_enqueue_style( 'sass-other' );
    }
    $path     = '/assets/public/css/sass-vendor-styles.min.css';
    $filename =  wp_normalize_path( PATH . $path );
    if( is_admin() || file_exists($filename) && filesize($filename) > 0 ){
        wp_register_style( 'sass-vendor', THEME_URI . $path );
        wp_enqueue_style( 'sass-vendor' );
    }
    //Compile theme scss
    $path     = '/assets/public/css/scss-other-theme-styles.min.css';
    $filename =  wp_normalize_path( PATH . $path );
    if( is_admin() || file_exists($filename) && filesize($filename) > 0 ){
        wp_register_style( 'scss-other', THEME_URI . $path );
        wp_enqueue_style( 'scss-other' );
    }
    $path     = '/assets/public/css/scss-vendor-styles.min.css';
    $filename =  wp_normalize_path( PATH . $path );
    if( is_admin() || file_exists($filename) && filesize($filename) > 0 ){
        wp_register_style( 'scss-vendor', THEME_URI . $path );
        wp_enqueue_style( 'scss-vendor' );
    }
    //Compile theme stylus
    $path     = '/assets/public/css/stylus-other-theme-styles.min.css';
    $filename =  wp_normalize_path( PATH . $path );
    if( is_admin() || file_exists($filename) && filesize($filename) > 0 ){
        wp_register_style( 'stylus-other', THEME_URI . $path );
        wp_enqueue_style( 'stylus-other' );
    }
    $path     = '/assets/public/css/stylus-vendor-styles.min.css';
    $filename =  wp_normalize_path( PATH . $path );
    if( is_admin() || file_exists($filename) && filesize($filename) > 0 ){
        wp_register_style( 'stylus-vendor', THEME_URI . $path );
        wp_enqueue_style( 'stylus-vendor' );
    }
    
    //Customizer
    $user_styles = wp_get_custom_css();
    if( !empty( $user_styles ) ){
        $path      = THEME_STYLE_URI . '/wp-users-styles.css';
        $cz_style  = fopen( $path, "w" );
        if( file_exists( $path  ) && is_writable( $path  ) && $cz_style ){
            if (fwrite($cz_style, $user_styles) === FALSE){
                exit;
            }
            fwrite($cz_style, $user_styles);
            fclose($cz_style);
            wp_register_style( 'wp-users-styles', $path );
	        wp_enqueue_style( 'wp-users-styles' );
        }
        else{
            if( $cz_style ){
                fclose($cz_style);
            }
            wp_add_inline_style('wp-style', $user_styles);
        }
    }
    
    //Default
    wp_register_style( 'wp-style', STYLESHEET_URI );
	wp_enqueue_style( 'wp-style' );
}
