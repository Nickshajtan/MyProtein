<?php
/*
 * Woo single page of product
 *
 *
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 
defined( 'ABSPATH' ) || exit;

global $post;
get_header(); 

if( have_posts() ) :
while ( have_posts() ) : 
			the_post();

$content = wp_kses_post( get_the_content() );
$title   = wp_kses_post( get_the_title() );
$image   = esc_url( get_the_post_thumbnail_url() );
$image   = ( !empty( $image ) ) ? aq_resize( $image, 527, 623, true, true, true) : false;

$id         = get_the_ID();
$product    = wc_get_product( $id );
$cycle      = get_field('product_faq', $id);
$price      = $product->get_price();
$price_text = '<span class="price">' . $price . '</span> ' . get_woocommerce_currency_symbol();

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>

<section id="product-<?php the_ID(); ?>" <?php wc_product_class( 'woo-wrap woo-product', $product ); ?>>
   <div class="container">
     <div class="row">
      <div class="col-12 woo-product__data">
         <div class="row">
            <?php if( function_exists('wc_print_notices') ) : ?>
              <div class="col-12 woo-product__data__notices">
                <?php wc_print_notices();?>
              </div>
            <?php endif; ?>
            
            <?php if( !empty( $image ) ) : ?>
              <div class="col-12 col-md-6 col-xl-5 woo-product__data__image">
                <img src="<?php echo $image; ?>" alt="" class="img-responsive img-inner">
              </div>
            <?php endif; ?>
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
            
            <?php if( !empty( $content ) ) : ?>
              <div class="col-12 woo-product__data__content text-white">
                <h3 class="product-title"><?php echo __('Описание товара', 'woocommerce'); ?></h3>
                <?php echo $content; ?>
              </div>
            <?php endif;
            if( !is_null( $cycle ) && is_array( $cycle ) ) : ?>
              <div id="accordion" class="col-12 woo-product__data__faq">
                <?php $counter = 1;
                foreach( $cycle as $block ) :
                      $question = wp_kses_post( $block['question'] );
                      $answer   = wp_kses_post( $block['answer'] );
                
                      if( !empty( $answer ) || !empty( $question ) ) : ?>
                      
                        <div class="woo-product__data__faq__card w-100">
                          <?php if( !empty( $question ) ) : ?>
                            <div class="w-100 card-header product-title" id="heading-<?php echo $counter; ?>">
                              <button class="btn btn-link" data-toggle="collapse" data-target="#collapse-<?php echo $counter; ?>" aria-expanded="true" aria-controls="collapse-<?php echo $counter; ?>">
                                <?php echo $question; ?>
                              </button>
                            </div>
                          <?php endif;
                          if( !empty( $answer ) ) : ?>
                          <div id="collapse-<?php echo $counter; ?>" class="collapse <?php echo ( $counter === 1 ) ? 'show' : ''; ?> w-100" aria-labelledby="heading-<?php echo $counter; ?>" data-parent="#accordion">
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

            <div class="col-12 woo-product__data__featured-products">
              <strong class="title text-left text-white"><?php echo __('Рекомендуемые товары', 'hcc'); ?></strong>
              <?php echo do_shortcode("[featured_products per_page='3' columns='3' order='ASC']"); ?>
            </div>
         </div>
       
        
        <?php //var_dump( $product ); ?> 
      </div>
    </div>
   </div>
</section>
  <?php do_action( 'woocommerce_after_single_product' ); ?>

  <?php if (get_field('flexible_content', $id)) :
      while (has_sub_field('flexible_content', $id)) :
                     $row_layout_slug = get_row_layout();
                     get_template_part('template-parts/flexible', $row_layout_slug);
      endwhile;
  endif; ?>

<?php endwhile;
endif;

get_footer(); ?>