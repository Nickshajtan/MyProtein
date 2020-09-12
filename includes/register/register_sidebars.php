<?php
/**
 * Register & setup your sidebars in this file.
 * 
 */

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
       if( $count > 1 ) {
         $counter = 1;
         while( $counter < $count + 1 ) {
            $args['name'] = $name . ' ' . $counter;
            $args['id']   = mb_strtolower($name . '-' . $counter);
            register_sidebar( $args );
            $counter++;
         }
       }
       else {
         $args['name'] = $name;
         $args['id']   = mb_strtolower($name);
         register_sidebar( $args );
       }
    };
    
    $register( __('Header', 'hcc'), 2 );
    $register( __('Search', 'hcc'), 1 );
    $register( __('Footer', 'hcc'), 3 );
  
    $woo = ( defined('WOO_SUPPORT') ) ? WOO_SUPPORT : is_plugin_active( 'woocommerce/woocommerce.php' );
    if ( $woo ) {
      $register( __('WOO-Left', 'hcc'), 1 );
      $register( __('WOO-Right', 'hcc'), 1 );
    }
  
  // Debug
  /*
  $test = function() {
    var_dump( wp_get_sidebars_widgets()['woo-left'] );
    wp_die();
  };
  $test();
  */
}

