<?php
/**
 * Register & setup your menus
 * 
 */
?>
<?php
add_action('after_setup_theme', 'hcc_register_menus');
function hcc_register_menus(){
    register_nav_menus( array(
        'header'    => __('Header menu', 'hcc'),
        'footer'    => __('Footer menu', 'hcc'),
        'aside'     => __('Aside menu', 'hcc'),
        'main_menu' => __('Main Navigation', 'hcc'),
    ) );
}