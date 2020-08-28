<?php
/*
 * Woo category page of shop
 *
 *
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 
defined( 'ABSPATH' ) || exit;

get_header(); ?>

<section class="container-fluid site-container woo-wrap woo-category">
    <div class="row-fluid">
      <div class="col-12 woo-wrap__product-list">
        <?php echo do_shortcode("[product_category category=" . get_queried_object()->term_id . "]"); ?>
      </div>
    </div>
</section>

<?php get_footer(); ?>