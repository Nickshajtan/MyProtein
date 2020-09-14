<?php
/*
 * Content for Woo single page of product
 *
 *
 */
?>

 

  
  <div class="col-12 col-md-6 col-xl-7">
    <?php if( $title ) : ?>
      <div class="w-100 woo-product__data__title">
        <h1 class="product-title text-left text-white"><?php echo $title; ?></h1>
        <?php
        if( $product->is_type( 'simple' ) ) :
          echo $price_text;
        endif;

        if( $product->is_type( 'variable' ) ) :
          echo __('от ', 'woocommerce') . $price_text;
        endif; 
        ?>
      </div>
    <?php endif; ?>

    <div class="w-100 woo-product__data__to-cart-btn d-flex justify-content-end">
      <div class="woo-product__data__to-cart-btn__wrapper">
        <a href="<?php echo do_shortcode('[add_to_cart_url id="'. $id .'"]'); ?>" class="woo-shop__products__item__to-cart add_to_cart_button w-100 button text-white text-center"><?php echo __('Купить', 'woocommerce'); ?></a>
      </div>
    </div>
  </div>



 
