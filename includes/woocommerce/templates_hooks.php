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
 * WOO categories item template hooks
 * 
 */
get_template_part('includes/woocommerce/hooks/category', 'item');










/*
 * Single card
 *
 */
/*
add_action( 'woocommerce_init', function() {
  remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
  remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
  remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
  remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
  remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
  remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
  remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
  remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
});


add_action( 'woocommerce_before_shop_loop_item', function() {
  global $product;
  $id = $product->get_id();
  echo '<a href="' . esc_url( get_permalink( $id ) ) . '" class="woo-shop__products__item ml-auto mr-auto d-flex flex-column align-items-start"><figure>';
}, 10);


add_action( 'woocommerce_before_shop_loop_item_title', function() {
  global $product;
  $id    = $product->get_id();
  $thumb = esc_url( get_the_post_thumbnail_url( $id ) );
  $alt   = wp_kses_post( get_the_title( $id ) . '|' . get_bloginfo('name') );
  
  if( is_page( get_option('woocommerce_shop_page_id') ) ) {
    $image = ( !empty( $thumb ) && strpos( $thumb, 'wp-header-logo' ) === false ) ? aq_resize( $thumb, 270, 270, true, true, true) : false;
  }
  else {
    $image = ( !empty( $thumb ) && strpos( $thumb, 'wp-header-logo' ) === false ) ? aq_resize( $thumb, 364, 411, true, true, true) : false;
  }
  
  if( !empty( $image ) ) {
    echo '<img src="' . $image . '" alt="' . $alt . '" title="" class="img-responsive img-inner woo-shop__products__item__img"/>';
  }
});

add_action('woocommerce_shop_loop_item_title', function() {
  global $product;
  $id    = $product->get_id();
  $title = wp_kses_post( get_the_title( $id ) );
  
  echo '<figurecaption class="woo-shop__products__item__title d-block w-100">' . $title . '</figurecaption>';
});

add_action('woocommerce_after_shop_loop_item_title', function() {
  global $product;
  $price      = $product->get_price();
  $price_text = '<span class="price">' . $price . '</span> ' . get_woocommerce_currency_symbol();
  
  if( $product->is_type( 'simple' ) ){
    echo $price_text;
  }
  
  if( $product->is_type( 'variable' ) ){
    echo __('от ', 'woocommerce') . $price_text . '<br />' . $product->get_attribute('pol') . '<br/>' . $product->get_attribute('vkus') . '<br/>' .$product->get_attribute('volume') . '<br/>';;
  }
});

add_action( 'woocommerce_after_shop_loop_item', function() {
      echo '</figure></a>';
}, 10);

add_action('woocommerce_after_shop_loop_item', function() {
  global $product;
  echo '<a href="' . do_shortcode('[add_to_cart_url id="'. $product->get_id() .'"]') .'" class="woo-shop__products__item__to-cart add_to_cart_button w-100 button btn_rectangle text-white text-center">' .  __('Купить', 'woocommerce') . '</a>';
});

/*
 * Override Main query for Product categories
 *
 *
 */
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

