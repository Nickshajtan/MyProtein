<?php
/*
 * Woo main page of shop
 *
 *
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 
defined( 'ABSPATH' ) || exit;

$shop_display = trim( get_option('woocommerce_shop_page_display') ); // what is displaying on shop page

get_header(); 

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );
if ( woocommerce_product_loop() ) : ?>
  
    <div class="container">
      <div class="row">
        <div class="col-12">
          <?php
            /**
             * Hook: woocommerce_before_shop_loop.
             *
             * @hooked woocommerce_output_all_notices - 10
             * @hooked woocommerce_result_count - 20
             * @hooked woocommerce_catalog_ordering - 30
             */
            do_action( 'woocommerce_before_shop_loop' );
          ?>
          <?php if( function_exists('wc_print_notices') ) : ?>
            <div class="w-100 shop-notices">
              <?php wc_print_notices(); ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  
    <?php if ( wc_get_loop_prop( 'total' ) ) :
      /**
       * Hook: woocommerce_shop_loop.
       */
       do_action( 'woocommerce_shop_loop' );
     endif;

    switch( $shop_display ) :
      case 'subcategories' :
        wc_get_template_part('loop/loop', 'categories');
        break;
      case 'both' :
        wc_get_template_part('loop/loop', 'categories');
        wc_get_template_part('loop/loop', 'products');
        break;
      case '' :
        wc_get_template_part('loop/loop', 'products');
        break;
      default :
        wc_get_template_part('loop/loop', 'categories');
    endswitch;

    ?>
    
    <div class="container">
      <div class="row">
        <div class="col-12">
        <?php
        /**
         * Hook: woocommerce_after_shop_loop.
         *
         * @hooked woocommerce_pagination - 10
         */
        do_action( 'woocommerce_after_shop_loop' );
        ?>
        </div>
      </div>
    </div>

  <?php else :
        /**
         * Hook: woocommerce_no_products_found.
         *
         * @hooked wc_no_products_found - 10
         */
        do_action( 'woocommerce_no_products_found' );
  
endif;

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