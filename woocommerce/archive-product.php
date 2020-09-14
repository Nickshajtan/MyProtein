<?php
/*
 * Woo main page of shop
 *
 *
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 
defined( 'ABSPATH' ) || exit;

$display_type = woocommerce_get_loop_display_mode(); // what is displaying on shop page: cats, or products, or together
if ( 'subcategories' === $display_type ) {
    wc_set_loop_prop( 'total', 0 );

    // This removes pagination and products from display for themes not using wc_get_loop_prop in their product loops.  @todo Remove in future major version.
    global $wp_query;

    if ( $wp_query->is_main_query() ) {
        $wp_query->post_count    = 0;
        $wp_query->max_num_pages = 0;
    }
}

get_header(); 

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );

/**
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
    <div class="woocommerce-products-header__description description col-12">
      <div class="row">
        <?php echo $descr; ?>
      </div>
    </div>
  <?php endif;
  if ( woocommerce_product_loop() ) :

        /**
         * WOO notices
         *
         *
         */
        if( function_exists('wc_print_notices') ) : ?>
          <div class="col-12 shop-notices d-block"><div class="row"><?php wc_print_notices(); ?></div></div>
        <?php endif;

        /**
         * Custom categories output
         *
         *
         */
        if ( 'subcategories' === $display_type || 'both' === $display_type ) :
          wc_get_template_part( 'content', 'product_cat_loop' );
        endif; ?>
        
        <div class="col-12 d-flex flex-row align-items-center justify-content-end filters-area-row">
          <div class="row">
          <?php
          /**
           * Hook: woocommerce_before_shop_loop.
           *
           * @hooked woocommerce_output_all_notices - 10
           * @hooked woocommerce_result_count - 20
           * @hooked woocommerce_catalog_ordering - 30
           */
          do_action( 'woocommerce_before_shop_loop' );
            
          if( is_product_taxonomy() || is_search() ) : 
            wc_get_template_part('sort/grid', 'sorting');
          endif; ?>
          </div>
        </div>
        <?php woocommerce_product_loop_start();

        if ( wc_get_loop_prop( 'total' ) && 'subcategories' !== $display_type ) :
            while ( have_posts() ) :
                the_post();

                /**
                 * Hook: woocommerce_shop_loop.
                 */
                do_action( 'woocommerce_shop_loop' );

                wc_get_template_part( 'content', 'product' );
            endwhile;
        endif;

        woocommerce_product_loop_end(); ?> 
        <div class="col-12 woo-wrap__pagination d-flex justify-content-center align-items-center">
          <?php 
            // Pagination
            get_template_part('template-parts/pagination');
          ?>
        </div>

  <?php else :   
          $class           = 'col-12';

          if( $left_sidebar && $right_sidebar ) {
            $class = 'col-12 col-lg-6';
          }

          if( $left_sidebar || $right_sidebar ) {
            $class = 'col-12 col-lg-9';
          } 
   ?>
         
          <div class="col-12 woo-wrap__not-found h-100 d-flex justify-content-center align-items-center">
            <div class="row">
             
              <?php if( $left_sidebar ) : ?>
                 <aside class="col-12 col-lg-3"><ul><?php dynamic_sidebar('WOO-Left'); ?></ul></aside>
              <?php endif; ?>
              <div class="<?php echo $class; ?>">
                <?php 
                /**
                 * Hook: woocommerce_no_products_found.
                 *
                 * @hooked wc_no_products_found - 10
                 */
                do_action( 'woocommerce_no_products_found' ); ?>
            </div>
             <?php if( $right_sidebar ) : ?>
                 <aside class="col-12 col-lg-3"><ul><?php dynamic_sidebar('WOO-Right'); ?></ul></aside>
             <?php endif; ?>
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