<?php
/**
 * HCC functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 

/*
 * Helper function for prettying up errors
 * @param string $message
 * @param string $subtitle
 * @param string $title
 */
$theme_error = function ($message, $subtitle = '', $title = '') {
    $title = $title ?: __('HCC &rsaquo; Error', 'hcc');
    $footer = '';
    $message = "<h1>{$title}<br><small>{$subtitle}</small></h1><p>{$message}</p><p>{$footer}</p>";
    wp_die($message, $title);
};

/*
 * Ensure compatible version of PHP is used
 * 
 */
if (version_compare('7.1', phpversion(), '>=')){
    add_action('admin_notices', function(){
                    echo '<div class="warning notice-warning"><p>' .  __('You should be using PHP 7.1 or greater.', 'hcc') . '</p></div>';
    });
    if ( is_user_logged_in() && current_user_can('edit_files') ) {
        $theme_error(__('You must be using PHP 7.1 or greater.', 'hcc'), __('Invalid PHP version', 'hcc'));
    }
    else {
        $theme_error(__('Contact with admin of site, please.', 'hcc'), __('Invalid PHP version', 'hcc'));
    }
}

/*
 * Ensure compatible version of WordPress is used
 * 
 */
if (version_compare('4.7.0', get_bloginfo('version'), '>=')){
    add_action('admin_notices', function(){
                    echo '<div class="error notice-error"><p>' .  __('You must be using WordPress 4.7.0 or greater.', 'hcc') . '</p></div>';
    });  
    if ( is_user_logged_in() && current_user_can('update_core') && current_user_can('edit_files') ) {
        $theme_error(__('You must be using WordPress 4.7.0 or greater.', 'hcc'), __('Invalid WordPress version', 'hcc'));
    }
    else {
        $theme_error(__('Contact with admin of site, please.', 'hcc'), __('Invalid WordPress version', 'hcc'));
    }
}

/*
 * Check ACF including 
 *
 */
if( !class_exists('ACF') ){
    add_action('admin_notices', function(){
                    echo '<div class="error notice-error"><p>' .  __('ACF is not included. Enable it now, please, this plugin is required', 'hcc') . '</p></div>';
    });  
    if ( is_user_logged_in() && current_user_can('update_plugins') && current_user_can('install_plugins') ) {
        $theme_error(__('ACF plugin is not included. Enable it now, please, this plugin is required for website correct work.', 'hcc'), __('Must use component not found.', 'hcc'));
    }
    else {
        $theme_error(__('Contact with admin of site, please.', 'hcc'), __('Must use component not found.', 'hcc'));
    }
    exit;
}

require_once(ABSPATH . 'wp-admin/includes/plugin.php');
require_once(ABSPATH . 'wp-admin/includes/screen.php');
require_once(ABSPATH . 'wp-admin/includes/media.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/image.php');

if(!function_exists('wp_get_current_user')) {
  include(ABSPATH . "wp-includes/pluggable.php"); 
}

/* -- defines -- */
get_template_part('includes/vars');

/* -- register -- */

get_template_part('includes/register/register_scripts');
get_template_part('includes/register/register_menus');
get_template_part('includes/register/menu_walker');
get_template_part('includes/register/register_widgets');
get_template_part('includes/register/register_post_types');
get_template_part('includes/register/register_taxonomies');
get_template_part('includes/register/register_image_sizes');

/*-- WP Multisite (MU) settings --*/

if( is_multisite() ){
    get_template_part('includes/helpers/wpmu_helpers');
}

/* -- config -- */

get_template_part('includes/config/hcc_setup');
get_template_part('includes/config/helper_tubs');
get_template_part('includes/config/instructions_page');
get_template_part('includes/config/admin/general-edits');
get_template_part('includes/config/admin/theme-options');

/* -- helpers -- */

get_template_part('includes/helpers/acf_helpers');
get_template_part('includes/helpers/aq_resizer');
get_template_part('includes/helpers/gutenberg/gutenberg'); 
get_template_part('includes/helpers/users_helpers');
get_template_part('includes/helpers/theme_helpers');
get_template_part('includes/helpers/theme_ajax');

if ( is_plugin_active( 'custom-post-type-ui/custom-post-type-ui.php' ) ) {
   get_template_part('includes/helpers/cpt_data/cptui-sync.php');
}

if ( !is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ) {
    get_template_part('includes/helpers/contact_form');
}

get_template_part('includes/helpers/theme_metaboxes'); 
get_template_part('includes/helpers/menu_metaboxes'); 
//get_template_part('includes/helpers/instagram'); 
get_template_part('includes/helpers/theme_customizer'); 

if ( is_plugin_active( 'wordpress-seo/wp-seo.php' ) ) {
    get_template_part('includes/helpers/yoast_helpers'); 
}
    
if ( is_plugin_active( 'woocommerce/woocommerce.php' ) || in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    get_template_part('includes/helpers/woo_helpers');
}  

if( is_plugin_active( 'polylang/polylang.php' ) || is_plugin_active( 'loco-translate/loco.php' ) || is_plugin_active( 'sitepress-multilingual-cms/sitepress.php' ) ){
    get_template_part('includes/helpers/langs_helpers');
}

/* -- Include GTM -- */
require 'includes/gtm/class-tgm-plugin-activation.php';
require 'includes/gtm/plugins.php'; !
    
//Find BOM
require_once('includes/find_bom.php');


