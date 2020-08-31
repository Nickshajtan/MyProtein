<?php
/*
 * Footer sripts
 *
 */
add_action( 'get_footer', 'hcc_add_footer_scripts' );
function hcc_add_footer_scripts() {
    //Including Google API script
    $key = trim( get_field('google_api_key', 'options') );
    wp_register_script( 'google_map_js', wp_normalize_path( '//maps.googleapis.com/maps/api/js?key=' . $key ), array('jquery'), '', true );
    wp_enqueue_script( 'google_map_js');
    //If you want to enable independently 
    /*wp_register_script( 'custom_google_map_js', THEME_URI . '/assets/js/theme/custom-map.js', array('jquery'), '', true );
    wp_enqueue_script( 'custom_google_map_js');*/
    //Including theme vendor scripts. Always must be on the end!
    wp_register_script( 'vendor-js', THEME_URI . '/assets/public/js/vendor.min.js', array('jquery'), '', true );
    wp_enqueue_script( 'vendor-js' );
    //Including theme scripts. Always must be on the end!
    wp_register_script( 'theme-js', THEME_URI . '/assets/public/js/theme.min.js', array('jquery', 'vendor-js'), '', true );
    wp_localize_script( 'theme-js', 'hcc_ajax_params', array(
		'ajaxurl' => SITE_URL . '/wp-admin/admin-ajax.php',
        'error_header' => __('Sending error', 'hcc'),
        'error_body' => __('Please try again later', 'hcc'),
        'success_header' => __('Thank you!', 'hcc'),
        'success_body' => __('Your message has been sent. We will contact you shortly', 'hcc'),
        'cfThankYou' => htmlspecialchars( trim( get_option('hcc-theme-cf-thanks') ) ),
        'more_text' => __('Show more', 'hcc'),
        'error_text' => __('The request failed', 'hcc'),
        'load_text' => __('Loading', 'hcc'),
        'loader' => get_option('hcc-theme-tl-preloader'),
	) );
    $template = get_post_meta( get_queried_object_id(), '_wp_page_template', true );
    if( $template == 'template-thanks.php' || $template == 'template-contacts.php' || $template == '404.php' || $template == 'template-privacy.php' ){
        $template_ex = false;
    }
    else{
        $template_ex = true;
    }
    wp_localize_script( 'theme-js', 'hcc_js_custom_params', array(
        'home_url' => THEME_HOME_URL,
        'theme_url' => THEME_URI . '/assets/public/',
        'true_theme_url' => THEME_URI,
        'template_name' => $template_ex,
        'is_404' => ( is_404() ) ? 'true' : 'false',
        'minute' => __('minute', 'hcc'),
        'minutes' => __('minutes', 'hcc'),
        'minut' => __('minutes', 'hcc'),
    ) );
    wp_enqueue_script( 'theme-js' );
  
    if( function_exists('is_product') && is_product() ) {
      /*** If CDN available ***/
      $popper_url = 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js';
      $response = wp_remote_get(wp_normalize_path($popper_url));
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
      
      //Bootstrap JS
      /*** If CDN available ***/
      $url = 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js';
      $response = wp_remote_get(wp_normalize_path($url));
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
}
