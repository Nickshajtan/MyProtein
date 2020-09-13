<?php
/*
 * WOO products single template hooks
 * 
 */
//save_post_product
/*
add_action("wp", function() {
  
  $products = (object) get_posts( array(
    'post_type'               => 'product',
    'numberposts'             => -1,
    'suppress_filters = true' => false,
  ));
  
  var_dump( count((array)$products) );
  
  foreach( $products as $product ) {
    
    $product = new WC_Product_Variable( $product->ID );
    
    //var_dump( $product->get_price() );

  }

  //wp_die();
  
  

      $price = $product->get_price();
      $price = ( !empty( $price ) ) ? $price : $product->get_variation_price( 'min', false );
      $price = $product->set_price( $price ); 
  
  
});
*/