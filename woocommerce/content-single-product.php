<?php
/*
 * Content for Woo single page of product
 *
 *
 */
global $post;
global $product;

$image   = esc_url( get_the_post_thumbnail_url() );
$id      = get_the_ID();
$cycle   = get_field('product_faq', $id);

/**
 * Hook: woocommerce_before_single_product_summary.
 *
 * @hooked woocommerce_show_product_sale_flash - 10
 * @hooked woocommerce_show_product_images - 20
 */
do_action( 'woocommerce_before_single_product_summary' ); ?>

<div class="row">
  <?php wc_get_template( 'single-product/sale-flash.php' );
  if( !empty( $image ) ) : ?>
    <div class="col-12 col-md-6 col-xl-5 woo-product__data__image">
      <?php wc_get_template( 'single-product/product-image.php' ); ?>
    </div>
  <?php endif; ?>
  
  <div class="col-12 col-md-6 col-xl-7 woo-product__data__additional">
    <div class="row">
     <div class="col-12">
       <?php wc_get_template( 'single-product/title.php' ); ?>
     </div>
     <div class="col-12">
       <?php wc_get_template( 'single-product/price.php' ); ?>
     </div>
      <?php
		/**
		 * Hook: woocommerce_single_product_summary.
		 *
		 * 
		 * @hooked woocommerce_template_single_add_to_cart - 30
		 * @hooked WC_Structured_Data::generate_product_data() - 60
		 */
		do_action( 'woocommerce_single_product_summary' ); ?>
        <div class="col-12">
          <?php wc_get_template( 'single-product/rating.php' ); ?>
        </div>
    </div>
  </div>
  
  <div class="col-12 woo-product__data__meta">
    <?php wc_get_template( 'single-product/meta.php' ); ?>
  </div>
  
  <div class="col-12 woo-product__data__main">
    <?php
    /**
	 * Hook: woocommerce_after_single_product_summary.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 * @hooked woocommerce_output_related_products - 20
	 */
	do_action( 'woocommerce_after_single_product_summary' ); ?>
  </div>
  
  <?php if( !is_null( $cycle ) && is_array( $cycle ) ) : ?>
    <div id="accordion" class="col-12 woo-product__data__faq">
      <?php $counter = 1;
      foreach( $cycle as $block ) :
            $question = wp_kses_post( $block['question'] );
            $answer   = wp_kses_post( $block['answer'] );

            if( !empty( $answer ) || !empty( $question ) ) : ?>

              <div class="woo-product__data__faq__card row">
                <?php if( !empty( $question ) ) : ?>
                  <div class="col-12 pl-0 pr-0 m-0 card-header product-title" id="heading-<?php echo $counter; ?>">
                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapse-<?php echo $counter; ?>" aria-expanded="true" aria-controls="collapse-<?php echo $counter; ?>">
                      <?php echo $question; ?>
                    </button>
                  </div>
                <?php endif;
                if( !empty( $answer ) ) : ?>
                <div id="collapse-<?php echo $counter; ?>" class="collapse <?php echo ( $counter === 1 ) ? 'show' : ''; ?> col-12 pl-0 pr-0 m-0" aria-labelledby="heading-<?php echo $counter; ?>" data-parent="#accordion">
                  <div class="card-body w-100">
                    <?php echo $answer; ?>
                  </div>
                </div>
                <?php endif; ?>
              </div>

            <?php endif;

      $counter++; endforeach; ?>
    </div>
  <?php endif; ?>
</div>
