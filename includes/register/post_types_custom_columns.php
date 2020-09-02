<?php
/*
 * Register admin custom columns for post types
 * Sorting by columns
 *
 */

( function() {
  
  // Vars
  $turn_on    = true;
  $post_type  = array('shares');
  $column     = array( 'cpt_tags' => __('Метки', 'hcc') );
  $num        = 4; //offset
  $term       = 'product_tag';

  $get_post_term = function() use( $term ) {
    global $post;
    $term = (string) $term;

    echo '<ul>';
    foreach( get_the_terms( $post->ID, $term ) as $tax ) {
      echo '<li>' . $tax->name . '</li>';
    }
    echo '</ul>';
  };

  /*
   * @param $post type is string | array
   * @param $column is array
   * @param $num is number
   * @param $event is setting data event function
   * @param $event_set is a param for $event function
   * add column with data
   */
  function hcc_cpt_column_init( $post_type, $column, $event, $event_set = null, $num = 4 ) {
    $term = $event_set;

    /*
     * @param $post type is string
     * @param $column is array
     * @param $num is number
     */
    $add_column = function( $post_type, $column, $num ) {
      add_filter( "manage_edit-{$post_type}_columns", function( $columns ) use( $post_type, $column, $num ) {
          return array_slice( $columns, 0, $num ) + $column + array_slice( $columns, $num );
      }, 10, 1 );
    };

    /*
     * @param $post type is string
     * @param $column is array
     * 
     */
    $set_column = function( $post_type, $column ) use( $event, $term ) {
      add_action("manage_{$post_type}_posts_custom_column", function( $colname, $post_id ) use( $post_type, $column, $event, $term ) {

        foreach( $column as $key => $value ) {
          if( $colname === $key ) {
            $event();
          }
        }

      }, 5, 2 );
    };
    
    /*
     * @param $post type is string
     * @param $column is array
     * 
     */
    $sort_column = function( $post_type, $column ) {
      add_filter( "manage_edit-{$post_type}_sortable_columns", function( $sortable_columns ) use( $post_type, $column ) {
        foreach( $column as $key => $value ) {
          $sortable_columns[$key] = [$key . '_' . $key, false];
        }
        return $sortable_columns;
      });
    };

    try {
      if( is_null( $post_type ) || is_null( $column ) || is_null( $event ) ) {
        return false;  
      }
      
      if( !is_array( $post_type ) && !is_object( $post_type ) && !is_string( $post_type ) ) {
        throw new Exception("$post_type has incorrect value");
      }

      if( !is_array( $column ) && !is_object( $column ) ) {
        throw new Exception("$column is not array | object");
      }

      if( !is_object( $event ) ) {
        throw new Exception( gettype( $event ) . " is not a object function");
      }

      if( !is_numeric( $num ) ) {
        throw new Exception("$num is not a number");
      }
      if( is_array( $post_type ) ) {
        foreach( $post_type as $type ) {
          $add_column( $type, $column, $num );
          $set_column( $type, $column );
          $sort_column( $type, $column );
        }
      }
      elseif( is_string( $post_type ) ) {
        $add_column( $post_type, $column, $num );
        $set_column( $post_type, $column );
        $sort_column( $post_type, $column );
      }
      else {
        return false;
      }
    }
    catch( Exception $e ) {
      $message = 'Error ' . $e->getMessage() . ' on line ' . $e->getLine() . ' in file ' . basename( __FILE__ );
      add_action('admin_notices', function() use( $message ){
        echo '<div class="error notice-error"><p>' .  $message . '; </p></div>';
      }, 10, 1); 
      echo $message;
    }
  }
  
  if( $turn_on ) {
    hcc_cpt_column_init( $post_type, $column, $get_post_term, $term, $num );
  }
  
})();
