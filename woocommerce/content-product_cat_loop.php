<?php
/*
 * Custom template for override WOO categories output
 *
 */
// Main cats
$product_categories = get_categories( 
  apply_filters(
          'woocommerce_product_subcategories_args',
          array(
              'taxonomy'     => 'product_cat',
              'type'         => 'product',
              'parent'       => is_product_category() ? get_queried_object_id() : 0,
              'orderby'      => 'name',
              'order'        => 'ASC',
              'hide_empty'   => is_shop() ? 0 : 1,
              'hierarchical' => 0,
              'exclude'      => array(
                get_term_by('name', 'Без категории', 'product_cat', 'ARRAY_A')['term_taxonomy_id'],
                get_term_by('name', 'No category', 'product_cat', 'ARRAY_A')['term_taxonomy_id'],
                get_term_by('name', 'Uncategorized', 'product_cat', 'ARRAY_A')['term_taxonomy_id'],
                get_term_by('name', 'Без рубрики', 'product_cat', 'ARRAY_A')['term_taxonomy_id'],   
              ),
              'include'      => '',
              'pad_counts'   => false,
          )
  ));


if( !empty( $product_categories ) && is_array( $product_categories ) ) :
  wc_get_template_part( 'loop/loop_cat', 'start' );

  $parent_ids = ( is_shop() ) ? array() : null;
  foreach( $product_categories as $cat ) :
    
    wc_get_template(
        'content-product_cat.php',
        array(
            'category' => $cat,
        )
    );
    if( !is_null( $parent_ids ) ) :
      array_push( $parent_ids, $cat->cat_ID );
    endif;
  endforeach;
  wc_get_template_part( 'loop/loop_cat', 'end' );

  // Subcats
  if( is_shop() && !empty( $parent_ids ) && is_array( $parent_ids ) ) :
    wc_get_template_part( 'loop/loop_cat', 'start' );

    foreach( $parent_ids as $id ) :
      $cats = get_categories( 
      apply_filters(
              'woocommerce_product_subcategories_args',
              array(
                  'taxonomy'     => 'product_cat',
                  'type'         => 'product',
                  'parent'       => $id,
                  'orderby'      => 'name',
                  'order'        => 'ASC',
                  'hide_empty'   => 1,
                  'hierarchical' => 0,
                  'include'      => '',
                  'pad_counts'   => false,
              )
      ));
      if( !is_null( $cats ) && is_array( $cats ) ) :

        foreach( $cats as $key => $cat ) : 
          wc_get_template(
              'content-product_cat.php',
              array(
                  'category' => $cat,
              )
          );
        endforeach;

      endif;
    endforeach;

    wc_get_template_part( 'loop/loop_cat', 'end' );
  endif;

endif;
