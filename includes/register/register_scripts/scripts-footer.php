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
    wp_register_script( 'theme-js', THEME_URI . '/assets/public/js/theme.min.js', array('jquery'), '', true );
    wp_localize_script( 'theme-js', 'hcc_ajax_params', array(
		'ajaxurl' => SITE_URL . '/wp-admin/admin-ajax.php',
        'error_header' => __('Ошибка отправки', 'hcc'),
        'error_body' => __('Пожалуйста, попробуйте позже', 'hcc'),
        'success_header' => __('Спасибо!', 'hcc'),
        'success_body' => __('Ваше сообщение отправлено. Мы свяжемся с Вами в ближайшее время', 'hcc'),
        'cfThankYou' => htmlspecialchars( trim( get_option('hcc-theme-cf-thanks') ) ),
        'more_text' => __('Показать ещё', 'hcc'),
        'error_text' => __('Ошибка запроса', 'hcc'),
        'load_text' => __('Загрузка', 'hcc'),
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
        'minute' => __('минута', 'hcc'),
        'minutes' => __('минут', 'hcc'),
        'minut' => __('минуты', 'hcc'),
    ) );
    wp_enqueue_script( 'theme-js' );
}
