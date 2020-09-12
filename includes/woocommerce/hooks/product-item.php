<?php
/*
 * WOO products item template hooks
 * 
 */

/**
 * Override defaults
 */
add_action( 'woocommerce_init', function() {
  remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
  
  add_action( 'woocommerce_before_shop_loop_item', function() {
    global $product;
    $id = $product->get_id();
    echo '<a href="' . esc_url( get_permalink( $id ) ) . '" class="woo-shop__products__item ml-auto mr-auto d-flex flex-column align-items-start"><figure>';
  }, 10);
  
  remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
  
  add_action( 'woocommerce_after_shop_loop_item', function() {
    echo '</figure></a>';
  }, 10);
  
  remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
  remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
  
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
  
  remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
  
  add_action('woocommerce_shop_loop_item_title', function() {
    global $product;
    $id    = $product->get_id();
    $title = wp_kses_post( get_the_title( $id ) );

    echo '<figurecaption class="woo-shop__products__item__title d-block w-100">' . $title . '</figurecaption>';
  });
  
  remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
  remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
  
  add_action('woocommerce_after_shop_loop_item_title', function() {
    global $product;
    $price      = $product->get_price();
    $price_text = '<span class="price">' . str_replace( get_woocommerce_currency_symbol(), '', wc_price($price) ) . '</span> ' . get_woocommerce_currency_symbol();

    if( $product->is_type( 'simple' ) ){
      echo ( !empty($price) ) ? $price_text : '';
    }

    if( $product->is_type( 'variable' ) ) {
      $price_text = array( $product->get_variation_price( 'min', false ), $product->get_variation_price( 'max', false ) );
      
      if( $_GET['orderby'] === 'price-desc' ) {
        $price_text = $price_text[0] !== $price_text[1] ? sprintf( __( 'до %1$s', 'woocommerce' ), $price_text[1] ) : $price_text[1];
        echo ( !empty($price_text) ) ? $price_text  . ' ' . get_woocommerce_currency_symbol() : '';
        echo ( !empty( $price ) && empty( $price_text ) ) ? sprintf( __( '%1$s', 'woocommerce' ), $price ) . ' ' . get_woocommerce_currency_symbol() : '';
      }
      else {
        $price_text = $price_text[0] !== $price_text[1] ? sprintf( __( 'от %1$s', 'woocommerce' ), $price_text[0] ) : $price_text[0];
        echo ( !empty($price_text) ) ? $price_text  . ' ' . get_woocommerce_currency_symbol() : '';
        echo ( !empty( $price ) && empty( $price_text ) ) ? sprintf( __( 'от %1$s', 'woocommerce' ), $price ) . ' ' . get_woocommerce_currency_symbol() : '';
      }
    
    }
  });
  
  remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
  
  add_action('woocommerce_after_shop_loop_item', function() {
    global $product;
    $id     = $product->get_id();
    
    $cart_btn   = function( $link, $text, $class = 'enable' ){
      echo '<a href="' . $link .'" class="woo-shop__products__item__to-cart add_to_cart_button w-100 button btn_rectangle text-white text-center ' . $class . '">' . $text . '</a>';
    };
    
    $quantity     = absint( $product->stock_quantity );
    $stock_status = $product->stock_status;
    
    if( $product->is_type( 'simple' ) ) {
      if( $stock_status !== 'outofstock' && $quantity > 0 ) {
        
        echo '<div class="add_to_cart_button hidden">' . do_shortcode('[add_to_cart id="'. $id .'"]') . '</div>';
        
        if( $quantity <= 3 ) {
          $cart_btn( do_shortcode('[add_to_cart_url id="'. $id .'"]'), __('Заканчивается', 'woocommerce') );
        }
        else{
          $cart_btn( do_shortcode('[add_to_cart_url id="'. $id .'"]'), __('Купить', 'woocommerce') );
        }
        
      }
      else {
        $cart_btn( '#', __('Нет в наличии', 'woocommerce'), 'disable' );
      }
    }

    if( $product->is_type( 'variable' ) ) {
      $active = false;
      $variations = $product->get_available_variations();
      if( !empty( $variations ) && is_array( $variations ) ) {
        foreach($variations as $variation) {
             $variation_id  = $variation['variation_id'];
             $variation_obj = new WC_Product_variation($variation_id);
             $stock         = $variation_obj->get_stock_quantity();
             
             if( $active === false ) {
               $active = ( $stock > 0 ) ? true : false;
             }
             
        }
      }
      
      if( $active === true ) {
        echo '<div class="add_to_cart_button hidden">' . do_shortcode('[add_to_cart id="'. $id .'"]') . '</div>';
        $cart_btn( do_shortcode('[add_to_cart_url id="'. $id .'"]'), __('Купить', 'woocommerce') );
      }
      else {
        $cart_btn( '#', __('Нет в наличии', 'woocommerce'), 'disable' );
      }
      
    }
    
  });

});
