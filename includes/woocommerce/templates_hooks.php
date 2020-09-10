<?php
/*
 * Global template hooks
 * 
 */
get_template_part('includes/woocommerce/hooks/global');

/*
 * Global loop template hooks
 * 
 */
get_template_part('includes/woocommerce/hooks/loop');

/*
 * WOO sidebar template hooks
 * 
 */
get_template_part('includes/woocommerce/hooks/sidebar');

/*
 * WOO categories loop template hooks
 * 
 */
get_template_part('includes/woocommerce/hooks/category', 'loop');

/*
 * WOO categories template page hooks
 * 
 */
get_template_part('includes/woocommerce/hooks/category', 'page');

/*
 * WOO categories item template hooks
 * 
 */
get_template_part('includes/woocommerce/hooks/category', 'item');

/*
 * WOO products item template hooks
 * 
 */
get_template_part('includes/woocommerce/hooks/product', 'item');





/*
 * Override Main query for Product categories
 *
 *
 *//*
add_action( 'pre_get_posts', function( $query ) {
  
  if( is_product_category( ) ) {  
    $rows       = (int) get_option( 'woocommerce_catalog_rows' );
    $columns    = (int) get_option( 'woocommerce_catalog_columns' );
    $columns    = ( !empty( $columns ) ) ? $columns - 1 : 3;
    $per_option = ( $rows >= 1 ) ? $rows * $columns - 2 : 4 * $columns + 1;
    $per_page   = (int) $per_option;

    if ( get_query_var('paged') ) {
      $paged = get_query_var('paged');
    } 
    elseif ( get_query_var('page') ) {  
        $paged = get_query_var('page');
    } 
    else {
        $paged = 1;
    }
    $paged = (int) $paged;

    $args = array(
        'numberposts'      => 0,
        'posts_per_page'   => $per_page,
        'paged'            => $paged,
        'post_type'        => 'product',
        'orderby'          => 'status',
        'order'            => 'ASC',
        'category_name'    => get_cat_name( get_queried_object()->term_id ),
    );

    if( $query->is_main_query() ) {
      $query->set( 'posts_per_page', $args['posts_per_page'] );
      $query->set( 'post_type', $args['post_type'] );
      $query->set( 'category_name', $args['category_name'] );
      $query->set( 'paged', $args['paged'] );
    }
  }
}, 1);

*/