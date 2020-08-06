<?php
/*
 *  This file inlude some functions for work with localizing & translating
 *  WP default locale functions:
 */

global $wp_locale; //Global class WP_Locale
$locale = determine_locale();

if( is_textdomain_loaded('hcc') ){
    
    // Localizing user rores
    if( function_exists('hcc_translate_Lore_users') ){
        hcc_translate_Lore_users();
    }
    
    // Customer lang
    if( function_exists('hcc_customer_lang') ){
        add_action('init', 'hcc_customer_lang');
    }
    
    // //be able to get smth another domains localizations, for example:
    // $data = get_translations_for_domain( 'classic-editor' );
    
    switch( $locale ){
        default: null;
    }
}
else{
    load_theme_textdomain( 'hcc', THEME . '/languages' );
}

/*
 * Localizing user rores
 * return array
 */
function hcc_translate_Lore_users(){
    $roles = [];
    foreach ( wp_roles()->roles as $role_name => $role_details ) {
        $roles[ $role_name ] = $role_details['name'];
    }
    return $roles;
}
               
function hcc_customer_lang(){
    if( isset($_COOKIE['user_locale']) ){
        switch_to_locale( $_COOKIE['user_locale'] );
        if( is_locale_switched() ){
            // Do something...
        }
    }
}               

/*
 * Polylang plugin settings
 * 
 */
if( is_plugin_active( 'polylang/polylang.php' ) ){
    $current_lang = pll_current_language();  
    
    //add_action('after_setup_theme', 'hcc_pll_setting');
    function hcc_pll_setting(){
        // Register your strings
        // pll_register_string($text, $domain);
    }
    
    add_filter( 'gettext', 'hcc_pll_get_text', 10, 3 );
    function hcc_pll_get_text( $translation, $text, $to_translate ){
        if(!empty($to_translate[$text])) { 
            return $to_translate[$text];
        }
        else{
            return $translation;
        }
    }

}

/*
 * WPML plugin settings
 * 
 */
if( is_plugin_active( 'sitepress-multilingual-cms/sitepress.php' ) ){
    //add_action('after_setup_theme', 'hcc_wpml_setting');
    function hcc_wpml_settings(){
        // Register your strings
        // icl_register_string($context, $name, $value);
    }
     
}