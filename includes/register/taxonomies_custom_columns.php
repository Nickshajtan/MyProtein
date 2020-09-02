<?php
/*
 * Register admin custom columns for taxonomies
 * Sorting by columns
 *
 */

( function() {
  $turn_on     = false;
  $taxes_type  = array();
  $column      = array();
  $num         = 3; //offset
  
  $tax_event = function(){};

  function hcc_term_column_init( $taxes_type, $column, $event, $event_set = null, $num = 3 ) {
    /*
     * @param $taxes_type is string
     * @param $column is array
     * @param $num is number
     */
    $add_column = function( $taxes_type, $column, $num ) {
      add_filter( "manage_edit-{$taxes_type}_columns", function( $columns ) use( $taxes_type, $column, $num ) {
          return array_slice( $columns, 0, $num ) + $column + array_slice( $columns, $num );
      }, 10, 1 );
    };
    
    /*
     * @param $taxes_type is string
     * @param $column is array
     * 
     */
    $set_column = function( $taxes_type, $column ) use( $event, $event_set  ) {
      add_filter("manage_{$taxes_type}_custom_column", function( $content, $colname, $term_id ) use( $taxes_type, $column, $event, $event_set ) {

        foreach( $column as $key => $value ) {
          if( $colname === $key ) {
            $content = $event();
          }
        }
        return $content;
      }, 10, 3 );
    };
    
    /*
     * @param $taxes_type is string
     * @param $column is array
     * 
     */
    $sort_column = function( $taxes_type, $column ) {
      add_filter( "manage_edit-{$taxes_type}_sortable_columns", function( $sortable_columns ) use( $taxes_type, $column ) {
        foreach( $column as $key => $value ) {
          $sortable_columns[$key] = [$key . '_' . $key, false];
        }
        return $sortable_columns;
      });
    };
    
    try {
      if( is_null( $taxes_type ) || is_null( $column ) || is_null( $event ) ) {
        return false;  
      }
      
      if( !is_array( $taxes_type ) && !is_object( $taxes_type ) && !is_string( $taxes_type ) ) {
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
    hcc_cpt_column_init( $taxes_type, $column, $tax_event, null, $num );
  }

})();
