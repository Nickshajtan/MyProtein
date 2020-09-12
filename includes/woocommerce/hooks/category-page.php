<?php
/*
 * Override Main query for Product categories
 *
 *
 */

add_filter( 'request', function( $request ) {
  $page = new WP_Query();
  $page->parse_query( $request );
  
  if( $page->is_tax( array('product_tag', 'product_cat') ) ) {
    $request['posts_per_page'] = 13;
  }
  
  return $request;
});
