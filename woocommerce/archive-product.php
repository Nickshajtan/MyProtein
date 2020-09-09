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

/*
 * Page title & description
 *
 *
 */
if( function_exists('woocommerce_taxonomy_archive_description') ) :
  $title = woocommerce_taxonomy_archive_description();
endif;
if( function_exists('woocommerce_product_archive_description') ) :
  $descr = woocommerce_product_archive_description();
endif;
  
  if( !empty( $descr ) ) : 
    if( !empty( $title ) ) : ?>
    <header class="col-12 woocommerce-products-header">
      <div class="row">
        <?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
          <h1 class="woocommerce-products-header__title page-title w-100"><?php woocommerce_page_title(); ?></h1>
        <?php endif; ?>
      </div>
    </header>
    <?php endif; ?>
    <div class="woocommerce-products-header__description description w-100">
      <?php echo $descr; ?>
    </div>
  <?php endif;
  if ( woocommerce_product_loop() ) : ?>
  
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
        <?php 
        woocommerce_product_loop_start();

        if ( wc_get_loop_prop( 'total' ) ) {
            while ( have_posts() ) {
                the_post();

                /**
                 * Hook: woocommerce_shop_loop.
                 */
                do_action( 'woocommerce_shop_loop' );

                wc_get_template_part( 'content', 'product' );
            }
        }

        woocommerce_product_loop_end(); 











?>
    
     
     
     
     
     
     
     
     
     
     
     
     
     
     
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

  <?php else : ?>
       <div class="container">
         <div class="row">
          <div class="col-12">
            <?php 
            /**
             * Hook: woocommerce_no_products_found.
             *
             * @hooked wc_no_products_found - 10
             */
            do_action( 'woocommerce_no_products_found' ); ?>
          </div>
         </div>
        </div>
        
<?php endif;

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