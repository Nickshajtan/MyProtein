<?php
/*
 * Display WOO categories & subcategories
 *
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post;
global $woocommerce;
$prod_terms = get_the_terms( $post->ID, 'product_cat' );

$prod_terms = get_categories( [
	'taxonomy'     => 'product_cat',
	'type'         => 'product',
	'child_of'     => 0,
	'parent'       => 0,
	'orderby'      => 'name',
	'order'        => 'ASC',
	'hide_empty'   => 1,
	'hierarchical' => 0,
	'exclude'      => array(
      get_term_by('name', 'Без категории', 'product_cat', 'ARRAY_A')['term_taxonomy_id'],
      get_term_by('name', 'No category', 'product_cat', 'ARRAY_A')['term_taxonomy_id'],
      get_term_by('name', 'Uncategorized', 'product_cat', 'ARRAY_A')['term_taxonomy_id'],
      get_term_by('name', 'Без рубрики', 'product_cat', 'ARRAY_A')['term_taxonomy_id'],   
    ),
	'include'      => '',
	'pad_counts'   => false,
] );


if( !is_null( $prod_terms ) && is_array( $prod_terms ) ) : ?>
      <div class="col-12 woo-shop__categories">
        <ul class="row d-grid grid-column-<?php echo esc_attr( wc_get_loop_prop( 'columns' ) ); ?> woo-shop__categories__grid">
          <?php $counter    = 1;
                $parent_ids = array();
          
                foreach ($prod_terms as $cat) :
                $cat_id       = $cat->cat_ID;
                $cat_name     = wp_kses_post( $cat->name ); 
                $link_url     = esc_url( get_category_link( $cat_id ) );
                $thumbnail_id = get_term_meta( $cat_id, 'thumbnail_id', true );
                $image        = esc_url( wp_get_attachment_url( $thumbnail_id ) );
                $image        = ( !empty( $image ) ) ? aq_resize( $image, 270, 270, true, true, true) : false;
                
                if( !empty( $cat_name ) ) : ?>
                <li <?php wc_product_cat_class( 'woo-shop__categories__grid__item', $category ); ?>>
                  <a href="<?php echo $link_url; ?>" class="woo-shop__categories__item ml-auto mr-auto d-flex flex-column align-items-start <?php echo 'item' . $counter; ?>">
                      <?php if ( $image ) : ?>
                        <div class="woo-shop__categories__item_parent__thumbnail woo-shop__categories__item__thumbnail">
                          <img src="<?php echo $image; ?>" alt="<?php echo wp_kses_post( $cat->description ); ?>">
                        </div>
                      <?php endif; ?>
                    <div class="woo-shop__categories__item_parent__name woo-shop__categories__item__name">
                      <?php echo $cat_name; ?>
                    </div>
                  </a>
                </li>
                <?php array_push( $parent_ids, $cat_id );
                endif;
                $counter++;
          endforeach; ?>
        </ul>
      </div>
      <?php 
      endif; ?>

      <?php if( !is_null( $parent_ids ) && is_array( $parent_ids ) ) : ?>
      <div class="col-12 woo-shop__child-categories">
        <ul class="row d-grid grid-column-<?php echo esc_attr( wc_get_loop_prop( 'columns' ) ); ?> woo-shop__child-categories__grid">
         
         <?php foreach( $parent_ids as $id ) :
            $cats = get_term_children($id, 'product_cat');
            if( !is_null( $cats ) && is_array( $cats ) ) :
              $counter = 1; ?>
          
              <li <?php wc_product_cat_class( 'woo-shop__child-categories__grid__item', $category ); ?>>
                <?php foreach( $cats as $cat ) : 
                $name         = wp_kses_post( get_the_category_by_ID( $cat ) );
                $link         = esc_url( get_category_link( $cat ) );
                $thumbnail_id = get_term_meta( $cat, 'thumbnail_id', true );
                $image        = esc_url( wp_get_attachment_url( $thumbnail_id ) );
                $image        = ( !empty( $image ) ) ? aq_resize( $image, 270, 270, true, true, true) : false;?>

                  <a href="<?php echo $link; ?>" class="woo-shop__child-categories__item mr-auto ml-auto d-flex flex-column align-items-start <?php echo 'item' . $counter; ?>">
                      <?php if ( $image ) : ?>
                        <div class="woo-shop__categories__item_parent__thumbnail woo-shop__categories__item__thumbnail">
                          <img src="<?php echo $image; ?>" alt="<?php echo wp_kses_post( category_description( $cat ) ); ?>">
                        </div>
                      <?php endif; ?>
                    <div class="woo-shop__categories__item_parent__name woo-shop__categories__item__name">
                      <?php echo $name; ?>
                    </div>
                  </a>

                <?php $counter++;
                endforeach; ?>
              </li>
              
            <?php endif; 
          endforeach; ?>
          
        </ul>
      </div>
      <?php endif; ?>
