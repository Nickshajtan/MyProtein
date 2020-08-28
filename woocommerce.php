<?php
/**
 * Template for woocommerce page
 * @package hcc
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 
get_header();
if( have_posts() ) : 
    while ( have_posts() ) :
        the_post(); ?>
      <section class="container-fluid site-container woo-wrap">
                <div class="row">
                  <div class="col-12 woo-wrap__content">
                    <?php woocommerce_content(); ?>
                  </div>
                </div>
      </section>
    <?php endwhile;
else :
    get_template_part( 'template-parts/content/content', 'none' );
endif; 
get_footer(); ?>
