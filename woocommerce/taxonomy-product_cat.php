<?php
/*
 * Woo category page of shop
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

$left_sidebar    = ( is_active_sidebar( 'WOO-Left' ) )  ? true : false;
$right_sidebar   = ( is_active_sidebar( 'WOO-Right' ) ) ? true : false;

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
        endif;

        if( have_posts() && 'subcategories' !== $display_type ) : ?>
          <div class="col-12 d-flex flex-row align-items-center justify-content-end filters-area-row"> 
            <div class="row">
              <?php if( function_exists('woocommerce_catalog_ordering') ) :
                woocommerce_catalog_ordering();
              endif;
              wc_get_template_part('sort/grid', 'sorting');
              ?>
            </div>
          </div>
        <?php endif; ?>
        
          <div class="col-12 woo-wrap__cat-page">
            <div class="row">
                <?php woocommerce_product_loop_start();
                  
                if( $left_sidebar ) : ?>
                    <li class="aside aside_left">
                      <?php echo __('Фильтры', 'woocommerce'); ?>
                      <?php 
                      /**
                       * Hook: woocommerce_sidebar.
                       *
                       * @hooked woocommerce_get_sidebar - 10
                       */
                      do_action( 'woocommerce_sidebar' ); ?>
                      <aside><ul><?php dynamic_sidebar('WOO-Left'); ?></ul></aside>
                    </li>
                <?php endif;
                  
                if ( wc_get_loop_prop( 'total' ) ) :
                    while ( have_posts() ) :
                        the_post();

                        /**
                         * Hook: woocommerce_shop_loop.
                         */
                        do_action( 'woocommerce_shop_loop' );

                        wc_get_template_part( 'content', 'product' );
                    endwhile;
                endif;

                if( $right_sidebar ) : ?>
                    <li class="aside aside_right">
                      <?php echo __('Фильтры', 'woocommerce'); ?>
                      <?php 
                      /**
                       * Hook: woocommerce_sidebar.
                       *
                       * @hooked woocommerce_get_sidebar - 10
                       */
                      do_action( 'woocommerce_sidebar' ); ?>
                      <aside><ul><?php dynamic_sidebar('WOO-Right'); ?></ul></aside>
                    </li>
                <?php endif;
               
                woocommerce_product_loop_end(); ?>
                <div class="col-12 woo-wrap__pagination d-flex justify-content-center align-items-center">
                  <?php 
                    /**
                     * Hook: woocommerce_after_shop_loop.
                     *
                     * @hooked woocommerce_pagination - 10
                     */
                    //do_action( 'woocommerce_after_shop_loop' );

                    // Pagination
                    get_template_part('template-parts/pagination');
                  ?>
                </div> 
            </div>
          </div>
          
   <?php else : ?>
         
          <div class="col-12 woo-wrap__not-found h-100 d-flex justify-content-center align-items-center">
            <?php 
            /**
             * Hook: woocommerce_no_products_found.
             *
             * @hooked wc_no_products_found - 10
             */
            do_action( 'woocommerce_no_products_found' ); ?>
          </div>
        
    <?php endif; ?>
    
 <style>
          .woo-shop__products__grid,
          .woo-wrap__list,
          .woo-wrap__list_products {
            grid-gap: 15px;
            grid-template-rows: max-content;
            grid-template-areas: 'aside product product'
                                 'aside product product';
          }
          .woo-shop__products__grid.row-blocks,
          .woo-wrap__list.row-blocks,
          .woo-wrap__list_products.row-blocks {
            display: block;
          }
          .aside {
            display: block;
            height: auto;
            min-width: 30%;
            grid-area: aside;
          }
          
          .woo-shop__products__grid__item {
            grid-area: 'product';
          }
          figure {
            margin: 0;
          }
  </style>
<script>
jQuery('.grid').on('click', function() {
  jQuery('.woo-shop__products__grid').removeClass('row-blocks').addClass('d-grid');
  jQuery('.woo-wrap__list').removeClass('row-blocks').addClass('d-grid');
  jQuery('.woo-wrap__list_products').removeClass('row-blocks').addClass('d-grid');
});
jQuery('.list').on('click', function() {
  jQuery('.woo-shop__products__grid').addClass('row-blocks').removeClass('d-grid');
  jQuery('.woo-wrap__list').addClass('row-blocks').removeClass('d-grid');
  jQuery('.woo-wrap__list_products').addClass('row-blocks').removeClass('d-grid');
});
</script>
<style>
  .add_to_cart_button.hidden {
    position: absolute;
    visibility: hidden;
  }
</style>
    
<?php
/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );
get_footer(); ?>
