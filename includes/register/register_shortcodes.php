<?php
/*
 * Register shortcodes
 *
 */

/*
 * Clone WOO category shortcode & change it
 * @return WOO shortcode | false
 *
 */
add_shortcode('hcc_woo_cats', 'hcc_woo_cats_register');
function hcc_woo_cats_register( $atts ) {
   $params = shortcode_atts(array(
      "per_page" => 3,
      "columns"  => 3,
      "order"    => "ASC",
      "orderby"  => "rand",
   ), $atts );
  
   $terms = get_terms(
   array(
        'taxonomy'     => 'product_cat',
        'type'         => 'product',
        'orderby'      => 'name',
        'order'        => 'ASC',
        'hide_empty'   => is_shop() ? false : true,
        'hierarchical' => true,
        'exclude'      => array(
          get_term_by('name', 'Без категории', 'product_cat', 'ARRAY_A')['term_taxonomy_id'],
          get_term_by('name', 'No category', 'product_cat', 'ARRAY_A')['term_taxonomy_id'],
          get_term_by('name', 'Uncategorized', 'product_cat', 'ARRAY_A')['term_taxonomy_id'],
          get_term_by('name', 'Без рубрики', 'product_cat', 'ARRAY_A')['term_taxonomy_id'],   
        ),
    )
   );
  
   if( !empty( $terms ) ) {
      $ids = array();
      foreach( $terms as $term ) {
        array_push( $ids, $term->term_id );
      }
     
      if( !empty( $ids ) ) {
         return do_shortcode('[product_categories per_page="' . $params['per_page'] . '" columns="' . $params['columns'] . '" order="' . $params['order'] . '" orderby="' . $params['orderby'] . '" ids="' . implode(',', $ids) . '"]');
      }
      else {
         return false;
      }
   }
   else {
     return false;
   }
}

/*
 * Clone WOO products shortcode & change it
 * @return WOO shortcode | false
 *
 */
add_shortcode('hcc_woo_products', 'hcc_woo_products_register');
function hcc_woo_products_register( $atts ) {
  global $wpdb;
  
  $params = shortcode_atts(array(
      "per_page" => 3,
      "columns"  => 3,
      "order"    => "ASC",
      "orderby"  => "rand",
   ), $atts );
  
  $user_param = array_diff( $atts, $params );
  if( !empty( $user_param ) ) {
    $user_param_str = '';
    foreach( $user_param as $key => $value ) {
      $user_param_str .= $key . '="' . $value . '" ';
    }
  }
  
  $sql = "SELECT * FROM {$wpdb->wc_product_meta_lookup} WHERE `min_price` is not null AND `stock_status` != 'outofstock' AND `min_price` > 0";
  $ids = implode( ',', $wpdb->get_col($sql, 0) );
  
  if( !empty( $ids ) ) {
    return do_shortcode('[products per_page="' . $params['per_page'] . '" columns="' . $params['columns'] . '" order="' . $params['order'] . '" orderby="' . $params['orderby'] . '" ids="' . $ids . '" ' . $user_param_str . ']');
  }
  else {
    return false;
  }
  
}

/*
 * Clone WOO related products shortcode & change it
 * @return WOO shortcode | false
 *
 */
add_shortcode('hcc_woo_related_products', 'hcc_woo_related_products_register');
function hcc_woo_related_products_register( $atts ) {
  global $wpdb;
  
  $params = shortcode_atts(array(
      "per_page" => 3,
      "columns"  => 3,
      "column"   => 3,
      "order"    => "ASC",
      "orderby"  => "rand",
   ), $atts );
  
  $user_param = array_diff( $atts, $params );
  if( !empty( $user_param ) ) {
    $user_param_str = '';
    foreach( $user_param as $key => $value ) {
      $user_param_str .= $key . '="' . $value . '" ';
    }
  }
  
  $sql = "SELECT * FROM {$wpdb->wc_product_meta_lookup} WHERE `min_price` is not null AND `stock_status` != 'outofstock' AND `min_price` > 0";
  $ids = implode( ',', $wpdb->get_col($sql, 0) );
  
  if( !empty( $ids ) ) {
    return do_shortcode('[related_products per_page="' . $params['per_page'] . '" columns="' . $params['columns'] . '" order="' . $params['order'] . '" orderby="' . $params['orderby'] . '" ids="' . $ids . '" ' . $user_param_str . ']');
  }
  else {
    return false;
  }
  
}
