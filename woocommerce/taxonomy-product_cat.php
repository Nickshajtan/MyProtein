<?php
/*
 * Woo category page of shop
 *
 *
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 
defined( 'ABSPATH' ) || exit;

global $post;
global $product;
global $woocommerce;
$id         = get_queried_object()->term_id;
$columns    = wc_get_loop_prop( 'columns' ) - 1;
$columns    = ( empty( $columns ) || $columns <= 0 ) ? 3 : $columns;

$left_sidebar    = ( is_active_sidebar( 'WOO-Left' ) )  ? true : false;
$second_sidebar  = ( is_active_sidebar( 'WOO-Right' ) ) ? true : false;
$class           = ( $left_sidebar && $second_sidebar ) ? 'woo-shop__products__grid_two-sidebars' : '';
$class           = ( empty( $class ) && $second_sidebar ) ? 'woo-shop__products__grid_right-sidebar' : '';
$class           = ( empty( $class ) && $left_sidebar )   ? 'woo-shop__products__grid_left-sidebar' : '';

get_header(); 

if( have_posts() ) : ?>

<section class="container woo-wrap woo-category">
    <div class="row">
      <div class="col-12 d-flex flex-row align-items-center justify-content-end filters-area-row">
        <?php wc_print_notices(); ?>
        <?php 
        /**
         * @hooked woocommerce_catalog_ordering
         */
        do_action( 'woocommerce_catalog_ordering' );
        ?>
        <button class="grid">grid</button>
        <button class="list">list</button>
      </div>
      <ul class="col-12 woo-shop__products__grid d-grid grid-columns-<?php echo $columns . ' ' . $class; ?>">
        <?php if( $left_sidebar ) : ?>
        <li class="aside">
          <aside><?php dynamic_sidebar('WOO-Left'); ?></aside>
        </li>
        <?php endif;
        if( $second_sidebar ) : ?>
        <li class="aside">
          <aside><?php dynamic_sidebar('WOO-Right'); ?></aside>
        </li>
        <?php endif;
        while (have_posts()) : the_post();
          /**
           * Hook: woocommerce_shop_loop.
           */
          do_action( 'woocommerce_shop_loop' );

          wc_get_template_part( 'content', 'product' );
        endwhile; ?>
        
        <style>
          .woo-shop__products__grid {
            grid-gap: 15px;
            grid-template-rows: max-content;
            grid-template-areas: 'aside product product'
                                 'aside product product';
          }
          .woo-shop__products__grid.row-blocks{
            display: block;
          }
          .aside {
            display: block;
            height: auto;
            min-width: 30%;
            background-color: red;
            grid-area: aside;
          }
          
          .woo-shop__products__grid__item {
            grid-area: 'product';
          }
          figure {
            margin: 0;
          }
        </style>
      </ul>
      <?php // Pagination
      get_template_part('template-parts/pagination'); ?>
    </div>
</section>

<?php else :
  get_template_part('template-parts/content/content', 'none');
endif;
get_footer(); ?>
<script>
jQuery('.grid').on('click', function() {
  jQuery('.woo-shop__products__grid').removeClass('row-blocks').addClass('d-grid');
});
jQuery('.list').on('click', function() {
  jQuery('.woo-shop__products__grid').addClass('row-blocks').removeClass('d-grid');
});
</script>