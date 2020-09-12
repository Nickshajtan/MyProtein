<?php
/**
 * Register & setup your widgets in this file.
 * 
 */

/*
* Disable some default widgets
*
*/
add_action( 'widgets_init', 'hcc_remove_default_widget', 20 );
function hcc_remove_default_widget() {
	unregister_widget('WP_Widget_Archives'); 
	unregister_widget('WP_Widget_Calendar'); 
	unregister_widget('WP_Widget_Categories'); 
	unregister_widget('WP_Widget_Meta');
	unregister_widget('WP_Widget_Pages');
	unregister_widget('WP_Widget_Recent_Comments');
	//unregister_widget('WP_Widget_Recent_Posts');
	unregister_widget('WP_Widget_RSS');
	unregister_widget('WP_Widget_Search');
	//unregister_widget('WP_Widget_Tag_Cloud');
	unregister_widget('WP_Widget_Text'); 
	unregister_widget('WP_Nav_Menu_Widget');
}

/*
 * Implement woo overrides
 *
 */
add_action( 'widgets_init', function() {
  if( class_exists('\WOO_Widgets\HCC_Widget_Layered_Nav') ) {
    register_widget( '\WOO_Widgets\HCC_Widget_Layered_Nav' );
  }
  if( class_exists('\WOO_Widgets\HCC_Widget_Layered_Nav_Filters') ) {
    register_widget( '\WOO_Widgets\HCC_Widget_Layered_Nav_Filters' );
  }
});
