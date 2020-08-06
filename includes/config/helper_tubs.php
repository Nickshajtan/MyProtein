<?php
/*
 * This file enable helpers WP tubs for admin panel users
 * Init tubs
 */

add_action('admin_menu', 'hcc_init_help_tubs');
function hcc_init_help_tubs(){
    $page_hook = ''; // Choose page hook and paste it in action
    add_action( "load-{$page_hook}", "hcc_admin_add_help_tab" );
}

/*
 * Register tub
 * $page_hook is a page slug
 */
function hcc_admin_add_help_tab( $page_hook ) {
    
    switch( $page_hook ){
        case 'example' :
            tub_content( $tub_id, $tub_title, $tub_text );
            break;
        
    }
  
    /*
     * Helper function for creating a tub content
     * $tub_id, $tub_title, $tub_text are a string, 
     */
    function tub_content( $tub_id, $tub_title, $tub_text ){
        $screen = get_current_screen();
        $screen->add_help_tab( array(
          'id'      => (string) $tub_id,
          'title'   => __($tub_title, 'hcc'),
          'content' => '<p>' . __($tub_text, 'hcc') . '</p>',
      ) );
    }
  
}
