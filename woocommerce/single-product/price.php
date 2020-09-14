<?php
/**
 * Single Product Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;
$money =  get_woocommerce_currency_symbol();

if( $product->is_type('variable') ) : ?>
<p class="<?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'price' ) ); ?>">
 
 <?php if( $product->is_on_sale() ) : ?>
    
     <?php echo $product->get_variation_regular_price( 'min', true ) . '&mdash;' . $product->get_variation_regular_price( 'max', true ) . ' ' . $money; ?>
     <?php echo $product->get_variation_sale_price( 'min', true ) . '&mdash;' . $product->get_variation_sale_price( 'max', true ) . ' ' . $money; ?>
 
 <?php else : ?>
    
    <?php echo $product->get_variation_price( 'min', true ) . '&mdash;' . $product->get_variation_price( 'max', true ) . ' ' . $money; ?>
      
 <?php endif; ?>
 
</p>
<?php endif;

if( $product->is_type('simple') ) : ?>
<p class="<?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'price' ) ); ?>">
  
  <?php if( $product->is_on_sale() ) : ?>
  
    <?php echo str_replace( get_woocommerce_currency_symbol(), '', wc_price( $product->get_regular_price() ) )  . ' ' . $money; ?>
    <?php echo str_replace( get_woocommerce_currency_symbol(), '', wc_price( $product->get_sale_price() ) )  . ' ' . $money; ?>
  
  <?php else : ?>
  
    <?php echo str_replace( get_woocommerce_currency_symbol(), '', wc_price( $product->get_price() ) ) . ' ' . $money; ?>
  <?php endif; ?>
</p>
<?php endif; ?>