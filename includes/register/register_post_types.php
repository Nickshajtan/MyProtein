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
  function hcc_labels_helper( $type_name, $main_name = null, $main_singular = null, $singular_name = null) {
      if( !is_string( $type_name ) || empty( $type_name ) ) {
        return false;
        exit;
      }
      
      $singular_name = ( !is_null($singular_name) ) ? (string) $singular_name : substr($type_name, 0, -1);
      $main_name     = ( !is_null($main_name) )     ? (string) $main_name : ucfirst($type_name);
      $main_singular = ( !is_null($main_singular) ) ? (string) $main_singular : ucfirst($singular_name);
    
      $labels = array(
                "name" => __($main_name, "hcc"),
                "singular_name" => __($main_singular, "hcc"),
                "menu_name" => __($main_name, "hcc"),
                "all_items" => __("Все " . $main_name, "hcc"),
                "add_new" => __("Добавить " . $singular_name, "hcc"),
                "add_new_item" => __("Добавить " . $singular_name, "hcc"),
                "edit" => __("Редактировать", "hcc"),
                "edit_item" => __("Редактировать", "hcc"),
                "new_item" => __("Новый " . $singular_name, "hcc"),
                "view" => __("Просмотр", "hcc"),
                "view_item" => __("Просмотр " . $singular_name, "hcc"),
                "search_items" => __("Искать " . $singular_name, "hcc"),
                "not_found" => __("Не найдено", "hcc"),
                "not_found_in_trash" => __("Не найдено", "hcc"),
       );
      
      return $labels;
  }
  // all post types with out WP core types
  $post_types = get_post_types( array( 'public'   => true, '_builtin' => false ), 'names', 'and' );
  // actions
  $type_name = 'shares';
  
  if( !post_type_exists( $type_name ) || !hcc_isset_post_type( $type_name, $post_types ) ) {
        $labels = hcc_labels_helper( $type_name, 'Акции', 'Акция', 'акции');
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
                "taxonomies" => array('product_tag'),
           );
          
          if( !is_null( $labels ) && is_array( $labels ) && !is_null( $args ) && is_array( $args ) ) {
            register_post_type( $type_name, $args );
          }
  }
  
  // reviews
  $type_name = 'reviews';  
  
  if( !post_type_exists( $type_name ) || !hcc_isset_post_type( $type_name, $post_types ) ) {
        $labels = hcc_labels_helper( $type_name, 'Отзывы', 'Отзыв', 'отзыв' );

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

/*
 * Set default taxonomy for post type
 *
 *
 */

$set_default_tax = function( $taxonomy, $tax_name, $post_type = array('post') ) {
  try{
    if( is_admin() ){
    
      $taxonomy = trim( $taxonomy );
      $tax_name = trim( $tax_name );
      $term_id  = get_option( "default_{$taxonomy}" );

      global $tax;
      global $type;
      $tax  = trim( $taxonomy );
      $type = $post_type;

      if( empty( $tax ) || empty( $type ) ) {
        throw new Exception("must use global param has incorrect value");
      }
      
      $hcc_set_default_term = function( $post_id, $post ) use ( $taxonomy, $post_type ) {
        $tax  = $taxonomy;
        $type = $post_type;
        
        if( empty( $tax ) || empty( $type ) ) {
          throw new Exception("must use global param has incorrect value");
        }

        $def_term_id  = get_option( "default_$tax" );

        if( !$def_term_id ) {
           throw new Exception("can not to get a tax option");
           return false;
        }

        if ( !in_array( $post->post_type, $type ) ) {
          throw new Exception("$type is not this post type");
          return false;
        }

        if( !has_term('', $tax, $post ) ) {
          if( $def_term = get_term( $def_term_id ) ) {
            wp_set_object_terms( $post->ID, $def_term, $tax );
          }
          else {
            throw new Exception("$def_term is not default tax");
          }
        }
      };
      
      if( is_array($post_type) || is_object($post_type) ) {
        foreach( $post_type as $type ) {
          add_action( "save_post_{$type}", function( $post_id, $post ) use ( $taxonomy, $post_type, $hcc_set_default_term ) {  
            $hcc_set_default_term( $post_id, $post );
          }, 11, 2 ); 
        }
      }
      else {
        add_action( "save_post_{$post_type}", function( $post_id, $post ) use ( $taxonomy, $post_type, $hcc_set_default_term ) {  
          $hcc_set_default_term( $post_id, $post );
        }, 11, 2 );
      }

      add_action( 'wp_loaded', function() use( $taxonomy, $tax_name, $post_type, $term_id, $hcc_set_default_term ) {
          
          if( empty( $taxonomy ) || empty( $tax_name ) || empty( $post_type ) || empty( $term_id ) ) {
              throw new Exception("must use param has incorrect value");
          }
        
          if ( !$term_id ){
              $term    = get_term_by( 'name', $tax_name, $taxonomy );
              $term_id = $term ? $term->term_id : 0;
            
              if( $term_id === 0 ) {
                throw new Exception("$term_id is not default tax id");
              }
              
              if( $term_id !== 0 ) {
                update_option( "default_{$taxonomy}", $term_id );
              }
              
          }

          $els = get_posts( array( 'post_type' => $post_type, 'numberposts' => 0, ) );

          if( !empty( $els ) ) {
            foreach( $els as $el ) {
              $hcc_set_default_term( $el->ID, $el );
            }
          }
          else {
            throw new Exception("$els has empty value");
          }
      });

    }
  }
  catch( Exception $e ) {
    $message = 'Error ' . $e->getMessage() . ' on line ' . $e->getLine() . ' in file ' . basename( __FILE__ );
    add_action('admin_notices', function() use( $message ){
      echo '<div class="error notice-error"><p>' .  $message . '; </p></div>';
    }, 10, 1); 
    echo $message;
  }
  finally {
    //unset( $tax );
    //unset( $type );
  }
  
};

$set_default_tax('product_tag', 'Акции', array('shares') );
