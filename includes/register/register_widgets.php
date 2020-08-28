<?php
/**
 * Register & setup your widgets in this file.
 * 
 */
?>
<?php
/*
* Disable some default widgets
*
*/
add_action( 'widgets_init', 'hcc_remove_default_widget', 20 );
function hcc_remove_default_widget() {
	unregister_widget('WP_Widget_Archives'); 
	unregister_widget('WP_Widget_Calendar'); 
	//unregister_widget('WP_Widget_Categories'); 
	unregister_widget('WP_Widget_Meta');
	unregister_widget('WP_Widget_Pages');
	unregister_widget('WP_Widget_Recent_Comments');
	//unregister_widget('WP_Widget_Recent_Posts');
	unregister_widget('WP_Widget_RSS');
	//unregister_widget('WP_Widget_Search');
	//unregister_widget('WP_Widget_Tag_Cloud');
	//unregister_widget('WP_Widget_Text'); 
	//unregister_widget('WP_Nav_Menu_Widget');
}

/*
* Register sidebars
*
*/
add_action( 'init', 'hcc_register_sidebars' );
function hcc_register_sidebars(){
    $args = array(
        'name'          => __('Sidebar', 'hcc') . ' %d',
        'id'            => "sidebar-%d",
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget'  => '</li>',
        'before_title'  => '<p class="widgettitle"><b>',
        'after_title'   => '</b></p>' 
    );
    
    // Helper function
    $register = function( $name, $count ) use ( $args ) {
       $num = ( $count > 1 ) ? ' %d' : '';
       $args['name'] = $name . $num;
       $args['id']   = $name . $num;
       register_sidebars( $count, $args );
    };
    
    $register( __('Header', 'hcc'), 2 );
    $register( __('Search', 'hcc'), 1 );
    $register( __('Footer', 'hcc'), 3 );
  
    $woo = ( defined('WOO_SUPPORT') ) ? WOO_SUPPORT : is_plugin_active( 'woocommerce/woocommerce.php' );
    if ( $woo ) {
      $register( __('WOO-Left', 'hcc'), 1 );
      $register( __('WOO-Right', 'hcc'), 1 );
    }
}

