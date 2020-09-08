<?php
/*
 * Custom fields for output menu
 *
 */

(function(){
  // Order is important!
  $fields_arr = array(
   '_options',
    array(
      0 => 'menu_image',
      1 => null,
      2 => 'image_pages',
    ),
  );

  /*
   * Change HTML nav render
   * @param $vars is array. Order is important! $vars[0] is str name for ACF group field, $vars[1] is array: 0 is $append field, 1 is $prepend field, 2 is $helper field.
   * @param $menu_location is string. Default values: [header, footer, aside, main_menu]
   * @return html
   */
  $change_nav_output = function( $vars, $menu_location = 'header') {
    
    if( !is_array( $vars ) ) {
      return null;
    }
    
    add_filter('wp_nav_menu_items', function( $items, $args ) use( $menu_location, $vars ) {
      // get menu
      $menu = wp_get_nav_menu_object($args->menu);

      if( !is_null($menu) && $args->theme_location == $menu_location ) {
        $append_field  = esc_url(get_field($menu_location . $vars[0], $menu)[$vars[1][0]] ); //Set BG image
        $prepend_field = null;
        $helper_field  = get_field($menu_location . $vars[0], $menu)[$vars[1][2]]; //Query Objects for BG

        if( is_array( $helper_field ) && ! in_array( get_page_link( get_queried_object_id() ),  $helper_field ) ) {

          $prepend = '';
          $append  = '<style type="text/css"> .site-' . $menu_location . ' { background-image: url(' . $append_field . ');}</style>';

          $prepend = empty( $prepend_field ) ? '' : $prepend;
          $append  = empty( $append_field )  ? '' : $append;

          $items   = $prepend . $items . $append;
        }

      }

      //return
      return $items;
    }, 10, 2);
  };

  $change_nav_output( $fields_arr );

})();

/*
 * Custom fields for output menu item
 *
 */

(function(){

  $item_field = 'icon';

  /*
   * Change HTML nav item render
   * @param $var is string
   * @param $menu_location is string. Default values: [header, footer, aside, main_menu]
   * @return html
   */
  $change_nav_output_item = function( $var, $menu_location = 'header' ) {
    add_filter('wp_nav_menu_objects', function( $items, $args ) use( $menu_location, $var ) {
      
      if( $args->theme_location == $menu_location ) {
        foreach( $items as &$item ) {
          $field = esc_attr( get_field( $var, $item ) );
          
          if( $field ) {
            $item->title .= ' <i class="fa fa-' . $field . '"></i>';
          }
        }
      }
      
      // return
	  return $items;
    }, 10, 2);
  };

  //$change_nav_output_item( $item_field );
})();