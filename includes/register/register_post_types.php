<?php
/**
 * Register & setup your custom post types
 * 
 */
/* @param $type_name is string
 * @param $post_types_arr is array
 * @return bool
 */
function hcc_isset_post_type( $type_name, $post_types_arr ) {
  try {
    if( !is_string( $type_name ) || empty( $type_name ) ) {
      throw new Exception( __("Incorrect param of type name: $type_name must be not empty string", 'hcc') );
      return false;
      exit;
    }
    
    if( !is_array( $post_types_arr ) || is_null( $post_types_arr ) ) {
      return false;
      exit;
    }
    
    if( is_array( $post_types_arr ) && in_array( (string) $type_name, (array) $post_types_arr ) ) {
      return true;
    }
    else {
      return false;
    }
  }
  catch (Exception $e) {
    $e = $e->getMessage();
    if( is_admin() ) {
      echo __('Error with post type registration: ', 'hcc') . $e;
    }
    add_action('admin_notices', function() use( $e ){
                            echo '<div class="error notice-error"><p>' . __('Error with post type registration: ', 'hcc') . $e . '; </p></div>';
    }, 10, 1);   
  }
}

add_action( 'init', 'hcc_cpt_manual_register' );
function hcc_cpt_manual_register() {
  function hcc_labels_helper( $type_name ) {
      if( !is_string( $type_name ) || empty( $type_name ) ) {
        return false;
        exit;
      }
      
      $singular_name = substr($type_name, 0, -1);
      $main_name     = ucfirst($type_name);
      $main_singular = ucfirst($singular_name);
    
      $labels = array(
                "name" => __($main_name, "hcc"),
                "singular_name" => __("Event", "hcc"),
                "menu_name" => __($main_name, "hcc"),
                "all_items" => __("All " . $type_name, "hcc"),
                "add_new" => __("Add " . $singular_name, "hcc"),
                "add_new_item" => __("Add " . $singular_name, "hcc"),
                "edit" => __("Edit", "hcc"),
                "edit_item" => __("Edit", "hcc"),
                "new_item" => __("New " . $singular_name, "hcc"),
                "view" => __("View", "hcc"),
                "view_item" => __("View " . $singular_name, "hcc"),
                "search_items" => __("Search " . $singular_name, "hcc"),
                "not_found" => __("Not found", "hcc"),
                "not_found_in_trash" => __("Not found", "hcc"),
       );
      
      return $labels;
  }
  // all post types with out WP core types
  $post_types = get_post_types( array( 'public'   => true, '_builtin' => false ), 'names', 'and' );
  // actions
  $type_name = 'shares';
  
  if( !post_type_exists( $type_name ) || !hcc_isset_post_type( $type_name, $post_types ) ) {
        $labels = hcc_labels_helper( $type_name );

        $args = array(
                "labels" => $labels,
                "description" => "",
                "public" => true,
                "show_ui" => true,
                "has_archive" => true,
                "show_in_menu" => true,
                "exclude_from_search" => false,
                "capability_type" => "post",
                "map_meta_cap" => true,
                "hierarchical" => false,
                "rewrite" => array( 'pages' => true, 'with_front' => true, ),
                "query_var" => true,
                "menu_position" => 4,
                "menu_icon" => "dashicons-admin-post",
                "supports" => array( "title", "editor", "custom-fields", "revisions", "thumbnail", "post-formats" ),
                "can_export" => true,
           );
          
          if( !is_null( $labels ) && is_array( $labels ) && !is_null( $args ) && is_array( $args ) ) {
            register_post_type( $type_name, $args );
          }
  }
  
  // reviews
  $type_name = 'reviews';  
  
  if( !post_type_exists( $type_name ) || !hcc_isset_post_type( $type_name, $post_types ) ) {
        $labels = hcc_labels_helper( $type_name );

        $args = array(
                "labels" => $labels,
                "description" => "",
                "public" => true,
                "show_ui" => true,
                "has_archive" => true,
                "show_in_menu" => true,
                "exclude_from_search" => false,
                "capability_type" => "post",
                "map_meta_cap" => true,
                "hierarchical" => false,
                "rewrite" => array( 'pages' => true, 'with_front' => true, ),
                "query_var" => true,
                "menu_position" => 4,
                "menu_icon" => "dashicons-admin-post",
                "supports" => array( "title", "editor", "custom-fields", "revisions", "thumbnail", "post-formats" ),
                "can_export" => true,
           );

          if( !is_null( $labels ) && is_array( $labels ) && !is_null( $args ) && is_array( $args ) ) {
            register_post_type( $type_name, $args );
          }
  }
}
