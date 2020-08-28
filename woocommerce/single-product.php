<?php
/*
 * Woo single page of product
 *
 *
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 
defined( 'ABSPATH' ) || exit;

global $post;
get_header(); ?>

<section class="container-fluid site-container woo-wrap woo-product">
    <div class="row-fluid">
      <div class="col-12 woo-product__data">
        <?php echo do_shortcode("[product_page id=" . $post->ID . "]"); ?>
      </div>
    </div>
</section>
<?php get_footer(); ?>