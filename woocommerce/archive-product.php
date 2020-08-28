<?php
/*
 * Woo main page of shop
 *
 *
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 
defined( 'ABSPATH' ) || exit;

global $post;
$prod_terms = get_the_terms( $post->ID, 'product_cat' );

$prod_terms = get_categories( [
	'taxonomy'     => 'product_cat',
	'type'         => 'product',
	'child_of'     => 0,
	'parent'       => '',
	'orderby'      => 'name',
	'order'        => 'ASC',
	'hide_empty'   => 1,
	'hierarchical' => 1,
	'exclude'      => '',
	'include'      => '',
	'number'       => 0,
	'pad_counts'   => false,
	// полный список параметров смотрите в описании функции http://wp-kama.ru/function/get_terms
] );


//var_dump( $prod_terms );

get_header(); 

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' ); ?>
  <section class="container-fluid site-container woo-wrap woo-shop">
    <div class="row-fluid">
      <?php if( !is_null( $prod_terms ) && is_array( $prod_terms ) ) : ?>
      <div class="col-12 woo-shop__categories">
        <div class="row">
          <?php foreach ($prod_terms as $cat) :
          endforeach; ?>
          <?php echo apply_shortcodes('[product_categories parent="0" hide_empty="0"]'); ?>
        </div>
      </div>
      
      <div class="col-12 woo-shop__child-categories">
        <div class="row">
          <div class="col-12 col-xl-3">
            <?php echo apply_shortcodes('[product_categories parent="18" hide_empty="0" columns="1"]'); ?>
          </div>
          <div class="col-12 col-xl-3">
            <?php echo apply_shortcodes('[product_categories parent="19" hide_empty="0" columns="1"]'); ?>
          </div>
          <div class="col-12 col-xl-3">
            <?php echo apply_shortcodes('[product_categories parent="20" hide_empty="0" columns="1"]'); ?>
          </div>
          <div class="col-12 col-xl-3">
            <?php echo apply_shortcodes('[product_categories parent="21" hide_empty="0" columns="1"]'); ?>
          </div>
        </div>
      </div>
      <?php endif; ?>
    </div>
  </section>
  
<?php 

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action( 'woocommerce_sidebar' );

get_footer(); ?>