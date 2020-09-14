<?php
/*
 * WP queries hooks
 * 
 */

/*
 * Sharies CPT archive page
 * 
 */
add_filter( 'request', function( $request ) {
  $sharies = new WP_Query();
  $sharies->parse_query( $request );
  
  if( !is_admin() && $sharies->is_post_type_archive('shares') ) {
    $request['posts_per_page'] = 1;
  }
  
  return $request;
});
