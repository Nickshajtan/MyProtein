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
$columns    = wc_get_loop_prop( 'columns' );

$left_sidebar    = ( is_active_sidebar( 'WOO-Left' ) )  ? true : false;
$second_sidebar  = ( is_active_sidebar( 'WOO-Right' ) ) ? true : false;

get_header(); 

if( have_posts() ) : ?>

<section class="container woo-wrap woo-category">
    <div class="row">
      <ul class="col-12 woo-shop__products__grid">
        <li class="aside">
          <aside><?php ?></aside>
        </li>
        <?php while (have_posts()) : the_post();
          /**
           * Hook: woocommerce_shop_loop.
           */
          do_action( 'woocommerce_shop_loop' );

          wc_get_template_part( 'content', 'product' );
        endwhile; 
        $args = array(
            'base'         => '%_%',
            'format'       => '?page=%#%',
            'show_all'     => false, 
            'end_size'     => 1,     
            'mid_size'     => 1,    
            'add_args'     => false, 
            'add_fragment' => '',     
            'screen_reader_text' => __( 'Product cat pagination', 'hcc' ),
        );
         ?>
        
        <style>
          .woo-shop__products__grid {
            display: grid;
            grid-gap: 15px;
            grid-template-columns: repeat( 3, 1fr );
            grid-template-rows: max-content;
            grid-template-areas: 'aside product product'
                                 'aside product product';
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

<?php endif;
get_footer(); ?>