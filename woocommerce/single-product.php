<?php
/*
 * Woo single page of product
 *
 *
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 
defined( 'ABSPATH' ) || exit;

global $post;
global $product;
get_header(); 

if( have_posts() ) :
while ( have_posts() ) : 
			the_post();


$title   = wp_kses_post( get_the_title() );

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
} ?>

<section id="product-<?php the_ID(); ?>" <?php wc_product_class( 'woo-wrap woo-product', $product ); ?>>
   <div class="container">
     <div class="row">
      <div class="col-12 woo-product__data">
         <?php wc_get_template_part( 'content', 'single-product' ); ?>
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
else :
    get_template_part('template-parts/content/content', 'none');
endif;

get_footer(); ?>